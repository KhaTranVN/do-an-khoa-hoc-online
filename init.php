<?php
// File: init.php – ĐÃ FIX CHO VERCEL + HOSTINGER + INFINITYFREE + LOCALHOST!!!
// Chạy ngon 100% ở mọi nơi – không cần sửa gì nữa!

// Bắt đầu session (nếu chưa có)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Đường dẫn tuyệt đối (rất quan trọng cho Vercel & hosting)
define('ROOT_PATH', __DIR__);

// TỰ ĐỘNG NHẬN BASE_URL – KHÔNG CẦN SỬA KHI DEPLOY!!!
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
             (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
             ? 'https://' : 'http://';

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$request_uri = $_SERVER['REQUEST_URI'] ?? '';
$script_name = $_SERVER['SCRIPT_NAME'] ?? '';
$base_path = dirname($script_name);

// Xử lý trường hợp Vercel có /api/ prefix
if (strpos($request_uri, '/api/') === 0) {
    $base_path = '/';
}

define('BASE_URL', $protocol . $host . rtrim($base_path, '/'));

// Kết nối CSDL + functions + classes (chuẩn MVC)
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/includes/functions.php';

// Tự động load tất cả class trong thư mục classes
foreach (glob(ROOT_PATH . '/classes/*.php') as $file) {
    require_once $file;
}

// Helper functions (siêu tiện)
function is_logged_in() {
    return isset($_SESSION['user']);
}

function is_admin() {
    return is_logged_in() && ($_SESSION['user']['role'] ?? '') === 'admin';
}

function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit;
}

function asset($path) {
    return BASE_URL . '/' . ltrim($path, '/');
}
?>