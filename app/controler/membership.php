<?php
include_once __DIR__ . '/../model/pdo.php';

class membership {
    public function __construct() {
    }
    
    public function getMembershipInfo() {
    $sql = "SELECT *
            FROM membership_discounts
            ORDER BY order_index ASC";
    return pdo_query($sql);
    }
}