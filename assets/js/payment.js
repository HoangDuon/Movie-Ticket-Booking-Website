// payment.js

document.addEventListener("DOMContentLoaded", () => {
  // Khởi tạo đếm ngược
  initCountdown(); //

  // Kiểm tra xem có phải là redirect từ VNPAY về không
  const urlParams = new URLSearchParams(window.location.search);
  const vnpayResponseCode = urlParams.get('vnp_ResponseCode');
  const vnpayTxnRef = urlParams.get('vnp_TxnRef'); // Lấy mã giao dịch từ VNPAY return

  if (vnpayResponseCode && typeof vnpaySuccess !== 'undefined') { // vnpaySuccess sẽ được set từ payment.php
    if (vnpaySuccess && vnpayTxnRef) {
      // Thanh toán VNPAY thành công
      // Ẩn các section không cần thiết
      document.getElementById("customer-section").style.display = "none"; //
      document.getElementById("payment-section").style.display = "none"; //
      document.getElementById("ticket-section").style.display = "block"; //
      updateStepStatus(3); //
      
      // Hiển thị thông tin vé sau khi VNPAY thành công
      displayTicketInfoAfterVnpay(localStorage.getItem("lastBookingId") || vnpayTxnRef); // Ưu tiên vnpayTxnRef nếu lastBookingId không có
    } else if (typeof vnpayMessage !== 'undefined') {
      // Thanh toán VNPAY thất bại hoặc có lỗi
      alert("Lỗi thanh toán VNPAY: " + vnpayMessage);
      // Có thể reset về bước thông tin khách hàng hoặc thanh toán
      // updateStepStatus(1); // Quay về bước 1 chẳng hạn
      // document.getElementById("customer-section").style.display = "block";
      // document.getElementById("payment-section").style.display = "none";
      // document.getElementById("ticket-section").style.display = "none";
    }
  } else {
    // Luồng bình thường, không phải redirect từ VNPAY
    const continueBtn = document.getElementById("continueBtn"); //
    if (continueBtn) {
      continueBtn.addEventListener("click", () => {
        goToPaymentStep(); //
      });
    }

    const paymentBtn = document.getElementById("paymentBtn"); //
    if (paymentBtn) {
      paymentBtn.addEventListener("click", () => {
        const paymentMethods = document.getElementsByName("paymentMethod"); //
        let selectedMethodId = "";
        for (const method of paymentMethods) {
          if (method.checked) {
            selectedMethodId = method.id;
            break;
          }
        }

        if (selectedMethodId === "bankTransfer") {
          // Người dùng chọn "Chuyển khoản ngân hàng" -> VNPAY
          initiateVnpayPayment();
        } else {
          goToTicketStep(); //
        }
      });
    }
  }
});

function initCountdown() { //
  let timeLeft = 300; // 5 phút
  const countdownElements = document.querySelectorAll("#countdown, #countdown2"); //

  function updateCountdown() { //
    const minutes = Math.floor(timeLeft / 60); //
    const seconds = timeLeft % 60; //
    const formattedMinutes = String(minutes).padStart(2, "0"); //
    const formattedSeconds = String(seconds).padStart(2, "0"); //

    countdownElements.forEach((element) => { //
      if (element) {
        element.textContent = `${formattedMinutes}:${formattedSeconds}`; //
      }
    });

    if (timeLeft <= 0) { //
      clearInterval(timerInterval); //
      alert("Thời gian giữ vé đã hết."); //
    } else {
      timeLeft--; //
    }
  }
  updateCountdown(); //
  const timerInterval = setInterval(updateCountdown, 1000); //
}

