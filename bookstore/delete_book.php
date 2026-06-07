<?php
session_start();
include 'db.php';
include 'admin_auth.php';


$id = (int)$_GET['id'];

/* Xóa liên kết thể loại */

mysqli_query($conn,"
    DELETE FROM book_categories
    WHERE book_id = $id
");

/* Xóa sách */

mysqli_query($conn,"
    DELETE FROM books
    WHERE id = $id
");

header("Location: admin_books.php");
exit();
?>