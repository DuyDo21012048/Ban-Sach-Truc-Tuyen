<?php

session_start();
include 'db.php';

$id = $_POST['id'];

$title = $_POST['title'];
$phone = $_POST['phone'];
$address = $_POST['address'];

mysqli_query($conn, "

    UPDATE addresses

    SET
        title = '$title',
        phone = '$phone',
        address = '$address'

    WHERE id = $id

");

header("Location: user.php?tab=address");
exit();