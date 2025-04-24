const allPages = ["dashboard", "users", "movies", "cinemas","concessions","membership","showtime"];

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
    document.getElementById('editDescription').value = button.dataset.description;
    document.getElementById('editId').value = button.dataset.id;
  
    // Hiện form nổi
    document.getElementById('editMovieFormPanel').style.display = 'flex';
}
  
function hideMovieEditForm() {
  document.getElementById('editMovieFormPanel').style.display = 'none';
}

function showMovieAddForm() {
  document.getElementById('editMovieForm').reset();

  document.getElementById('editId').value = "";

  document.getElementById('editMovieFormPanel').style.display = 'flex';
}

function showMovieDeleteConfirm(movieId) {
  document.getElementById('deleteMovieId').value = movieId;
  document.getElementById('deleteMovieConfirmPanel').style.display = 'flex';
}

function hideMovieDeleteConfirm() {
  document.getElementById('deleteMovieConfirmPanel').style.display = 'none';
}
///


//JS phần thêm xóa sửa người dùng
function showEditUserForm(button) {
  document.getElementById('editUserName').value = button.dataset.name;
  document.getElementById('editUserEmail').value = button.dataset.email;
  document.getElementById('editUserPhone').value = button.dataset.phone;
  document.getElementById('editUserBirthday').value = button.dataset.birthday;
  document.getElementById('editUserRole').value = button.dataset.role;
  document.getElementById('editUserMember').value = button.dataset.member;
  document.getElementById('editUserPassword').value = button.dataset.password;
  document.getElementById('editUserId').value = button.dataset.id;

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


function showDeleteUserConfirm(movieId) {
  document.getElementById('deleteUserId').value = movieId;
  document.getElementById('deleteUserConfirmPanel').style.display = 'flex';
}

function hideDeleteUserConfirm() {
  document.getElementById('deleteUserConfirmPanel').style.display = 'none';
}

//JS phần thêm xóa sửa membership
function showEditMemberForm(button) {
  document.getElementById('editMemberMember').value = button.dataset.member;
  document.getElementById('editMemberDiscount').value = button.dataset.discount;

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


function showDeleteConcessionsConfirm(movieId) {
  document.getElementById('deleteConcessionsId').value = movieId;
  document.getElementById('deleteConcessionsConfirmPanel').style.display = 'flex';
}

function hideDeleteConcessionsConfirm() {
  document.getElementById('deleteConcessionsConfirmPanel').style.display = 'none';
}