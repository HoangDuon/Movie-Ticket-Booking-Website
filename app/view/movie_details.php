
<body>
    <div class="container mt-4">
        <div class="row">
            <?php
                $filmservices=new film_services();
                $showdates=$filmservices->getShowDatesByMovieID($movie_id);
                $movieId = $_GET['id'] ?? null;
                $cinemaId = $_GET['cinema_id'] ?? null;
                $showtimeId = $_GET['showtime_id'] ?? null;
                $showDateFromShowtime = null;
                if ($showtimeId) {
                    $showDateFromShowtime = $filmservices->getShowDateByShowtimeId($showtimeId);
                }
            ?>
            <div class="col-md-4">
                <img src=<?= $film['poster_url']?> alt=<?= $film['title']?> class="movie-poster">
            </div>
            <div class="col-md-8">
                <h2><?= $film['title']?></h2>
                <p><i class="fas fa-film"></i> <?= $film['genre']?> | <?= $film['duration']?>' | <?= $film['language']?></p>
                <h4>Mô Tả</h4>
                <p><?= $film['description']?></p>
                <a href="<?= $film['trailer_url'] ?>" target="_blank">
                    <button class="btn btn-danger">
                        <i class="fas fa-play"></i> Xem Trailer
                    </button>
                </a>
            </div>
        </div>
        
        <!-- Section: Lịch Chiếu -->
        <div id="booking-content">
            <div class="booking-section" id="schedule-section">
                <h3 class="mt-4">Lịch Chiếu</h3>
                <div class="d-flex gap-3">
                <?php foreach ($showdates as $showdate): ?>
                    <button 
                        class="btn date-btn"
                        onclick="showSchedule('<?= $movie_id ?>','<?= $showdate['show_date'] ?>')"
                        data-date="<?= $showdate['show_date'] ?>"
                        data-movie-id="<?= $movie_id ?>">
                        <?= $showdate['show_date'] ?>
                    </button>

                <?php endforeach; ?>

                </div>
                <h3 class="mt-4">Danh Sách Rạp</h3>
                <div id="cinema-list" style="display: none;">
                    <!-- Các rạp sẽ được hiển thị tùy theo ngày được chọn -->                    
                </div>
            </div>
            
            <!-- Các phần khác sẽ hiển thị sau khi chọn giờ chiếu -->
            <div class="additional-content" style="display: none;" id="addtional">
                <!-- Section: Chọn Loại Vé -->
                <h3 class="mt-4">CHỌN GHẾ</h3>
                <!-- Section: Chọn Ghế -->
                <div class="booking-section" id="seats-section">

                </div>

                <div class="seat-legend">
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #fff;"></div>
                            <span>Ghế Thường</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #fff;"></div>
                            <span>Ghế Vip</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #fff; width: 40px;"></div>
                            <span>Ghế Đôi (2 Người)</span>
                        </div>
                        
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #ffc107;"></div>
                            <span>Ghế Chọn</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color" style="background-color: #6c757d;"></div>
                            <span>Ghế Đã Đặt</span>
                        </div>
                </div>
                
                <!-- Section: Chọn Bắp Nước -->
                <div class="booking-section" id="concession-section">
                    <h3 class="mt-4">Chọn Bắp Nước</h3>
                    <?php
                    $concessionService= new concessions_services();
                    $concessions = $concessionService->ShowConcessions();                   
                    ?>
                    <div class="food-grid">
                    <?php foreach ($concessions as $concession): ?>
                        <div class="card bg-dark text-white">
                            <div class="card-body food-card">
                                <img src="<?= $concession['picture_link']?>" alt="<?= $concession['name']?>" class="food-img">
                                <h5 class="card-title"><?= $concession['name']?></h5>
                                <p class="card-text"><?= intval($concession['price'])?> VND</p>
                                <div class="quantity-control">
                                    <button class="quantity-btn minus" data-type="<?= $concession['name']?>">-</button>
                                    <input type="text" class="quantity-input" value="0" id="<?= $concession['concession_id']?>-quantity" readonly>
                                    <button class="quantity-btn plus" data-type="<?= $concession['name']?>">+</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Fixed booking bar -->
    <div class="fixed-bar" style="display: none;">
        <div class="fixed-bar-left">
            <div class="fixed-bar-timer">
                <div class="timer-label">Thời gian giữ vé:</div>
                <div id="timer">05:00</div>
            </div>
            <div class="booking-summary">
                <p class="mb-0" id="booking-summary">Vui lòng chọn lịch chiếu</p>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <div class="booking-total" id="booking-total">0 VND</div>
            <button id="book-btn" class="booking-btn">ĐẶT VÉ</button>
        </div>
    </div>
    <script>
    // Gán các biến PHP vào biến toàn cục JS
    window.presetMovieId = "<?= $movieId ?>";
    window.presetCinemaId = "<?= $cinemaId ?>";
    window.presetShowtimeId = "<?= $showtimeId ?>";
    window.presetShowDate = "<?= $showDateFromShowtime ?>";
    window.presetMovieId = "123";
    window.presetCinemaId = "5";
    window.presetShowtimeId = "10";
    window.presetShowDate = "2025-05-20";
    console.log(window.presetMovieId, window.presetCinemaId,window.presetShowDate)
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src=" ../LTW/assets/js/detail.js"></script>
</body>