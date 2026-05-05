<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($result);
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
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3">
            <div class="user-sidebar">

                <div class="user-header text-center">
                    <img src="https://i.pravatar.cc/100" class="avatar">
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

                <button class="btn logout-btn w-100">Đăng xuất</button>

            </div>
        </div>

        <!-- CONTENT -->
        <div class="col-md-9">

            <!-- INFO BOX -->
            <div class="info-box">
                <div class="d-flex justify-content-between">
                    <h4>Thông tin cá nhân</h4>
                    <a href="#" class="edit-btn">
                        <i class="bi bi-pencil"></i> Chỉnh sửa
                    </a>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <p><strong>Họ tên:</strong> <?= $user['name'] ?></p>
                        <p><strong>Điện thoại:</strong> <?= $user['phone'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Email:</strong> <?= $user['email'] ?></p>
                        <p><strong>Thành viên:</strong> Từ <?= $user['joined'] ?></p>
                    </div>
                </div>
            </div>

            <!-- STATS -->
            <div class="row mt-4">

                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="bi bi-bag"></i>
                        <h3>3</h3>
                        <p>Đơn hàng</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="bi bi-heart"></i>
                        <h3>2</h3>
                        <p>Yêu thích</p>
                    </div>
                </div>
                
            </div>

        </div>

    </div>
</div>

</body>
</html>