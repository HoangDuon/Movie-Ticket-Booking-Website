<?php
session_start();
include "user_services.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // var_dump($_POST);
    // exit;   

    $user = new user_services();
    $email = $_POST['username'];
    $password = $_POST['password'];

    $user_info = $user->login($email, $password);

    if ($user_info) {
        $_SESSION['user'] = $user_info;
        if ($user_info['role'] === 'Admin') {
            header("Location: /LTW/app/view/admin.php");
        } else {
            header("Location: /LTW/index.php");
        }
        exit();
        } else {
                echo "<script>
                    alert('Sai tài khoản hoặc mật khẩu');
                    window.history.back();
                    </script>";
                exit;
        }

    
}
?>