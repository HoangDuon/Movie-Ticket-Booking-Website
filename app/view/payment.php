
<?php
$bookingData = json_decode($_POST['booking_data'], true);
?>  
<body>
    <div class="container-fluid payment-page">
        <!-- Header -->
        <header class="py-4">
            <h1 class="text-white fw-bold">TRANG THANH TOÁN</h1>
        </header>

        <!-- Progress Steps -->
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-10">
                <div class="progress-steps">
                    <div id="step1" class="step active">
                        <div class="step-number">1</div>
                        <div class="step-text">THÔNG TIN KHÁCH HÀNG</div>
                    </div>
                    <div class="step-line" id="line1"></div>
                    <div id="step2" class="step">
                        <div class="step-number">2</div>
                        <div class="step-text">THANH TOÁN</div>
                    </div>
                    <div class="step-line" id="line2"></div>
                    <div id="step3" class="step">
                        <div class="step-number">3</div>
                        <div class="step-text">THÔNG TIN VÉ PHIM</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information Section -->
        <div id="customer-section" class="row">
            <!-- Customer Information Form -->
            <div class="col-12 col-md-6 mb-4">
                <form id="customerForm">
                    <!-- <pre><?php print_r($bookingData); ?></pre> -->
                    <!-- <div class="mb-3">
                        <label for="fullName" class="form-label text-white">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="fullName" placeholder="Họ và tên" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label text-white">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" placeholder="Số điện thoại" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label text-white">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" placeholder="Email" required>
                    </div> -->
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="ageCheck" required>
                        <label class="form-check-label text-white" for="ageCheck">Đảm bảo mua vé đúng số tuổi quy định.</label>
                    </div>
                    
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="termsCheck" required>
                        <label class="form-check-label text-white" for="termsCheck">
                            Đồng ý về <span class="text-warning">điều khoản của Cinestar</span>.
                        </label>
                    </div>
                    
                    <button type="button" id="continueBtn" class="btn btn-warning w-100 py-2 fw-bold">TIẾP TỤC</button>
                </form>
            </div>
            <?php
            
            ?>
            <!-- Movie Information -->
            <div class="col-12 col-md-6 mb-4">
                <div class="movie-info" style="background-color: #2e64c5; color: white; padding: 24px; border-radius: 12px; font-family: 'Arial', sans-serif;">
                <?php
                $Showtime = new cinemas_services();
                $ShowtimeInformation = $Showtime->GetCinemasByShowtimesID($bookingData['showtime_id']);
                ?>  
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <h2 style="font-size: 20px; font-weight: bold;">
                        <?= $ShowtimeInformation['movie_title'] ?>
                    </h2>
                    <div style="background-color: yellow; color: black; padding: 4px 10px; border-radius: 4px; font-weight: bold;">
                        THỜI GIAN GIỮ VÉ: <span id="countdown"></span>
                    </div>
                </div>

                <p class="age-rating mb-3">Phim dành cho khán giả từ đủ 13 tuổi trở lên (13+)</p>

                <h3 style="color: yellow; font-weight: bold; margin: 8px 0 0;"><?= $ShowtimeInformation['cinema_name'] ?></h3>
                <p style="margin-bottom: 16px;"><i class="fas fa-map-marker-alt" style="margin-right: 6px;"></i><?= $ShowtimeInformation['cinema_location'] ?></p>

                <div style="margin-bottom: 8px;">
                    <strong style="color: yellow;">Thời gian:</strong> <?= $ShowtimeInformation['start_time'] ?>
                </div>

                <div style="margin-bottom: 8px;">
                    <strong style="color: yellow;">Phòng chiếu:</strong> <?= $ShowtimeInformation['room_name'] ?> | 
                    <strong style="color: yellow;">Số vé:</strong> <?= count($bookingData['seats']) ?> |
                    <strong style="color: yellow;">Giá vé:</strong> <?= number_format($ShowtimeInformation['price'], 0, ',', '.') ?> VND
                </div>

                <?php foreach ($bookingData['seats'] as $seat): ?>
                <div style="margin-bottom: 8px;">
                    <strong style="color: yellow;">Loại ghế:</strong> <?= $seat['type'] ?> | 
                    <strong style="color: yellow;">Số ghế:</strong> <?= $seat['seatNumber'] ?>
                </div>
                <?php endforeach; ?>

                <div style="margin-top: 12px;">
                    <strong>Bắp nước:</strong>
                </div>
                <?php foreach ($bookingData['concessions'] as $concession): 
                    $concessionService = new concessions_services();
                    $con = $concessionService->GetConcessionByID($concession['concession_id']);
                ?>
                <div>
                    <?= $con['name'] ?> x<?= $concession['quantity'] ?> |
                    <strong style="color: yellow;">Giá:</strong> <?= number_format($con['price'], 0, ',', '.') ?> VND
                </div>
                <?php endforeach; ?>

                <hr style="border-top: 2px dashed #ffee58; margin: 16px 0;">

                <div style="text-align: right;">
                    <h4 style="color: #ffee58; margin-bottom: 4px;">SỐ TIỀN CẦN THANH TOÁN</h4>
                    <h2 style="font-size: 24px; font-weight: bold;">
                        <?= number_format($bookingData['total_price'], 0, ',', '.') ?> VND
                    </h2>
                </div>
            </div>
        </div>

        </div>

        <!-- Payment Section -->
        <div id="payment-section" style="display: none;">
            <div>
                <div class="payment-section">
                    <h2 class="payment-title">THANH TOÁN</h2>
                    
                    <div class="payment-methods">
                        <div class="payment-method">
                            <input type="radio" id="creditCard" name="paymentMethod" checked>
                            <label for="creditCard">
                                <i class="fas fa-credit-card"></i> Thẻ tín dụng/ghi nợ
                            </label>
                        </div>
                        
                        <div class="payment-method">
                            <input type="radio" id="bankTransfer" name="paymentMethod">
                            <label for="bankTransfer">
                                <i class="fas fa-university"></i> Chuyển khoản ngân hàng
                            </label>
                        </div>
                        
                        <div class="payment-method">
                            <input type="radio" id="momo" name="paymentMethod">
                            <label for="momo">
                                <i class="fas fa-wallet"></i> Ví MoMo
                            </label>
                        </div>
                        
                        <div class="payment-method">
                            <input type="radio" id="zalopay" name="paymentMethod">
                            <label for="zalopay">
                                <i class="fas fa-wallet"></i> ZaloPay
                            </label>
                        </div>
                    </div>
                    
                    <button type="button" id="paymentBtn" class="payment-button">THANH TOÁN</button>
                </div>
            </div>
        </div>

        <!-- Ticket Section -->
        <div id="ticket-section" class="row" style="display: none;">
            <div class="col-12">
                <div class="ticket-info-box">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="ticket-container">
                                <!-- Success Message -->
                                <div class="success-message text-center mb-4">
                                    <div class="success-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <h2 class="mt-3 text-white">Đặt vé thành công!</h2>
                                    <p class="text-white">Cảm ơn bạn đã đặt vé tại Cinestar. Thông tin vé của bạn đã được gửi đến email.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../LTW/assets/js/payment.js"></script>
</body>