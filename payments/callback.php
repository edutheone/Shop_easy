<?php
include "../config.php";

$content = file_get_contents('php://input');
$res = json_decode($content, true);

$checkoutID = $res['Body']['stkCallback']['CheckoutRequestID'];
$resultCode = $res['Body']['stkCallback']['ResultCode'];
$resultDesc = $res['Body']['stkCallback']['ResultDesc'];

$amount = null;
$receipt = null;
$phone = null;

if (isset($res['Body']['stkCallback']['CallbackMetadata']['Item'])) {
    foreach ($res['Body']['stkCallback']['CallbackMetadata']['Item'] as $item) {
        if ($item['Name'] == 'Amount') $amount = $item['Value'];
        if ($item['Name'] == 'MpesaReceiptNumber') $receipt = $item['Value'];
        if ($item['Name'] == 'PhoneNumber') $phone = $item['Value'];
    }
}

/* Determine Status */
$status = "FAILED";
if ($resultCode == 0) $status = "SUCCESS";
if ($resultCode == 1032) $status = "CANCELLED";

/* Update payments table */
$stmt = $conn->prepare("
    UPDATE payments
    SET status=?, amount=?, phone=?, receipt=?, result_code=?, result_desc=?, updated_at=NOW()
    WHERE checkout_request_id=?
");
$stmt->bind_param("sdssiss", $status, $amount, $phone, $receipt, $resultCode, $resultDesc, $checkoutID);
$stmt->execute();

/* Get order_id */
$stmt2 = $conn->prepare("SELECT order_id FROM payments WHERE checkout_request_id=?");
$stmt2->bind_param("s", $checkoutID);
$stmt2->execute();
$res2 = $stmt2->get_result();
$data = $res2->fetch_assoc();

if ($data) {
    $order_id = $data['order_id'];

    if ($status === "SUCCESS") {
        $stmt3 = $conn->prepare("UPDATE orders SET status='PAID' WHERE id=?");
    } else {
        $stmt3 = $conn->prepare("UPDATE orders SET status='FAILED' WHERE id=?");
    }

    $stmt3->bind_param("i", $order_id);
    $stmt3->execute();
}

file_put_contents(
    "transaction_log.txt",
    date("Y-m-d H:i:s") . " | $checkoutID | $status\n",
    FILE_APPEND
);
?>