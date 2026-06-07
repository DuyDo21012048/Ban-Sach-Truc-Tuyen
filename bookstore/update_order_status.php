<?php

session_start();

include 'db.php';
include 'admin_auth.php';

$id = intval($_POST['order_id']);
$status = $_POST['status'];

mysqli_query($conn,"
    UPDATE orders
    SET status='$status'
    WHERE id=$id
");

header("Location: admin_orders.php");
exit();