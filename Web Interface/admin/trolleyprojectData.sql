-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2022 at 09:21 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trolleyproject`
--

--
-- Dumping data for table `all_bills`
--

INSERT INTO `all_bills` (`Sl_No`, `Customer`, `Bill_Date`, `Product_ID`, `Product_Name`, `Cost`, `Quantity`, `Amount`) VALUES
(6, 919449414199, '2022-04-19', 8902519310828, 'book', 40, 4, 160),
(8, 919449414199, '2022-04-19', 8906128540713, 'Charger Cable', 100, 6, 600),
(30, 919449414199, '2022-04-19', 8908002207569, 'Tissue', 60, 4, 240),
(32, 9880156393, '2022-04-20', 4549526605895, 'Calculator', 1295, 2, 2590),
(41, 9880156393, '2022-04-21', 8908002207569, 'Tissue', 60, 27, 1620),
(42, 919449414199, '2022-04-21', 8901326115121, 'Jockey', 449, 1, 449),
(44, 9880156393, '2022-04-22', 8901326115121, 'Jockey', 449, 1, 449),
(45, 9880156393, '2022-04-22', 8908002207569, 'Tissue', 60, 2, 120),
(47, 9449414199, '2022-04-22', 8902519310828, 'book', 40, 3, 120);

--
-- Dumping data for table `all_products`
--

INSERT INTO `all_products` (`Product_ID`, `Product_Name`, `Quantity_Available`, `Cost`, `Sl_No`) VALUES
('4549526605895', 'Calculator', 20, 1295, 1),
('89002207569', '', 0, 0, 2),
('8901326115121', 'Jockey', 30, 449, 3),
('8902519310828', 'book', 100, 40, 4),
('8906058350185', 'ApGel', 45, 174, 5),
('8906128540713', 'Charger Cable', 65, 100, 6),
('8908002207569', 'Tissue', 21, 60, 7);

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`Contact_Number`, `Customer_Name`, `Email`, `Password`, `Sl_No`) VALUES
(9449414199, 'Srivasta ', '', 'abC', 1),
(9480531460, 'fasg', 'adsdfg@gmail.com', 'abc', 2),
(9880156393, 'Product_Name', 'srivatsarupadhya@gmail.com', 'abc', 3),
(919449414199, 'Srivatsa R Upadhya', 'srivatsarupadhya@gmail.com', 'abc', 4);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
