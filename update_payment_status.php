<?php
require('connection.php');
// update_payment_status.php

$order_id = $_GET['order_id'];
$payment_id = $_GET['payment_id'];
$payment_status = $_GET['payment_status'];

// Update the payment status in the database
mysqli_query($con, "UPDATE `order_list` SET `payment_status`='$payment_status' WHERE `id`='$order_id'");

// Redirect to the thank you page
header("Location: thankyou.php");
exit();
?>
