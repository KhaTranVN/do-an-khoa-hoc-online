<?php require_once '../includes/header.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$cat = $stmt->fetch();

if (!$cat) redirect('index.php');
?>

<h3>Sửa danh mục</h3>
<form method="POST" action="update.php" class="card p-4">
    <input type="hidden" name="id" value="<?= $cat['id'] ?>">
    <div class="mb-3">
        <label>Tên danh mục</label>
        <input type="text" name="name" value="<?= $cat['name'] ?>" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-warning">Cập nhật</button>
</form>
<?php require_once '../includes/footer.php'; ?>