<?php
include 'db.php';
session_start();

$keyword = isset($_GET['keyword'])
    ? mysqli_real_escape_string($conn, $_GET['keyword'])
    : '';

$sql = "SELECT * FROM books";

if (!empty($keyword)) {
    $sql .= " WHERE title LIKE '%$keyword%'
              OR author LIKE '%$keyword%'";
}

$result = mysqli_query($conn, $sql);
$totalResult = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tìm kiếm sách</title>

    <link rel="stylesheet" href="css/search.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">

    <h4 class="mb-4">
        Tìm thấy <?= $totalResult ?> kết quả
    </h4>

    <div class="row">

        <!-- FILTER -->
        <div class="col-md-3">
            <div class="filter-box">

                <h5>Bộ lọc</h5>

                <p><strong>Khoảng giá</strong></p>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox">
                    <label>Dưới 200.000đ</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox">
                    <label>200.000đ - 500.000đ</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox">
                    <label>Trên 500.000đ</label>
                </div>

            </div>
        </div>

        <!-- RESULT -->
        <div class="col-md-9">
            <div class="row">

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                    <div class="col-md-4 mb-4">
                        <div class="card book-card">

                            <img src="<?= $row['image'] ?>" class="book-image">

                            <div class="p-3">
                                <h5><?= $row['title'] ?></h5>

                                <p class="book-price">
                                    <?= number_format($row['price']) ?>đ
                                </p>

                                <div class="d-flex gap-2">

                                    <form action="add_to_cart.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button class="btn btn-primary">
                                            Thêm vào giỏ
                                        </button>
                                    </form>

                                    <a href="detail.php?id=<?= $row['id'] ?>"
                                       class="btn btn-outline-primary">
                                        Chi tiết
                                    </a>

                                </div>
                            </div>

                        </div>
                    </div>

                <?php } ?>

            </div>
        </div>

    </div>

</div>

</body>
</html>