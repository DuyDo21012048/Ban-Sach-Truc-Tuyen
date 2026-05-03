<?php include 'db.php'; ?>

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