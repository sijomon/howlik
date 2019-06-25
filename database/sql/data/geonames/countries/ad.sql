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
INSERT INTO `subadmin1` VALUES (1,'AD.02','Canillo','Canillo',1);
INSERT INTO `subadmin1` VALUES (2,'AD.03','Encamp','Encamp',1);
INSERT INTO `subadmin1` VALUES (3,'AD.04','La Massana','La Massana',1);
INSERT INTO `subadmin1` VALUES (4,'AD.05','Ordino','Ordino',1);
INSERT INTO `subadmin1` VALUES (5,'AD.06','Sant Julià de Loria','Sant Julia de Loria',1);
INSERT INTO `subadmin1` VALUES (6,'AD.07','Andorra la Vella','Andorra la Vella',1);
INSERT INTO `subadmin1` VALUES (7,'AD.08','Escaldes-Engordany','Escaldes-Engordany',1);
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
INSERT INTO `cities` VALUES (3039163,'AD','Sant Julià de Lòria','Sant Julia de Loria',1.49129,42.4637,'P','PPLA','06','',8022,'Europe/Andorra',1,NULL,NULL);
INSERT INTO `cities` VALUES (3039678,'AD','Ordino','Ordino',1.53319,42.5562,'P','PPLA','05','',3066,'Europe/Andorra',1,NULL,NULL);
INSERT INTO `cities` VALUES (3040051,'AD','les Escaldes','les Escaldes',1.53414,42.5073,'P','PPLA','08','',15853,'Europe/Andorra',1,NULL,NULL);
INSERT INTO `cities` VALUES (3040132,'AD','la Massana','la Massana',1.51483,42.545,'P','PPLA','04','',7211,'Europe/Andorra',1,NULL,NULL);
INSERT INTO `cities` VALUES (3040686,'AD','Encamp','Encamp',1.58014,42.5347,'P','PPLA','03','',11223,'Europe/Andorra',1,NULL,NULL);
INSERT INTO `cities` VALUES (3041204,'AD','Canillo','Canillo',1.59756,42.5676,'P','PPLA','02','',3292,'Europe/Andorra',1,NULL,NULL);
INSERT INTO `cities` VALUES (3041563,'AD','Andorra la Vella','Andorra la Vella',1.52109,42.5078,'P','PPLC','07','',20430,'Europe/Andorra',1,NULL,NULL);
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
