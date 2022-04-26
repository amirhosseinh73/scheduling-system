-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2022 at 10:17 PM
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
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL COMMENT 'doctor_ID',
  `type` bit(1) NOT NULL COMMENT '0: meeting,\r\n1: phone',
  `date` datetime NOT NULL COMMENT 'day of visit',
  `start` varchar(5) COLLATE utf8_persian_ci NOT NULL COMMENT 'start time for visit',
  `end` varchar(5) COLLATE utf8_persian_ci NOT NULL COMMENT 'end time for visit',
  `time` tinyint(3) NOT NULL COMMENT 'each person by minute',
  `number_reserve` tinyint(3) NOT NULL COMMENT 'تعدادی بیماری که میتواند معاینه کند',
  `number_reserved` tinyint(3) NOT NULL DEFAULT 0 COMMENT 'تعداد بیماران رزرو شده',
  `kind_text` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'نوع مشاوره',
  `price` int(8) NOT NULL COMMENT 'toman',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`ID`, `user_ID`, `type`, `date`, `start`, `end`, `time`, `number_reserve`, `number_reserved`, `kind_text`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 5, b'1', '2022-04-20 00:00:00', '16:40', '18:31', 20, 5, 0, 'مشاوره ازدواج', 120000, '2022-04-15 16:44:17', '2022-04-15 16:44:17', NULL),
(3, 5, b'0', '2022-04-21 00:00:00', '16:46', '19:45', 15, 11, 9, 'مشاوره بالینی', 180000, '2022-04-15 16:46:17', '2022-04-21 14:52:09', NULL),
(4, 5, b'1', '2022-04-23 00:00:00', '09:30', '13:00', 45, 4, 4, 'مشاوره فردی', 150000, '2022-04-16 23:42:45', '2022-04-21 14:37:58', NULL),
(5, 5, b'0', '2022-05-18 00:00:00', '09:00', '12:00', 30, 6, 0, 'مشاوره کودک', 10000, '2022-04-19 01:34:25', '2022-04-19 01:34:25', NULL);

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
  `question` tinytext COLLATE utf8_persian_ci DEFAULT NULL,
  `answer` longtext COLLATE utf8_persian_ci DEFAULT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1' COMMENT '0: not show,\r\n1: show',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`ID`, `question`, `answer`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'لورم ایپسوم متن ساختگی با تولید سادگی؟', '\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n', b'1', '2022-04-07 17:32:12', '2022-04-07 17:32:12', NULL),
(2, 'لورم ایپسوم متن ساختگی با سادگی؟', '\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n', b'1', '2022-04-07 17:32:12', '2022-04-07 17:32:12', NULL),
(3, 'لورم متن ساختگی با سادگی؟', '\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n', b'1', '2022-04-07 17:32:12', '2022-04-07 17:32:12', NULL),
(4, 'لورم متن ساختگی با سادگی؟', '\r\nلورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در\r\n', b'1', '2022-04-07 17:32:12', '2022-04-07 17:32:12', NULL);

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
-- Table structure for table `metadata`
--

CREATE TABLE `metadata` (
  `ID` int(11) NOT NULL,
  `meta_key` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `meta_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_value`)),
  `parent` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `metadata`
--

INSERT INTO `metadata` (`ID`, `meta_key`, `meta_value`, `parent`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'address', '[\"اصفهان، نجف آباد، خیابان امام خمینی، باغ ملی ، جنب شیرینی فروشی سینا\"]', 'contact_us', '2022-04-07 16:36:25', '2022-04-07 16:36:25', NULL),
(2, 'mobile', '[\"09123456789\"]', 'contact_us', '2022-04-07 16:36:25', '2022-04-07 16:36:25', NULL),
(3, 'phone', '[\"03141234567\"]', 'contact_us', '2022-04-07 16:36:25', '2022-04-07 16:36:25', NULL),
(4, 'email', '[\"support@info.com\"]', 'contact_us', '2022-04-07 16:36:25', '2022-04-07 16:36:25', NULL);

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
  `booking_ID` int(11) NOT NULL COMMENT 'booking_ID',
  `booking_turn` tinyint(3) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `payment_request`
--

