<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>

    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

<div class="login-container">

    <!-- Back -->
    <a href="home.php" class="back-link">
        ← Quay lại
    </a>

    <div class="login-box">

        <!-- Header -->
        <div class="login-header">
            <h2>BOOKSTORE</h2>
            <p>Chào mừng bạn trở lại!</p>
        </div>

        <!-- Form -->
        <form action="handle_login.php" method="POST">

            <!-- Email -->
            <div class="mb-3">
                <label>Email</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label>Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    <span class="input-group-text toggle-password">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>

            <!-- Options -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <input type="checkbox"> Ghi nhớ đăng nhập
                </div>
                <a href="#" class="forgot-link">Quên mật khẩu?</a>
            </div>

            <!-- Button -->
            <button type="submit" class="login-btn">
                Đăng nhập
            </button>

        </form>

        <!-- Register -->
        <p class="register-text">
            Chưa có tài khoản?
            <a href="register.php">Đăng ký ngay</a>
        </p>

    </div>

</div>

<script>
// show/hide password
const toggle = document.querySelector('.toggle-password');
const password = document.querySelector('input[name="password"]');

toggle.addEventListener('click', () => {
    if (password.type === "password") {
        password.type = "text";
        toggle.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
        password.type = "password";
        toggle.innerHTML = '<i class="bi bi-eye"></i>';
    }
});
</script>

</body>
</html>
