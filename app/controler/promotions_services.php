<?php
include_once __DIR__ . '/../model/pdo.php';

class promotions_services{
    public function __construct() {
    }

    public function ShowPromotionsAdmin(){
        $sql = "SELECT * FROM promotions ORDER BY promotion_id DESC";
        return pdo_query($sql);
    }
}
?>  