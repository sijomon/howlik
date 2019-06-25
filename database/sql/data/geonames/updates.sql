-- Geonames.org updates SQL Import for LaraClassified
-- 
-- Author: Mayeul Akpovi
-- http://larapen.com
--
--
-- As you already know, LaraClassified uses the Geonames databases from:
-- http://download.geonames.org/export/dump/
--
-- Here is the correspondence between the LaraClassified’s tables and Geonames’s data:
-- http://download.geonames.org/export/dump/admin1CodesASCII.txt (for subadmin1 table)
-- http://download.geonames.org/export/dump/admin2Codes.txt (for subadmin2 table)
-- http://download.geonames.org/export/dump/cities5000.zip (for cities table)
--
-- To update your database:
-- * Truncate (Empty) the tables you want to update (e.g. subadmin1, subadmin2, cities)
-- * Download the latest updates of Geonames (unpack them if need)
-- * Use SQL code below to import the updates:
--
-- NOTE: Don't forget to change /path/to/downloaded/files/ by your real path.


-- subadmin1
SET NAMES utf8;
SET character_set_database=utf8;
SET FOREIGN_KEY_CHECKS = 0;
LOAD DATA LOCAL INFILE '/path/to/downloaded/files/admin1CodesASCII.txt' 
INTO TABLE subadmin1 
FIELDS TERMINATED BY "\t" 
LINES TERMINATED BY "\n" 
(code, name, asciiname);


-- subadmin2
SET NAMES utf8;
SET character_set_database=utf8;
SET FOREIGN_KEY_CHECKS = 0;
LOAD DATA LOCAL INFILE '/path/to/downloaded/files/admin2Codes.txt' 
INTO TABLE subadmin2 
FIELDS TERMINATED BY "\t" 
LINES TERMINATED BY "\n" 
(code, name, asciiname);


-- cities
SET NAMES utf8;
SET character_set_database=utf8;
SET FOREIGN_KEY_CHECKS = 0;
LOAD DATA local INFILE '/path/to/downloaded/files/cities5000.txt' 
INTO TABLE cities 
FIELDS TERMINATED BY "\t" 
LINES TERMINATED BY "\n" 
(id, name, asciiname, @dummy, latitude, longitude, feature_class, feature_code, country_code, @dummy, subadmin1_code, subadmin2_code, @dummy, @dummy, population, @dummy, @dummy, time_zone);



-- AFTER IMPORT
-- UK <=> GB Fixing
UPDATE cities SET country_code='UK' WHERE country_code='GB';
UPDATE subadmin1 SET code=REPLACE(code, 'GB.', 'UK.') WHERE code LIKE 'GB.%';
UPDATE subadmin2 SET code=REPLACE(code, 'GB.', 'UK.') WHERE code LIKE 'GB.%';

