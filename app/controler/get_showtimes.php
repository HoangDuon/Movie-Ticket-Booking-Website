<?php
header('Content-Type: application/json');

// Kết nối database
require_once '../model/pdo.php'; // hoặc đường dẫn file kết nối CSDL

$movie_id = $_GET['movie_id'] ?? null;
$show_date = $_GET['show_date'] ?? null;


if (!$movie_id || !$show_date) {
    echo json_encode(['error' => 'Thiếu movie_id hoặc show_date']);
    exit;
}

try {
    // Lấy danh sách suất chiếu theo phim và ngày
    $sql = "
        SELECT 
            c.cinema_id,
            c.name AS cinema_name,
            c.location,
            r.room_id,
            r.name AS room_name,
            s.showtime_id,
            s.start_time,
            s.end_time,
            s.price
        FROM showtimes s
        JOIN rooms r ON s.room_id = r.room_id
        JOIN cinemas c ON r.cinema_id = c.cinema_id
        WHERE s.movie_id = ? AND DATE(s.start_time) = ?
        ORDER BY c.cinema_id, r.room_id, s.start_time
    ";

    $rows = pdo_query($sql, $movie_id, $show_date);
    // Gom dữ liệu theo cinema -> room -> showtime
    $result = [];

    foreach ($rows as $row) {
        $cid = $row['cinema_id'];
        $rid = $row['room_id'];

        if (!isset($result[$cid])) {
            $result[$cid] = [
                'cinema_id' => $cid,
                'cinema_name' => $row['cinema_name'],
                'location' => $row['location'],
                'rooms' => []
            ];
        }

        if (!isset($result[$cid]['rooms'][$rid])) {
            $result[$cid]['rooms'][$rid] = [
                'room_id' => $rid,
                'room_name' => $row['room_name'],
                'showtimes' => []
            ];
        }

        $result[$cid]['rooms'][$rid]['showtimes'][] = [
            'showtime_id' => $row['showtime_id'],
            'start_time' => date('H:i', strtotime($row['start_time'])),
            'end_time' => date('H:i', strtotime($row['end_time'])),
            'price' => $row['price']
        ];
    }

    // Convert rooms từ map -> array
    foreach ($result as &$cinema) {
        $cinema['rooms'] = array_values($cinema['rooms']);
    }

    echo json_encode(array_values($result));
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
