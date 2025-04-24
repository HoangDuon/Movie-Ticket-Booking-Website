<?php
require_once "../model/pdo.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    pdo_execute("UPDATE movies SET hide = 1 WHERE movie_id = ?", $id);
    header("Location: ../view/admin.php");
    exit;
}
?>