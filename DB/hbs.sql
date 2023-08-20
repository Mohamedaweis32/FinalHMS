-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2023 at 03:45 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hbs`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `CompanyID` int(11) primary key AUTO_INCREMENT,
  `CompanyName` varchar(250) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Phone` varchar(30) NOT NULL,
  `Email` varchar(20) NOT NULL,
  `Logo` varchar(5000) NOT NULL,
  `Description` text NOT NULL,
  `Status` varchar(20) NOT NULL,
  `ActionDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
);
--
-- Dumping data for table `company`
--

INSERT INTO `company` (`CompanyID`, `CompanyName`, `Address`, `Phone`, `Email`, `Logo`, `Description`, `Status`, `ActionDate`) VALUES
(1, 'Java Coffea', 'Taleex Road', '78', 'hello@java.com', 'WhatsApp Image 2023-06-24 at 8.04.08 PM (1).jpeg', 'Welcome to Java', '', '2023-07-01 13:40:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`CompanyID`),
  ADD KEY `CompanyID` (`CompanyID`),
  ADD KEY `CompanyID_2` (`CompanyID`),
  ADD KEY `CompanyID_3` (`CompanyID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `CompanyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
