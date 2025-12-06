<?php 
require_once '../includes/header.php';

$id = $_POST['id'] ?? 0;
$name = trim($_POST['name'] ?? '');
$description = $_POST['description'] ?? '';

if ($id <= 0 || empty($name)) {
    $_SESSION['error'] = "Dữ liệu không hợp lệ!";
    redirect('index.php');
}

// Upload ảnh mới (nếu có)
$avatar = $pdo->query("SELECT avatar FROM instructors WHERE id = $id")->fetchColumn();
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $filename = 'instructor_' . time() . '.' . $ext;
    $upload_dir = '../../assets/uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_dir . $filename);
    $avatar = 'assets/uploads/' . $filename;
}

$stmt = $pdo->prepare("UPDATE instructors SET name = ?, description = ?, avatar = ? WHERE id = ?");
$stmt->execute([$name, $description, $avatar, $id]);

$_SESSION['success'] = "Cập nhật giảng viên thành công!";
redirect('index.php');
?>