<?php require_once '../includes/header.php'; ?>

<?php
// Lấy tất cả đơn hàng + thông tin user
$stmt = $pdo->query("SELECT o.*, u.username, u.email 
                     FROM orders o 
                     LEFT JOIN users u ON o.user_id = u.id 
                     ORDER BY o.created_at DESC");
$orders = $stmt->fetchAll();
?>

<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-shopping-cart"></i> Quản lý Đơn hàng (<?= count($orders) ?>)</h2>

    <div class="card border-0 shadow-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã ĐH</th>
                            <th>Khách hàng</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orders as $o): 
                            // Đếm số khóa học trong đơn
                            $item_count = $pdo->query("SELECT COUNT(*) FROM order_details WHERE order_id = " . $o['id'])->fetchColumn();
                        ?>
                        <tr>
                            <td><strong>#<?= str_pad($o['id'], 5, '0', STR_PAD_LEFT) ?></strong></td>
                            <td>
                                <div class="fw-bold"><?= htmlspecialchars($o['username'] ?? 'Khách vãng lai') ?></div>
                                <small class="text-muted"><?= htmlspecialchars($o['email'] ?? '—') ?></small>
                            </td>
                            <td><span class="badge bg-info fs-6"><?= $item_count ?> khóa</span></td>
                            <td class="fw-bold text-danger fs-5"><?= number_format($o['total_amount']) ?>₫</td>
                            <td>
                                <?php 
                                $status_class = $o['status'] == 'completed' ? 'bg-success' : ($o['status'] == 'pending' ? 'bg-warning text-dark' : 'bg-secondary');
                                $status_text = $o['status'] == 'completed' ? 'ĐÃ GIAO' : ($o['status'] == 'pending' ? 'CHỜ XỬ LÝ' : 'ĐÃ HỦY');
                                ?>
                                <span class="badge <?= $status_class ?> fs-6"><?= $status_text ?></span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="detail.php?id=<?= $o['id'] ?>" class="btn btn-primary btn-sm" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
                                    <?php if($o['status'] == 'pending'): ?>
                                        <a href="complete.php?id=<?= $o['id'] ?>" class="btn btn-success btn-sm" title="Xác nhận đã giao hàng">
                                            <i class="fas fa-check"></i> Giao hàng
                                        </a>
                                    <?php endif; ?>
                                    <?php if($o['status'] != 'cancelled'): ?>
                                        <a href="cancel.php?id=<?= $o['id'] ?>" class="btn btn-danger btn-sm" title="Hủy đơn hàng"
                                           onclick="return confirm('Hủy đơn hàng này?')">
                                            <i class="fas fa-times"></i> Hủy
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>