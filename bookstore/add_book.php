<?php 
include 'db.php'; 
session_start();

include 'admin_auth.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sách</title>

    <link rel="stylesheet" href="css/edit_book.css"> <!-- dùng lại CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="edit-wrapper">

    <!-- Header -->
    <div class="edit-header">
        <h2>Thêm sách mới</h2>
        <a href="admin.php" class="close-btn">×</a>
    </div>

    <!-- FORM -->
    <form action="insert_book.php" method="POST">

        <!-- Tên sách -->
        <div class="mb-4">
            <label class="form-label">Tên sách *</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <!-- Giá -->
        <div class="mb-4">
            <label class="form-label">Giá *</label>
            <div class="price-input">
                <input type="number" name="price" class="form-control" required>
                <span>đ</span>
            </div>
        </div>

        <!-- Tác giả -->
        <div class="mb-4">
            <label class="form-label">Tác giả *</label>
            <input type="text" name="author" class="form-control" required>
        </div>

        <?php
        $categories = mysqli_query($conn,"
            SELECT *
            FROM categories
            WHERE parent_id IS NOT NULL
            ORDER BY name
        ");
        ?>

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

                    <option value="<?= $cat['id'] ?>">
                        <?= $cat['name'] ?>
                    </option>

                <?php } ?>

            </select>

            <small class="text-muted">
                Giữ Ctrl để chọn nhiều thể loại
            </small>
        </div>

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
                    placeholder="VD: 2025"
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
                    placeholder="VD: Tiếng Việt"
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
                    placeholder="VD: 320"
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

                    <option value="">
                        -- Chọn hình thức --
                    </option>

                    <option value="Bìa mềm">
                        Bìa mềm
                    </option>

                    <option value="Bìa cứng">
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
                placeholder="VD: NXB Văn Học"
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
                placeholder="VD: 978-604-2-12345-6"
            >

        </div>

        <!-- Số lượng -->
        <div class="mb-4">
            <label class="form-label">Số lượng *</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>

        <!-- URL ảnh -->
        <div class="mb-4">
            <label class="form-label">URL hình ảnh *</label>
            <input type="text" name="image" class="form-control" required>
        </div>

        <!-- Preview -->
        <div class="mb-4">
            <label class="form-label">Xem trước:</label>
            <div>
                <img src="" class="preview-image" style="display:none;">
            </div>
        </div>

        <!-- Mô tả -->
        <div class="mb-4">
            <label class="form-label">Mô tả sản phẩm *</label>
            <textarea name="description" class="form-control" rows="5" required></textarea>
        </div>

        <!-- Footer -->
        <div class="edit-footer">

            <a href="admin.php" class="cancel-btn">
                Hủy
            </a>

            <button type="submit" class="save-btn">
                Thêm sách
            </button>

        </div>

    </form>

</div>

<!-- Preview ảnh realtime -->
<script>
const input = document.querySelector('input[name="image"]');
const preview = document.querySelector('.preview-image');

input.addEventListener('input', () => {
    if (input.value.trim() !== "") {
        preview.style.display = "block";
        preview.src = input.value;
    } else {
        preview.style.display = "none";
    }
});
</script>

</body>
</html>