<?php require_once '../../init.php'; ?>
<?php 
$base_url = "http://localhost:3000";

// Phân trang
$page = max(1, $_GET['page'] ?? 1);
$per_page = 9;
$offset = ($page - 1) * $per_page;

$total = $pdo->query("SELECT COUNT(*) FROM news WHERE is_deleted = 0")->fetchColumn();
$total_pages = ceil($total / $per_page);

// FIX LỖI SQL 1064 – DÙNG bindValue + PARAM_INT
$stmt = $pdo->prepare("SELECT * FROM news WHERE is_deleted = 0 ORDER BY created_at DESC LIMIT ? OFFSET ?");
$stmt->bindValue(1, $per_page, PDO::PARAM_INT);
$stmt->bindValue(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$news_list = $stmt->fetchAll();
?>
<?php require_once '../../includes/header.php'; ?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">
            Tin tức & Blog
        </h1>
        <p class="lead text-muted">Cập nhật kiến thức công nghệ, kinh nghiệm học tập và cơ hội việc làm</p>
    </div>

    <?php if(empty($news_list)): ?>
        <div class="text-center py-5">
            <i class="fas fa-newspaper fa-5x text-muted mb-4"></i>
            <h4 class="text-muted">Chưa có tin tức nào</h4>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach($news_list as $item): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift rounded-4 overflow-hidden">
                    <img src="<?= $base_url ?>/<?= $item['image'] ?? 'assets/img/news-default.jpg' ?>" 
                         class="card-img-top" style="height:220px;object-fit:cover;">
                    <div class="card-body d-flex flex-column p-4">
                        <div class="text-muted small mb-2">
                            <?= date('d/m/Y', strtotime($item['created_at'])) ?>
                        </div>
                        <h5 class="card-title fw-bold">
                            <a href="<?= $base_url ?>/modules/news/detail.php?id=<?= $item['id'] ?>" 
                               class="text-decoration-none text-dark stretched-link">
                                <?= htmlspecialchars($item['title']) ?>
                            </a>
                        </h5>
                        <p class="text-muted small flex-grow-1">
                            <?= htmlspecialchars(mb_substr(strip_tags($item['content']), 0, 120)) ?>...
                        </p>
                        <a href="<?= $base_url ?>/modules/news/detail.php?id=<?= $item['id'] ?>" 
                           class="btn btn-outline-primary btn-sm mt-3">
                            Đọc thêm
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Phân trang -->
        <?php if($total_pages > 1): ?>
        <nav class="mt-5">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page-1 ?>">&laquo; Trước</a>
                </li>
                <?php for($i = max(1, $page-2); $i <= min($total_pages,$page+2); $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page+1 ?>">Sau &raquo;</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<style>
.hover-lift:hover {
    transform: translateY(-10px);
    transition: all 0.3s ease;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}
.card-title a:hover { color: #667eea !important; }
</style>

<?php require_once '../../includes/footer.php'; ?>