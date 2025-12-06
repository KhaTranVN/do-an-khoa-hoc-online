<?php require_once '../includes/header.php'; 
$categories = $pdo->query("SELECT * FROM categories WHERE is_deleted = 0")->fetchAll();
$instructors = $pdo->query("SELECT * FROM instructors")->fetchAll();
?>

<h3><i class="fas fa-plus-circle"></i> Thêm khóa học mới</h3>
<form method="POST" action="store.php" enctype="multipart/form-data" class="card p-4">
    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <label>Tiêu đề</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Mô tả ngắn</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label>Nội dung chi tiết</label>
                <textarea name="content" id="editor"></textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label>Ảnh thumbnail</label>
                <input type="file" name="thumbnail" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label>Giá gốc</label>
                <input type="number" name="price" class="form-control" value="0">
            </div>
            <div class="mb-3">
                <label>Danh mục</label>
                <select name="category_id" class="form-control">
                    <?php foreach($categories as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success btn-lg w-100">Thêm khóa học</button>
        </div>
    </div>
</form>

<script src="../../assets/vendor/ckeditor5/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#editor'), {
    toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','|','imageUpload','|','undo','redo']
}).catch(error => console.error(error));
</script>

<?php require_once '../includes/footer.php'; ?>