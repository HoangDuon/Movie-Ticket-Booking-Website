<?php
require_once "../model/pdo.php"; // hoặc đường dẫn tới file DAO

// Lấy dữ liệu từ POST
$roomName = $_POST['roomname'];
$roomStatus = $_POST['status'];
$roomId=$_POST['roomid'];
$seatName=$_POST['seatname'];
$price=$_POST['price'];
$type=$_POST['type'];
$seatStatus=$_POST['seatstatus'];
$seatHide=$_POST['seathide'];
$seatId=$_POST['seatid'];

$sql = "UPDATE rooms SET name=?,hide=? WHERE room_id=?";
    pdo_execute($sql, $roomName,$roomStatus,$roomId);

if(!empty($seatId) && !empty($seatName)){
    $sql = "UPDATE seats SET seat_number=?,seat_type=?,extra_price=?,status=?,hide=? WHERE seat_id=?";
    pdo_execute($sql, $seatName,$type,$price,$seatStatus,$seatHide,$seatId);
}

header("Location: ../view/admin.php#cinemas");
// echo '<pre>';
// print_r($_FILES);
// echo '</pre>';
exit;

?>