<?php
session_start();
include 'db.php';
include 'admin_auth.php';

$parentCategories = mysqli_query($conn,"
    SELECT *
    FROM categories
    WHERE id IN (1,2,3)
    ORDER BY id
");
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Quản lý danh mục</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<link rel="stylesheet" href="css/admin_categories.css">

</head>
<body>
<div class="admin-layout">
    <div class="container my-4">

        <a href="home.php" class="back-link">
            <i class="bi bi-arrow-left"></i>
            Quay lại
        </a>

        <h1 class="admin-heading">
            Quản trị
        </h1>

        <p class="admin-subtitle">
            Quản lý hệ thống cửa hàng
        </p>

        <!-- MENU -->

        <?php include 'admin_menu.php'; ?>

        <h1 class="page-title">
            Quản lý danh mục
        </h1>

        <p class="page-subtitle">
            Thêm, sửa, xóa các thể loại sách
        </p>

        <?php

        $totalParent = mysqli_num_rows(mysqli_query($conn,"
            SELECT id
            FROM categories
            WHERE id IN (1,2,3)
        "));

        $totalChild = mysqli_fetch_assoc(mysqli_query($conn,"
            SELECT COUNT(*) total
            FROM categories
            WHERE parent_id IS NOT NULL
        "))['total'];

        $totalBooks = mysqli_fetch_assoc(mysqli_query($conn,"
            SELECT COUNT(*) total
            FROM books
        "))['total'];

        ?>

        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-folder2-open"></i>
                </div>

                <div>
                    <h3><?= $totalParent ?></h3>
                    <p>Danh mục cha</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="bi bi-diagram-3"></i>
                </div>

                <div>
                    <h3><?= $totalChild ?></h3>
                    <p>Danh mục con</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-book"></i>
                </div>

                <div>
                    <h3><?= $totalBooks ?></h3>
                    <p>Tổng sách</p>
                </div>
            </div>

        </div>

        <?php while($parent = mysqli_fetch_assoc($parentCategories)): ?>

        <?php

        $children = mysqli_query($conn,"
            SELECT *
            FROM categories
            WHERE parent_id=".$parent['id']."
        ");

        $countChildren = mysqli_num_rows($children);

        $bookCountQuery = mysqli_query($conn,"
            SELECT COUNT(book_categories.book_id) total
            FROM book_categories

            JOIN categories
                ON categories.id = book_categories.category_id

            WHERE categories.parent_id=".$parent['id']."
        ");

        $bookCount =
        mysqli_fetch_assoc($bookCountQuery)['total'];

        $collapseId = "cat".$parent['id'];

        ?>

        <div class="category-group">

            <div class="parent-card">

                <div class="parent-left">

                    <div class="parent-icon">
                        <i class="bi bi-folder2-open"></i>
                    </div>

                    <div>

                        <h3>
                            <?= htmlspecialchars($parent['name']) ?>
                        </h3>

                        <div class="parent-meta">

                            <span>
                                <?= $countChildren ?>
                                danh mục con
                            </span>

                            <span>
                                <?= $bookCount ?>
                                sách
                            </span>

                        </div>

                    </div>

                </div>

                <div class="parent-actions">

                    <button
                        type="button"
                        class="add-child-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#addCategoryModal"
                    >
                        <i class="bi bi-plus"></i>
                        Thêm danh mục con
                    </button>

                    <i
                        class="bi bi-chevron-down collapse-arrow"
                        data-bs-toggle="collapse"
                        data-bs-target="#<?= $collapseId ?>"
                    ></i>

                </div>

            </div>

            <div
                id="<?= $collapseId ?>"
                class="collapse show"
            >

                <div class="children-grid">

                <?php while($child = mysqli_fetch_assoc($children)): ?>

                    <?php

                    $childBooks = mysqli_query($conn,"
                        SELECT COUNT(*) total
                        FROM book_categories
                        WHERE category_id=".$child['id']
                    );

                    $bookTotal =
                    mysqli_fetch_assoc($childBooks)['total'];

                    ?>

                    <div class="child-card">

                        <div class="child-top">

                            <i class="bi bi-folder"></i>

                            <div class="child-actions">

                                <a
                                    href="edit_category.php?id=<?= $child['id'] ?>"
                                    class="edit-btn"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <a
                                    href="delete_category.php?id=<?= $child['id'] ?>"
                                    class="delete-btn"
                                    onclick="return confirm('Xóa danh mục này?')"
                                >
                                    <i class="bi bi-trash"></i>
                                </a>

                            </div>

                        </div>
                        <h5>
                            <?= htmlspecialchars($child['name']) ?>
                        </h5>

                        <p>
                            ID:
                            <?= $child['id'] ?>
                        </p>

                        <div class="child-footer">

                            <span>
                                <?= $bookTotal ?>
                                sách
                            </span>

                        </div>

                    </div>

                <?php endwhile; ?>

                </div>

            </div>

        </div>

        <?php endwhile; ?>


    </div>
</div>
<div
    class="modal fade"
    id="addCategoryModal"
    tabindex="-1"
>

    <div class="modal-dialog">

        <div class="modal-content category-modal">

        <form
            action="add_category.php"
            method="POST"
        >

            <div class="modal-header">

                <h4>Thêm danh mục mới</h4>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="mb-3">

                    <label class="form-label">
                        Danh mục cha
                    </label>

                    <select
                        name="parent_id"
                        class="form-select"
                        required
                    >
                        <option value="">
                            Chọn danh mục cha
                        </option>

                        <option value="1">
                            Hư cấu
                        </option>

                        <option value="2">
                            Phi hư cấu
                        </option>

                        <option value="3">
                            Khác
                        </option>

                    </select>

                </div>

                <div>

                    <label class="form-label">
                        Tên danh mục con
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        placeholder="Nhập tên danh mục"
                        required
                    >

                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Hủy
                </button>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Thêm danh mục
                </button>

            </div>

        </form>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelectorAll('.collapse-arrow')
.forEach(arrow=>{

    arrow.addEventListener('click',function(){

        this.classList.toggle('rotate');

    });

});
</script>
</body>
</html>