<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Tạo thư mục nếu chưa tồn tại */
$uploadDir = "uploads/avatars/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

/* Kiểm tra có file upload không */
if (
    isset($_FILES['avatar']) &&
    $_FILES['avatar']['error'] == 0
) {

    $file = $_FILES['avatar'];

    /* Danh sách định dạng cho phép */
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    $ext = strtolower(
        pathinfo($file['name'], PATHINFO_EXTENSION)
    );

    /* Kiểm tra đuôi file */
    if (!in_array($ext, $allowed)) {

        echo "
        <script>
            alert('Chỉ hỗ trợ JPG, JPEG, PNG, WEBP');
            window.location.href='user.php';
        </script>
        ";

        exit();
    }

    /* Kiểm tra file có phải ảnh thật không */
    $imageInfo = getimagesize($file['tmp_name']);

    if ($imageInfo === false) {

        echo "
        <script>
            alert('File tải lên không phải ảnh hợp lệ');
            window.location.href='user.php';
        </script>
        ";

        exit();
    }

    /* Giới hạn dung lượng 2MB */
    if ($file['size'] > 2 * 1024 * 1024) {

        echo "
        <script>
            alert('Ảnh không được vượt quá 2MB');
            window.location.href='user.php';
        </script>
        ";

        exit();
    }

    /* Tạo tên file ngẫu nhiên */
    $fileName = uniqid('avatar_') . '.' . $ext;

    $target = $uploadDir . $fileName;

    /* Upload ảnh */
    if (move_uploaded_file($file['tmp_name'], $target)) {

        /* Lấy avatar cũ */
        $getUser = mysqli_query($conn, "
            SELECT avatar
            FROM users
            WHERE id = $user_id
        ");

        $user = mysqli_fetch_assoc($getUser);

        /* Xóa avatar cũ nếu có */
        if (
            !empty($user['avatar']) &&
            file_exists($uploadDir . $user['avatar'])
        ) {
            unlink($uploadDir . $user['avatar']);
        }

        /* Cập nhật database */
        mysqli_query($conn, "
            UPDATE users
            SET avatar = '$fileName'
            WHERE id = $user_id
        ");

        header("Location: user.php");
        exit();

    } else {

        echo "
        <script>
            alert('Upload thất bại');
            window.location.href='user.php';
        </script>
        ";
    }

} else {

    echo "
    <script>
        alert('Vui lòng chọn ảnh');
        window.location.href='user.php';
    </script>
    ";
}
?>