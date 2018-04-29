-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2017 at 06:48 AM
-- Server version: 10.1.8-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `message_session`
--

CREATE TABLE `message_session` (
  `id` int(11) NOT NULL,
  `message_session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_session`
--

INSERT INTO `message_session` (`id`, `message_session_id`, `user_id`) VALUES
(119, 1495428163, 1),
(120, 1495428163, 3),
(121, 1495428188, 1),
(122, 1495428188, 2),
(123, 1495428425, 3),
(124, 1495428425, 2);

-- --------------------------------------------------------

--
-- Table structure for table `message_storage`
--

CREATE TABLE `message_storage` (
  `message_storage_id` int(11) NOT NULL,
  `message_session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message_value` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  `active_conn` int(11) NOT NULL,
  `last_seen` time NOT NULL,
  `active_chat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `status`, `active_conn`, `last_seen`, `active_chat`) VALUES
(1, 'Agus', 'online', 140, '00:00:00', 1495428188),
(2, 'Setiadi', 'online', 45, '00:00:00', 0),
(3, 'adi', 'online', 131, '00:00:00', 1495428163);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message_session`
--
ALTER TABLE `message_session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_storage`
--
ALTER TABLE `message_storage`
  ADD PRIMARY KEY (`message_storage_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message_session`
--
ALTER TABLE `message_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;
--
-- AUTO_INCREMENT for table `message_storage`
--
ALTER TABLE `message_storage`
  MODIFY `message_storage_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
