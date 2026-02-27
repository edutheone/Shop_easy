<?php
session_start();
include "../config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!isset($_POST['order_id'])) {
        die("Order ID missing.");
    }

    //MPESA CONFIG 
    $consumerKey    = "DrDIALRrA9AeiAqhm6PGcXbzeBvLW71OdbZYrKiMVWbAa5mT";
    $consumerSecret = "GDxVAdwtYYO7L2AKZ5zxjo10TRHljTBWNhOtOtgzPWb3zDv1xbXtzjIoMbL5KLuN";
    $shortCode      = "174379";
    $passkey        = "bfb279f9aa9bdbcf158e97dd6b3b6a3e4c9e2b4d0f0f5a4f3e6a6f3b6a3e4c9e2b";
    $callbackUrl    = "https://abcd-1234.ngrok-free.app/mpesa/callback.php";
    $timestamp      = date("YmdHis");
    $password       = base64_encode($shortCode . $passkey . $timestamp);
    

    $order_id = intval($_POST['order_id']);

    // Fetch Order 
    $stmt = $conn->prepare("SELECT total_amount, user_name FROM orders WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    if (!$order) die("Invalid Order.");

    $amount = $order['total_amount'];
    $user_name = $order['user_name'];

    //Fetch User Phone 
    $stmt2 = $conn->prepare("SELECT phone FROM users WHERE name = ?");
    $stmt2->bind_param("s", $user_name);
    $stmt2->execute();
    $user = $stmt2->get_result()->fetch_assoc();

    if (!$user) die("User not found.");

    $phone = preg_replace('/\D/', '', $user['phone']);
    if (substr($phone, 0, 1) == "0") {
        $phone = "254" . substr($phone, 1);
    } elseif (substr($phone, 0, 1) == "7") {
        $phone = "254" . $phone;
    }

    //GENERATE ACCESS TOKEN 
    $credentials = base64_encode($consumerKey . ":" . $consumerSecret);
    $token_url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

    $ch = curl_init($token_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic $credentials"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    if (curl_errno($ch)) die("OAuth Error: " . curl_error($ch));

    curl_close($ch);
    $result = json_decode($response, true);

    if (!isset($result['access_token'])) die("Token Error");

    $access_token = $result['access_token'];

    //STK DATA 
    $stkData = [
        "BusinessShortCode" => $shortCode,
        "Password" => $password,
        "Timestamp" => $timestamp,
        "TransactionType" => "CustomerPayBillOnline",
        "Amount" => $amount,
        "PartyA" => $phone,
        "PartyB" => $shortCode,
        "PhoneNumber" => $phone,
        "CallBackURL" => $callbackUrl,
        "AccountReference" => $order_id,
        "TransactionDesc" => "Payment for Order #" . $order_id
    ];

    $stk_url = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

    $ch = curl_init($stk_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $access_token",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($stkData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    if (curl_errno($ch)) die("STK Error: " . curl_error($ch));

    curl_close($ch);
    $stkResponse = json_decode($response, true);

    //HANDLE RESPONSE 
    if (isset($stkResponse['ResponseCode']) && $stkResponse['ResponseCode'] === "0") {

        $checkoutID = $stkResponse['CheckoutRequestID'];
        $merchantID = $stkResponse['MerchantRequestID'];

        //Insert into payments table 
        $insert = $conn->prepare("
            INSERT INTO payments
            (order_id, checkout_request_id, merchant_request_id, amount, phone, status, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, 'PENDING', NOW(), NOW())
        ");
        $insert->bind_param("issds", $order_id, $checkoutID, $merchantID, $amount, $phone);
        $insert->execute();

        $_SESSION['order_id'] = $order_id;
        $_SESSION['CheckoutRequestID'] = $checkoutID;

        header("Location: wait_confirmpayment.php");
        exit;

    } else {
        echo "<pre>";
        print_r($stkResponse);
        echo "</pre>";
        die("STK Push Failed.");
    }
}
?>