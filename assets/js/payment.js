document.addEventListener("DOMContentLoaded", () => {
  // Khởi tạo đếm ngược
  initCountdown(); //
  console.log("Dữ liệu booking từ PHP:", window.bookingData);

  console.log("Dữ liệu booking từ PHP VNPAY:", window.bookingDataVNPAY);

  const urlParams = new URLSearchParams(window.location.search);
  const vnpayResponseCode = urlParams.get('vnp_ResponseCode');
  const vnpayTxnRef = urlParams.get('vnp_TxnRef');

  if (vnpayResponseCode && typeof vnpaySuccess !== 'undefined') {
    if (vnpaySuccess && vnpayTxnRef) {
      // Thanh toán VNPAY thành công
      // Ẩn các section không cần thiết
      document.getElementById("customer-section").style.display = "none"; //
      document.getElementById("payment-section").style.display = "none"; //
      document.getElementById("ticket-section").style.display = "block"; //
      updateStepStatus(3); //
      
      saveBookingToDatabase(window.bookingDataVNPAY);
      sendTicketEmail(window.bookingDataVNPAY);

      // Hiển thị thông tin vé sau khi VNPAY thành công
      displayTicketInfoAfterVnpay(localStorage.getItem("lastBookingId") || vnpayTxnRef);
    } else if (typeof vnpayMessage !== 'undefined') {
      // Thanh toán VNPAY thất bại hoặc có lỗi
      alert("Lỗi thanh toán VNPAY: " + vnpayMessage);
    }
  } else {
    const continueBtn = document.getElementById("continueBtn");
    if (continueBtn) {
      continueBtn.addEventListener("click", () => {
        goToPaymentStep();
      });
    }

    const paymentBtn = document.getElementById("paymentBtn");
    if (paymentBtn) {
      paymentBtn.addEventListener("click", () => {
        const paymentMethods = document.getElementsByName("paymentMethod");
        let selectedMethodId = "";
        for (const method of paymentMethods) {
          if (method.checked) {
            selectedMethodId = method.id;
            break;
          }
        }

        if (selectedMethodId === "bankTransfer") {
          initiateVnpayPayment();
        } else {
          alert("Vui lòng chọn phương thức thanh toán");
          return;
        }
      });
    }
  }
});

function initCountdown() {
  let timeLeft = 300; // 5 phút
  const countdownElements = document.querySelectorAll("#countdown, #countdown2");

  function updateCountdown() {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60; //
    const formattedMinutes = String(minutes).padStart(2, "0");
    const formattedSeconds = String(seconds).padStart(2, "0");

    countdownElements.forEach((element) => {
      if (element) {
        element.textContent = `${formattedMinutes}:${formattedSeconds}`; 
      }
    });

    if (timeLeft <= 0) { 
      clearInterval(timerInterval); 
      alert("Thời gian giữ vé đã hết."); 
    } else {
      timeLeft--; 
    }
  }
  updateCountdown(); 
  const timerInterval = setInterval(updateCountdown, 1000); 
}

function goToPaymentStep() {
  const ageCheck = document.getElementById("ageCheck").checked; 
  const termsCheck = document.getElementById("termsCheck").checked; 

  const fullNameValue = document.getElementById("fullName").value.trim();
  const phoneValue = document.getElementById("phone").value.trim();
  const emailValue = document.getElementById("email").value.trim();

  const fullNameInput = document.getElementById("fullName");
  if (!fullNameInput.readOnly && fullNameValue === "") {
    alert("Vui lòng nhập họ và tên.");
    return;
  }
  if (!document.getElementById("email").readOnly && emailValue !== "" && !/\S+@\S+\.\S+/.test(emailValue)) {
      alert("Vui lòng nhập địa chỉ email hợp lệ.");
      return;
  }
  if (!document.getElementById("phone").readOnly && phoneValue !== "" && !/^\d{10,11}$/.test(phoneValue)) {
      alert("Vui lòng nhập số điện thoại hợp lệ (10-11 số).");
      return;
  }
  if (!document.getElementById("phone").readOnly && phoneValue === "") {
    alert("Vui lòng nhập số điện thoại.");
    return;
  }
  if (!document.getElementById("email").readOnly && emailValue === "") {
    alert("Vui lòng nhập email.");
    return;
  }

  if (!ageCheck || !termsCheck) { 
    alert("Vui lòng điền đầy đủ thông tin và đồng ý với các điều khoản."); 
    return; 
  }

  localStorage.setItem("customerName", document.getElementById("fullName").value);
  localStorage.setItem("customerPhone", document.getElementById("phone").value);
  localStorage.setItem("customerEmail", document.getElementById("email").value);

  document.getElementById("customer-section").style.display = "none"; 
  document.getElementById("payment-section").style.display = "block"; 
  updateStepStatus(2); 
}

async function initiateVnpayPayment() {
  const amountText = document.querySelector(".total-price").textContent;
  const amount = parseInt(amountText.replace(/[^0-9]/g, ""), 10);

  if (isNaN(amount) || amount <= 0) {
    alert("Số tiền không hợp lệ. Vui lòng kiểm tra lại.");
    return;
  }

  const orderId = "CS" + Math.floor(Math.random() * 1000000000); 
  localStorage.setItem("lastBookingId", orderId); 

  const orderDescription = "Thanh toán đơn hàng đặt vé xem phim";
  const bankCode = "";

  try {
    const response = await fetch('app/controler/vnpay_create_payment.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        orderId: orderId,
        amount: amount,
        orderDescription: orderDescription,
        bankCode: bankCode,
        bookingData: window.bookingData,
      }),
    });

    if (!response.ok) {
      const errorData = await response.json().catch(() => ({ message: 'Lỗi không xác định từ máy chủ.' }));
      throw new Error(errorData.message || 'Lỗi khi tạo yêu cầu thanh toán VNPAY.');
    }

    const data = await response.json();

    if (data.vnpayUrl) {
      window.location.href = data.vnpayUrl;
    } else {
      alert(data.message || 'Không nhận được URL thanh toán VNPAY.');
    }
  } catch (error) {
    console.error('Lỗi VNPAY:', error);
    alert('Đã xảy ra lỗi khi xử lý thanh toán VNPAY: ' + error.message);
  }
}

