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

    public function getPromotionbyID($promotion_id){
        $sql = "SELECT * FROM promotions WHERE hide=0 and promotion_id=?";
        return pdo_query_one($sql,$promotion_id);
    }

    public function GetMemberDiscountByName($member){
        $sql = "SELECT discount_percent 
        FROM membership_discounts 
        WHERE hide = 0 AND member_type = ? 
        LIMIT 1";
    return pdo_query_value($sql, $member);
    }
}
?>  