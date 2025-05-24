<?php
// payment.php

// Khởi tạo các biến để truyền cho JavaScript
$vnpay_success_script = "";

// Xử lý VNPAY Return (nếu có tham số từ VNPAY)
if (isset($_GET['vnp_Amount'])) { // Dấu hiệu có redirect từ VNPAY về
    $vnp_TmnCode = "6F05EVIZ"; // Mã website tại VNPAY (CẦN GIỐNG TRÊN vnpay_create_payment.php)
    $vnp_HashSecret = "6HMGVY19V4IKB4YMA6MPL4W1RDD6NOOI"; // Chuỗi bí mật (CẦN GIỐNG TRÊN vnpay_create_payment.php)
    
    $vnp_SecureHash = $_GET['vnp_SecureHash'];
    $inputData = array();
    foreach ($_GET as $key => $value) {
        if (substr($key, 0, 4) == "vnp_") {
            $inputData[$key] = $value;
        }
    }
    
    unset($inputData['vnp_SecureHash']); // Xóa vnp_SecureHash ra khỏi dữ liệu để tạo hash so sánh
    ksort($inputData);
    $i = 0;
    $hashData = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }

    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
    $vnp_ResponseCode = $inputData['vnp_ResponseCode'];
    $vnp_TxnRef = $inputData['vnp_TxnRef']; // Mã giao dịch VNPAY trả về

    if ($secureHash == $vnp_SecureHash) {
        if ($vnp_ResponseCode == '00') {
            // Thanh toán thành công
            // TODO: Bạn nên cập nhật trạng thái đơn hàng trong database tại đây
            $vnpay_success_script = "<script>var vnpaySuccess = true; var vnpayBookingId = '" . htmlspecialchars($vnp_TxnRef) . "'; var vnpayMessage = 'Giao dịch thành công';</script>";
        } else {
            // Thanh toán thất bại
            $vnpay_success_script = "<script>var vnpaySuccess = false; var vnpayMessage = 'Giao dịch không thành công (Mã lỗi: " . htmlspecialchars($vnp_ResponseCode) . ")';</script>";
        }
    } else {
        // Sai chữ ký
        $vnpay_success_script = "<script>var vnpaySuccess = false; var vnpayMessage = 'Sai chữ ký VNPAY.';</script>";
    }
}

// Lấy dữ liệu booking_data nếu có (từ POST request ban đầu khi vào trang payment)
$bookingData = [];
if (isset($_POST['booking_data'])) {
    $bookingData = json_decode($_POST['booking_data'], true);
}
// Giả sử $bookingData['tongtien'] chứa tổng số tiền
$tongtien_display = isset($bookingData['total_price']) ? number_format($bookingData['total_price']) . "VND" : "0VND";

