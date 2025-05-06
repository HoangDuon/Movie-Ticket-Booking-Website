<?php
include_once __DIR__ . '/../model/pdo.php';

class promotions_services{
    public function __construct() {
    }

    public function ShowPromotionsAdmin(){
        $sql = "SELECT * FROM promotions ORDER BY promotion_id DESC";
        return pdo_query($sql);
    }

    public function ShowPromotions(){
        $sql = "SELECT * FROM promotions WHERE hide=0 ORDER BY promotion_id DESC";
        return pdo_query($sql);
    }
}
?>  