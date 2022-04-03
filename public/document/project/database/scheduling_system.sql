-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2022 at 02:22 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scheduling_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_request`
--

CREATE TABLE `payment_request` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `amount` int(9) NOT NULL COMMENT '100,000,000,\r\nیکصد میلیون ریال',
  `order_ID` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_track`
--

CREATE TABLE `payment_track` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `payment_request_ID` int(11) NOT NULL,
  `amount` int(9) NOT NULL COMMENT '100,000,000,\r\nیکصد میلیون ریال',
  `order_ID` int(11) NOT NULL COMMENT 'Res_NUM',
  `track_ID` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `ID` int(11) NOT NULL,
  `token` varchar(70) NOT NULL,
  `ip_address` varchar(15) DEFAULT NULL COMMENT 'user ip',
  `user_agent` varchar(100) DEFAULT NULL COMMENT 'browser info',
  `expire_at` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `username` varchar(11) COLLATE utf8_persian_ci NOT NULL COMMENT 'mobile',
  `firstname` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `type_user` bit(1) DEFAULT NULL COMMENT '1: Doctor,\r\n2: Patient',
  `status` bit(1) NOT NULL DEFAULT b'0' COMMENT '0: Disable,\r\n1: Enable',
  `is_admin` bit(1) NOT NULL DEFAULT b'0' COMMENT 'Admin Panel,\r\n0: Not Admin,\r\n1: Is Admin',
  `verifile_code_mobile` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL,
  `verifile_code_email` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL,
  `mobile_verified_at` datetime DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `last_login_dt` datetime DEFAULT NULL,
  `recovery_pass_dt` datetime DEFAULT NULL,
  `change_pass_dt` datetime DEFAULT NULL,
  `token` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'Uniqe,\r\nFor login',
  `password` varchar(100) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `payment_request`
--
ALTER TABLE `payment_request`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `payment_track`
--
ALTER TABLE `payment_track`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_request`
--
ALTER TABLE `payment_request`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_track`
--
ALTER TABLE `payment_track`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
