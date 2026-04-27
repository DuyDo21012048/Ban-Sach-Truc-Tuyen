<?php
include 'db.php';
session_start();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    die("Không tìm thấy sản phẩm.");
}
$result = mysqli_query($conn, "SELECT * FROM books WHERE id = $id");
$book = mysqli_fetch_assoc($result);

$count = 0;
if (isset($_SESSION['cart'])) {
    $count = array_sum($_SESSION['cart']);
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
        <div class="row align-items-start">

            <!-- ẢNH SÁCH -->
            <div class="col-md-4 text-center">
                <img src="<?= $book['image'] ?>" class="detail-image" alt="<?= $book['title'] ?>">
            </div>

            <!-- THÔNG TIN -->
            <div class="col-md-6">
                <h2 class="book-title"><?= $book['title'] ?></h2>

                <p class="book-rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <span>(4.5 đánh giá)</span>
                </p>

                <p class="book-author">
                    Tác giả: <strong><?= $book['author'] ?? 'Đang cập nhật' ?></strong>
                </p>

                <p class="book-price">
                    <?= number_format($book['price']) ?>đ
                </p>

                <!-- SỐ LƯỢNG -->
                <div class="qty-box mb-4">
                    <a href="#" class="qty-btn">−</a>
                    <span class="qty-number">1</span>
                    <a href="#" class="qty-btn">+</a>
                </div>

                <!-- BUTTON -->
                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="id" value="<?= $book['id'] ?>">
                    <button class="btn add-cart-btn">
                        Thêm vào giỏ
                    </button>
                </form>
            </div>

            <!-- NÚT THÍCH -->
            <div class="col-md-2 text-end">
                <button class="wishlist-btn">
                    <i class="bi bi-heart"></i>
                </button>
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
