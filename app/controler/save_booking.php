<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "../model/pdo.php";

$data = json_decode(file_get_contents("php://input"), true);
var_dump($data);

// Kiểm tra dữ liệu đầu vào
if (!$data || !isset($data['showtime_id'], $data['seats'], $data['total_price'], $data['txnRef'])) {
    http_response_code(400);
    echo json_encode(["error" => "Thiếu dữ liệu bắt buộc"]);
    exit;
}

$showtime_id = $data['showtime_id'];
$seats = $data['seats'];
$concessions = $data['concessions'] ?? [];
$total_price = $data['total_price'];
$txnRef = $data['txnRef'];

// user_id giả định đã đăng nhập (bạn thay bằng session khi có auth)
$user_id = $_SESSION['user']['id'];

// 1. Kiểm tra txnRef đã tồn tại trong bảng payments chưa (tránh trùng)
$sql_check = "SELECT COUNT(*) FROM payments WHERE transaction_code = ?";
if (pdo_query_value($sql_check, $txnRef) > 0) {
    echo json_encode(["message" => "Đã lưu rồi"]);
    exit;
}

// 2. Lưu vào `bookings`
$sql_booking = "INSERT INTO bookings (user_id, showtime_id, total_price) VALUES (?, ?, ?)";
$booking_id = pdo_execute_return_last_id($sql_booking, $user_id, $showtime_id, $total_price);

$sql_details = "INSERT INTO booking_details (booking_id, seat_id) VALUES (?, ?)";
foreach ($seats as $seat) {
    // (Giả định mỗi item có `concession_id`, `quantity`)
    $seat_id = $seat['id'];

    pdo_execute($sql_details, $booking_id,$seat_id);
}

// 4. Lưu bắp nước vào `booking_concessions`
$sql_con = "INSERT INTO booking_concessions (booking_id, concession_id, quantity, total_price) VALUES (?, ?, ?, ?)";
foreach ($concessions as $item) {
    // (Giả định mỗi item có `concession_id`, `quantity`)
    $concession_id = $item['concession_id'];
    $quantity = $item['quantity'];

    // Lấy giá từ bảng `concessions` (nếu cần)
    $concession = pdo_query_one("SELECT price FROM concessions WHERE concession_id = ?", $concession_id);
    $unit_price = $concession ? $concession['price'] : 0;
    $total = $unit_price * $quantity;

    pdo_execute($sql_con, $booking_id, $concession_id, $quantity, $total);
}

// 5. Lưu thông tin vào `payments`
$sql_payment = "INSERT INTO payments (booking_id, user_id, price, payment_method, transaction_code, payment_status)
                VALUES (?, ?, ?, ?, ?, ?)";
$payment_method = 'VNPAY'; // hoặc lấy từ `bookingData.payment_method`
$payment_status = 'Success';
pdo_execute($sql_payment, $booking_id, $user_id, $total_price, $payment_method, $txnRef, $payment_status);

// 6. Trả kết quả
echo json_encode(["success" => true, "booking_id" => $booking_id]);
exit;
