<?php
include_once "../model/pdo.php";

class film_services{
    public function __construct() {
    }

    public function ShowFilmAdmin(){
        $sql = "SELECT * FROM movies ORDER BY movie_id DESC";
        return pdo_query($sql);
    }
}
?>  