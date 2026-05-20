<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$orders = mysqli_query($conn, "

    SELECT *
    FROM orders

    WHERE user_id = $user_id

    ORDER BY created_at DESC

");
?>