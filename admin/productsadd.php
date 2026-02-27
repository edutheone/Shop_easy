<?php
session_start();
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $price = trim($_POST['price']);

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // sanitize filename
        $image = time() . '_' . preg_replace('/\s+/', '_', $_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];

        // Save to admin/uploads/
        move_uploaded_file($tmp_name, "uploads/" . $image);

        $sql = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '$image')";
        if ($conn->query($sql)) {
            echo "<script>alert('Product added successfully!');window.location.href='productsadd.php';</script>";
        } else {
            echo "Database error: " . $conn->error;
        }
    } else {
        echo "<script>alert('Please select a file to upload.');window.history.back();</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products</title>
    <link rel="stylesheet" href="products.css">
</head>
<body>

<div class="fr">
<form method="POST" enctype="multipart/form-data">
    <h2>Add Product</h2>
    <input type="text" name="name" placeholder="Product Name" required><br>
    <input type="number" name="price" placeholder="Price" required><br>
    <input type="file" name="image" required><br>
    <button type="submit">Add Product</button>
</form>


<a href="view_order.php">View Orders</a>
</div>

</body>
</html>
