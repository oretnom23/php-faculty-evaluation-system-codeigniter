-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2021 at 06:28 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eval_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(30) NOT NULL,
  `restriction_id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `chairperson_id` int(30) NOT NULL,
  `evaluation_id` int(30) NOT NULL,
  `faculty_id` int(30) NOT NULL,
  `subject_id` int(30) NOT NULL,
  `question_id` int(30) NOT NULL,
  `answer` text NOT NULL,
  `other_details` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `restriction_id`, `student_id`, `chairperson_id`, `evaluation_id`, `faculty_id`, `subject_id`, `question_id`, `answer`, `other_details`, `date_created`) VALUES
(1, 1, 1, 0, 1, 2, 1, 14, '5', '[\"Subject 1\"]', '2020-10-27 02:13:48'),
(2, 1, 1, 0, 1, 2, 1, 18, '4', '[\"Subject 1\"]', '2020-10-27 02:13:48'),
(3, 1, 1, 0, 1, 2, 1, 15, '5', '[\"Subject 1\"]', '2020-10-27 02:13:48'),
(4, 1, 1, 0, 1, 2, 1, 16, '5', '[\"Subject 1\"]', '2020-10-27 02:13:48'),
(5, 1, 1, 0, 1, 2, 1, 17, '4', '[\"Subject 1\"]', '2020-10-27 02:13:48'),
(6, 2, 1, 0, 1, 2, 3, 14, '5', '[\"Subject 2\"]', '2020-10-27 02:14:50'),
(7, 2, 1, 0, 1, 2, 3, 18, '5', '[\"Subject 2\"]', '2020-10-27 02:14:50'),
(8, 2, 1, 0, 1, 2, 3, 15, '5', '[\"Subject 2\"]', '2020-10-27 02:14:50'),
(9, 2, 1, 0, 1, 2, 3, 16, '5', '[\"Subject 2\"]', '2020-10-27 02:14:50'),
(10, 2, 1, 0, 1, 2, 3, 17, '5', '[\"Subject 2\"]', '2020-10-27 02:14:50'),
(16, 7, 1, 0, 1, 6, 4, 14, '5', '[\"Subject 3\"]', '2020-10-27 03:28:49'),
(17, 7, 1, 0, 1, 6, 4, 18, '5', '[\"Subject 3\"]', '2020-10-27 03:28:49'),
(18, 7, 1, 0, 1, 6, 4, 15, '5', '[\"Subject 3\"]', '2020-10-27 03:28:49'),
(19, 7, 1, 0, 1, 6, 4, 16, '5', '[\"Subject 3\"]', '2020-10-27 03:28:49'),
(20, 7, 1, 0, 1, 6, 4, 17, '5', '[\"Subject 3\"]', '2020-10-27 03:28:49'),
(23, 0, 0, 1, 1, 2, 0, 12, '5', '', '2020-10-27 03:33:48'),
(24, 0, 0, 1, 1, 2, 0, 13, '5', '', '2020-10-27 03:33:48'),
(25, 0, 0, 1, 1, 6, 0, 12, '4', '', '2020-10-27 03:34:05'),
(26, 0, 0, 1, 1, 6, 0, 13, '5', '', '2020-10-27 03:34:05'),
(27, 1, 3, 0, 1, 2, 1, 14, '4', '[\"Subject 1\"]', '2021-02-13 08:59:03'),
(28, 1, 3, 0, 1, 2, 1, 18, '4', '[\"Subject 1\"]', '2021-02-13 08:59:03'),
(29, 1, 3, 0, 1, 2, 1, 15, '5', '[\"Subject 1\"]', '2021-02-13 08:59:03'),
(30, 1, 3, 0, 1, 2, 1, 16, '5', '[\"Subject 1\"]', '2021-02-13 08:59:03'),
(31, 1, 3, 0, 1, 2, 1, 17, '4', '[\"Subject 1\"]', '2021-02-13 08:59:03'),
(32, 2, 3, 0, 1, 2, 3, 14, '5', '[\"Subject 2\"]', '2021-02-13 08:59:15'),
(33, 2, 3, 0, 1, 2, 3, 18, '4', '[\"Subject 2\"]', '2021-02-13 08:59:15'),
(34, 2, 3, 0, 1, 2, 3, 15, '5', '[\"Subject 2\"]', '2021-02-13 08:59:15'),
(35, 2, 3, 0, 1, 2, 3, 16, '4', '[\"Subject 2\"]', '2021-02-13 08:59:15'),
(36, 2, 3, 0, 1, 2, 3, 17, '5', '[\"Subject 2\"]', '2021-02-13 08:59:15'),
(37, 7, 3, 0, 1, 6, 4, 14, '5', '[\"Subject 3\"]', '2021-02-13 08:59:22'),
(38, 7, 3, 0, 1, 6, 4, 18, '4', '[\"Subject 3\"]', '2021-02-13 08:59:22'),
(39, 7, 3, 0, 1, 6, 4, 15, '5', '[\"Subject 3\"]', '2021-02-13 08:59:22'),
(40, 7, 3, 0, 1, 6, 4, 16, '4', '[\"Subject 3\"]', '2021-02-13 08:59:22'),
(41, 7, 3, 0, 1, 6, 4, 17, '5', '[\"Subject 3\"]', '2021-02-13 08:59:22');

-- --------------------------------------------------------

--
-- Table structure for table `chairperson_list`
--

CREATE TABLE `chairperson_list` (
  `id` int(30) NOT NULL,
  `id_code` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `auto_generated` text NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `department_id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = inactive , 2 = active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chairperson_list`
--

INSERT INTO `chairperson_list` (`id`, `id_code`, `password`, `auto_generated`, `firstname`, `middlename`, `lastname`, `department_id`, `course_id`, `status`, `date_created`, `date_updated`) VALUES
(1, '123456', '', '36ji8rhi', 'Chair1', '', 'Chair1', 1, 2, 1, '2020-10-26 21:23:52', '2021-02-13 13:21:52'),
(2, '654321', '', '654321', 'George', '', 'Wilson', 1, 3, 1, '2020-10-26 22:52:43', '2020-10-26 23:12:28'),
(3, '12345', '', 'vzx74zkn', 'James', 'A', 'Bond', 1, 2, 0, '2021-02-13 09:02:30', '2021-02-13 09:02:40');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(30) NOT NULL,
  `evaluation_id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `chairperson_id` int(30) NOT NULL,
  `restriction_id` int(30) NOT NULL,
  `comment` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `evaluation_id`, `student_id`, `chairperson_id`, `restriction_id`, `comment`, `date_created`, `date_updated`) VALUES
