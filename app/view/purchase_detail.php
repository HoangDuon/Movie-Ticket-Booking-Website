<?php

$booking_id = $_GET['booking_id'] ?? null;

if (!$booking_id) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Không tìm thấy mã đơn hàng.</div></div>";
    exit;
}

if (!$detail) {
    echo "<div class='container py-5'><div class='alert alert-warning'>Không tìm thấy thông tin đơn hàng.</div></div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng #<?= htmlspecialchars($booking_id) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/LTW/assets/css/homepage.css">
    <link rel="stylesheet" href="/LTW/assets/css/footer.css">
    <link rel="stylesheet" href="/LTW/assets/css/purchase_detail.css">
</head>
<body class="purchase-detail-page"> <div class="purchase-main-container"> <div class="purchase-detail-header">
        <h2>Chi tiết đơn hàng #<?= htmlspecialchars($booking_id) ?></h2>
    </div>

    <div class="booking-info-card"> <dl class="row booking-details-list">
                <dt class="col-sm-4">Mã giao dịch:</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($detail['transaction_code'] ?? 'N/A') ?></dd>

                <dt class="col-sm-4">Phim:</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($detail['movie_title'] ?? 'N/A') ?></dd>

                <dt class="col-sm-4">Rạp:</dt>
                <dd class="col-sm-8"><?= htmlspecialchars($detail['cinema_name'] ?? 'N/A') ?> - Phòng <?= htmlspecialchars($detail['room_name'] ?? 'N/A') ?></dd>

                <dt class="col-sm-4">Giờ chiếu:</dt>
                <dd class="col-sm-8"><?= isset($detail['start_time']) ? date("d/m/Y H:i", strtotime($detail['start_time'])) : 'N/A' ?></dd>

                <dt class="col-sm-4">Thời gian đặt vé:</dt>
                <dd class="col-sm-8"><?= isset($detail['booking_time']) ? date("d/m/Y H:i", strtotime($detail['booking_time'])) : 'N/A' ?></dd>
                
                <dt class="col-sm-4">Số lượng vé:</dt>
                <dd class="col-sm-8"><?= isset($detail['seat_count']) ? htmlspecialchars($detail['seat_count']) : 0 ?></dd>

                <dt class="col-sm-4">Ghế đã chọn:</dt>
                <dd class="col-sm-8 selected-seats"><?= isset($detail['seats']) ? htmlspecialchars($detail['seats']) : 'N/A' ?></dd>

                <dt class="col-sm-4 total-price-label">Tổng tiền:</dt>
                <dd class="col-sm-8 total-price-value"><?= isset($detail['total_price']) ? number_format($detail['total_price'], 0, ',', '.') . ' VNĐ' : 'N/A' ?></dd>
            </dl>
        </div>

    <div class="concessions-section">
        <h4>Đồ ăn kèm</h4>
        <?php if (!empty($detail['concessions']) && is_array($detail['concessions'])): ?>
            <div class="table-responsive">
                <table class="table table-hover concessions-table text-center"> <thead>
                        <tr>
                            <th>Tên món</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail['concessions'] as $con): ?>
                            <tr>
                                <td><?= htmlspecialchars($con['name']) ?></td>
                                <td><?= htmlspecialchars($con['quantity']) ?></td>
                                <td><?= number_format($con['total_price'], 0, ',', '.') ?> VNĐ</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-concessions-message">Không có đồ ăn nào được mua trong đơn hàng này.</p>
        <?php endif; ?>
    </div>

    <div class="back-button-container">
        <a href="/LTW/index.php?page=profile" class="btn-custom-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại lịch sử
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
