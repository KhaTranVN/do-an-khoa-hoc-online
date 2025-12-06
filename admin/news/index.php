<?php require_once '../includes/header.php'; ?>

<?php
$stmt = $pdo->query("SELECT * FROM news WHERE is_deleted = 0 ORDER BY id DESC");
$news = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-newspaper"></i> Quản lý Tin tức</h2>
        <a href="add.php" class="btn btn-success btn-lg">
            <i class="fas fa-plus"></i> Viết bài mới
        </a>
    </div>

    <?php if (empty($news)): ?>
        <div class="card border-0 shadow-lg">
            <div class="card-body text-center py-5">
                <i class="fas fa-newspaper fa-5x text-muted mb-4"></i>
                <h4 class="text-muted">Chưa có tin tức nào</h4>
                <p class="text-muted">Hãy bấm nút <strong>"Viết bài mới"</strong> để bắt đầu!</p>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach($news as $n): ?>
            <div class="col-xl-4 col-lg-6">
                <div class="card border-0 shadow-lg h-100 hover-lift">
                    <?php if($n['image']): ?>
                        <img src="../../<?= $n['image'] ?>" class="card-img-top" style="height:200px; object-fit:cover;">
                    <?php else: ?>
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold"><?= htmlspecialchars($n['title']) ?></h5>
                        <p class="text-muted small">
                            <i class="fas fa-calendar"></i> <?= date('d/m/Y H:i', strtotime($n['created_at'])) ?>
                        </p>
                        <p class="flex-grow-1"><?= htmlspecialchars(mb_substr(strip_tags($n['content']), 0, 120)) ?>...</p>
                        <div class="mt-auto">
                            <div class="btn-group w-100">
                                <a href="edit.php?id=<?= $n['id'] ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="delete.php?id=<?= $n['id'] ?>" class="btn btn-danger" 
                                   onclick="return confirm('Xóa tin tức này?')">
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
.hover-lift:hover { transform: translateY(-10px); transition: all 0.3s ease; box-shadow: 0 20px 40px rgba(0,0,0,0.15)!important; }
</style>

<?php require_once '../includes/footer.php'; ?>