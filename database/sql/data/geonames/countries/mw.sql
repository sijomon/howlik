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
INSERT INTO `subadmin1` VALUES (2252,'MW.C','Central Region','Central Region',1);
INSERT INTO `subadmin1` VALUES (2253,'MW.N','Northern Region','Northern Region',1);
INSERT INTO `subadmin1` VALUES (2254,'MW.S','Southern Region','Southern Region',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (19483,'MW.C.06','Dedza District','Dedza District',1);
INSERT INTO `subadmin2` VALUES (19484,'MW.C.07','Dowa District','Dowa District',1);
INSERT INTO `subadmin2` VALUES (19485,'MW.C.09','Kasungu District','Kasungu District',1);
INSERT INTO `subadmin2` VALUES (19486,'MW.C.11','Lilongwe District','Lilongwe District',1);
INSERT INTO `subadmin2` VALUES (19487,'MW.C.13','Mchinji District','Mchinji District',1);
INSERT INTO `subadmin2` VALUES (19488,'MW.C.16','Ntcheu District','Ntcheu District',1);
INSERT INTO `subadmin2` VALUES (19489,'MW.C.18','Nkhotakota District','Nkhotakota District',1);
INSERT INTO `subadmin2` VALUES (19490,'MW.C.20','Ntchisi District','Ntchisi District',1);
INSERT INTO `subadmin2` VALUES (19491,'MW.C.22','Salima District','Salima District',1);
INSERT INTO `subadmin2` VALUES (19492,'MW.N.04','Chitipa District','Chitipa District',1);
INSERT INTO `subadmin2` VALUES (19493,'MW.N.08','Karonga District','Karonga District',1);
INSERT INTO `subadmin2` VALUES (19494,'MW.N.15','Mzimba District','Mzimba District',1);
INSERT INTO `subadmin2` VALUES (19495,'MW.N.17','Nkhata Bay District','Nkhata Bay District',1);
INSERT INTO `subadmin2` VALUES (19496,'MW.N.21','Rumphi District','Rumphi District',1);
INSERT INTO `subadmin2` VALUES (19497,'MW.N.27','Likoma District','Likoma District',1);
INSERT INTO `subadmin2` VALUES (19498,'MW.S.02','Chikwawa District','Chikwawa District',1);
INSERT INTO `subadmin2` VALUES (19499,'MW.S.03','Chiradzulu District','Chiradzulu District',1);
INSERT INTO `subadmin2` VALUES (19500,'MW.S.05','Thyolo District','Thyolo District',1);
INSERT INTO `subadmin2` VALUES (19501,'MW.S.12','Mangochi District','Mangochi District',1);
INSERT INTO `subadmin2` VALUES (19502,'MW.S.19','Nsanje District','Nsanje District',1);
INSERT INTO `subadmin2` VALUES (19503,'MW.S.23','Zomba District','Zomba District',1);
INSERT INTO `subadmin2` VALUES (19504,'MW.S.24','Blantyre District','Blantyre District',1);
INSERT INTO `subadmin2` VALUES (19505,'MW.S.25','Mwanza District','Mwanza District',1);
INSERT INTO `subadmin2` VALUES (19506,'MW.S.26','Balaka District','Balaka District',1);
INSERT INTO `subadmin2` VALUES (19507,'MW.S.28','Machinga District','Machinga District',1);
INSERT INTO `subadmin2` VALUES (19508,'MW.S.29','Mulanje District','Mulanje District',1);
INSERT INTO `subadmin2` VALUES (19509,'MW.S.30','Phalombe District','Phalombe District',1);
INSERT INTO `subadmin2` VALUES (19510,'MW.S.31','Neno District','Neno District',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (235715,'MW','Karonga','Karonga',33.9333,-9.93333,'P','PPLA2','N','08',34207,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (235751,'MW','Chitipa','Chitipa',33.2697,-9.70237,'P','PPLA2','N','04',8824,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (923295,'MW','Zomba','Zomba',35.3188,-15.386,'P','PPLA2','S','23',80932,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (923652,'MW','Thyolo','Thyolo',35.1405,-16.0678,'P','PPLA2','S','05',5775,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (924055,'MW','Salima','Salima',34.4587,-13.7804,'P','PPLA2','C','22',30052,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (924102,'MW','Rumphi','Rumphi',33.8575,-11.0186,'P','PPLA2','N','21',20727,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (924491,'MW','Ntchisi','Ntchisi',33.9149,-13.5278,'P','PPLA2','C','20',7918,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (924492,'MW','Ntcheu','Ntcheu',34.6359,-14.8203,'P','PPLA2','C','16',10445,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (924572,'MW','Nsanje','Nsanje',35.262,-16.92,'P','PPLA2','S','19',21774,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (924705,'MW','Nkhotakota','Nkhotakota',34.2961,-12.9274,'P','PPLA2','C','18',24865,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (924732,'MW','Nkhata Bay','Nkhata Bay',34.2907,-11.6066,'P','PPLA2','N','17',11721,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (925475,'MW','Mzuzu','Mzuzu',34.0207,-11.4656,'P','PPLA','N','15',175345,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (925498,'MW','Mzimba','Mzimba',33.6,-11.9,'P','PPLA2','N','15',19308,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (925596,'MW','Mwanza','Mwanza',34.5248,-15.6026,'P','PPLA2','S','25',11379,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (925789,'MW','Mulanje','Mulanje',35.5,-16.0316,'P','PPLA2','S','29',16483,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (926087,'MW','Mponela','Mponela',33.7401,-13.5319,'P','PPL','C','07',11222,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (926308,'MW','Monkey Bay','Monkey Bay',34.9165,-14.0824,'P','PPL','S','12',11619,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (926747,'MW','Mchinji','Mchinji',32.8802,-13.7984,'P','PPLA2','C','13',18305,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (927246,'MW','Mangochi','Mangochi',35.2645,-14.4782,'P','PPLA2','S','12',40236,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (927792,'MW','Luchenza','Luchenza',35.3095,-16.0069,'P','PPL','S','05',11939,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (927834,'MW','Liwonde','Liwonde',35.2254,-15.0667,'P','PPL','S','28',22469,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (927856,'MW','Livingstonia','Livingstonia',34.1063,-10.606,'P','PPL','N','21',5552,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (927967,'MW','Lilongwe','Lilongwe',33.7873,-13.9669,'P','PPLC','C','11',646750,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (928534,'MW','Kasungu','Kasungu',33.4833,-13.0333,'P','PPLA2','C','09',42555,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (929977,'MW','Dowa','Dowa',33.9375,-13.654,'P','PPLA2','C','07',5565,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (930025,'MW','Dedza','Dedza',34.3332,-14.3779,'P','PPLA2','C','06',15608,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (931070,'MW','Chikwawa','Chikwawa',34.8009,-16.0335,'P','PPLA2','S','02',6987,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (931755,'MW','Blantyre','Blantyre',35.0085,-15.785,'P','PPLA','S','24',584877,'Africa/Blantyre',1,NULL,NULL);
INSERT INTO `cities` VALUES (931865,'MW','Balaka','Balaka',34.9557,-14.9793,'P','PPLA2','S','26',18902,'Africa/Blantyre',1,NULL,NULL);
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
