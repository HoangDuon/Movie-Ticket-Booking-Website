-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 24, 2025 lúc 07:47 PM
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

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `showtime_id` int(11) NOT NULL,
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Paid','Cancelled') DEFAULT 'Pending',
  `total_price` decimal(10,2) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `order_index` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `showtime_id`, `booking_time`, `status`, `total_price`, `link`, `hide`, `order_index`) VALUES
(1, 1, 1, '2025-04-23 12:23:40', 'Pending', 300000.00, 'https://link.example.com', 0, 1),
(2, 2, 2, '2025-04-23 12:23:40', 'Pending', 240000.00, 'https://link.example.com', 0, 2),
(3, 3, 3, '2025-04-23 12:23:40', 'Pending', 220000.00, 'https://link.example.com', 0, 3),
(4, 4, 4, '2025-04-23 12:23:40', 'Pending', 260000.00, 'https://link.example.com', 0, 4),
(5, 5, 5, '2025-04-23 12:23:40', 'Pending', 230000.00, 'https://link.example.com', 0, 5),
(6, 6, 6, '2025-04-23 12:23:40', 'Pending', 280000.00, 'https://link.example.com', 0, 6),
(7, 7, 7, '2025-04-23 12:23:40', 'Pending', 310000.00, 'https://link.example.com', 0, 7),
(8, 8, 8, '2025-04-23 12:23:40', 'Pending', 270000.00, 'https://link.example.com', 0, 8),
(9, 9, 9, '2025-04-23 12:23:40', 'Pending', 250000.00, 'https://link.example.com', 0, 9),
(10, 10, 10, '2025-04-23 12:23:40', 'Pending', 320000.00, 'https://link.example.com', 0, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_concessions`
--

CREATE TABLE `booking_concessions` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `concession_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL CHECK (`quantity` > 0),
  `total_price` decimal(10,2) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `order_index` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(10, 10, 10, 5, 175000.00, 'https://link.example.com', 0, 10, '2025-04-23 12:23:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_details`
--

CREATE TABLE `booking_details` (
  `detail_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `order_index` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_details`
--

INSERT INTO `booking_details` (`detail_id`, `booking_id`, `seat_id`, `price`, `link`, `hide`, `order_index`, `created_at`) VALUES
(1, 1, 1, 150000.00, 'https://link.example.com', 0, 1, '2025-04-23 12:23:40'),
(2, 2, 2, 220000.00, 'https://link.example.com', 0, 2, '2025-04-23 12:23:40'),
(3, 3, 3, 200000.00, 'https://link.example.com', 0, 3, '2025-04-23 12:23:40'),
(4, 4, 4, 240000.00, 'https://link.example.com', 0, 4, '2025-04-23 12:23:40'),
(5, 5, 5, 210000.00, 'https://link.example.com', 0, 5, '2025-04-23 12:23:40'),
(6, 6, 6, 270000.00, 'https://link.example.com', 0, 6, '2025-04-23 12:23:40'),
(7, 7, 7, 300000.00, 'https://link.example.com', 0, 7, '2025-04-23 12:23:40'),
(8, 8, 8, 260000.00, 'https://link.example.com', 0, 8, '2025-04-23 12:23:40'),
(9, 9, 9, 240000.00, 'https://link.example.com', 0, 9, '2025-04-23 12:23:40'),
(10, 10, 10, 310000.00, 'https://link.example.com', 0, 10, '2025-04-23 12:23:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cinemas`
--

CREATE TABLE `cinemas` (
  `cinema_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `link` varchar(255) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `order_index` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cinemas`
--

INSERT INTO `cinemas` (`cinema_id`, `name`, `location`, `phone`, `created_at`, `link`, `hide`, `order_index`) VALUES
(1, 'Cineplex 1', 'Hanoi, Vietnam', '0241234567', '2025-04-23 12:20:54', 'https://link.example.com', 0, 1),
(2, 'Galaxy Cinema', 'Ho Chi Minh City, Vietnam', '0289876543', '2025-04-23 12:20:54', 'https://link.example.com', 0, 2),
(3, 'Lotte Cinema', 'Da Nang, Vietnam', '0236456789', '2025-04-23 12:20:54', 'https://link.example.com', 0, 3),
(4, 'CGV', 'Hanoi, Vietnam', '0243456789', '2025-04-23 12:20:54', 'https://link.example.com', 0, 4),
(5, 'Megastar Cinema', 'Ho Chi Minh City, Vietnam', '0287654321', '2025-04-23 12:20:54', 'https://link.example.com', 0, 5),
(6, 'BHD Star Cineplex', 'Da Nang, Vietnam', '0236123456', '2025-04-23 12:20:54', 'https://link.example.com', 0, 6),
(7, 'Cineworld', 'Hanoi, Vietnam', '0241230000', '2025-04-23 12:20:54', 'https://link.example.com', 0, 7),
(8, 'Galaxy Mega', 'Ho Chi Minh City, Vietnam', '0289988776', '2025-04-23 12:20:54', 'https://link.example.com', 0, 8),
(9, 'CGV Landmark', 'Ho Chi Minh City, Vietnam', '0289988777', '2025-04-23 12:20:54', 'https://link.example.com', 0, 9),
(10, 'Lotte Cinema Bitexco', 'Ho Chi Minh City, Vietnam', '0289977665', '2025-04-23 12:20:54', 'https://link.example.com', 0, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `concessions`
--

CREATE TABLE `concessions` (
  `concession_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `picture_link` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `order_index` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `concessions`
--

INSERT INTO `concessions` (`concession_id`, `name`, `price`, `picture_link`, `link`, `hide`, `order_index`, `created_at`) VALUES
(1, 'Popcorn', 30000.00, 'https://link.example.com', 'https://link.example.com', 0, 1, '2025-04-23 12:23:40'),
(2, 'Soda', 20000.00, 'assets/img/soda.jpg', 'https://link.example.com', 0, 2, '2025-04-23 12:23:40'),
(3, 'Nachos', 25000.00, 'https://link.example.com', 'https://link.example.com', 0, 3, '2025-04-23 12:23:40'),
(4, 'Candy', 15000.00, 'https://link.example.com', 'https://link.example.com', 0, 4, '2025-04-23 12:23:40'),
(5, 'Water', 10000.00, 'https://link.example.com', 'https://link.example.com', 0, 5, '2025-04-23 12:23:40'),
(6, 'Ice Cream', 35000.00, 'https://link.example.com', 'https://link.example.com', 0, 6, '2025-04-23 12:23:40'),
(7, 'Hot Dog', 25000.00, 'assets/img/HotDog.jpg', 'https://link.example.com', 0, 7, '2025-04-23 12:23:40'),
(8, 'Chocolate', 20000.00, 'https://link.example.com', 'https://link.example.com', 0, 8, '2025-04-23 12:23:40'),
(9, 'Tea', 15000.00, 'assets/img/tea.jpg', 'https://link.example.com', 0, 9, '2025-04-23 12:23:40'),
(10, 'Juice', 18000.00, 'https://link.example.com', 'https://link.example.com', 0, 10, '2025-04-23 12:23:40'),
(11, 'Coca', 20000.00, 'assets/img/coca.jpg', NULL, 0, NULL, '2025-04-24 17:45:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `membership_discounts`
--

CREATE TABLE `membership_discounts` (
  `member_type` enum('None','Silver','Gold','Diamond') NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL CHECK (`discount_percent` between 0 and 100),
  `link` varchar(255) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `order_index` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `membership_discounts`
--

INSERT INTO `membership_discounts` (`member_type`, `discount_percent`, `link`, `hide`, `order_index`, `created_at`) VALUES
('None', 0.00, 'https://link.example.com', 0, 1, '2025-04-23 12:20:54'),
('Silver', 5.00, 'https://link.example.com', 0, 2, '2025-04-23 12:20:54'),
('Gold', 10.00, 'https://link.example.com', 0, 3, '2025-04-23 12:20:54'),
('Diamond', 15.00, 'https://link.example.com', 0, 4, '2025-04-23 12:20:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `director` varchar(255) DEFAULT NULL,
  `cast` text DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `poster_url` varchar(255) DEFAULT NULL,
  `trailer_url` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `link` varchar(255) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `order_index` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(11, 'Mickey 17', 'Khoa học viễn tưởng, Phiêu lưu', 118, 'Bong Joon-ho', 'Robert Pattinson, Mark Ruffalo, Toni Collette', 'English', '2025-04-18', 'Mickey 17 là một bộ phim khoa học viễn tưởng do Bong Joon-ho đạo diễn, kể về một nhân vật có khả năng hồi sinh không ngừng, thực hiện một nhiệm vụ du hành ngoài vũ trụ đầy nguy hiểm. Phim hứa hẹn mang đến những trải nghiệm điện ảnh độc đáo và hấp dẫn .', 'assets/img/Mickey17.jpg', 'https://www.youtube.com/watch?v=kFT4D0o9IZ4', 'assets/img/Mickey17-banner.jpg', '2025-04-23 18:21:40', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `payment_method` enum('Credit_card','Paypal','Momo','Zalopay') NOT NULL,
  `payment_status` enum('Success','Failed','Pending') DEFAULT 'Pending',
  `payment_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `link` varchar(255) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `order_index` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`payment_id`, `booking_id`, `user_id`, `price`, `payment_method`, `payment_status`, `payment_time`, `link`, `hide`, `order_index`) VALUES
(1, 1, 1, 360000.00, 'Credit_card', 'Success', '2025-04-23 12:23:40', 'https://link.example.com', 0, 1),
(2, 2, 2, 300000.00, 'Paypal', 'Pending', '2025-04-23 12:23:40', 'https://link.example.com', 0, 2),
(3, 3, 3, 330000.00, 'Credit_card', 'Success', '2025-04-23 12:23:40', 'https://link.example.com', 0, 3),
(4, 4, 4, 360000.00, 'Paypal', 'Failed', '2025-04-23 12:23:40', 'https://link.example.com', 0, 4),
(5, 5, 5, 320000.00, 'Credit_card', 'Pending', '2025-04-23 12:23:40', 'https://link.example.com', 0, 5),
(6, 6, 6, 380000.00, 'Credit_card', 'Success', '2025-04-23 12:23:40', 'https://link.example.com', 0, 6),
(7, 7, 7, 400000.00, 'Paypal', 'Success', '2025-04-23 12:23:40', 'https://link.example.com', 0, 7),
(8, 8, 8, 370000.00, 'Credit_card', 'Failed', '2025-04-23 12:23:40', 'https://link.example.com', 0, 8),
(9, 9, 9, 380000.00, 'Paypal', 'Success', '2025-04-23 12:23:40', 'https://link.example.com', 0, 9),
(10, 10, 10, 420000.00, 'Credit_card', 'Pending', '2025-04-23 12:23:40', 'https://link.example.com', 0, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `cinema_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `seat_count` int(11) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `order_index` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`room_id`, `cinema_id`, `name`, `seat_count`, `link`, `hide`, `order_index`, `created_at`) VALUES
(1, 1, 'Room 1', 100, 'https://link.example.com', 0, 1, '2025-04-23 12:20:54'),
(2, 2, 'Room 2', 100, 'https://link.example.com', 0, 1, '2025-04-23 12:20:54'),
(3, 3, 'Room 3', 100, 'https://link.example.com', 0, 1, '2025-04-23 12:20:54'),
(4, 1, 'Room 1', 100, 'https://link.example.com', 0, 1, '2025-04-23 12:20:54'),
(5, 2, 'Room 2', 120, 'https://link.example.com', 0, 2, '2025-04-23 12:20:54'),
(6, 3, 'Room 3', 150, 'https://link.example.com', 0, 3, '2025-04-23 12:20:54'),
(7, 4, 'Room 4', 200, 'https://link.example.com', 0, 4, '2025-04-23 12:20:54'),
(8, 5, 'Room 5', 180, 'https://link.example.com', 0, 5, '2025-04-23 12:20:54'),
(9, 6, 'Room 6', 220, 'https://link.example.com', 0, 6, '2025-04-23 12:20:54'),
(10, 7, 'Room 7', 130, 'https://link.example.com', 0, 7, '2025-04-23 12:20:54'),
(11, 8, 'Room 8', 170, 'https://link.example.com', 0, 8, '2025-04-23 12:20:54'),
(12, 9, 'Room 9', 160, 'https://link.example.com', 0, 9, '2025-04-23 12:20:54'),
(13, 10, 'Room 10', 140, 'https://link.example.com', 0, 10, '2025-04-23 12:20:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `seats`
--

CREATE TABLE `seats` (
  `seat_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `seat_type` enum('Standard','Vip','Couple') DEFAULT 'Standard',
  `extra_price` decimal(10,2) DEFAULT 0.00,
  `status` enum('Available','Booked') DEFAULT 'Available',
  `link` varchar(255) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `order_index` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `seats`
--

INSERT INTO `seats` (`seat_id`, `room_id`, `seat_number`, `seat_type`, `extra_price`, `status`, `link`, `hide`, `order_index`, `created_at`) VALUES
(1, 1, 'A1', 'Standard', 0.00, 'Available', 'https://link.example.com', 0, 1, '2025-04-23 12:23:00'),
(2, 1, 'A2', 'Vip', 50000.00, 'Available', 'https://link.example.com', 0, 2, '2025-04-23 12:23:00'),
(3, 2, 'B1', 'Couple', 100000.00, 'Available', 'https://link.example.com', 0, 3, '2025-04-23 12:23:00'),
(4, 3, 'C1', 'Standard', 0.00, 'Available', 'https://link.example.com', 0, 4, '2025-04-23 12:23:00'),
(5, 4, 'D1', 'Vip', 50000.00, 'Available', 'https://link.example.com', 0, 5, '2025-04-23 12:23:00'),
(6, 5, 'E1', 'Couple', 100000.00, 'Available', 'https://link.example.com', 0, 6, '2025-04-23 12:23:00'),
(7, 6, 'F1', 'Standard', 0.00, 'Available', 'https://link.example.com', 0, 7, '2025-04-23 12:23:00'),
(8, 7, 'G1', 'Vip', 50000.00, 'Available', 'https://link.example.com', 0, 8, '2025-04-23 12:23:00'),
(9, 8, 'H1', 'Couple', 100000.00, 'Available', 'https://link.example.com', 0, 9, '2025-04-23 12:23:00'),
(10, 9, 'I1', 'Standard', 0.00, 'Available', 'https://link.example.com', 0, 10, '2025-04-23 12:23:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `showtimes`
--

CREATE TABLE `showtimes` (
  `showtime_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `order_index` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `showtimes`
--

INSERT INTO `showtimes` (`showtime_id`, `movie_id`, `room_id`, `start_time`, `end_time`, `price`, `link`, `hide`, `order_index`, `created_at`) VALUES
(1, 1, 1, '2025-05-01 10:00:00', '2025-05-01 13:00:00', 150000.00, 'https://link.example.com', 0, 1, '2025-04-23 12:23:00'),
(2, 2, 2, '2025-05-01 14:00:00', '2025-05-01 17:00:00', 120000.00, 'https://link.example.com', 0, 2, '2025-04-23 12:23:00'),
(3, 3, 3, '2025-05-02 10:30:00', '2025-05-02 15:00:00', 100000.00, 'https://link.example.com', 0, 3, '2025-04-23 12:23:00'),
(4, 4, 4, '2025-05-02 15:00:00', '2025-05-02 18:00:00', 130000.00, 'https://link.example.com', 0, 4, '2025-04-23 12:23:00'),
(5, 5, 5, '2025-05-03 11:00:00', '2025-05-03 14:00:00', 110000.00, 'https://link.example.com', 0, 5, '2025-04-23 12:23:00'),
(6, 6, 6, '2025-05-03 14:30:00', '2025-05-03 18:00:00', 140000.00, 'https://link.example.com', 0, 6, '2025-04-23 12:23:00'),
(7, 7, 7, '2025-05-04 16:00:00', '2025-05-04 20:00:00', 150000.00, 'https://link.example.com', 0, 7, '2025-04-23 12:23:00'),
(8, 8, 8, '2025-05-04 18:30:00', '2025-05-04 21:00:00', 120000.00, 'https://link.example.com', 0, 8, '2025-04-23 12:23:00'),
(9, 9, 9, '2025-05-05 10:00:00', '2025-05-05 13:00:00', 110000.00, 'https://link.example.com', 0, 9, '2025-04-23 12:23:00'),
(10, 10, 10, '2025-05-05 13:00:00', '2025-05-05 17:00:00', 160000.00, 'https://link.example.com', 0, 10, '2025-04-23 12:23:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `birthday` date NOT NULL,
  `role` enum('Customer','Admin') DEFAULT 'Customer',
  `member` enum('None','Silver','Gold','Diamond') DEFAULT 'None',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `link` varchar(255) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT 0,
  `order_index` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `phone`, `birthday`, `role`, `member`, `created_at`, `link`, `hide`, `order_index`) VALUES
(1, 'Nguyen Thi Mai', 'mai@example.com', '$2y$10$QIIRXoTcM4bPf.gf9zfQEuVsnH./1VaB3gRvoE195wsqDP/6cmVRa', '0123456789', '1990-05-20', 'Customer', 'Gold', '2025-04-23 12:20:54', 'https://link.example.com', 0, 1),
(2, 'Tran Minh Tu', 'tu@example.com', '$2y$10$TWWviHalgk1her8DJa9cq.gTeeWezOWtifBK4RzsUyh7LAwqCQLTC', '0987654321', '1985-08-15', 'Admin', 'Silver', '2025-04-23 12:20:54', 'https://link.example.com', 0, 2),
(3, 'Le Thi Lan', 'lan@example.com', '$2y$10$LXi.46cdyKkFSOg52ZBcrev..p.IdvvFVETUepLeSlMRM1arN0vwG', '0912345678', '1988-01-20', 'Customer', 'Silver', '2025-04-23 12:20:54', 'https://link.example.com', 0, 3),
(4, 'Hoang Minh Hieu', 'hieu@example.com', '$2y$10$SLCvX3D3Ad3wdkj7vW8iPeJU0qJSVIKMELfMxo1ErcgdHHr9Pnydi', '0945678901', '1992-10-05', 'Customer', 'Gold', '2025-04-23 12:20:54', 'https://link.example.com', 0, 4),
(5, 'Nguyen Hoang Nam', 'nam@example.com', '$2y$10$JQNWSLRgLXJ8auHaFZgoAuV1stgpS8VDy8LrvpAC0U1.s/UrqwlFy', '09123456782', '1994-02-11', 'Admin', 'None', '2025-04-23 12:20:54', 'https://link.example.com', 0, 5),
(6, 'Pham Minh Hoang', 'hoang@example.com', '$2y$10$mJQEWw7gu95Z2S507LU/f.fEgo9SMAWMTJftltOQHJphq8bM7bn4W', '0971234567', '1991-06-30', 'Customer', 'Diamond', '2025-04-23 12:20:54', 'https://link.example.com', 0, 6),
(7, 'Tran Thi Thanh', 'thanh@example.com', '$2y$10$K8lMnZC7F.4rNEGhshXIu.aN9RngQoVCKtJQrNFX55.UN65/yIKUW', '0903456789', '1993-03-25', 'Customer', 'Silver', '2025-04-23 12:20:54', 'https://link.example.com', 0, 7),
(8, 'Le Thi Mai', 'mai2@example.com', '$2y$10$hQiqcoVKxeP2jJvy2o2DiOOyS9LEk1w68/wqTWINmNAMkp508I8MO', '0967654321', '1995-11-15', 'Customer', 'Gold', '2025-04-23 12:20:54', 'https://link.example.com', 0, 8),
(9, 'Nguyen Bao Han', 'han@example.com', '$2y$10$UyynL5cbCpw9vjMK9Lukw.i3dsi7e9D8Mnj.h3/lAWWKY/yBG4S9e', '0982345678', '1990-07-22', 'Admin', 'Gold', '2025-04-23 12:20:54', 'https://link.example.com', 0, 9),
(10, 'Phan Thi Lan', 'lan2@example.com', '$2y$10$grmByn5a6Mpe2/tOoTOT9ObqiAPv2AFELI69C50kQh867vLJsOase', '0934345678', '1987-12-10', 'Customer', 'None', '2025-04-23 12:20:54', 'https://link.example.com', 0, 10),
(13, 'Duong Hoang', 'hd34227@gmail.com', '$2y$10$5619w.WL3ehiJIwbrgWdd.kP/lKHj2S9Ez9lbaz5AGZRaez7z4joO', '0928051363', '2025-04-07', 'Admin', 'Diamond', '2025-04-24 13:52:20', NULL, 1, NULL),
(15, 'ADMIN', 'ADMIN@gmail.com', '$2y$10$FuTrTxDRLbrPRmSJ/Cdbd.YZmgaWfj6iZmeNuTQlub3xUyG0n3wz6', '0', '2025-04-01', 'Admin', 'Diamond', '2025-04-24 14:03:36', NULL, 0, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `showtime_id` (`showtime_id`);

--
-- Chỉ mục cho bảng `booking_concessions`
--
ALTER TABLE `booking_concessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `concession_id` (`concession_id`);

--
-- Chỉ mục cho bảng `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `seat_id` (`seat_id`);

--
-- Chỉ mục cho bảng `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`cinema_id`);

--
-- Chỉ mục cho bảng `concessions`
--
ALTER TABLE `concessions`
  ADD PRIMARY KEY (`concession_id`);

--
-- Chỉ mục cho bảng `membership_discounts`
--
ALTER TABLE `membership_discounts`
  ADD PRIMARY KEY (`member_type`);

--
-- Chỉ mục cho bảng `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `cinema_id` (`cinema_id`);

--
-- Chỉ mục cho bảng `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`seat_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `showtimes`
--
ALTER TABLE `showtimes`
  ADD PRIMARY KEY (`showtime_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `booking_concessions`
--
ALTER TABLE `booking_concessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `cinema_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `concessions`
--
ALTER TABLE `concessions`
  MODIFY `concession_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `seats`
--
ALTER TABLE `seats`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `showtimes`
--
ALTER TABLE `showtimes`
  MODIFY `showtime_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`showtime_id`) REFERENCES `showtimes` (`showtime_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `booking_concessions`
--
ALTER TABLE `booking_concessions`
  ADD CONSTRAINT `booking_concessions_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_concessions_ibfk_2` FOREIGN KEY (`concession_id`) REFERENCES `concessions` (`concession_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_details_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`seat_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`cinema_id`) REFERENCES `cinemas` (`cinema_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `showtimes`
--
ALTER TABLE `showtimes`
  ADD CONSTRAINT `showtimes_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `showtimes_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