function goToTicketStep(bookingIdFromVnpay = null) { //
  document.getElementById("payment-section").style.display = "none";
  document.getElementById("ticket-section").style.display = "block";
  updateStepStatus(3); 

  const finalBookingId = bookingIdFromVnpay || localStorage.getItem("lastBookingId") || ("CS" + Math.floor(Math.random() * 1000000000)); 
  document.getElementById("booking-id").textContent = finalBookingId; 
  localStorage.removeItem("lastBookingId");

  const customerName = localStorage.getItem("customerNameForTicket");
  const customerPhone = localStorage.getItem("customerPhoneForTicket");
  const customerEmail = localStorage.getItem("customerEmailForTicket");
  
  if (customerName && document.getElementById("customer-name")) document.getElementById("customer-name").textContent = customerName;
  if (customerPhone && document.getElementById("customer-phone")) document.getElementById("customer-phone").textContent = customerPhone;
  if (customerEmail && document.getElementById("customer-email")) document.getElementById("customer-email").textContent = customerEmail;
  
  // Hiển thị phương thức thanh toán đã chọn
  const paymentMethods = document.getElementsByName("paymentMethod"); 
  let selectedMethodText = "Thẻ tín dụng/ghi nợ";
  let selectedMethodId = "";

   for (const method of paymentMethods) {
    if (method.checked) {
      selectedMethodId = method.id;
      break;
    }
  }
  
  // Nếu là VNPAY trả về, selectedMethodId có thể không được check, nên ta dựa vào bookingIdFromVnpay
  if (bookingIdFromVnpay) {
      selectedMethodText = "Thanh toán qua VNPAY";
  } else {
      switch (selectedMethodId) { 
        case "creditCard": 
          selectedMethodText = "Thẻ tín dụng/ghi nợ";
          break;
        case "bankTransfer": //
          selectedMethodText = "Thanh toán qua VNPAY";
          break;
        case "momo": 
          selectedMethodText = "Ví MoMo"; 
          break;
        case "zalopay": //
          selectedMethodText = "ZaloPay"; 
          break;
      }
  }
  document.getElementById("payment-method").textContent = selectedMethodText; 
}

// Hàm riêng để hiển thị thông tin vé sau khi VNPAY thành công
function displayTicketInfoAfterVnpay(bookingId) {


  document.getElementById("booking-id").textContent = bookingId; 
  
  const customerName = localStorage.getItem("customerName"); 
  const customerPhone = localStorage.getItem("customerPhone"); 
  const customerEmail = localStorage.getItem("customerEmail"); 

  const ticketCustomerNameEl = document.getElementById("customer-name"); 
  const ticketCustomerPhoneEl = document.getElementById("customer-phone");
  const ticketCustomerEmailEl = document.getElementById("customer-email");
  const ticketPaymentMethodEl = document.getElementById("payment-method");

  if (ticketCustomerNameEl && customerName) ticketCustomerNameEl.textContent = customerName;
  if (ticketCustomerPhoneEl && customerPhone) ticketCustomerPhoneEl.textContent = customerPhone;
  if (ticketCustomerEmailEl && customerEmail) ticketCustomerEmailEl.textContent = customerEmail;
  
  if(ticketPaymentMethodEl) ticketPaymentMethodEl.textContent = "Thanh toán qua VNPAY";
}


function updateStepStatus(currentStep) { 
  document.getElementById("step1").className = "step"; 
  document.getElementById("step2").className = "step"; 
  document.getElementById("step3").className = "step"; 
  document.getElementById("line1").className = "step-line"; 
  document.getElementById("line2").className = "step-line"; 

  if (currentStep >= 1) { 
    document.getElementById("step1").className = "step completed"; 
  }
  if (currentStep >= 2) { 
    document.getElementById("line1").className = "step-line completed"; 
    document.getElementById("step2").className = "step active"; 
    if (currentStep > 2) {
        document.getElementById("step2").className = "step completed"; 
    }
  }
  if (currentStep >= 3) { //
    document.getElementById("step2").className = "step completed";
    document.getElementById("line2").className = "step-line completed"; 
    document.getElementById("step3").className = "step active"; 
  }
}

function saveBookingToDatabase(bookingData) {
  // Thêm mã giao dịch VNPAY vào dữ liệu gửi

  fetch("app/controler/save_booking.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(bookingData)
  })
    .then((res) => res.json())
    .then((data) => {
      console.log("Booking đã được lưu:", data);
    })
    .catch((err) => {
      console.error("Lỗi khi lưu booking:", err);
    });
}

function sendTicketEmail(bookingData) {
  fetch('../LTW/app/controler/send_ticket_email.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(bookingData)
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          alert('Thông tin vé đã được gửi đến email. Vui lòng kiểm tra');
      } else {
          alert('Không thể gửi Thông tin vé. ' + data.message);
      }
  })
  .catch(error => {
      console.error('Lỗi gửi Thông tin vé:', error);
  });
}