<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_FILES['avatar'])){

    $file = $_FILES['avatar'];

    $fileName = time() . '_' . basename($file['name']);

    $target = "uploads/avatars/" . $fileName;

    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    /* CHECK EXTENSION */

    if(!in_array($ext, $allowed)){

        echo "
        <script>
            alert('Chỉ hỗ trợ JPG, PNG, WEBP');
            window.location.href='user.php';
        </script>
        ";

        exit();
    }

    /* UPLOAD */

    if(move_uploaded_file($file['tmp_name'], $target)){

        mysqli_query($conn, "
            UPDATE users
            SET avatar = '$fileName'
            WHERE id = $user_id
        ");

        header("Location: user.php");
        exit();

    }else{

        echo "Upload thất bại!";
    }
}
?>