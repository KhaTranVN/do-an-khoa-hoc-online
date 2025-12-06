<?php 
require_once '../includes/header.php';

$id = $_POST['id'] ?? 0;
$title = trim($_POST['title'] ?? '');
$content = $_POST['content'] ?? '';

if ($id <= 0 || empty($title) || empty($content)) {
    $_SESSION['error'] = "Dữ liệu không hợp lệ!";
    redirect('index.php');
}

$slug = strtolower(preg_replace('/[^a-z0-9-]+/', '-', $title));

// Lấy ảnh cũ
$old_image = $pdo->query("SELECT image FROM news WHERE id = $id")->fetchColumn();

// Upload ảnh mới (nếu có)
$image = $old_image;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = 'news_' . time() . '.' . $ext;
    $upload_dir = '../../assets/uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename);
    $image = 'assets/uploads/' . $filename;
}

$stmt = $pdo->prepare("UPDATE news SET title = ?, slug = ?, image = ?, content = ? WHERE id = ?");
$stmt->execute([$title, $slug, $image, $content, $id]);

$_SESSION['success'] = "Cập nhật tin tức thành công!";
redirect('index.php');
?>