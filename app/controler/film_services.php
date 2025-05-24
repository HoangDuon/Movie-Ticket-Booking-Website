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
        // Cập nhật tất cả các suất chiếu đã kết thúc và thay đổi hide thành 1
        $sql = "UPDATE showtimes
            SET hide = 1
            WHERE end_time < NOW() AND hide = 0"; // Kiểm tra những suất chiếu chưa bị ẩn và đã kết thúc
        pdo_execute($sql);

        // // Cập nhật tất cả các ghế đã booked
        // $sql = "UPDATE seats
        //     SET status = 'Available'
        //     WHERE end_time < NOW() AND hide = 0"; // Kiểm tra những suất chiếu chưa bị ẩn và đã kết thúc
        // pdo_execute($sql);

        $sql = "SELECT 
                s.showtime_id, 
                m.title AS movie_title, 
                c.name AS cinema_name, 
                r.name AS room_name, 
                c.cinema_id as cinemas_id,
                s.movie_id,
                s.room_id, 
                s.start_time, 
                s.end_time, 
                s.price, 
                s.hide,
                m.hide as movie_hide,
                r.hide as room_hide,
                c.hide as cinema_hide
            FROM showtimes s
            JOIN movies m 
                ON s.movie_id = m.movie_id   -- Chỉ lấy phim không ẩn
            JOIN rooms r 
                ON s.room_id = r.room_id   -- Chỉ lấy phòng không ẩn
            JOIN cinemas c 
                ON r.cinema_id = c.cinema_id  -- Chỉ lấy rạp không ẩn 
            ORDER BY s.start_time DESC;  -- Sắp xếp theo thời gian bắt đầu của suất chiếu
            ";

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

    public function getMoviebyID($id) {
        $sql = "SELECT *
                FROM movies
                WHERE movie_id = $id";
        return pdo_query($sql);
    }

    function getShowDatesByMovieID($movie_id) {
        $sql = "SELECT DISTINCT DATE(start_time) AS show_date 
                FROM showtimes 
                WHERE movie_id = ? and hide=0
                ORDER BY show_date ASC";
        return pdo_query($sql, $movie_id);
    }

        function getShowDateByShowtimeId($showtimeId) {
        $sql = "SELECT DISTINCT DATE(start_time) AS show_date 
                FROM showtimes 
                WHERE showtime_id = ? ";
        return pdo_query($sql, $showtimeId);
    }

    public function getMovieInfo() {
        $sql = "UPDATE showtimes
            SET hide = 1
            WHERE end_time < NOW() AND hide = 0"; // Kiểm tra những suất chiếu chưa bị ẩn và đã kết thúc
        pdo_execute($sql);
        $sql = "SELECT *
                FROM movies
                WHERE release_date < NOW() and hide=0
                ORDER BY order_index ASC";
        return pdo_query($sql);
    }

    public function getUpcomingMovies() {
        $sql = "SELECT *
                FROM movies
                WHERE release_date > NOW()
                AND hide = 0
                ORDER BY release_date ASC";
        return pdo_query($sql);
    }
    
    // public function getSaleInfo() {
    //     $sql = "SELECT *
    //             FROM sales              
    //             WHERE release_date > NOW()"
    //     return pdo_query($sql);
    // }

public function searchMovies($keyword) {
    if (empty(trim($keyword))) {
        return [];
    }

    $searchTerm = "%" . trim($keyword) . "%";

    $sql = "SELECT 
                movie_id, 
                title, 
                poster_url, 
                description,
                genre,
                duration,
                director,
                release_date 
            FROM movies 
            WHERE (title LIKE ? 
                   OR director LIKE ? 
                   OR cast LIKE ? 
                   OR description LIKE ?
                   OR genre LIKE ?)
              AND hide = 0
            ORDER BY release_date DESC, title ASC";

    return pdo_query($sql, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
}
}
?>  