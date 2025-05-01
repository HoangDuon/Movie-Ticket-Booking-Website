<?php
require_once "../model/pdo.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $currentHide = pdo_query_one("SELECT hide FROM showtimes WHERE showtime_id = ?", $id)['hide'];

    $newHide = $currentHide == 1 ? 0 : 1;

    pdo_execute("UPDATE showtimes SET hide = ? WHERE showtime_id = ?", $newHide,$id);
    header("Location: ../view/admin.php");
    exit;
}
?>