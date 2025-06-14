-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 23, 2025 lúc 12:03 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `movie_ticket_booking`
--
CREATE DATABASE IF NOT EXISTS `movie_ticket_booking` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `movie_ticket_booking`;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `showtime_id`, `booking_time`, `total_price`, `link`, `hide`, `order_index`) VALUES
(1, 1, 1, '2025-04-23 12:23:40', 300000.00, 'https://link.example.com', 0, 1),
(2, 2, 2, '2025-04-23 12:23:40', 240000.00, 'https://link.example.com', 0, 2),
(3, 3, 3, '2025-04-23 12:23:40', 220000.00, 'https://link.example.com', 0, 3),
(4, 4, 4, '2025-04-23 12:23:40', 260000.00, 'https://link.example.com', 0, 4),
(5, 5, 5, '2025-04-23 12:23:40', 230000.00, 'https://link.example.com', 0, 5),
(6, 6, 6, '2025-04-23 12:23:40', 280000.00, 'https://link.example.com', 0, 6),
(7, 7, 7, '2025-04-23 12:23:40', 310000.00, 'https://link.example.com', 0, 7),
(8, 8, 8, '2025-04-23 12:23:40', 270000.00, 'https://link.example.com', 0, 8),
(9, 9, 9, '2025-04-23 12:23:40', 250000.00, 'https://link.example.com', 0, 9),
(10, 10, 10, '2025-04-23 12:23:40', 320000.00, 'https://link.example.com', 0, 10),
(16, 13, 1, '2025-05-23 09:52:12', 670000.00, NULL, 0, NULL);

--
-- Đang đổ dữ liệu cho bảng `booking_concessions`
--

INSERT INTO `booking_concessions` (`id`, `booking_id`, `concession_id`, `quantity`, `total_price`, `link`, `hide`, `order_index`, `created_at`) VALUES
(1, 1, 1, 2, 60000.00, 'https://link.example.com', 0, 1, '2025-04-23 12:23:40'),
(2, 2, 2, 3, 60000.00, 'https://link.example.com', 0, 2, '2025-04-23 12:23:40'),
(3, 3, 3, 2, 50000.00, 'https://link.example.com', 0, 3, '2025-04-23 12:23:40'),
(4, 4, 4, 3, 75000.00, 'https://link.example.com', 0, 4, '2025-04-23 12:23:40'),
(5, 5, 5, 1, 10000.00, 'https://link.example.com', 0, 5, '2025-04-23 12:23:40'),
(6, 6, 6, 4, 140000.00, 'https://link.example.com', 0, 6, '2025-04-23 12:23:40'),
(7, 7, 7, 2, 60000.00, 'https://link.example.com', 0, 7, '2025-04-23 12:23:40'),
(8, 8, 8, 3, 90000.00, 'https://link.example.com', 0, 8, '2025-04-23 12:23:40'),
(9, 9, 9, 1, 15000.00, 'https://link.example.com', 0, 9, '2025-04-23 12:23:40'),
(10, 10, 10, 5, 175000.00, 'https://link.example.com', 0, 10, '2025-04-23 12:23:40'),
(24, 16, 5, 1, 10000.00, NULL, 0, NULL, '2025-05-23 09:52:12'),
(25, 16, 6, 1, 35000.00, NULL, 0, NULL, '2025-05-23 09:52:12'),
(26, 16, 7, 1, 25000.00, NULL, 0, NULL, '2025-05-23 09:52:12');

--
-- Đang đổ dữ liệu cho bảng `booking_details`
--

INSERT INTO `booking_details` (`detail_id`, `booking_id`, `seat_id`, `link`, `hide`, `order_index`, `created_at`) VALUES
(3, 3, 3, 'https://link.example.com', 0, 3, '2025-04-23 12:23:40'),
(4, 4, 4, 'https://link.example.com', 0, 4, '2025-04-23 12:23:40'),
(5, 5, 5, 'https://link.example.com', 0, 5, '2025-04-23 12:23:40'),
(6, 6, 6, 'https://link.example.com', 0, 6, '2025-04-23 12:23:40'),
(7, 7, 7, 'https://link.example.com', 0, 7, '2025-04-23 12:23:40'),
(8, 8, 8, 'https://link.example.com', 0, 8, '2025-04-23 12:23:40'),
(9, 9, 9, 'https://link.example.com', 0, 9, '2025-04-23 12:23:40'),
(10, 10, 10, 'https://link.example.com', 0, 10, '2025-04-23 12:23:40'),
(33, 16, 170, NULL, 0, NULL, '2025-05-23 09:52:12'),
(34, 16, 171, NULL, 0, NULL, '2025-05-23 09:52:12'),
(35, 16, 172, NULL, 0, NULL, '2025-05-23 09:52:12');

--
-- Đang đổ dữ liệu cho bảng `cinemas`
--

