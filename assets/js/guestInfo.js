const specialCharRegex = /[!@#$%^&*]/;
const phoneRegex = /^(0[3|5|7|8|9])[0-9]{8}$/;
const digitRegex = /\d/;
document.addEventListener('DOMContentLoaded', function() {
    console.log("File JS đã được load thành công!");

    // Định nghĩa cấp độ thành viên và điểm yêu cầu theo cấp số cộng +100
    const memberLevels = [
        { name: "None", minPoints: 0, maxPoints: 100, nextLevel: "Silver" },
        { name: "Silver", minPoints: 100, maxPoints: 300, nextLevel: "Gold" },
        { name: "Gold", minPoints: 300, maxPoints: 600, nextLevel: "Platinum" },
        { name: "Platinum", minPoints: 600, maxPoints: 1000, nextLevel: "Diamond" },
        { name: "Diamond", minPoints: 1000, maxPoints: Infinity, nextLevel: null }
    ];

    const menuItems = document.querySelectorAll('.menu-item');
    const contentSections = document.querySelectorAll('.main-content-section');

    menuItems[0].classList.add('active');

    menuItems.forEach(item => {
        if (!item.dataset.section) return;
        
        item.addEventListener('click', function() {
            menuItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            const sectionToShow = this.dataset.section;
            contentSections.forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(`${sectionToShow}-content`).style.display = 'block';

            // If purchase history is selected, simulate loading data
            if (sectionToShow === 'purchase-history') {
                simulateLoadPurchaseHistory();
            }
        });
    });

    // Edit button handler
    document.getElementById("edit-button").addEventListener("click", function () {
        console.log("active");
        const inputs = document.querySelectorAll("#customer-info-content input");
        inputs.forEach(input => {
            if (input.type !== 'password') {
                input.removeAttribute("disabled");
            }
        });
    });

    // Password change handler
    const changePasswordBtn = document.querySelectorAll('.btn-save')[2];
    if (changePasswordBtn) {
        changePasswordBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const currentPassword = document.getElementById('current-password').value;
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            if (!currentPassword || !newPassword || !confirmPassword) {
                alert('Vui lòng điền đầy đủ thông tin!');
                return;
            }

            if (newPassword !== confirmPassword) {
                alert('Mật khẩu mới và xác nhận mật khẩu không khớp!');
                return;
            }

            alert('Mật khẩu đã được thay đổi thành công!');
            document.getElementById('current-password').value = '';
            document.getElementById('new-password').value = '';
            document.getElementById('confirm-password').value = '';
        });
    }

    // Save info button handler
    const saveInfoBtn = document.querySelectorAll('.btn-save')[1];
    if (saveInfoBtn) {
        saveInfoBtn.addEventListener('click', function(e) {
            e.preventDefault();
            alert('Thông tin đã được lưu!');
            
            // Disable inputs after saving
            const inputs = document.querySelectorAll("#customer-info-content input");
            inputs.forEach(input => {
                if (input.type !== 'password') {
                    input.setAttribute("disabled", "disabled");
                }
            });
        });
    }

    // function simulateLoadPurchaseHistory() {
    //     const tableBody = document.getElementById('purchase-history-data');
    //     const loadingSpinner = document.getElementById('loading-spinner');

    //     tableBody.style.display = 'none';
    //     loadingSpinner.style.display = 'block';

    //     setTimeout(() => {
    //         loadingSpinner.style.display = 'none';
    //         tableBody.style.display = 'table-row-group';
            
    //         tableBody.innerHTML = `
    //             <tr>
    //                 <td colspan="6" class="text-center py-4">Không có dữ liệu lịch sử mua hàng</td>
    //             </tr>
    //         `;
    //     }, 1000);
    // }

    // Hàm cập nhật thông tin thành viên dựa trên điểm
    function updateMemberInfo(points) {
        // Tìm cấp độ thành viên hiện tại
        let currentLevel = memberLevels[0];
        for (let i = memberLevels.length - 1; i >= 0; i--) {
            if (points >= memberLevels[i].minPoints) {
                currentLevel = memberLevels[i];
                break;
            }
        }
        
        // Tìm cấp độ tiếp theo
        const nextLevelIndex = memberLevels.findIndex(level => level.name === currentLevel.name) + 1;
        const nextLevel = nextLevelIndex < memberLevels.length ? memberLevels[nextLevelIndex] : null;
        
        // Cập nhật UI
        document.getElementById('currentPoints').textContent = points;
        document.getElementById('memberRank').textContent = currentLevel.name;
        
        // Cập nhật thông tin cấp độ tiếp theo
        const nextRankInfoElement = document.getElementById('nextRankInfo');
        if (nextLevel) {
            const pointsToNext = nextLevel.minPoints - points;
            document.getElementById('pointsToNext').textContent = pointsToNext;
            nextRankInfoElement.innerHTML = `Còn <span class="points-to-next">${pointsToNext}</span> điểm để lên hạng ${nextLevel.name}`;
        } else {
            nextRankInfoElement.textContent = "Bạn đã đạt hạng cao nhất!";
        }
        
        // Cập nhật thanh tiến trình
        document.getElementById('minPoints').textContent = currentLevel.minPoints;
        document.getElementById('maxPoints').textContent = `${nextLevel ? nextLevel.name : 'Max'} (${nextLevel ? nextLevel.minPoints : currentLevel.maxPoints})`;
        
        // Tính phần trăm tiến trình
        const progressPercentage = ((points - currentLevel.minPoints) / (nextLevel ? nextLevel.minPoints - currentLevel.minPoints : currentLevel.maxPoints - currentLevel.minPoints)) * 100;
        document.querySelector('.progress-bar').style.width = `${progressPercentage}%`;
        
        // Đánh dấu cấp độ thành viên hiện tại
        document.querySelectorAll('.benefit-item').forEach(item => {
            item.classList.remove('active');
        });
        
        const activeMemberElement = document.getElementById(`${currentLevel.name.toLowerCase()}Member`);
        if (activeMemberElement) {
            activeMemberElement.classList.add('active');
        }
    }
    
    // Giả lập điểm thành viên ban đầu
    const initialPoints = 341;
    updateMemberInfo(initialPoints);
});

