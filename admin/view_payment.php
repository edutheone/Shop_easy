<?php
session_start();
include "../config.php";

// Simple admin check
/*if (!isset($_SESSION['admin_logged_in'])) {
    die("Access Denied");
}*/

// Clear cart for paid orders automatically
$clearCart = $conn->prepare("
    DELETE c FROM cart c
    JOIN orders o ON c.user_name = o.user_name
    JOIN payments p ON p.order_id = o.id
    WHERE p.status='SUCCESS' AND o.status='PAID'
");
$clearCart->execute();

// Fetch all payments with order info
$query = "
    SELECT p.id as payment_id, p.amount, p.phone, p.receipt, p.status as payment_status,
           o.id as order_id, o.user_name, o.total_amount, o.status as order_status
    FROM payments p
    JOIN orders o ON p.order_id = o.id
    ORDER BY p.created_at DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Payments</title>
<style>
table {border-collapse: collapse; width: 100%;}
th, td {border: 1px solid #ccc; padding: 8px; text-align: left;}
th {background: #f2f2f2;}
.success {color: green; font-weight: bold;}
.failed {color: red; font-weight: bold;}
.pending {color: orange; font-weight: bold;}
</style>
</head>
<body>

<h2>All Payments</h2>
<table>
<tr>
    <th>Payment ID</th>
    <th>Order ID</th>
    <th>User</th>
    <th>Amount Paid</th>
    <th>Phone</th>
    <th>Receipt</th>
    <th>Payment Status</th>
    <th>Order Status</th>
    <th>Created At</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['payment_id']; ?></td>
    <td><?php echo $row['order_id']; ?></td>
    <td><?php echo htmlspecialchars($row['user_name']); ?></td>
    <td><?php echo $row['amount']; ?></td>
    <td><?php echo $row['phone']; ?></td>
    <td><?php echo $row['receipt'] ?? '-'; ?></td>
    <td class="<?php echo strtolower($row['payment_status']); ?>"><?php echo $row['payment_status']; ?></td>
    <td><?php echo $row['order_status']; ?></td>
    <td><?php echo $row['created_at']; ?></td>
</tr>
<?php endwhile; ?>

</table>
</body>
</html>