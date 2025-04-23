<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<?php
include "../controler/user_services.php";
include "../controler/film_services.php";
include "../controler/concessions_services.php";
include "../controler/cinemas_services.php";

$concessionssevices = new concessions_services();
$userservice = new user_services();
$filmservice = new film_services();
$cinemaservice = new cinemas_services();
$concessions = $concessionssevices->ShowConcessionsAdmin();
$users = $userservice->ShowUser();
$memberships = $userservice->ShowMembership();
$showtimes = $filmservice->ShowShowtimesFilmAdmin();
$films = $filmservice->ShowFilmAdmin();
$cinemas = $cinemaservice->ShowCinemasAdmin();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar-custom {
            background-color: #212529;
            height: 50px;
        }
        .navbar-custom .navbar-brand {
            color: white;
            font-weight: bold;
        }
        .navbar-custom .logout {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }
        .navbar-custom .logout:hover {
            color: #adb5bd;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            position: fixed;
            top: 50px;
            left: 0;
            padding-top: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
        }
        .content {
            margin-top: 50px;
            margin-left: 250px;
            padding: 20px;
        }
            /* Đặt kích thước cho poster phim */
    .movie-poster {
        width: 100px;
        height: auto;
        border-radius: 5px;
        object-fit: cover;
    }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand ms-2" href="#">ADMIN SITE</a>
        <div class="d-flex me-3">
            <a class="logout" href="#"><i class="bi bi-box-arrow-right"></i> Đăng xuất</a>
        </div>
    </div>
</nav>

<div class="sidebar text-light" id="sidebar">
    <h4 class="text-center">HELLO ADMIN</h4>
    <a class="menu-item active" data-page="dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a class="menu-item" data-page="movies"><i class="bi bi-film"></i> Quản lý phim</a>
    <a class="menu-item" data-page="cinemas"><i class="bi bi-building"></i> Quản lý rạp</a>
    <a class="menu-item" data-page="showtime"><i class="bi bi-calendar-event"></i> Quản lý xuất chiếu</a>
    <a class="menu-item" data-page="users"><i class="bi bi-people"></i> Quản lý người dùng</a>
    <a class="menu-item" data-page="membership"><i class="bi bi-gem"></i> Quản lý Membership</a>
    <a class="menu-item" data-page="concessions"><i class="bi bi-basket"></i> Quản lý đồ ăn</a>
</div>

