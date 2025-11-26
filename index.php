<?php
session_start();
require_once 'config/database.php';

// Hệ thống điều hướng
$mod = $_GET['mod'] ?? 'home';
$act = $_GET['act'] ?? 'index';

$mod = preg_replace('/[^a-zA-Z0-9_-]/', '', $mod);
$act = preg_replace('/[^a-zA-Z0-9_-]/', '', $act);

$file = "modules/{$mod}/{$act}.php";

if (file_exists($file)) {
    require $file;
} else {
    require 'modules/home/index.php';
}
?>