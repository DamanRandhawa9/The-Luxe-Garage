-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 25, 2025 at 12:29 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luxe_garage`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password_hash`, `email`) VALUES
(1, 'damanrandhawa9', '$2y$10$VoYwRdCXjPQSRhJ3EPqZguLm4FMxN7gJbv1hqx4oz3TxkW3oXV5Yq', 'damandeeps094@gmail.com'),
(2, 'admin', '$2y$10$CLq.0jNQwB30SzNV.RvHkeT7Ilm5gc4HLgw1RcwRih5nYgSYPzYs6', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `booking_id` int NOT NULL AUTO_INCREMENT,
  `car_id` int DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `preferred_date` date DEFAULT NULL,
  `booking_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`booking_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `car_id`, `name`, `email`, `preferred_date`, `booking_date`) VALUES
(1, 1, 'Daman', 'user101@yahoo.com', '2026-01-12', '2025-05-25 02:51:59'),
(2, 1, 'Daman', 'damandewjwid@gmail.com', '2025-06-24', '2025-05-25 06:59:26');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
CREATE TABLE IF NOT EXISTS `cars` (
  `car_id` int NOT NULL AUTO_INCREMENT,
  `seller_id` int DEFAULT NULL,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `year` int NOT NULL,
  `mileage` int NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `car_condition` enum('New','Used','Certified Pre-Owned') NOT NULL,
  `description` text,
  `location` varchar(100) NOT NULL,
  `images` json NOT NULL,
  `status` enum('Available','Sold','Pending') NOT NULL,
  `date_listed` datetime DEFAULT CURRENT_TIMESTAMP,
  `verified` tinyint(1) DEFAULT '0',
  `trending` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`car_id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `seller_id`, `make`, `model`, `year`, `mileage`, `price`, `car_condition`, `description`, `location`, `images`, `status`, `date_listed`, `verified`, `trending`) VALUES
(1, 201, 'Ford', 'Mustang GT', 2022, 12000, '72000.00', 'Used', 'Iconic American muscle car with V8 engine.', 'Hurstville, NSW', '[\"mustang_gt.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0),
(2, 202, 'Chevrolet', 'Camaro SS', 2025, 0, '121000.00', 'New', 'powerful performance.', 'Kogarah, NSW', '[\"camaro_ss.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0),
(3, 203, 'Dodge', 'Challenger R/T', 2020, 15000, '45000.00', 'Used', 'Classic muscle with modern tech.', 'Sydney, NSW', '[\"challenger_rt.jpg\"]', 'Pending', '2025-05-01 00:00:00', 1, 1),
(4, 204, 'Ford', 'Shelby GT500', 2023, 4000, '78000.00', '', 'Supercharged V8, track-ready.', 'Tarneit, Victoria', '[\"shelby_gt500.jpg\"]', 'Sold', '2025-05-18 00:00:00', 1, 0),
(5, 205, 'Chevrolet', 'Corvette Stingray', 2022, 8000, '68000.00', '', 'Mid-engine muscle, breathtaking design.', 'Orange, NSW', '[\"corvette_stingray.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0),
(6, 206, 'Dodge', 'Charger SRT Hellcat', 2021, 12000, '72000.00', '', 'Supercharged muscle sedan.', 'Atlanta, ACT', '[\"charger_hellcat.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0),
(7, 207, 'Pontiac', 'GTO', 2006, 45000, '30000.00', '', 'Modern classic muscle, limited edition.', 'Blacktown, NSW', '[\"pontiac_gto.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0),
(8, 208, 'Mercedes-Benz', 'S-Class S580', 2023, 5000, '110000.00', '', 'Flagship luxury sedan, loaded with tech.', 'Bendigo, Victoria', '[\"sclass_s580.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0),
(9, 209, 'BMW', '7 Series 750i', 2022, 7000, '95000.00', '', 'Executive sedan, ultimate comfort.', 'Mount Barker, SA', '[\"bmw_750i.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0),
(10, 210, 'Audi', 'A8 L', 2022, 6000, '90000.00', '', 'Spacious, refined, advanced features.', 'Tailem Bend, SA', '[\"audi_a8l.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0),
(11, 211, 'Lexus', 'LS 500', 2023, 4000, '85000.00', '', 'Japanese luxury, smooth ride.', 'Alice Springs, NT', '[\"lexus_ls500.jpg\"]', 'Available', '2025-05-18 00:00:00', 0, 0),
(12, 212, 'Genesis', 'G90', 2022, 9000, '70000.00', '', 'Luxury redefined', 'Midland, WA', '[\"genesis_g90.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0),
(13, 213, 'Jaguar', 'XJ', 2020, 15000, '60000.00', '', 'Elegant British luxury sedan.', 'Fremantle, WA', '[\"jaguar_xj.jpg\"]', 'Pending', '2025-05-18 00:00:00', 1, 0),
(14, 214, 'Lamborghini', 'Huracan EVO', 2021, 3000, '240000.00', 'Certified Pre-Owned', 'V10 power, Italian masterpiece.', 'Parramatta, NSW', '[\"huracan_evo.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 1),
(15, 215, 'Ferrari', '488 GTB', 2019, 8000, '270000.00', '', 'Turbocharged V8, thrilling drive.', 'Preston, Victoria', '[\"ferrari_488.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0),
(16, 216, 'McLaren', '720S', 2022, 4000, '310000.00', 'Certified Pre-Owned', 'Supercar performance, lightweight.', 'Gold Coast, Queensland', '[\"mclaren_720s.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0),
(17, 217, 'Aston Martin', 'DB11', 2025, 0, '280000.00', 'New', 'British luxury and performance.', 'Greenwich, NSW', '[\"aston_db11.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0),
(18, 218, 'Porsche', '911 Turbo S', 2023, 2000, '220000.00', 'Certified Pre-Owned', 'Legendary handling', 'Auburn, NSW', '[\"porsche_911.jpg\"]', 'Pending', '2025-05-18 00:00:00', 1, 1),
(19, 219, 'Bentley', 'Continental GT', 2025, 0, '210000.00', 'New', 'Ultimate grand tourer.', 'Potts Point, NSW', '[\"bentley_gt.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0),
(20, 220, 'Rolls-Royce', 'Wraith', 2025, 13000, '320000.00', 'New', 'Unparalleled luxury coupe.', 'Darwin,NT', '[\"rolls_wraith.jpg\"]', 'Available', '2025-05-18 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `car_images`
--

DROP TABLE IF EXISTS `car_images`;
CREATE TABLE IF NOT EXISTS `car_images` (
  `image_id` int NOT NULL AUTO_INCREMENT,
  `car_id` int DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `image_type` enum('Exterior','Interior','360') NOT NULL,
  PRIMARY KEY (`image_id`),
  KEY `car_id` (`car_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `car_images`
--

INSERT INTO `car_images` (`image_id`, `car_id`, `image_url`, `image_type`) VALUES
(1, 1, 'resources/mustang_gt.jpg', ''),
(2, 2, 'resources/camaro.jpg', ''),
(4, 4, 'resources/gt500.jpg', ''),
(5, 5, 'resources/stingray.jpg', ''),
(6, 6, 'resources/hellcat.jpg', ''),
(7, 7, 'resources/pont.jpg', ''),
(8, 8, 'resources/s500.jpg', ''),
(9, 9, 'resources/750i.jpg', ''),
(10, 10, 'resources/a8.jpg', ''),
(11, 11, 'resources/ls500.jpg', ''),
(12, 12, 'resources/g90.jpg', ''),
(13, 13, 'resources/xj.jpg', ''),
(14, 14, 'resources/evo.jpg', ''),
(15, 15, 'resources/488.jpg', ''),
(16, 16, 'resources/720.jpg', ''),
(17, 17, 'resources/db11.jpg', ''),
(18, 18, 'resources/911.jpg', ''),
(19, 19, 'resources/bentley.jpg', ''),
(20, 20, 'resources/rr.jpg', ''),
(3, 3, 'resources/rt.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(5, 'Daman', 'user101@yahoo.com', 'hi daman her, just want to know about the mustang car you posted.\r\ncan I bring my mechanic for inspection\r\nthanks.', '2025-05-25 11:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

DROP TABLE IF EXISTS `subscribers`;
CREATE TABLE IF NOT EXISTS `subscribers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `subscribed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `subscribed_at`) VALUES
(1, 'user101@yahoo.com', '2025-05-25 06:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`) VALUES
(1, 'user', '', '$2y$10$NYWYKy7rKU8RVyvJ.tF8o.gpn7ncYGqfXBDfyt9vcxaHzD5uefpC2');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
