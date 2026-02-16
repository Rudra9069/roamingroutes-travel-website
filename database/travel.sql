-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 15, 2026 at 05:20 PM
-- Server version: 8.0.43
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
CREATE TABLE IF NOT EXISTS `complaints` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_email`, `message`, `created_at`) VALUES
(2, 'sonvanebhargav@gmail.com', 'Hi Roaming Routes', '2026-01-26 15:37:02');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
CREATE TABLE IF NOT EXISTS `destinations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `images` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `city` varchar(25) NOT NULL,
  `state` varchar(25) NOT NULL,
  `country` varchar(25) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `price_range` varchar(50) DEFAULT NULL,
  `keywords` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` enum('0','1') NOT NULL,
  `reviews` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ratings` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`id`, `name`, `description`, `images`, `city`, `state`, `country`, `category`, `price_range`, `keywords`, `created_at`, `is_deleted`, `reviews`, `ratings`) VALUES
(1, 'Brazil', 'Greatest statue situated here.', 'brazil.jpg', 'Rio De Janeiro', 'Rio De Janeiro', 'Brazil', 'Family, Friends', '90000', 'Brazil', '2025-12-28 12:23:11', '0', 'average', 2),
(2, 'California', 'It has the best beaches and parties.', 'california.jpg', 'Los Angeles', 'California', 'USA', 'Family, Friends, couples', '99500', 'California, Beaches, Party', '2025-12-28 15:36:03', '0', 'top', 4),
(3, 'China', 'The Best Tech-City.', 'china.jpg', 'Shangai', 'Shangai Muncipality', 'China', 'Friends, Solo-trip', '65000', 'China, Tech', '2025-12-28 15:37:06', '0', 'medium', 5),
(4, 'Goa', 'Best beaches & clubs in the whole world', 'goa.jpg', 'Panjim', 'Goa', 'India', 'Friends, couples', '39000', 'Goa, Clubs, Beach', '2025-12-28 15:38:14', '0', 'top\n', 3),
(5, 'Greece', 'known best for their islands.', 'greece.jpg', 'Athens', 'Greece', 'Hellen Republic', 'Family, Friends, couples', '55000', 'Islands, Beaches', '2025-12-28 15:40:40', '0', 'top', 5),
(6, 'Italy', 'known for their pizzas mainly', 'italy.jpg', 'Milan', 'Lombardy', 'Italy', 'Friends, Solo-trip', '69000', 'Ferrari, Pizzas', '2025-12-28 15:42:45', '0', 'top', 5),
(7, 'Jammu & Kashmir', 'Had the best and beautiful mountains', 'j&k.jpg', 'Srinagar', 'Jammu & Kashmir', 'India', 'Family, Friends, couples', '45000', 'India, Jammu, Mountains', '2025-12-28 15:43:55', '0', 'top', 3),
(8, 'Japan', 'Best High-tech city', 'japan.jpg', 'Tokyo', 'Tokyo Metropolis', 'Japan', 'Friends, couples', '71000', 'Japan', '2025-12-28 15:45:19', '0', 'medium', 1),
(9, 'New-Zealand', 'Best for every type of vacations', 'new-zealand.jpg', 'Auckland', 'Auckland Region', 'New Zealand', 'Friends, Solo-trip', '50000', 'New Zealand, Mountains, Beach', '2025-12-28 15:48:01', '0', 'top', 3),
(10, 'Paris', 'Eiffel Tower', 'paris.jpg', 'Paris', 'Paris Region', 'France', 'Family, Friends, couples', '89000', 'Paris, Eiffel Tower', '2025-12-28 15:49:38', '0', 'medium', 4),
(11, 'South Africa', 'Has the best cricket team', 'south-africa.jpg', 'Cape Town', 'Cape', 'South Africa', 'Friends, Solo-trip', '150000', 'South Africa', '2025-12-28 15:51:10', '0', 'top', 3),
(12, 'Istanbul', 'Best in all', 'turkey.jpg', 'Istanbul', 'Istanbul Province', 'Turkey', 'Family, Friends, couples', '99000', 'Istanbul, Turkey', '2025-12-28 15:52:50', '0', 'average', 4),
(13, 'Spiti valley', 'A full best combination of mountains and lakes.', 'spiti_valley.jpg', 'Kaza', 'Himachal Pradesh', 'India', 'Friends', '25000', 'Mountain, Trekking', '2026-01-16 13:37:40', '0', 'top', 5);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `u_id` int DEFAULT NULL,
  `destination_id` int DEFAULT NULL,
  `razorpay_id` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `u_id`, `destination_id`, `razorpay_id`, `name`, `email`, `amount`, `status`, `created_at`) VALUES
(6, 6, 5, 'pay_S8YhxF6i6IT91Z', 'Bhargav Sonvane', 'sonvanebhargav@gmail.com', '55000.00', 'authorized', '2026-01-26 15:36:32'),
(7, 12, 1, 'pay_SGR14iQuy8rpd1', 'Rudra Bhavsar', 'rudrabhavsar04@gmail.com', '90000.00', 'authorized', '2026-02-15 13:17:04'),
(8, 12, 2, 'pay_SGRmdZF7rq0Vzf', 'Rudra Bhavsar', 'rudrabhavsar04@gmail.com', '99500.00', 'authorized', '2026-02-15 14:02:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `u_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contactno` varchar(15) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `verify_token` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`u_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `name`, `email`, `contactno`, `pwd`, `dob`, `verify_token`, `is_verified`, `created_at`) VALUES
(2, 'Bhavya Motiyani', 'bhavyamotiyani29@gmail.com', '9773061563', '$2y$10$gOLofc0D3sFqtkf3Wq2RqO0fpuPnwXX0g13di2k747ldO/4jDlLLO', '2003-10-29', '690d6a3461c1e98e780e8b067998ac35', 1, '2025-12-28 15:24:01'),
(6, 'Bhargav Sonvane', 'sonvanebhargav@gmail.com', '9426205953', '$2y$10$X1zaTBxA58L4QEbYtMPZwu5GvENFyZIGqshxCPUmf3dKB.9Nmo0EW', '1999-02-10', '6adfc8fc4154095ee54298cb30b398f1', 1, '2026-01-26 15:34:52'),
(12, 'Rudra Bhavsar', 'rudrabhavsar04@gmail.com', '8200214115', '$2y$10$QXpBHaPsthu0ydu4yFXAJOVqKjA.EfRx0wxedccS6mpaQhF/hgd7q', '2004-12-10', NULL, 1, '2026-02-15 13:13:54');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
