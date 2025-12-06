<?php
require_once '../../init.php';

if (!is_logged_in()) {
    header("Location: http://localhost:3000/auth/login");
    exit();
}

$id = $_POST['id'] ?? 0;
$quantity = max(1, (int)($_POST['quantity'] ?? 1));

if ($id > 0 && isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity'] = $quantity;
    $_SESSION['success'] = "Đã cập nhật số lượng!";
} else {
    $_SESSION['error'] = "Không tìm thấy sản phẩm!";
}

header("Location: http://localhost:3000/modules/cart/index.php");
exit();
?>