<?php

session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];

$title = $_POST['title'];
$phone = $_POST['phone'];
$address = $_POST['address'];

mysqli_query($conn, "

    INSERT INTO addresses(
        user_id,
        title,
        phone,
        address
    )

    VALUES(
        '$user_id',
        '$title',
        '$phone',
        '$address'
    )

");

header("Location: user.php?tab=address");
exit();