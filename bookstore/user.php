<?php
session_start();
include 'db.php';

$backUrl = 'home.php';

if(isset($_GET['back'])){

    $backUrl = urldecode($_GET['back']);

}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($result);

$orders = mysqli_query($conn, "
    SELECT *
    FROM orders
    WHERE user_id = $user_id
    ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>

    <link rel="stylesheet" href="css/user.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

<div class="container mt-5">

    <a href="<?= $backUrl ?>" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Quay lại
    </a>
    
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3">
            <div class="user-sidebar">

                <div class="user-header text-center">

                    <?php

                    $avatar = !empty($user['avatar'])
                        ? 'uploads/avatars/' . $user['avatar']
                        : 'https://i.pravatar.cc/100';

                    ?>

                    <img src="<?= $avatar ?>" class="avatar">

                    <form action="upload_avatar.php"
                        method="POST"
                        enctype="multipart/form-data"
                        class="avatar-form">

                        <input
                            type="file"
                            name="avatar"
                            id="avatarInput"
                            hidden
                            accept="image/*"
                        >

                        <label for="avatarInput" class="change-avatar-btn">
                            <i class="bi bi-camera"></i>
                            Đổi ảnh
                        </label>

                    </form>

                    <h5><?= $user['name'] ?></h5>
                    <p><?= $user['email'] ?></p>
                </div>

                <ul class="menu">
                    <li class="active"><i class="bi bi-person"></i> Tổng quan</li>
                    <li><i class="bi bi-bag"></i> Đơn hàng</li>
                    <li><i class="bi bi-heart"></i> Yêu thích</li>
                    <li><i class="bi bi-geo-alt"></i> Địa chỉ</li>
                    <li><i class="bi bi-gear"></i> Cài đặt</li>
                </ul>

                <a href="logout.php" class="logout-btn">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Đăng xuất
                </a>

            </div>
        </div>

        <!-- CONTENT -->
        <div class="col-md-9">

            <!-- INFO BOX -->
            <div class="info-box">

                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="info-title">Thông tin cá nhân</h2>

                    <button class="edit-btn" id="editToggle">
                        <i class="bi bi-pencil-square"></i>
                        Chỉnh sửa
                    </button>
                </div>

                <!-- VIEW MODE -->
                <div id="viewMode">

                    <div class="info-grid">

                        <div class="info-item">
                            <span class="info-label">Họ tên:</span>
                            <span class="info-value"><?= $user['name'] ?></span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Email:</span>
                            <span class="info-value"><?= $user['email'] ?></span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Điện thoại:</span>
                            <span class="info-value">
                                <?= $user['phone'] ? $user['phone'] : 'Chưa cập nhật' ?>
                            </span>
                        </div>

                        <div class="info-item">
                            <span class="info-label">Thành viên:</span>
                            <span class="info-value">
                                Từ <?= date('m/Y', strtotime($user['created_at'])) ?>
                            </span>
                        </div>

                    </div>

                </div>

                <!-- EDIT MODE -->
                <div id="editMode" style="display:none;">

                    <form action="update_profile.php" method="POST">

                        <div class="mb-3">
                            <label class="form-label">Họ và tên</label>
                            <input
                                type="text"
                                name="name"
                                class="form-control profile-input"
                                value="<?= $user['name'] ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control profile-input"
                                value="<?= $user['email'] ?>"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Số điện thoại</label>
                            <input
                                type="text"
                                name="phone"
                                class="form-control profile-input"
                                value="<?= $user['phone'] ?>"
                            >
                        </div>

                        <button class="save-btn">
                            Lưu thay đổi
                        </button>

                    </form>

                </div>

            </div>

            <!-- STATS -->
            <div class="row mt-4 g-4">

                <div class="col-md-4">
                    <div class="stat-card">

                        <div class="stat-icon blue">
                            <i class="bi bi-bag"></i>
                        </div>

                        <div class="stat-content">
                            <h3>3</h3>
                            <p>Đơn hàng</p>
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card">

                        <div class="stat-icon pink">
                            <i class="bi bi-heart"></i>
                        </div>

                        <div class="stat-content">
                            <h3>2</h3>
                            <p>Yêu thích</p>
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card">

                        <div class="stat-icon green">
                            <i class="bi bi-credit-card"></i>
                        </div>

                        <div class="stat-content">
                            <h3>2.1M</h3>
                            <p>Tổng chi tiêu</p>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<!-- Đơn hàng -->
<div class="orders-wrapper">

    <div class="orders-box">

        <div class="orders-header">
            <h2>Đơn hàng của tôi</h2>
        </div>

        <?php while($order = mysqli_fetch_assoc($orders)) { ?>

            <?php

            $orderId = $order['id'];

            $items = mysqli_query($conn, "

                SELECT books.image
                FROM order_items

                JOIN books
                ON books.id = order_items.book_id

                WHERE order_items.order_id = $orderId

                LIMIT 3

            ");

            $countItems = mysqli_query($conn, "

                SELECT SUM(quantity) as total
                FROM order_items

                WHERE order_id = $orderId

            ");

            $count = mysqli_fetch_assoc($countItems)['total'];

            ?>

            <div class="order-card">

                <!-- LEFT -->
                <div class="order-left">

                    <h4>
                        Đơn hàng #<?= $order['order_code'] ?>
                    </h4>

                    <p class="order-date">
                        <?= date('Y-m-d', strtotime($order['created_at'])) ?>
                    </p>

                    <!-- IMAGES -->
                    <div class="order-images">

                        <?php while($item = mysqli_fetch_assoc($items)) { ?>

                            <img src="<?= $item['image'] ?>">

                        <?php } ?>

                    </div>

                    <p class="order-total">

                        <?= $count ?> sản phẩm
                        •

                        Tổng:
                        <span>
                            <?= number_format($order['total_price']) ?> đ
                        </span>

                    </p>

                </div>

                <!-- RIGHT -->
                <div class="order-right">

                    <?php

                    $status = $order['status'];

                    if($status == 'delivered'){
                        echo '<div class="status delivered">
                                <i class="bi bi-check-circle"></i>
                                Đã giao
                              </div>';
                    }

                    if($status == 'shipping'){
                        echo '<div class="status shipping">
                                <i class="bi bi-box-seam"></i>
                                Đang giao
                              </div>';
                    }

                    if($status == 'pending'){
                        echo '<div class="status pending">
                                <i class="bi bi-clock"></i>
                                Đang xử lý
                              </div>';
                    }

                    ?>

                    <a href="#" class="detail-btn">
                        Chi tiết
                    </a>

                </div>

            </div>

        <?php } ?>

    </div>

</div>
<script>

const editBtn = document.getElementById('editToggle');

const viewMode = document.getElementById('viewMode');
const editMode = document.getElementById('editMode');

let isEdit = false;

editBtn.addEventListener('click', () => {

    isEdit = !isEdit;

    if (isEdit) {

        viewMode.style.display = 'none';
        editMode.style.display = 'block';

        editBtn.innerHTML = `
            <i class="bi bi-x-lg"></i>
            Hủy
        `;

    } else {

        viewMode.style.display = 'block';
        editMode.style.display = 'none';

        editBtn.innerHTML = `
            <i class="bi bi-pencil-square"></i>
            Chỉnh sửa
        `;
    }

});

</script>

<script>
const avatarInput = document.getElementById('avatarInput');

avatarInput.addEventListener('change', () => {

    avatarInput.form.submit();

});
</script>

</body>
</html>