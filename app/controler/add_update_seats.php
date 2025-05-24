<?php
require_once "../model/pdo.php";

// Lấy dữ liệu từ POST
$roomName = $_POST['roomname'];
$roomStatus = $_POST['status'];
$roomId=$_POST['roomid'];
$seatName=$_POST['seatname'];
$price=$_POST['price'];
$type=$_POST['type'];
$seatStatus='Available';
$seatHide=$_POST['seathide'];
$seatId=$_POST['seatid'];

$sql = "UPDATE rooms SET name=?,hide=? WHERE room_id=?";
    pdo_execute($sql, $roomName,$roomStatus,$roomId);

if(!empty($seatId) && !empty($seatName)){
    $sql = "UPDATE seats SET seat_number=?,seat_type=?,extra_price=?,hide=? WHERE seat_id=?";
    pdo_execute($sql, $seatName,$type,$price,$seatHide,$seatId);
}

header("Location: ../view/admin.php#cinemas");
// echo '<pre>';
// print_r($seatHide);
// echo '</pre>';
exit;

?>