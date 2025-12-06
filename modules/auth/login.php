<?php require_once dirname(__DIR__, 2) . '/init.php'; 

// Nếu đã đăng nhập rồi thì đá về trang chủ
if (is_logged_in()) {
    redirect('../index.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = 'Vui lòng nhập đầy đủ email và mật khẩu';
    } else {
        // Lấy user từ CSDL
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Đăng nhập thành công
            $_SESSION['user'] = [
                'id'       => $user['id'],
                'username' => $user['username'],
                'email'    => $user['email'],
                'role'     => $user['role']
            ];

            // Chuyển hướng theo role
            if ($user['role'] === 'admin') {
                redirect('../admin/dashboard.php');
            } else {
                redirect('../index.php');
            }
        } else {
            $errors[] = 'Email hoặc mật khẩu không đúng';
        }
    }
}

$title = "Đăng nhập";
require_once dirname(__DIR__, 2) . '/includes/header.php'; 
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-5">
                <h3 class="text-center mb-4">Đăng nhập</h3>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach($errors as $e) echo $e . '<br>'; ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required 
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label>Mật khẩu</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>

                <hr>
                <div class="text-center">
                    
                    <a href="register.php" class="text-decoration-none">Chưa có tài khoản? Đăng ký</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/includes/footer.php'; ?>