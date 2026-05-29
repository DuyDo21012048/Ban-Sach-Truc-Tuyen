<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(!isset($_GET['id'])){
    header("Location: user.php?tab=orders");
    exit();
}

$order_id = (int)$_GET['id'];


/* =====================================================
   KIỂM TRA ĐƠN HÀNG
===================================================== */

$orderQuery = mysqli_query($conn, "

    SELECT *
    FROM orders
    WHERE id = $order_id
    AND user_id = $user_id

");

if(mysqli_num_rows($orderQuery) == 0){
    die("Đơn hàng không tồn tại");
}


/* =====================================================
   LẤY SẢN PHẨM TRONG ĐƠN
===================================================== */

$itemsQuery = mysqli_query($conn, "

    SELECT *
    FROM order_items
    WHERE order_id = $order_id

");


/* =====================================================
   TẠO GIỎ HÀNG NẾU CHƯA CÓ
===================================================== */

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}


/* =====================================================
   THÊM LẠI VÀO GIỎ
===================================================== */

while($item = mysqli_fetch_assoc($itemsQuery)){

    $book_id = $item['book_id'];
    $quantity = $item['quantity'];

    // Nếu đã tồn tại -> cộng thêm
    if(isset($_SESSION['cart'][$book_id])){

        $_SESSION['cart'][$book_id] += $quantity;

    } else {

        $_SESSION['cart'][$book_id] = $quantity;
    }
}


/* =====================================================
   CHUYỂN QUA GIỎ HÀNG
===================================================== */

$_SESSION['back_url'] = "order_detail.php?id=" . $order_id;

header("Location: cart.php");
exit();