<?php require_once '../../init.php'; ?>
<?php 
$base_url = "http://localhost:3000";

// === LỌC & TÌM KIẾM ===
$category_id = $_GET['cat'] ?? '';
$search = trim($_GET['s'] ?? '');
$sort = $_GET['sort'] ?? 'newest';

// Build query
$sql = "SELECT c.*, i.name as instructor_name, cat.name as cat_name 
        FROM courses c 
        LEFT JOIN instructors i ON c.instructor_id = i.id
        LEFT JOIN categories cat ON c.category_id = cat.id
        WHERE c.is_published = 1 AND c.is_deleted = 0";
$params = [];

if ($category_id) {
    $sql .= " AND c.category_id = ?";
    $params[] = $category_id;
}
if ($search) {
    $sql .= " AND c.title LIKE ?";
    $params[] = "%$search%";
}

// Sort
switch ($sort) {
    case 'price_asc': $sql .= " ORDER BY COALESCE(c.discount_price, c.price) ASC"; break;
    case 'price_desc': $sql .= " ORDER BY COALESCE(c.discount_price, c.price) DESC"; break;
    case 'popular': $sql .= " ORDER BY c.views DESC"; break;
    default: $sql .= " ORDER BY c.created_at DESC";
}

// Phân trang
$page = max(1, (int)($_GET['page'] ?? 1));
$per_page = 12;
$offset = ($page - 1) * $per_page;

// Tổng số
$count_stmt = $pdo->prepare(str_replace('c.*, i.name as instructor_name, cat.name as cat_name', 'COUNT(*)', $sql));
$count_stmt->execute($params);
$total = $count_stmt->fetchColumn();
$total_pages = ceil($total / $per_page);

// Lấy dữ liệu
$sql .= " LIMIT ? OFFSET ?";
$params[] = $per_page;
$params[] = $offset;

$stmt = $pdo->prepare($sql);
foreach ($params as $i => $param) {
    $stmt->bindValue($i + 1, $param, is_int($param) ? PDO::PARAM_INT : PDO::PARAM_STR);
}
$stmt->execute();
$courses = $stmt->fetchAll();

// Danh mục
$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll();
?>
<?php require_once '../../includes/header.php'; ?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">Tất cả khóa học</h1>
        <p class="lead text-muted">Khám phá hơn 100+ khóa học chất lượng cao từ chuyên gia hàng đầu</p>
    </div>

    <!-- Bộ lọc -->
    <div class="card border-0 shadow-sm mb-5 p-4 rounded-4">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-lg-4 col-md-6">
                <input type="text" name="s" value="<?= htmlspecialchars($search) ?>" class="form-control form-control-lg" placeholder="Tìm kiếm khóa học...">
            </div>
            <div class="col-lg-3 col-md-6">
                <select name="cat" class="form-select form-select-lg">
                    <option value="">Tất cả danh mục</option>
                    <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $category_id == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-3 col-md-6">
                <select name="sort" class="form-select form-select-lg">
                    <option value="newest" <?= $sort=='newest'?'selected':'' ?>>Mới nhất</option>
                    <option value="price_asc" <?= $sort=='price_asc'?'selected':'' ?>>Giá thấp → cao</option>
                    <option value="price_desc" <?= $sort=='price_desc'?'selected':'' ?>>Giá cao → thấp</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-12">
                <button type="submit" class="btn btn-primary btn-lg w-100">Lọc</button>
            </div>
        </form>
    </div>

    <!-- Danh sách khóa học -->
    <?php if(empty($courses)): ?>
        <div class="text-center py-5">
            <i class="fas fa-search fa-5x text-muted mb-4"></i>
            <h4 class="text-muted">Không tìm thấy khóa học nào</h4>
            <a href="<?= $base_url ?>/modules/courses" class="btn btn-primary btn-lg mt-3">Xem tất cả</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach($courses as $c): ?>
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift rounded-4 overflow-hidden">
                    <div class="position-relative">
                        <img src="<?= $base_url ?>/<?= $c['thumbnail'] ?? 'assets/img/no-image.jpg' ?>" 
                             class="card-img-top" style="height:220px;object-fit:cover;">
                        <?php if($c['discount_price']): ?>
                        <div class="position-absolute top-0 start-0 m-3">
                            <span class="badge bg-danger fs-6">
                                -<?= round(100 - ($c['discount_price']/$c['price']*100)) ?>%
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title fw-bold mb-3">
                            <?= htmlspecialchars($c['title']) ?>
                        </h5>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-user-tie"></i> <?= htmlspecialchars($c['instructor_name'] ?? 'Chưa có') ?>
                        </p>
                        <p class="text-muted small mb-4">
                            <i class="fas fa-folder"></i> <?= htmlspecialchars($c['cat_name'] ?? 'Chưa phân loại') ?>
                        </p>

                        <div class="mt-auto">
                            <?php if($c['discount_price']): ?>
                                <del class="text-muted small"><?= number_format($c['price']) ?>đ</del>
                                <div class="text-danger fw-bold fs-4"><?= number_format($c['discount_price']) ?>đ</div>
                            <?php else: ?>
                                <div class="text-primary fw-bold fs-4"><?= number_format($c['price']) ?>đ</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- 2 NÚT RÕ RÀNG, ĐẸP LUNG LINH -->
                    <div class="card-footer bg-white border-0 p-3">
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="<?= $base_url ?>/modules/courses/detail.php?id=<?= $c['id'] ?>" 
                                   class="btn btn-outline-primary w-100">
                                    <i class="fas fa-eye"></i> Xem chi tiết
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?= $base_url ?>/modules/cart/add.php?id=<?= $c['id'] ?>" 
                                   class="btn btn-success w-100 shadow">
                                    <i class="fas fa-cart-plus"></i> Thêm giỏ
                                </a>
                            </div>
                        </div>
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
                    <a class="page-link" href="?page=<?= $page-1 ?>&s=<?= urlencode($search) ?>&cat=<?= $category_id ?>&sort=<?= $sort ?>">&laquo;</a>
                </li>
                <?php for($i = max(1, $page-2); $i <= min($total_pages, $page+2); $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&s=<?= urlencode($search) ?>&cat=<?= $category_id ?>&sort=<?= $sort ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page+1 ?>&s=<?= urlencode($search) ?>&cat=<?= $category_id ?>&sort=<?= $sort ?>">»</a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<style>
.hover-lift:hover {
    transform: translateY(-12px);
    transition: all 0.4s ease;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}
.card-title { min-height: 60px; }
</style>

<?php require_once '../../includes/footer.php'; ?>