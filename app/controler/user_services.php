<?php
include_once "../model/pdo.php";

class user_services{
    public function __construct() {
    }

    public function add_User($name,$dob,$phone,$email,$password){
        
        if ($this->isEmailExists($email)) {
            echo "<script>alert('Email đã được sử dụng.');
            window.history.back();
            </script>";
            return;
        }
    
        if ($this->isPhoneExists($phone)) {
            echo "<script>alert('Số điện thoại đã được sử dụng.');
            window.history.back();
            </script>";
            return;
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (full_name, birthday, phone, email, password)
        VALUES (?, ?, ?, ?, ?)";
        pdo_execute($sql, $name, $dob, $phone, $email, $hashed_password);
    }

    public function login($email,$password){
    $sql = "SELECT * FROM users WHERE email = ? and hide=0";
    $user = pdo_query_one($sql, $email);
    if ($user && password_verify($password, $user['password'])) {
        return [    
            'id' => $user['user_id'],
            'full_name' => $user['full_name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'birthday' => $user['birthday'],
            'phone' => $user['phone']
        ];
    }

    return false; 
    }

    public function isEmailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        return pdo_query_value($sql, $email) > 0;
    }
    
    public function isPhoneExists($phone) {
        $sql = "SELECT COUNT(*) FROM users WHERE phone = ?";
        return pdo_query_value($sql, $phone) > 0;
    }

    public function ShowUser(){
        $sql = "SELECT * FROM users ORDER BY user_id DESC";
        return pdo_query($sql);
    }

    public function ShowMembership(){
        $sql = "SELECT * FROM membership_discounts Where hide=0";
        return pdo_query($sql);
    }

    public function ShowUserwithId($id){
        $sql = "SELECT * FROM users WHERE hide=0 and user_id = ? ORDER BY user_id DESC";
        return pdo_query($sql,$id);
    }
}

?>