<?php
require_once "../model/pdo.php";
class dashboard_admin_service {

    public function __construct() {
    }
    public function getTodayRevenue() {
        $sql = "
            SELECT SUM(price) as total_revenue
            FROM payments
            WHERE payment_status = 'success'
              AND DATE(payment_time) = CURDATE()
        ";

        $result = pdo_query_one($sql);
        return $result['total_revenue'] ?? 0; // Trả về 0 nếu không có kết quả
    }
}
?>