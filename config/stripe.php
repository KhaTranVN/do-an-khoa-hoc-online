<?php
require_once '../vendor/autoload.php'; // Nếu dùng Composer
// Hoặc: require_once '../assets/vendor/stripe/init.php';

\Stripe\Stripe::setApiKey('sk_test_51Q9y...'); // THAY BẰNG SECRET KEY CỦA BẠN
?>