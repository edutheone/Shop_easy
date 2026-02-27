<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    // Check empty fields
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        echo "<script>alert('Fill all fields.'); window.history.back();</script>";
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email exists
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $email_result = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($email_result) > 0) {
        echo "<script>alert('Email already exists. Proceed to login'); window.location.href='login.php';</script>";
        exit;
    }

    // Insert user
    $sql = "INSERT INTO users (name, email, phone, password) VALUES('$name','$email','$phone','$hashed_password')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Account created successfully. Proceed to login'); window.location.href='login.php';</script>";
    } 
    else {
        echo "<script>alert('Error occurred, try again'); window.history.back();</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    
<form onsubmit="return validate()" action="register.php" method="POST">
    <h2>Create Account</h2>
    <label for="name">Enter your name</label><br>
    <input type="text" name="name" placeholder="Full Name"><br><br>
    <label for="email">Enter your email</label><br>
    <input type="email" name="email" placeholder="Email"><br><br>
    <label for="phone">Enter phone number</label><br>
    <input type="text" name="phone" placeholder="0735465342" ><br><br>
    <label for="pass">Set your Password</label><br>
    <input type="password" id="pass" name="password" placeholder="Password"><br><br>
    <button type="submit" name="register">Register</button>
    already have account:::<a href="login.php">login</a>
</form>
<footer>
    <p>@ shopeasy all products available</p>
</footer>
</body>
</html>