<?php require_once '../../init.php'; ?>
<?php 
if (!is_logged_in()) header("Location: http://localhost:3000/index.php?mod=auth&act=login");
$user = $_SESSION['user'];
$base_url = "http://localhost:3000";
?>
<?php require_once '../../includes/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- HEADER GRADIENT ĐẸP LUNG LINH – ĐÃ SỬA LỖI 100% -->
                <div class="card-header text-white text-center py-5 position-relative overflow-hidden" 
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); background-size: 200% 200%; animation: gradient 8s ease infinite;">
                    <div class="position-relative z-index-2">
                        <img src="<?= $user['avatar'] ?? $base_url . '/assets/img/default-avatar.png' ?>" 
                             class="rounded-circle shadow-lg border border-5 border-white mb-4" 
                             style="width:140px;height:140px;object-fit:cover;">
                        <h2 class="mb-0">Chỉnh sửa hồ sơ</h2>
                        <p class="mb-0 opacity-90 fs-5">@<?= htmlspecialchars($user['username']) ?></p>
                    </div>
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                        <i class="fas fa-user-edit fa-6x"></i>
                    </div>
                </div>

                <!-- FORM CHỈNH SỬA -->
                <div class="card-body p-5 p-lg-6">
                    <form method="POST" action="<?= $base_url ?>/modules/user/update.php" enctype="multipart/form-data">
                        <!-- Upload Avatar -->
                        <div class="text-center mb-5">
                            <div class="position-relative d-inline-block">
                                <img src="<?= $user['avatar'] ?? $base_url . '/assets/img/default-avatar.png' ?>" 
                                     id="preview-avatar"
                                     class="rounded-circle shadow-lg border border-4 border-white" 
                                     style="width:160px;height:160px;object-fit:cover;cursor:pointer;">
                                <label for="avatar-input" class="btn btn-primary rounded-circle position-absolute bottom-0 end-0 shadow" 
                                       style="width:50px;height:50px;cursor:pointer;" title="Đổi ảnh đại diện">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" name="avatar" id="avatar-input" class="d-none" accept="image/*" 
                                       onchange="previewImage(event)">
                            </div>
                            <p class="mt-3 text-muted">Click vào ảnh để thay đổi</p>
                        </div>

                        <div class="row g-4">
                            <!-- Họ tên -->
                            <div class="col-12">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname'] ?? '') ?>" 
                                           class="form-control" placeholder="Ví dụ: Nguyễn Văn A">
                                </div>
                            </div>

                            <!-- Số điện thoại -->
                            <div class="col-12">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" 
                                           class="form-control" placeholder="0901234567">
                                </div>
                            </div>

                            <!-- Email (không cho sửa) -->
                            <div class="col-12">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" value="<?= htmlspecialchars($user['email']) ?>" 
                                           class="form-control bg-light" disabled>
                                </div>
                                <small class="text-muted">Email không thể thay đổi</small>
                            </div>
                        </div>

                        <!-- Nút hành động -->
                        <div class="text-center mt-5">
                            <a href="<?= $base_url ?>/modules/user/profile.php" class="btn btn-light btn-lg px-5 me-3">
                                <i class="fas fa-arrow-left"></i> Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                                <i class="fas fa-save"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
#preview-avatar {
    transition: all 0.3s ease;
}
#preview-avatar:hover {
    transform: scale(1.05);
}
</style>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('preview-avatar').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<?php require_once '../../includes/footer.php'; ?>