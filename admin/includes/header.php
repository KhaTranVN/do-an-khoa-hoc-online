<?php
require_once '../init.php';
if (!is_admin()) {
    redirect('../index.php');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Khóa Học Online</title>
    
    <!-- Bootstrap 5 + FontAwesome -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/fontawesome/css/all.min.css" rel="stylesheet">
    
    <!-- Admin CSS -->
    <link href="assets/css/admin.css" rel="stylesheet">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="text-center mb-4">
        <h4 class="text-white fw-bold"><i class="fas fa-cogs"></i> ADMIN</h4>
    </div>
    <div class="list-group">
        <a href="dashboard.php" class="list-group-item <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="courses/" class="list-group-item"><i class="fas fa-book"></i> Khóa học</a>
        <a href="categories/" class="list-group-item"><i class="fas fa-tags"></i> Danh mục</a>
        <a href="instructors/" class="list-group-item"><i class="fas fa-chalkboard-teacher"></i> Giảng viên</a>
        <a href="users/" class="list-group-item"><i class="fas fa-users"></i> Người dùng</a>
        <a href="orders/" class="list-group-item"><i class="fas fa-shopping-cart"></i> Đơn hàng</a>
        <a href="news/" class="list-group-item"><i class="fas fa-newspaper"></i> Tin tức</a>
        <a href="../index.php" class="list-group-item text-warning"><i class="fas fa-home"></i> Về trang chủ</a>
        <a href="../modules/auth/logout.php" class="list-group-item text-danger"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
    </div>
</div>

<!-- Top Navbar -->
<nav class="navbar navbar-admin shadow">
    <div class="container-fluid">
        <span class="navbar-text">
            Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong>
        </span>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content">