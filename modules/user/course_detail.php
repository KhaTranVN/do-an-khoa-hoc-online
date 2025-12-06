<?php require_once '../../init.php'; ?>
<?php 
if (!is_logged_in()) header("Location: http://localhost:3000/auth/login");

$user_id = $_SESSION['user']['id'];
$course_id = $_GET['id'] ?? 0;
$base_url = "http://localhost:3000";

// Kiểm tra user có quyền xem khóa học này không
$stmt = $pdo->prepare("
    SELECT c.*, i.name as instructor_name, i.description as instructor_desc, i.avatar as instructor_avatar
    FROM courses c
    LEFT JOIN instructors i ON c.instructor_id = i.id
    JOIN order_details od ON c.id = od.course_id
    JOIN orders o ON od.order_id = o.id
    WHERE c.id = ? AND o.user_id = ? AND o.status = 'completed' AND c.is_deleted = 0
");
$stmt->execute([$course_id, $user_id]);
$course = $stmt->fetch();

if (!$course) {
    $_SESSION['error'] = "Bạn chưa sở hữu khóa học này hoặc khóa học không tồn tại!";
    header("Location: my_courses.php");
    exit();
}
?>
<?php require_once '../../includes/header.php'; ?>

<div class="container py-5">
    <div class="row g-5">
        <!-- Nội dung chính -->
        <div class="col-lg-8">
            <!-- Thumbnail + Tiêu đề -->
            <div class="card border-0 shadow-lg mb-4 overflow-hidden rounded-4">
                <img src="<?= $base_url ?>/<?= $course['thumbnail'] ?? 'assets/img/no-image.jpg' ?>" 
                     class="card-img-top" style="height:450px;object-fit:cover;">
                <div class="card-body p-5">
                    <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($course['title']) ?></h1>
                    <div class="d-flex align-items-center gap-4 text-muted mb-4">
                        <div><i class="fas fa-chalkboard-teacher text-primary"></i> <strong>Giảng viên:</strong> 
                            <?= htmlspecialchars($course['instructor_name'] ?? 'Chưa có') ?>
                        </div>
                        <div><i class="fas fa-calendar-alt text-success"></i> 
                            <?= date('d/m/Y', strtotime($course['created_at'])) ?>
                        </div>
                    </div>

                    <!-- Mô tả ngắn -->
                    <div class="bg-light p-4 rounded-3 mb-4">
                        <h4 class="text-primary"><i class="fas fa-info-circle"></i> Giới thiệu khóa học</h4>
                        <p class="lead"><?= nl2br(htmlspecialchars($course['description'] ?? 'Chưa có mô tả')) ?></p>
                    </div>

                    <!-- Nội dung chi tiết -->
                    <div class="bg-white p-4 rounded-3 border">
                        <h4 class="text-success mb-4"><i class="fas fa-play-circle"></i> Nội dung chi tiết</h4>
                        <div class="course-content">
                            <?= $course['content'] ? $course['content'] : '<p class="text-muted">Nội dung đang được cập nhật...</p>' ?>
                        </div>
                    </div>

                    <!-- Nút hành động -->
                    <div class="text-center mt-5">
                        <button class="btn btn-success btn-lg px-5 shadow-lg">
                            <i class="fas fa-play-circle fa-2x align-middle"></i> 
                            <span class="align-middle ms-2">Bắt đầu học ngay</span>
                        </button>
                        <a href="<?= $base_url ?>/modules/user/my_courses.php" class="btn btn-outline-secondary btn-lg ms-3">
                            <i class="fas fa-arrow-left"></i> Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar bên phải -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg sticky-top" style="top: 100px;">
                <div class="card-body p-4 text-center">
                    <!-- Giảng viên -->
                    <img src="<?= $course['instructor_avatar'] ? $base_url . '/' . $course['instructor_avatar'] : $base_url . '/assets/img/default-avatar.png' ?>" 
                         class="rounded-circle shadow mb-3" style="width:120px;height:120px;object-fit:cover;">
                    <h5 class="fw-bold"><?= htmlspecialchars($course['instructor_name'] ?? 'Chưa có') ?></h5>
                    <p class="text-muted small"><?= htmlspecialchars($course['instructor_desc'] ?? 'Giảng viên chuyên nghiệp') ?></p>
                    <hr>

                    <!-- Thông tin khóa học -->
                    <div class="text-start">
                        <div class="d-flex justify-content-between py-2">
                            <span><i class="fas fa-clock text-info"></i> Thời lượng</span>
                            <strong>Đang cập nhật</strong>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span><i class="fas fa-play-circle text-success"></i> Bài học</span>
                            <strong>Đang cập nhật</strong>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span><i class="fas fa-users text-primary"></i> Học viên</span>
                            <strong>Đang cập nhật</strong>
                        </div>
                    </div>
                    <hr>

                    <!-- Thông báo sở hữu -->
                    <div class="bg-success text-white p-4 rounded-3">
                        <i class="fas fa-check-circle fa-3x mb-3"></i>
                        <h5>Bạn đã sở hữu khóa học này</h5>
                        <p class="mb-0">Học thoải mái – Vĩnh viễn!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.course-content img { max-width: 100%; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.btn-success:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(25,135,84,0.4) !important; }
</style>

<?php require_once '../../includes/footer.php'; ?>