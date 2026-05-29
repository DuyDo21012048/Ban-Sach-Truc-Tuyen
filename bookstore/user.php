<?php
session_start();
include 'db.php';


// =====================================================
// AUTHENTICATION
// =====================================================

$backUrl = 'home.php';

if(isset($_GET['back'])){
    $backUrl = urldecode($_GET['back']);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


// =====================================================
// USER INFORMATION
// =====================================================

$result = mysqli_query($conn, "
    SELECT *
    FROM users
    WHERE id = $user_id
");

$user = mysqli_fetch_assoc($result);


// =====================================================
// STATISTICS
// =====================================================

// Tổng đơn hàng
$orderCountQuery = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM orders
    WHERE user_id = $user_id
");

$orderCount = mysqli_fetch_assoc($orderCountQuery)['total'];


// Tổng yêu thích
$favoriteCountQuery = mysqli_query($conn, "
    SELECT COUNT(*) AS total
    FROM favorites
    WHERE user_id = $user_id
");

$favoriteCount = mysqli_fetch_assoc($favoriteCountQuery)['total'];


// Tổng chi tiêu
$totalSpentQuery = mysqli_query($conn, "
    SELECT COALESCE(SUM(total_price),0) AS total
    FROM orders
    WHERE user_id = $user_id
    AND status = 'delivered'
");

$totalSpent = mysqli_fetch_assoc($totalSpentQuery)['total'];


// =====================================================
// ORDERS
// =====================================================

$orders = mysqli_query($conn, "
    SELECT *
    FROM orders
    WHERE user_id = $user_id
    ORDER BY created_at DESC
");


// =====================================================
// FAVORITES
// =====================================================

$favorites = mysqli_query($conn, "
    SELECT books.*
    FROM favorites

    INNER JOIN books
    ON books.id = favorites.book_id

    WHERE favorites.user_id = $user_id

    ORDER BY favorites.created_at DESC
");

$activeTab = $_GET['tab'] ?? 'overview';

// =====================================================
// ADDRESSES
// =====================================================

$addresses = mysqli_query($conn, "
    SELECT *
    FROM addresses
    WHERE user_id = $user_id
    ORDER BY is_default DESC
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

<!-- HEADER -->
<?php include 'header.php'; ?>

<!-- ==========================================
     PAGE CONTAINER
========================================== -->
<div class="container mt-5">

    <!-- BACK BUTTON -->
    <a href="<?= $backUrl ?>" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Quay lại
    </a>
    
    <div class="row">

        <!-- ==========================================
             SIDEBAR
        ========================================== -->
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

                    <li class="active menu-item" data-tab="overview">
                        <i class="bi bi-person"></i>
                        Tổng quan
                    </li>

                    <li class="menu-item" data-tab="orders">
                        <i class="bi bi-bag"></i>
                        Đơn hàng
                    </li>

                    <li class="menu-item" data-tab="favorites" id="favoritesTab">
                        <i class="bi bi-heart"></i>
                        Yêu thích
                    </li>

                    <li class="menu-item" data-tab="address">
                        <i class="bi bi-geo-alt"></i>
                        Địa chỉ
                    </li>

                    <li class="menu-item" data-tab="settings">
                        <i class="bi bi-gear"></i>
                        Cài đặt
                    </li>

                </ul>

                <a href="logout.php" class="logout-btn">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Đăng xuất
                </a>

            </div>
        </div>

        <!-- ==========================================
             MAIN CONTENT
        ========================================== -->
        <div class="col-md-9">

            <div id="overviewTab">

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
                                <h5><?= $orderCount ?></h5>
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
                                <h5><?= $favoriteCount ?></h5>
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
                                <h5><?= number_format($totalSpent) ?>đ</h5>
                                <p>Tổng chi tiêu</p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ORDERS TAB -->
            <div id="ordersTab" style="display:none;">

                <div class="orders-box">

                    <div class="orders-title">
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

                                if($status == 'waiting_confirm'){
                                    echo '<div class="status waiting-confirm">
                                        <i class="bi bi-hourglass-split"></i>
                                        Chờ xác nhận
                                    </div>';
                                }

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

                                if($status == 'cancelled'){
                                    echo '<div class="status cancelled">
                                            <i class="bi bi-x-circle"></i>
                                            Đã hủy
                                        </div>';
                                }

                                ?>

                                <a href="order_detail.php?id=<?= $order['id'] ?>" class="detail-btn">
                                    Chi tiết
                                </a>

                            </div>

                        </div>

                    <?php } ?>

                </div>

            </div>

            <!-- FAVORITES TAB -->

            <div id="favoritesContent" class="tab-content" style="display:none;">

                <div class="favorites-box">

                    <h2 class="favorites-title">
                        Sách yêu thích
                    </h2>

                    <div class="favorite-grid">

                        <?php

                        $favorites = mysqli_query($conn, "
                            SELECT books.*
                            FROM favorites

                            INNER JOIN books
                            ON books.id = favorites.book_id

                            WHERE favorites.user_id = $user_id

                            ORDER BY favorites.created_at DESC
                        ");

                        if(mysqli_num_rows($favorites) > 0){

                            while($book = mysqli_fetch_assoc($favorites)){

                        ?>

                            <div class="favorite-card">

                                <a href="book_detail.php?id=<?= $book['id'] ?>" class="book-link">

                                    <img src="<?= $book['image'] ?>" alt="">

                                    <div class="favorite-body">

                                        <span class="favorite-type">
                                            <?= $book['cover_type'] ?>
                                        </span>

                                        <h3 class="favorite-title-book">
                                            <?= $book['title'] ?>
                                        </h3>

                                        <p class="favorite-author">
                                            <?= $book['author'] ?>
                                        </p>

                                        <div class="favorite-price">
                                            <?= number_format($book['price']) ?>đ
                                        </div>

                                    </div>

                                </a>        

                                <div class="favorite-actions">

                                    <form action="add_to_cart.php" method="POST">

                                        <input
                                            type="hidden"
                                            name="id"
                                            value="<?= $book['id'] ?>"
                                        >

                                        <input
                                            type="hidden"
                                            name="quantity"
                                            value="1"
                                        >
                                        
                                        <input
                                            type="hidden"
                                            name="redirect_tab"
                                            value="favorites"
                                        >

                                        <button type="submit" class="favorite-btn">
                                            Thêm vào giỏ
                                        </button>

                                    </form>

                                    <a href="remove_favorite.php?id=<?= $book['id'] ?>&tab=favorites"
                                    class="remove-favorite">
                                       Xóa
                                    </a>

                                </div>

                            </div>

                        <?php

                            }

                        } else {

                        ?>

                            <div class="empty-favorites">

                                <i class="bi bi-heart"></i>

                                <p>
                                    Bạn chưa có sách yêu thích nào
                                </p>

                            </div>

                        <?php } ?>

                    </div>

                </div>

            </div>

            <!-- ADDRESS TAB -->

            <div id="addressTab" style="display:none;">

                <div class="address-box">

                    <!-- HEADER -->

                    <div class="address-header">

                        <h2>Địa chỉ giao hàng</h2>

                        <button
                            class="add-address-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#addAddressModal"
                        >
                            + Thêm địa chỉ
                        </button>

                    </div>

                    <!-- LIST -->

                    <?php while($address = mysqli_fetch_assoc($addresses)) { ?>

                        <div class="address-card">

                            <div class="address-info">

                                <div class="address-top">

                                    <h4>
                                        <?= $address['title'] ?>
                                    </h4>

                                    <?php if($address['is_default']) { ?>

                                        <span class="default-badge">
                                            <i class="bi bi-star-fill"></i>
                                            Mặc định
                                        </span>

                                    <?php } ?>

                                </div>

                                <p>
                                    <?= $address['address'] ?>
                                </p>

                                <span>
                                    SDT: <?= $address['phone'] ?>
                                </span>

                                <!-- ACTIONS -->

                                <div class="address-actions">

                                    <?php if(!$address['is_default']) { ?>

                                        <a
                                            href="set_default_address.php?id=<?= $address['id'] ?>"
                                            class="set-default-btn"
                                        >
                                            Đặt làm mặc định
                                        </a>

                                    <?php } ?>

                                    <button
                                        class="edit-btn-address"

                                        data-id="<?= $address['id'] ?>"
                                        data-title="<?= $address['title'] ?>"
                                        data-phone="<?= $address['phone'] ?>"
                                        data-address="<?= $address['address'] ?>"

                                        data-bs-toggle="modal"
                                        data-bs-target="#editAddressModal"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        Sửa
                                    </button>

                                    <a
                                        href="delete_address.php?id=<?= $address['id'] ?>"
                                        class="delete-address-btn"
                                        onclick="return confirm('Xóa địa chỉ này?')"
                                    >
                                        <i class="bi bi-trash"></i>
                                        Xóa
                                    </a>

                                </div>

                            </div>

                        </div>

                    <?php } ?>

                </div>

                <!-- ADD ADDRESS MODAL -->

                <div class="modal fade" id="addAddressModal">

                    <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content">

                            <form action="add_address.php" method="POST">

                                <div class="modal-header">

                                    <h3>Thêm địa chỉ mới</h3>

                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                    ></button>

                                </div>

                                <div class="modal-body">

                                    <div class="mb-3">

                                        <label>Tên địa chỉ</label>

                                        <input
                                            type="text"
                                            name="title"
                                            class="form-control"
                                            placeholder="Ví dụ: Nhà riêng"
                                            required
                                        >

                                    </div>

                                    <div class="mb-3">

                                        <label>Số điện thoại</label>

                                        <input
                                            type="text"
                                            name="phone"
                                            class="form-control"
                                            required
                                        >

                                    </div>

                                    <div class="mb-3">

                                        <label>Địa chỉ chi tiết</label>

                                        <textarea
                                            name="address"
                                            class="form-control"
                                            rows="4"
                                            required
                                        ></textarea>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button
                                        type="button"
                                        class="btn btn-light"
                                        data-bs-dismiss="modal"
                                    >
                                        Hủy
                                    </button>

                                    <button type="submit" class="btn btn-primary">
                                        Thêm địa chỉ
                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                <!-- EDIT ADDRESS MODAL -->

                <div class="modal fade" id="editAddressModal">

                    <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content">

                            <form action="edit_address.php" method="POST">

                                <input type="hidden" name="id" id="edit_id">

                                <div class="modal-header">

                                    <h3>Sửa địa chỉ</h3>

                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                    ></button>

                                </div>

                                <div class="modal-body">

                                    <div class="mb-3">

                                        <label>Tên địa chỉ</label>

                                        <input
                                            type="text"
                                            name="title"
                                            id="edit_title"
                                            class="form-control"
                                            required
                                        >

                                    </div>

                                    <div class="mb-3">

                                        <label>Số điện thoại</label>

                                        <input
                                            type="text"
                                            name="phone"
                                            id="edit_phone"
                                            class="form-control"
                                            required
                                        >

                                    </div>

                                    <div class="mb-3">

                                        <label>Địa chỉ</label>

                                        <textarea
                                            name="address"
                                            id="edit_address"
                                            class="form-control"
                                            rows="4"
                                            required
                                        ></textarea>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button
                                        type="button"
                                        class="btn btn-light"
                                        data-bs-dismiss="modal"
                                    >
                                        Hủy
                                    </button>

                                    <button type="submit" class="btn btn-primary">
                                        Lưu thay đổi
                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

            <!-- SETTINGS TAB -->
            <div id="settingsTab" style="display:none;">

                <!-- SETTINGS BOX -->

                <div class="settings-box">

                    <h2 class="settings-title">
                        Cài đặt tài khoản
                    </h2>

                    <!-- EMAIL -->

                    <div class="setting-row">

                        <div>

                            <h5>Thông báo qua Email</h5>

                            <p>Nhận thông báo về đơn hàng và khuyến mãi</p>

                        </div>

                        <label class="switch">

                            <input type="checkbox" checked>

                            <span class="slider"></span>

                        </label>

                    </div>

                    <!-- SMS -->

                    <div class="setting-row">

                        <div>

                            <h5>Thông báo qua SMS</h5>

                            <p>Nhận tin nhắn về trạng thái đơn hàng</p>

                        </div>

                        <label class="switch">

                            <input type="checkbox">

                            <span class="slider"></span>

                        </label>

                    </div>

                </div>

                <!-- CHANGE PASSWORD -->

                <div class="password-box">

                    <h2 class="settings-title">
                        Đổi mật khẩu
                    </h2>

                    <form action="change_password.php" method="POST">

                        <div class="mb-3">

                            <label>Mật khẩu hiện tại</label>

                            <input
                                type="password"
                                name="current_password"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label>Mật khẩu mới</label>

                            <input
                                type="password"
                                name="new_password"
                                class="form-control"
                                required
                            >

                        </div>

                        <div class="mb-4">

                            <label>Xác nhận mật khẩu mới</label>

                            <input
                                type="password"
                                name="confirm_password"
                                class="form-control"
                                required
                            >

                        </div>

                        <button class="save-password-btn">

                            Cập nhật mật khẩu

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

// =====================================================
// EDIT PROFILE
// =====================================================
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

// =====================================================
// AVATAR UPLOAD
// =====================================================
const avatarInput = document.getElementById('avatarInput');

avatarInput.addEventListener('change', () => {

    avatarInput.form.submit();

});

// =====================================================
// TAB NAVIGATION
// =====================================================

const menuItems = document.querySelectorAll('.menu-item');

const overviewTab = document.getElementById('overviewTab');
const ordersTab = document.getElementById('ordersTab');
const favoritesContent = document.getElementById('favoritesContent');
const addressTab = document.getElementById('addressTab');
const settingsTab = document.getElementById('settingsTab');

function showTab(tab){

    // ACTIVE MENU
    menuItems.forEach(item => {
        item.classList.remove('active');
    });

    const activeMenu = document.querySelector(
        `[data-tab="${tab}"]`
    );

    if(activeMenu){
        activeMenu.classList.add('active');
    }

    // HIDE ALL
    overviewTab.style.display = 'none';
    ordersTab.style.display = 'none';
    favoritesContent.style.display = 'none';
    addressTab.style.display = 'none';
    settingsTab.style.display = 'none';

    // SHOW CURRENT
    if(tab === 'overview'){
        overviewTab.style.display = 'block';
    }

    if(tab === 'orders'){
        ordersTab.style.display = 'block';
    }

    if(tab === 'favorites'){
        favoritesContent.style.display = 'block';
    }

    if(tab === 'address'){
        addressTab.style.display = 'block';
    }

    if(tab === 'settings'){
        settingsTab.style.display = 'block';
    }

    // SAVE TAB
    localStorage.setItem('activeUserTab', tab);
}

// CLICK EVENT
menuItems.forEach(item => {

    item.addEventListener('click', () => {

        const tab = item.dataset.tab;

        showTab(tab);

    });

});

// =====================================================
// RESTORE TAB AFTER REFRESH
// =====================================================

window.addEventListener('load', () => {

    const savedTab =
        localStorage.getItem('activeUserTab') || 'overview';

    showTab(savedTab);

});

// =====================================================
// ADDRESS EDIT
// =====================================================

const editButtons = document.querySelectorAll('.edit-btn-address');

editButtons.forEach(button => {

    button.addEventListener('click', () => {

        document.getElementById('edit_id').value =
            button.dataset.id;

        document.getElementById('edit_title').value =
            button.dataset.title;

        document.getElementById('edit_phone').value =
            button.dataset.phone;

        document.getElementById('edit_address').value =
            button.dataset.address;

    });

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>