INSERT INTO `cinemas` (`cinema_id`, `name`, `location`, `phone`, `created_at`, `link`, `hide`, `order_index`) VALUES
(1, 'CineStar', 'TPHCM, Vietnam', '0241234567', '2025-04-23 12:20:54', 'https://link.example.com', 0, 1),
(2, 'Galaxy Cinema', 'Ho Chi Minh City, Vietnam', '0289876543', '2025-04-23 12:20:54', 'https://link.example.com', 0, 2),
(3, 'Lotte Cinema', 'Da Nang, Vietnam', '0236456789', '2025-04-23 12:20:54', 'https://link.example.com', 0, 3),
(4, 'CGV', 'Hanoi, Vietnam', '0243456789', '2025-04-23 12:20:54', 'https://link.example.com', 0, 4),
(5, 'Megastar Cinema', 'Ho Chi Minh City, Vietnam', '0287654321', '2025-04-23 12:20:54', 'https://link.example.com', 0, 5),
(6, 'BHD Star Cineplex', 'Da Nang, Vietnam', '0236123456', '2025-04-23 12:20:54', 'https://link.example.com', 0, 6),
(7, 'Cineworld', 'Hanoi, Vietnam', '0241230000', '2025-04-23 12:20:54', 'https://link.example.com', 0, 7),
(8, 'Galaxy Mega', 'Ho Chi Minh City, Vietnam', '0289988776', '2025-04-23 12:20:54', 'https://link.example.com', 0, 8),
(9, 'CGV Landmark', 'Ho Chi Minh City, Vietnam', '0289988777', '2025-04-23 12:20:54', 'https://link.example.com', 0, 9),
(10, 'Lotte Cinema Bitexco', 'Ho Chi Minh City, Vietnam', '0289977665', '2025-04-23 12:20:54', 'https://link.example.com', 0, 10);

--
-- Đang đổ dữ liệu cho bảng `concessions`
--

INSERT INTO `concessions` (`concession_id`, `name`, `price`, `picture_link`, `link`, `hide`, `order_index`, `created_at`) VALUES
(1, 'Popcorn', 30000.00, 'assets/img/air-fryer-popcorn-9.jpg', 'https://link.example.com', 0, 1, '2025-04-23 12:23:40'),
(2, 'Soda', 20000.00, 'assets/img/soda.jpg', 'https://link.example.com', 0, 2, '2025-04-23 12:23:40'),
(3, 'Nachos', 25000.00, 'assets/img/nachos.webp', 'https://link.example.com', 0, 3, '2025-04-23 12:23:40'),
(4, 'Candy', 15000.00, 'assets/img/candy.jpg', 'https://link.example.com', 0, 4, '2025-04-23 12:23:40'),
(5, 'Water', 10000.00, 'assets/img/frostvictoria.webp', 'https://link.example.com', 0, 5, '2025-04-23 12:23:40'),
(6, 'Ice Cream', 35000.00, 'assets/img/kem.png', 'https://link.example.com', 0, 6, '2025-04-23 12:23:40'),
(7, 'Hot Dog', 25000.00, 'assets/img/HotDog.jpg', 'https://link.example.com', 0, 7, '2025-04-23 12:23:40'),
(8, 'Chocolate', 20000.00, 'assets/img/Feastabke.webp', 'https://link.example.com', 0, 8, '2025-04-23 12:23:40'),
(9, 'Tea', 15000.00, 'assets/img/tea.jpg', 'https://link.example.com', 1, 9, '2025-04-23 12:23:40'),
(10, 'Juice', 18000.00, 'https://link.example.com', 'https://link.example.com', 1, 10, '2025-04-23 12:23:40'),
(11, 'Coca', 20000.00, 'assets/img/coca.jpg', NULL, 1, NULL, '2025-04-24 17:45:00');

--
-- Đang đổ dữ liệu cho bảng `membership_discounts`
--

