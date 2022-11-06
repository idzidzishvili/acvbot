-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 06, 2022 at 07:45 PM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acv`
--

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `state` varchar(50) NOT NULL,
  `abbr` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `state`, `abbr`) VALUES
(1, 'Alabama', 'AL'),
(2, 'Alaska', 'AK'),
(3, 'Arizona', 'AZ'),
(4, 'Arkansas', 'AR'),
(5, 'American Samoa', 'AS'),
(6, 'California', 'CA'),
(7, 'Colorado', 'CO'),
(8, 'Connecticut', 'CT'),
(9, 'Delaware', 'DE'),
(10, 'District of Columbia', 'DC'),
(11, 'Florida', 'FL'),
(12, 'Georgia', 'GA'),
(13, 'Guam', 'GU'),
(14, 'Hawaii', 'HI'),
(15, 'Idaho', 'ID'),
(16, 'Illinois', 'IL'),
(17, 'Indiana', 'IN'),
(18, 'Iowa', 'IA'),
(19, 'Kansas', 'KS'),
(20, 'Kentucky', 'KY'),
(21, 'Louisiana', 'LA'),
(22, 'Maine', 'ME'),
(23, 'Maryland', 'MD'),
(24, 'Massachusetts', 'MA'),
(25, 'Michigan', 'MI'),
(26, 'Minnesota', 'MN'),
(27, 'Mississippi', 'MS'),
(28, 'Missouri', 'MO'),
(29, 'Montana', 'MT'),
(30, 'Nebraska', 'NE'),
(31, 'Nevada', 'NV'),
(32, 'New Hampshire', 'NH'),
(33, 'New Jersey', 'NJ'),
(34, 'New Mexico', 'NM'),
(35, 'New York', 'NY'),
(36, 'North Carolina', 'NC'),
(37, 'North Dakota', 'ND'),
(38, 'Northern Mariana Islands', 'MP'),
(39, 'Ohio', 'OH'),
(40, 'Oklahoma', 'OK'),
(41, 'Oregon', 'OR'),
(42, 'Pennsylvania', 'PA'),
(43, 'Puerto Rico', 'PR'),
(44, 'Rhode Island', 'RI'),
(45, 'South Carolina', 'SC'),
(46, 'South Dakota', 'SD'),
(47, 'Tennessee', 'TN'),
(48, 'Texas', 'TX'),
(49, 'Trust Territories', 'TT'),
(50, 'Utah', 'UT'),
(51, 'Vermont', 'VT'),
(52, 'Virginia', 'VA'),
(53, 'Virgin Islands', 'VI'),
(54, 'Washington', 'WA'),
(55, 'West Virginia', 'WV'),
(56, 'Wisconsin', 'WI'),
(57, 'Wyoming', 'WY');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `recoverystring` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `recoverystring`) VALUES
(1, 'newwayservicesinc@gmail.com', '$2a$12$Y6hp9HP5F4HsNtEq7wPMn.YLNPmjpPMY8aNjVv6BOvGGokYuPp2EG', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `states`
--
ALTER TABLE `states`
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
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
