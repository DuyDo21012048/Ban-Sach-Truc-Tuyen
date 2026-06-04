<?php
session_start();

/* Kiểm tra dữ liệu đầu vào */
if (
    !isset($_GET['id']) ||
    !isset($_GET['action'])
) {
    header("Location: cart.php");
    exit();
}

$id = (int)$_GET['id'];
$action = $_GET['action'];

$allowedActions = ['plus', 'minus', 'delete'];

if (!in_array($action, $allowedActions)) {
    header("Location: cart.php");
    exit();
}

/* Kiểm tra sản phẩm có trong giỏ */
if (isset($_SESSION['cart'][$id])) {

    // Tăng số lượng
    if ($action === "plus") {

        $_SESSION['cart'][$id]++;

    }

    // Giảm số lượng
    elseif ($action === "minus") {

        if ($_SESSION['cart'][$id] > 1) {

            $_SESSION['cart'][$id]--;

        }

    }

    // Xóa sản phẩm
    elseif ($action === "delete") {

        unset($_SESSION['cart'][$id]);

    }

}

header("Location: cart.php");
exit();
?>