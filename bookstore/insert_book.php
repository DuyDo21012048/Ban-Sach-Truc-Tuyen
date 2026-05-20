<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $price = (int) $_POST['price'];

    $author = mysqli_real_escape_string($conn, $_POST['author']);

    $quantity = (int) $_POST['quantity'];

    $image = mysqli_real_escape_string($conn, $_POST['image']);

    $description = mysqli_real_escape_string($conn, $_POST['description']);

    /* THÔNG TIN MỚI */

    $published_year =
        !empty($_POST['published_year'])
        ? (int)$_POST['published_year']
        : "NULL";

    $language =
        mysqli_real_escape_string($conn, $_POST['language']);

    $pages =
        !empty($_POST['pages'])
        ? (int)$_POST['pages']
        : "NULL";

    $cover_type =
        mysqli_real_escape_string($conn, $_POST['cover_type']);

    $publisher =
        mysqli_real_escape_string($conn, $_POST['publisher']);

    $isbn =
        mysqli_real_escape_string($conn, $_POST['isbn']);

    $sql = "
        INSERT INTO books (

            title,
            price,
            author,
            quantity,
            image,
            description,

            published_year,
            language,
            pages,
            cover_type,
            publisher,
            isbn,

            created_at

        )

        VALUES (

            '$title',
            $price,
            '$author',
            $quantity,
            '$image',
            '$description',

            $published_year,
            '$language',
            $pages,
            '$cover_type',
            '$publisher',
            '$isbn',

            NOW()

        )
    ";

    if (mysqli_query($conn, $sql)) {

        header("Location: admin.php");

        exit();

    } else {

        echo "Lỗi: " . mysqli_error($conn);

    }
}
?>