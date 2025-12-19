-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2025 at 06:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_reservation_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`id`, `admin_id`, `name`, `email`, `created_at`, `updated_at`) VALUES
(1, 1, 'amaro johnly', 'amarojohnlypepino@gmail.com', '2025-12-05 07:57:06', '2025-12-05 07:57:06');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `email`, `password`, `created_at`) VALUES
(1, 'sample2@gmail.com', 'amaro123', '2025-12-06 10:27:04'),
(2, 'sample@gmail.com', 'amaro123', '2025-12-06 11:06:56'),
(3, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 14:38:27'),
(4, 'sample2@gmail.com', 'amaro123', '2025-12-06 14:42:22'),
(5, 'sample2@gmail.com', 'amaro123', '2025-12-06 14:44:13'),
(6, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 15:09:56'),
(7, 'sample2@gmail.com', 'amaro123', '2025-12-06 15:13:25'),
(8, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 15:13:54'),
(9, 'sample2@gmail.com', 'amaro123', '2025-12-06 15:14:53'),
(10, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 15:30:40'),
(11, 'sample2@gmail.com', 'amaro123', '2025-12-06 15:34:05'),
(12, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 15:35:17'),
(13, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 15:36:14'),
(14, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 15:50:38'),
(15, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 15:51:57'),
(16, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 15:54:51'),
(17, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 16:12:20'),
(18, 'sample2@gmail.com', 'amaro123', '2025-12-06 16:20:55'),
(19, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 16:23:20'),
(20, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 16:37:05'),
(21, 'sample2@gmail.com', 'amaro123', '2025-12-06 16:59:52'),
(22, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 17:00:18'),
(23, 'sample2@gmail.com', 'amaro123', '2025-12-06 17:00:50'),
(24, 'sample2@gmail.com', 'amaro123', '2025-12-06 17:01:14'),
(25, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 19:22:21'),
(26, 'sample2@gmail.com', 'amaro123', '2025-12-06 19:22:42'),
(27, 'sample2@gmail.com', 'amaro123', '2025-12-06 19:45:58'),
(28, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 20:02:04'),
(29, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-06 20:02:26'),
(30, 'sample@gmail.com', 'amaro123', '2025-12-06 20:02:39'),
(31, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 20:34:01'),
(32, 'sample2@gmail.com', 'amaro123', '2025-12-06 20:34:31'),
(33, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 20:41:36'),
(34, 'sample2@gmail.com', 'amaro123', '2025-12-06 20:42:13'),
(35, 'sample2@gmail.com', 'amaro123', '2025-12-06 20:42:59'),
(36, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 20:43:47'),
(37, 'sample2@gmail.com', 'amaro123', '2025-12-06 20:44:07'),
(38, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 20:44:56'),
(39, 'sample2@gmail.com', 'amaro123', '2025-12-06 20:45:14'),
(40, 'sample2@gmail.com', 'amaro123', '2025-12-06 20:46:22'),
(41, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 20:47:35'),
(42, 'sample2@gmail.com', 'amaro123', '2025-12-06 20:47:53'),
(43, 'sample2@gmail.com', 'amaro123', '2025-12-06 20:51:55'),
(44, 'sample@gmail.com', 'amaro123', '2025-12-06 20:59:23'),
(45, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 21:00:06'),
(46, 'sample@gmail.com', 'amaro123', '2025-12-06 21:00:28'),
(47, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 21:04:01'),
(48, 'sample@gmail.com', 'amaro123', '2025-12-06 21:04:23'),
(49, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 21:13:22'),
(50, 'sample@gmail.com', 'amaro123', '2025-12-06 21:13:45'),
(51, 'sample2@gmail.com', 'amaro123', '2025-12-06 21:14:35'),
(52, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 21:15:14'),
(53, 'sample2@gmail.com', 'amaro123', '2025-12-06 21:15:35'),
(54, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 21:23:50'),
(55, 'sample2@gmail.com', 'amaro123', '2025-12-06 21:24:05'),
(56, 'sample2@gmail.com', 'amaro123', '2025-12-06 21:34:13'),
(57, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 21:35:14'),
(58, 'sample2@gmail.com', 'amaro123', '2025-12-06 21:35:37'),
(59, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 21:49:08'),
(60, 'sample2@gmail.com', 'amaro123', '2025-12-06 21:49:24'),
(61, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 21:52:07'),
(62, 'sample2@gmail.com', 'amaro123', '2025-12-06 21:52:41'),
(63, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-06 21:53:05'),
(64, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 21:55:46'),
(65, 'sample2@gmail.com', 'amaro123', '2025-12-06 22:13:50'),
(66, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 22:14:28'),
(67, 'sample2@gmail.com', 'amaro123', '2025-12-06 22:15:21'),
(68, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 22:15:59'),
(69, 'sample2@gmail.com', 'amaro123', '2025-12-06 22:30:46'),
(70, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 22:31:18'),
(71, 'sample2@gmail.com', 'amaro123', '2025-12-06 22:31:42'),
(72, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 22:31:58'),
(73, 'sample2@gmail.com', 'amaro123', '2025-12-06 22:32:22'),
(74, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 22:44:08'),
(75, 'sample2@gmail.com', 'amaro123', '2025-12-06 22:44:29'),
(76, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 22:44:44'),
(77, 'sample2@gmail.com', 'amaro123', '2025-12-06 22:45:12'),
(78, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 22:54:26'),
(79, 'sample2@gmail.com', 'amaro123', '2025-12-06 22:55:36'),
(80, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 22:56:26'),
(81, 'sample2@gmail.com', 'amaro123', '2025-12-06 23:03:22'),
(82, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 23:21:38'),
(83, 'sample@gmail.com', 'amaro123', '2025-12-06 23:22:14'),
(84, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-06 23:23:04'),
(85, 'sample@gmail.com', 'amaro123', '2025-12-06 23:24:13'),
(86, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-06 23:24:27'),
(87, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 08:03:55'),
(88, 'sample2@gmail.com', 'amaro123', '2025-12-07 08:34:15'),
(89, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 08:34:49'),
(90, 'sample2@gmail.com', 'amaro123', '2025-12-07 08:51:13'),
(91, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 08:53:31'),
(92, 'sample2@gmail.com', 'amaro123', '2025-12-07 09:05:22'),
(93, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 09:23:23'),
(94, 'sample2@gmail.com', 'amaro123', '2025-12-07 09:43:22'),
(95, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 09:43:44'),
(96, 'sample2@gmail.com', 'amaro123', '2025-12-07 09:47:40'),
(97, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 10:02:34'),
(98, 'sample2@gmail.com', 'amaro123', '2025-12-07 10:04:06'),
(99, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 10:13:03'),
(100, 'sample2@gmail.com', 'amaro123', '2025-12-07 10:15:29'),
(101, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 10:16:44'),
(102, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 10:18:08'),
(103, 'sample2@gmail.com', 'amaro123', '2025-12-07 10:25:49'),
(104, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 10:27:37'),
(105, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 10:28:33'),
(106, 'sample2@gmail.com', 'amaro123', '2025-12-07 10:40:21'),
(107, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 10:41:56'),
(108, 'sample2@gmail.com', 'amaro123', '2025-12-07 10:46:18'),
(109, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 10:48:52'),
(110, 'sample2@gmail.com', 'amaro123', '2025-12-07 10:49:11'),
(111, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 10:51:28'),
(112, 'sample@gmail.com', 'amaro123', '2025-12-07 10:54:00'),
(113, 'sample2@gmail.com', 'amaro123', '2025-12-07 10:54:27'),
(114, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 10:55:56'),
(115, 'sample2@gmail.com', 'amaro123', '2025-12-07 11:01:22'),
(116, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 11:01:56'),
(117, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 11:19:19'),
(118, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 11:19:34'),
(119, 'sample2@gmail.com', 'amaro123', '2025-12-07 11:27:54'),
(120, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 11:28:18'),
(121, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 11:29:04'),
(122, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 11:50:21'),
(123, 'sample2@gmail.com', 'amaro123', '2025-12-07 11:50:42'),
(124, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 11:51:40'),
(125, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 11:51:59'),
(126, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 12:03:35'),
(127, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 12:08:55'),
(128, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 12:13:05'),
(129, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 12:15:44'),
(130, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 12:16:49'),
(131, 'sample@gmail.com', 'amaro123', '2025-12-07 12:18:31'),
(132, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 12:19:08'),
(133, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 12:19:32'),
(134, 'sample@gmail.com', 'amaro123', '2025-12-07 12:20:06'),
(135, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 12:23:57'),
(136, 'sample@gmail.com', 'amaro123', '2025-12-07 12:25:05'),
(137, 'sample@gmail.com', 'amaro123', '2025-12-07 12:25:25'),
(138, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 12:25:45'),
(139, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 12:26:14'),
(140, 'sample@gmail.com', 'amaro123', '2025-12-07 12:26:34'),
(141, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 12:26:51'),
(142, 'amarojohnlypepino@gmail.com', 'amaro123', '2025-12-07 12:27:26'),
(143, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 12:28:11'),
(144, 'sample@gmail.com', 'amaro123', '2025-12-07 12:37:08'),
(145, 'sample@gmail.com', 'amaro123', '2025-12-07 12:49:50'),
(146, 'lesliemiot794@gmail.com', 'amaro123', '2025-12-07 12:53:10'),
(147, 'sample@gmail.com', 'amaro123', '2025-12-07 12:54:52'),
(148, 'sample2@gmail.com', 'amaro123', '2025-12-07 13:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `checkin_date` date DEFAULT NULL,
  `checkout_date` date DEFAULT NULL,
  `reservation_code` varchar(225) NOT NULL,
  `payment_status` varchar(225) NOT NULL DEFAULT 'pending',
  `days_staying` int(11) NOT NULL DEFAULT 1,
  `payment_type` enum('Cash','GCash','Credit Card','PayPal') DEFAULT NULL,
  `options` text DEFAULT NULL,
  `payment_transaction` varchar(225) DEFAULT NULL,
  `status` varchar(225) NOT NULL DEFAULT 'pending',
  `admin_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `user_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `notifications` varchar(225) NOT NULL,
  `staff_notification` varchar(225) DEFAULT NULL,
  `staff_approved` tinyint(1) NOT NULL DEFAULT 0,
  `admin_approved` tinyint(1) NOT NULL DEFAULT 0,
  `admin_notification` varchar(225) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `room_id`, `checkin_date`, `checkout_date`, `reservation_code`, `payment_status`, `days_staying`, `payment_type`, `options`, `payment_transaction`, `status`, `admin_deleted`, `user_deleted`, `notifications`, `staff_notification`, `staff_approved`, `admin_approved`, `admin_notification`, `created_at`) VALUES
(76, 12, 1, '2025-12-07', '2025-12-08', '', 'pending', 1, 'GCash', 'Spa Access', NULL, 'Cancelled', 0, 0, '', 'Staff approved, awaiting admin approval', 1, 1, 'Your reservation has been cancelled by admin.', '2025-12-07 03:51:26');

-- --------------------------------------------------------

--
-- Table structure for table `staff_info`
--

CREATE TABLE `staff_info` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_info`
--

INSERT INTO `staff_info` (`id`, `staff_id`, `name`, `email`, `created_at`) VALUES
(1, 2, 'leslie', 'lesliemiot794@gmail.com', '2025-12-05 07:59:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(225) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','staff','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `full_name`, `created_at`, `role`) VALUES
(1, 'amarojohnlypepino@gmail.com', '$2y$10$gkD.SiSvhUWxwoWx1JO2DO6RD8OQ0uvCN2Nar9v3eiQwnXq8SRphG', '', '2025-12-02 00:05:58', 'user'),
(2, 'lesliemiot794@gmail.com', '$2y$10$XaDB9zxDnd8aG/Wc5Y.9s.W3v0U9n5AIipepqYMVJ4Wevudm4Ynni', '', '2025-12-02 00:05:02', 'user'),
(3, 'sample@gmail.com', '$2y$10$l0qkwrK7oAneIcETS3mVTudjzLw.Bh0xWudMm8rzgOa8VUE57oZ4i', '', '2025-12-03 21:13:08', 'user'),
(12, 'sample2@gmail.com', '$2y$10$fdOSOMZw5e10dQyJsic26e87LD8vlmpEaZWekhsoQ.GjNVVOA3SkW', '', '2025-12-03 23:52:52', 'user'),
(13, 'anale@gmail.com', '$2y$10$G3R4QuQ55JfYv.YuwIveK.2w5KboHlcFMdq755NyijUtjfX.x24HK', '', '2025-12-05 13:45:18', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `user_id`, `name`, `phone`, `address`, `created_at`) VALUES
(1, 11, 'amaro johnly', '09876544565', 'bais', '2025-12-03 14:51:24'),
(2, 3, 'amaro johnly', '09876544565', 'bais', '2025-12-03 15:30:56'),
(3, 12, 'leslie', '09876544000', 'bais', '2025-12-03 15:53:25'),
(4, 13, 'amaro johnly', '09876544565', 'bais', '2025-12-05 05:45:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_info`
--
ALTER TABLE `admin_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_admin` (`admin_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_info`
--
ALTER TABLE `staff_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_info`
--
ALTER TABLE `admin_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `staff_info`
--
ALTER TABLE `staff_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
