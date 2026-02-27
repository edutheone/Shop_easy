<?php
session_start();
include 'config.php';

// If user not logged in
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit;
}

$user_name = $_SESSION['name']; // username from session

// Add product to cart using name
if (isset($_GET['name'])) {
    $product_name = $_GET['name'];

    // Get product details by name
    $product_query = $conn->query("SELECT * FROM products WHERE name='$product_name'");
    if ($product_query->num_rows > 0) {
        $product = $product_query->fetch_assoc();
        $price = $product['price'];

        // Checking if product already exists in cart
        $check = $conn->query("SELECT * FROM cart WHERE product_name='$product_name' AND user_name='$user_name'");

        if ($check->num_rows > 0) {
            $conn->query("UPDATE cart SET quantity = quantity + 1 
                          WHERE product_name='$product_name' AND user_name='$user_name'");
        } else {
            // Inserting using product_name (as you don’t have product_id)
            $conn->query("INSERT INTO cart (user_name, product_name, quantity) 
                          VALUES ('$user_name', '$product_name', 1)");
        }
    }

    header("Location: dashboard.php");
    exit;
}

// Fetch cart items
$items = $conn->query("
    SELECT cart.id AS cart_id, cart.product_name, products.price, products.image, cart.quantity
    FROM cart
    JOIN products ON cart.product_name = products.name
    WHERE cart.user_name='$user_name'
");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    * {
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background: #f4f6f8;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .cart-container {
        max-width: 900px;
        margin: auto;
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th {
        background: #111;
        color: #fff;
        padding: 12px;
        text-align: left;
    }

    table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        color: #333;
    }

    table tr:hover {
        background: #f9f9f9;
    }

    .total {
        text-align: right;
        margin-top: 20px;
        font-size: 20px;
        font-weight: bold;
        color: #222;
    }

    .btn {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 25px;
        background: #111;
        color: #fff;
        text-decoration: none;
        border-radius: 6px;
        transition: 0.3s;
    }

    .btn:hover {
        background: #333;
    }

    .empty {
        text-align: center;
        color: #777;
        font-style: italic;
    }

    /* WhatsApp floating button */
    .whatsapp {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #25D366;
        color: white;
        padding: 12px 18px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: bold;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .whatsapp:hover {
        background: #1ebe5d;
    }

</style>
    <title>My Cart</title>
</head>
<body>

<h2>Your Shopping</h2>
<HEADer>
    <a href="https://wa.me/254759465329" target="_blank"
   style="position:fixed; bottom:20px; right:20px; background:#25D366; color:white;
   padding:12px 16px; border-radius:50px; text-decoration:none; font-weight:bold;">
   WhatsApp us
</a>

</HEADer>

<table border="1" cellpadding="10">
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Total</th>
</tr>

<?php
$grandTotal = 0;
if($items->num_rows > 0):
    while($row = $items->fetch_assoc()):
        $total = $row['price'] * $row['quantity'];
        $grandTotal += $total;
?>
<tr>
    <td><?= htmlspecialchars($row['product_name']); ?></td>
    <td><?= number_format($row['price'], 2); ?></td>
    <td><?= $row['quantity']; ?></td>
    <td><?= number_format($total, 2); ?></td>
</tr>
<?php
    endwhile;
else:
?>
<tr>
    <td colspan="4">Your cart is empty!</td>
</tr>
<?php endif; ?>
</table>

<h3>Grand Total: KES <?= number_format($grandTotal, 2); ?></h3>
<a class="btn"  href="dashboard.php">Proceed Checkout</a>

</body>
</html>
