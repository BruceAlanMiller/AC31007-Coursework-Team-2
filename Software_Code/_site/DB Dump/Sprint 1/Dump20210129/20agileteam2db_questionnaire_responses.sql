-- MySQL dump 10.13  Distrib 8.0.23, for Win64 (x86_64)
--
-- Host: silva.computing.dundee.ac.uk    Database: 20agileteam2db
-- ------------------------------------------------------
-- Server version	5.6.20-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `questionnaire_responses`
--

DROP TABLE IF EXISTS `questionnaire_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questionnaire_responses` (
  `Response_ID` int(10) NOT NULL AUTO_INCREMENT,
  `Question_ID` int(10) NOT NULL,
  `Question_Option_ID` int(10) DEFAULT NULL,
  `Participant_ID` int(10) NOT NULL,
  `Response` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`Response_ID`),
  UNIQUE KEY `Response_ID_UNIQUE` (`Response_ID`),
  KEY `Question_ID` (`Question_ID`),
  KEY `questionnaire_responses_ibfk_2` (`Question_Option_ID`),
  KEY `questionnaire_responses_ibfk_3` (`Participant_ID`),
  CONSTRAINT `questionnaire_responses_ibfk_1` FOREIGN KEY (`Question_ID`) REFERENCES `questionnaire_questions` (`Question_ID`),
  CONSTRAINT `questionnaire_responses_ibfk_2` FOREIGN KEY (`Question_Option_ID`) REFERENCES `questionnaire_questions_options` (`Question_Option_ID`),
  CONSTRAINT `questionnaire_responses_ibfk_3` FOREIGN KEY (`Participant_ID`) REFERENCES `participant` (`Participant_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaire_responses`
--

LOCK TABLES `questionnaire_responses` WRITE;
/*!40000 ALTER TABLE `questionnaire_responses` DISABLE KEYS */;
INSERT INTO `questionnaire_responses` VALUES (7,1,NULL,2,'34'),(8,2,NULL,2,'Male'),(9,3,47,2,NULL),(10,4,49,2,NULL),(11,5,54,2,NULL),(12,6,NULL,2,''),(13,10,14,2,NULL),(14,10,12,2,NULL),(15,11,62,2,NULL),(16,12,66,2,NULL),(17,13,28,2,NULL),(18,14,32,2,NULL),(19,15,71,2,NULL),(20,16,44,2,NULL),(21,17,73,2,NULL),(22,18,82,2,NULL),(23,19,85,2,NULL),(24,20,NULL,2,'qwerqw'),(25,21,87,2,NULL),(26,22,NULL,2,'Xzvcxzv'),(27,23,89,2,NULL),(28,24,NULL,2,'iooyoiuiy');
/*!40000 ALTER TABLE `questionnaire_responses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-29 10:13:39
