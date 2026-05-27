<?php

session_start();
include 'db.php';

$id = (int)$_GET['id'];

mysqli_query($conn, "

    DELETE FROM addresses
    WHERE id = $id

");

header("Location: user.php?tab=address");
exit();