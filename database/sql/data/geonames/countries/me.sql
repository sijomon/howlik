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
INSERT INTO `subadmin1` VALUES (1924,'ME.01','Andrijevica','Andrijevica',1);
INSERT INTO `subadmin1` VALUES (1925,'ME.02','Bar','Bar',1);
INSERT INTO `subadmin1` VALUES (1926,'ME.03','Berane','Berane',1);
INSERT INTO `subadmin1` VALUES (1927,'ME.04','Bijelo Polje','Bijelo Polje',1);
INSERT INTO `subadmin1` VALUES (1928,'ME.05','Budva','Budva',1);
INSERT INTO `subadmin1` VALUES (1929,'ME.06','Cetinje','Cetinje',1);
INSERT INTO `subadmin1` VALUES (1930,'ME.07','Danilovgrad','Danilovgrad',1);
INSERT INTO `subadmin1` VALUES (1931,'ME.08','Herceg Novi','Herceg Novi',1);
INSERT INTO `subadmin1` VALUES (1932,'ME.09','Opština Kolašin','Opstina Kolasin',1);
INSERT INTO `subadmin1` VALUES (1933,'ME.10','Kotor','Kotor',1);
INSERT INTO `subadmin1` VALUES (1934,'ME.11','Mojkovac','Mojkovac',1);
INSERT INTO `subadmin1` VALUES (1935,'ME.12','Opština Nikšić','Opstina Niksic',1);
INSERT INTO `subadmin1` VALUES (1936,'ME.13','Opština Plav','Opstina Plav',1);
INSERT INTO `subadmin1` VALUES (1937,'ME.14','Pljevlja','Pljevlja',1);
INSERT INTO `subadmin1` VALUES (1938,'ME.15','Opština Plužine','Opstina Pluzine',1);
INSERT INTO `subadmin1` VALUES (1939,'ME.16','Podgorica','Podgorica',1);
INSERT INTO `subadmin1` VALUES (1940,'ME.17','Opština Rožaje','Opstina Rozaje',1);
INSERT INTO `subadmin1` VALUES (1941,'ME.18','Opština Šavnik','Opstina Savnik',1);
INSERT INTO `subadmin1` VALUES (1942,'ME.19','Tivat','Tivat',1);
INSERT INTO `subadmin1` VALUES (1943,'ME.20','Ulcinj','Ulcinj',1);
INSERT INTO `subadmin1` VALUES (1944,'ME.21','Opština Žabljak','Opstina Zabljak',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (786234,'ME','Rožaje','Rozaje',20.1665,42.833,'P','PPLA','17','',9121,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3186999,'ME','Žabljak','Zabljak',19.1232,43.1542,'P','PPLA','21','',1937,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3188516,'ME','Ulcinj','Ulcinj',19.2244,41.9294,'P','PPLA','20','',10828,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3189073,'ME','Tivat','Tivat',18.6961,42.4364,'P','PPLA','19','',6280,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3191222,'ME','Šavnik','Savnik',19.0967,42.9564,'P','PPLA','18','',633,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3193044,'ME','Podgorica','Podgorica',19.2636,42.4411,'P','PPLC','16','',136473,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3193131,'ME','Plužine','Pluzine',18.8394,43.1528,'P','PPLA','15','',1494,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3193161,'ME','Pljevlja','Pljevlja',19.3584,43.3567,'P','PPLA','14','',19489,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3193228,'ME','Plav','Plav',19.9456,42.5969,'P','PPLA','13','',3615,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3194494,'ME','Nikšić','Niksic',18.9445,42.7731,'P','PPLA','12','',58212,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3194926,'ME','Mojkovac','Mojkovac',19.5833,42.9604,'P','PPLA','11','',4120,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3197538,'ME','Kotor','Kotor',18.7682,42.4207,'P','PPLA','10','',5345,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3197896,'ME','Kolašin','Kolasin',19.5165,42.8223,'P','PPLA','09','',2989,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3199071,'ME','Berane','Berane',19.8733,42.8425,'P','PPLA','03','',11073,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3199394,'ME','Herceg-Novi','Herceg-Novi',18.5375,42.4531,'P','PPLA','08','',19536,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3201903,'ME','Dobrota','Dobrota',18.7683,42.4542,'P','PPLL','00','',5435,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3202194,'ME','Danilovgrad','Danilovgrad',19.1461,42.5538,'P','PPLA','07','',5208,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3202641,'ME','Cetinje','Cetinje',18.9142,42.3906,'P','PPLA','06','',15137,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3203106,'ME','Budva','Budva',18.84,42.2864,'P','PPLA','05','',18000,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3204176,'ME','Bijelo Polje','Bijelo Polje',19.7476,43.0383,'P','PPLA','04','',15400,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3204509,'ME','Bar','Bar',19.1003,42.0931,'P','PPLA','02','',17727,'Europe/Podgorica',1,NULL,NULL);
INSERT INTO `cities` VALUES (3204816,'ME','Andrijevica','Andrijevica',19.7919,42.7339,'P','PPLA','01','',1073,'Europe/Podgorica',1,NULL,NULL);
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
