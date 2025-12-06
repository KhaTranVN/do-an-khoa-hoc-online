<?php 
require_once '../includes/header.php';
$id = $_GET['id'] ?? 0;
if ($id > 0) {
    $pdo->prepare("UPDATE orders SET status = 'cancelled' WHERE id = ?")->execute([$id]);
    $_SESSION['success'] = "Đơn hàng #$id đã bị hủy!";
}
redirect('index.php');
?>