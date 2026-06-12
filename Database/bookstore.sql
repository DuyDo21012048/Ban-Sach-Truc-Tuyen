-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2026 at 08:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `title`, `phone`, `address`, `is_default`, `created_at`) VALUES
(1, 1, 'Nhà riêng', '0945913869', '170 Đường Nguyễn Văn 10, TP.HCM', 1, '2026-06-01 10:58:06'),
(2, 1, 'Công ty', '0957516286', '103 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(3, 2, 'Nhà riêng', '0982990430', '185 Đường Nguyễn Văn 12, TP.HCM', 1, '2026-06-01 10:58:06'),
(4, 2, 'Công ty', '0910972428', '155 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(5, 3, 'Nhà riêng', '0953818900', '112 Đường Nguyễn Văn 5, TP.HCM', 1, '2026-06-01 10:58:06'),
(6, 3, 'Công ty', '0907878072', '136 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(7, 4, 'Nhà riêng', '0916208218', '232 Đường Nguyễn Văn 8, TP.HCM', 1, '2026-06-01 10:58:06'),
(8, 4, 'Công ty', '0953860712', '117 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(9, 5, 'Nhà riêng', '0929132851', '214 Đường Nguyễn Văn 14, TP.HCM', 1, '2026-06-01 10:58:06'),
(10, 5, 'Công ty', '0930183185', '90 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(11, 6, 'Nhà riêng', '0932363131', '85 Đường Nguyễn Văn 9, TP.HCM', 1, '2026-06-01 10:58:06'),
(12, 6, 'Công ty', '0932050172', '61 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(13, 7, 'Nhà riêng', '0956340836', '271 Đường Nguyễn Văn 17, TP.HCM', 1, '2026-06-01 10:58:06'),
(14, 7, 'Công ty', '0939493787', '103 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(15, 8, 'Nhà riêng', '0938497597', '115 Đường Nguyễn Văn 16, TP.HCM', 1, '2026-06-01 10:58:06'),
(16, 8, 'Công ty', '0965149577', '196 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(17, 9, 'Nhà riêng', '0993136476', '218 Đường Nguyễn Văn 17, TP.HCM', 1, '2026-06-01 10:58:06'),
(18, 9, 'Công ty', '0998640718', '87 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(19, 10, 'Nhà riêng', '0921392289', '230 Đường Nguyễn Văn 4, TP.HCM', 1, '2026-06-01 10:58:06'),
(20, 10, 'Công ty', '0963716945', '126 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(21, 11, 'Nhà riêng', '0921466943', '60 Đường Nguyễn Văn 7, TP.HCM', 1, '2026-06-01 10:58:06'),
(22, 11, 'Công ty', '0912805015', '122 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(23, 12, 'Nhà riêng', '0965418854', '135 Đường Nguyễn Văn 6, TP.HCM', 1, '2026-06-01 10:58:06'),
(24, 12, 'Công ty', '0904183822', '76 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(25, 13, 'Nhà riêng', '0976347222', '206 Đường Nguyễn Văn 3, TP.HCM', 1, '2026-06-01 10:58:06'),
(26, 13, 'Công ty', '0959523592', '118 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(27, 14, 'Nhà riêng', '0915376147', '2 Đường Nguyễn Văn 12, TP.HCM', 1, '2026-06-01 10:58:06'),
(28, 14, 'Công ty', '0980634714', '68 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(29, 15, 'Nhà riêng', '0927446344', '107 Đường Nguyễn Văn 20, TP.HCM', 1, '2026-06-01 10:58:06'),
(30, 15, 'Công ty', '0971976401', '146 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(31, 16, 'Nhà riêng', '0946958760', '52 Đường Nguyễn Văn 9, TP.HCM', 1, '2026-06-01 10:58:06'),
(32, 16, 'Công ty', '0970961219', '44 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(33, 17, 'Nhà riêng', '0994713956', '28 Đường Nguyễn Văn 13, TP.HCM', 1, '2026-06-01 10:58:06'),
(34, 17, 'Công ty', '0977537493', '10 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(35, 18, 'Nhà riêng', '0992111439', '138 Đường Nguyễn Văn 11, TP.HCM', 1, '2026-06-01 10:58:06'),
(36, 18, 'Công ty', '0924231173', '129 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(37, 19, 'Nhà riêng', '0948886649', '155 Đường Nguyễn Văn 3, TP.HCM', 1, '2026-06-01 10:58:06'),
(38, 19, 'Công ty', '0999373610', '130 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(39, 20, 'Nhà riêng', '0924732283', '90 Đường Nguyễn Văn 16, TP.HCM', 1, '2026-06-01 10:58:06'),
(40, 20, 'Công ty', '0987905901', '26 Đường Lê Lợi, Hà Nội', 0, '2026-06-01 10:58:06'),
(41, 21, 'Nhà riêng', '123456789', 'Villa 3 - Kđt Dương Nội - Quận Hà Đông - Thành phố Hà Nội ', 1, '2026-06-05 08:21:41'),
(42, 21, 'Công ty', '0123456789', 'Quận Hà Đông - Thành phố Hà Nội', 0, '2026-06-05 09:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `review` decimal(2,1) DEFAULT 5.0,
  `favor` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `published_year` year(4) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `pages` int(11) DEFAULT NULL,
  `cover_type` varchar(50) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `price`, `image`, `author`, `description`, `review`, `favor`, `quantity`, `created_at`, `updated_at`, `published_year`, `language`, `pages`, `cover_type`, `publisher`, `isbn`) VALUES
(1, 'Educated', 333436, 'images/book8.jpg', 'Stephen King', 'A bestselling book loved by readers worldwide.', 3.9, 191, 288, '2026-06-01 10:57:40', '2026-06-03 09:12:51', '2005', 'Tiếng anh', 424, 'Bìa mềm', 'Macmillan', '1678191068'),
(2, 'Rich Dad Poor Dad', 214287, 'images/book1.jpg', 'Haruki Murakami', 'A bestselling book loved by readers worldwide.', 4.7, 777, 94, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2006', 'Tiếng anh', 427, 'Bìa cứng', 'Simon & Schuster', '8003136096'),
(3, 'Educated', 235518, 'images/book1.jpg', 'J.K. Rowling', 'A bestselling book loved by readers worldwide.', 4.0, 577, 226, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2022', 'Tiếng anh', 275, 'Bìa cứng', 'Random House', '8906033433'),
(4, 'To Kill a Mockingbird', 339159, 'images/book4.jpg', 'Eric Ries', 'A bestselling book loved by readers worldwide.', 3.9, 293, 156, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2015', 'Tiếng anh', 316, 'Bìa mềm', 'HarperCollins', '1480325892'),
(5, 'Dune', 247073, 'images/book7.jpg', 'George Orwell', 'A bestselling book loved by readers worldwide.', 4.1, 199, 164, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2024', 'Tiếng anh', 332, 'Bìa cứng', 'Random House', '2276018770'),
(6, 'Meditations', 341125, 'images/book7.jpg', 'Robert Martin', 'A bestselling book loved by readers worldwide.', 4.9, 533, 233, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2007', 'Tiếng anh', 338, 'Bìa cứng', 'Oxford', '2227123441'),
(7, 'Harry Potter', 445067, 'images/book6.jpg', 'Yuval Noah Harari', 'A bestselling book loved by readers worldwide.', 4.3, 158, 289, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2008', 'Tiếng anh', 233, 'Bìa mềm', 'Penguin', '4882833239'),
(8, 'Meditations', 122603, 'images/book10.jpg', 'Yuval Noah Harari', 'A bestselling book loved by readers worldwide.', 4.6, 864, 281, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2023', 'Tiếng anh', 648, 'Bìa mềm', 'Penguin', '7609230417'),
(9, 'The Hobbit', 498928, 'images/book1.jpg', 'James Clear', 'A bestselling book loved by readers worldwide.', 4.9, 587, 256, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2011', 'Tiếng anh', 275, 'Bìa mềm', 'Hachette', '6339648286'),
(10, 'The Lean Startup', 425694, 'images/book4.jpg', 'Eric Ries', 'A bestselling book loved by readers worldwide.', 4.8, 376, 302, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2019', 'Tiếng anh', 551, 'Bìa cứng', 'Oxford', '5121038495'),
(11, 'Meditations', 541340, 'images/book3.jpg', 'Morgan Housel', 'A bestselling book loved by readers worldwide.', 4.5, 591, 213, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2017', 'Tiếng anh', 186, 'Bìa cứng', 'Random House', '3415300386'),
(12, 'The Great Gatsby', 335077, 'images/book3.jpg', 'James Clear', 'A bestselling book loved by readers worldwide.', 4.9, 1040, 35, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2010', 'Tiếng anh', 302, 'Bìa cứng', 'Simon & Schuster', '6881050072'),
(13, 'Thinking Fast and Slow', 140478, 'images/book5.jpg', 'George Orwell', 'A bestselling book loved by readers worldwide.', 3.6, 1047, 259, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2024', 'Tiếng anh', 434, 'Bìa cứng', 'Hachette', '6107194206'),
(14, 'Meditations', 138601, 'images/book4.jpg', 'Haruki Murakami', 'A bestselling book loved by readers worldwide.', 4.1, 1035, 258, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2005', 'Tiếng anh', 505, 'Bìa mềm', 'Simon & Schuster', '3222817347'),
(15, 'Clean Code', 377025, 'images/book2.jpg', 'Robert Martin', 'A bestselling book loved by readers worldwide.', 3.7, 74, 264, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2005', 'Tiếng anh', 435, 'Bìa cứng', 'Macmillan', '9669849900'),
(16, 'Thinking Fast and Slow', 418493, 'images/book2.jpg', 'Eric Ries', 'A bestselling book loved by readers worldwide.', 4.5, 106, 80, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2021', 'Tiếng anh', 436, 'Bìa mềm', 'Penguin', '4058537166'),
(17, 'The Hobbit', 440258, 'images/book10.jpg', 'Robert Martin', 'A bestselling book loved by readers worldwide.', 4.3, 809, 100, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2006', 'Tiếng anh', 412, 'Bìa mềm', 'Random House', '6092932892'),
(18, 'Deep Work', 152945, 'images/book8.jpg', 'Stephen King', 'A bestselling book loved by readers worldwide.', 4.0, 628, 278, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2016', 'Tiếng anh', 290, 'Bìa cứng', 'Random House', '9521305669'),
(19, 'Meditations', 179055, 'images/book4.jpg', 'Marcus Aurelius', 'A bestselling book loved by readers worldwide.', 3.8, 984, 64, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2023', 'Tiếng anh', 268, 'Bìa mềm', 'HarperCollins', '7490791711'),
(20, 'The Psychology of Money', 253686, 'images/book6.jpg', 'Paulo Coelho', 'A bestselling book loved by readers worldwide.', 4.7, 344, 59, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2020', 'Tiếng anh', 403, 'Bìa mềm', 'Macmillan', '6668170644'),
(21, 'Start With Why', 431023, 'images/book8.jpg', 'Robert Martin', 'A bestselling book loved by readers worldwide.', 4.6, 338, 111, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2018', 'Tiếng anh', 358, 'Bìa mềm', 'HarperCollins', '6436708336'),
(22, 'Dune', 145246, 'images/book2.jpg', 'Eric Ries', 'A bestselling book loved by readers worldwide.', 4.3, 228, 120, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2007', 'Tiếng anh', 515, 'Bìa mềm', 'Oxford', '7121718577'),
(23, 'Start With Why', 423984, 'images/book4.jpg', 'James Clear', 'A bestselling book loved by readers worldwide.', 4.3, 726, 265, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2006', 'Tiếng anh', 590, 'Bìa mềm', 'Simon & Schuster', '2822142845'),
(24, 'Meditations', 306255, 'images/book10.jpg', 'James Clear', 'A bestselling book loved by readers worldwide.', 4.2, 695, 240, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2019', 'Tiếng anh', 390, 'Bìa mềm', 'Random House', '1261606649'),
(25, 'The Great Gatsby', 274857, 'images/book3.jpg', 'Tara Westover', 'A bestselling book loved by readers worldwide.', 4.0, 795, 258, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2019', 'Tiếng anh', 322, 'Bìa mềm', 'Simon & Schuster', '4855278243'),
(26, 'Atomic Habits', 556124, 'images/book5.jpg', 'Tara Westover', 'A bestselling book loved by readers worldwide.', 3.9, 1017, 43, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2014', 'Tiếng anh', 266, 'Bìa cứng', 'Hachette', '5044311391'),
(27, 'Clean Code', 426662, 'images/book2.jpg', 'J.K. Rowling', 'A bestselling book loved by readers worldwide.', 4.3, 434, 103, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2009', 'Tiếng anh', 342, 'Bìa mềm', 'Oxford', '5261255749'),
(28, 'Meditations', 327616, 'images/book6.jpg', 'Robert Martin', 'A bestselling book loved by readers worldwide.', 4.0, 175, 190, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2014', 'Tiếng anh', 452, 'Bìa cứng', 'Simon & Schuster', '9547504380'),
(29, '1984', 417560, 'images/book4.jpg', 'Paulo Coelho', 'A bestselling book loved by readers worldwide.', 4.8, 307, 218, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2015', 'Tiếng anh', 504, 'Bìa cứng', 'Random House', '8685643635'),
(30, 'To Kill a Mockingbird', 186963, 'images/book3.jpg', 'Tara Westover', 'A bestselling book loved by readers worldwide.', 4.6, 897, 54, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2005', 'Tiếng anh', 551, 'Bìa cứng', 'HarperCollins', '4846724578'),
(31, 'The Hobbit', 338713, 'images/book3.jpg', 'Marcus Aurelius', 'A bestselling book loved by readers worldwide.', 4.4, 392, 298, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2017', 'Tiếng anh', 278, 'Bìa mềm', 'Random House', '4102116214'),
(32, 'The Psychology of Money', 402046, 'images/book1.jpg', 'Yuval Noah Harari', 'A bestselling book loved by readers worldwide.', 3.8, 885, 216, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2020', 'Tiếng anh', 600, 'Bìa mềm', 'HarperCollins', '6164482293'),
(33, 'Clean Code', 373632, 'images/book2.jpg', 'Robert Martin', 'A bestselling book loved by readers worldwide.', 3.5, 646, 312, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2006', 'Tiếng anh', 410, 'Bìa mềm', 'Penguin', '5656285441'),
(34, 'The Alchemist', 272732, 'images/book2.jpg', 'Tara Westover', 'A bestselling book loved by readers worldwide.', 4.9, 233, 37, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2019', 'Tiếng anh', 410, 'Bìa mềm', 'Macmillan', '7431847100'),
(35, 'The Hobbit', 168640, 'images/book3.jpg', 'Morgan Housel', 'A bestselling book loved by readers worldwide.', 3.5, 401, 217, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2009', 'Tiếng anh', 253, 'Bìa mềm', 'Penguin', '2193374001'),
(36, 'The Great Gatsby', 568545, 'images/book4.jpg', 'George Orwell', 'A bestselling book loved by readers worldwide.', 4.4, 211, 298, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2008', 'Tiếng anh', 645, 'Bìa mềm', 'Macmillan', '9671380368'),
(37, 'Harry Potter', 259001, 'images/book10.jpg', 'Stephen King', 'A bestselling book loved by readers worldwide.', 4.5, 747, 141, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2023', 'Tiếng anh', 367, 'Bìa mềm', 'Hachette', '9819733592'),
(38, 'Atomic Habits', 413066, 'images/book9.jpg', 'Cal Newport', 'A bestselling book loved by readers worldwide.', 3.8, 691, 174, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2018', 'Tiếng anh', 518, 'Bìa cứng', 'Simon & Schuster', '7236156022'),
(39, 'Harry Potter', 351878, 'images/book5.jpg', 'Eric Ries', 'A bestselling book loved by readers worldwide.', 4.3, 564, 292, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2024', 'Tiếng anh', 269, 'Bìa mềm', 'Simon & Schuster', '2938882631'),
(40, 'Educated', 474101, 'images/book6.jpg', 'Morgan Housel', 'A bestselling book loved by readers worldwide.', 4.0, 184, 204, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2018', 'Tiếng anh', 414, 'Bìa cứng', 'Macmillan', '6826032567'),
(41, 'Sapiens', 352283, 'images/book4.jpg', 'Marcus Aurelius', 'A bestselling book loved by readers worldwide.', 3.8, 866, 192, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2013', 'Tiếng anh', 351, 'Bìa cứng', 'Macmillan', '2918421065'),
(42, '1984', 193359, 'images/book7.jpg', 'Yuval Noah Harari', 'A bestselling book loved by readers worldwide.', 4.4, 336, 181, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2021', 'Tiếng anh', 406, 'Bìa mềm', 'Pearson', '3672246488'),
(43, 'Sapiens', 527473, 'images/book1.jpg', 'Tara Westover', 'A bestselling book loved by readers worldwide.', 4.3, 472, 193, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2017', 'Tiếng anh', 342, 'Bìa mềm', 'Penguin', '4911436131'),
(44, 'Start With Why', 279855, 'images/book6.jpg', 'Marcus Aurelius', 'A bestselling book loved by readers worldwide.', 4.2, 734, 53, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2014', 'Tiếng anh', 231, 'Bìa mềm', 'Penguin', '5834903211'),
(45, 'Harry Potter', 382703, 'images/book9.jpg', 'Yuval Noah Harari', 'A bestselling book loved by readers worldwide.', 4.3, 248, 116, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2005', 'Tiếng anh', 191, 'Bìa mềm', 'Hachette', '3219118438'),
(46, 'Clean Code', 344992, 'images/book9.jpg', 'Robert Martin', 'A bestselling book loved by readers worldwide.', 4.7, 391, 127, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2020', 'Tiếng anh', 550, 'Bìa cứng', 'Pearson', '8259578354'),
(47, 'Deep Work', 535231, 'images/book9.jpg', 'Paulo Coelho', 'A bestselling book loved by readers worldwide.', 3.9, 90, 114, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2014', 'Tiếng anh', 304, 'Bìa mềm', 'Penguin', '6792575069'),
(48, 'The Psychology of Money', 184219, 'images/book3.jpg', 'J.R.R. Tolkien', 'A bestselling book loved by readers worldwide.', 5.0, 89, 99, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2009', 'Tiếng anh', 286, 'Bìa cứng', 'Oxford', '7982401900'),
(49, 'Dune', 434045, 'images/book8.jpg', 'Robert Martin', 'A bestselling book loved by readers worldwide.', 4.4, 933, 184, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2006', 'Tiếng anh', 555, 'Bìa cứng', 'Macmillan', '1113127370'),
(50, 'To Kill a Mockingbird', 172183, 'images/book10.jpg', 'Robert Martin', 'A bestselling book loved by readers worldwide.', 4.0, 987, 210, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2012', 'Tiếng anh', 594, 'Bìa mềm', 'HarperCollins', '7738948784'),
(51, 'Rich Dad Poor Dad', 532372, 'images/book9.jpg', 'Stephen King', 'A bestselling book loved by readers worldwide.', 4.0, 143, 185, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2014', 'Tiếng anh', 530, 'Bìa mềm', 'Macmillan', '3708109072'),
(52, 'The Psychology of Money', 363413, 'images/book1.jpg', 'George Orwell', 'A bestselling book loved by readers worldwide.', 4.2, 199, 150, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2019', 'Tiếng anh', 314, 'Bìa mềm', 'Simon & Schuster', '3375007454'),
(53, 'Thinking Fast and Slow', 227020, 'images/book7.jpg', 'Tara Westover', 'A bestselling book loved by readers worldwide.', 4.4, 950, 253, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2008', 'Tiếng anh', 471, 'Bìa cứng', 'HarperCollins', '1748852875'),
(54, 'Start With Why', 258319, 'images/book7.jpg', 'Haruki Murakami', 'A bestselling book loved by readers worldwide.', 3.9, 393, 310, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2021', 'Tiếng anh', 242, 'Bìa mềm', 'Oxford', '5166905778'),
(55, 'Atomic Habits', 149194, 'images/book5.jpg', 'Simon Sinek', 'A bestselling book loved by readers worldwide.', 3.8, 739, 248, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2019', 'Tiếng anh', 348, 'Bìa cứng', 'Hachette', '1637252998'),
(56, 'Thinking Fast and Slow', 557134, 'images/book7.jpg', 'Yuval Noah Harari', 'A bestselling book loved by readers worldwide.', 4.4, 851, 100, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2023', 'Tiếng anh', 578, 'Bìa mềm', 'Pearson', '1066781589'),
(57, 'Thinking Fast and Slow', 312965, 'images/book1.jpg', 'Eric Ries', 'A bestselling book loved by readers worldwide.', 3.6, 154, 120, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2012', 'Tiếng anh', 545, 'Bìa cứng', 'Penguin', '5473096709'),
(58, 'The Hobbit', 295404, 'images/book4.jpg', 'J.R.R. Tolkien', 'A bestselling book loved by readers worldwide.', 4.7, 813, 156, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2024', 'Tiếng anh', 440, 'Bìa cứng', 'Pearson', '8093241069'),
(59, 'Clean Code', 294312, 'images/book2.jpg', 'George Orwell', 'A bestselling book loved by readers worldwide.', 4.5, 759, 209, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2005', 'Tiếng anh', 287, 'Bìa mềm', 'Random House', '7967723268'),
(60, 'Thinking Fast and Slow', 361566, 'images/book8.jpg', 'Paulo Coelho', 'A bestselling book loved by readers worldwide.', 3.9, 91, 135, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2021', 'Tiếng anh', 581, 'Bìa cứng', 'Pearson', '8578777965'),
(61, 'The Silent Patient', 159566, 'images/book8.jpg', 'Stephen King', 'A bestselling book loved by readers worldwide.', 3.9, 347, 209, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2010', 'Tiếng anh', 371, 'Bìa mềm', 'Hachette', '4210923183'),
(62, '1984', 388106, 'images/book7.jpg', 'Morgan Housel', 'A bestselling book loved by readers worldwide.', 4.4, 80, 113, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2014', 'Tiếng anh', 332, 'Bìa mềm', 'HarperCollins', '4684573753'),
(63, 'The Great Gatsby', 517941, 'images/book3.jpg', 'Eric Ries', 'A bestselling book loved by readers worldwide.', 4.2, 741, 31, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2007', 'Tiếng anh', 370, 'Bìa cứng', 'Penguin', '6435273899'),
(64, 'The Lean Startup', 303926, 'images/book3.jpg', 'Simon Sinek', 'A bestselling book loved by readers worldwide.', 4.7, 442, 186, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2017', 'Tiếng anh', 320, 'Bìa cứng', 'Macmillan', '7689544103'),
(65, 'Rich Dad Poor Dad', 226962, 'images/book3.jpg', 'Haruki Murakami', 'A bestselling book loved by readers worldwide.', 4.0, 996, 259, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2007', 'Tiếng anh', 315, 'Bìa mềm', 'HarperCollins', '9593041173'),
(66, 'Harry Potter', 314418, 'images/book8.jpg', 'Morgan Housel', 'A bestselling book loved by readers worldwide.', 4.4, 834, 31, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2021', 'Tiếng anh', 182, 'Bìa cứng', 'Pearson', '1091757163'),
(67, 'Harry Potter', 150085, 'images/book9.jpg', 'Tara Westover', 'A bestselling book loved by readers worldwide.', 4.9, 123, 213, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2024', 'Tiếng anh', 179, 'Bìa mềm', 'Simon & Schuster', '7244087934'),
(68, 'Dune', 536681, 'images/book2.jpg', 'J.R.R. Tolkien', 'A bestselling book loved by readers worldwide.', 4.9, 394, 275, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2009', 'Tiếng anh', 424, 'Bìa mềm', 'Oxford', '6616565463'),
(69, 'Ikigai', 165586, 'images/book3.jpg', 'Morgan Housel', 'A bestselling book loved by readers worldwide.', 4.7, 304, 298, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2022', 'Tiếng anh', 463, 'Bìa mềm', 'Random House', '2952642515'),
(70, 'The Silent Patient', 323320, 'images/book10.jpg', 'Marcus Aurelius', 'A bestselling book loved by readers worldwide.', 3.8, 337, 267, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2010', 'Tiếng anh', 567, 'Bìa mềm', 'Macmillan', '1696462317'),
(71, 'Atomic Habits', 402755, 'images/book4.jpg', 'Haruki Murakami', 'A bestselling book loved by readers worldwide.', 4.4, 228, 33, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2018', 'Tiếng anh', 296, 'Bìa mềm', 'HarperCollins', '5934800376'),
(72, 'The Alchemist', 561378, 'images/book7.jpg', 'Marcus Aurelius', 'A bestselling book loved by readers worldwide.', 3.6, 712, 26, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2007', 'Tiếng anh', 426, 'Bìa mềm', 'Simon & Schuster', '4723615409'),
(73, 'Deep Work', 184333, 'images/book9.jpg', 'Paulo Coelho', 'A bestselling book loved by readers worldwide.', 4.6, 316, 39, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2015', 'Tiếng anh', 371, 'Bìa cứng', 'Oxford', '2979998130'),
(74, '1984', 412153, 'images/book8.jpg', 'J.R.R. Tolkien', 'A bestselling book loved by readers worldwide.', 4.4, 1048, 51, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2015', 'Tiếng anh', 323, 'Bìa mềm', 'Hachette', '8643016377'),
(75, 'The Alchemist', 368779, 'images/book2.jpg', 'Stephen King', 'A bestselling book loved by readers worldwide.', 4.9, 348, 230, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2017', 'Tiếng anh', 622, 'Bìa cứng', 'Hachette', '6248300034'),
(76, 'Meditations', 175371, 'images/book7.jpg', 'Haruki Murakami', 'A bestselling book loved by readers worldwide.', 4.7, 148, 48, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2008', 'Tiếng anh', 442, 'Bìa mềm', 'Simon & Schuster', '2187056971'),
(77, 'The Lean Startup', 460388, 'images/book2.jpg', 'Tara Westover', 'A bestselling book loved by readers worldwide.', 4.6, 1002, 211, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2011', 'Tiếng anh', 528, 'Bìa cứng', 'Hachette', '8691715268'),
(78, 'Harry Potter', 538476, 'images/book1.jpg', 'Cal Newport', 'A bestselling book loved by readers worldwide.', 4.2, 370, 52, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2016', 'Tiếng anh', 421, 'Bìa mềm', 'Simon & Schuster', '8595353162'),
(79, 'Deep Work', 494608, 'images/book1.jpg', 'James Clear', 'A bestselling book loved by readers worldwide.', 4.7, 861, 218, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2022', 'Tiếng anh', 353, 'Bìa mềm', 'Oxford', '6628873860'),
(80, 'Start With Why', 145995, 'images/book4.jpg', 'Paulo Coelho', 'A bestselling book loved by readers worldwide.', 4.3, 784, 23, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2022', 'Tiếng anh', 261, 'Bìa cứng', 'Penguin', '9545263294'),
(81, 'Harry Potter', 549437, 'images/book8.jpg', 'James Clear', 'A bestselling book loved by readers worldwide.', 4.7, 758, 82, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2023', 'Tiếng anh', 611, 'Bìa cứng', 'Hachette', '7228800299'),
(82, 'The Hobbit', 323084, 'images/book8.jpg', 'Cal Newport', 'A bestselling book loved by readers worldwide.', 4.3, 467, 149, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2023', 'Tiếng anh', 260, 'Bìa mềm', 'Simon & Schuster', '4823847967'),
(83, 'Clean Code', 127279, 'images/book6.jpg', 'J.R.R. Tolkien', 'A bestselling book loved by readers worldwide.', 4.9, 872, 125, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2010', 'Tiếng anh', 336, 'Bìa mềm', 'Pearson', '7354563874'),
(84, 'To Kill a Mockingbird', 294583, 'images/book1.jpg', 'Paulo Coelho', 'A bestselling book loved by readers worldwide.', 3.9, 1023, 60, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2020', 'Tiếng anh', 345, 'Bìa cứng', 'HarperCollins', '1145938824'),
(85, 'The Silent Patient', 450667, 'images/book1.jpg', 'Robert Martin', 'A bestselling book loved by readers worldwide.', 4.8, 397, 49, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2014', 'Tiếng anh', 633, 'Bìa mềm', 'Macmillan', '9346225448'),
(86, 'Rich Dad Poor Dad', 163136, 'images/book5.jpg', 'Yuval Noah Harari', 'A bestselling book loved by readers worldwide.', 4.7, 680, 269, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2010', 'Tiếng anh', 556, 'Bìa mềm', 'Pearson', '1282484478'),
(87, 'Rich Dad Poor Dad', 371716, 'images/book7.jpg', 'James Clear', 'A bestselling book loved by readers worldwide.', 4.4, 952, 260, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2010', 'Tiếng anh', 184, 'Bìa mềm', 'Penguin', '2426339771'),
(88, 'The Silent Patient', 487539, 'images/book6.jpg', 'Tara Westover', 'A bestselling book loved by readers worldwide.', 4.0, 111, 98, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2007', 'Tiếng anh', 577, 'Bìa cứng', 'Pearson', '7772012274'),
(89, 'Deep Work', 168475, 'images/book7.jpg', 'Paulo Coelho', 'A bestselling book loved by readers worldwide.', 3.6, 351, 112, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2017', 'Tiếng anh', 270, 'Bìa mềm', 'Oxford', '2067885016'),
(90, 'Clean Code', 565049, 'images/book5.jpg', 'J.R.R. Tolkien', 'A bestselling book loved by readers worldwide.', 3.9, 966, 270, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2013', 'Tiếng anh', 451, 'Bìa cứng', 'Pearson', '5168576559'),
(91, 'The Silent Patient', 473356, 'images/book8.jpg', 'James Clear', 'A bestselling book loved by readers worldwide.', 4.3, 363, 313, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2024', 'Tiếng anh', 574, 'Bìa mềm', 'Simon & Schuster', '4680101010'),
(92, 'Deep Work', 483688, 'images/book8.jpg', 'J.K. Rowling', 'A bestselling book loved by readers worldwide.', 3.7, 665, 205, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2010', 'Tiếng anh', 353, 'Bìa mềm', 'HarperCollins', '9661126501'),
(93, 'Thinking Fast and Slow', 566880, 'images/book6.jpg', 'Tara Westover', 'A bestselling book loved by readers worldwide.', 4.7, 512, 266, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2019', 'Tiếng anh', 225, 'Bìa cứng', 'Macmillan', '6255930726'),
(94, 'Dune', 412233, 'images/book8.jpg', 'Tara Westover', 'A bestselling book loved by readers worldwide.', 4.5, 234, 293, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2024', 'Tiếng anh', 275, 'Bìa mềm', 'Random House', '1654781493'),
(95, '1984', 142116, 'images/book3.jpg', 'Haruki Murakami', 'A bestselling book loved by readers worldwide.', 3.7, 1017, 137, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2005', 'Tiếng anh', 187, 'Bìa mềm', 'Pearson', '9606285745'),
(96, 'Educated', 321779, 'images/book10.jpg', 'Morgan Housel', 'A bestselling book loved by readers worldwide.', 4.4, 102, 155, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2006', 'Tiếng anh', 216, 'Bìa mềm', 'Macmillan', '2704242534'),
(97, 'The Great Gatsby', 374029, 'images/book1.jpg', 'Robert Martin', 'A bestselling book loved by readers worldwide.', 4.5, 98, 106, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2010', 'Tiếng anh', 452, 'Bìa mềm', 'Pearson', '1453649965'),
(98, 'The Great Gatsby', 441676, 'images/book6.jpg', 'Eric Ries', 'A bestselling book loved by readers worldwide.', 4.2, 875, 226, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2024', 'Tiếng anh', 539, 'Bìa cứng', 'Random House', '9788887350'),
(99, 'Deep Work', 167044, 'images/book5.jpg', 'Eric Ries', 'A bestselling book loved by readers worldwide.', 4.8, 1046, 140, '2026-06-01 10:57:40', '2026-06-01 10:57:40', '2005', 'Tiếng anh', 610, 'Bìa cứng', 'Oxford', '7980577830'),
(100, 'The Alchemist', 200773, 'images/book10.jpg', 'Haruki Murakami', 'A bestselling book loved by readers worldwide.', 3.5, 467, 318, '2026-06-01 10:57:40', '2026-06-03 09:46:44', '2019', 'Tiếng anh', 445, 'Bìa cứng', 'Simon & Schuster', '1157896741');

-- --------------------------------------------------------

--
-- Table structure for table `book_categories`
--

CREATE TABLE `book_categories` (
  `book_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_categories`
--

INSERT INTO `book_categories` (`book_id`, `category_id`) VALUES
(1, 8),
(1, 17),
(2, 9),
(2, 10),
(3, 16),
(4, 15),
(5, 15),
(5, 22),
(6, 6),
(7, 9),
(7, 21),
(8, 4),
(8, 14),
(9, 10),
(9, 25),
(10, 23),
(11, 4),
(12, 8),
(12, 17),
(13, 5),
(14, 12),
(14, 14),
(15, 20),
(16, 9),
(16, 25),
(17, 9),
(18, 13),
(19, 17),
(19, 20),
(20, 7),
(20, 25),
(21, 4),
(22, 15),
(22, 23),
(23, 18),
(24, 7),
(24, 11),
(25, 13),
(26, 7),
(27, 6),
(27, 16),
(28, 22),
(29, 6),
(29, 23),
(30, 19),
(31, 17),
(31, 19),
(32, 10),
(33, 15),
(34, 6),
(35, 7),
(36, 11),
(36, 23),
(37, 13),
(38, 9),
(38, 21),
(39, 24),
(40, 14),
(40, 25),
(41, 4),
(41, 20),
(42, 15),
(43, 11),
(43, 12),
(44, 10),
(45, 16),
(46, 12),
(46, 16),
(47, 4),
(48, 6),
(48, 9),
(49, 12),
(49, 16),
(50, 6),
(51, 7),
(51, 11),
(52, 14),
(52, 20),
(53, 6),
(54, 11),
(55, 19),
(56, 15),
(56, 25),
(57, 9),
(57, 13),
(58, 5),
(58, 8),
(59, 24),
(60, 21),
(60, 22),
(61, 7),
(62, 25),
(63, 9),
(63, 24),
(64, 21),
(65, 5),
(66, 15),
(66, 21),
(67, 8),
(68, 18),
(68, 19),
(69, 19),
(70, 9),
(70, 15),
(71, 25),
(72, 4),
(72, 22),
(73, 6),
(73, 9),
(74, 9),
(74, 14),
(75, 9),
(75, 22),
(76, 5),
(77, 13),
(78, 10),
(78, 25),
(79, 14),
(79, 25),
(80, 18),
(81, 6),
(82, 4),
(82, 14),
(83, 8),
(84, 6),
(84, 14),
(85, 13),
(85, 24),
(86, 6),
(86, 19),
(87, 4),
(88, 6),
(89, 17),
(89, 24),
(90, 20),
(91, 23),
(92, 10),
(93, 5),
(93, 20),
(94, 10),
(95, 14),
(96, 12),
(97, 15),
(97, 18),
(98, 24),
(99, 21),
(100, 13),
(100, 19);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`) VALUES
(1, 'Hư cấu', NULL),
(2, 'Phi hư cấu', NULL),
(3, 'Khác', NULL),
(4, 'Kỳ ảo', 1),
(5, 'Lãng mạn', 1),
(6, 'Trinh thám', 1),
(7, 'Khoa học viễn tưởng', 1),
(8, 'Bí ẩn', 1),
(9, 'Kinh dị', 1),
(10, 'Suspense', 1),
(11, 'Thriller', 1),
(12, 'Tội phạm', 1),
(13, 'Tiểu thuyết lịch sử', 1),
(14, 'Literary', 1),
(15, 'Young Adult', 1),
(16, 'Kinh tế', 2),
(17, 'Tâm lý học', 2),
(18, 'Hồi ký', 2),
(19, 'Tiểu sử', 2),
(20, 'Lịch sử', 2),
(21, 'Tội phạm có thật', 2),
(22, 'Sức khỏe và Thể hình', 2),
(23, 'Nấu ăn', 2),
(24, 'Self-help', 2),
(25, 'Thiếu nhi', 3),
(26, 'Novel', 3),
(27, 'Thơ', 3),
(28, 'Tôn giáo', 3),
(29, 'Tâm linh', 3);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `book_id`, `created_at`) VALUES
(1, 11, 27, '2026-06-01 10:58:34'),
(2, 16, 17, '2026-06-01 10:58:34'),
(3, 10, 84, '2026-06-01 10:58:34'),
(4, 16, 29, '2026-06-01 10:58:34'),
(5, 4, 100, '2026-06-01 10:58:34'),
(6, 10, 37, '2026-06-01 10:58:34'),
(7, 8, 88, '2026-06-01 10:58:34'),
(8, 5, 40, '2026-06-01 10:58:34'),
(9, 7, 54, '2026-06-01 10:58:34'),
(10, 13, 61, '2026-06-01 10:58:34'),
(11, 2, 69, '2026-06-01 10:58:34'),
(12, 3, 51, '2026-06-01 10:58:34'),
(13, 4, 40, '2026-06-01 10:58:34'),
(14, 9, 3, '2026-06-01 10:58:34'),
(15, 16, 90, '2026-06-01 10:58:34'),
(16, 2, 76, '2026-06-01 10:58:34'),
(17, 11, 34, '2026-06-01 10:58:34'),
(18, 2, 49, '2026-06-01 10:58:34'),
(19, 3, 26, '2026-06-01 10:58:34'),
(20, 17, 42, '2026-06-01 10:58:34'),
(21, 12, 66, '2026-06-01 10:58:34'),
(22, 11, 75, '2026-06-01 10:58:34'),
(23, 2, 19, '2026-06-01 10:58:34'),
(24, 14, 79, '2026-06-01 10:58:34'),
(25, 19, 21, '2026-06-01 10:58:34'),
(26, 6, 83, '2026-06-01 10:58:34'),
(27, 6, 81, '2026-06-01 10:58:34'),
(28, 5, 83, '2026-06-01 10:58:34'),
(29, 9, 55, '2026-06-01 10:58:34'),
(30, 11, 91, '2026-06-01 10:58:34'),
(31, 1, 33, '2026-06-01 10:58:34'),
(32, 12, 97, '2026-06-01 10:58:34'),
(33, 2, 47, '2026-06-01 10:58:34'),
(34, 3, 19, '2026-06-01 10:58:34'),
(35, 12, 39, '2026-06-01 10:58:34'),
(36, 4, 64, '2026-06-01 10:58:34'),
(37, 15, 67, '2026-06-01 10:58:34'),
(38, 4, 98, '2026-06-01 10:58:34'),
(39, 6, 45, '2026-06-01 10:58:34'),
(40, 8, 65, '2026-06-01 10:58:34'),
(41, 2, 35, '2026-06-01 10:58:34'),
(42, 12, 73, '2026-06-01 10:58:34'),
(43, 20, 71, '2026-06-01 10:58:34'),
(44, 12, 82, '2026-06-01 10:58:34'),
(45, 7, 15, '2026-06-01 10:58:34'),
(46, 16, 52, '2026-06-01 10:58:34'),
(47, 5, 51, '2026-06-01 10:58:34'),
(48, 18, 92, '2026-06-01 10:58:34'),
(49, 19, 86, '2026-06-01 10:58:34'),
(50, 11, 9, '2026-06-01 10:58:34'),
(51, 17, 89, '2026-06-01 10:58:34'),
(52, 19, 3, '2026-06-01 10:58:34'),
(53, 7, 50, '2026-06-01 10:58:34'),
(54, 11, 20, '2026-06-01 10:58:34'),
(55, 8, 20, '2026-06-01 10:58:34'),
(56, 18, 91, '2026-06-01 10:58:34'),
(57, 18, 55, '2026-06-01 10:58:34'),
(58, 4, 27, '2026-06-01 10:58:34'),
(59, 16, 13, '2026-06-01 10:58:34'),
(60, 6, 6, '2026-06-01 10:58:34'),
(61, 9, 93, '2026-06-01 10:58:34'),
(62, 7, 98, '2026-06-01 10:58:34'),
(63, 17, 17, '2026-06-01 10:58:34'),
(64, 8, 37, '2026-06-01 10:58:34'),
(65, 15, 46, '2026-06-01 10:58:34'),
(66, 3, 38, '2026-06-01 10:58:34'),
(67, 9, 96, '2026-06-01 10:58:34'),
(68, 11, 80, '2026-06-01 10:58:34'),
(69, 8, 52, '2026-06-01 10:58:34'),
(71, 10, 71, '2026-06-01 10:58:34'),
(72, 3, 44, '2026-06-01 10:58:34'),
(73, 17, 88, '2026-06-01 10:58:34'),
(74, 18, 78, '2026-06-01 10:58:34'),
(75, 5, 76, '2026-06-01 10:58:34'),
(76, 4, 49, '2026-06-01 10:58:34'),
(77, 20, 42, '2026-06-01 10:58:34'),
(78, 4, 55, '2026-06-01 10:58:34'),
(79, 5, 56, '2026-06-01 10:58:34'),
(80, 1, 59, '2026-06-01 10:58:34'),
(81, 16, 14, '2026-06-01 10:58:34'),
(82, 8, 36, '2026-06-01 10:58:34'),
(83, 15, 55, '2026-06-01 10:58:34'),
(84, 12, 22, '2026-06-01 10:58:34'),
(85, 7, 11, '2026-06-01 10:58:34'),
(86, 10, 2, '2026-06-01 10:58:34'),
(87, 14, 43, '2026-06-01 10:58:34'),
(88, 1, 85, '2026-06-01 10:58:34'),
(89, 4, 31, '2026-06-01 10:58:34'),
(90, 1, 15, '2026-06-01 10:58:34'),
(91, 14, 5, '2026-06-01 10:58:34'),
(92, 3, 50, '2026-06-01 10:58:34'),
(93, 2, 99, '2026-06-01 10:58:34'),
(94, 13, 28, '2026-06-01 10:58:34'),
(95, 9, 41, '2026-06-01 10:58:34'),
(96, 14, 17, '2026-06-01 10:58:34'),
(97, 16, 48, '2026-06-01 10:58:34'),
(98, 20, 57, '2026-06-01 10:58:34'),
(100, 4, 17, '2026-06-01 10:58:34'),
(101, 8, 33, '2026-06-01 10:58:34'),
(102, 11, 63, '2026-06-01 10:58:34'),
(103, 12, 93, '2026-06-01 10:58:34'),
(104, 19, 90, '2026-06-01 10:58:34'),
(105, 14, 77, '2026-06-01 10:58:34'),
(106, 15, 40, '2026-06-01 10:58:34'),
(107, 16, 62, '2026-06-01 10:58:34'),
(108, 17, 23, '2026-06-01 10:58:34'),
(109, 14, 80, '2026-06-01 10:58:34'),
(110, 18, 96, '2026-06-01 10:58:34'),
(111, 4, 2, '2026-06-01 10:58:34'),
(112, 11, 69, '2026-06-01 10:58:34'),
(113, 16, 85, '2026-06-01 10:58:34'),
(114, 18, 95, '2026-06-01 10:58:34'),
(115, 1, 25, '2026-06-01 10:58:34'),
(116, 4, 22, '2026-06-01 10:58:34'),
(117, 11, 97, '2026-06-01 10:58:34'),
(118, 5, 30, '2026-06-01 10:58:34'),
(119, 16, 89, '2026-06-01 10:58:34'),
(120, 4, 19, '2026-06-01 10:58:34'),
(121, 9, 64, '2026-06-01 10:58:34'),
(122, 18, 45, '2026-06-01 10:58:34'),
(123, 13, 75, '2026-06-01 10:58:34'),
(124, 18, 18, '2026-06-01 10:58:34'),
(125, 5, 53, '2026-06-01 10:58:34'),
(127, 2, 13, '2026-06-01 10:58:34'),
(128, 9, 76, '2026-06-01 10:58:34'),
(129, 10, 12, '2026-06-01 10:58:34'),
(130, 4, 42, '2026-06-01 10:58:34'),
(131, 13, 93, '2026-06-01 10:58:34'),
(132, 14, 73, '2026-06-01 10:58:34'),
(133, 11, 47, '2026-06-01 10:58:34'),
(134, 15, 29, '2026-06-01 10:58:34'),
(135, 5, 33, '2026-06-01 10:58:34'),
(136, 19, 55, '2026-06-01 10:58:34'),
(137, 1, 45, '2026-06-01 10:58:34'),
(140, 8, 62, '2026-06-01 10:58:34'),
(141, 20, 8, '2026-06-01 10:58:34'),
(142, 9, 99, '2026-06-01 10:58:34'),
(143, 13, 5, '2026-06-01 10:58:34'),
(144, 9, 95, '2026-06-01 10:58:34'),
(145, 10, 51, '2026-06-01 10:58:34'),
(146, 3, 9, '2026-06-01 10:58:34'),
(147, 2, 18, '2026-06-01 10:58:34'),
(148, 12, 47, '2026-06-01 10:58:34'),
(149, 11, 32, '2026-06-01 10:58:34'),
(150, 19, 78, '2026-06-01 10:58:34'),
(152, 21, 39, '2026-06-07 18:18:59'),
(153, 21, 89, '2026-06-07 18:19:02'),
(154, 21, 1, '2026-06-07 18:19:13');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `order_code` varchar(20) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT 'COD',
  `status` enum('waiting_confirm','pending','shipping','delivered','cancelled') NOT NULL DEFAULT 'waiting_confirm',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `order_code`, `total_price`, `payment_method`, `status`, `created_at`) VALUES
(1, 20, NULL, 'ORD0001', 890134, 'COD', 'cancelled', '2026-02-28 10:58:11'),
(2, 19, NULL, 'ORD0002', 3982343, 'COD', 'waiting_confirm', '2026-02-23 10:58:11'),
(3, 12, NULL, 'ORD0003', 2616696, 'COD', 'waiting_confirm', '2025-12-15 10:58:11'),
(4, 7, NULL, 'ORD0004', 2676419, 'COD', 'delivered', '2025-12-31 10:58:11'),
(5, 20, NULL, 'ORD0005', 1942326, 'COD', 'pending', '2026-03-25 10:58:11'),
(6, 4, NULL, 'ORD0006', 2359655, 'COD', 'delivered', '2026-02-07 10:58:11'),
(7, 7, NULL, 'ORD0007', 6165639, 'COD', 'delivered', '2026-02-16 10:58:11'),
(8, 17, NULL, 'ORD0008', 565049, 'COD', 'pending', '2026-01-01 10:58:11'),
(9, 10, NULL, 'ORD0009', 421926, 'COD', 'delivered', '2026-02-20 10:58:11'),
(10, 10, NULL, 'ORD0010', 1201596, 'COD', 'shipping', '2026-02-23 10:58:11'),
(11, 20, NULL, 'ORD0011', 4872876, 'COD', 'pending', '2026-01-30 10:58:11'),
(12, 9, NULL, 'ORD0012', 3940177, 'COD', 'cancelled', '2026-02-11 10:58:11'),
(13, 4, NULL, 'ORD0013', 6929380, 'COD', 'waiting_confirm', '2026-01-07 10:58:11'),
(14, 17, NULL, 'ORD0014', 5828235, 'COD', 'delivered', '2025-12-13 10:58:11'),
(15, 14, NULL, 'ORD0015', 6895490, 'COD', 'delivered', '2026-05-10 10:58:11'),
(16, 14, NULL, 'ORD0016', 701484, 'COD', 'waiting_confirm', '2026-03-15 10:58:11'),
(17, 18, NULL, 'ORD0017', 5166521, 'COD', 'waiting_confirm', '2026-02-13 10:58:11'),
(18, 18, NULL, 'ORD0018', 4556765, 'COD', 'delivered', '2026-03-08 10:58:11'),
(19, 10, NULL, 'ORD0019', 1750029, 'COD', 'waiting_confirm', '2026-01-24 10:58:11'),
(20, 10, NULL, 'ORD0020', 4119437, 'COD', 'waiting_confirm', '2026-04-22 10:58:11'),
(21, 16, NULL, 'ORD0021', 1292336, 'COD', 'pending', '2026-01-12 10:58:11'),
(22, 5, NULL, 'ORD0022', 2339822, 'COD', 'cancelled', '2026-02-17 10:58:11'),
(23, 7, NULL, 'ORD0023', 5892368, 'COD', 'cancelled', '2026-05-14 10:58:11'),
(24, 2, NULL, 'ORD0024', 1566446, 'COD', 'waiting_confirm', '2026-03-16 10:58:11'),
(25, 15, NULL, 'ORD0025', 3705266, 'COD', 'pending', '2026-02-01 10:58:11'),
(26, 5, NULL, 'ORD0026', 1475342, 'COD', 'waiting_confirm', '2025-12-19 10:58:11'),
(27, 5, NULL, 'ORD0027', 4932982, 'COD', 'pending', '2026-05-18 10:58:11'),
(28, 8, NULL, 'ORD0028', 2026470, 'COD', 'shipping', '2026-01-16 10:58:11'),
(29, 2, NULL, 'ORD0029', 3350910, 'COD', 'waiting_confirm', '2026-02-24 10:58:11'),
(30, 5, NULL, 'ORD0030', 2300622, 'COD', 'shipping', '2025-12-21 10:58:11'),
(31, 20, NULL, 'ORD0031', 4061703, 'COD', 'waiting_confirm', '2026-02-05 10:58:11'),
(32, 19, NULL, 'ORD0032', 9931544, 'COD', 'shipping', '2026-05-02 10:58:11'),
(33, 3, NULL, 'ORD0033', 4746293, 'COD', 'waiting_confirm', '2026-04-24 10:58:11'),
(34, 15, NULL, 'ORD0034', 6338521, 'COD', 'cancelled', '2026-02-04 10:58:11'),
(35, 8, NULL, 'ORD0035', 2294268, 'COD', 'cancelled', '2026-04-17 10:58:11'),
(36, 14, NULL, 'ORD0036', 879597, 'COD', 'shipping', '2025-12-28 10:58:11'),
(37, 12, NULL, 'ORD0037', 2743565, 'COD', 'pending', '2026-05-26 10:58:11'),
(38, 2, NULL, 'ORD0038', 1525889, 'COD', 'pending', '2026-03-16 10:58:11'),
(39, 3, NULL, 'ORD0039', 1410276, 'COD', 'shipping', '2026-01-27 10:58:11'),
(40, 5, NULL, 'ORD0040', 1644440, 'COD', 'cancelled', '2026-04-20 10:58:11'),
(41, 6, NULL, 'ORD0041', 2957108, 'COD', 'shipping', '2026-05-03 10:58:11'),
(42, 2, NULL, 'ORD0042', 2559573, 'COD', 'cancelled', '2025-12-22 10:58:11'),
(43, 1, NULL, 'ORD0043', 5324746, 'COD', 'shipping', '2026-04-17 10:58:11'),
(44, 18, NULL, 'ORD0044', 883749, 'COD', 'shipping', '2026-06-01 10:58:11'),
(45, 10, NULL, 'ORD0045', 2031308, 'COD', 'pending', '2026-03-19 10:58:11'),
(46, 20, NULL, 'ORD0046', 5948068, 'COD', 'delivered', '2025-12-28 10:58:11'),
(47, 14, NULL, 'ORD0047', 3319134, 'COD', 'delivered', '2025-12-12 10:58:11'),
(48, 8, NULL, 'ORD0048', 145995, 'COD', 'waiting_confirm', '2025-12-14 10:58:11'),
(49, 14, NULL, 'ORD0049', 2724709, 'COD', 'shipping', '2026-02-11 10:58:11'),
(50, 10, NULL, 'ORD0050', 5024319, 'COD', 'delivered', '2026-03-11 10:58:11'),
(51, 21, 41, 'ORD20260605113010', 795088, 'cod', 'waiting_confirm', '2026-06-05 09:30:10'),
(52, 21, 41, 'ORD20260605114730', 451434, 'cod', 'waiting_confirm', '2026-06-05 09:47:30'),
(53, 21, 41, 'ORD20260605115527', 591912, 'cod', 'waiting_confirm', '2026-06-05 09:55:27'),
(54, 21, 41, 'ORD20260605115904', 170478, 'cod', 'waiting_confirm', '2026-06-05 09:59:04'),
(55, 21, 41, 'ORD20260605120055', 823842, 'cod', 'waiting_confirm', '2026-06-05 10:00:55'),
(56, 21, 41, 'ORD20260605120422', 170478, 'cod', 'waiting_confirm', '2026-06-05 10:04:22'),
(57, 21, 41, 'ORD20260605120631', 256962, 'cod', 'waiting_confirm', '2026-06-05 10:06:31'),
(58, 21, 41, 'ORD20260605121135', 205371, 'cod', 'delivered', '2026-06-05 10:11:35'),
(59, 21, 41, 'ORD20260608053552', 515389, 'cod', 'waiting_confirm', '2026-06-08 03:35:52');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `book_id`, `quantity`, `price`) VALUES
(1, 25, 90, 1, 565049),
(2, 27, 53, 1, 227020),
(3, 33, 15, 3, 377025),
(4, 14, 11, 3, 541340),
(5, 21, 82, 4, 323084),
(6, 43, 66, 3, 314418),
(7, 32, 98, 4, 441676),
(8, 1, 7, 2, 445067),
(9, 17, 70, 3, 323320),
(10, 29, 25, 3, 274857),
(11, 46, 96, 1, 321779),
(12, 19, 71, 2, 402755),
(13, 45, 23, 2, 423984),
(14, 35, 3, 1, 235518),
(15, 13, 9, 3, 498928),
(16, 50, 3, 1, 235518),
(17, 29, 44, 2, 279855),
(18, 9, 34, 1, 272732),
(19, 44, 84, 3, 294583),
(20, 13, 59, 1, 294312),
(21, 5, 97, 3, 374029),
(22, 40, 33, 1, 373632),
(23, 15, 69, 3, 165586),
(24, 38, 6, 1, 341125),
(25, 49, 76, 4, 175371),
(26, 11, 34, 1, 272732),
(27, 13, 9, 3, 498928),
(28, 13, 11, 4, 541340),
(29, 35, 2, 1, 214287),
(30, 7, 55, 2, 149194),
(31, 48, 80, 1, 145995),
(32, 11, 69, 4, 165586),
(33, 3, 79, 4, 494608),
(34, 23, 99, 3, 167044),
(35, 49, 8, 2, 122603),
(36, 4, 96, 3, 321779),
(37, 50, 25, 2, 274857),
(38, 30, 16, 1, 418493),
(39, 32, 5, 2, 247073),
(40, 36, 47, 1, 535231),
(41, 28, 22, 2, 145246),
(42, 17, 48, 2, 184219),
(43, 26, 41, 3, 352283),
(44, 14, 89, 3, 168475),
(45, 12, 45, 3, 382703),
(46, 18, 16, 3, 418493),
(47, 7, 53, 1, 227020),
(48, 24, 76, 2, 175371),
(49, 22, 13, 2, 140478),
(50, 14, 34, 4, 272732),
(51, 19, 24, 1, 306255),
(52, 33, 3, 1, 235518),
(53, 38, 28, 1, 327616),
(54, 34, 9, 2, 498928),
(55, 33, 15, 4, 377025),
(56, 19, 61, 4, 159566),
(57, 27, 4, 3, 339159),
(58, 46, 76, 1, 175371),
(59, 49, 73, 3, 184333),
(60, 12, 13, 4, 140478),
(61, 16, 76, 4, 175371),
(62, 46, 9, 3, 498928),
(63, 2, 21, 4, 431023),
(64, 47, 93, 4, 566880),
(65, 18, 27, 2, 426662),
(66, 34, 49, 2, 434045),
(67, 32, 92, 3, 483688),
(68, 30, 97, 1, 374029),
(69, 20, 82, 4, 323084),
(70, 43, 71, 4, 402755),
(71, 31, 24, 2, 306255),
(72, 2, 15, 3, 377025),
(73, 27, 84, 3, 294583),
(74, 31, 22, 1, 145246),
(75, 22, 51, 1, 532372),
(76, 33, 58, 4, 295404),
(77, 41, 31, 1, 338713),
(78, 31, 78, 1, 538476),
(79, 40, 86, 4, 163136),
(80, 6, 73, 2, 184333),
(81, 17, 78, 4, 538476),
(82, 49, 24, 2, 306255),
(83, 42, 26, 4, 556124),
(84, 7, 31, 1, 338713),
(85, 40, 49, 1, 434045),
(86, 2, 82, 1, 323084),
(87, 31, 1, 1, 333436),
(88, 3, 61, 4, 159566),
(89, 27, 2, 3, 214287),
(90, 28, 17, 1, 440258),
(91, 25, 88, 4, 487539),
(92, 46, 80, 2, 145995),
(93, 50, 16, 4, 418493),
(94, 20, 69, 1, 165586),
(95, 50, 31, 3, 338713),
(96, 45, 79, 1, 494608),
(97, 41, 33, 1, 373632),
(98, 7, 96, 2, 321779),
(99, 7, 47, 4, 535231),
(100, 15, 62, 1, 388106),
(101, 13, 63, 2, 517941),
(102, 47, 58, 1, 295404),
(103, 35, 24, 1, 306255),
(104, 34, 12, 3, 335077),
(105, 24, 64, 4, 303926),
(106, 50, 65, 1, 226962),
(107, 11, 40, 2, 474101),
(108, 23, 26, 4, 556124),
(109, 47, 84, 2, 294583),
(110, 22, 96, 2, 321779),
(111, 31, 60, 1, 361566),
(112, 41, 69, 4, 165586),
(113, 45, 50, 4, 172183),
(114, 26, 16, 1, 418493),
(115, 38, 2, 4, 214287),
(116, 6, 3, 4, 235518),
(117, 50, 49, 2, 434045),
(118, 46, 11, 4, 541340),
(119, 34, 98, 4, 441676),
(120, 18, 16, 3, 418493),
(121, 12, 92, 4, 483688),
(122, 43, 48, 4, 184219),
(123, 35, 2, 4, 214287),
(124, 43, 28, 4, 327616),
(125, 23, 66, 4, 314418),
(126, 39, 97, 3, 374029),
(127, 43, 60, 2, 361566),
(128, 14, 14, 4, 138601),
(129, 49, 24, 2, 306255),
(130, 30, 15, 4, 377025),
(131, 25, 51, 1, 532372),
(132, 32, 3, 2, 235518),
(133, 17, 80, 4, 145995),
(134, 28, 84, 2, 294583),
(135, 46, 9, 3, 498928),
(136, 15, 29, 3, 417560),
(137, 7, 88, 4, 487539),
(138, 14, 42, 2, 193359),
(139, 5, 67, 1, 150085),
(140, 15, 31, 3, 338713),
(141, 14, 45, 2, 382703),
(142, 32, 97, 4, 374029),
(143, 39, 8, 1, 122603),
(144, 4, 22, 4, 145246),
(145, 23, 77, 2, 460388),
(146, 11, 52, 4, 363413),
(147, 11, 21, 2, 431023),
(148, 17, 52, 3, 363413),
(149, 15, 72, 3, 561378),
(150, 27, 42, 3, 193359),
(151, 14, 85, 2, 450667),
(152, 23, 5, 4, 247073),
(153, 12, 58, 1, 295404),
(154, 4, 90, 2, 565049),
(155, 33, 46, 2, 344992),
(156, 6, 72, 1, 561378),
(157, 47, 99, 1, 167044),
(158, 40, 48, 1, 184219),
(159, 39, 69, 1, 165586),
(160, 37, 16, 3, 418493),
(161, 29, 6, 3, 341125),
(162, 27, 2, 3, 214287),
(163, 27, 13, 4, 140478),
(164, 32, 13, 4, 140478),
(165, 20, 71, 2, 402755),
(166, 32, 13, 3, 140478),
(167, 11, 89, 4, 168475),
(168, 15, 9, 3, 498928),
(169, 28, 3, 3, 235518),
(170, 25, 91, 1, 473356),
(171, 31, 88, 3, 487539),
(172, 6, 88, 1, 487539),
(173, 37, 44, 4, 279855),
(174, 32, 17, 4, 440258),
(175, 10, 15, 1, 377025),
(176, 22, 59, 3, 294312),
(177, 32, 15, 4, 377025),
(178, 34, 93, 3, 566880),
(179, 7, 93, 1, 566880),
(180, 18, 4, 1, 339159),
(181, 31, 64, 2, 303926),
(182, 35, 53, 3, 227020),
(183, 10, 25, 3, 274857),
(184, 36, 50, 2, 172183),
(185, 13, 17, 1, 440258),
(186, 5, 12, 2, 335077),
(187, 2, 32, 2, 402046),
(188, 27, 15, 1, 377025),
(189, 20, 47, 1, 535231),
(190, 18, 27, 2, 426662),
(191, 37, 73, 2, 184333),
(192, 50, 65, 2, 226962),
(193, 20, 17, 3, 440258),
(194, 42, 12, 1, 335077),
(195, 9, 55, 1, 149194),
(196, 25, 73, 1, 184333),
(197, 41, 43, 3, 527473),
(198, 15, 30, 3, 186963),
(199, 8, 90, 1, 565049),
(200, 29, 66, 3, 314418),
(201, 51, 13, 1, 140478),
(202, 51, 34, 1, 272732),
(203, 51, 39, 1, 351878),
(204, 52, 13, 3, 140478),
(205, 53, 13, 4, 140478),
(206, 54, 13, 1, 140478),
(207, 55, 93, 1, 566880),
(208, 55, 65, 1, 226962),
(209, 56, 13, 1, 140478),
(210, 57, 65, 1, 226962),
(211, 58, 76, 1, 175371),
(212, 59, 83, 1, 127279),
(213, 59, 19, 2, 179055);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `book_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 71, 18, 5, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(2, 30, 14, 4, 'Sách rất hay', '2026-06-01 10:58:28'),
(3, 22, 11, 4, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(4, 78, 20, 5, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(5, 2, 4, 4, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(6, 96, 17, 4, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(7, 48, 14, 4, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(8, 5, 7, 3, 'Đáng đọc', '2026-06-01 10:58:28'),
(9, 14, 17, 3, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(10, 25, 19, 4, 'Sách rất hay', '2026-06-01 10:58:28'),
(11, 16, 15, 4, 'Đáng đọc', '2026-06-01 10:58:28'),
(12, 9, 1, 4, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(13, 33, 17, 3, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(14, 68, 18, 5, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(15, 28, 9, 3, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(16, 44, 9, 5, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(17, 39, 1, 5, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(18, 41, 10, 4, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(19, 13, 7, 5, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(20, 5, 16, 5, 'Sách rất hay', '2026-06-01 10:58:28'),
(21, 45, 4, 5, 'Sách rất hay', '2026-06-01 10:58:28'),
(22, 26, 16, 3, 'Đáng đọc', '2026-06-01 10:58:28'),
(23, 71, 6, 4, 'Sách rất hay', '2026-06-01 10:58:28'),
(24, 52, 12, 5, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(25, 74, 18, 5, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(26, 84, 12, 4, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(27, 96, 11, 3, 'Sách rất hay', '2026-06-01 10:58:28'),
(28, 80, 1, 5, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(29, 29, 1, 4, 'Sách rất hay', '2026-06-01 10:58:28'),
(30, 50, 12, 5, 'Sách rất hay', '2026-06-01 10:58:28'),
(31, 31, 2, 3, 'Đáng đọc', '2026-06-01 10:58:28'),
(32, 77, 20, 5, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(33, 91, 5, 5, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(34, 24, 9, 5, 'Sách rất hay', '2026-06-01 10:58:28'),
(35, 91, 13, 4, 'Sách rất hay', '2026-06-01 10:58:28'),
(36, 99, 2, 4, 'Sách rất hay', '2026-06-01 10:58:28'),
(37, 24, 19, 4, 'Sách rất hay', '2026-06-01 10:58:28'),
(38, 83, 4, 4, 'Đáng đọc', '2026-06-01 10:58:28'),
(39, 96, 11, 3, 'Sách rất hay', '2026-06-01 10:58:28'),
(40, 5, 18, 4, 'Sách rất hay', '2026-06-01 10:58:28'),
(41, 37, 16, 4, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(42, 62, 15, 5, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(43, 26, 4, 5, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(44, 5, 18, 4, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(45, 36, 5, 3, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(46, 29, 18, 5, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(47, 86, 2, 5, 'Đáng đọc', '2026-06-01 10:58:28'),
(48, 38, 5, 3, 'Đáng đọc', '2026-06-01 10:58:28'),
(49, 54, 5, 5, 'Đáng đọc', '2026-06-01 10:58:28'),
(50, 49, 14, 3, 'Sách rất hay', '2026-06-01 10:58:28'),
(51, 30, 20, 4, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(52, 27, 16, 5, 'Sách rất hay', '2026-06-01 10:58:28'),
(53, 15, 10, 3, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(54, 37, 17, 4, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(55, 93, 19, 5, 'Đáng đọc', '2026-06-01 10:58:28'),
(56, 78, 3, 4, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(57, 41, 11, 4, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(58, 88, 12, 5, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(59, 59, 16, 4, 'Đáng đọc', '2026-06-01 10:58:28'),
(60, 11, 8, 4, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(61, 73, 11, 3, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(62, 48, 14, 4, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(63, 22, 12, 4, 'Sách rất hay', '2026-06-01 10:58:28'),
(64, 7, 5, 4, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(65, 7, 7, 4, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(66, 19, 19, 3, 'Sách rất hay', '2026-06-01 10:58:28'),
(67, 90, 16, 3, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(68, 89, 13, 4, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(69, 48, 3, 3, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(70, 96, 19, 5, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(71, 59, 4, 4, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(72, 61, 19, 3, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(73, 31, 11, 5, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(74, 28, 9, 3, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(75, 24, 8, 3, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(76, 48, 16, 3, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(77, 77, 3, 4, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(78, 35, 11, 3, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(79, 71, 13, 4, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(80, 31, 8, 4, 'Đáng đọc', '2026-06-01 10:58:28'),
(81, 87, 8, 3, 'Đáng đọc', '2026-06-01 10:58:28'),
(82, 41, 7, 3, 'Đáng đọc', '2026-06-01 10:58:28'),
(83, 94, 8, 4, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(84, 100, 7, 5, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(85, 24, 17, 5, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(86, 1, 7, 5, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(87, 60, 14, 5, 'Sách rất hay', '2026-06-01 10:58:28'),
(88, 45, 7, 3, 'Sách rất hay', '2026-06-01 10:58:28'),
(89, 95, 9, 4, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(90, 26, 19, 4, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(91, 27, 7, 4, 'Sách rất hay', '2026-06-01 10:58:28'),
(92, 24, 6, 3, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(93, 75, 16, 4, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(94, 94, 20, 5, 'Sách rất hay', '2026-06-01 10:58:28'),
(95, 34, 12, 5, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(96, 65, 6, 4, 'Chất lượng tốt', '2026-06-01 10:58:28'),
(97, 82, 17, 4, 'Nội dung hấp dẫn', '2026-06-01 10:58:28'),
(98, 48, 12, 5, 'Giao hàng nhanh', '2026-06-01 10:58:28'),
(99, 66, 14, 3, 'Sách rất hay', '2026-06-01 10:58:28'),
(100, 28, 10, 5, 'Sách rất hay', '2026-06-01 10:58:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `avatar`, `created_at`, `updated_at`, `role`) VALUES
(1, 'User 1', 'user1@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0993243138', '1780477858_diamond alert.jpg', '2026-06-01 10:57:59', '2026-06-03 09:10:58', 'user'),
(2, 'User 2', 'user2@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0925615634', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(3, 'User 3', 'user3@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0948348759', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(4, 'User 4', 'user4@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0964896899', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(5, 'User 5', 'user5@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0979438222', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(6, 'User 6', 'user6@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0902500418', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(7, 'User 7', 'user7@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0974187426', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(8, 'User 8', 'user8@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0963435881', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(9, 'User 9', 'user9@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0994617129', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(10, 'User 10', 'user10@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0982778010', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(11, 'User 11', 'user11@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0930038669', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(12, 'User 12', 'user12@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0901859316', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(13, 'User 13', 'user13@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0919180575', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(14, 'User 14', 'user14@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0990324930', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(15, 'User 15', 'user15@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0994082933', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(16, 'User 16', 'user16@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0999439879', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(17, 'User 17', 'user17@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0914950603', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(18, 'User 18', 'user18@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0976433378', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(19, 'User 19', 'user19@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0937315085', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(20, 'User 20', 'user20@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0957275297', NULL, '2026-06-01 10:57:59', '2026-06-01 11:12:39', 'user'),
(21, 'Admin', 'admin@gmail.com', '$2y$10$/TpCjAPIhb7oTeVQ3hx7XuD189ilxp2ACTlrKjLUYO9XB76oNAnv6', '0123456789', 'avatar_6a25b5ea2bb8e.png', '2026-06-03 09:58:57', '2026-06-07 18:18:18', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_categories`
--
ALTER TABLE `book_categories`
  ADD PRIMARY KEY (`book_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`book_id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`,`book_id`),
  ADD UNIQUE KEY `user_id_3` (`user_id`,`book_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_orders_address` (`address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_items_order` (`order_id`),
  ADD KEY `fk_order_items_book` (`book_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `book_categories`
--
ALTER TABLE `book_categories`
  ADD CONSTRAINT `book_categories_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_address` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
