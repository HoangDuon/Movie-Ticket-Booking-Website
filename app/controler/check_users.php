<?php
include "../LTW/app/controler/user_services.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? '';
    $value = trim($_POST['value'] ?? '');
    $user = new user_services();

    if ($type === 'email') {
        if ($user->isEmailExists($value)) {
            echo 'exists';
        } else {
            echo 'not_exists';
        }
    } elseif ($type === 'phone') {
        if ($user->isPhoneExists($value)) {
            echo 'exists';
        } else {
            echo 'not_exists';
        }
    }
}
