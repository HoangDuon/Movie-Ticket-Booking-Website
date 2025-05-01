<?php
include_once __DIR__ . '/../model/pdo.php';

class cinemas_services{
    public function __construct() {
    }

    public function ShowCinemasAdmin(){
        $sql = "SELECT 
            c.cinema_id, 
            c.name,
            c.location ,
            c.phone , 
            c.hide,
            COUNT(DISTINCT r.room_id) AS `Số Phòng`, 
            COUNT(DISTINCT CASE WHEN s.end_time > NOW() THEN s.showtime_id END) AS `Số Suất Chiếu` 
        FROM cinemas c 
        LEFT JOIN rooms r ON c.cinema_id = r.cinema_id 
        LEFT JOIN showtimes s ON r.room_id = s.room_id 
        GROUP BY c.cinema_id, c.name, c.location, c.phone 
        ORDER BY c.order_index IS NULL, c.order_index ASC, c.created_at DESC";

        return pdo_query($sql);
    }
}
?>  