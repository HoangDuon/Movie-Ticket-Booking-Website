<?php
require_once '../model/pdo.php'; // Trong đó có $pdo và pdo_query()

if (!isset($_GET['showtime_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Thiếu showtime_id']);
    exit;
}

$showtime_id = intval($_GET['showtime_id']);

// Lấy room_id từ suất chiếu
$sqlRoom = "SELECT room_id FROM showtimes WHERE showtime_id = ?";
$roomResult = pdo_query($sqlRoom, $showtime_id);

if (!$roomResult || count($roomResult) === 0) {
    echo json_encode(['error' => 'Không tìm thấy suất chiếu']);
    exit;
}

$room_id = $roomResult[0]['room_id'];

// Lấy danh sách ghế trong phòng
$sqlSeats = "
    SELECT 
        s.seat_id,
        s.seat_number,
        s.seat_type,
        s.extra_price,
        CASE 
            WHEN EXISTS (
                SELECT 1 FROM booking_details bd
                JOIN bookings b ON bd.booking_id = b.booking_id
                WHERE bd.seat_id = s.seat_id AND b.showtime_id = ?
            ) THEN 'Booked'
            ELSE 'Available'
        END AS status
    FROM seats s
    WHERE s.room_id = ?
";

$seats = pdo_query($sqlSeats, $showtime_id, $room_id);


echo json_encode(['seats' => $seats]);
