<?php
require_once dirname(__DIR__, 2) . '/init.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo "<script>window.location.href = 'http://localhost:3000/index.php';</script>";
    exit();
}

$base_url = "http://localhost:3000";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Khóa Học Online Pro</title>

    <!-- FONT AWESOME 6 – CHẠY NGON 100% Ở VIỆT NAM (UNPKG) -->
    <link rel="stylesheet" href="https://unpkg.com/@fortawesome/fontawesome-free@6.6.0/css/all.min.css">

    <!-- Bootstrap 5 + Google Font -->
    <link href="<?= $base_url ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --sidebar-width: 300px;
            --topbar-height: 70px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: #e2e8f0;
            z-index: 1050;
            box-shadow: 10px 0 40px rgba(0,0,0,0.4);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            background: #0f172a;
            text-align: center;
            border-bottom: 1px solid #334155;
        }

        .sidebar-header h3 {
            color: #fff;
            margin: 0;
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .sidebar .list-group-item {
            background: transparent;
            border: none;
            padding: 1.1rem 1.8rem;
            color: #cbd5e1;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            gap: 18px;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar .list-group-item i {
            width: 28px;
            font-size: 1.4rem;
            text-align: center;
            color: #94a3b8;
            transition: all 0.3s;
        }

        .sidebar .list-group-item:hover {
            background: rgba(99, 102, 241, 0.15);
            color: white;
            padding-left: 2.5rem;
            border-left: 4px solid var(--primary);
        }

        .sidebar .list-group-item:hover i {
            color: white;
            transform: scale(1.2);
        }

        .sidebar .list-group-item.active {
            background: rgba(99, 102, 241, 0.25);
            color: white;
            font-weight: 600;
            padding-left: 2.5rem;
            border-left: 4px solid var(--primary);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
        }

        .sidebar .list-group-item.active i {
            color: white;
            transform: scale(1.2);
        }

        .topbar {
            height: var(--topbar-height);
            background: white;
            margin-left: var(--sidebar-width);
            padding: 0 3rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1040;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--topbar-height);
            padding: 3rem;
            min-height: calc(100vh - var(--topbar-height));
            background: #f8fafc;
        }

        .admin-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 2rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            :root { --sidebar-width: 80px; }
            .sidebar-header h3, .sidebar .list-group-item span { display: none; }
            .sidebar .list-group-item { justify-content: center; padding: 1.3rem; }
            .sidebar .list-group-item:hover, .sidebar .list-group-item.active { padding-left: 1.3rem; padding-right: 1.3rem; }
            .topbar, .main-content { margin-left: 80px; }
            .topbar { padding: 0 1.5rem; }
        }
    </style>
</head>
<body>

<!-- SIDEBAR ADMIN – ICON ĐẸP, HIỆN RÕ 100% -->
<div class="sidebar">
    <div class="sidebar-header">
        <h3>ADMIN</h3>
    </div>
    <div class="list-group list-group-flush mt-4">
        <a href="<?= $base_url ?>/admin/dashboard.php" 
           class="list-group-item <?= (basename($_SERVER['PHP_SELF']) == 'dashboard.php' || $_SERVER['REQUEST_URI'] == '/admin/') ? 'active' : '' ?>">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>
        <a href="<?= $base_url ?>/admin/courses/index.php" 
           class="list-group-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/courses') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-book"></i>
            <span>Quản lý khóa học</span>
        </a>
        <a href="<?= $base_url ?>/admin/categories/index.php" 
           class="list-group-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/categories') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-folder-tree"></i>
            <span>Danh mục</span>
        </a>
        <a href="<?= $base_url ?>/admin/instructors/index.php" 
           class="list-group-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/instructors') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-chalkboard-teacher"></i>
            <span>Giảng viên</span>
        </a>
        <a href="<?= $base_url ?>/admin/users/index.php" 
           class="list-group-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/users') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-users-gear"></i>
            <span>Người dùng</span>
        </a>
        <a href="<?= $base_url ?>/admin/orders/index.php" 
           class="list-group-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/orders') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-receipt"></i>
            <span>Đơn hàng</span>
        </a>
        <a href="<?= $base_url ?>/admin/news/index.php" 
           class="list-group-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/news') !== false ? 'active' : '' ?>">
            <i class="fa-solid fa-newspaper"></i>
            <span>Tin tức</span>
        </a>

        <hr class="border-secondary my-5 mx-4">

        <a href="<?= $base_url ?>/index.php" class="list-group-item text-info">
            <i class="fa-solid fa-home"></i>
            <span>Trang chủ</span>
        </a>
        <a href="<?= $base_url ?>/modules/auth/logout.php" class="list-group-item text-danger">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Đăng xuất</span>
        </a>
    </div>
</div>

<!-- TOPBAR -->
<nav class="topbar">
    <h4 class="mb-0 text-primary fw-bold">QUẢN TRỊ HỆ THỐNG</h4>
    <div class="d-flex align-items-center gap-4">
        <div class="text-end">
            <div class="fw-bold text-dark fs-5"><?= htmlspecialchars($_SESSION['user']['username']) ?></div>
            <small class="text-muted">Quản trị viên</small>
        </div>
        <div class="bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center" 
             style="width:60px;height:60px;background: linear-gradient(135deg, #667eea, #764ba2);">
            <i class="fa-solid fa-user-shield fa-2x"></i>
        </div>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container-fluid">
        <!-- NỘI DUNG CÁC TRANG ADMIN SẼ ĐƯỢC INCLUDE TẠI ĐÂY -->