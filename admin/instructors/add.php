<?php require_once '../includes/header.php'; ?>

<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-plus-circle"></i> Thêm giảng viên mới</h2>

    <div class="card border-0 shadow-lg">
        <div class="card-body p-5">
            <form method="POST" action="store.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Họ tên giảng viên</label>
                            <input type="text" name="name" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Mô tả / Chuyên môn</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="VD: Chuyên gia PHP & Laravel 15 năm kinh nghiệm"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Ảnh đại diện</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                            <small class="text-muted">Để trống nếu không muốn thêm ảnh</small>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="fas fa-save"></i> Thêm giảng viên
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>