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
INSERT INTO `subadmin1` VALUES (2328,'NC.01','North Province','North Province',1);
INSERT INTO `subadmin1` VALUES (2329,'NC.02','South Province','South Province',1);
INSERT INTO `subadmin1` VALUES (2330,'NC.03','Loyalty Islands','Loyalty Islands',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (22212,'NC.01.98801','Bélep','Belep',1);
INSERT INTO `subadmin2` VALUES (22213,'NC.01.98804','Canala','Canala',1);
INSERT INTO `subadmin2` VALUES (22214,'NC.01.98807','Hienghéne','Hienghene',1);
INSERT INTO `subadmin2` VALUES (22215,'NC.01.98808','Houaïlou','Houailou',1);
INSERT INTO `subadmin2` VALUES (22216,'NC.01.98810','Kaala-Gomén','Kaala-Gomen',1);
INSERT INTO `subadmin2` VALUES (22217,'NC.01.98811','Koné','Kone',1);
INSERT INTO `subadmin2` VALUES (22218,'NC.01.98812','Koumac','Koumac',1);
INSERT INTO `subadmin2` VALUES (22219,'NC.01.98819','Ouégoa','Ouegoa',1);
INSERT INTO `subadmin2` VALUES (22220,'NC.01.98822','Poindimié','Poindimie',1);
INSERT INTO `subadmin2` VALUES (22221,'NC.01.98823','Ponérihouen','Ponerihouen',1);
INSERT INTO `subadmin2` VALUES (22222,'NC.01.98824','Pouébo','Pouebo',1);
INSERT INTO `subadmin2` VALUES (22223,'NC.01.98825','Pouembout','Pouembout',1);
INSERT INTO `subadmin2` VALUES (22224,'NC.01.98826','Poum','Poum',1);
INSERT INTO `subadmin2` VALUES (22225,'NC.01.98827','Poya','Poya',1);
INSERT INTO `subadmin2` VALUES (22226,'NC.01.98830','Touho','Touho',1);
INSERT INTO `subadmin2` VALUES (22227,'NC.01.98831','Voh','Voh',1);
INSERT INTO `subadmin2` VALUES (22228,'NC.01.98833','Kouaoua','Kouaoua',1);
INSERT INTO `subadmin2` VALUES (22229,'NC.02.98802','Bouloupari','Bouloupari',1);
INSERT INTO `subadmin2` VALUES (22230,'NC.02.98803','Bourail','Bourail',1);
INSERT INTO `subadmin2` VALUES (22231,'NC.02.98805','Dumbéa','Dumbea',1);
INSERT INTO `subadmin2` VALUES (22232,'NC.02.98806','Farino','Farino',1);
INSERT INTO `subadmin2` VALUES (22233,'NC.02.98809','L’Île des Pins','L\'Ile des Pins',1);
INSERT INTO `subadmin2` VALUES (22234,'NC.02.98813','La Foa','La Foa',1);
INSERT INTO `subadmin2` VALUES (22235,'NC.02.98816','Moindou','Moindou',1);
INSERT INTO `subadmin2` VALUES (22236,'NC.02.98817','Le Mont-Dore','Le Mont-Dore',1);
INSERT INTO `subadmin2` VALUES (22237,'NC.02.98818','Nouméa','Noumea',1);
INSERT INTO `subadmin2` VALUES (22238,'NC.02.98821','Païta','Paita',1);
INSERT INTO `subadmin2` VALUES (22239,'NC.02.98828','Sarraméa','Sarramea',1);
INSERT INTO `subadmin2` VALUES (22240,'NC.02.98829','Thio','Thio',1);
INSERT INTO `subadmin2` VALUES (22241,'NC.02.98832','Yaté','Yate',1);
INSERT INTO `subadmin2` VALUES (22242,'NC.03.98814','Lifou','Lifou',1);
INSERT INTO `subadmin2` VALUES (22243,'NC.03.98815','Maré','Mare',1);
INSERT INTO `subadmin2` VALUES (22244,'NC.03.98820','Ouvéa','Ouvea',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (2137690,'NC','Wé','We',167.265,-20.9169,'P','PPLA','03','98814',10375,'Pacific/Noumea',1,NULL,NULL);
INSERT INTO `cities` VALUES (2138285,'NC','Tadine','Tadine',167.883,-21.55,'P','PPL','03','98815',7492,'Pacific/Noumea',1,NULL,NULL);
INSERT INTO `cities` VALUES (2138981,'NC','Païta','Paita',166.367,-22.1333,'P','PPL','02','98821',12617,'Pacific/Noumea',1,NULL,NULL);
INSERT INTO `cities` VALUES (2139521,'NC','Nouméa','Noumea',166.457,-22.2763,'P','PPLC','02','98818',93060,'Pacific/Noumea',1,NULL,NULL);
INSERT INTO `cities` VALUES (2140066,'NC','Mont-Dore','Mont-Dore',166.566,-22.2626,'P','PPL','02','98817',24680,'Pacific/Noumea',1,NULL,NULL);
INSERT INTO `cities` VALUES (2140466,'NC','La Foa','La Foa',165.828,-21.7108,'P','PPLA','02','98813',2947,'Pacific/Noumea',1,NULL,NULL);
INSERT INTO `cities` VALUES (2140691,'NC','Koné','Kone',164.866,-21.0595,'P','PPLA','01','98811',4572,'Pacific/Noumea',1,NULL,NULL);
INSERT INTO `cities` VALUES (2141394,'NC','Dumbéa','Dumbea',166.45,-22.15,'P','PPL','02','98805',19346,'Pacific/Noumea',1,NULL,NULL);
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
