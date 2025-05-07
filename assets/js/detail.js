console.log("JavaScript file is loaded and connected");

let basePrice = 0;
let selectedSeats = [];
let selectedConcessions = {};
let countdownInterval = null;
let countdownSeconds = 300; // 5 phút


function showSchedule(movieId,date) {
    // Ẩn toàn bộ danh sách rạp
    const Showtimelist = document.getElementById('cinema-list');
    Showtimelist.style.display="block"

    fetch(`app/controler/get_showtimes.php?movie_id=${movieId}&show_date=${date}`)
    .then(response => response.json())
    .then(data => {
      // Xóa hết các nội dung cũ trong cinema-list
      Showtimelist.innerHTML = '';

      // Kiểm tra nếu có dữ liệu
      if (data && Array.isArray(data) && data.length > 0) {
          data.forEach(cinema => {
              // Tạo phần tử cho mỗi rạp
              const cinemaElement = document.createElement('div');
              cinemaElement.classList.add('cinema-group');

              // Tạo tiêu đề cho tên rạp và địa chỉ
              const cinemaTitle = document.createElement('h4');
              cinemaTitle.innerHTML = `🎬 ${cinema.cinema_name} (${cinema.location})`;
              cinemaElement.appendChild(cinemaTitle);

              // Duyệt qua các phòng chiếu của rạp
              cinema.rooms.forEach(room => {
                  const roomElement = document.createElement('div');
                  roomElement.classList.add('schedule-box');

                  const roomTitle = document.createElement('h5');
                  roomTitle.innerHTML = `Phòng: ${room.room_name}`;
                  roomElement.appendChild(roomTitle);

                  // Duyệt qua các suất chiếu của phòng
                  room.showtimes.forEach(showtime => {
                      const showtimeButton = document.createElement('button');
                      showtimeButton.classList.add('time-slot');
                      showtimeButton.innerHTML = `${showtime.start_time} - ${showtime.end_time} | Giá: ${showtime.price} VNĐ`;
                        
                      showtimeButton.onclick = () => {
                        document.querySelector('.fixed-bar').style.display = 'flex';
                        basePrice = parseInt(showtime.price);
                        selectedSeats = [];
                        selectedConcessions = {};
                        document.getElementById("book-btn").disabled=true;
                        updateBookingTotal();
                        startTimer();
                        showSeatMap(showtime.showtime_id);
                    };                    

                      roomElement.appendChild(showtimeButton);
                  });

                  cinemaElement.appendChild(roomElement);
              });

              // Thêm rạp vào danh sách
              Showtimelist.appendChild(cinemaElement);
          });
      } else {
          // Nếu không có suất chiếu
          const noShowtimesMessage = document.createElement('p');
          noShowtimesMessage.innerHTML = 'Không có suất chiếu cho ngày này.';
          showtimelist.appendChild(noShowtimesMessage);
      }
      console.log(data);
    })
    .catch(error => {
      console.error('Lỗi khi fetch seats:', error);
    });
}

