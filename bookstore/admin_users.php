<?php
session_start();
include 'db.php';
include 'admin_auth.php';

$where = "";

if(!empty($_GET['keyword'])){

    $keyword = mysqli_real_escape_string(
        $conn,
        $_GET['keyword']
    );

    $where = "
        WHERE users.name LIKE '%$keyword%'
        OR users.email LIKE '%$keyword%'
        OR users.phone LIKE '%$keyword%'
    ";
}

$users = mysqli_query($conn,"
SELECT
    users.*,

    COUNT(DISTINCT orders.id) total_orders,

    COALESCE(
        SUM(
            CASE
                WHEN orders.status='delivered'
                THEN orders.total_price
                ELSE 0
            END
        ),0
    ) total_spent,

    MAX(orders.created_at) last_order

FROM users

LEFT JOIN orders
    ON orders.user_id = users.id

$where

GROUP BY users.id
");
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Quản lý người dùng</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<link rel="stylesheet" href="css/admin_user.css">

</head>
<body>
<div class="admin-layout">
<div class="container my-4">

    <a href="home.php" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Quay lại
    </a>

    <h1 class="admin-heading">
        Quản trị
    </h1>

    <p class="admin-subtitle">
        Quản lý hệ thống cửa hàng
    </p>

    <!-- MENU -->

    <?php include 'admin_menu.php'; ?>

    <h1 class="page-title">
        Quản lý người dùng
    </h1>

    <p class="page-subtitle">
        Xem và quản lý người dùng
    </p>
    <div class="search">
        <form method="GET" class="search-box">

        <?php if(!empty($_GET['status'])): ?>
            <input type="hidden"
                name="status"
                value="<?= $_GET['status'] ?>">
        <?php endif; ?>

        <i class="bi bi-search"></i>

        <input
            type="text"
            name="keyword"
            value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
            placeholder="Tìm tên khách hàng, email, Số điện thoại..."
        >

        </form>
    </div>        
    <table class="table table-hover">

        <thead>
            <tr>
                <th>ID</th>
                <th>KHÁCH HÀNG</th>
                <th>SỐ ĐIỆN THOẠI</th>
                <th>NGÀY THAM GIA</th>
                <th>TỔNG ĐƠN</th>
                <th>TỔNG CHI TIÊU</th>
                <th>ĐƠN GẦN NHẤT</th>
                <th>THAO TÁC</th>
            </tr>
        </thead>

        <tbody>

        <?php while($user = mysqli_fetch_assoc($users)): ?>

        <tr>

            <td>#<?= $user['id'] ?></td>

            <td class="customer-cell">
                <div class="customer-name">
                    <?= htmlspecialchars($user['name']) ?>
                </div>

                <div class="customer-email">
                    <?= htmlspecialchars($user['email']) ?>
                </div>
            </td>

            <td>
                <?= !empty($user['phone']) ? htmlspecialchars($user['phone']) : '-' ?>
            </td>

            <td>
                <?= !empty($user['created_at'])
                    ? date('Y-m-d',strtotime($user['created_at']))
                    : '-'
                ?>
            </td>

            <td class="total-orders">
                <?= $user['total_orders'] ?> đơn
            </td>

            <td class="spent-money">
                <?= number_format($user['total_spent']) ?>đ
            </td>

            <td>
                <?= $user['last_order']
                    ? date('Y-m-d',strtotime($user['last_order']))
                    : '-'
                ?>
            </td>

            <td>

                <button
                    class="view-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#userModal<?= $user['id'] ?>"
                >
                    <i class="bi bi-eye"></i>
                </button>

            </td>

        </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

    <?php
    mysqli_data_seek($users, 0);

    while($user = mysqli_fetch_assoc($users)):

    $userOrders = mysqli_query($conn,"
        SELECT
            orders.*,
            (
                SELECT COALESCE(SUM(quantity),0)
                FROM order_items
                WHERE order_items.order_id = orders.id
            ) qty
        FROM orders
        WHERE user_id=".$user['id']."
        ORDER BY id DESC
        LIMIT 5
    ");
    ?>

    <div class="modal fade"
        id="userModal<?= $user['id'] ?>"
        tabindex="-1">

        <div class="modal-dialog modal-xl">

            <div class="modal-content customer-modal">

                <div class="modal-header">

                    <h3>Thông tin khách hàng</h3>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="customer-info-box">

                        <div>
                            <span>Họ và tên</span>
                            <strong><?= htmlspecialchars($user['name']) ?></strong>
                        </div>

                        <div>
                            <span>Email</span>
                            <strong><?= htmlspecialchars($user['email']) ?></strong>
                        </div>

                        <div>
                            <span>Số điện thoại</span>
                            <strong><?= $user['phone'] ?: '-' ?></strong>
                        </div>

                        <div>
                            <span>Ngày tham gia</span>
                            <strong>
                                <?= date('Y-m-d',strtotime($user['created_at'])) ?>
                            </strong>
                        </div>

                    </div>

                    <div class="customer-stats">

                        <div class="info-card blue">
                            <span>Tổng đơn hàng</span>
                            <strong><?= $user['total_orders'] ?></strong>
                        </div>

                        <div class="info-card green">
                            <span>Tổng chi tiêu</span>
                            <strong>
                                <?= number_format($user['total_spent']) ?>đ
                            </strong>
                        </div>

                        <div class="info-card purple">
                            <span>Đơn gần nhất</span>
                            <strong>
                                <?= $user['last_order']
                                    ? date('Y-m-d',strtotime($user['last_order']))
                                    : '-'
                                ?>
                            </strong>
                        </div>

                    </div>

                    <h4 class="history-title">
                        Lịch sử mua hàng
                    </h4>

                    <table class="table history-table">

                        <thead>
                            <tr>
                                <th>MÃ ĐƠN</th>
                                <th>NGÀY ĐẶT</th>
                                <th>SỐ LƯỢNG</th>
                                <th>TỔNG TIỀN</th>
                                <th>TRẠNG THÁI</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php while($order = mysqli_fetch_assoc($userOrders)): ?>

                        <?php

                        $statusClass = match($order['status']){
                            'waiting_confirm' => 'waiting',
                            'pending' => 'processing',
                            'shipping' => 'shipping',
                            'delivered' => 'delivered',
                            'cancelled' => 'cancelled',
                            default => 'waiting'
                        };

                        $statusText = match($order['status']){
                            'waiting_confirm' => 'Chờ xử lý',
                            'pending' => 'Đang xử lý',
                            'shipping' => 'Đang giao',
                            'delivered' => 'Đã giao',
                            'cancelled' => 'Đã hủy',
                            default => $order['status']
                        };

                        ?>

                        <tr>

                            <td><?= $order['order_code'] ?></td>

                            <td>
                                <?= date('Y-m-d',strtotime($order['created_at'])) ?>
                            </td>

                            <td>
                                <?= $order['qty'] ?> sản phẩm
                            </td>

                            <td>
                                <?= number_format($order['total_price']) ?>đ
                            </td>

                            <td>
                                <span class="status-pill <?= $statusClass ?>">
                                    <?= $statusText ?>
                                </span>
                            </td>

                        </tr>

                        <?php endwhile; ?>

                        </tbody>

                    </table>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-light w-100"
                        data-bs-dismiss="modal">
                        Đóng
                    </button>

                </div>

            </div>

        </div>

    </div>

    <?php endwhile; ?>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>