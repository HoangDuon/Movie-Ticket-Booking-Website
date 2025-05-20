document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const togglePasswordReg = document.getElementById('togglePasswordReg');
    const togglePasswordCon = document.getElementById('togglePasswordCon');
    const toggleNewPassword = document.getElementById('toggleNewPassword');
    const toggleConfirmNewPassword = document.getElementById('toggleConfirmNewPassword');
    
    const password = document.getElementById('password');
    const passwordReg = document.getElementById('passwordReg');
    const passwordCon = document.getElementById('passwordCon');
    const newPassword = document.getElementById('newPassword');
    const confirmNewPassword = document.getElementById('confirmNewPassword');

    // Xử lý hiển thị/ẩn mật khẩu
    function setupPasswordToggle(toggleElement, passwordElement) {
        if (toggleElement && passwordElement) {
            toggleElement.addEventListener('click', function() {
                const type = passwordElement.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordElement.setAttribute('type', type);
                
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        }
    }

    setupPasswordToggle(togglePassword, password);
    setupPasswordToggle(togglePasswordReg, passwordReg);
    setupPasswordToggle(togglePasswordCon, passwordCon);
    setupPasswordToggle(toggleNewPassword, newPassword);
    setupPasswordToggle(toggleConfirmNewPassword, confirmNewPassword);

    // Xử lý chức năng quên mật khẩu
    const forgotPasswordLink = document.getElementById('forgotPasswordLink');
    const backToLoginLink = document.getElementById('backToLoginLink');
    const forgotTab = document.getElementById('forgot-tab');
    const loginTab = document.getElementById('login-tab');
    
    if (forgotPasswordLink) {
        forgotPasswordLink.addEventListener('click', function(e) {
            e.preventDefault();
            forgotTab.style.display = 'block';
            forgotTab.click();
        });
    }
    
    if (backToLoginLink) {
        backToLoginLink.addEventListener('click', function(e) {
            e.preventDefault();
            loginTab.click();
            setTimeout(() => {
                forgotTab.style.display = 'none';
                // Reset form quên mật khẩu
                resetForgotPasswordForm();
            }, 300);
        });
    }
    
    // Xử lý form quên mật khẩu
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    const otpSection = document.getElementById('otpSection');
    const newPasswordSection = document.getElementById('newPasswordSection');
    const forgotSubmitBtn = document.getElementById('forgotSubmitBtn');
    const resendOtpBtn = document.getElementById('resendOtp');
    
    let forgotPasswordStep = 1; // 1: Nhập email, 2: Nhập OTP, 3: Đặt mật khẩu mới
    
    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (forgotPasswordStep === 1) {
                // Xác thực email/số điện thoại
                const forgotEmail = document.getElementById('forgotEmail').value;
                if (validateEmailOrPhone(forgotEmail)) {
                    // Giả lập gửi mã OTP
                    otpSection.style.display = 'block';
                    forgotPasswordStep = 2;
                    forgotSubmitBtn.innerHTML = '<span>XÁC NHẬN MÃ</span>';
                    
                    // Hiển thị thông báo đã gửi OTP
                    alert('Mã xác nhận đã được gửi đến ' + forgotEmail);
                    
                    // Bắt đầu đếm ngược để gửi lại OTP
                    startOtpCountdown();
                } else {
                    const forgotEmailError = document.getElementById('forgotEmailError');
                    forgotEmailError.style.display = 'block';
                }
            } else if (forgotPasswordStep === 2) {
                // Xác thực mã OTP
                const otpCode = document.getElementById('otpCode').value;
                if (validateOtp(otpCode)) {
                    // Hiển thị phần đặt mật khẩu mới
                    newPasswordSection.style.display = 'block';
                    forgotPasswordStep = 3;
                    forgotSubmitBtn.innerHTML = '<span>ĐẶT LẠI MẬT KHẨU</span>';
                } else {
                    const otpError = document.getElementById('otpError');
                    otpError.style.display = 'block';
                }
            } else if (forgotPasswordStep === 3) {
                // Xác thực và đặt mật khẩu mới
                const newPasswordValue = document.getElementById('newPassword').value;
                const confirmNewPasswordValue = document.getElementById('confirmNewPassword').value;
                
                let isValid = true;
                
                if (newPasswordValue.length < 6) {
                    document.getElementById('newPasswordError').style.display = 'block';
                    isValid = false;
                } else {
                    document.getElementById('newPasswordError').style.display = 'none';
                }
                
                if (newPasswordValue !== confirmNewPasswordValue) {
                    document.getElementById('confirmNewPasswordError').style.display = 'block';
                    isValid = false;
                } else {
                    document.getElementById('confirmNewPasswordError').style.display = 'none';
                }
                
                if (isValid) {
                    // Giả lập đặt lại mật khẩu thành công
                    alert('Đặt lại mật khẩu thành công! Vui lòng đăng nhập với mật khẩu mới.');
                    
                    // Quay lại tab đăng nhập
                    loginTab.click();
                    setTimeout(() => {
                        forgotTab.style.display = 'none';
                        resetForgotPasswordForm();
                    }, 300);
                }
            }
        });
    }
    
    // Xử lý nút gửi lại mã OTP
    if (resendOtpBtn) {
        resendOtpBtn.addEventListener('click', function() {
            const forgotEmail = document.getElementById('forgotEmail').value;
            alert('Mã xác nhận mới đã được gửi đến ' + forgotEmail);
            startOtpCountdown();
        });
    }
    
    // Hàm kiểm tra email hoặc số điện thoại
    function validateEmailOrPhone(value) {
        // Kiểm tra email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        // Kiểm tra số điện thoại (10 số, bắt đầu bằng 0)
        const phoneRegex = /^0\d{9}$/;
        
        return emailRegex.test(value) || phoneRegex.test(value);
    }
    
    // Hàm kiểm tra mã OTP (giả lập)
    function validateOtp(otp) {
        // Giả lập: OTP hợp lệ là 6 chữ số
        return /^\d{6}$/.test(otp);
    }
    
    // Hàm reset form quên mật khẩu
    function resetForgotPasswordForm() {
        if (forgotPasswordForm) {
            forgotPasswordForm.reset();
            otpSection.style.display = 'none';
            newPasswordSection.style.display = 'none';
            forgotPasswordStep = 1;
            forgotSubmitBtn.innerHTML = '<span>GỬI YÊU CẦU</span>';
            
            // Ẩn tất cả thông báo lỗi
            document.getElementById('forgotEmailError').style.display = 'none';
            document.getElementById('otpError').style.display = 'none';
            document.getElementById('newPasswordError').style.display = 'none';
            document.getElementById('confirmNewPasswordError').style.display = 'none';
        }
    }
    
    // Hàm đếm ngược thời gian gửi lại OTP
    function startOtpCountdown() {
        let countdown = 60;
        resendOtpBtn.disabled = true;
        
        // Xóa đếm ngược cũ nếu có
        const oldCountdown = document.querySelector('.otp-countdown');
        if (oldCountdown) {
            oldCountdown.remove();
        }
        
        // Tạo phần tử đếm ngược
        const countdownElement = document.createElement('span');
        countdownElement.className = 'otp-countdown';
        countdownElement.textContent = `(${countdown}s)`;
        resendOtpBtn.parentNode.appendChild(countdownElement);
        
        const countdownInterval = setInterval(() => {
            countdown--;
            countdownElement.textContent = `(${countdown}s)`;
            
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                countdownElement.remove();
                resendOtpBtn.disabled = false;
            }
        }, 1000);
    }
});