<?php require_once '../../init.php'; ?>
<?php 
$base_url = "http://localhost:3000";
$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ? AND is_deleted = 0");
$stmt->execute([$id]);
$news = $stmt->fetch();

if (!$news) {
    $_SESSION['error'] = "Tin tức không tồn tại!";
    header("Location: index.php");
    exit();
}
?>
<?php require_once '../../includes/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <img src="<?= $base_url ?>/<?= $news['image'] ?? 'assets/img/news-default.jpg' ?>" 
                     class="card-img-top" style="height:500px;object-fit:cover;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h1 class="display-5 fw-bold"><?= htmlspecialchars($news['title']) ?></h1>
                        <div class="text-muted small">
                            <i class="fas fa-calendar"></i> <?= date('d/m/Y H:i', strtotime($news['created_at'])) ?>
                        </div>
                    </div>
                    <hr>
                    <div class="news-content fs-5 lh-lg">
                        <?= $news['content'] ?>
                    </div>
                    <div class="text-center mt-5">
                        <a href="<?= $base_url ?>/modules/news/index.php" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-arrow-left"></i> Quay lại tin tức
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.news-content img { 
    max-width: 100%; 
    border-radius: 12px; 
    box-shadow: 0 8px 25px rgba(0,0,0,0.1); 
    margin: 20px 0;
}
.news-content h2, .news-content h3 { color: #667eea; margin-top: 2rem; }
</style>

<?php require_once '../../includes/footer.php'; ?>