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
INSERT INTO `subadmin1` VALUES (122,'AS.010','Eastern District','Eastern District',1);
INSERT INTO `subadmin1` VALUES (123,'AS.020','Manu\'a','Manu\'a',1);
INSERT INTO `subadmin1` VALUES (124,'AS.030','Rose Island','Rose Island',1);
INSERT INTO `subadmin1` VALUES (125,'AS.040','Swains Island','Swains Island',1);
INSERT INTO `subadmin1` VALUES (126,'AS.050','Western District','Western District',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (1160,'AS.010.5880872','West Vaifanua County','West Vaifanua County',1);
INSERT INTO `subadmin2` VALUES (1161,'AS.010.5880894','East Vaifanua County','East Vaifanua County',1);
INSERT INTO `subadmin2` VALUES (1162,'AS.010.5881191','Sā‘ole County','Sa\'ole County',1);
INSERT INTO `subadmin2` VALUES (1163,'AS.010.5881213','Sua County','Sua County',1);
INSERT INTO `subadmin2` VALUES (1164,'AS.010.5881281','Itu‘aū County','Itu\'au County',1);
INSERT INTO `subadmin2` VALUES (1165,'AS.010.5881500','Mauputasi County','Mauputasi County',1);
INSERT INTO `subadmin2` VALUES (1166,'AS.010.7267973','Vaifanua County','Vaifanua County',1);
INSERT INTO `subadmin2` VALUES (1167,'AS.020.7267965','Faleasao County','Faleasao County',1);
INSERT INTO `subadmin2` VALUES (1168,'AS.020.8181800','Fitiuta County','Fitiuta County',1);
INSERT INTO `subadmin2` VALUES (1169,'AS.020.8181801','Ta\'u County','Ta\'u County',1);
INSERT INTO `subadmin2` VALUES (1170,'AS.020.8181803','Olosega County','Olosega County',1);
INSERT INTO `subadmin2` VALUES (1171,'AS.020.8198683','Ofu County','Ofu County',1);
INSERT INTO `subadmin2` VALUES (1172,'AS.050.5881074','Tuālāuta County','Tualauta County',1);
INSERT INTO `subadmin2` VALUES (1173,'AS.050.5881085','Tūalātai County','Tualatai County',1);
INSERT INTO `subadmin2` VALUES (1174,'AS.050.5881380','Leālātaua County','Lealataua County',1);
INSERT INTO `subadmin2` VALUES (1175,'AS.050.5881381','Leāsina County','Leasina County',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (5881150,'AS','Taulaga','Taulaga',-171.088,-11.0553,'P','PPLA','040','',37,'Pacific/Pago_Pago',1,NULL,NULL);
INSERT INTO `cities` VALUES (5881165,'AS','Ta`ū','Ta`u',-169.514,-14.2336,'P','PPLA','020','',873,'Pacific/Pago_Pago',1,NULL,NULL);
INSERT INTO `cities` VALUES (5881192,'AS','Tāfuna','Tafuna',-170.72,-14.3358,'P','PPL','050','',11017,'Pacific/Pago_Pago',1,NULL,NULL);
INSERT INTO `cities` VALUES (5881576,'AS','Pago Pago','Pago Pago',-170.702,-14.2781,'P','PPLC','010','',11500,'Pacific/Pago_Pago',1,NULL,NULL);
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
