<!-- --------------------------------------- content ------------------------------------------------------------------------------------------------- -->

<div class="container">
<div class="main-slide">
                <div id="carouselExample" class="carousel slide">
                    <?php
                        $filmService = new film_services();
                        $films = $filmService->getBannerMovie();
                    ?>

                        <div class="carousel-inner">
                        <?php
                            $isFirst = true;
                            foreach($films as $film):
                        ?>
                            <div class="carousel-item  <?= $isFirst ? 'active' : '' ?>">
                                <img src="<?= $film['banner_url']?>" class="d-block w-100" alt="banner-<?= $film['title']?>">
                            </div>
                        <?php 
                        $isFirst = false;
                    endforeach; ?>
                            
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
        
                <div class="container-fluid">
                    <div class="filter-film">
                        <div class="filter-heading">
                            <h1>ĐẶT VÉ NHANH</h1>
                        </div>
                        <div class="filter-group">
                            <div class="filter-1">
                                <div class="dropdown">
                                    <button id="filter-btn" class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="heading-dropdown">1. Chọn rạp</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="filter-2">
                                <div class="dropdown">
                                    <button id="filter-btn" class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="heading-dropdown">2. Chọn phim</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="filter-3">
                                <div class="dropdown">
                                    <button id="filter-btn" class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="heading-dropdown">3. Chọn ngày</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="filter-4">
                                <div class="dropdown">
                                    <button id="filter-btn" class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span id="heading-dropdown">4. Chọn suất</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="btn-order">
                                <a href="#" id="order-now">ĐẶT NGAY</a>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="heading-phim dang-chieu">
                    <h1>PHIM ĐANG CHIẾU</h1>
                </div>
        
                <div class="showing-movie-slide">
                    <div id="carouselExampleIndicators" class="carousel slide" style="padding-bottom: 5rem;">

                        <?php
                            // Lấy dữ liệu phim (Giữ nguyên phần này)
                            $filmService = new film_services();
                            $films = $filmService->getMovieInfo(); // Giả sử trả về mảng các phim

                            // Chia mảng $films thành các nhóm, mỗi nhóm tối đa 4 phần tử
                            $itemsPerSlide = 4;
                            $filmChunks = []; // Khởi tạo mảng chứa các nhóm phim
                            if (!empty($films)) { // Chỉ chia nếu có phim
                                $filmChunks = array_chunk($films, $itemsPerSlide);
                            }
                            $totalSlides = count($filmChunks); // Tổng số slide
                        ?>

                        <div class="carousel-indicators">
                            <?php if ($totalSlides > 0): ?>
                                <?php for ($i = 0; $i < $totalSlides; $i++): ?>
                                    <button type="button"
                                            data-bs-target="#carouselExampleIndicators"
                                            data-bs-slide-to="<?= $i ?>"
                                            class="<?= ($i == 0) ? 'active' : '' ?>"
                                            aria-current="<?= ($i == 0) ? 'true' : 'false' ?>"
                                            aria-label="Slide <?= $i + 1 ?>">
                                    </button>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>

                        <div class="carousel-inner">
                            <?php
                            // Kiểm tra xem có nhóm phim nào không
                            if (!empty($filmChunks)):
                                // Lặp qua từng nhóm phim (mỗi nhóm là một slide)
                                foreach ($filmChunks as $index => $chunk):
                                    // Xác định slide đầu tiên cần có class 'active'
                                    $activeClass = ($index == 0) ? 'active' : '';
                            ?>
                                    <div class="carousel-item <?= $activeClass ?>">
                                        <div class="row row-cols-1 row-cols-md-4 g-4">
                                            <?php
                                            // Lặp qua từng phim trong nhóm hiện tại ($chunk)
                                            foreach ($chunk as $film):
                                            ?>
                                                <div class="col">
                                                    <div id="movie-poster" name="movie-poster-<?= htmlspecialchars($film['movie_id'] ?? '') ?>" class="card h-100">
                                                        <img src="<?= htmlspecialchars($film['poster_url'] ?? 'path/to/default/image.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($film['title'] ?? 'Movie Poster') ?>">
                                                        <div class="card-body d-flex flex-column">
                                                            <h5 class="movie-title"><?= htmlspecialchars($film['title'] ?? 'Không có tiêu đề') ?></h5>
                                                            <div class="card-bottom mt-auto">
                                                                <p class="card-text">
                                                                    <?php if(!empty($film['trailer_url'])): ?>
                                                                        <a href="<?= htmlspecialchars($film['trailer_url']) ?>" target="_blank">
                                                                            <i class="fa-solid fa-video" style="color: #ffffff;"></i>
                                                                            Xem Trailer
                                                                        </a>
                                                                    <?php else: ?>
                                                                        <span>&nbsp;</span>
                                                                    <?php endif; ?>
                                                                </p>
                                                                <a href="index.php?page=movie-details&id=<?= htmlspecialchars($film['movie_id'] ?? '') ?>" class="btn btn-primary">
                                                                    <p class="btn-datve">ĐẶT VÉ</p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            // Kết thúc vòng lặp cho từng phim trong chunk
                                            endforeach;
                                            ?>
                                        </div>
                                    </div>
                            <?php
                                // Kết thúc vòng lặp cho từng chunk (slide)
                                endforeach;
                            else:
                                // Trường hợp không có phim nào
                            ?>
                                <div class="carousel-item active">
                                    <div class="row row-cols-1 row-cols-md-4 g-4">
                                        <div class="col">
                                            <p>Không có phim nào để hiển thị.</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; // Kết thúc kiểm tra !empty($filmChunks) ?>

                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
        
                <div class="heading-phim sap-chieu">
                    <h1>PHIM SẮP CHIẾU</h1>
                </div>
            
                <div class="slide-phimsapchieu">
                    <div id="carouselExampleIndicators1" class="carousel slide" style="padding-bottom: 5rem;">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
        
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="container text-center">
                                    <div class="row">
                                        <div class="col">
                                            <div id="movie-poster" class="card">
                                                <a href="#">
                                                    <img src="../img/thieu-nu-anh-trang-image.webp" class="card-img-top" alt="...">
                                                </a>
                                                <div class="movie-info">
                                                    <div class="card-body">
                                                        <h5 class="movie-title">THIẾU NỮ ÁNH TRĂNG</h5>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <p class="card-text">
                                                            <a href="#">
                                                                <i class="fa-solid fa-video" style="color: #ffffff;"></i>
                                                                Xem Trailer</a>
                                                        </p>
                                                        <a href="#" class="btn btn-primary">
                                                            <p class="btn-datve">ĐẶT VÉ</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div id="movie-poster" class="card">
                                                <a href="#">
                                                    <img src="../img/giai-cuu-quan-su-image.webp" class="card-img-top" alt="...">
                                                </a>
                                                <div class="movie-info">
                                                    <div class="card-body">
                                                        <h5 class="movie-title">NINJA RINTARO: GIẢI CỨU QUÂN SƯ</h5>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <p class="card-text">
                                                            <a href="#">
                                                                <i class="fa-solid fa-video" style="color: #ffffff;"></i>
                                                                Xem Trailer</a>
                                                        </p>
                                                        <a href="#" class="btn btn-primary">
                                                            <p class="btn-datve">ĐẶT VÉ</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div id="movie-poster" class="card">
                                                <a href="#">
                                                    <img src="../img/cuoc-xe-kinh-hoang-image.webp" class="card-img-top" alt="...">
                                                </a>
                                                <div class="movie-info">
                                                    <div class="card-body">
                                                        <h5 class="movie-title">CUỐC XE KINH HOÀNG</h5>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <p class="card-text">
                                                            <a href="#">
                                                                <i class="fa-solid fa-video" style="color: #ffffff;"></i>
                                                                Xem Trailer</a>
                                                        </p>
                                                        <a href="#" class="btn btn-primary">
                                                            <p class="btn-datve">ĐẶT VÉ</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div id="movie-poster" class="card">
                                                <a href="#">
                                                    <img src="../img/gau-yeu-cua-anh-image.webp" class="card-img-top" alt="...">
                                                </a>
                                                <div class="movie-info">
                                                    <div class="card-body">
                                                        <h5 class="movie-title">GẤU YÊU CỦA ANH</h5>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <p class="card-text">
                                                            <a href="#">
                                                                <i class="fa-solid fa-video" style="color: #ffffff;"></i>
                                                                Xem Trailer</a>
                                                        </p>
                                                        <a href="#" class="btn btn-primary">
                                                            <p class="btn-datve">ĐẶT VÉ</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="container text-center">
                                    <div class="row">
                                        <div class="col">
                                            <div id="movie-poster" class="card">
                                                <a href="#">
                                                    <img src="../img/gau-yeu-cua-anh-image.webp" class="card-img-top" alt="...">
                                                </a>
                                                <div class="movie-info">
                                                    <div class="card-body">
                                                        <h5 class="movie-title">GẤU YÊU CỦA ANH</h5>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <p class="card-text">
                                                            <a href="#">
                                                                <i class="fa-solid fa-video" style="color: #ffffff;"></i>
                                                                Xem Trailer</a>
                                                        </p>
                                                        <a href="#" class="btn btn-primary">
                                                            <p class="btn-datve">ĐẶT VÉ</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div id="movie-poster" class="card">
                                                <a href="#">
                                                    <img src="../img/minecraft-image.webp" class="card-img-top" alt="...">
                                                </a>
                                                <div class="movie-info">
                                                    <div class="card-body">
                                                        <h5 class="movie-title">MINECRAFT</h5>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <p class="card-text">
                                                            <a href="#">
                                                                <i class="fa-solid fa-video" style="color: #ffffff;"></i>
                                                                Xem Trailer</a>
                                                        </p>
                                                        <a href="#" class="btn btn-primary">
                                                            <p class="btn-datve">ĐẶT VÉ</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div id="movie-poster" class="card">
                                                <a href="#">
                                                    <img src="../img/lac-troi-image.webp" class="card-img-top" alt="...">
                                                </a>
                                                <div class="movie-info">
                                                    <div class="card-body">
                                                        <h5 class="movie-title">LẠC TRÔI (P)</h5>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <p class="card-text">
                                                            <a href="#">
                                                                <i class="fa-solid fa-video" style="color: #ffffff;"></i>
                                                                Xem Trailer</a>
                                                        </p>
                                                        <a href="#" class="btn btn-primary">
                                                            <p class="btn-datve">ĐẶT VÉ</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div id="movie-poster" class="card">
                                                <a href="#">
                                                    <img src="../img//little-emma-image.webp" class="card-img-top" alt="...">
                                                </a>
                                                <div class="movie-info">
                                                    <div class="card-body">
                                                        <h5 class="movie-title">EMMA VÀ VƯƠNG QUỐC TÍ HON (P)</h5>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <p class="card-text">
                                                            <a href="#">
                                                                <i class="fa-solid fa-video" style="color: #ffffff;"></i>
                                                                Xem Trailer</a>
                                                        </p>
                                                        <a href="#" class="btn btn-primary">
                                                            <p class="btn-datve">ĐẶT VÉ</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="container text-center">
                                    <div class="row">
                                        <div class="col">
                                            <div id="movie-poster" class="card">
                                                <a href="#">
                                                    <img src="../img/dao-cuong-sat-image.webp" class="card-img-top" alt="...">
                                                </a>
                                                <div class="movie-info">
                                                    <div class="card-body">
                                                        <h5 class="movie-title">MOBILE SUIT GUNDAM GQUUUUUUX -KỶ NGUYÊN MỚI</h5>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <p class="card-text">
                                                            <a href="#">
                                                                <i class="fa-solid fa-video" style="color: #ffffff;"></i>
                                                                Xem Trailer</a>
                                                        </p>
                                                        <a href="#" class="btn btn-primary">
                                                            <p class="btn-datve">ĐẶT VÉ</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div id="movie-poster" class="card">
                                                <a href="#">
                                                    <img src="../img/ky-nguyen-moi-image.webp" class="card-img-top" alt="...">
                                                </a>
                                                <div class="movie-info">
                                                    <div class="card-body">
                                                        <h5 class="movie-title">VIETNAMESE CONCERT FILM: CHÚNG TA LÀ NGƯỜI VIỆT NAM (P)</h5>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <p class="card-text">
                                                            <a href="#">
                                                                <i class="fa-solid fa-video" style="color: #ffffff;"></i>
                                                                Xem Trailer</a>
                                                        </p>
                                                        <a href="#" class="btn btn-primary">
                                                            <p class="btn-datve">ĐẶT VÉ</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div id="movie-poster" class="card">
                                                <a href="#">
                                                    <img src="../img/hoang-thuy-linh-concert-image.webp" class="card-img-top" alt="...">
                                                </a>
                                                <div class="movie-info">
                                                    <div class="card-body">
                                                        <h5 class="movie-title">ĐẢO CUỒNG SÁT (T18)</h5>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <p class="card-text">
                                                            <a href="#">
                                                                <i class="fa-solid fa-video" style="color: #ffffff;"></i>
                                                                Xem Trailer</a>
                                                        </p>
                                                        <a href="#" class="btn btn-primary">
                                                            <p class="btn-datve">ĐẶT VÉ</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div id="movie-poster" class="card">
                                                <a href="#">
                                                    <img src="../img/hien-me-cho-quy-image.webp" class="card-img-top" alt="...">
                                                </a>
                                                <div class="movie-info">
                                                    <div class="card-body">
                                                        <h5 class="movie-title">CƯỚI MA (T18)</h5>
                                                    </div>
                                                    <div class="card-bottom">
                                                        <p class="card-text">
                                                            <a href="#">
                                                                <i class="fa-solid fa-video" style="color: #ffffff;"></i>
                                                                Xem Trailer</a>
                                                        </p>
                                                        <a href="#" class="btn btn-primary">
                                                            <p class="btn-datve">ĐẶT VÉ</p>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
        
                <div class="heading-phim khuyen-mai">
                    <h1>KHUYẾN MÃI</h1>
                </div>
        
                <div class="sales">
                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
        
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="../img/sales-1.webp" id="card-img-sales" class="card-img-top" alt="...">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="../img/sales-2.webp" id="card-img-sales" class="card-img-top" alt="...">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="../img/sales-3.webp" id="card-img-sales" class="card-img-top" alt="...">
                                        </div>
                                    </div>
        
                                    </div>
                            </div>
                            <div class="carousel-item">
        
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="../img/sales-3.webp" id="card-img-sales" class="card-img-top" alt="...">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="../img/sales-2.webp" id="card-img-sales" class="card-img-top" alt="...">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="../img/sales-1.webp" id="card-img-sales" class="card-img-top" alt="...">
                                        </div>
                                    </div>
        
                            </div>
        
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
        
                <div class="heading-phim members">
                    <h1>CHƯƠNG TRÌNH THÀNH VIÊN</h1>
                </div>
        
                <div class="members-info">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="normal-members">
                                    <div class="card">
                                        <img src="../img/c'vip.webp" class="card-img-top" alt="..." style="box-shadow: 0 12px 48px 0 rgba(243,234,40,.5);">
                                        <div class="card-body">
                                            <h5 class="card-title">THÀNH VIÊN C'VIP</h5>
                                            <p class="card-text">Thẻ C'Friend nhiều ưu đãi dành cho thành viên mới.</p>
                                            <a href="#" class="btn btn-primary">TÌM HIỂU NGAY</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col">
                                <div class="vip-members">
                                    <div class="card">
                                        <img src="../img/c'friend.webp" class="card-img-top" alt="..." style="box-shadow: 0 12px 48px 0 rgba(243,234,40,.5)">
                                        <div class="card-body">
                                            <h5 class="card-title">THÀNH VIÊN C'FRIEND</h5>
                                            <p class="card-text">Thẻ VIP mang đến nhiều ưu đãi độc quyền.</p>
                                            <a href="#" class="btn btn-primary">TÌM HIỂU NGAY</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
            <div class="col-1">

            </div>
        </div>
    </div>
    </div>