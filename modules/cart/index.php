<?php require_once '../../init.php'; ?>
<?php 
if (!is_logged_in()) header("Location: http://localhost:3000/auth/login");
$base_url = "http://localhost:3000";

$total = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
}
?>
<?php require_once '../../includes/header.php'; ?>

<div class="container py-5 min-vh-100">
    <h1 class="mb-3xl mb-5 text-center fw-bold">Giỏ hàng của bạn</h1>

    <?php if(empty($_SESSION['cart'])): ?>
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
            <h4 class="text-muted">Giỏ hàng trống</h4>
            <a href="<?= $base_url ?>/modules/courses" class="btn btn-primary btn-lg mt-3">
                Tiếp tục mua sắm
            </a>
        </div>
    <?php else: ?>
        <div class="row g-5">
            <!-- Danh sách sản phẩm -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-4">
                        <?php foreach($_SESSION['cart'] as $id => $item): 
                            $stmt = $pdo->prepare("SELECT title, thumbnail FROM courses WHERE id = ?");
                            $stmt->execute([$id]);
                            $c = $stmt->fetch();
                        ?>
                        <div class="row align-items-center mb-4 pb-4 border-bottom">
                            <div class="col-3 col-md-2">
                                <img src="<?= $base_url ?>/<?= $c['thumbnail'] ?? 'assets/img/no-image.jpg' ?>" 
                                     class="img-fluid rounded shadow-sm" style="height:100px;object-fit:cover;">
                            </div>
                            <div class="col-5 col-md-4">
                                <h5 class="mb-1"><?= htmlspecialchars($item['title']) ?></h5>
                            </div>
                            <div class="col-2 text-center">
                                <strong class="text-danger fs-5"><?= number_format($item['price']) ?>đ</strong>
                            </div>
                            <div class="col-2 col-md-2">
                                <!-- SỬA SỐ LƯỢNG -->
                                <form action="<?= $base_url ?>/modules/cart/update.php" method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="99"
                                           class="form-control form-control-sm text-center" style="width:70px;"
                                           onchange="this.form.submit()">
                                </form>
                            </div>
                            <div class="col-2 col-md-1 text-end">
                                <!-- XÓA KHỎI GIỎ -->
                                <a href="<?= $base_url ?>/modules/cart/remove.php?id=<?= $id ?>" 
                                   class="text-danger fs-4" onclick="return confirm('Xóa khỏi giỏ hàng?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Tổng tiền + Thanh toán -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-lg rounded-4 sticky-top" style="top:100px;">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Tóm tắt đơn hàng</h3>
                        <div class="d-flex justify-content-between mb-3 fs-5">
                            <span>Tạm tính</span>
                            <strong><?= number_format($total) ?>đ</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <h4 class="text-primary"><?= number_format($total) ?>đ</h4>
                        </div>

                        <!-- NÚT THANH TOÁN SIÊU ĐẸP -->
                        <a href="<?= $base_url ?>/modules/checkout" class="btn btn-success btn-lg w-100 shadow-lg py-3 fs-5">
                            <i class="fas fa-credit-card"></i> Thanh toán ngay
                        </a>

                        <a href="<?= $base_url ?>/modules/courses" class="btn btn-outline-secondary btn-lg w-100 mt-3">
                            Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>