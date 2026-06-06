<?php
session_start();
include 'db.php';
include 'admin_auth.php';

$users = mysqli_query($conn,"
    SELECT *
    FROM users
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Quản lý người dùng</title>

<link rel="stylesheet" href="css/admin.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container my-4">

<h1 class="admin-title">
    Quản lý người dùng
</h1>

<?php include 'admin_menu.php'; ?>

<table class="table table-hover">

<thead>

<tr>
<th>ID</th>
<th>Tên</th>
<th>Email</th>
<th>Vai trò</th>
</tr>

</thead>

<tbody>

<?php while($user=mysqli_fetch_assoc($users)): ?>

<tr>

<td><?= $user['id'] ?></td>

<td><?= $user['name'] ?></td>

<td><?= $user['email'] ?></td>

<td><?= $user['role'] ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</body>
</html>