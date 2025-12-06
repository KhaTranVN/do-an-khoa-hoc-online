<?php 
require_once '../../init.php';
if (!is_logged_in()) redirect('../../index.php');

$user_id = $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT o.*, (SELECT COUNT(*) FROM order_details WHERE order_id = o.id) as item_count 
                       FROM orders o WHERE o.user_id = ? ORDER BY o.created_at DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lịch sử đơn hàng - Khóa Học Online Pro</title>
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require_once '../../includes/header.php'; ?>

    <div class="container my-5">
        <h2 class="mb-4"><i class="fas fa-history"></i> Lịch sử mua hàng</h2>

        <?php if (empty($orders)): ?>
            <div class="text-center py-5">
                <i class="fas fa-shopping-bag fa-5x text-muted mb-4"></i>
                <h4 class="text-muted">Bạn chưa mua khóa học nào</h4>
                <a href="../../index.php" class="btn btn-primary btn-lg">Xem khóa học ngay</a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach($orders as $o): ?>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5>Đơn hàng #<?= str_pad($o['id'], 5, '0', STR_PAD_LEFT) ?></h5>
                                    <p class="text-muted small">
                                        <i class="fas fa-calendar"></i> <?= date('d/m/Y H:i', strtotime($o['created_at'])) ?>
                                    </p>
                                    <p><strong><?= $o['item_count'] ?> khóa học</strong> - <?= number_format($o['total_amount']) ?>₫</p>
                                </div>
                                <span class="badge <?= $o['status'] == 'completed' ? 'bg-success' : 'bg-warning text-dark' ?> fs-6">
                                    <?= $o['status'] == 'completed' ? 'ĐÃ GIAO' : 'CHỜ XỬ LÝ' ?>
                                </span>
                            </div>
                            <?php if($o['status'] == 'completed'): ?>
                                <a href="view_courses.php?order_id=<?= $o['id'] ?>" class="btn btn-primary btn-sm mt-3">
                                    <i class="fas fa-play-circle"></i> Xem khóa học
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php require_once '../../includes/footer.php'; ?>
</body>
</html>