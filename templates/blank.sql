-- MySQL dump 10.13  Distrib 5.7.26, for Win64 (x86_64)
--
-- Host: localhost    Database: finance
-- ------------------------------------------------------
-- Server version	5.7.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `finance`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `finance` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `finance`;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `Account` varchar(50) NOT NULL,
  `accounttype` varchar(50) NOT NULL,
  `Balance` float NOT NULL DEFAULT '0',
  `Date` date NOT NULL DEFAULT '2000-01-01',
  `Description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Account`),
  KEY `Type` (`accounttype`),
  CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`accounttype`) REFERENCES `accounttypes` (`accounttype`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `accounttypes`
--

DROP TABLE IF EXISTS `accounttypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounttypes` (
  `accounttype` varchar(50) NOT NULL,
  `Description` varchar(100) NOT NULL,
  PRIMARY KEY (`accounttype`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounttypes`
--

LOCK TABLES `accounttypes` WRITE;
/*!40000 ALTER TABLE `accounttypes` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounttypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currency`
--

DROP TABLE IF EXISTS `currency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `currency` (
  `currency1` varchar(20) NOT NULL,
  `currency2` varchar(20) DEFAULT NULL,
  `ROE` float DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`currency1`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currency`
--

LOCK TABLES `currency` WRITE;
/*!40000 ALTER TABLE `currency` DISABLE KEYS */;
/*!40000 ALTER TABLE `currency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `expenseaccountview`
--

DROP TABLE IF EXISTS `expenseaccountview`;
/*!50001 DROP VIEW IF EXISTS `expenseaccountview`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `expenseaccountview` AS SELECT 
 1 AS `Account`,
 1 AS `total`,
 1 AS `month`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expenses` (
  `Expense` varchar(50) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Expense`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `expenseview`
--

DROP TABLE IF EXISTS `expenseview`;
/*!50001 DROP VIEW IF EXISTS `expenseview`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `expenseview` AS SELECT 
 1 AS `Expense`,
 1 AS `total`,
 1 AS `month`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `fromaccountview`
--

DROP TABLE IF EXISTS `fromaccountview`;
/*!50001 DROP VIEW IF EXISTS `fromaccountview`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `fromaccountview` AS SELECT 
 1 AS `FromAccount`,
 1 AS `total`,
 1 AS `month`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `graphelement`
--

DROP TABLE IF EXISTS `graphelement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `graphelement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `graphname` varchar(50) NOT NULL,
  `viewtable` varchar(30) NOT NULL,
  `FieldHeader` varchar(50) NOT NULL,
  `FieldString` varchar(50) NOT NULL,
  `operation` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `graphelement_ibfk_1` (`graphname`),
  CONSTRAINT `graphelement_ibfk_1` FOREIGN KEY (`graphname`) REFERENCES `graphs` (`graphName`)
) ENGINE=InnoDB AUTO_INCREMENT=509 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `graphelement`
--

LOCK TABLES `graphelement` WRITE;
/*!40000 ALTER TABLE `graphelement` DISABLE KEYS */;
/*!40000 ALTER TABLE `graphelement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `graphs`
--

DROP TABLE IF EXISTS `graphs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `graphs` (
  `graphName` varchar(50) NOT NULL,
  `graphDescription` varchar(100) NOT NULL,
  `AutoShow` tinyint(1) NOT NULL,
  `AccountsGraph` tinyint(1) NOT NULL,
  PRIMARY KEY (`graphName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `graphs`
--

LOCK TABLES `graphs` WRITE;
/*!40000 ALTER TABLE `graphs` DISABLE KEYS */;
/*!40000 ALTER TABLE `graphs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `incomeaccountview`
--

DROP TABLE IF EXISTS `incomeaccountview`;
/*!50001 DROP VIEW IF EXISTS `incomeaccountview`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `incomeaccountview` AS SELECT 
 1 AS `Account`,
 1 AS `total`,
 1 AS `month`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `incomes`
--

DROP TABLE IF EXISTS `incomes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incomes` (
  `Income` varchar(50) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Income`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incomes`
--

LOCK TABLES `incomes` WRITE;
/*!40000 ALTER TABLE `incomes` DISABLE KEYS */;
/*!40000 ALTER TABLE `incomes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `incomeview`
--

DROP TABLE IF EXISTS `incomeview`;
/*!50001 DROP VIEW IF EXISTS `incomeview`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `incomeview` AS SELECT 
 1 AS `Income`,
 1 AS `total`,
 1 AS `month`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `intoaccountview`
--

DROP TABLE IF EXISTS `intoaccountview`;
/*!50001 DROP VIEW IF EXISTS `intoaccountview`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `intoaccountview` AS SELECT 
 1 AS `IntoAccount`,
 1 AS `total`,
 1 AS `month`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `mylogs`
--

DROP TABLE IF EXISTS `mylogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mylogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actionTaken` varchar(100) NOT NULL,
  `dbTable` varchar(100) NOT NULL,
  `timeStamp` datetime NOT NULL,
  `fullEntry` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1357 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mylogs`
--

LOCK TABLES `mylogs` WRITE;
/*!40000 ALTER TABLE `mylogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `mylogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preauthorised`
--

DROP TABLE IF EXISTS `preauthorised`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preauthorised` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Account` varchar(50) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `MinAmount` float NOT NULL,
  `MaxAmount` float NOT NULL,
  `Category` varchar(50) NOT NULL,
  `verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Account` (`Account`),
  CONSTRAINT `preauthorised_ibfk_1` FOREIGN KEY (`Account`) REFERENCES `accounts` (`Account`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preauthorised`
--

LOCK TABLES `preauthorised` WRITE;
/*!40000 ALTER TABLE `preauthorised` DISABLE KEYS */;
/*!40000 ALTER TABLE `preauthorised` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `session` (
  `IPAddress` varchar(100) NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`IPAddress`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transfers`
--

DROP TABLE IF EXISTS `transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transfers` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Date` date NOT NULL,
  `Amount` float NOT NULL,
  `IntoAccount` varchar(50) NOT NULL,
  `FromAccount` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `IntoAccount` (`IntoAccount`),
  KEY `FromAccount` (`FromAccount`),
  CONSTRAINT `transfers_ibfk_1` FOREIGN KEY (`IntoAccount`) REFERENCES `accounts` (`Account`),
  CONSTRAINT `transfers_ibfk_2` FOREIGN KEY (`FromAccount`) REFERENCES `accounts` (`Account`)
) ENGINE=InnoDB AUTO_INCREMENT=1030 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfers`
--

LOCK TABLES `transfers` WRITE;
/*!40000 ALTER TABLE `transfers` DISABLE KEYS */;
/*!40000 ALTER TABLE `transfers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `txexpense`
--

DROP TABLE IF EXISTS `txexpense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `txexpense` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Date` date NOT NULL,
  `Amount` float NOT NULL,
  `Expense` varchar(50) NOT NULL,
  `Account` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Account` (`Account`),
  KEY `Expense` (`Expense`),
  CONSTRAINT `txexpense_ibfk_2` FOREIGN KEY (`Account`) REFERENCES `accounts` (`Account`),
  CONSTRAINT `txexpense_ibfk_3` FOREIGN KEY (`Expense`) REFERENCES `expenses` (`Expense`)
) ENGINE=InnoDB AUTO_INCREMENT=6130 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `txexpense`
--

LOCK TABLES `txexpense` WRITE;
/*!40000 ALTER TABLE `txexpense` DISABLE KEYS */;
/*!40000 ALTER TABLE `txexpense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `txincome`
--

DROP TABLE IF EXISTS `txincome`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `txincome` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(100) NOT NULL,
  `Date` date NOT NULL,
  `Amount` float NOT NULL,
  `Account` varchar(50) NOT NULL,
  `Income` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Account` (`Account`),
  KEY `Income` (`Income`),
  CONSTRAINT `txincome_ibfk_2` FOREIGN KEY (`Account`) REFERENCES `accounts` (`Account`),
  CONSTRAINT `txincome_ibfk_3` FOREIGN KEY (`Income`) REFERENCES `incomes` (`Income`)
) ENGINE=InnoDB AUTO_INCREMENT=634 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `txincome`
--

LOCK TABLES `txincome` WRITE;
/*!40000 ALTER TABLE `txincome` DISABLE KEYS */;
/*!40000 ALTER TABLE `txincome` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Current Database: `finance`
--

USE `finance`;

--
-- Final view structure for view `expenseaccountview`
--

/*!50001 DROP VIEW IF EXISTS `expenseaccountview`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `expenseaccountview` AS select `txexpense`.`Account` AS `Account`,sum(`txexpense`.`Amount`) AS `total`,substr(`txexpense`.`Date`,1,7) AS `month` from `txexpense` where 1 group by `txexpense`.`Account`,substr(`txexpense`.`Date`,1,7) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `expenseview`
--

/*!50001 DROP VIEW IF EXISTS `expenseview`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `expenseview` AS select `txexpense`.`Expense` AS `Expense`,sum(`txexpense`.`Amount`) AS `total`,substr(`txexpense`.`Date`,1,7) AS `month` from `txexpense` where 1 group by `txexpense`.`Expense`,substr(`txexpense`.`Date`,1,7) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `fromaccountview`
--

/*!50001 DROP VIEW IF EXISTS `fromaccountview`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `fromaccountview` AS select `transfers`.`FromAccount` AS `FromAccount`,sum(`transfers`.`Amount`) AS `total`,substr(`transfers`.`Date`,1,7) AS `month` from `transfers` where 1 group by `transfers`.`FromAccount`,substr(`transfers`.`Date`,1,7) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `incomeaccountview`
--

/*!50001 DROP VIEW IF EXISTS `incomeaccountview`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `incomeaccountview` AS select `txincome`.`Account` AS `Account`,sum(`txincome`.`Amount`) AS `total`,substr(`txincome`.`Date`,1,7) AS `month` from `txincome` where 1 group by `txincome`.`Account`,substr(`txincome`.`Date`,1,7) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `incomeview`
--

/*!50001 DROP VIEW IF EXISTS `incomeview`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `incomeview` AS select `txincome`.`Income` AS `Income`,sum(`txincome`.`Amount`) AS `total`,substr(`txincome`.`Date`,1,7) AS `month` from `txincome` where 1 group by `txincome`.`Income`,substr(`txincome`.`Date`,1,7) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `intoaccountview`
--

/*!50001 DROP VIEW IF EXISTS `intoaccountview`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `intoaccountview` AS select `transfers`.`IntoAccount` AS `IntoAccount`,sum(`transfers`.`Amount`) AS `total`,substr(`transfers`.`Date`,1,7) AS `month` from `transfers` where 1 group by `transfers`.`IntoAccount`,substr(`transfers`.`Date`,1,7) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-29 17:35:23
