<?php require_once '../../init.php'; ?>
<?php 
if (!is_logged_in()) header("Location: http://localhost:3000/auth/login");
$user = $_SESSION['user'];
$base_url = "http://localhost:3000";
?>
<?php require_once '../../includes/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header text-white text-center py-5" 
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <img src="<?= $user['avatar'] ?? $base_url . '/assets/img/default-avatar.png' ?>" 
                         class="rounded-circle shadow-lg border border-5 border-white mb-4" 
                         style="width:150px;height:150px;object-fit:cover;">
                    <h2 class="mb-1"><?= htmlspecialchars($user['fullname'] ?? $user['username']) ?></h2>
                    <p class="mb-0 opacity-90 fs-5">@<?= htmlspecialchars($user['username']) ?></p>
                </div>

                <div class="card-body p-5">
                    <div class="row g-4 text-center text-md-start">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-envelope fa-2x text-primary"></i>
                                <div>
                                    <strong>Email</strong><br>
                                    <?= htmlspecialchars($user['email']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-phone fa-2x text-success"></i>
                                <div>
                                    <strong>Điện thoại</strong><br>
                                    <?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-calendar-alt fa-2x text-info"></i>
                                <div>
                                    <strong>Tham gia</strong><br>
                                    <?= isset($user['created_at']) ? date('d/m/Y', strtotime($user['created_at'])) : 'Chưa xác định' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <i class="fas fa-user-shield fa-2x text-warning"></i>
                                <div>
                                    <strong>Quyền</strong><br>
                                    <span class="badge bg-success fs-6">Thành viên</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <a href="<?= $base_url ?>/modules/user/edit.php" class="btn btn-warning btn-lg px-5 me-3">
                            <i class="fas fa-edit"></i> Chỉnh sửa hồ sơ
                        </a>
                        <a href="<?= $base_url ?>/modules/user/orders.php" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-history"></i> Lịch sử mua hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>