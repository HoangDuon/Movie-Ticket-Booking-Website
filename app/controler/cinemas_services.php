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

    public function ShowCinemas(){
        $sql = "SELECT 
            c.cinema_id, 
            c.name,
            c.location ,
            c.phone , 
            c.hide
        FROM cinemas c Where hide=0";

        return pdo_query($sql);
    }

    public function GetCinemasByShowtimesID($ShowtimeId){
        $sql = "SELECT 
            m.title AS movie_title,
            c.name AS cinema_name,
            c.location AS cinema_location,
            s.start_time,
            s.end_time,
            s.price,
            r.name AS room_name
            FROM showtimes s
            JOIN movies m ON s.movie_id = m.movie_id
            JOIN rooms r ON s.room_id = r.room_id
            JOIN cinemas c ON r.cinema_id = c.cinema_id
            WHERE s.showtime_id = ?;
        ";

        return pdo_query_one($sql,$ShowtimeId);
    }
}
?>  