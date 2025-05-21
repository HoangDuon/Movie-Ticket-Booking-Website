<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php'; // Nếu dùng Composer
require '../../config/PHPMailer-master/src/PHPMailer.php'; require '../../config/PHPMailer-master/src/SMTP.php'; require '../../config/PHPMailer-master/src/Exception.php';

header('Content-Type: application/json');

// Lấy dữ liệu từ JavaScript
$data = json_decode(file_get_contents('php://input'), true);
$emailOrPhone = trim($data['emailOrPhone'] ?? '');

// echo json_encode([
//     'success' => false,
//     'message' => 'Email không hợp lệ',
//     'Email' => $emailOrPhone,
//     'debug_raw_data' => $data
// ]);
// exit;

if (empty($emailOrPhone) || !filter_var($emailOrPhone, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email không hợp lệ','Email'=> $emailOrPhone]);
    exit;
}

// Tạo mã OTP
$otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
session_start();
$_SESSION['otp'] = $otp;
$_SESSION['otp_email'] = $emailOrPhone;
$_SESSION['otp_expire'] = time() + 60;

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
    $mail->Subject = 'OTP - Password Reset';
    $mail->Body    = "<p>Mã OTP của bạn là: <strong>$otp</strong></p><p>Hiệu lực trong 1 phút.</p>";

    $mail->send();
    echo json_encode(['success' => true, 'message' => 'OTP đã được gửi qua email.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => "Gửi thất bại: {$mail->ErrorInfo}"]);
}
