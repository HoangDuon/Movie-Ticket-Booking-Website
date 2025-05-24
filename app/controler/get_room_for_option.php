<?php

require_once '../model/pdo.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['cinema_id'])) {
    $cinemaId = $_GET['cinema_id'];

    // Cập nhật câu truy vấn để lọc theo cinema_id
    $sql = "SELECT
                    r.room_id,
                    r.name -- Đảm bảo key trả về là 'name' nếu JS dùng 'room.name'
                FROM
                    rooms r
                WHERE
                    r.cinema_id = ?
                GROUP BY -- Hoặc DISTINCT nếu không cần count gì khác
                    r.room_id, r.name
                ORDER BY
                    r.order_index ASC, r.name ASC";

    // Truyền tham số $cinemaId vào câu truy vấn
    $rooms = pdo_query($sql, $cinemaId);    

    // Trả về kết quả dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode(['rooms' => $rooms]);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Thiếu tham số cinema_id']);
}
?>
