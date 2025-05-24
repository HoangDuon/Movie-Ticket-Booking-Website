const allPages = ["dashboard", "users", "movies", "cinemas","concessions","membership","showtime","promotions"];
const specialCharRegex = /[!@#$%^&*]/;
const phoneRegex = /^(0[3|5|7|8|9])[0-9]{8}$/;
const digitRegex = /\d/;
const emailRegex = /^[\w.-]+@([\w-]+\.)+[\w-]{2,4}$/;
// const specialCharRegex = /[^a-zA-Z0-9\s\-']/;

document.querySelectorAll(".menu-item").forEach(item => {
    item.addEventListener("click", function () {
        const page = this.getAttribute("data-page");

        document.querySelectorAll(".menu-item").forEach(i => i.classList.remove("active"));
        this.classList.add("active");

        allPages.forEach(p => {
            document.getElementById("page-" + p).style.display = "none";
        });

        document.getElementById("page-" + page).style.display = "block";
    });
});
// Sửa xong vẫn ở tab đó
document.addEventListener("DOMContentLoaded", function () {
    const hash = window.location.hash;
    if (hash) {
        const tab = hash.replace('#', '');
        const targetTab = document.querySelector(`[data-page="${tab}"]`);
        if (targetTab) {
            targetTab.click(); // Kích hoạt tab bằng cách click vào menu
        }
    }
});
//JS phần thêm xóa sửa phim
function showMovieEditForm(button) {
  document.getElementById('editTitle').value = button.dataset.title;
  document.getElementById('editGenre').value = button.dataset.genre;
  document.getElementById('editDuration').value = button.dataset.duration;
  document.getElementById('editDirector').value = button.dataset.director;
  document.getElementById('editCast').value = button.dataset.cast;
  document.getElementById('editLanguage').value = button.dataset.language;
  document.getElementById('editTrailer').value = button.dataset.trailer;
  document.getElementById('editReleaseDate').value = button.dataset.release;
  document.getElementById('editId').value = button.dataset.id;

  // Gán mô tả vào CKEditor
  if (CKEDITOR.instances['editDescription']) {
      CKEDITOR.instances['editDescription'].setData(button.dataset.description);
  } else {
      CKEDITOR.replace('editDescription', {
          on: {
              instanceReady: function () {
                  this.setData(button.dataset.description);
              }
          }
      });
  }

  // Hiện form nổi
  document.getElementById('editMovieFormPanel').style.display = 'flex';
}

function hideMovieEditForm() {
  document.getElementById('editMovieFormPanel').style.display = 'none';
}

function showMovieAddForm() {
  document.getElementById('editMovieForm').reset();
  document.getElementById('editId').value = "";

  // Nếu đã có CKEditor thì xóa nội dung
  if (CKEDITOR.instances['editDescription']) {
      CKEDITOR.instances['editDescription'].setData('');
  }

  document.getElementById('editMovieFormPanel').style.display = 'flex';
}

function updateCkEditorBeforeSubmit() {
  for (let instance in CKEDITOR.instances) {
      CKEDITOR.instances[instance].updateElement();
  }
}

function showMovieDeleteConfirm(movieId,hide) {
  document.getElementById('deleteMovieId').value = movieId;
  const title = document.getElementById('titleMovie');
  title.textContent = hide === 0
      ? "Bạn có chắc muốn ẩn phim này không?"
      : "Bạn có chắc muốn hiện phim này không?";
  document.getElementById('deleteMovieConfirmPanel').style.display = 'flex';
}

function hideMovieDeleteConfirm() {
  document.getElementById('deleteMovieConfirmPanel').style.display = 'none';
}
// Validate sửa phim
document.getElementById('editMovieForm').addEventListener('submit', function (e) {
    updateCkEditorBeforeSubmit(); // đảm bảo CKEditor cập nhật textarea

    const title = document.getElementById("editTitle").value.trim();
    const genre = document.getElementById("editGenre").value.trim();
    const director = document.getElementById("editDirector").value.trim();
    const duration = document.getElementById("editDuration").value.trim();
    const language = document.getElementById("editLanguage").value.trim();
    const releaseDate = document.getElementById("editReleaseDate").value.trim();
    const cast = document.getElementById("editCast").value.trim();
    const trailer = document.getElementById("editTrailer").value.trim();
    const poster = document.getElementById("editPoster"); // type="file"
    const banner = document.getElementById("editBanner");
    const description = CKEDITOR.instances['editDescription'].getData().trim();

    // 1. Tiêu đề
    if (!title) {
        alert("Tiêu đề không được để trống!");
        document.getElementById('editTitle').focus();
        e.preventDefault(); return;
    }
    if (title.length > 100) {
      alert("Tiêu đề chỉ tối đa là 100 ký tự");
      document.getElementById('editTitle').focus();
      e.preventDefault(); return;
    }

    if (specialCharRegex.test(title)) {
      alert("Tên phim không được chứa ký tự đặc biệt (!@#$%^&*).");
      document.getElementById('editTitle').focus();
      e.preventDefault(); return;
    }

    if (digitRegex.test(title)) {
        alert("Tên phim không được chứa số.");
        document.getElementById('editGenre').focus();
        e.preventDefault(); return;
    }
    // 2. Thể loại
    if (!genre) {
        alert("Thể loại không được để trống!");
        document.getElementById('editGenre').focus();
        e.preventDefault(); return;
    }
    if (genre.length > 100) {
        alert("Thể loại tối đa 100 ký tự!");
        document.getElementById('editGenre').focus();
        e.preventDefault(); return;
    }
    if (specialCharRegex.test(genre)) {
      alert("Thể loại không được chứa ký tự đặc biệt (!@#$%^&*).");
      document.getElementById('editGenre').focus();
      e.preventDefault(); return;
    }

    if (digitRegex.test(genre)) {
        alert("Thể loại không được chứa số.");
        document.getElementById('editGenre').focus();
        e.preventDefault(); return;
    }
    // 3. Đạo diễn
    if (!director) {
        alert("Đạo diễn không được để trống!");
        document.getElementById('editDirector').focus();
        e.preventDefault(); return;
    }
    if (specialCharRegex.test(director)) {
      alert("Đạo diễn không được chứa ký tự đặc biệt (!@#$%^&*).");
      document.getElementById('editDirector').focus();
      e.preventDefault(); return;
    }

    if (digitRegex.test(director)) {
        alert("Đạo diễn không được chứa số.");
        document.getElementById('editDirector').focus();
        e.preventDefault(); return;
    }
    // 4. Thời lượng
    if (!duration) {
        alert("Thời lượng không được để trống!");
        document.getElementById('editDuration').focus();
        e.preventDefault(); return;
    }
    if (isNaN(duration) || duration <= 0) {
        alert("Thời lượng phải là số dương!");
        document.getElementById('editDuration').focus();
        e.preventDefault(); return;
    }

    // 5. Ngôn ngữ
    if (!language) {
        alert("Ngôn ngữ không được để trống!");
        document.getElementById('editLanguage').focus();
        e.preventDefault(); return;
    }
    if (specialCharRegex.test(language)) {
      alert("Ngôn ngữ không được chứa ký tự đặc biệt (!@#$%^&*).");
      document.getElementById('editLanguage').focus();
      e.preventDefault(); return;
    }

    if (digitRegex.test(language)) {
        alert("Ngôn ngữ không được chứa số.");
        document.getElementById('editLanguage').focus();
        e.preventDefault(); return;
    }
    // 6. Ngày phát hành
    if (!releaseDate) {
        alert("Ngày phát hành không được để trống!");
        document.getElementById('editReleaseDate').focus();
        e.preventDefault(); return;
    }
    const today = new Date();
    const release = new Date(releaseDate);

    // Khoảng cho phép: từ 1 tháng trước đến 3 tháng sau
    const oneMonthAgo = new Date(today);
    oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);

    const threeMonthsLater = new Date(today);
    threeMonthsLater.setMonth(threeMonthsLater.getMonth() + 3);

    if (release < oneMonthAgo || release > threeMonthsLater) {
        alert("Ngày phát hành phải nằm trong khoảng từ 1 tháng trước đến 3 tháng sau tính từ hôm nay.");
        document.getElementById('editReleaseDate').focus();
        e.preventDefault(); return;
    }
    // 7. Diễn viên
    if (!cast) {
        alert("Diễn viên không được để trống!");
        document.getElementById('editCast').focus();
        e.preventDefault(); return;
    }

    if (specialCharRegex.test(cast)) {
      alert("Diễn viên không được chứa ký tự đặc biệt (!@#$%^&*).");
      document.getElementById('editCast').focus();
      e.preventDefault(); return;
    }

    if (digitRegex.test(cast)) {
        alert("Diễn viên không được chứa số.");
        document.getElementById('editCast').focus();
        e.preventDefault(); return;
    }
    // 8. Mô tả
    if (!description) {
        alert("Mô tả không được để trống!");
        document.getElementById('editCast').focus();
        e.preventDefault(); return;
    }

    // 9. Trailer
    if (!/^https?:\/\//.test(trailer)) {
        alert("Link trailer phải bắt đầu bằng http:// hoặc https://");
        document.getElementById('editTrailer').focus();
        e.preventDefault(); return;
    }

    // 10 + 11. Poster và Banner: nếu là thêm mới (id rỗng)
    const isAddMode = document.getElementById("editId").value === "";

    if (isAddMode) {
        if (poster.files.length === 0) {
            alert("Poster là bắt buộc khi thêm mới!");
            e.preventDefault(); return;
        }
        // if (banner.files.length === 0) {
        //     alert("Banner là bắt buộc khi thêm mới!");
        //     e.preventDefault(); return;
        // }
    }
});

