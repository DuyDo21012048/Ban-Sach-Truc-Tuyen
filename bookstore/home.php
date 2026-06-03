<?php 
include 'db.php'; 
session_start();

// Đếm số lượng giỏ
$count = 0;
if (isset($_SESSION['cart'])) {
    $count = array_sum($_SESSION['cart']);
}

$parentCategories = mysqli_query($conn, "
    SELECT * FROM categories
    WHERE parent_id IS NULL
");

$selectedCategories = isset($_GET['category'])
    ? $_GET['category']
    : [];

$recentBooks = null;

if(!empty($_SESSION['recently_viewed'])){

    $ids = implode(',', $_SESSION['recently_viewed']);

    $recentBooks = mysqli_query($conn,"
        SELECT *
        FROM books
        WHERE id IN ($ids)
        ORDER BY FIELD(id,$ids)
    ");
}    

$viewedIds = '';

if(!empty($_SESSION['recently_viewed'])){
    $viewedIds = implode(',', $_SESSION['recently_viewed']);
}

$recommendedBooks = null;

if(!empty($_SESSION['recently_viewed'])){

    $viewedIds = implode(',', $_SESSION['recently_viewed']);

    $favoriteCategories = mysqli_query($conn,"
        SELECT DISTINCT category_id
        FROM book_categories
        WHERE book_id IN ($viewedIds)
    ");

    $categoryIds = [];

    while($row = mysqli_fetch_assoc($favoriteCategories)){
        $categoryIds[] = $row['category_id'];
    }

    if(!empty($categoryIds)){

        $ids = implode(',', $categoryIds);

        $recommendedBooks = mysqli_query($conn,"
            SELECT
                books.*,
                AVG(reviews.rating) AS avg_rating,
                COUNT(reviews.id) AS total_reviews
            FROM books

            JOIN book_categories
                ON books.id = book_categories.book_id

            LEFT JOIN reviews
                ON books.id = reviews.book_id

            WHERE book_categories.category_id IN ($ids)
            AND books.id NOT IN ($viewedIds)

            GROUP BY books.id

            ORDER BY avg_rating DESC

            LIMIT 10
        ");
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Bookstore</title>

  <link rel="stylesheet" href="css/home.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<!-- HEADER -->
<?php include 'header.php'; ?>
<?php
if($recentBooks && mysqli_num_rows($recentBooks) > 0){
?>
    
<section class="recently-viewed">

    <h2 class="recent-title">
        Đã xem gần đây
    </h2>

    <div class="recent-grid">

        <?php while($book = mysqli_fetch_assoc($recentBooks)){ ?>

            <div class="recent-card">

                <a href="detail.php?id=<?= $book['id'] ?>">

                    <img
                        src="<?= $book['image'] ?>"
                        alt="<?= $book['title'] ?>"
                    >

                    <h4>
                        <?= $book['title'] ?>
                    </h4>

                </a>

            </div>

        <?php } ?>

    </div>

</section>
<?php if($recommendedBooks && mysqli_num_rows($recommendedBooks) > 0){ ?>

<section class="recommended-section">

    <h2>Dành cho bạn</h2>

    <div class="row-books">

        <?php while($book = mysqli_fetch_assoc($recommendedBooks)){ ?>
        
        <div class="col-custom-5">

            <div class="card">

                <a href="detail.php?id=<?= $book['id'] ?>&source=home"
                class="text-decoration-none text-dark">

                    <img src="<?= $book['image'] ?>">

                    <div class="card-content">

                        <!-- HÌNH THỨC -->
                        <span class="book-type">
                            <?= $book['cover_type'] ?>
                        </span>

                        <!-- TÊN -->
                        <h5>
                            <?= $book['title'] ?>
                        </h5>

                        <!-- TÁC GIẢ -->
                        <p class="book-author">
                            <?= $book['author'] ?>
                        </p>

                        <!-- RATING -->
                        <div class="book-rating">

                            <?php

                            $rating = round($book['avg_rating']);

                            for($i = 1; $i <= 5; $i++){

                                if($i <= $rating){

                                    echo '<i class="bi bi-star-fill"></i>';

                                }else{

                                    echo '<i class="bi bi-star"></i>';

                                }

                            }

                            ?>

                            <span>
                                (<?= $book['total_reviews'] ?>)
                            </span>

                        </div>

                        <!-- PRICE -->
                        <p class="price">
                            <?= number_format($book['price']) ?>đ
                        </p>

                    </div>

                </a>

                <div class="px-3 pb-3">
                    <form action="add_to_cart.php" method="POST">

                        <input type="hidden" name="id" value="<?= $book['id'] ?>">

                            <button class="btn btn-primary">
                                Thêm vào giỏ
                            </button>

                    </form>
                </div>

            </div>

        </div>

        <?php } ?>   

    </div>

</section>

<?php } ?>

<?php } ?>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

      <!-- LIST BOOK -->
      <div class="container-fluid  mt-5">

          <div class="row">

              <!-- SIDEBAR -->
              <div class="col-md-2">

                  <form method="GET" action="home.php">

                      <div class="category-sidebar">

                          <h4 class="sidebar-title">
                              Thể loại
                          </h4>

                          <?php while($parent = mysqli_fetch_assoc($parentCategories)) { ?>

                              <?php
                              $parentId = $parent['id'];

                              $children = mysqli_query($conn, "
                                  SELECT * FROM categories
                                  WHERE parent_id = $parentId
                              ");
                              ?>

                              <div class="category-group">

                                  <!-- CATEGORY CHA -->
                                  <div class="parent-header">

                                      <div class="parent-left">

                                          <input
                                              type="checkbox"
                                              class="parent-checkbox"
                                          >

                                          <h5 class="parent-category">
                                              <?= $parent['name'] ?>
                                          </h5>

                                      </div>

                                      <button
                                          type="button"
                                          class="toggle-btn"
                                          onclick="toggleCategory(<?= $parentId ?>)"
                                      >
                                          +
                                      </button>

                                  </div>

                                  <!-- CATEGORY CON -->
                                  <div class="children" id="children-<?= $parentId ?>">

                                      <?php while($child = mysqli_fetch_assoc($children)) { ?>

                                          <label class="category-item">

                                              <input
                                                  type="checkbox"
                                                  class="child-checkbox"
                                                  name="category[]"
                                                  value="<?= $child['id'] ?>"

                                                  <?= in_array($child['id'], $selectedCategories)
                                                      ? 'checked'
                                                      : ''
                                                  ?>
                                              >

                                              <span>
                                                  <?= $child['name'] ?>
                                              </span>

                                          </label>

                                      <?php } ?>

                                  </div>

                              </div>

                          <?php } ?>

                          <button class="filter-btn">
                              Áp dụng
                          </button>

                      </div>

                  </form>

              </div>

              <!-- BOOK LIST -->
              <div class="col-md-10">

                  <div class="row-books">

                      <?php

                      $where = "";

                      if (!empty($_GET['category'])) {

                          $categoryIds = array_map('intval', $_GET['category']);

                          $ids = implode(',', $categoryIds);

                          $where = "
                              WHERE books.id IN (

                                  SELECT book_id
                                  FROM book_categories
                                  WHERE category_id IN ($ids)

                              )
                          ";
                      }

                        $sql = "
                            SELECT 
                                books.*,

                                AVG(reviews.rating) AS avg_rating,
                                COUNT(reviews.id) AS total_reviews

                            FROM books

                            LEFT JOIN reviews
                                ON books.id = reviews.book_id

                            $where

                            GROUP BY books.id
                        ";

                      $result = mysqli_query($conn, $sql);

                      while ($row = mysqli_fetch_assoc($result)) {

                      ?>
                      

                      <div class="col-custom-5">

                        <div class="card">

                            <a href="detail.php?id=<?= $row['id'] ?>&source=home"
                            class="text-decoration-none text-dark">

                                <img src="<?= $row['image'] ?>">

                                <div class="card-content">

                                    <!-- HÌNH THỨC -->
                                    <span class="book-type">
                                        <?= $row['cover_type'] ?>
                                    </span>

                                    <!-- TÊN -->
                                    <h5>
                                        <?= $row['title'] ?>
                                    </h5>

                                    <!-- TÁC GIẢ -->
                                    <p class="book-author">
                                        <?= $row['author'] ?>
                                    </p>

                                    <!-- RATING -->
                                    <div class="book-rating">

                                        <?php

                                        $rating = round($row['avg_rating']);

                                        for($i = 1; $i <= 5; $i++){

                                            if($i <= $rating){

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
                                    <p class="price">
                                        <?= number_format($row['price']) ?>đ
                                    </p>

                                </div>

                            </a>

                            <div class="px-3 pb-3">
                                <form action="add_to_cart.php" method="POST">

                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">

                                    <button class="btn btn-primary">
                                        Thêm vào giỏ
                                    </button>

                                </form>
                            </div>

                        </div>

                      </div>

                      <?php } ?>

                  </div>

              </div>

          </div>

      </div>
<script>

document.querySelectorAll('.category-group').forEach(group => {

    const parentCheckbox = group.querySelector('.parent-checkbox');

    const childCheckboxes = group.querySelectorAll('.child-checkbox');

    const toggleBtn = group.querySelector('.toggle-btn');

    const childList = group.querySelector('.children');

    /* TICK CATEGORY CHA */

    parentCheckbox.addEventListener('change', () => {

        childCheckboxes.forEach(child => {
            child.checked = parentCheckbox.checked;
        });

    });

    /* CATEGORY CON -> CATEGORY CHA */

    childCheckboxes.forEach(child => {

        child.addEventListener('change', () => {

            const checkedCount =
                group.querySelectorAll('.child-checkbox:checked').length;

            parentCheckbox.checked =
                checkedCount > 0;

        });

    });

    /* LOAD LẦN ĐẦU */

    const checkedCount =
        group.querySelectorAll('.child-checkbox:checked').length;

    parentCheckbox.checked =
        checkedCount > 0;

    /* THU GỌN */

    toggleBtn.addEventListener('click', () => {

        if(childList.style.display === 'block'){

            childList.style.display = 'none';
            toggleBtn.innerHTML = '+';

        }else{

            childList.style.display = 'block';
            toggleBtn.innerHTML = '-';

        }

    });

});

</script>
<?php include 'footer.php'; ?>
</body>
</html>