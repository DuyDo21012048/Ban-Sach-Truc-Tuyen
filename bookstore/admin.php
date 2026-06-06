<?php
session_start();
include 'db.php';
include 'admin_auth.php';

/*
|--------------------------------------------------------------------------
| Tổng doanh thu
|--------------------------------------------------------------------------
*/
$revenueResult = mysqli_query($conn,"
    SELECT SUM(total_price) AS revenue
    FROM orders
    WHERE status='delivered'
");

$revenue =
mysqli_fetch_assoc($revenueResult)['revenue'] ?? 0;

/*
|--------------------------------------------------------------------------
| Tổng đơn hàng
|--------------------------------------------------------------------------
*/
$orderResult = mysqli_query($conn,"
    SELECT COUNT(*) total
    FROM orders
");

$totalOrders =
mysqli_fetch_assoc($orderResult)['total'];

/*
|--------------------------------------------------------------------------
| Tổng khách hàng
|--------------------------------------------------------------------------
*/
$userResult = mysqli_query($conn,"
    SELECT COUNT(*) total
    FROM users
");

$totalUsers =
mysqli_fetch_assoc($userResult)['total'];

/*
|--------------------------------------------------------------------------
| Tổng tồn kho
|--------------------------------------------------------------------------
*/
$stockResult = mysqli_query($conn,"
    SELECT SUM(quantity) total
    FROM books
");

$totalStock =
mysqli_fetch_assoc($stockResult)['total'] ?? 0;

/*
|--------------------------------------------------------------------------
| Doanh thu 7 ngày
|--------------------------------------------------------------------------
*/
$labels = [];
$revenues = [];

for($i=6;$i>=0;$i--){

    $date = date(
        'Y-m-d',
        strtotime("-$i days")
    );

    $query = mysqli_query($conn,"
        SELECT SUM(total_price) total
        FROM orders
        WHERE DATE(created_at)='$date'
        AND status='delivered'
    ");

    $row = mysqli_fetch_assoc($query);

    $labels[] = date('d/m',strtotime($date));
    $revenues[] = $row['total'] ?? 0;
}

/*
|--------------------------------------------------------------------------
| Trạng thái đơn hàng
|--------------------------------------------------------------------------
*/
$statusData = [];

$statusQuery = mysqli_query($conn,"
    SELECT
        status,
        COUNT(*) total
    FROM orders
    GROUP BY status
");

while($row=mysqli_fetch_assoc($statusQuery)){
    $statusData[$row['status']] = $row['total'];
}

/*
|--------------------------------------------------------------------------
| Top sách bán chạy
|--------------------------------------------------------------------------
*/
$topBooks = mysqli_query($conn,"
    SELECT
        books.title,
        SUM(order_items.quantity) sold
    FROM order_items

    JOIN books
        ON books.id=order_items.book_id

    GROUP BY books.id

    ORDER BY sold DESC

    LIMIT 5
");

$bookNames = [];
$bookSold = [];

while($row=mysqli_fetch_assoc($topBooks)){

    $bookNames[] = $row['title'];
    $bookSold[] = $row['sold'];
}

/*
|--------------------------------------------------------------------------
| Top sách doanh thu
|--------------------------------------------------------------------------
*/
$topRevenue = mysqli_query($conn,"
    SELECT
        books.title,

        SUM(
            order_items.quantity *
            order_items.price
        ) revenue,

        SUM(order_items.quantity) sold

    FROM order_items

    JOIN books
        ON books.id=order_items.book_id

    GROUP BY books.id

    ORDER BY revenue DESC

    LIMIT 10
");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Dashboard</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link rel="stylesheet" href="css/admin.css">
</head>

<body>

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

    <div class="admin-tabs">

        <a href="admin.php" class="active">
            <i class="bi bi-grid"></i>
            Dashboard
        </a>

        <a href="admin_books.php">
            <i class="bi bi-book"></i>
            Quản lý sách
        </a>

        <a href="admin_orders.php">
            <i class="bi bi-bag"></i>
            Quản lý đơn hàng
        </a>

        <a href="admin_users.php">
            <i class="bi bi-people"></i>
            Quản lý người dùng
        </a>

        <a href="admin_categories.php">
            <i class="bi bi-folder"></i>
            Quản lý danh mục
        </a>

    </div>

    <!-- THỐNG KÊ -->

    <div class="stats-grid">

        <div class="stat-card">

            <div class="stat-header">

                <div class="stat-icon green">
                    <i class="bi bi-currency-dollar"></i>
                </div>

                <span class="stat-change positive">
                    ↑ 12.5%
                </span>

            </div>

            <div class="stat-label">
                Tổng doanh thu
            </div>

            <div class="stat-value">
                <?= number_format($revenue) ?>đ
            </div>

            <div class="stat-sub">
                30 ngày qua
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-header">

                <div class="stat-icon green">
                    <i class="bi bi-bag stat-icon blue"></i>
                </div>

                <span class="stat-change positive">
                    ↑ 8.3%
                </span>

            </div>

            <div class="stat-label">
                Tổng đơn hàng
            </div>

            <div class="stat-value">
                <?= $totalOrders ?>
            </div>

            <div class="stat-sub">
                30 ngày qua
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-header">

                <div class="stat-icon green">
                    <i class="bi bi-box-seam stat-icon purple"></i>
                </div>

                <span class="stat-change positive">
                    ↑ 11.2%
                </span>

            </div>

            <div class="stat-label">
                Sách tồn kho
            </div>

            <div class="stat-value">
                <?= $totalStock ?>
            </div>

            <div class="stat-sub">
                Tổng số đầu sách
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-header">

                <div class="stat-icon green">
                    <i class="bi bi-people stat-icon orange"></i>
                </div>

                <span class="stat-change positive">
                    ↑ 11.2%
                </span>

            </div>

            <div class="stat-label">
                Khách hàng
            </div>

            <div class="stat-value">
                <?= $totalUsers ?>
            </div>

            <div class="stat-sub">
                30 ngày qua
            </div>

        </div>

    </div>

    <!-- CHART -->

    <div class="row g-4">

        <div class="col-lg-6">

            <div class="chart-card">

                <h4>
                    Doanh thu 7 ngày qua
                </h4>

                <canvas id="revenueChart"></canvas>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="chart-card">

                <h4>
                    Trạng thái đơn hàng
                </h4>

                <canvas id="statusChart"></canvas>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="chart-card">

                <h4>
                    Top sách bán chạy
                </h4>

                <canvas id="bookChart"></canvas>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="chart-card">

                <h4>
                    Phân bố trạng thái đơn
                </h4>

                <canvas id="pieChart"></canvas>

            </div>

        </div>

    </div>

    <!-- TOP DOANH THU -->

    <div class="table-card mt-4">

        <h3>
            Top sách theo doanh thu
        </h3>

        <table class="table">

            <thead>

                <tr>
                    <th>#</th>
                    <th>Tên sách</th>
                    <th>Đã bán</th>
                    <th>Doanh thu</th>
                </tr>

            </thead>

            <tbody>

            <?php
            $rank=1;

            while($book=mysqli_fetch_assoc($topRevenue)):
            ?>

                <tr>

                    <td><?= $rank++ ?></td>

                    <td><?= $book['title'] ?></td>

                    <td><?= $book['sold'] ?></td>

                    <td>
                        <?= number_format($book['revenue']) ?>đ
                    </td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

<script>

new Chart(
document.getElementById('revenueChart'),
{
    type:'line',

    data:{
        labels:
        <?= json_encode($labels) ?>,

        datasets:[{
            label:'Doanh thu',

            data:
            <?= json_encode($revenues) ?>,

            borderWidth:3,

            tension:.4
        }]
    }
});

new Chart(
document.getElementById('statusChart'),
{
    type:'pie',

    data:{
        labels:
        <?= json_encode(array_keys($statusData)) ?>,

        datasets:[{
            data:
            <?= json_encode(array_values($statusData)) ?>
        }]
    }
});

new Chart(
document.getElementById('bookChart'),
{
    type:'bar',

    data:{
        labels:
        <?= json_encode($bookNames) ?>,

        datasets:[{
            label:'Đã bán',

            data:
            <?= json_encode($bookSold) ?>
        }]
    }
});

new Chart(
document.getElementById('pieChart'),
{
    type:'doughnut',

    data:{
        labels:
        <?= json_encode(array_keys($statusData)) ?>,

        datasets:[{
            data:
            <?= json_encode(array_values($statusData)) ?>
        }]
    }
});

</script>

</body>
</html>