<?php
include 'db.php';
session_start();

$parentCategories = mysqli_query($conn, "
    SELECT * FROM categories
    WHERE parent_id IS NULL
");

$selectedCategories = isset($_GET['category'])
    ? $_GET['category']
    : [];

$conditions = [];

/* Từ khóa */
if (!empty($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
    $conditions[] = "
    (
        books.title LIKE '%$keyword%'
        OR books.author LIKE '%$keyword%'
        OR books.publisher LIKE '%$keyword%'
    )
    ";
}

if (!empty($_GET['price'])) {
    $priceConditions = [];

    foreach ($_GET['price'] as $p) {
        if ($p == 'low') {
            $priceConditions[] = "price < 200000";
        }
        if ($p == 'mid') {
            $priceConditions[] = "price BETWEEN 200000 AND 500000";
        }
        if ($p == 'high') {
            $priceConditions[] = "price > 500000";
        }
    }

    $conditions[] = "(" . implode(" OR ", $priceConditions) . ")";
}

/* CATEGORY */

if (!empty($_GET['category'])) {

    $categoryIds = array_map('intval', $_GET['category']);

    $ids = implode(',', $categoryIds);

    $conditions[] = "
        books.id IN (

            SELECT book_id
            FROM book_categories
            WHERE category_id IN ($ids)

        )
    ";
}

$limit = 21;

$page = isset($_GET['page'])
    ? max(1, (int)$_GET['page'])
    : 1;

$offset = ($page - 1) * $limit;

$sql = "
SELECT
    books.*,
    AVG(reviews.rating) AS avg_rating,
    COUNT(reviews.id) AS total_reviews

FROM books

LEFT JOIN reviews
    ON books.id = reviews.book_id
";

if(!empty($conditions)){
    $sql .= "
    WHERE " . implode(' AND ', $conditions);
}

$sql .= "
GROUP BY books.id

ORDER BY avg_rating DESC

LIMIT $limit OFFSET $offset
";

$result = mysqli_query($conn, $sql);

$totalResult = mysqli_num_rows($result);

$countSql = "
SELECT COUNT(DISTINCT books.id) AS total

FROM books

LEFT JOIN reviews
    ON books.id = reviews.book_id
";

if(!empty($conditions)){
    $countSql .= "
    WHERE " . implode(' AND ', $conditions);
}

$countResult = mysqli_query($conn,$countSql);

$totalBooks = mysqli_fetch_assoc($countResult)['total'];

$totalPages = ceil($totalBooks / $limit);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tìm kiếm sách</title>

    <link rel="stylesheet" href="css/search.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container search-page">

    <h4 class="mb-4">
        Tìm thấy <?= $totalBooks ?> kết quả
    </h4>

    <div class="row">
        
        <div class="col-md-3">
        <!-- FILTER -->
            <form method="GET" action="search.php">

                <input type="hidden" name="keyword"
                value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                
                <div class="filter-box">

                    <h5>Bộ lọc</h5>

                    <p><strong>Khoảng giá</strong></p>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="price[]" value="low"
                        <?= (isset($_GET['price']) && in_array('low', $_GET['price'])) ? 'checked' : '' ?>>
                        <label>Dưới 200.000đ</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="price[]" value="mid"
                        <?= (isset($_GET['price']) && in_array('mid', $_GET['price'])) ? 'checked' : '' ?>>
                        <label>200.000đ - 500.000đ</label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="price[]" value="high"
                        <?= (isset($_GET['price']) && in_array('high', $_GET['price'])) ? 'checked' : '' ?>>
                        <label>Trên 500.000đ</label>
                    </div>

                    <hr>

                    <p><strong>Thể loại</strong></p>

                    <?php while($parent = mysqli_fetch_assoc($parentCategories)) { ?>

                        <?php
                        $parentId = $parent['id'];

                        $children = mysqli_query($conn, "
                            SELECT * FROM categories
                            WHERE parent_id = $parentId
                        ");

                        $hasChecked = false;

                        foreach($selectedCategories as $selected){
                            $checkQuery = mysqli_query($conn, "
                                SELECT * FROM categories
                                WHERE id = $selected
                                AND parent_id = $parentId
                            ");

                            if(mysqli_num_rows($checkQuery) > 0){
                                $hasChecked = true;
                                break;
                            }
                        }
                        ?>

                        <div class="search-category-group">

                            <!-- HEADER -->
                            <div class="search-parent-header">

                                <div class="parent-left">

                                    <input
                                        type="checkbox"
                                        class="parent-checkbox"
                                        <?= $hasChecked ? 'checked' : '' ?>
                                    >

                                    <h6 class="search-parent">
                                        <?= $parent['name'] ?>
                                    </h6>

                                </div>

                                <button
                                    type="button"
                                    class="search-toggle-btn <?= $hasChecked ? 'active' : '' ?>"
                                    onclick="toggleCategory(<?= $parentId ?>, this)"
                                >
                                    <i class="bi bi-chevron-right"></i>
                                </button>

                            </div>

                            <!-- CHILDREN -->
                            <div
                                class="seacrh-children"
                                id="children-<?= $parentId ?>"
                                style="<?= $hasChecked ? 'display:block' : 'display:none' ?>"
                            >

                                <?php while($child = mysqli_fetch_assoc($children)) { ?>

                                    <div class="form-check mb-2">

                                        <input
                                            class="form-check-input child-checkbox"
                                            type="checkbox"
                                            name="category[]"
                                            value="<?= $child['id'] ?>"

                                            <?= in_array($child['id'], $selectedCategories)
                                                ? 'checked'
                                                : ''
                                            ?>
                                        >

                                        <label class="form-check-label">
                                            <?= $child['name'] ?>
                                        </label>

                                    </div>

                                <?php } ?>

                            </div>

                        </div>

                    <?php } ?>

                    <button class="btn btn-primary mt-3 w-100">Lọc</button>

                </div>
                
            </form>
            
        </div>
        <!-- RESULT -->
        <div class="col-md-9">
            <div class="row">

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                    <div class="col-md-4 mb-4">
                        <div class="card book-card">

                            <a href="detail.php?id=<?= $row['id'] ?>&source=search" class="text-decoration-none text-dark">
                                <img src="<?= $row['image'] ?>" class="book-image">

                                <div class="search-card-content">

                                    <!-- HÌNH THỨC -->
                                    <span class="search-book-type">
                                        <?= $row['cover_type'] ?>
                                    </span>

                                    <!-- TÊN -->
                                    <h5>
                                        <?= $row['title'] ?>
                                    </h5>

                                    <!-- TÁC GIẢ -->
                                    <p class="search-book-author">
                                        <?= $row['author'] ?>
                                    </p>

                                    <!-- RATING -->
                                    <div class="search-book-rating">

                                        <?php

                                        $avgRating = round($row['avg_rating']);

                                        for($i = 1; $i <= 5; $i++){

                                            if($i <= $avgRating){

                                                echo '<i class="bi bi-star-fill"></i>';

                                            }else{

                                                echo '<i class="bi bi-star"></i>';

                                            }

                                        }

                                        ?>

                                        <span>
                                            (<?= $row['total_reviews'] ?>)
                                        </span>

                                    </div>

                                    <!-- PRICE -->
                                    <p class="book-price">
                                        <?= number_format($row['price']) ?>đ
                                    </p>

                                    <div class="d-flex gap-2">

                                        <form action="add_to_cart.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <button class="btn btn-primary">
                                                Thêm vào giỏ
                                            </button>
                                        </form>

                                        <a href="detail.php?id=<?= $row['id'] ?>&source=search"
                                        class="btn btn-outline-primary">
                                            Chi tiết
                                        </a>

                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                <?php } ?>

            </div>
            <?php if($totalPages > 1): ?>

            <nav class="mt-4">

                <ul class="pagination justify-content-center">

                    <?php for($i = 1; $i <= $totalPages; $i++): ?>

                        <?php

                        $params = $_GET;
                        $params['page'] = $i;

                        ?>

                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">

                            <a
                                class="page-link"
                                href="?<?= http_build_query($params) ?>"
                            >
                                <?= $i ?>
                            </a>

                        </li>

                    <?php endfor; ?>

                </ul>

            </nav>

            <?php endif; ?>
        </div>

    </div>

</div>

</div>
<script>

function toggleCategory(id, btn){

    const children =
        document.getElementById(`children-${id}`);

    if(children.style.display === 'block'){

        children.style.display = 'none';

        btn.classList.remove('active');

    }else{

        children.style.display = 'block';

        btn.classList.add('active');
    }
}

/* CHECKBOX CHA */

document.querySelectorAll('.search-category-group').forEach(group => {

    const parentCheckbox =
        group.querySelector('.parent-checkbox');

    const childCheckboxes =
        group.querySelectorAll('.child-checkbox');

    /* parent -> children */

    parentCheckbox.addEventListener('change', () => {

        childCheckboxes.forEach(child => {

            child.checked = parentCheckbox.checked;

        });

    });

    /* children -> parent */

    childCheckboxes.forEach(child => {

        child.addEventListener('change', () => {

            const checked =
                group.querySelectorAll('.child-checkbox:checked').length;

            parentCheckbox.checked = checked > 0;

        });

    });

});

</script>
</body>
</html>