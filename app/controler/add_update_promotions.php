<?php
require_once "../model/pdo.php"; // hoặc đường dẫn tới file DAO

// Lấy dữ liệu từ POST
$id = $_POST['id'] ?? '';
$title = $_POST['title'];
$content = $_POST['content'];

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

$banner = upload_file('banner');

// Thêm mới
if (empty($id)) {
    $sql = "INSERT INTO promotions (title, content ,banner_url)
            VALUES (?, ?, ?)";
    pdo_execute($sql, $title, $content,$banner);
} else {
    // Cập nhật
    $sql = "UPDATE promotions SET title=?, content=?";
    $params = [$title, $content];

    if ($banner) {
        $sql .= ", banner_url=?";
        $params[] = $banner;
    }

    $sql .= " WHERE promotion_id=?";
    $params[] = $id;

    pdo_execute($sql, ...$params);
}
header("Location: ../view/admin.php");
// echo '<pre>';
// print_r($_FILES);
// echo '</pre>';
exit;

?>