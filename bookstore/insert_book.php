<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = (int) $_POST['price'];
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $quantity = (int) $_POST['quantity'];
    $image = mysqli_real_escape_string($conn, $_POST['image']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "
        INSERT INTO books (title, price, author, quantity, image, description, created_at)
        VALUES ('$title', $price, '$author', $quantity, '$image', '$description', NOW())
    ";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>