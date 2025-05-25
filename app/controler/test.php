<?php
require_once '../model/pdo.php';
header('Content-Type: application/json');

$roomId = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;
if ($roomId <= 0) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT 
            s.showtime_id,
            r.name AS room_name,
            m.title AS movie_title,
            s.start_time,
            s.end_time,
            s.price
        FROM showtimes s
        JOIN rooms r ON s.room_id = r.room_id
        JOIN movies m ON s.movie_id = m.movie_id
        WHERE s.room_id = ?
        AND s.hide = 0 
        AND s.end_time > NOW()
        ORDER BY s.start_time";

$result = pdo_query($sql, $roomId);

// Format lại start_time và end_time sang ISO 8601 (YYYY-MM-DDTHH:MM:SS)
foreach ($result as &$row) {
    $row['start_time'] = date('c', strtotime($row['start_time'])); // 'c' = ISO 8601
    $row['end_time'] = date('c', strtotime($row['end_time']));
}
unset($row); // good practice

echo json_encode($result);
