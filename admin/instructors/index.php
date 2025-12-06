<?php require_once '../includes/header.php'; ?>

<?php
// Lấy tất cả giảng viên (kể cả đã xóa mềm để admin quản lý)
$stmt = $pdo->query("SELECT * FROM instructors WHERE is_deleted = 0 ORDER BY id DESC");
$instructors = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-chalkboard-teacher"></i> Quản lý Giảng viên</h2>
        <a href="add.php" class="btn btn-success btn-lg">
            <i class="fas fa-plus"></i> Thêm giảng viên mới
        </a>
    </div>

    <?php if (empty($instructors)): ?>
        <div class="card border-0 shadow-lg">
            <div class="card-body text-center py-5">
                <i class="fas fa-chalkboard-teacher fa-5x text-muted mb-4"></i>
                <h4 class="text-muted">Chưa có giảng viên nào</h4>
                <p class="text-muted">Hãy bấm nút <strong>"Thêm giảng viên mới"</strong> để bắt đầu!</p>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach($instructors as $i): ?>
            <div class="col-xl-4 col-lg-6">
                <div class="card border-0 shadow-lg h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="avatar mb-3 mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 120px; height: 120px; font-size: 3rem;">
                            <?php if ($i['avatar']): ?>
                                <img src="../../<?= $i['avatar'] ?>" class="rounded-circle w-100 h-100" style="object-fit: cover;">
                            <?php else: ?>
                                <i class="fas fa-user-tie"></i>
                            <?php endif; ?>
                        </div>
                        <h5 class="card-title fw-bold mb-1"><?= htmlspecialchars($i['name']) ?></h5>
                        <p class="text-muted small mb-3"><?= htmlspecialchars($i['description'] ?? 'Chưa có mô tả') ?></p>
                        
                        <div class="mt-auto">
                            <div class="btn-group w-100" role="group">
                                <a href="edit.php?id=<?= $i['id'] ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="delete.php?id=<?= $i['id'] ?>" class="btn btn-danger" 
                                   onclick="return confirm('Xóa giảng viên này?')">
                                    <i class="fas fa-trash"></i> Xóa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.hover-lift:hover {
    transform: translateY(-10px);
    transition: all 0.3s ease;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}
</style>

<?php require_once '../includes/footer.php'; ?>