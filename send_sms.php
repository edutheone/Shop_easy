<?php

function formatPhone($phone){
    $phone = trim($phone);
    $phone = str_replace(" ", "", $phone); // remove spaces
//if phone number starts with 0 repalce it with +254

    if(substr($phone,0,1)==="0") {
        $phone = "+254" . substr($phone, 1);
    } else if(substr($phone,0,1)==="7" || substr($phone,0,1)==="1") {
        $phone = "+254" . $phone;
    }

    return $phone;
}

function sendSMS($phone, $message) {
    $username = trim("edwin monari"); 
    $apiKey   = trim("atsk_29c46e695afe508fbf1f22394aeb0d68ec18adb92c071fb1c3a6a5e38735523d904a7189");

    $phone = formatPhone($phone);

    $url = "https://api.africastalking.com/version1/messaging";

    $data = [
        "username" => $username,
        "to"       => $phone,
        "message"  => $message
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $apiKey);

    $response = curl_exec($ch);

    if($response === false){
        echo "cURL Error: " . curl_error($ch);
    } else {
        echo "SMS Response: " . $response;
    }

    curl_close($ch);
}

// Example usage:
sendSMS("0712345678", "Hello! This is a test from XAMPP sandbox.");

?>
