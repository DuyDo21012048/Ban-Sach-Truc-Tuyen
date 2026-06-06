<?php
session_start();
include 'db.php';
include 'admin_auth.php';

$categories = mysqli_query($conn,"
    SELECT *
    FROM categories
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Quản lý danh mục</title>

<link rel="stylesheet" href="css/admin.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container my-4">

<h1 class="admin-title">
    Quản lý danh mục
</h1>

<?php include 'admin_menu.php'; ?>

<table class="table table-hover">

<thead>

<tr>
<th>ID</th>
<th>Tên danh mục</th>
</tr>

</thead>

<tbody>

<?php while($cat=mysqli_fetch_assoc($categories)): ?>

<tr>

<td><?= $cat['id'] ?></td>

<td><?= $cat['name'] ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</body>
</html>