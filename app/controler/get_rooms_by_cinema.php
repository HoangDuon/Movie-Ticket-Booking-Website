<?php
include_once '../model/pdo.php'; // file kết nối PDO

if (isset($_GET['cinema_id'])) {
    $cinemaId = intval($_GET['cinema_id']);

    $rooms = pdo_query("
    SELECT 
        r.room_id, 
        r.name, 
        COUNT(s.seat_id) AS seat_count
    FROM 
        rooms r
    LEFT JOIN 
        seats s ON r.room_id = s.room_id
    WHERE 
        r.cinema_id = ?
    GROUP BY 
        r.room_id, r.name
    ORDER BY 
        r.order_index ASC, r.name ASC
    ", $cinemaId);


    echo json_encode(['rooms' => $rooms]);
} else {
    echo json_encode(['rooms' => []]);
}