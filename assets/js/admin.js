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

//JS phần thêm xóa sửa rạp phim
function showEditCinemasForm(button, cinemaId) {
  document.getElementById('editCinemasName').value = button.dataset.name;
  document.getElementById('editCinemasLocation').value = button.dataset.location;
  document.getElementById('editCinemasId').value = button.dataset.id;
  document.getElementById('editCinemasPhone').value = button.dataset.phone;
  document.getElementById('editCinemasRooms').value = button.dataset.rooms;
  document.getElementById('editCinemasShowtimes').value = button.dataset.showtimes;

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
          seatDiv.className = `seat ${seat.status === 'Booked' ? 'booked' : 'available'} ${seat.seat_type.toLowerCase()}`;
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
  document.getElementById('editSeatStatus').value = seat.status;
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
  document.getElementById('ShowtimeList').style.display = 'none';
  document.getElementById('CostAndTime').style.display = 'none';
  if (!cinemaId){
    return;
  }
  fetch("../controler/get_rooms.php?cinema_id=" + encodeURIComponent(cinemaId))
    .then(response => {
      if (!response.ok) throw new Error("Lỗi khi lấy phòng chiếu");
      return response.json();
    })
    .then(data => {
      const rooms = data.rooms; 
      roomsSelect.innerHTML = "";
      defaultOption.value = "";
      defaultOption.textContent = "-- Chọn phòng --";
      roomsSelect.appendChild(defaultOption);
      rooms.forEach(room => {
        const option = document.createElement("option");
        option.value = room.room_id;
        option.textContent = room.room_name;
        roomsSelect.appendChild(option);
      });
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
      ? "Bạn có chắc muốn ẩn rạp này không?"
      : "Bạn có chắc muốn hiện rạp này không?";


  document.getElementById('deleteShowtimeConfirmPanel').style.display = 'flex';
}

function hideDeleteShowtimeConfirm() {
  document.getElementById('deleteShowtimeConfirmPanel').style.display = 'none';
}