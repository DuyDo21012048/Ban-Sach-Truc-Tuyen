<!-- header.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Đếm số lượng sản phẩm trong giỏ */
$count = 0;

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $count = array_sum($_SESSION['cart']);
}
?>

<link rel="stylesheet" href="css/header.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<div class="container-fluid navbar-custom">
    <div class="d-flex justify-content-evenly align-items-center">

        <!-- Logo -->
        
        <a href="home.php" class="logo-link">
            <h3 class="logo">BOOKSTORE</h3>
        </a>

        <!-- Search -->
        <input
            type="text"
            class="form-control search-box"
            placeholder="Tìm kiếm sách..."
        >

        <!-- Right Menu -->
        <div class="nav-right">

            <!-- Login -->
            <a href="login.php" class="nav-link-custom me-3">
                <i class="bi bi-person-circle me-1"></i>
                Login
            </a>

            <!-- Cart -->
            <a href="cart.php" class="nav-link-custom cart-link position-relative pe-4">
                <i class="bi bi-cart3 me-1"></i>
                Cart

                <?php if ($count > 0): ?>
                    <span class="cart-badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $count ?>
                    </span>
                <?php endif; ?>
            </a>

        </div>
    </div>
</div>