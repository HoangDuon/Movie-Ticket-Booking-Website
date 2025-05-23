console.log("JavaScript file is loaded and connected")

// Global variables
let basePrice = 0
let selectedSeats = []
let selectedConcessions = {}
let countdownInterval = null
let countdownSeconds = 300 // 5 phút

// Nhận các biến preset từ window (gán từ PHP)
const presetMovieId = window.presetMovieId || null;
const presetCinemaId = window.presetCinemaId || null;
const presetShowtimeId = window.presetShowtimeId || null;
const presetShowDate = window.presetShowDate || null;
console.log(presetCinemaId,presetMovieId,presetShowDate)

document.addEventListener("DOMContentLoaded", () => {
  if (presetMovieId && presetShowDate) {
    // Gọi hàm showSchedule (giả sử đã được định nghĩa ở file khác)
    showSchedule(presetMovieId, presetShowDate);
  }
});

function autoSelectShowtime(showtimeId) {
  const button = document.querySelector(`button[data-showtime-id="${showtimeId}"]`);
  if (button) {
    button.click();
    button.scrollIntoView({ behavior: "smooth", block: "center" });
  } else {
    console.warn("Không tìm thấy suất chiếu để tự động chọn");
  }
}


// Initialize event listeners when document is ready
document.addEventListener("DOMContentLoaded", () => {
  // Initialize quantity controls for concessions
  initializeQuantityControls()

  // Initialize booking button
  initializeBookingButton()
})

function showSchedule(movieId, date) {
  // Update date button states
  document.querySelectorAll(".date-btn").forEach((btn) => {
    btn.classList.remove("selected")
  })

  // Mark selected date button
  const selectedBtn = document.querySelector(`[data-date="${date}"]`)
  if (selectedBtn) {
    selectedBtn.classList.add("selected")
  }

  // Ẩn toàn bộ danh sách rạp
  const Showtimelist = document.getElementById("cinema-list")
  Showtimelist.style.display = "block"

  fetch(`app/controler/get_showtimes.php?movie_id=${movieId}&show_date=${date}`)
    .then((response) => response.json())
    .then((data) => {
      // Xóa hết các nội dung cũ trong cinema-list
      Showtimelist.innerHTML = ""

      // Kiểm tra nếu có dữ liệu
      if (data && Array.isArray(data) && data.length > 0) {
        data.forEach((cinema) => {
          // Tạo phần tử cho mỗi rạp
          const cinemaElement = document.createElement("div")
          cinemaElement.classList.add("cinema-group")

          // Tạo tiêu đề cho tên rạp và địa chỉ
          const cinemaTitle = document.createElement("h4")
          cinemaTitle.innerHTML = `🎬 ${cinema.cinema_name} (${cinema.location})`
          cinemaElement.appendChild(cinemaTitle)

          // Duyệt qua các phòng chiếu của rạp
          cinema.rooms.forEach((room) => {
            const roomElement = document.createElement("div")
            roomElement.classList.add("schedule-box")

            const roomTitle = document.createElement("h5")
            roomTitle.innerHTML = `Phòng: ${room.room_name}`
            roomElement.appendChild(roomTitle)

            // Duyệt qua các suất chiếu của phòng
            room.showtimes.forEach((showtime) => {
              const showtimeButton = document.createElement("button")
              showtimeButton.classList.add("time-slot")
              showtimeButton.setAttribute("data-showtime-id", showtime.showtime_id)
              showtimeButton.setAttribute("data-cinema", cinema.cinema_name)
              showtimeButton.setAttribute("data-time", showtime.start_time)
              showtimeButton.innerHTML = `${showtime.start_time} - ${showtime.end_time} | Giá: ${Number.parseInt(showtime.price)} VNĐ`

              showtimeButton.onclick = () => {
                // Update time slot states
                document.querySelectorAll(".time-slot").forEach((slot) => {
                  slot.classList.remove("selected")
                })

                // Mark selected time slot
                showtimeButton.classList.add("selected")

                // Set base price
                basePrice = Number.parseInt(showtime.price)

                // Reset selections
                selectedSeats = []
                selectedConcessions = {}

                // Show fixed bar
                const fixedBar = document.querySelector(".fixed-bar")
                fixedBar.style.display = "flex"

                // Update booking display
                updateBookingTotal()
                document.getElementById("book-btn").disabled = true

                // Start timer
                startTimer()

                // Show additional content
                const additionalContent = document.getElementById("addtional")
                additionalContent.style.display = "block"

                // Update booking summary with cinema and time only
                const summaryElement = document.getElementById("booking-summary")
                if (summaryElement) {
                  summaryElement.textContent = `${cinema.cinema_name} | ${showtime.start_time}`
                }

                // Load seat map
                showSeatMap(showtime.showtime_id)
              }

              roomElement.appendChild(showtimeButton)
            })

            cinemaElement.appendChild(roomElement)
          })

          // Thêm rạp vào danh sách
          Showtimelist.appendChild(cinemaElement)
        })
      } else {
        // Nếu không có suất chiếu
        const noShowtimesMessage = document.createElement("p")
        noShowtimesMessage.innerHTML = "Không có suất chiếu cho ngày này."
        Showtimelist.appendChild(noShowtimesMessage)
      }
      console.log(data)
      if (presetShowtimeId) {
        // dùng setTimeout 0 để đợi DOM cập nhật xong
        setTimeout(() => {
          autoSelectShowtime(presetShowtimeId)
        }, 0)
      }
    })
    .catch((error) => {
      console.error("Lỗi khi fetch showtimes:", error)
    })
}

