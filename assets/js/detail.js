console.log("JavaScript file is loaded and connected");

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

                      // Thêm sự kiện click cho suất chiếu
                      showtimeButton.onclick = () => {
                          console.log(`Chọn suất chiếu: ${showtime.start_time}`);
                          showSeatMap(showtime.showtime_id);
                          // Bạn có thể thêm các hành động khác khi chọn suất chiếu
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























































// // State management
// const bookingState = {
//     movie: 'Lập Trình CobWeb',
//     date: '',
//     cinema: '',
//     time: '',
//     tickets: {
//         adult: 0,
//         senior: 0,
//         couple: 0
//     },
//     seats: [],
//     concessions: {
//         combo1: 0,
//         combo2: 0,
//         combo3: 0,
//         sprite: 0,
//         cokezero: 0,
//         coke: 0,
//         fanta: 0,
//         poca: 0
//     },
//     totalAmount: 0,
//     timeRemaining: 300 // 5 minutes in seconds
// };

// // DOM elements
// let bookSummary, bookBtn, timerElement, bookingTotalElement, fixedBar, additionalContent;
// let timerInterval;

// // Initialize when DOM is loaded
// document.addEventListener('DOMContentLoaded', function() {
//     bookSummary = document.getElementById('booking-summary');
//     bookBtn = document.getElementById('book-btn');
//     timerElement = document.getElementById('timer');
//     bookingTotalElement = document.getElementById('booking-total');
//     fixedBar = document.querySelector('.fixed-bar');
//     additionalContent = document.querySelector('.additional-content');
    
//     // Hide fixed bar initially
//     if (fixedBar) {
//         fixedBar.style.display = 'none';
//     }
    
//     // Initialize - auto select first date
//     const firstDateBtn = document.querySelector('.date-btn');
//     if (firstDateBtn) {
//         firstDateBtn.classList.add('selected');
//         bookingState.date = firstDateBtn.dataset.date;
        
//         // Show corresponding cinemas
//         const firstDateCinemas = document.querySelector(`.cinema-group[data-date="${bookingState.date}"]`);
//         if (firstDateCinemas) {
//             firstDateCinemas.style.display = 'block';
//         }
//     }
    
//     // Initialize
//     updateBookingSummary();
//     initEventListeners();
//     randomizeUnavailableSeats();
// });

// // Timer function
// function startTimer() {
//     if (timerInterval) {
//         clearInterval(timerInterval);
//     }
    
//     timerInterval = setInterval(function() {
//         bookingState.timeRemaining--;
        
//         if (bookingState.timeRemaining <= 0) {
//             clearInterval(timerInterval);
//             alert('Thời gian giữ vé đã hết! Vui lòng bắt đầu lại.');
//             window.location.reload();
//             return;
//         }
        
//         const minutes = Math.floor(bookingState.timeRemaining / 60);
//         const seconds = bookingState.timeRemaining % 60;
        
//         timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
//     }, 1000);
// }

// // Set up all event listeners
// function initEventListeners() {
//     // Date selection
//     document.querySelectorAll('.date-btn').forEach(button => {
//         button.addEventListener('click', function() {
//             document.querySelectorAll('.date-btn').forEach(btn => btn.classList.remove('selected'));
//             this.classList.add('selected');
//             bookingState.date = this.dataset.date;
            
//             // Show appropriate cinemas for the selected date
//             document.querySelectorAll('.cinema-group').forEach(group => {
//                 if (group.dataset.date === this.dataset.date) {
//                     group.style.display = 'block';
//                 } else {
//                     group.style.display = 'none';
//                 }
//             });
            
//             updateBookingSummary();
//         });
//     });
    
//     // Time slot selection
//     document.querySelectorAll('.time-slot').forEach(button => {
//         button.addEventListener('click', function() {
//             document.querySelectorAll('.time-slot').forEach(btn => btn.classList.remove('selected'));
//             this.classList.add('selected');
//             bookingState.time = this.dataset.time;
//             bookingState.cinema = this.dataset.cinema;
            
//             // Show fixed bar and start timer when a time slot is selected
//             if (fixedBar) {
//                 fixedBar.style.display = 'flex';
//                 document.body.style.paddingBottom = '100px'; // Add padding to body when fixed bar is shown
//                 // Reset timer if it was already running
//                 bookingState.timeRemaining = 300; // Reset to 5 minutes
//                 startTimer();
//             }
            
//             // Show the rest of the booking sections
//             if (additionalContent) {
//                 additionalContent.style.display = 'block';
                
//                 // Scroll to the ticket section after a short delay
//                 setTimeout(() => {
//                     document.getElementById('ticket-section').scrollIntoView({ behavior: 'smooth' });
//                 }, 300);
//             }
            
//             updateBookingSummary();
//         });
//     });
    
//     // Ticket quantity buttons
//     document.querySelectorAll('.quantity-btn').forEach(button => {
//         button.addEventListener('click', function() {
//             const type = this.dataset.type;
//             const input = document.getElementById(`${type}-quantity`);
//             let value = parseInt(input.value);
            
//             if (this.classList.contains('minus')) {
//                 if (value > 0) {
//                     value--;
//                 }
//             } else {
//                 value++;
//             }
            
//             input.value = value;
            
//             // Update state based on type
//             if (['adult', 'senior', 'couple'].includes(type)) {
//                 bookingState.tickets[type] = value;
                
//                 // Scroll to seat section if tickets are selected
//                 const totalTickets = bookingState.tickets.adult + bookingState.tickets.senior + bookingState.tickets.couple;
//                 if (totalTickets > 0) {
//                     setTimeout(() => {
//                         document.getElementById('seats-section').scrollIntoView({ behavior: 'smooth' });
//                     }, 300);
//                 }
//             } else {
//                 bookingState.concessions[type] = value;
//             }
            
//             updateBookingSummary();
//             updateBookButton();
//         });
//     });
    
//     // Seat selection
//     document.querySelectorAll('.seat').forEach(seat => {
//         seat.addEventListener('click', function() {
//             // Don't allow seat selection if no tickets selected
//             const totalTickets = bookingState.tickets.adult + bookingState.tickets.senior + (bookingState.tickets.couple * 2);
//             if (totalTickets === 0) {
//                 alert('Vui lòng chọn loại vé trước');
//                 return;
//             }
            
//             // Don't allow more seats than tickets
//             if (!this.classList.contains('selected') && bookingState.seats.length >= totalTickets) {
//                 alert(`Bạn chỉ có thể chọn tối đa ${totalTickets} ghế`);
//                 return;
//             }
            
//             if (this.classList.contains('unavailable')) {
//                 return;
//             }
            
//             this.classList.toggle('selected');
            
//             if (this.classList.contains('selected')) {
//                 bookingState.seats.push(this.dataset.seat);
//             } else {
//                 const index = bookingState.seats.indexOf(this.dataset.seat);
//                 if (index > -1) {
//                     bookingState.seats.splice(index, 1);
//                 }
//             }
            
//             // If all seats are selected, scroll to concession section
//             const expectedSeats = bookingState.tickets.adult + bookingState.tickets.senior + (bookingState.tickets.couple * 2);
//             if (bookingState.seats.length === expectedSeats) {
//                 setTimeout(() => {
//                     document.getElementById('concession-section').scrollIntoView({ behavior: 'smooth' });
//                 }, 300);
//             }
            
//             updateBookingSummary();
//             updateBookButton();
//         });
//     });
    
//     // Book button
//     bookBtn.addEventListener('click', function() {
//         if (!isBookingComplete()) {
//             alert('Vui lòng hoàn tất quá trình đặt vé');
//             return;
//         }
        
//         // Process booking
//         alert('Đặt vé thành công!');
//         console.log('Booking details:', bookingState);
//     });
// }

// // Update the booking summary display
// function updateBookingSummary() {
//     if (!bookSummary) return; // Guard clause for early initialization
    
//     let summary = '';
//     const totalTickets = bookingState.tickets.adult + bookingState.tickets.senior + bookingState.tickets.couple;
    
//     // Calculate total amount
//     let amount = 0;
//     amount += bookingState.tickets.adult * 45000;
//     amount += bookingState.tickets.senior * 45000;
//     amount += bookingState.tickets.couple * 95000;
    
//     amount += bookingState.concessions.combo1 * 119000;
//     amount += bookingState.concessions.combo2 * 129000;
//     amount += bookingState.concessions.combo3 * 259000;
//     amount += (bookingState.concessions.sprite + 
//               bookingState.concessions.cokezero + 
//               bookingState.concessions.coke + 
//               bookingState.concessions.fanta) * 37000;
//     amount += bookingState.concessions.poca * 28000;
    
//     bookingState.totalAmount = amount;
    
//     // Update total amount in the fixed bar
//     if (bookingTotalElement) {
//         bookingTotalElement.textContent = `${amount.toLocaleString('vi-VN')} VND`;
//     }
    
//     // Build summary text
//     if (bookingState.date && bookingState.time) {
//         summary = `${bookingState.movie} | ${bookingState.date} ${bookingState.time} | ${bookingState.cinema}`;
        
//         if (totalTickets > 0) {
//             let ticketDetails = [];
//             if (bookingState.tickets.adult > 0) {
//                 ticketDetails.push(`${bookingState.tickets.adult} vé người lớn`);
//             }
//             if (bookingState.tickets.senior > 0) {
//                 ticketDetails.push(`${bookingState.tickets.senior} vé HSSV/NCT`);
//             }
//             if (bookingState.tickets.couple > 0) {
//                 ticketDetails.push(`${bookingState.tickets.couple} vé đôi`);
//             }
//             summary += ` | ${ticketDetails.join(', ')}`;
//         }
        
//         if (bookingState.seats.length > 0) {
//             summary += ` | Ghế: ${bookingState.seats.join(', ')}`;
//         }
        
//         // Add concessions if any
//         const totalConcessions = Object.values(bookingState.concessions).reduce((sum, qty) => sum + qty, 0);
//         if (totalConcessions > 0) {
//             summary += ` | Bắp nước: ${totalConcessions} món`;
//         }
//     } else {
//         summary = 'Vui lòng chọn lịch chiếu';
//     }
    
//     bookSummary.textContent = summary;
// }

// // Update book button state based on booking completion
// function updateBookButton() {
//     if (bookBtn) {
//         const isComplete = isBookingComplete();
//         bookBtn.classList.toggle('active', isComplete);
//         bookBtn.disabled = !isComplete;
//     }
// }

// // Check if all booking requirements are met
// function isBookingComplete() {
//     const totalTickets = bookingState.tickets.adult + bookingState.tickets.senior + bookingState.tickets.couple;
//     const totalSeats = bookingState.seats.length;
//     const expectedSeats = bookingState.tickets.adult + bookingState.tickets.senior + (bookingState.tickets.couple * 2);
    
//     return bookingState.date && 
//            bookingState.time && 
//            totalTickets > 0 && 
//            totalSeats === expectedSeats;
// }

// // Randomize some unavailable seats
// function randomizeUnavailableSeats() {
//     const seats = document.querySelectorAll('.seat');
//     const unavailableCount = Math.floor(seats.length * 0.2); // Make 20% unavailable
    
//     for (let i = 0; i < unavailableCount; i++) {
//         const randomIndex = Math.floor(Math.random() * seats.length);
//         seats[randomIndex].classList.add('unavailable');
//     }
// }