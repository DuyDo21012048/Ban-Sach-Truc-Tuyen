<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>

    <link rel="stylesheet" href="css/register.css">
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
            <p>Tạo tài khoản mới</p>
        </div>

        <!-- FORM -->
        <form action="register_process.php" method="POST">

            <!-- Name -->
            <div class="mb-3">
                <label>Họ và tên</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" name="name" class="form-control"
                        placeholder="Nguyễn Văn A" required>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label>Email</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" name="email" class="form-control"
                        placeholder="example@email.com" required>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label>Mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="password" class="form-control"
                        placeholder="••••••••" required>
                    <span class="input-group-text toggle-password">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label>Xác nhận mật khẩu</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="confirm_password"
                        class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <!-- Button -->
            <button class="btn register-btn w-100">
                Đăng ký
            </button>

        </form>

        <!-- LOGIN LINK -->
        <p class="register-text text-center mt-3">
            Đã có tài khoản?
            <a href="login.php">Đăng nhập</a>
        </p>

    </div>

</div>

<!-- JS show/hide password -->
<script>
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