<?php 
    include "app/view/header.php"; 
    include "app/controler/film_services.php";
    include_once "app/model/pdo.php";
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
            default:
                echo "<h2>404 - Page not found</h2>";
        }
    ?>
</div>
<?php include("app/view/footer.php"); ?>

