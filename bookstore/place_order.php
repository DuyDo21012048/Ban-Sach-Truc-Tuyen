<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Địa chỉ giao hàng
|--------------------------------------------------------------------------
*/
$address_id = isset($_POST['address_id'])
    ? (int)$_POST['address_id']
    : 0;

if ($address_id <= 0) {
    header("Location: order.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Lấy giỏ hàng
|--------------------------------------------------------------------------
*/
$cartQuery = mysqli_query($conn, "
    SELECT
        carts.book_id,
        carts.quantity,
        books.price
    FROM carts
    JOIN books
        ON books.id = carts.book_id
    WHERE carts.user_id = $user_id
");

if (!$cartQuery || mysqli_num_rows($cartQuery) == 0) {
    header("Location: cart.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Tính tổng tiền
|--------------------------------------------------------------------------
*/
$total = 0;
$shipping = 30000;
$cartItems = [];

while ($item = mysqli_fetch_assoc($cartQuery)) {

    $subtotal = $item['price'] * $item['quantity'];

    $total += $subtotal;

    $cartItems[] = $item;
}

$grandTotal = $total + $shipping;

/*
|--------------------------------------------------------------------------
| Phương thức thanh toán
|--------------------------------------------------------------------------
*/
$payment_method = $_POST['payment_method'] ?? 'cod';

$allowed_methods = ['cod', 'bank'];

if (!in_array($payment_method, $allowed_methods)) {
    $payment_method = 'cod';
}

/*
|--------------------------------------------------------------------------
| Tạo mã đơn hàng
|--------------------------------------------------------------------------
*/
$order_code = 'ORD' . date('YmdHis');

/*
|--------------------------------------------------------------------------
| Tạo đơn hàng
|--------------------------------------------------------------------------
*/
$orderSql = "
    INSERT INTO orders(
        user_id,
        address_id,
        order_code,
        total_price,
        payment_method,
        status,
        created_at
    )
    VALUES(
        '$user_id',
        '$address_id',
        '$order_code',
        '$grandTotal',
        '$payment_method',
        'waiting_confirm',
        NOW()
    )
";

$orderResult = mysqli_query($conn, $orderSql);

if (!$orderResult) {
    die("Lỗi tạo đơn hàng: " . mysqli_error($conn));
}

/*
|--------------------------------------------------------------------------
| ID đơn hàng vừa tạo
|--------------------------------------------------------------------------
*/
$order_id = mysqli_insert_id($conn);

/*
|--------------------------------------------------------------------------
| Lưu chi tiết đơn hàng
|--------------------------------------------------------------------------
*/
foreach ($cartItems as $item) {

    $book_id  = (int)$item['book_id'];
    $quantity = (int)$item['quantity'];
    $price    = (int)$item['price'];

    $detailResult = mysqli_query($conn, "
        INSERT INTO order_items(
            order_id,
            book_id,
            quantity,
            price
        )
        VALUES(
            '$order_id',
            '$book_id',
            '$quantity',
            '$price'
        )
    ");

    if (!$detailResult) {
        die("Lỗi lưu chi tiết đơn hàng: " . mysqli_error($conn));
    }
}

/*
|--------------------------------------------------------------------------
| Xóa giỏ hàng
|--------------------------------------------------------------------------
*/
mysqli_query($conn, "
    DELETE FROM carts
    WHERE user_id = $user_id
");

/*
|--------------------------------------------------------------------------
| Chuyển sang trang thành công
|--------------------------------------------------------------------------
*/
header("Location: order_success.php?order_id=" . $order_id);
exit();
?>