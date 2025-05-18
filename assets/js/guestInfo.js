document.addEventListener('DOMContentLoaded', function() {
    console.log("✅ File JS đã được load thành công!");

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

    const saveInfoBtn = document.querySelector('.btn-save');
    if (saveInfoBtn) {
        saveInfoBtn.addEventListener('click', function(e) {
            e.preventDefault();
            alert('Thông tin đã được lưu!');
        });
    }

    // Password change handler
    const changePasswordBtn = document.querySelectorAll('.btn-save')[1];
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

    function simulateLoadPurchaseHistory() {
        const tableBody = document.getElementById('purchase-history-data');
        const loadingSpinner = document.getElementById('loading-spinner');

        tableBody.style.display = 'none';
        loadingSpinner.style.display = 'block';

        setTimeout(() => {
            loadingSpinner.style.display = 'none';
            tableBody.style.display = 'table-row-group';
            
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4">Không có dữ liệu lịch sử mua hàng</td>
                </tr>
            `;
        }, 1000);
    }

    document.getElementById("edit-button").addEventListener("click", function () {
    console.log("active")
    const inputs = document.querySelectorAll("#customer-info-content input");
    inputs.forEach(input => input.removeAttribute("disabled"));
    });
});