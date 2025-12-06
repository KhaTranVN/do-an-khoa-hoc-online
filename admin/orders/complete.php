<?php 
require_once '../includes/header.php';
$id = $_GET['id'] ?? 0;
if ($id > 0) {
    $pdo->prepare("UPDATE orders SET status = 'completed' WHERE id = ?")->execute([$id]);
    $_SESSION['success'] = "Đơn hàng #$id đã được xác nhận giao thành công!";
}
redirect('index.php');
?>