document.addEventListener('DOMContentLoaded', function() {
    // --- Phần xử lý Thông tin cá nhân ---
    const editInfoButton = document.getElementById('edit-button');
    const saveInfoButton = document.getElementById('save-info-button');
   // Lấy form chứa nút "LƯU THÔNG TIN"
    const personalInfoForm = document.querySelector('form[action="app/controler/update_profile.php"]');

    const fullnameInput = document.getElementById('fullname');
    const birthdateInput = document.getElementById('birthdate');
    const phoneInput = document.getElementById('phone');
    const emailInput = document.getElementById('email');

    const infoInputs = [fullnameInput, birthdateInput, phoneInput, emailInput];
    const originalValues = {}; // Object để lưu giá trị gốc
    
    let isEditMode = false; // Biến cờ để theo dõi trạng thái chỉnh sửa

    if (editInfoButton) {
        editInfoButton.addEventListener('click', function() {
            isEditMode = !isEditMode; // Đảo trạng thái
            if (isEditMode) {
                // Chế độ Sửa
                this.innerHTML = '<i class="bi bi-x-circle"></i> Hủy'; // Đổi thành nút Hủy
                this.classList.remove('btn-secondary');
                this.classList.add('btn-dark');

                infoInputs.forEach(input => {
                    if (input) {
                        originalValues[input.id] = input.value; // << LƯU GIÁ TRỊ GỐC
                        input.removeAttribute('disabled');
                    }
                });
                // Không hiển thị nút "LƯU THÔNG TIN" ngay, chờ người dùng nhập liệu
            } else {
                this.innerHTML = '<i class="bi bi-wrench"></i> Sửa';
                this.classList.remove('btn-warning');
                this.classList.add('btn-secondary');

                infoInputs.forEach(input => {
                    if (input) {
                        input.value = originalValues[input.id]; // << KHÔI PHỤC GIÁ TRỊ GỐC
                        input.setAttribute('disabled', 'disabled');
                    }
                });
                if (saveInfoButton) saveInfoButton.style.display = 'none'
            }
        });
    }

    infoInputs.forEach(input => {
        if (input) {
            input.addEventListener('input', function() {
                if (isEditMode && saveInfoButton) {
                    saveInfoButton.style.display = 'inline-block';
                }
            });
        }
    });

    if (personalInfoForm) {
        personalInfoForm.addEventListener('submit', function(e) {
            // Kiểm tra khi form được submit (người dùng nhấn nút "LƯU THÔNG TIN")
            if (isEditMode) { // Chỉ kiểm tra nếu đang ở chế độ sửa
                const fullnameValue = fullnameInput ? fullnameInput.value.trim() : '';
                const birthdateValue = birthdateInput ? birthdateInput.value : '';
                const phoneValue = phoneInput ? phoneInput.value.trim() : '';
                const emailValue = emailInput ? emailInput.value.trim() : '';

                // 1. Kiểm tra Họ và tên
                if (fullnameValue === '') {
                    alert('Họ và tên không được để trống!');
                    fullnameInput.focus();
                    e.preventDefault();
                    return;
                }
                if (specialCharRegex.test(fullnameValue)) {
                    alert('Họ và tên không được chứa ký tự đặc biệt!');
                    fullnameInput.focus();
                    e.preventDefault();
                    return;
                }
                if (digitRegex.test(fullnameValue)) {
                    alert('Họ và tên không được chứa số!');
                    fullnameInput.focus();
                    e.preventDefault();
                    return;
                }
                // 2. Kiểm tra Ngày sinh
                if (birthdateValue === '') {
                    alert('Ngày sinh không được để trống!');
                    birthdateInput.focus();
                    e.preventDefault();
                    return;
                } else {
                    const birthDate = new Date(birthdateValue);
                    const today = new Date();
                    // Đặt giờ, phút, giây, ms về 0 để so sánh ngày chính xác
                    birthDate.setHours(0, 0, 0, 0);
                    today.setHours(0, 0, 0, 0);

                    if (birthDate >= today) {
                        alert('Ngày sinh phải là một ngày trong quá khứ!');
                        birthdateInput.focus();
                        e.preventDefault();
                        return;
                    }

                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }

                    if (age < 13) {
                        alert('Bạn phải đủ 13 tuổi trở lên!');
                        birthdateInput.focus();
                        e.preventDefault();
                        return;
                    }
                }
                // 3. Kiểm tra Số điện thoại
                if (phoneValue === '') {
                    alert('Số điện thoại không được để trống!');
                    phoneInput.focus();
                    e.preventDefault();
                    return;
                }
                if (!phoneRegex.test(phoneValue)) {
                    alert('Số điện thoại không hợp lệ. Vui lòng kiểm tra lại (VD: 09xxxxxxxx, 03xxxxxxxx, ...)!');
                    phoneInput.focus();
                    e.preventDefault();
                    return;
                }
                if (phoneValue.length < 10) {
                    alert("Số điện thoại phải gồm 10 chữ số");
                    phoneInput.focus();
                    e.preventDefault(); return;
                }

                // 4. Kiểm tra Email
                if (emailValue === '') {
                    alert('Email không được để trống!');
                    emailInput.focus();
                    e.preventDefault();
                    return;
                }
                // Kiểm tra email phải kết thúc bằng @gmail.com (không phân biệt chữ hoa/thường)
                if (!emailValue.toLowerCase().endsWith('@gmail.com')) {
                    alert('Email phải có định dạng là ...@gmail.com!');
                    emailInput.focus();
                    e.preventDefault();
                    return;
                }
            }
        });
    }


    // --- Phần xử lý Đổi mật khẩu ---
    const changePasswordButton = document.getElementById('change-password-button');
    const changePasswordForm = document.getElementById('changePasswordForm');

    if (changePasswordForm && changePasswordButton) {
        changePasswordForm.addEventListener('submit', function(e) {
            const currentPassword = document.getElementById('current-password').value;
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            let isValid = true;

            if (!currentPassword || !newPassword || !confirmPassword) {
                alert('Vui lòng điền đầy đủ thông tin mật khẩu!');
                isValid = false;
            }

            if (isValid && newPassword !== confirmPassword) {
                alert('Mật khẩu mới và xác nhận mật khẩu không khớp!');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault(); // Ngăn form submit nếu có lỗi validation
            } else {
                // Nếu validation phía client OK, cho phép form submit
                // Không cần alert ở đây, PHP (change_password.php) sẽ xử lý và thông báo kết quả
                // Ví dụ: alert('Yêu cầu đổi mật khẩu đã được gửi!');
                // Các trường input sẽ tự động được giữ lại hoặc xóa bởi trình duyệt khi submit,
                // hoặc bạn có thể xóa sau khi nhận phản hồi thành công từ server (nếu dùng AJAX).
                // Vì không dùng AJAX, không cần xóa ở đây.
                // document.getElementById('current-password').value = '';
                // document.getElementById('new-password').value = '';
                // document.getElementById('confirm-password').value = '';
            }
        });
    }
});