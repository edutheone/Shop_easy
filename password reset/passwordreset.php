<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $update_stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
        $update_stmt->bind_param("sss", $token, $expiry, $email);
        $update_stmt->execute();

        $reset_link = "https://shopeasy.page.gd/password_reset/reset.php?token=" . urlencode($token);

        $apiKey = trim("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");

        $data = [
            "sender" => [
                "name" => "Shop Easy",
                "email" => "sharoedu46@gmail.com"
            ],
            "to" => [
                ["email" => $email]
            ],
            "subject" => "Password Reset - Shop Easy",
            "htmlContent" => "
                <h2>Password Reset</h2>
                <p>Click the link below to reset your password:</p>
                <a href='$reset_link'>Reset Password</a>
                <p>This link expires in 1 hour.</p>
            "
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.brevo.com/v3/smtp/email");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "accept: application/json",
            "api-key: $apiKey",
            "content-type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        curl_close($ch);
    }

    echo "If the email exists, a reset link has been sent.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body{
            flex-direction: column;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            min-height: 100vh;
            background-color: grey;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 100px;
        }
        h2{
            color: aqua;
            display: contents;
            text-align: center;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);

        }
        form{
            background: white;
            padding: 25px;
            border-radius: 10px;
            width: 450px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        input{
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        button{
            width: 50%;
            padding: 12px;
            background-color: blueviolet;
            color: aliceblue;
            border: 1px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;


        }
        button:active{
            transform: scale(0.85);
        }
    </style>
</head>
<body>
    <h2>Enter your email to receive reset link</h2>

    <form action="reset.php" method="post">
        <input type="email" name="email" placeholder="Enter your email" required><br><br>
        <button type="submit">send the link</button>
    </form>
    
</body>
</html>