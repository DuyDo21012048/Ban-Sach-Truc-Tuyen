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

  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<!-- HEADER -->
<div class="container-fluid p-3 shadow-sm bg-white">
  <div class="d-flex justify-content-between align-items-center">

    <h3 class="fw-bold text-primary">BOOKSTORE</h3>

    <input class="form-control w-50" placeholder="Tìm kiếm sách...">

    <div>
      <a href="login.php" class="me-3">Login</a>
      <a href="cart.php">Cart (<?= $count ?>)</a>
    </div>

  </div>
</div>

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