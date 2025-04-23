<?php
include_once __DIR__ . '/../model/pdo.php';

class film_services{
    public function __construct() {
    }

    public function ShowFilmAdmin(){
        $sql = "SELECT * FROM movies ORDER BY movie_id DESC";
        return pdo_query($sql);
    }

    public function ShowShowtimesFilmAdmin(){
        $sql = "SELECT s.showtime_id, m.title AS movie_title, c.name AS cinema_name, r.name AS room_name, 
                    s.start_time, s.end_time, s.price, s.hide
                FROM showtimes s
                JOIN movies m ON s.movie_id = m.movie_id
                JOIN rooms r ON s.room_id = r.room_id
                JOIN cinemas c ON r.cinema_id = c.cinema_id
                ORDER BY s.start_time DESC";
        return pdo_query($sql);
    }

    public function getBannerMovie() {
        $sql = "SELECT *
                FROM movies
                WHERE hide = 0
                AND banner_url is not null
                AND banner_url != ' '
                ORDER BY order_index ASC";
        return pdo_query($sql);
    }

    public function getMovieInfo() {
        $sql = "SELECT *
                FROM movies
                ORDER BY order_index ASC";
        return pdo_query($sql);
    }
}
?>  