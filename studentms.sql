-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 13, 2024 at 06:06 PM
-- Server version: 8.0.30
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentms`
--

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE `clubs` (
  `id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admno` int NOT NULL,
  `club` varchar(20) NOT NULL,
  `rank` varchar(20) NOT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`id`, `date`, `admno`, `club`, `rank`, `status`) VALUES
(8, '2024-09-11 18:02:31', 100, 'Wildlife club', 'secretary', 1),
(9, '2024-09-11 20:47:56', 100, 'ART', 'CAPTAIN', 1);

-- --------------------------------------------------------

--
-- Table structure for table `disciplinary`
--

CREATE TABLE `disciplinary` (
  `id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admno` int NOT NULL,
  `case` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `punishment` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `disciplinary`
--

INSERT INTO `disciplinary` (`id`, `date`, `admno`, `case`, `punishment`, `status`) VALUES
(8, '2018-02-02 21:00:00', 100, 'stealing', 'suspended', 1),
(9, '2024-09-11 21:05:12', 100, 'Murder', 'CONDEMN', 1);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(20) NOT NULL,
  `admno` int NOT NULL,
  `form` int NOT NULL,
  `term` int NOT NULL,
  `subject` varchar(20) NOT NULL,
  `score` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `date`, `type`, `admno`, `form`, `term`, `subject`, `score`) VALUES
(1, '2024-09-12 13:56:39', 'CAT 1', 100, 1, 1, 'MATHS', 20),
(2, '2024-09-12 14:22:16', 'CAT 1', 100, 1, 1, 'ENGLISH', 22),
(5, '2024-09-12 21:43:02', 'CAT 2', 100, 1, 1, 'MATHS', 23),
(6, '2024-09-12 21:45:29', 'END TERM', 100, 1, 1, 'MATHS', 50),
(7, '2024-09-12 21:45:56', 'OVERALL', 100, 1, 1, 'MATHS', 72);

-- --------------------------------------------------------

--
-- Table structure for table `feestructure`
--

CREATE TABLE `feestructure` (
  `id` int NOT NULL,
  `form` int NOT NULL,
  `term` int NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feestructure`
--

INSERT INTO `feestructure` (`id`, `form`, `term`, `amount`) VALUES
(18, 1, 1, 30000),
(19, 1, 2, 35000),
(20, 1, 3, 29000),
(21, 2, 1, 34000),
(22, 2, 2, 40000),
(23, 2, 3, 25000),
(24, 3, 1, 39000),
(25, 3, 2, 42000),
(26, 3, 3, 29000),
(27, 4, 1, 38000),
(28, 4, 2, 37000),
(29, 4, 3, 29000);

-- --------------------------------------------------------

--
-- Table structure for table `finance`
--

CREATE TABLE `finance` (
  `id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admno` int NOT NULL,
  `form` int NOT NULL,
  `term` int NOT NULL,
  `receipt` varchar(12) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finance`
--

INSERT INTO `finance` (`id`, `date`, `admno`, `form`, `term`, `receipt`, `amount`) VALUES
(22, '2024-09-12 12:35:21', 100, 1, 1, '12345', 25000),
(23, '2024-09-12 12:58:50', 100, 1, 1, '1234', 1000),
(24, '2024-09-12 13:12:19', 100, 1, 1, '11222dd', 3000);

-- --------------------------------------------------------

--
-- Table structure for table `medical`
--

CREATE TABLE `medical` (
  `id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admno` int NOT NULL,
  `sickness` varchar(20) NOT NULL,
  `allergies` varchar(20) NOT NULL,
  `treatment` varchar(20) NOT NULL,
  `status` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medical`
--

INSERT INTO `medical` (`id`, `date`, `admno`, `sickness`, `allergies`, `treatment`, `status`) VALUES
(19, '2018-02-02 21:00:00', 100, 'fever', 'dust', 'medication', 0),
(20, '2024-09-11 22:37:06', 100, 'Malaria', 'Meat', 'Panadol', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE `sports` (
  `id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admno` int NOT NULL,
  `sport` varchar(20) NOT NULL,
  `rank` varchar(20) NOT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`id`, `date`, `admno`, `sport`, `rank`, `status`) VALUES
(16, '2024-09-11 21:48:09', 100, 'Football            ', 'CAPTAIN', 1),
(17, '2024-09-11 21:59:59', 100, 'ATHLETICS', 'CAPTAIN', 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admno` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `form` int NOT NULL,
  `stream` varchar(10) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` varchar(20) NOT NULL,
  `kcpe` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `date`, `admno`, `name`, `form`, `stream`, `contact`, `address`, `kcpe`) VALUES
(5, '2024-09-11 17:40:34', 100, 'Kal Henry', 1, 'West', '0707711265', '00100, Nairobi', 420);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(20) NOT NULL,
  `type` varchar(30) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(64) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `date`, `name`, `type`, `phone`, `username`, `password`, `status`) VALUES
(36, '2024-09-12 15:25:13', 'Langat Nelson', 'PRINCIPAL', '0707711265', 'principal@gmail.com', 'c9e8b9a7a8fdc0a89e002d0508ead2e0f32df664', 1),
(37, '2024-09-12 15:43:56', 'Donna Bora', 'CLUB MASTER', '0707723456', 'club@gmail.com', 'c9e8b9a7a8fdc0a89e002d0508ead2e0f32df664', 1),
(38, '2024-09-12 15:43:56', 'Donna Bora', 'DISCIPLINARY MASTER', '0707723456', 'disciplinary@gmail.com', 'c9e8b9a7a8fdc0a89e002d0508ead2e0f32df664', 1),
(39, '2024-09-12 15:43:56', 'Donna Bora', 'SPORT MASTER', '0707723456', 'sports@gmail.com', 'c9e8b9a7a8fdc0a89e002d0508ead2e0f32df664', 1),
(40, '2024-09-12 15:43:56', 'Donna Bora', 'NURSE', '0707723456', 'medical@gmail.com', 'c9e8b9a7a8fdc0a89e002d0508ead2e0f32df664', 1),
(41, '2024-09-12 15:25:13', 'Langat Nelson', 'FINANCE', '0707711265', 'finance@gmail.com', 'c9e8b9a7a8fdc0a89e002d0508ead2e0f32df664', 1),
(42, '2024-09-12 15:25:13', 'Langat Nelson', 'TEACHER', '0707711265', 'exam@gmail.com', 'c9e8b9a7a8fdc0a89e002d0508ead2e0f32df664', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disciplinary`
--
ALTER TABLE `disciplinary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feestructure`
--
ALTER TABLE `feestructure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finance`
--
ALTER TABLE `finance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical`
--
ALTER TABLE `medical`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
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
-- AUTO_INCREMENT for table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `disciplinary`
--
ALTER TABLE `disciplinary`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feestructure`
--
ALTER TABLE `feestructure`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `finance`
--
ALTER TABLE `finance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `medical`
--
ALTER TABLE `medical`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sports`
--
ALTER TABLE `sports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
