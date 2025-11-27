<?php require_once dirname(__DIR__, 2) . '/init.php'; ?>
<?php $title = "Trang chủ"; ?>
<?php require_once dirname(__DIR__, 2) . '/includes/header.php'; ?>

<!-- Slider -->
<div class="owl-carousel owl-theme mb-5">
    <div class  class="item">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2000" class="w-100" alt="Học lập trình">
        <div class="carousel-caption d-none d-md-block">
            <h1 class="display-4 fw-bold">Học Lập Trình Cùng Chuyên Gia</h1>
            <p class="lead">Hàng trăm khóa học chất lượng cao – Giá chỉ từ 199k</p>
            <a href="index.php?mod=course&act=list" class="btn btn-warning btn-lg">Xem tất cả khóa học</a>
        </div>
    </div>
</div>

<!-- Danh sách khóa học nổi bật -->
<h2 class="mb-4">Khóa học mới nhất</h2>
<?php
// Lấy khóa học (sẽ lỗi nhẹ vì chưa có dữ liệu, nhưng không sao)
$stmt = $pdo->query("SELECT c.*, cat.name as cat_name, i.name as instructor_name 
                     FROM courses c 
                     LEFT JOIN categories cat ON c.category_id = cat.id 
                     LEFT JOIN instructors i ON c.instructor_id = i.id 
                     WHERE c.is_published = 1 AND c.is_deleted = 0 
                     ORDER BY c.id DESC LIMIT 8");
$courses = $stmt->fetchAll();
?>

<div class="row">
    <?php if(empty($courses)): ?>
        <div class="col-12 text-center py-5">
            <p class="text-muted">Chưa có khóa học nào. Vào <a href="admin/">Admin</a> để thêm nhé!</p>
        </div>
    <?php else: ?>
        <?php foreach($courses as $c): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100 card-course shadow-sm">
                <img src="<?= $c['thumbnail'] ?: 'https://via.placeholder.com/300x200?text=No+Image' ?>" class="card-img-top" alt="<?= htmlspecialchars($c['title']) ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($c['title']) ?></h5>
                    <p class="text-muted small">
                        Giảng viên: <?= $c['instructor_name'] ?? 'Chưa có' ?>
                    </p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <?php if($c['discount_price']): ?>
                                    <del class="text-muted"><?= number_format($c['price']) ?>₫</del>
                                    <span class="text-danger fw-bold fs-5"><?= number_format($c['discount_price']) ?>₫</span>
                                <?php else: ?>
                                    <span class="fw-bold fs-5"><?= number_format($c['price'] ?: 0) ?>₫</span>
                                <?php endif; ?>
                            </div>
                            <a href="index.php?mod=course&act=detail&id=<?= $c['id'] ?>" class="btn btn-sm btn-buy">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
$(document).ready(function(){
    $(".owl-carousel").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        nav: true,
        dots: true,
        navText: ['<i class="fas fa-chevron-left fa-2x"></i>','<i class="fas fa-chevron-right fa-2x"></i>']
    });
});
</script>

<?php require_once dirname(__DIR__, 2) . '/includes/footer.php'; ?>
<!-- ĐÚNG RỒI! DÙNG dirname(__DIR__, 2) ĐỂ NHẢY LÊN GỐC -->