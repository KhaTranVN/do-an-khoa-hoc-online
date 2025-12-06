<?php require_once '../includes/header.php'; 

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT o.*, u.username, u.email FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE o.id = ?");
$stmt->execute([$id]);
$order = $stmt->fetch();

if (!$order) {
    $_SESSION['error'] = "Đơn hàng không tồn tại!";
    redirect('index.php');
}

$items = $pdo->prepare("SELECT od.*, c.title FROM order_details od JOIN courses c ON od.course_id = c.id WHERE od.order_id = ?");
$items->execute([$id]);
$order_items = $items->fetchAll();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-receipt"></i> Chi tiết đơn hàng #<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></h2>
        <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Danh sách khóa học</h4>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Khóa học</th>
                                <th class="text-end">Giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($order_items as $item): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($item['title']) ?></strong></td>
                                <td class="text-end fw-bold"><?= number_format($item['price']) ?>₫</td>
                            </tr>
                            <?php endforeach; ?>
                            <tr class="table-primary">
                                <td class="fw-bold fs-5">TỔNG CỘNG</td>
                                <td class="text-end fw-bold fs-4 text-primary"><?= number_format($order['total_amount']) ?>₫</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Thông tin đơn hàng</h5>
                </div>
                <div class="card-body">
                    <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['username'] ?? 'Khách vãng lai') ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($order['email'] ?? '—') ?></p>
                    <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i:s', strtotime($order['created_at'])) ?></p>
                    <p><strong>Trạng thái:</strong> 
                        <span class="badge <?= $order['status'] == 'completed' ? 'bg-success' : ($order['status'] == 'pending' ? 'bg-warning text-dark' : 'bg-secondary') ?> fs-6">
                            <?= $order['status'] == 'completed' ? 'ĐÃ GIAO' : ($order['status'] == 'pending' ? 'CHỜ XỬ LÝ' : 'ĐÃ HỦY') ?>
                        </span>
                    </p>
                    <hr>
                    <div class="d-grid gap-2">
                        <?php if($order['status'] == 'pending'): ?>
                            <a href="complete.php?id=<?= $order['id'] ?>" class="btn btn-success btn-lg">Xác nhận đã giao</a>
                        <?php endif; ?>
                        <?php if($order['status'] != 'cancelled'): ?>
                            <a href="cancel.php?id=<?= $order['id'] ?>" class="btn btn-danger" onclick="return confirm('Hủy đơn hàng này?')">Hủy đơn hàng</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>