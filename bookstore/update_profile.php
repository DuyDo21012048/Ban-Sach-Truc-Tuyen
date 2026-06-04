<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];

/* Kiểm tra submit */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: user.php");
    exit();
}

/* Lấy dữ liệu */
$name  = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

/* Validate */
if (empty($name) || empty($email)) {

    echo "
    <script>
        alert('Tên và Email không được để trống');
        window.location.href='user.php';
    </script>
    ";

    exit();
}

/* Escape dữ liệu */
$name  = mysqli_real_escape_string($conn, $name);
$email = mysqli_real_escape_string($conn, $email);
$phone = mysqli_real_escape_string($conn, $phone);

/* Kiểm tra email đã tồn tại chưa */
$checkEmail = mysqli_query($conn, "
    SELECT id
    FROM users
    WHERE email = '$email'
    AND id != $user_id
");

if (mysqli_num_rows($checkEmail) > 0) {

    echo "
    <script>
        alert('Email đã được sử dụng');
        window.location.href='user.php';
    </script>
    ";

    exit();
}

/* Update */
$sql = "
    UPDATE users
    SET
        name = '$name',
        email = '$email',
        phone = '$phone'
    WHERE id = $user_id
";

if (mysqli_query($conn, $sql)) {

    $_SESSION['user_name'] = $name;

    echo "
    <script>
        alert('Cập nhật thông tin thành công');
        window.location.href='user.php';
    </script>
    ";

} else {

    echo "Lỗi: " . mysqli_error($conn);

}
?>