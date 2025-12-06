<?php 
require_once '../includes/header.php';   // ← DÒNG DUY NHẤT CẦN CÓ – ĐÃ LOAD TẤT CẢ!!!
if (!is_admin()) redirect('../../index.php');

$cat = new Category();           // ← BÂY GIỜ CHẠY NGON LÀNH!
$categories = $cat->all();
?>

<div class="container-fluid">
    <h2 class="mb-4"><i class="fas fa-tags"></i> Quản lý Danh mục</h2>
    <a href="add.php" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Thêm danh mục mới
    </a>

    <?php if (empty($categories)): ?>
        <div class="alert alert-info">Chưa có danh mục nào. <a href="add.php">Thêm ngay!</a></div>
    <?php else: ?>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['name']) ?></td>
                    <td><code><?= $c['slug'] ?></code></td>
                    <td>
                        <a href="edit.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="delete.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-danger" 
                           onclick="return confirm('Xóa danh mục này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require_once '../includes/footer.php'; ?>