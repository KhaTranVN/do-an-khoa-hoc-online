<?php require_once '../../init.php'; ?>
<?php require_once '../../includes/header.php'; ?>

<div class="container py-5 text-center">
    <div class="my-5">
        <i class="fas fa-check-circle text-success" style="font-size: 100px;"></i>
        <h1 class="display-4 fw-bold text-success mt-4">Thanh toán thành công!</h1>
        <p class="lead">Cảm ơn bạn đã tin tưởng Khóa Học Online Pro</p>
        <div class="mt-5">
            <a href="<?= $base_url ?>/modules/user/my_courses.php" class="btn btn-success btn-lg px-5">
                Vào học ngay
            </a>
            <a href="<?= $base_url ?>/modules/user/orders.php" class="btn btn-outline-primary btn-lg px-5 ms-3">
                Xem lịch sử đơn hàng
            </a>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>