<?php
require_once "../model/pdo.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $currentHide = pdo_query_one("SELECT hide FROM users WHERE user_id = ?", $id)['hide'];

    $newHide = $currentHide == 1 ? 0 : 1;

    pdo_execute("UPDATE users SET hide = ? WHERE user_id = ?", $newHide, $id);

    // Quay lại trang quản lý
    header("Location: ../view/admin.php");
    exit;
}
?>
