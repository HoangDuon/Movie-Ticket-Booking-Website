<?php
require_once "../model/pdo.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    pdo_execute("UPDATE concessions SET hide = 1 WHERE concession_id = ?", $id);
    header("Location: ../view/admin.php");
    exit;
}
?>