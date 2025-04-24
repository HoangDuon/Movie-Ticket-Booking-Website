<?php
require_once "../model/pdo.php"; // hoặc đường dẫn tới file DAO
include "user_services.php";
$users = new user_services();

// Lấy dữ liệu từ POST
$id = $_POST['id'] ?? '';
$name = $_POST['full_name'];
$dob = $_POST['birthday'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$member = $_POST['member'];
$role = $_POST['role'];
$password = $_POST['password'];
$user = $users->ShowUserwithId($id);
if($password != $user['password']){
    $password = password_hash($password, PASSWORD_DEFAULT);
}

// Thêm mới
if (empty($id)) {
    $sql = "INSERT INTO users (full_name, birthday, phone, email ,`member`, `role`, password)
        VALUES (?, ?, ?, ?, ?,? , ?)";
    pdo_execute($sql, $name, $dob, $phone, $email, $member, $role, $password);
} else {
    // Cập nhật
    $sql = "UPDATE users SET full_name=?, birthday=?, phone=?, email=?, `member`=?, `role`=?";
    $params = [$name, $dob, $phone, $email, $member, $role];

    $sql .= " WHERE user_id=?";
    $params[] = $id;

    pdo_execute($sql, ...$params);
}
header("Location: ../view/admin.php");
// echo '<pre>';
// print_r($_FILES);
// echo '</pre>';
exit;

?>