document.addEventListener('DOMContentLoaded', function() {
    console.log("guestInfo.js loaded successfully");
    
    // Initialize Datepicker
    const birthDateInput = document.getElementById('birthDate');
    const dateIcon = document.querySelector('.date-icon');
    
    // Kiểm tra xem jQuery và bootstrap-datepicker có sẵn không
    if (typeof $ !== 'undefined' && typeof $.fn.datepicker !== 'undefined' && birthDateInput) {
        // Khởi tạo Bootstrap Datepicker
        $(birthDateInput).datepicker({
            format: 'dd-M-yyyy',
            autoclose: true,
            todayHighlight: true,
            language: 'vi',
            clearBtn: true,
            orientation: 'bottom auto'
        });
        
        // Thêm sự kiện click cho biểu tượng lịch
        if (dateIcon) {
            dateIcon.addEventListener('click', function() {
                $(birthDateInput).datepicker('show');
            });
        }
        
        // Sự kiện khi datepicker thay đổi để xóa lỗi nếu có
        $(birthDateInput).on('changeDate', function() {
            birthDateInput.classList.remove('is-invalid');
            const errorElement = birthDateInput.parentElement.nextElementSibling;
            if (errorElement && errorElement.classList.contains('invalid-feedback')) {
                errorElement.style.display = 'none';
            }
        });
    } else {
        console.log("Bootstrap Datepicker or jQuery not available. Using native date validation.");
        
        // Nếu không có Bootstrap Datepicker, sử dụng hàm kiểm tra ngày tùy chỉnh
        function isValidDate(dateString) {
            // Ví dụ cho định dạng "DD-MMM-YYYY" như "13-Oct-2000"
            const regex = /^(\d{1,2})-([a-zA-Z]{3})-(\d{4})$/;
            if (!regex.test(dateString)) return false;
            
            const parts = dateString.match(regex);
            const day = parseInt(parts[1], 10);
            const monthStr = parts[2];
            const year = parseInt(parts[3], 10);
            
            // Chuyển đổi chuỗi tháng thành số (0-11)
            const months = {
                'Jan': 0, 'Feb': 1, 'Mar': 2, 'Apr': 3, 'May': 4, 'Jun': 5,
                'Jul': 6, 'Aug': 7, 'Sep': 8, 'Oct': 9, 'Nov': 10, 'Dec': 11
            };
            
            if (!months.hasOwnProperty(monthStr)) return false;
            const month = months[monthStr];
            
            // Kiểm tra ngày hợp lệ
            const date = new Date(year, month, day);
            return date.getDate() === day && 
                   date.getMonth() === month && 
                   date.getFullYear() === year;
        }
        
        // Thêm sự kiện click cho biểu tượng lịch (sử dụng đầu vào ngày gốc)
        if (dateIcon) {
            dateIcon.addEventListener('click', function() {
                birthDateInput.focus();
                // Nếu sử dụng trình chọn ngày tùy chỉnh, hãy mở nó ở đây
            });
        }
    }
    
    // Tab navigation functionality
    window.showTab = function(tabName) {
        // Hide all content sections
        document.querySelectorAll('.content-section').forEach(function(section) {
            section.style.display = 'none';
        });
        
        // Remove active class from all tabs
        document.querySelectorAll('.sidebar-menu .nav-item').forEach(function(item) {
            item.classList.remove('active');
        });
        
        // Show selected content and activate tab
        document.getElementById(tabName + '-content').style.display = 'block';
        document.getElementById(tabName + '-tab').classList.add('active');
        
        // If purchase history tab is selected, load the data
        if (tabName === 'history') {
            loadPurchaseHistory();
        }
    };
    
    // Form validation for personal info
    const personalInfoForm = document.getElementById('personalInfoForm');
    
    // Check if the form exists before adding event listeners
    if (personalInfoForm) {
        const saveInfoBtn = personalInfoForm.querySelector('.save-btn');
        
        // Double check if button exists
        if (saveInfoBtn) {
            console.log("Save button found, adding event listener");
            
            // Add a direct click handler
            saveInfoBtn.addEventListener('click', function() {
                console.log("Save button clicked!");
                validatePersonalInfo();
            });
        }
    }
    
    // Function to validate personal info
    function validatePersonalInfo() {
        console.log("Validating personal info");
        
        const fullName = document.getElementById('fullName').value.trim();
        const birthDate = document.getElementById('birthDate').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const email = document.getElementById('email').value.trim();
        
        // Reset previous error states
        resetErrorStates();
        
        // Check for empty fields
        let isValid = true;
        
        if (!fullName) {
            showError('fullName', 'Vui lòng nhập họ và tên');
            isValid = false;
        } else if (fullName.length < 2) {
            showError('fullName', 'Họ và tên phải có ít nhất 2 ký tự');
            isValid = false;
        } else if (!/^[a-zA-ZÀ-ỹ\s]+$/.test(fullName)) {
            showError('fullName', 'Họ và tên chỉ được chứa chữ cái và khoảng trắng');
            isValid = false;
        }
        
        if (!birthDate) {
            showError('birthDate', 'Vui lòng nhập ngày sinh');
            isValid = false;
        } else if (typeof $ === 'undefined' || typeof $.fn.datepicker === 'undefined') {
            // Chỉ kiểm tra định dạng ngày theo cách thủ công nếu không có datepicker
            if (typeof isValidDate === 'function' && !isValidDate(birthDate)) {
                showError('birthDate', 'Ngày sinh không hợp lệ (định dạng DD-MMM-YYYY, ví dụ: 13-Oct-2000)');
                isValid = false;
            }
        }
        
        if (!phone) {
            showError('phone', 'Vui lòng nhập số điện thoại');
            isValid = false;
        } else if (!/^0\d{9}$/.test(phone)) {
            showError('phone', 'Số điện thoại phải có 10 chữ số và bắt đầu bằng số 0');
            isValid = false;
        }
        
        if (!email) {
            showError('email', 'Vui lòng nhập email');
            isValid = false;
        } else {
            const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailRegex.test(email)) {
                showError('email', 'Email không hợp lệ');
                isValid = false;
            }
        }
        
        if (isValid) {
            console.log("Form is valid, showing success message");
            
            // Show success message
            showSuccessMessage('Thông tin cá nhân đã được lưu thành công!');
        } else {
            console.log("Form validation failed");
        }
    }
    
    // Form validation for password change
    const passwordForm = document.getElementById('passwordChangeForm');
    
    if (passwordForm) {
        const changePasswordBtn = passwordForm.querySelector('.save-btn');
        
        if (changePasswordBtn) {
            changePasswordBtn.addEventListener('click', function() {
                validatePasswordChange();
            });
        }
    }
    
    // Function to validate password change
    function validatePasswordChange() {
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        // Reset previous error states for password form
        resetErrorStatesPassword();
        
        let isValid = true;
        
        if (!currentPassword) {
            showErrorPassword('currentPassword', 'Vui lòng nhập mật khẩu hiện tại');
            isValid = false;
        }
        
        if (!newPassword) {
            showErrorPassword('newPassword', 'Vui lòng nhập mật khẩu mới');
            isValid = false;
        } else if (newPassword.length < 6) {
            showErrorPassword('newPassword', 'Mật khẩu mới phải có ít nhất 6 ký tự');
            isValid = false;
        } else if (!/(?=.*[A-Za-z])(?=.*\d)/.test(newPassword)) {
            showErrorPassword('newPassword', 'Mật khẩu phải chứa ít nhất một chữ cái và một số');
            isValid = false;
        }
        
        if (!confirmPassword) {
            showErrorPassword('confirmPassword', 'Vui lòng xác nhận mật khẩu mới');
            isValid = false;
        } else if (newPassword !== confirmPassword) {
            showErrorPassword('confirmPassword', 'Xác nhận mật khẩu không khớp');
            isValid = false;
        }
        
        if (isValid) {
            // Show success message
            showSuccessMessage('Mật khẩu đã được thay đổi thành công!');
            
            // Clear password fields for security
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
        }
    }
    
    // Helper functions for validation and error display
    function showError(fieldId, message) {
        const field = document.getElementById(fieldId);
        if (!field) {
            console.error('Field not found:', fieldId);
            return;
        }
        
        field.classList.add('is-invalid');
        
        // Find the feedback element - could be after the input or after the input-group
        let parent = field.parentElement;
        let errorElement;
        
        // If it's in an input group, look for feedback in the parent of the input-group
        if (parent.classList.contains('input-group')) {
            errorElement = parent.nextElementSibling;
            if (!errorElement || !errorElement.classList.contains('invalid-feedback')) {
                errorElement = document.createElement('div');
                errorElement.className = 'invalid-feedback';
                parent.parentNode.insertBefore(errorElement, parent.nextSibling);
            }
        } else {
            // Regular input field
            errorElement = field.nextElementSibling;
            if (!errorElement || !errorElement.classList.contains('invalid-feedback')) {
                errorElement = document.createElement('div');
                errorElement.className = 'invalid-feedback';
                field.parentNode.insertBefore(errorElement, field.nextSibling);
            }
        }
        
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
    
    function showErrorPassword(fieldId, message) {
        const field = document.getElementById(fieldId);
        if (!field) {
            console.error('Password field not found:', fieldId);
            return;
        }
        
        field.classList.add('is-invalid');
        
        // Create error message element if it doesn't exist
        let errorElement = field.nextElementSibling;
        if (!errorElement || !errorElement.classList.contains('invalid-feedback')) {
            errorElement = document.createElement('div');
            errorElement.className = 'invalid-feedback';
            field.parentNode.insertBefore(errorElement, field.nextSibling);
        }
        
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }
    
    function resetErrorStates() {
        const fields = ['fullName', 'birthDate', 'phone', 'email'];
        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field) {
                console.error('Field not found when resetting errors:', fieldId);
                return;
            }
            
            field.classList.remove('is-invalid');
            
            // Find and remove error messages
            let parent = field.parentElement;
            let errorElement;
            
            // If it's in an input group, check for feedback after the group
            if (parent.classList.contains('input-group')) {
                errorElement = parent.nextElementSibling;
                if (errorElement && errorElement.classList.contains('invalid-feedback')) {
                    errorElement.textContent = '';
                    errorElement.style.display = 'none';
                }
            } else {
                // Regular input field
                errorElement = field.nextElementSibling;
                if (errorElement && errorElement.classList.contains('invalid-feedback')) {
                    errorElement.textContent = '';
                    errorElement.style.display = 'none';
                }
            }
        });
    }
    
    function resetErrorStatesPassword() {
        const fields = ['currentPassword', 'newPassword', 'confirmPassword'];
        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field) {
                console.error('Password field not found when resetting errors:', fieldId);
                return;
            }
            
            field.classList.remove('is-invalid');
            
            // Remove any existing error messages
            const errorElement = field.nextElementSibling;
            if (errorElement && errorElement.classList.contains('invalid-feedback')) {
                errorElement.textContent = '';
                errorElement.style.display = 'none';
            }
        });
    }
    
    function showSuccessMessage(message) {
        console.log("Success message:", message);
        
        // Create toast container if it doesn't exist
        if (!document.getElementById('toast-container')) {
            const toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
            toastContainer.style.zIndex = '1050';
            document.body.appendChild(toastContainer);
        }
        
        // Create unique ID for this toast
        const toastId = 'toast-' + Date.now();
        
        // Create toast HTML
        const toastHTML = `
            <div id="${toastId}" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Đóng"></button>
                </div>
            </div>
        `;
        
        // Add toast to container
        document.getElementById('toast-container').innerHTML += toastHTML;
        
        // Initialize and show the toast using Bootstrap JS
        if (typeof bootstrap !== 'undefined') {
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: 3000
            });
            toast.show();
            
            // Remove toast after it's hidden
            toastElement.addEventListener('hidden.bs.toast', function() {
                toastElement.remove();
            });
        } else {
            // Fallback if Bootstrap JS is not available
            alert(message);
        }
    }
    
    // Mobile sidebar toggle functionality
    function adjustForMobile() {
        const windowWidth = window.innerWidth;
        const sidebar = document.querySelector('.sidebar');
        
        if (sidebar) {
            if (windowWidth < 768) {
                sidebar.style.minHeight = 'auto';
            } else {
                sidebar.style.minHeight = '100vh';
            }
        }
    }
    
    // Call on page load
    adjustForMobile();
    
    // Call on window resize
    window.addEventListener('resize', adjustForMobile);
});