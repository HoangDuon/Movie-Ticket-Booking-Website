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
            transition: all 0.3s;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
            cursor: pointer;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
        }

        .content {
            margin-top: 50px;
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .content.full {
            margin-left: 70px;
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
    <a class="menu-item" data-page="users"><i class="bi bi-people"></i> Quản lý người dùng</a>
    <a class="menu-item" data-page="movies"><i class="bi bi-film"></i> Quản lý phim</a>
    <a class="menu-item" data-page="comments"><i class="bi bi-chat-dots"></i> Quản lý bình luận</a>
</div>

<div class="content" id="content">
    <div id="main-content">
        <h2>Dashboard</h2>
        <p>Chào mừng bạn đến với hệ thống quản lý.</p>
    </div>
</div>

<?php
include "../controler/user_services.php";

$service = new user_services();
$users = $service->ShowUser();
?>

<script>
    const pages = {
        dashboard: `<h2>Dashboard</h2><p>Chào mừng bạn đến với hệ thống quản lý.</p>`,
        users: `
            <h2>Quản lý người dùng</h2>
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
        `,
        movies: `<h2>Quản lý phim</h2><p>Danh sách phim đang cập nhật...</p>`,
        comments: `<h2>Quản lý bình luận</h2><p>Danh sách bình luận từ người dùng.</p>`
    };

    document.querySelectorAll(".menu-item").forEach(item => {
        item.addEventListener("click", function() {
            document.querySelectorAll(".menu-item").forEach(i => i.classList.remove("active"));
            this.classList.add("active");

            const page = this.getAttribute("data-page");
            document.getElementById("main-content").innerHTML = pages[page];
        });
    });
</script>

</body>
</html>
