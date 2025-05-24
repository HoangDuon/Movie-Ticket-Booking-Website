<?php
include "cinemas_services.php";
include "concessions_services.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php'; // Nếu dùng Composer
require '../../config/PHPMailer-master/src/PHPMailer.php'; require '../../config/PHPMailer-master/src/SMTP.php'; require '../../config/PHPMailer-master/src/Exception.php';

header('Content-Type: application/json');

// Lấy dữ liệu từ JavaScript
$data = json_decode(file_get_contents('php://input'), true);
$emailOrPhone = trim($data['email'] ?? '');
$showtime_id = $data['showtime_id'] ?? '';
$seats = $data['seats'] ?? [];
$concessions = $data['concessions'] ?? [];
$total_price = $data['total_price'] ?? 0;
$discount = $data['discount'] ?? 0;

if (empty($emailOrPhone) || !filter_var($emailOrPhone, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email không hợp lệ']);
    exit;
}

// Ví dụ tạm lấy thông tin showtime theo ID
$Showtime = new cinemas_services();
$ShowtimeInformation = $Showtime->GetCinemasByShowtimesID($showtime_id );

$html = '<div style="font-family:Arial,sans-serif;padding:20px;max-width:600px;margin:auto;border:1px solid #ddd;">
    <h2 style="text-align:center;color:#333;">🎟️ Chi tiết đơn hàng</h2>
    
    <p><strong>🎬 Phim:</strong> ' . $ShowtimeInformation['movie_title'] . '</p>
    <p><strong>🏢 Rạp:</strong> ' . $ShowtimeInformation['cinema_name'] . ' - ' . $ShowtimeInformation['cinema_location'] . '</p>
    <p><strong>🕒 Giờ chiếu:</strong> ' . $ShowtimeInformation['start_time'] . '</p>
    <p><strong>🎫 Số lượng vé:</strong> ' . count($seats) . '</p>';

if (count($seats) > 0) {
    $html .= '<p><strong>🪑 Ghế đã chọn:</strong> ' . implode(', ', array_map(fn($s) => $s['seatNumber'], $seats)) . '</p>';
    $html .= '<ul style="padding-left:20px;">';
    foreach ($seats as $seat) {
        $html .= '<li>' . $seat['seatNumber'] . ' - ' . $seat['type'] . ' - ' . number_format($seat['price'], 0, ',', '.') . ' VNĐ</li>';
    }
    $html .= '</ul>';
} else {
    $html .= '<p><strong>🪑 Ghế đã chọn:</strong> (không có)</p>';
}

// Đồ ăn kèm
if (count($concessions) > 0) {
    $html .= '<h3 style="margin-top:20px;">🍿 Đồ ăn kèm</h3>
    <table style="border-collapse: collapse; width:100%; margin-top:10px;">
        <thead>
            <tr style="background-color:#f2f2f2;">
                <th style="border:1px solid #ddd;padding:8px;">Tên món</th>
                <th style="border:1px solid #ddd;padding:8px;">Số lượng</th>
                <th style="border:1px solid #ddd;padding:8px;">Giá</th>
            </tr>
        </thead>
        <tbody>';
    foreach ($concessions as $item) {
        $concessionService = new concessions_services();
        $con = $concessionService->GetConcessionByID($item['concession_id']);
        $tongGia = $con['price'] * $item['quantity'];
        $html .= '<tr>
            <td style="border:1px solid #ddd;padding:8px;">' . $con['name'] . '</td>
            <td style="border:1px solid #ddd;padding:8px;text-align:center;">' . $item['quantity'] . '</td>
            <td style="border:1px solid #ddd;padding:8px;">' . number_format($tongGia, 0, ',', '.') . ' VNĐ</td>
        </tr>';
    }
    $html .= '</tbody></table>';
}

$html .= '<p style="margin-top:20px;"><strong>💸 Giảm giá:</strong> ' . intval($discount) . '%</p>';
$html .= '<p style="color:red;font-size:18px;font-weight:bold;text-align:right;margin-top:10px;">Tổng tiền: ' . number_format($total_price, 0, ',', '.') . ' VNĐ</p>';
$html .= '</div>';



$mail = new PHPMailer(true);
try {
    // Cấu hình SMTP Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'hd34227@gmail.com';       // Email Gmail của bạn
    $mail->Password   = 'sorctpcevisgwwfc';          // App password (KHÔNG phải mật khẩu Gmail)
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Gửi từ đâu và đến đâu
    $mail->setFrom('hd34227@gmail.com', 'CINEWAVE');
    $mail->addAddress($emailOrPhone);

    // Nội dung mail
    $mail->isHTML(true);
    $mail->Subject = 'TICKET INFORMATION';
    $mail->Body    = $html;

    $mail->send();
    echo json_encode(['success' => true, 'message' => 'Thông tin đặt vé đã được gửi qua email.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Gửi thất bại: {$mail->ErrorInfo}"]);
}
