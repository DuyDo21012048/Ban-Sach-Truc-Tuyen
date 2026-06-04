<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (
    !isset($_GET['id']) ||
    !isset($_GET['action'])
) {
    header("Location: cart.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$book_id = (int)$_GET['id'];
$action = $_GET['action'];

$allowedActions = ['plus', 'minus', 'delete'];

if (!in_array($action, $allowedActions)) {
    header("Location: cart.php");
    exit();
}

/* Lấy sản phẩm trong giỏ */
$result = mysqli_query($conn, "
    SELECT *
    FROM carts
    WHERE user_id = $user_id
    AND book_id = $book_id
");

if ($cart = mysqli_fetch_assoc($result)) {

    // Tăng số lượng
    if ($action === 'plus') {

        mysqli_query($conn, "
            UPDATE carts
            SET quantity = quantity + 1
            WHERE user_id = $user_id
            AND book_id = $book_id
        ");

    }

    // Giảm số lượng
    elseif ($action === 'minus') {

        if ($cart['quantity'] > 1) {

            mysqli_query($conn, "
                UPDATE carts
                SET quantity = quantity - 1
                WHERE user_id = $user_id
                AND book_id = $book_id
            ");

        }

    }

    // Xóa sản phẩm
    elseif ($action === 'delete') {

        mysqli_query($conn, "
            DELETE FROM carts
            WHERE user_id = $user_id
            AND book_id = $book_id
        ");

    }

}

header("Location: cart.php");
exit();
?>