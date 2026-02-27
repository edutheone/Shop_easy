<?php
session_start();
include "../config.php";

// Fetch all orders
$orders = $conn->query("
    SELECT * FROM orders
    ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Orders - Edu Boutique</title>
    <link rel="stylesheet" href="view.css">
</head>
<body>

<h2>Customer Orders</h2>

<table border="1" cellpadding="10">
<tr>
   <th>Customer Name</th>
   <th>product name</th>
   <th>Total Amount</th>
   <th>Status</th>
   <th>Date</th>
   <th>Actions</th>
</tr>

<?php while($row = $orders->fetch_assoc()): ?>
<tr>
   <td><?php echo $row['user_name']; ?></td>
   <td><?php echo $row['product_name']; ?></td>
   <td>KES <?php echo $row['total_amount']; ?></td>
   <td><?php echo $row['status']; ?></td>
   <td><?php echo $row['created_at']; ?></td>
   <td>
       <a class="btn" href="update.php?id=<?php echo $row['id']; ?>&status=Approved">Approve</a>
       <a class="btn" href="update.php?id=<?php echo $row['id']; ?>&status=cancel">cancel order</a>
   </td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
