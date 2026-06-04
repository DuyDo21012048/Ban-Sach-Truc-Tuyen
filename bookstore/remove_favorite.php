<?php

session_start();
include 'db.php';

/* Chưa đăng nhập */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* Không có id sách */
if (!isset($_GET['id'])) {
    header("Location: user.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$book_id = (int)$_GET['id'];

/* Xóa khỏi yêu thích */
mysqli_query($conn, "
    DELETE FROM favorites
    WHERE user_id = $user_id
    AND book_id = $book_id
");

/* Giữ nguyên tab hiện tại */
$tab = $_GET['tab'] ?? '';

if ($tab === 'favorites') {

    header("Location: user.php?tab=favorites");

} else {

    header("Location: user.php");

}

exit();