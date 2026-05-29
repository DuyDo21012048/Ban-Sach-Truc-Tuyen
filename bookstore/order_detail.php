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
   ORDER
===================================================== */

$orderQuery = mysqli_query($conn, "

    SELECT orders.*, addresses.address, addresses.phone, addresses.title
    FROM orders

    LEFT JOIN addresses
    ON addresses.user_id = orders.user_id
    AND addresses.is_default = 1

    WHERE orders.id = $order_id
    AND orders.user_id = $user_id

");

if(mysqli_num_rows($orderQuery) == 0){
    die("Đơn hàng không tồn tại");
}

$order = mysqli_fetch_assoc($orderQuery);


/* =====================================================
   ORDER ITEMS
===================================================== */

$itemsQuery = mysqli_query($conn, "

    SELECT
        order_items.*,
        books.title,
        books.image

    FROM order_items

    JOIN books
    ON books.id = order_items.book_id

    WHERE order_items.order_id = $order_id

");

$items = [];

while($row = mysqli_fetch_assoc($itemsQuery)){
    $items[] = $row;
}


/* =====================================================
   TOTAL
===================================================== */

$subtotal = 0;

foreach($items as $item){

    $subtotal += $item['price'] * $item['quantity'];

}

$shipping = 30000;
$total = $subtotal + $shipping;


/* =====================================================
   STATUS
===================================================== */

$statusText = '';
$statusClass = '';

if($order['status'] == 'waiting_confirm'){
    $statusText = 'Chờ xác nhận';
    $statusClass = 'waiting_confirm';
}

if($order['status'] == 'pending'){
    $statusText = 'Đang xử lý';
    $statusClass = 'pending';
}

if($order['status'] == 'shipping'){
    $statusText = 'Đang giao';
    $statusClass = 'shipping';
}

if($order['status'] == 'delivered'){
    $statusText = 'Đã giao';
    $statusClass = 'delivered';
}

if($order['status'] == 'cancelled'){
    $statusText = 'Đã hủy';
    $statusClass = 'cancelled';
}
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
            <h1>Đơn hàng #<?= $order['order_code'] ?></h1>

            <p>
                Đặt ngày:
                <?= date('d/m/Y', strtotime($order['created_at'])) ?>
            </p>
        </div>

        <?php

        $statusIcon = 'bi bi-clock';

        if($order['status'] == 'waiting_confirm'){
            $statusIcon = 'bi bi-hourglass-split';
        }

        if($order['status'] == 'pending'){
            $statusIcon = 'bi bi-box';
        }

        if($order['status'] == 'shipping'){
            $statusIcon = 'bi bi-truck';
        }

        if($order['status'] == 'delivered'){
            $statusIcon = 'bi bi-check-circle';
        }

        if($order['status'] == 'cancelled'){
            $statusIcon = 'bi bi-x-circle';
        }

        ?>

        <div class="status <?= $statusClass ?>">

            <i class="<?= $statusIcon ?>"></i>

            <?= $statusText ?>

        </div>  

    </div>

    <!-- TIMELINE -->

    <div class="card timeline-card">

        <h2>Trạng thái đơn hàng</h2>

        <div class="timeline">

            <!-- ĐẶT HÀNG -->

            <div class="timeline-item active">

                <div class="timeline-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>

                <div>
                    <h4>Đặt hàng</h4>

                    <p>
                        <?= date('d/m/Y', strtotime($order['created_at'])) ?>
                    </p>
                </div>

            </div>

            <!-- XÁC NHẬN -->

            <div class="timeline-item
                <?= (
                    $order['status'] == 'pending' ||
                    $order['status'] == 'shipping' ||
                    $order['status'] == 'delivered'
                ) ? 'active' : '' ?>
            ">

                <div class="timeline-icon">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <div>

                    <h4>Xác nhận</h4>

                    <p>

                        <?php

                        if(
                            $order['status'] == 'pending' ||
                            $order['status'] == 'shipping' ||
                            $order['status'] == 'delivered'
                        ){
                            echo 'Đã hoàn thành';
                        } else {
                            echo '...';
                        }

                        ?>

                    </p>

                </div>

            </div>

            <!-- ĐANG GIAO -->

            <div class="timeline-item
                <?= (
                    $order['status'] == 'shipping' ||
                    $order['status'] == 'delivered'
                ) ? 'active' : '' ?>
            ">

                <div class="timeline-icon">
                    <i class="bi bi-truck"></i>
                </div>

                <div>

                    <h4>Đang giao</h4>

                    <p>

                        <?php

                        if(
                            $order['status'] == 'shipping' ||
                            $order['status'] == 'delivered'
                        ){
                            echo 'Đã hoàn thành';
                        } else {
                            echo '...';
                        }

                        ?>

                    </p>

                </div>

            </div>

            <!-- HOÀN THÀNH -->

            <div class="timeline-item
                <?= ($order['status'] == 'delivered')
                    ? 'active'
                    : '' ?>
            ">

                <div class="timeline-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div>

                    <h4>Hoàn thành</h4>

                    <p>

                        <?php

                        if($order['status'] == 'delivered'){
                            echo 'Đã hoàn thành';
                        } else {
                            echo '...';
                        }

                        ?>

                    </p>

                </div>

            </div>

        </div>

    </div>

    <?php if($order['status'] == 'cancelled') { ?>

        <div class="cancel-box">

            <i class="bi bi-x-circle"></i>

            Đơn hàng đã bị hủy

        </div>

    <?php } ?>

    <div class="content-grid">

        <!-- LEFT -->

        <div>

            <div class="card">

                <h2>Sản phẩm</h2>

                <?php foreach($items as $item):

                    $itemTotal = $item['price'] * $item['quantity'];

                ?>

                    <div class="product-item">

                        <img src="<?= $item['image'] ?>" alt="">

                        <div class="product-info">

                            <h3><?= $item['title'] ?></h3>

                            <p>
                                Số lượng:
                                <?= $item['quantity'] ?>
                            </p>

                            <span>
                                <?= number_format($item['price']) ?>đ
                            </span>

                        </div>

                        <div class="product-total">
                            <?= number_format($itemTotal) ?>đ
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

            <div class="card">

                <!-- CHỜ XÁC NHẬN / ĐANG XỬ LÝ -->
                <?php if($order['status'] == 'waiting_confirm' || $order['status'] == 'pending') { ?>

                    <a
                        href="cancel_order.php?id=<?= $order['id'] ?>"
                        class="danger-btn"
                        onclick="return confirm('Bạn có chắc muốn hủy đơn hàng?')"
                    >
                        <i class="bi bi-x-circle"></i>
                        Hủy đơn hàng
                    </a>

                    <button class="outline-btn">
                        <i class="bi bi-telephone"></i>
                        Liên hệ hỗ trợ
                    </button>

                <?php } ?>



                <!-- ĐANG GIAO -->
                <?php if($order['status'] == 'shipping') { ?>

                    <button class="outline-btn">
                        <i class="bi bi-telephone"></i>
                        Liên hệ hỗ trợ
                    </button>

                <?php } ?>



                <!-- ĐÃ GIAO -->
                <?php if($order['status'] == 'delivered') { ?>

                    <a href="buy_again.php?id=<?= $order['id'] ?>" class="primary-btn">
                        <i class="bi bi-arrow-repeat"></i>
                        Mua lại
                    </a>

                    <button class="outline-btn">
                        <i class="bi bi-download"></i>
                        Tải hóa đơn
                    </button>

                    <button class="outline-btn">
                        <i class="bi bi-telephone"></i>
                        Liên hệ hỗ trợ
                    </button>

                <?php } ?>



                <!-- ĐÃ HỦY -->
                <?php if($order['status'] == 'cancelled') { ?>

                    <a href="buy_again.php?id=<?= $order['id'] ?>" class="primary-btn">
                        <i class="bi bi-arrow-repeat"></i>
                        Mua lại
                    </a>

                    <button class="outline-btn">
                        <i class="bi bi-telephone"></i>
                        Liên hệ hỗ trợ
                    </button>

                <?php } ?>

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

                <p>
                    <strong><?= $order['title'] ?></strong>
                </p>

                <p>
                    <?= $order['phone'] ?>
                </p>

                <p>
                    <?= $order['address'] ?>
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