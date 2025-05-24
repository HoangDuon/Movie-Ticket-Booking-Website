<?php

require_once '../model/pdo.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['cinema_id'])) {
    $cinemaId = $_GET['cinema_id'];

    $sql = "SELECT s.showtime_id, m.title AS movie_title, m.movie_id, 
                   c.name AS cinema_name, c.cinema_id, 
                   r.name AS room_name, r.room_id,
                   s.start_time, s.end_time, s.price, s.hide
            FROM showtimes s
            JOIN movies m ON s.movie_id = m.movie_id
            JOIN rooms r ON s.room_id = r.room_id
            JOIN cinemas c ON r.cinema_id = c.cinema_id 
            WHERE c.cinema_id = ? 
            ORDER BY s.start_time DESC";

    $rooms = pdo_query($sql, $cinemaId);    

    header('Content-Type: application/json');
    echo json_encode(['rooms' => $rooms]);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Thiếu tham số cinema_id']);
}
?>
