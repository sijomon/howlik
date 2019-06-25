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
INSERT INTO `subadmin1` VALUES (2763,'RS.SE','Central Serbia','Central Serbia',1);
INSERT INTO `subadmin1` VALUES (2764,'RS.VO','Vojvodina','Vojvodina',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (29493,'RS.SE.0','Belgrade','Belgrade',1);
INSERT INTO `subadmin2` VALUES (29494,'RS.SE.10','Podunavski Okrug','Podunavski Okrug',1);
INSERT INTO `subadmin2` VALUES (29495,'RS.SE.11','Braničevski Okrug','Branicevski Okrug',1);
INSERT INTO `subadmin2` VALUES (29496,'RS.SE.12','Šumadijski Okrug','Sumadijski Okrug',1);
INSERT INTO `subadmin2` VALUES (29497,'RS.SE.13','Pomoravski Okrug','Pomoravski Okrug',1);
INSERT INTO `subadmin2` VALUES (29498,'RS.SE.14','Borski Okrug','Borski Okrug',1);
INSERT INTO `subadmin2` VALUES (29499,'RS.SE.15','Zaječarski Okrug','Zajecarski Okrug',1);
INSERT INTO `subadmin2` VALUES (29500,'RS.SE.16','Zlatiborski Okrug','Zlatiborski Okrug',1);
INSERT INTO `subadmin2` VALUES (29501,'RS.SE.17','Moravički Okrug','Moravicki Okrug',1);
INSERT INTO `subadmin2` VALUES (29502,'RS.SE.18','Raški Okrug','Raski Okrug',1);
INSERT INTO `subadmin2` VALUES (29503,'RS.SE.19','Rasinski Okrug','Rasinski Okrug',1);
INSERT INTO `subadmin2` VALUES (29504,'RS.SE.20','Nišavski Okrug','Nisavski Okrug',1);
INSERT INTO `subadmin2` VALUES (29505,'RS.SE.21','Toplički Okrug','Toplicki Okrug',1);
INSERT INTO `subadmin2` VALUES (29506,'RS.SE.22','Pirotski Okrug','Pirotski Okrug',1);
INSERT INTO `subadmin2` VALUES (29507,'RS.SE.23','Jablanički Okrug','Jablanicki Okrug',1);
INSERT INTO `subadmin2` VALUES (29508,'RS.SE.24','Pčinjski Okrug','Pcinjski Okrug',1);
INSERT INTO `subadmin2` VALUES (29509,'RS.SE.8','Mačvanski Okrug','Macvanski Okrug',1);
INSERT INTO `subadmin2` VALUES (29510,'RS.SE.9','Kolubarski Okrug','Kolubarski Okrug',1);
INSERT INTO `subadmin2` VALUES (29511,'RS.VO.1','Severnobački Okrug','Severnobacki Okrug',1);
INSERT INTO `subadmin2` VALUES (29512,'RS.VO.2','Srednjebanatski Okrug','Srednjebanatski Okrug',1);
INSERT INTO `subadmin2` VALUES (29513,'RS.VO.3','Severnobanatski Okrug','Severnobanatski Okrug',1);
INSERT INTO `subadmin2` VALUES (29514,'RS.VO.4','Južnobanatski Okrug','Juznobanatski Okrug',1);
INSERT INTO `subadmin2` VALUES (29515,'RS.VO.5','Zapadnobački Okrug','Zapadnobacki Okrug',1);
INSERT INTO `subadmin2` VALUES (29516,'RS.VO.6','Južnobački Okrug','Juznobacki Okrug',1);
INSERT INTO `subadmin2` VALUES (29517,'RS.VO.7','Sremski Okrug','Sremski Okrug',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (783768,'RS','Zvečka','Zvecka',20.1643,44.6403,'P','PPL','00','',5321,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (783814,'RS','Zrenjanin','Zrenjanin',20.3819,45.3836,'P','PPLA2','VO','2',79773,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (783920,'RS','Zemun','Zemun',20.4011,44.8431,'P','PPLA3','SE','0',155591,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (784024,'RS','Zaječar','Zajecar',22.264,43.9036,'P','PPLA2','SE','15',49800,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (784068,'RS','Žabalj','Zabalj',20.0639,45.3722,'P','PPLA3','VO','6',8503,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (784136,'RS','Vršac','Vrsac',21.3036,45.1167,'P','PPLA3','VO','4',36300,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (784141,'RS','Vrnjačka Banja','Vrnjacka Banja',20.8963,43.6273,'P','PPLA3','SE','18',10207,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (784227,'RS','Vranje','Vranje',21.9003,42.5514,'P','PPLA2','SE','24',56199,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (784352,'RS','Vladimirovac','Vladimirovac',20.8657,45.0312,'P','PPL','00','',5106,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (784764,'RS','Umka','Umka',20.3047,44.6781,'P','PPL','00','',5618,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (784873,'RS','Trstenik','Trstenik',21.0025,43.6169,'P','PPLA3','SE','19',49043,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (785062,'RS','Titel','Titel',20.2944,45.2061,'P','PPLA3','VO','6',6227,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (785288,'RS','Surčin','Surcin',20.2803,44.7931,'P','PPLA3','SE','0',12575,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (785559,'RS','Stara Pazova','Stara Pazova',20.1608,44.985,'P','PPLA3','VO','7',16217,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (785603,'RS','Srpska Crnja','Srpska Crnja',20.6901,45.7254,'P','PPL','00','',5467,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (785615,'RS','Sremčica','Sremcica',20.3923,44.6765,'P','PPL','SE','',23000,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (785753,'RS','Smederevska Palanka','Smederevska Palanka',20.9589,44.3655,'P','PPLA3','SE','10',27000,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (785756,'RS','Smederevo','Smederevo',20.93,44.6628,'P','PPLA2','SE','10',62000,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (785965,'RS','Senta','Senta',20.0772,45.9275,'P','PPLA3','VO','3',20302,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (786690,'RS','Prokuplje','Prokuplje',21.5881,43.2342,'P','PPLA2','SE','21',27673,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (786827,'RS','Požarevac','Pozarevac',21.1878,44.6213,'P','PPLA2','SE','11',41736,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (787050,'RS','Pirot','Pirot',22.5861,43.1531,'P','PPLA2','SE','22',40678,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (787215,'RS','Paraćin','Paracin',21.4078,43.8608,'P','PPLA3','SE','13',6000,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (787237,'RS','Pančevo','Pancevo',20.6403,44.8708,'P','PPLA2','VO','4',76654,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (787271,'RS','Padina','Padina',20.7286,45.1199,'P','PPL','00','',6367,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (787516,'RS','Obrenovac','Obrenovac',20.2002,44.6549,'P','PPLA3','SE','0',16821,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (787584,'RS','Novo Miloševo','Novo Milosevo',20.3036,45.7192,'P','PPL','00','',7805,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (787595,'RS','Novi Pazar','Novi Pazar',20.5122,43.1367,'P','PPLA3','SE','18',85996,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (787600,'RS','Novi Kneževac','Novi Knezevac',20.1,46.05,'P','PPLA3','VO','3',8166,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (787615,'RS','Nova Pazova','Nova Pazova',20.2193,44.9437,'P','PPL','VO','',15488,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (787657,'RS','Niš','Nis',21.9033,43.3247,'P','PPLA2','SE','20',250000,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (787718,'RS','Negotin','Negotin',22.5308,44.2264,'P','PPLA3','SE','14',17612,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (787855,'RS','Mol','Mol',20.1329,45.7646,'P','PPL','00','',7950,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (787857,'RS','Mokrin','Mokrin',20.4121,45.9336,'P','PPL','00','',6567,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (788040,'RS','Melenci','Melenci',20.3196,45.5168,'P','PPL','00','',7685,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (788357,'RS','Majdanpek','Majdanpek',21.946,44.4277,'P','PPLA3','SE','14',10071,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (788709,'RS','Leskovac','Leskovac',21.9461,42.9981,'P','PPLA2','SE','23',94758,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (788771,'RS','Lazarevac','Lazarevac',20.2557,44.3853,'P','PPLA3','SE','0',23551,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (788792,'RS','Lapovo','Lapovo',21.0973,44.1842,'P','PPLA3','SE','12',7422,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (788975,'RS','Kruševac','Krusevac',21.3339,43.58,'P','PPLA2','SE','19',75256,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (789107,'RS','Kraljevo','Kraljevo',20.6894,43.7258,'P','PPLA2','SE','18',82846,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (789128,'RS','Kragujevac','Kragujevac',20.9167,44.0167,'P','PPLA2','SE','12',147473,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (789168,'RS','Kovin','Kovin',20.9761,44.7475,'P','PPLA3','VO','4',14250,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (789170,'RS','Kovilj','Kovilj',20.0233,45.2342,'P','PPL','VO','6',5279,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (789178,'RS','Kovačica','Kovacica',20.6214,45.1117,'P','PPLA3','VO','4',7357,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (789518,'RS','Kikinda','Kikinda',20.4653,45.8297,'P','PPLA2','VO','3',41935,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (789600,'RS','Kanjiža','Kanjiza',20.05,46.0667,'P','PPLA3','VO','3',10200,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (789923,'RS','Jagodina','Jagodina',21.2612,43.9771,'P','PPLA2','SE','13',35589,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (790015,'RS','Inđija','Ingija',20.0816,45.0482,'P','PPL','VO','7',26247,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (790367,'RS','Gornji Milanovac','Gornji Milanovac',20.4615,44.026,'P','PPLA3','SE','17',23982,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (790847,'RS','Ečka','Ecka',20.4429,45.3233,'P','PPL','00','',5293,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (791471,'RS','Dobanovci','Dobanovci',20.2249,44.8263,'P','PPL','00','',7592,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (791589,'RS','Debeljača','Debeljaca',20.6015,45.0707,'P','PPL','00','',6413,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (791672,'RS','Čurug','Curug',20.0686,45.4722,'P','PPL','00','',9231,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (791678,'RS','Ćuprija','Cuprija',21.37,43.9275,'P','PPLA3','SE','13',20585,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (791887,'RS','Crepaja','Crepaja',20.637,45.0098,'P','PPL','00','',5369,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (791900,'RS','Čoka','Coka',20.1433,45.9425,'P','PPLA3','VO','3',5414,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (792078,'RS','Čačak','Cacak',20.3497,43.8914,'P','PPLA2','SE','17',117072,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (792456,'RS','Bor','Bor',22.0959,44.0749,'P','PPLA2','SE','14',39387,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (792651,'RS','Beška','Beska',20.067,45.1309,'P','PPL','00','',6377,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (792680,'RS','Belgrade','Belgrade',20.4651,44.804,'P','PPLC','SE','',1273651,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (792794,'RS','Bela Crkva','Bela Crkva',21.4172,44.8975,'P','PPLA3','VO','4',10675,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (792814,'RS','Bečej','Becej',20.0333,45.6163,'P','PPLA3','VO','6',25774,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (792866,'RS','Barič','Baric',20.2594,44.6507,'P','PPL','00','',5033,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (792945,'RS','Banatski Karlovac','Banatski Karlovac',21.018,45.0499,'P','PPL','00','',6319,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (793014,'RS','Bačko Petrovo Selo','Backo Petrovo Selo',20.0793,45.7068,'P','PPL','00','',8959,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (793015,'RS','Bačko Gradište','Backo Gradiste',20.0308,45.5327,'P','PPL','00','',5764,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (793093,'RS','Arilje','Arilje',20.0956,43.7531,'P','PPLA3','SE','16',6762,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (793111,'RS','Aranđelovac','Arangelovac',20.56,44.3069,'P','PPLA3','SE','12',24309,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3187297,'RS','Vrbas','Vrbas',19.6408,45.5714,'P','PPLA3','VO','6',25907,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3187829,'RS','Veternik','Veternik',19.7588,45.2545,'P','PPL','00','',10226,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3188402,'RS','Valjevo','Valjevo',19.8982,44.2751,'P','PPLA2','SE','9',61035,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3188434,'RS','Užice','Uzice',19.8488,43.8586,'P','PPLA2','SE','16',63577,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3189595,'RS','Subotica','Subotica',19.6667,46.1,'P','PPLA2','VO','1',100000,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3190042,'RS','Stanišić','Stanisic',19.1671,45.9389,'P','PPL','00','',5476,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3190101,'RS','Sremski Karlovci','Sremski Karlovci',19.9344,45.2025,'P','PPLA3','VO','6',8839,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3190103,'RS','Sremska Mitrovica','Sremska Mitrovica',19.6122,44.9764,'P','PPLA2','VO','7',39084,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3190335,'RS','Sonta','Sonta',19.0972,45.5943,'P','PPL','00','',5991,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3190342,'RS','Sombor','Sombor',19.1122,45.7742,'P','PPLA2','VO','5',48454,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3191376,'RS','Šabac','Sabac',19.69,44.7467,'P','PPLA2','SE','8',55114,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3191429,'RS','Ruma','Ruma',19.8222,45.0081,'P','PPLA3','VO','7',32229,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3192420,'RS','Prigrevica','Prigrevica',19.0881,45.6764,'P','PPL','00','',5026,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3193406,'RS','Petrovaradin','Petrovaradin',19.8794,45.2467,'P','PPLA3','VO','6',13917,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3194360,'RS','Novi Sad','Novi Sad',19.8369,45.2517,'P','PPLA','VO','6',215400,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3202798,'RS','Čelarevo','Celarevo',19.5248,45.27,'P','PPL','00','',5017,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3203840,'RS','Bogatić','Bogatic',19.4806,44.8375,'P','PPLA3','SE','8',7225,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3204623,'RS','Bajina Bašta','Bajina Basta',19.5675,43.9708,'P','PPLA3','SE','16',8533,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3204635,'RS','Badovinci','Badovinci',19.3715,44.7853,'P','PPL','00','',5879,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3204665,'RS','Bački Petrovac','Backi Petrovac',19.5917,45.3606,'P','PPLA3','VO','6',7229,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3204672,'RS','Bačka Topola','Backa Topola',19.6318,45.8152,'P','PPLA3','VO','1',16154,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3204674,'RS','Bačka Palanka','Backa Palanka',19.3919,45.2508,'P','PPLA3','VO','6',29449,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (3204793,'RS','Apatin','Apatin',18.9847,45.6711,'P','PPLA3','VO','5',18320,'Europe/Belgrade',1,NULL,NULL);
INSERT INTO `cities` VALUES (6619277,'RS','Knjazevac','Knjazevac',22.257,43.5663,'P','PPLA3','SE','15',25000,'Europe/Belgrade',1,NULL,NULL);
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
