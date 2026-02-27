<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  
    $token = trim($_POST['token']);
    $new_password = trim($_POST['new_password']);

   
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

 
    $stmt = $conn->prepare(
        "UPDATE users 
         SET password = ?, reset_token = NULL, token_expiry = NULL 
         WHERE reset_token = ?"
    );

    $stmt->bind_param("ss", $hashed_password, $token);

    if ($stmt->execute()) {
       
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Password updated successfully. Please login.'); window.location.href='../login.php';</script>";
        } else {
            echo "Error: The reset link is invalid or has already been used.";
        }
    } else {
        echo "Database error. Please try again later.";
    }
    
    $stmt->close();
}
$conn->close();
?>