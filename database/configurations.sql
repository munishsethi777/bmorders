-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 25, 2019 at 12:32 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 5.6.37

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

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`configkey`, `configvalue`, `seq`) VALUES
('email', 'baljeetgaheer@gmail.com', 1),
('mobile', '9814600356', 2),
('smtpusername', 'noreply@myhealthsolutionz.com', 3),
('smtppassword', '!NMaoHY6ZsO%', 4),
('smtphost', 'mail.myhealthsolutionz.com', 5);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
