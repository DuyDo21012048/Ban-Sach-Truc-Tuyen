<?php
session_start();

$id = $_GET['id'];
$action = $_GET['action'];

if (isset($_SESSION['cart'][$id])) {

    // Tăng số lượng
    if ($action == "plus") {
        $_SESSION['cart'][$id]++;

    }

    // Giảm số lượng nhưng không nhỏ hơn 1
    elseif ($action == "minus") {
        if ($_SESSION['cart'][$id] > 1) {
            $_SESSION['cart'][$id]--;
        }
    }
}

header("Location: cart.php");
exit();
?>