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
                                  <div class="children" id="children-<?= $parentId ?>" style="display:none;">

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
                          SELECT * FROM books
                          $where
                      ";

                      $result = mysqli_query($conn, $sql);

                      while ($row = mysqli_fetch_assoc($result)) {

                      ?>

                      <div class="col-custom-5">

                        <div class="card">

                            <a href="detail.php?id=<?= $row['id'] ?>" class="text-decoration-none text-dark">

                                <img src="<?= $row['image'] ?>">

                                <div class="card-content">

                                    <h5>
                                        <?= $row['title'] ?>
                                    </h5>

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

    const childList = group.querySelector('.child-list');

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

        childList.classList.toggle('hidden');

        if(childList.classList.contains('hidden')){

            childList.style.display = 'none';

            toggleBtn.innerHTML = '+';

        }else{

            childList.style.display = 'block';

            toggleBtn.innerHTML = '-';

        }

    });

});

</script>
</body>
</html>