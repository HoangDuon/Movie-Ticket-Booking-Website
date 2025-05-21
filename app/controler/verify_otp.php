<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$otpInput = trim($data['otp'] ?? '');
$emailInput = trim($data['emailOrPhone'] ?? '');

// Kiểm tra dữ liệu
if (empty($otpInput) || empty($emailInput)) {
    echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu OTP hoặc email']);
    exit;
}

// Kiểm tra OTP đúng và chưa hết hạn
if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_email']) || !isset($_SESSION['otp_expire'])) {
    echo json_encode(['success' => false, 'message' => 'OTP chưa được gửi hoặc đã hết hạn']);
    exit;
}

if ($_SESSION['otp_email'] !== $emailInput) {
    echo json_encode(['success' => false, 'message' => 'Email không khớp với OTP']);
    exit;
}

if (time() > $_SESSION['otp_expire']) {
    echo json_encode(['success' => false, 'message' => 'OTP đã hết hạn']);
    exit;
}

if ($_SESSION['otp'] !== $otpInput) {
    echo json_encode(['success' => false, 'message' => 'Mã OTP không đúng']);
    exit;
}

echo json_encode(['success' => true, 'message' => 'OTP hợp lệ']);
