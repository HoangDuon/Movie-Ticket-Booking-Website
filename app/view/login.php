<body class="web-login">
    <div class="container d-flex justify-content-start align-items-center min-vh-100">
        <div class="card p-3" style="width: 400px;">
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs nav-fill" id="authTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="login-tab" data-bs-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">ĐĂNG NHẬP</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="register-tab" data-bs-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">ĐĂNG KÝ</a>
                </li>
            </ul>
            <!-- Tab Content -->
            <div class="tab-content mt-3" id="authTabsContent">

            <?php

            ?>
                <!-- Form Đăng Nhập -->
                <div class="tab-pane fade show active" id="login" aria-labelledby="login-tab">
                    <form id="loginForm" action="" method="post">

                        <!-- Tài khoản -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Tài khoản, Email hoặc số điện thoại <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" required>
                            <span class="error" id="loginUsernameError">Vui lòng nhập tài khoản.</span>
                        </div>

                        <!-- Mật Khẩu -->
                         <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu <span style="color: red;">*</span></label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                            <span class="error" id="loginPasswordError">Vui lòng nhập mật khẩu.</span>
                         </div>

                        <!-- Ghi nhớ-->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Lưu mật khẩu đăng nhập</label>
                        </div>

                        <!-- Quên Mật Khẩu -->
                        <div class="forgotPassword">
                            <a href="#" style="color: black;">Quên mật khẩu?</a>
                        </div>
                        
                        <!-- Đăng Nhập -->
                        <button type="submit" class="btn-warning" name="action" value="login"><span>ĐĂNG NHẬP</span></button>
                        <input type="hidden" name="action" value="login">
                    </form>
                </div>

                <?php
                include "../LTW/app/controler/user_services.php";

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    var_dump($_POST);
                    if (isset($_POST['action'])) {
                        $action = $_POST['action'];

                        $user = new user_services();

                        if ($action === 'login') {
                            $email = $_POST['username'];
                            $password = $_POST['password'];

                            $user_info = $user->login($email, $password);

                            if ($user_info) {
                                $_SESSION['user'] = $user_info;

                                if ($user_info['role'] === 'admin') {
                                    header("Location: ../LTW/app/view/admin.php");
                                } else {
                                    header("Location: ../LTW/index.php?page=home");
                                }
                                exit();
                            } else {
                                echo "Email hoặc mật khẩu không đúng!";
                            }

                        } elseif ($action === 'register') {
                            $full_name = $_POST['fullName'];
                            $dob = $_POST['dob'];
                            $phone = $_POST['phone'];
                            $email = $_POST['email'];
                            $password = $_POST['password'];
                            $user->add_User($full_name, $dob, $phone, $email, $password);
                        }
                    } else {
                        echo 'Không có action trong POST';
                    }
                }
                ?>


                <!-- Form Đăng Ký -->
                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                    <form id="registerForm" action="" method="post">
                        
                        <!-- Họ và Tên -->
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Họ và tên <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="fullName" name="fullName" required>
                            <span class="error" id="fullNameError">Vui lòng nhập họ và tên.</span>
                        </div>

                        <!-- Ngày Sinh -->
                        <div class="mb-3">
                            <label for="dob" class="form-label">Ngày sinh <span style="color: red;">*</span></label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                            <span class="error" id="dobError">Vui lòng nhập ngày sinh.</span>
                        </div>

                        <!-- Số Điện Thoại -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                            <span class="error" id="phoneError">Vui lòng nhập số điện thoại.</span>
                        </div>


                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span style="color: red;">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <span class="error" id="emailError">Vui lòng nhập email hợp lệ.</span>
                        </div>

                        <!-- Mật Khẩu -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu <span style="color: red;">*</span></label>
                            <input type="password" name="password" id="passwordReg" class="form-control" required>
                            <i class="bi bi-eye-slash" id="togglePasswordReg"></i>
                            <span class="error" id="regPasswordError">Vui lòng nhập mật khẩu.</span>
                        </div>

                        <!-- Xác Thực Mật Khẩu -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Nhập lại mật khẩu <span style="color: red;">*</span></label>
                            <input type="password" name="passwordAgain" id="passwordCon" class="form-control" required>
                            <i class="bi bi-eye-slash" id="togglePasswordCon"></i>
                            <span class="error" id="confirmPasswordError">Mật khẩu xác thực không khớp.</span>
                        </div>

                        <!-- Điều Khoản -->
                        <div class>
                            <a href="#" data-bs-toggle="modal" d    ata-bs-target="#myModal" class="details">Bấm vào để xem nội dung</a>
                            <div class="modal fade" id="myModal">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Chính sách bảo mật</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Chúng tôi cam kết bảo vệ thông tin cá nhân của bạn.</p>  
                                        <p>Dữ liệu chỉ được thu thập và sử dụng nhằm cải thiện dịch vụ.</p>
                                        <p>Chúng tôi không chia sẻ thông tin với bên thứ ba khi chưa có sự đồng ý của bạn.</p>
                                        <p>.-. --- -. .- .-.. -.. --- / .. ... / - .- .-.. .-.. . .-. / - .... .- -. / -- . ... ... ..</p>  
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">Khách hàng đã đồng ý các điều khoản.</label>
                            <span class="error" id="termsError">Bạn cần đồng ý với chính sách bảo mật.</span>
                        </div>
                        <button type="submit" class="btn-warning" name="action" value="register"><span>ĐĂNG KÝ</span></button>
                        <div>
                            <p style="margin-top: 10px; text-align: center;">Bạn đã có tài khoản? <a href="login.html" class="login-tab">Đăng nhập</a></p>
                        </div>
                        <input type="hidden" name="action" value="register">
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../LTW/assets/js/login.js"></script>
</body>