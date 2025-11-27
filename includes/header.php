
<?php 
if(session_status() == PHP_SESSION_NONE) session_start();
// require_once 'config/database.php';
// require_once 'includes/functions.php';
// require_once dirname(__DIR__) . '/config/database.php';
// require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/init.php'; 

// Đếm số lượng giỏ hàng
$cart_count = 0;
if(isset($_SESSION['cart'])) {
    foreach($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Khóa Học Online Pro</title>
    
    <!-- Bootstrap + FontAwesome -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="assets/vendor/owlcarousel/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/vendor/owlcarousel/owl.theme.default.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expansion navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="fas fa-graduation-cap"></i> KHÓA HỌC ONLINE
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?mod=course&act=list">Khóa học</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?mod=news&act=list">Tin tức</a></li>
            </ul>

            <ul class="navbar-nav">
                <?php if(is_logged_in()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?mod=user&act=profile">Hồ sơ</a></li>
                            <li><a class="dropdown-item" href="index.php?mod=order&act=history">Đơn hàng</a></li>
                            <?php if(is_admin()): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger fw-bold" href="admin/dashboard.php">
                                    <i class="fas fa-cogs"></i> Quản trị
                                </a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="index.php?mod=auth&act=logout">Đăng xuất</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="index.php?mod=cart&act=index">
                            <i class="fas fa-shopping-cart"></i>
                            <?php if($cart_count > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $cart_count ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?mod=auth&act=login">Đăng nhập</a></li>
                    <li class="nav-item"><a class="btn btn-outline-light ms-2" href="index.php?mod=auth&act=register">Đăng ký</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">