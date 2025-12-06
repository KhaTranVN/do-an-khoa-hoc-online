// update.php
<?php require_once '../includes/header.php';
$id = $_POST['id'];
$name = trim($_POST['name']);
$slug = strtolower(preg_replace('/[^a-z0-9-]+/', '-', $name));

$stmt = $pdo->prepare("UPDATE categories SET name = ?, slug = ? WHERE id = ?");
$stmt->execute([$name, $slug, $id]);

$_SESSION['success'] = "Cập nhật thành công!";
redirect('index.php');