<?php
require_once "../model/pdo.php"; // hoặc đường dẫn tới file DAO

// Lấy dữ liệu từ POST
$id = $_POST['id'] ?? '';
$name = $_POST['name'];
$price = $_POST['price'];


// Xử lý ảnh (poster + banner)
function upload_file($fileKey, $uploadDir = "../../assets/img/") {
    if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES[$fileKey]['tmp_name'];
        $fileName = basename($_FILES[$fileKey]['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmp, $targetPath)) {
            return 'assets/img/'. $fileName;
        }
    }
    return null;
}

$poster = upload_file('picture');

// Thêm mới
if (empty($id)) {
    $sql = "INSERT INTO concessions (name,price,picture_link)
            VALUES (?, ?, ?)";
    pdo_execute($sql, $name,$price,$poster);
} else {
    // Cập nhật
    $sql = "UPDATE concessions SET name=?, price=?";
    $params = [$name, $price];

    if ($poster) {
        $sql .= ", picture_link=?";
        $params[] = $poster;
    }

    $sql .= " WHERE concession_id=?";
    $params[] = $id;

    pdo_execute($sql, ...$params);
}
header("Location: ../view/admin.php");
// echo '<pre>';
// print_r($_FILES);
// echo '</pre>';
exit;

?>