<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineWave Cinema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="../LTW/assets/img/favicon.ico">
    <link rel="stylesheet" href="/LTW/assets/css/common.css">
    <link rel="stylesheet" href="../LTW/assets/css/slide.css">
    <link rel="stylesheet" href="../LTW/assets/css/homepage.css">
    <link rel="stylesheet" href="../LTW/assets/css/footer.css">
    <link rel="stylesheet" href="../LTW/assets/css/detail.css">
    <link rel="stylesheet" href="../LTW/assets/css/filter.css">
    <link rel="stylesheet" href="../LTW/assets/css/login.css">
    <link rel="stylesheet" href="../LTW/assets/css/guestInfo.css">
    <link rel="stylesheet" href="../LTW/assets/css/payment.css">
    <link rel="stylesheet" href="../LTW/assets/css/promotion.css">
    <link rel="stylesheet" href="../LTW/assets/css/search.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ef3e2ec704.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../LTW/assets/js/main.js"></script>
    
</head>
<body>
<div class="page-wrapper">
                <header>
                    <div class="header-top">
                        <div class="hd-logo">
                            <a href="index.php?page=home">
                                <img height="130" src="/LTW/assets/img/logo.png" alt="logo">
                            </a>
                        </div>
                
                        <div class="hd-action">
                            <a href="#" id="dat-ve">
                                <img src="https://cinestar.com.vn/assets/images/ic-ticket.svg" alt="">
                                ĐẶT VÉ NGAY
                            </a>
                            <a href="#" id="dat-bapnuoc">
                                <img src="https://cinestar.com.vn/assets/images/ic-cor.svg" alt="">
                                ĐẶT BẮP NƯỚC
                            </a>
                        </div>
            
<div class="hd-searchbar">
    <form class="search-form-wrapper" method="GET" action="index.php">
        <input type="hidden" name="page" value="search_results_movies">
        <div class="input-icon-container">
            <input class="form-control" type="search" name="query_movie" placeholder="Tìm kiếm tên phim..." aria-label="Search"
                   style="padding: 1rem 3rem 1rem 2rem;" value="<?php echo isset($_GET['query_movie']) ? htmlspecialchars($_GET['query_movie']) : ''; ?>">
            <button class="btn-icon-inside" type="submit" aria-label="Tìm kiếm">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </form>
</div>
            
                    <div class="hd-log">
                        <div class="login-ic">
                            <a href="index.php?page=login"> <i class="fa-regular fa-circle-user"></i>
                            </a>
                        </div>
                        <?php
                        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'Customer') {
                            // Khi người dùng đã đăng nhập
                            echo '<div class="login user-dropdown-container">
                                    <a href="javascript:void(0);" class="user-name-link">' .
                                        htmlspecialchars($_SESSION['user']['full_name']) .
                                    '</a>
                                    <ul class="user-options-dropdown"> 
                                        <li><a href="index.php?page=profile">Thông tin cá nhân</a></li>
                                        <li><a class="logout" href="app/controler/logout.php">Đăng xuất</a></li>
                                    </ul>
                                </div>';
                        } else {
                            // Khi người dùng chưa đăng nhập
                            echo '<div class="login">    
                                    <a href="index.php?page=login">
                                        Đăng nhập
                                    </a>                          
                                  </div>';
                        }
                            // echo '<pre>';
                            // var_dump($_SESSION);
                            // echo '</pre>';            
                            ?>
                        </div>
                    </div>                    
                    <div class="header-bottom">
            
                        <div class="hd-bottom-action">
                            <div class="pick-location">
                                <i class="fa-solid fa-location-dot"></i>
                                <a href="#fast-booking">
                                    <h6>Chọn rạp</h6>
                                </a>
                            </div>
                            <div class="calendar">
                                <i class="fa-solid fa-calendar"></i>
                                <a href="#now-showing">
                                    <h6>Lịch chiếu</h6>
                                </a>
                            </div>
                        </div>
            
                        <div class="hd-bottom-information">
                            <ul>
                                <li>
                                    <a href="#showkhuyenmai">Khuyến mãi</a>
                                </li>
                                <li>
                                    <a href="#">Giới thiệu</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </header>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
