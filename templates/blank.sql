-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 03, 2020 at 09:20 PM
-- Server version: 5.7.26
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finance`
--
CREATE DATABASE IF NOT EXISTS `finance` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `finance`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `Account` varchar(50) NOT NULL,
  `accounttype` varchar(50) NOT NULL,
  `Balance` float NOT NULL DEFAULT '0',
  `Date` date NOT NULL DEFAULT '2000-01-01',
  `Description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Account`),
  KEY `Type` (`accounttype`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `accounttypes`
--

DROP TABLE IF EXISTS `accounttypes`;
CREATE TABLE IF NOT EXISTS `accounttypes` (
  `accounttype` varchar(50) NOT NULL,
  `Description` varchar(100) NOT NULL,
  PRIMARY KEY (`accounttype`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
CREATE TABLE IF NOT EXISTS `currency` (
  `currency1` varchar(20) NOT NULL,
  `currency2` varchar(20) DEFAULT NULL,
  `ROE` float DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`currency1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `expenseaccountview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `expenseaccountview`;
CREATE TABLE IF NOT EXISTS `expenseaccountview` (
`Account` varchar(50)
,`total` double
,`month` varchar(7)
);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE IF NOT EXISTS `expenses` (
  `Expense` varchar(50) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Expense`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `expenseview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `expenseview`;
CREATE TABLE IF NOT EXISTS `expenseview` (
`Expense` varchar(50)
,`total` double
,`month` varchar(7)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `fromaccountview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `fromaccountview`;
CREATE TABLE IF NOT EXISTS `fromaccountview` (
`FromAccount` varchar(50)
,`total` double
,`month` varchar(7)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `incomeaccountview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `incomeaccountview`;
CREATE TABLE IF NOT EXISTS `incomeaccountview` (
`Account` varchar(50)
,`total` double
,`month` varchar(7)
);

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

DROP TABLE IF EXISTS `incomes`;
CREATE TABLE IF NOT EXISTS `incomes` (
  `Income` varchar(50) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Income`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `incomeview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `incomeview`;
CREATE TABLE IF NOT EXISTS `incomeview` (
`Income` varchar(50)
,`total` double
,`month` varchar(7)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `intoaccountview`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `intoaccountview`;
CREATE TABLE IF NOT EXISTS `intoaccountview` (
`IntoAccount` varchar(50)
,`total` double
,`month` varchar(7)
);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actionTaken` varchar(100) NOT NULL,
  `dbTable` varchar(100) NOT NULL,
  `timeStamp` datetime NOT NULL,
  `fullEntry` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

DROP TABLE IF EXISTS `transfers`;
CREATE TABLE IF NOT EXISTS `transfers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Date` date NOT NULL,
  `Amount` float NOT NULL,
  `IntoAccount` varchar(50) NOT NULL,
  `FromAccount` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `IntoAccount` (`IntoAccount`),
  KEY `FromAccount` (`FromAccount`)
) ENGINE=InnoDB AUTO_INCREMENT=1030 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `txexpense`
--

DROP TABLE IF EXISTS `txexpense`;
CREATE TABLE IF NOT EXISTS `txexpense` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Date` date NOT NULL,
  `Amount` float NOT NULL,
  `Expense` varchar(50) NOT NULL,
  `Account` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Account` (`Account`),
  KEY `Expense` (`Expense`)
) ENGINE=InnoDB AUTO_INCREMENT=6129 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `txincome`
--

DROP TABLE IF EXISTS `txincome`;
CREATE TABLE IF NOT EXISTS `txincome` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Date` date NOT NULL,
  `Amount` float NOT NULL,
  `Account` varchar(50) NOT NULL,
  `Income` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Account` (`Account`),
  KEY `Income` (`Income`)
) ENGINE=InnoDB AUTO_INCREMENT=635 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `expenseaccountview`
--
DROP TABLE IF EXISTS `expenseaccountview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `expenseaccountview`  AS  select `txexpense`.`Account` AS `Account`,sum(`txexpense`.`Amount`) AS `total`,substr(`txexpense`.`Date`,1,7) AS `month` from `txexpense` where 1 group by `txexpense`.`Account`,substr(`txexpense`.`Date`,1,7) ;

-- --------------------------------------------------------

--
-- Structure for view `expenseview`
--
DROP TABLE IF EXISTS `expenseview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `expenseview`  AS  select `txexpense`.`Expense` AS `Expense`,sum(`txexpense`.`Amount`) AS `total`,substr(`txexpense`.`Date`,1,7) AS `month` from `txexpense` where 1 group by `txexpense`.`Expense`,substr(`txexpense`.`Date`,1,7) ;

-- --------------------------------------------------------

--
-- Structure for view `fromaccountview`
--
DROP TABLE IF EXISTS `fromaccountview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `fromaccountview`  AS  select `transfers`.`FromAccount` AS `FromAccount`,sum(`transfers`.`Amount`) AS `total`,substr(`transfers`.`Date`,1,7) AS `month` from `transfers` where 1 group by `transfers`.`FromAccount`,substr(`transfers`.`Date`,1,7) ;

-- --------------------------------------------------------

--
-- Structure for view `incomeaccountview`
--
DROP TABLE IF EXISTS `incomeaccountview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `incomeaccountview`  AS  select `txincome`.`Account` AS `Account`,sum(`txincome`.`Amount`) AS `total`,substr(`txincome`.`Date`,1,7) AS `month` from `txincome` where 1 group by `txincome`.`Account`,substr(`txincome`.`Date`,1,7) ;

-- --------------------------------------------------------

--
-- Structure for view `incomeview`
--
DROP TABLE IF EXISTS `incomeview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `incomeview`  AS  select `txincome`.`Income` AS `Income`,sum(`txincome`.`Amount`) AS `total`,substr(`txincome`.`Date`,1,7) AS `month` from `txincome` where 1 group by `txincome`.`Income`,substr(`txincome`.`Date`,1,7) ;

-- --------------------------------------------------------

--
-- Structure for view `intoaccountview`
--
DROP TABLE IF EXISTS `intoaccountview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `intoaccountview`  AS  select `transfers`.`IntoAccount` AS `IntoAccount`,sum(`transfers`.`Amount`) AS `total`,substr(`transfers`.`Date`,1,7) AS `month` from `transfers` where 1 group by `transfers`.`IntoAccount`,substr(`transfers`.`Date`,1,7) ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`accounttype`) REFERENCES `accounttypes` (`accounttype`);

--
-- Constraints for table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_ibfk_1` FOREIGN KEY (`IntoAccount`) REFERENCES `accounts` (`Account`),
  ADD CONSTRAINT `transfers_ibfk_2` FOREIGN KEY (`FromAccount`) REFERENCES `accounts` (`Account`);

--
-- Constraints for table `txexpense`
--
ALTER TABLE `txexpense`
  ADD CONSTRAINT `txexpense_ibfk_2` FOREIGN KEY (`Account`) REFERENCES `accounts` (`Account`),
  ADD CONSTRAINT `txexpense_ibfk_3` FOREIGN KEY (`Expense`) REFERENCES `expenses` (`Expense`);

--
-- Constraints for table `txincome`
--
ALTER TABLE `txincome`
  ADD CONSTRAINT `txincome_ibfk_2` FOREIGN KEY (`Account`) REFERENCES `accounts` (`Account`),
  ADD CONSTRAINT `txincome_ibfk_3` FOREIGN KEY (`Income`) REFERENCES `incomes` (`Income`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