function showSeatMap(showtimeId) {
  const additionalContent = document.getElementById("addtional")
  const seatSection = document.getElementById("seats-section")
  seatSection.innerHTML = ""

  fetch(`app/controler/get_seats.php?showtime_id=${showtimeId}`)
    .then((response) => response.json())
    .then((data) => {
      const seats = data.seats || []

      const screen = document.createElement("div")
      screen.className = "screen"
      screen.innerText = "Màn hình"

      const seatGrid = document.createElement("div")
      seatGrid.className = "seat-grid"

      // Nhóm ghế theo hàng (A, B, C,...)
      const seatMap = {}
      seats.forEach((seat) => {
        const row = seat.seat_number.charAt(0)
        if (!seatMap[row]) seatMap[row] = []
        seatMap[row].push(seat)
      })

      Object.keys(seatMap)
        .sort()
        .forEach((row) => {
          const seatRow = document.createElement("div")
          seatRow.className = "seat-row"

          const label = document.createElement("span")
          label.style = "display: inline-block; width: 20px; text-align: right; margin-right: 10px;"
          label.textContent = row
          seatRow.appendChild(label)

          // Sắp xếp theo số
          seatMap[row].sort((a, b) => {
            const n1 = Number.parseInt(a.seat_number.slice(1))
            const n2 = Number.parseInt(b.seat_number.slice(1))
            return n1 - n2
          })

          seatMap[row].forEach((seat) => {
            const seatDiv = document.createElement("div")
            seatDiv.className = "seat"
            if (seat.seat_type === "Couple") seatDiv.classList.add("couple")
            if (seat.seat_type === "Standard") seatDiv.classList.add("standard")
            if (seat.seat_type === "Vip") seatDiv.classList.add("vip")
            if (seat.status === "Booked") {
              seatDiv.classList.add("booked")
              seatDiv.style.pointerEvents = "none"
            } else {
              seatDiv.onclick = () => {
                seatDiv.classList.toggle("selected")

                const seatPrice = Number.parseInt(seat.extra_price) || 0
                const seatId = seat.seat_id

                const index = selectedSeats.findIndex((s) => s.id === seatId)
                if (index >= 0) {
                  selectedSeats.splice(index, 1) // bỏ chọn
                } else {
                  selectedSeats.push({
                    id: seatId,
                    seatNumber: seat.seat_number,
                    price: seatPrice,
                    type: seat.seat_type,
                  }) // chọn
                }
                const bookingBtn = document.getElementById("book-btn")
                if (selectedSeats.length > 0) {
                  bookingBtn.disabled = false
                } else {
                  bookingBtn.disabled = true
                }

                updateBookingTotal()
              }
            }

            seatDiv.dataset.seat = seat.seat_number
            seatDiv.textContent = seat.seat_number
            seatRow.appendChild(seatDiv)
          })

          seatGrid.appendChild(seatRow)
        })

      seatSection.appendChild(screen)
      seatSection.appendChild(seatGrid)
      additionalContent.style.display = "block"
    })
    .catch((error) => {
      console.error("Lỗi khi fetch ghế:", error)
    })
}

