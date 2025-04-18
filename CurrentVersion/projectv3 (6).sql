-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 06:28 AM
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
  `Cname` varchar(255) NOT NULL UNIQUE,
  `Cmobile` decimal(10,0) DEFAULT NULL,
  `Address_line1` varchar(255) DEFAULT NULL,
  `District` varchar(255) DEFAULT NULL,
  `Pincode` decimal(6,0) DEFAULT NULL,
  `State` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL UNIQUE,
  `Pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Cid`, `Cname`, `Cmobile`, `Address_line1`, `District`, `Pincode`, `State`, `Email`, `Pass`) VALUES
('C068', 'Customer2', 0, 'vv', 'joi', NULL, 'rdr', 'ak04_02@outlook.com', 'customer123'),
('C102', 'Customer13', 1111111111, 'rgr', 'ff', 0, 'rdr', 'ak04_02@outlook.com', 'customer123'),
('C103', 'Customer1', 1111111111, 'vvv', 'ff', NULL, 'rdr', 'ak04_02@outlook.com', '$2y$10$hpzzW/0hzLcHq0AnPZfZaOoszw8JKDUwBN.f7Aes0PpRQlHhb.Dfu'),
('C67f417f27fdae', 'AKyy', 1111111111, 'vv', 'joi', 453536, 'rdr', 'ak04_02@outlook.com', '$2y$10$hpzzW/0hzLcHq0AnPZfZaOoszw8JKDUwBN.f7Aes0PpRQlHhb.Dfu');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_requests`
--

CREATE TABLE `delivery_requests` (
  `Rid` varchar(255) NOT NULL,
  `Cid` varchar(255) NOT NULL,
  `Pid` varchar(255) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `DeliveryAddress` text NOT NULL,
  `DeliveryDate` date NOT NULL,
  `Timing` time NOT NULL,
  `SpecialInstructions` text DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_requests`
--

