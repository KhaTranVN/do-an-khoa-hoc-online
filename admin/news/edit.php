<?php require_once '../includes/header.php'; 

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ? AND is_deleted = 0");
$stmt->execute([$id]);
$news = $stmt->fetch();

if (!$news) {
    $_SESSION['error'] = "Tin tức không tồn tại hoặc đã bị xóa!";
    redirect('index.php');
}
?>

<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-edit"></i> Sửa tin tức</h2>

    <form method="POST" action="update.php" enctype="multipart/form-data" class="card border-0 shadow-lg">
        <div class="card-body p-5">
            <input type="hidden" name="id" value="<?= $news['id'] ?>">
            
            <div class="row g-4">
                <div class="col-md-8">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tiêu đề bài viết</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($news['title']) ?>" class="form-control form-control-lg" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Nội dung bài viết</label>
                        <textarea name="content" id="editor" rows="15"><?= htmlspecialchars($news['content']) ?></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <?php if($news['image']): ?>
                        <div class="text-center mb-4">
                            <img src="../../<?= $news['image'] ?>" class="img-fluid rounded shadow" style="max-height:250px;">
                            <p class="mt-2 text-muted small">Ảnh hiện tại</p>
                        </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Đổi ảnh bìa</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Để trống nếu không muốn thay đổi</small>
                    </div>

                    <div class="text-end">
                        <a href="index.php" class="btn btn-secondary btn-lg me-3">Hủy</a>
                        <button type="submit" class="btn btn-warning btn-lg px-5">
                            <i class="fas fa-save"></i> Cập nhật bài viết
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
    toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','|','imageUpload','blockQuote','insertTable','|','undo','redo']
}).catch(error => console.error(error));
</script>

<?php require_once '../includes/footer.php'; ?>