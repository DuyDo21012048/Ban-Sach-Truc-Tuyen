<?php
session_start();

/* Lấy ID sách */
$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

/* Lấy số lượng từ form */
$quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 1;

/* Không cho quantity nhỏ hơn 1 */
if ($quantity < 1) {
    $quantity = 1;
}

/* Nếu chưa có cart thì tạo mới */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* Nếu sách đã tồn tại trong giỏ → cộng thêm */
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] += $quantity;
}

/* Nếu chưa có → thêm mới */
else {
    $_SESSION['cart'][$id] = $quantity;
}

header("Location: cart.php");
exit();
?>