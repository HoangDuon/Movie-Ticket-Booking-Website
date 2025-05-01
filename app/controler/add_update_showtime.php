<?php
require_once "../model/pdo.php";
print_r($_POST);

// Lấy dữ liệu từ form
$showtimeId = $_POST['id'] ?? null;
$movieId    = $_POST['movie'] ?? null;

// Ưu tiên ID sửa nếu có, nếu không lấy từ thêm mới
$cinemaId   =  $_POST['cinemas'] ?? null;
$roomId     =  $_POST['rooms'] ?? null;

$startTime = isset($_POST['start']) ? str_replace('T', ' ', $_POST['start']) : null;
$endTime   = isset($_POST['end']) ? str_replace('T', ' ', $_POST['end']) : null;

$price      = $_POST['price'] ?? 0;

$cinemaIdhidden   =  $_POST['cinemasid'] ?? null;
$movieIdhidden  = $_POST['movieid'] ?? null;
var_dump($cinemaIdhidden ,$movieIdhidden,$movieId,$cinemaId, $roomId, $startTime, $endTime, $price);
// Kiểm tra dữ liệu bắt buộc
if ( !$roomId || !$startTime || !$endTime || !$price) {
    die("Thiếu dữ liệu cần thiết!");
}

// Đảm bảo thời gian bắt đầu nhỏ hơn thời gian kết thúc
if (strtotime($startTime) >= strtotime($endTime)) {
    // Nếu sai, hoán đổi
    $tmp = $startTime;
    $startTime = $endTime;
    $endTime = $tmp;
}

if ($showtimeId) {
    // Cập nhật suất chiếu
    $sql = "UPDATE showtimes 
            SET movie_id = ?, room_id = ?, start_time = ?, end_time = ?, price = ?
            WHERE showtime_id = ?";
    pdo_execute($sql, $movieIdhidden, $roomId, $startTime, $endTime, $price, $showtimeId);
} else {
    // Thêm mới suất chiếu
    $sql = "INSERT INTO showtimes (movie_id, room_id, start_time, end_time, price, hide) 
            VALUES (?, ?, ?, ?, ?, 0)";
    pdo_execute($sql, $movieId, $roomId, $startTime, $endTime, $price);
}

// Quay lại trang quản lý
header("Location: ../view/admin.php");
exit;
