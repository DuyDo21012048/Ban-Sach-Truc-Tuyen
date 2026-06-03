<?php
include 'db.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    $user = mysqli_fetch_assoc($result);

    // CHECK PASSWORD
    if (password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        header("Location: home.php");
        exit();

    } else {

        $_SESSION['login_error'] = "Sai mật khẩu hoặc email";
        header("Location: login.php");
        exit();

    }

} else {

    $_SESSION['login_error'] = "Sai mật khẩu hoặc email";
    header("Location: login.php");
    exit();

}
?>