INSERT INTO `delivery_requests` (`Rid`, `Cid`, `Pid`, `Quantity`, `DeliveryAddress`, `DeliveryDate`, `Timing`, `SpecialInstructions`, `Status`) VALUES
('R67f4108979647', 'C102', 'P101', 4, '21,sukan,bunglows', '2025-04-08', '12:00:00', 'none', 'Cancelled'),
('R67f411281a903', 'C102', 'P101', 4, '21,sukan,bunglows', '2025-04-08', '12:00:00', 'none', 'Delivered'),
('R67f41199501bf', 'C102', 'P101', 4, '21,sukan,bunglows', '2025-04-08', '12:00:00', 'none', 'Pending'),
('R67f411bc02862', 'C102', 'P101', 3, 'sds', '3333-03-31', '12:00:00', 'fff', 'Pending'),
('R67f4129083e34', 'C102', 'P101', 1, 'bh', '0076-06-07', '15:00:00', 'kk', 'Pending'),
('R67f414dc7e15d', 'C102', 'P101', 2, 'ggg', '2025-04-07', '12:00:00', 'jjj', 'Pending'),
('R67f41641050f9', 'C102', 'P101', 37, 'nn', '2025-04-07', '09:00:00', 'hh', 'Delivered'),
('R67f41dc7bb949', 'C102', 'P102', 1, 'ddd', '2025-04-08', '09:00:00', '', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `forgot_pass`
--

CREATE TABLE `forgot_pass` (
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forgot_pass`
--

INSERT INTO `forgot_pass` (`email`) VALUES
('ak04_02@outlook.com'),
('ak04_02@outlook.com'),
('ak04_02@outlook.com');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `Vid` varchar(255) NOT NULL,
  `Pname` varchar(255) NOT NULL,
  `StockLevel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `link_product_to_shop`
--

CREATE TABLE `link_product_to_shop` (
  `Pid` varchar(255) NOT NULL,
  `Sid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `link_product_to_shop`
--

INSERT INTO `link_product_to_shop` (`Pid`, `Sid`) VALUES
('P101', 'S101'),
('P102', 'S101'),
('P103', 'S101');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `email` text NOT NULL,
  `otp` int(6) NOT NULL,
  `generated_at` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Dumping data for table `product`
--

INSERT INTO `product` (`Pid`, `Pname`, `specifications`, `Price`, `images`) VALUES
('P101', 'Product1', 'specifications_of_product1', 100.00, './images/buns.jpg'),
('P102', 'Product2', 'specifications_of_product2', 200.00, './images/coconut.jpg'),
('P103', 'Product3', 'specifications_of_product3', 300.00, './images/screw.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `product_views`
--

CREATE TABLE `product_views` (
  `id` int(11) NOT NULL,
  `Pid` varchar(255) NOT NULL,
  `view_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_views`
--

INSERT INTO `product_views` (`id`, `Pid`, `view_date`) VALUES
(1, 'P101', '2025-04-07'),
(2, 'P101', '2025-04-07'),
(3, 'P101', '2025-04-07'),
(4, 'P101', '2025-04-07'),
(5, 'P101', '2025-04-07'),
(6, 'P101', '2025-04-07'),
(7, 'P101', '2025-04-07'),
(8, 'P101', '2025-04-07'),
(9, 'P101', '2025-04-07'),
(10, 'P101', '2025-04-07'),
(11, 'P101', '2025-04-07'),
(12, 'P101', '2025-04-07'),
(13, 'P101', '2025-04-07'),
(14, 'P103', '2025-04-08'),
(15, 'P103', '2025-04-08'),
(16, 'P101', '2025-04-08'),
(17, 'P102', '2025-04-08'),
(18, 'P102', '2025-04-08'),
(19, 'P102', '2025-04-08'),
(20, 'P101', '2025-04-13'),
(21, 'P101', '2025-04-13'),
(22, 'P101', '2025-04-13'),
(23, 'P102', '2025-04-13'),
(24, 'P102', '2025-04-14'),
(25, 'P102', '2025-04-14'),
(26, 'P102', '2025-04-14'),
(27, 'P102', '2025-04-14'),
(28, 'P102', '2025-04-14'),
(29, 'P102', '2025-04-14'),
(30, 'P102', '2025-04-14'),
(31, 'P102', '2025-04-14'),
(32, 'P102', '2025-04-14'),
(33, 'P102', '2025-04-14');

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
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`Sid`, `Vid`, `Sname`, `Address_line1`, `District`, `Pincode`, `State`) VALUES
('S101', 'V101', 'Shop2', '123,shopname,xyz_road', 'Anand', 388125, 'Gujarat');

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
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`Vid`, `Vname`, `Vmobile`, `Address_line1`, `District`, `Pincode`, `State`, `Email`, `Pass`) VALUES
('V101', 'vendor1', 9427858557, '123,shopname,xyz_road', 'district1', 388125, 'Gujarat', 'vendor1@gmail.com', 'vendor123'),
('V67f41868a2cff', 'AKyy', 1111111111, 'vv', 'joi', 453536, 'rdrrr', 'ak04_02@outlook.com', 'customer123');

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
  ADD PRIMARY KEY (`Rid`);

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
-- Indexes for table `product_views`
--
ALTER TABLE `product_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Pid` (`Pid`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product_views`
--
ALTER TABLE `product_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `link_product_to_shop`
--
ALTER TABLE `link_product_to_shop`
  ADD CONSTRAINT `fk_link_product_to_shop_product` FOREIGN KEY (`Pid`) REFERENCES `product` (`Pid`),
  ADD CONSTRAINT `fk_link_product_to_shop_shop` FOREIGN KEY (`Sid`) REFERENCES `shop` (`Sid`);

--
-- Constraints for table `product_views`
--
ALTER TABLE `product_views`
  ADD CONSTRAINT `product_views_ibfk_1` FOREIGN KEY (`Pid`) REFERENCES `product` (`Pid`);

--
-- Constraints for table `shop`
--
ALTER TABLE `shop`
  ADD CONSTRAINT `fk_shop_vendor` FOREIGN KEY (`Vid`) REFERENCES `vendor` (`Vid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
