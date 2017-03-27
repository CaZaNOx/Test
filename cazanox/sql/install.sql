CREATE DATABASE  IF NOT EXISTS `fleXtime` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `fleXtime`;
-- MySQL dump 10.13  Distrib 5.6.19, for osx10.7 (i386)
--
-- Host: localhost    Database: fleXtime
-- ------------------------------------------------------
-- Server version   5.6.20
 
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
-- Table structure for table `Absences`
--
 
DROP TABLE IF EXISTS `Absences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Absences` (
  `idAbsences` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idEmployee` int(11) unsigned NOT NULL,
  `type` varchar(45) NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `status` enum('Approved','Pending','Declined') NOT NULL DEFAULT 'Pending',
  `creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` mediumtext,
  PRIMARY KEY (`idAbsences`),
  KEY `FK_idEmployee_Absences_idx` (`idEmployee`),
  CONSTRAINT `FK_idEmployee_Absences` FOREIGN KEY (`idEmployee`) REFERENCES `Employee` (`idEmployee`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`127.0.0.1`*/ /*!50003 TRIGGER `fleXtime`.`Absences_BEFORE_INSERT`
BEFORE INSERT ON `Absences`
FOR EACH ROW
BEGIN
  IF (NEW.end < NEW.begin) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'End date before begin date!';
  END IF;
  IF EXISTS(SELECT * FROM Absences WHERE idEmployee = NEW.idEmployee AND (NEW.begin <= end AND NEW.end >= begin)) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Overlapping intervals!';
  END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`127.0.0.1`*/ /*!50003 TRIGGER `fleXtime`.`Absences_BEFORE_UPDATE`
BEFORE UPDATE ON `Absences`
FOR EACH ROW
BEGIN
  IF OLD.status = 'Approved' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Absence already approved.';
  END IF;
  IF (NEW.end < NEW.begin) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'End date before begin date!';
  END IF;
    IF EXISTS(SELECT * FROM Absences WHERE idEmployee = NEW.idEmployee AND NEW.idAbsences <> idAbsences AND (NEW.begin <= end AND NEW.end >= begin)) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Overlapping intervals!';
  END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
 
--
-- Table structure for table `Calendar`
--
 
DROP TABLE IF EXISTS `Calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Calendar` (
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
 
--
-- Table structure for table `Department`
--
 
DROP TABLE IF EXISTS `Department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Department` (
  `idDepartment` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`idDepartment`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
 
--
-- Table structure for table `Employee`
--
 
DROP TABLE IF EXISTS `Employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Employee` (
  `idEmployee` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idDepartment` int(11) unsigned DEFAULT NULL,
  `firstname` varchar(45) NOT NULL DEFAULT '',
  `lastname` varchar(45) NOT NULL DEFAULT '',
  `username` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) NOT NULL DEFAULT '',
  `accessLevel` int(11) DEFAULT '1',
  `status` enum('Active','Disabled','Deleted') NOT NULL DEFAULT 'Disabled',
  `userCreation` datetime DEFAULT CURRENT_TIMESTAMP,
  `lastLogin` datetime DEFAULT NULL,
  `numOfPeriods` tinyint(2) NOT NULL DEFAULT '2',
  `showNotes` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `showMessages` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  PRIMARY KEY (`idEmployee`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `FK_idDepartment_Employee_idx` (`idDepartment`),
  CONSTRAINT `FK_idDepartment_Employee` FOREIGN KEY (`idDepartment`) REFERENCES `Department` (`idDepartment`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
 
--
-- Insert Admin
--
 
LOCK TABLES `Employee` WRITE;
/*!40000 ALTER TABLE `Employee` DISABLE KEYS */;
INSERT INTO `Employee` VALUES (1,1,'John','Doe','admin',NULL,'admin',1000,'Active',NULL, NULL,2,'Yes','Yes');
/*!40000 ALTER TABLE `Employee` ENABLE KEYS */;
UNLOCK TABLES;
 
 
--
-- Table structure for table `EmploymentLevel`
--
 
DROP TABLE IF EXISTS `EmploymentLevel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EmploymentLevel` (
  `idEmploymentLevel` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idEmployee` int(10) unsigned NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  `level` varchar(45) NOT NULL DEFAULT '0',
  `monday` time DEFAULT '00:00:00',
  `tuesday` time DEFAULT '00:00:00',
  `wednesday` time DEFAULT '00:00:00',
  `thursday` time DEFAULT '00:00:00',
  `friday` time DEFAULT '00:00:00',
  `saturday` time DEFAULT '00:00:00',
  PRIMARY KEY (`idEmploymentLevel`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`127.0.0.1`*/ /*!50003 TRIGGER `fleXtime`.`EmploymentLevel_BEFORE_INSERT`
BEFORE INSERT ON `EmploymentLevel`
FOR EACH ROW
BEGIN
  IF (NEW.end < NEW.begin) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'End date before begin date!';
  END IF;
  IF EXISTS(SELECT * FROM EmploymentLevel WHERE idEmployee = NEW.idEmployee AND (NEW.begin <= end AND NEW.end >= begin)) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Overlapping intervals!';
  END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`127.0.0.1`*/ /*!50003 TRIGGER `fleXtime`.`EmploymentLevel_BEFORE_UPDATE`
BEFORE UPDATE ON `EmploymentLevel`
FOR EACH ROW
BEGIN
  IF (NEW.end < NEW.begin) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'End date before begin date!';
  END IF;
  IF EXISTS(SELECT * FROM EmploymentLevel WHERE idEmployee = NEW.idEmployee AND NEW.idEmploymentLevel <> idEmploymentLevel AND (NEW.begin <= end AND NEW.end >= begin)) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Overlapping intervals!';
  END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
 
--
-- Table structure for table `Holiday`
--
 
DROP TABLE IF EXISTS `Holiday`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Holiday` (
  `idHoliday` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`idHoliday`),
  UNIQUE KEY `date_UNIQUE` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
 
--
-- Table structure for table `Notes`
--
 
DROP TABLE IF EXISTS `Notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Notes` (
  `idNotes` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idEmployee` int(11) unsigned NOT NULL,
  `date` date NOT NULL,
  `note` mediumtext NOT NULL,
  `creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idNotes`),
  KEY `FK_idEmployee_Notes_idx` (`idEmployee`),
  CONSTRAINT `FK_idEmployee_Notes` FOREIGN KEY (`idEmployee`) REFERENCES `Employee` (`idEmployee`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
 
--
-- Table structure for table `WorkingHours`
--
 
DROP TABLE IF EXISTS `WorkingHours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `WorkingHours` (
  `idWorkingHours` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `idEmployee` int(11) unsigned NOT NULL,
  `begin` datetime NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`idWorkingHours`),
  KEY `FK_idEmployee_WorkingHours_idx` (`idEmployee`),
  CONSTRAINT `FK_idEmployee_WorkingHours` FOREIGN KEY (`idEmployee`) REFERENCES `Employee` (`idEmployee`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`127.0.0.1`*/ /*!50003 TRIGGER `fleXtime`.`WorkingHours_BEFORE_INSERT`
BEFORE INSERT ON `WorkingHours`
FOR EACH ROW
BEGIN
  IF (NEW.end < NEW.begin) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'End time before begin time!';
  END IF;
  IF EXISTS(SELECT * FROM WorkingHours WHERE idEmployee = NEW.idEmployee AND (NEW.begin <= end AND NEW.end >= begin)) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Overlapping intervals!';
  END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`127.0.0.1`*/ /*!50003 TRIGGER `fleXtime`.`WorkingHours_BEFORE_UPDATE`
BEFORE UPDATE ON `WorkingHours`
FOR EACH ROW
BEGIN
  IF (NEW.end < NEW.begin) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'End date before begin date!';
  END IF;
    IF EXISTS(SELECT * FROM WorkingHours WHERE idEmployee = NEW.idEmployee AND (NEW.begin <= end AND NEW.end >= begin)) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Overlapping intervals!';
  END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
 
--
-- Dumping routines for database 'fleXtime'
--
/*!50003 DROP FUNCTION IF EXISTS `GET_ABSENCE` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` FUNCTION `GET_ABSENCE`(date DATE, id INT(11)) RETURNS varchar(45) CHARSET utf8
BEGIN
    DECLARE absence VARCHAR(45);
    SET absence = (SELECT type FROM Absences WHERE date BETWEEN begin AND end AND idEmployee = id AND status='Approved' AND GET_SCHEDULE(date, id) IS NOT NULL);
RETURN absence;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `GET_SCHEDULE` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` FUNCTION `GET_SCHEDULE`(date DATE, id INT) RETURNS time
BEGIN
    DECLARE hours TIME;
    DECLARE weekday INT;
    SET weekday = (SELECT WEEKDAY(date));
    CASE weekday
    WHEN 0 THEN SET hours = (SELECT monday FROM EmploymentLevel WHERE idEmployee = id AND date BETWEEN begin AND end);
    WHEN 1 THEN SET hours = (SELECT tuesday FROM EmploymentLevel WHERE idEmployee = id AND date BETWEEN begin AND end);
    WHEN 2 THEN SET hours = (SELECT wednesday FROM EmploymentLevel WHERE idEmployee = id AND date BETWEEN begin AND end);
    WHEN 3 THEN SET hours = (SELECT thursday FROM EmploymentLevel WHERE idEmployee = id AND date BETWEEN begin AND end);
    WHEN 4 THEN SET hours = (SELECT friday FROM EmploymentLevel WHERE idEmployee = id AND date BETWEEN begin AND end);
    WHEN 5 THEN SET hours = NULL;
    WHEN 6 THEN SET hours = NULL;
    END CASE;
RETURN hours;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `NUM_OF_WEEKDAYS` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` FUNCTION `NUM_OF_WEEKDAYS`(begin DATE, end DATE) RETURNS int(11)
BEGIN
    DECLARE days INT;
    SET days =(SELECT COUNT(*) FROM Calendar WHERE date BETWEEN begin AND end AND WEEKDAY(date) < 5);
    RETURN days;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `TIMEDIFF` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` FUNCTION `TIMEDIFF`(time1 TIME, time2 TIME) RETURNS time
BEGIN
    DECLARE diff TIME;
    SET diff = SEC_TO_TIME(SUM(TIME_TO_SEC(time1)-TIME_TO_SEC(time2)));
RETURN diff;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `fill_calendar` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`127.0.0.1` PROCEDURE `fill_calendar`(start_date DATE, end_date DATE)
BEGIN
  DECLARE crt_date DATE;
  SET crt_date=start_date;
  WHILE crt_date < end_date DO
    INSERT INTO Calendar VALUES(crt_date);
    SET crt_date = ADDDATE(crt_date, INTERVAL 1 DAY);
  END WHILE;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
 
CALL fill_calendar('2010-01-01', '2020-12-31');
 
-- Dump completed on 2015-01-22 17:48:01

