-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2023 at 07:03 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chalennge1a`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `message_id` int(11) NOT NULL,
  `sender` text NOT NULL,
  `receiver` text NOT NULL,
  `message` text NOT NULL,
  `times` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`message_id`, `sender`, `receiver`, `message`, `times`) VALUES
(81, 'teacher1', 'student1', 'hello', '2023-09-06 18:08:41'),
(82, 'teacher1', 'student1', 'test', '2023-09-06 18:08:43'),
(83, 'student2', 'teacher1', '123', '2023-09-06 18:44:43'),
(84, 'student2', 'teacher1', 'test message', '2023-09-06 18:44:51'),
(85, 'teacher1', 'student1', 'aaaaaaa', '2023-09-06 19:00:08'),
(86, 'teacher1', 'student1', 'aaaaaaa', '2023-09-06 19:00:11');

-- --------------------------------------------------------

--
-- Table structure for table `homeworks`
--

CREATE TABLE `homeworks` (
  `homework_id` int(11) NOT NULL,
  `filename` text NOT NULL,
  `filesize` text NOT NULL,
  `fileext` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homeworks`
--

INSERT INTO `homeworks` (`homework_id`, `filename`, `filesize`, `fileext`) VALUES
(1, 'Screenshot 2023-07-29 124754.png', '45.53 KB', 'png'),
(2, 'Screenshot 2023-07-19 223454.png', '13.71 KB', 'png'),
(3, 'Screenshot 2023-07-19 223454.png', '13.71 KB', 'png'),
(4, 'Screenshot 2023-07-19 223544.png', '17.02 KB', 'png'),
(5, 'Screenshot 2023-07-31 022033.png', '242.74 KB', 'png'),
(6, 'Screenshot 2023-07-31 021137.png', '183.06 KB', 'png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL,
  `id` int(11) NOT NULL,
  `phone` text DEFAULT NULL,
  `fullname` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `homework` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `role`, `id`, `phone`, `fullname`, `email`, `homework`) VALUES
('teacher1', 'f83e69e4170a786e44e3d32a2479cce9', 'teacher', 1, '0123456789', 'teacher1', 'teacher2@mail.com.vn', NULL),
('teacher2', 'f83e69e4170a786e44e3d32a2479cce9', 'teacher', 2, '0987654321', 'teacher2', 'teacher2@mail.com.vn', NULL),
('student1', 'f83e69e4170a786e44e3d32a2479cce9', 'student', 3, '0987654321', 'student1', 'student1@mail.com.vn', 1),
('student2', 'f83e69e4170a786e44e3d32a2479cce9', 'student', 4, '0123456789', 'student2', 'student2@mail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `homeworks`
--
ALTER TABLE `homeworks`
  ADD PRIMARY KEY (`homework_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `homeworks`
--
ALTER TABLE `homeworks`
  MODIFY `homework_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
