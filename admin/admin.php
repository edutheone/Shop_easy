<?php
session_start();

include "../config.php";

$sql = "SELECT name, phone, email FROM users ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered members</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
            color: blue;
            font-size: 20px;
            font-family: sans-serif;
        }
    </style>
</head>
<body>

<h2>Registered Members</h2>

<table>
    <tr>
        <th>Name</th>
        <th>phone</th>
        <th>Email</th>
    </tr>
    <?php if ($result->num_rows> 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No Registered users found</td>
            </tr>
            
            <?php endif; ?>
            <tr>
                <td><a href="view_payment.php">view payment</a></td>
                <td><a href="view_order.php">View Oders</a></td>
                <td><a href="productsadd.php">Add Products</a></td>
            </tr>
    

</table>
    
</body>
</html>
