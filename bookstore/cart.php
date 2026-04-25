<?php 
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="cart.css">
</head>
<body>

<div class="container mt-5">

    <!-- Back -->
    <a href="index.php" class="text-dark text-decoration-none fw-semibold">
        ← Tiếp tục mua sắm
    </a>

    <!-- Title -->
    <h1 class="mt-4 mb-4 fw-bold">Giỏ hàng của bạn</h1>

    <div class="row">

        <!-- LEFT SIDE -->

        <div class="col-md-8">

        <?php
        $total = 0;
        $shipping = 30000;

        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {

            foreach ($_SESSION['cart'] as $id => $qty) {

                $result = mysqli_query($conn, "SELECT * FROM books WHERE id = $id");
                $book = mysqli_fetch_assoc($result);

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

                                <a href="update_cart.php?id=<?= $id ?>&action=minus"
                                class="qty-btn">−</a>

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
                        <a href="remove.php?id=<?= $id ?>" class="remove-btn">
                            🗑 Xóa
                        </a>
                    </div>

                </div>

            </div>

        <?php
            }

        } else {
            echo "<h4>Giỏ hàng đang trống</h4>";
        }
        ?>

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

                    <a href="index.php" class="btn continue-btn w-100">
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

    </div>

</div>

</body>
</html>