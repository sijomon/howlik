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
INSERT INTO `subadmin1` VALUES (3168,'SL.01','Eastern Province','Eastern Province',1);
INSERT INTO `subadmin1` VALUES (3169,'SL.02','Northern Province','Northern Province',1);
INSERT INTO `subadmin1` VALUES (3170,'SL.03','Southern Province','Southern Province',1);
INSERT INTO `subadmin1` VALUES (3171,'SL.04','Western Area','Western Area',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (30860,'SL.01.2407469','Kono District','Kono District',1);
INSERT INTO `subadmin2` VALUES (30861,'SL.01.2407781','Kenema District','Kenema District',1);
INSERT INTO `subadmin2` VALUES (30862,'SL.01.2408249','Kailahun District','Kailahun District',1);
INSERT INTO `subadmin2` VALUES (30863,'SL.02.2403287','Tonkolili District','Tonkolili District',1);
INSERT INTO `subadmin2` VALUES (30864,'SL.02.2404431','Port Loko District','Port Loko District',1);
INSERT INTO `subadmin2` VALUES (30865,'SL.02.2407650','Koinadugu District','Koinadugu District',1);
INSERT INTO `subadmin2` VALUES (30866,'SL.02.2408083','Kambia District','Kambia District',1);
INSERT INTO `subadmin2` VALUES (30867,'SL.02.2409983','Bombali District','Bombali District',1);
INSERT INTO `subadmin2` VALUES (30868,'SL.03.2404399','Pujehun District','Pujehun District',1);
INSERT INTO `subadmin2` VALUES (30869,'SL.03.2405008','Moyamba District','Moyamba District',1);
INSERT INTO `subadmin2` VALUES (30870,'SL.03.2409913','Bonthe District','Bonthe District',1);
INSERT INTO `subadmin2` VALUES (30871,'SL.03.2410021','Bo District','Bo District',1);
INSERT INTO `subadmin2` VALUES (30872,'SL.04.9179949','Western Area Urban','Western Area Urban',1);
INSERT INTO `subadmin2` VALUES (30873,'SL.04.9179950','Western Area Rural','Western Area Rural',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (2402816,'SL','Yengema','Yengema',-11.1706,8.71441,'P','PPL','01','',11221,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2403094,'SL','Waterloo','Waterloo',-13.0709,8.3389,'P','PPL','04','',19750,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2403324,'SL','Tombodu','Tombodu',-10.6196,8.13526,'P','PPL','01','',5985,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2403407,'SL','Tintafor','Tintafor',-13.215,8.62667,'P','PPL','02','',5460,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2403698,'SL','Sumbuya','Sumbuya',-11.9606,7.64789,'P','PPL','03','',7074,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2404041,'SL','Segbwema','Segbwema',-10.9502,7.99471,'P','PPL','01','',16532,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2404303,'SL','Rokupr','Rokupr',-12.385,8.67121,'P','PPL','02','',12504,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2404433,'SL','Port Loko','Port Loko',-12.787,8.76609,'P','PPL','02','',21308,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2404614,'SL','Pendembu','Pendembu',-10.6943,8.09807,'P','PPL','01','',8780,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2404663,'SL','Panguma','Panguma',-11.1329,8.18507,'P','PPL','01','',7965,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2405013,'SL','Moyamba','Moyamba',-12.4317,8.15898,'P','PPL','03','',6700,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2405038,'SL','Motema','Motema',-11.0125,8.61427,'P','PPL','01','',5474,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2405729,'SL','Masingbi','Masingbi',-11.9517,8.78197,'P','PPL','02','',5644,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2406142,'SL','Mamboma','Mamboma',-11.6884,8.08742,'P','PPL','03','',5201,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2406145,'SL','Mambolo','Mambolo',-13.0367,8.9186,'P','PPL','02','',6624,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2406407,'SL','Makeni','Makeni',-12.0442,8.88605,'P','PPLA','02','',87679,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2406576,'SL','Magburaka','Magburaka',-11.9488,8.72306,'P','PPL','02','',14915,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2406916,'SL','Lunsar','Lunsar',-12.535,8.68439,'P','PPL','02','',22461,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2407262,'SL','Kukuna','Kukuna',-12.6648,9.39841,'P','PPL','02','',7676,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2407656,'SL','Koidu','Koidu',-10.9714,8.64387,'P','PPL','01','',88000,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2407790,'SL','Kenema','Kenema',-11.1903,7.87687,'P','PPLA','01','',143137,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2407899,'SL','Kassiri','Kassiri',-13.1154,8.93814,'P','PPL','02','',5161,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2408088,'SL','Kambia','Kambia',-12.9182,9.12504,'P','PPL','02','',11520,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2408154,'SL','Kamakwie','Kamakwie',-12.2406,9.49689,'P','PPL','02','',8098,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2408250,'SL','Kailahun','Kailahun',-10.573,8.2789,'P','PPL','01','',14085,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2408329,'SL','Kabala','Kabala',-11.5526,9.58893,'P','PPL','02','',17948,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2408582,'SL','Hastings','Hastings',-13.1369,8.37994,'P','PPL','04','',5121,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2408585,'SL','Hangha','Hangha',-11.1413,7.93974,'P','PPL','01','',5007,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2408770,'SL','Freetown','Freetown',-13.2897,8.43194,'P','PPL','04','',13768,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2409214,'SL','Gandorhun','Gandorhun',-11.6926,7.55502,'P','PPL','03','',12288,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2409215,'SL','Gandorhun','Gandorhun',-11.8306,7.49431,'P','PPL','03','',10678,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2409306,'SL','Freetown','Freetown',-13.2299,8.484,'P','PPLC','04','',802639,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2409382,'SL','Foindu','Foindu',-11.5433,7.40906,'P','PPL','03','',5868,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2409663,'SL','Daru','Daru',-10.8422,7.98976,'P','PPL','01','',5958,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2409751,'SL','Buedu','Buedu',-10.3714,8.2796,'P','PPL','01','',5412,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2409783,'SL','Bunumbu','Bunumbu',-10.8643,8.17421,'P','PPL','01','',7355,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2409823,'SL','Bumpe','Bumpe',-11.9054,7.89209,'P','PPL','03','',13580,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2409914,'SL','Bonthe','Bonthe',-12.505,7.52639,'P','PPL','03','',9647,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2409970,'SL','Bomi','Bomi',-11.5258,7.24611,'P','PPL','03','',5463,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2410040,'SL','Boajibu','Boajibu',-11.3403,8.18763,'P','PPL','01','',7384,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2410048,'SL','Bo','Bo',-11.7383,7.96472,'P','PPLA','03','',174354,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2410065,'SL','Blama','Blama',-11.3455,7.87481,'P','PPL','01','',8146,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2410090,'SL','Binkolo','Binkolo',-11.9803,8.95225,'P','PPL','02','',13867,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2410312,'SL','Barma','Barma',-11.3306,8.34959,'P','PPL','01','',7529,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2410380,'SL','Baoma','Baoma',-11.7147,7.99344,'P','PPL','03','',7044,'Africa/Freetown',1,NULL,NULL);
INSERT INTO `cities` VALUES (2571039,'SL','Pujehun','Pujehun',-11.7208,7.35806,'P','PPL','03','',7926,'Africa/Freetown',1,NULL,NULL);
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
