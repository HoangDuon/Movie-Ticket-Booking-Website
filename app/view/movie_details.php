<?php 

?>


<body>
    <div class="container mt-4">
        <div class="row">
            <?php
                $filmservices=new film_services();
                $showdates=$filmservices->getShowDatesByMovieID($movie_id);
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
                    
                    <h4 class="section-title">COMBO 2 NGĂN</h4>
                    <div class="food-grid">
                        <div class="card bg-dark text-white">
                            <div class="card-body food-card">
                                <img src="https://placehold.co/100x100" alt="Combo Gấu" class="food-img">
                                <h5 class="card-title">COMBO GẤU</h5>
                                <p>1 Coke 32oz + 1 Bắp 2 Ngăn 64OZ Phô Mai + Caramel</p>
                                <p class="card-text">119,000 VND</p>
                                <div class="quantity-control">
                                    <button class="quantity-btn minus" data-type="combo1">-</button>
                                    <input type="text" class="quantity-input" value="0" id="combo1-quantity" readonly>
                                    <button class="quantity-btn plus" data-type="combo1">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="card bg-dark text-white">
                            <div class="card-body food-card">
                                <img src="https://placehold.co/100x100" alt="Combo Có Gấu" class="food-img">
                                <h5 class="card-title">COMBO CÓ GẤU</h5>
                                <p>2 Coke 32oz + 1 Bắp 2 Ngăn 64OZ Phô Mai + Caramel</p>
                                <p class="card-text">129,000 VND</p>
                                <div class="quantity-control">
                                    <button class="quantity-btn minus" data-type="combo2">-</button>
                                    <input type="text" class="quantity-input" value="0" id="combo2-quantity" readonly>
                                    <button class="quantity-btn plus" data-type="combo2">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h4 class="section-title mt-4">NƯỚC NGỌT</h4>
                    <div class="food-grid">
                        <div class="card bg-dark text-white">
                            <div class="card-body food-card">
                                <img src="https://placehold.co/100x100" alt="Sprite" class="food-img">
                                <h5 class="card-title">SPRITE 32OZ</h5>
                                <p class="card-text">37,000 VND</p>
                                <div class="quantity-control">
                                    <button class="quantity-btn minus" data-type="sprite">-</button>
                                    <input type="text" class="quantity-input" value="0" id="sprite-quantity" readonly>
                                    <button class="quantity-btn plus" data-type="sprite">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="card bg-dark text-white">
                            <div class="card-body food-card">
                                <img src="https://placehold.co/100x100" alt="Coke" class="food-img">
                                <h5 class="card-title">COKE 32OZ</h5>
                                <p class="card-text">37,000 VND</p>
                                <div class="quantity-control">
                                    <button class="quantity-btn minus" data-type="coke">-</button>
                                    <input type="text" class="quantity-input" value="0" id="coke-quantity" readonly>
                                    <button class="quantity-btn plus" data-type="coke">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Fixed booking bar -->
    <div class="fixed-bar">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src=" ../LTW/assets/js/detail.js"></script>
</body>