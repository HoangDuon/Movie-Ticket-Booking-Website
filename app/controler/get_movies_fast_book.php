<?php
require_once '../model/pdo.php';

$cinema_id = isset($_GET['cinema_id']) ? (int)$_GET['cinema_id'] : 0;
$sql = "
    SELECT DISTINCT m.movie_id, m.title
    FROM showtimes s
    JOIN rooms r ON s.room_id = r.room_id
    JOIN movies m ON s.movie_id = m.movie_id
    WHERE r.cinema_id = ? AND m.hide = 0
    ORDER BY m.order_index ASC
";// AND s.hide = 0

$movies = pdo_query($sql, $cinema_id);
echo json_encode($movies);
?>
