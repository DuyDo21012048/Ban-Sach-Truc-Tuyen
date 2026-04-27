<?php
include 'db.php';
session_start();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    die("Không tìm thấy sản phẩm.");
}
$result = mysqli_query($conn, "SELECT * FROM books WHERE id = $id");
$book = mysqli_fetch_assoc($result);
if (!$book) {
    die("Sản phẩm không tồn tại.");
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sách</title>

    <link rel="stylesheet" href="css/detail.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

<!-- HEADER -->
<?php include 'header.php'; ?>

<div class="container my-5">
    <!-- Back -->
    <a href="home.php" class="text-dark text-decoration-none fw-semibold">
        ← Quay lại
    </a>
    <!-- BOX TRÊN -->
    <div class="detail-top-box">

        <div class="row g-4 align-items-start">

            <!-- BOX ẢNH -->
            <div class="col-md-5">
                <div class="image-box text-center">

                    <img
                        src="<?= $book['image'] ?>"
                        class="detail-image"
                        alt="<?= $book['title'] ?>"
                    >

                </div>
            </div>

            <!-- BOX THÔNG TIN -->
            <div class="col-md-7">
                <div class="info-box">

                    <h2 class="book-title">
                        <?= $book['title'] ?>
                    </h2>

                    <p class="book-rating">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                        <span>(4.5 đánh giá)</span>
                    </p>

                    <p class="book-author">
                        Tác giả:
                        <strong>
                            <?= $book['author'] ?? 'Đang cập nhật' ?>
                        </strong>
                    </p>

                    <p class="book-price">
                        <?= number_format($book['price']) ?>đ
                    </p>

                    <!-- SỐ LƯỢNG -->
                    <div class="qty-box mb-4">

                        <?php if (isset($_GET['qty']) && $_GET['qty'] > 1): ?>
                            <a href="detail.php?id=<?= $book['id'] ?>&qty=<?= $_GET['qty'] - 1 ?>"
                            class="qty-btn">−</a>
                        <?php else: ?>
                            <span class="qty-btn disabled-btn">−</span>
                        <?php endif; ?>

                        <span class="qty-number">
                            <?= isset($_GET['qty']) ? (int)$_GET['qty'] : 1 ?>
                        </span>

                        <a href="detail.php?id=<?= $book['id'] ?>&qty=<?= isset($_GET['qty']) ? $_GET['qty'] + 1 : 2 ?>"
                        class="qty-btn">+</a>

                    </div>

                    <!-- BUTTONS -->
                    <div class="action-buttons">

                        <!-- Add to cart -->
                        <form action="add_to_cart.php" method="POST">

                            <input
                                type="hidden"
                                name="id"
                                value="<?= $book['id'] ?>"
                            >

                            <input
                                type="hidden"
                                name="quantity"
                                value="<?= isset($_GET['qty']) ? (int)$_GET['qty'] : 1 ?>"
                            >

                            <button class="btn add-cart-btn">
                                <i class="bi bi-cart3 me-2"></i>
                                Thêm vào giỏ
                            </button>

                        </form>

                        <!-- Wishlist -->
                        <button class="wishlist-btn">
                            <i class="bi bi-heart"></i>
                        </button>

                    </div>


                    <!-- SERVICE INFO -->
                    <div class="service-info">

                        <div class="service-item">
                            <i class="bi bi-truck"></i>
                            <span>Giao hàng miễn phí cho đơn từ 200.000đ</span>
                        </div>

                        <div class="service-item">
                            <i class="bi bi-shield-check"></i>
                            <span>Bảo hành chất lượng sách</span>
                        </div>

                        <div class="service-item">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            <span>Đổi trả trong 7 ngày</span>
                        </div>

                    </div>


                </div>
            </div>

        </div>

    </div>

    <!-- BOX DƯỚI -->
    <div class="detail-bottom-box mt-4">
        <div class="row text-center info-tabs">
            <div class="col-md-4">Mô tả sản phẩm</div>
            <div class="col-md-4">Thông tin chi tiết</div>
            <div class="col-md-4">Đánh giá</div>
        </div>

        <div class="content-box mt-4">
            <p>
                <?= $book['description'] ?? 'Nội dung sách đang được cập nhật. Đây là nơi hiển thị mô tả chi tiết về nội dung sách, giá trị mang lại và lý do nên sở hữu cuốn sách này.' ?>
            </p>
        </div>
    </div>

</div>

</body>
</html>
