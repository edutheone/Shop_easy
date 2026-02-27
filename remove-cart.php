<?php
session_start();
include 'config.php';

// Prevent access if not logged in
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit;
}

// DEBUG (use once if needed)
// echo '<pre>'; print_r($_POST); exit;

if (isset($_POST['cart_id'])) {

    $cart_id = (int) $_POST['cart_id'];
    $user_name = $_SESSION['name'];


    $sql = "DELETE FROM cart WHERE id = ? AND user_name = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("is", $cart_id, $user_name);

    if ($stmt->execute()) {
        header("Location: dashboard.php?removed=1");
        exit;
    } else {
        die("Execute failed: " . $stmt->error);
    }

} else {
    die("Invalid request");
}
