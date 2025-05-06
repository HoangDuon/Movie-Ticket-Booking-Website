<?php 
    session_start();
    include "app/view/header.php"; 
    include "app/controler/film_services.php";
    include_once "app/model/pdo.php";
    include "app/controler/promotions_services.php";
?>

<div id="main-content">
    <?php
        $page = $_GET['page'] ?? 'home';

        switch ($page) {
            case 'home':
                include("../LTW/app/view/homepages.php");
                break;
            case 'login':
                include("../LTW/app/view/login.php");
                break;
            case 'movie-details':
                $movie_id = $_GET['id'] ?? null;
                $filmservices=new film_services();
                $film = $filmservices->getMoviebyID($movie_id)[0];
                
                include "../LTW/app/view/movie_details.php";
                break;
            default:
                echo "<h2>404 - Page not found</h2>";
        }
    ?>
</div>
<?php include("app/view/footer.php"); ?>

