<?php
// File: index.php (gốc project) – SIÊU ROUTER TÍCH HỢP, KHÔNG CẦN FILE ROUTER.PHP NỮA!!!
session_start();
require_once 'init.php';

// === TỰ ĐỘNG LẤY BASE_URL – CHẠY NGON MỌI NƠI (LOCAL, VERCEL, HOSTING) ===
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
             $_SERVER['SERVER_PORT'] == 443 || 
             (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
             ? "https://" : "http://";

$base_url = $protocol . $_SERVER['HTTP_HOST'];
define('BASE_URL', $base_url);

// === LẤY ĐƯỜNG DẪN HIỆN TẠI ===
$request_uri = $_SERVER['REQUEST_URI'] ?? '/';
$request = parse_url($request_uri, PHP_URL_PATH);
$request = ltrim($request, '/');
$request = $request === '' ? 'home' : $request;

// === TỰ ĐỘNG CHUYỂN ADMIN VÀO DASHBOARD ===
if (is_logged_in() && is_admin() && !str_starts_with($request, 'admin') && $request !== 'auth/logout') {
    header("Location: " . BASE_URL . "/admin");
    exit();
}

// === SIÊU ROUTER THÔNG MINH – CHỈ 1 FILE DUY NHẤT ===
switch (true) {

    case $request === '' || $request === 'home' || $request === 'index.php':
        require 'modules/home/index.php';
        break;

    case str_starts_with($request, 'admin'):
        if (!is_logged_in() || !is_admin()) {
            $_SESSION['toast'] = ['type' => 'error', 'title' => 'Lỗi', 'message' => 'Bạn không có quyền truy cập khu vực này!'];
            header("Location: " . BASE_URL . "/auth/login");
            exit();
        }
        $file = 'admin/' . substr($request, 6);
        $file = $file === 'admin/' ? 'admin/dashboard.php' : 'admin/' . rtrim($file, '/') . '.php';
        require file_exists($file) ? $file : 'admin/dashboard.php';
        break;

    case str_starts_with($request, 'courses'):
        if ($request === 'courses' || $request === 'courses/') {
            require 'modules/courses/index.php';
        } elseif (preg_match('#^courses/detail/(\d+)$#', $request, $m)) {
            $_GET['id'] = $m[1];
            require 'modules/courses/detail.php';
        }
        break;

    case str_starts_with($request, 'auth/'):
        $auth_file = 'modules/' . $request . '.php';
        if (file_exists($auth_file)) {
            require $auth_file;
        } else {
            $_SESSION['toast'] = ['type' => 'error', 'title' => 'Lỗi', 'message' => 'Trang không tồn tại!'];
            require 'modules/home/index.php';
        }
        break;

    case $request === 'cart' || $request === 'cart/':
        require 'cart/index.php';
        break;

    case $request === 'checkout':
        require 'modules/checkout/index.php';
        break;

    default:
        http_response_code(404);
        require 'modules/home/index.php'; // hoặc tạo file 404.php đẹp
        break;
}
