<?php
session_start();
include 'db.php';
include 'admin_auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = (int) $_POST['id'];

    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $price = (int) $_POST['price'];

    $author = mysqli_real_escape_string($conn, $_POST['author']);

    $quantity = (int) $_POST['quantity'];

    $image = mysqli_real_escape_string($conn, $_POST['image']);

    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $published_year = (int) $_POST['published_year'];

    $language = mysqli_real_escape_string($conn, $_POST['language']);

    $pages = (int) $_POST['pages'];

    $cover_type = mysqli_real_escape_string($conn, $_POST['cover_type']);

    $publisher = mysqli_real_escape_string($conn, $_POST['publisher']);

    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);

    $id = (int)$_POST['id'];

    /* UPDATE */

    $sql = "
        UPDATE books SET

            title = '$title',
            price = $price,
            author = '$author',
            quantity = $quantity,
            image = '$image',
            description = '$description',
            published_year = $published_year,
            language = '$language',
            pages = $pages,
            cover_type = '$cover_type',
            publisher = '$publisher',
            isbn = '$isbn',

            updated_at = NOW()

        WHERE id = $id
    ";

    mysqli_query($conn,"
        DELETE FROM book_categories
        WHERE book_id = $id
    ");

    if(isset($_POST['categories'])){

        foreach($_POST['categories'] as $cat_id){

            mysqli_query($conn,"
                INSERT INTO book_categories(
                    book_id,
                    category_id
                )
                VALUES(
                    $id,
                    $cat_id
                )
            ");
        }
    }

    if (mysqli_query($conn, $sql)) {

        header("Location: admin_books.php");

        exit();

    } else {

        echo "Lỗi: " . mysqli_error($conn);

    }
}
?>