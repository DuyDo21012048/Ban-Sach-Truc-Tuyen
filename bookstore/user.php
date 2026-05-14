<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
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

    <a href="home.php" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Quay lại
    </a>
    
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

</body>
</html>