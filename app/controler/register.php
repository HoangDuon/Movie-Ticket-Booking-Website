<?php
include "user_services.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST);
    exit;
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    $user = new user_services();
    if (isset($_POST['btn_reg'])) {
        $full_name = $_POST['fullName'];
        $dob = $_POST['dob'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user->add_User($full_name, $dob, $phone, $email, $password);;
    } else {
        echo "Không có name='btn_reg' gửi lên.";
    }
    // header("Location: /LTW/index.php");
}
?>