document.addEventListener("DOMContentLoaded", () => {
  // Khởi tạo đếm ngược
  initCountdown()

  // Thiết lập sự kiện cho nút tiếp tục
  const continueBtn = document.getElementById("continueBtn")
  if (continueBtn) {
    continueBtn.addEventListener("click", () => {
      goToPaymentStep()
    })
  }

  // Thiết lập sự kiện cho nút thanh toán
  const paymentBtn = document.getElementById("paymentBtn")
  if (paymentBtn) {
    paymentBtn.addEventListener("click", () => {
      goToTicketStep()
    })
  }
})

// Khởi tạo đếm ngược
function initCountdown() {
  let timeLeft = 300 // 6 phút 2 giây
  const countdownElements = document.querySelectorAll("#countdown, #countdown2")

  function updateCountdown() {
    const minutes = Math.floor(timeLeft / 60)
    const seconds = timeLeft % 60

    // Format thời gian với số 0 đứng trước nếu cần
    const formattedMinutes = String(minutes).padStart(2, "0")
    const formattedSeconds = String(seconds).padStart(2, "0")

    countdownElements.forEach((element) => {
      if (element) {
        element.textContent = `${formattedMinutes}:${formattedSeconds}`
      }
    })

    if (timeLeft <= 0) {
      clearInterval(timerInterval)
      alert("Thời gian giữ vé đã hết. Vui lòng thực hiện lại.")
      // Trong thực tế, có thể chuyển hướng người dùng đến trang hết hạn
    } else {
      timeLeft--
    }
  }

  // Gọi hàm lần đầu để hiển thị ngay lập tức
  updateCountdown()

  // Cập nhật đếm ngược mỗi giây
  const timerInterval = setInterval(updateCountdown, 1000)
}

// Chuyển đến bước thanh toán
function goToPaymentStep() {
  // Kiểm tra form thông tin khách hàng
  const fullName = document.getElementById("fullName").value
  const phone = document.getElementById("phone").value
  const email = document.getElementById("email").value
  const ageCheck = document.getElementById("ageCheck").checked
  const termsCheck = document.getElementById("termsCheck").checked

  // Kiểm tra dữ liệu đầu vào
  if (!fullName || !phone || !email || !ageCheck || !termsCheck) {
    alert("Vui lòng điền đầy đủ thông tin và đồng ý với các điều khoản.")
    return
  }

  // Lưu thông tin khách hàng
  saveCustomerInfo(fullName, phone, email)

  // Ẩn phần thông tin khách hàng
  document.getElementById("customer-section").style.display = "none"

  // Hiển thị phần thanh toán
  document.getElementById("payment-section").style.display = "block"

  // Cập nhật trạng thái các bước
  updateStepStatus(2)
}

// Chuyển đến bước thông tin vé
function goToTicketStep() {
  // Ẩn phần thanh toán
  document.getElementById("payment-section").style.display = "none"

  // Hiển thị phần thông tin vé
  document.getElementById("ticket-section").style.display = "block"

  // Cập nhật trạng thái các bước
  updateStepStatus(3)

  // Tạo mã đặt vé ngẫu nhiên
  document.getElementById("booking-id").textContent = "CS" + Math.floor(Math.random() * 1000000000)
}

// Lưu thông tin khách hàng
function saveCustomerInfo(name, phone, email) {
  // Lưu thông tin để hiển thị trong phần thông tin vé
  document.getElementById("customer-name").textContent = name
  document.getElementById("customer-phone").textContent = phone
  document.getElementById("customer-email").textContent = email
}

// Cập nhật trạng thái các bước
function updateStepStatus(currentStep) {
  // Reset tất cả các bước
  document.getElementById("step1").className = "step"
  document.getElementById("step2").className = "step"
  document.getElementById("step3").className = "step"
  document.getElementById("line1").className = "step-line"
  document.getElementById("line2").className = "step-line"

  // Cập nhật trạng thái dựa trên bước hiện tại
  if (currentStep >= 1) {
    document.getElementById("step1").className = "step completed"
  }

  if (currentStep >= 2) {
    document.getElementById("line1").className = "step-line completed"
    document.getElementById("step2").className = "step active"
  }

  if (currentStep >= 3) {
    document.getElementById("step2").className = "step completed"
    document.getElementById("line2").className = "step-line completed"
    document.getElementById("step3").className = "step active"
  }
}