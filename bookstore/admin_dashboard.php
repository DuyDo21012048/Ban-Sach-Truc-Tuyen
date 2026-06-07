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
        CASE
            WHEN status IN ('waiting_confirm','pending')
                THEN 'processing'
            ELSE status
        END AS status_group,
        COUNT(*) total
    FROM orders
    GROUP BY status_group
");

while($row=mysqli_fetch_assoc($statusQuery)){
    $statusData[$row['status_group']] = $row['total'];
}

$statusLabels = [
    'processing' => 'Đang xử lý',
    'shipping'   => 'Đang giao',
    'delivered'  => 'Đã giao',
    'cancelled'  => 'Đã hủy'
];

$chartLabels = [];

foreach($statusData as $key=>$value){

    $chartLabels[] =
        $statusLabels[$key];

}

$categoryQuery = mysqli_query($conn,"
    SELECT
        categories.name,
        COUNT(book_categories.book_id) total
    FROM categories
    LEFT JOIN book_categories
        ON categories.id = book_categories.category_id
    GROUP BY categories.id
    ORDER BY total DESC
    LIMIT 3
");

$categoryLabels = [];
$categoryData = [];

while($row = mysqli_fetch_assoc($categoryQuery)){
    $categoryLabels[] = $row['name'];
    $categoryData[] = $row['total'];
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>


<link rel="stylesheet" href="css/admin_dashboard.css">
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

    <!-- THỐNG KÊ -->
    <h1 class="page-title">
        Dashboard
    </h1>

    <p class="page-subtitle">
        Tổng quan về hoạt động kinh doanh
    </p>
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

                <div class="stat-icon blue">
                    <i class="bi bi-bag"></i>
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

                <div class="stat-icon purple">
                    <i class="bi bi-box-seam"></i>
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

                <div class="stat-icon orange">
                    <i class="bi bi-people"></i>
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

                <div class="chart-wrapper">
                    <canvas id="revenueChart"></canvas>
                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="chart-card">

                <h4>Trạng thái đơn hàng</h4>

                <div class="pie-wrapper">
                    <canvas id="statusChart"></canvas>
                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="chart-card">

                <h4>
                    Top sách bán chạy
                </h4>

                <div class="chart-wrapper">
                    <canvas id="bookChart"></canvas>
                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="chart-card">

                <h4>Phân bố danh mục</h4>

                <div class="pie-wrapper">
                    <canvas id="pieChart"></canvas>
                </div>

            </div>

        </div>

    </div>

    <!-- TOP DOANH THU -->
    <div class="dashboard-card full-width">
        <h3>Top sách theo doanh thu</h3>

        <table class="revenue-table">
            <thead>
                <tr>
                    <th>THỨ HẠNG</th>
                    <th>TÊN SÁCH</th>
                    <th>SỐ LƯỢNG BÁN</th>
                    <th>DOANH THU</th>
                </tr>
            </thead>

            <tbody>

            <?php
            $rank = 1;

            while($book = mysqli_fetch_assoc($topRevenue)):
            ?>

                <tr>

                    <td>
                        <?php if($rank == 1): ?>
                            <span class="rank-badge gold">1</span>

                        <?php elseif($rank == 2): ?>
                            <span class="rank-badge silver">2</span>

                        <?php elseif($rank == 3): ?>
                            <span class="rank-badge bronze">3</span>

                        <?php else: ?>
                            <span class="rank-badge normal">
                                <?= $rank ?>
                            </span>
                        <?php endif; ?>
                    </td>

                    <td class="book-title-cell">
                        <?= htmlspecialchars($book['title']) ?>
                    </td>

                    <td>
                        <?= number_format($book['sold']) ?> cuốn
                    </td>

                    <td class="revenue-money">
                        <?= number_format($book['revenue']) ?>đ
                    </td>

                </tr>

            <?php
            $rank++;
            endwhile;
            ?>

            </tbody>
        </table>
    </div>

</div>
</div>
<script>
Chart.register(ChartDataLabels);
new Chart(
document.getElementById('revenueChart'),
{
    type:'line',

    data:{
        labels: <?= json_encode($labels) ?>,

        datasets:[{
            label:'Doanh thu',
            data: <?= json_encode($revenues) ?>,

            borderColor:'#3b82f6',
            backgroundColor:'#3b82f6',

            tension:0.4,

            fill:false,

            pointRadius:5
        }]
    },

    options:{
        responsive:true,
        maintainAspectRatio:false,

        plugins:{
            legend:{
                position:'bottom'
            }
        },

        scales:{
            y:{
                beginAtZero:true
            }
        }
    }
});

Chart.register(ChartDataLabels);

new Chart(
document.getElementById('statusChart'),
{
    type:'pie',

    data:{
        labels: <?= json_encode($chartLabels) ?>,

        datasets:[{
            data: <?= json_encode(array_values($statusData)) ?>,

            backgroundColor:[
                '#10b981',
                '#3b82f6',
                '#f59e0b',
                '#ef4444'
            ],

            borderColor:'#fff',
            borderWidth:2
        }]
    },

    options:{
        responsive:true,
        maintainAspectRatio:false,

        plugins:{
            legend:{
                position:'bottom',
                align:'start',
                labels:{
                    usePointStyle:true,
                    pointStyle:'circle',
                    padding:15
                }
            },

            datalabels:{
                color:'#111',
                anchor:'end',
                align:'end',

                formatter:(value,ctx)=>{

                    const data =
                    ctx.chart.data.datasets[0].data;

                    const total =
                    data.reduce((a,b)=>a+b,0);

                    const percent =
                    Math.round(value*100/total);

                    return percent + '%';
                },

                font:{
                    weight:'bold',
                    size:14
                }
            }
        }
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
    },
    
    options:{
        responsive:true,
        maintainAspectRatio:false,
        plugins:{
            legend:{
                display:false
            }
        },
        scales:{
            x:{
                ticks:{
                    maxRotation:45,
                    minRotation:45
                }
            }
        }
    }
});

new Chart(
document.getElementById('pieChart'),
{
    type:'pie',

    data:{
        labels: <?= json_encode($categoryLabels) ?>,

        datasets:[{
            data: <?= json_encode($categoryData) ?>,

            backgroundColor:[
                '#ec4899',
                '#3b82f6',
                '#8b5cf6'
            ],

            borderColor:'#fff',
            borderWidth:2
        }]
    },

    options:{
        responsive:true,
        maintainAspectRatio:false,

        plugins:{
            legend:{
                position:'bottom',
                align:'start',
                labels:{
                    usePointStyle:true,
                    pointStyle:'circle',
                    padding:15
                }
            },
            datalabels:{
                anchor:'end',
                align:'end',
                offset:10,
                color:'#111',
                font:{
                    weight:'bold',
                    size:14
                }
            }
        }
    }
});

</script>

</body>
</html>