function populateEditUserForm(userData) {
    const form = document.getElementById('editUserForm');
    if (!form) {
        console.error("Không tìm thấy #editUserForm!");
        return;
    }

    document.getElementById('editUserName').value = userData.name || '';
    document.getElementById('editUserEmail').value = userData.email || '';
    document.getElementById('editUserPhone').value = userData.phone || '';
    document.getElementById('editUserBirthday').value = userData.birthday || '';
    document.getElementById('editUserPassword').value = ""; // Để trống mật khẩu khi sửa, chỉ nhập nếu muốn đổi

    form.dataset.originalEmail = userData.email ? userData.email.toLowerCase() : '';
    form.dataset.originalPhone = userData.phone || '';

    console.log("Dataset sau khi populate:", form.dataset.originalEmail, form.dataset.originalPhone);
}

//JS phần thêm xóa sửa người dùng
function showEditUserForm(button) {
    const form = document.getElementById('editUserForm'); 
    const userId = button.dataset.id;
    const userName = button.dataset.name;
    const userEmail = button.dataset.email;
    const userPhone = button.dataset.phone;
    const userBirthday = button.dataset.birthday;
    const userRole = button.dataset.role;
    const userMember = button.dataset.member;

    // 2. Điền các giá trị vào input fields của form
    document.getElementById('editUserId').value = userId || '';
    document.getElementById('editUserName').value = userName || '';
    document.getElementById('editUserEmail').value = userEmail || '';
    document.getElementById('editUserPhone').value = userPhone || '';
    document.getElementById('editUserBirthday').value = userBirthday || '';
    document.getElementById('editUserRole').value = userRole || '';
    document.getElementById('editUserMember').value = userMember || '';

    // --- ẨN TRƯỜNG MẬT KHẨU KHI SỬA ---
    const passwordInput = document.getElementById('editUserPassword');
    const passwordLabel = document.querySelector("label[for='editUserPassword']");

    if (passwordInput) {
        passwordInput.style.display = 'none';
        passwordInput.value = '';
    }
    if (passwordLabel) {
        passwordLabel.style.display = 'none';
    }
    // --- KẾT THÚC ẨN TRƯỜNG MẬT KHẨU ---

    // 3. Lưu email và SĐT gốc (lấy từ button.dataset) vào dataset của FORM
    form.dataset.originalEmail = userEmail ? userEmail.toLowerCase() : '';
    form.dataset.originalPhone = userPhone || '';

    console.log("Form được điền. UserID:", userId);
    console.log("Dataset originalEmail được set:", form.dataset.originalEmail);
    console.log("Dataset originalPhone được set:", form.dataset.originalPhone);

  // Hiện form nổi
  document.getElementById('editUserFormPanel').style.display = 'flex';
}

function hideEditUserForm() {
  document.getElementById('editUserFormPanel').style.display = 'none';
}

function showAddUserForm() {
  document.getElementById('editUserForm').reset();

  document.getElementById('editUserId').value = "";

  document.getElementById('editUserFormPanel').style.display = 'flex';
}


function showDeleteUserConfirm(movieId,hide) {
  document.getElementById('deleteUserId').value = movieId;
  const title = document.getElementById('titleUser');
  title.textContent = hide === 0
      ? "Bạn có chắc muốn ẩn người dùng này không?"
      : "Bạn có chắc muốn hiện người dùng này không?";
  document.getElementById('deleteUserConfirmPanel').style.display = 'flex';
}

function hideDeleteUserConfirm() {
  document.getElementById('deleteUserConfirmPanel').style.display = 'none';
}

