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
INSERT INTO `subadmin1` VALUES (2424,'NP.CR','Central Region','Central Region',1);
INSERT INTO `subadmin1` VALUES (2425,'NP.ER','Eastern Region','Eastern Region',1);
INSERT INTO `subadmin1` VALUES (2426,'NP.FR','Far Western','Far Western',1);
INSERT INTO `subadmin1` VALUES (2427,'NP.MR','Mid Western','Mid Western',1);
INSERT INTO `subadmin1` VALUES (2428,'NP.WR','Western Region','Western Region',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (23935,'NP.CR.01','Bāgmatī Zone','Bagmati Zone',1);
INSERT INTO `subadmin2` VALUES (23936,'NP.CR.05','Janakpur Zone','Janakpur Zone',1);
INSERT INTO `subadmin2` VALUES (23937,'NP.CR.11','Nārāyanī Zone','Narayani Zone',1);
INSERT INTO `subadmin2` VALUES (23938,'NP.ER.07','Kosī Zone','Kosi Zone',1);
INSERT INTO `subadmin2` VALUES (23939,'NP.ER.10','Mechī Zone','Mechi Zone',1);
INSERT INTO `subadmin2` VALUES (23940,'NP.ER.13','Sagarmāthā Zone','Sagarmatha Zone',1);
INSERT INTO `subadmin2` VALUES (23941,'NP.FR.09','Mahākālī Zone','Mahakali Zone',1);
INSERT INTO `subadmin2` VALUES (23942,'NP.FR.14','Setī Zone','Seti Zone',1);
INSERT INTO `subadmin2` VALUES (23943,'NP.MR.02','Bherī Zone','Bheri Zone',1);
INSERT INTO `subadmin2` VALUES (23944,'NP.MR.06','Karnālī Zone','Karnali Zone',1);
INSERT INTO `subadmin2` VALUES (23945,'NP.MR.12','Rāptī Zone','Rapti Zone',1);
INSERT INTO `subadmin2` VALUES (23946,'NP.WR.03','Dhawalāgiri Zone','Dhawalagiri Zone',1);
INSERT INTO `subadmin2` VALUES (23947,'NP.WR.04','Gandakī Zone','Gandaki Zone',1);
INSERT INTO `subadmin2` VALUES (23948,'NP.WR.08','Lumbinī Zone','Lumbini Zone',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (1282616,'NP','Wāling','Waling',83.7667,27.9833,'P','PPL','WR','',21867,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1282635,'NP','Tulsīpur','Tulsipur',82.2973,28.131,'P','PPL','MR','',39058,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1282666,'NP','Tīkāpur','Tikapur',81.1333,28.5,'P','PPL','FR','',44758,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1282714,'NP','Tānsen','Tansen',83.5467,27.8673,'P','PPL','WR','',23693,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1282770,'NP','Sirāhā','Siraha',86.2087,26.6541,'P','PPL','ER','',24657,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1282884,'NP','Rājbirāj','Rajbiraj',86.75,26.5333,'P','PPL','ER','',33061,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1282898,'NP','Pokhara','Pokhara',83.9685,28.2669,'P','PPLA','WR','04',200000,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1282931,'NP','Pātan','Patan',85.3142,27.6766,'P','PPL','CR','01',183310,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1282950,'NP','Panauti̇̄','Panauti',85.5148,27.5845,'P','PPL','CR','',27602,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283082,'NP','Malangwa','Malangwa',85.5581,26.8568,'P','PPL','CR','',20284,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283095,'NP','Mahendranagar','Mahendranagar',80.3333,28.9167,'P','PPL','FR','',88381,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283119,'NP','Lobujya','Lobujya',86.8167,27.95,'P','PPL','ER','',8767,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283161,'NP','Lahān','Lahan',86.4951,26.7296,'P','PPL','ER','',31495,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283190,'NP','Kirtipur','Kirtipur',85.2775,27.6787,'P','PPL','CR','',44632,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283217,'NP','Khāndbāri','Khandbari',87.2039,27.3747,'P','PPL','ER','',22903,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283240,'NP','Kathmandu','Kathmandu',85.3206,27.7017,'P','PPLC','CR','01',1442271,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283285,'NP','Jumla','Jumla',82.1838,29.2747,'P','PPL','MR','06',9073,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283318,'NP','Janakpur','Janakpur',85.9065,26.7183,'P','PPL','CR','',93767,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283323,'NP','Jaleswar','Jaleswar',85.8008,26.6471,'P','PPL','CR','',23573,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283329,'NP','Ithari','Ithari',87.2833,26.6667,'P','PPL','ER','',47984,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283333,'NP','Ilām','Ilam',87.9282,26.9094,'P','PPLA3','ER','10',17491,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283339,'NP','Hetauda','Hetauda',85.0322,27.4284,'P','PPL','CR','11',84775,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283368,'NP','Gulariyā','Gulariya',81.3333,28.2333,'P','PPL','MR','',53107,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283401,'NP','Gaur','Gaur',85.2667,26.7667,'P','PPL','CR','',27325,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283460,'NP','Dharān Bāzār','Dharan Bazar',87.2835,26.8125,'P','PPL','ER','',108600,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283465,'NP','Dhankutā','Dhankuta',87.3333,26.9833,'P','PPLA','ER','',22084,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283467,'NP','Dhangarhi','Dhangarhi',80.5961,28.7079,'P','PPL','FR','',92294,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283484,'NP','Dārchulā','Darchula',80.5287,29.8412,'P','PPL','WR','',18317,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283496,'NP','Dailekh','Dailekh',81.7101,28.8443,'P','PPLA3','MR','02',20908,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283499,'NP','Dadeldhurā','Dadeldhura',80.5806,29.2984,'P','PPL','FR','',19014,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283562,'NP','Butwāl','Butwal',83.4484,27.7006,'P','PPL','WR','',91733,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283581,'NP','Bīrganj','Birganj',84.8773,27.0104,'P','PPL','CR','',133238,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283582,'NP','Birātnagar','Biratnagar',87.2834,26.4831,'P','PPL','ER','07',182324,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283613,'NP','Bharatpur','Bharatpur',84.4333,27.6833,'P','PPL','CR','11',107157,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283621,'NP','Bhairāhawā','Bhairahawa',83.45,27.5,'P','PPL','WR','08',63367,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283628,'NP','Bhadrapur','Bhadrapur',88.0944,26.544,'P','PPL','ER','',19523,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283679,'NP','Banepā','Banepa',85.5219,27.6325,'P','PPL','CR','',17153,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (1283711,'NP','Bāglung','Baglung',83.5898,28.2719,'P','PPL','WR','',23296,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (6254842,'NP','Besisahar','Besisahar',82.4128,28.2342,'P','PPL','00','',5427,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (6254843,'NP','Birendranagar','Birendranagar',81.6339,28.6019,'P','PPLA','MR','',31381,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (6254845,'NP','Dipayal','Dipayal',80.94,29.2608,'P','PPLA','FR','',23416,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (6941099,'NP','Nepalgunj','Nepalgunj',81.6167,28.05,'P','PPL','MR','02',64400,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (8199102,'NP','kankrabari Dovan','kankrabari Dovan',85.4593,27.6288,'P','PPL','CR','01',10000,'Asia/Kathmandu',1,NULL,NULL);
INSERT INTO `cities` VALUES (8504556,'NP','Hari Bdr Tamang House','Hari Bdr Tamang House',85.4589,27.6289,'P','PPL','CR','01',10000,'Asia/Kathmandu',1,NULL,NULL);
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