(1, 1, 1, 0, 7, 'test', '2020-10-27 03:28:49', '2020-10-27 03:29:29'),
(2, 1, 0, 1, 0, 'asdasdasd', '2020-10-27 03:33:48', '2020-10-27 03:33:48'),
(3, 1, 0, 1, 0, 'ddsss', '2020-10-27 03:34:05', '2020-10-27 03:34:05'),
(4, 1, 3, 0, 1, '', '2021-02-13 08:59:03', '2021-02-13 08:59:03'),
(5, 1, 3, 0, 2, '', '2021-02-13 08:59:15', '2021-02-13 08:59:15'),
(6, 1, 3, 0, 7, '', '2021-02-13 08:59:22', '2021-02-13 08:59:22');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(30) NOT NULL,
  `department_id` int(30) NOT NULL,
  `course` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0= Inactive, 1= active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `department_id`, `course`, `description`, `status`, `date_created`, `date_updated`) VALUES
(2, 1, 'BSIS', 'Bachelor of Science in Industrial Technology', 1, '2020-10-12 21:21:06', '2020-10-26 22:06:20'),
(3, 1, 'BSIT', 'BSIT', 1, '2020-10-26 22:03:02', '2020-10-26 22:03:02'),
(4, 1, 'BSCE', 'BSCE', 1, '2020-10-26 22:04:09', '2020-10-26 22:04:27');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `id` int(30) NOT NULL,
  `criteria` varchar(200) NOT NULL,
  `parent_id` int(30) NOT NULL,
  `order_by` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `criteria`, `parent_id`, `order_by`, `status`) VALUES
