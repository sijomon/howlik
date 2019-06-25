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
INSERT INTO `subadmin1` VALUES (2657,'PS.GZ','Gaza Strip','Gaza Strip',1);
INSERT INTO `subadmin1` VALUES (2658,'PS.WE','West Bank','West Bank',1);
/*!40000 ALTER TABLE `subadmin1` ENABLE KEYS */;

--
-- Dumping data for table `subadmin2`
--

/*!40000 ALTER TABLE `subadmin2` DISABLE KEYS */;
INSERT INTO `subadmin2` VALUES (25999,'PS.GZ.7870268','Deir Al Balah','Deir Al Balah',1);
INSERT INTO `subadmin2` VALUES (26000,'PS.GZ.7871092','Khan Yunis Governorate','Khan Yunis Governorate',1);
/*!40000 ALTER TABLE `subadmin2` ENABLE KEYS */;

--
-- Dumping data for table `cities`
--

/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (281093,'PS','Shūkat aş Şūfī','Shukat as Sufi',34.2826,31.26,'P','PPL','GZ','',10566,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281102,'PS','Rafaḩ','Rafah',34.2595,31.287,'P','PPL','GZ','',126305,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281109,'PS','An Nuşayrāt','An Nusayrat',34.3925,31.4486,'P','PPL','GZ','',36123,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281119,'PS','Khuzā‘ah','Khuza`ah',34.3611,31.3067,'P','PPL','GZ','',9023,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281124,'PS','Khān Yūnis','Khan Yunis',34.3063,31.3402,'P','PPL','GZ','',173183,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281129,'PS','Jabālyā','Jabalya',34.4835,31.5272,'P','PPL','GZ','',168568,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281133,'PS','Gaza','Gaza',34.4667,31.5,'P','PPLA','GZ','',410000,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281141,'PS','Dayr al Balaḩ','Dayr al Balah',34.3503,31.4178,'P','PPL','GZ','',59504,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281145,'PS','Bayt Lāhyā','Bayt Lahya',34.4951,31.5464,'P','PPL','GZ','',56919,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281146,'PS','Bayt Ḩānūn','Bayt Hanun',34.5358,31.5353,'P','PPL','GZ','',37392,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281148,'PS','Banī Suhaylā','Bani Suhayla',34.3234,31.3434,'P','PPL','GZ','',31272,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281160,'PS','Al Fukhkhārī','Al Fukhkhari',34.3306,31.2928,'P','PPL','GZ','',5464,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281161,'PS','Al Burayj','Al Burayj',34.4031,31.4394,'P','PPL','GZ','',34951,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281165,'PS','‘Abasān al Kabīrah','`Abasan al Kabirah',34.34,31.3191,'P','PPL','GZ','',18163,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (281240,'PS','Za‘tarah','Za`tarah',35.2566,31.6736,'P','PPL','WE','',6210,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (281292,'PS','Yuta','Yuta',35.0944,31.4459,'P','PPL','WE','',41425,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (281318,'PS','Ya‘bad','Ya`bad',35.1682,32.4457,'P','PPL','WE','',13477,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (281577,'PS','Ţūlkarm','Tulkarm',35.0286,32.3104,'P','PPL','WE','',44169,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (281581,'PS','Ţūbās','Tubas',35.3699,32.3209,'P','PPL','WE','',15591,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (281637,'PS','Tarqūmyā','Tarqumya',35.0122,31.5755,'P','PPL','WE','',14202,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (281657,'PS','Ţammūn','Tammun',35.3837,32.2835,'P','PPL','WE','',10119,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (281690,'PS','Taffūḩ','Taffuh',35.0497,31.5385,'P','PPL','WE','',9480,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (281715,'PS','Şūrīf','Surif',35.0644,31.6508,'P','PPL','WE','',12992,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (281778,'PS','Sinjil','Sinjil',35.2654,32.0333,'P','PPL','WE','',5371,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (281789,'PS','Silwād','Silwad',35.2613,31.9762,'P','PPL','WE','',7006,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (281790,'PS','Sīlat az̧ Z̧ahr','Silat az Zahr',35.1842,32.3193,'P','PPL','WE','',6079,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (281791,'PS','Sīlat al Ḩārithīyah','Silat al Harithiyah',35.2275,32.5085,'P','PPL','WE','',9557,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (281793,'PS','Sa‘īr','Sa`ir',35.1402,31.5786,'P','PPL','WE','',17775,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (282039,'PS','Salfīt','Salfit',35.1808,32.0837,'P','PPL','WE','',9452,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (282239,'PS','Ramallah','Ramallah',35.2042,31.8996,'P','PPL','WE','',24599,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (282376,'PS','Qaţanah','Qatanah',35.1189,31.8337,'P','PPL','WE','',7274,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (282457,'PS','Qalqīlyah','Qalqilyah',34.9706,32.1897,'P','PPL','WE','',43212,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (282463,'PS','Qaffīn','Qaffin',35.0827,32.4327,'P','PPL','WE','',8489,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (282476,'PS','Qabāţīyah','Qabatiyah',35.2809,32.4104,'P','PPL','WE','',19127,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (282477,'PS','Qabalān','Qabalan',35.2894,32.1018,'P','PPL','WE','',7043,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (282593,'PS','Naḩḩālīn','Nahhalin',35.1208,31.6856,'P','PPL','WE','',6215,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (282615,'PS','Nablus','Nablus',35.2544,32.2211,'P','PPL','WE','',130326,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (282783,'PS','Banī Zayd ash Shārqīyah','Bani Zayd ash Sharqiyah',35.1659,32.0494,'P','PPL','WE','',5015,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (282793,'PS','Maythalūn','Maythalun',35.2745,32.348,'P','PPL','WE','',6804,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283129,'PS','Bayt ‘Awwā','Bayt `Awwa',34.9494,31.5091,'P','PPL','WE','',7943,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283133,'PS','Jannātah','Jannatah',35.2196,31.6696,'P','PPL','WE','',5348,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283157,'PS','Kharbathā al Mişbāḩ','Kharbatha al Misbah',35.0718,31.8855,'P','PPL','WE','',5141,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283246,'PS','Khārās','Kharas',35.0417,31.6148,'P','PPL','WE','',6885,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283361,'PS','Kafr Rā‘ī','Kafr Ra`i',35.1545,32.374,'P','PPL','WE','',7276,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283506,'PS','Janīn','Janin',35.3009,32.4594,'P','PPL','WE','',34730,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283521,'PS','Jammā‘īn','Jamma`in',35.204,32.1316,'P','PPL','WE','',6158,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283570,'PS','Jaba‘','Jaba`',35.2213,32.3241,'P','PPL','WE','',8391,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283612,'PS','‘Illār','`Illar',35.1071,32.3702,'P','PPL','WE','',6681,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283621,'PS','Idhnā','Idhna',34.9744,31.5587,'P','PPL','WE','',18727,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283636,'PS','Ḩuwwārah','Huwwarah',35.2567,32.1522,'P','PPL','WE','',5633,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283643,'PS','Ḩūsān','Husan',35.1348,31.7093,'P','PPL','WE','',5535,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283676,'PS','Ḩizmā','Hizma',35.2631,31.8334,'P','PPL','WE','',5916,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283806,'PS','Ḩalḩūl','Halhul',35.1018,31.5803,'P','PPL','WE','',21076,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (283843,'PS','Ḩablah','Hablah',34.9775,32.1652,'P','PPL','WE','',5945,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284011,'PS','Dūrā','Dura',35.0293,31.5078,'P','PPL','WE','',20835,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284046,'PS','Dhannābah','Dhannabah',35.0414,32.3134,'P','PPL','WE','',8193,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284078,'PS','Dayr Dibwān','Dayr Dibwan',35.2666,31.9111,'P','PPL','WE','',6692,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284100,'PS','Dayr al Ghuşūn','Dayr al Ghusun',35.0769,32.3524,'P','PPL','WE','',9187,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284105,'PS','Dayr Abū Ḑa‘īf','Dayr Abu Da`if',35.3616,32.456,'P','PPL','WE','',5506,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284194,'PS','Birqīn','Birqin',35.2608,32.4546,'P','PPL','WE','',5730,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284237,'PS','Bīr Zayt','Bir Zayt',35.1941,31.9696,'P','PPL','WE','',6398,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284270,'PS','Biddū','Biddu',35.1495,31.8348,'P','PPL','WE','',6180,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284271,'PS','Bidyā','Bidya',35.0803,32.1146,'P','PPL','WE','',8065,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284294,'PS','Baytūnyā','Baytunya',35.1705,31.8966,'P','PPL','WE','',12822,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284304,'PS','Bayt Sāḩūr','Bayt Sahur',35.2263,31.701,'P','PPL','WE','',14921,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284312,'PS','Bayt Liqyā','Bayt Liqya',35.0654,31.8696,'P','PPL','WE','',7795,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284313,'PS','Bayt Līd','Bayt Lid',35.1317,32.2609,'P','PPL','WE','',5740,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284315,'PS','Bethlehem','Bethlehem',35.2038,31.7049,'P','PPL','WE','',29019,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284320,'PS','Bayt Kāḩil','Bayt Kahil',35.065,31.5701,'P','PPL','WE','',5663,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284324,'PS','Bayt Jālā','Bayt Jala',35.1879,31.7155,'P','PPL','WE','',16183,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284329,'PS','Bayt Ūmmar','Bayt Ummar',35.1045,31.6233,'P','PPL','WE','',12238,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284339,'PS','Bayt Fūrīk','Bayt Furik',35.3354,32.1769,'P','PPL','WE','',10108,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284341,'PS','Bayt Fajjār','Bayt Fajjar',35.1546,31.6244,'P','PPL','WE','',10579,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284347,'PS','Bayt Ūlā','Bayt Ula',35.0296,31.5962,'P','PPL','WE','',9159,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284362,'PS','Baytā al Fawqā','Bayta al Fawqa',35.2877,32.1426,'P','PPL','WE','',8535,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284431,'PS','Banī Na‘īm','Bani Na`im',35.1642,31.5159,'P','PPL','WE','',19783,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284446,'PS','Balāţah','Balatah',35.2856,32.2121,'P','PPL','WE','',17146,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284461,'PS','Bal‘ā','Bal`a',35.1116,32.3339,'P','PPL','WE','',6545,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284480,'PS','‘Azzūn','`Azzun',35.0575,32.175,'P','PPL','WE','',7727,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284486,'PS','Az̧ Z̧āhirīyah','Az Zahiriyah',34.9733,31.4097,'P','PPL','WE','',27616,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284547,'PS','‘Awartā','`Awarta',35.2839,32.1611,'P','PPL','WE','',5563,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284557,'PS','‘Attīl','`Attil',35.0719,32.3694,'P','PPL','WE','',10100,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284583,'PS','As Samū‘','As Samu`',35.0661,31.3967,'P','PPL','WE','',19355,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284593,'PS','‘Aşīrah ash Shamālīyah','`Asirah ash Shamaliyah',35.2672,32.2512,'P','PPL','WE','',7475,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284597,'PS','Ash Shuyūkh','Ash Shuyukh',35.1561,31.57,'P','PPL','WE','',8151,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284890,'PS','Ar Rām wa Ḑāḩiyat al Barīd','Ar Ram wa Dahiyat al Barid',35.2342,31.8494,'P','PPL','WE','',24838,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284893,'PS','‘Arrābah','`Arrabah',35.2019,32.4052,'P','PPL','WE','',9703,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284899,'PS','Jericho','Jericho',35.45,31.8667,'P','PPLA','WE','',19783,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284922,'PS','‘Aqrabā','`Aqraba',35.3455,32.125,'P','PPL','WE','',7707,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284973,'PS','‘Anātā','`Anata',35.259,31.8092,'P','PPL','WE','',11946,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284976,'PS','‘Anabtā','`Anabta',35.1169,32.3079,'P','PPL','WE','',7106,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (284999,'PS','Al Yāmūn','Al Yamun',35.2301,32.4856,'P','PPL','WE','',16164,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (285034,'PS','Az Zaytūnīyah','Az Zaytuniyah',35.1624,31.954,'P','PPL','WE','',6107,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (285061,'PS','Al Khaḑir','Al Khadir',35.1669,31.694,'P','PPL','WE','',9003,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (285066,'PS','Hebron','Hebron',35.0938,31.5294,'P','PPL','WE','',160470,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (285108,'PS','Al Bīrah','Al Birah',35.2164,31.91,'P','PPL','WE','',38192,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (285111,'PS','Al ‘Ayzarīyah','Al `Ayzariyah',35.2692,31.7708,'P','PPL','WE','',17455,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (285279,'PS','Abū Dīs','Abu Dis',35.2617,31.7621,'P','PPL','WE','',11753,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (6945291,'PS','Old City','Old City',35.2342,31.7767,'P','PPLX','WE','',36000,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (6967857,'PS','An Naşr','An Nasr',34.3025,31.2814,'P','PPL','GZ','',6211,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (6967863,'PS','‘Abasān al Jadīdah','`Abasan al Jadidah',34.3459,31.3416,'P','PPL','00','',5984,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (6967865,'PS','Al Qarārah','Al Qararah',34.3409,31.3739,'P','PPL','GZ','',19500,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (6967990,'PS','Az Zuwāydah','Az Zuwaydah',34.3805,31.4395,'P','PPL','GZ','',16688,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (6968063,'PS','Al Mughrāqah','Al Mughraqah',34.4121,31.4659,'P','PPL','00','',6448,'Asia/Gaza',1,NULL,NULL);
INSERT INTO `cities` VALUES (7303419,'PS','East Jerusalem','East Jerusalem',35.2339,31.7834,'P','PPLX','WE','',428304,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (7889665,'PS','Banī Zayd','Bani Zayd',35.1032,32.0392,'P','PPL','00','',5441,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (7890350,'PS','Al ‘Ubaydīyah','Al `Ubaydiyah',35.2901,31.717,'P','PPL','00','',10618,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (7890368,'PS','Ad Dawḩah','Ad Dawhah',35.1805,31.6995,'P','PPL','00','',9631,'Asia/Hebron',1,NULL,NULL);
INSERT INTO `cities` VALUES (7890847,'PS','Dayr Sāmit','Dayr Samit',34.9744,31.5206,'P','PPL','00','',6144,'Asia/Hebron',1,NULL,NULL);
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
