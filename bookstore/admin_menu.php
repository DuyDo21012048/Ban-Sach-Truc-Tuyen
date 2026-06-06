<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<div class="admin-tabs">

    <a href="admin.php"
       class="<?= $current=='admin.php' ? 'active' : '' ?>">
        <i class="bi bi-grid"></i>
        Dashboard
    </a>

    <a href="admin_books.php"
       class="<?= $current=='admin_books.php' ? 'active' : '' ?>">
        <i class="bi bi-book"></i>
        Quản lý sách
    </a>

    <a href="admin_orders.php"
       class="<?= $current=='admin_orders.php' ? 'active' : '' ?>">
        <i class="bi bi-bag"></i>
        Quản lý đơn hàng
    </a>

    <a href="admin_users.php"
       class="<?= $current=='admin_users.php' ? 'active' : '' ?>">
        <i class="bi bi-people"></i>
        Quản lý người dùng
    </a>

    <a href="admin_categories.php"
       class="<?= $current=='admin_categories.php' ? 'active' : '' ?>">
        <i class="bi bi-folder"></i>
        Quản lý danh mục
    </a>

</div>