INSERT INTO `membership_discounts` (`member_type`, `discount_percent`, `content`, `link`, `hide`, `order_index`, `created_at`) VALUES
('None', 0.00, '<ul>\r\n	<li>Tham gia c&aacute;c chương tr&igrave;nh khuyến m&atilde;i th&ocirc;ng thường</li>\r\n	<li>Nhận th&ocirc;ng b&aacute;o về sản phẩm mới v&agrave; ưu đ&atilde;i qua email</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n', 'https://link.example.com', 0, 1, '2025-04-23 12:20:54'),
('Silver', 10.00, '<ul>\r\n	<li>Giảm gi&aacute; 10% tr&ecirc;n tổng h&oacute;a đơn cho mỗi lần mua h&agrave;ng</li>\r\n	<li>Ưu ti&ecirc;n tư vấn v&agrave; hỗ trợ kỹ thuật</li>\r\n	<li>Qu&agrave; tặng sinh nhật đặc biệt</li>\r\n	<li>Tất cả quyền lợi của th&agrave;nh vi&ecirc;n thường</li>\r\n</ul>\r\n', 'https://link.example.com', 0, 2, '2025-04-23 12:20:54'),
('Gold', 15.00, '<ul>\r\n	<li>Giảm gi&aacute; 15% tr&ecirc;n tổng h&oacute;a đơn cho mỗi lần mua h&agrave;ng</li>\r\n	<li>Miễn ph&iacute; vận chuyển cho mọi đơn h&agrave;ng</li>\r\n	<li>Tham gia c&aacute;c sự kiện đặc biệt d&agrave;nh ri&ecirc;ng cho th&agrave;nh vi&ecirc;n V&agrave;ng</li>\r\n	<li>Đổi điểm thưởng lấy sản phẩm với tỷ lệ ưu đ&atilde;i</li>\r\n	<li>Tất cả quyền lợi của th&agrave;nh vi&ecirc;n Bạc</li>\r\n</ul>\r\n', 'https://link.example.com', 0, 3, '2025-04-23 12:20:54'),
('Diamond', 20.00, '<ul>\r\n	<li>Giảm gi&aacute; 20% tr&ecirc;n tổng h&oacute;a đơn cho mỗi lần mua h&agrave;ng</li>\r\n	<li>Dịch vụ chăm s&oacute;c kh&aacute;ch h&agrave;ng VIP 24/7</li>\r\n	<li>Qu&agrave; tặng đặc biệt h&agrave;ng qu&yacute;</li>\r\n	<li>Ưu ti&ecirc;n trải nghiệm sản phẩm mới trước khi ra mắt</li>\r\n	<li>Tham gia c&aacute;c sự kiện độc quyền</li>\r\n	<li>Tất cả quyền lợi của th&agrave;nh vi&ecirc;n V&agrave;ng</li>\r\n</ul>\r\n', 'https://link.example.com', 0, 4, '2025-04-23 12:20:54');

--
-- Đang đổ dữ liệu cho bảng `movies`
--

