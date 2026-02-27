<?php
session_start();
include 'config.php';

if (!isset($_SESSION['order_id'])) {
    echo json_encode(["status" => "INVALID"]);
    exit;
}

$order_id = $_SESSION['order_id'];

$stmt = $conn->prepare("SELECT status FROM orders WHERE id=?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo json_encode(["status" => "INVALID"]);
    exit;
}

echo json_encode(["status" => strtoupper($order['status'])]);