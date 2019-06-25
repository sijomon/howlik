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
INSERT INTO `subadmin1` VALUES (1250,'IL.01','Southern District','Southern District',1);
INSERT INTO `subadmin1` VALUES (1251,'IL.02','Central District','Central District',1);
INSERT INTO `subadmin1` VALUES (1252,'IL.03','Northern District','Northern District',1);
INSERT INTO `subadmin1` VALUES (1253,'IL.04','Haifa','Haifa',1);
INSERT INTO `subadmin1` VALUES (1254,'IL.05','Tel Aviv','Tel Aviv',1);
INSERT INTO `subadmin1` VALUES (1255,'IL.06','Jerusalem','Jerusalem',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (14675,'IL.01.295618','Nefat Ashqelon','Nefat Ashqelon',1);
INSERT INTO `subadmin2` VALUES (14676,'IL.01.7870269','Gaza','Gaza',1);
INSERT INTO `subadmin2` VALUES (14677,'IL.03.295719','Nefat ‘Akko','Nefat `Akko',1);
INSERT INTO `subadmin2` VALUES (14678,'IL.04.294798','Nefat H̱efa','Nefat Hefa',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (281184,'IL','Jerusalem','Jerusalem',35.2163,31.769,'P','PPLA','06','',801000,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293100,'IL','Safed','Safed',35.496,32.9646,'P','PPL','03','',27816,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293203,'IL','Yeroẖam','Yeroham',34.9318,30.9882,'P','PPL','01','',8631,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293207,'IL','Yehud','Yehud',34.8909,32.0332,'P','PPL','02','',25600,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293222,'IL','Yavné','Yavne',34.7384,31.8808,'P','PPL','02','',31774,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293253,'IL','Yafo','Yafo',34.7522,32.0504,'P','PPLX','05','',100000,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293286,'IL','Umm el Faḥm','Umm el Fahm',35.1535,32.5173,'P','PPL','04','',41030,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293308,'IL','Tirat Karmel','Tirat Karmel',34.9718,32.7602,'P','PPL','04','',18993,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293322,'IL','Tiberias','Tiberias',35.5312,32.7922,'P','PPL','03','',39790,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293354,'IL','Tel Mond','Tel Mond',34.9174,32.25,'P','PPL','02','',8725,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293397,'IL','Tel Aviv','Tel Aviv',34.7806,32.0809,'P','PPLA','05','',250000,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293420,'IL','maalot Tarshīhā','maalot Tarshiha',35.2667,33.0167,'P','PPL','03','',21400,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293426,'IL','Tamra','Tamra',35.1987,32.853,'P','PPL','03','',25917,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293522,'IL','Shelomi','Shelomi',35.1445,33.0722,'P','PPL','03','',5608,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293619,'IL','Sederot','Sederot',34.5969,31.525,'P','PPL','01','',20228,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293655,'IL','Sakhnīn','Sakhnin',35.2971,32.8642,'P','PPL','03','',24596,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293690,'IL','Rosh Ha‘Ayin','Rosh Ha\'Ayin',34.9566,32.0956,'P','PPL','02','',39215,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293703,'IL','Rishon LeẔiyyon','Rishon LeZiyyon',34.7894,31.971,'P','PPL','02','',220492,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293721,'IL','Rekhasim','Rekhasim',35.099,32.7491,'P','PPL','04','',8513,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293768,'IL','Ramla','Ramla',34.8656,31.9292,'P','PPLA','02','',63860,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293773,'IL','Ramat Yishay','Ramat Yishay',35.1707,32.7044,'P','PPL','03','',5431,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293783,'IL','Ramat HaSharon','Ramat HaSharon',34.8394,32.1461,'P','PPL','05','',36137,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293788,'IL','Ramat Gan','Ramat Gan',34.8106,32.0823,'P','PPL','05','',128095,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293807,'IL','Ra\'anana','Ra\'anana',34.8739,32.1836,'P','PPL','02','',80000,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293822,'IL','Qiryat Yam','Qiryat Yam',35.0697,32.8497,'P','PPL','04','',37639,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293825,'IL','Qiryat Shemona','Qiryat Shemona',35.5721,33.2073,'P','PPL','03','',22035,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293831,'IL','Qiryat Moẕqin','Qiryat Mozqin',35.0776,32.8371,'P','PPL','04','',39404,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293842,'IL','Qiryat Gat','Qiryat Gat',34.7642,31.61,'P','PPL','01','',47450,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293844,'IL','Qiryat Bialik','Qiryat Bialik',35.0858,32.8275,'P','PPL','04','',36551,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293845,'IL','Qiryat Ata','Qiryat Ata',35.1132,32.8115,'P','PPL','04','',48966,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293896,'IL','Qalansuwa','Qalansuwa',34.9811,32.2849,'P','PPL','02','',16898,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293918,'IL','Petaẖ Tiqwa','Petah Tiqwa',34.8875,32.0871,'P','PPL','02','',200000,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293942,'IL','Pardesiyya','Pardesiyya',34.9091,32.3058,'P','PPL','02','',6254,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293962,'IL','Or Yehuda','Or Yehuda',34.8579,32.0292,'P','PPL','05','',30802,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (293992,'IL','Ofaqim','Ofaqim',34.6203,31.3141,'P','PPL','01','',24311,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294068,'IL','Netivot','Netivot',34.5886,31.4221,'P','PPL','01','',24564,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294071,'IL','Netanya','Netanya',34.8599,32.3329,'P','PPL','02','',171676,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294074,'IL','Ness Ziona','Ness Ziona',34.7987,31.9293,'P','PPL','02','',38700,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294078,'IL','Nesher','Nesher',35.0443,32.7662,'P','PPL','04','',21245,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294098,'IL','Nazareth','Nazareth',35.3048,32.6992,'P','PPLA','03','',64800,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294114,'IL','Naḥf','Nahf',35.3168,32.9344,'P','PPL','03','',10105,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294117,'IL','Nahariya','Nahariya',35.0947,33.0113,'P','PPL','03','',51200,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294210,'IL','Migdal Ha‘Emeq','Migdal Ha`Emeq',35.2399,32.676,'P','PPL','03','',24800,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294244,'IL','Mevo Betar','Mevo Betar',35.1067,31.7218,'P','PPL','06','',27267,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294303,'IL','Mazkeret Batya','Mazkeret Batya',34.8465,31.8536,'P','PPL','02','',8034,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294387,'IL','Maghār','Maghar',35.407,32.8898,'P','PPL','03','',18915,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294421,'IL','Lod','Lod',34.8903,31.9467,'P','PPL','02','',66589,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294492,'IL','Kefar Yona','Kefar Yona',34.9351,32.3167,'P','PPL','02','',13320,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294514,'IL','Kfar Saba','Kfar Saba',34.9069,32.175,'P','PPL','02','',80773,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294577,'IL','Karmi’el','Karmi\'el',35.305,32.9171,'P','PPL','03','',44382,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294600,'IL','Kafir Yasif','Kafir Yasif',35.1623,32.9545,'P','PPL','03','',8308,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294604,'IL','Kafr Qāsim','Kafr Qasim',34.9762,32.1141,'P','PPL','02','',17303,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294608,'IL','Kafr Mandā','Kafr Manda',35.2601,32.8103,'P','PPL','03','',15014,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294610,'IL','Kafr Kannā','Kafr Kanna',35.3424,32.7466,'P','PPL','03','',17606,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294615,'IL','Kābūl','Kabul',35.2117,32.8686,'P','PPL','03','',9497,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294622,'IL','Judeida Makr','Judeida Makr',35.1571,32.9282,'P','PPL','03','',17530,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294634,'IL','Jaljūlya','Jaljulya',34.9537,32.1547,'P','PPL','02','',7505,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294658,'IL','Iksāl','Iksal',35.3237,32.6816,'P','PPL','03','',11398,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294666,'IL','Ḥurfeish','Hurfeish',35.3484,33.0171,'P','PPL','03','',5308,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294751,'IL','H̱olon','Holon',34.7792,32.0103,'P','PPL','05','',165787,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294760,'IL','Hod HaSharon','Hod HaSharon',34.8932,32.1593,'P','PPL','02','',43185,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294778,'IL','Herzliyya','Herzliyya',34.8254,32.1663,'P','PPL','05','',83600,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294801,'IL','Haifa','Haifa',34.9885,32.8184,'P','PPLA','04','',267300,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294946,'IL','H̱adera','Hadera',34.9039,32.4419,'P','PPL','04','',75854,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294981,'IL','Giv‘at Shemu’él','Giv`at Shemu\'el',34.8486,32.0782,'P','PPL','05','',18500,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (294999,'IL','Giv‘atayim','Giv`atayim',34.8125,32.0723,'P','PPL','05','',48000,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295064,'IL','Gedera','Gedera',34.78,31.8146,'P','PPL','02','',14575,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295080,'IL','Gan Yavne','Gan Yavne',34.7066,31.7874,'P','PPL','02','',14975,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295089,'IL','Ganné Tiqwa','Ganne Tiqwa',34.8732,32.0597,'P','PPL','02','',12213,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295122,'IL','Even Yehuda','Even Yehuda',34.8876,32.2696,'P','PPL','02','',9282,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295127,'IL','Tirah','Tirah',34.9502,32.2341,'P','PPL','02','',20786,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295130,'IL','Eṭ Ṭaiyiba','Et Taiyiba',35.0089,32.2662,'P','PPL','02','',32978,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295174,'IL','Er Reina','Er Reina',35.3162,32.7234,'P','PPL','03','',15621,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295269,'IL','El Fureidīs','El Fureidis',34.9515,32.5981,'P','PPL','04','',9999,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295277,'IL','Eilat','Eilat',34.9482,29.5581,'P','PPL','01','',45588,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295328,'IL','Dimona','Dimona',35.0337,31.0713,'P','PPL','01','',33558,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295339,'IL','Deir Ḥannā','Deir Hanna',35.3637,32.862,'P','PPL','03','',8417,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295365,'IL','Dāliyat el Karmil','Daliyat el Karmil',35.0469,32.6938,'P','PPL','04','',25000,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295370,'IL','Dabbūrīya','Dabburiya',35.3712,32.6926,'P','PPL','03','',8305,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295379,'IL','Buqei‘a','Buqei`a',35.3335,32.9775,'P','PPL','03','',5200,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295380,'IL','Bu‘eina','Bu`eina',35.3649,32.8064,'P','PPL','03','',7900,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295404,'IL','Bīr el Maksūr','Bir el Maksur',35.2207,32.7773,'P','PPL','03','',7106,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295432,'IL','Bet Shemesh','Bet Shemesh',34.9929,31.7307,'P','PPL','06','',67100,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295435,'IL','Bet She’an','Bet She\'an',35.4963,32.4973,'P','PPL','03','',16800,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295475,'IL','Bet Dagan','Bet Dagan',34.8298,32.0019,'P','PPL','02','',5604,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295514,'IL','Bené Beraq','Bene Beraq',34.8338,32.0807,'P','PPL','05','',154400,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295515,'IL','Bene \'Ayish','Bene \'Ayish',34.75,31.7833,'P','PPL','02','',7763,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295523,'IL','Beit Jann','Beit Jann',35.3815,32.9646,'P','PPL','03','',10002,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295530,'IL','Beersheba','Beersheba',34.7913,31.2518,'P','PPLA','01','',186600,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295548,'IL','Bat Yam','Bat Yam',34.7519,32.0238,'P','PPL','05','',128979,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295553,'IL','Basmat Ṭab‘ūn','Basmat Tab`un',35.1572,32.739,'P','PPL','03','',6300,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295584,'IL','Azor','Azor',34.8063,32.0243,'P','PPL','05','',10108,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295620,'IL','Ashqelon','Ashqelon',34.5715,31.6693,'P','PPL','01','',105995,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295629,'IL','Ashdod','Ashdod',34.6497,31.7921,'P','PPL','01','',224656,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295657,'IL','‘Arad','\'Arad',35.2128,31.2588,'P','PPL','01','',23700,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295721,'IL','‘Akko','`Akko',35.0765,32.9281,'P','PPL','03','',45603,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295739,'IL','‘Afula ‘Illit','`Afula `Illit',35.3253,32.6322,'P','PPLX','03','',40000,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (295772,'IL','Abū Ghaush','Abu Ghaush',35.1093,31.8059,'P','PPL','06','',5707,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (386445,'IL','Kefar Weradim','Kefar Weradim',35.2779,32.9939,'P','PPL','03','',5608,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (6693244,'IL','Lehavim','Lehavim',34.8162,31.3728,'P','PPL','01','',6000,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (6693679,'IL','Modiin','Modiin',35.0105,31.8983,'P','PPL','02','',76466,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (7498240,'IL','West Jerusalem','West Jerusalem',35.2196,31.782,'P','PPLX','06','',400000,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (8199378,'IL','Modiin Ilit','Modiin Ilit',35.0442,31.9322,'P','PPL','06','',48639,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (8199386,'IL','Givat Zeev','Givat Zeev',35.1686,31.8615,'P','PPL','','',11764,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (8199394,'IL','Ariel','Ariel',35.1845,32.1065,'P','PPL','06','',17668,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (8199420,'IL','Oranit','Oranit',34.9909,32.1316,'P','PPL','','',6205,'Asia/Jerusalem',1,NULL,NULL);
INSERT INTO `cities` VALUES (8478264,'IL','Herzliya Pituah','Herzliya Pituah',34.8028,32.1741,'P','PPLX','05','',10000,'Asia/Jerusalem',1,NULL,NULL);
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
