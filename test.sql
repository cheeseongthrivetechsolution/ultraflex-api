-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2022 at 11:52 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` bigint(20) NOT NULL,
  `name` varchar(64) NOT NULL,
  `sequence` int(11) NOT NULL DEFAULT 1,
  `remark` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` bigint(20) DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp(),
  `updated_by` bigint(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `name`, `sequence`, `remark`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'IT Backend', 1, NULL, 1, '2022-04-13 17:04:23', 1, '2022-04-13 17:04:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `position_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `code` varchar(5) CHARACTER SET utf8 NOT NULL,
  `sequence` int(10) NOT NULL,
  `remark` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `create_by` bigint(20) NOT NULL,
  `update_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`position_id`, `department_id`, `name`, `code`, `sequence`, `remark`, `status`, `create_at`, `create_by`, `update_at`, `update_by`) VALUES
(1, 1, 'Senior Software Developer', 'E1', 1, NULL, 1, '2022-04-13 17:03:27', 1, '2022-04-13 17:03:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `sequence` int(10) NOT NULL,
  `remark` varchar(500) CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `create_by` bigint(20) NOT NULL,
  `update_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `name`, `sequence`, `remark`, `status`, `create_at`, `create_by`, `update_at`, `update_by`) VALUES
(1, 'Super Admin', 1, 'All privileges', 1, '2022-04-13 17:02:48', 1, '2022-04-13 17:02:48', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `position_id` bigint(20) NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `salt` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(63) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` int(1) NOT NULL DEFAULT 1,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sound` int(1) NOT NULL DEFAULT 1,
  `phone` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remark` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `login_ip` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fail_login` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `create_by` bigint(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  `update_by` bigint(20) DEFAULT NULL,
  `access_token` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `department_id`, `position_id`, `password`, `role_id`, `salt`, `name`, `email`, `dob`, `gender`, `avatar`, `sound`, `phone`, `remark`, `status`, `last_login`, `login_ip`, `fail_login`, `created_at`, `create_by`, `updated_at`, `update_by`, `access_token`) VALUES
(1, 'cheeseong', 1, 1, 'a434df8389d477852e159ab794d9b637cfdbc19aefe896c887956b1214dcd1e9', 1, 'zhCK7nORKh8Ou0uOI7K69pz28hbMjI33', 'Chee Seong', 'cheeseong.thrivetechsolution@gmail.com', '1992-05-30', 1, 'http://storage.googleapis.com/fg_merchant_image/PG/PG_diaochan_1622613681.png', 0, '016-9349794', NULL, 1, '2022-04-13 16:33:44', '127.0.0.1', 0, '2022-04-08 11:53:15', NULL, '2022-04-08 11:53:15', NULL, 'e73c3af895815a6d84ec2e4bcd97465fa4e5cb75cf6fedfae887c7bc0bac117a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `FK_department_user_created_by` (`created_by`),
  ADD KEY `FK_department_user_updated_by` (`updated_by`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `position_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `FK_department_user_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `FK_department_user_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
