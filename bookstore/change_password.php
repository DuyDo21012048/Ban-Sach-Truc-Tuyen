<?php

session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];

$current = $_POST['current_password'];
$new = $_POST['new_password'];
$confirm = $_POST['confirm_password'];

$userQuery = mysqli_query($conn,"
    SELECT password
    FROM users
    WHERE id = $user_id
");

$user = mysqli_fetch_assoc($userQuery);

if(!password_verify($current, $user['password'])){
    die("Mật khẩu hiện tại không đúng");
}

if($new != $confirm){
    die("Xác nhận mật khẩu không khớp");
}

$newPassword = password_hash($new, PASSWORD_DEFAULT);

mysqli_query($conn,"
    UPDATE users
    SET password = '$newPassword'
    WHERE id = $user_id
");

header("Location: user.php");
exit();
?>