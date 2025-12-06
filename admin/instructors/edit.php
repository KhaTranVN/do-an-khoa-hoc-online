<?php require_once '../includes/header.php'; 

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM instructors WHERE id = ?");
$stmt->execute([$id]);
$instructor = $stmt->fetch();

if (!$instructor) {
    $_SESSION['error'] = "Giảng viên không tồn tại!";
    redirect('index.php');
}
?>

<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-edit"></i> Sửa giảng viên</h2>

    <div class="card border-0 shadow-lg">
        <div class="card-body p-5">
            <form method="POST" action="update.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $instructor['id'] ?>">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Họ tên</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($instructor['name']) ?>" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Mô tả</label>
                            <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($instructor['description'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="<?= $instructor['avatar'] ? '../../' . $instructor['avatar'] : '../../assets/img/no-avatar.jpg' ?>" 
                             class="rounded-circle mb-3" style="width:150px;height:150px;object-fit:cover;">
                        <div>
                            <label class="form-label fw-bold">Đổi ảnh</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="text-end mt-4">
                    <a href="index.php" class="btn btn-secondary btn-lg me-3">Hủy</a>
                    <button type="submit" class="btn btn-warning btn-lg px-5">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>