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
INSERT INTO `subadmin1` VALUES (975,'GA.01','Estuaire','Estuaire',1);
INSERT INTO `subadmin1` VALUES (976,'GA.02','Haut-Ogooué','Haut-Ogooue',1);
INSERT INTO `subadmin1` VALUES (977,'GA.03','Moyen-Ogooué','Moyen-Ogooue',1);
INSERT INTO `subadmin1` VALUES (978,'GA.04','Ngounié','Ngounie',1);
INSERT INTO `subadmin1` VALUES (979,'GA.05','Nyanga','Nyanga',1);
INSERT INTO `subadmin1` VALUES (980,'GA.06','Ogooué-Ivindo','Ogooue-Ivindo',1);
INSERT INTO `subadmin1` VALUES (981,'GA.07','Ogooué-Lolo','Ogooue-Lolo',1);
INSERT INTO `subadmin1` VALUES (982,'GA.08','Ogooué-Maritime','Ogooue-Maritime',1);
INSERT INTO `subadmin1` VALUES (983,'GA.09','Woleu-Ntem','Woleu-Ntem',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (12680,'GA.01.7870458','Komo Mondah District','Komo Mondah District',1);
INSERT INTO `subadmin2` VALUES (12681,'GA.01.8260630','Commune of Libreville','Commune of Libreville',1);
INSERT INTO `subadmin2` VALUES (12682,'GA.01.8260631','Komo-Mondah Department','Komo-Mondah Department',1);
INSERT INTO `subadmin2` VALUES (12683,'GA.01.8260632','Komo Department','Komo Department',1);
INSERT INTO `subadmin2` VALUES (12684,'GA.02.7870333','Plateaux Department','Plateaux Department',1);
INSERT INTO `subadmin2` VALUES (12685,'GA.02.7870395','Mpassa Department','Mpassa Department',1);
INSERT INTO `subadmin2` VALUES (12686,'GA.02.7870474','Passa','Passa',1);
INSERT INTO `subadmin2` VALUES (12687,'GA.02.8260627','Leboumbi-Leyou Department','Leboumbi-Leyou Department',1);
INSERT INTO `subadmin2` VALUES (12688,'GA.02.8260634','Lekoko Department','Lekoko Department',1);
INSERT INTO `subadmin2` VALUES (12689,'GA.03.7870425','Abanga-Bigné Department','Abanga-Bigne Department',1);
INSERT INTO `subadmin2` VALUES (12690,'GA.03.7870459','Ogooue et Lacs District','Ogooue et Lacs District',1);
INSERT INTO `subadmin2` VALUES (12691,'GA.04.7870328','Douya-Onoye Department','Douya-Onoye Department',1);
INSERT INTO `subadmin2` VALUES (12692,'GA.04.7870330','Ndolou Department','Ndolou Department',1);
INSERT INTO `subadmin2` VALUES (12693,'GA.04.7870428','Ogoulou Department','Ogoulou Department',1);
INSERT INTO `subadmin2` VALUES (12694,'GA.04.8260610','Tsamba-Magotsi Department','Tsamba-Magotsi Department',1);
INSERT INTO `subadmin2` VALUES (12695,'GA.04.8260628','Dola Department','Dola Department',1);
INSERT INTO `subadmin2` VALUES (12696,'GA.04.8260629','Louetsi-Wano Department','Louetsi-Wano Department',1);
INSERT INTO `subadmin2` VALUES (12697,'GA.05.7870325','Basse-Banio Department','Basse-Banio Department',1);
INSERT INTO `subadmin2` VALUES (12698,'GA.05.7870326','Mougoutsi Department','Mougoutsi Department',1);
INSERT INTO `subadmin2` VALUES (12699,'GA.05.7870411','Haute-Banio Department','Haute-Banio Department',1);
INSERT INTO `subadmin2` VALUES (12700,'GA.06.7870426','Lope Department','Lope Department',1);
INSERT INTO `subadmin2` VALUES (12701,'GA.07.7870427','Lolo Bouenguidi Department','Lolo Bouenguidi Department',1);
INSERT INTO `subadmin2` VALUES (12702,'GA.07.8260626','Mouloundou Department','Mouloundou Department',1);
INSERT INTO `subadmin2` VALUES (12703,'GA.08.7870327','Ndougou Department','Ndougou Department',1);
INSERT INTO `subadmin2` VALUES (12704,'GA.08.7870331','Étimboué Department','Etimboue Department',1);
INSERT INTO `subadmin2` VALUES (12705,'GA.08.7870461','Bendje District','Bendje District',1);
INSERT INTO `subadmin2` VALUES (12706,'GA.08.8224678','Bendje','Bendje',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (2396253,'GA','Tchibanga','Tchibanga',10.9818,-2.93323,'P','PPLA','05','7870326',19365,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2396518,'GA','Port-Gentil','Port-Gentil',8.78151,-0.71933,'P','PPLA','08','',109163,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2396646,'GA','Oyem','Oyem',11.5793,1.5995,'P','PPLA','09','',30870,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2396898,'GA','Okondja','Okondja',13.6753,-0.65487,'P','PPL','02','',7155,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2397169,'GA','Ntoum','Ntoum',9.76096,0.39051,'P','PPL','01','',8569,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2397614,'GA','Ndendé','Ndende',11.3581,-2.40077,'P','PPL','04','',6200,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2397674,'GA','Ndjolé','Ndjole',10.7649,-0.17827,'P','PPL','03','',5098,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2397978,'GA','Mounana','Mounana',13.1586,-1.4085,'P','PPL','02','',8780,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2398073,'GA','Mouila','Mouila',11.0559,-1.86846,'P','PPLA','04','',22469,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2398269,'GA','Moanda','Moanda',13.1987,-1.56652,'P','PPL','02','',30151,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2399371,'GA','Makokou','Makokou',12.8642,0.57381,'P','PPLA','06','',13571,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2399697,'GA','Libreville','Libreville',9.45356,0.39241,'P','PPLC','01','',578156,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2399870,'GA','Lastoursville','Lastoursville',12.7082,-0.81742,'P','PPL','07','',8340,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2399888,'GA','Lambaréné','Lambarene',10.2406,-0.7001,'P','PPLA','03','',20714,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2399959,'GA','Koulamoutou','Koulamoutou',12.4736,-1.13032,'P','PPLA','07','',16222,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2400547,'GA','Gamba','Gamba',10,-2.65,'P','PPL','08','',9928,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2400555,'GA','Franceville','Franceville',13.5836,-1.63333,'P','PPLA','02','',42967,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2400578,'GA','Fougamou','Fougamou',10.5838,-1.21544,'P','PPL','04','',5649,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2401495,'GA','Booué','Booue',11.9385,-0.09207,'P','PPL','06','',5787,'Africa/Libreville',1,NULL,NULL);
INSERT INTO `cities` VALUES (2401578,'GA','Bitam','Bitam',11.5007,2.07597,'P','PPL','09','',10297,'Africa/Libreville',1,NULL,NULL);
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
