<?php
// File: D:\do-an-khoa-học-online\init.php
// BẮT BUỘC PHẢI CÓ FILE NÀY Ở GỐC!!!

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROOT_PATH', __DIR__);

// Kết nối CSDL + functions
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/includes/functions.php';

// Tự động load tất cả class trong thư mục classes
foreach (glob(ROOT_PATH . '/classes/*.php') as $file) {
    require_once $file;
}
?>