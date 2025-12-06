<?php
require_once '../../init.php';

if (!is_logged_in()) {
    $_SESSION['error'] = "Vui lòng đăng nhập để thêm vào giỏ hàng!";
    header("Location: http://localhost:3000/auth/login");
    exit();
}

$id = $_GET['id'] ?? 0;
if ($id <= 0) {
    $_SESSION['error'] = "Khóa học không hợp lệ!";
    header("Location: javascript://history.go(-1)");
    exit();
}

// Lấy thông tin khóa học
$stmt = $pdo->prepare("SELECT id, title, price, discount_price FROM courses WHERE id = ? AND is_published = 1 AND is_deleted = 0");
$stmt->execute([$id]);
$course = $stmt->fetch();

if (!$course) {
    $_SESSION['error'] = "Khóa học không tồn tại hoặc chưa được công khai!";
    header("Location: javascript://history.go(-1)");
    exit();
}

$price = $course['discount_price'] ?: $course['price'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$was_in_cart = isset($_SESSION['cart'][$id]);

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity'] += 1;
} else {
    $_SESSION['cart'][$id] = [
        'title'     => $course['title'],
        'price'     => $price,
        'quantity'  => 1
    ];
}

// THÔNG BÁO SIÊU ĐẸP
$_SESSION['toast'] = [
    'type' => 'success',
    'title' => $was_in_cart ? 'Cập nhật giỏ hàng' : 'Thêm thành công!',
    'message' => $was_in_cart 
        ? "Đã tăng số lượng <strong>{$course['title']}</strong>"
        : "<strong>{$course['title']}</strong> đã được thêm vào giỏ hàng!"
];

header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "http://localhost:3000/modules/courses"));
exit();
?>