INSERT INTO `movies` (`movie_id`, `title`, `genre`, `duration`, `director`, `cast`, `language`, `release_date`, `description`, `poster_url`, `trailer_url`, `banner_url`, `created_at`, `link`, `hide`, `order_index`) VALUES
(1, 'Avengers: Endgame', 'Action', 181, 'Anthony Russo', 'Robert Downey Jr., Chris Hemsworth', 'English', '2019-04-26', 'Epic conclusion of the Avengers saga', 'assets/img/aendgame.jpg', 'https://trailer.example.com', 'https://banner.example.com', '2025-04-23 12:20:54', 'https://link.example.com', 0, 1),
(2, 'The Lion King', 'Animation', 118, 'Jon Favreau', 'Donald Glover, Beyoncé', 'English', '2019-07-19', 'A young lion prince overcomes adversity to reclaim his throne', 'assets/img/lionking.jpg', 'https://trailer.example.com', 'https://banner.example.com', '2025-04-23 12:20:54', 'https://link.example.com', 0, 2),
(3, 'Frozen 2', 'Animation', 103, 'Chris Buck', 'Idina Menzel, Kristen Bell', 'English', '2019-11-22', 'Elsa and Anna’s journey to discover the origins of Elsa’s magical powers', 'assets/img/frozen2.jpg', 'https://trailer.example.com', 'https://banner.example.com', '2025-04-23 12:20:54', 'https://link.example.com', 1, 3),
(4, 'Joker', 'Drama', 122, 'Todd Phillips', 'Joaquin Phoenix, Robert De Niro', 'English', '2019-10-04', 'A gritty character study of Arthur Fleck, a man disregarded by society', 'assets/img/joker.jpg', 'https://trailer.example.com', 'https://banner.example.com', '2025-04-23 12:20:54', 'https://link.example.com', 0, 4),
(5, 'Toy Story 4', 'Animation', 100, 'Josh Cooley', 'Tom Hanks, Tim Allen', 'English', '2019-06-21', 'Woody, Buzz, and the gang set out on an adventure with a new friend, Forky', 'assets/img/toystory4.jpg', 'https://trailer.example.com', 'https://banner.example.com', '2025-04-23 12:20:54', 'https://link.example.com', 0, 5),
(6, 'The Matrix 4', 'Action', 148, 'Lana Wachowski', 'Keanu Reeves, Carrie-Anne Moss', 'English', '2021-12-22', 'Neo and Trinity’s return to a new Matrix', 'assets/img/the-matrix4.jpg', 'https://trailer.example.com', 'https://banner.example.com', '2025-04-23 12:20:54', 'https://link.example.com', 1, 6),
(7, 'Spider-Man: No Way Home', 'Action', 148, 'Jon Watts', 'Tom Holland, Zendaya', 'English', '2021-12-17', 'Peter Parker deals with the fallout from the events of Far From Home', 'assets/img/spiderman-nowayhome.jpg', 'https://trailer.example.com', 'https://banner.example.com', '2025-04-23 12:20:54', 'https://link.example.com', 0, 7),
(8, 'The Godfather', 'Crime', 175, 'Francis Ford Coppola', 'Marlon Brando, Al Pacino', 'English', '1972-03-24', 'The epic story of a crime family in New York', 'assets/img/godfather.jpg', 'https://trailer.example.com', 'https://banner.example.com', '2025-04-23 12:20:54', 'https://link.example.com', 0, 8),
(9, 'Titanic', 'Romance', 195, 'James Cameron', 'Leonardo DiCaprio, Kate Winslet', 'English', '1997-12-19', 'A young couple fall in love aboard the ill-fated ship Titanic', 'assets/img/titanic.jpg', 'https://trailer.example.com', 'https://banner.example.com', '2025-04-23 12:20:54', 'https://link.example.com', 0, 9),
(10, 'Inception', 'Sci-Fi', 148, 'Christopher Nolan', 'Leonardo DiCaprio, Joseph Gordon-Levitt', 'English', '2010-07-16', 'A thief who steals corporate secrets is given the chance to erase his criminal record', 'assets/img/inception.jpg', 'https://www.youtube.com/watch?v=y2TCjYiTGIo', 'https://banner.example.com', '2025-04-23 12:20:54', 'https://link.example.com', 0, 10),
(11, 'Mickey 17', 'Khoa học viễn tưởng, Phiêu lưu', 118, 'Bong Joon-ho', 'Robert Pattinson, Mark Ruffalo, Toni Collette', 'English', '2025-04-18', 'Mickey 17 là một bộ phim khoa học viễn tưởng do Bong Joon-ho đạo diễn, kể về một nhân vật có khả năng hồi sinh không ngừng, thực hiện một nhiệm vụ du hành ngoài vũ trụ đầy nguy hiểm. Phim hứa hẹn mang đến những trải nghiệm điện ảnh độc đáo và hấp dẫn .', 'assets/img/Mickey17.jpg', 'https://www.youtube.com/watch?v=kFT4D0o9IZ4', 'assets/img/Mickey17-banner.jpg', '2025-04-23 18:21:40', NULL, 0, NULL),
(12, 'Chiếm đoạt', 'Chính Kịch, Huyền Thoại', 190, 'Thắng Vũ', 'Miu Lê, KaZik', 'Tiếng Việt', '2023-11-24', 'Chuyện tình giữa My và Hoàng không liên quan nhiều đến tổng thể kịch bản. Ban đầu, My lợi dụng Hoàng như một quân cờ để giúp công việc của Sơn được thuận lợi. Về sau, phát hiện kế hoạch trả thù của My, anh vẫn đem lòng yêu cô, muốn sống chung dưới một mái nhà. Đạo diễn dàn dựng nhiều khoảnh khắc lãng mạn giữa My và Hoàng để dung hòa, giúp tác phẩm bớt màu u tối. Song, cách sắp xếp chưa mượt mà khiến tình tiết này lệch ra khỏi tổng thể phim.', 'assets/img/Chiemdoat.PNG', 'https://www.youtube.com/watch?v=vFJpPawJWjw', 'assets/img/chiemdoat banner.PNG', '2025-04-26 15:25:45', NULL, 0, NULL),
(13, 'MA DA', 'Kinh thánh', 95, 'Nguyễn Hữu Hoàng', 'Việt Hương, đứa bé con gái giả tưởng, đứa bé con gái không phải người việt, thằng béo oscar 10/10', 'Tiếng Việt', '2024-08-16', '<p><strong>&quot;Ma da&quot;</strong> kể về cuộc sống của b&agrave; Lệ (do Việt Hương thủ vai), một phụ nữ l&agrave;m nghề vớt x&aacute;c tr&ecirc;n s&ocirc;ng. C&ocirc;ng việc của b&agrave; l&agrave; đưa những người đ&atilde; mất trở về với gia đ&igrave;nh họ, gi&uacute;p họ c&oacute; một nơi an nghỉ cuối c&ugrave;ng. Một ng&agrave;y nọ, b&agrave; Lệ vớt được x&aacute;c của một thanh ni&ecirc;n b&iacute; ẩn. Từ đ&oacute;, b&agrave; bắt đầu gặp phải nhiều hiện tượng kỳ lạ v&agrave; những dấu hiệu tai ương.</p>\r\n', 'assets/img/madaposter.jpg', 'https://youtu.be/vC-KNlLNIso?si=DrJkPJXnR3demkmQ', 'assets/img/mada.jpg', '2025-04-29 16:25:28', NULL, 0, NULL);

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `user_id`, `price`, `payment_method`, `transaction_code`, `payment_status`, `payment_time`, `link`, `hide`, `order_index`) VALUES
(1, 1, 1, 360000.00, 'Credit_card', '', 'Success', '2025-04-23 12:23:40', 'https://link.example.com', 0, 1),
(2, 2, 2, 300000.00, 'Paypal', '', 'Pending', '2025-04-23 12:23:40', 'https://link.example.com', 0, 2),
(3, 3, 3, 330000.00, 'Credit_card', '', 'Success', '2025-04-23 12:23:40', 'https://link.example.com', 0, 3),
(4, 4, 4, 360000.00, 'Paypal', '', 'Failed', '2025-04-23 12:23:40', 'https://link.example.com', 0, 4),
(5, 5, 5, 320000.00, 'Credit_card', '', 'Pending', '2025-04-23 12:23:40', 'https://link.example.com', 0, 5),
(6, 6, 6, 380000.00, 'Credit_card', '', 'Success', '2025-04-23 12:23:40', 'https://link.example.com', 0, 6),
(7, 7, 7, 400000.00, 'Paypal', '', 'Success', '2025-04-23 12:23:40', 'https://link.example.com', 0, 7),
(8, 8, 8, 370000.00, 'Credit_card', '', 'Failed', '2025-04-23 12:23:40', 'https://link.example.com', 0, 8),
(9, 9, 9, 380000.00, 'Paypal', '', 'Success', '2025-04-23 12:23:40', 'https://link.example.com', 0, 9),
(10, 10, 10, 420000.00, 'Credit_card', '', 'Pending', '2025-04-23 12:23:40', 'https://link.example.com', 0, 10),
(14, 16, 13, 670000.00, '', 'CS708929870', 'Success', '2025-05-23 09:52:12', NULL, 0, NULL);

