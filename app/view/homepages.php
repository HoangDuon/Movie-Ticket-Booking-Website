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
                                <img id="banner-movie" src="<?= $film['banner_url']?>" class="d-block w-100" alt="banner-<?= $film['title']?>">
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
                <?php
                $CinemaService = new cinemas_services(); // Khởi tạo service
                $cinemas= $CinemaService->ShowCinemas();
                ?>
                <div class="container-fluid">
                    <div class="filter-film">
                        <div class="filter-heading">
                            <h1>ĐẶT VÉ NHANH</h1>
                        </div>
                        <div class="filter-group">
                            <div class="container mt-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <select id="cinema-select" class="form-select">
                                            <option value=""> 1. Chọn rạp </option>
                                            <?php foreach ($cinemas as $cinema): ?>
                                                <option value="<?= $cinema['cinema_id'] ?>"><?= $cinema['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="movie-select" class="form-select" disabled>
                                            <option value=""> 2. Chọn phim </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select id="showtime-select" class="form-select" disabled>
                                            <option value=""> 3. Chọn suất chiếu </option>
                                        </select>
                                    </div>
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
                            $filmService = new film_services();
                            $films = $filmService->getMovieInfo(); // Giả sử trả về mảng các phim

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

                        <?php
                            // --- PHP Lấy và chuẩn bị dữ liệu ---
                            try {
                                $filmService = new film_services(); // Khởi tạo service

                                // *** Sử dụng phương thức mới để lấy phim sắp chiếu ***
                                $upcomingFilms = $filmService->getUpcomingMovies();

                                // Chia mảng phim sắp chiếu thành các nhóm 4 phim
                                $itemsPerSlide = 4;
                                $upcomingFilmChunks = [];
                                if (!empty($upcomingFilms)) {
                                    $upcomingFilmChunks = array_chunk($upcomingFilms, $itemsPerSlide);
                                }
                                $totalSlides = count($upcomingFilmChunks); // Tổng số slide cần tạo

                            } catch (Exception $e) {
                                // Xử lý lỗi nếu có vấn đề khi lấy dữ liệu
                                error_log("Lỗi khi lấy dữ liệu phim sắp chiếu: " . $e->getMessage());
                                $upcomingFilmChunks = []; // Đảm bảo là mảng rỗng nếu lỗi
                                $totalSlides = 0;
                            }
                        ?>

                        <div class="carousel-indicators">
                            <?php // Tạo indicators động dựa trên số slide
                            if ($totalSlides > 0):
                                for ($i = 0; $i < $totalSlides; $i++):
                            ?>
                                    <button type="button"
                                            data-bs-target="#carouselExampleIndicators1"
                                            data-bs-slide-to="<?= $i ?>"
                                            class="<?= ($i == 0) ? 'active' : '' ?>"
                                            aria-current="<?= ($i == 0) ? 'true' : 'false' ?>"
                                            aria-label="Slide <?= $i + 1 ?>">
                                    </button>
                            <?php
                                endfor;
                            endif;
                            ?>
                        </div>

                        <div class="carousel-inner">
                            <?php
                            // Kiểm tra xem có dữ liệu phim sắp chiếu không
                            if (!empty($upcomingFilmChunks)):
                                // Lặp qua từng nhóm phim (mỗi nhóm là 1 slide)
                                foreach ($upcomingFilmChunks as $index => $chunk):
                                    $activeClass = ($index == 0) ? 'active' : ''; // Xác định slide active
                            ?>
                                    <div class="carousel-item <?= $activeClass ?>">
                                        <div class="container text-center">
                                            <div class="row row-cols-1 row-cols-md-4 g-4">
                                                <?php
                                                // Lặp qua từng phim trong nhóm hiện tại
                                                foreach ($chunk as $film):
                                                    // Định dạng ngày phát hành (tùy chọn)
                                                    $releaseDateFormatted = 'N/A';
                                                    if (!empty($film['release_date'])) {
                                                        try {
                                                            $dt = new DateTime($film['release_date']);
                                                            $releaseDateFormatted = $dt->format('d/m/Y');
                                                        } catch (Exception $e) { /* Bỏ qua lỗi ngày không hợp lệ */ }
                                                    }
                                                    // Tạo link chi tiết phim
                                                    $detailLink = "index.php?page=movie-details&id=" . htmlspecialchars($film['movie_id'] ?? '');
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

                                                <?php endforeach; // Kết thúc vòng lặp phim trong chunk ?>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                endforeach; // Kết thúc vòng lặp qua các chunk
                            else: // Trường hợp không có phim sắp chiếu nào
                            ?>
                                <div class="carousel-item active">
                                    <div class="container text-center">
                                        <div class="row">
                                            <div class="col">
                                                <p class="my-5">Chưa có thông tin phim sắp chiếu.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;?>
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
                            <?php
                            $promotionsservices= new promotions_services();
                            $promotions = $promotionsservices->ShowPromotions();
                            $chunks = array_chunk($promotions, 3);
                            foreach ($chunks as $index => $chunk) {
                                $active = $index == 0 ? 'active' : '';
                                echo '<div class="carousel-item ' . $active . '">';
                                echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
                                foreach ($chunk as $img) {
                                    echo '<div class="col">';
                                    echo '  <div class="card h-100">';
                                    echo '    <img src="/assets/img/sales-2.webp" class="card-img-top" alt="...">';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
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
					<?php
						$membershipinfo = new membership();
						$memberships = $membershipinfo->getMembershipInfo();
					?>
					<div class="container">
						<div class="row">
							<?php foreach ($memberships as $member): ?>
								<div class="col">
									<div class="card">
										<img src="<?= htmlspecialchars($member['link']) ?>" class="card-img-top" alt="..." style="box-shadow: 0 12px 48px 0 rgba(243,234,40,.5);">
										<div class="card-body">
											<h5 class="card-title">THÀNH VIÊN <?= htmlspecialchars($member['member_type']) ?></h5>
											<a href="#" class="btn btn-primary">TÌM HIỂU NGAY</a>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
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
    <!-- <script src="../LTW/assets/js/homepages.js"></script> -->
    <script src="../LTW/assets/js/filter.js"></script>