?>
<!DOCTYPE html> 
<body>
    <div class="payment-page">
        <header class="py-4">
            <h1 class="text-white fw-bold">TRANG THANH TOÁN</h1>
        </header>

        <!-- Progress Steps -->
        <div class="container-fluid row justify-content-center mb-4 mt-4">
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

        <div class="container-fluid row justify-content-center mb-4">
            </div>

        <div id="customer-section" class="container-fluid row" <?php if (isset($_GET['vnp_Amount'])) echo 'style="display:none;"'; ?>> <div class="col-12 col-md-6 mb-4">
                <form id="customerForm">
                    <!-- <pre><?php print_r($bookingData); ?></pre> -->
            <h4 class="text-white mb-3">Thông tin người nhận vé</h4>
            <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])): // Kiểm tra xem người dùng đã đăng nhập chưa ?>
                <?php
                // Lấy thông tin người dùng từ session
                $loggedInUserFullName = htmlspecialchars($_SESSION['user']['full_name'] ?? '');
                $loggedInUserEmail = htmlspecialchars($_SESSION['user']['email'] ?? '');
                $loggedInUserPhone = htmlspecialchars($_SESSION['user']['phone'] ?? '');
                ?>
                <div class="mb-3">
                    <label for="fullName" class="form-label text-white">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fullName" placeholder="Họ và tên" required 
                           value="<?= $loggedInUserFullName ?>" readonly>
                           </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label text-white">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="phone" placeholder="Số điện thoại" required
                           value="<?= $loggedInUserPhone ?>" readonly>
                           </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label text-white">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" placeholder="Email" required
                           value="<?= $loggedInUserEmail ?>" readonly>
                           </div>
            <?php else: // Trường hợp người dùng chưa đăng nhập ?>
                <p class="text-white mb-3" style="font-size: 2rem;">Vui lòng <a href="index.php?page=login&return_url=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="text-warning">đăng nhập</a> để tiếp tục đặt vé.</p>
                <div class="mb-3">
                    <label for="fullName" class="form-label text-white">Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fullName" placeholder="Họ và tên" required disabled>
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label text-white">Số điện thoại <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="phone" placeholder="Số điện thoại" required disabled>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label text-white">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" placeholder="Email" required disabled>
                </div>
            <?php endif; ?>
                    
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
            
            <div class="col-12 col-md-6 mb-4">
                <div class="movie-info">
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
                        <strong style="color: yellow;">Số vé:</strong> <?= (isset($bookingData['seats']) && is_array($bookingData['seats'])) ? count($bookingData['seats']) : 0 ?> |
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
                        $tongGia = $con['price'] * $concession['quantity']; 
                    ?>
                    <div>
                        <?= $con['name'] ?> x<?= $concession['quantity'] ?> |
                        <strong style="color: yellow;">Giá:</strong> <?= number_format($tongGia, 0, ',', '.') ?> VND
                    </div>
                    <?php endforeach; ?>
                    
                    <hr style="border-top: 2px dashed #ffee58; margin: 16px 0;">

                    <div style="text-align: right;">
                        <h5 style="color:rgb(252, 252, 252); margin-bottom: 4px;">GIẢM GIÁ HẠNG THÀNH VIÊN: <?php echo $bookingData['discount']; ?>%</h5>
                        <h4 style="color: #ffee58; margin-bottom: 4px;">SỐ TIỀN CẦN THANH TOÁN</h4>
                        <h2 style="font-size: 24px; font-weight: bold;">
                            <p class="total-price"><?php echo $tongtien_display; ?></p>
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <div id="payment-section" style="display: none;" class="container-fluid " <?php if (isset($_GET['vnp_Amount'])) echo 'style="display:none;"'; ?>> <div>
                <div class="payment-section">
                    <h2 class="payment-title">THANH TOÁN</h2>
                    
                    <div class="payment-methods">
                        <div class="payment-method">
                            <input type="radio" id="bankTransfer" name="paymentMethod"> <label for="bankTransfer">
                                <i class="fas fa-university"></i> Thanh toán qua VNPAY </label>
                        </div>
                    </div>
                    <button type="button" id="paymentBtn" class="payment-button">THANH TOÁN</button>
                </div>
            </div>
        </div>

        <div id="ticket-section" class="container-fluid row" style="display: none;">
            <div class="col-12">
                <div class="ticket-info-box">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="ticket-container">
                                <div class="success-message text-center mb-4">
                                    <div class="success-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <h2 class="mt-3 text-white">Đặt vé thành công!</h2>
                                    <p class="text-white">Cảm ơn bạn đã đặt vé tại Cinestar. Thông tin vé của bạn đã được gửi đến email.</p>
                                </div>
                                <div class="ticket-details">
                                    <p>Mã đặt vé: <span id="booking-id"></span></p>
                                    <p>Tên khách hàng: <span id="customer-name"></span></p>
                                    <p>Số điện thoại: <span id="customer-phone"></span></p>
                                    <p>Email: <span id="customer-email"></span></p>
                                    <p>Phương thức thanh toán: <span id="payment-method"></span></p>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h1></h1>
        </div>
    </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $vnpay_success_script; // Chèn script báo trạng thái VNPAY ?>
    <script>
        window.bookingData = <?php echo json_encode($bookingData); ?>;
        window.bookingDataVNPAY = <?php echo json_encode($_SESSION['bookingData'] ?? []); ?>;
    </script>
    <script src="../LTW/assets/js/payment.js"></script> </body>
</html>