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
    const initialPoints = 134;
    updateMemberInfo(initialPoints);
});