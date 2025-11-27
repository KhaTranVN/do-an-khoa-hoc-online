<?php
// File init.php – đặt ở thư mục gốc dự án
session_status() === PHP_SESSION_NONE && session_start();

// Định nghĩa đường dẫn tuyệta tuyệt đối 1 lần duy nhất
define('BASE_PATH', __DIR__);

// Include các file quan trọng với đường dẫn tuyệt đối
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/includes/functions.php';
?>