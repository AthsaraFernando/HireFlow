-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2025 at 10:50 AM
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
-- Database: `hireflow_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_logs`
--

CREATE TABLE `access_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access_logs`
--

INSERT INTO `access_logs` (`id`, `user_id`, `ip_address`, `action`, `details`, `user_agent`, `created_at`) VALUES
(1, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 13:48:12'),
(2, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 13:48:21'),
(3, NULL, '::1', 'failed_login', 'Failed login attempt for email: recruiter@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 13:48:39'),
(4, 6, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 13:50:05'),
(5, 6, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 13:53:39'),
(6, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 13:54:47'),
(7, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 13:54:56'),
(8, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 13:55:04'),
(9, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 13:55:17'),
(10, NULL, '::1', 'failed_login', 'Failed login attempt for email: jane@example.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 13:55:54'),
(11, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 13:59:44'),
(12, NULL, '::1', 'failed_login', 'Failed login attempt for email: hr@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:00:09'),
(13, NULL, '::1', 'failed_login', 'Failed login attempt for email: hr@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:00:19'),
(14, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:04:47'),
(15, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:09:24'),
(16, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:09:35'),
(17, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:09:41'),
(18, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:14:28'),
(19, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:15:13'),
(20, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:17:11'),
(21, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:24:39'),
(22, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:24:45'),
(23, NULL, '::1', 'failed_login', 'Failed login attempt for email: jane.smith@email.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:28:16'),
(24, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:28:29'),
(25, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:28:34'),
(26, 10, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:36:02'),
(30, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 14:49:34'),
(32, 1, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:00:09'),
(33, 1, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:01:25'),
(34, 1, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:01:41'),
(35, 1, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:01:43'),
(38, 1, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:06:18'),
(39, 1, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:06:25'),
(40, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:09:13'),
(41, 1, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:09:18'),
(42, 1, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:10:02'),
(43, NULL, '::1', 'failed_login', 'Failed login attempt for email: athsara@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:11:06'),
(44, 2, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:11:17'),
(45, 2, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:11:34'),
(46, 1, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:18:00'),
(47, 1, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:34:29'),
(48, 3, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 15:34:40'),
(49, 3, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:09:30'),
(50, 3, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:09:56'),
(51, 1, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:10:34'),
(52, 1, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:21:05'),
(53, 1, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:25:10'),
(54, NULL, '::1', 'failed_login', 'Failed login attempt for email: admin@hireflow.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:31:06'),
(55, 1, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:31:13'),
(56, 1, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:31:38'),
(57, 4, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:31:47'),
(58, 4, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:33:53'),
(59, 2, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:34:00'),
(60, 2, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:34:47'),
(61, 1, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:35:00'),
(62, 1, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:35:50'),
(63, 2, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:35:58'),
(64, 1, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:44:06'),
(65, 2, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:58:39'),
(66, 2, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 17:59:06'),
(67, 2, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 18:09:31'),
(68, NULL, '::1', 'failed_login', 'Failed login attempt for email: athsara@test.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 18:09:38'),
(69, NULL, '::1', 'failed_login', 'Failed login attempt for email: athsara@test.com', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 18:09:45'),
(70, 2, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 18:09:56'),
(71, 2, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 18:18:26'),
(72, 1, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 18:18:33'),
(73, 1, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 18:43:23'),
(74, 2, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 18:44:05'),
(75, 2, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-06 18:44:18'),
(76, 2, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:15:36'),
(77, 2, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:16:06'),
(78, 2, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:16:14'),
(79, 2, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:16:20'),
(80, 1, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:16:27'),
(81, 1, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:17:18'),
(82, 2, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:17:30'),
(83, 2, '::1', 'logout', 'User logged out', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:17:39'),
(84, 4, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:17:47'),
(85, 3, '::1', 'login', 'User logged in successfully', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-09-07 05:18:46');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `resume_path` varchar(255) NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `status` enum('Applied','Under Review','Shortlisted','Interview Scheduled','Rejected','Offered') DEFAULT 'Applied',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `applicant_id`, `job_id`, `resume_path`, `cover_letter`, `status`, `applied_at`) VALUES
(1, 4, 1, '/uploads/john_resume.pdf', NULL, 'Applied', '2025-08-30 20:00:21'),
(2, 5, 1, '/uploads/jane_resume.pdf', NULL, 'Under Review', '2025-08-30 20:00:21'),
(3, 4, 2, '/uploads/john_resume_2.pdf', NULL, 'Shortlisted', '2025-08-30 20:00:21'),
(4, 2, 12, '/uploads/resumes/athsara_resume.pdf', 'Dear Hiring Manager,\n\nI am excited to apply for the Senior Software Engineer position at HireFlow. With my experience in full-stack development, I have developed a strong foundation in PHP, JavaScript, and database design.\n\nI am passionate about clean code, best practices, and continuous learning. I would love to bring my expertise to your innovative team.\n\nBest regards,\nAthsara Fernando', 'Applied', '2025-09-07 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `head_of_department` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `head_of_department`, `created_at`, `updated_at`) VALUES
(1, 'Human Resources', 'Manages recruitment, employee relations, and HR policies', 2, '2025-08-31 17:55:27', '2025-08-31 17:55:27'),
(2, 'Information Technology', 'Handles software development, system administration, and technical support', 2, '2025-08-31 17:55:27', '2025-08-31 17:55:27'),
(3, 'Marketing', 'Responsible for brand management, digital marketing, and customer outreach', 2, '2025-08-31 17:55:27', '2025-08-31 17:55:27'),
(4, 'Finance', 'Manages company finances, budgeting, and financial reporting', 2, '2025-08-31 17:55:27', '2025-08-31 17:55:27'),
(5, 'Operations', 'Oversees daily operations, process improvement, and logistics', 2, '2025-08-31 17:55:27', '2025-08-31 17:55:27'),
(6, 'Customer Support', 'Customer service and technical support roles', 1, '2025-09-07 08:41:36', '2025-09-07 08:41:36'),
(7, 'Research & Development', 'Product research, innovation, and development', 1, '2025-09-07 08:41:36', '2025-09-07 08:41:36'),
(8, 'Quality Assurance', 'Testing, quality control, and process improvement', 1, '2025-09-07 08:41:36', '2025-09-07 08:41:36');

-- --------------------------------------------------------

--
-- Table structure for table `interviews`
--

CREATE TABLE `interviews` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `interviewer_id` int(11) NOT NULL,
  `scheduled_date` date NOT NULL,
  `scheduled_time` time NOT NULL,
  `status` enum('Scheduled','Completed','Canceled') DEFAULT 'Scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_posts`
--

CREATE TABLE `job_posts` (
  `id` int(11) NOT NULL,
  `hr_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `salary_range` varchar(100) DEFAULT NULL,
  `employment_type` enum('Full-time','Part-time','Contract','Internship') DEFAULT 'Full-time',
  `deadline` date DEFAULT NULL,
  `status` enum('Open','Closed','Draft') DEFAULT 'Draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_posts`
--

INSERT INTO `job_posts` (`id`, `hr_id`, `title`, `department_id`, `description`, `requirements`, `department`, `location`, `salary_range`, `employment_type`, `deadline`, `status`, `created_at`) VALUES
(1, 2, 'Software Engineer', 2, 'Looking for a skilled software developer', NULL, 'IT', 'Colombo', NULL, 'Full-time', '2025-12-31', 'Open', '2025-08-30 20:00:21'),
(2, 2, 'Marketing Specialist', 2, 'Digital marketing expert needed', NULL, 'Marketing', 'Kandy', NULL, 'Full-time', '2025-11-30', 'Open', '2025-08-30 20:00:21'),
(3, 2, 'Data Analyst', 3, 'Analyze business data and trends', NULL, 'Analytics', 'Galle', NULL, 'Full-time', '2025-10-31', 'Open', '2025-08-30 20:00:21'),
(4, 4, 'Senior Software Engineer', 2, 'We are seeking an experienced Software Engineer to join our dynamic development team. You will be responsible for designing, developing, and maintaining high-quality software applications using modern technologies and best practices.', '??? Bachelor\'s degree in Computer Science or related field\n??? 5+ years of experience in software development\n??? Proficiency in PHP, JavaScript, Python, or Java\n??? Experience with database design (MySQL, PostgreSQL)\n??? Knowledge of web frameworks (Laravel, React, Vue.js)\n??? Understanding of version control systems (Git)\n??? Strong problem-solving and analytical skills\n??? Excellent communication and teamwork abilities', NULL, 'Colombo, Sri Lanka', '$70,000 - $90,000', 'Full-time', '2025-10-15', 'Open', '2025-09-07 08:44:02'),
(5, 4, 'Frontend Developer', 2, 'Join our creative team as a Frontend Developer and help us build beautiful, responsive, and user-friendly web applications. You will work closely with designers and backend developers to create exceptional user experiences.', '??? Bachelor\'s degree in Computer Science, Web Development, or related field\n??? 3+ years of frontend development experience\n??? Expert knowledge of HTML5, CSS3, and JavaScript (ES6+)\n??? Experience with modern frameworks (React, Vue.js, Angular)\n??? Proficiency in CSS preprocessors (SASS, LESS)\n??? Understanding of responsive design principles\n??? Experience with build tools (Webpack, Gulp, npm)\n??? Knowledge of version control (Git)\n??? Eye for design and attention to detail', NULL, 'Colombo, Sri Lanka', '$50,000 - $70,000', 'Full-time', '2025-09-30', 'Open', '2025-09-07 08:44:02'),
(6, 4, 'DevOps Engineer', 2, 'We are looking for a skilled DevOps Engineer to help us streamline our development and deployment processes. You will be responsible for maintaining our CI/CD pipelines, cloud infrastructure, and ensuring system reliability.', '??? Bachelor\'s degree in Computer Science, Engineering, or related field\n??? 4+ years of experience in DevOps or system administration\n??? Experience with cloud platforms (AWS, Azure, Google Cloud)\n??? Proficiency in containerization (Docker, Kubernetes)\n??? Knowledge of CI/CD tools (Jenkins, GitLab CI, GitHub Actions)\n??? Experience with infrastructure as code (Terraform, CloudFormation)\n??? Scripting skills (Bash, Python, PowerShell)\n??? Understanding of monitoring tools (Prometheus, Grafana)\n??? Strong troubleshooting and problem-solving skills', NULL, 'Remote', '$65,000 - $85,000', 'Full-time', '2025-10-01', 'Open', '2025-09-07 08:44:02'),
(7, 4, 'HR Business Partner', 1, 'Join our HR team as an HR Business Partner and play a key role in supporting our organizational growth. You will work closely with management to develop HR strategies, policies, and programs that align with business objectives.', '??? Bachelor\'s degree in Human Resources, Business Administration, or related field\n??? 5+ years of HR experience with focus on business partnering\n??? Strong knowledge of employment law and HR best practices\n??? Experience in talent acquisition and performance management\n??? Excellent interpersonal and communication skills\n??? Proficiency in HRIS systems and MS Office suite\n??? Professional HR certification (SHRM, HRCI) preferred\n??? Ability to handle confidential information with discretion\n??? Strong analytical and problem-solving skills', NULL, 'Colombo, Sri Lanka', '$55,000 - $75,000', 'Full-time', '2025-10-20', 'Open', '2025-09-07 08:44:02'),
(8, 4, 'Talent Acquisition Specialist', 1, 'We are seeking a dynamic Talent Acquisition Specialist to join our growing HR team. You will be responsible for identifying, attracting, and hiring top talent across various departments and skill levels.', '??? Bachelor\'s degree in Human Resources, Psychology, or related field\n??? 3+ years of experience in recruitment and talent acquisition\n??? Experience with various recruitment channels (job boards, social media, networking)\n??? Proficiency in applicant tracking systems (ATS)\n??? Strong interviewing and assessment skills\n??? Knowledge of employment laws and regulations\n??? Excellent communication and negotiation skills\n??? Ability to work in a fast-paced environment\n??? Experience with technical recruitment preferred', NULL, 'Colombo, Sri Lanka', '$45,000 - $60,000', 'Full-time', '2025-09-25', 'Open', '2025-09-07 08:44:02'),
(9, 4, 'Digital Marketing Manager', 3, 'We are looking for a creative and results-driven Digital Marketing Manager to lead our digital marketing initiatives. You will develop and execute comprehensive digital marketing strategies to increase brand awareness and drive customer acquisition.', '??? Bachelor\'s degree in Marketing, Communications, or related field\n??? 4+ years of experience in digital marketing\n??? Proven experience with digital marketing channels (SEO, SEM, social media, email)\n??? Proficiency in marketing tools (Google Analytics, AdWords, Facebook Ads Manager)\n??? Experience with marketing automation platforms\n??? Strong analytical skills and data-driven mindset\n??? Excellent written and verbal communication skills\n??? Creative thinking and problem-solving abilities\n??? Experience with content management systems', NULL, 'Colombo, Sri Lanka', '$55,000 - $70,000', 'Full-time', '2025-09-28', 'Open', '2025-09-07 08:44:02'),
(10, 4, 'Customer Success Manager', 6, 'Join our Customer Success team and help us build lasting relationships with our clients. You will be responsible for ensuring customer satisfaction, driving product adoption, and identifying growth opportunities.', '??? Bachelor\'s degree in Business, Communications, or related field\n??? 3+ years of experience in customer success, account management, or related role\n??? Strong customer service and relationship management skills\n??? Experience with CRM systems (Salesforce, HubSpot)\n??? Excellent communication and presentation skills\n??? Problem-solving and conflict resolution abilities\n??? Data analysis skills to track customer metrics\n??? Ability to work collaboratively across teams\n??? Technical aptitude to understand our products', NULL, 'Colombo, Sri Lanka', '$45,000 - $60,000', 'Full-time', '2025-10-05', 'Open', '2025-09-07 08:44:02'),
(11, 4, 'QA Engineer', 8, 'We are seeking a detail-oriented QA Engineer to join our quality assurance team. You will be responsible for testing our software applications, identifying bugs, and ensuring our products meet the highest quality standards.', '??? Bachelor\'s degree in Computer Science, Engineering, or related field\n??? 3+ years of experience in software testing and quality assurance\n??? Experience with manual and automated testing methodologies\n??? Knowledge of testing tools (Selenium, TestRail, JIRA)\n??? Understanding of software development lifecycle (SDLC)\n??? Experience with API testing and database testing\n??? Strong analytical and problem-solving skills\n??? Excellent attention to detail\n??? Good communication skills for reporting issues', NULL, 'Colombo, Sri Lanka', '$45,000 - $60,000', 'Full-time', '2025-10-12', 'Open', '2025-09-07 08:44:02'),
(12, 4, 'Senior Software Engineer', 2, 'We are seeking an experienced Software Engineer to join our dynamic development team. You will be responsible for designing, developing, and maintaining high-quality software applications using modern technologies and best practices.', '??? Bachelor\'s degree in Computer Science or related field\n??? 5+ years of experience in software development\n??? Proficiency in PHP, JavaScript, Python, or Java\n??? Experience with database design (MySQL, PostgreSQL)\n??? Knowledge of web frameworks (Laravel, React, Vue.js)\n??? Understanding of version control systems (Git)\n??? Strong problem-solving and analytical skills\n??? Excellent communication and teamwork abilities', NULL, 'Colombo, Sri Lanka', '$70,000 - $90,000', 'Full-time', '2025-10-15', 'Open', '2025-09-07 08:44:43'),
(13, 4, 'Frontend Developer', 2, 'Join our creative team as a Frontend Developer and help us build beautiful, responsive, and user-friendly web applications. You will work closely with designers and backend developers to create exceptional user experiences.', '??? Bachelor\'s degree in Computer Science, Web Development, or related field\n??? 3+ years of frontend development experience\n??? Expert knowledge of HTML5, CSS3, and JavaScript (ES6+)\n??? Experience with modern frameworks (React, Vue.js, Angular)\n??? Proficiency in CSS preprocessors (SASS, LESS)\n??? Understanding of responsive design principles\n??? Experience with build tools (Webpack, Gulp, npm)\n??? Knowledge of version control (Git)\n??? Eye for design and attention to detail', NULL, 'Colombo, Sri Lanka', '$50,000 - $70,000', 'Full-time', '2025-09-30', 'Open', '2025-09-07 08:44:43'),
(14, 4, 'Digital Marketing Manager', 3, 'We are looking for a creative and results-driven Digital Marketing Manager to lead our digital marketing initiatives. You will develop and execute comprehensive digital marketing strategies to increase brand awareness and drive customer acquisition.', '??? Bachelor\'s degree in Marketing, Communications, or related field\n??? 4+ years of experience in digital marketing\n??? Proven experience with digital marketing channels (SEO, SEM, social media, email)\n??? Proficiency in marketing tools (Google Analytics, AdWords, Facebook Ads Manager)\n??? Experience with marketing automation platforms\n??? Strong analytical skills and data-driven mindset\n??? Excellent written and verbal communication skills\n??? Creative thinking and problem-solving abilities\n??? Experience with content management systems', NULL, 'Colombo, Sri Lanka', '$55,000 - $70,000', 'Full-time', '2025-09-28', 'Open', '2025-09-07 08:44:43'),
(15, 4, 'HR Business Partner', 1, 'Join our HR team as an HR Business Partner and play a key role in supporting our organizational growth. You will work closely with management to develop HR strategies, policies, and programs that align with business objectives.', '??? Bachelor\'s degree in Human Resources, Business Administration, or related field\n??? 5+ years of HR experience with focus on business partnering\n??? Strong knowledge of employment law and HR best practices\n??? Experience in talent acquisition and performance management\n??? Excellent interpersonal and communication skills\n??? Proficiency in HRIS systems and MS Office suite\n??? Professional HR certification (SHRM, HRCI) preferred\n??? Ability to handle confidential information with discretion\n??? Strong analytical and problem-solving skills', NULL, 'Colombo, Sri Lanka', '$55,000 - $75,000', 'Full-time', '2025-10-20', 'Open', '2025-09-07 08:44:43'),
(16, 4, 'QA Engineer', 8, 'We are seeking a detail-oriented QA Engineer to join our quality assurance team. You will be responsible for testing our software applications, identifying bugs, and ensuring our products meet the highest quality standards.', '??? Bachelor\'s degree in Computer Science, Engineering, or related field\n??? 3+ years of experience in software testing and quality assurance\n??? Experience with manual and automated testing methodologies\n??? Knowledge of testing tools (Selenium, TestRail, JIRA)\n??? Understanding of software development lifecycle (SDLC)\n??? Experience with API testing and database testing\n??? Strong analytical and problem-solving skills\n??? Excellent attention to detail\n??? Good communication skills for reporting issues', NULL, 'Colombo, Sri Lanka', '$45,000 - $60,000', 'Full-time', '2025-10-12', 'Open', '2025-09-07 08:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `type` enum('info','success','warning','error') DEFAULT 'info',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`) VALUES
(1, 4, 'Application Submitted', 'Your application for Senior Software Engineer position has been submitted successfully.', 'success', 0, '2025-08-31 17:48:47'),
(2, 4, 'Application Update', 'Your application for Senior Software Engineer has been shortlisted for interview.', 'info', 0, '2025-08-31 17:48:47'),
(3, 2, 'New Application', 'A new application has been received for the Marketing Specialist position.', 'info', 0, '2025-08-31 17:48:47'),
(4, 3, 'Interview Reminder', 'You have an interview scheduled with Priya Jayasinghe tomorrow at 2:00 PM.', 'warning', 0, '2025-08-31 17:48:47'),
(5, 2, 'Application Received', 'Your application for Senior Software Engineer has been received and is under review.', '', 0, '2025-09-07 08:44:43'),
(6, 4, 'New Application', 'New application received for Senior Software Engineer position from Athsara Fernando.', '', 1, '2025-09-07 08:44:43');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `description`, `created_at`) VALUES
(1, 'System Admin', 'System management and configuration', '2025-08-30 20:00:21'),
(2, 'HR Admin', 'HR operations and job management', '2025-08-30 20:00:21'),
(3, 'Recruitment Manager', 'Candidate evaluation and interviews', '2025-08-30 20:00:21'),
(4, 'Applicant', 'Job seekers and candidates', '2025-08-30 20:00:21');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `description`, `updated_by`, `updated_at`) VALUES
(1, 'site_name', 'HireFlow', 'Name of the recruitment system', 1, '2025-08-31 17:48:05'),
(2, 'max_file_size', '5242880', 'Maximum file upload size in bytes (5MB)', 1, '2025-08-31 17:48:05'),
(3, 'allowed_file_types', 'pdf,doc,docx', 'Allowed file types for resume upload', 1, '2025-08-31 17:48:05'),
(4, 'session_timeout', '3600', 'Session timeout in seconds', 1, '2025-08-31 17:48:05'),
(5, 'email_notifications', 'true', 'Enable/disable email notifications', 1, '2025-08-31 17:48:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `full_name`, `role_id`, `phone`, `address`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin@hireflow.com', '$2y$10$tbGBjb8h3TQdvzToV.CDyuCUKEHphtMOH0RcMRL939ankZrR/b066', 'Sineth Mendis', 1, '0712345678', 'test, address', 'active', '2025-09-07 05:16:27', '2025-09-06 18:14:46', '2025-09-07 08:46:27'),
(2, 'athsara@hireflow.com', '$2y$10$S7m.XJbNWuTFLKgc5QdkIOjZ7ZfzCQY6dGITiBpaIXsWrGB/7Uc4.', 'Athsara Fernando', 4, '', '', 'active', '2025-09-07 05:17:30', '2025-09-06 15:10:51', '2025-09-07 08:47:30'),
(3, 'recruiter@hireflow.com', '$2y$10$vlr0hoSSCCGfwaAm.taYOeezIkPNSRCC01Akl.MSiLkJG/KBGi6rK', 'Tehan Isum', 3, '0712345678', NULL, 'active', '2025-09-07 05:18:46', '2025-09-06 15:33:46', '2025-09-07 08:48:46'),
(4, 'hr@hireflow.com', '$2y$10$UaLGajZ1lfRW0qR.CJHKZehd8w4U5tk1rA7bjAoZMy0wJQZHVb3MO', 'Hasindu Rodrigo', 2, '0712345678', NULL, 'active', '2025-09-07 05:17:47', '2025-09-06 17:22:34', '2025-09-07 08:47:47'),
(5, 'chamali.perera@gmail.com', 'Password@1', 'Chamali Perera', 4, '+94772345678', NULL, 'active', NULL, '2025-09-07 08:41:36', '2025-09-07 08:41:36'),
(6, 'nuwan.silva@gmail.com', 'Password@1', 'Nuwan Silva', 4, '+94773456789', NULL, 'active', NULL, '2025-09-07 08:41:36', '2025-09-07 08:41:36'),
(7, 'priya.j@gmail.com', 'Password@1', 'Priya Jayasinghe', 4, '+94774567890', NULL, 'active', NULL, '2025-09-07 08:41:36', '2025-09-07 08:41:36'),
(8, 'kamal.fernando@gmail.com', 'Password@1', 'Kamal Fernando', 4, '+94775678901', NULL, 'active', NULL, '2025-09-07 08:41:36', '2025-09-07 08:41:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_logs`
--
ALTER TABLE `access_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `applicant_id` (`applicant_id`,`job_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `head_of_department` (`head_of_department`);

--
-- Indexes for table `interviews`
--
ALTER TABLE `interviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_id` (`application_id`),
  ADD KEY `interviewer_id` (`interviewer_id`);

--
-- Indexes for table `job_posts`
--
ALTER TABLE `job_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hr_id` (`hr_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_logs`
--
ALTER TABLE `access_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `interviews`
--
ALTER TABLE `interviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_posts`
--
ALTER TABLE `job_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `access_logs`
--
ALTER TABLE `access_logs`
  ADD CONSTRAINT `access_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`head_of_department`) REFERENCES `users` (`id`);

--
-- Constraints for table `interviews`
--
ALTER TABLE `interviews`
  ADD CONSTRAINT `interviews_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`),
  ADD CONSTRAINT `interviews_ibfk_2` FOREIGN KEY (`interviewer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `job_posts`
--
ALTER TABLE `job_posts`
  ADD CONSTRAINT `job_posts_ibfk_1` FOREIGN KEY (`hr_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `job_posts_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD CONSTRAINT `system_settings_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
