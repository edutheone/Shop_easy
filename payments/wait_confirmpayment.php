<?php
session_start();
if (!isset($_SESSION['order_id'])) {
    header("Location: apply.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Processing Payment</title>
<style>
body {
    font-family: Arial;
    background:#f4f4f4;
    text-align:center;
    padding-top:100px;
}
.box {
    background:white;
    width:420px;
    margin:auto;
    padding:40px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,0.1);
}
.loader {
    border:8px solid #eee;
    border-top:8px solid #28a745;
    border-radius:50%;
    width:60px;
    height:60px;
    margin:20px auto;
    animation:spin 1s linear infinite;
}
@keyframes spin {
    0%{transform:rotate(0deg);}
    100%{transform:rotate(360deg);}
}
</style>
</head>
<body>

<div class="box">
    <h2>Processing Your Payment</h2>
    <div class="loader"></div>
    <p>Please complete payment on your phone.</p>
    <p id="statusText">Waiting for confirmation...</p>
</div>

<script>
function checkPaymentStatus() {
    fetch("check_status.php")
    .then(response => response.json())
    .then(data => {

        if (data.status === "PAID") {
            window.location.href = "confirmation.php";
        }

        if (data.status === "FAILED") {
            window.location.href = "payment_failed.php";
        }

        if (data.status === "PENDING") {
            document.getElementById("statusText").innerText = 
                "Still waiting for payment confirmation...";
        }

    })
    .catch(error => console.error("Error:", error));
}

// Check every 3 seconds
setInterval(checkPaymentStatus, 3000);
</script>

</body>
</html>