<?php 
require_once '../includes/header.php';
$id = $_GET['id'] ?? 0;
if ($id > 0) {
    $current = $pdo->query("SELECT is_active FROM users WHERE id = $id")->fetchColumn();
    $new_status = $current == 1 ? 0 : 1;
    $pdo->prepare("UPDATE users SET is_active = ? WHERE id = ?")->execute([$new_status, $id]);
    $_SESSION['success'] = $new_status ? "Mở khóa tài khoản thành công!" : "Khóa tài khoản thành công!";
}
redirect('index.php');
?>