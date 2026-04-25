<?php 
include 'db.php'; 
session_start();

// Đếm số lượng giỏ
$count = 0;
if (isset($_SESSION['cart'])) {
    $count = array_sum($_SESSION['cart']);
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
<div class="container-fluid p-3 shadow-sm bg-white">
  <div class="d-flex justify-content-evenly align-items-center">

    <!-- Logo -->
    <h3 class="fw-bold text-primary">BOOKSTORE</h3>

    <!-- Search -->
    <input class="form-control w-50" placeholder="Tìm kiếm sách...">

    <!-- Login -->
    <div>
      <a href="login.php" class="text-decoration-none text-dark fw-semibold fs-6 me-3"> 
        <i class="bi bi-person-circle me-1"></i> Login 
      </a> 
    <!-- Cart --> 
      <a href="cart.php" class="text-decoration-none text-dark position-relative pe-4 fw-semibold fs-6"> 
        <i class="bi bi-cart3 me-1"></i> Cart 

        <?php if ($count > 0): ?> 
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"> 
            <?= $count ?> 
          </span> 
        <?php endif; ?> 
      </a>
    </div>

  </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">


<!-- LIST BOOK -->
<div class="container mt-5">
  <div class="row">

    <?php
    $result = mysqli_query($conn, "SELECT * FROM books");

    while ($row = mysqli_fetch_assoc($result)) {
    ?>

    <div class="col-md-4">
      <div class="card p-2 shadow-sm">

        <img src="<?= $row['image'] ?>" class="img-fluid rounded">

        <h5 class="mt-2"><?= $row['title'] ?></h5>

        <p class="price"><?= number_format($row['price']) ?>đ</p>

        <!-- FORM ADD TO CART -->
        <form action="add_to_cart.php" method="POST">
          <input type="hidden" name="id" value="<?= $row['id'] ?>">
          <button class="btn btn-primary w-100">Thêm vào giỏ</button>
        </form>

      </div>
    </div>

    <?php } ?>

  </div>
</div>

</body>
</html>