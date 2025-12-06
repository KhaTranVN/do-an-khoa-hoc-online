// delete.php
<?php require_once '../includes/header.php';
$id = $_GET['id'];
$pdo->prepare("UPDATE categories SET is_deleted = 1 WHERE id = ?")->execute([$id]);
redirect('index.php');