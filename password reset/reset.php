<?php
include '../config.php';

// Initialize a flag to hide/show the form
$valid_token = false;
$token = "";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // 1. Check if token exists and is still fresh
    $stmt = $conn->prepare(
        "SELECT id FROM users 
         WHERE reset_token = ? 
         AND token_expiry > NOW()"
    );
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $valid_token = true; // Token is good!
    } else {
        echo "<h3>Link invalid or expired. Please request a new one.</h3>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Update</title>
</head>
<body>
    <?php if ($valid_token): ?>
        <h2>New password update</h2>
        <form action="update_password.php" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            
            <input type="password" name="new_password" placeholder="Set your new password" required minlength="8">
            <br><br>
            <button type="submit">Update Password</button>
        </form>
    <?php endif; ?>
</body>
</html>