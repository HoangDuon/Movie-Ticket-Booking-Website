<?php
require_once "../model/pdo.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    pdo_execute("UPDATE users SET hide = 1 WHERE user_id = ?", $id);
    header("Location: ../view/admin.php");
    exit;
}
?>