function goToPaymentStep() { //
  const ageCheck = document.getElementById("ageCheck").checked; //
  const termsCheck = document.getElementById("termsCheck").checked; //

    // Lấy lại giá trị từ các input (giờ đây có thể đã được điền sẵn từ PHP nếu đăng nhập)
  const fullNameValue = document.getElementById("fullName").value.trim();
  const phoneValue = document.getElementById("phone").value.trim();
  const emailValue = document.getElementById("email").value.trim();

  // Kiểm tra các trường thông tin khách hàng nếu chúng không readonly (tức là cho phép nhập)
  const fullNameInput = document.getElementById("fullName");
  if (!fullNameInput.readOnly && fullNameValue === "") { // Chỉ kiểm tra trống nếu trường không phải readonly
    alert("Vui lòng nhập họ và tên.");
    return;
  }
  // Kiểm tra email chỉ khi không readonly và đã nhập
  if (!document.getElementById("email").readOnly && emailValue !== "" && !/\S+@\S+\.\S+/.test(emailValue)) {
      alert("Vui lòng nhập địa chỉ email hợp lệ.");
      return;
  }
  // Kiểm tra SĐT chỉ khi không readonly và đã nhập (regex cơ bản, bạn có thể cần regex chặt hơn)
  if (!document.getElementById("phone").readOnly && phoneValue !== "" && !/^\d{10,11}$/.test(phoneValue)) {
      alert("Vui lòng nhập số điện thoại hợp lệ (10-11 số).");
      return;
  }
  // Bắt buộc nhập nếu trường không readonly
  if (!document.getElementById("phone").readOnly && phoneValue === "") {
    alert("Vui lòng nhập số điện thoại.");
    return;
  }
  if (!document.getElementById("email").readOnly && emailValue === "") {
    alert("Vui lòng nhập email.");
    return;
  }

  if (!ageCheck || !termsCheck) { //
    alert("Vui lòng điền đầy đủ thông tin và đồng ý với các điều khoản."); //
    return; //
  }

  // Lưu thông tin khách hàng (nếu cần thiết, vì bạn đã comment out phần này)
  localStorage.setItem("customerName", document.getElementById("fullName").value);
  localStorage.setItem("customerPhone", document.getElementById("phone").value);
  localStorage.setItem("customerEmail", document.getElementById("email").value);

  document.getElementById("customer-section").style.display = "none"; //
  document.getElementById("payment-section").style.display = "block"; //
  updateStepStatus(2); //
}

async function initiateVnpayPayment() {
  // Lấy số tiền từ phần tử hiển thị trên trang
  // Giả sử #totalPriceDisplay là ID của phần tử chứa số tiền thuần túy (ví dụ 45000)
  // Hoặc bạn lấy từ `document.querySelector(".total-price").textContent` và xử lý nó
  const amountText = document.querySelector(".total-price").textContent; // Ví dụ: "45,000VND"
  const amount = parseInt(amountText.replace(/[^0-9]/g, ""), 10); // Chuyển thành số 45000

  if (isNaN(amount) || amount <= 0) {
    alert("Số tiền không hợp lệ. Vui lòng kiểm tra lại.");
    return;
  }

  const orderId = "CS" + Math.floor(Math.random() * 1000000000); //
  // Lưu orderId này lại để đối chiếu khi VNPAY trả về, hoặc hiển thị trên trang vé
  localStorage.setItem("lastBookingId", orderId); 

  const orderDescription = "Thanh toán đơn hàng đặt vé xem phim";
  const bankCode = ""; // Để trống để VNPAY hiển thị danh sách ngân hàng

  try {
    const response = await fetch('app/controler/vnpay_create_payment.php', { // Gọi file PHP mới để tạo URL VNPAY
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        orderId: orderId,
        amount: amount,
        orderDescription: orderDescription,
        bankCode: bankCode,
        // các thông tin khác nếu cần thiết cho backend
      }),
    });

    if (!response.ok) {
      const errorData = await response.json().catch(() => ({ message: 'Lỗi không xác định từ máy chủ.' }));
      throw new Error(errorData.message || 'Lỗi khi tạo yêu cầu thanh toán VNPAY.');
    }

    const data = await response.json();

    if (data.vnpayUrl) {
      window.location.href = data.vnpayUrl; // Chuyển hướng đến VNPAY
    } else {
      alert(data.message || 'Không nhận được URL thanh toán VNPAY.');
    }
  } catch (error) {
    console.error('Lỗi VNPAY:', error);
    alert('Đã xảy ra lỗi khi xử lý thanh toán VNPAY: ' + error.message);
  }
}

