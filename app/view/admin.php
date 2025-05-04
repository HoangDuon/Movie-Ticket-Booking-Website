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
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

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

    <!-- NGƯỜI DÙNG -->
    <div id="page-users" style="display: none;">
        <h2>Quản lý người dùng</h2>
        <a href="#" class="btn btn-success btn-sm" onclick="showAddUserForm()">
            <i class="bi bi-plus-circle"></i> Thêm
        </a>
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Ngày sinh</th>
                    <th>Thành viên</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['user_id'] ?>
                        <?php if ($user['hide'] == 0): ?>
                            <i class="bi bi-eye" style="color: green;" title="Đang hiển thị"></i>
                        <?php else: ?>
                            <i class="bi bi-eye-slash" style="color: gray;" title="Đang ẩn"></i>
                        <?php endif; ?></td>
                    <td><?= $user['full_name'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td><?= $user['phone'] ?></td>
                    <td><?= $user['birthday'] ?></td>
                    <td><?= $user['member'] ?></td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm"
                            onclick="showEditUserForm(this)"
                            data-id="<?= $user['user_id'] ?>"
                            data-name="<?= htmlspecialchars($user['full_name'], ENT_QUOTES) ?>"
                            data-email="<?= $user['email'] ?>"
                            data-phone="<?= $user['phone'] ?>"
                            data-birthday="<?= $user['birthday'] ?>"
                            data-role="<?= $user['role'] ?>"
                            data-member="<?= $user['member'] ?>"
                            data-password="<?= $user['password'] ?>">
                                <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                    <?php if ($user['hide'] == 0): ?>
                        <a href="#"
                        onclick="showDeleteUserConfirm(<?= $user['user_id'] ?>,<?= $user['hide'] ?>)" 
                        class="btn btn-danger btn-sm">
                            <i class="bi bi-eye-slash"></i> Ẩn
                        </a>
                    <?php else: ?>
                        <a href="#"
                        onclick="showDeleteUserConfirm(<?= $user['user_id'] ?>,<?= $user['hide'] ?>)" 
                        class="btn btn-success btn-sm">
                            <i class="bi bi-eye"></i> Hiện
                        </a>
                    <?php endif; ?>
                </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- FORM EDIT USER -->
    <div id="editUserFormPanel" class="modal-overlay" style="display: none;">
        <div class="modal-content edit-user-modal">
            <span class="close-button" onclick="hideEditUserForm()">&times;</span>
            <form id="editUserForm" action="../controler/add_update_user.php" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label>Họ và tên:</label>
                        <input type="text" id="editUserName" name="full_name">
                    </div>
                    <div class="form-group">
                        <label>Ngày sinh:</label>
                        <input type="date" id="editUserBirthday" name="birthday">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" id="editUserEmail" name="email">
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại:</label>
                        <input type="text" id="editUserPhone" name="phone">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                    <label>Thành viên:</label>
                    <select id="editUserMember" name="member">
                    <?php foreach ($memberships as $option): ?>
                        <option value="<?php echo $option['member_type'] ?>"><?php echo $option['member_type'];?></option>
                    <?php endforeach; ?>
                    </select>
                    </div>
                    <div class="form-group">
                    <label>Vai trò:</label>
                    <select id="editUserRole" name="role">
                        <option value="Admin">Admin</option>
                        <option value="Customer">Customer</option>
                    </select>
                    </div>
                </div>

                <label>Mật khẩu:</label>
                <input type="text" id="editUserPassword" name="password">

                <input type="hidden" id="editUserId" name="id">
                <button type="submit">Lưu thay đổi</button>
            </form>
        </div>
    </div>

    <!-- FORM DELETE USER -->
    <div id="deleteUserConfirmPanel" class="modal-overlay" style="display: none;">
        <div class="modal-content delete-modal delete-user-modal" style="text-align: center;">
            <span class="close-button" onclick="hideDeleteUserConfirm()">&times;</span>
            <h3 id="titleUser">Bạn có chắc muốn ẩn người dùng này không?</h3>
            <form id="deleteUserForm" action="../controler/delete_user.php" method="post">
                <input type="hidden" name="id" id="deleteUserId">
                <button type="submit" style="background-color: rgb(24, 181, 63); margin-right: 10px;">Xác nhận</button>
                <button type="button" style="background-color: #e74c3c; margin-right: 10px;" onclick="hideDeleteUserConfirm()">Hủy</button>
            </form>
        </div>
    </div>

    <!-- PHIM -->
    <div id="page-movies" style="display: none;">
        <h2>Quản lý phim</h2>
        <a href="#" class="btn btn-success btn-sm" onclick="showMovieAddForm()">
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
                    <td><?= $film['movie_id'] ?>
                        <?php if ($film['hide'] == 0): ?>
                            <i class="bi bi-eye" style="color: green;" title="Đang hiển thị"></i>
                        <?php else: ?>
                            <i class="bi bi-eye-slash" style="color: gray;" title="Đang ẩn"></i>
                        <?php endif; ?></td>
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
                            onclick="showMovieEditForm(this)"
                            data-id="<?= $film['movie_id'] ?>"
                            data-title="<?= htmlspecialchars($film['title'], ENT_QUOTES) ?>"
                            data-genre="<?= htmlspecialchars($film['genre'], ENT_QUOTES) ?>"
                            data-duration="<?= $film['duration'] ?>"
                            data-director="<?= htmlspecialchars($film['director'], ENT_QUOTES) ?>"
                            data-cast="<?= htmlspecialchars($film['cast'], ENT_QUOTES) ?>"
                            data-trailer="<?= htmlspecialchars($film['trailer_url'], ENT_QUOTES) ?>"
                            data-language="<?= $film['language'] ?>"
                            data-release="<?= $film['release_date'] ?>"
                            data-description="<?= htmlspecialchars($film['description'], ENT_QUOTES) ?>"
                            >
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                    <?php if ($film['hide'] == 0): ?>
                        <a href="#"
                        onclick="showMovieDeleteConfirm(<?= $film['movie_id'] ?>,<?= $film['hide'] ?>)" 
                        class="btn btn-danger btn-sm">
                            <i class="bi bi-eye-slash"></i> Ẩn
                        </a>
                    <?php else: ?>
                        <a href="#"
                        onclick="showMovieDeleteConfirm(<?= $film['movie_id'] ?>,<?= $film['hide'] ?>)" 
                        class="btn btn-success btn-sm">
                            <i class="bi bi-eye"></i> Hiện
                        </a>
                    <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- FORM EDIT HIỂN NỔI LÊN -->
    <div id="editMovieFormPanel" class="modal-overlay" style="display: none;">
        <div class="modal-content edit-movie-modal">
            <span class="close-button" onclick="hideMovieEditForm()">&times;</span>
            <form id="editMovieForm" action="../controler/add_update_movies.php" method="post" enctype="multipart/form-data"onsubmit="updateCkEditorBeforeSubmit()">
            <label>Tiêu đề:</label>
            <input type="text" id="editTitle" name="title">

            <label>Thể loại:</label>
            <input type="text" id="editGenre" name="genre">

            <!-- Dòng: Đạo diễn & Thời lượng -->
            <div class="form-row">
            <div class="form-group">
                <label>Đạo diễn:</label>
                <input type="text" id="editDirector" name="director">
            </div>
            <div class="form-group">
                <label>Thời lượng:</label>
                <input type="text" id="editDuration" name="duration">
            </div>
            </div>

            <!-- Dòng: Ngôn ngữ & Diễn viên -->
            <div class="form-row">
            <div class="form-group">
                <label>Ngôn ngữ:</label>
                <input type="text" id="editLanguage" name="language">
            </div>
            <div class="form-group">
            <label>Ngày phát hành:</label>
            <input type="date" id="editReleaseDate" name="release_date">
            </div>
            </div>
                        
            <label>Diễn viên:</label>
            <input type="text" id="editCast" name="cast">


            <label>Mô tả:</label>
            <textarea id="editDescription" name="description"></textarea>
            <script>
                CKEDITOR.replace('editDescription');
            </script>

            <label>URL Trailer:</label>
            <input type="url" id="editTrailer" name="trailer"></input>

            <label>Poster phim:</label>
            <input type="file" id="editPoster" accept="image/*" name="poster">

            <label>Banner phim:</label>
            <input type="file" id="editBanner" accept="image/*" name="banner">
            <input type="hidden" id="editId" name="id">

            <button type="submit">Lưu thay đổi</button>
            </form>
        </div>
    </div>

    <!-- PANEL XÁC NHẬN XÓA -->
    <div id="deleteMovieConfirmPanel" class="modal-overlay" style="display: none;">
        <div class="modal-content delete-modal delete-movie-modal" style="text-align: center;">
            <span class="close-button" onclick="hideMovieDeleteConfirm()">&times;</span>
            <h3 id="titleMovie">Bạn có chắc muốn ẩn phim này không?</h3>
            <form id="deleteMovieForm" action="../controler/delete_movie.php" method="post">
            <input type="hidden" name="id" id="deleteMovieId">
            <button type="submit" style="background-color: rgb(24, 181, 63); margin-right: 10px;">Xác nhận</button>
            <button type="button" style="background-color:#e74c3c; margin-right: 10px;" onclick="hideMovieDeleteConfirm()">Hủy</button>
            </form>
        </div>
    </div>

    <!-- RẠP -->               
    <div id="page-cinemas" style="display: none;">
        <h2>Quản lý rạp</h2>
        <!-- <a href="#" class="btn btn-success btn-sm" onclick="showAddCinemasForm()">
            <i class="bi bi-plus-circle"></i> Thêm -->
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
                    <td><?= $cinema['cinema_id'] ?>
                        <?php if ($cinema['hide'] == 0): ?>
                            <i class="bi bi-eye" style="color: green;" title="Đang hiển thị"></i>
                        <?php else: ?>
                            <i class="bi bi-eye-slash" style="color: gray;" title="Đang ẩn"></i>
                        <?php endif; ?></td>
                    <td><?= $cinema['name'] ?></td>
                    <td><?= $cinema['location'] ?></td>
                    <td><?= $cinema['phone'] ?></td>
                    <td><?= $cinema['Số Phòng'] ?></td>
                    <td><?= $cinema['Số Suất Chiếu'] ?></td>
                    <td>
                    <a href="#" class="btn btn-warning btn-sm"
                            onclick="showEditCinemasForm(this,<?= $cinema['cinema_id'] ?>)"
                            data-id="<?= $cinema['cinema_id'] ?>"
                            data-name="<?= htmlspecialchars($cinema['name'], ENT_QUOTES) ?>"
                            data-location="<?= htmlspecialchars($cinema['location'], ENT_QUOTES) ?>"
                            data-phone="<?= $cinema['phone'] ?>"
                            data-rooms="<?= $cinema['Số Phòng'] ?>"
                            data-showtimes="<?= $cinema['Số Suất Chiếu'] ?>"
                            >
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                    <?php if ($cinema['hide'] == 0): ?>
                        <a href="#"
                        onclick="showDeleteCinemasConfirm(<?= $cinema['cinema_id'] ?>,<?= $cinema['hide'] ?>)" 
                        class="btn btn-danger btn-sm">
                            <i class="bi bi-eye-slash"></i> Ẩn
                        </a>
                    <?php else: ?>
                        <a href="#"
                        onclick="showDeleteCinemasConfirm(<?= $cinema['cinema_id'] ?>,<?= $cinema['hide'] ?>)" 
                        class="btn btn-success btn-sm">
                            <i class="bi bi-eye"></i> Hiện
                        </a>
                    <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- FORM EDIT HIỂN NỔI LÊN -->
    <div id="editCinemasFormPanel" class="modal-overlay" style="display: none;">
        <div class="modal-content edit-cinemas-modal" style="width: 90%; max-width: 1200px; max-height: 95%;  overflow-y: auto;">
        <span class="close-button" onclick="hideEditCinemasForm()">&times;</span>

        <!-- Chia 2 cột: -->
        <div style="display: flex; gap: 20px;">
        <!-- Cột trái: Form thông tin rạp -->
        <div style="flex: 4;">
            <form id="editCinemasForm" action="../controler/add_update_cinemas.php" method="post" enctype="multipart/form-data">
            <h2>Thông tin rạp</h2>
            <label>Tên rạp:</label>
            <input type="text" id="editCinemasName" name="name">

            <div class="form-row" style="display: flex; gap: 10px;">
                <div class="form-group" style="flex: 1;">
                <label>Vị trí:</label>
                <input type="text" id="editCinemasLocation" name="location">
                </div>
                <div class="form-group" style="flex: 1;">
                <label>Số điện thoại:</label>
                <input type="text" id="editCinemasPhone" name="phone">
                </div>
            </div>

            <div class="form-row" style="display: flex; gap: 10px;">
                <div class="form-group" style="flex: 1;">
                <label>Số phòng:</label>
                <input type="text" id="editCinemasRooms" name="room" readonly>
                </div>
                <div class="form-group" style="flex: 1;">
                <label>Xuất chiếu:</label>
                <input type="text" id="editCinemasShowtimes" name="showtime" readonly>
                </div>
            </div>

            <input type="hidden" id="editCinemasId" name="id">

            <button type="submit" style="margin-top: 10px;">Lưu thay đổi</button>
            </form>
        </div>

        <!-- Cột phải: Danh sách phòng -->
        <div style="flex: 6;">
                <h3 style="margin-top: 30px;">Danh sách phòng</h3>
                <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #eee;">
                    <th style="padding: 8px;">STT</th>
                    <th style="padding: 8px;">Tên phòng</th>
                    <th style="padding: 8px;">Số ghế</th>
                    <th style="padding: 8px;">Chức năng</th>
                    </tr>
                </thead>    
                <tbody id="roomsTableBody">
                    <!-- Danh sách phòng -->
                </tbody>
                </table>
                <form id="editSeatsForm" action="../controler/add_update_seats.php" method="post">
                <!-- Sơ đồ ghế sẽ hiện ra ở đây -->
                <div id="seatMapContainer" style="margin-top: 20px; display: none;">
                    <h3>Sơ đồ phòng</h3>
                    <div class="form-row" style="display: flex; gap: 10px;">
                        <div class="form-group" style="flex: 1;">
                            <label>Tên phòng: </label>
                            <input type="text" id="editRoomName" name="roomname">
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label>Trạng thái:</label>
                            <select id="editStatus" name="status" class="select-hide">
                                <option value="0">Hoạt động</option>
                                <option value="1">Ngừng Hoạt Động</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="editRoomId" name="roomid">
                    <div id="seatDetail" style="display: none;">
                    <div class="form-row" style="display: flex; gap: 10px;">
                        <div class="form-group" style="flex: 1;">
                            <label>Số ghế: </label>
                            <input type="text" id="editSeatName" name="seatname">
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label>Giá:</label>
                            <input type="text" id="editSeatPrice" name="price">
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label>Loại ghế:</label>
                            <select id="editSeatType" name="type" class="select-hide">
                                <option value="Standard">Standard</option>
                                <option value="Vip">Vip</option>
                                <option value="Couple">Couple</option>
                            </select>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label>Tình trạng:</label>
                            <select id="editSeatStatus" name="seatstatus" class="select-hide">
                                <option value="Available">Chưa đặt</option>
                                <option value="Booked">Đã đặt</option>
                            </select>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label>Trạng thái:</label>
                            <select id="editSeatHide" name="seathide" class="select-hide">
                                <option value="0">Hoạt động</option>
                                <option value="1">Không hoạt động</option>
                            </select>
                        </div>
                    </div>
                </div>
                    <button type="submit" style="margin-top: 10px;">Lưu</button>
                </div>
                <input type="hidden" id="editSeatId" name="seatid">
                <div class="screen">Màn hình</div>
                <div class="seat-container" id="seatMap">
                    <!-- Mẫu ghế -->
                </div>
                </form>
            </div>
        </div>

        </div>
    </div>

    <!-- PANEL XÁC NHẬN XÓA -->
    <div id="deleteCinemasConfirmPanel" class="modal-overlay" style="display: none;">
        <div class="modal-content delete-modal delete-cinemas-modal" style="text-align: center;">
            <span class="close-button" onclick="hideDeleteCinemasConfirm()">&times;</span>
            <h3 id="titleCinema">Bạn có chắc muốn ẩn rạp này không?</h3>
            <form id="deleteCinemasForm" action="../controler/delete_cinemas.php" method="post">
            <input type="hidden" name="id" id="deleteCinemasId">
            <button type="submit" style="background-color:  rgb(24, 181, 63); margin-right: 10px;">Xác nhận</button>
            <button type="button" style="background-color: #e74c3c; margin-right: 10px;" onclick="hideDeleteCinemasConfirm()">Hủy</button>
            </form>
        </div>
    </div>

    <!-- BẮP NƯỚC -->
    <div id="page-concessions" style="display: none;">
        <h2>Quản lý đồ ăn</h2>
        <a href="#" class="btn btn-success btn-sm" onclick="showAddConcessionsForm()">
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
                    <td><?= $concession['concession_id'] ?>
                        <?php if ($concession['hide'] == 0): ?>
                            <i class="bi bi-eye" style="color: green;" title="Đang hiển thị"></i>
                        <?php else: ?>
                            <i class="bi bi-eye-slash" style="color: gray;" title="Đang ẩn"></i>
                        <?php endif; ?></td>
                    <td><?= $concession['name'] ?></td>
                    <td><?= $concession['price'] ?></td>
                    <td><img src="../../<?= $concession['picture_link']?>" class="movie-poster" alt=""> </td>
                    <td>
                    <a href="#" class="btn btn-warning btn-sm"
                            onclick="showEditConcessionsForm(this)"
                            data-id="<?= $concession['concession_id'] ?>"
                            data-name="<?= htmlspecialchars($concession['name'], ENT_QUOTES) ?>"
                            data-price="<?= $concession['price'] ?>"
                            >
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                        <?php if ($concession['hide'] == 0): ?>
                        <a href="#"
                        onclick="showDeleteConcessionsConfirm(<?= $concession['concession_id'] ?>,<?= $concession['hide'] ?>)" 
                        class="btn btn-danger btn-sm">
                            <i class="bi bi-eye-slash"></i> Ẩn
                        </a>
                    <?php else: ?>
                        <a href="#"
                        onclick="showDeleteConcessionsConfirm(<?= $concession['concession_id'] ?>,<?= $concession['hide'] ?>)" 
                        class="btn btn-success btn-sm">
                            <i class="bi bi-eye"></i> Hiện
                        </a>
                    <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- FORM EDIT HIỂN NỔI LÊN -->
    <div id="editConcessionsFormPanel" class="modal-overlay" style="display: none;">
        <div class="modal-content edit-concessions-modal">
            <span class="close-button" onclick="hideEditConcessionsForm()">&times;</span>
            <form id="editConcessionsForm" action="../controler/add_update_concessions.php" method="post" enctype="multipart/form-data">

        <!-- Dòng: -->
        <div class="form-row">
            <div class="form-group">
                <label>Tên:</label>
                <input type="text" id="editConcessionsName" name="name">
            </div>
            <div class="form-group">
                <label>Giá:</label>
                <input type="text" id="editConcessionsPrice" name="price">
            </div>
        </div>

            <label>Hình ảnh</label>
            <input type="file" id="editPicture" accept="image/*" name="picture">

            <input type="hidden" id="editConcessionsId" name="id">

            <button type="submit">Lưu thay đổi</button>
            </form>
        </div>
    </div>

    <!-- PANEL XÁC NHẬN XÓA -->
    <div id="deleteConcessionsConfirmPanel" class="modal-overlay" style="display: none;">
        <div class="modal-content delete-modal delete-concessions-modal" style="text-align: center;">
            <span class="close-button" onclick="hideDeleteConcessionsConfirm()">&times;</span>
            <h3 id="titleConcession">Bạn có chắc muốn ẩn phần này không?</h3>
            <form id="deleteConcessionsForm" action="../controler/delete_concessions.php" method="post">
            <input type="hidden" name="id" id="deleteConcessionsId">
            <button type="submit" style="background-color: rgb(24, 181, 63); margin-right: 10px;">Xác nhận</button>
            <button type="button" style="background-color: #e74c3c; margin-right: 10px;" onclick="hideMovieDeleteConfirm()">Hủy</button>
            </form> 
        </div>
    </div>

    <!-- THÀNH VIÊN -->
    <div id="page-membership" style="display: none;">
        <h2>Quản lý Membership</h2>
        <!-- <a href="#" class="btn btn-success btn-sm" onclick="showAddMemberForm()"> 
            <i class="bi bi-plus-circle"></i> Thêm
        </a> -->
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
                    <a href="#" class="btn btn-warning btn-sm"
                            onclick="showEditMemberForm(this)"
                            data-member="<?= $membership['member_type']?>"
                            data-discount="<?= $membership['discount_percent'] ?>"
                            >
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                        <!-- <a href="#" 
                           onclick="showDeleteMemberConfirm('<?= $membership['member_type'] ?>')" 
                           class="btn btn-danger btn-sm">
                            <i class="bi bi-eye-slash"></i> Xóa
                        </a> -->
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- FORM EDIT MEMBERSHIP -->
    <div id="editMemberFormPanel" class="modal-overlay" style="display: none;">
        <div class="modal-content edit-member-modal">
            <span class="close-button" onclick="hideEditMemberForm()">&times;</span>
            <form id="editMemberForm" action="../controler/add_update_member.php" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label>Thành viên:</label>
                        <input type="text" id="editMemberMember" name="member" readonly>
                    </div>
                    <div class="form-group">
                        <label>Giảm giá (%):</label>
                        <input type="text" id="editMemberDiscount" name="discount">
                    </div>
                </div>
                <button type="submit">Lưu thay đổi</button>
            </form>
        </div>
    </div>

    <!-- FORM DELETE MEMEBERSHIP -->
    <div id="deleteMemberConfirmPanel" class="modal-overlay" style="display: none;">
        <div class="modal-content delete-modal delete-member-modal" style="text-align: center;">
            <span class="close-button" onclick="hideDeleteMemberConfirm()">&times;</span>
            <h3>Bạn có chắc muốn xóa loại thành viên này không?</h3>
            <form id="deleteMemberForm" action="../controler/delete_member.php" method="post">
                <input type="hidden" name="id" id="deleteMemberId">
                <button type="submit" style="background-color: rgb(24, 181, 63) ; margin-right: 10px;">Xác nhận</button>
                <button type="button" style="background-color: #e74c3c; margin-right: 10px;" onclick="hideDeleteMemberConfirm()">Hủy</button>
            </form>
        </div>
    </div>

    <!-- XUẤT CHIẾU -->
    <div id="page-showtime" style="display: none;">
        <h2>Quản lý xuất chiếu</h2>
        <a href="#" class="btn btn-success btn-sm" onclick="showAddShowtimeForm()">
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
                    <td><?= $showtime['showtime_id'] ?><?php if ($showtime['hide'] == 1 || $showtime['movie_hide'] == 1||$showtime['room_hide'] == 1 ||$showtime['cinema_hide'] == 1): ?>
                        <i class="bi bi-eye-slash" style="color: gray;" title="Đang ẩn"></i>    
                        <?php else: ?>
                            <i class="bi bi-eye" style="color: green;" title="Đang hiển thị"></i>
                        <?php endif; ?></td>
                    <td><?= $showtime['movie_title'] ?></td>
                    <td><?= $showtime['cinema_name'] ?></td>
                    <td><?= $showtime['room_name'] ?></td>
                    <td><?= $showtime['start_time'] ?></td>
                    <td><?= $showtime['end_time'] ?></td>
                    <td><?= $showtime['price'] ?></td>
                    <td>
                    <a href="#" class="btn btn-warning btn-sm" onclick="showEditShowtimeForm(this)" 
                    data-id="<?= $showtime['showtime_id'] ?>"
                        data-movietitle="<?= $showtime['movie_title'] ?>" 
                        data-cinemaname="<?= $showtime['cinema_name'] ?>" 
                        data-roomname="<?= $showtime['room_name'] ?>" 
                        data-start="<?= $showtime['start_time']?>" 
                        data-end="<?= $showtime['end_time'] ?>" 
                        data-price="<?= $showtime['price']?>" 
                        data-cinemaid="<?= $showtime['cinemas_id'] ?>"
                        data-movieid="<?= $showtime['movie_id'] ?>"
                        data-roomid="<?= $showtime['room_id'] ?>">
                        <i class="bi bi-pencil-square"></i> Sửa
                    </a>
                    <?php if ($showtime['hide'] == 0): ?>
                        <a href="#"
                        onclick="showDeleteShowtimeConfirm(<?= $showtime['showtime_id'] ?>,<?= $showtime['hide'] ?>)" 
                        class="btn btn-danger btn-sm">
                            <i class="bi bi-eye-slash"></i> Ẩn
                        </a>
                    <?php else: ?>
                        <a href="#"
                        onclick="showDeleteShowtimeConfirm(<?= $showtime['showtime_id'] ?>,<?= $showtime['hide'] ?>)" 
                        class="btn btn-success btn-sm">
                            <i class="bi bi-eye"></i> Hiện
                        </a>
                    <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- FORM EDIT SHOWTIMES -->
    <div id="editShowtimeFormPanel" class="modal-overlay" style="display: none;">
        <div class="modal-content edit-showtime-modal">
            <!-- Chia 2 cột: -->
            <div style="display: flex; gap: 20px;">
            <!-- Cột trái: Form thông tin rạp -->
            <div style="flex: 4;">
                <span class="close-button" onclick="hideEditShowtimeForm()">&times;</span>
                <form id="editShowtimeForm" action="../controler/add_update_showtime.php" method="post">
                    <h2>Quản lý xuất chiếu</h2>
                    <label>Phim:</label>
                    <select id="editShowtimeMovie" name="movie">
                    <option value="">-- Chọn phim --</option> 
                    <?php foreach ($showtimes as $option): ?>
                        <?php if ($option['movie_hide'] == 0): ?>
                            <option value="<?php echo $option['movie_id']; ?>">
                                <?php echo $option['movie_title']; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </select>
                    <label>Rạp:</label>
                    <select id="editShowtimeCinemas" name="cinemas" onchange="getRoomsForCinema()">
                    <option value="">-- Chọn rạp --</option> 
                    <?php foreach ($showtimes as $option): ?>
                        <option value="<?php echo $option['cinemas_id'] ?>"><?php echo $option['cinema_name'];?></option>
                    <?php endforeach; ?>
                    </select>
                    <label>Phòng chiếu:</label>
                    <select id="editShowtimeRooms" name="rooms" onchange="getShowtimeForRoom()">
                    <option value="">-- Chọn phòng --</option> 
                    <!-- Các phòng chiếu sẽ được thêm vào đây sau khi chọn rạp -->
                    </select>
                    <div id="CostAndTime" style="display: none;">
                        <div class="form-row" style="display: flex; gap: 10px;">
                            <div class="form-group" style="flex: 1;">
                                <label>Giờ chiếu: </label>
                                <input type="datetime-local" id="StartTime" name="start">
                            </div>
                            <div class="form-group" style="flex: 1;">
                                <label>Giờ kết thúc:</label>
                                <input type="datetime-local" id="EndTime" name="end">
                            </div>
                            <div class="form-group" style="flex: 1;">
                                <label>Giá:</label>
                                <input type="text" id="Price" name="price">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="editShowtimeId" name="id"> 
                    <input type="hidden" id="editCinemasHidden" name="cinemasid">
                    <input type="hidden" id="editRoomsId" name="roomsid"> 
                    <input type="hidden" id="editMovieHidden" name="movieid"> 
                    <button type="submit" style="margin-top: 10px;">Lưu thay đổi</button>
            </div>

            <!-- Cột phải: Danh sách phim đang chiếu -->
            <div style="flex: 6; display: none;" id="ShowtimeList">
            <h3>Các xuất chiếu hoạt động</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #eee;">
                    <th style="padding: 8px;">STT</th>
                    <th style="padding: 8px;">Tên phim</th>
                    <th style="padding: 8px;">Giờ chiếu</th>
                    <th style="padding: 8px;">Giờ kết thúc</th>
                    <th style="padding: 8px;">Giá vé</th>
                    </tr>
                </thead>    
                <tbody id="roomsShowtimeBody">
                    <!-- Danh sách phòng -->
                </tbody>
                </table>
            </div>
                </form>
            </div>
        </div>
    </div>

    <!-- FORM DELETE MEMEBERSHIP -->
    <div id="deleteShowtimeConfirmPanel" class="modal-overlay" style="display: none;">
        <div class="modal-content delete-modal delete-showtime-modal" style="text-align: center;">
            <span class="close-button" onclick="hideDeleteShowtimeConfirm()">&times;</span>
            <h3 id="titleShowtime">Bạn có chắc muốn ẩn xuất chiếu này không?</h3>
            <form id="deleteShowtimeForm" action="../controler/delete_showtime.php" method="post">
                <input type="hidden" name="id" id="deleteShowtimeId">
                <button type="submit" style="background-color:rgb(24, 181, 63); margin-right: 10px;">Xác nhận</button>
                <button type="button" style="background-color: #e74c3c; margin-right: 10px;" onclick="hideDeleteShowtimeConfirm()">Hủy</button>
            </form>
        </div>
    </div>

</div>
<script src="../../assets/js/admin.js"></script>
</body>
</html>
