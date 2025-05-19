<?php
session_start();
include "user_services.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // var_dump($_POST);
    // exit;   

    $user = new user_services();
    $email = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user_info = $user->login($email, $password);

    if ($user_info) {

        unset($_SESSION['login_error_message_text']); // Xóa lỗi nếu có từ lần trước
        $_SESSION['user'] = $user_info;
        if ($user_info['role'] === 'Admin') {
            header("Location: /LTW/app/view/admin.php");
        } else {
            header("Location: /LTW/index.php");
        }
        exit();
        } else {
            $_SESSION['login_error_message_text'] = "Thông tin đăng nhập chưa chính xác, vui lòng nhập lại.";
            header("Location: /LTW/index.php?page=login"); // Chuyển hướng về trang login
            exit();
        }
}
?>
