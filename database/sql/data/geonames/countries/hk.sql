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
INSERT INTO `subadmin1` VALUES (1125,'HK.HCW','Central and Western','Central and Western',1);
INSERT INTO `subadmin1` VALUES (1126,'HK.HEA','Eastern','Eastern',1);
INSERT INTO `subadmin1` VALUES (1127,'HK.HSO','Southern','Southern',1);
INSERT INTO `subadmin1` VALUES (1128,'HK.HWC','Wanchai','Wanchai',1);
INSERT INTO `subadmin1` VALUES (1129,'HK.KKC','Kowloon City','Kowloon City',1);
INSERT INTO `subadmin1` VALUES (1130,'HK.KKT','Kwon Tong','Kwon Tong',1);
INSERT INTO `subadmin1` VALUES (1131,'HK.KSS','Sham Shui Po','Sham Shui Po',1);
INSERT INTO `subadmin1` VALUES (1132,'HK.KWT','Wong Tai Sin','Wong Tai Sin',1);
INSERT INTO `subadmin1` VALUES (1133,'HK.KYT','Yau Tsim Mong','Yau Tsim Mong',1);
INSERT INTO `subadmin1` VALUES (1134,'HK.NIS','Islands','Islands',1);
INSERT INTO `subadmin1` VALUES (1135,'HK.NKT','Kwai Tsing','Kwai Tsing',1);
INSERT INTO `subadmin1` VALUES (1136,'HK.NNO','North','North',1);
INSERT INTO `subadmin1` VALUES (1137,'HK.NSK','Sai Kung','Sai Kung',1);
INSERT INTO `subadmin1` VALUES (1138,'HK.NST','Sha Tin','Sha Tin',1);
INSERT INTO `subadmin1` VALUES (1139,'HK.NTM','Tuen Mun','Tuen Mun',1);
INSERT INTO `subadmin1` VALUES (1140,'HK.NTP','Tai Po','Tai Po',1);
INSERT INTO `subadmin1` VALUES (1141,'HK.NTW','Tsuen Wan','Tsuen Wan',1);
INSERT INTO `subadmin1` VALUES (1142,'HK.NYL','Yuen Long','Yuen Long',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1818209,'HK','Tsuen Wan','Tsuen Wan',114.105,22.3707,'P','PPLA','NTW','',288728,'Asia/Hong_Kong',1,NULL,NULL);
INSERT INTO `cities` VALUES (1818211,'HK','Yung Shue Wan','Yung Shue Wan',114.112,22.2262,'P','PPL','00','',6000,'Asia/Hong_Kong',1,NULL,NULL);
INSERT INTO `cities` VALUES (1818223,'HK','Yuen Long Kau Hui','Yuen Long Kau Hui',114.033,22.45,'P','PPLA','NYL','',141900,'Asia/Hong_Kong',1,NULL,NULL);
INSERT INTO `cities` VALUES (1818304,'HK','Wong Tai Sin','Wong Tai Sin',114.183,22.35,'P','PPLA','KWT','',0,'Asia/Hong_Kong',1,NULL,NULL);
INSERT INTO `cities` VALUES (1818379,'HK','Wan Chai','Wan Chai',114.173,22.2814,'P','PPLA','HWC','',0,'Asia/Hong_Kong',1,NULL,NULL);
INSERT INTO `cities` VALUES (1818446,'HK','Tuen Mun','Tuen Mun',113.972,22.3918,'P','PPLA','NTM','',16940,'Asia/Hong_Kong',1,NULL,NULL);
INSERT INTO `cities` VALUES (1818673,'HK','Tai Po','Tai Po',114.169,22.4501,'P','PPLA','NTP','',16302,'Asia/Hong_Kong',1,NULL,NULL);
INSERT INTO `cities` VALUES (1818920,'HK','Sha Tin','Sha Tin',114.183,22.3833,'P','PPLA','NST','',21559,'Asia/Hong_Kong',1,NULL,NULL);
INSERT INTO `cities` VALUES (1818953,'HK','Sham Shui Po','Sham Shui Po',114.159,22.3302,'P','PPLA','KSS','',0,'Asia/Hong_Kong',1,NULL,NULL);
INSERT INTO `cities` VALUES (1819050,'HK','Sai Kung','Sai Kung',114.267,22.3833,'P','PPLA','NSK','',11927,'Asia/Hong_Kong',1,NULL,NULL);
INSERT INTO `cities` VALUES (1819609,'HK','Kowloon','Kowloon',114.183,22.3167,'P','PPLA','KKC','',2019533,'Asia/Hong_Kong',1,NULL,NULL);
INSERT INTO `cities` VALUES (1819729,'HK','Hong Kong','Hong Kong',114.158,22.2855,'P','PPLC','00','',7012738,'Asia/Hong_Kong',1,NULL,NULL);
INSERT INTO `cities` VALUES (8223932,'HK','Central','Central',114.158,22.283,'P','PPLA','HCW','',0,'Asia/Hong_Kong',1,NULL,NULL);
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
