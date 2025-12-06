<?php 
require_once '../includes/header.php';

$title = trim($_POST['title'] ?? '');
$content = $_POST['content'] ?? '';

if (empty($title) || empty($content)) {
    $_SESSION['error'] = "Vui lòng nhập đầy đủ tiêu đề và nội dung!";
    redirect('add.php');
}

$slug = strtolower(preg_replace('/[^a-z0-9-]+/', '-', $title));
$image = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = 'news_' . time() . '.' . $ext;
    $upload_dir = '../../assets/uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $filename);
    $image = 'assets/uploads/' . $filename;
}

$stmt = $pdo->prepare("INSERT INTO news (title, slug, image, content, created_at, is_deleted) VALUES (?, ?, ?, ?, NOW(), 0)");
$stmt->execute([$title, $slug, $image, $content]);

$_SESSION['success'] = "Đăng bài thành công!";
redirect('index.php');
?>