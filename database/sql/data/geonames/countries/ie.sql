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
INSERT INTO `subadmin1` VALUES (1246,'IE.C','Connaught','Connaught',1);
INSERT INTO `subadmin1` VALUES (1247,'IE.L','Leinster','Leinster',1);
INSERT INTO `subadmin1` VALUES (1248,'IE.M','Munster','Munster',1);
INSERT INTO `subadmin1` VALUES (1249,'IE.U','Ulster','Ulster',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (14642,'IE.C.10','County Galway','County Galway',1);
INSERT INTO `subadmin2` VALUES (14643,'IE.C.14','County Leitrim','County Leitrim',1);
INSERT INTO `subadmin2` VALUES (14644,'IE.C.20','Maigh Eo','Maigh Eo',1);
INSERT INTO `subadmin2` VALUES (14645,'IE.C.24','Roscommon','Roscommon',1);
INSERT INTO `subadmin2` VALUES (14646,'IE.C.25','Sligo','Sligo',1);
INSERT INTO `subadmin2` VALUES (14647,'IE.C.36','Galway City','Galway City',1);
INSERT INTO `subadmin2` VALUES (14648,'IE.L.01','County Carlow','County Carlow',1);
INSERT INTO `subadmin2` VALUES (14649,'IE.L.12','Kildare','Kildare',1);
INSERT INTO `subadmin2` VALUES (14650,'IE.L.13','Kilkenny','Kilkenny',1);
INSERT INTO `subadmin2` VALUES (14651,'IE.L.15','Laois','Laois',1);
INSERT INTO `subadmin2` VALUES (14652,'IE.L.18','An Longfort','An Longfort',1);
INSERT INTO `subadmin2` VALUES (14653,'IE.L.19','Lú','Lu',1);
INSERT INTO `subadmin2` VALUES (14654,'IE.L.21','An Mhí','An Mhi',1);
INSERT INTO `subadmin2` VALUES (14655,'IE.L.23','Uíbh Fhailí','Uibh Fhaili',1);
INSERT INTO `subadmin2` VALUES (14656,'IE.L.29','An Iarmhí','An Iarmhi',1);
INSERT INTO `subadmin2` VALUES (14657,'IE.L.30','Loch Garman','Loch Garman',1);
INSERT INTO `subadmin2` VALUES (14658,'IE.L.31','Wicklow','Wicklow',1);
INSERT INTO `subadmin2` VALUES (14659,'IE.L.33','Dublin City','Dublin City',1);
INSERT INTO `subadmin2` VALUES (14660,'IE.L.34','Dún Laoghaire-Rathdown','Dun Laoghaire-Rathdown',1);
INSERT INTO `subadmin2` VALUES (14661,'IE.L.35','Fingal County','Fingal County',1);
INSERT INTO `subadmin2` VALUES (14662,'IE.L.39','South Dublin','South Dublin',1);
INSERT INTO `subadmin2` VALUES (14663,'IE.M.03','An Clár','An Clar',1);
INSERT INTO `subadmin2` VALUES (14664,'IE.M.04','County Cork','County Cork',1);
INSERT INTO `subadmin2` VALUES (14665,'IE.M.11','Ciarraí','Ciarrai',1);
INSERT INTO `subadmin2` VALUES (14666,'IE.M.16','County Limerick','County Limerick',1);
INSERT INTO `subadmin2` VALUES (14667,'IE.M.26','County Tipperary','County Tipperary',1);
INSERT INTO `subadmin2` VALUES (14668,'IE.M.27','Waterford','Waterford',1);
INSERT INTO `subadmin2` VALUES (14669,'IE.M.32','Cork City','Cork City',1);
INSERT INTO `subadmin2` VALUES (14670,'IE.M.37','Limerick City','Limerick City',1);
INSERT INTO `subadmin2` VALUES (14671,'IE.M.41','Waterford City','Waterford City',1);
INSERT INTO `subadmin2` VALUES (14672,'IE.U.02','An Cabhán','An Cabhan',1);
INSERT INTO `subadmin2` VALUES (14673,'IE.U.06','County Donegal','County Donegal',1);
INSERT INTO `subadmin2` VALUES (14674,'IE.U.22','County Monaghan','County Monaghan',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (2654332,'IE','Buncrana','Buncrana',-7.45,55.1333,'P','PPL','U','06',5546,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960869,'IE','Youghal','Youghal',-7.85056,51.95,'P','PPL','M','04',6868,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960936,'IE','Wicklow','Wicklow',-6.04944,52.975,'P','PPLA2','L','31',14048,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960964,'IE','Loch Garman','Loch Garman',-6.4575,52.3342,'P','PPLA2','L','30',19913,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960970,'IE','Westport','Westport',-9.51667,53.8,'P','PPL','C','20',6200,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2960992,'IE','Waterford','Waterford',-7.11194,52.2583,'P','PPLA2','M','27',47904,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961086,'IE','Tullamore','Tullamore',-7.48889,53.2739,'P','PPLA2','L','23',11575,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961099,'IE','Tuam','Tuam',-8.85,53.5167,'P','PPL','C','10',6130,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961120,'IE','Trá Mhór','Tra Mhor',-7.15244,52.1623,'P','PPL','M','27',9164,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961123,'IE','Tralee','Tralee',-9.70264,52.2704,'P','PPLA2','M','11',22941,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961214,'IE','Thurles','Thurles',-7.80222,52.6819,'P','PPL','M','26',7588,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961235,'IE','Terenure','Terenure',-6.28528,53.3097,'P','PPL','L','39',7674,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961284,'IE','Tallaght','Tallaght',-6.37344,53.2859,'P','PPL','L','07',64282,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961297,'IE','Swords','Swords',-6.21806,53.4597,'P','PPLA','L','35',36924,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961423,'IE','Sligo','Sligo',-8.46943,54.2697,'P','PPLA2','C','25',20228,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961461,'IE','Skerries','Skerries',-6.10833,53.5828,'P','PPL','L','35',9671,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961523,'IE','Shankill','Shankill',-6.12444,53.2261,'P','PPL','L','07',10102,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961589,'IE','Sandymount','Sandymount',-6.21139,53.335,'P','PPL','L','07',8967,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961607,'IE','Sallins','Sallins',-6.66611,53.2489,'P','PPL','L','12',5283,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961651,'IE','An Ros','An Ros',-6.10497,53.5242,'P','PPL','L','07',9231,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961730,'IE','Roscrea','Roscrea',-7.80167,52.9511,'P','PPL','M','26',5403,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961732,'IE','Roscommon','Roscommon',-8.18333,53.6333,'P','PPLA2','C','24',5693,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961816,'IE','Ringsend','Ringsend',-6.22639,53.3419,'P','PPLX','L','07',8202,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961872,'IE','Ratoath','Ratoath',-6.4625,53.5081,'P','PPL','L','21',9043,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961896,'IE','Rathmines','Rathmines',-6.26333,53.3203,'P','PPLX','L','07',11044,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2961960,'IE','Raheny','Raheny',-6.18067,53.3868,'P','PPL','L','07',7197,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962019,'IE','Portmarnock','Portmarnock',-6.1375,53.4231,'P','PPL','L','07',9285,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962026,'IE','Portlaoise','Portlaoise',-7.29979,53.0344,'P','PPLA2','L','15',13622,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962029,'IE','Portarlington','Portarlington',-7.19111,53.1622,'P','PPL','L','15',7788,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962222,'IE','Newtown Trim','Newtown Trim',-6.77,53.5561,'P','PPLX','L','21',6781,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962252,'IE','New Ross','New Ross',-6.93667,52.3967,'P','PPL','L','30',6695,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962283,'IE','Newcastle West','Newcastle West',-9.06111,52.4492,'P','PPL','M','16',6327,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962290,'IE','Droichead Nua','Droichead Nua',-6.79667,53.1819,'P','PPL','L','12',18860,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962304,'IE','Nenagh','Nenagh',-8.19667,52.8619,'P','PPLA','M','26',5500,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962308,'IE','Navan','Navan',-6.68139,53.6528,'P','PPLA2','L','21',24545,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962334,'IE','Naas','Naas',-6.66694,53.2158,'P','PPLA2','L','12',20713,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962361,'IE','An Muileann gCearr','An Muileann gCearr',-7.35,53.5333,'P','PPLA2','L','29',17262,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962543,'IE','Monkstown','Monkstown',-6.15312,53.2931,'P','PPL','L','07',5555,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962568,'IE','Monaghan','Monaghan',-6.96667,54.25,'P','PPL','U','22',5937,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962630,'IE','Midleton','Midleton',-8.18052,51.9153,'P','PPL','M','04',8891,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962638,'IE','Mount Merrion','Mount Merrion',-6.21504,53.3001,'P','PPLX','L','07',7846,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962668,'IE','Maynooth','Maynooth',-6.59361,53.385,'P','PPL','L','12',12510,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962696,'IE','Marino','Marino',-6.23646,53.3702,'P','PPLX','L','07',11023,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962714,'IE','Mallow','Mallow',-8.63333,52.1333,'P','PPL','M','04',9495,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962725,'IE','Malahide','Malahide',-6.15444,53.4508,'P','PPL','L','07',15846,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962769,'IE','Lusk','Lusk',-6.16423,53.5274,'P','PPL','L','07',7022,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962785,'IE','Lucan','Lucan',-6.44859,53.3574,'P','PPL','L','07',15269,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962800,'IE','Loughrea','Loughrea',-8.56694,53.1969,'P','PPL','C','10',5062,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962840,'IE','Longford','Longford',-7.79823,53.7254,'P','PPLA2','L','18',7787,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962943,'IE','Luimneach','Luimneach',-8.62306,52.6647,'P','PPLA2','M','16',90054,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962961,'IE','Letterkenny','Letterkenny',-7.73333,54.95,'P','PPL','U','06',16901,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2962974,'IE','Leixlip','Leixlip',-6.49556,53.3658,'P','PPL','L','12',15452,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2963007,'IE','Laytown','Laytown',-6.23917,53.6819,'P','PPL','L','21',10889,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2963370,'IE','Cill Airne','Cill Airne',-9.51667,52.05,'P','PPL','M','11',7300,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2963398,'IE','Kilkenny','Kilkenny',-7.25222,52.6542,'P','PPLA2','L','13',21589,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2963436,'IE','Kildare','Kildare',-6.91444,53.1561,'P','PPL','L','12',8142,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2963472,'IE','Kilcock','Kilcock',-6.67083,53.4022,'P','PPL','L','12',5533,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2963848,'IE','Greystones','Greystones',-6.06306,53.1408,'P','PPL','L','31',13492,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2963962,'IE','Gorey','Gorey',-6.2925,52.6747,'P','PPL','L','30',6040,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964180,'IE','Gaillimh','Gaillimh',-9.04889,53.2719,'P','PPLA','C','10',70686,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964303,'IE','Finglas','Finglas',-6.29694,53.3892,'P','PPL','L','33',19768,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964403,'IE','Enniscorthy','Enniscorthy',-6.55778,52.5008,'P','PPL','L','30',9709,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964405,'IE','Ennis','Ennis',-8.98639,52.8436,'P','PPLA2','M','03',24427,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964506,'IE','Dún Laoghaire','Dun Laoghaire',-6.13586,53.2939,'P','PPL','L','34',185400,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964528,'IE','Dungarvan','Dungarvan',-7.62528,52.0881,'P','PPL','M','27',7551,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964532,'IE','Dundrum','Dundrum',-6.25714,53.2907,'P','PPL','L','07',12152,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964540,'IE','Dundalk','Dundalk',-6.41667,54,'P','PPLA2','L','19',33428,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964547,'IE','Dunboyne','Dunboyne',-6.46667,53.4,'P','PPL','L','21',6959,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964574,'IE','Dublin','Dublin',-6.24889,53.3331,'P','PPLC','L','33',1024027,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964661,'IE','Drogheda','Drogheda',-6.34778,53.7189,'P','PPL','L','19',33441,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964745,'IE','Donnybrook','Donnybrook',-6.22274,53.3138,'P','PPL','L','07',10645,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964765,'IE','Donabate','Donabate',-6.15194,53.4872,'P','PPL','L','07',6778,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964767,'IE','Dollymount','Dollymount',-6.18032,53.3649,'P','PPL','L','07',5070,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964820,'IE','Derry','Derry',-9.05026,51.5867,'P','PPL','M','04',10000,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964892,'IE','Dalkey','Dalkey',-6.10028,53.2783,'P','PPL','L','07',6622,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2964963,'IE','Crumlin','Crumlin',-6.32861,53.3242,'P','PPL','L','07',11294,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965140,'IE','Cork','Cork',-8.47061,51.898,'P','PPLA2','M','04',190384,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965260,'IE','Cobh','Cobh',-8.29917,51.8572,'P','PPL','M','04',10501,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965353,'IE','Cluain Meala','Cluain Meala',-7.70389,52.355,'P','PPLA2','M','26',17394,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965381,'IE','Clondalkin','Clondalkin',-6.39722,53.3244,'P','PPL','L','07',14508,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965484,'IE','Clane','Clane',-6.68917,53.2914,'P','PPL','L','12',6702,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965509,'IE','Cherryville','Cherryville',-6.96667,53.1569,'P','PPL','L','12',6380,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965525,'IE','Chapelizod','Chapelizod',-6.34667,53.3489,'P','PPL','L','07',5296,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965529,'IE','Celbridge','Celbridge',-6.54361,53.3386,'P','PPL','L','12',19537,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965535,'IE','Cavan','Cavan',-7.36056,53.9908,'P','PPLA2','U','02',6388,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965599,'IE','Castleknock','Castleknock',-6.36336,53.3748,'P','PPL','L','07',8301,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965654,'IE','Castlebar','Castlebar',-9.3,53.85,'P','PPLA2','C','20',12874,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965715,'IE','Carrigaline','Carrigaline',-8.39861,51.8117,'P','PPL','M','04',14775,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965726,'IE','Carrick-on-Suir','Carrick-on-Suir',-7.41306,52.3492,'P','PPL','M','26',5710,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965768,'IE','Carlow','Carlow',-6.92611,52.8408,'P','PPLA2','L','01',20055,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2965882,'IE','Cabinteely','Cabinteely',-6.16058,53.2697,'P','PPL','L','07',10038,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966022,'IE','Bray','Bray',-6.09833,53.2028,'P','PPL','L','31',6477,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966101,'IE','Blessington','Blessington',-6.5325,53.17,'P','PPL','L','31',5010,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966110,'IE','Blanchardstown','Blanchardstown',-6.37556,53.3881,'P','PPL','L','35',16511,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966131,'IE','Blackrock','Blackrock',-6.1778,53.3015,'P','PPL','L','07',8821,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966370,'IE','Bandon','Bandon',-8.7425,51.7469,'P','PPL','M','04',5492,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966670,'IE','Ballyboden','Ballyboden',-6.31639,53.2806,'P','PPL','L','07',9611,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966753,'IE','Ballinasloe','Ballinasloe',-8.21944,53.3275,'P','PPL','C','10',6388,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966778,'IE','Ballina','Ballina',-9.16667,54.1167,'P','PPL','C','20',10087,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966793,'IE','Baldoyle','Baldoyle',-6.12583,53.3997,'P','PPL','L','35',8043,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966794,'IE','Balbriggan','Balbriggan',-6.18194,53.6128,'P','PPL','L','07',23364,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966837,'IE','Athy','Athy',-6.98028,52.9914,'P','PPL','L','12',12855,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966839,'IE','Athlone','Athlone',-7.95,53.4333,'P','PPL','L','29',15951,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966870,'IE','Ashbourne','Ashbourne',-6.39821,53.5116,'P','PPL','L','21',11355,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (2966883,'IE','Arklow','Arklow',-6.14139,52.7931,'P','PPL','L','31',11761,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3306439,'IE','Nenagh Bridge','Nenagh Bridge',-8.19583,52.8817,'P','PPL','M','26',6672,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3310247,'IE','Shannon','Shannon',-8.86417,52.7039,'P','PPL','M','03',9673,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315200,'IE','Eadestown','Eadestown',-6.57806,53.2028,'P','PPL','L','12',5346,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315204,'IE','Little Bray','Little Bray',-6.12083,53.2044,'P','PPL','L','07',8015,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315276,'IE','Firhouse','Firhouse',-6.33917,53.2817,'P','PPL','L','07',6859,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315278,'IE','Sandyford','Sandyford',-6.2253,53.2747,'P','PPL','L','07',22288,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315280,'IE','Foxrock','Foxrock',-6.17417,53.2667,'P','PPL','L','07',12870,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315282,'IE','Sallynoggin','Sallynoggin',-6.14058,53.2792,'P','PPL','L','07',6916,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315287,'IE','Rathgar','Rathgar',-6.275,53.3146,'P','PPL','L','07',8394,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315304,'IE','Artane','Artane',-6.2138,53.3871,'P','PPL','L','07',5328,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315311,'IE','Beaumont','Beaumont',-6.24056,53.3914,'P','PPL','L','07',8609,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315315,'IE','Ballymun','Ballymun',-6.26693,53.3981,'P','PPL','L','07',6262,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315332,'IE','Hartstown','Hartstown',-6.42694,53.3931,'P','PPL','L','07',5882,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315378,'IE','Ballyfermot','Ballyfermot',-6.35889,53.3453,'P','PPL','L','07',8558,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315404,'IE','Templeogue','Templeogue',-6.30889,53.2953,'P','PPLX','L','07',7023,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (3315430,'IE','Oldbawn','Oldbawn',-6.3675,53.2756,'P','PPL','L','07',9784,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (6619871,'IE','Cherry Orchard','Cherry Orchard',-6.37799,53.336,'P','PPLX','','',7924,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (6691006,'IE','Booterstown','Booterstown',-6.19985,53.3045,'P','PPLX','','',7142,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (6691010,'IE','Ballinteer','Ballinteer',-6.25397,53.2741,'P','PPLX','L','',8547,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (6691017,'IE','Greenhills','Greenhills',-6.30302,53.3347,'P','PPLX','','',6876,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (6691033,'IE','Donaghmede','Donaghmede',-6.16179,53.3984,'P','PPLX','L','',15299,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (6691035,'IE','Darndale','Darndale',-6.18886,53.3995,'P','PPLX','','',5667,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (6691048,'IE','Donnycarney','Donnycarney',-6.20976,53.3735,'P','PPLX','','',7660,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (7838921,'IE','Knocklyon','Knocklyon',-6.3313,53.2803,'P','PPL','','',14628,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (7838923,'IE','Palmerstown','Palmerstown',-6.37778,53.3502,'P','PPL','','',7197,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (7869995,'IE','Jobstown','Jobstown',-6.40803,53.2787,'P','PPL','','',10825,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (7869996,'IE','Killester','Killester',-6.20431,53.3732,'P','PPL','','',5099,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (7870938,'IE','Confey','Confey',-6.49052,53.3792,'P','PPL','','',5389,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (7870988,'IE','Kilquade','Kilquade',-6.08411,53.0974,'P','PPL','','',14886,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (8642910,'IE','Balally','Balally',-6.23594,53.275,'P','PPL','L','',9051,'Europe/Dublin',1,NULL,NULL);
INSERT INTO `cities` VALUES (8658946,'IE','Kinsealy-Drinan','Kinsealy-Drinan',-6.20334,53.444,'P','PPL','L','',5814,'Europe/Dublin',1,NULL,NULL);
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
