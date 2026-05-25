<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = (int)$_GET['id'];

$check = mysqli_query($conn, "
    SELECT id
    FROM favorites
    WHERE user_id = $user_id
    AND book_id = $book_id
");

if(mysqli_num_rows($check) > 0){

    mysqli_query($conn, "
        DELETE FROM favorites
        WHERE user_id = $user_id
        AND book_id = $book_id
    ");

}else{

    mysqli_query($conn, "
        INSERT INTO favorites(user_id, book_id)
        VALUES($user_id, $book_id)
    ");

}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>