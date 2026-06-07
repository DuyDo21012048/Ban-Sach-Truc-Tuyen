<?php
session_start();
include 'db.php';
include 'admin_auth.php';

$status = $_GET['status'] ?? '';
$keyword = trim($_GET['keyword'] ?? '');

$where = [];

if($status != ''){
    $where[] = "orders.status='$status'";
}

if($keyword != ''){

    $keyword = mysqli_real_escape_string($conn,$keyword);

    $where[] = "(
        orders.order_code LIKE '%$keyword%'
        OR users.name LIKE '%$keyword%'
        OR users.email LIKE '%$keyword%'
    )";
}

$whereSql = '';

if(count($where)){
    $whereSql = "WHERE ".implode(' AND ',$where);
}

$orders = mysqli_query($conn,"
    SELECT
        orders.*,
        users.name,
        users.email

    FROM orders

    LEFT JOIN users
        ON users.id = orders.user_id

    $whereSql

    ORDER BY orders.id DESC
");


$totalOrders = mysqli_num_rows(mysqli_query($conn,"
    SELECT id FROM orders
"));

$waitingCount = mysqli_num_rows(mysqli_query($conn,"
    SELECT id FROM orders
    WHERE status='waiting_confirm'
"));

$processingCount = mysqli_num_rows(mysqli_query($conn,"
    SELECT id FROM orders
    WHERE status='pending'
"));

$shippingCount = mysqli_num_rows(mysqli_query($conn,"
    SELECT id FROM orders
    WHERE status='shipping'
"));

$deliveredCount = mysqli_num_rows(mysqli_query($conn,"
    SELECT id FROM orders
    WHERE status='delivered'
"));

$cancelledCount = mysqli_num_rows(mysqli_query($conn,"
    SELECT id FROM orders
    WHERE status='cancelled'
"));

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Quản lý đơn hàng</title>

<link rel="stylesheet" href="css/admin_orders.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

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
        Quản lý đơn hàng
    </h1>

    <p class="page-subtitle">
        Xem và quản lý tất cả đơn hàng
    </p>
     <div class="order-filters">

        <a href="admin_orders.php"
            class="<?= empty($_GET['status']) ? 'active' : '' ?>">
            Tất cả
        </a>

        <a href="?status=waiting_confirm"
            class="<?= ($_GET['status'] ?? '')=='waiting_confirm' ? 'active':'' ?>">
            Chờ xử lý
        </a>

        <a href="?status=pending"
            class="<?= ($_GET['status'] ?? '')=='pending' ? 'active':'' ?>">
            Đang xử lý
        </a>

        <a href="?status=shipping"
            class="<?= ($_GET['status'] ?? '')=='shipping' ? 'active':'' ?>">
            Đang giao
        </a>

        <a href="?status=delivered"
            class="<?= ($_GET['status'] ?? '')=='delivered' ? 'active':'' ?>">
            Đã giao
        </a>

        <a href="?status=cancelled"
            class="<?= ($_GET['status'] ?? '')=='cancelled' ? 'active':'' ?>">
            Đã hủy
        </a>

    </div>
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
                placeholder="Tìm theo mã đơn, tên khách hàng, email..."
            >

        </form>
    </div>
    <div class="table-box">

        <table class="table table-hover">

            <thead>

                <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Thanh toán</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
                </tr>

            </thead>

            <tbody>

                <?php while($order=mysqli_fetch_assoc($orders)): ?>

                    <tr>

                        <td>
                            <div class="order-code">
                                <?= $order['order_code'] ?>
                            </div>
                        </td>

                        <td class="customer-cell">

                            <div class="customer-name">
                                <?= htmlspecialchars($order['name']) ?>
                            </div>

                            <div class="customer-email">
                                <?= htmlspecialchars($order['email']) ?>
                            </div>

                        </td>

                        <td><?= $order['created_at'] ?></td>

                        <td>
                            <div class="total-price">
                                <?= number_format($order['total_price']) ?>đ
                            </div>
                        </td>

                        <td><?= strtoupper($order['payment_method']) ?></td>
    
                        <td>

                        <?php
                        switch($order['status']){

                            case 'waiting_confirm':
                                echo '<span class="status waiting">
                                        <i class="bi bi-clock"></i>
                                        Chờ xử lý
                                    </span>';
                                break;

                            case 'pending':
                                echo '<span class="status pending">
                                        <i class="bi bi-box"></i>
                                        Đang xử lý
                                    </span>';
                                break;

                            case 'shipping':
                                echo '<span class="status shipping">
                                        <i class="bi bi-truck"></i>
                                        Đang giao
                                    </span>';
                                break;

                            case 'delivered':
                                echo '<span class="status delivered">
                                        <i class="bi bi-check-circle"></i>
                                        Đã giao
                                    </span>';
                                break;

                            case 'cancelled':
                                echo '<span class="status cancelled">
                                        <i class="bi bi-x-circle"></i>
                                        Đã hủy
                                    </span>';
                                break;
                        }
                        ?>

                        </td>
                        <td class="actions">

                            <a
                            href="order_detail.php?id=<?= $order['id'] ?>"
                            class="view-btn">

                                <i class="bi bi-eye"></i>

                            </a>

                            <button
                                class="edit-btn"
                                data-id="<?= $order['id'] ?>"
                                data-code="<?= $order['order_code'] ?>"
                                data-status="<?= $order['status'] ?>">

                                <i class="bi bi-pencil"></i>

                            </button>

                        </td>
                    </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>
<div class="modal fade" id="statusModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h4 id="modalTitle"></h4>

                <button class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <form action="update_order_status.php" method="POST">

                <input type="hidden" name="order_id" id="orderId">

                    <div class="status-options">

                        <label class="status-card">

                            <input type="radio"
                                name="status"
                                value="waiting_confirm">

                                <div>
                                    <h5>Chờ xử lý</h5>
                                    <p>Đơn hàng chưa được xử lý</p>
                                </div>

                        </label>

                        <label class="status-card">

                            <input type="radio" name="status" value="pending">

                                <div>
                                    <h5>Đang xử lý</h5>
                                    <p>Đang chuẩn bị hàng</p>
                                </div>

                        </label>

                        <label class="status-card">

                            <input type="radio" name="status" value="shipping">

                                <div>
                                    <h5>Đang giao hàng</h5>
                                    <p>Đơn hàng đang vận chuyển</p>
                                </div>

                        </label>

                        <label class="status-card">

                            <input type="radio" name="status" value="delivered">

                                <div>
                                    <h5>Đã giao hàng</h5>
                                    <p>Giao hàng thành công</p>
                                </div>

                        </label>

                        <label class="status-card">

                            <input type="radio" name="status" value="cancelled">

                                <div>
                                    <h5>Đã hủy</h5>
                                    <p>Đơn hàng bị hủy</p>
                                </div>

                        </label>

                    </div>

                    <div class="mt-3">

                        <button type="submit" class="btn btn-primary w-100">

                            Cập nhật trạng thái

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
    
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

document
.querySelectorAll('.edit-btn')
.forEach(btn=>{

    btn.addEventListener('click',()=>{

        document.getElementById('orderId').value =
        btn.dataset.id;

        document.getElementById('modalTitle').innerText =
        'Cập nhật trạng thái đơn hàng ' +
        btn.dataset.code;

        const radio =
        document.querySelector(
        `input[name="status"][value="${btn.dataset.status}"]`
        );

        if(radio) radio.checked = true;

        new bootstrap.Modal(
            document.getElementById('statusModal')
        ).show();

    });

});

</script>
</body>
</html>