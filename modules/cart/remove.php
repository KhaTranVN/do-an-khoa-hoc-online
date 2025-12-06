<?php
require_once '../../init.php';

if (!is_logged_in()) {
    header("Location: http://localhost:3000/auth/login");
    exit();
}

$id = $_GET['id'] ?? 0;

if ($id > 0 && isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
    $_SESSION['success'] = "Đã xóa khỏi giỏ hàng!";
} else {
    $_SESSION['error'] = "Không tìm thấy sản phẩm!";
}

header("Location: http://localhost:3000/modules/cart/index.php");
exit();
?>