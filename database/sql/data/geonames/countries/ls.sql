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
INSERT INTO `subadmin1` VALUES (1706,'LS.10','Berea','Berea',1);
INSERT INTO `subadmin1` VALUES (1707,'LS.11','Butha-Buthe','Butha-Buthe',1);
INSERT INTO `subadmin1` VALUES (1708,'LS.12','Leribe','Leribe',1);
INSERT INTO `subadmin1` VALUES (1709,'LS.13','Mafeteng','Mafeteng',1);
INSERT INTO `subadmin1` VALUES (1710,'LS.14','Maseru','Maseru',1);
INSERT INTO `subadmin1` VALUES (1711,'LS.15','Mohaleʼs Hoek','Mohale\'s Hoek District',1);
INSERT INTO `subadmin1` VALUES (1712,'LS.16','Mokhotlong','Mokhotlong',1);
INSERT INTO `subadmin1` VALUES (1713,'LS.17','Qachaʼs Nek','Qacha\'s Nek',1);
INSERT INTO `subadmin1` VALUES (1714,'LS.18','Quthing','Quthing',1);
INSERT INTO `subadmin1` VALUES (1715,'LS.19','Thaba-Tseka','Thaba-Tseka',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (18705,'LS.10.7670808','Mokomahatsi','Mokomahatsi',1);
INSERT INTO `subadmin2` VALUES (18706,'LS.10.7670809','Mokhachane','Mokhachane',1);
INSERT INTO `subadmin2` VALUES (18707,'LS.10.7670811','Mapoteng','Mapoteng',1);
INSERT INTO `subadmin2` VALUES (18708,'LS.10.7670815','Makhoroana','Makhoroana',1);
INSERT INTO `subadmin2` VALUES (18709,'LS.10.7670819','Urban','Urban',1);
INSERT INTO `subadmin2` VALUES (18710,'LS.10.7670820','Mamathe','Mamathe',1);
INSERT INTO `subadmin2` VALUES (18711,'LS.12.7303922','Khomokhoana Community','Khomokhoana Community',1);
INSERT INTO `subadmin2` VALUES (18712,'LS.12.7670780','Urban','Urban',1);
INSERT INTO `subadmin2` VALUES (18713,'LS.12.7670807','Hleoheng','Hleoheng',1);
INSERT INTO `subadmin2` VALUES (18714,'LS.14.7522489','Makhaleng Constituency','Makhaleng Constituency',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (932035,'LS','Teyateyaneng','Teyateyaneng',27.7489,-29.1472,'P','PPLA','10','',5115,'Africa/Maseru',1,NULL,NULL);
INSERT INTO `cities` VALUES (932183,'LS','Quthing','Quthing',27.7003,-30.4,'P','PPLA','18','',24130,'Africa/Maseru',1,NULL,NULL);
INSERT INTO `cities` VALUES (932218,'LS','Qacha’s Nek','Qacha\'s Nek',28.6894,-30.1154,'P','PPLA','17','',25573,'Africa/Maseru',1,NULL,NULL);
INSERT INTO `cities` VALUES (932320,'LS','Nako','Nako',27.7667,-29.6167,'P','PPL','14','',13146,'Africa/Maseru',1,NULL,NULL);
INSERT INTO `cities` VALUES (932416,'LS','Mokhotlong','Mokhotlong',29.0675,-29.2894,'P','PPLA','16','',8809,'Africa/Maseru',1,NULL,NULL);
INSERT INTO `cities` VALUES (932438,'LS','Mohale’s Hoek','Mohale\'s Hoek',27.4769,-30.1514,'P','PPLA','15','',28310,'Africa/Maseru',1,NULL,NULL);
INSERT INTO `cities` VALUES (932505,'LS','Maseru','Maseru',27.4833,-29.3167,'P','PPLC','14','',118355,'Africa/Maseru',1,NULL,NULL);
INSERT INTO `cities` VALUES (932521,'LS','Maputsoe','Maputsoe',27.8992,-28.8866,'P','PPL','12','',32117,'Africa/Maseru',1,NULL,NULL);
INSERT INTO `cities` VALUES (932614,'LS','Mafeteng','Mafeteng',27.2374,-29.823,'P','PPLA','13','',57059,'Africa/Maseru',1,NULL,NULL);
INSERT INTO `cities` VALUES (932698,'LS','Leribe','Leribe',28.045,-28.8718,'P','PPLA','12','',47675,'Africa/Maseru',1,NULL,NULL);
INSERT INTO `cities` VALUES (932886,'LS','Butha-Buthe','Butha-Buthe',28.2494,-28.7666,'P','PPLA','11','',16330,'Africa/Maseru',1,NULL,NULL);
INSERT INTO `cities` VALUES (1106835,'LS','Thaba-Tseka','Thaba-Tseka',28.6084,-29.522,'P','PPLA','19','',5423,'Africa/Maseru',1,NULL,NULL);
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
