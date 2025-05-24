<?php
session_start();
require_once "../model/pdo.php";

$userId = $_SESSION['user']['id'];
$fullname = trim($_POST['fullname']);
$birthdate = $_POST['birthdate'];
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);

$sql = "UPDATE users SET
    full_name = ?,
    email = ?,
    phone = ?,
    birthday = ?
WHERE
    user_id = ?;
";

pdo_execute($sql, $fullname,$email,$phone,$birthdate,$userId);

$sqlGet = "SELECT * FROM users WHERE user_id = ?";
$user = pdo_query_one($sqlGet, $userId);
$_SESSION['user'] = [
    'id' => $user['user_id'],
    'full_name' => $user['full_name'],
    'email' => $user['email'],
    'role' => $user['role'],
    'birthday' => $user['birthday'],
    'phone' => $user['phone'],
    'member' => $user['member']
];

header("Location: ../../index.php?page=profile");
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
exit;

?>