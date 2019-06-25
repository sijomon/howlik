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
INSERT INTO `subadmin1` VALUES (2848,'RW.11','Eastern Province','Eastern Province',1);
INSERT INTO `subadmin1` VALUES (2849,'RW.12','Kigali','Kigali',1);
INSERT INTO `subadmin1` VALUES (2850,'RW.13','Northern Province','Northern Province',1);
INSERT INTO `subadmin1` VALUES (2851,'RW.14','Western Province','Western Province',1);
INSERT INTO `subadmin1` VALUES (2852,'RW.15','Southern Province','Southern Province',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (30405,'RW.11.7688799','Nyagatare District','Nyagatare District',1);
INSERT INTO `subadmin2` VALUES (30406,'RW.11.7688800','Gatsibo District','Gatsibo District',1);
INSERT INTO `subadmin2` VALUES (30407,'RW.11.7688801','Kayonza District','Kayonza District',1);
INSERT INTO `subadmin2` VALUES (30408,'RW.11.7688802','Rwamagana District','Rwamagana District',1);
INSERT INTO `subadmin2` VALUES (30409,'RW.11.7688803','Bugesera District','Bugesera District',1);
INSERT INTO `subadmin2` VALUES (30410,'RW.11.7688804','Ngoma District','Ngoma District',1);
INSERT INTO `subadmin2` VALUES (30411,'RW.11.7688805','Kirehe District','Kirehe District',1);
INSERT INTO `subadmin2` VALUES (30412,'RW.11.9173537','Rusumo District','Rusumo District',1);
INSERT INTO `subadmin2` VALUES (30413,'RW.12.7690204','Gasabo District','Gasabo District',1);
INSERT INTO `subadmin2` VALUES (30414,'RW.12.7690205','Nyarugenge District','Nyarugenge District',1);
INSERT INTO `subadmin2` VALUES (30415,'RW.12.7690206','Kicukiro District','Kicukiro District',1);
INSERT INTO `subadmin2` VALUES (30416,'RW.13.7688806','Gicumbi District','Gicumbi District',1);
INSERT INTO `subadmin2` VALUES (30417,'RW.13.7688807','Rulindo District','Rulindo District',1);
INSERT INTO `subadmin2` VALUES (30418,'RW.13.7688808','Burera District','Burera District',1);
INSERT INTO `subadmin2` VALUES (30419,'RW.13.7688809','Musanze District','Musanze District',1);
INSERT INTO `subadmin2` VALUES (30420,'RW.13.7688810','Gakenke District','Gakenke District',1);
INSERT INTO `subadmin2` VALUES (30421,'RW.14.7690207','Nyabihu District','Nyabihu District',1);
INSERT INTO `subadmin2` VALUES (30422,'RW.14.7690208','Ngororero District','Ngororero District',1);
INSERT INTO `subadmin2` VALUES (30423,'RW.14.7690209','Rubavu District','Rubavu District',1);
INSERT INTO `subadmin2` VALUES (30424,'RW.14.7690210','Rutsiro District','Rutsiro District',1);
INSERT INTO `subadmin2` VALUES (30425,'RW.14.7690211','Karongi District','Karongi District',1);
INSERT INTO `subadmin2` VALUES (30426,'RW.14.7690212','Nyamasheke District','Nyamasheke District',1);
INSERT INTO `subadmin2` VALUES (30427,'RW.14.7690213','Rusizi District','Rusizi District',1);
INSERT INTO `subadmin2` VALUES (30428,'RW.15.7690214','Muhanga District','Muhanga District',1);
INSERT INTO `subadmin2` VALUES (30429,'RW.15.7690215','Kamonyi District','Kamonyi District',1);
INSERT INTO `subadmin2` VALUES (30430,'RW.15.7690216','Ruhango District','Ruhango District',1);
INSERT INTO `subadmin2` VALUES (30431,'RW.15.7690217','Nyanza District','Nyanza District',1);
INSERT INTO `subadmin2` VALUES (30432,'RW.15.7690218','Nyamagabe District','Nyamagabe District',1);
INSERT INTO `subadmin2` VALUES (30433,'RW.15.7690219','Huye District','Huye District',1);
INSERT INTO `subadmin2` VALUES (30434,'RW.15.7690220','Gisagara District','Gisagara District',1);
INSERT INTO `subadmin2` VALUES (30435,'RW.15.7690221','Nyaruguru District','Nyaruguru District',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (201463,'RW','Rwamagana','Rwamagana',30.4347,-1.9487,'P','PPLA','11','',47203,'Africa/Kigali',1,NULL,NULL);
INSERT INTO `cities` VALUES (201521,'RW','Musanze','Musanze',29.635,-1.49984,'P','PPL','13','',86685,'Africa/Kigali',1,NULL,NULL);
INSERT INTO `cities` VALUES (201865,'RW','Nzega','Nzega',29.5564,-2.479,'P','PPL','15','',33832,'Africa/Kigali',1,NULL,NULL);
INSERT INTO `cities` VALUES (202061,'RW','Kigali','Kigali',30.0588,-1.94995,'P','PPLC','12','',745261,'Africa/Kigali',1,NULL,NULL);
INSERT INTO `cities` VALUES (202065,'RW','Kibuye','Kibuye',29.3478,-2.06028,'P','PPLA','14','',48024,'Africa/Kigali',1,NULL,NULL);
INSERT INTO `cities` VALUES (202068,'RW','Kibungo','Kibungo',30.5427,-2.1597,'P','PPL','11','',46240,'Africa/Kigali',1,NULL,NULL);
INSERT INTO `cities` VALUES (202217,'RW','Gitarama','Gitarama',29.7567,-2.07444,'P','PPLA2','15','',87613,'Africa/Kigali',1,NULL,NULL);
INSERT INTO `cities` VALUES (202326,'RW','Cyangugu','Cyangugu',28.9075,-2.4846,'P','PPL','14','',63883,'Africa/Kigali',1,NULL,NULL);
INSERT INTO `cities` VALUES (202905,'RW','Gisenyi','Gisenyi',29.2564,-1.70278,'P','PPLA2','14','',83623,'Africa/Kigali',1,NULL,NULL);
INSERT INTO `cities` VALUES (203104,'RW','Byumba','Byumba',30.0675,-1.5763,'P','PPLA','13','',70593,'Africa/Kigali',1,NULL,NULL);
INSERT INTO `cities` VALUES (203112,'RW','Butare','Butare',29.7394,-2.59667,'P','PPL','15','',89600,'Africa/Kigali',1,NULL,NULL);
INSERT INTO `cities` VALUES (7062967,'RW','Nyanza','Nyanza',29.7509,-2.35187,'P','PPLA','15','',0,'Africa/Kigali',1,NULL,NULL);
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
