<?php 
if(session_status() == PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__) . '/init.php'; 

$cart_count = 0;
if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'] ?? 0;
    }
}

$base_url = "http://localhost:3000";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Khóa Học Online Pro</title>

    <link rel="stylesheet" href="https://unpkg.com/@fortawesome/fontawesome-free@6.6.0/css/all.min.css">
    <link href="<?= $base_url ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $base_url ?>/assets/vendor/owlcarousel/owl.carousel.min.css" rel="stylesheet">
    <link href="<?= $base_url ?>/assets/vendor/owlcarousel/owl.theme.default.min.css" rel="stylesheet">
    <link href="<?= $base_url ?>/assets/css/style.css" rel="stylesheet">

    <style>
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            padding: 1rem 0;
            min-height: 80px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            box-shadow: 0 8px 30px rgba(0,0,0,0.4);
        }

        .navbar-brand {
            font-size: 2rem;
            font-weight: 900;
            color: white !important;
        }

        /* ĐẢM BẢO TẤT CẢ NÚT TRÊN 1 DÒNG, KHÔNG TRÀN MÀN HÌNH */
        .navbar-nav .nav-link,
        .navbar-nav .btn {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 52px !important;
            padding: 0 1.1rem !important;
            margin: 0 0.4rem !important;
            border-radius: 50px !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            white-space: nowrap !important;
            gap: 8px;
            min-width: auto !important;
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .navbar-nav .nav-link i {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        /* Giỏ hàng */
        .navbar-nav .nav-link.position-relative {
            background: rgba(255,255,255,0.12);
        }

        /* Nút đăng nhập */
        .navbar-nav .nav-link.bg-primary {
            background: rgba(255,255,255,0.18) !important;
        }

        /* Nút đăng ký */
        .navbar-nav .btn-outline-light {
            border: 2.5px solid white !important;
            background: transparent;
            color: white !important;
        }

        /* Hover */
        .navbar-nav .nav-link:hover,
        .navbar-nav .btn:hover {
            background: rgba(255,255,255,0.3) !important;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }

        .cart-badge {
            background: #ff4757;
            color: white;
            font-weight: bold;
            font-size: 0.75rem;
            padding: 0.35em 0.6em;
            border-radius: 50px;
            top: -8px;
            right: -8px;
            z-index: 99999;
        }

        /* RESPONSIVE – ĐẸP TRÊN MỌI MÀN HÌNH */
        @media (max-width: 1200px) {
            .navbar-nav .nav-link,
            .navbar-nav .btn {
                padding: 0 1rem !important;
                font-size: 0.9rem !important;
                min-width: auto !important;
            }
        }

        @media (max-width: 992px) {
            .navbar-nav {
                gap: 0.5rem !important;
            }
            .navbar-nav .nav-link,
            .navbar-nav .btn {
                height: 48px !important;
                padding: 0 0.8rem !important;
                font-size: 0.85rem !important;
                margin: 0.3rem 0 !important;
            }
            .navbar-nav .nav-link i {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 768px) {
            .navbar-nav .nav-link,
            .navbar-nav .btn {
                width: 100%;
                justify-content: flex-start;
                padding-left: 2rem !important;
            }
        }
    </style>
</head>
<body>

<!-- TOAST -->
<?php if(isset($_SESSION['toast'])): 
    $toast = $_SESSION['toast'];
    unset($_SESSION['toast']);
?>
<div class="position-fixed top-0 end-0 p-4" style="z-index: 99999;">
    <div class="toast align-items-center text-white border-0 show shadow-lg" role="alert" 
         style="background: <?= $toast['type']=='success'?'#28a745':'#dc3545' ?>; border-radius: 16px;">
        <div class="d-flex">
            <div class="toast-body py-4 px-5">
                <strong class="d-block fs-5 mb-2"><?= $toast['title'] ?></strong>
                <?= $toast['message'] ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-3 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
<script>
setTimeout(() => document.querySelector('.toast') && new bootstrap.Toast(document.querySelector('.toast')).hide(), 4000);
</script>
<?php endif; ?>

<!-- NAVBAR – KHÔNG TRÀN MÀN HÌNH, ĐẸP HOÀN HẢO -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?= $base_url ?>/">
            <i class="fa-solid fa-graduation-cap text-warning me-3" style="font-size:2.4rem;"></i>
            <span class="fw-bold">KHÓA HỌC ONLINE</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/">
                        <i class="fa-solid fa-house"></i> Trang chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/modules/courses">
                        <i class="fa-solid fa-book-open"></i> Khóa học
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>/modules/news">
                        <i class="fa-solid fa-newspaper"></i> Tin tức
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav align-items-center">
                <!-- Giỏ hàng -->
                <li class="nav-item">
                    <a class="nav-link position-relative" href="<?= $base_url ?>/modules/cart/index.php">
                        <i class="fa-solid fa-cart-shopping"></i> Giỏ hàng
                        <?php if($cart_count > 0): ?>
                            <span class="position-absolute translate-middle badge rounded-pill bg-danger cart-badge">
                                <?= $cart_count ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>

                <?php if(is_logged_in()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="<?= $_SESSION['user']['avatar'] ?? $base_url . '/assets/img/default-avatar.png' ?>" 
                                 class="rounded-circle me-3" style="width:40px;height:40px;object-fit:cover;border:3px solid white;">
                            <?= htmlspecialchars($_SESSION['user']['username']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                            <li><a class="dropdown-item" href="<?= $base_url ?>/modules/user/profile.php">Hồ sơ cá nhân</a></li>
                            <li><a class="dropdown-item" href="<?= $base_url ?>/modules/user/orders.php">Lịch sử mua hàng</a></li>
                            <li><a class="dropdown-item" href="<?= $base_url ?>/modules/user/my_courses.php">Khóa học của tôi</a></li>
                            <?php if(is_admin()): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger fw-bold" href="<?= $base_url ?>/admin/dashboard.php">Quản trị hệ thống</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= $base_url ?>/modules/auth/logout.php">Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?= $base_url ?>/modules/auth/login.php" class="nav-link text-white bg-primary bg-opacity-20">
                            <i class="fa-solid fa-right-to-bracket"></i> Đăng nhập
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $base_url ?>/modules/auth/register.php" class="btn btn-outline-light">
                            <i class="fa-solid fa-user-plus"></i> Đăng ký
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div style="height: 100px;"></div>
<div class="main-content">