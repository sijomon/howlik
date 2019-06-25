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
INSERT INTO `subadmin1` VALUES (69,'AM.01','Aragatsotn Province','Aragatsotn Province',1);
INSERT INTO `subadmin1` VALUES (70,'AM.02','Ararat Province','Ararat Province',1);
INSERT INTO `subadmin1` VALUES (71,'AM.03','Armavir Province','Armavir Province',1);
INSERT INTO `subadmin1` VALUES (72,'AM.04','Gegharkunik Province','Gegharkunik Province',1);
INSERT INTO `subadmin1` VALUES (73,'AM.05','Kotayk Province','Kotayk Province',1);
INSERT INTO `subadmin1` VALUES (74,'AM.06','Lori Province','Lori Province',1);
INSERT INTO `subadmin1` VALUES (75,'AM.07','Shirak Province','Shirak Province',1);
INSERT INTO `subadmin1` VALUES (76,'AM.08','Syunik Province','Syunik Province',1);
INSERT INTO `subadmin1` VALUES (77,'AM.09','Tavush Province','Tavush Province',1);
INSERT INTO `subadmin1` VALUES (78,'AM.10','Vayots Dzor Province','Vayots Dzor Province',1);
INSERT INTO `subadmin1` VALUES (79,'AM.11','Yerevan','Yerevan',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (473,'AM.01.7874001','Achtarak','Achtarak',1);
INSERT INTO `subadmin2` VALUES (474,'AM.04.616436','Martuni','Martuni',1);
INSERT INTO `subadmin2` VALUES (475,'AM.08.174761','Sisian','Sisian',1);
INSERT INTO `subadmin2` VALUES (476,'AM.10.174959','Vayk\'i Shrjan','Vayk\'i Shrjan',1);
INSERT INTO `subadmin2` VALUES (477,'AM.11.616200','Spandaryanskiy Rayon','Spandaryanskiy Rayon',1);
INSERT INTO `subadmin2` VALUES (478,'AM.11.616205','Arabkir','Arabkir',1);
INSERT INTO `subadmin2` VALUES (479,'AM.11.616233','Shaumyanskiy Rayon','Shaumyanskiy Rayon',1);
INSERT INTO `subadmin2` VALUES (480,'AM.11.616323','Ordzhonikidzevskiy Rayon','Ordzhonikidzevskiy Rayon',1);
INSERT INTO `subadmin2` VALUES (481,'AM.11.616485','Leninskiy Rayon','Leninskiy Rayon',1);
INSERT INTO `subadmin2` VALUES (482,'AM.11.616624','Imeni Dvadtsati Shesti Komissarov Rayon','Imeni Dvadtsati Shesti Komissarov Rayon',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (174710,'AM','Yeghegnadzor','Yeghegnadzor',45.3324,39.7639,'P','PPLA','10','',8200,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (174725,'AM','Vedi','Vedi',44.7222,39.9142,'P','PPL','02','',12192,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (174726,'AM','Vayk’','Vayk\'',45.4667,39.6889,'P','PPL','10','',5419,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (174875,'AM','Kapan','Kapan',46.4058,39.2076,'P','PPLA','08','',33160,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (174895,'AM','Goris','Goris',46.3382,39.5129,'P','PPL','08','',20379,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (174972,'AM','Hats’avan','Hats\'avan',45.9705,39.4641,'P','PPL','08','',15208,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (174979,'AM','Artashat','Artashat',44.5445,39.9614,'P','PPLA','02','',20562,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (174991,'AM','Ararat','Ararat',44.7049,39.8317,'P','PPL','02','',28832,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616052,'AM','Yerevan','Yerevan',44.5136,40.1811,'P','PPLC','11','',1093485,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616062,'AM','Ejmiatsin','Ejmiatsin',44.2946,40.1656,'P','PPL','03','',49513,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616065,'AM','Yeghvard','Yeghvard',44.4814,40.3205,'P','PPL','05','',10705,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616108,'AM','Vardenis','Vardenis',45.7311,40.1827,'P','PPL','04','',11382,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616109,'AM','Vardenik','Vardenik',45.4431,40.1335,'P','PPL','04','',7709,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616178,'AM','Tashir','Tashir',44.2846,41.1207,'P','PPL','06','',7318,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616199,'AM','Spitak','Spitak',44.2673,40.8322,'P','PPL','06','',15059,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616250,'AM','Sevan','Sevan',44.9487,40.5484,'P','PPL','04','',17083,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616255,'AM','Sarukhan','Sarukhan',45.1306,40.2905,'P','PPL','04','',6173,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616328,'AM','Hoktember','Hoktember',44.0097,40.1321,'P','PPL','03','',5348,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616333,'AM','Noyemberyan','Noyemberyan',44.9992,41.1724,'P','PPL','09','',5119,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616361,'AM','Noratus','Noratus',45.1772,40.3755,'P','PPL','04','',5426,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616375,'AM','Nerk’in Getashen','Nerk\'in Getashen',45.2709,40.1417,'P','PPL','04','',7010,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616417,'AM','Metsamor','Metsamor',44.2896,40.073,'P','PPL','03','',8789,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616435,'AM','Masis','Masis',44.4359,40.0676,'P','PPL','02','',18911,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616438,'AM','Martuni','Martuni',45.3055,40.1389,'P','PPL','04','',11037,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616530,'AM','Vanadzor','Vanadzor',44.4939,40.8046,'P','PPLA','06','',101098,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616576,'AM','Karanlukh','Karanlukh',45.2897,40.1044,'P','PPL','04','',5104,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616599,'AM','Gavarr','Gavarr',45.1239,40.354,'P','PPLA','04','',21680,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616627,'AM','Ijevan','Ijevan',45.1485,40.8788,'P','PPLA','09','',14737,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616629,'AM','Hrazdan','Hrazdan',44.7662,40.4975,'P','PPLA','05','',40795,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616631,'AM','Armavir','Armavir',44.0382,40.1545,'P','PPLA','03','',25963,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616635,'AM','Gyumri','Gyumri',43.8453,40.7942,'P','PPLA','07','',148381,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616697,'AM','Garrni','Garrni',44.7344,40.1193,'P','PPL','05','',6827,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616752,'AM','Dilijan','Dilijan',44.8636,40.741,'P','PPL','09','',13478,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616786,'AM','Chambarak','Chambarak',45.355,40.5965,'P','PPL','04','',6153,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616790,'AM','Byureghavan','Byureghavan',44.594,40.3148,'P','PPL','05','',6972,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616802,'AM','Berd','Berd',45.389,40.8814,'P','PPL','09','',8374,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616877,'AM','Ashtarak','Ashtarak',44.362,40.2991,'P','PPLA','01','',18779,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616953,'AM','Aparan','Aparan',44.3589,40.5932,'P','PPL','01','',5670,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616974,'AM','Alaverdi','Alaverdi',44.6732,41.0977,'P','PPL','06','',13184,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (616989,'AM','Akhuryan','Akhuryan',43.9003,40.78,'P','PPL','07','',7672,'Asia/Yerevan',1,NULL,NULL);
INSERT INTO `cities` VALUES (617026,'AM','Abovyan','Abovyan',44.6266,40.2674,'P','PPL','05','',35673,'Asia/Yerevan',1,NULL,NULL);
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
