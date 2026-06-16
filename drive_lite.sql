-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2026 at 03:38 PM
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
-- Database: `drive_lite`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `is_public` tinyint(1) DEFAULT 0,
  `upload_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `user_id`, `filename`, `filepath`, `is_public`, `upload_date`) VALUES
(2, 7, 'materi pkr feb m 3 strategi harga.docx', '../uploads/1770121797_materi pkr feb m 3 strategi harga.docx', 0, '2026-02-03 19:29:57'),
(3, 8, 'komponen strategi pemasaran m3.docx', '../uploads/1770122011_komponen strategi pemasaran m3.docx', 1, '2026-02-03 19:33:31'),
(4, 12, 'piscina barcelona.jpg', '../uploads/1770123836_piscina barcelona.jpg', 1, '2026-02-03 20:03:56'),
(5, 12, 'Radical Optimism.mcworld', '../uploads/1770123845_Radical Optimism.mcworld', 1, '2026-02-03 20:04:05'),
(6, 7, 'taylor swift debut.jpg', '../uploads/1770123888_taylor swift debut.jpg', 1, '2026-02-03 20:04:48'),
(7, 11, 'radical optimism dua lipa.jpg', '../uploads/1770123917_radical optimism dua lipa.jpg', 1, '2026-02-03 20:05:17'),
(8, 11, 'radical optimism dua lipa back cover.jpg', '../uploads/1770123926_radical optimism dua lipa back cover.jpg', 0, '2026-02-03 20:05:26'),
(9, 13, 'Script Unity.pdf', '../uploads/1770124059_Script Unity.pdf', 1, '2026-02-03 20:07:39'),
(10, 7, 'Minecraft-Logo-2013.png', '../uploads/1770188108_Minecraft-Logo-2013.png', 0, '2026-02-04 13:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `file_access`
--

CREATE TABLE `file_access` (
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin@mail.com', 'admin123', 'admin'),
(7, 'TaylorSwift', 'taylor@gmail.com', 'taylor123', 'user'),
(8, 'SabrinaCarpenter', 'sabrina@gmail.com', 'sabrina123', 'user'),
(9, 'DuaLipa', 'dualipa@gmail.com', 'dualipa123', 'admin'),
(10, 'JustinBieber', 'justin@gmail.com', 'justin123', 'admin'),
(11, 'Ayyash', 'ayas@gmail.com', 'ayas123', 'user'),
(12, 'Ikhsan', 'isan@gmail.com', 'isan123', 'user'),
(13, 'HarryPotter', 'harry@gmail.com', 'harry123', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `file_access`
--
ALTER TABLE `file_access`
  ADD PRIMARY KEY (`file_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `file_access`
--
ALTER TABLE `file_access`
  ADD CONSTRAINT `file_access_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `files` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `file_access_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
