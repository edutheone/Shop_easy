<?php
include 'config.php';

//display products randomly each time the page
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);
    $products = $conn->query(
        "SELECT * FROM products WHERE name LIKE '%$search%' ORDER BY RAND()"
    );
} else {
    $products = $conn->query(
        "SELECT * FROM products ORDER BY RAND()"
    );
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        /* RESET + BASE */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: Arial, Helvetica, sans-serif;
}

body {
  background: #f5f5f5;
  color: #222;
}

/* HEADER */
.header {
  background: #fff;
  padding: 15px 30px;
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 15px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.header h2 {
  width: 100%;
  font-size: 22px;
  font-weight: bold;
  color: #f68b1e; /* Jumia orange */
}

.header a {
  text-decoration: none;
  color: #333;
  font-size: 14px;
  margin-right: 15px;
}

.header a:hover {
  color: #f68b1e;
}

/* SEARCH BAR (JUMIA STYLE) */
.search-form {
  margin-left: auto;
  display: flex;
  align-items: center;
}

.search-form input {
  width: 320px;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 4px 0 0 4px;
  outline: none;
}

.search-form button {
  padding: 10px 18px;
  border: none;
  background: #f68b1e;
  color: #fff;
  font-weight: bold;
  cursor: pointer;
  border-radius: 0 4px 4px 0;
}

.search-form button:hover {
  background: #e07d13;
}

/* PRODUCTS GRID */
.products {
  max-width: 1200px;
  margin: 30px auto;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 15px;
  padding: 0 15px;
}

/* PRODUCT CARD */
.product-card {
  background: #fff;
  border-radius: 6px;
  padding: 12px;
  text-align: left;
  box-shadow: 0 1px 4px rgba(0,0,0,0.08);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

/* PRODUCT IMAGE */
.product-card img {
  width: 100%;
  height: 180px;
  object-fit: contain;
  margin-bottom: 10px;
}

/* PRODUCT NAME */
.product-card {
  font-size: 14px;
  line-height: 1.4;
}

/* PRICE */
.product-card br + br {
  display: none;
}

.product-card strong {
  font-weight: bold;
}

.product-card::after {
  content: "";
  display: block;
  margin-top: 8px;
}

/* PRICE TEXT (KES) */
.product-card {
  position: relative;
}

.product-card a {
  display: block;
  margin-top: 10px;
  text-align: center;
  background: #f68b1e;
  color: #fff;
  padding: 8px;
  border-radius: 4px;
  text-decoration: none;
  font-size: 14px;
  font-weight: bold;
}

.product-card a:hover {
  background: #e07d13;
}

/* MOBILE RESPONSIVENESS */
@media (max-width: 768px) {
  .search-form input {
    width: 200px;
  }

  .header {
    gap: 10px;
  }
}

    </style>
    
    <title><shopeasy class="com"></shopeasy></title>
</head>
<body>
    <header class="header">

<h2>WELCOME TO SHOP EASY 
    YOUR WALLET IS SAFE WITH US
</h2>
<a href="index.php">Home</a>
<a href="login.php">Sign in</a>
<a href="register.php">Sign up</a>
<a href="about.php">About us</a>


<form method="POST" action="" class="search-form">
    <input 
        type="text" 
        name="search" 
        placeholder="Search products..."
        value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>"
    >
    <button type="submit">Search</button>
</form>
</header>

<a href="https://wa.me/254759465329" target="_blank"
   style="position:fixed; bottom:20px; right:20px; background:#25D366; color:white;
   padding:12px 16px; border-radius:50px; text-decoration:none; font-weight:bold;">
   WhatsApp us
</a>


<div class="products">
<?php while($row = $products->fetch_assoc()): ?>
    <div class="product-card">
        <img src="admin/uploads/<?php echo $row['image']; ?>" width="20%"><br>
        <?php echo htmlspecialchars($row['name']); ?><br>
        KES <?php echo $row['price']; ?><br>
<a href="add-to-cart.php?name=<?php echo urlencode($row['name']); ?>">Add to shopping list</a>
    </div>
<?php endwhile; ?>
</div>
<?php 
include 'payments/footer.php';
?>

</body>
</html>
