<?php
session_start();

include 'db.php';

$order_id = (int)$_GET['order_id'];

$query = mysqli_query($conn,"
    SELECT *
    FROM orders
    WHERE id = $order_id
");

$order = mysqli_fetch_assoc($query);

if(!$order){
    header("Location: home.php");
    exit();
}

$order_code = $order['order_code'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/order_success.css">
</head>
<body>

<div class="success-card">

    <div class="success-icon">
        ✓
    </div>

    <h1 class="fw-bold">
        Đặt hàng thành công!
    </h1>

    <p class="text-muted">
        Cảm ơn bạn đã đặt hàng tại BookStore
    </p>

    <div class="order-box">
        <div>Mã đơn hàng</div>

        <div class="order-code">
            <?= htmlspecialchars($order_code) ?>
        </div>
    </div>

    <div class="info-list">

        <p>✓ Đơn hàng của bạn đã được tiếp nhận</p>

        <p>✓ Chúng tôi sẽ liên hệ với bạn để xác nhận</p>

        <p>✓ Thông tin chi tiết đã được gửi qua email</p>

    </div>

    <a href="order_detail.php?id=<?= $order_id ?>" class="btn-primary-custom">
        📦 Xem đơn hàng của tôi
    </a>

    <a href="home.php" class="btn-home">
        🏠 Về trang chủ
    </a>

    <div class="support">
        Cần hỗ trợ? Liên hệ:<br>
        <strong>Hotline: 1900-xxxx</strong>
    </div>

</div>

</body>
</html>