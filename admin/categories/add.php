<?php require_once '../includes/header.php'; ?>

<div class="card shadow-lg border-0">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="fas fa-plus"></i> Thêm danh mục mới</h4>
    </div>
    <div class="card-body p-5">
        <form method="POST" action="store.php">
            <div class="mb-4">
                <label class="form-label fw-bold">Tên danh mục</label>
                <input type="text" name="name" class="form-control form-control-lg" required placeholder="Ví dụ: Lập trình Web">
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="index.php" class="btn btn-secondary btn-lg me-md-3">Hủy</a>
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-save"></i> Thêm ngay
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>