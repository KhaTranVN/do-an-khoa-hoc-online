<?php
require_once '../../init.php';

// Nếu đã đăng nhập rồi thì không cho vào trang đăng ký nữa
if (is_logged_in()) {
    header("Location: " . $base_url);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register.php");
    exit();
}

// Lấy dữ liệu từ form
$fullname = trim($_POST['fullname'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm  = $_POST['password_confirm'] ?? '';

// Validate
if (empty($fullname) || empty($email) || empty($password)) {
    $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin!";
    header("Location: register.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Email không hợp lệ!";
    header("Location: register.php");
    exit();
}

if (strlen($password) < 6) {
    $_SESSION['error'] = "Mật khẩu phải ít nhất 6 ký tự!";
    header("Location: register.php");
    exit();
}

if ($password !== $confirm) {
    $_SESSION['error'] = "Nhập lại mật khẩu không khớp!";
    header("Location: register.php");
    exit();
}

// Kiểm tra email đã tồn tại chưa
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    $_SESSION['error'] = "Email này đã được sử dụng!";
    header("Location: register.php");
    exit();
}

// Mã hóa mật khẩu
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Tạo username tự động (có thể trùng, không sao)
$username = 'user_' . substr(md5($email . time()), 0, 8);

// Insert vào database
try {
    $stmt = $pdo->prepare("INSERT INTO users (username, fullname, email, password, role, created_at) 
                           VALUES (?, ?, ?, ?, 'user', NOW())");
    $stmt->execute([$username, $fullname, $email, $hashed_password]);

    $_SESSION['success'] = "Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.";
    header("Location: login.php");
    exit();
} catch (Exception $e) {
    $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại sau!";
    header("Location: register.php");
    exit();
}