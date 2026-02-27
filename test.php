<?php
// order_test.php

// Example: assume order is submitted via POST
if(isset($_POST['submit_order'])){
    $customerName  = $_POST['name'];
    $customerPhone = $_POST['phone'];
    $orderDetails  = $_POST['order'];

    // Save order to database (replace with your DB code)
    $conn = new mysqli("localhost", "root", "", "shop");
    if($conn->connect_error){
        die("DB connection failed: ".$conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO orders ("user_name", phone, "details") VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $customerName, $customerPhone, $orderDetails);
    $orderSaved = $stmt->execute();
    $stmt->close();
    $conn->close();

    if($orderSaved){
        // Send SMS via Africa's Talking Sandbox
        $username = "sandbox"; // sandbox username
        $apiKey   = "YOUR_SANDBOX_API_KEY";
        $message  = "Hi $customerName, your order has been received. Thank you!";

        $url = "https://api.africastalking.com/version1/messaging";
        $data = http_build_query([
            'username' => $username,
            'to'       => $customerPhone,
            'message'  => $message
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "apikey: $apiKey"
        ]);

        $response = curl_exec($ch);
        if(curl_errno($ch)){
            echo 'Curl error: ' . curl_error($ch);
        } else {
            echo "SMS sent! Response: <br>";
            echo $response;
        }
        curl_close($ch);
    } else {
        echo "Order could not be saved.";
    }
}
?>

<!-- Simple HTML Form to test -->
<form method="POST" action="">
    <input type="text" name="name" placeholder="Your Name" required><br>
    <input type="text" name="phone" placeholder="Phone +254..." required><br>
    <textarea name="order" placeholder="Order Details" required></textarea><br>
    <button type="submit" name="submit_order">Place Order</button>
</form>
