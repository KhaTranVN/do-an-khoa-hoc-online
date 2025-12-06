<?php
function redirect($url) {
    echo "<script>window.location.href = '$url';</script>";
    exit();
}

function is_logged_in() {
    return isset($_SESSION['user']);
}

function is_admin() {
    return is_logged_in() && $_SESSION['user']['role'] === 'admin';
}
?>