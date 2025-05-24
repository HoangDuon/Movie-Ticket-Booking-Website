<?php 
    session_start();
    include "app/view/header.php"; 
    include "app/controler/film_services.php";
    include_once "app/model/pdo.php";
    include "app/controler/promotions_services.php";
    include "app/controler/concessions_services.php";
    include "app/controler/cinemas_services.php";
    include "app/controler/membership.php";
    include "app/controler/get_purchase_history.php";

    $filmService = new film_services();
?>

<div id="main-content">
    <?php
        $page = $_GET['page'] ?? 'home';
        $search_query_movie = trim($_GET['query_movie'] ?? ''); 
        if (!empty($search_query_movie) && $page === 'search_results_movies') {
            $searchResults = $filmService->searchMovies($search_query_movie);
            
            $search_query = $search_query_movie;
            
            if (file_exists("app/view/search_result_movies_view.php")) {
                include "app/view/search_result_movies_view.php";
                
            } else {
                echo "<h2>Lỗi: Không tìm thấy trang hiển thị kết quả tìm kiếm.</h2>";
            }
        } else {
        switch ($page) {
            case 'home':
                include("../LTW/app/view/homepages.php");
                break;
            case 'login':
                include("../LTW/app/view/login.php");
                break;
            case 'profile':
                include("../LTW/app/view/profile.php");
                break;
            case 'payment':
                include("../LTW/app/view/payment.php");
                break;
            case 'promotion-details':
                $promotion_id = $_GET['id'] ?? null;
                $promotionservices=new promotions_services();
                $promotion = $promotionservices->getPromotionbyID($promotion_id);
                
                include "../LTW/app/view/promotion_details.php";
                break;
            case 'movie-details':
                $movie_id = $_GET['id'] ?? null;
                $filmservices=new film_services();
                $film = $filmservices->getMoviebyID($movie_id)[0];
                
                include "../LTW/app/view/movie_details.php";
                break;
            case 'purchase-detail':
                $booking_id = $_GET['booking_id'] ?? null;
                $historyFetcher = new get_purchase_history();
                $detail = $historyFetcher->getDetailByBookingID($booking_id);
                include("../LTW/app/view/purchase_detail.php");
                break;
            default:
                echo "<h2>404 - Page not found</h2>";
        }
    }
    ?>
</div>
<?php include("app/view/footer.php"); ?>

