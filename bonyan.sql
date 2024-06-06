-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2024 at 11:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bonyan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contractor`
--

CREATE TABLE `contractor` (
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `specialty` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `experienceYears` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Region` varchar(255) NOT NULL,
  `City` varchar(255) NOT NULL,
  `Job` varchar(255) NOT NULL,
  `Services` varchar(255) NOT NULL,
  `Phone_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contractor`
--

INSERT INTO `contractor` (`first_name`, `last_name`, `specialty`, `rating`, `experienceYears`, `username`, `password`, `Region`, `City`, `Job`, `Services`, `Phone_number`) VALUES
('Contractor1_FirstName', 'Contractor1_LastName', 'Specialty1', 4, 5, 'contractor1', 'contractorpassword', 'Region1', 'City1', 'Job1', 'Service1', '1234567890'),
('Contractor2_FirstName', 'Contractor2_LastName', 'Specialty2', 3, 7, 'contractor2', 'contractorpassword', 'Region2', 'City2', 'Job2', 'Service2', '9876543210');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`first_name`, `last_name`, `email`, `username`, `phone_number`, `password`) VALUES
('Customer1_FirstName', 'Customer1_LastName', 'customer1@example.com', 'customer1', '123456789', 'customerpassword'),
('Customer2_FirstName', 'Customer2_LastName', 'customer2@example.com', 'customer2', '987654321', 'customerpassword');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `amount` float DEFAULT NULL,
  `paymentDate` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `projectName` varchar(255) NOT NULL,
  `customerName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `amount`, `paymentDate`, `status`, `projectName`, `customerName`) VALUES
(1, 1000, '2024-04-01', 'Paid', 'Project1', 'Customer1_FirstName'),
(2, 1500, '2024-04-02', 'Pending', 'Project2', 'Customer2_FirstName');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `budget` float DEFAULT NULL,
  `admin_username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`name`, `description`, `startDate`, `endDate`, `budget`, `admin_username`) VALUES
('Project1', 'Description1', '2024-04-01', '2024-05-01', 2000, 'admin123'),
('Project2', 'Description2', '2024-04-02', '2024-06-01', 3000, 'admin456'),
('بنيؤمء', 'برلؤ', NULL, NULL, NULL, ''),
('لابي', 'لارؤ', NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `tender`
--

CREATE TABLE `tender` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `openingDate` date DEFAULT NULL,
  `closingDate` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `projectName` varchar(255) NOT NULL,
  `contractorName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tender`
--

INSERT INTO `tender` (`id`, `description`, `openingDate`, `closingDate`, `status`, `projectName`, `contractorName`) VALUES
(1, 'Tender1 Description', '2024-04-01', '2024-04-10', 'Open', 'Project1', 'Contractor1_FirstName'),
(2, 'Tender2 Description', '2024-04-02', '2024-04-12', 'Closed', 'Project2', 'Contractor2_FirstName');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','contractor','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin123', 'adminpassword', 'admin'),
(2, 'admin456', 'adminpassword', 'admin'),
(3, 'customer1', 'customerpassword', 'customer'),
(4, 'customer2', 'customerpassword', 'customer'),
(5, 'contractor1', 'contractorpassword', 'contractor'),
(6, 'contractor2', 'contractorpassword', 'contractor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contractor`
--
ALTER TABLE `contractor`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `tender`
--
ALTER TABLE `tender`
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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
