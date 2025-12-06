<?php 
require_once '../includes/header.php';

$id = $_POST['id'] ?? 0;
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$fullname = $_POST['fullname'] ?? '';
$phone = $_POST['phone'] ?? '';

if ($id <= 0 || empty($username) || empty($email)) {
    $_SESSION['error'] = "Dữ liệu không hợp lệ!";
    redirect('index.php');
}

$stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, fullname = ?, phone = ? WHERE id = ?");
$stmt->execute([$username, $email, $fullname, $phone, $id]);

$_SESSION['success'] = "Cập nhật người dùng thành công!";
redirect('index.php');
?>