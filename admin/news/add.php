<?php require_once '../includes/header.php'; ?>

<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-plus-circle"></i> Viết bài tin tức mới</h2>

    <form method="POST" action="store.php" enctype="multipart/form-data" class="card border-0 shadow-lg">
        <div class="card-body p-5">
            <div class="mb-4">
                <label class="form-label fw-bold">Tiêu đề bài viết</label>
                <input type="text" name="title" class="form-control form-control-lg" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Ảnh đại diện</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Nội dung bài viết</label>
                <textarea name="content" id="editor" rows="15"></textarea>
            </div>

            <div class="text-end">
                <a href="index.php" class="btn btn-secondary btn-lg me-3">Hủy</a>
                <button type="submit" class="btn btn-success btn-lg px-5">
                    <i class="fas fa-paper-plane"></i> Đăng bài
                </button>
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