<div class="content" id="content">
    <div id="page-dashboard">
        <h2>Dashboard</h2>
        <p>Chào mừng bạn đến với hệ thống quản lý.</p>
    </div>

    <div id="page-users" style="display: none;">
        <h2>Quản lý người dùng</h2>
        <a href="#" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Thêm
        </a>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Sinh nhật</th>
                    <th>Thành viên</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['user_id'] ?></td>
                    <td><?= $user['full_name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['phone'] ?></td>
                    <td><?= $user['birthday'] ?></td>
                    <td><?= $user['role'] ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $user['user_id'] ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                        <a href="delete_user.php?id=<?= $user['user_id'] ?>" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')" 
                           class="btn btn-danger btn-sm">
                            <i class="bi bi-trash-fill"></i> Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="page-movies" style="display: none;">
        <h2>Quản lý phim</h2>
        <a href="#" class="btn btn-success btn-sm" onclick="showAddForm()">
            <i class="bi bi-plus-circle"></i> Thêm
        </a>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Poster</th>
                    <th>Tên phim</th>
                    <th>Thể loại</th>
                    <th>Thời lượng</th>
                    <th>Đạo diễn</th>
                    <th>Diễn viên</th>
                    <th>Ngôn ngữ</th>
                    <th>Ngày phát hành</th>
                    <th>Nội dung</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($films as $film): ?>
                <tr>
                    <td><?= $film['movie_id'] ?></td>
                    <td><img src="../../<?= $film['poster_url']?>" class="movie-poster" alt=""> </td>
                    <td><?= $film['title'] ?></td>
                    <td><?= $film['genre'] ?></td>
                    <td><?= $film['duration'] ?></td>
                    <td><?= $film['director'] ?></td>
                    <td><?= $film['cast'] ?></td>
                    <td><?= $film['language'] ?></td>
                    <td><?= $film['release_date'] ?></td>
                    <td><?= $film['description'] ?></td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm"
                            onclick="showEditForm(this)"
                            data-id="<?= $film['movie_id'] ?>"
                            data-title="<?= htmlspecialchars($film['title'], ENT_QUOTES) ?>"
                            data-genre="<?= htmlspecialchars($film['genre'], ENT_QUOTES) ?>"
                            data-duration="<?= $film['duration'] ?>"
                            data-director="<?= htmlspecialchars($film['director'], ENT_QUOTES) ?>"
                            data-cast="<?= htmlspecialchars($film['cast'], ENT_QUOTES) ?>"
                            data-language="<?= $film['language'] ?>"
                            data-release="<?= $film['release_date'] ?>"
                            data-description="<?= htmlspecialchars($film['description'], ENT_QUOTES) ?>"
                            >
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                        <a href="#" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa phim này?')" 
                           class="btn btn-danger btn-sm">
                            <i class="bi bi-trash-fill"></i> Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- FORM EDIT HIỂN NỔI LÊN -->
    <div id="editFormPanel" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <span class="close-button" onclick="hideEditForm()">&times;</span>
        <form id="editForm" action="../controler/add_update_movies.php" method="post" enctype="multipart/form-data">
        <label>Tiêu đề:</label>
        <input type="text" id="editTitle" name="title">

        <label>Thể loại:</label>
        <input type="text" id="editGenre" name="genre">

        <label>Thời lượng:</label>
        <input type="text" id="editDuration" name="duration">

        <label>Đạo diễn:</label>
        <input type="text" id="editDirector" name="director">

        <label>Diễn viên:</label>
        <input type="text" id="editCast" name="cast">

        <label>Ngôn ngữ:</label>
        <input type="text" id="editLanguage" name="language">

        <label>Ngày phát hành:</label>
        <input type="date" id="editReleaseDate" name="release_date">

        <label>Mô tả:</label>
        <textarea id="editDescription" name="description"></textarea>

        <label>Poster phim:</label>
        <input type="file" id="editPoster" accept="image/*" name="poster">

        <label>Banner phim:</label>
        <input type="file" id="editBanner" accept="image/*" name="banner">
        <input type="hidden" id="editId" name="id">

        <button type="submit">Lưu thay đổi</button>
        </form>
    </div>
    </div>

    <div id="page-cinemas" style="display: none;">
        <h2>Quản lý rạp</h2>
        <a href="#" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Thêm
        </a>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Tên rạp</th>
                    <th>Vị trí</th>
                    <th>SDT</th>
                    <th>Số phòng</th>
                    <th>Số xuất chiếu</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cinemas as $cinema): ?>
                <tr>
                    <td><?= $cinema['cinema_id'] ?></td>
                    <td><?= $cinema['name'] ?></td>
                    <td><?= $cinema['location'] ?></td>
                    <td><?= $cinema['phone'] ?></td>
                    <td><?= $cinema['Số Phòng'] ?></td>
                    <td><?= $cinema['Số Suất Chiếu'] ?></td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                        <a href="#" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa phim này?')" 
                           class="btn btn-danger btn-sm">
                            <i class="bi bi-trash-fill"></i> Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="page-concessions" style="display: none;">
        <h2>Quản lý đồ ăn</h2>
        <a href="#" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Thêm
        </a>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Hình ảnh</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($concessions as $concession): ?>
                <tr>
                    <td><?= $concession['concession_id'] ?></td>
                    <td><?= $concession['name'] ?></td>
                    <td><?= $concession['price'] ?></td>
                    <td><img src="<?= $concession['picture_link']?>" class="movie-poster" alt=""> </td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                        <a href="#" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa phim này?')" 
                           class="btn btn-danger btn-sm">
                            <i class="bi bi-trash-fill"></i> Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="page-membership" style="display: none;">
        <h2>Quản lý Membership</h2>
        <a href="#" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Thêm
        </a>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Loại</th>
                    <th>Tỉ lệ giảm (%)</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($memberships as $membership): ?>
                <tr>
                    <td><?= $membership['member_type'] ?></td>
                    <td><?= $membership['discount_percent'] ?></td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                        <a href="#" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa phim này?')" 
                           class="btn btn-danger btn-sm">
                            <i class="bi bi-trash-fill"></i> Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="page-showtime" style="display: none;">
        <h2>Quản lý xuất chiếu</h2>
        <a href="#" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> Thêm
        </a>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Tên phim</th>
                    <th>Tên rạp</th>
                    <th>Tên phòng chiếu</th>
                    <th>Thời gian bắt đầu</th>
                    <th>Thời gian kết thúc</th>
                    <th>Giá vé</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($showtimes as $showtime): ?>
                <tr>
                    <td><?= $showtime['showtime_id'] ?></td>
                    <td><?= $showtime['movie_title'] ?></td>
                    <td><?= $showtime['cinema_name'] ?></td>
                    <td><?= $showtime['room_name'] ?></td>
                    <td><?= $showtime['start_time'] ?></td>
                    <td><?= $showtime['end_time'] ?></td>
                    <td><?= $showtime['price'] ?></td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                        <a href="#" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa phim này?')" 
                           class="btn btn-danger btn-sm">
                            <i class="bi bi-trash-fill"></i> Xóa
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="../../assets/js/admin.js"></script>
</body>
</html>
