<?php

require_once '../model/pdo.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['cinema_id'])) {
    $cinemaId = $_GET['cinema_id'];

    // câu truy vấn để lọc theo cinema_id
    $sql = "SELECT
                    r.room_id,
                    r.name
                FROM
                    rooms r
                WHERE
                    r.cinema_id = ?
                GROUP BY
                    r.room_id, r.name
                ORDER BY
                    r.order_index ASC, r.name ASC";

    $rooms = pdo_query($sql, $cinemaId);    

    header('Content-Type: application/json');
    echo json_encode(['rooms' => $rooms]);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Thiếu tham số cinema_id']);
}
?>
