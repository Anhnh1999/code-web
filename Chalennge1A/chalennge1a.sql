-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2023 at 07:37 AM
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
(0, 'student1', 'teacher1', '333333', '2023-08-31 13:13:37'),
(0, 'student1', 'teacher1', '123213', '2023-08-31 13:13:43'),
(0, 'student1', 'teacher1', 'asdad', '2023-08-31 13:13:55'),
(0, 'student1', 'teacher1', 'asdad', '2023-08-31 13:13:57'),
(0, 'student1', 'teacher1', 'aaaaaaa', '2023-08-31 13:15:10'),
(0, 'student1', 'teacher1', 'dd', '2023-08-31 13:15:13'),
(0, 'student1', 'teacher1', 'aaaaaaaaa', '2023-08-31 13:15:29'),
(0, 'student1', 'teacher1', 'ddddddd', '2023-08-31 13:15:31'),
(0, 'student1', 'teacher1', 'asd', '2023-08-31 13:16:11'),
(0, 'student1', 'teacher1', 'ddasd', '2023-08-31 13:16:29'),
(0, 'student1', 'teacher1', 'ddasd', '2023-08-31 13:16:32'),
(0, 'student1', 'teacher1', 'ddasd', '2023-08-31 13:16:38'),
(0, 'student1', 'teacher1', 'dit me may', '2023-08-31 13:24:45'),
(0, 'student1', 'teacher1', 'dit me may', '2023-08-31 13:25:10'),
(0, 'student1', 'teacher1', 'dit me may', '2023-08-31 13:25:21'),
(0, 'student1', 'teacher1', 'hehehe', '2023-08-31 13:25:25'),
(0, 'student1', 'teacher1', 'hehehe', '2023-08-31 13:25:56'),
(0, 'student1', 'teacher1', 'aaaa', '2023-08-31 13:25:58'),
(0, 'student1', 'teacher1', 'asdasd', '2023-08-31 13:26:04'),
(0, 'student1', 'teacher1', 'ddd', '2023-08-31 13:26:12');

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
  `email` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `role`, `id`, `phone`, `fullname`, `email`) VALUES
('teacher1', 'f83e69e4170a786e44e3d32a2479cce9', 'teacher', 1, '0123456789', 'teacher1', 'teacher2@mail.com.vn'),
('teacher2', 'f83e69e4170a786e44e3d32a2479cce9', 'teacher', 2, '0987654321', 'teacher2', 'teacher2@mail.com.vn'),
('student1', 'f83e69e4170a786e44e3d32a2479cce9', 'student', 3, '0987654321', 'student1', 'student1@mail.com'),
('student2', 'f83e69e4170a786e44e3d32a2479cce9', 'student', 4, '0123456789', 'student2', 'student2@mail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD KEY `message_id` (`message_id`);

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