--
-- Đang đổ dữ liệu cho bảng `promotions`
--

INSERT INTO `promotions` (`promotion_id`, `title`, `content`, `banner_url`, `created_at`, `link`, `hide`, `order_index`) VALUES
(1, 'Giảm giá mùa hè 2025', '<p>Tận hưởng m&ugrave;a h&egrave; rực rỡ với ưu đ&atilde;i giảm gi&aacute; 30% cho mọi suất chiếu từ 1/6 đến 30/6.</p>\r\n', '/LTW/assets/img/sales-2.webp', '2025-05-05 15:41:28', NULL, 0, 1),
(2, 'Combo bắp nước siêu rẻ', '<p>Chỉ với 49K, nhận ngay 1 bắp + 1 nước. &Aacute;p dụng tại tất cả c&aacute;c rạp to&agrave;n quốc.</p>\r\n', '/LTW/assets/img/sales-2.webp', '2025-05-05 15:41:28', NULL, 0, 2),
(3, 'Ngày hội thành viên', '<p>Th&agrave;nh vi&ecirc;n Silver trở l&ecirc;n được giảm 15% mọi h&oacute;a đơn trong ng&agrave;y 10 h&agrave;ng th&aacute;ng.</p>\r\n', '/LTW/assets/img/sales-3.webp', '2025-05-05 15:41:28', NULL, 0, 3),
(4, 'Ưu đãi học sinh - sinh viên', '<p>Xuất tr&igrave;nh thẻ HSSV để được giảm 25% v&eacute; xem phim từ thứ 2 đến thứ 5.</p>\r\n', '/LTW/assets/img/Loreal_advertisement-examples-1024x616.webp', '2025-05-05 15:41:28', NULL, 0, 4),
(5, 'Khuyến mãi cuối tuần này', '<p><strong>Mua v&eacute; thứ 7</strong>, chủ nhật nhận ngay 1 combo bắp nước miễn ph&iacute;.</p>\r\n', '/LTW/assets/img/sales-1.webp', '2025-05-05 15:41:28', NULL, 0, 5),
(6, 'KM1', '<p><strong><s><em>APDAKADSKAJSDIASD</em></s></strong></p>\r\n', '/LTW/assets/img/Loreal_advertisement-examples-1024x616.webp', '2025-05-05 17:06:38', NULL, 1, NULL),
(7, '123', '<p>123</p>\r\n', '/LTW/assets/img/sales-2.webp', '2025-05-20 09:00:41', NULL, 1, NULL),
(8, 's', '<p><s><em>dasd</em></s></p>\r\n', '/LTW/assets/img/sales-3.webp', '2025-05-20 09:01:25', NULL, 1, NULL);

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`room_id`, `cinema_id`, `name`, `link`, `hide`, `order_index`, `created_at`) VALUES
(1, 1, 'Rạp 1', 'https://link.example.com', 0, 1, '2025-04-23 12:20:54'),
(2, 2, 'Room 2', 'https://link.example.com', 0, 1, '2025-04-23 12:20:54'),
(3, 3, 'Room 3', 'https://link.example.com', 0, 1, '2025-04-23 12:20:54'),
(4, 1, 'Rạp 2', 'https://link.example.com', 0, 1, '2025-04-23 12:20:54'),
(5, 2, 'Room 2', 'https://link.example.com', 0, 2, '2025-04-23 12:20:54'),
(6, 3, 'Room 3', 'https://link.example.com', 0, 3, '2025-04-23 12:20:54'),
(7, 4, 'Room 4', 'https://link.example.com', 0, 4, '2025-04-23 12:20:54'),
(8, 5, 'Room 5', 'https://link.example.com', 0, 5, '2025-04-23 12:20:54'),
(9, 6, 'Room 6', 'https://link.example.com', 0, 6, '2025-04-23 12:20:54'),
(10, 7, 'Room 7', 'https://link.example.com', 0, 7, '2025-04-23 12:20:54'),
(11, 8, 'Room 8', 'https://link.example.com', 0, 8, '2025-04-23 12:20:54'),
(12, 9, 'Room 9', 'https://link.example.com', 0, 9, '2025-04-23 12:20:54'),
(13, 10, 'Room 10', 'https://link.example.com', 0, 10, '2025-04-23 12:20:54');

