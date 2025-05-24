<?php
require_once "../model/pdo.php";

// Lấy dữ liệu từ POST
$id = $_POST['id'] ?? '';
$title = $_POST['title'];
$genre = $_POST['genre'];
$duration = $_POST['duration'];
$director = $_POST['director'];
$cast = $_POST['cast'];
$trailer = $_POST['trailer'];
$language = $_POST['language'];
$release_date = $_POST['release_date'];
$description = $_POST['description'];

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

$poster = upload_file('poster');
$banner = upload_file('banner');

// Thêm mới
if (empty($id)) {
    $sql = "INSERT INTO movies (title, genre, duration, director, cast, language, release_date, description, poster_url,trailer_url, banner_url)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
    pdo_execute($sql, $title, $genre, $duration, $director, $cast, $language, $release_date, $description, $poster,$trailer, $banner);
} else {
    // Cập nhật
    $sql = "UPDATE movies SET title=?, genre=?, duration=?, director=?, cast=?, language=?, release_date=?, description=?,trailer_url=?";
    $params = [$title, $genre, $duration, $director, $cast, $language, $release_date, $description, $trailer];

    if ($poster) {
        $sql .= ", poster_url=?";
        $params[] = $poster;
    }
    if ($banner) {
        $sql .= ", banner_url=?";
        $params[] = $banner;
    }

    $sql .= " WHERE movie_id=?";
    $params[] = $id;

    pdo_execute($sql, ...$params);
}
header("Location: ../view/admin.php#movies");
// echo '<pre>';
// print_r($_FILES);
// echo '</pre>';
exit;

?>