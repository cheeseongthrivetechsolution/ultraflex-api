-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2022 at 06:00 PM
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
  `parent_id` bigint(20) DEFAULT 0,
  `ancestors` varchar(32) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `leader` varchar(32) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `sequence` int(11) NOT NULL DEFAULT 1,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` bigint(20) DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp(),
  `updated_by` bigint(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) NOT NULL,
  `department_id` bigint(20) DEFAULT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
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

INSERT INTO `user` (`user_id`, `department_id`, `username`, `password`, `salt`, `name`, `email`, `dob`, `gender`, `avatar`, `sound`, `phone`, `remark`, `status`, `last_login`, `login_ip`, `fail_login`, `created_at`, `create_by`, `updated_at`, `update_by`, `access_token`) VALUES
(1, NULL, 'cheeseong', 'a434df8389d477852e159ab794d9b637cfdbc19aefe896c887956b1214dcd1e9', 'zhCK7nORKh8Ou0uOI7K69pz28hbMjI33', 'Chee Seong', 'cheeseong.thrivetechsolution@gmail.com', '1992-05-30', 1, 'http://storage.googleapis.com/fg_merchant_image/PG/PG_diaochan_1622613681.png', 0, '016-9349794', NULL, 1, '2022-04-10 23:54:39', '127.0.0.1', 0, '2022-04-08 11:53:15', NULL, '2022-04-08 11:53:15', NULL, '9588ea9821e54bdd2a2f9e4f0b8ed88ef8374583e18fda07dd673e053743c7e0');

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
  MODIFY `department_id` bigint(20) NOT NULL AUTO_INCREMENT;

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
