<?php require_once '../includes/header.php'; 

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT c.*, cat.name as cat_name FROM courses c LEFT JOIN categories cat ON c.category_id = cat.id WHERE c.id = ?");
$stmt->execute([$id]);
$course = $stmt->fetch();

if (!$course) {
    $_SESSION['error'] = "Khóa học không tồn tại!";
    redirect('index.php');
}

$categories = $pdo->query("SELECT * FROM categories WHERE is_deleted = 0")->fetchAll();
?>

<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-edit"></i> Sửa khóa học</h2>

    <form method="POST" action="update.php" enctype="multipart/form-data" class="card border-0 shadow-lg">
        <div class="card-body p-5">
            <input type="hidden" name="id" value="<?= $course['id'] ?>">
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tiêu đề khóa học</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($course['title']) ?>" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Mô tả ngắn</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($course['description'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nội dung chi tiết</label>
                        <textarea name="content" id="editor"><?= htmlspecialchars($course['content'] ?? '') ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php if($course['thumbnail']): ?>
                        <div class="mb-3 text-center">
                            <img src="../../<?= $course['thumbnail'] ?>" class="img-fluid rounded shadow" style="max-height:200px;">
                            <p class="mt-2 text-muted">Ảnh hiện tại</p>
                        </div>
                    <?php endif; ?>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Đổi ảnh thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label fw-bold">Giá gốc</label>
                            <input type="number" name="price" value="<?= $course['price'] ?>" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Giá khuyến mãi</label>
                            <input type="number" name="discount_price" value="<?= $course['discount_price'] ?? '' ?>" class="form-control form-control-lg">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Danh mục</label>
                        <select name="category_id" class="form-select form-select-lg" required>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $course['category_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="text-end">
                        <a href="index.php" class="btn btn-secondary btn-lg me-3">Hủy</a>
                        <button type="submit" class="btn btn-warning btn-lg px-5">
                            <i class="fas fa-save"></i> Cập nhật khóa học
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="../../assets/vendor/ckeditor5/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#editor'), {
    toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','|','imageUpload','blockQuote','|','undo','redo']
}).catch(error => console.error(error));
</script>

<?php require_once '../includes/footer.php'; ?>