<?php require_once '../includes/header.php';
$name = trim($_POST['name']);
$slug = strtolower(preg_replace('/[^a-z0-9-]+/', '-', $name));

$stmt = $pdo->prepare("INSERT INTO categories (name, slug, created_at) VALUES (?, ?, NOW())");
$stmt->execute([$name, $slug]);

$_SESSION['success'] = "Thêm danh mục thành công!";
redirect('index.php');