INSERT INTO `payment_request` (`ID`, `user_ID`, `amount`, `order_ID`, `time`, `booking_ID`, `booking_turn`, `created_at`, `updated_at`) VALUES
(11, 6, 150000, 1650534786, '2022-04-21 14:23:06', 4, 0, '2022-04-21 14:23:06', '2022-04-21 14:23:06'),
(12, 6, 150000, 1650534805, '2022-04-21 14:23:26', 4, 0, '2022-04-21 14:23:26', '2022-04-21 14:23:26'),
(13, 6, 150000, 1650535059, '2022-04-21 14:27:40', 4, 2, '2022-04-21 14:27:40', '2022-04-21 14:27:40'),
(14, 6, 150000, 1650535673, '2022-04-21 14:37:54', 4, 3, '2022-04-21 14:37:54', '2022-04-21 14:37:54'),
(15, 6, 180000, 1650535744, '2022-04-21 14:39:05', 3, 0, '2022-04-21 14:39:05', '2022-04-21 14:39:05'),
(16, 6, 180000, 1650536357, '2022-04-21 14:49:18', 3, 2, '2022-04-21 14:49:18', '2022-04-21 14:49:18'),
(17, 6, 180000, 1650536410, '2022-04-21 14:50:10', 3, 4, '2022-04-21 14:50:10', '2022-04-21 14:50:10'),
(18, 6, 180000, 1650536474, '2022-04-21 14:51:15', 3, 6, '2022-04-21 14:51:15', '2022-04-21 14:51:15'),
(19, 6, 180000, 1650536524, '2022-04-21 14:52:05', 3, 8, '2022-04-21 14:52:05', '2022-04-21 14:52:05'),
(20, 6, 10000, 1650613617, '2022-04-22 12:16:58', 5, 0, '2022-04-22 12:16:58', '2022-04-22 12:16:58'),
(21, 6, 10000, 1650827767, '2022-04-24 23:46:08', 5, 0, '2022-04-24 23:46:08', '2022-04-24 23:46:08');

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
  `booking_ID` int(11) NOT NULL,
  `booking_turn` tinyint(3) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `payment_track`
--

