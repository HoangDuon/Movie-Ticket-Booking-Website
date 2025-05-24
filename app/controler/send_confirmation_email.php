<?php
// File: app/controler/send_confirmation_email.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Đường dẫn này cần chính xác từ vị trí file send_confirmation_email.php
// đến thư mục PHPMailer của bạn.
// Ví dụ nếu send_confirmation_email.php và config/ nằm cùng cấp trong app/controler/
// thì có thể là: require_once __DIR__ . '/../../config/PHPMailer-master/src/Exception.php';
// Dựa trên code gửi OTP của bạn, có vẻ PHPMailer nằm trong thư mục config.
require_once __DIR__ . '/../../config/PHPMailer-master/src/Exception.php'; //
require_once __DIR__ . '/../../config/PHPMailer-master/src/PHPMailer.php'; //
require_once __DIR__ . '/../../config/PHPMailer-master/src/SMTP.php'; //

/**
 * Gửi email xác nhận đặt vé.
 *
 * @param array $bookingDetails Mảng chứa đầy đủ thông tin chi tiết đơn hàng.
 * @return bool True nếu gửi thành công, false nếu thất bại.
 */
function sendBookingConfirmationEmail(array $bookingDetails): bool {
    if (empty($bookingDetails) || !isset($bookingDetails['user_email']) || !filter_var($bookingDetails['user_email'], FILTER_VALIDATE_EMAIL)) {
        error_log("Gửi email xác nhận thất bại: Thông tin đặt vé không đủ hoặc email người dùng không hợp lệ cho booking_id " . ($bookingDetails['booking_id'] ?? 'N/A'));
        return false;
    }

    $mail = new PHPMailer(true);

    try {
        // Cấu hình Server SMTP (giống như file gửi OTP của bạn)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hd34227@gmail.com';      // Email Gmail của bạn
        $mail->Password   = 'sorctpcevisgwwfc';     // App Password của bạn đã tạo cho Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8'; // Rất quan trọng để hiển thị tiếng Việt

        // Người gửi và người nhận
        $mail->setFrom('hd34227@gmail.com', 'CineWave'); // Tên và email người gửi
        $mail->addAddress($bookingDetails['user_email'], $bookingDetails['user_full_name']); // Email và tên người nhận

        // Nội dung Email
        $mail->isHTML(true);
        // Tiêu đề email (UTF-8 encoded)
        $mail->Subject = '=?UTF-8?B?' . base64_encode('CineWave - Xác nhận đặt vé thành công ĐH #' . $bookingDetails['booking_id']) . '?=';

        // Xây dựng nội dung HTML cho email
        $logoUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/LTW/assets/img/logo.png"; // Cập nhật đường dẫn logo của bạn
        $posterBaseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/LTW/";
        
        $full_poster_url = '';
        if (!empty($bookingDetails['poster_url'])) {
             // Kiểm tra xem poster_url đã là URL đầy đủ chưa
            if (strpos($bookingDetails['poster_url'], 'http://') === 0 || strpos($bookingDetails['poster_url'], 'https://') === 0) {
                $full_poster_url = $bookingDetails['poster_url'];
            } else {
                // Nếu là đường dẫn tương đối, nối với base URL
                $full_poster_url = $posterBaseUrl . ltrim($bookingDetails['poster_url'], '/');
            }
        }


        $emailBody = file_get_contents(__DIR__ . '/email_template/booking_confirmation_template.html');
        if ($emailBody === false) {
            error_log("Không thể đọc file template email: email_template/booking_confirmation_template.html");
            return false;
        }
        
        // Thay thế các placeholder trong template
        $emailBody = str_replace('{{LOGO_URL}}', htmlspecialchars($logoUrl), $emailBody);
        $emailBody = str_replace('{{USER_FULL_NAME}}', htmlspecialchars($bookingDetails['user_full_name']), $emailBody);
        $emailBody = str_replace('{{BOOKING_ID}}', htmlspecialchars($bookingDetails['booking_id']), $emailBody);
        $emailBody = str_replace('{{TRANSACTION_CODE}}', htmlspecialchars($bookingDetails['transaction_code'] ?? 'N/A'), $emailBody);
        $emailBody = str_replace('{{BOOKING_TIME}}', (isset($bookingDetails['booking_time']) ? date("H:i:s d/m/Y", strtotime($bookingDetails['booking_time'])) : 'N/A'), $emailBody);
        $emailBody = str_replace('{{PAYMENT_METHOD}}', htmlspecialchars($bookingDetails['payment_method'] ?? 'N/A'), $emailBody);
        
        $emailBody = str_replace('{{POSTER_URL}}', htmlspecialchars($full_poster_url), $emailBody);
        $emailBody = str_replace('{{MOVIE_TITLE}}', htmlspecialchars($bookingDetails['movie_title']), $emailBody);
        $emailBody = str_replace('{{CINEMA_NAME}}', htmlspecialchars($bookingDetails['cinema_name']), $emailBody);
        $emailBody = str_replace('{{CINEMA_LOCATION}}', htmlspecialchars($bookingDetails['cinema_location'] ?? ''), $emailBody);
        $emailBody = str_replace('{{ROOM_NAME}}', htmlspecialchars($bookingDetails['room_name']), $emailBody);
        $emailBody = str_replace('{{START_TIME}}', (isset($bookingDetails['start_time']) ? date("H:i d/m/Y", strtotime($bookingDetails['start_time'])) : 'N/A'), $emailBody);
        $emailBody = str_replace('{{SEAT_COUNT}}', htmlspecialchars($bookingDetails['seat_count']), $emailBody);
        $emailBody = str_replace('{{SEATS_DISPLAY}}', htmlspecialchars($bookingDetails['seats_display']), $emailBody);

        $concessionsHtml = "";
        if (!empty($bookingDetails['concessions_list'])) {
            $concessionsHtml .= "<div class='booking-section'><h2>Đồ ăn/Nước uống</h2>";
            $concessionsHtml .= "<table class='item-list'><thead><tr><th>Tên món</th><th>Số lượng</th><th class='price'>Thành tiền</th></tr></thead><tbody>";
            foreach ($bookingDetails['concessions_list'] as $concession) {
                $concessionsHtml .= "<tr>
                                    <td>" . htmlspecialchars($concession['concession_name']) . "</td>
                                    <td class='quantity'>" . htmlspecialchars($concession['quantity']) . "</td>
                                    <td class='price'>" . number_format($concession['concession_item_total_price'], 0, ',', '.') . " VNĐ</td>
                                   </tr>";
            }
            $concessionsHtml .= "</tbody></table></div>";
        } else {
            $concessionsHtml = "<p>Không có đồ ăn/nước uống nào được đặt.</p>";
        }
        $emailBody = str_replace('{{CONCESSIONS_SECTION}}', $concessionsHtml, $emailBody);
        
        $emailBody = str_replace('{{TOTAL_PRICE}}', number_format($bookingDetails['total_price'], 0, ',', '.'), $emailBody);
        $profileLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/LTW/index.php?page=profile#purchase-history";
        $emailBody = str_replace('{{PROFILE_LINK}}', htmlspecialchars($profileLink), $emailBody);


        $mail->Body    = $emailBody;
        $mail->AltBody = 'Cảm ơn bạn đã đặt vé tại CineWave. Mã đặt vé của bạn là #' . $bookingDetails['booking_id'] . '. Tổng tiền: ' . number_format($bookingDetails['total_price'], 0, ',', '.') . ' VNĐ. Vui lòng kiểm tra email để xem chi tiết dạng HTML.';

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Lỗi gửi email xác nhận cho booking_id {$bookingDetails['booking_id']}: {$mail->ErrorInfo} - Chi tiết: {$e->getMessage()}");
        return false;
    }
}
?>