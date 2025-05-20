<?php
require_once "../model/pdo.php"; // hoặc đường dẫn tới file DAO

// Lấy dữ liệu từ POST
$discount = $_POST['discount'];
$member = $_POST['member'];
$content = $_POST['content'];

// Cập nhật
$sql = "UPDATE membership_discounts SET discount_percent=?,content=? WHERE member_type=?";

pdo_execute($sql, $discount,$content,$member);

header("Location: ../view/admin.php#membership");
// echo '<pre>';
// print_r($_FILES);
// echo '</pre>';
exit;

?>