// Validate sửa người dùng
document.addEventListener('DOMContentLoaded', function() {
    // --- Các hằng số Regex bạn đã cung cấp hoặc đã chuẩn hóa ---
    const specialCharRegex = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~`]/;
    const phoneRegex = /^(0[3|5|7|8|9])[0-9]{8}$/;
    const digitRegex = /\d/;
    const emailRegex = /^[\w.-]+@([\w-]+\.)+[\w-]{2,4}$/; // Regex email tổng quát

    let existingCredentials = []; // Mảng chứa danh sách [email1, phone1, email2, phone2, ...]

    // Hàm để tải danh sách email và số điện thoại hiện có từ server
    async function fetchExistingCredentials() {
        try {
            // Đảm bảo đường dẫn này chính xác đến file PHP của bạn
            const response = await fetch('../controler/get_all_emails_phones.php');
            if (!response.ok) {
                throw new Error('Lỗi mạng khi tải danh sách email/SĐT: ' + response.status);
            }
            const data = await response.json();
            if (data.success && Array.isArray(data.list)) {
                // Chuyển tất cả về chữ thường để so sánh không phân biệt hoa/thường (đặc biệt quan trọng cho email)
                // và loại bỏ các giá trị null/undefined nếu có từ PHP
                existingCredentials = data.list.filter(item => item != null).map(item => String(item).toLowerCase());
                // console.log('Danh sách email/SĐT đã tải:', existingCredentials);
            } else {
                console.error('Dữ liệu email/SĐT từ server không hợp lệ:', data);
                alert('Không thể tải danh sách email/SĐT để kiểm tra trùng lặp.');
            }
        } catch (error) {
            console.error('Lỗi khi fetchExistingCredentials:', error);
            alert('Xảy ra lỗi khi kết nối để lấy danh sách email/SĐT: ' + error.message);
        }
    }

    // Gọi hàm này khi trang/phần quản lý người dùng được tải
    fetchExistingCredentials();

    // Sự kiện submit cho form thêm/sửa người dùng
    const editUserForm = document.getElementById('editUserForm');
    if (editUserForm) {
        editUserForm.addEventListener('submit', function (e) {
            const userNameInput = document.getElementById("editUserName");
            const userEmailInput = document.getElementById("editUserEmail");
            const userPhoneInput = document.getElementById("editUserPhone");
            const userDOBInput = document.getElementById("editUserBirthday");
            // const userRoleInput = document.getElementById("editUserRole"); // Lấy nếu cần validate
            // const userMemberInput = document.getElementById("editUserMember"); // Lấy nếu cần validate
            const userPasswordInput = document.getElementById("editUserPassword");
            const userIdInput = document.getElementById("editUserId");

            const userName = userNameInput.value.trim();
            const userEmail = userEmailInput.value.trim();
            const userPhone = userPhoneInput.value.trim();
            const userDOB = userDOBInput.value.trim();
            const userPassword = userPasswordInput.value; // Không trim mật khẩu
            const userId = userIdInput.value.trim(); // ID của user đang sửa, hoặc rỗng nếu thêm mới

            const isAdd = (userId === "" || userId === "0" || !userId); // Xác định đang Thêm hay Sửa

            // Lấy email/SĐT gốc từ dataset của form (đã được set khi load form sửa)
            const originalEmail = (editUserForm.dataset.originalEmail || '').toLowerCase();
            const originalPhone = editUserForm.dataset.originalPhone || '';
            const userEmailLower = userEmail.toLowerCase();

            // --- VALIDATION CƠ BẢN (giữ nguyên và bổ sung) ---
            // 1. Tên người dùng
            if (!userName) {
                alert("Tên người dùng không được để trống!");
                userNameInput.focus();
                e.preventDefault(); return;
            }
            if (userName.length > 100) {
                alert("Tên người dùng tối đa 100 ký tự.");
                userNameInput.focus();
                e.preventDefault(); return;
            }
            if (specialCharRegex.test(userName)) {
                alert("Tên người dùng không được chứa ký tự đặc biệt.");
                userNameInput.focus();
                e.preventDefault(); return;
            }
            if (digitRegex.test(userName)) {
                alert("Tên người dùng không được chứa số.");
                userNameInput.focus();
                e.preventDefault(); return;
            }

            // 2. Email người dùng
            if (!userEmail) {
                alert("Email không được để trống.");
                userEmailInput.focus();
                e.preventDefault(); return;
            }
            if (!emailRegex.test(userEmail)) {
                alert("Email không hợp lệ.");
                userEmailInput.focus();
                e.preventDefault(); return;
            }
            // Kiểm tra đuôi @gmail.com nếu cần
            if (!userEmail.toLowerCase().endsWith('@gmail.com')) {
                 alert('Hệ thống chỉ hỗ trợ email có đuôi @gmail.com!');
                 userEmailInput.focus();
                 e.preventDefault(); return;
            }


            // 3. Số điện thoại
            if (!userPhone) {
                alert("Số điện thoại không được để trống.");
                userPhoneInput.focus();
                e.preventDefault(); return;
            }
            if (userPhone.length !== 10) { // Sửa: chính xác 10 chữ số
                alert("Số điện thoại phải gồm 10 chữ số.");
                userPhoneInput.focus();
                e.preventDefault(); return;
            }
            if (!phoneRegex.test(userPhone)) { // Đảm bảo phoneRegex đã được định nghĩa
                alert("Số điện thoại không hợp lệ (VD: 09xxxxxxxx, 03xxxxxxxx...).");
                userPhoneInput.focus();
                e.preventDefault(); return;
            }
console.log("--- DEBUG TRƯỚC KHI KIỂM TRA TRÙNG LẶP ---");
            console.log("ID Người dùng đang sửa (userId):", userId);
            console.log("Chế độ Thêm mới (isAdd):", isAdd);
            console.log("Email nhập vào (form, lowercase):", userEmailLower);
            console.log("Email gốc (dataset, lowercase):", originalEmail);
            console.log("SĐT nhập vào (form):", userPhone);
            console.log("SĐT gốc (dataset):", originalPhone);
            console.log("Danh sách hiện có (existingCredentials, lowercase):", existingCredentials);
            console.log("-------------------------------------------");
          // --- KIỂM TRA TRÙNG LẶP EMAIL (ĐÃ CẬP NHẬT LOGIC) ---
            if (isAdd) { // Nếu là THÊM MỚI người dùng
                if (existingCredentials.includes(userEmailLower)) {
                    alert("Địa chỉ email này đã được sử dụng. Vui lòng chọn email khác.");
                    userEmailInput.focus();
                    e.preventDefault();
                    return;
                }
            } else { // Nếu là SỬA người dùng hiện tại
                if (userEmailLower !== originalEmail) { // Chỉ kiểm tra nếu email đã bị THAY ĐỔI
                    if (existingCredentials.includes(userEmailLower)) {
                        alert("Địa chỉ email mới này đã được sử dụng bởi người dùng khác. Vui lòng chọn email khác.");
                        userEmailInput.focus();
                        e.preventDefault();
                        return;
                    }
                }
                // Nếu email không thay đổi (userEmailLower === originalEmail), bỏ qua kiểm tra trùng lặp cho email này.
            }

            // --- KIỂM TRA TRÙNG LẶP SỐ ĐIỆN THOẠI (ĐÃ CẬP NHẬT LOGIC) ---
            if (isAdd) { // Nếu là THÊM MỚI người dùng
                if (existingCredentials.includes(userPhone)) {
                    alert("Số điện thoại này đã được sử dụng. Vui lòng chọn số khác.");
                    userPhoneInput.focus();
                    e.preventDefault();
                    return;
                }
            } else { // Nếu là SỬA người dùng hiện tại
                if (userPhone !== originalPhone) { // Chỉ kiểm tra nếu SĐT đã bị THAY ĐỔI
                    if (existingCredentials.includes(userPhone)) {
                        alert("Số điện thoại mới này đã được sử dụng bởi người dùng khác. Vui lòng chọn số khác.");
                        userPhoneInput.focus();
                        e.preventDefault();
                        return;
                    }
                }
                // Nếu SĐT không thay đổi (userPhone === originalPhone), bỏ qua kiểm tra trùng lặp cho SĐT này.
            }
            // --- KẾT THÚC KIỂM TRA TRÙNG LẶP ---

            // 4. Ngày sinh
            if (userDOB === '') {
                alert('Ngày sinh không được để trống!');
                userDOBInput.focus();
                e.preventDefault(); return;
            } else {
                const birthDate = new Date(userDOB);
                const today = new Date();
                birthDate.setHours(0, 0, 0, 0);
                today.setHours(0, 0, 0, 0);

                if (isNaN(birthDate.getTime())) { // Kiểm tra ngày hợp lệ
                    alert('Ngày sinh không hợp lệ.');
                    userDOBInput.focus();
                    e.preventDefault(); return;
                }
                if (birthDate >= today) {
                    alert('Ngày sinh phải là một ngày trong quá khứ!');
                    userDOBInput.focus();
                    e.preventDefault(); return;
                }
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                if (age < 13) {
                    alert('Người dùng phải đủ 13 tuổi trở lên!');
                    userDOBInput.focus();
                    e.preventDefault(); return;
                }
            }
            
            // 7. Mật khẩu
            if (isAdd) { // Mật khẩu bắt buộc khi thêm mới
                if (!userPassword) {
                    alert("Mật khẩu bắt buộc khi thêm mới.");
                    userPasswordInput.focus();
                    e.preventDefault(); return;
                }
                if (userPassword.length < 6) {
                    alert("Mật khẩu phải có ít nhất 6 kí tự.");
                    userPasswordInput.focus();
                    e.preventDefault(); return;
                }
            } else { // Khi sửa người dùng
                if (userPassword !== "" && userPassword.length < 6) {
                    // Nếu admin nhập mật khẩu mới (khác rỗng) thì phải đủ dài
                    alert("Nếu thay đổi, mật khẩu mới phải có ít nhất 6 kí tự.");
                    userPasswordInput.focus();
                    e.preventDefault(); return;
                }
                // Nếu userPassword rỗng khi sửa, nghĩa là không muốn đổi mật khẩu -> server sẽ không cập nhật.
            }

            // Nếu không có lỗi nào, form sẽ submit
            // alert("Dữ liệu hợp lệ!"); // Cho mục đích debug
        });
    }
});
//JS phần thêm xóa sửa membership
function showEditMemberForm(button) {
  document.getElementById('editMemberMember').value = button.dataset.member;
  document.getElementById('editMemberDiscount').value = button.dataset.discount;

    // Gán mô tả vào CKEditor
  if (CKEDITOR.instances['editMemberContent']) {
      CKEDITOR.instances['editMemberContent'].setData(button.dataset.content);
  } else {
      CKEDITOR.replace('editMemberContent', {
          on: {
              instanceReady: function () {
                  this.setData(button.dataset.content);
              }
          }
      });
  }

  // Hiện form nổi
  document.getElementById('editMemberFormPanel').style.display = 'flex';
}

function hideEditMemberForm() {
  document.getElementById('editMemberFormPanel').style.display = 'none';
}

function showDeleteMemberConfirm(movieId) {
  document.getElementById('deleteMemberId').value = movieId;
  document.getElementById('deleteMemberConfirmPanel').style.display = 'flex';
}

function hideDeleteMemberConfirm() {
  document.getElementById('deleteMemberConfirmPanel').style.display = 'none';
}
// Validate sửa membership 
document.getElementById("editMemberForm").addEventListener("submit", function (e) {
    const discountPercent = document.getElementById("editMemberDiscount").value.trim();
    const description = document.getElementById("editMemberContent").value.trim();

    // 1. Phần trăm giảm giá
    if (!discountPercent) {
        alert("Tỉ lệ giảm không được để trống.");
        document.getElementById('editConcessionsPrice').focus();
        e.preventDefault(); return;
    }
    if (isNaN(discountPercent) || parseFloat(discountPercent) < 0) {
      alert("Tỉ lệ giảm phải là số dương.");
      document.getElementById('editConcessionsPrice').focus();
      e.preventDefault(); return;
    }

    if(parseFloat(discountPercent) > 50) {
      alert("Tỉ lệ giảm không vượt quá 50%");
      document.getElementById('editConcessionsPrice').focus();
      e.preventDefault(); return;
    }

    // 3. Ảnh (bắt buộc khi thêm mới)
    if (!description) {
      alert("Nội dung không được để trống");
      document.getElementById('editMemberContent').focus();
      e.preventDefault(); return;
    }
});

//JS phần thêm xóa sửa đồ ăn
function showEditConcessionsForm(button) {
  document.getElementById('editConcessionsName').value = button.dataset.name;
  document.getElementById('editConcessionsPrice').value = button.dataset.price;
  document.getElementById('editConcessionsId').value = button.dataset.id;

  // Hiện form nổi
  document.getElementById('editConcessionsFormPanel').style.display = 'flex';
}

function hideEditConcessionsForm() {
  document.getElementById('editConcessionsFormPanel').style.display = 'none';
}

function showAddConcessionsForm() {
  document.getElementById('editConcessionsForm').reset();

  document.getElementById('editConcessionsId').value = "";

  document.getElementById('editConcessionsFormPanel').style.display = 'flex';
}


function showDeleteConcessionsConfirm(movieId,hide) {
  document.getElementById('deleteConcessionsId').value = movieId;

  const title = document.getElementById('titleConcession');
  title.textContent = hide === 0
      ? "Bạn có chắc muốn ẩn phần này không?"
      : "Bạn có chắc muốn hiện phần này không?";

  document.getElementById('deleteConcessionsConfirmPanel').style.display = 'flex';
}

function hideDeleteConcessionsConfirm() {
  document.getElementById('deleteConcessionsConfirmPanel').style.display = 'none';
}
// Validate thêm sửa đồ ăn
document.getElementById("editConcessionsForm").addEventListener("submit", function (e) {
    const name = document.getElementById("editConcessionsName").value.trim();
    const price = document.getElementById("editConcessionsPrice").value.trim();
    const picture = document.getElementById("editPicture");
    const id = document.getElementById("editConcessionsId").value.trim();

    // 1. Tên đồ ăn
    if (!name) {
        alert("Tên đồ ăn không được để trống.");
        document.getElementById('editConcessionsName').focus();
        e.preventDefault(); return;
    }
    if (name.length > 100) {
      alert("Tên đồ ăn không vượt quá 100 ký tự.");
      document.getElementById('editConcessionsName').focus();
      e.preventDefault(); return;
    }

    if (specialCharRegex.test(name)) {
        alert("Tên đồ ăn không được chứa ký tự đặc biệt (!@#$%^&*).");
        document.getElementById('editConcessionsName').focus();
        e.preventDefault(); return;
    }

    // 2. Giá
    if (!price) {
        alert("Giá không được để trống.");
        document.getElementById('editConcessionsPrice').focus();
        e.preventDefault(); return;
    }
    if (isNaN(price) || parseFloat(price) <= 0) {
      alert("Giá phải là số dương.");
      document.getElementById('editConcessionsPrice').focus();
      e.preventDefault(); return;
    }

    if(parseFloat(price) > 1000000) {
      alert("Giá không vượt quá 1 triệu VNĐ.");
      document.getElementById('editConcessionsPrice').focus();
      e.preventDefault(); return;
    }

    if (specialCharRegex.test(name)) {
      alert("Giá không được chứa ký tự đặc biệt (!@#$%^&*).");
      document.getElementById('editConcessionsName').focus();
      e.preventDefault(); return;
    }

    // 3. Ảnh (bắt buộc khi thêm mới)
    const isAdd = id === "";
    if (isAdd && picture.files.length === 0) {
        alert("Ảnh minh họa là bắt buộc khi thêm mới.");
        e.preventDefault(); return;
    }
});

//JS phần thêm xóa sửa rạp phim
function showEditCinemasForm(button, cinemaId) {
  document.getElementById('editCinemasName').value = button.dataset.name;
  document.getElementById('editCinemasLocation').value = button.dataset.location;
  document.getElementById('editCinemasId').value = button.dataset.id;
  document.getElementById('editCinemasPhone').value = button.dataset.phone;
  document.getElementById('editCinemasRooms').value = button.dataset.rooms;
  document.getElementById('editCinemasShowtimes').value = button.dataset.showtimes;

  document.querySelector('.seat-container').innerHTML = '';
  // Hiện form nổi
  document.getElementById('editCinemasFormPanel').style.display = 'flex';

  // Gán CinemaId vào hidden input
  button.dataset.id = cinemaId;

  // Gọi API lấy danh sách phòng theo cinemaId
  fetch(`../../app/controler/get_rooms_by_cinema.php?cinema_id=${cinemaId}`)
      .then(response => response.json())
      .then(data => {
          const roomsTableBody = document.getElementById('roomsTableBody');
          roomsTableBody.innerHTML = '';
          // Đổ danh sách phòng ra bảng
          data.rooms.forEach((room, index) => {
              const row = `
                  <tr>
                      <td style="padding: 8px; text-align: center;">${index + 1}</td>
                      <td style="padding: 8px; text-align: center;">${room.name}</td>
                      <td style="padding: 8px; text-align: center;">${room.seat_count}</td>
                      <td style="padding: 8px; text-align: center;">
                          <button type="button" onclick="showSeatMap(${room.room_id})">Xem chi tiết</button>
                      </td>
                  </tr>
              `;
              roomsTableBody.innerHTML += row;
          });
      })
      .catch(error => {
          console.error('Lỗi khi load phòng:', error);
      });
}

function showSeatMap(roomId) {
  fetch(`../../app/controler/get_seats_by_room.php?room_id=${roomId}`)
  .then(response => response.json())
  .then(data => { 
      const seatContainer = document.querySelector('.seat-container');
      document.getElementById('seatMapContainer').style.display = 'block';
      seatContainer.innerHTML = ''; // Clear seats cũ
      data.seats.forEach(seat => {
          const seatDiv = document.createElement('div');
          seatDiv.className = `seat ${seat.hide == 1 ? 'booked' : 'available'} ${seat.seat_type.toLowerCase()}`;
          seatDiv.textContent = seat.seat_number;
          seatDiv.onclick = function() {
            handleSeatClick(seat);};
          seatContainer.appendChild(seatDiv);
          document.getElementById('editRoomName').value = seat.room_name;
          document.getElementById('editStatus').value = seat.room_hide;
          document.getElementById('editRoomId').value = roomId;
      });
  })
  .catch(error => {
      console.error('Error:', error);
  });
}

function handleSeatClick(seat) {
  console.log(seat)
  document.getElementById('seatDetail').style.display = 'block';
  document.getElementById('editSeatName').value = seat.seat_number;
  document.getElementById('editSeatPrice').value = seat.extra_price;
  document.getElementById('editSeatType').value = seat.seat_type;
  // document.getElementById('editSeatStatus').value = seat.status;
  document.getElementById('editSeatHide').value = seat.hide;  
  document.getElementById('editSeatId').value = seat.seat_id;
}

function hideEditCinemasForm() {
  document.getElementById('editCinemasFormPanel').style.display = 'none';
  document.getElementById('seatMapContainer').style.display = 'none';
  document.getElementById('seatDetail').style.display = 'none';
}

function showAddCinemasForm() {
  document.getElementById('editCinemasForm').reset();

  document.getElementById('editCinemasId').value = "";

  document.getElementById('editCinemasFormPanel').style.display = 'flex';
}


function showDeleteCinemasConfirm(movieId,hide) {
  document.getElementById('deleteCinemasId').value = movieId;

  const title = document.getElementById('titleCinema');
  title.textContent = hide === 0
      ? "Bạn có chắc muốn ẩn rạp này không?"
      : "Bạn có chắc muốn hiện rạp này không?";

  document.getElementById('deleteCinemasConfirmPanel').style.display = 'flex';
}

function hideDeleteCinemasConfirm() {
  document.getElementById('deleteCinemasConfirmPanel').style.display = 'none';
}
// Validate thêm, sửa rạp phim
document.getElementById("editCinemasForm").addEventListener("submit", function (e) {
    const cineName = document.getElementById("editCinemasName").value.trim();
    const cineLocation = document.getElementById("editCinemasLocation").value.trim();
    const cineId = document.getElementById("editCinemasId");
    const cinePhone = document.getElementById("editCinemasPhone").value.trim();
    const cineRooms = document.getElementById("editCinemasRooms").value.trim();
    const cineShowtimes = document.getElementById("editCinemasShowtimes").value.trim();

    // 1. Tên rạp phim
    if (!cineName) {
        alert("Tên rạp phim không được để trống");
        document.getElementById('editCinemasName').focus();
        e.preventDefault(); return;
    }
    if (cineName.length > 100) {
      alert("Tên rạp phim không vượt quá 100 ký tự.");
      document.getElementById('editCinemasName').focus();
      e.preventDefault(); return;
    }
    if (specialCharRegex.test(cineName)) {
      alert("Tên rạp phim không được chứa ký tự đặc biệt (!@#$%^&*).");
      document.getElementById('editCinemasName').focus();
      e.preventDefault(); return;
    }
    if (digitRegex.test(cineName)) {
      alert("Tên rạp phim không được chứa số.");
      document.getElementById('editCinemasName').focus();
      e.preventDefault(); return;
    }

    // 2. Vị trí rạp phim
    if (!cineLocation) {
        alert("Vị trí rạp phim không được để trống");
        document.getElementById('editCinemasLocation').focus();
        e.preventDefault(); return;
    }
    if (cineLocation.length > 100) {
      alert("Vị trí rạp phim không vượt quá 100 ký tự.");
      document.getElementById('editCinemasLocation').focus();
      e.preventDefault(); return;
    }
    if (specialCharRegex.test(cineLocation)) {
      alert("Vị trí rạp phim không được chứa ký tự đặc biệt (!@#$%^&*).");
      document.getElementById('editCinemasLocation').focus();
      e.preventDefault(); return;
    }
    if (digitRegex.test(cineLocation)) {
      alert("Vị trí rạp phim không được chứa số.");
      document.getElementById('editCinemasLocation').focus();
      e.preventDefault(); return;
    }

    // 3. Điện thoại rạp phim
    if (!cinePhone) {
        alert("Số điện thoại không được để trống");
        document.getElementById('editUserPhone').focus();
        e.preventDefault(); return;
    }

    if (cinePhone.length < 10) {
        alert("Số điện thoại phải gồm 10 chữ số");
        document.getElementById('editUserPhone').focus();
        e.preventDefault(); return;
    }

    if (!phoneRegex.test(cinePhone)) {
        alert("Số điện thoại phải bắt đầu bằng với số 0[3|5|7|8|9]");
        document.getElementById('editUserPhone').focus();
        e.preventDefault(); return;
    }
});

document.getElementById("editSeatsForm").addEventListener("submit", async function (e) {
    e.preventDefault(); // Ngăn submit ngay từ đầu
    const seatNumberInput = document.getElementById("editSeatName");
    const seatNumber = seatNumberInput.value.trim();
    const seatPrice = document.getElementById("editSeatPrice").value.trim();
    const roomId = document.getElementById("editRoomId").value.trim();
    const seatId = document.getElementById("editSeatId").value.trim();
  // Kiểm tra số ghế
  if (!seatNumberInput) {
        alert("Số ghế không được để trống.");
        document.getElementById('editSeatName').focus();
        return;
    }

    if (seatNumberInput.length > 5) {
        alert("Số ghế không được vượt quá 5 ký tự.");
        document.getElementById('editSeatName').focus();
        return;
    }

    // const seatFormatRegex = /^[A-Za-z]{1,2}\d{1,2}$/; 
    // if (!seatFormatRegex.test(seatNumberInput)) {
    //     alert("Định dạng số ghế không hợp lệ. Ví dụ: A1, B12, AA5.");
    //     document.getElementById('editSeatName').focus();
    //     e.preventDefault(); return;
    // }
  // Kiểm tra giá ghế
  if (!seatPrice) {
    alert("Giá ghế không được để trống.");
    document.getElementById("editSeatPrice").focus();
    return;
  }

  if (isNaN(seatPrice)) {
    alert("Giá ghế phải là số.");
    document.getElementById("editSeatPrice").focus();
    return;
  }

  const price = parseFloat(seatPrice);
  if (price <= 0) {
    alert("Giá ghế phải lớn hơn 0.");
    document.getElementById("editSeatPrice").focus();
    return;
  }

  if (price > 1000000) {
    alert("Giá ghế không được vượt quá 1,000,000 VND.");
    document.getElementById("editSeatPrice").focus();
    return;
  }
    // --- KIỂM TRA TRÙNG LẶP SỐ GHẾ BẰNG AJAX ---
    if (roomId && seatNumber) {
        try {
            const params = new URLSearchParams({
                room_id: roomId,
                seat_number: seatNumber,
                seat_id: seatId
            });

            const response = await fetch(`../controler/check_seat_number.php?${params.toString()}`);
            
            if (!response.ok) {
                throw new Error('Lỗi mạng khi kiểm tra số ghế.');
            }
            const data = await response.json();

            if (data.error) {
                alert('Lỗi từ server khi kiểm tra số ghế: ' + data.error);
                return;
            } else if (data.isTaken) {
                alert("Số ghế '" + seatNumber + "' đã tồn tại trong phòng này. Vui lòng chọn số ghế khác.");
                document.getElementById("editSeatName").focus();
                return;
            }
        } catch (error) {
            console.error('Lỗi khi kiểm tra trùng lặp số ghế:', error);
            alert('Có lỗi xảy ra trong quá trình kiểm tra số ghế: ' + error.message);
            return;
        }
    }
    // --- KẾT THÚC KIỂM TRA TRÙNG LẶP SỐ GHẾ ---
    console.log("Tất cả kiểm tra hợp lệ. Tiến hành submit form.");
    this.submit();
});

//JS phần thêm xóa sửa Xuất chiếu
function showEditShowtimeForm(button) {
  // Gán các trường đơn giản
  document.getElementById('editShowtimeMovie').disabled = true;
  document.getElementById('editShowtimeCinemas').disabled = true; 
  document.getElementById('editShowtimeMovie').value = button.dataset.movieid;
  document.getElementById('editMovieHidden').value = button.dataset.movieid;
  
  document.getElementById('editShowtimeCinemas').value = button.dataset.cinemaid;
  document.getElementById('editCinemasHidden').value = button.dataset.cinemaid;
  
  document.getElementById('Price').value = button.dataset.price;
  document.getElementById('StartTime').value = button.dataset.start;
  document.getElementById('EndTime').value = button.dataset.end;
  document.getElementById('editShowtimeId').value = button.dataset.id;

  const cinemaId = button.dataset.cinemaid;
  const selectedRoomId = button.dataset.roomid;
  const roomsSelect = document.getElementById("editShowtimeRooms");

  // Gọi lại getRoomsForCinema và set phòng sau khi fetch xong
  fetch("../controler/get_rooms.php?cinema_id=" + encodeURIComponent(cinemaId))
    .then(response => {
      if (!response.ok) throw new Error("Lỗi khi lấy phòng chiếu");
      return response.json();
    })
    .then(data => {
      // Clear và gán các option
      roomsSelect.innerHTML = "";
      const defaultOption = document.createElement("option");
      defaultOption.value = "";
      defaultOption.textContent = "-- Chọn phòng --";
      roomsSelect.appendChild(defaultOption);

      data.rooms.forEach(room => {
        const option = document.createElement("option");
        option.value = room.room_id;
        option.textContent = room.room_name;
        roomsSelect.appendChild(option);
      });

      roomsSelect.value = selectedRoomId;

      getShowtimeForRoom();

      // Hiện các vùng thông tin bổ sung
      document.getElementById('CostAndTime').style.display = 'block';
      document.getElementById('ShowtimeList').style.display = 'block';
    })
    .catch(error => {
      console.error("Fetch error:", error);
    });

  // Hiện form
  document.getElementById('editShowtimeFormPanel').style.display = 'flex';
}


function getRoomsForCinema() {
  const cinemaId = document.getElementById("editShowtimeCinemas").value;
  const roomsSelect = document.getElementById("editShowtimeRooms");
  // Xóa các tùy chọn cũ và thêm tùy chọn mặc định
  roomsSelect.innerHTML = "";
  const defaultOption = document.createElement("option");
  defaultOption.value = "";
  defaultOption.textContent = "-- Chọn phòng --";
  roomsSelect.appendChild(defaultOption);
  roomsSelect.value = "";
  
  const showtimeList = document.getElementById('ShowtimeList');
  if (showtimeList) showtimeList.style.display = 'none';
  
  const costAndTime = document.getElementById('CostAndTime');
  if (costAndTime) costAndTime.style.display = 'none';
  
  const roomsShowtimeBody = document.getElementById('roomsShowtimeBody');
  if (roomsShowtimeBody) roomsShowtimeBody.innerHTML = ''; // Xóa danh sách suất chiếu cũ

  if (!cinemaId){
    return;
  }
  fetch("../controler/get_room_for_option.php?cinema_id=" + encodeURIComponent(cinemaId))
    .then(response => {
      if (!response.ok) throw new Error("Lỗi khi lấy phòng chiếu" + response.status + " " + response.statusText);
      return response.json();
    })
    .then(data => {
      if (data && Array.isArray(data.rooms)) {
                const rooms = data.rooms;
                if (rooms.length === 0) {
                    // console.log("Không có phòng nào cho rạp đã chọn.");
                    // Bạn có thể thêm một option thông báo không có phòng nếu muốn
                    const noRoomOption = document.createElement("option");
                    noRoomOption.value = "";
                    noRoomOption.textContent = "-- Không có phòng --";
                    noRoomOption.disabled = true;
                    roomsSelect.appendChild(noRoomOption);
                } else {
                    rooms.forEach(room => {
                        const option = document.createElement("option");
                        option.value = room.room_id; // room_id từ PHP
                        option.textContent = room.name;  // SỬA Ở ĐÂY: dùng room.name từ PHP
                        roomsSelect.appendChild(option);
                    });
                }
            } else {
                console.warn("Dữ liệu phòng không hợp lệ hoặc không có key 'rooms':", data);
                // alert("Không nhận được dữ liệu phòng hoặc định dạng không đúng.");
            }
    })
    .catch(error => {
      console.error("Fetch error:", error);
    });
}

function getShowtimeForRoom() {
  const roomId = document.getElementById('editShowtimeRooms').value;
  if (!roomId) return;

  document.getElementById('ShowtimeList').style.display = 'block';
  document.getElementById('CostAndTime').style.display = 'block';

  // Gửi AJAX đến server để lấy danh sách suất chiếu
  fetch(`../controler/get_showtimes_by_room.php?room_id=${roomId}`)
      .then(response => response.json())
      .then(data => {
          const tbody = document.getElementById('roomsShowtimeBody');
          tbody.innerHTML = ''; // Xoá nội dung cũ
          console.log(data)
          data.forEach(showtime => {
              const row = document.createElement('tr');
              row.innerHTML = `
                  <td style="padding: 8px;">${showtime.showtime_id}</td>
                  <td style="padding: 8px;">${showtime.movie_title}</td>
                  <td style="padding: 8px;">${showtime.start_time}</td>
                  <td style="padding: 8px;">${showtime.end_time}</td>
                  <td style="padding: 8px;">${showtime.price}</td>
              `;
              tbody.appendChild(row);
          });
      })
      .catch(error => {
          console.error("Lỗi khi lấy danh sách suất chiếu:", error);
      });
}


function hideEditShowtimeForm() {
  document.getElementById('editShowtimeFormPanel').style.display = 'none';
}

function showAddShowtimeForm() {
  document.getElementById('editShowtimeForm').reset();
  document.getElementById('ShowtimeList').style.display = 'none';
  document.getElementById('CostAndTime').style.display = 'none';
  // document.getElementById('editShowtimeId').value = "";
  document.getElementById('editShowtimeMovie').disabled = false;
  document.getElementById('editShowtimeCinemas').disabled = false; 
  document.getElementById('editShowtimeFormPanel').style.display = 'flex';
}


function showDeleteShowtimeConfirm(movieId,hide) {
  document.getElementById('deleteShowtimeId').value = movieId;

  const title = document.getElementById('titleShowtime');
  title.textContent = hide === 0
      ? "Bạn có chắc muốn ẩn xuất chiếu này không?"
      : "Bạn có chắc muốn hiện xuất chiếu này không?";


  document.getElementById('deleteShowtimeConfirmPanel').style.display = 'flex';
}

function hideDeleteShowtimeConfirm() {
  document.getElementById('deleteShowtimeConfirmPanel').style.display = 'none';
}

// Validate sửa xuất chiếu
document.getElementById("editShowtimeForm").addEventListener("submit", function (e) {
    const priceShowTimes = document.getElementById("Price").value.trim();
    const movieSelect = document.getElementById('editShowtimeMovie');
    const cinemaSelect = document.getElementById('editShowtimeCinemas');
    const roomSelect = document.getElementById('editShowtimeRooms');
    const startTimeInput = document.getElementById('StartTime');
    const endTimeInput = document.getElementById('EndTime');
    const costAndTimeSection = document.getElementById('CostAndTime');

    // 1. Kiểm tra Phim
    if (movieSelect.value === "") {
        alert("Vui lòng chọn phim.");
        movieSelect.focus();
        e.preventDefault(); // Ngăn form submit
        return; // Dừng các kiểm tra khác
    }
    // 2. Kiểm tra Rạp
    if (cinemaSelect.value === "") {
        alert("Vui lòng chọn rạp.");
        cinemaSelect.focus();
        e.preventDefault();
        return;
    }

    // 3. Kiểm tra Phòng chiếu
    if (roomSelect.value === "") {
        alert("Vui lòng chọn phòng chiếu.");
        roomSelect.focus();
        e.preventDefault();
        return;
    }
    // Kiểm tra xem phần Giờ và Giá có hiển thị không.
    // Chỉ kiểm tra các trường này nếu phần tử cha của chúng (#CostAndTime) đang hiển thị.
    const isCostAndTimeVisible = costAndTimeSection && costAndTimeSection.style.display !== 'none';

    if (isCostAndTimeVisible) {
      // 4. Kiểm tra Giờ chiếu (StartTime)
      const startTimeValue = startTimeInput.value;
      if (startTimeValue === "") {
          alert("Vui lòng nhập giờ chiếu.");
          startTimeInput.focus();
          e.preventDefault();
          return;
      }
      const startDate = new Date(startTimeValue);
      const now = new Date();
      if (startDate <= now) {
          alert("Giờ chiếu phải là một thời điểm trong tương lai.");
          startTimeInput.focus();
          e.preventDefault();
          return;
      }

      // 5. Kiểm tra Giờ kết thúc (EndTime)
      const endTimeValue = endTimeInput.value;
      if (endTimeValue === "") {
          alert("Vui lòng nhập giờ kết thúc.");
          endTimeInput.focus();
          e.preventDefault();
          return;
      }
      const actualEndDate = new Date(endTimeValue);
      if (actualEndDate <= startDate) {
          alert("Giờ kết thúc phải sau giờ chiếu.");
          endTimeInput.focus();
          e.preventDefault();
          return;
      }

      // --- BẮT ĐẦU LOGIC KIỂM TRA THỜI LƯỢNG PHIM ---
      const selectedMovieOption = movieSelect.options[movieSelect.selectedIndex];
      const movieDurationString = selectedMovieOption.getAttribute('data-duration');

      if (!movieDurationString) {
          alert("Lỗi: Không tìm thấy thông tin thời lượng cho phim đã chọn. Vui lòng đảm bảo thuộc tính 'data-duration' được thiết lập cho các tùy chọn phim.");
          e.preventDefault();
          return;
      }

      const movieDurationMinutes = parseInt(movieDurationString, 10);

      if (isNaN(movieDurationMinutes) || movieDurationMinutes <= 0) {
          alert("Thời lượng phim không hợp lệ (" + movieDurationString + "). Vui lòng kiểm tra lại dữ liệu phim.");
          e.preventDefault();
          return;
      }

      // Tính toán giờ kết thúc dự kiến
      const expectedEndDate = new Date(startDate.getTime() + movieDurationMinutes * 60000); // 60000 ms trong một phút

      // Khoảng chênh lệch cho phép (tolerance)
      const toleranceMinutes = 30;
      const toleranceMilliseconds = toleranceMinutes * 60000;

      // Tính toán khoảng thời gian kết thúc cho phép
      const minAllowedEndTime = new Date(expectedEndDate.getTime() - toleranceMilliseconds);
      const maxAllowedEndTime = new Date(expectedEndDate.getTime() + toleranceMilliseconds);

      // So sánh giờ kết thúc thực tế với khoảng cho phép
      if (actualEndDate < minAllowedEndTime || actualEndDate > maxAllowedEndTime) {
          const formatDate = (dateObj) => { // Hàm helper để định dạng thời gian
              return dateObj.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false }) + ' ngày ' + dateObj.toLocaleDateString();
          };

          alert(
              `Giờ kết thúc không khớp với thời lượng của phim.\n` +
              `Phim đã chọn có thời lượng: ${movieDurationMinutes} phút.\n` +
              `Với giờ bắt đầu là ${formatDate(startDate)}, giờ kết thúc dự kiến (chính xác) là ${formatDate(expectedEndDate)}.\n` +
              `Giờ kết thúc của bạn (${formatDate(actualEndDate)}) phải nằm trong khoảng từ ${formatDate(minAllowedEndTime)} đến ${formatDate(maxAllowedEndTime)} (bao gồm sai số ±${toleranceMinutes} phút).`
          );
          endTimeInput.focus();
          e.preventDefault();
          return;
      }
      // --- KẾT THÚC LOGIC KIỂM TRA THỜI LƯỢNG PHIM ---
      // 1. Giá
      if (!priceShowTimes) {
          alert("Giá xuất chiếu không được để trống.");
          document.getElementById('editConcessionsPrice').focus();
          e.preventDefault(); return;
      }
      if (isNaN(priceShowTimes) || parseFloat(priceShowTimes) < 0) {
        alert("Giá xuất chiếu phải là số dương.");
        document.getElementById('editConcessionsPrice').focus();
        e.preventDefault(); return;
      }

      if(parseFloat(priceShowTimes) > 1000000) {
        alert("Giá xuất chiếu không vượt quá 1 triệu VNĐ");
        document.getElementById('editConcessionsPrice').focus();
        e.preventDefault(); return;
      }
    }
});
//JS phần thêm xóa sửa khuyến mãi
function showPromotionEditForm(button) {
  document.getElementById('editPromotionTitle').value = button.dataset.title;
  document.getElementById('editPromotionId').value = button.dataset.id;

  // Gán mô tả vào CKEditor
  if (CKEDITOR.instances['editPromotionContent']) {
      CKEDITOR.instances['editPromotionContent'].setData(button.dataset.content);
  } else {
      CKEDITOR.replace('editPromotionContent', {
          on: {
              instanceReady: function () {
                  this.setData(button.dataset.content);
              }
          }
      });
  }

  // Hiện form nổi
  document.getElementById('editPromotionFormPanel').style.display = 'flex';
}

function hideEditPromotionForm() {
  document.getElementById('editPromotionFormPanel').style.display = 'none';
}

function showAddPromotionForm() {
  document.getElementById('editPromotionForm').reset();
  document.getElementById('editPromotionId').value = "";

  // Nếu đã có CKEditor thì xóa nội dung
  if (CKEDITOR.instances['editPromotionsContent']) {
      CKEDITOR.instances['editPromotionsContent'].setData('');
  }

  document.getElementById('editPromotionFormPanel').style.display = 'flex';
}

function updateCkEditorBeforeSubmit() {
  for (let instance in CKEDITOR.instances) {
      CKEDITOR.instances[instance].updateElement();
  }
}

function showDeletePromotionsConfirm(promotionId,hide) {
  document.getElementById('deletePromotionId').value = promotionId;
  const title = document.getElementById('titlePromotion');
  title.textContent = hide === 0
      ? "Bạn có chắc muốn ẩn khuyến mãi này không?"
      : "Bạn có chắc muốn hiện khuyến mãi này không?";
  document.getElementById('deletePromotionsConfirmPanel').style.display = 'flex';
}

function hideDeletePromotionsConfirm() {
  document.getElementById('deletePromotionsConfirmPanel').style.display = 'none';
}

//Validate thêm, sửa khuyến mãi
document.getElementById('editPromotionForm').addEventListener('submit', function(e) {
  updateCkEditorBeforeSubmit(); // đảm bảo CKEditor cập nhật textarea

  const PromotionTitle= document.getElementById("editPromotionTitle").value.trim();
  const PromotionImg= document.getElementById("editPromotionPicture").value.trim(); 
    // CKEditor (dùng ID editPromotionContent)
  const PromotionContent = CKEDITOR.instances['editPromotionContent'].getData().trim();

  // 1. Tiêu đề
  if (!PromotionTitle || PromotionTitle.length > 255) {
      alert("Tiêu đề khuyến mãi không được để trống!");
      document.getElementById('editPromotionTitle').focus();
      e.preventDefault(); return;
  }
  if (PromotionTitle.length > 255) {
      alert("Tiêu đề khuyến mãi không vượt quá 255 ký tự.");
      document.getElementById('editPromotionTitle').focus();
      e.preventDefault(); return;
  }
  if (specialCharRegex.test(PromotionTitle)) {
      alert("Tiêu đề không được chứa ký tự đặc biệt (!@#$%^&*).");
      document.getElementById('editConcessionsName').focus();
      e.preventDefault(); return;
  }

  // 2. Nội dung
  if (!PromotionContent) {
      alert("Nội dung khuyến mãi không được để trống.");
      document.getElementById('editPromotionContent').focus();
      e.preventDefault(); return;
  }
  if (PromotionContent.length > 255) {
      alert("Tiêu đề khuyến mãi không vượt quá 255 ký tự.");
      document.getElementById('editPromotionTitle').focus();
      e.preventDefault(); return;
  }
  if (specialCharRegex.test(PromotionContent)) {
      alert("Nội dung không được chứa ký tự đặc biệt (!@#$%^&*).");
      document.getElementById('editConcessionsName').focus();
      e.preventDefault(); return;
    }

  // 3. Hình ảnh
      const isAddMode = document.getElementById("editId").value === "";

    if (isAddMode) {
        if (PromotionImg.files.length === 0) {
            alert("Hình ảnh là bắt buộc khi thêm mới!");
            e.preventDefault(); return;
        }
    }
});

function filterAdminTable(inputId, tableId) {
    const input = document.getElementById(inputId);
    const filter = input.value.toUpperCase().trim(); // Lấy từ khóa, chuyển thành chữ hoa, bỏ khoảng trắng thừa
    const table = document.getElementById(tableId);
    
    const tbody = table.getElementsByTagName("tbody")[0]; // Lấy phần tbody của bảng
    const rows = tbody.getElementsByTagName("tr"); // Lấy tất cả các hàng trong tbody

    // Lặp qua tất cả các hàng dữ liệu
    for (let i = 0; i < rows.length; i++) {
        const currentRow = rows[i];
        let textContentOfRow = "";

        // Lấy nội dung text từ tất cả các ô <td> trong hàng hiện tại
        // Bỏ qua cột cuối cùng (thường là cột "Chức năng" chứa các nút)
        const cells = currentRow.getElementsByTagName("td");
        for (let j = 0; j < cells.length - 1; j++) { // Bỏ qua ô cuối cùng
            if (cells[j]) {
                textContentOfRow += (cells[j].textContent || cells[j].innerText) + " ";
            }
        }
        
        // So sánh với từ khóa tìm kiếm
        if (textContentOfRow.toUpperCase().indexOf(filter) > -1) {
            currentRow.style.display = ""; // Hiện hàng nếu khớp
        } else {
            currentRow.style.display = "none"; // Ẩn hàng nếu không khớp
        }
    }
}

function formatDateDisplay(dateStr, range) {
    const date = new Date(dateStr);
    const day = date.getDate();
    const month = date.getMonth() + 1; // tháng bắt đầu từ 0
    const year = date.getFullYear();

    if (range === 'day') {
        return `ngày ${day}/${month}/${year}`;
    } else if (range === 'week') {
        const weekNumber = Math.ceil(day / 7);
        return `tuần ${weekNumber}, tháng ${month}/${year}`;
    } else if (range === 'month') {
        return `tháng ${month}/${year}`;
    } else {
        return '';
    }
}

const ctx = document.getElementById('statsChart').getContext('2d');
let chart;

document.getElementById('viewChartBtn').addEventListener('click', function () {
    const cinemaId = document.getElementById('cinemaSelect').value;
    const movieId = document.getElementById('filmSelect').value;
    const range = document.getElementById('timeRange').value;
    const date = document.getElementById('dateSelect').value || new Date().toISOString().slice(0, 10); // lấy từ input
    const timeDisplayText = `Biểu đồ doanh thu theo ${formatDateDisplay(date, range)}`;
    document.getElementById('timeDisplay').innerText = timeDisplayText;

    fetch(`../../app/controler/get_chart_data.php?cinema_id=${cinemaId}&film_id=${movieId}&range=${range}&date=${date}`)
        .then(res => res.json())
        .then(response => {
            if (chart) chart.destroy(); // destroy chart cũ
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: response.labels,
                    datasets: [{
                        label: 'Doanh thu (VND)',
                        data: response.data,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
});