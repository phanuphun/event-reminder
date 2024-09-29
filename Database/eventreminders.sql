-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2021 at 07:34 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventreminders`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `A_id` int(11) NOT NULL,
  `U_id` int(11) NOT NULL,
  `C_id` int(11) NOT NULL,
  `A_name` varchar(255) NOT NULL,
  `A_detail` varchar(255) NOT NULL,
  `A_state` varchar(20) NOT NULL,
  `A_Notification_state` varchar(20) NOT NULL,
  `A_Date_Create` datetime NOT NULL,
  `A_Date_End` datetime NOT NULL,
  `A_Date_Bf_End` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`A_id`, `U_id`, `C_id`, `A_name`, `A_detail`, `A_state`, `A_Notification_state`, `A_Date_Create`, `A_Date_End`, `A_Date_Bf_End`) VALUES
(363, 68, 78, 'sad', '', 'ยกเลิก', 'เเจ้งล่วงหน้าเเล้ว', '2021-09-27 19:11:00', '2021-09-27 21:13:00', '2021-09-27 20:13:00'),
(366, 68, 78, 'test 29/9/64', '', 'เสร็จสิ้น', 'แจ้งครบเเล้ว', '2021-09-29 07:28:00', '2021-09-29 10:00:00', '2021-09-29 09:00:00'),
(367, 68, 78, 'วันเเม่', '', 'เสร็จสิ้น', 'แจ้งครบเเล้ว', '2021-09-29 10:09:00', '2021-09-29 12:00:00', '2021-09-29 11:00:00'),
(369, 68, 78, 'วันเเม่', '', 'ยกเลิก', 'ยกเลิก', '2021-09-30 00:11:00', '2021-09-30 00:15:00', '0000-00-00 00:00:00'),
(370, 68, 78, 'วันเเม่', '', 'เสร็จสิ้น', 'แจ้งครบเเล้ว', '2021-09-30 10:54:00', '2021-09-30 10:56:00', '0000-00-00 00:00:00'),
(371, 68, 78, 'asd', '', 'ยกเลิก', 'แจ้งครบเเล้ว', '2021-09-30 12:24:00', '2021-09-30 12:25:00', '0000-00-00 00:00:00'),
(372, 68, 190, 'sad sad ฟหกฟหกหฟก', 'ฟหกฟหก', 'เสร็จสิ้น', 'ยกเลิก', '2021-09-30 12:31:00', '2021-10-02 12:31:00', '2021-10-02 11:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `C_id` int(11) NOT NULL,
  `C_name` varchar(255) NOT NULL,
  `U_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`C_id`, `C_name`, `U_id`) VALUES
(78, 'ไม่มีหมวดหมู่', 68),
(186, 'งานกีฬา', 68),
(188, 'sad days', 68),
(190, 'วันสำคัญ', 68),
(191, 'งานกีฬา2', 68),
(192, 'ไม่มีหมวดหมู่', 76),
(193, 'งานกีฬา', 76);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `U_id` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `U_prefix` varchar(20) NOT NULL,
  `U_fname` varchar(255) NOT NULL,
  `U_lname` varchar(255) NOT NULL,
  `U_email` varchar(255) NOT NULL,
  `U_state` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`U_id`, `Username`, `Password`, `U_prefix`, `U_fname`, `U_lname`, `U_email`, `U_state`) VALUES
(68, 'admin', 'admin', 'นาย', 'admin ', 'Test0', 'parnuphun5555@gmail.com', 'admin'),
(76, 'sayomphu', '12345', 'นาย', 'สยมภู', '12345', 'phill2544@gmail.com', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`A_id`),
  ADD KEY `foreign key U_id` (`U_id`),
  ADD KEY `foreign key C_id` (`C_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`C_id`),
  ADD KEY `U_id fk` (`U_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`U_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `A_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=373;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `C_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `U_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `foreign key C_id` FOREIGN KEY (`C_id`) REFERENCES `category` (`C_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foreign key U_id` FOREIGN KEY (`U_id`) REFERENCES `user` (`U_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `U_id fk` FOREIGN KEY (`U_id`) REFERENCES `user` (`U_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
