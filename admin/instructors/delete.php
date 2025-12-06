<?php 
require_once '../includes/header.php';

$id = $_GET['id'] ?? 0;
if ($id > 0) {
    $pdo->prepare("UPDATE instructors SET is_deleted = 1 WHERE id = ?")->execute([$id]);
    $_SESSION['success'] = "Xóa giảng viên thành công!";
}
redirect('index.php');
?>