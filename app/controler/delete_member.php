<?php
require_once "../model/pdo.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    pdo_execute("UPDATE membership_discounts SET hide = 1 WHERE member_type=?", $id);
    header("Location: ../view/admin.php");
    exit;
}
?>