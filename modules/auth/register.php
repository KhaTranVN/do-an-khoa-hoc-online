<?php $title = "Đăng ký"; require_once 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-5">
                <h3 class="text-center mb-4">Đăng nhập</h3>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label>Mật khẩu</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>
                <hr>
                <a href="oauth2callback.php" class="btn btn-danger w-100">
                    <i class="fab fa-google"></i> Đăng nhập bằng Google
                </a>
                <p class="text-center mt-3">
                    Chưa có tài khoản? <a href="index.php?mod=auth&act=register">Đăng ký ngay</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>