document.addEventListener('DOMContentLoaded', function () {
    // Toggle hiển thị mật khẩu
    const toggleMappings = [
        { toggleId: 'togglePassword', inputId: 'password' },
        { toggleId: 'togglePasswordReg', inputId: 'passwordReg' },
        { toggleId: 'togglePasswordCon', inputId: 'passwordCon' },
        { toggleId: 'toggleNewPassword', inputId: 'newPassword' },
        { toggleId: 'toggleConfirmNewPassword', inputId: 'confirmNewPassword' },
    ];

    toggleMappings.forEach(({ toggleId, inputId }) => {
        const toggleElement = document.getElementById(toggleId);
        const inputElement = document.getElementById(inputId);
        if (toggleElement && inputElement) {
            toggleElement.addEventListener('click', function () {
                const type = inputElement.type === 'password' ? 'text' : 'password';
                inputElement.type = type;
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        }
    });

    // Chuyển tab quên mật khẩu
    const forgotPasswordLink = document.getElementById('forgotPasswordLink');
    const backToLoginLink = document.getElementById('backToLoginLink');
    const forgotTab = document.getElementById('forgot-tab');
    const loginTab = document.getElementById('login-tab');

    forgotPasswordLink?.addEventListener('click', function (e) {
        e.preventDefault();
        forgotTab.style.display = 'block';
        forgotTab.click();
    });

    backToLoginLink?.addEventListener('click', function (e) {
        e.preventDefault();
        loginTab.click();
        setTimeout(() => {
            forgotTab.style.display = 'none';
            resetForgotPasswordForm();
        }, 300);
    });

    // Quản lý form quên mật khẩu
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    const otpSection = document.getElementById('otpSection');
    const newPasswordSection = document.getElementById('newPasswordSection');
    const forgotSubmitBtn = document.getElementById('forgotSubmitBtn');
    const resendOtpBtn = document.getElementById('resendOtp');

    let forgotPasswordStep = 1;

    forgotPasswordForm?.addEventListener('submit', function (e) {
        e.preventDefault();

        const emailInput = document.getElementById('forgotEmail');
        const email = emailInput.value.trim();

        if (forgotPasswordStep === 1) {
            validateEmailOrPhone(email).then(isValid => {
            if (isValid) {
                document.getElementById('forgotEmailError').style.display = 'none';

                // Gửi OTP lên server
                otpSection.style.display = 'block';
                forgotPasswordStep = 2;
                forgotSubmitBtn.innerHTML = '<span>XÁC NHẬN MÃ</span>';

                fetch('../LTW/app/controler/send_otp.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ emailOrPhone: email })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('OTP đã gửi đến ' + email);
                        startOtpCountdown();
                    } else {
                        alert('Không thể gửi OTP. ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Lỗi gửi OTP:', error);
                });
            } else {
                document.getElementById('forgotEmailError').style.display = 'block';
            }
        });
        } else if (forgotPasswordStep === 2) {
            const otp = document.getElementById('otpCode').value.trim();
            if (validateOtp(otp)) {
                // Gửi lên server kiểm tra OTP
                fetch('../LTW/app/controler/verify_otp.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ otp: otp, emailOrPhone: email }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('otpError').style.display = 'none';
                        newPasswordSection.style.display = 'block';
                        forgotPasswordStep = 3;
                        forgotSubmitBtn.innerHTML = '<span>ĐẶT LẠI MẬT KHẨU</span>';
                    } else {
                        document.getElementById('otpError').textContent = data.message;
                        document.getElementById('otpError').style.display = 'block';
                    }
                })
                .catch(err => {
                    console.error('Lỗi kiểm tra OTP:', err);
                });
            } else {
                document.getElementById('otpError').textContent = 'Mã OTP phải gồm 6 chữ số';
                document.getElementById('otpError').style.display = 'block';
            }
        } else if (forgotPasswordStep === 3) {
            const newPass = document.getElementById('newPassword').value;
            const confirmPass = document.getElementById('confirmNewPassword').value;

            let isValid = true;

            if (newPass.length < 6) {
                document.getElementById('newPasswordError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('newPasswordError').style.display = 'none';
            }

            if (newPass !== confirmPass) {
                document.getElementById('confirmNewPasswordError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('confirmNewPasswordError').style.display = 'none';
            }

            if (isValid) {
               // Gửi lên server đặt lại mật khẩu
                fetch('../LTW/app/controler/reset_password.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        emailOrPhone: email,
                        newPassword: newPass,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Đặt lại mật khẩu thành công! Vui lòng đăng nhập với mật khẩu mới.');
                        loginTab.click();
                        setTimeout(() => {
                            forgotTab.style.display = 'none';
                            resetForgotPasswordForm();
                        }, 300);
                    } else {
                        alert('Đặt lại mật khẩu thất bại: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Lỗi đặt lại mật khẩu:', error);
                    alert('Có lỗi xảy ra khi đặt lại mật khẩu. Vui lòng thử lại.');
                });
            }
        }
    });

    // Gửi lại mã OTP
    resendOtpBtn?.addEventListener('click', function () {
        const email = document.getElementById('forgotEmail').value.trim();

            if (!validateEmailOrPhone(email)) {
                alert('Vui lòng nhập email hoặc số điện thoại hợp lệ trước khi gửi lại OTP.');
                return;
            }

            fetch('../LTW/app/controler/send_otp.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ emailOrPhone: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('OTP đã gửi đến ' + email);
                    forgotPasswordStep = 2;
                    otpSection.style.display = 'block';  // đảm bảo phần nhập OTP hiển thị
                    startOtpCountdown();
                } else {
                    alert('Không thể gửi OTP. ' + data.message);
                }
            })
            .catch(error => {
                console.error('Lỗi gửi OTP:', error);
                alert('Có lỗi xảy ra khi gửi OTP. Vui lòng thử lại.');
            });
    });

    // Helpers
    function validateEmailOrPhone(value) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^0\d{9}$/;
        if (!emailRegex.test(value) && !phoneRegex.test(value)) {
            return Promise.resolve(false);  // trả Promise.resolve để đồng bộ với phần gọi
        }

        return fetch('../LTW/app/controler/get_all_emails_phones.php')
            .then(response => response.json())
            .then(data => {
                if (!data.success) return false;
                return data.list.includes(value);
            })
            .catch(error => {
                console.error('Lỗi lấy danh sách email/phone:', error);
                return false;
            });
    }

    

    function validateOtp(otp) {
        return /^\d{6}$/.test(otp);
    }

    function resetForgotPasswordForm() {
        forgotPasswordForm.reset();
        otpSection.style.display = 'none';
        newPasswordSection.style.display = 'none';
        forgotPasswordStep = 1;
        forgotSubmitBtn.innerHTML = '<span>GỬI YÊU CẦU</span>';

        ['forgotEmailError', 'otpError', 'newPasswordError', 'confirmNewPasswordError']
            .forEach(id => document.getElementById(id).style.display = 'none');
    }

    function startOtpCountdown() {
        let countdown = 60;
        resendOtpBtn.disabled = true;

        const oldCountdown = document.querySelector('.otp-countdown');
        oldCountdown?.remove();

        const countdownElement = document.createElement('span');
        countdownElement.className = 'otp-countdown ms-2';
        countdownElement.textContent = `(${countdown}s)`;
        resendOtpBtn.parentNode.appendChild(countdownElement);

        const interval = setInterval(() => {
            countdown--;
            countdownElement.textContent = `(${countdown}s)`;

            if (countdown <= 0) {
                clearInterval(interval);
                countdownElement.remove();
                resendOtpBtn.disabled = false;
            }
        }, 1000);
    }
});
