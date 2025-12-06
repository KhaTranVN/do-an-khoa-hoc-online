<?php require_once '../../includes/header.php'; ?>  <!-- ĐÃ SỬA ĐÚNG ĐƯỜNG DẪN -->
<?php $title = "Đăng ký tài khoản"; ?>

<div class="min-vh-100 d-flex align-items-center bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">
                <div class="card border-0 shadow-2xl rounded-4 overflow-hidden">
                    <div class="card-header text-white text-center py-5 position-relative overflow-hidden" 
                         style="background: linear-gradient(135deg, #667eea, #764ba2);">
                       <div class="position-absolute top-50 start-50 translate-middle" style="opacity: 0.04; filter: blur(1px);">
                            <i class="fa-solid fa-user-plus fa-10x text-white"></i>
                        </div>
                        <h1 class="display-5 fw-bold mb-3 position-relative">
                            <i class="fa-solid fa-graduation-cap me-3"></i> KHÓA HỌC ONLINE
                        </h1>
                        <p class="fs-4 mb-0 position-relative opacity-90">Tạo tài khoản miễn phí</p>
                    </div>

                    <div class="card-body p-5">
                        <?php if(isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger rounded-4 border-0 shadow-sm">
                                <i class="fa-solid fa-circle-exclamation me-2"></i>
                                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>

                        <form action="register_process.php" method="POST" class="needs-validation" novalidate>
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fa-solid fa-user text-primary me-2"></i> Họ và tên
                                </label>
                                <input type="text" name="fullname" class="form-control form-control-lg rounded-pill px-4" 
                                       placeholder="Nguyễn Văn A" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fa-solid fa-envelope text-primary me-2"></i> Email
                                </label>
                                <input type="email" name="email" class="form-control form-control-lg rounded-pill px-4" 
                                       placeholder="you@example.com" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fa-solid fa-lock text-primary me-2"></i> Mật khẩu
                                </label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" 
                                           class="form-control form-control-lg rounded-pill px-4" 
                                           placeholder="Tối thiểu 6 ký tự" minlength="6" required>
                                    <button type="button" class="btn btn-outline-secondary rounded-pill" onclick="togglePassword()">
                                        <i class="fa-solid fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fa-solid fa-lock text-primary me-2"></i> Nhập lại mật khẩu
                                </label>
                                <input type="password" name="password_confirm" class="form-control form-control-lg rounded-pill px-4" 
                                       placeholder="Nhập lại mật khẩu" required>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="agree" required>
                                <label class="form-check-label text-muted" for="agree">
                                    Tôi đồng ý với <a href="#" class="text-primary">điều khoản dịch vụ</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill shadow-lg fw-bold py-3 mb-4"
                                    style="background: linear-gradient(135deg, #43e97b, #38f9d7); border:none;">
                                TẠO TÀI KHOẢN MIỄN PHÍ
                            </button>
                        </form>

                        <div class="text-center my-4">
                            <span class="text-muted">hoặc đăng ký bằng</span>
                        </div>

                        <a href="<?= $base_url ?>/auth/google-callback.php" 
                           class="btn btn-danger btn-lg w-100 rounded-pill shadow d-flex align-items-center justify-content-center gap-3 py-3">
                            <i class="fab fa-google"></i>
                            <span class="fw-bold">Google</span>
                        </a>

                        <div class="text-center mt-4">
                            <p class="mb-0 text-muted fs-6">
                                Đã có tài khoản? 
                                <a href="<?= $base_url ?>/modules/auth/login.php" class="text-primary fw-bold">
                                    Đăng nhập ngay
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.25) !important;
        transition: all 0.3s;
    }
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102,126,234,0.25);
    }
</style>

<script>
function togglePassword() {
    const p = document.getElementById('password');
    const i = document.getElementById('eyeIcon');
    if (p.type === 'password') {
        p.type = 'text';
        i.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        p.type = 'password';
        i.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>

<?php require_once '../../includes/footer.php'; ?>  <!-- ĐÃ SỬA ĐÚNG ĐƯỜNG DẪN -->