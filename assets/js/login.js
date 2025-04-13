// Hiển thị hoặc ẩn mật khẩu
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');
togglePassword.addEventListener('click', (e) => {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    e.target.classList.toggle('bi-eye');
});

// Hiển thị hoặc ẩn mật khẩu đăng ký
const togglePasswordReg = document.querySelector('#togglePasswordReg');
const passwordReg = document.querySelector('#passwordReg');
togglePasswordReg.addEventListener('click', (e) => {
    const type = passwordReg.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordReg.setAttribute('type', type);
    e.target.classList.toggle('bi-eye');
});

// Hiển thị hoặc ẩn mật khẩu xác thực
const togglePasswordRegCon = document.querySelector('#togglePasswordCon');
const passwordRegCon = document.querySelector('#passwordCon');
togglePasswordRegCon.addEventListener('click', (e) => {
    const type = passwordRegCon.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordRegCon.setAttribute('type', type);
    e.target.classList.toggle('bi-eye');
});

// Hàm kiểm tra tính hợp lệ của email
function validateEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

// Hàm kiểm tra tính hợp lệ của số điện thoại (ví dụ: chỉ chấp nhận số có 10 chữ số)
function validatePhone(phone) {
    return /^\d{10}$/.test(phone);
}

// Hàm kiểm tra mật khẩu và mật khẩu xác nhận
function validatePassword(password, confirmPassword) {
    return password === confirmPassword;
}

// Hàm ẩn thông báo lỗi khi người dùng nhập lại
function clearError(input) {
    const errorSpan = input.nextElementSibling;
    if (errorSpan && errorSpan.classList.contains('error')) {
        errorSpan.style.display = 'none';
    }
}

// Xử lý form đăng nhập
const loginForm = document.querySelector('#loginForm');
loginForm.addEventListener('submit', (e) => {
    e.preventDefault();

    // Lấy giá trị các trường
    const username = document.querySelector('#username').value;
    const password = document.querySelector('#password').value;

    // Kiểm tra các trường và hiển thị thông báo lỗi
    if (username === '') {
        document.querySelector('#loginUsernameError').style.display = 'block';
    } else {
        document.querySelector('#loginUsernameError').style.display = 'none';
    }

    if (password === '') {
        document.querySelector('#loginPasswordError').style.display = 'block';
    } else {
        document.querySelector('#loginPasswordError').style.display = 'none';
    }
});

// Xử lý form đăng ký
const registerForm = document.querySelector('#registerForm');
registerForm.addEventListener('submit', (e) => {
    e.preventDefault();

    // Lấy giá trị các trường
    const fullName = document.querySelector('#fullName').value;
    const dob = document.querySelector('#dob').value;
    const phone = document.querySelector('#phone').value;
    const usernameReg = document.querySelector('#usernameReg').value;
    const cccd = document.querySelector('#cccd').value;
    const email = document.querySelector('#email').value;
    const passwordReg = document.querySelector('#passwordReg').value;
    const passwordCon = document.querySelector('#passwordCon').value;
    const terms = document.querySelector('#terms').checked;

    // Kiểm tra các trường và hiển thị thông báo lỗi
    if (fullName === '') {
        document.querySelector('#fullNameError').style.display = 'block';
    } else {
        document.querySelector('#fullNameError').style.display = 'none';
    }

    if (dob === '') {
        document.querySelector('#dobError').style.display = 'block';
    } else {
        document.querySelector('#dobError').style.display = 'none';
    }

    if (phone === '') {
        document.querySelector('#phoneError').style.display = 'block';
    } else if (!validatePhone(phone)) {
        document.querySelector('#phoneError').textContent = 'Số điện thoại không hợp lệ.';
        document.querySelector('#phoneError').style.display = 'block';
    } else {
        document.querySelector('#phoneError').style.display = 'none';
    }

    if (usernameReg === '') {
        document.querySelector('#usernameRegError').style.display = 'block';
    } else {
        document.querySelector('#usernameRegError').style.display = 'none';
    }

    if (cccd === '') {
        document.querySelector('#cccdError').style.display = 'block';
    } else {
        document.querySelector('#cccdError').style.display = 'none';
    }

    if (email === '') {
        document.querySelector('#emailError').style.display = 'block';
    } else if (!validateEmail(email)) {
        document.querySelector('#emailError').textContent = 'Email không hợp lệ.';
        document.querySelector('#emailError').style.display = 'block';
    } else {
        document.querySelector('#emailError').style.display = 'none';
    }

    if (passwordReg === '') {
        document.querySelector('#regPasswordError').style.display = 'block';
    } else {
        document.querySelector('#regPasswordError').style.display = 'none';
    }

    if (passwordCon === '') {
        document.querySelector('#confirmPasswordError').style.display = 'block';
    } else if (!validatePassword(passwordReg, passwordCon)) {
        document.querySelector('#confirmPasswordError').textContent = 'Mật khẩu xác thực không khớp.';
        document.querySelector('#confirmPasswordError').style.display = 'block';
    } else {
        document.querySelector('#confirmPasswordError').style.display = 'none';
    }

    if (!terms) {
        document.querySelector('#termsError').style.display = 'block';
    } else {
        document.querySelector('#termsError').style.display = 'none';
    }
});

// Ẩn thông báo lỗi khi người dùng bắt đầu nhập lại
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('input', (e) => {
        clearError(e.target);
    });
});

