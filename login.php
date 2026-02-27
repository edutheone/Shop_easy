<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']); // corrected passwoerd → password

    

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email); // missing comma fixed
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {

            // Store user session
            $_SESSION['name']  = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $user['phone'];

            echo "<script>
                    alert('Login successful! Welcome, {$user['name']}');
                    window.location.href = 'dashboard.php';
                  </script>";
            exit;

        } else {
            echo "<script>alert('Invalid password. Try Again.'); window.history.back();</script>";
            exit;
        }

    } else {
        echo "<script>alert('No account found with that email.'); window.history.back();</script>";
        exit;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login page</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <a href="https://wa.me/254759465329" target="_blank"
   style="position:fixed; bottom:20px; right:20px; background:#25D366; color:white;
   padding:12px 16px; border-radius:50px; text-decoration:none; font-weight:bold;">
   WhatsApp us
</a>
    </header>
    
<form method="POST" action="login.php">
    <h2>Login</h2>
    <label>Enter email</label><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <label>Enter your password</label><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="login">Login</button>
    <a href="password reset/passwordreset.php">Forgot password</a>
    <p>No account? <a href="register.php">Create account</a></p>
</form>

</body>
</html>