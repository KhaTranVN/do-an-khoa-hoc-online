<?php 
require_once '../includes/header.php';

$id = $_GET['id'] ?? 0;
if ($id > 0) {
    // Xóa mềm
    $pdo->prepare("UPDATE news SET is_deleted = 1 WHERE id = ?")->execute([$id]);
    $_SESSION['success'] = "Xóa tin tức thành công!";
}
redirect('index.php');
?>