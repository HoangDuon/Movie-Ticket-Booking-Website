const specialCharRegex = /[!@#$%^&*]/;
const phoneRegex = /^(0[3|5|7|8|9])[0-9]{8}$/;
const digitRegex = /\d/;
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

//Validate form đăng kí
document.getElementById('registerForm').addEventListener('submit', function (e) {

  const regName = document.getElementById("fullName").value.trim();
  const regEmail = document.getElementById("email").value.trim();
  const regPhone = document.getElementById("phone").value.trim();
  const regDOB = document.getElementById("dob").value.trim();
  const regPassword = document.getElementById("passwordReg").value.trim();
  const regConPassword = document.getElementById("passwordCon").value.trim();

  // 1. Tên người dùng
  if (!regName) {
      alert("Tên người dùng bắt buộc không được để trống!");
      document.getElementById('fullName').focus();
      e.preventDefault(); return;
  }
  if (regName.length < 3) {
    alert("Tên người dùng phải có tối thiểu 3 kí tự.");
    document.getElementById('fullName').focus();
    e.preventDefault(); return;
  }
  if (regName.length > 100) {
    alert("Tên người dùng chỉ tối đa là 100 ký tự");
    document.getElementById('fullName').focus();
    e.preventDefault(); return;
  }

  if (specialCharRegex.test(regName)) {
      alert("Tên người dùng không được chứa ký tự đặc biệt (!@#$%^&*).");
      document.getElementById('fullName').focus();
      e.preventDefault(); return;
  }

  if (digitRegex.test(regName)) {
      alert("Tên người dùng không được chứa số.");
      document.getElementById('fullName').focus();
      e.preventDefault(); return;
  }
  // 2. Email người dùng
  const emailRegex = /^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,}$/;
    if (regEmail === '') {
        alert("Email không được để trống!");
        document.getElementById('email').focus();
        e.preventDefault(); return;
    }
    if (!emailRegex.test(regEmail)) {
        alert("Email không hợp lệ. Vui lòng nhập địa chỉ email đúng định dạng.");
        document.getElementById('email').focus();
        e.preventDefault(); return;
    }
    // Kiểm tra email phải kết thúc bằng @gmail.com nếu bạn muốn giới hạn cụ thể
    if (!regEmail.toLowerCase().endsWith('@gmail.com')) {
        alert('Hiện tại hệ thống chỉ hỗ trợ đăng ký bằng email có đuôi @gmail.com!');
        document.getElementById('email').focus();
        e.preventDefault(); return;
    }

  // 3. Số điện thoại
  if (!regPhone) {
      alert("Số điện thoại không được để trống");
      document.getElementById('phone').focus();
      e.preventDefault(); return;
  }

  if (regPhone.length < 10) {
      alert("Số điện thoại phải gồm 10 chữ số");
      document.getElementById('phone').focus();
      e.preventDefault(); return;
  }

  if (!phoneRegex.test(regPhone)) {
      alert("Số điện thoại phải bắt đầu bằng với số 0[3|5|7|8|9]");
      document.getElementById('phone').focus();
      e.preventDefault(); return;
  }

  // 4. Ngày sinh
  if (regDOB === '') {
      alert('Ngày sinh không được để trống!');
      document.getElementById('dob').focus();
      e.preventDefault();
      return;
  } else {
      const birthDate = new Date(regDOB);
      const today = new Date();
      birthDate.setHours(0, 0, 0, 0);
      today.setHours(0, 0, 0, 0);

      if (birthDate >= today) {
          alert('Ngày sinh phải là một ngày trong quá khứ!');
          document.getElementById('dob').focus();
          e.preventDefault();
          return;
      }

      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
          age--;
      }

      if (age < 13) {
          alert('Phải đủ 13 tuổi trở lên!');
          document.getElementById('dob').focus();
          e.preventDefault();
          return;
      }
  }

    // 5. Kiểm tra Mật khẩu
    if (regPassword === '') {
        alert("Mật khẩu không được để trống!");
        regPassword.focus();
        e.preventDefault();
        return;
    }
    if (regPassword.length < 6) { // Yêu cầu mật khẩu tối thiểu 6 ký tự
        alert("Mật khẩu phải có ít nhất 6 ký tự.");
        document.getElementById('phone').focus();
        e.preventDefault(); return;
    }

    // 6. Kiểm tra Nhập lại mật khẩu
    if (regConPassword === '') {
        alert("Vui lòng nhập lại mật khẩu!");
        document.getElementById('phone').focus();
        e.preventDefault(); return;
    }
    if (regPassword !== regConPassword) {
        alert("Mật khẩu nhập lại không khớp!");
        document.getElementById('phone').focus();
        e.preventDefault(); return;
        // document.getElementById('confirmPasswordError').style.display = 'block'; // Hiện span lỗi
    }
});