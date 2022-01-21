-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2022 at 06:19 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phinterest`
--

-- --------------------------------------------------------

--
-- Table structure for table `boards`
--

CREATE TABLE `boards` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `boards`
--

INSERT INTO `boards` (`id`, `user_id`, `name`) VALUES
('0a4cf4f2-7302-11ec-b397-0c9d9205636c', 'a7130ebf-71d1-11ec-9b11-0c9d9205636c', 'Board Sebelah'),
('4394acd1-735e-11ec-a5c6-0c9d9205636c', '9e7d27cf-71d9-11ec-9b11-0c9d9205636c', 'Videos'),
('85be814f-735d-11ec-a5c6-0c9d9205636c', '9e7d27cf-71d9-11ec-9b11-0c9d9205636c', 'Pictures');

-- --------------------------------------------------------

--
-- Table structure for table `board_details`
--

CREATE TABLE `board_details` (
  `board_id` char(36) NOT NULL,
  `pin_id` char(36) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `board_details`
--

INSERT INTO `board_details` (`board_id`, `pin_id`, `timestamp`) VALUES
('0a4cf4f2-7302-11ec-b397-0c9d9205636c', '35bc8761-728e-11ec-8aa2-0c9d9205636c', '2022-01-11 17:34:12'),
('0a4cf4f2-7302-11ec-b397-0c9d9205636c', '8797efd5-735e-11ec-a5c6-0c9d9205636c', '2022-01-12 04:17:18'),
('4394acd1-735e-11ec-a5c6-0c9d9205636c', '35bc8761-728e-11ec-8aa2-0c9d9205636c', '2022-01-12 04:15:55'),
('85be814f-735d-11ec-a5c6-0c9d9205636c', '07859f92-79d3-11ec-a225-0c9d9205636c', '2022-01-20 09:26:21'),
('85be814f-735d-11ec-a5c6-0c9d9205636c', '20a37a3b-79f8-11ec-84fc-0c9d9205636c', '2022-01-20 13:51:54'),
('85be814f-735d-11ec-a5c6-0c9d9205636c', '8797efd5-735e-11ec-a5c6-0c9d9205636c', '2022-01-20 08:16:17'),
('85be814f-735d-11ec-a5c6-0c9d9205636c', 'eb97c4c9-735d-11ec-a5c6-0c9d9205636c', '2022-01-12 04:12:56');

-- --------------------------------------------------------

--
-- Table structure for table `pins`
--

CREATE TABLE `pins` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` varchar(30) NOT NULL,
  `media` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pins`
--

INSERT INTO `pins` (`id`, `user_id`, `title`, `description`, `type`, `media`, `timestamp`) VALUES
('07859f92-79d3-11ec-a225-0c9d9205636c', '9e7d27cf-71d9-11ec-9b11-0c9d9205636c', 'Pin 2', 'This is my second pin', 'image', '1642670781_image3.jpg', '2022-01-20 13:52:14'),
('20a37a3b-79f8-11ec-84fc-0c9d9205636c', '9e7d27cf-71d9-11ec-9b11-0c9d9205636c', 'Pin 3', 'This is my third pin', 'image', '1642686714_image4.jpg', '2022-01-20 13:51:54'),
('35bc8761-728e-11ec-8aa2-0c9d9205636c', '9e7d27cf-71d9-11ec-9b11-0c9d9205636c', 'Pin Video', 'This is video', 'video', '1641871565_video.mp4', '2022-01-12 04:08:48'),
('8797efd5-735e-11ec-a5c6-0c9d9205636c', 'a7130ebf-71d1-11ec-9b11-0c9d9205636c', 'Pin dari user2', '', 'image', '1641961038_image2.png', '2022-01-12 04:17:18'),
('eb97c4c9-735d-11ec-a5c6-0c9d9205636c', '9e7d27cf-71d9-11ec-9b11-0c9d9205636c', 'Pin 1', 'First pin', 'image', '1641960776_image1.jpg', '2022-01-12 04:12:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `profile_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `age`, `profile_picture`) VALUES
('9e7d27cf-71d9-11ec-9b11-0c9d9205636c', 'user@gmail.com', 'user', '$2y$10$cv4sBRUAgyN76Nd/y77D0e7JFSuAVVhcXpm61UJ/2OGIyKBvlZ4Su', 12, '1642662089_profile.jpg'),
('a7130ebf-71d1-11ec-9b11-0c9d9205636c', 'user2@gmail.com', 'user2', '$2y$10$fJNEe/1rUw4ee/IvuN.5Ve1cDzL0Q2Ly3uxY.Vz2GRNT/AFBf9u5y', 20, 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `board_details`
--
ALTER TABLE `board_details`
  ADD PRIMARY KEY (`board_id`,`pin_id`),
  ADD KEY `DETAIL_PIN_FK` (`pin_id`);

--
-- Indexes for table `pins`
--
ALTER TABLE `pins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PIN_USER_FK` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `EMAIL_UNIQUE` (`email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `board_details`
--
ALTER TABLE `board_details`
  ADD CONSTRAINT `DETAIL_BOARD_FK` FOREIGN KEY (`board_id`) REFERENCES `boards` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `DETAIL_PIN_FK` FOREIGN KEY (`pin_id`) REFERENCES `pins` (`id`);

--
-- Constraints for table `pins`
--
ALTER TABLE `pins`
  ADD CONSTRAINT `PIN_USER_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