--
-- Đang đổ dữ liệu cho bảng `seats`
--

INSERT INTO `seats` (`seat_id`, `room_id`, `seat_number`, `seat_type`, `extra_price`, `status`, `link`, `hide`, `order_index`, `created_at`) VALUES
(3, 2, 'B1', 'Couple', 100000.00, 'Available', 'https://link.example.com', 0, 3, '2025-04-23 12:23:00'),
(4, 3, 'C1', 'Standard', 0.00, 'Available', 'https://link.example.com', 0, 4, '2025-04-23 12:23:00'),
(5, 4, 'A1', 'Vip', 50000.00, 'Available', 'https://link.example.com', 0, 5, '2025-04-23 12:23:00'),
(6, 5, 'E1', 'Couple', 100000.00, 'Available', 'https://link.example.com', 0, 6, '2025-04-23 12:23:00'),
(7, 6, 'F1', 'Standard', 0.00, 'Available', 'https://link.example.com', 0, 7, '2025-04-23 12:23:00'),
(8, 7, 'G1', 'Vip', 50000.00, 'Available', 'https://link.example.com', 0, 8, '2025-04-23 12:23:00'),
(9, 8, 'H1', 'Couple', 100000.00, 'Available', 'https://link.example.com', 0, 9, '2025-04-23 12:23:00'),
(10, 9, 'I1', 'Standard', 0.00, 'Available', 'https://link.example.com', 0, 10, '2025-04-23 12:23:00'),
(11, 1, 'A1', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(12, 1, 'A2', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(13, 1, 'A3', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(14, 1, 'A4', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(15, 1, 'A5', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(16, 1, 'A6', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(17, 1, 'A7', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(18, 1, 'A8', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(19, 1, 'A9', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(20, 1, 'A10', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(21, 1, 'A11', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(22, 1, 'A12', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(23, 1, 'A13', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(24, 1, 'A14', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(25, 1, 'B1', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(26, 1, 'B2', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(27, 1, 'B3', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(28, 1, 'B4', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(29, 1, 'B5', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(30, 1, 'B6', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(31, 1, 'B7', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(32, 1, 'B8', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(33, 1, 'B9', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(34, 1, 'B10', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(35, 1, 'B11', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(36, 1, 'B12', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(37, 1, 'B13', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(38, 1, 'B14', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(39, 1, 'C1', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(40, 1, 'C2', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(41, 1, 'C3', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(42, 1, 'C4', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(43, 1, 'C5', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(44, 1, 'C6', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(45, 1, 'C7', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(46, 1, 'C8', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(47, 1, 'C9', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(48, 1, 'C10', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(49, 1, 'C11', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(50, 1, 'C12', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(51, 1, 'C13', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(52, 1, 'C14', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(53, 1, 'D1', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(54, 1, 'D2', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(55, 1, 'D3', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(56, 1, 'D4', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(57, 1, 'D5', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(58, 1, 'D6', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(59, 1, 'D7', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(60, 1, 'D8', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(61, 1, 'D9', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(62, 1, 'D10', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(63, 1, 'D11', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(64, 1, 'D12', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(65, 1, 'D13', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(66, 1, 'D14', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(67, 1, 'E1', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(68, 1, 'E2', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(69, 1, 'E3', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(70, 1, 'E4', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(71, 1, 'E5', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(72, 1, 'E6', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(73, 1, 'E7', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(74, 1, 'E8', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(75, 1, 'E9', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(76, 1, 'E10', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(77, 1, 'E11', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(78, 1, 'E12', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(79, 1, 'E13', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(80, 1, 'E14', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(81, 1, 'F1', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(82, 1, 'F2', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(83, 1, 'F3', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(84, 1, 'F4', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(85, 1, 'F5', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(86, 1, 'F6', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(87, 1, 'F7', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(88, 1, 'F8', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(89, 1, 'F9', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(90, 1, 'F10', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(91, 1, 'F11', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(92, 1, 'F12', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(93, 1, 'F13', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(94, 1, 'F14', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(95, 1, 'G1', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(96, 1, 'G2', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(97, 1, 'G3', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(98, 1, 'G4', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(99, 1, 'G5', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(100, 1, 'G6', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(101, 1, 'G7', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(102, 1, 'G8', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(103, 1, 'G9', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(104, 1, 'G10', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(105, 1, 'G11', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(106, 1, 'G12', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(107, 1, 'G13', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(108, 1, 'G14', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(109, 1, 'H1', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(110, 1, 'H2', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(111, 1, 'H3', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(112, 1, 'H4', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(113, 1, 'H5', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(114, 1, 'H6', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(115, 1, 'H7', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(116, 1, 'H8', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(117, 1, 'H9', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(118, 1, 'H10', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(119, 1, 'H11', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(120, 1, 'H12', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(121, 1, 'H13', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(122, 1, 'H14', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(123, 1, 'I1', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(124, 1, 'I2', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(125, 1, 'I3', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(126, 1, 'I4', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(127, 1, 'I5', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(128, 1, 'I6', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(129, 1, 'I7', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(130, 1, 'I8', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(131, 1, 'I9', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(132, 1, 'I10', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(133, 1, 'I11', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(134, 1, 'I12', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(135, 1, 'I13', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(136, 1, 'I14', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(137, 1, 'J1', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(138, 1, 'J2', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(139, 1, 'J3', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(140, 1, 'J4', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(141, 1, 'J5', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(142, 1, 'J6', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(143, 1, 'J7', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(144, 1, 'J8', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(145, 1, 'J9', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(146, 1, 'J10', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(147, 1, 'J11', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(148, 1, 'J12', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(149, 1, 'J13', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(150, 1, 'J14', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(151, 1, 'K1', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(152, 1, 'K2', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(153, 1, 'K3', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(154, 1, 'K4', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(155, 1, 'K5', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(156, 1, 'K6', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(157, 1, 'K7', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(158, 1, 'K8', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(159, 1, 'K9', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(160, 1, 'K10', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(161, 1, 'K11', 'Vip', 20000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(162, 1, 'K12', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(163, 1, 'K13', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(164, 1, 'K14', 'Standard', 0.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(165, 1, 'L1', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(166, 1, 'L2', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(167, 1, 'L3', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(168, 1, 'L4', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(169, 1, 'L5', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(170, 1, 'L6', 'Couple', 50000.00, 'Booked', NULL, 0, NULL, '2025-04-26 10:50:34'),
(171, 1, 'L7', 'Couple', 50000.00, 'Booked', NULL, 0, NULL, '2025-04-26 10:50:34'),
(172, 1, 'L8', 'Couple', 50000.00, 'Booked', NULL, 0, NULL, '2025-04-26 10:50:34'),
(173, 1, 'L9', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(174, 1, 'L10', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(175, 1, 'L11', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(176, 1, 'L12', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(177, 1, 'L13', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(178, 1, 'L14', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(179, 1, 'M1', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(180, 1, 'M2', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(181, 1, 'M3', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(182, 1, 'M4', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(183, 1, 'M5', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(184, 1, 'M6', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(185, 1, 'M7', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(186, 1, 'M8', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(187, 1, 'M9', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(188, 1, 'M10', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(189, 1, 'M11', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(190, 1, 'M12', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(191, 1, 'M13', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(192, 1, 'M14', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(193, 1, 'N1', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(194, 1, 'N2', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(195, 1, 'N3', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(196, 1, 'N4', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(197, 1, 'N5', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(198, 1, 'N6', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(199, 1, 'N7', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(200, 1, 'N8', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(201, 1, 'N9', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(202, 1, 'N10', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(203, 1, 'N11', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(204, 1, 'N12', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(205, 1, 'N13', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34'),
(206, 1, 'N14', 'Couple', 50000.00, 'Available', NULL, 0, NULL, '2025-04-26 10:50:34');

--
-- Đang đổ dữ liệu cho bảng `showtimes`
--

INSERT INTO `showtimes` (`showtime_id`, `movie_id`, `room_id`, `start_time`, `end_time`, `price`, `link`, `hide`, `order_index`, `created_at`) VALUES
(1, 1, 1, '2025-06-30 10:00:00', '2025-06-30 13:00:00', 150000.00, 'https://link.example.com', 0, 1, '2025-04-23 12:23:00'),
(2, 2, 2, '2025-06-30 14:00:00', '2025-06-30 17:00:00', 120000.00, 'https://link.example.com', 0, 2, '2025-04-23 12:23:00'),
(3, 3, 3, '2025-06-30 10:30:00', '2025-06-30 15:00:00', 100000.00, 'https://link.example.com', 0, 3, '2025-04-23 12:23:00'),
(4, 4, 4, '2025-06-30 15:00:00', '2025-06-30 18:00:00', 130000.00, 'https://link.example.com', 0, 4, '2025-04-23 12:23:00'),
(5, 5, 5, '2025-06-30 11:00:00', '2025-06-30 14:00:00', 110000.00, 'https://link.example.com', 0, 5, '2025-04-23 12:23:00'),
(6, 6, 3, '2025-06-30 14:30:00', '2025-06-30 18:00:00', 200000.00, 'https://link.example.com', 0, 6, '2025-04-23 12:23:00'),
(7, 7, 7, '2025-06-30 16:00:00', '2025-06-30 20:00:00', 150000.00, 'https://link.example.com', 0, 7, '2025-04-23 12:23:00'),
(8, 8, 8, '2025-06-30 18:30:00', '2025-06-30 21:00:00', 120000.00, 'https://link.example.com', 0, 8, '2025-04-23 12:23:00'),
(9, 9, 9, '2025-06-30 10:00:00', '2025-06-30 13:00:00', 110000.00, 'https://link.example.com', 0, 9, '2025-04-23 12:23:00'),
(10, 10, 10, '2025-06-30 13:00:00', '2025-06-30 17:00:00', 150000.00, 'https://link.example.com', 0, 10, '2025-04-23 12:23:00'),
(29, 8, 7, '2025-06-30 21:30:00', '2025-06-30 21:30:00', 30000.00, NULL, 0, NULL, '2025-04-30 14:30:12'),
(30, 8, 1, '2025-06-30 16:46:00', '2025-06-30 20:00:00', 150000.00, NULL, 0, NULL, '2025-05-06 15:16:03'),
(31, 1, 1, '2025-06-30 18:00:00', '2025-06-30 20:00:00', 150000.00, NULL, 0, NULL, '2025-05-23 09:49:49');

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `phone`, `birthday`, `role`, `member`, `created_at`, `link`, `hide`, `order_index`) VALUES
(1, 'Nguyen Thi Mai', 'mai@example.com', '$2y$10$QIIRXoTcM4bPf.gf9zfQEuVsnH./1VaB3gRvoE195wsqDP/6cmVRa', '0123456789', '1990-05-20', 'Customer', 'Gold', '2025-04-23 12:20:54', 'https://link.example.com', 0, 1),
(2, 'Tran Minh Tu', 'tu@example.com', '$2y$10$TWWviHalgk1her8DJa9cq.gTeeWezOWtifBK4RzsUyh7LAwqCQLTC', '0987654321', '1985-08-15', 'Admin', 'Silver', '2025-04-23 12:20:54', 'https://link.example.com', 0, 2),
(3, 'Le Thi Lan', 'lan@example.com', '$2y$10$LXi.46cdyKkFSOg52ZBcrev..p.IdvvFVETUepLeSlMRM1arN0vwG', '0912345678', '1988-01-20', 'Customer', 'Silver', '2025-04-23 12:20:54', 'https://link.example.com', 0, 3),
(4, 'Hoang Minh Hieu', 'hieu@example.com', '$2y$10$SLCvX3D3Ad3wdkj7vW8iPeJU0qJSVIKMELfMxo1ErcgdHHr9Pnydi', '0945678901', '1992-10-05', 'Customer', 'Gold', '2025-04-23 12:20:54', 'https://link.example.com', 0, 4),
(5, 'Nguyen Hoang Nam', 'nam@example.com', '$2y$10$JQNWSLRgLXJ8auHaFZgoAuV1stgpS8VDy8LrvpAC0U1.s/UrqwlFy', '09123456782', '1994-02-11', 'Admin', 'None', '2025-04-23 12:20:54', 'https://link.example.com', 0, 5),
(6, 'Pham Minh Hoang', 'boty1402@gmail.com', '$2y$10$2H00xy1AexD9dSG5cpOabekqF5bFzf7OZ65Qj0gUYl1ls2EalNBvi', '0971234567', '1991-06-30', 'Customer', 'Diamond', '2025-04-23 12:20:54', 'https://link.example.com', 0, 6),
(7, 'Tran Thi Thanh', 'thanh@example.com', '$2y$10$K8lMnZC7F.4rNEGhshXIu.aN9RngQoVCKtJQrNFX55.UN65/yIKUW', '0903456789', '1993-03-25', 'Customer', 'Silver', '2025-04-23 12:20:54', 'https://link.example.com', 0, 7),
(8, 'Le Thi Mai', 'mai2@example.com', '$2y$10$hQiqcoVKxeP2jJvy2o2DiOOyS9LEk1w68/wqTWINmNAMkp508I8MO', '0967654321', '1995-11-15', 'Customer', 'Gold', '2025-04-23 12:20:54', 'https://link.example.com', 0, 8),
(9, 'Nguyen Bao Han', 'han@example.com', '$2y$10$UyynL5cbCpw9vjMK9Lukw.i3dsi7e9D8Mnj.h3/lAWWKY/yBG4S9e', '0982345678', '1990-07-22', 'Customer', 'Gold', '2025-04-23 12:20:54', 'https://link.example.com', 0, 9),
(10, 'Phan Thi Lan', 'lan2@example.com', '$2y$10$grmByn5a6Mpe2/tOoTOT9ObqiAPv2AFELI69C50kQh867vLJsOase', '0934345678', '1987-12-10', 'Customer', 'None', '2025-04-23 12:20:54', 'https://link.example.com', 1, 10),
(13, 'Duong Hoang', 'hd34227@gmail.com', '$2y$10$pA5OuBgyQWcUa0EtYHN1l.pgO4ek9Tf8z2BQP/DkczzHVk2qwWTvi', '0928051366', '2025-04-07', 'Customer', 'Diamond', '2025-04-24 13:52:20', NULL, 0, NULL),
(15, 'ADMIN', 'ADMIN@gmail.com', '$2y$10$FuTrTxDRLbrPRmSJ/Cdbd.YZmgaWfj6iZmeNuTQlub3xUyG0n3wz6', '0', '2025-04-01', 'Admin', 'Diamond', '2025-04-24 14:03:36', NULL, 0, NULL),
(16, 'Hoàng', 'kophailamdau@gmail.com', '$2y$10$7zpErqUIhZ4q3JcBcw4FoepPL2twdP7h35r8j1vZjjioy9VuO8IpW', '0928051332', '2025-05-05', 'Customer', 'None', '2025-05-19 10:45:11', NULL, 0, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
