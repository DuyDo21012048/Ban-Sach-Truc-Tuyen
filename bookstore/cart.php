<?php 
include 'db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$backUrl = 'home.php';

if(isset($_GET['back'])){

    $backUrl = urldecode($_GET['back']);

}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="css/cart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
</head>
<body>

<!-- HEADER -->
<?php include 'header.php'; ?>

<div class="container mt-5">

    <!-- Back -->
    <?php
    $backUrl = $_SESSION['back_url'] ?? 'home.php';
    ?>

    <a href="<?= $backUrl ?>" class="back-link">
        <i class="bi bi-arrow-left"></i>
        Quay lại
    </a>

    <!-- Title -->
    <h1 class="mt-4 mb-4 fw-bold">Giỏ hàng của bạn</h1>

        

        <?php
        $total = 0;
        $shipping = 30000;

        $cartItems = mysqli_query($conn,"
            SELECT
                carts.book_id,
                carts.quantity AS cart_quantity,
                books.*
            FROM carts
            JOIN books
                ON books.id = carts.book_id
            WHERE carts.user_id = $user_id
        ");

        $cartBooks = [];

        while($row = mysqli_fetch_assoc($cartItems)){
            $cartBooks[] = $row;
        }

        $cartCount = count($cartBooks);
        ?>
        <?php if($cartCount > 0): ?>
        <div class="row">
            
            <!-- LEFT SIDE -->
            <div class="col-md-8">
                <?php foreach($cartBooks as $book): ?>

                    <?php
                    $id = $book['book_id'];
                    $qty = $book['cart_quantity'];

                    $subtotal = $book['price'] * $qty;
                    $total += $subtotal;
                    ?>

                    <!-- MỖI SÁCH = 1 FRAME RIÊNG -->
                    <div class="cart-card mb-4">

                        <div class="d-flex align-items-center justify-content-between">

                            <!-- LEFT -->
                            <div class="d-flex align-items-center gap-4">

                                <!-- IMAGE -->
                                <img src="<?= $book['image'] ?>" class="cart-image">

                                <!-- INFO -->
                                <div>

                                    <h3 class="book-title">
                                        <?= $book['title'] ?>
                                    </h3>

                                    <p class="book-price">
                                        <?= number_format($book['price']) ?>đ
                                    </p>

                                    <!-- QTY -->
                                    <div class="qty-box">

                                        <?php if ($qty > 1): ?>
                                            <a href="update_cart.php?id=<?= $id ?>&action=minus"
                                            class="qty-btn">−</a>
                                        <?php else: ?>
                                            <span class="qty-btn disabled-btn">−</span>
                                        <?php endif; ?>

                                        <span class="qty-number">
                                            <?= $qty ?>
                                        </span>

                                        <a href="update_cart.php?id=<?= $id ?>&action=plus"
                                        class="qty-btn">+</a>

                                    </div>

                                </div>
                            </div>

                            <!-- RIGHT -->
                            <div>
                                <a href="update_cart.php?id=<?= $id ?>&action=delete" class="remove-btn">
                                    <i class="bi bi-trash3-fill"></i> Xóa
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>   

            </div>          
            <!-- RIGHT SIDE -->            
            <div class="col-md-4">

                <!-- FRAME RIÊNG CHO TÓM TẮT ĐƠN HÀNG -->
                <div class="summary-box">

                    <h2 class="summary-title">
                        Tóm tắt đơn hàng
                    </h2>

                    <!-- Tạm tính -->
                    <div class="summary-row">
                        <span>Tạm tính</span>
                        <span class="price-right">
                            <?= number_format($total) ?>đ
                        </span>
                    </div>

                    <!-- Phí ship -->
                    <div class="summary-row">
                        <span>Phí vận chuyển</span>
                        <span class="price-right">
                            <?= number_format($shipping) ?>đ
                        </span>
                    </div>

                    <hr>

                    <!-- Tổng cộng -->
                    <div class="summary-total">
                        <span>Tổng cộng</span>
                        <span class="price-total">
                            <?= number_format($total + $shipping) ?>đ
                        </span>
                    </div>

                    <!-- Button -->
                    <a href="order.php" class="btn checkout-btn w-100">
                        Thanh toán
                    </a>

                    <a href="home.php" class="btn continue-btn w-100">
                        Tiếp tục mua sắm
                    </a>

                    <hr>

                    <!-- Discount -->
                    <p class="discount-label">
                        Mã giảm giá
                    </p>

                    <div class="d-flex gap-2">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Nhập mã"
                        >

                        <button class="apply-btn">
                            Áp dụng
                        </button>
                    </div>

                </div>

            </div>
            <?php else: ?>                                    
            <!-- Empty Cart Box -->
            <div class="row justify-content-center">

                <div class="col-md-8">

                    <div class="empty-cart-box text-center">

                        <div class="empty-icon">
                            <i class="bi bi-bag-heart"></i>
                        </div>

                        <h3 class="empty-title">
                            Giỏ hàng trống
                        </h3>

                        <p class="empty-text">
                            Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm
                        </p>

                        <a href="<?= $backUrl ?>" class="btn explore-btn">
                            Khám phá sách
                        </a>

                    </div>

                </div>

            </div>
            <?php endif; ?>
        </div>      
</div>

</body>
</html>