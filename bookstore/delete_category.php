<?php
session_start();
include 'db.php';
include 'admin_auth.php';

$id = intval($_GET['id']);

$check = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT COUNT(*) total
        FROM book_categories
        WHERE category_id=$id
    ")
);

if($check['total'] > 0){

    echo "
    <script>
        alert('Danh mục đang chứa sách, không thể xóa!');
        window.location='admin_categories.php';
    </script>";
    exit;
}

mysqli_query($conn,"
    DELETE FROM categories
    WHERE id=$id
");

header("Location: admin_categories.php");
exit;