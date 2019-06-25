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
INSERT INTO `subadmin1` VALUES (1043,'GP.GP','Guadeloupe','Guadeloupe',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (13075,'GP.GP.971','Guadeloupe','Guadeloupe',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (3578278,'GP','Vieux-Habitants','Vieux-Habitants',-61.7659,16.0589,'P','PPL','GP','971',7728,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3578324,'GP','Trois-Rivières','Trois-Rivieres',-61.6451,15.9757,'P','PPL','GP','971',8812,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3578441,'GP','Saint-François','Saint-Francois',-61.2741,16.2526,'P','PPL','GP','971',12732,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3578447,'GP','Sainte-Rose','Sainte-Rose',-61.6979,16.3324,'P','PPL','GP','971',20192,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3578466,'GP','Sainte-Anne','Sainte-Anne',-61.3792,16.2264,'P','PPL','GP','971',22859,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3578467,'GP','Saint-Claude','Saint-Claude',-61.7021,16.0241,'P','PPL','GP','971',10134,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3578575,'GP','Port-Louis','Port-Louis',-61.5313,16.419,'P','PPL','GP','971',5515,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3578594,'GP','Pointe-Noire','Pointe-Noire',-61.7878,16.2309,'P','PPL','GP','971',7749,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3578599,'GP','Pointe-à-Pitre','Pointe-a-Pitre',-61.5361,16.2412,'P','PPL','GP','971',18264,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3578681,'GP','Petit-Canal','Petit-Canal',-61.4879,16.3784,'P','PPL','GP','971',8554,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3578682,'GP','Petit-Bourg','Petit-Bourg',-61.5916,16.1914,'P','PPL','GP','971',24994,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3578959,'GP','Les Abymes','Les Abymes',-61.5045,16.271,'P','PPL','GP','971',63058,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3578967,'GP','Le Moule','Le Moule',-61.3473,16.3332,'P','PPL','GP','971',22692,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3578978,'GP','Le Gosier','Le Gosier',-61.4933,16.2069,'P','PPL','GP','971',28698,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3579023,'GP','Lamentin','Lamentin',-61.6312,16.271,'P','PPL','GP','971',14891,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3579250,'GP','Grand-Bourg','Grand-Bourg',-61.3148,15.8835,'P','PPL','GP','971',5867,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3579267,'GP','Gourbeyre','Gourbeyre',-61.6914,15.9938,'P','PPL','GP','971',8571,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3579585,'GP','Capesterre-Belle-Eau','Capesterre-Belle-Eau',-61.566,16.0432,'P','PPL','GP','971',19821,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3579642,'GP','Bouillante','Bouillante',-61.7692,16.1304,'P','PPL','GP','971',7540,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3579732,'GP','Basse-Terre','Basse-Terre',-61.7255,15.9985,'P','PPLC','GP','971',11472,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3579761,'GP','Baillif','Baillif',-61.7463,16.0202,'P','PPL','GP','971',5705,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3579767,'GP','Baie-Mahault','Baie-Mahault',-61.5854,16.2674,'P','PPL','GP','971',30551,'America/Guadeloupe',1,NULL,NULL);
INSERT INTO `cities` VALUES (3579789,'GP','Anse-Bertrand','Anse-Bertrand',-61.5078,16.4721,'P','PPL','GP','971',5146,'America/Guadeloupe',1,NULL,NULL);
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
