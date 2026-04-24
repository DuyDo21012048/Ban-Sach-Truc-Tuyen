<?php
session_start();

$id = $_GET['id'];
$action = $_GET['action'];

if (isset($_SESSION['cart'][$id])) {

    if ($action == "plus") {
        $_SESSION['cart'][$id]++;
    }

    if ($action == "minus") {
        $_SESSION['cart'][$id]--;

        // nếu <= 0 thì xóa khỏi giỏ
        if ($_SESSION['cart'][$id] <= 0) {
            unset($_SESSION['cart'][$id]);
        }
    }
}

header("Location: cart.php");
exit();
?>