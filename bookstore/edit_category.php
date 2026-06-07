<?php
session_start();
include 'db.php';
include 'admin_auth.php';

$id = intval($_GET['id']);

$category = mysqli_fetch_assoc(
    mysqli_query($conn,"
        SELECT *
        FROM categories
        WHERE id=$id
    ")
);

if(!$category){
    die("Danh mục không tồn tại");
}

if(isset($_POST['update'])){

    $name = mysqli_real_escape_string(
        $conn,
        $_POST['name']
    );

    mysqli_query($conn,"
        UPDATE categories
        SET name='$name'
        WHERE id=$id
    ");

    header("Location: admin_categories.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sửa danh mục</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/edit_category.css">

</head>
<body>

<div class="form-card">

    <h2>Chỉnh sửa danh mục</h2>

    <form method="POST">

        <label>Tên danh mục</label>

        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($category['name']) ?>"
            required
        >

        <div class="form-actions">

            <a
                href="admin_categories.php"
                class="btn-cancel"
            >
                Hủy
            </a>

            <button
                type="submit"
                name="update"
                class="btn-save"
            >
                Cập nhật
            </button>

        </div>

    </form>

</div>

</body>
</html>