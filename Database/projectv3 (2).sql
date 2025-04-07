-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2025 at 12:02 PM
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
-- Database: `projectv3`
--
CREATE DATABASE IF NOT EXISTS `projectv3` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `projectv3`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_staff_login`
--

CREATE TABLE `admin_staff_login` (
  `Aid` varchar(255) NOT NULL,
  `Aname` varchar(255) NOT NULL,
  `AEmail` varchar(255) NOT NULL,
  `Apass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `admin_staff_login`
--

TRUNCATE TABLE `admin_staff_login`;
--
-- Dumping data for table `admin_staff_login`
--

INSERT INTO `admin_staff_login` (`Aid`, `Aname`, `AEmail`, `Apass`) VALUES
('A101', 'Admin', 'admin@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `contact_message`
--

CREATE TABLE `contact_message` (
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `contact_message`
--

TRUNCATE TABLE `contact_message`;
--
-- Dumping data for table `contact_message`
--

INSERT INTO `contact_message` (`Name`, `Email`, `Message`) VALUES
('ak', 'ak04_02@gmail.com', 'ddddddddddddddddddddddddddddddd'),
('AK', 'ak04_02@outlook.com', 'dddddddddddddddddddddddd'),
('AK', 'ak04_02@outlook.com', 'helloooooooooo');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Cid` varchar(255) NOT NULL,
  `Cname` varchar(255) NOT NULL,
  `Cmobile` decimal(10,0) DEFAULT NULL,
  `Address_line1` varchar(255) DEFAULT NULL,
  `District` varchar(255) DEFAULT NULL,
  `Pincode` decimal(6,0) DEFAULT NULL,
  `State` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `customer`
--

TRUNCATE TABLE `customer`;
--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Cid`, `Cname`, `Cmobile`, `Address_line1`, `District`, `Pincode`, `State`, `Email`, `Pass`) VALUES
('C101', 'Customer1', 8238213284, '234,yzw_road', 'District2', 388128, 'Gujarat', 'c1@gmail.com', 'customer123');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_requests`
--

CREATE TABLE `delivery_requests` (
  `Rid` varchar(255) NOT NULL,
  `Cid` varchar(255) NOT NULL,
  `Pid` varchar(255) NOT NULL,
  `Timing` time NOT NULL,
  `Status` varchar(255) DEFAULT NULL,
  `DeliveredAt` datetime DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `delivery_requests`
--

TRUNCATE TABLE `delivery_requests`;
-- --------------------------------------------------------

--
-- Table structure for table `link_product_to_shop`
--

CREATE TABLE `link_product_to_shop` (
  `Pid` varchar(255) NOT NULL,
  `Sid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `link_product_to_shop`
--

TRUNCATE TABLE `link_product_to_shop`;
--
-- Dumping data for table `link_product_to_shop`
--

INSERT INTO `link_product_to_shop` (`Pid`, `Sid`) VALUES
('P101', 'S101'),
('P102', 'S101'),
('P103', 'S101');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Pid` varchar(255) NOT NULL,
  `Pname` varchar(255) NOT NULL,
  `specifications` varchar(255) DEFAULT NULL,
  `Price` decimal(8,2) DEFAULT NULL,
  `images` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `product`
--

TRUNCATE TABLE `product`;
--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Pid`, `Pname`, `specifications`, `Price`, `images`) VALUES
('P101', 'Product1', 'specifications_of_product1', 100.00, './images/buns.jpg'),
('P102', 'Product2', 'specifications_of_product2', 200.00, './images/coconut.jpg'),
('P103', 'Product3', 'specifications_of_product3', 300.00, './images/screw.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `Sid` varchar(255) NOT NULL,
  `Vid` varchar(255) NOT NULL,
  `Sname` varchar(255) NOT NULL,
  `Address_line1` varchar(255) DEFAULT NULL,
  `District` varchar(255) DEFAULT NULL,
  `Pincode` decimal(6,0) DEFAULT NULL,
  `State` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `shop`
--

TRUNCATE TABLE `shop`;
--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`Sid`, `Vid`, `Sname`, `Address_line1`, `District`, `Pincode`, `State`) VALUES
('S101', 'V101', 'Shop1', '123,shopname,xyz_road', 'District1', 388125, 'Gujarat');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `Vid` varchar(255) NOT NULL,
  `Vname` varchar(255) NOT NULL,
  `Vmobile` decimal(10,0) DEFAULT NULL,
  `Address_line1` varchar(255) DEFAULT NULL,
  `District` varchar(255) DEFAULT NULL,
  `Pincode` decimal(6,0) DEFAULT NULL,
  `State` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncate table before insert `vendor`
--

TRUNCATE TABLE `vendor`;
--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`Vid`, `Vname`, `Vmobile`, `Address_line1`, `District`, `Pincode`, `State`, `Email`, `Pass`) VALUES
('V101', 'vendor1', 9427858557, '123,shopname,xyz_road', 'district1', 388125, 'Gujarat', 'vendor1@gmail.com', 'vendor123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_staff_login`
--
ALTER TABLE `admin_staff_login`
  ADD PRIMARY KEY (`Aid`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Cid`);

--
-- Indexes for table `delivery_requests`
--
ALTER TABLE `delivery_requests`
  ADD PRIMARY KEY (`Rid`),
  ADD KEY `fk_delivery_requests_customer` (`Cid`),
  ADD KEY `fk_delivery_requests_product` (`Pid`);

--
-- Indexes for table `link_product_to_shop`
--
ALTER TABLE `link_product_to_shop`
  ADD PRIMARY KEY (`Pid`,`Sid`),
  ADD KEY `fk_link_product_to_shop_shop` (`Sid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Pid`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`Sid`),
  ADD KEY `fk_shop_vendor` (`Vid`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`Vid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery_requests`
--
ALTER TABLE `delivery_requests`
  ADD CONSTRAINT `fk_delivery_requests_customer` FOREIGN KEY (`Cid`) REFERENCES `customer` (`Cid`),
  ADD CONSTRAINT `fk_delivery_requests_product` FOREIGN KEY (`Pid`) REFERENCES `product` (`Pid`);

--
-- Constraints for table `link_product_to_shop`
--
ALTER TABLE `link_product_to_shop`
  ADD CONSTRAINT `fk_link_product_to_shop_product` FOREIGN KEY (`Pid`) REFERENCES `product` (`Pid`),
  ADD CONSTRAINT `fk_link_product_to_shop_shop` FOREIGN KEY (`Sid`) REFERENCES `shop` (`Sid`);

--
-- Constraints for table `shop`
--
ALTER TABLE `shop`
  ADD CONSTRAINT `fk_shop_vendor` FOREIGN KEY (`Vid`) REFERENCES `vendor` (`Vid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
