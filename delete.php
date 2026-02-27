<?php
include "config.php";
session_start();

$id = $_GET['id'];

$conn->query("DELETE FROM cart WHERE id='$id'");

header("Location: checkout.php");
exit;
