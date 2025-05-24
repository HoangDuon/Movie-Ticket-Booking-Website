<?php
session_start();
// vnpay_create_payment.php
date_default_timezone_set('Asia/Ho_Chi_Minh');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

header('Content-Type: application/json');

// Nhận dữ liệu JSON từ request
$json_param = file_get_contents('php://input');
$param = json_decode($json_param);


// --- CẤU HÌNH VNPAY ---
// Thay thế bằng thông tin thật của bạn
$vnp_TmnCode = "6F05EVIZ"; // Mã website tại VNPAY
$vnp_HashSecret = "6HMGVY19V4IKB4YMA6MPL4W1RDD6NOOI"; // Chuỗi bí mật
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // URL Giao diện thanh toán VNPAY (sandbox)
// $vnp_Url = "https://vnpayment.vn/paymentv2/vpcpay.html"; // URL Production
$vnp_Returnurl = "http://localhost/LTW/index.php?page=payment"; // URL trả về sau khi thanh toán

// --- LẤY THÔNG TIN TỪ REQUEST ---
$vnp_TxnRef = $param->orderId ?? ('CS' . time()); // Mã đơn hàng. Nên đảm bảo tính duy nhất.
$vnp_OrderInfo = $param->orderDescription ?? "Thanh toan don hang";
$vnp_OrderType = "billpayment"; // Loại hàng hóa (theo tài liệu VNPAY)
$vnp_Amount = ($param->amount ?? 0) * 100; // Số tiền thanh toán (nhân 100 theo yêu cầu VNPAY)
$vnp_Locale = 'vn'; // Ngôn ngữ giao diện (vn hoặc en)
// $vnp_BankCode = $param->bankCode ?? ''; // Mã ngân hàng (để trống nếu muốn khách chọn)
$vnp_IpAddr = $_SERVER['REMOTE_ADDR']; // IP Khách hàng

$bookingData = $param->bookingData;

$bookingData->txnRef = $vnp_TxnRef;
$bookingData->email = $_SESSION['user']['email'];

$_SESSION['bookingData'] = $bookingData;

// --- TẠO DỮ LIỆU GỬI SANG VNPAY ---
$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef
);

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}

ksort($inputData); // Sắp xếp các tham số theo thứ tự alphabet
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}

echo json_encode(['vnpayUrl' => $vnp_Url, 'message' => 'success']);
exit();