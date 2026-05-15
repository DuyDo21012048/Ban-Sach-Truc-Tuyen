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

$ratingQuery = mysqli_query($conn, "
    SELECT 
        AVG(rating) as avg_rating,
        COUNT(*) as total_reviews
    FROM reviews
    WHERE book_id = $id
");

$ratingData = mysqli_fetch_assoc($ratingQuery);

$avgRating = round($ratingData['avg_rating'], 1);
$totalReviews = $ratingData['total_reviews'];


$reviews = mysqli_query($conn, "
    SELECT reviews.*, users.name
    FROM reviews
    JOIN users ON reviews.user_id = users.id
    WHERE book_id = $id
    ORDER BY reviews.created_at DESC
");

$categorySql = "
    SELECT categories.name
    FROM categories
    JOIN book_categories
        ON categories.id = book_categories.category_id
    WHERE book_categories.book_id = $id
";

$categoryResult = mysqli_query($conn, $categorySql);

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
        ← Tiếp tục mua sắm
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
                        <span>
                            (<?= $avgRating ?> đánh giá)
                        </span>
                    </p>

                    <p class="book-author">
                        Tác giả:
                        <strong>
                            <?= $book['author'] ?? 'Đang cập nhật' ?>
                        </strong>
                    </p>

                    <p class="book-category">
                        Thể loại:

                        <?php
                        $categories = [];

                        while ($cat = mysqli_fetch_assoc($categoryResult)) {
                            $categories[] = $cat['name'];
                        }

                        echo implode(', ', $categories);
                        ?>
                    </p>

                    <!-- PRICE -->
                    <div class="price-box">
                        <span class="book-price">
                            <?= number_format($book['price']) ?>đ
                        </span>
                    </div>

                    <!-- LABEL -->
                    <p class="qty-label">Số lượng</p>

                    <!-- QTY -->
                    <div class="qty-wrapper">

                        <div class="qty-box">

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

                        <!-- STOCK -->
                        <span class="stock-text">
                            Còn <?= $book['quantity'] ?> sản phẩm
                        </span>

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

        <!-- TABS -->
        <div class="detail-tabs">

            <button class="tab-btn active" data-tab="description">
                Mô tả sản phẩm
            </button>

            <button class="tab-btn" data-tab="info">
                Thông tin chi tiết
            </button>

            <button class="tab-btn" data-tab="review">
                Đánh giá
            </button>

        </div>

        <!-- CONTENT -->
        <div class="tab-content-box">

            <!-- DESCRIPTION -->
            <div class="tab-content active" id="description">

                <p>
                    <?= $book['description'] ?? 'Nội dung đang cập nhật...' ?>
                </p>

            </div>

            <!-- INFO -->
            <div class="tab-content" id="info">

                <p><strong>Tác giả:</strong> <?= $book['author'] ?></p>

                <p><strong>Số lượng:</strong> <?= $book['quantity'] ?></p>

                <p><strong>Giá:</strong> <?= number_format($book['price']) ?>đ</p>

            </div>

            <!-- REVIEW -->
            <div class="tab-content" id="review">

                <?php
                $reviews = mysqli_query($conn, "
                    SELECT reviews.*, users.name
                    FROM reviews
                    JOIN users ON reviews.user_id = users.id
                    WHERE book_id = $id
                    ORDER BY reviews.created_at DESC
                ");
                ?>

                <?php if(mysqli_num_rows($reviews) > 0): ?>

                    <?php while($review = mysqli_fetch_assoc($reviews)) { ?>

                        <div class="review-item">

                            <h6><?= $review['name'] ?></h6>

                            <p class="review-stars">
                                <?= str_repeat('⭐', $review['rating']) ?>
                            </p>

                            <p class="review-comment">
                                <?= $review['comment'] ?>
                            </p>

                        </div>

                    <?php } ?>

                <?php else: ?>

                    <p>Chưa có đánh giá nào.</p>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>
<script>

const tabs = document.querySelectorAll('.tab-btn');
const contents = document.querySelectorAll('.tab-content');

tabs.forEach(tab => {

    tab.addEventListener('click', () => {

        tabs.forEach(btn => btn.classList.remove('active'));
        contents.forEach(content => content.classList.remove('active'));

        tab.classList.add('active');

        document
            .getElementById(tab.dataset.tab)
            .classList.add('active');

    });

});

</script>
</body>
</html>