// Hàm này sẽ được gọi khi thanh toán (không phải VNPAY) thành công hoặc VNPAY trả về thành công
function goToTicketStep(bookingIdFromVnpay = null) { //
  document.getElementById("payment-section").style.display = "none"; //
  document.getElementById("ticket-section").style.display = "block"; //
  updateStepStatus(3); //

  const finalBookingId = bookingIdFromVnpay || localStorage.getItem("lastBookingId") || ("CS" + Math.floor(Math.random() * 1000000000)); //
  document.getElementById("booking-id").textContent = finalBookingId; //
  localStorage.removeItem("lastBookingId"); // Xóa ID đã dùng

  // Hiển thị thông tin khách hàng đã lưu (nếu có)
  const customerName = localStorage.getItem("customerNameForTicket");
  const customerPhone = localStorage.getItem("customerPhoneForTicket");
  const customerEmail = localStorage.getItem("customerEmailForTicket");
  
  if (customerName && document.getElementById("customer-name")) document.getElementById("customer-name").textContent = customerName;
  if (customerPhone && document.getElementById("customer-phone")) document.getElementById("customer-phone").textContent = customerPhone;
  if (customerEmail && document.getElementById("customer-email")) document.getElementById("customer-email").textContent = customerEmail;
  
  // Hiển thị phương thức thanh toán đã chọn
  const paymentMethods = document.getElementsByName("paymentMethod"); //
  let selectedMethodText = "Thẻ tín dụng/ghi nợ"; // Mặc định
  let selectedMethodId = "";

   for (const method of paymentMethods) { //
    if (method.checked) { //
      selectedMethodId = method.id; //
      break;
    }
  }
  
  // Nếu là VNPAY trả về, selectedMethodId có thể không được check, nên ta dựa vào bookingIdFromVnpay
  if (bookingIdFromVnpay) { // hoặc một cờ khác báo hiệu là VNPAY
      selectedMethodText = "Thanh toán qua VNPAY";
  } else {
      switch (selectedMethodId) { //
        case "creditCard": //
          selectedMethodText = "Thẻ tín dụng/ghi nợ"; //
          break;
        case "bankTransfer": //
          selectedMethodText = "Thanh toán qua VNPAY"; // Đã đổi tên
          break;
        case "momo": //
          selectedMethodText = "Ví MoMo"; //
          break;
        case "zalopay": //
          selectedMethodText = "ZaloPay"; //
          break;
      }
  }
  document.getElementById("payment-method").textContent = selectedMethodText; //
}

// Hàm riêng để hiển thị thông tin vé sau khi VNPAY thành công
function displayTicketInfoAfterVnpay(bookingId) {
  // Ẩn các section không cần thiết đã làm ở DOMContentLoaded
  // document.getElementById("customer-section").style.display = "none";
  // document.getElementById("payment-section").style.display = "none";
  // document.getElementById("ticket-section").style.display = "block";
  // updateStepStatus(3); // Đã gọi ở DOMContentLoaded

  document.getElementById("booking-id").textContent = bookingId; //
  
  const customerName = localStorage.getItem("customerName"); //
  const customerPhone = localStorage.getItem("customerPhone"); //
  const customerEmail = localStorage.getItem("customerEmail"); //

  const ticketCustomerNameEl = document.getElementById("customer-name"); // Sử dụng ID đã có
  const ticketCustomerPhoneEl = document.getElementById("customer-phone"); // Sử dụng ID đã có
  const ticketCustomerEmailEl = document.getElementById("customer-email"); // Sử dụng ID đã có
  const ticketPaymentMethodEl = document.getElementById("payment-method"); // Sử dụng ID đã có

  if (ticketCustomerNameEl && customerName) ticketCustomerNameEl.textContent = customerName;
  if (ticketCustomerPhoneEl && customerPhone) ticketCustomerPhoneEl.textContent = customerPhone;
  if (ticketCustomerEmailEl && customerEmail) ticketCustomerEmailEl.textContent = customerEmail;
  
  if(ticketPaymentMethodEl) ticketPaymentMethodEl.textContent = "Thanh toán qua VNPAY";
}


function updateStepStatus(currentStep) { //
  document.getElementById("step1").className = "step"; //
  document.getElementById("step2").className = "step"; //
  document.getElementById("step3").className = "step"; //
  document.getElementById("line1").className = "step-line"; //
  document.getElementById("line2").className = "step-line"; //

  if (currentStep >= 1) { //
    document.getElementById("step1").className = "step completed"; //
  }
  if (currentStep >= 2) { //
    document.getElementById("line1").className = "step-line completed"; //
    document.getElementById("step2").className = "step active"; //
    // Nếu đã qua bước 2 (thanh toán) và đang ở bước 3, thì bước 2 cũng là completed
    if (currentStep > 2) {
        document.getElementById("step2").className = "step completed"; //
    }
  }
  if (currentStep >= 3) { //
    document.getElementById("step2").className = "step completed"; // Mark step 2 as completed if we are at step 3
    document.getElementById("line2").className = "step-line completed"; //
    document.getElementById("step3").className = "step active"; //
  }
}