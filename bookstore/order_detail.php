<?php
session_start();
include 'db.php';

/* Demo dữ liệu */
$order = [
    'id' => 'ORD001',
    'date' => '2026-04-28',
    'status' => 'Đã giao hàng'
];

$items = [
    [
        'title' => 'The Art of Reading',
        'price' => 299000,
        'qty' => 2,
        'image' => 'images/book1.jpg'
    ],
    [
        'title' => 'Modern Literature',
        'price' => 350000,
        'qty' => 1,
        'image' => 'images/book2.jpg'
    ]
];

$subtotal = 948000;
$shipping = 30000;
$total = $subtotal + $shipping;
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>

    <link rel="stylesheet" href="css/order_detail.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<div class="container">

    <a href="user.php?tab=orders" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Quay lại đơn hàng
    </a>

    <!-- HEADER -->

    <div class="order-header">

        <div>
            <h1>Đơn hàng #<?= $order['id'] ?></h1>

            <p>
                Đặt ngày:
                <?= $order['date'] ?>
            </p>
        </div>

        <div class="status delivered">
            <i class="bi bi-check-circle"></i>
            <?= $order['status'] ?>
        </div>

    </div>

    <!-- TIMELINE -->

    <div class="card timeline-card">

        <h2>Trạng thái đơn hàng</h2>

        <div class="timeline">

            <div class="timeline-item active">
                <div class="timeline-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>

                <div>
                    <h4>Đặt hàng</h4>
                    <p>2026-04-28</p>
                </div>
            </div>

            <div class="timeline-item active">
                <div class="timeline-icon">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <div>
                    <h4>Xác nhận</h4>
                    <p>Đã hoàn thành</p>
                </div>
            </div>

            <div class="timeline-item active">
                <div class="timeline-icon">
                    <i class="bi bi-truck"></i>
                </div>

                <div>
                    <h4>Đang giao</h4>
                    <p>Đã hoàn thành</p>
                </div>
            </div>

            <div class="timeline-item active">
                <div class="timeline-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div>
                    <h4>Hoàn thành</h4>
                    <p>Đã hoàn thành</p>
                </div>
            </div>

        </div>

    </div>

    <div class="content-grid">

        <!-- LEFT -->

        <div>

            <div class="card">

                <h2>Sản phẩm</h2>

                <?php foreach($items as $item): ?>

                    <div class="product-item">

                        <img src="<?= $item['image'] ?>" alt="">

                        <div class="product-info">

                            <h3><?= $item['title'] ?></h3>

                            <p>
                                Số lượng:
                                <?= $item['qty'] ?>
                            </p>

                            <span>
                                <?= number_format($item['price']) ?>đ
                            </span>

                        </div>

                        <div class="product-total">
                            <?= number_format($item['price'] * $item['qty']) ?>đ
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

            <div class="card">

                <h2>Thao tác</h2>

                <div class="action-buttons">

                    <button class="primary-btn">
                        <i class="bi bi-arrow-repeat"></i>
                        Mua lại
                    </button>

                    <button class="outline-btn">
                        <i class="bi bi-download"></i>
                        Tải hóa đơn
                    </button>

                    <button class="outline-btn">
                        <i class="bi bi-telephone"></i>
                        Liên hệ hỗ trợ
                    </button>

                </div>

            </div>

        </div>

        <!-- RIGHT -->

        <div>

            <div class="card">

                <h2>Tóm tắt đơn hàng</h2>

                <div class="summary-row">
                    <span>Tạm tính</span>
                    <span><?= number_format($subtotal) ?>đ</span>
                </div>

                <div class="summary-row">
                    <span>Phí vận chuyển</span>
                    <span><?= number_format($shipping) ?>đ</span>
                </div>

                <hr>

                <div class="summary-total">
                    <span>Tổng cộng</span>
                    <span><?= number_format($total) ?>đ</span>
                </div>

            </div>

            <div class="card">

                <h2>
                    <i class="bi bi-geo-alt"></i>
                    Địa chỉ giao hàng
                </h2>

                <p><strong>Nguyễn Văn A</strong></p>

                <p>0912 345 678</p>

                <p>
                    123 Đường ABC,
                    Phường XYZ,
                    Quận 1,
                    TP.HCM
                </p>

            </div>

            <div class="card">

                <h2>
                    <i class="bi bi-credit-card"></i>
                    Phương thức thanh toán
                </h2>

                <p>Thanh toán khi nhận hàng (COD)</p>

            </div>

        </div>

    </div>

</div>

</body>
</html>