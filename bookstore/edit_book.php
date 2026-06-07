<?php
session_start();
include 'db.php';
include 'admin_auth.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$result = mysqli_query($conn, "SELECT * FROM books WHERE id = $id");

$book = mysqli_fetch_assoc($result);

$bookCategories = [];

$catQuery = mysqli_query($conn,"
    SELECT category_id
    FROM book_categories
    WHERE book_id = $id
");

while($row = mysqli_fetch_assoc($catQuery)){
    $bookCategories[] = $row['category_id'];
}

$categories = mysqli_query($conn,"
    SELECT *
    FROM categories
    WHERE parent_id IS NOT NULL
    ORDER BY name
");

if (!$book) {
    die("Không tìm thấy sách.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sách</title>

    <link rel="stylesheet" href="css/edit_book.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="edit-wrapper">

    <!-- Header -->
    <div class="edit-header">
        <h2>Chỉnh sửa sách</h2>
        <a href="admin_books.php" class="close-btn">×</a>
    </div>

    <!-- Form -->
    <form action="update_book.php" method="POST">

        <input type="hidden" name="id" value="<?= $book['id'] ?>">

        <!-- Tên sách -->
        <div class="mb-4">
            <label class="form-label">Tên sách *</label>
            <input
                type="text"
                name="title"
                class="form-control"
                value="<?= $book['title'] ?>"
                required
            >
        </div>

        <!-- Giá -->
        <div class="mb-4">
            <label class="form-label">Giá *</label>
            <div class="price-input">
                <input
                    type="number"
                    name="price"
                    class="form-control"
                    value="<?= $book['price'] ?>"
                    required
                >
                <span>đ</span>
            </div>
            <small>Nhập số tiền không có dấu phân cách</small>
        </div>

        <!-- Tác giả -->
        <div class="mb-4">
            <label class="form-label">Tác giả *</label>
            <input
                type="text"
                name="author"
                class="form-control"
                value="<?= $book['author'] ?>"
                required
            >
        </div>

        <div class="mb-4">

            <label class="form-label">
                Thể loại
            </label>

            <select
                name="categories[]"
                class="form-select"
                multiple
                size="8"
            >

                <?php while($cat = mysqli_fetch_assoc($categories)) { ?>

                    <option
                        value="<?= $cat['id'] ?>"
                        <?= in_array($cat['id'],$bookCategories) ? 'selected' : '' ?>
                    >
                        <?= $cat['name'] ?>
                    </option>

                <?php } ?>

            </select>

            <small class="text-muted">
                Giữ Ctrl để chọn nhiều thể loại
            </small>

        </div>

        <!-- THÔNG TIN XUẤT BẢN -->

        <div class="row">

            <!-- Năm xuất bản -->
            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Năm xuất bản
                </label>

                <input
                    type="number"
                    name="published_year"
                    class="form-control"
                    value="<?= $book['published_year'] ?>"
                >

            </div>

            <!-- Ngôn ngữ -->
            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Ngôn ngữ
                </label>

                <input
                    type="text"
                    name="language"
                    class="form-control"
                    value="<?= $book['language'] ?>"
                >

            </div>

        </div>

        <div class="row">

            <!-- Số trang -->
            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Số trang
                </label>

                <input
                    type="number"
                    name="pages"
                    class="form-control"
                    value="<?= $book['pages'] ?>"
                >

            </div>

            <!-- Hình thức -->
            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Hình thức
                </label>

                <select
                    name="cover_type"
                    class="form-select"
                >

                    <option value="Bìa mềm"
                        <?= $book['cover_type'] == 'Bìa mềm' ? 'selected' : '' ?>>
                        Bìa mềm
                    </option>

                    <option value="Bìa cứng"
                        <?= $book['cover_type'] == 'Bìa cứng' ? 'selected' : '' ?>>
                        Bìa cứng
                    </option>

                </select>

            </div>

        </div>

        <!-- Nhà xuất bản -->

        <div class="mb-4">

            <label class="form-label">
                Nhà xuất bản
            </label>

            <input
                type="text"
                name="publisher"
                class="form-control"
                value="<?= $book['publisher'] ?>"
            >

        </div>

        <!-- ISBN -->

        <div class="mb-4">

            <label class="form-label">
                ISBN
            </label>

            <input
                type="text"
                name="isbn"
                class="form-control"
                value="<?= $book['isbn'] ?>"
            >

        </div>        

        <!-- Số lượng -->
        <div class="mb-4">
            <label class="form-label">Số lượng *</label>
            <input
                type="number"
                name="quantity"
                class="form-control"
                value="<?= $book['quantity'] ?>"
                required
            >
        </div>

        <!-- URL hình ảnh -->
        <div class="mb-4">
            <label class="form-label">URL hình ảnh *</label>
            <input
                type="text"
                name="image"
                class="form-control"
                value="<?= $book['image'] ?>"
                required
            >
        </div>

        <!-- Preview -->
        <div class="mb-4">
            <label class="form-label">Xem trước:</label>
            <div>
                <img
                    src="<?= $book['image'] ?>"
                    class="preview-image"
                >
            </div>
        </div>

        <!-- Mô tả -->
        <div class="mb-4">
            <label class="form-label">Mô tả sản phẩm *</label>
            <textarea
                name="description"
                class="form-control"
                rows="5"
                required
            ><?= $book['description'] ?></textarea>
        </div>

        <!-- Footer -->
        <div class="edit-footer">

            <a href="admin_books.php" class="cancel-btn">
                Hủy
            </a>

            <button type="submit" class="save-btn">
                Cập nhật
            </button>

        </div>

    </form>

</div>

</body>
</html>