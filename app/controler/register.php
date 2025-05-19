<?php
include "user_services.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new user_services();

    if (isset($_POST['btn_reg'])) {
        $full_name = trim($_POST['fullName']);
        $dob = $_POST['dob'];
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Kiểm tra email đã tồn tại
        if ($user->isEmailExists($email)) {
            echo "<script>
                alert('Email đã được sử dụng.');
                window.history.back();
            </script>";
            exit;
        }

        // Kiểm tra số điện thoại đã tồn tại
        if ($user->isPhoneExists($phone)) {
            echo "<script>
                alert('Số điện thoại đã được sử dụng.');
                window.history.back();
            </script>";
            exit;
        }

        // Tạo tài khoản mới
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (full_name, birthday, phone, email, password)
                VALUES (?, ?, ?, ?, ?)";
        pdo_execute($sql, $full_name, $dob, $phone, $email, $hashed_password);

        echo "<script>
            alert('Đăng ký thành công!');
            window.location.href = '/LTW/index.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Không nhận được yêu cầu đăng ký.');
            window.history.back();
        </script>";
        exit;
    }
}
?>
