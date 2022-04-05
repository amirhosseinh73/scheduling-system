-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2022 at 08:43 AM
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
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL COMMENT 'doctor or patient',
  `question_ID` int(11) NOT NULL,
  `answer` longtext COLLATE utf8_persian_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `ID` int(11) NOT NULL,
  `uniqe_image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `title` varchar(150) COLLATE utf8_persian_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8_persian_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_persian_ci DEFAULT NULL,
  `tag` text COLLATE utf8_persian_ci DEFAULT NULL,
  `view` smallint(5) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_time`
--

CREATE TABLE `booking_time` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL COMMENT 'doctor_ID',
  `type` tinyint(1) NOT NULL COMMENT '1: meeting,\r\n2: phone',
  `date` varchar(10) COLLATE utf8_persian_ci NOT NULL COMMENT 'day of visit',
  `start` varchar(5) COLLATE utf8_persian_ci NOT NULL COMMENT 'start time for visit',
  `end` varchar(5) COLLATE utf8_persian_ci NOT NULL COMMENT 'end time for visit',
  `time` tinyint(3) NOT NULL COMMENT 'each person by minute',
  `number_reserve` tinyint(3) NOT NULL COMMENT 'تعدادی بیماری که میتواند معاینه کند',
  `number_reserved` tinyint(3) NOT NULL DEFAULT 0 COMMENT 'تعداد بیماران رزرو شده',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us_message`
--

CREATE TABLE `contact_us_message` (
  `ID` int(11) NOT NULL,
  `fullname` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `subject` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL,
  `message` text COLLATE utf8_persian_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `ID` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `description` tinytext COLLATE utf8_persian_ci DEFAULT NULL,
  `time` tinyint(3) NOT NULL COMMENT 'Minute',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_answer`
--

CREATE TABLE `exam_answer` (
  `ID` int(11) NOT NULL,
  `question_ID` int(11) NOT NULL,
  `answer` longtext COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'JSON or TEXT',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_question`
--

CREATE TABLE `exam_question` (
  `ID` int(11) NOT NULL,
  `exam_ID` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0: Descriptiveو\r\n1: checkbox,\r\n2: radio',
  `status` bit(1) NOT NULL DEFAULT b'1' COMMENT '0: Not Show,\r\n1: show',
  `question` longtext COLLATE utf8_persian_ci DEFAULT NULL,
  `answer` longtext COLLATE utf8_persian_ci NOT NULL COMMENT 'JSON or TEXT',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `ID` int(11) NOT NULL,
  `question` longtext COLLATE utf8_persian_ci DEFAULT NULL,
  `answer` longtext COLLATE utf8_persian_ci DEFAULT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1' COMMENT '0: not show,\r\n1: show',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

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
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `ID` int(11) NOT NULL,
  `uniqe_image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `title` varchar(150) COLLATE utf8_persian_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8_persian_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_persian_ci DEFAULT NULL,
  `tag` text COLLATE utf8_persian_ci DEFAULT NULL,
  `view` smallint(5) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
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
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL COMMENT 'patient_ID',
  `question` longtext COLLATE utf8_persian_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: new,\r\n1: answered,\r\n2: closed',
  `show` bit(1) NOT NULL DEFAULT b'0' COMMENT '0: private,\r\n1: public',
  `type` bit(1) NOT NULL COMMENT '0: QUESTION and ANSWER,\r\n1: Ticket',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL COMMENT 'patient_ID',
  `booking_ID` int(11) NOT NULL,
  `number` int(3) NOT NULL COMMENT 'number of turn,\r\nJOIN with booking',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
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
  `gender` bit(1) NOT NULL DEFAULT b'0' COMMENT '0: female\r\n1: male',
  `type_user` bit(1) DEFAULT NULL COMMENT '1: Doctor,\r\n2: Patient',
  `status` bit(1) NOT NULL DEFAULT b'0' COMMENT '0: Disable,\r\n1: Enable',
  `is_admin` bit(1) NOT NULL DEFAULT b'0' COMMENT 'Admin Panel,\r\n0: Not Admin,\r\n1: Is Admin',
  `image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
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
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `booking_time`
--
ALTER TABLE `booking_time`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `contact_us_message`
--
ALTER TABLE `contact_us_message`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `exam_answer`
--
ALTER TABLE `exam_answer`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `exam_question`
--
ALTER TABLE `exam_question`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
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
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
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
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_time`
--
ALTER TABLE `booking_time`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_us_message`
--
ALTER TABLE `contact_us_message`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_answer`
--
ALTER TABLE `exam_answer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_question`
--
ALTER TABLE `exam_question`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
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
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
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
