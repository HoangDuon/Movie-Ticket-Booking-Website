<?php
include_once __DIR__ . '/../model/pdo.php';

$cinema_id = $_GET['cinema_id'] ?? '';
$movie_id = $_GET['movie_id'] ?? '';
$range = $_GET['range'] ?? 'day';
$date = $_GET['date'] ?? date('Y-m-d');

$params = [];
$where = "WHERE payments.payment_status = 'Success'";

// Filter theo rạp
if ($cinema_id !== '') {
    $where .= " AND cinemas.cinema_id = ?";
    $params[] = $cinema_id;
}

// Filter theo phim
if ($movie_id !== '') {
    $where .= " AND movies.movie_id = ?";
    $params[] = $movie_id;
}

$labels = [];
$data = [];
$sql = "";

// Query khung JOIN để lấy movie và cinema
$baseJoin = "
    FROM payments
    JOIN bookings ON payments.booking_id = bookings.booking_id
    JOIN showtimes ON bookings.showtime_id = showtimes.showtime_id
    JOIN rooms ON showtimes.room_id = rooms.room_id
    JOIN cinemas ON rooms.cinema_id = cinemas.cinema_id
    JOIN movies ON showtimes.movie_id = movies.movie_id
";

// Theo ngày
if ($range === 'day') {
    $where .= " AND DATE(payments.payment_time) = ?";
    $params[] = $date;

    $sql = "
        SELECT HOUR(payments.payment_time) as label, SUM(payments.price) as total
        $baseJoin
        $where
        GROUP BY HOUR(payments.payment_time)
        ORDER BY HOUR(payments.payment_time)
    ";

    $result = pdo_query($sql, ...$params);
    for ($i = 0; $i < 24; $i++) {
        $labels[] = sprintf('%02d:00', $i);
        $data[] = 0;
    }
    foreach ($result as $row) {
        $index = (int)$row['label'];
        $data[$index] = (float)$row['total'];
    }
}

// Theo tuần
elseif ($range === 'week') {
    $where .= " AND WEEK(payments.payment_time) = WEEK(?) AND YEAR(payments.payment_time) = YEAR(?)";
    $params[] = $date;
    $params[] = $date;

    $sql = "
        SELECT DAY(payments.payment_time) as label, SUM(payments.price) as total
        $baseJoin
        $where
        GROUP BY DAY(payments.payment_time)
        ORDER BY DAY(payments.payment_time)
    ";

    $result = pdo_query($sql, ...$params);
    for ($i = 1; $i <= 7; $i++) {
        $labels[] = "Ngày $i";
        $data[] = 0;
    }
    foreach ($result as $row) {
        $index = (int)$row['label'] - 1;
        $data[$index] = (float)$row['total'];
    }
}

// Theo tháng
elseif ($range === 'month') {
    $where .= " AND YEAR(payments.payment_time) = YEAR(?)";
    $params[] = $date;

    $sql = "
        SELECT MONTH(payments.payment_time) as label, SUM(payments.price) as total
        $baseJoin
        $where
        GROUP BY MONTH(payments.payment_time)
        ORDER BY MONTH(payments.payment_time)
    ";

    $result = pdo_query($sql, ...$params);
    for ($i = 1; $i <= 12; $i++) {
        $labels[] = "Tháng $i";
        $data[] = 0;
    }
    foreach ($result as $row) {
        $index = (int)$row['label'] - 1;
        $data[$index] = (float)$row['total'];
    }
}

echo json_encode([
    'labels' => $labels,
    'data' => $data
]);
