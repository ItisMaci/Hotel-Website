-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 07, 2025 at 11:10 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbaccess`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `fk_user_id` int(11) DEFAULT NULL,
  `fk_room_id` int(11) DEFAULT NULL,
  `checkin` date DEFAULT NULL,
  `checkout` date DEFAULT NULL,
  `breakfast_included` tinyint(1) DEFAULT 0,
  `parking_included` tinyint(1) DEFAULT 0,
  `pets_included` tinyint(1) DEFAULT 0,
  `payment_method` enum('cash') NOT NULL DEFAULT 'cash',
  `booking_status` enum('new','confirmed','canceled') NOT NULL,
  `price_total` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `fk_user_id`, `fk_room_id`, `checkin`, `checkout`, `breakfast_included`, `parking_included`, `pets_included`, `payment_method`, `booking_status`, `price_total`, `created_at`) VALUES
(13, 38, 12, '2025-01-09', '2025-01-11', 1, 0, 1, 'cash', 'new', 412.98, '2025-01-07 23:04:43'),
(14, 38, 11, '2025-01-23', '2025-01-25', 1, 1, 0, 'cash', 'new', 254.98, '2025-01-07 23:05:24');

-- --------------------------------------------------------

--
-- Table structure for table `booking_options`
--

CREATE TABLE `booking_options` (
  `booking_options_id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `booking_options`
--

INSERT INTO `booking_options` (`booking_options_id`, `description`, `price`) VALUES
(1, 'breakfast', 5.00),
(2, 'parking', 2.50),
(3, 'pets', 1.50);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `text` text NOT NULL,
  `file_reference` varchar(255) NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `image`, `text`, `file_reference`, `post_date`) VALUES
(93, 'sean-oulashin-KMn4VEeEPR8-unsplash.jpg', 'Water', './assets/news_thumbnail/thumbnail__sean-oulashin-KMn4VEeEPR8-unsplash.jpg', '2025-01-05 21:08:14'),
(94, 'beach_view.jpg', 'A beautiful view of our beach houses.', './assets/news_thumbnail/thumbnail_93_beach_view.jpg', '2025-01-07 22:59:45');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_number` int(11) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image_reference` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_number`, `room_type`, `price`, `description`, `image_reference`) VALUES
(10, 101, 'Single', 79.99, 'A cozy single room with a queen-sized bed.', '/Hotel-Website/images/rooms/room1.jpg'),
(11, 202, 'Double', 119.99, 'A spacious double room with two twin beds.', '/Hotel-Website/images/rooms/room2.jpg'),
(12, 303, 'Suite', 199.99, 'A luxurious suite with a king-sized bed and a balcony.', '/Hotel-Website/images/rooms/room3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `is_admin` tinyint(4) NOT NULL DEFAULT 0,
  `active` int(11) NOT NULL DEFAULT 0,
  `email` varchar(100) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `gender`, `firstName`, `lastName`, `username`, `is_admin`, `active`, `email`, `pwd`, `created_at`) VALUES
(37, 'male', 'admin', 'admin', 'admin', 1, 0, 'admin@admin.com', '$2y$12$uMfV83AGDM.B4W5y8TdrqulCGeIb5FLWECEN/jxgwoEsDZKonxwFy', '2025-01-05 21:02:37'),
(38, 'male', 'user', 'user', 'user', 0, 0, 'user@user.com', '$2y$12$PDmcUxTCq27yQTk2OvtGj.F0yq5re5/eTNFU6JE.GPoxiZHw2d4jS', '2025-01-05 21:02:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `booking_user_const` (`fk_user_id`),
  ADD KEY `booking_room_const` (`fk_room_id`);

--
-- Indexes for table `booking_options`
--
ALTER TABLE `booking_options`
  ADD PRIMARY KEY (`booking_options_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `booking_options`
--
ALTER TABLE `booking_options`
  MODIFY `booking_options_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `booking_room_const` FOREIGN KEY (`fk_room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `booking_user_const` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
