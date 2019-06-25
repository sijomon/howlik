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
INSERT INTO `subadmin1` VALUES (1029,'GM.01','Banjul','Banjul',1);
INSERT INTO `subadmin1` VALUES (1030,'GM.02','Lower River','Lower River',1);
INSERT INTO `subadmin1` VALUES (1031,'GM.03','Central River','Central River',1);
INSERT INTO `subadmin1` VALUES (1032,'GM.04','Upper River','Upper River',1);
INSERT INTO `subadmin1` VALUES (1033,'GM.05','Western','Western',1);
INSERT INTO `subadmin1` VALUES (1034,'GM.07','North Bank','North Bank',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (13002,'GM.01.2413107','Kanifing','Kanifing',1);
INSERT INTO `subadmin2` VALUES (13003,'GM.01.2593772','Kombo Saint Mary District','Kombo Saint Mary District',1);
INSERT INTO `subadmin2` VALUES (13004,'GM.02.2412885','Kiang West District','Kiang West District',1);
INSERT INTO `subadmin2` VALUES (13005,'GM.02.2412886','Kiang East','Kiang East',1);
INSERT INTO `subadmin2` VALUES (13006,'GM.02.2412887','Kiang Central','Kiang Central',1);
INSERT INTO `subadmin2` VALUES (13007,'GM.02.2413266','Jarra West','Jarra West',1);
INSERT INTO `subadmin2` VALUES (13008,'GM.02.2413267','Jarra East','Jarra East',1);
INSERT INTO `subadmin2` VALUES (13009,'GM.02.2413268','Jarra Central','Jarra Central',1);
INSERT INTO `subadmin2` VALUES (13010,'GM.03.10299957','Janjanbureh','Janjanbureh',1);
INSERT INTO `subadmin2` VALUES (13011,'GM.03.2411710','Upper Saloum','Upper Saloum',1);
INSERT INTO `subadmin2` VALUES (13012,'GM.03.2412201','Sami District','Sami District',1);
INSERT INTO `subadmin2` VALUES (13013,'GM.03.2412420','Nianija District','Nianija District',1);
INSERT INTO `subadmin2` VALUES (13014,'GM.03.2412421','Niani','Niani',1);
INSERT INTO `subadmin2` VALUES (13015,'GM.03.2412422','Niamina West District','Niamina West District',1);
INSERT INTO `subadmin2` VALUES (13016,'GM.03.2412423','Niamina East District','Niamina East District',1);
INSERT INTO `subadmin2` VALUES (13017,'GM.03.2412424','Niamina Dankunku District','Niamina Dankunku District',1);
INSERT INTO `subadmin2` VALUES (13018,'GM.03.2412715','Lower Saloum','Lower Saloum',1);
INSERT INTO `subadmin2` VALUES (13019,'GM.03.2413461','Fulladu West','Fulladu West',1);
INSERT INTO `subadmin2` VALUES (13020,'GM.04.2411671','Wuli','Wuli',1);
INSERT INTO `subadmin2` VALUES (13021,'GM.04.2412176','Sandu','Sandu',1);
INSERT INTO `subadmin2` VALUES (13022,'GM.04.2413088','Kantora','Kantora',1);
INSERT INTO `subadmin2` VALUES (13023,'GM.04.2413462','Fulladu East','Fulladu East',1);
INSERT INTO `subadmin2` VALUES (13024,'GM.05.2412849','Kombo South District','Kombo South District',1);
INSERT INTO `subadmin2` VALUES (13025,'GM.05.2412850','Kombo North District','Kombo North District',1);
INSERT INTO `subadmin2` VALUES (13026,'GM.05.2412851','Kombo East District','Kombo East District',1);
INSERT INTO `subadmin2` VALUES (13027,'GM.05.2412852','Kombo Central District','Kombo Central District',1);
INSERT INTO `subadmin2` VALUES (13028,'GM.05.2413477','Foni Kansala','Foni Kansala',1);
INSERT INTO `subadmin2` VALUES (13029,'GM.05.2413478','Foni Jarrol','Foni Jarrol',1);
INSERT INTO `subadmin2` VALUES (13030,'GM.05.2413479','Foni Brefet','Foni Brefet',1);
INSERT INTO `subadmin2` VALUES (13031,'GM.05.2413480','Foni Bondali','Foni Bondali',1);
INSERT INTO `subadmin2` VALUES (13032,'GM.05.2413481','Foni Bintang-Karenai','Foni Bintang-Karenai',1);
INSERT INTO `subadmin2` VALUES (13033,'GM.07.2411712','Upper Niumi District','Upper Niumi District',1);
INSERT INTO `subadmin2` VALUES (13034,'GM.07.2411714','Upper Baddibu','Upper Baddibu',1);
INSERT INTO `subadmin2` VALUES (13035,'GM.07.2412717','Lower Niumi District','Lower Niumi District',1);
INSERT INTO `subadmin2` VALUES (13036,'GM.07.2412718','Lower Baddibu District','Lower Baddibu District',1);
INSERT INTO `subadmin2` VALUES (13037,'GM.07.2413213','Jokadu','Jokadu',1);
INSERT INTO `subadmin2` VALUES (13038,'GM.07.2413640','Dappo','Dappo',1);
INSERT INTO `subadmin2` VALUES (13039,'GM.07.2413641','Dappo','Dappo',1);
INSERT INTO `subadmin2` VALUES (13040,'GM.07.2413686','Central Baddibu','Central Baddibu',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (2411880,'GM','Sukuta','Sukuta',-16.7082,13.4103,'P','PPL','05','',15131,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2411905,'GM','Soma','Soma',-15.5333,13.4333,'P','PPL','02','',9869,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2412248,'GM','Sabi','Sabi',-14.2,13.2333,'P','PPL','04','',7738,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2412605,'GM','Mansa Konko','Mansa Konko',-15.55,13.4667,'P','PPLA','02','',1978,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2412749,'GM','Lamin','Lamin',-16.4339,13.3522,'P','PPL','07','',24797,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2412992,'GM','Kerewan','Kerewan',-16.0888,13.4898,'P','PPLA','07','',2751,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2413419,'GM','Gunjur','Gunjur',-16.7339,13.2019,'P','PPL','05','',14088,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2413437,'GM','Georgetown','Georgetown',-14.7637,13.5404,'P','PPLA','03','',3584,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2413515,'GM','Farafenni','Farafenni',-15.6,13.5667,'P','PPL','07','',29867,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2413533,'GM','Essau','Essau',-16.5347,13.4839,'P','PPL','07','',5907,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2413753,'GM','Brikama','Brikama',-16.6494,13.2714,'P','PPLA','05','',77700,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2413818,'GM','Basse Santa Su','Basse Santa Su',-14.2137,13.3099,'P','PPLA','04','',14380,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2413827,'GM','Barra','Barra',-16.5456,13.4828,'P','PPL','07','',5323,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2413866,'GM','Bansang','Bansang',-14.65,13.4333,'P','PPL','03','',7615,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2413876,'GM','Banjul','Banjul',-16.578,13.4527,'P','PPLC','01','',34589,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2413920,'GM','Bakau','Bakau',-16.6819,13.4781,'P','PPL','01','',43098,'Africa/Banjul',1,NULL,NULL);
INSERT INTO `cities` VALUES (2413990,'GM','Abuko','Abuko',-16.6558,13.4042,'P','PPL','05','',6572,'Africa/Banjul',1,NULL,NULL);
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
