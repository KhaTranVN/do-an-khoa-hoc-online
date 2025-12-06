<?php
require_once '../../init.php';
require_once '../../config/stripe.php'; // File chứa Stripe secret key

if (!is_logged_in() || empty($_SESSION['cart'])) {
    header("Location: http://localhost:3000/cart");
    exit();
}

$total = 0;
foreach($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

try {
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $total * 100, // VND → cent
        'currency' => 'vnd',
        'payment_method' => $_POST['payment_method_id'],
        'confirmation_method' => 'manual',
        'confirm' => true,
    ]);

    if ($paymentIntent->status === 'succeeded') {
        // Tạo đơn hàng
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'completed')");
        $stmt->execute([$_SESSION['user']['id'], $total]);
        $order_id = $pdo->lastInsertId();

        foreach($_SESSION['cart'] as $course_id => $item) {
            $pdo->prepare("INSERT INTO order_details (order_id, course_id, price, quantity) VALUES (?, ?, ?, ?)")
                ->execute([$order_id, $course_id, $item['price'], $item['quantity']]);
        }

        // Gửi email xác nhận (sẽ thêm sau)
        unset($_SESSION['cart']);
        $_SESSION['success'] = "Thanh toán thành công! Đơn hàng #$order_id";

        header("Location: http://localhost:3000/modules/checkout/success.php");
        exit();
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Thanh toán thất bại: " . $e->getMessage();
    header("Location: http://localhost:3000/modules/checkout");
    exit();
}
?>