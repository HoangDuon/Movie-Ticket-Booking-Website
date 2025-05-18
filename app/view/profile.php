<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
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
                    <div class="menu-item" data-section="purchase-history">
                        <i class="fas fa-calendar"></i>
                        <span>Lịch sử mua hàng</span>
                    </div>
                    <div class="menu-item mt-5">
                        <i class="fas fa-sign-out-alt"></i>
                        <a href="login.html" class="logout-link">Đăng xuất</a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 main-content">
                <div id="customer-info-content" class="main-content-section">
                    <h2 class="title">THÔNG TIN KHÁCH HÀNG</h2>
                    <!-- Personal Information Section -->
                    <div class="content-box">
                        <h3 class="section-title">Thông tin cá nhân</h3>
                        <button class="btn btn-secondary" id="edit-button">
                            <i class="bi bi-wrench"></i>
                        </button>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fullname">Họ và tên</label>
                                <input type="text" class="form-control" id="fullname" value="<?= htmlspecialchars($_SESSION['user']['full_name']) ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="birthdate">Ngày sinh</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="birthdate" value="<?= ($_SESSION['user']['birthday']) ?>" disabled>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" value="<?= ($_SESSION['user']['phone']) ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" value="<?= ($_SESSION['user']['email']) ?>" disabled>
                            </div>
                        </div>
                        
                        <div class="text">
                            <button class="btn btn-save">LƯU THÔNG TIN</button>
                        </div>
                    </div>
                    
                    <!-- Password Change Section -->
                    <div class="content-box mt-4">
                        <h3 class="section-title">Đổi mật khẩu</h3>
                        
                        <div class="mb-3">
                            <label for="current-password">Mật khẩu cũ <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="current-password">
                        </div>
                        
                        <div class="mb-3">
                            <label for="new-password">Mật khẩu mới <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="new-password">
                        </div>
                        
                        <div class="mb-4">
                            <label for="confirm-password">Xác thực mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm-password">
                        </div>
                        
                        <div class="text">
                            <button class="btn btn-save">ĐỔI MẬT KHẨU</button>
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
                                        <th>Hoạt động</th>
                                        <th>Chi nhánh</th>
                                        <th>Ngày</th>
                                        <th>Tổng cộng</th>
                                        <th>Điểm</th>
                                    </tr>
                                </thead>
                                <tbody id="purchase-history-data">
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Không có dữ liệu lịch sử mua hàng</td>
                                    </tr>
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
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../LTW/assets/js/guestInfo.js"></script>
</body>