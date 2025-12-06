<?php 
require_once '../includes/header.php';

$title = trim($_POST['title'] ?? '');
if (empty($title)) {
    $_SESSION['error'] = "Vui lòng nhập tiêu đề khóa học!";
    redirect('add.php');
}

$description = $_POST['description'] ?? '';
$content = $_POST['content'] ?? '';
$price = $_POST['price'] ?? 0;
$category_id = $_POST['category_id'] ?? null;

// Tạo slug cơ bản
$base_slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', trim($title)));
$slug = $base_slug;

// Kiểm tra trùng slug → tự động thêm số đuôi
$counter = 1;
while (true) {
    $check = $pdo->prepare("SELECT id FROM courses WHERE slug = ?");
    $check->execute([$slug]);
    if ($check->rowCount() == 0) {
        break; // Không trùng → dùng slug này
    }
    $slug = $base_slug . '-' . $counter;
    $counter++;
}

// Upload ảnh (nếu có)
$thumbnail = '';
if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
    $ext = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
    $filename = 'course_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
    $upload_dir = '../../assets/uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    move_uploaded_file($_FILES['thumbnail']['tmp_name'], $upload_dir . $filename);
    $thumbnail = 'assets/uploads/' . $filename;
}

// Lưu vào CSDL
$stmt = $pdo->prepare("INSERT INTO courses 
    (title, slug, thumbnail, description, content, price, category_id, is_published, created_at) 
    VALUES (?, ?, ?, ?, ?, ?, ?, 1, NOW())");

$stmt->execute([$title, $slug, $thumbnail, $description, $content, $price, $category_id]);

$_SESSION['success'] = "Thêm khóa học thành công! Slug: <strong>$slug</strong>";
redirect('index.php');
?>