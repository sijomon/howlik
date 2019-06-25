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
INSERT INTO `subadmin1` VALUES (947,'FO.NO','Norðoyar','Nordoyar',1);
INSERT INTO `subadmin1` VALUES (948,'FO.OS','Eysturoy','Eysturoy',1);
INSERT INTO `subadmin1` VALUES (949,'FO.SA','Sandoy','Sandoy',1);
INSERT INTO `subadmin1` VALUES (950,'FO.ST','Streymoy','Streymoy',1);
INSERT INTO `subadmin1` VALUES (951,'FO.SU','Suðuroy','Suduroy',1);
INSERT INTO `subadmin1` VALUES (952,'FO.VG','Vágar','Vagar',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (12554,'FO.NO.2614213','Sandur','Sandur',1);
INSERT INTO `subadmin2` VALUES (12555,'FO.OS.2622677','Eiði','Eidi',1);
INSERT INTO `subadmin2` VALUES (12556,'FO.OS.7798679','Eystur','Eystur',1);
INSERT INTO `subadmin2` VALUES (12557,'FO.OS.7798686','Sjóvar','Sjovar',1);
INSERT INTO `subadmin2` VALUES (12558,'FO.SA.2610303','Viðareiði','Vidareidi',1);
INSERT INTO `subadmin2` VALUES (12559,'FO.SA.2613661','Skopun','Skopun',1);
INSERT INTO `subadmin2` VALUES (12560,'FO.SA.2616501','Nes','Nes',1);
INSERT INTO `subadmin2` VALUES (12561,'FO.ST.2610344','Vestmanna','Vestmanna',1);
INSERT INTO `subadmin2` VALUES (12562,'FO.ST.2611397','Tórshavn','Torshavn',1);
INSERT INTO `subadmin2` VALUES (12563,'FO.ST.2612891','Sørvágur','Sorvagur',1);
INSERT INTO `subadmin2` VALUES (12564,'FO.ST.2614403','Runavík','Runavik',1);
INSERT INTO `subadmin2` VALUES (12565,'FO.ST.2618086','Kvívík','Kvivik',1);
INSERT INTO `subadmin2` VALUES (12566,'FO.ST.2619616','Húsar','Husar',1);
INSERT INTO `subadmin2` VALUES (12567,'FO.ST.2621795','Fugloy','Fugloy',1);
INSERT INTO `subadmin2` VALUES (12568,'FO.ST.2621810','Fuglafjørður','Fuglafjordur',1);
INSERT INTO `subadmin2` VALUES (12569,'FO.ST.7798685','Sunda','Sunda',1);
INSERT INTO `subadmin2` VALUES (12570,'FO.SU.2610808','Vágur','Vagur',1);
INSERT INTO `subadmin2` VALUES (12571,'FO.SU.2612088','Sunnbøur','Sunnbour',1);
INSERT INTO `subadmin2` VALUES (12572,'FO.SU.2613479','Skúvoy','Skuvoy',1);
INSERT INTO `subadmin2` VALUES (12573,'FO.SU.2613922','Skálavík','Skalavik',1);
INSERT INTO `subadmin2` VALUES (12574,'FO.SU.2615133','Porkeri','Porkeri',1);
INSERT INTO `subadmin2` VALUES (12575,'FO.SU.2618121','Kunoy','Kunoy',1);
INSERT INTO `subadmin2` VALUES (12576,'FO.SU.2618796','Klaksvik','Klaksvik',1);
INSERT INTO `subadmin2` VALUES (12577,'FO.SU.2619569','Hvannasund','Hvannasund',1);
INSERT INTO `subadmin2` VALUES (12578,'FO.SU.2619592','Hvalbøur','Hvalbour',1);
INSERT INTO `subadmin2` VALUES (12579,'FO.SU.2619613','Húsavík','Husavik',1);
INSERT INTO `subadmin2` VALUES (12580,'FO.SU.2619738','Hov','Hov',1);
INSERT INTO `subadmin2` VALUES (12581,'FO.SU.2622349','Fámjin','Famjin',1);
INSERT INTO `subadmin2` VALUES (12582,'FO.SU.7798684','Tvøroyri','Tvoroyri',1);
INSERT INTO `subadmin2` VALUES (12583,'FO.VG.7798680','Vága Municipality','Vaga Municipality',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (2611060,'FO','Tvøroyri','Tvoroyri',-6.81109,61.5556,'P','PPLA','SU','',1230,'Atlantic/Faroe',1,NULL,NULL);
INSERT INTO `cities` VALUES (2611396,'FO','Tórshavn','Torshavn',-6.77164,62.0097,'P','PPLC','ST','2611397',13200,'Atlantic/Faroe',1,NULL,NULL);
INSERT INTO `cities` VALUES (2614212,'FO','Sandur','Sandur',-6.80778,61.8425,'P','PPLA','SA','',608,'Atlantic/Faroe',1,NULL,NULL);
INSERT INTO `cities` VALUES (2616914,'FO','Miðvágur','Midvagur',-7.19389,62.0511,'P','PPLA','VG','',1040,'Atlantic/Faroe',1,NULL,NULL);
INSERT INTO `cities` VALUES (2618795,'FO','Klaksvík','Klaksvik',-6.58901,62.2266,'P','PPLA','NO','',4664,'Atlantic/Faroe',1,NULL,NULL);
INSERT INTO `cities` VALUES (2621808,'FO','Fuglafjørður','Fuglafjordur',-6.81395,62.244,'P','PPLA','OS','',1542,'Atlantic/Faroe',1,NULL,NULL);
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
