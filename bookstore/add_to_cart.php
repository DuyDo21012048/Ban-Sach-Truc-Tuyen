<?php
session_start();
include 'db.php';

/* Lấy ID sách */
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

/* Lấy số lượng */
$quantity = isset($_POST['quantity'])
    ? (int)$_POST['quantity']
    : 1;

if ($quantity < 1) {
    $quantity = 1;
}

/* Đã đăng nhập */
if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    // Kiểm tra sách đã có trong cart chưa
    $check = mysqli_query($conn,"
        SELECT *
        FROM carts
        WHERE user_id = $user_id
        AND book_id = $id
    ");

    if(mysqli_num_rows($check) > 0){

        mysqli_query($conn,"
            UPDATE carts
            SET quantity = quantity + $quantity
            WHERE user_id = $user_id
            AND book_id = $id
        ");

    }else{

        mysqli_query($conn,"
            INSERT INTO carts(user_id, book_id, quantity)
            VALUES($user_id, $id, $quantity)
        ");

    }

}

/* Chưa đăng nhập → dùng session */
else{

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {

        $_SESSION['cart'][$id] += $quantity;

    } else {

        $_SESSION['cart'][$id] = $quantity;

    }

}

$redirectTab = $_POST['redirect_tab'] ?? '';

if ($redirectTab == 'favorites') {

    header("Location: user.php?tab=favorites");

} else {

    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'home.php'));

}

exit();
?>