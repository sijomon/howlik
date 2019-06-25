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
INSERT INTO `subadmin1` VALUES (1087,'GU.AH','Agana Heights','Agana Heights',1);
INSERT INTO `subadmin1` VALUES (1088,'GU.AN','Hagatna','Hagatna',1);
INSERT INTO `subadmin1` VALUES (1089,'GU.AS','Asan','Asan',1);
INSERT INTO `subadmin1` VALUES (1090,'GU.AT','Agat','Agat',1);
INSERT INTO `subadmin1` VALUES (1091,'GU.BA','Barrigada','Barrigada',1);
INSERT INTO `subadmin1` VALUES (1092,'GU.CP','Chalan Pago-Ordot','Chalan Pago-Ordot',1);
INSERT INTO `subadmin1` VALUES (1093,'GU.DD','Dededo','Dededo',1);
INSERT INTO `subadmin1` VALUES (1094,'GU.IN','Inarajan','Inarajan',1);
INSERT INTO `subadmin1` VALUES (1095,'GU.MA','Mangilao','Mangilao',1);
INSERT INTO `subadmin1` VALUES (1096,'GU.ME','Merizo','Merizo',1);
INSERT INTO `subadmin1` VALUES (1097,'GU.MT','Mongmong-Toto-Maite','Mongmong-Toto-Maite',1);
INSERT INTO `subadmin1` VALUES (1098,'GU.PI','Piti','Piti',1);
INSERT INTO `subadmin1` VALUES (1099,'GU.SJ','Sinajana','Sinajana',1);
INSERT INTO `subadmin1` VALUES (1100,'GU.SR','Santa Rita','Santa Rita',1);
INSERT INTO `subadmin1` VALUES (1101,'GU.TF','Talofofo','Talofofo',1);
INSERT INTO `subadmin1` VALUES (1102,'GU.TM','Tamuning','Tamuning',1);
INSERT INTO `subadmin1` VALUES (1103,'GU.UM','Umatac','Umatac',1);
INSERT INTO `subadmin1` VALUES (1104,'GU.YG','Yigo','Yigo',1);
INSERT INTO `subadmin1` VALUES (1105,'GU.YN','Yona','Yona',1);
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
INSERT INTO `cities` VALUES (4038473,'GU','Piti Village','Piti Village',144.693,13.4626,'P','PPLA','PI','',1666,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4038554,'GU','Santa Rita Village','Santa Rita Village',144.672,13.3861,'P','PPLA','SR','',7500,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4038588,'GU','Sinajana Village','Sinajana Village',144.754,13.4633,'P','PPLA','SJ','',2853,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4038647,'GU','Talofofo Village','Talofofo Village',144.758,13.3551,'P','PPLA','TF','',3215,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4038659,'GU','Tamuning-Tumon-Harmon Village','Tamuning-Tumon-Harmon Village',144.781,13.4877,'P','PPLA','TM','',19685,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4038733,'GU','Umatac Village','Umatac Village',144.661,13.2976,'P','PPLA','UM','',903,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4038794,'GU','Yigo Village','Yigo Village',144.889,13.536,'P','PPLA','YG','',20539,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4038809,'GU','Yona Village','Yona Village',144.777,13.4097,'P','PPLA','YN','',6484,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4043399,'GU','Merizo Village','Merizo Village',144.669,13.2658,'P','PPLA','ME','',2152,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4043499,'GU','Inarajan Village','Inarajan Village',144.748,13.2736,'P','PPLA','IN','',3052,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4043525,'GU','Agana Heights Village','Agana Heights Village',144.748,13.4656,'P','PPLA','AH','',3940,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4043547,'GU','Guam Government House','Guam Government House',144.75,13.4719,'P','PPLG','AN','',0,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4043615,'GU','Chalan Pago-Ordot Village','Chalan Pago-Ordot Village',144.759,13.4474,'P','PPLA','CP','',6822,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4043656,'GU','Barrigada Village','Barrigada Village',144.799,13.4691,'P','PPLA','BA','',8875,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4043804,'GU','Agat Village','Agat Village',144.659,13.3885,'P','PPLA','AT','',5656,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4043812,'GU','Asan-Maina Village','Asan-Maina Village',144.717,13.4721,'P','PPLA','AS','',2137,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4043909,'GU','Dededo Village','Dededo Village',144.839,13.5178,'P','PPLA','DD','',44943,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (4044012,'GU','Hagåtña','Hagatna',144.749,13.4757,'P','PPLC','AN','',1051,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (7268049,'GU','Mangilao Village','Mangilao Village',144.801,13.4476,'P','PPLA','MA','',15191,'Pacific/Guam',1,NULL,NULL);
INSERT INTO `cities` VALUES (7873866,'GU','Mongmong-Toto-Maite Village','Mongmong-Toto-Maite Village',144.782,13.4686,'P','PPLA','MT','',6825,'Pacific/Guam',1,NULL,NULL);
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
