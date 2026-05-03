<?php
include 'db.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($result);

if ($user && $user['password'] == $password) {
    $_SESSION['user'] = $user;
    header("Location: home.php");
} else {
    echo "Sai email hoặc mật khẩu";
}
?>