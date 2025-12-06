<?php 
require_once '../includes/header.php';
$id = $_GET['id'] ?? 0;
if ($id > 0) {
    $current = $pdo->query("SELECT role FROM users WHERE id = $id")->fetchColumn();
    $new_role = $current === 'admin' ? 'user' : 'admin';
    $pdo->prepare("UPDATE users SET role = ? WHERE id = ?")->execute([$new_role, $id]);
    $_SESSION['success'] = "Đổi role thành công!";
}
redirect('index.php');
?>