<?php require_once '../includes/header.php'; ?>

<?php
// Lấy tất cả khóa học (kể cả chưa publish để admin quản lý)
$stmt = $pdo->query("SELECT c.*, cat.name as cat_name, i.name as instructor_name 
                     FROM courses c 
                     LEFT JOIN categories cat ON c.category_id = cat.id 
                     LEFT JOIN instructors i ON c.instructor_id = i.id 
                     WHERE c.is_deleted = 0 
                     ORDER BY c.id DESC");
$courses = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-book text-primary"></i> Quản lý Khóa học</h2>
        <a href="add.php" class="btn btn-success btn-lg shadow">
            <i class="fa-solid fa-plus"></i> Thêm khóa học mới
        </a>
    </div>

    <?php if (empty($courses)): ?>
        <div class="card border-0 shadow-lg">
            <div class="card-body text-center py-5">
                <i class="fa-solid fa-book-open fa-5x text-muted mb-4"></i>
                <h4 class="text-muted">Chưa có khóa học nào</h4>
                <p class="text-muted">Hãy bấm nút <strong>"Thêm khóa học mới"</strong> để bắt đầu!</p>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach($courses as $c): ?>
            <div class="col-xl-4 col-lg-6">
                <div class="card border-0 shadow-lg h-100 hover-lift rounded-4 overflow-hidden">
                    <img src="<?= $c['thumbnail'] ? '../../' . $c['thumbnail'] : '../../assets/img/no-image.jpg' ?>" 
                         class="card-img-top" alt="<?= htmlspecialchars($c['title']) ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title fw-bold text-primary"><?= htmlspecialchars($c['title']) ?></h5>
                        <p class="text-muted small mb-3">
                            <i class="fa-solid fa-folder me-1"></i> <?= $c['cat_name'] ?? 'Chưa có danh mục' ?> | 
                            <i class="fa-solid fa-chalkboard-teacher me-1"></i> <?= $c['instructor_name'] ?? 'Chưa có giảng viên' ?>
                        </p>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <?php if($c['discount_price']): ?>
                                    <div>
                                        <del class="text-muted small"><?= number_format($c['price']) ?>₫</del>
                                        <span class="text-danger fs-4 fw-bold ms-2"><?= number_format($c['discount_price']) ?>₫</span>
                                    </div>
                                <?php else: ?>
                                    <span class="fs-4 fw-bold text-success"><?= number_format($c['price']) ?>₫</span>
                                <?php endif; ?>
                                
                                <span class="badge <?= $c['is_published'] ? 'bg-success' : 'bg-warning text-dark' ?> fs-6 px-3 py-2">
                                    <?= $c['is_published'] ? 'Đã đăng' : 'Nháp' ?>
                                </span>
                            </div>

                            <div class="btn-group w-100" role="group">
                                <a href="edit.php?id=<?= $c['id'] ?>" class="btn btn-warning flex-fill">
                                    <i class="fa-solid fa-edit"></i> Sửa
                                </a>
                                <a href="delete.php?id=<?= $c['id'] ?>" class="btn btn-danger flex-fill" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa khóa học này? Hành động này không thể hoàn tác!')">
                                    <i class="fa-solid fa-trash"></i> Xóa
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
    transform: translateY(-12px);
    transition: all 0.4s ease;
    box-shadow: 0 25px 50px rgba(0,0,0,0.2) !important;
}
.card-title { min-height: 60px; }
</style>

<?php require_once '../includes/footer.php'; ?>