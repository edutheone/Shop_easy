<?php
include "../config.php";

$id = $_GET['id'];
$status = $_GET['status'];

$conn->query("UPDATE orders SET status='$status' WHERE id='$id'");

header("Location: view_order.php");
exit;
?>
