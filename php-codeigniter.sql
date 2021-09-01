-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-05-19 08:48:30
-- 伺服器版本： 10.4.14-MariaDB
-- PHP 版本： 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `php-codeigniter`
--

-- --------------------------------------------------------

--
-- 資料表結構 `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `courses`
--

INSERT INTO `courses` (`course_id`, `code`, `name`, `teacher_id`) VALUES
(1, 'AST10201', 'Computer Organization', 1),
(2, 'AST10303', 'Understanding the Network-Centric World', 2),
(3, 'AST10106', 'Introduction to Programming', 3);

-- --------------------------------------------------------

--
-- 資料表結構 `course_lecture`
--

CREATE TABLE `course_lecture` (
  `lecture_id` int(11) UNSIGNED NOT NULL,
  `course_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `course_lecture`
--

INSERT INTO `course_lecture` (`lecture_id`, `course_id`, `date`, `start_time`, `end_time`) VALUES
(1, 1, '2021-05-18', '12:00:00', '20:00:00'),
(2, 1, '2021-05-19', '12:00:00', '20:00:00'),
(3, 2, '2021-05-19', '12:00:00', '20:00:00'),
(4, 1, '2021-05-19', '14:00:00', '15:00:00'),
(5, 1, '2021-05-20', '12:40:00', '18:40:00');

-- --------------------------------------------------------

--
-- 資料表結構 `course_student`
--

CREATE TABLE `course_student` (
  `id` int(11) UNSIGNED NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `course_student`
--

INSERT INTO `course_student` (`id`, `course_id`, `student_id`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 1, 4),
(4, 1, 5);

-- --------------------------------------------------------

--
-- 資料表結構 `lecture_attendance`
--

CREATE TABLE `lecture_attendance` (
  `attendance_id` int(11) UNSIGNED NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `lecture_attendance`
--

INSERT INTO `lecture_attendance` (`attendance_id`, `lecture_id`, `student_id`) VALUES
(1, 1, 2),
(3, 1, 3),
(8, 2, 5),
(9, 4, 2),
(10, 4, 3),
(11, 4, 5),
(13, 2, 4),
(14, 2, 6),
(15, 2, 7),
(16, 2, 8),
(17, 2, 9),
(18, 2, 10),
(19, 2, 11),
(20, 2, 12),
(21, 2, 13),
(22, 2, 51),
(23, 3, 51),
(24, 4, 4),
(25, 4, 6),
(26, 4, 38);

-- --------------------------------------------------------

--
-- 資料表結構 `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(42, '2021-05-15-032738', 'App\\Database\\Migrations\\Addusers', 'default', 'App', 1621389926, 1),
(43, '2021-05-18-133449', 'App\\Database\\Migrations\\Courses', 'default', 'App', 1621389926, 1),
(44, '2021-05-18-151901', 'App\\Database\\Migrations\\CourseStudent', 'default', 'App', 1621389926, 1),
(45, '2021-05-18-152141', 'App\\Database\\Migrations\\CourseLecture', 'default', 'App', 1621389927, 1),
(46, '2021-05-18-152220', 'App\\Database\\Migrations\\LectureAttendance', 'default', 'App', 1621389927, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rank` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `token_created` datetime NOT NULL,
  `last_active` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `rank`, `token`, `token_created`, `last_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Liu', '', 0, 'password', 'teacher', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(2, 'Yan', '', 0, 'password', 'teacher', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(3, 'Pang', '', 0, 'password', 'teacher', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(4, 'CHAN Chak Mo', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(5, 'CHAN Cheuk Fung', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(6, 'CHAN Tsam Lam Kathleen', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(7, 'CHAN Wing Hei', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(8, 'CHAN Yuen Ni', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(9, 'CHANG Wai Chung', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(10, 'CHAU Yue Hei', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(11, 'CHENG Shenqi', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(12, 'CHONG Chun Man', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(13, 'CHOU Chun Yu Dominic', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(14, 'CHU Shun Hei', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(15, 'CHUNG Wing Hei', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(16, 'FAN Tsz Kin', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(17, 'HEUNG Wing Kit Francis', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(18, 'HUANG Jinhuan', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(19, 'HUANG Yiting', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(20, 'HUI Wang Hon', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(21, 'HUI Yat Nok', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(22, 'JIANG Yiyang', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(23, 'KU Ming Kit', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(24, 'KWAN Cheuk Man', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(25, 'KWONG Ho Yin', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(26, 'LAI Ching Man', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(27, 'LAM Ho Hei', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(28, 'LEE Kwok Hei Conway', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(29, 'LI Po Lung', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(30, 'LI Weizong', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(31, 'LI Wo Hing', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(32, 'LIANG Yee Sum Eason', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(33, 'LIN Zhiwei', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(34, 'LIU Kai Chun', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(35, 'MANDALIHAN Martha Hillary Sales', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(36, 'MUI Chun Yu', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(37, 'NG Hong Wing', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(38, 'PUN Yiu Kwan', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(39, 'QIAN Weifeng', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(40, 'SINGH Pawandeep', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(41, 'SZE Chun', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(42, 'TAM Tsz Hei', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(43, 'TANG Wing Yin', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(44, 'WANG Yuxuan', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(45, 'WONG Chak Hei', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(46, 'WONG Ho Ming', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(47, 'WONG Kwong Hong', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(48, 'WONG Pak Kong Parco', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(49, 'YIP Ming Keung', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(50, 'YUNG Kam Kong', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36'),
(51, 'student', '', 0, 'password', 'student', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2021-05-19 14:22:36', '2021-05-19 14:22:36', '2021-05-19 14:22:36');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- 資料表索引 `course_lecture`
--
ALTER TABLE `course_lecture`
  ADD PRIMARY KEY (`lecture_id`);

--
-- 資料表索引 `course_student`
--
ALTER TABLE `course_student`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `lecture_attendance`
--
ALTER TABLE `lecture_attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- 資料表索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `course_lecture`
--
ALTER TABLE `course_lecture`
  MODIFY `lecture_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `course_student`
--
ALTER TABLE `course_student`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `lecture_attendance`
--
ALTER TABLE `lecture_attendance`
  MODIFY `attendance_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
