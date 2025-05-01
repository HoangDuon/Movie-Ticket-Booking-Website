<?php
require_once "../model/pdo.php"; // hoặc đường dẫn tới file DAO

// Lấy dữ liệu từ POST
$name = $_POST['name'];
$location = $_POST['location'];
$phone = $_POST['phone'];
$id=$_POST['id'];


// Cập nhật
$sql = "UPDATE cinemas SET name=?,location=?,phone=? WHERE cinema_id=?";

pdo_execute($sql, $name,$location,$phone,$id);

header("Location: ../view/admin.php");
// echo '<pre>';
// print_r($_FILES);
// echo '</pre>';
exit;

?>