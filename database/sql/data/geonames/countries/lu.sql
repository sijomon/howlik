-- MySQL dump 10.13  Distrib 5.5.42, for osx10.6 (i386)
--
-- Host: localhost    Database: laraclassified
-- ------------------------------------------------------
-- Server version	5.5.42

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
-- Dumping data for table `subadmin1`
--

/*!40000 ALTER TABLE `subadmin1` DISABLE KEYS */;
INSERT INTO `subadmin1` VALUES (1726,'LU.01','Diekirch','Diekirch',1);
INSERT INTO `subadmin1` VALUES (1727,'LU.02','Grevenmacher','Grevenmacher',1);
INSERT INTO `subadmin1` VALUES (1728,'LU.03','Luxembourg','Luxembourg',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (18776,'LU.01.06','Canton de Clervaux','Canton de Clervaux',1);
INSERT INTO `subadmin2` VALUES (18777,'LU.01.07','Canton de Diekirch','Canton de Diekirch',1);
INSERT INTO `subadmin2` VALUES (18778,'LU.01.08','Canton de Redange','Canton de Redange',1);
INSERT INTO `subadmin2` VALUES (18779,'LU.01.09','Canton de Wiltz','Canton de Wiltz',1);
INSERT INTO `subadmin2` VALUES (18780,'LU.01.10','Canton de Vianden','Canton de Vianden',1);
INSERT INTO `subadmin2` VALUES (18781,'LU.02.11','Canton d\'Echternach','Canton d\'Echternach',1);
INSERT INTO `subadmin2` VALUES (18782,'LU.02.12','Canton de Grevenmacher','Canton de Grevenmacher',1);
INSERT INTO `subadmin2` VALUES (18783,'LU.02.13','Canton de Remich','Canton de Remich',1);
INSERT INTO `subadmin2` VALUES (18784,'LU.03.02','Canton de Capellen','Canton de Capellen',1);
INSERT INTO `subadmin2` VALUES (18785,'LU.03.03','Canton d\'Esch-sur-Alzette','Canton d\'Esch-sur-Alzette',1);
INSERT INTO `subadmin2` VALUES (18786,'LU.03.04','Canton de Luxembourg','Canton de Luxembourg',1);
INSERT INTO `subadmin2` VALUES (18787,'LU.03.05','Canton de Mersch','Canton de Mersch',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (2960054,'LU','Strassen','Strassen',6.07333,49.6206,'P','PPLA3','03','04',6006,'Europe/Luxembourg',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960102,'LU','Schifflange','Schifflange',6.01278,49.5064,'P','PPLA3','03','03',8155,'Europe/Luxembourg',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960187,'LU','Pétange','Petange',5.88056,49.5583,'P','PPLA3','03','03',7187,'Europe/Luxembourg',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960299,'LU','Mamer','Mamer',6.02333,49.6275,'P','PPLA3','03','02',5017,'Europe/Luxembourg',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960316,'LU','Luxembourg','Luxembourg',6.13,49.6117,'P','PPLC','03','04',76684,'Europe/Luxembourg',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960515,'LU','Grevenmacher','Grevenmacher',6.44194,49.6747,'P','PPLA','02','12',3958,'Europe/Luxembourg',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960589,'LU','Ettelbruck','Ettelbruck',6.10417,49.8475,'P','PPLA3','01','07',6364,'Europe/Luxembourg',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960596,'LU','Esch-sur-Alzette','Esch-sur-Alzette',5.98056,49.4958,'P','PPLA2','03','03',28228,'Europe/Luxembourg',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960634,'LU','Dudelange','Dudelange',6.0875,49.4806,'P','PPLA3','03','03',18013,'Europe/Luxembourg',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960651,'LU','Differdange','Differdange',5.89139,49.5242,'P','PPLA3','03','03',5296,'Europe/Luxembourg',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960657,'LU','Diekirch','Diekirch',6.15583,49.8678,'P','PPLA','01','07',6242,'Europe/Luxembourg',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960777,'LU','Bettembourg','Bettembourg',6.10278,49.5186,'P','PPLA3','03','03',7437,'Europe/Luxembourg',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960782,'LU','Bertrange','Bertrange',6.05,49.6111,'P','PPLA3','03','04',5615,'Europe/Luxembourg',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960800,'LU','Belvaux','Belvaux',5.92944,49.5128,'P','PPL','03','',5313,'Europe/Luxembourg',1,NULL,NULL);
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
