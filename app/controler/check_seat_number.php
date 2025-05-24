<?php
header('Content-Type: application/json');
require_once "../model/pdo.php";

$roomId = isset($_GET['room_id']) ? (int)$_GET['room_id'] : 0;
$seatNumber = isset($_GET['seat_number']) ? trim($_GET['seat_number']) : '';
$seatId = isset($_GET['seat_id']) && !empty($_GET['seat_id']) ? (int)$_GET['seat_id'] : 0;

if (empty($roomId) || empty($seatNumber)) {
    echo json_encode(['error' => 'Thiếu thông tin phòng hoặc số ghế.']);
    exit;
}

try {
    $pdo = pdo_get_connection();
    
    $sql = "SELECT COUNT(*) FROM seats WHERE room_id = :roomId AND seat_number = :seatNumber";
    $params = [':roomId' => $roomId, ':seatNumber' => $seatNumber];

    if ($seatId > 0) { // Nếu là đang sửa ghế, loại trừ chính nó ra
        $sql .= " AND seat_id != :seatId";
        $params[':seatId'] = $seatId;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $count = $stmt->fetchColumn();

    echo json_encode(['isTaken' => $count > 0]);

} catch (PDOException $e) {
    error_log("Lỗi kiểm tra số ghế: " . $e->getMessage());
    echo json_encode(['error' => 'Lỗi truy vấn cơ sở dữ liệu.']);
}
?>