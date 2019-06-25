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
INSERT INTO `subadmin1` VALUES (3537,'TW.01','Fukien','Fukien',1);
INSERT INTO `subadmin1` VALUES (3538,'TW.02','Kaohsiung','Kaohsiung',1);
INSERT INTO `subadmin1` VALUES (3539,'TW.03','Taipei','Taipei',1);
INSERT INTO `subadmin1` VALUES (3540,'TW.04','Taiwan','Taiwan',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (33388,'TW.01.1676511','Kinmen County','Kinmen County',1);
INSERT INTO `subadmin2` VALUES (33389,'TW.01.6724655','Lienchiang','Lienchiang',1);
INSERT INTO `subadmin2` VALUES (33390,'TW.02.KHH','Kaohsiung','Kaohsiung',1);
INSERT INTO `subadmin2` VALUES (33391,'TW.03.TPQ','Taipei','Taipei',1);
INSERT INTO `subadmin2` VALUES (33392,'TW.04.CHA','Changhua','Changhua',1);
INSERT INTO `subadmin2` VALUES (33393,'TW.04.CYI','Chiayi','Chiayi',1);
INSERT INTO `subadmin2` VALUES (33394,'TW.04.CYQ','Chiayi','Chiayi',1);
INSERT INTO `subadmin2` VALUES (33395,'TW.04.HSQ','Hsinchu','Hsinchu',1);
INSERT INTO `subadmin2` VALUES (33396,'TW.04.HSZ','Hsinchu','Hsinchu',1);
INSERT INTO `subadmin2` VALUES (33397,'TW.04.HUA','Hualien','Hualien',1);
INSERT INTO `subadmin2` VALUES (33398,'TW.04.ILA','Yilan','Yilan',1);
INSERT INTO `subadmin2` VALUES (33399,'TW.04.KEE','Keelung','Keelung',1);
INSERT INTO `subadmin2` VALUES (33400,'TW.04.MIA','Miaoli','Miaoli',1);
INSERT INTO `subadmin2` VALUES (33401,'TW.04.NAN','Nantou','Nantou',1);
INSERT INTO `subadmin2` VALUES (33402,'TW.04.PEN','Penghu','Penghu',1);
INSERT INTO `subadmin2` VALUES (33403,'TW.04.PIF','Pingtung','Pingtung',1);
INSERT INTO `subadmin2` VALUES (33404,'TW.04.TAO','Taoyuan','Taoyuan',1);
INSERT INTO `subadmin2` VALUES (33405,'TW.04.TNN','Tainan','Tainan',1);
INSERT INTO `subadmin2` VALUES (33406,'TW.04.TPE','T’ai-pei Shih','T\'ai-pei Shih',1);
INSERT INTO `subadmin2` VALUES (33407,'TW.04.TTT','Taitung','Taitung',1);
INSERT INTO `subadmin2` VALUES (33408,'TW.04.TXG','Taichung City','Taichung City',1);
INSERT INTO `subadmin2` VALUES (33409,'TW.04.YUN','Yunlin','Yunlin',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1665196,'TW','Douliu','Douliu',120.543,23.7094,'P','PPLA2','04','YUN',104723,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1665357,'TW','Yujing','Yujing',120.461,23.1249,'P','PPL','04','',16597,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1668341,'TW','Taipei','Taipei',121.532,25.0478,'P','PPLC','03','TPE',7871900,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1668355,'TW','Tainan','Tainan',120.213,22.9908,'P','PPLA2','04','TNN',771235,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1668399,'TW','Taichung','Taichung',120.684,24.1469,'P','PPLA2','04','TXG',1040725,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1668467,'TW','Daxi','Daxi',121.29,24.8837,'P','PPL','04','',84549,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1670029,'TW','Banqiao','Banqiao',121.467,25.0143,'P','PPLA2','03','TPQ',543342,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1670310,'TW','Puli','Puli',120.97,23.9664,'P','PPL','04','NAN',86406,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1671566,'TW','Nantou','Nantou',120.664,23.9157,'P','PPLA2','04','NAN',105682,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1672228,'TW','Ma-kung','Ma-kung',119.586,23.5654,'P','PPLA2','04','PEN',56435,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1672551,'TW','Lugu','Lugu',120.753,23.7464,'P','PPL','04','',19599,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1673820,'TW','Kaohsiung','Kaohsiung',120.313,22.6163,'P','PPLA','02','',1519711,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1674199,'TW','Yilan','Yilan',121.753,24.757,'P','PPLA2','04','ILA',94188,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1674504,'TW','Hualian','Hualian',121.604,23.9769,'P','PPLA2','04','HUA',350468,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1675151,'TW','Hsinchu','Hsinchu',120.969,24.8036,'P','PPLA2','04','HSZ',404109,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1676242,'TW','Hengchun','Hengchun',120.744,22.0042,'P','PPL','04','',31288,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1678008,'TW','Jincheng','Jincheng',118.318,24.4367,'P','PPLA','01','1676511',37507,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (1678228,'TW','Keelung','Keelung',121.742,25.1283,'P','PPLA2','04','KEE',397515,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (6696918,'TW','Taoyuan City','Taoyuan City',121.297,24.9937,'P','PPL','04','',402014,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (6949678,'TW','Taitung City','Taitung City',121.144,22.7583,'P','PPL','04','',109584,'Asia/Taipei',1,NULL,NULL);
INSERT INTO `cities` VALUES (7601921,'TW','Zhongxing New Village','Zhongxing New Village',120.685,23.9591,'P','PPLA','04','',25549,'Asia/Taipei',1,NULL,NULL);
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
