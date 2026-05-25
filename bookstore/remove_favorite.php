<?php

session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$book_id = (int)$_GET['id'];

mysqli_query($conn,"
    DELETE FROM favorites
    WHERE user_id = $user_id
    AND book_id = $book_id
");

$tab = $_GET['tab'] ?? '';

if($tab === 'favorites'){
    header("Location: user.php?tab=favorites");
}else{
    header("Location: user.php");
}

exit();