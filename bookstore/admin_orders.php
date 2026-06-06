<?php
session_start();
include 'db.php';
include 'admin_auth.php';

$orders = mysqli_query($conn,"
    SELECT
        orders.*,
        users.name
    FROM orders

    LEFT JOIN users
        ON users.id = orders.user_id

    ORDER BY orders.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Quản lý đơn hàng</title>

<link rel="stylesheet" href="css/admin.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>
<body>

<div class="container my-4">

<h1 class="admin-title">
    Quản lý đơn hàng
</h1>

<?php include 'admin_menu.php'; ?>

<div class="table-box">

<table class="table table-hover">

<thead>

<tr>
<th>Mã đơn</th>
<th>Khách hàng</th>
<th>Tổng tiền</th>
<th>Thanh toán</th>
<th>Trạng thái</th>
<th>Ngày tạo</th>
</tr>

</thead>

<tbody>

<?php while($order=mysqli_fetch_assoc($orders)): ?>

<tr>

<td><?= $order['order_code'] ?></td>

<td><?= $order['name'] ?></td>

<td><?= number_format($order['total_price']) ?>đ</td>

<td><?= strtoupper($order['payment_method']) ?></td>

<td><?= $order['status'] ?></td>

<td><?= $order['created_at'] ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</body>
</html>