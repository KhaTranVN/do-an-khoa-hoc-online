<?php require_once 'includes/header.php'; ?>

<?php
$base_url = "http://localhost:3000";

// Thống kê nhanh
$stats = [
    'courses'  => $pdo->query("SELECT COUNT(*) FROM courses WHERE is_deleted = 0")->fetchColumn(),
    'orders'   => $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
    'users'    => $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(),
    'revenue'  => $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE status='completed'")->fetchColumn(),
    'pending'  => $pdo->query("SELECT COUNT(*) FROM orders WHERE status='pending'")->fetchColumn(),
];
?>

<div class="container-fluid py-4">

    <!-- 4 Ô THỐNG KÊ SIÊU ĐẸP – ICON NỀN KHÔNG CHỒNG CHỮ -->
    <div class="row g-4 mb-5">
        <!-- Khóa học -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 position-relative text-white"
                 style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <div class="card-body p-5 text-center position-relative z-3">
                    <h2 class="display-5 fw-bold mb-2"><?= number_format($stats['courses']) ?></h2>
                    <p class="fs-5 mb-0 opacity-90">Tổng khóa học</p>
                </div>
                <div class="position-absolute top-50 end-0 translate-middle-y pe-4 opacity-12" style="z-index:1;">
                    <i class="fa-solid fa-book-open fa-9x"></i>
                </div>
            </div>
        </div>

        <!-- Đơn hàng -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 position-relative text-white"
                 style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <div class="card-body p-5 text-center position-relative z-3">
                    <h2 class="display-5 fw-bold mb-2"><?= number_format($stats['orders']) ?></h2>
                    <p class="fs-5 mb-0 opacity-90">Tổng đơn hàng</p>
                    <?php if($stats['pending'] > 0): ?>
                        <div class="badge bg-light text-dark fs-6 mt-2 px-3 py-2">
                            <i class="fa-solid fa-clock me-1"></i> <?= $stats['pending'] ?> chờ duyệt
                        </div>
                    <?php endif; ?>
                </div>
                <div class="position-absolute top-50 end-0 translate-middle-y pe-4 opacity-12" style="z-index:1;">
                    <i class="fa-solid fa-receipt fa-9x"></i>
                </div>
            </div>
        </div>

        <!-- Người dùng -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 position-relative text-white"
                 style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                <div class="card-body p-5 text-center position-relative z-3">
                    <h2 class="display-5 fw-bold mb-2"><?= number_format($stats['users']) ?></h2>
                    <p class="fs-5 mb-0 opacity-90">Người dùng</p>
                </div>
                <div class="position-absolute top-50 end-0 translate-middle-y pe-4 opacity-12" style="z-index:1;">
                    <i class="fa-solid fa-users fa-9x"></i>
                </div>
            </div>
        </div>

        <!-- Doanh thu -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 position-relative text-white"
                 style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                <div class="card-body p-5 text-center position-relative z-3">
                    <h2 class="display-5 fw-bold mb-2"><?= number_format($stats['revenue']) ?>₫</h2>
                    <p class="fs-5 mb-0 opacity-90">Tổng doanh thu</p>
                </div>
                <div class="position-absolute top-50 end-0 translate-middle-y pe-4 opacity-12" style="z-index:1;">
                    <i class="fa-solid fa-sack-dollar fa-9x"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- CHÀO MỪNG + SHORTCUT SIÊU ĐẸP -->
    <div class="text-center py-5">
        <div class="card border-0 shadow-2xl d-inline-block p-5 rounded-5" 
             style="background: linear-gradient(135deg, #667eea, #764ba2); max-width: 1100px;">
            <h1 class="text-white mb-4 display-4 fw-bold">
                <i class="fa-solid fa-crown text-warning fa-beat me-3" style="font-size: 3rem;"></i><br>
                Chào mừng quay lại, <span class="text-warning"><?= htmlspecialchars($_SESSION['user']['username']) ?>!</span>
            </h1>
            <p class="lead text-white fs-3 mb-5 opacity-90">
                Quản lý hệ thống một cách dễ dàng và chuyên nghiệp
            </p>

            <div class="row g-5 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <a href="<?= $base_url ?>/admin/courses/index.php" class="text-decoration-none">
                        <div class="p-5 bg-white rounded-4 shadow-lg hover-lift text-center h-100 border border-3 border-primary">
                            <i class="fa-solid fa-book fa-5x text-primary mb-4"></i>
                            <h4 class="fw-bold text-dark">Khóa học</h4>
                            <p class="text-muted fs-5 mb-0"><?= $stats['courses'] ?> khóa học</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="<?= $base_url ?>/admin/categories/index.php" class="text-decoration-none">
                        <div class="p-5 bg-white rounded-4 shadow-lg hover-lift text-center h-100 border border-3 border-success">
                            <i class="fa-solid fa-folder-tree fa-5x text-success mb-4"></i>
                            <h4 class="fw-bold text-dark">Danh mục</h4>
                            <p class="text-muted fs-5 mb-0">Quản lý phân loại</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="<?= $base_url ?>/admin/orders/index.php" class="text-decoration-none">
                        <div class="p-5 bg-white rounded-4 shadow-lg hover-lift text-center h-100 border border-3 border-warning">
                            <i class="fa-solid fa-receipt fa-5x text-warning mb-4"></i>
                            <h4 class="fw-bold text-dark">Đơn hàng</h4>
                            <p class="text-muted fs-5 mb-0"><?= $stats['orders'] ?> đơn hàng</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- <div class="mt-5 p-5 bg-white rounded-4 shadow-lg">
                <h3 class="text-primary fw-bold mb-3">
                    <i class="fa-solid fa-rocket text-warning me-3"></i>
                    Sẵn sàng chinh phục ngày mới!
                </h3>
                <p class="fs-4 text-dark mb-0">
                    Hôm nay là <strong><?= date('l, d/m/Y') ?></strong> — Chúc bạn quản trị thật hiệu quả!
                </p>
            </div> -->
        </div>
    </div>
</div>

<style>
/* ICON NỀN SIÊU ĐẸP – KHÔNG CHỒNG LÊN CHỮ */
.card-body {
    position: relative;
    z-index: 3;
    padding: 2.5rem !important;
}

.card-body i.opacity-25,
.position-absolute i {
    position: absolute !important;
    top: 50% !important;
    right: 15px !important;
    transform: translateY(-50%) !important;
    opacity: 0.12 !important;
    font-size: 9rem !important;
    pointer-events: none !important;
    z-index: 1 !important;
}

/* Đảm bảo chữ luôn ở trên */
.card-body h2,
.card-body p,
.card-body .badge {
    position: relative;
    z-index: 4;
}

/* Hiệu ứng hover cho shortcut */
.hover-lift {
    transition: all 0.4s ease;
}
.hover-lift:hover {
    transform: translateY(-15px) scale(1.03);
    box-shadow: 0 30px 60px rgba(0,0,0,0.3) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .display-5 { font-size: 2.8rem !important; }
    .card-body i.opacity-25 { font-size: 7rem !important; right: 10px !important; }
    .navbar-brand { font-size: 1.8rem !important; }
}
</style>

<?php require_once 'includes/footer.php'; ?>