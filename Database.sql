-- phpMyAdmin SQL Dump
-- version 4.9.7deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 20, 2021 at 12:02 AM
-- Server version: 8.0.23-0ubuntu0.20.10.1
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_demo`
--
CREATE DATABASE IF NOT EXISTS `pluem_db_demo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `pluem_db_demo`;

-- --------------------------------------------------------

--
-- Table structure for table `Cart`
--

CREATE TABLE `Cart` (
  `CartID` int NOT NULL,
  `CustomerID` int DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `Province` varchar(255) DEFAULT NULL,
  `PostCode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Coupon`
--

CREATE TABLE `Coupon` (
  `CouponID` int NOT NULL,
  `Promotion` varchar(255) DEFAULT NULL,
  `ExpireDate` date DEFAULT NULL,
  `ProductID` int DEFAULT NULL,
  `ShopID` int DEFAULT NULL,
  `TypeID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `CouponCode`
--

CREATE TABLE `CouponCode` (
  `CouponCode` int NOT NULL,
  `CouponID` int DEFAULT NULL,
  `GenCode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `CustomerID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Firstname` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Lastname` varchar(120) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `CustTel` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `CustAddress` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `City` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Province` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Postcode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Interest1` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Interest2` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Interest3` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Password` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Delivery`
--

CREATE TABLE `Delivery` (
  `DeliveryID` int NOT NULL,
  `DeliveryName` varchar(255) DEFAULT NULL,
  `ShopID` int DEFAULT NULL,
  `LimitType` varchar(255) DEFAULT NULL,
  `LimitRate` int DEFAULT NULL,
  `PriceRate` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Mailbox`
--

CREATE TABLE `Mailbox` (
  `MailID` int NOT NULL,
  `UserID` int NOT NULL,
  `Text` varchar(255) NOT NULL DEFAULT 'ทดสอบระบบ',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `OrderProduct`
--

CREATE TABLE `OrderProduct` (
  `LogID` int NOT NULL,
  `OrderID` int DEFAULT NULL,
  `ProductID` int DEFAULT NULL,
  `Quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `OrderID` int NOT NULL,
  `CartID` int DEFAULT NULL,
  `OrderPrice` int DEFAULT '0',
  `SpendID` int DEFAULT NULL,
  `CouponID` int DEFAULT NULL,
  `DeliveryID` int DEFAULT NULL,
  `TrackCode` varchar(255) DEFAULT NULL,
  `AcceptDate` int DEFAULT NULL,
  `ShopID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE `Product` (
  `ProductID` int NOT NULL,
  `ProductName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ProductPrice` int NOT NULL,
  `Quantity` int NOT NULL,
  `ShopID` int NOT NULL,
  `Size` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Color` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `TypeID` int NOT NULL,
  `productpicture` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ProductType`
--

CREATE TABLE `ProductType` (
  `TypeID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `TypeName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Request`
--

CREATE TABLE `Request` (
  `RequestID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `CustomerID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `ProductID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Quantity` int NOT NULL DEFAULT '1',
  `Status` int(10) UNSIGNED ZEROFILL NOT NULL DEFAULT '0000000001',
  `ShopAlert` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Shop`
--

CREATE TABLE `Shop` (
  `ShopID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `ShopName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Rate` int(1) UNSIGNED ZEROFILL NOT NULL DEFAULT '3',
  `ShopTel` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ShopType` int(10) UNSIGNED ZEROFILL NOT NULL DEFAULT '0000000001',
  `Balance` int(10) UNSIGNED ZEROFILL NOT NULL DEFAULT '0000000000',
  `BankACC` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Owner` int(10) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `SpendType`
--

CREATE TABLE `SpendType` (
  `SpendID` int NOT NULL,
  `BankCode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Cart`
--
ALTER TABLE `Cart`
  ADD PRIMARY KEY (`CartID`);

--
-- Indexes for table `Coupon`
--
ALTER TABLE `Coupon`
  ADD PRIMARY KEY (`CouponID`);

--
-- Indexes for table `CouponCode`
--
ALTER TABLE `CouponCode`
  ADD PRIMARY KEY (`CouponCode`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`CustomerID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `Delivery`
--
ALTER TABLE `Delivery`
  ADD PRIMARY KEY (`DeliveryID`);

--
-- Indexes for table `Mailbox`
--
ALTER TABLE `Mailbox`
  ADD PRIMARY KEY (`MailID`);

--
-- Indexes for table `OrderProduct`
--
ALTER TABLE `OrderProduct`
  ADD PRIMARY KEY (`LogID`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `ProductType`
--
ALTER TABLE `ProductType`
  ADD PRIMARY KEY (`TypeID`);

--
-- Indexes for table `Request`
--
ALTER TABLE `Request`
  ADD PRIMARY KEY (`RequestID`);

--
-- Indexes for table `Shop`
--
ALTER TABLE `Shop`
  ADD PRIMARY KEY (`ShopID`);

--
-- Indexes for table `SpendType`
--
ALTER TABLE `SpendType`
  ADD PRIMARY KEY (`SpendID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Cart`
--
ALTER TABLE `Cart`
  MODIFY `CartID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Coupon`
--
ALTER TABLE `Coupon`
  MODIFY `CouponID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `CouponCode`
--
ALTER TABLE `CouponCode`
  MODIFY `CouponCode` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `CustomerID` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Delivery`
--
ALTER TABLE `Delivery`
  MODIFY `DeliveryID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Mailbox`
--
ALTER TABLE `Mailbox`
  MODIFY `MailID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `OrderProduct`
--
ALTER TABLE `OrderProduct`
  MODIFY `LogID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `OrderID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Product`
--
ALTER TABLE `Product`
  MODIFY `ProductID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ProductType`
--
ALTER TABLE `ProductType`
  MODIFY `TypeID` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Request`
--
ALTER TABLE `Request`
  MODIFY `RequestID` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Shop`
--
ALTER TABLE `Shop`
  MODIFY `ShopID` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `SpendType`
--
ALTER TABLE `SpendType`
  MODIFY `SpendID` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
