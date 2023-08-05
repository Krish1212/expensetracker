-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 05, 2023 at 10:20 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expense_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `budget_planner`
--

CREATE TABLE `budget_planner` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `month` varchar(50) NOT NULL,
  `year` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `category` int(100) NOT NULL,
  `description` text NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `budget_planner`
--

INSERT INTO `budget_planner` (`id`, `date`, `month`, `year`, `type`, `category`, `description`, `amount`) VALUES
(1, '2023-07-20', 'July', 2023, 'expenses', 1, 'daily house expenses', 6000),
(2, '2023-07-20', 'July', 2023, 'expenses', 4, 'principal + interest', 28222),
(3, '2023-07-20', 'July', 2023, 'expenses', 11, 'GRT monthly payment', 5000),
(4, '2023-07-20', 'July', 2023, 'income', 29, 'july month', 70000),
(5, '2023-07-20', 'July', 2023, 'expenses', 13, 'airtel', 510),
(6, '2023-07-20', 'July', 2023, 'expenses', 20, 'to appa', 4000),
(7, '2023-07-20', 'July', 2023, 'expenses', 20, 'to mridu a/c', 5000),
(8, '2023-07-20', 'July', 2023, 'expenses', 9, 'broadband', 1178),
(9, '2023-07-20', 'July', 2023, 'expenses', 10, '', 181),
(10, '2023-07-22', 'July', 2023, 'income', 35, 'reimbursement', 1178),
(11, '2023-07-22', 'July', 2023, 'income', 38, 'share dividend', 250),
(12, '2023-07-22', 'July', 2023, 'income', 37, 'bank interest', 375),
(13, '2023-07-25', 'July', 2023, 'expenses', 7, '', 3940),
(14, '2023-07-29', 'February', 2021, 'expenses', 1, 'daily house exp', 6000),
(15, '2023-07-29', 'June', 2022, 'expenses', 2, 'gsm', 5500);

-- --------------------------------------------------------

--
-- Table structure for table `category_table`
--

CREATE TABLE `category_table` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_table`
--

INSERT INTO `category_table` (`id`, `type`, `name`) VALUES
(1, 'expenses', 'Household expense'),
(2, 'expenses', 'Groceries'),
(3, 'expenses', 'Vegetables'),
(4, 'expenses', 'Home Loan'),
(5, 'expenses', 'CC - HDFC'),
(6, 'expenses', 'CC - Amex'),
(7, 'expenses', 'EB - home'),
(8, 'expenses', 'EB - common'),
(9, 'expenses', 'Jio landline'),
(10, 'expenses', 'Jio mobile'),
(11, 'expenses', 'Savings - jewel'),
(12, 'expenses', 'Recharge - mobile'),
(13, 'expenses', 'Recharge - DTH'),
(14, 'expenses', 'Recharge - OTT'),
(15, 'expenses', 'Petrol'),
(16, 'expenses', 'LIC Premium'),
(17, 'expenses', 'Travel'),
(18, 'expenses', 'Doctor'),
(19, 'expenses', 'Medicine'),
(20, 'expenses', 'Money Transfer'),
(21, 'expenses', 'ATM Withdraw'),
(29, 'income', 'Salary'),
(35, 'income', 'Broadband'),
(37, 'income', 'Interest'),
(38, 'income', 'Dividend');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `month` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `details` text DEFAULT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `date`, `month`, `year`, `category`, `details`, `amount`) VALUES
(1, '2023-07-31', 'July', 2023, 1, 'daily house exp', 6000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budget_planner`
--
ALTER TABLE `budget_planner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_share` (`category`);

--
-- Indexes for table `category_table`
--
ALTER TABLE `category_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_link` (`category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budget_planner`
--
ALTER TABLE `budget_planner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `category_table`
--
ALTER TABLE `category_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget_planner`
--
ALTER TABLE `budget_planner`
  ADD CONSTRAINT `category_share` FOREIGN KEY (`category`) REFERENCES `category_table` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `category_link` FOREIGN KEY (`category`) REFERENCES `category_table` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
