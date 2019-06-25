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
INSERT INTO `subadmin1` VALUES (424,'BW.01','Central','Central',1);
INSERT INTO `subadmin1` VALUES (425,'BW.03','Ghanzi','Ghanzi',1);
INSERT INTO `subadmin1` VALUES (426,'BW.04','Kgalagadi','Kgalagadi',1);
INSERT INTO `subadmin1` VALUES (427,'BW.05','Kgatleng','Kgatleng',1);
INSERT INTO `subadmin1` VALUES (428,'BW.06','Kweneng','Kweneng',1);
INSERT INTO `subadmin1` VALUES (429,'BW.08','North East','North East',1);
INSERT INTO `subadmin1` VALUES (430,'BW.09','South East','South East',1);
INSERT INTO `subadmin1` VALUES (431,'BW.10','Southern','Southern',1);
INSERT INTO `subadmin1` VALUES (432,'BW.11','North West','North West',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (8232,'BW.01.7670706','Mahalapye','Mahalapye',1);
INSERT INTO `subadmin2` VALUES (8233,'BW.01.7670708','Machaneng','Machaneng',1);
INSERT INTO `subadmin2` VALUES (8234,'BW.01.7670709','Serowe','Serowe',1);
INSERT INTO `subadmin2` VALUES (8235,'BW.01.7670710','Palapye','Palapye',1);
INSERT INTO `subadmin2` VALUES (8236,'BW.05.7670705','Kgatleng','Kgatleng',1);
INSERT INTO `subadmin2` VALUES (8237,'BW.09.7670702','Gaborone','Gaborone',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (932987,'BW','Tshabong','Tshabong',22.45,-26.05,'P','PPLA','04','',6591,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933000,'BW','Tonota','Tonota',27.4615,-21.4424,'P','PPL','01','',17759,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933018,'BW','Thamaga','Thamaga',25.5397,-24.6701,'P','PPL','06','',20756,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933077,'BW','Shakawe','Shakawe',21.8422,-18.3654,'P','PPL','11','',5651,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933088,'BW','Serowe','Serowe',26.7108,-22.3875,'P','PPLA','01','',47419,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933099,'BW','Selebi-Phikwe','Selebi-Phikwe',27.843,-21.979,'P','PPL','01','',53727,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933141,'BW','Ramotswa','Ramotswa',25.8699,-24.8716,'P','PPLA','09','',21450,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933151,'BW','Rakops','Rakops',24.3605,-21.0226,'P','PPL','01','',5222,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933182,'BW','Palapye','Palapye',27.1251,-22.546,'P','PPL','01','',30650,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933184,'BW','Otse','Otse',25.7333,-25.0167,'P','PPL','09','',6275,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933186,'BW','Orapa','Orapa',25.3764,-21.3115,'P','PPL','01','',9189,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933271,'BW','Mosopa','Mosopa',25.4216,-24.7718,'P','PPL','10','',19561,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933305,'BW','Molepolole','Molepolole',25.4951,-24.4066,'P','PPLA','06','',63248,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933331,'BW','Mogoditshane','Mogoditshane',25.8656,-24.6269,'P','PPL','06','',43394,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933340,'BW','Mochudi','Mochudi',26.15,-24.4167,'P','PPLA','05','',36962,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933366,'BW','Maun','Maun',23.4167,-19.9833,'P','PPLA','11','',49945,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933471,'BW','Mahalapye','Mahalapye',26.8142,-23.1041,'P','PPL','01','',44471,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933521,'BW','Lobatse','Lobatse',25.6773,-25.2243,'P','PPL','09','',30883,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933534,'BW','Letlhakeng','Letlhakeng',25.0298,-24.0944,'P','PPL','06','',6781,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933535,'BW','Letlhakane','Letlhakane',25.5926,-21.4149,'P','PPL','01','',18136,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933596,'BW','Kopong','Kopong',25.8833,-24.4833,'P','PPL','09','',6895,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933677,'BW','Kasane','Kasane',25.15,-17.8167,'P','PPL','11','',9250,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933685,'BW','Kanye','Kanye',25.3327,-24.9667,'P','PPLA','10','',44716,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933719,'BW','Janeng','Janeng',25.55,-25.4167,'P','PPL','09','',16853,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933759,'BW','Ghanzi','Ghanzi',21.7833,-21.5667,'P','PPLA','03','',9934,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933773,'BW','Gaborone','Gaborone',25.9086,-24.6545,'P','PPLC','09','',208411,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933777,'BW','Gabane','Gabane',25.7822,-24.6667,'P','PPL','06','',12884,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (933778,'BW','Francistown','Francistown',27.5079,-21.17,'P','PPLA','08','',89979,'Africa/Gaborone',1,NULL,NULL);
INSERT INTO `cities` VALUES (1106206,'BW','Metsemotlhaba','Metsemotlhaba',25.8031,-24.5514,'P','PPL','06','',5544,'Africa/Gaborone',1,NULL,NULL);
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
