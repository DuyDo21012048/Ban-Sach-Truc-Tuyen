<?php

session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];

$id = (int)$_GET['id'];

mysqli_query($conn, "

    UPDATE addresses
    SET is_default = 0
    WHERE user_id = $user_id

");

mysqli_query($conn, "

    UPDATE addresses
    SET is_default = 1
    WHERE id = $id

");

header("Location: user.php?tab=address");
exit();