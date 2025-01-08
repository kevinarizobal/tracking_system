-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 08, 2025 at 03:42 AM
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
-- Table structure for table `icsr_tb`
--

CREATE TABLE `icsr_tb` (
  `ICSID` int(11) NOT NULL,
  `EntityName` varchar(255) DEFAULT 'NEMSU - Cantilan Campus',
  `FundCluster` varchar(50) DEFAULT NULL,
  `ICSNo` varchar(50) DEFAULT NULL,
  `RecievedFrom` varchar(255) DEFAULT NULL,
  `RFPositionOffice` varchar(255) DEFAULT NULL,
  `RF` datetime DEFAULT NULL,
  `RecievedBy` varchar(255) DEFAULT NULL,
  `RBPositionOffice` varchar(255) DEFAULT NULL,
  `RB` datetime DEFAULT NULL,
  `AllTotalCost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `item_tb`
--

CREATE TABLE `item_tb` (
  `ITEMID` int(11) NOT NULL,
  `ICSNo` varchar(50) DEFAULT NULL,
  `InvNo` varchar(50) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Unit` varchar(50) DEFAULT NULL,
  `UnitCost` decimal(10,2) DEFAULT NULL,
  `UnitTotalCost` decimal(10,2) DEFAULT NULL,
  `LifeSpan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `parr_tb`
--

CREATE TABLE `parr_tb` (
  `PARRID` int(11) NOT NULL,
  `EntityName` varchar(255) DEFAULT 'NEMSU - Cantilan Campus',
  `FundCluster` varchar(50) DEFAULT NULL,
  `PARRNo` varchar(50) DEFAULT NULL,
  `RecievedBy` varchar(255) DEFAULT NULL,
  `RBPositionOffice` varchar(255) DEFAULT NULL,
  `RB` datetime DEFAULT NULL,
  `IssuedBy` varchar(255) DEFAULT NULL,
  `IBPositionOffice` varchar(255) DEFAULT NULL,
  `IB` datetime DEFAULT NULL,
  `AllTotalAmount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parr_tb`
--

INSERT INTO `parr_tb` (`PARRID`, `EntityName`, `FundCluster`, `PARRNo`, `RecievedBy`, `RBPositionOffice`, `RB`, `IssuedBy`, `IBPositionOffice`, `IB`, `AllTotalAmount`) VALUES
(23, 'NEMSU-Cantilan Campus', '05-206441', '24-07-016', 'Engr. Jordan Y. Arpilleda', 'Maint.', '2024-08-08 10:48:04', 'Ernesto L. Gonzales', 'AOI/Supply Officer', '2024-08-08 10:48:04', '225000.00');

-- --------------------------------------------------------

--
-- Table structure for table `property_tb`
--

CREATE TABLE `property_tb` (
  `PROPERTYID` int(11) NOT NULL,
  `PropertyNo` varchar(50) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Unit` varchar(50) DEFAULT NULL,
  `DateAcquired` datetime DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `TotalAmount` decimal(10,2) DEFAULT NULL,
  `PARRNo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `property_tb`
--

INSERT INTO `property_tb` (`PROPERTYID`, `PropertyNo`, `Description`, `Quantity`, `Unit`, `DateAcquired`, `Amount`, `TotalAmount`, `PARRNo`) VALUES
(19, '24-07-016', 'Transforrmer, Single Phase, Pole Type, 75KVA', 1, 'Unit', '2024-08-08 10:48:04', '225000.00', '225000.00', '24-07-016');

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
(2, 'admin@gmail.com', 'admin', 'Administrator', 'c4ca4238a0b923820dcc509a6f75849b', 'Admin', '2024-12-09 17:11:54', '2024-12-18 16:40:11', 'Active'),
(3, 'jaybe@gmail.com', 'jaybe123', 'Jaybe Siano', '7d88985a5821fa01ca0c544e875fb56b', 'Staff', '2025-01-08 09:56:10', NULL, 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `icsr_tb`
--
ALTER TABLE `icsr_tb`
  ADD PRIMARY KEY (`ICSID`),
  ADD UNIQUE KEY `ICSNo` (`ICSNo`);

--
-- Indexes for table `item_tb`
--
ALTER TABLE `item_tb`
  ADD PRIMARY KEY (`ITEMID`),
  ADD KEY `ICSNo` (`ICSNo`);

--
-- Indexes for table `parr_tb`
--
ALTER TABLE `parr_tb`
  ADD PRIMARY KEY (`PARRID`),
  ADD UNIQUE KEY `PARRNo` (`PARRNo`);

--
-- Indexes for table `property_tb`
--
ALTER TABLE `property_tb`
  ADD PRIMARY KEY (`PROPERTYID`),
  ADD KEY `PARRNo` (`PARRNo`);

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
-- AUTO_INCREMENT for table `icsr_tb`
--
ALTER TABLE `icsr_tb`
  MODIFY `ICSID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `item_tb`
--
ALTER TABLE `item_tb`
  MODIFY `ITEMID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `parr_tb`
--
ALTER TABLE `parr_tb`
  MODIFY `PARRID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `property_tb`
--
ALTER TABLE `property_tb`
  MODIFY `PROPERTYID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item_tb`
--
ALTER TABLE `item_tb`
  ADD CONSTRAINT `item_tb_ibfk_1` FOREIGN KEY (`ICSNo`) REFERENCES `icsr_tb` (`ICSNo`);

--
-- Constraints for table `property_tb`
--
ALTER TABLE `property_tb`
  ADD CONSTRAINT `property_tb_ibfk_1` FOREIGN KEY (`PARRNo`) REFERENCES `parr_tb` (`PARRNo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
