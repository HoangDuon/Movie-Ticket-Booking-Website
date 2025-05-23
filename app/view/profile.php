<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-1"></div>
            <div class="col-md-2 sidebar">
                <div class="user-profile">
                    <div class="avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h4><?= htmlspecialchars($_SESSION['user']['full_name']) ?></h4>
                </div>
                
                <div class="sidebar-menu">
                    <div class="menu-item" data-section="customer-info">
                        <i class="fas fa-user"></i>
                        <span>Thông tin khách hàng</span>
                    </div>
                    <div class="menu-item" data-section="member">
                        <i class="fas fa-crown"></i>
                        <span>Thành viên</span>
                    </div>
                    <div class="menu-item" data-section="purchase-history">
                        <i class="fas fa-calendar"></i>
                        <span>Lịch sử mua hàng</span>
                    </div>
                    <div class="menu-item mt-5">
                        <i class="fas fa-sign-out-alt"></i>
                        <a href="app/controler/logout.php" class="logout-link">Đăng xuất</a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-8 main-content">
                <form method="POST" action="app/controler/update_profile.php">
                <div id="customer-info-content" class="main-content-section">
                    <h2 class="title">THÔNG TIN KHÁCH HÀNG</h2>
                    <!-- Personal Information Section -->
                    <div class="content-box">
                        <h3 class="section-title">Thông tin cá nhân</h3>
                        <button class="btn btn-secondary" id="edit-button" type="button">
                            <i class="bi bi-wrench"> Sửa</i>
                        </button>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fullname">Họ và tên</label>
                                <input type="text" class="form-control" name="fullname" id="fullname" value="<?= htmlspecialchars($_SESSION['user']['full_name']) ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="birthdate">Ngày sinh</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?= ($_SESSION['user']['birthday']) ?>" disabled>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= ($_SESSION['user']['phone']) ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= ($_SESSION['user']['email']) ?>" disabled>
                            </div>
                        </div>
                        
                        <div class="text-end"> <button class="btn btn-primary" id="save-info-button" type="submit" style="display: none;">LƯU THÔNG TIN</button>
                        </div>
                    </div>
                    </form>

                    <!-- Password Change Section -->
                    <div class="content-box mt-4">
                        <h3 class="section-title">Đổi mật khẩu</h3>
                        <form method="POST" action="app/controler/change_password.php" id="changePasswordForm">
                        <div class="mb-3">
                            <label for="current-password">Mật khẩu cũ <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="current-password" name="current_password" require>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new-password">Mật khẩu mới <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="new-password" name="new_password" require>
                        </div>
                        
                        <div class="mb-4">
                            <label for="confirm-password">Xác thực mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                        </div>
                        
                        <div class="text">
                            <button type="submit" class="btn btn-primary" id="change-password-button">ĐỔI MẬT KHẨU</button>
                        </div>
                        </form>
                    </div>
                </div>

                 <!-- Member Section -->
                <div id="member-content" class="main-content-section" style="display: none;">
                    <h2 class="title">THÀNH VIÊN</h2>
                    
                    <!-- Points Accumulation Section -->
                    <div class="content-box">
                        <h3 class="section-title">Thông tin</h3>
                        
                        <div class="points-info mb-3">
                            <div class="row align-items-center">
                                <div>
                                    <p class="mb-1 ranking">HẠNG THÀNH VIÊN: <span class="member-rank" id="memberRank"><?= ($_SESSION['user']['member']) ?></span></p>
                                </div>
                            </div>
                        </div>
                        
                        
                        <p class="points-note">
                            Mua vé càng nhiều, ưu đãi càng phiêu!
                        </p>
                    </div>
                    
                    <!-- Member Benefits Section -->
                    <div class="content-box mt-4">
                        <h3 class="section-title">Quyền lợi thành viên</h3>
                        <?php
                        $memberships=new membership();
                        $members=$memberships->getMembershipInfo();
                        ?>
                        <div class="member-benefits">
                            <?php foreach ($members as $member): ?>
                                <?php
                                    $isActive = strtolower($member['member_type']) === strtolower($_SESSION['user']['member']) ? 'active' : '';
                                    $memberId = strtolower($member['member_type']) . 'Member';
                                ?>
                                <div class="benefit-item <?= $isActive ?>" id="<?= $memberId ?>">
                                    <div class="benefit-header">
                                        <h5><i class="fas fa-gem me-2 <?= htmlspecialchars($member['member_type']) ?>"></i><?= htmlspecialchars($member['member_type']) ?></h5>
                                    </div>
                                    <div class="benefit-content">
                                        <?= $member['content'] ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <div id="purchase-history-content" class="main-content-section" style="display: none;">
                    <h2 class="title">LỊCH SỬ MUA HÀNG</h2>
                    
                    <div class="content-box purchase-history-box">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-header">
                                        <th>Mã đơn</th>
                                        <th>Mã giao dịch</th>
                                        <th>Tên phim</th>
                                        <th>Chi nhánh</th>
                                        <th>Ngày</th>
                                        <th>Tổng cộng</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody id="purchase-history-data" class="text-center">
                                    <?php
                                        require_once 'app/controler/get_purchase_history.php'; // Đường dẫn đến file class của bạn

                                        $current_user_id_from_session = $_SESSION['user']['id'] ?? null;

                                        if ($current_user_id_from_session) {
                                            $historyFetcher = new get_purchase_history(); // Tạo đối tượng
                                            $purchase_items = $historyFetcher->getHistoryForUser($current_user_id_from_session); // Gọi phương thức

                                            if (empty($purchase_items)) {
                                                echo '<tr><td colspan="6" class="text-center py-4">Không có dữ liệu lịch sử mua hàng</td></tr>';
                                            } else {
                                                foreach ($purchase_items as $item) {
                                                    // Kiểm tra key trước khi sử dụng để tránh lỗi Notice
                                                    $booking_id_val = htmlspecialchars($item['booking_id'] ?? 'N/A');
                                                    $transaction_code_val = htmlspecialchars($item['transaction_code'] ?? 'N/A'); 
                                                    $movie_title_val = htmlspecialchars($item['movie_title'] ?? 'N/A');
                                                    $cinema_name_val = htmlspecialchars($item['cinema_name'] ?? 'N/A');
                                                    $booking_time_val = $item['booking_time'] ? date("d/m/Y H:i", strtotime($item['booking_time'])) : 'N/A';
                                                    $total_price_val = isset($item['total_price']) ? number_format($item['total_price'], 0, ',', '.') . ' VNĐ' : 'N/A';
                                                    $points_val = "-"; // Placeholder

                                                    echo "<tr>";
                                                    echo "<td>" . $booking_id_val . "</td>";
                                                    echo "<td>" . $transaction_code_val . "</td>";
                                                    echo "<td>" . $movie_title_val . "</td>";
                                                    echo "<td>" . $cinema_name_val . "</td>";
                                                    echo "<td>" . $booking_time_val . "</td>";
                                                    echo "<td>" . $total_price_val . "</td>";
                                                    echo "<td><a href='index.php?page=purchase-detail&booking_id=" . $booking_id_val . "' class='btn btn-sm btn-outline-primary'>Xem chi tiết</a></td>";
                                                    echo "</tr>";
                                                }
                                            }
                                        } else {
                                            echo '<tr><td colspan="6" class="text-center py-4">Lỗi: Không xác định được người dùng.</td></tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="loading-spinner" class="text-center py-5" style="display: none;">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../LTW/assets/js/guestInfo.js"></script>
</body>