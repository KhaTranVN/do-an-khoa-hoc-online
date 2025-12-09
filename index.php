<?php
session_start();
require_once 'init.php';

// Đường dẫn gốc
$base_url = "http://localhost:3000";

// Lấy URL hiện tại và xử lý
$request = $_SERVER['REQUEST_URI'];
$script_name = $_SERVER['SCRIPT_NAME'];
$script_dir = dirname($script_name);
$request = str_replace($script_dir, '', $request);
$request = parse_url($request, PHP_URL_PATH);
$request = ltrim($request, '/');
$parts = explode('/', $request);

// === TỰ ĐỘNG ĐƯA ADMIN VÀO TRANG QUẢN TRỊ SAU KHI ĐĂNG NHẬP ===
if (is_logged_in() && is_admin() && !strpos($request, 'admin') === 0 && $request !== 'auth/logout') {
    // Nếu là admin mà đang ở trang user hoặc trang chủ → đưa thẳng vào admin
    header("Location: $base_url/admin");
    exit();
}

// === ROUTING SIÊU THÔNG MINH ===
switch (true) {

    // Trang chủ
    case $request === '' || $request === 'index.php' || $request === '/':
        require 'modules/home/index.php';
        exit();

    // === ADMIN – CHỈ ADMIN MỚI VÀO ĐƯỢC ===
    case strpos($request, 'admin') === 0:
        if (!is_logged_in() || !is_admin()) {
            $_SESSION['error'] = "Bạn không có quyền truy cập khu vực quản trị!";
            header("Location: $base_url/auth/login");
            exit();
        }
        $path = 'admin/' . ltrim(str_replace('admin', '', $request), '/');
        $file = rtrim($path, '/') . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            require 'admin/dashboard.php';
        }
        exit();

    // === USER (kể cả admin cũng dùng được) ===
    case in_array($request, ['user/profile', 'user/edit', 'user/orders', 'user/my-courses']):
        if (!is_logged_in()) {
            $_SESSION['error'] = "Vui lòng đăng nhập!";
            header("Location: $base_url/auth/login");
            exit();
        }
        $file = 'modules/user/' . substr($request, 5) . '.php';
        require file_exists($file) ? $file : 'modules/user/profile.php';
        exit();

    case preg_match('/^user\/course-detail\/(\d+)$/', $request, $m):
        if (!is_logged_in()) {
            header("Location: $base_url/auth/login");
            exit();
        }
        $_GET['id'] = $m[1];
        require 'modules/user/course_detail.php';
        exit();

    // === KHÓA HỌC ===
    case $request === 'courses' || $request === 'courses/':
        require 'modules/courses/index.php';
        exit();
    case preg_match('/^courses\/detail\/(\d+)$/', $request, $m):
        $_GET['id'] = $m[1];
        require 'modules/courses/detail.php';
        exit();

    // === TIN TỨC ===
    case $request === 'news' || $request === 'news/':
        require 'modules/news/index.php';
        exit();
    case preg_match('/^news\/detail\/(\d+)$/', $request, $m):
        $_GET['id'] = $m[1];
        require 'modules/news/detail.php';
        exit();

    // === GIỎ HÀNG & THANH TOÁN ===
    case $request === 'cart' || $request === 'cart/':
        require 'cart/index.php';
        exit();
    case $request === 'checkout':
        require 'modules/checkout/index.php';
        exit();
    case $request === 'checkout/success':
        require 'modules/checkout/success.php';
        exit();

    // === AUTH ===
    case in_array($request, ['auth/login', 'auth/register', 'auth/logout', 'auth/google-callback']):
        require ($request === 'auth/google-callback' ? '' : 'modules/') . $request . '.php';
        exit();

    // === XỬ LÝ GIỎ HÀNG ===
    case preg_match('/^modules\/cart\/(add|remove|update)\.php$/', $_SERVER['REQUEST_URI']):
        $file = 'modules/cart/' . basename($_SERVER['REQUEST_URI']);
        if (file_exists($file)) require $file;
        exit();

    // Trang không tồn tại
    default:
        http_response_code(404);
        require 'modules/home/index.php';
        exit();
}