<?php
require_once '../model/pdo.php';

$cinema_id = isset($_GET['cinema_id']) ? (int)$_GET['cinema_id'] : 0;
$movie_id = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;

$sql = "
    SELECT s.showtime_id, s.start_time
    FROM showtimes s
    JOIN rooms r ON s.room_id = r.room_id
    WHERE r.cinema_id = ? AND s.movie_id = ?  and s.hide=0
    ORDER BY s.start_time ASC
"; // AND s.hide = 0


$showtimes = pdo_query($sql, $cinema_id, $movie_id);
echo json_encode($showtimes);
?>

