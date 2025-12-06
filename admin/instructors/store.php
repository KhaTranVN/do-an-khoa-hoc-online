<?php 
require_once '../includes/header.php';

$name = trim($_POST['name'] ?? '');
$description = $_POST['description'] ?? '';

if (empty($name)) {
    $_SESSION['error'] = "Vui lòng nhập tên giảng viên!";
    redirect('add.php');
}

// Upload ảnh
$avatar = '';
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $filename = 'instructor_' . time() . '.' . $ext;
    $upload_dir = '../../assets/uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_dir . $filename);
    $avatar = 'assets/uploads/' . $filename;
}

$stmt = $pdo->prepare("INSERT INTO instructors (name, description, avatar, created_at, is_deleted) VALUES (?, ?, ?, NOW(), 0)");
$stmt->execute([$name, $description, $avatar]);

$_SESSION['success'] = "Thêm giảng viên \"$name\" thành công!";
redirect('index.php');
?>