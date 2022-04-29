-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2022 at 11:29 AM
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
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `bank_id` bigint(20) NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `mypay_code` varchar(5) CHARACTER SET utf8 NOT NULL,
  `logo` varchar(200) CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` bigint(20) NOT NULL,
  `code` varchar(30) CHARACTER SET utf8 NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL,
  `logo` varchar(64) CHARACTER SET utf8 NOT NULL,
  `favicon` varchar(64) CHARACTER SET utf8 NOT NULL,
  `api` varchar(250) CHARACTER SET utf8 NOT NULL,
  `image_path` varchar(250) CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `company_bank`
--

CREATE TABLE `company_bank` (
  `company_bank_id` bigint(20) NOT NULL,
  `bank_id` bigint(20) NOT NULL,
  `acc_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `acc_no` varchar(30) CHARACTER SET utf8 NOT NULL,
  `remark` varchar(200) CHARACTER SET utf8 NOT NULL,
  `balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `min_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `max_balance` decimal(12,0) NOT NULL DEFAULT 0,
  `purpose` int(1) NOT NULL,
  `display` int(1) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `currency_id` bigint(20) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL,
  `alias` varchar(4) CHARACTER SET utf8 NOT NULL,
  `myr_rate` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `dict`
--

CREATE TABLE `dict` (
  `dict_id` bigint(20) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `remark` varchar(200) CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dictdata`
--

CREATE TABLE `dictdata` (
  `dictdata_id` bigint(20) NOT NULL,
  `dict_id` bigint(20) NOT NULL,
  `indicator` int(5) NOT NULL,
  `value` varchar(50) CHARACTER SET utf8 NOT NULL,
  `sequence` int(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `game_id` bigint(20) NOT NULL,
  `provider_id` bigint(20) NOT NULL,
  `category` int(2) NOT NULL,
  `code` varchar(100) CHARACTER SET utf8 NOT NULL,
  `name_en` varchar(100) CHARACTER SET utf8 NOT NULL,
  `name_zh` varchar(100) CHARACTER SET utf8 NOT NULL,
  `image` varchar(200) CHARACTER SET utf8 NOT NULL,
  `display` int(1) NOT NULL,
  `sequence` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` bigint(20) NOT NULL,
  `module` varchar(100) CHARACTER SET utf8 NOT NULL,
  `action` varchar(100) CHARACTER SET utf8 NOT NULL,
  `old` text CHARACTER SET utf8 NOT NULL,
  `new` text CHARACTER SET utf8 NOT NULL,
  `created_type` int(1) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` bigint(20) NOT NULL,
  `site_id` bigint(20) NOT NULL,
  `member_group_id` bigint(20) NOT NULL,
  `affiliate_id` bigint(20) NOT NULL,
  `referral_id` bigint(20) NOT NULL,
  `referral_code` varchar(20) CHARACTER SET utf8 NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 NOT NULL,
  `password` varchar(200) CHARACTER SET utf8 NOT NULL,
  `salt` varchar(50) CHARACTER SET utf8 NOT NULL,
  `full_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(12) CHARACTER SET utf8 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `verify` int(1) NOT NULL DEFAULT 0,
  `fail_login` int(1) NOT NULL DEFAULT 0,
  `remark` varchar(500) NOT NULL,
  `risk` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1,
  `login_ip` varchar(30) CHARACTER SET utf8 NOT NULL,
  `created_type` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_type` int(1) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `member_bank`
--

CREATE TABLE `member_bank` (
  `member_bank_id` bigint(20) NOT NULL,
  `member_id` bigint(20) NOT NULL,
  `bank_id` bigint(20) NOT NULL,
  `acc_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `acc_number` varchar(30) CHARACTER SET utf8 NOT NULL,
  `verify` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_type` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_type` int(1) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `member_provider`
--

CREATE TABLE `member_provider` (
  `member_id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 NOT NULL,
  `cashin` int(1) NOT NULL DEFAULT 1,
  `cashout` int(1) NOT NULL DEFAULT 1,
  `status` int(1) NOT NULL DEFAULT 1,
  `updated_type` int(1) NOT NULL,
  `updated_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_type` int(1) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` bigint(20) NOT NULL,
  `type` int(1) NOT NULL,
  `parent` bigint(20) NOT NULL,
  `code` varchar(10) CHARACTER SET utf8 NOT NULL,
  `indicator` varchar(200) CHARACTER SET utf8 NOT NULL,
  `name_en` varchar(100) CHARACTER SET utf8 NOT NULL,
  `name_zh` varchar(100) CHARACTER SET utf8 NOT NULL,
  `sequence` int(10) NOT NULL,
  `icon` varchar(100) CHARACTER SET utf8 NOT NULL,
  `path` varchar(200) CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE `provider` (
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `type` int(1) NOT NULL,
  `api_url` varchar(200) CHARACTER SET utf8 NOT NULL,
  `sequence` int(10) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `provider_category`
--

CREATE TABLE `provider_category` (
  `provider_category_id` bigint(20) NOT NULL,
  `provider_id` bigint(20) NOT NULL,
  `category` int(2) NOT NULL,
  `sequence` int(10) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `sequence` int(10) NOT NULL,
  `remark` varchar(500) CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `department_id`, `name`, `sequence`, `remark`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 'Super Admin', 1, 'All privileges', 1, '2022-04-13 17:02:48', 1, '2022-04-13 17:02:48', 1),
(2, 1, 'haha', 0, '', 1, '2022-04-22 13:33:40', 0, '2022-04-22 13:33:40', 0),
(3, 1, 'haha', 0, '', 1, '2022-04-22 13:34:04', 1, '2022-04-22 13:34:04', 1),
(4, 1, 'haha', 1, '', 1, '2022-04-22 13:34:15', 1, '2022-04-22 13:34:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_menu`
--

CREATE TABLE `role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `seo`
--

CREATE TABLE `seo` (
  `seo_id` bigint(20) NOT NULL,
  `site_id` bigint(20) NOT NULL,
  `language` varchar(4) CHARACTER SET utf8 NOT NULL,
  `type` bigint(20) NOT NULL,
  `url` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `sequence` int(5) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `seo_property`
--

CREATE TABLE `seo_property` (
  `seo_property_id` bigint(20) NOT NULL,
  `seo_id` bigint(20) NOT NULL,
  `property` varchar(100) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site`
--

CREATE TABLE `site` (
  `site_id` bigint(20) NOT NULL,
  `currency_id` bigint(20) NOT NULL,
  `type` int(1) NOT NULL,
  `logo` varchar(300) CHARACTER SET utf8 NOT NULL,
  `favicon` varchar(300) CHARACTER SET utf8 NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `remark` varchar(500) CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_banner`
--

CREATE TABLE `site_banner` (
  `site_id` bigint(20) NOT NULL,
  `language` varchar(4) CHARACTER SET utf8 NOT NULL,
  `stype_id` bigint(20) NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `url` varchar(300) CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) NOT NULL,
  `created_ay` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_contact`
--

CREATE TABLE `site_contact` (
  `site_id` bigint(20) NOT NULL,
  `type` bigint(20) NOT NULL,
  `method` bigint(20) NOT NULL,
  `value` varchar(300) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_language`
--

CREATE TABLE `site_language` (
  `site_id` bigint(20) NOT NULL,
  `language` varchar(4) CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_link`
--

CREATE TABLE `site_link` (
  `site_link_id` bigint(20) NOT NULL,
  `site_id` bigint(20) NOT NULL,
  `link` varchar(200) CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` bigint(20) NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
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
  `created_by` bigint(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  `updated_by` bigint(20) DEFAULT NULL,
  `access_token` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `role_id`, `salt`, `name`, `email`, `dob`, `gender`, `avatar`, `sound`, `phone`, `remark`, `status`, `last_login`, `login_ip`, `fail_login`, `created_at`, `created_by`, `updated_at`, `updated_by`, `access_token`) VALUES
(1, 'cheeseong', '1edb2e61d728d1fe85bc07c652522d6a129ff1d813031904917beee794dcf662', 1, 'd3Kd4MRz6fOVK9TCV58O3KC6l2GIMp26', 'Chee Seong', 'cheeseong.thrivetechsolution@gmail.com', '1992-05-30', 2, 'http://storage.googleapis.com/fg_merchant_image/PG/PG_diaochan_1622613681.png', 0, '016-9349794', NULL, 1, '2022-04-22 14:07:20', '127.0.0.1', 0, '2022-04-08 11:53:15', 1, '2022-04-20 16:51:09', 1, '61e6e634a0f4fc7f09ab34faac453af0177da990022486774af6ee36c5faf41f');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `wallet_id` bigint(20) NOT NULL,
  `member_id` bigint(20) NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `company_bank`
--
ALTER TABLE `company_bank`
  ADD PRIMARY KEY (`company_bank_id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `FK_department_user_created_by` (`created_by`),
  ADD KEY `FK_department_user_updated_by` (`updated_by`);

--
-- Indexes for table `dict`
--
ALTER TABLE `dict`
  ADD PRIMARY KEY (`dict_id`);

--
-- Indexes for table `dictdata`
--
ALTER TABLE `dictdata`
  ADD PRIMARY KEY (`dictdata_id`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `member_bank`
--
ALTER TABLE `member_bank`
  ADD PRIMARY KEY (`member_bank_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`provider_id`);

--
-- Indexes for table `provider_category`
--
ALTER TABLE `provider_category`
  ADD PRIMARY KEY (`provider_category_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `seo`
--
ALTER TABLE `seo`
  ADD PRIMARY KEY (`seo_id`);

--
-- Indexes for table `seo_property`
--
ALTER TABLE `seo_property`
  ADD PRIMARY KEY (`seo_property_id`);

--
-- Indexes for table `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`site_id`);

--
-- Indexes for table `site_link`
--
ALTER TABLE `site_link`
  ADD PRIMARY KEY (`site_link_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`wallet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `bank_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_bank`
--
ALTER TABLE `company_bank`
  MODIFY `company_bank_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `currency_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dict`
--
ALTER TABLE `dict`
  MODIFY `dict_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dictdata`
--
ALTER TABLE `dictdata`
  MODIFY `dictdata_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `game_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member_bank`
--
ALTER TABLE `member_bank`
  MODIFY `member_bank_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provider`
--
ALTER TABLE `provider`
  MODIFY `provider_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provider_category`
--
ALTER TABLE `provider_category`
  MODIFY `provider_category_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seo`
--
ALTER TABLE `seo`
  MODIFY `seo_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seo_property`
--
ALTER TABLE `seo_property`
  MODIFY `seo_property_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site`
--
ALTER TABLE `site`
  MODIFY `site_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_link`
--
ALTER TABLE `site_link`
  MODIFY `site_link_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `wallet_id` bigint(20) NOT NULL AUTO_INCREMENT;

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
