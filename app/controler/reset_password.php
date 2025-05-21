<?php
session_start();
require_once "../model/pdo.php";

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['emailOrPhone']) || !isset($data['newPassword'])) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
    exit;
}

$emailOrPhone = trim($data['emailOrPhone']);
$newPassword = $data['newPassword'];

// Validate mật khẩu mới
if (strlen($newPassword) < 6) {
    echo json_encode(['success' => false, 'message' => 'Mật khẩu mới phải có ít nhất 6 ký tự']);
    exit;
}

// Lấy thông tin user theo email hoặc phone
$sql = "SELECT user_id FROM users WHERE email = ? OR phone = ?";
$user = pdo_query_one($sql, $emailOrPhone, $emailOrPhone);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'Không tìm thấy tài khoản']);
    exit;
}

// Mã hóa mật khẩu mới
$new_hash = password_hash($newPassword, PASSWORD_DEFAULT);

// Cập nhật mật khẩu mới
$sql = "UPDATE users SET password = ? WHERE user_id = ?";
pdo_execute($sql, $new_hash, $user['user_id']);

// Trả về success
echo json_encode(['success' => true]);
exit;