INSERT INTO `payment_track` (`ID`, `user_ID`, `payment_request_ID`, `amount`, `order_ID`, `track_ID`, `time`, `booking_ID`, `booking_turn`, `created_at`, `updated_at`) VALUES
(5, 6, 12, 150000, 1650534805, 2147483647, '2022-04-21 14:23:29', 4, 0, '2022-04-21 14:23:29', '2022-04-21 14:23:29'),
(6, 6, 12, 150000, 1650534805, 2147483647, '2022-04-21 14:25:17', 4, 0, '2022-04-21 14:25:17', '2022-04-21 14:25:17'),
(7, 6, 13, 150000, 1650535059, 2147483647, '2022-04-21 14:27:43', 4, 2, '2022-04-21 14:27:43', '2022-04-21 14:27:43'),
(8, 6, 14, 150000, 1650535673, 2147483647, '2022-04-21 14:37:58', 4, 3, '2022-04-21 14:37:58', '2022-04-21 14:37:58'),
(9, 6, 15, 180000, 1650535744, 2147483647, '2022-04-21 14:39:08', 3, 0, '2022-04-21 14:39:08', '2022-04-21 14:39:08'),
(10, 6, 15, 180000, 1650535744, 2147483647, '2022-04-21 14:49:12', 3, 0, '2022-04-21 14:49:12', '2022-04-21 14:49:12'),
(11, 6, 16, 180000, 1650536357, 2147483647, '2022-04-21 14:49:22', 3, 2, '2022-04-21 14:49:22', '2022-04-21 14:49:22'),
(12, 6, 16, 180000, 1650536357, 2147483647, '2022-04-21 14:50:05', 3, 2, '2022-04-21 14:50:05', '2022-04-21 14:50:05'),
(13, 6, 17, 180000, 1650536410, 2147483647, '2022-04-21 14:50:14', 3, 4, '2022-04-21 14:50:14', '2022-04-21 14:50:14'),
(14, 6, 17, 180000, 1650536410, 2147483647, '2022-04-21 14:51:09', 3, 4, '2022-04-21 14:51:09', '2022-04-21 14:51:09'),
(15, 6, 18, 180000, 1650536474, 2147483647, '2022-04-21 14:51:20', 3, 6, '2022-04-21 14:51:20', '2022-04-21 14:51:20'),
(16, 6, 18, 180000, 1650536474, 2147483647, '2022-04-21 14:52:00', 3, 6, '2022-04-21 14:52:00', '2022-04-21 14:52:00'),
(17, 6, 19, 180000, 1650536524, 2147483647, '2022-04-21 14:52:09', 3, 8, '2022-04-21 14:52:09', '2022-04-21 14:52:09');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `ID` int(11) NOT NULL,
  `image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `title` varchar(150) COLLATE utf8_persian_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8_persian_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_persian_ci DEFAULT NULL,
  `tag` text COLLATE utf8_persian_ci DEFAULT NULL,
  `sub_title` varchar(150) COLLATE utf8_persian_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `type` bit(1) NOT NULL DEFAULT b'0' COMMENT '0: page,\r\n1: blog',
  `status` bit(1) NOT NULL DEFAULT b'1' COMMENT '0: draft\r\n1: show',
  `view` smallint(5) NOT NULL DEFAULT 0,
  `publish_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`ID`, `image`, `title`, `excerpt`, `content`, `tag`, `sub_title`, `url`, `type`, `status`, `view`, `publish_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'blog-1.jpg', 'لورم ایپسوم متن ساختگی', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.', '<img src=\"http://localhost:8080/uploads/global/single-blog.jpg\" class=\"float-end\"/><p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p><p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p><p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p><p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p><p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.</p>', 'لورم - ایپسوم  - متن ساختگی، کاربردهای / طراحان ', NULL, 'لورم-ایپسوم-متن-ساختگی', b'1', b'1', 12, '2022-04-05 23:12:06', '2022-04-05 18:18:37', '2022-04-07 00:06:31', NULL),
(2, NULL, 'لورم ایپسوم', '', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n', 'لورم - ایپسوم ', NULL, 'لورم-ایپسوم', b'1', b'1', 0, '2022-04-04 18:18:37', '2022-04-05 18:18:37', '2022-04-05 18:18:37', NULL),
(3, 'blog-2.jpg', 'لورم ایپسوم متن ساختگی', '', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n', 'لورم - ایپسوم  - متن ساختگی، کاربردهای / طراحان ', NULL, 'lorem-ipsum', b'1', b'1', 3, '2022-04-05 18:18:37', '2022-04-05 18:18:37', '2022-04-06 23:22:45', NULL),
(4, 'blog-3.jpg', 'لورم ایپسوم متن', '', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n', 'لورم - ایپسوم  - متن ساختگی، کاربردهای / طراحان ', NULL, 'lorem-ipsum-matn', b'1', b'1', 12, '2022-04-05 18:18:37', '2022-04-05 18:18:37', '2022-04-06 23:22:56', NULL),
(5, 'blog-4.jpg', 'لورم ایپسوم متن', '', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n', 'لورم - ایپسوم  - متن ساختگی، کاربردهای / طراحان ', NULL, 'lorem-ipsum-matn-2', b'1', b'1', 3, '2022-04-05 18:18:37', '2022-04-05 18:18:37', '2022-04-06 23:23:08', NULL),
(6, 'about.jpg', 'درباره ما', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک ', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.\r\n', 'لورم - ایپسوم  - متن ساختگی، کاربردهای / طراحان ', 'مرکز مشاوره کیمیای مهر ', 'about-us', b'0', b'1', 12, '2022-04-05 18:18:37', '2022-04-05 18:18:37', '2022-04-07 23:11:31', NULL),
(7, 'contact-us.jpg', 'تماس با ما', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک ', '<p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.</p>', 'لورم - ایپسوم  - متن ساختگی، کاربردهای / طراحان ', 'با ما در ارتباط باشید', 'contact-us', b'0', b'1', 97, '2022-04-05 18:18:37', '2022-04-05 18:18:37', '2022-04-07 23:11:32', NULL);

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
  `relation_user_ID` int(11) DEFAULT NULL COMMENT 'doctor_ID for question and answer\r\nAdmin for Ticket',
  `is_verified` bit(1) NOT NULL DEFAULT b'0' COMMENT 'verify only check for public',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`ID`, `user_ID`, `question`, `status`, `show`, `type`, `relation_user_ID`, `is_verified`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 6, 'سلام', 0, b'0', b'0', 5, b'0', '2022-04-27 00:29:56', '2022-04-27 00:46:31', NULL);

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

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`ID`, `user_ID`, `booking_ID`, `number`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 6, 4, 1, '2022-04-21 14:23:29', '2022-04-21 14:23:29', NULL),
(4, 6, 4, 2, '2022-04-21 14:25:17', '2022-04-21 14:25:17', NULL),
(5, 6, 4, 3, '2022-04-21 14:27:43', '2022-04-21 14:27:43', NULL),
(6, 6, 4, 4, '2022-04-21 14:37:58', '2022-04-21 14:37:58', NULL),
(7, 6, 3, 1, '2022-04-21 14:39:08', '2022-04-21 14:39:08', NULL),
(8, 6, 3, 2, '2022-04-21 14:49:12', '2022-04-21 14:49:12', NULL),
(9, 6, 3, 3, '2022-04-21 14:49:22', '2022-04-21 14:49:22', NULL),
(10, 6, 3, 4, '2022-04-21 14:50:05', '2022-04-21 14:50:05', NULL),
(11, 6, 3, 5, '2022-04-21 14:50:14', '2022-04-21 14:50:14', NULL),
(12, 6, 3, 6, '2022-04-21 14:51:09', '2022-04-21 14:51:09', NULL),
(13, 6, 3, 7, '2022-04-21 14:51:20', '2022-04-21 14:51:20', NULL),
(14, 6, 3, 8, '2022-04-21 14:52:00', '2022-04-21 14:52:00', NULL),
(15, 6, 3, 9, '2022-04-21 14:52:09', '2022-04-21 14:52:09', NULL);

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

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`ID`, `token`, `ip_address`, `user_agent`, `expire_at`, `created_at`, `updated_at`) VALUES
(11, '053193c4a81653981ba82c4153b83a30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88', '2022-05-15 01:09:05', '2022-04-15 01:09:05', '2022-04-15 01:09:05'),
(13, '119acdc42137db520065e1641aa40932', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:99.0) Gecko/20100101 Firefox/99.0', '2022-04-16 16:48:26', '2022-04-15 16:48:26', '2022-04-15 16:48:26'),
(55, '6c91a0bd293321a23c1112d0ffcac7ba', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:99.0) Gecko/20100101 Firefox/99.0', '2022-04-28 00:30:08', '2022-04-27 00:30:08', '2022-04-27 00:30:08');

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
  `gender` bit(1) DEFAULT b'0' COMMENT '0: female\r\n1: male',
  `type_user` bit(1) DEFAULT NULL COMMENT '0: Doctor,\r\n1: Patient',
  `status` bit(1) NOT NULL DEFAULT b'0' COMMENT '0: Disable,\r\n1: Enable',
  `is_admin` bit(1) NOT NULL DEFAULT b'0' COMMENT 'Admin Panel,\r\n0: Not Admin,\r\n1: Is Admin',
  `image` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `verify_code_mobile` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL,
  `verify_code_email` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL,
  `mobile_verified_at` datetime DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `recovery_pass_at` datetime DEFAULT NULL,
  `change_pass_at` datetime DEFAULT NULL,
  `token` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'Uniqe,\r\nFor login',
  `password` varchar(100) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `username`, `firstname`, `lastname`, `email`, `gender`, `type_user`, `status`, `is_admin`, `image`, `verify_code_mobile`, `verify_code_email`, `mobile_verified_at`, `email_verified_at`, `created_at`, `updated_at`, `deleted_at`, `last_login_at`, `recovery_pass_at`, `change_pass_at`, `token`, `password`) VALUES
(5, '09376885515', 'امیرحسین', 'حسنی نجف آبادی', 'amirhoseinh1373@gmail.com', b'1', b'0', b'1', b'0', '1649965396_2d1877cc81c824dd8e28.jpg', '851269', NULL, '2022-04-11 00:26:11', NULL, '2022-04-11 00:25:35', '2022-04-27 00:30:08', NULL, '2022-04-27 00:30:08', '2022-04-21 14:28:42', '2022-04-21 14:37:14', '6c91a0bd293321a23c1112d0ffcac7ba', '$2y$10$9vHHZ57QlsbNp2Nx3ZJoPetSQtWgYd1vQ7Ipj28qLKkU9eMBG6NqK'),
(6, '09380332228', 'بانو', 'شفیعی', NULL, b'0', b'1', b'1', b'0', '1651000569_044b01c89b36843808cf.jpg', '988786', NULL, '2022-04-15 16:48:26', NULL, '2022-04-15 16:47:37', '2022-04-27 00:28:28', NULL, '2022-04-27 00:28:28', NULL, NULL, '6173b752c66cb959b0eb55b4181a1712', '$2y$10$21okBDW34XpR4hHEsfYmKO0c.bAH1/h72K4dKw72PPLMjwrxLvYkO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
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
-- Indexes for table `metadata`
--
ALTER TABLE `metadata`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `meta_key` (`meta_key`);

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
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `permalink` (`url`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metadata`
--
ALTER TABLE `metadata`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_request`
--
ALTER TABLE `payment_request`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `payment_track`
--
ALTER TABLE `payment_track`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
