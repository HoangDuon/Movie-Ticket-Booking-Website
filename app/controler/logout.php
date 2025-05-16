<?php
session_start();
session_unset();
session_destroy();

// Chuyển hướng về trang đăng nhập (hoặc homepage nếu bạn muốn)
header("Location: http://localhost/LTW/index.php?page=login");
exit();
