<?php
session_start();
include "config.php";

// Make sure user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit;
}

$user_name = $_SESSION['name'];

// Get user's phone number from users table since it is neede for sms notification
$userQuery = $conn->query("SELECT phone FROM users WHERE name = '$user_name'");
$userRow = $userQuery->fetch_assoc();
$phone = $userRow['phone'];

$total = 0;
$totalQty = 0;

// Fetch products + quantities in cartand totals together
$items = $conn->query("
    SELECT cart.product_name, cart.quantity, products.price
    FROM cart
    JOIN products ON cart.product_name = products.name
    WHERE cart.user_name = '$user_name'
");

// Check if cart is empty
if ($items->num_rows == 0) {
    echo "<script>
        alert('You have not selected any item.');
        window.location.href = 'dashboard.php';
    </script>";
    exit;
}
//defining the key array product
$productNames = [];
// Calculate totals
while ($row = $items->fetch_assoc()) {
    $total += $row['price'] * $row['quantity'];
    $totalQty += $row['quantity'];
    $productNames[] = $row['product_name'] . "(x" . $row['quantity'] .")";
}
//converting product to string
$product_name = implode(",",$productNames);
include "send_sms.php";

// Insert order
$conn->query("
    INSERT INTO orders (user_name,product_name, total_amount, total_quantity, status)
    VALUES ('$user_name','$product_name', '$total', '$totalQty', 'Pending')
");

// Get inserted order ID
$order_id = $conn->insert_id;

// Redirect to payment page
header("Location: payments/checkout.php?order_id=" . $order_id);
exit();

?>

