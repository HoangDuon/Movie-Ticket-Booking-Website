<?php
session_start();
require_once "../model/pdo.php";

$userId = $_SESSION['user']['id'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Kiểm tra xác nhận mật khẩu
if ($new_password !== $confirm_password) {
    echo "<script>
        alert('Mật khẩu xác nhận không khớp.');
        window.history.back(); // Quay lại trang trước
    </script>";
    exit;
}

// Lấy mật khẩu từ DB
$sql = "SELECT password FROM users WHERE user_id = ?";
$user = pdo_query_one($sql, $userId);

if (!$user || !password_verify($current_password, $user['password'])) {
    echo "<script>
        alert('Mật khẩu cũ không đúng.');
        window.history.back();
    </script>";
    exit;
}

// Cập nhật mật khẩu mới
$new_hash = password_hash($new_password, PASSWORD_DEFAULT);
$sql = "UPDATE users SET password = ? WHERE user_id = ?";
pdo_execute($sql, $new_hash, $userId);

// Hiện thông báo thành công và chuyển về profile
echo "<script>
    alert('Đổi mật khẩu thành công!');
    window.location.href = '../../index.php?page=profile';
</script>";
exit;
