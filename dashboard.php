<?php
session_start();
include 'config.php';

// Prevent access if no session
if(!isset($_SESSION['name'])){
    header("Location: login.php");
    exit;
}

$user_name = $_SESSION['name']; // FIXED session index 

// Fetch products from cart using user_name instead of user_id
$cart = $conn->query("
    SELECT cart.id AS cart_id, products.name, products.price, products.image
    FROM cart
    JOIN products ON cart.product_name = products.name
    WHERE cart.user_name = '$user_name'
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<h2>YOUR SHOPING </h2>
<header>
    <a href="https://wa.me/254759465329" target="_blank"
   style="position:fixed; bottom:20px; right:20px; background:#25D366; color:white;
   padding:12px 16px; border-radius:50px; text-decoration:none; font-weight:bold;">
   WhatsApp us
</a>
</header>

<table border="1" cellpadding="10">
    <tr>
        <th>Image</th>
        <th>Product</th>
        <th>Price</th>
        <th>Action</th>
    </tr>

    <?php
    $total = 0;
    while($row = $cart->fetch_assoc()):
        $total += $row['price'];
    ?>
    <tr>
        <td><img src="admin/uploads/<?php echo $row['image']; ?>" width="70"></td>
        <td><?php echo $row['name']; ?></td>
        <td>KES <?php echo $row['price']; ?></td>
        <td>
    <form action="remove-cart.php" method="post" style="display:inline;"
      onsubmit="return confirm('Are you sure you want to remove this item?');">
      
    <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
    <button type="submit" class="del">Remove</button>
</form>


</td>
    </tr>
    <?php endwhile; ?>
</table>

<h3>Total Amount: <strong>KES <?php echo $total; ?></strong></h3>

<a class="btn" href="order.php">Place Order</a>
<a class="btn" href="products.php">Continue Shopping</a>

</body>
</html>
