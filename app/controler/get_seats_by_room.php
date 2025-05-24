<?php
include_once '../model/pdo.php';

if (isset($_GET['room_id'])) {
    $roomId = intval($_GET['room_id']);

    $sql = "SELECT 
            seats.seat_id, 
            seats.seat_number, 
            seats.seat_type, 
            seats.status, 
            seats.extra_price,
            seats.hide,
            rooms.room_id, 
            rooms.name AS room_name, 
            rooms.hide AS room_hide
        FROM seats
        INNER JOIN rooms ON seats.room_id = rooms.room_id
        WHERE seats.room_id = ?";


    $seats =  pdo_query($sql,$roomId);

    echo json_encode(['seats' => $seats]);
} else {
    echo json_encode(['seats' => []]);
}
