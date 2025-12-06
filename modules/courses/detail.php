<?php require_once '../../init.php'; ?>
<?php 
$base_url = "http://localhost:3000";
$id = $_GET['id'] ?? 0;

if ($id <= 0) {
    $_SESSION['error'] = "Khóa học không hợp lệ!";
    header("Location: index.php");
    exit();
}

// LẤY KHÓA HỌC – ĐÃ SỬA LỖI CÚ PHÁP 100%
$stmt = $pdo->prepare("
    SELECT c.*, 
           i.name as instructor_name, 
           i.description as instructor_desc, 
           i.avatar as instructor_avatar,
           cat.name as category_name,
           COALESCE(c.views, 0) as views_count
    FROM courses c
    LEFT JOIN instructors i ON c.instructor_id = i.id
    LEFT JOIN categories cat ON c.category_id = cat.id
    WHERE c.id = ? AND c.is_published = 1 AND c.is_deleted = 0
");
$stmt->execute([$id]);
$course = $stmt->fetch();

if (!$course) {
    $_SESSION['error'] = "Khóa học không tồn tại hoặc chưa được công khai!";
    header("Location: index.php");
    exit();
}

// Tăng lượt xem (an toàn)
try {
    $pdo->prepare("UPDATE courses SET views = COALESCE(views, 0) + 1 WHERE id = ?")->execute([$id]);
} catch (Exception $e) {
    // Nếu chưa có cột views → bỏ qua
}
?>
<?php require_once '../../includes/header.php'; ?>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <img src="<?= $base_url ?>/<?= $course['thumbnail'] ?? 'assets/img/no-image.jpg' ?>" 
                     class="card-img-top" style="height:500px;object-fit:cover;">

                <div class="card-body p-5">
                    <h1 class="display-5 fw-bold mb-4"><?= htmlspecialchars($course['title']) ?></h1>
                    
                    <div class="d-flex flex-wrap gap-4 text-muted mb-4 fs-5">
                        <div>Giảng viên: <strong><?= htmlspecialchars($course['instructor_name'] ?? 'Chưa có') ?></strong></div>
                        <div>Danh mục: <?= htmlspecialchars($course['category_name'] ?? 'Chưa phân loại') ?></div>
                        <div>Lượt xem: <?= number_format($course['views_count'] + 1) ?></div>
                        <div>Ngày đăng: <?= date('d/m/Y', strtotime($course['created_at'])) ?></div>
                    </div>

                    <!-- Giá tiền -->
                    <div class="bg-light p-4 rounded-4 mb-5 text-center">
                        <?php if($course['discount_price']): ?>
                            <del class="text-muted fs-3"><?= number_format($course['price']) ?>đ</del>
                            <div class="text-danger display-4 fw-bold"><?= number_format($course['discount_price']) ?>đ</div>
                            <span class="badge bg-danger fs-5">
                                GIẢM <?= round(100 - round($course['discount_price'])/$course['price']*100) ?>%
                            </span>
                        <?php else: ?>
                            <div class="text-primary display-4 fw-bold"><?= number_format($course['price']) ?>đ</div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-5">
                        <h3 class="text-primary mb-3">Giới thiệu khóa học</h3>
                        <p class="lead fs-4"><?= nl2br(htmlspecialchars($course['description'] ?? 'Chưa có mô tả')) ?></p>
                    </div>

                    <div class="border-start border-4 border-primary ps-4">
                        <h3 class="text-success mb-4">Nội dung chi tiết</h3>
                        <div class="course-content fs-5 lh-lg">
                            <?= $course['content'] ?: '<p class="text-muted">Nội dung đang được cập nhật...</p>' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg sticky-top rounded-4" style="top:100px;">
                <div class="card-body p-4 text-center">
                    <img src="<?= $course['instructor_avatar'] ? $base_url . '/' . $course['instructor_avatar'] : $base_url . '/assets/img/default-avatar.png' ?>" 
                         class="rounded-circle shadow mb-3" style="width:120px;height:120px;object-fit:cover;">
                    <h5 class="fw-bold"><?= htmlspecialchars($course['instructor_name'] ?? 'Chưa có') ?></h5>
                    <p class="text-muted small"><?= htmlspecialchars($course['instructor_desc'] ?? 'Chuyên gia hàng đầu') ?></p>
                    <hr>

                    <a href="<?= $base_url ?>/modules/cart/add.php?id=<?= $course['id'] ?>" 
                       class="btn btn-success btn-lg w-100 shadow-lg mb-3">
                        Thêm vào giỏ hàng
                    </a>

                    <a href="<?= $base_url ?>/modules/courses" class="btn btn-outline-secondary btn-lg w-100">
                        Quay lại danh sách
                    </a>

                    <div class="mt-4 p-3 bg-light rounded">
                        <small class="text-success">
                            Cam kết hoàn tiền 100% nếu không hài lòng trong 7 ngày
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>