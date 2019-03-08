-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 08, 2019 at 04:32 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bmorders`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `seq` bigint(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `contactperson` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address1` varchar(100) NOT NULL,
  `address2` varchar(100) NOT NULL,
  `city` varchar(25) NOT NULL,
  `state` varchar(25) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `discount` decimal(10,0) NOT NULL,
  `userseq` bigint(20) NOT NULL,
  `createdon` datetime NOT NULL,
  `lastmodifiedon` datetime NOT NULL,
  `isenabled` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`seq`, `title`, `description`, `contactperson`, `email`, `mobile`, `phone`, `address1`, `address2`, `city`, `state`, `zip`, `discount`, `userseq`, `createdon`, `lastmodifiedon`, `isenabled`) VALUES
(8, 'Learntech Inc.21111', 'no description', 'Amandeep Dubey', 'amandeepdubey@gmail.com', '9128191211', '011928192182', 'Azad Appartments, Near new Flyover', 'Sector 56', 'Gurugram', 'Haryana', '1208392', '0', 1, '2019-03-07 10:15:27', '2019-03-07 11:51:31', 1),
(10, 'Learntech Inc12', 'no description', 'Amandeep Dubey', 'amandeepdubey@gmail.com', '9128191211', '011928192182', 'Azad Appartments, Near new Flyover', 'Sector 56', 'Gurugram', 'Haryana', '1208392', '0', 1, '2019-03-07 10:15:27', '2019-03-07 15:04:41', 1),
(12, 'Learntech Inc.6', 'no description', 'Amandeep Dubey', 'amandeepdubey@gmail.com', '9128191211', '011928192182', 'Azad Appartments, Near new Flyover', 'Sector 56', 'Gurugram', 'Haryana', '1208392', '0', 1, '2019-03-07 10:15:27', '2019-03-07 11:27:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `expenselogs`
--

CREATE TABLE `expenselogs` (
  `seq` bigint(20) NOT NULL,
  `userseq` bigint(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `createdon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `seq` bigint(20) NOT NULL,
  `notificationtype` varchar(25) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `userseq` bigint(20) NOT NULL,
  `isviewed` tinyint(4) NOT NULL,
  `createdon` datetime NOT NULL,
  `isemailsent` tinyint(4) NOT NULL,
  `issmssent` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orderpaymentdetails`
--

CREATE TABLE `orderpaymentdetails` (
  `seq` bigint(20) NOT NULL,
  `orderseq` bigint(20) NOT NULL,
  `paymentmode` varchar(25) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `details` varchar(100) NOT NULL,
  `isconfirmed` tinyint(4) NOT NULL,
  `ispaid` tinyint(4) NOT NULL,
  `createdon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orderproductdetails`
--

CREATE TABLE `orderproductdetails` (
  `seq` bigint(20) NOT NULL,
  `orderseq` bigint(20) NOT NULL,
  `productseq` bigint(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `seq` bigint(20) NOT NULL,
  `customerseq` bigint(20) NOT NULL,
  `comments` varchar(250) NOT NULL,
  `discountpercent` decimal(10,0) NOT NULL,
  `totalamount` decimal(10,0) NOT NULL,
  `ispaymentcompletelypaid` tinyint(4) NOT NULL,
  `createdon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `productbrands`
--

CREATE TABLE `productbrands` (
  `seq` bigint(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `userseq` bigint(20) NOT NULL,
  `createdon` datetime NOT NULL,
  `lastmodifiedon` datetime NOT NULL,
  `isenabled` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productbrands`
--

INSERT INTO `productbrands` (`seq`, `title`, `description`, `userseq`, `createdon`, `lastmodifiedon`, `isenabled`) VALUES
(1, 'Muscle Technology', '', 1, '2019-03-07 14:59:27', '2019-03-07 15:01:34', 1),
(2, 'MVP Biotech', '', 1, '2019-03-07 15:01:45', '2019-03-07 15:01:45', 1),
(3, 'MuscleTech', '', 1, '2019-03-07 15:01:56', '2019-03-07 15:01:56', 1),
(4, 'Ultimate Nutrition', '', 1, '2019-03-07 15:02:05', '2019-03-07 15:06:34', 1),
(8, 'BSN', '', 1, '2019-03-07 15:06:14', '2019-03-07 15:06:14', 1),
(9, 'Superior 14', '', 1, '2019-03-07 15:06:23', '2019-03-07 15:06:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `productcategories`
--

CREATE TABLE `productcategories` (
  `seq` bigint(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `userseq` bigint(20) NOT NULL,
  `createdon` datetime NOT NULL,
  `lastmodifiedon` datetime NOT NULL,
  `isenabled` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productcategories`
--

INSERT INTO `productcategories` (`seq`, `title`, `description`, `userseq`, `createdon`, `lastmodifiedon`, `isenabled`) VALUES
(1, 'Fat Burner Capsules', 'All Fat Burner capsules here', 1, '2019-03-07 15:55:02', '2019-03-07 15:57:34', 1),
(3, 'Whey Protein Concentrate', '', 1, '2019-03-07 15:58:33', '2019-03-07 15:58:33', 1),
(4, 'Whey protein isolate', '', 1, '2019-03-07 15:58:39', '2019-03-07 15:59:33', 1),
(5, 'Mega Mass', '', 1, '2019-03-07 15:58:43', '2019-03-07 15:59:29', 1),
(6, 'Glutamine Capsules', '', 1, '2019-03-07 15:58:51', '2019-03-07 15:59:25', 1),
(7, 'Weight Gainers', '', 1, '2019-03-07 15:59:01', '2019-03-07 15:59:21', 1),
(8, 'Steroids Capsules', '', 1, '2019-03-07 15:59:09', '2019-03-07 15:59:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `productflavours`
--

CREATE TABLE `productflavours` (
  `seq` bigint(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `userseq` bigint(20) NOT NULL,
  `createdon` datetime NOT NULL,
  `lastmodifiedon` datetime NOT NULL,
  `isenabled` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productflavours`
--

INSERT INTO `productflavours` (`seq`, `title`, `description`, `userseq`, `createdon`, `lastmodifiedon`, `isenabled`) VALUES
(1, 'Vanilla Plain', '', 1, '2019-03-07 16:10:25', '2019-03-07 16:10:25', 1),
(2, 'Strawberry', '', 1, '2019-03-07 16:15:47', '2019-03-07 16:15:47', 1),
(3, 'Banana & Strawberry', '', 1, '2019-03-07 16:15:55', '2019-03-07 16:16:18', 1),
(4, 'Chocolate', '', 1, '2019-03-07 16:16:00', '2019-03-07 16:16:13', 1),
(5, 'Choco Latte', '', 1, '2019-03-07 16:16:04', '2019-03-07 16:16:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `seq` bigint(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `measuringunit` varchar(20) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `categoryseq` bigint(20) NOT NULL,
  `flavourseq` bigint(20) NOT NULL,
  `brandseq` bigint(20) NOT NULL,
  `userseq` bigint(20) NOT NULL,
  `imageformat` varchar(10) DEFAULT NULL,
  `createdon` datetime NOT NULL,
  `lastmodifiedon` datetime NOT NULL,
  `isenabled` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`seq`, `title`, `description`, `measuringunit`, `stock`, `price`, `quantity`, `categoryseq`, `flavourseq`, `brandseq`, `userseq`, `imageformat`, `createdon`, `lastmodifiedon`, `isenabled`) VALUES
(8, '2', '12', 'pounds', 11, 11, 11, 7, 1, 3, 1, 'png', '2019-03-08 14:28:30', '2019-03-08 14:28:30', 1),
(9, '2', '12', 'pounds', 11, 11, 11, 7, 1, 3, 1, 'png', '2019-03-08 14:28:38', '2019-03-08 14:28:38', 1),
(10, '2', '12', 'pounds', 11, 11, 11, 7, 1, 3, 1, 'png', '2019-03-08 14:30:25', '2019-03-08 15:20:53', 1),
(11, 'qq', 'q', 'pounds', 11, 11, 1, 1, 3, 8, 1, 'png', '2019-03-08 14:34:20', '2019-03-08 14:34:20', 1),
(12, 'qq', 'q', 'pounds', 11, 11, 1, 1, 3, 8, 1, 'png', '2019-03-08 14:34:36', '2019-03-08 14:34:37', 1),
(13, 'qq', 'q', 'pounds', 11, 11, 1, 1, 3, 8, 1, 'png', '2019-03-08 14:35:17', '2019-03-08 14:35:18', 1),
(14, 'qq', 'q', 'pounds', 11, 11, 1, 1, 3, 8, 1, 'png', '2019-03-08 14:38:29', '2019-03-08 14:38:29', 1),
(15, 'qq', 'q', 'pounds', 11, 11, 1, 1, 3, 8, 1, 'png', '2019-03-08 14:39:18', '2019-03-08 14:39:18', 1),
(16, 'qq', 'q', 'pounds', 11, 11, 1, 1, 3, 8, 1, 'png', '2019-03-08 14:40:02', '2019-03-08 14:40:02', 1),
(17, 'qq', 'q', 'pounds', 11, 11, 1, 1, 3, 8, 1, 'png', '2019-03-08 14:42:19', '2019-03-08 14:42:19', 1),
(18, 'qq', 'q', 'pounds', 11, 11, 1, 1, 3, 8, 1, 'png', '2019-03-08 14:42:51', '2019-03-08 14:42:51', 1),
(19, 'qq', 'q', 'kilograms', 11, 11, 1, 1, 3, 8, 1, NULL, '2019-03-08 14:44:47', '2019-03-08 16:29:10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `seq` bigint(20) NOT NULL,
  `emailid` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `mobile` varchar(20) NOT NULL,
  `usertype` varchar(25) NOT NULL,
  `createdon` datetime NOT NULL,
  `lastmodifiedon` datetime NOT NULL,
  `isenabled` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`seq`, `emailid`, `password`, `fullname`, `mobile`, `usertype`, `createdon`, `lastmodifiedon`, `isenabled`) VALUES
(1, 'munishsethi777@gmail.com', 'a', 'Munish Sethi', '9814600356', 'superadmin', '2019-03-06 00:00:00', '2019-03-06 00:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`seq`),
  ADD KEY `AddedByUser` (`userseq`);

--
-- Indexes for table `expenselogs`
--
ALTER TABLE `expenselogs`
  ADD PRIMARY KEY (`seq`),
  ADD KEY `User` (`userseq`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`seq`);

--
-- Indexes for table `orderpaymentdetails`
--
ALTER TABLE `orderpaymentdetails`
  ADD PRIMARY KEY (`seq`);

--
-- Indexes for table `orderproductdetails`
--
ALTER TABLE `orderproductdetails`
  ADD PRIMARY KEY (`seq`),
  ADD KEY `OrderProduct` (`productseq`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`seq`),
  ADD KEY `CustomerOrder` (`customerseq`);

--
-- Indexes for table `productbrands`
--
ALTER TABLE `productbrands`
  ADD PRIMARY KEY (`seq`);

--
-- Indexes for table `productcategories`
--
ALTER TABLE `productcategories`
  ADD PRIMARY KEY (`seq`);

--
-- Indexes for table `productflavours`
--
ALTER TABLE `productflavours`
  ADD PRIMARY KEY (`seq`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`seq`),
  ADD KEY `ProductBrand` (`brandseq`),
  ADD KEY `ProductCategory` (`categoryseq`),
  ADD KEY `ProductFlavour` (`flavourseq`),
  ADD KEY `ProductUser` (`userseq`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`seq`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `seq` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `expenselogs`
--
ALTER TABLE `expenselogs`
  MODIFY `seq` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `seq` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderpaymentdetails`
--
ALTER TABLE `orderpaymentdetails`
  MODIFY `seq` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderproductdetails`
--
ALTER TABLE `orderproductdetails`
  MODIFY `seq` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `seq` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productbrands`
--
ALTER TABLE `productbrands`
  MODIFY `seq` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `productcategories`
--
ALTER TABLE `productcategories`
  MODIFY `seq` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `productflavours`
--
ALTER TABLE `productflavours`
  MODIFY `seq` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `seq` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `seq` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `AddedByUser` FOREIGN KEY (`userseq`) REFERENCES `users` (`seq`) ON UPDATE NO ACTION;

--
-- Constraints for table `expenselogs`
--
ALTER TABLE `expenselogs`
  ADD CONSTRAINT `User` FOREIGN KEY (`userseq`) REFERENCES `users` (`seq`) ON UPDATE NO ACTION;

--
-- Constraints for table `orderproductdetails`
--
ALTER TABLE `orderproductdetails`
  ADD CONSTRAINT `OrderProduct` FOREIGN KEY (`productseq`) REFERENCES `products` (`seq`) ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `CustomerOrder` FOREIGN KEY (`customerseq`) REFERENCES `customers` (`seq`) ON UPDATE NO ACTION;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `ProductBrand` FOREIGN KEY (`brandseq`) REFERENCES `productbrands` (`seq`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductCategory` FOREIGN KEY (`categoryseq`) REFERENCES `productcategories` (`seq`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductFlavour` FOREIGN KEY (`flavourseq`) REFERENCES `productflavours` (`seq`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductUser` FOREIGN KEY (`userseq`) REFERENCES `users` (`seq`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