(1, 'Tecahing Effectiveness', 0, 0, 1),
(3, 'Knowledge of Subject', 1, 4, 1),
(4, 'Commitment', 1, 1, 1),
(5, 'Teaching for Independent Learning', 1, 2, 1),
(6, 'Management of Learning', 1, 3, 1),
(7, 'test', 0, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_level_list`
--

CREATE TABLE `curriculum_level_list` (
  `id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `year` varchar(15) NOT NULL,
  `section` varchar(100) NOT NULL,
  `department_id` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = Inactive, 1 = active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `curriculum_level_list`
--

INSERT INTO `curriculum_level_list` (`id`, `course_id`, `year`, `section`, `department_id`, `status`, `date_created`, `date_updated`) VALUES
(1, 2, '1', 'A', 1, 1, '2020-10-12 21:32:46', '2020-10-26 23:00:21'),
(2, 2, '1', 'B', 1, 1, '2020-10-12 22:13:46', '2020-10-26 23:00:25'),
(3, 2, '1', 'C', 1, 1, '2020-10-26 23:11:17', '2020-10-26 23:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `department_list`
--

CREATE TABLE `department_list` (
  `id` int(30) NOT NULL,
  `department` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive , 1 = Active',
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department_list`
--

INSERT INTO `department_list` (`id`, `department`, `description`, `status`, `date_updated`, `date_created`) VALUES
(1, 'CIT', 'C Information Technology', 1, '2020-09-01 12:57:04', '2020-09-01'),
(2, 'Sample ', 'Sample Department', 0, '2020-09-06 13:35:31', '2020-09-01'),
(3, 'Sample Departmenttt', 'Sample only', 0, '2020-09-06 13:10:21', '2020-09-06'),
(4, 'Sample Departmenttt', 'Sample only\r\n', 0, '2020-09-06 13:14:11', '2020-09-06'),
(5, 'Sample Department', 'Sample only', 0, '2020-09-06 13:16:10', '2020-09-06'),
(6, 'Sample Departmentttt', 'Sample only', 0, '2020-09-06 13:21:31', '2020-09-06'),
(7, 'Sample Department', 'Sample Only', 0, '2020-09-06 13:24:32', '2020-09-06'),
(8, 'Sample Department', 'Sample Only', 0, '2020-09-06 13:24:35', '2020-09-06'),
(9, 'Sample Department', 'Sample only', 0, '2020-09-06 13:25:47', '2020-09-06'),
(10, 'Sample Department', 'Sample only', 0, '2020-09-06 13:25:49', '2020-09-06'),
(11, 'Sample Department', 'Sample only', 0, '2020-09-06 13:26:34', '2020-09-06'),
(12, 'Sample Departmentttt', 'Sample onlyyyy', 0, '2020-09-06 13:34:26', '2020-09-06'),
(13, 'Samplee', 'Sample onlyy', 1, '2020-09-06 13:35:58', '2020-09-06');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_criteria`
--

CREATE TABLE `evaluation_criteria` (
  `id` int(30) NOT NULL,
  `criteria` varchar(200) NOT NULL,
  `order_by` int(30) NOT NULL,
  `parent_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_list`
--

CREATE TABLE `evaluation_list` (
  `id` int(11) NOT NULL,
  `school_year` text NOT NULL,
  `semester` varchar(50) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0= Inactive, 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `evaluation_list`
--

INSERT INTO `evaluation_list` (`id`, `school_year`, `semester`, `is_default`, `date_created`, `date_updated`, `status`) VALUES
(1, '2020-2021', '1st', 1, '2020-10-12 21:47:51', '2020-10-25 13:14:43', 1);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_settings`
--

CREATE TABLE `evaluation_settings` (
  `id` int(30) NOT NULL,
  `evaluation_id` int(30) NOT NULL,
  `details` text NOT NULL,
  `rating_max` tinyint(3) NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_list`
--

CREATE TABLE `faculty_list` (
  `id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `name_pref` text NOT NULL,
  `department_id` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive , 1 = active',
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty_list`
--

INSERT INTO `faculty_list` (`id`, `firstname`, `lastname`, `name_pref`, `department_id`, `status`, `date_updated`, `date_created`) VALUES
(1, 'Sample', 'Sample', 'Jr.', 2, 1, '2020-10-26 14:07:26', '2020-09-01'),
(2, 'sample', 'Sample', '', 1, 1, '2020-09-02 10:28:46', '2020-09-02'),
(3, 'Test', 'Test', 'Sr.', 1, 0, '2020-09-06 13:16:32', '2020-09-06'),
(4, 'Test', 'Testtttt', 'Sr.', 6, 0, '2020-09-06 13:34:42', '2020-09-06'),
(5, 'sample', 'Sample', 'Sr.', 1, 0, '2020-09-06 13:34:47', '2020-09-06'),
(6, 'Juan', 'Dela Cruz', '', 1, 1, '2020-09-06 13:37:00', '2020-09-06'),
(7, 'John', 'Smith', '', 1, 1, '2020-10-26 14:31:54', '2020-10-26');

-- --------------------------------------------------------

--
-- Table structure for table `question_list`
--

CREATE TABLE `question_list` (
  `id` int(30) NOT NULL,
  `evaluation_id` int(30) NOT NULL,
  `criteria_id` int(30) NOT NULL,
  `order_by` int(10) NOT NULL,
  `question` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = rating, 2 = textarea',
  `question_for` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = for students, 2= for chairperson',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_list`
--

INSERT INTO `question_list` (`id`, `evaluation_id`, `criteria_id`, `order_by`, `question`, `type`, `question_for`, `date_updated`) VALUES
(12, 1, 4, 0, 'Q1', 1, 2, '2020-10-25 22:04:51'),
(13, 1, 5, 1, 'Q1', 1, 2, '2020-10-25 22:04:51'),
(14, 1, 4, 0, 'Sample 1', 1, 1, '2020-10-25 22:21:15'),
(15, 1, 5, 2, 'Sample 1', 1, 1, '2020-10-27 01:57:50'),
(16, 1, 6, 3, 'Sample 1', 1, 1, '2020-10-27 01:57:50'),
(17, 1, 3, 4, 'Sample 1', 1, 1, '2020-10-27 01:57:50'),
(18, 1, 4, 1, 'question 2', 1, 1, '2020-10-27 01:57:50');

-- --------------------------------------------------------

--
-- Table structure for table `restriction_list`
--

CREATE TABLE `restriction_list` (
  `id` int(30) NOT NULL,
  `evaluation_id` int(30) NOT NULL,
  `curriculum_id` int(30) NOT NULL,
  `faculty_id` int(30) NOT NULL,
  `subject_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `restriction_list`
--

INSERT INTO `restriction_list` (`id`, `evaluation_id`, `curriculum_id`, `faculty_id`, `subject_id`, `date_created`, `date_updated`) VALUES
(1, 1, 1, 2, 1, '2020-10-25 16:02:27', '2020-10-25 16:02:27'),
(2, 1, 1, 2, 3, '2020-10-25 16:02:27', '2020-10-25 16:02:27'),
(7, 1, 1, 6, 4, '2020-10-27 01:16:10', '2020-10-27 01:16:10');

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `id` int(30) NOT NULL,
  `student_code` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `auto_generated` text NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `department_id` int(30) NOT NULL,
  `cl_id` int(30) NOT NULL COMMENT 'curriculum level and section ID',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = inactive , 2 = active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`id`, `student_code`, `password`, `auto_generated`, `firstname`, `middlename`, `lastname`, `department_id`, `cl_id`, `status`, `date_created`, `date_updated`) VALUES
(1, '20140623', 'c865547a41d4208a4a9272426b85b435', '', 'sample', 'S', 'Sample', 1, 1, 1, '2020-10-12 21:44:37', '2020-10-27 00:28:07'),
(2, '06232014', '', 'y64897k2', 'John', 'C', 'Smith', 1, 1, 1, '2020-10-12 21:45:18', '2020-10-12 21:45:18'),
(3, '6231415', '', 'on5yuca8', 'Claire', 'C', 'Blake', 1, 1, 1, '2021-02-13 08:53:46', '2021-02-13 08:53:46');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(30) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `subject`, `description`, `status`, `date_created`) VALUES
(1, 'Subject 1', 'Sample Subject 1', 1, '2020-10-25 12:55:00'),
(3, 'Subject 2', 'Sample Subject 2', 1, '2020-10-25 12:56:46'),
(4, 'Subject 3', 'Subject 3', 1, '2020-10-27 01:01:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `user_type` tinyint(1) NOT NULL COMMENT '1=admin,=2= Staff,3=Dean',
  `department_id` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = inactive ,1 = active',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `user_type`, `department_id`, `status`, `date_updated`) VALUES
(1, 'Admin', '', 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', 1, 0, 1, '2020-09-07 19:27:55'),
(3, 'Dean', 'Dean', 'Dean', 'dean', '48767461cb09465362c687ae0c44753b', 3, 1, 1, '2020-10-26 00:09:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chairperson_list`
--
ALTER TABLE `chairperson_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `curriculum_level_list`
--
ALTER TABLE `curriculum_level_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_list`
--
ALTER TABLE `department_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation_list`
--
ALTER TABLE `evaluation_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation_settings`
--
ALTER TABLE `evaluation_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty_list`
--
ALTER TABLE `faculty_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_list`
--
ALTER TABLE `question_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restriction_list`
--
ALTER TABLE `restriction_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `chairperson_list`
--
ALTER TABLE `chairperson_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `curriculum_level_list`
--
ALTER TABLE `curriculum_level_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `department_list`
--
ALTER TABLE `department_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `evaluation_list`
--
ALTER TABLE `evaluation_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `evaluation_settings`
--
ALTER TABLE `evaluation_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculty_list`
--
ALTER TABLE `faculty_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `question_list`
--
ALTER TABLE `question_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `restriction_list`
--
ALTER TABLE `restriction_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