function initializeQuantityControls() {
  document.querySelectorAll(".quantity-btn").forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault()

      const isPlus = this.classList.contains("plus")
      const type = this.getAttribute("data-type")
      const input = this.parentElement.querySelector(".quantity-input")
      const concessionId = input.id.split("-")[0]

      let value = Number.parseInt(input.value) || 0

      if (isPlus) {
        value++
      } else {
        value = Math.max(0, value - 1)
      }

      input.value = value

      // Update concessions
      if (!selectedConcessions[concessionId]) {
        const priceText = this.closest(".card-body").querySelector(".card-text").textContent
        const price = Number.parseInt(priceText.replace(/[^\d]/g, ""))
        selectedConcessions[concessionId] = { quantity: 0, price: price }
      }

      selectedConcessions[concessionId].quantity = value

      if (value === 0) {
        delete selectedConcessions[concessionId]
      }

      updateBookingTotal()
    })
  })
}

function updateBookingTotal() {
  // Calculate totals
  const seatTotal = selectedSeats.reduce((sum, seat) => sum + Number.parseInt(seat.price), 0)
  const concessionTotal = Object.values(selectedConcessions).reduce((sum, item) => sum + item.price * item.quantity, 0)

  // Calculate total price (base price per seat + seat extras + concessions)
  const total = basePrice * selectedSeats.length + seatTotal + concessionTotal

  // Update total display
  document.getElementById("booking-total").innerText = `${total.toLocaleString()} VND`

  // Update summary - keep only cinema and time
  const summaryElement = document.getElementById("booking-summary")
  if (summaryElement) {
    const currentText = summaryElement.textContent
    // Only keep the cinema and time information
    if (currentText.includes("|")) {
      // Extract just the cinema and time part (first two segments)
      const parts = currentText.split("|")
      if (parts.length >= 2) {
        const cinemaTime = parts[0] + "|" + parts[1]
        summaryElement.textContent = cinemaTime.trim()
      }
    }
  }
}

function startTimer() {
  clearInterval(countdownInterval)
  countdownSeconds = 300
  updateTimerDisplay()
  countdownInterval = setInterval(() => {
    countdownSeconds--
    updateTimerDisplay()
    if (countdownSeconds <= 0) {
      clearInterval(countdownInterval)
      alert("Hết thời gian giữ vé. Vui lòng chọn lại!")
      location.reload()
    }
  }, 1000)
}

function updateTimerDisplay() {
  const minutes = String(Math.floor(countdownSeconds / 60)).padStart(2, "0")
  const seconds = String(countdownSeconds % 60).padStart(2, "0")
  document.getElementById("timer").innerText = `${minutes}:${seconds}`
}

function initializeBookingButton() {
  const bookingBtn = document.getElementById("book-btn")
  if (bookingBtn) {
    bookingBtn.addEventListener("click", () => {
      if (selectedSeats.length === 0) {
        alert("Vui lòng chọn ít nhất một ghế!")
        return
      }

        lastTotal= Number.parseInt(document.getElementById("booking-total").textContent.replace(/[^\d]/g, ""));
        const discountAmount = lastTotal *  (window.discountPercent/100);
        console.log(lastTotal);
        lastTotal = lastTotal - discountAmount;

      // Prepare booking data
      const bookingData = {
        showtime_id: document.querySelector(".time-slot.selected").getAttribute("data-showtime-id"),
        seats: selectedSeats,
        concessions: Object.entries(selectedConcessions).map(([id, item]) => ({
          concession_id: id,
          quantity: item.quantity,
        })),
        total_price: lastTotal,
        discount: window.discountPercent,
      }

      console.log("Booking data:", JSON.stringify(bookingData))

      // Gửi dữ liệu bookingData sang payment.php bằng POST
      const form = document.createElement("form")
      form.method = "POST"
      form.action = "index.php?page=payment"

      const input = document.createElement("input")
      input.type = "hidden"
      input.name = "booking_data"
      input.value = JSON.stringify(bookingData)

      form.appendChild(input)
      document.body.appendChild(form)
      form.submit()

    })
  }
}
