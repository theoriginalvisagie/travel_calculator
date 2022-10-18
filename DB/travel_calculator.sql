-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2022 at 03:27 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `travel_calculator`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_travel_allowance`
--

DROP TABLE IF EXISTS `daily_travel_allowance`;
CREATE TABLE `daily_travel_allowance` (
  `id` int(11) NOT NULL,
  `employee` int(11) NOT NULL,
  `transport_type` int(11) NOT NULL,
  `daily_allowance` text NOT NULL,
  `date` date NOT NULL,
  `distance` text NOT NULL,
  `to_from_work` varchar(4) NOT NULL,
  `status` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
(1, 'Human Resources'),
(2, 'Development'),
(3, 'Design'),
(4, 'Finaces'),
(5, 'Managment'),
(6, 'Legal'),
(7, 'Marketing'),
(8, 'IT');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `middle_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text NOT NULL,
  `contact_number` text NOT NULL,
  `department` int(11) NOT NULL,
  `workdays_per_week` decimal(12,1) NOT NULL,
  `workdays` text NOT NULL,
  `profile_pic` text NOT NULL,
  `defualt_transport_method` int(11) NOT NULL,
  `default_distance` decimal(12,2) NOT NULL,
  `travel_allowance` bit(1) NOT NULL,
  `start_allowance_from` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `userID`, `first_name`, `middle_name`, `last_name`, `email`, `contact_number`, `department`, `workdays_per_week`, `workdays`, `profile_pic`, `defualt_transport_method`, `default_distance`, `travel_allowance`, `start_allowance_from`) VALUES
(1, 0, 'Hein', '', 'Doe', 'hein@gmail.com', '01100111111', 1, '5.0', ',1,,2,,3,,4,,5,', 'SYSTEMREC/Employee_Profile_Images/298564723_5938497749511166_151310172096962044_n.jpg', 3, '12.00', b'1', '2022-09-01'),
(2, 0, 'Florian', 'May', 'James', 'james@mail.com', '0789567894', 2, '4.0', '', '', 4, '15.00', b'1', '2022-10-01'),
(3, 0, 'Wobbe', '', 'Spruijt', 'spruijt40@gmail.com', '0721516367', 5, '3.0', ',2,,3,,4,,7,', '', 3, '4.00', b'1', '2022-06-01'),
(9, 0, 'Dolj', '', 'Merwe', 'merwe@gmail.com', '0146527896', 7, '5.0', ',1,,2,,3,,4,,5,', '', 2, '20.00', b'1', '0000-00-00'),
(10, 0, 'Ioannis', 'Johannes', 'De Jager', 'dj@mail.com', '2365647894', 6, '5.0', ',1,,2,,3,,4,,5,', '', 1, '100.00', b'1', '0000-00-00'),
(11, 0, 'Ben', '', 'Schoor', 'sc@mail.com', '0254567546', 3, '4.5', ',1,,2,,3,,4,,5,', '', 3, '8.00', b'1', '0000-00-00'),
(12, 0, 'Hans', 'James', 'Heinsburg', 'hj@mail.com', '0146329854', 2, '2.0', ',2,,4,', '', 2, '150.00', b'1', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `object` text NOT NULL,
  `icon` text NOT NULL,
  `is_active` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `object`, `icon`, `is_active`) VALUES
(1, 'Home', 'BiClass', 'fa fa-solid fa-house-user', b'1'),
(2, 'Employess', 'EmployeesClass', 'fa-solid fa-people-roof', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings_tabs`
--

DROP TABLE IF EXISTS `system_settings_tabs`;
CREATE TABLE `system_settings_tabs` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `function` text NOT NULL,
  `position` int(11) NOT NULL,
  `is_active` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings_tabs`
--

INSERT INTO `system_settings_tabs` (`id`, `name`, `function`, `position`, `is_active`) VALUES
(1, 'Table Settings', 'getTableSettings', 3, 'Yes'),
(2, 'System Settings', 'getSysSettings', 2, 'Yes'),
(3, 'System Info', 'getSysInfo', 1, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `transport_types`
--

DROP TABLE IF EXISTS `transport_types`;
CREATE TABLE `transport_types` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `base_compensation_per_km` text NOT NULL,
  `min_km` decimal(12,1) NOT NULL,
  `max_km` decimal(12,1) NOT NULL,
  `factor` decimal(12,1) NOT NULL,
  `last_synced` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transport_types`
--

INSERT INTO `transport_types` (`id`, `name`, `base_compensation_per_km`, `min_km`, `max_km`, `factor`, `last_synced`) VALUES
(1, 'Train', '0.25', '0.0', '0.0', '0.0', '2022-10-17'),
(2, 'Car', '0.10', '0.0', '0.0', '0.0', '2022-10-17'),
(3, 'Bike', '0.33', '5.0', '10.0', '2.0', '2022-10-17'),
(4, 'Bus', '0.25', '0.0', '0.0', '0.0', '2022-10-17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `dateCreated`) VALUES
(1, 'demo@mail.com', 'Demo', '$2y$10$SQhwM9s/kyL8VT7Y0DDlW.1icqvwP.8LPWeK2alIrA/Q8iZGrhBF6', '2022-06-17 19:34:17');

-- --------------------------------------------------------

--
-- Table structure for table `users_settings`
--

DROP TABLE IF EXISTS `users_settings`;
CREATE TABLE `users_settings` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `middle_name` text NOT NULL,
  `last_name` text NOT NULL,
  `profile_pic` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_settings`
--

INSERT INTO `users_settings` (`id`, `userID`, `first_name`, `middle_name`, `last_name`, `profile_pic`) VALUES
(1, 1, 'Christiaan', 'Mauritz', 'Visagie', 'SYSTEMREC/User_Profile_Images/298564723_5938497749511166_151310172096962044_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `workdays`
--

DROP TABLE IF EXISTS `workdays`;
CREATE TABLE `workdays` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `abreviation` text NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `workdays`
--

INSERT INTO `workdays` (`id`, `name`, `abreviation`, `value`) VALUES
(1, 'Monday', 'Mon', 1),
(2, 'Tuesday', 'Tue', 2),
(3, 'Wednesday', 'Wed', 3),
(4, 'Thursday', 'Thu', 4),
(5, 'Fryday', 'Fry', 5),
(6, 'Saterday', 'Sat', 6),
(7, 'Sunday', 'Sun', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daily_travel_allowance`
--
ALTER TABLE `daily_travel_allowance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings_tabs`
--
ALTER TABLE `system_settings_tabs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_types`
--
ALTER TABLE `transport_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_settings`
--
ALTER TABLE `users_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workdays`
--
ALTER TABLE `workdays`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daily_travel_allowance`
--
ALTER TABLE `daily_travel_allowance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `system_settings_tabs`
--
ALTER TABLE `system_settings_tabs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transport_types`
--
ALTER TABLE `transport_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users_settings`
--
ALTER TABLE `users_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `workdays`
--
ALTER TABLE `workdays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
