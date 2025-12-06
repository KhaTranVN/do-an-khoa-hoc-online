<?php 
require_once '../../init.php';
if (!is_logged_in()) redirect('../../index.php');

$id = $_SESSION['user']['id'];

$fullname = trim($_POST['fullname'] ?? '');
$phone = trim($_POST['phone'] ?? '');

// Upload avatar
$avatar = $_SESSION['user']['avatar'] ?? '';
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $filename = 'user_' . $id . '_' . time() . '.' . $ext;
    $upload_dir = '../../assets/uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
    move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_dir . $filename);
    $avatar = 'assets/uploads/' . $filename;
}

$stmt = $pdo->prepare("UPDATE users SET fullname = ?, phone = ?, avatar = ? WHERE id = ?");
$stmt->execute([$fullname, $phone, $avatar, $id]);

// Cập nhật session
$_SESSION['user']['fullname'] = $fullname;
$_SESSION['user']['phone'] = $phone;
$_SESSION['user']['avatar'] = $avatar;

$_SESSION['success'] = "Cập nhật hồ sơ thành công!";
redirect('profile.php');
?>