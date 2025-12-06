<?php require_once '../includes/header.php'; 

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    $_SESSION['error'] = "User không tồn tại!";
    redirect('index.php');
}
?>

<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-user-edit"></i> Sửa thông tin người dùng</h2>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <form method="POST" action="update.php">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Username</label>
                                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Họ tên</label>
                                <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname'] ?? '') ?>" class="form-control form-control-lg">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Số điện thoại</label>
                                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" class="form-control form-control-lg">
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <a href="index.php" class="btn btn-secondary btn-lg me-3">Hủy</a>
                            <button type="submit" class="btn btn-primary btn-lg">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>