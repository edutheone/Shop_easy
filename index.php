<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fashion Hub</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="index1.css">

</head>
<body>

<header class="navbar">
<div class="logo">👕 FASHION HUB</div>
<nav>
<a href="about.php">About us</a>
<a href="products.php">CATEGORIES</a>
<a href="products.php">PRODUCTS</a>
<a href="add-to-cart.php">🛒 CART</a>
</nav>

<a href="https://wa.me/254759465329" target="_blank"
   style="position:fixed; bottom:20px; right:20px; background:#25D366; color:white;
   padding:12px 16px; border-radius:50px; text-decoration:none; font-weight:bold;">
   WhatsApp us
</a>

</header>
<h2 class="h2">WELCOME TO OUR ONLINE SHOPPING FAMILY</h2>

<section class="hero">
<div class="hero-left">
<span class="vertical-text">be bold / be you</span>
<div class="image-box"><img src="images/woman.jpg"></div>
</div>

<div class="hero-center">
<h1>ONLINE<br>FASHION<br>##<br>DIGITAL SALE</h1>
<p>Discover trend-setting fashion designed for confidence and comfort.</p>
<button id="buyBtn">SHOP NOW</button>
</div>

<div class="hero-right"><img src="images/men.png"></div>
</section>

<section class="categories">
<h2>Shop By Category</h2>
<div class="cat-grid">
<div class="cat">Men</div>
<div class="cat">Women</div>
<div class="cat">Kids</div>
<div class="cat">Accessories</div>
</div>
</section>

<section class="products">
<h2 style="text-align:center">Featured Products</h2>
<div class="prod-grid">
<div class="prod"><img src="images/shirt.jpg"><h4>Casual Shirts</h4><p>Ksh. 1200</p></div>
<div class="prod"><img src="images/dress1.jpeg"><h4>Dress</h4><p>Ksh. 480</p></div>
<div class="prod"><img src="images/OIP.jfif"><h4>Jacket</h4><p>Ksh. 1000</p></div>
<div class="prod"><img src="images/shoes.jfif"><h4>Shoes</h4><p>Ksh. 1200</p></div>
</div>
</section>

<section class="news">
<h2>Join Our Newsletter</h2>
<p>Get offers & fashion updates</p>

<a href="products.php"><button>Shop</button></a>
</section>

<footer>
<p>© 2026 Fashion Hub. All rights reserved.</p>
</footer>
<?php if (!isset($_SESSION['name'])): ?>
<script>
   window.onload = function () {
    alert(
        "Welcome to ShopEasy! 🛍️\n\n" +
        "Save a lot with us — all products are available at affordable prices.\n" +
        "Enjoy FREE delivery in:\n" +
        "Kirinyaga, Embu, Nairobi, Kisii, and Kisumu.\n\n" +
        "Happy shopping!"
    );
};

</script>
<?php endif; ?>

</body>
</html>
