<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .footer {
    background-color: #071a2c;
    color: #cbd5e1;
    padding: 50px 8%;
    font-family: 'Poppins', sans-serif;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 40px;
}

.footer-col {
    flex: 1;
    min-width: 250px;
}

.footer-col h3 {
    color: #ff9900;
    margin-bottom: 20px;
}

.footer-col p {
    line-height: 1.6;
    margin-bottom: 10px;
}

.footer-col ul {
    list-style: none;
    padding: 0;
}

.footer-col ul li {
    margin-bottom: 10px;
}

.footer-col ul li a {
    text-decoration: none;
    color: #cbd5e1;
    transition: 0.3s;
}

.footer-col ul li a:hover {
    color: #ff9900;
}

.footer-bottom {
    margin-top: 40px;
    border-top: 1px solid #1e293b;
    padding-top: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.secure-btn {
    background-color: #0f766e;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    transition: 0.3s;
}

.secure-btn:hover {
    background-color: #14b8a6;
}
@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
    }

    .footer-bottom {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
}
    </style>
</head>
<body>
    <footer class="footer">
    <div class="footer-container">

        
        <div class="footer-col">
            <h3>About ShopMaster</h3>
            <p>
                Your trusted online store for quality products. 
                We provide fast delivery, secure payments, and 24/7 support.
            </p>

            <div class="help">
                <strong>Need help?</strong>
                <p>📞 +254 700 000 000</p>
                <p>✉ support@shopmaster.com</p>
            </div>
        </div>

        
        <div class="footer-col">
            <h3>Shop</h3>
            <ul>
                <li><a href="products.php">All Products</a></li>
                <li><a href="products.php">Categories</a></li>
                <li><a href="products.php">New Arrivals</a></li>
                <li><a href="#">Best Sellers</a></li>
                <li><a href="#">Offers</a></li>
            </ul>
        </div>

       
        <div class="footer-col">
            <h3>Company</h3>
            <ul>
                <li><a href="about.php">About Us</a></li>
                <li><a href="https://wa.me/+254711297314">Contact Us</a></li>
                <li><a href="#">Track Order</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
        </div>

    </div>

    
    <div class="footer-bottom">
        <p>© 2026 ShopMaster. All Rights Reserved.</p>
        <button class="secure-btn">Secure Payments</button>
    </div>
</footer>
</body>
</html>