function showSeatMap(showtimeId) {
    const additionalContent = document.getElementById('addtional');
    const seatSection = document.getElementById('seats-section');
    seatSection.innerHTML = '';

    fetch(`app/controler/get_seats.php?showtime_id=${showtimeId}`)
        .then(response => response.json())
        .then(data => {
            const seats = data.seats || [];

            const screen = document.createElement('div');
            screen.className = 'screen';
            screen.innerText = 'Màn hình';

            const seatGrid = document.createElement('div');
            seatGrid.className = 'seat-grid';

            // Nhóm ghế theo hàng (A, B, C,...)
            const seatMap = {};
            seats.forEach(seat => {
                const row = seat.seat_number.charAt(0);
                if (!seatMap[row]) seatMap[row] = [];
                seatMap[row].push(seat);
            });

            Object.keys(seatMap).sort().forEach(row => {
                const seatRow = document.createElement('div');
                seatRow.className = 'seat-row';

                const label = document.createElement('span');
                label.style = 'display: inline-block; width: 20px; text-align: right; margin-right: 10px;';
                label.textContent = row;
                seatRow.appendChild(label);

                // Sắp xếp theo số
                seatMap[row].sort((a, b) => {
                    const n1 = parseInt(a.seat_number.slice(1));
                    const n2 = parseInt(b.seat_number.slice(1));
                    return n1 - n2;
                });

                seatMap[row].forEach(seat => {
                    const seatDiv = document.createElement('div');
                    seatDiv.className = 'seat';
                    if (seat.seat_type === 'Couple') seatDiv.classList.add('couple');
                    if (seat.seat_type === 'Standard') seatDiv.classList.add('standard');
                    if (seat.seat_type === 'Vip') seatDiv.classList.add('vip');
                    if (seat.status === 'Booked') {
                        seatDiv.classList.add('booked');
                        seatDiv.style.pointerEvents = 'none';
                    } else {
                        seatDiv.onclick = () => {
                            seatDiv.classList.toggle('selected');
                        
                            const seatPrice = seat.extra_price || 0;
                            const seatId = seat.seat_number;
                        
                            const index = selectedSeats.findIndex(s => s.id === seatId);
                            if (index >= 0) {
                                selectedSeats.splice(index, 1); // bỏ chọn  
                            } else {
                                selectedSeats.push({ id: seatId, price: seatPrice }); // chọn
                            }
                            const bookingBtn = document.getElementById("book-btn");
                                if (selectedSeats.length > 0) {
                                    bookingBtn.disabled = false;
                                } else {
                                    bookingBtn.disabled = true;
                                }

                            updateBookingTotal();
                        };
                        
                    }

                    seatDiv.dataset.seat = seat.seat_number;
                    seatDiv.textContent = seat.seat_number;
                    seatRow.appendChild(seatDiv);
                });

                seatGrid.appendChild(seatRow);
            });

            seatSection.appendChild(screen);
            seatSection.appendChild(seatGrid);
            additionalContent.style.display="block"
        })
        .catch(error => {
            console.error('Lỗi khi fetch ghế:', error);
        });
}

function updateBookingTotal() {
    let seatTotal = selectedSeats.reduce((sum, seat) => sum + parseInt(seat.price), 0);
    let concessionTotal = Object.values(selectedConcessions).reduce((sum, item) => sum + item.price * item.quantity, 0);
    let total = basePrice + seatTotal + concessionTotal;

    document.getElementById('booking-total').innerText = `${total.toLocaleString()} VND`;

    const summary = [];
    if (basePrice > 0) summary.push(`Giá vé cơ bản: ${basePrice.toLocaleString()} VND`);
    if (selectedSeats.length > 0) summary.push(`Đã chọn ${selectedSeats.length} ghế, Tổng tiền ghế: ${seatTotal} VND`);
    if (concessionTotal > 0) summary.push(`Bắp nước: ${concessionTotal.toLocaleString()} VND`);

    document.getElementById('booking-summary').innerText = summary.join(' | ');
}

function startTimer() {
    clearInterval(countdownInterval);
    countdownSeconds = 300;
    updateTimerDisplay();
    countdownInterval = setInterval(() => {
        countdownSeconds--;
        updateTimerDisplay();
        if (countdownSeconds <= 0) {
            clearInterval(countdownInterval);
            alert("Hết thời gian giữ vé. Vui lòng chọn lại!");
            location.reload();
        }
    }, 1000);
}

function updateTimerDisplay() {
    const minutes = String(Math.floor(countdownSeconds / 60)).padStart(2, '0');
    const seconds = String(countdownSeconds % 60).padStart(2, '0');
    document.getElementById('timer').innerText = `${minutes}:${seconds}`;
}

document.querySelectorAll('.quantity-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const type = this.getAttribute('data-type');
        const input = this.parentElement.querySelector('.quantity-input');
        const concessionId = input.id.split('-')[0];
        const price = parseInt(this.closest('.food-card').querySelector('.card-text').innerText);

        if (!selectedConcessions[concessionId]) {
            selectedConcessions[concessionId] = { quantity: 0, price: price };
        }

        if (this.classList.contains('plus')) {
            selectedConcessions[concessionId].quantity++;
        } else {
            selectedConcessions[concessionId].quantity = Math.max(0, selectedConcessions[concessionId].quantity - 1);
        }

        input.value = selectedConcessions[concessionId].quantity;
        updateBookingTotal();
    });
});