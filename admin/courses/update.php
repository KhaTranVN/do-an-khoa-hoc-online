<?php 
require_once '../includes/header.php';

$id = $_POST['id'] ?? 0;
$title = trim($_POST['title'] ?? '');
if ($id <= 0 || empty($title)) {
    $_SESSION['error'] = "Dữ liệu không hợp lệ!";
    redirect('index.php');
}

$description = $_POST['description'] ?? '';
$content = $_POST['content'] ?? '';
$price = $_POST['price'] ?? 0;
$discount_price = !empty($_POST['discount_price']) ? $_POST['discount_price'] : null;
$category_id = $_POST['category_id'] ?? null;

// Tạo slug mới
$slug = strtolower(preg_replace('/[^a-z0-9-]+/', '-', $title));

// Upload ảnh mới (nếu có)
$thumbnail = $pdo->query("SELECT thumbnail FROM courses WHERE id = $id")->fetchColumn();
if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
    $ext = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
    $filename = 'course_' . time() . '.' . $ext;
    $upload_dir = '../../assets/uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    move_uploaded_file($_FILES['thumbnail']['tmp_name'], $upload_dir . $filename);
    $thumbnail = 'assets/uploads/' . $filename;
}

$stmt = $pdo->prepare("UPDATE courses SET 
    title = ?, slug = ?, thumbnail = ?, description = ?, content = ?, 
    price = ?, discount_price = ?, category_id = ? 
    WHERE id = ?");

$stmt->execute([$title, $slug, $thumbnail, $description, $content, $price, $discount_price, $category_id, $id]);

$_SESSION['success'] = "Cập nhật khóa học thành công!";
redirect('index.php');
?>