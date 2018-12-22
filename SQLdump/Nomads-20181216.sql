-- MySQL dump 10.16  Distrib 10.1.36-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: nomads
-- ------------------------------------------------------
-- Server version	10.1.36-MariaDB

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
-- Table structure for table `galactic_market_buy_table`
--

DROP TABLE IF EXISTS `galactic_market_buy_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galactic_market_buy_table` (
  `listing_id` int(11) NOT NULL AUTO_INCREMENT,
  `listing_model` int(11) NOT NULL,
  `listing_table` varchar(100) NOT NULL,
  `listing_value` int(11) NOT NULL,
  `listing_currency` varchar(100) NOT NULL,
  `listing_limit` int(11) NOT NULL,
  `listing_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`listing_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galactic_market_buy_table`
--

LOCK TABLES `galactic_market_buy_table` WRITE;
/*!40000 ALTER TABLE `galactic_market_buy_table` DISABLE KEYS */;
INSERT INTO `galactic_market_buy_table` VALUES (1,1,'unit',100,'workers',1,1);
/*!40000 ALTER TABLE `galactic_market_buy_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_settings`
--

DROP TABLE IF EXISTS `game_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_settings` (
  `game_setting_ID` int(11) NOT NULL AUTO_INCREMENT,
  `game_setting_name` varchar(100) NOT NULL,
  `game_setting_value` varchar(100) NOT NULL,
  PRIMARY KEY (`game_setting_ID`),
  UNIQUE KEY `game_setting_name` (`game_setting_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_settings`
--

LOCK TABLES `game_settings` WRITE;
/*!40000 ALTER TABLE `game_settings` DISABLE KEYS */;
INSERT INTO `game_settings` VALUES (1,'user_session_validity_minutes','60'),(2,'number_of_default_map_tiles','50'),(3,'star_spawn_percentage','4'),(4,'star_gravity_factor','1000'),(5,'number_of_default_star_models','4'),(6,'number_of_default_planet_models','4');
/*!40000 ALTER TABLE `game_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `map_default`
--

DROP TABLE IF EXISTS `map_default`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `map_default` (
  `map_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `map_name` varchar(100) NOT NULL,
  `map_X` int(11) NOT NULL,
  `map_Y` int(11) NOT NULL,
  `map_star` int(11) NOT NULL DEFAULT '0',
  `map_image` varchar(500) NOT NULL,
  `map_tile` varchar(500) NOT NULL,
  PRIMARY KEY (`map_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `map_default`
--

LOCK TABLES `map_default` WRITE;
/*!40000 ALTER TABLE `map_default` DISABLE KEYS */;
INSERT INTO `map_default` VALUES (1,'Solar System',0,0,1,'0','solarsystem_1');
/*!40000 ALTER TABLE `map_default` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `map_generated`
--

DROP TABLE IF EXISTS `map_generated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `map_generated` (
  `mapGen_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mapGen_name` varchar(1000) DEFAULT NULL,
  `mapGen_discoveredBy` int(11) NOT NULL,
  `mapGen_X` int(11) NOT NULL,
  `mapGen_Y` int(11) NOT NULL,
  `mapGen_star` int(11) NOT NULL DEFAULT '0',
  `mapGen_tile` varchar(500) NOT NULL,
  `mapGen_createdAt` int(11) NOT NULL,
  PRIMARY KEY (`mapGen_id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `map_generated`
--

LOCK TABLES `map_generated` WRITE;
/*!40000 ALTER TABLE `map_generated` DISABLE KEYS */;
INSERT INTO `map_generated` VALUES (1,NULL,1,0,-1,0,'Maptile_11',1544907534),(2,NULL,1,-1,1,0,'Maptile_16',1544907885),(3,NULL,1,-1,-1,0,'Maptile_9',1544908608),(4,NULL,1,-1,0,0,'Maptile_32',1544909233),(5,NULL,1,1,-1,0,'Maptile_19',1544909241),(6,NULL,1,2,0,0,'Maptile_24',1544909262),(7,NULL,1,1,0,0,'Maptile_9',1544909270),(8,NULL,1,0,-2,0,'Maptile_22',1544916607),(9,NULL,1,2,-1,0,'Maptile_23',1544916618),(10,NULL,1,3,0,0,'Maptile_8',1544916635),(11,NULL,1,3,1,0,'Maptile_41',1544916643),(12,NULL,1,1,1,0,'Maptile_18',1544917063),(13,NULL,1,0,1,0,'Maptile_27',1544956216),(14,NULL,1,-2,0,0,'Maptile_1',1544957814),(15,NULL,1,-2,1,0,'Maptile_46',1544957818),(16,NULL,1,0,2,0,'Maptile_12',1544957825),(17,NULL,1,-1,2,0,'Maptile_13',1544957828),(18,'Acrux System',1,-2,2,1,'Maptile_18',1544957831),(19,NULL,1,-3,1,0,'Maptile_14',1544957861),(20,NULL,1,-3,2,0,'Maptile_42',1544957865),(21,NULL,1,-3,3,0,'Maptile_14',1544957868),(22,NULL,1,-2,3,0,'Maptile_6',1544957871),(23,NULL,1,-1,3,0,'Maptile_21',1544957874),(24,NULL,1,-4,1,0,'Maptile_28',1544957901),(25,NULL,1,-4,2,0,'Maptile_29',1544957904),(26,NULL,1,-4,3,0,'Maptile_38',1544957907),(27,NULL,1,-5,1,0,'Maptile_42',1544957915),(28,NULL,1,-5,2,0,'Maptile_47',1544957917),(29,NULL,1,-5,3,0,'Maptile_5',1544957919),(30,NULL,1,-6,1,0,'Maptile_29',1544957926),(31,NULL,1,-6,2,0,'Maptile_11',1544957929),(32,NULL,1,-6,3,0,'Maptile_49',1544957932),(33,NULL,1,-7,1,0,'Maptile_3',1544957938),(34,NULL,1,-7,2,0,'Maptile_33',1544957940),(35,NULL,1,-7,3,0,'Maptile_48',1544957943),(36,NULL,1,-8,1,0,'Maptile_44',1544957950),(37,NULL,1,-8,2,0,'Maptile_43',1544957952),(38,NULL,1,-8,3,0,'Maptile_33',1544957954),(39,NULL,1,-9,1,0,'Maptile_2',1544957959),(40,NULL,1,-9,2,0,'Maptile_30',1544957962),(41,NULL,1,-9,3,0,'Maptile_14',1544957964),(42,NULL,1,-10,1,0,'Maptile_6',1544957968),(43,NULL,1,-10,2,0,'Maptile_45',1544957972),(44,NULL,1,-10,3,0,'Maptile_47',1544957975),(45,NULL,1,-11,2,0,'Maptile_4',1544958425),(46,NULL,1,-11,3,0,'Maptile_32',1544958427),(47,NULL,1,-11,1,0,'Maptile_30',1544958431),(48,NULL,1,-12,1,0,'Maptile_50',1544958440),(49,NULL,1,-12,2,0,'Maptile_34',1544958443),(50,NULL,1,-12,3,0,'Maptile_11',1544958446),(51,NULL,1,-13,1,0,'Maptile_30',1544958452),(52,NULL,1,-13,2,0,'Maptile_8',1544958455),(53,NULL,1,-13,3,0,'Maptile_36',1544958458),(54,NULL,1,-14,1,0,'Maptile_43',1544958464),(55,NULL,1,-14,2,0,'Maptile_3',1544958467),(56,NULL,1,-14,3,0,'Maptile_28',1544958470),(57,NULL,1,-14,0,0,'Maptile_8',1544958479),(58,'Zhou System',1,-13,0,2,'Maptile_13',1544958482),(59,NULL,1,-12,0,0,'Maptile_40',1544958497),(60,NULL,1,-12,-1,0,'Maptile_28',1544958500),(61,NULL,1,-13,-1,0,'Maptile_6',1544958503),(62,NULL,1,-14,-1,0,'Maptile_5',1544958506),(63,NULL,1,-15,0,0,'Maptile_42',1544958791),(64,NULL,1,-15,-1,0,'Maptile_10',1544958794),(65,NULL,1,-15,-2,0,'Maptile_12',1544958797),(66,NULL,1,-14,-2,0,'Maptile_25',1544958800),(67,NULL,1,-13,-2,0,'Maptile_6',1544958803),(68,NULL,1,-14,-3,0,'Maptile_32',1544958830),(69,NULL,1,-13,-3,0,'Maptile_32',1544958833),(70,NULL,1,-12,-3,0,'Maptile_38',1544958835),(71,'Ras Elased System',1,-12,-2,3,'Maptile_47',1544958838),(72,NULL,1,-11,-3,0,'Maptile_3',1544958846),(73,NULL,1,-11,-2,0,'Maptile_14',1544958848),(74,NULL,1,-11,-1,0,'Maptile_27',1544958851),(75,NULL,1,-10,-3,0,'Maptile_18',1544958859),(76,NULL,1,-10,-2,0,'Maptile_50',1544958862),(77,NULL,1,-10,-1,0,'Maptile_13',1544958864),(78,NULL,1,-9,-3,0,'Maptile_17',1544958869),(79,NULL,1,-9,-2,0,'Maptile_41',1544958872),(80,NULL,1,-9,-1,0,'Maptile_6',1544958875),(81,NULL,1,-8,-3,0,'Maptile_10',1544958890),(82,'Leo System',1,-8,-2,4,'Maptile_40',1544958893),(83,NULL,1,-7,-3,0,'Maptile_8',1544958902),(84,NULL,1,-7,-2,0,'Maptile_20',1544958905),(85,NULL,1,-7,-1,0,'Maptile_1',1544958908),(86,NULL,1,-8,-1,0,'Maptile_32',1544958911),(87,NULL,1,-6,-3,0,'Maptile_17',1544958992),(88,NULL,1,-6,-2,0,'Maptile_39',1544958995),(89,NULL,1,-6,-1,0,'Maptile_3',1544958998);
/*!40000 ALTER TABLE `map_generated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planet_generated`
--

DROP TABLE IF EXISTS `planet_generated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planet_generated` (
  `planet_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `planet_name` varchar(200) NOT NULL,
  `planet_star` int(11) NOT NULL,
  `planet_diameter` int(11) NOT NULL,
  `planet_slots` int(11) NOT NULL,
  `planet_max_temp` int(11) NOT NULL,
  `planet_min_temp` int(11) NOT NULL,
  PRIMARY KEY (`planet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planet_generated`
--

LOCK TABLES `planet_generated` WRITE;
/*!40000 ALTER TABLE `planet_generated` DISABLE KEYS */;
/*!40000 ALTER TABLE `planet_generated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planet_model`
--

DROP TABLE IF EXISTS `planet_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planet_model` (
  `model_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_name` varchar(400) NOT NULL,
  `model_diameter_range` varchar(400) NOT NULL,
  PRIMARY KEY (`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planet_model`
--

LOCK TABLES `planet_model` WRITE;
/*!40000 ALTER TABLE `planet_model` DISABLE KEYS */;
INSERT INTO `planet_model` VALUES (1,'typeA','10000;15000'),(2,'typeB','5000;7500'),(3,'typeC','100000;120000'),(4,'typeD','25000;35000'),(5,'typeE','7500;15000'),(6,'typeF','10000;20000');
/*!40000 ALTER TABLE `planet_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `star_default`
--

DROP TABLE IF EXISTS `star_default`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `star_default` (
  `star_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `star_name` varchar(100) NOT NULL,
  `star_diameter` int(11) NOT NULL,
  `star_heat` int(11) NOT NULL,
  `star_gravity` int(11) NOT NULL,
  `star_map` int(11) NOT NULL,
  `star_model` int(11) NOT NULL,
  `star_image` varchar(500) NOT NULL,
  PRIMARY KEY (`star_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `star_default`
--

LOCK TABLES `star_default` WRITE;
/*!40000 ALTER TABLE `star_default` DISABLE KEYS */;
INSERT INTO `star_default` VALUES (1,'Sun',1300000,5500,130,1,1,'default_sun');
/*!40000 ALTER TABLE `star_default` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `star_generated`
--

DROP TABLE IF EXISTS `star_generated`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `star_generated` (
  `starGen_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `starGen_name` varchar(500) NOT NULL,
  `starGen_diameter` int(11) NOT NULL,
  `starGen_heat` int(11) NOT NULL,
  `starGen_gravity` int(11) NOT NULL,
  `starGen_map` int(11) NOT NULL,
  `starGen_model` int(11) NOT NULL,
  `starGen_image` varchar(255) NOT NULL,
  PRIMARY KEY (`starGen_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `star_generated`
--

LOCK TABLES `star_generated` WRITE;
/*!40000 ALTER TABLE `star_generated` DISABLE KEYS */;
INSERT INTO `star_generated` VALUES (1,'Acrux',1458028,5314,1458,18,1,'star_model_2'),(2,'Zhou',1446967,5016,1447,58,1,'star_model_3'),(3,'Ras Elased',1314763,5125,1315,71,1,'star_model_2'),(4,'Leo',1211233,5920,1211,82,1,'star_model_1');
/*!40000 ALTER TABLE `star_generated` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `star_model`
--

DROP TABLE IF EXISTS `star_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `star_model` (
  `model_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_name` varchar(1500) NOT NULL,
  `model_diameter_range` varchar(1500) NOT NULL,
  `model_heat_range` varchar(1500) NOT NULL,
  `model_gravity_range` varchar(1500) NOT NULL,
  PRIMARY KEY (`model_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `star_model`
--

LOCK TABLES `star_model` WRITE;
/*!40000 ALTER TABLE `star_model` DISABLE KEYS */;
INSERT INTO `star_model` VALUES (1,'Red Giant','1000000;1500000','5000;6000','100;150');
/*!40000 ALTER TABLE `star_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_model_table`
--

DROP TABLE IF EXISTS `unit_model_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_model_table` (
  `model_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_name` varchar(100) NOT NULL,
  `model_type` varchar(100) NOT NULL,
  `model_description` varchar(500) NOT NULL,
  `model_speed` int(11) DEFAULT NULL,
  `model_hitpoints` int(11) DEFAULT NULL,
  `model_attack` int(11) DEFAULT NULL,
  `model_cargo` int(11) DEFAULT NULL,
  `model_require_workers` int(11) NOT NULL DEFAULT '0',
  `model_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`model_id`),
  UNIQUE KEY `model_name` (`model_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_model_table`
--

LOCK TABLES `unit_model_table` WRITE;
/*!40000 ALTER TABLE `unit_model_table` DISABLE KEYS */;
INSERT INTO `unit_model_table` VALUES (1,'Mother Ship','ship','description_ship_1',1,1000000,0,15000,100,1),(2,'Explorer Probe','ship','description_ship_2',100,1,0,0,0,1);
/*!40000 ALTER TABLE `unit_model_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_table`
--

DROP TABLE IF EXISTS `unit_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_table` (
  `unit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_model` int(11) NOT NULL,
  `unit_owner` int(11) NOT NULL,
  `unit_name` varchar(100) NOT NULL,
  `unit_posX` int(11) NOT NULL DEFAULT '0',
  `unit_posY` int(11) NOT NULL DEFAULT '0',
  `unit_busy` tinyint(4) NOT NULL DEFAULT '0',
  `unit_destroyed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_table`
--

LOCK TABLES `unit_table` WRITE;
/*!40000 ALTER TABLE `unit_table` DISABLE KEYS */;
INSERT INTO `unit_table` VALUES (1,1,1,'Mother Ship',-7,-2,0,0);
/*!40000 ALTER TABLE `unit_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(128) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0',
  `createdAt` datetime DEFAULT NULL,
  `lastAction` datetime DEFAULT NULL,
  `password` varchar(40) NOT NULL,
  `workers` int(11) NOT NULL DEFAULT '100',
  `gold` int(11) NOT NULL DEFAULT '0',
  `location_ship` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Kiko','du@da.de',1,'2018-12-15 00:00:00','2018-12-16 00:00:00','098f6bcd4621d373cade4e832627b4f6',0,0,1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_session`
--

DROP TABLE IF EXISTS `user_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_session` (
  `session_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_userID` int(11) NOT NULL,
  `session_timestamp` int(11) NOT NULL,
  `session_ip` varchar(500) NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_session`
--

LOCK TABLES `user_session` WRITE;
/*!40000 ALTER TABLE `user_session` DISABLE KEYS */;
INSERT INTO `user_session` VALUES (4,1,1544959053,'::1');
/*!40000 ALTER TABLE `user_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_token`
--

DROP TABLE IF EXISTS `user_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_token` (
  `token_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token_username` varchar(100) NOT NULL,
  `token_token` varchar(50) NOT NULL,
  PRIMARY KEY (`token_id`),
  UNIQUE KEY `token_username` (`token_username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_token`
--

LOCK TABLES `user_token` WRITE;
/*!40000 ALTER TABLE `user_token` DISABLE KEYS */;
INSERT INTO `user_token` VALUES (1,'Coocoo','5c1587b60879b');
/*!40000 ALTER TABLE `user_token` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-16 12:21:21
