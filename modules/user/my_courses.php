<?php require_once '../../init.php'; ?>
<?php 
if (!is_logged_in()) header("Location: http://localhost:3000/index.php?mod=auth&act=login");
$user_id = $_SESSION['user']['id'];
$base_url = "http://localhost:3000";

$stmt = $pdo->prepare("
    SELECT DISTINCT c.* FROM courses c
    JOIN order_details od ON c.id = od.course_id
    JOIN orders o ON od.order_id = o.id
    WHERE o.user_id = ? AND o.status = 'completed' AND c.is_deleted = 0
    ORDER BY c.created_at DESC
");
$stmt->execute([$user_id]);
$courses = $stmt->fetchAll();
?>
<?php require_once '../../includes/header.php'; ?>

<div class="container py-5">
    <h2 class="mb-4"><i class="fas fa-graduation-cap"></i> Khóa học của tôi (<?= count($courses) ?>)</h2>

    <?php if (empty($courses)): ?>
        <div class="text-center py-5">
            <i class="fas fa-book-open fa-5x text-muted mb-4"></i>
            <h4 class="text-muted">Bạn chưa sở hữu khóa học nào</h4>
            <a href="<?= $base_url ?>/index.php" class="btn btn-primary btn-lg mt-3">Mua ngay</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach($courses as $c): ?>
            <div class="col-xl-4 col-lg-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <img src="<?= $base_url ?>/<?= $c['thumbnail'] ?? 'assets/img/no-image.jpg' ?>" class="card-img-top" style="height:200px;object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold"><?= htmlspecialchars($c['title']) ?></h5>
                        <p class="text-muted small flex-grow-1"><?= htmlspecialchars(mb_substr(strip_tags($c['description']), 0, 100)) ?>...</p>
                        <a href="#" class="btn btn-primary mt-auto">
                            <i class="fas fa-play-circle"></i> Vào học ngay
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.hover-lift:hover { transform: translateY(-10px); transition: 0.3s; box-shadow: 0 20px 40px rgba(0,0,0,0.15)!important; }
</style>

<?php require_once '../../includes/footer.php'; ?>