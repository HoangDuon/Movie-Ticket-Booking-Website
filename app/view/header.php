<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinestar Cinema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../LTW/assets/css/slide.css">
    <link rel="stylesheet" href="../LTW/assets/css/homepage.css">
    <link rel="stylesheet" href="../LTW/assets/css/footer.css">
    <link rel="stylesheet" href="../LTW/assets/css/detail.css">
    <link rel="stylesheet" href="../LTW/assets/css/filter.css">
    <link rel="stylesheet" href="../LTW/assets/css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ef3e2ec704.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../LTW/assets/js/main.js"></script>
    
</head>
<body>

        <div class="row">

            <div class="col-1">

            </div>
            <div class="col-12">

                <!-- ------------------- HEADER ----------------------------- -->
                <header>
                    <div class="header-top">
                        <div class="hd-logo">
                            <a href="index.php?page=home">
                                <img src="/LTW/assets/img/cinestar_logo.webp" alt="logo of Cinestar">
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
                            <form class="d-flex" role="search">
                                <input class="form-control me-2" type="search" placeholder="Tìm phim, rạp" aria-label="Search" style="padding: 1rem 2rem;">
                                <button class="btn btn-outline-secondary" type="submit" style="border-radius: 100rem;">
                                    <i class="fa-solid fa-magnifying-glass" style="color: #ced2da;"></i>
                                </button>
                            </form>
                        </div>
            
                    <div class="hd-log">
                        <div class="login-ic">
                            <a href="#"> <i class="fa-regular fa-circle-user"></i>
                            </a>
                        </div>
                        <?php
                        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'Customer') {
                            // Khi người dùng đã đăng nhập
                            echo '<div class="login user-dropdown-container">  
                                    <a href="javascript:void(0);" class="user-name-link"> ' . htmlspecialchars($_SESSION['user']['full_name']) . '
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
                                <a href="#">
                                    <h6>Chọn rạp</h6>
                                </a>
                            </div>
                            <div class="calendar">
                                <i class="fa-solid fa-calendar"></i>
                                <a href="#">
                                    <h6>Lịch chiếu</h6>
                                </a>
                            </div>
                        </div>
            
                        <div class="hd-bottom-information">
                            <ul>
                                <li>
                                    <a href="#">Khuyến mãi</a>
                                </li>
                                <li>
                                    <a href="#">Giới thiệu</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </header>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
