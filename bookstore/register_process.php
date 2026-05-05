<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// 1. CHECK EMAIL TỒN TẠI
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<script>
        alert('Email đã tồn tại!');
        window.location.href='register.php';
    </script>";
    exit();
}

// 2. HASH PASSWORD
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// 3. INSERT USER
$sql = "INSERT INTO users (name, email, password)
        VALUES ('$name', '$email', '$hashedPassword')";

if (mysqli_query($conn, $sql)) {
    echo "<script>
        alert('Đăng ký thành công!');
        window.location.href='login.php';
    </script>";
} else {
    echo "Lỗi: " . mysqli_error($conn);
}
?>