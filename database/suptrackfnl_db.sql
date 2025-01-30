-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 30, 2025 at 12:39 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suptrackfnl_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ics_tb`
--

CREATE TABLE `ics_tb` (
  `id` int(11) NOT NULL,
  `entity_name` text DEFAULT NULL,
  `fund_cluster` text DEFAULT NULL,
  `ics_no` text DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `unit` text DEFAULT NULL,
  `unit_cost` int(11) DEFAULT NULL,
  `total_cost` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `item_no` text DEFAULT NULL,
  `estimate` text DEFAULT NULL,
  `receive_by` text DEFAULT NULL,
  `role1` text DEFAULT NULL,
  `issue_by` text DEFAULT NULL,
  `role2` text DEFAULT NULL,
  `date_file` date DEFAULT NULL,
  `receivefrom_date` date DEFAULT NULL,
  `receiveby_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ics_tb`
--

INSERT INTO `ics_tb` (`id`, `entity_name`, `fund_cluster`, `ics_no`, `qty`, `unit`, `unit_cost`, `total_cost`, `description`, `item_no`, `estimate`, `receive_by`, `role1`, `issue_by`, `role2`, `date_file`, `receivefrom_date`, `receiveby_date`) VALUES
(1, 'NEMSU Cantilan Campus', '05-206441', '24-128', 10, 'unit', 6000, 60000, 'Moving white board (4\" x 5\")', '24-09-496', '5 yrs', 'ERNESTO GONZALES', 'AOI/Supply Officer', 'JUANCHO INTANO', 'Campus director', '2025-01-30', '2025-01-30', '2025-01-30'),
(2, 'NEMSU Cantilan Campus', '05-206441', '24-128', 10, 'unit', 4700, 47000, 'White board (4\" x 8\")', '24-09-496', '5 yrs', 'ERNESTO GONZALES', 'AOI/Supply Officer', 'JUANCHO INTANO', 'Campus director', '2025-01-30', '2025-01-30', '2025-01-31');

-- --------------------------------------------------------

--
-- Table structure for table `par_tb`
--

CREATE TABLE `par_tb` (
  `id` int(11) NOT NULL,
  `entity_name` varchar(255) DEFAULT NULL,
  `fund_cluster` varchar(255) DEFAULT NULL,
  `par_no` varchar(100) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `property_number` varchar(100) DEFAULT NULL,
  `date_acquired` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `received_by` varchar(255) DEFAULT NULL,
  `position` text DEFAULT NULL,
  `issued_by` varchar(255) DEFAULT NULL,
  `date_file` date DEFAULT NULL,
  `position2` text DEFAULT NULL,
  `receive_date` date DEFAULT NULL,
  `issue_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `par_tb`
--

INSERT INTO `par_tb` (`id`, `entity_name`, `fund_cluster`, `par_no`, `qty`, `unit`, `description`, `property_number`, `date_acquired`, `amount`, `received_by`, `position`, `issued_by`, `date_file`, `position2`, `receive_date`, `issue_date`) VALUES
(1, 'NEMSU Cantilan Campus', '05-206441', '013-07-448', 1, 'Unit', 'Transformer, Single Phase, Pole Type, 75KVA', '24-07-016', '2025-01-31', '225000.00', 'ENGR. JORDAN Y. ARPILLEDA', 'Maintenance Office', 'ERNESTO L. GONZALES', '2025-01-30', 'AOI/Supply Offices', '2025-01-30', '2025-01-30'),
(3, 'NEMSU Cantilan Campus', '05-206441', '013-07-448', 1, 'Unit', 'Transformer, Single Phase, Pole Type, 75KVA', '24-07-016', '2025-01-31', '225000.00', 'ENGR. JORDAN Y. ARPILLEDA', 'Maintenance Office', 'ERNESTO L. GONZALES', '2025-01-30', 'AOI/Supply Offices', '2025-01-30', '2025-01-30');

-- --------------------------------------------------------

--
-- Table structure for table `qr_tb`
--

CREATE TABLE `qr_tb` (
  `id` int(11) NOT NULL,
  `serial_id` varchar(50) DEFAULT NULL,
  `property_id` varchar(50) DEFAULT NULL,
  `article` text DEFAULT NULL,
  `office` text DEFAULT NULL,
  `service_status` text DEFAULT NULL,
  `unit` text DEFAULT NULL,
  `cost` text DEFAULT NULL,
  `date_acquired` varchar(20) DEFAULT NULL,
  `date_counted` varchar(20) DEFAULT NULL,
  `coa_rep` text DEFAULT NULL,
  `property_cus` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `qr_tb`
--

INSERT INTO `qr_tb` (`id`, `serial_id`, `property_id`, `article`, `office`, `service_status`, `unit`, `cost`, `date_acquired`, `date_counted`, `coa_rep`, `property_cus`) VALUES
(3, 'SN-566', 'PN-579', 'Sample Item 2', 'Department of Computer Studies Laboratory', 'Serviceable', '200 pcs', '550000', '2025-01-09', '2025-01-23', 'Juancho Intano', 'Ernesto Gonzales'),
(4, 'SN-200', 'PN-206', 'New Office in Wing B', 'Forty Degrees Celsius Inc', 'Unserviceable', '180 unit', '450000', '2025-01-14', '2025-01-06', 'Juancho Intano', 'Ernesto Gonzales'),
(5, 'asd214124', '123', 'Sample Item ', 'Department of Computer Studies Faculty', 'Serviceable', '150pcs', '450000', '2025-01-30', '2025-01-31', 'Juancho Intano', 'Ernesto Gonzales');

-- --------------------------------------------------------

--
-- Table structure for table `user_tb`
--

CREATE TABLE `user_tb` (
  `userid` int(11) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `role` varchar(50) CHARACTER SET utf8 NOT NULL,
  `datecreated` datetime DEFAULT current_timestamp(),
  `lastlogin` datetime DEFAULT current_timestamp(),
  `status` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_tb`
--

INSERT INTO `user_tb` (`userid`, `email`, `username`, `fullname`, `password`, `role`, `datecreated`, `lastlogin`, `status`) VALUES
(2, 'admin@gmail.com', 'admin', 'Administrator', 'c4ca4238a0b923820dcc509a6f75849b', 'Admin', '2024-12-09 17:11:54', '2025-01-30 15:11:52', 'Active'),
(3, 'jaybe@gmail.com', 'jaybe123', 'Jaybe Siano', '7d88985a5821fa01ca0c544e875fb56b', 'Staff', '2025-01-08 09:56:10', NULL, 'Active'),
(7, 'kevin.arizobal@yahoo.com', 'ncwww', 'Administrator', 'f47cd8cc9729e5b92eb9513f91ce45e9', 'Admin', '2025-01-14 09:49:18', '2025-01-14 09:49:18', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ics_tb`
--
ALTER TABLE `ics_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `par_tb`
--
ALTER TABLE `par_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qr_tb`
--
ALTER TABLE `qr_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_tb`
--
ALTER TABLE `user_tb`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ics_tb`
--
ALTER TABLE `ics_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `par_tb`
--
ALTER TABLE `par_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `qr_tb`
--
ALTER TABLE `qr_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
