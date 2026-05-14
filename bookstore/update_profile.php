<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);

// UPDATE
$sql = "UPDATE users
        SET
            name = '$name',
            email = '$email',
            phone = '$phone'
        WHERE id = $user_id";

if (mysqli_query($conn, $sql)) {

    $_SESSION['user_name'] = $name;

    header("Location: user.php");
    exit();

} else {

    echo "Lỗi: " . mysqli_error($conn);

}
?>