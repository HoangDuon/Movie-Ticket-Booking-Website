<?php
// session_start();
require_once __DIR__ . '/../model/pdo.php';

// Kiểm tra người dùng đã đăng nhập hay chưa
$user_id = $_SESSION['user']['id'] ?? null;

class get_purchase_history {
    public function __construct() {
    }

    public function getHistoryForUser($userId) {
        if (!$userId) {
            return []; // Nếu không có user ID, trả về mảng rỗng
        }

        $sql = "SELECT 
                    b.booking_id,
                    m.title AS movie_title, -- Thêm lại tên phim
                    c.name AS cinema_name,
                    b.booking_time,
                    b.total_price,
                    p.transaction_code
                FROM bookings b
                JOIN showtimes s ON b.showtime_id = s.showtime_id
                JOIN movies m ON s.movie_id = m.movie_id -- Thêm join với bảng movies
                JOIN rooms r ON s.room_id = r.room_id
                JOIN cinemas c ON r.cinema_id = c.cinema_id
                JOIN payments p ON b.booking_id = p.booking_id -- JOIN với bảng payments
                WHERE b.user_id = ? AND b.hide = 0 -- Thêm điều kiện hide = 0 nếu cần
                ORDER BY b.booking_time DESC";

        try {
            // Truyền $userId vào cho pdo_query
            return pdo_query($sql, $userId);
        } catch (PDOException $e) {
            // Ghi log lỗi thay vì echo trực tiếp
            error_log("Lỗi khi lấy lịch sử mua hàng cho user $userId: " . $e->getMessage());
            return []; // Trả về mảng rỗng nếu có lỗi
        }
    }

    public function getDetailByBookingID($booking_id) {
        // Lấy thông tin chính
        $sql = "
            SELECT 
                p.transaction_code,
                b.booking_time,
                b.total_price,
                m.title AS movie_title,
                c.name AS cinema_name,
                r.name AS room_name,
                s.start_time
            FROM payments p
            JOIN bookings b ON p.booking_id = b.booking_id
            JOIN showtimes s ON b.showtime_id = s.showtime_id
            JOIN movies m ON s.movie_id = m.movie_id
            JOIN rooms r ON s.room_id = r.room_id
            JOIN cinemas c ON r.cinema_id = c.cinema_id
            WHERE p.booking_id = ?
            LIMIT 1
        ";
        $bookingInfo = pdo_query_one($sql, $booking_id);

        // Lấy danh sách ghế đã đặt
        $sqlSeats = "
            SELECT seats.seat_number
            FROM booking_details
            JOIN seats ON booking_details.seat_id = seats.seat_id
            WHERE booking_details.booking_id = ?
        ";
        $seatRows = pdo_query($sqlSeats, $booking_id);

        $seatList = array_column($seatRows, 'seat_number');
        $bookingInfo['seats'] = implode(', ', $seatList);
        $bookingInfo['seat_count'] = count($seatList);
        $sqlConcessions = "
            SELECT c.name, bc.quantity, bc.total_price
            FROM booking_concessions bc
            JOIN concessions c ON bc.concession_id = c.concession_id
            WHERE bc.booking_id = ?
        ";
        $concessionRows = pdo_query($sqlConcessions, $booking_id);
        $bookingInfo['concessions'] = $concessionRows;

        return $bookingInfo;
    }

public function getFullBookingDetailsForEmail($booking_id) {
        // Lấy thông tin chính và bổ sung thông tin người dùng, poster phim
        $sql = "
            SELECT 
                p.transaction_code,
                b.booking_id,          -- Thêm booking_id để chắc chắn có
                b.booking_time,
                b.total_price,
                u.full_name AS user_full_name, 
                u.email AS user_email,         
                m.title AS movie_title,
                m.poster_url,                  
                c.name AS cinema_name,
                c.location AS cinema_location, 
                r.name AS room_name,
                s.start_time,
                s.end_time,
                p.payment_method              -- Thêm phương thức thanh toán
            FROM payments p
            JOIN bookings b ON p.booking_id = b.booking_id
            JOIN users u ON b.user_id = u.user_id 
            JOIN showtimes s ON b.showtime_id = s.showtime_id
            JOIN movies m ON s.movie_id = m.movie_id
            JOIN rooms r ON s.room_id = r.room_id
            JOIN cinemas c ON r.cinema_id = c.cinema_id
            WHERE p.booking_id = ? AND p.payment_status = 'Success' 
            ORDER BY p.payment_time DESC -- Lấy thông tin payment thành công mới nhất
            LIMIT 1
        ";
        // Hàm pdo_query_one được định nghĩa trong file pdo.php
        $bookingInfo = pdo_query_one($sql, $booking_id); 

        if (!$bookingInfo) {
            error_log("Không tìm thấy thông tin booking hoặc payment không thành công cho booking_id: " . $booking_id);
            return null;
        }

        // Lấy danh sách ghế đã đặt
        $sqlSeats = "
            SELECT seats.seat_number, seats.seat_type
            FROM booking_details
            JOIN seats ON booking_details.seat_id = seats.seat_id
            WHERE booking_details.booking_id = ?
        ";
        // Hàm pdo_query được định nghĩa trong file pdo.php
        $seatRows = pdo_query($sqlSeats, $booking_id); 

        $seatList = array_column($seatRows, 'seat_number');
        $bookingInfo['seats_display'] = implode(', ', $seatList);
        $bookingInfo['seat_count'] = count($seatList);

        // Lấy danh sách đồ ăn kèm
        $sqlConcessions = "
            SELECT c.name as concession_name, bc.quantity, bc.total_price as concession_item_total_price 
            FROM booking_concessions bc
            JOIN concessions c ON bc.concession_id = c.concession_id
            WHERE bc.booking_id = ?
        ";
        $concessionRows = pdo_query($sqlConcessions, $booking_id);
        $bookingInfo['concessions_list'] = $concessionRows;

        return $bookingInfo;
    }
}
