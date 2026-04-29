<?php
include 'db.php';
session_start();

$result = mysqli_query($conn, "SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Quản lý sách</title>

    <link rel="stylesheet" href="css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

<div class="container my-5">

    <!-- Back -->
    <a href="home.php" class="back-link">
        <i class="bi bi-arrow-left"></i> Quay lại
    </a>

    <!-- Header -->
    <div class="admin-header">

        <div>
            <h1 class="admin-title">Quản lý sách</h1>
            <p class="admin-subtitle">
                Thêm, sửa, xóa sách trong hệ thống
            </p>
        </div>

        <a href="add_book.php" class="add-book-btn">
            <i class="bi bi-plus-lg"></i>
            Thêm sách mới
        </a>

    </div>

    <!-- Search -->
    <div class="search-wrapper">
        <input
            type="text"
            class="form-control admin-search"
            placeholder="Tìm kiếm sách theo tên..."
        >
    </div>

    <!-- Table -->
    <div class="table-box">

        <table class="table align-middle">

            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sách</th>
                    <th>Tác giả</th>
                    <th>Giá</th>
                    <th>Mô tả</th>
                    <th>Số lượng</th>
                    <th>Mã ID</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>

                <?php while ($book = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td>
                        <img
                            src="<?= $book['image'] ?>"
                            class="admin-book-image"
                        >
                    </td>

                    <td class="book-name">
                        <?= $book['title'] ?>
                    </td>

                    <td>
                        <?= $book['author'] ?>
                    </td>

                    <td class="book-price">
                        <?= number_format($book['price']) ?>đ
                    </td>

                    <td class="book-description">
                        <?= substr($book['description'], 0, 80) ?>...
                    </td>

                    <td>
                        <?= $book['quantity'] ?>
                    </td>

                    <td>
                        #<?= $book['id'] ?>
                    </td>

                    <td>
                        <div class="action-buttons">

                            <a href="edit_book.php?id=<?= $book['id'] ?>"
                            class="edit-btn">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <a href="delete_book.php?id=<?= $book['id'] ?>"
                            class="delete-btn"
                            onclick="return confirm('Bạn có chắc muốn xóa?')">
                                <i class="bi bi-trash"></i>
                            </a>

                        </div>
                    </td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>