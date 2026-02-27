<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "shop";

// Create connection
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

// Check connection
if ($conn) {
    echo "";
} else {
    echo "Connection error: " . mysqli_connect_error();
}
?>
