
-- Changed 2018-12-14 by Karsten Maske --
-- Copy and Backup of initial Nomads.sql

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Nomads`
--

-- --------------------------------------------------------

--
-- Table structure for table `galactic_market_buy_table`
--
DROP TABLE IF EXISTS `galactic_market_buy_table`;
CREATE TABLE `galactic_market_buy_table` (
  `listing_id` int auto_increment PRIMARY KEY,
  `listing_model` int NOT NULL,
  `listing_table` varchar(100) NOT NULL,
  `listing_value` int NOT NULL,
  `listing_currency` varchar(100) NOT NULL,
  `listing_limit` int NOT NULL,
  `listing_active` tinyint NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `galactic_market_buy_table`
--

INSERT INTO `galactic_market_buy_table` (`listing_id`, `listing_model`, `listing_table`, `listing_value`, `listing_currency`, `listing_limit`, `listing_active`) VALUES
(1, 1, 'unit', 100, 'workers', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `game_settings`
--
DROP TABLE IF EXISTS `game_settings`;
CREATE TABLE `game_settings` (
  `game_setting_ID` int auto_increment PRIMARY KEY,
  `game_setting_name` varchar(100) NOT NULL,
  `game_setting_value` varchar(100) NOT NULL,
  UNIQUE KEY (`game_setting_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `game_settings`
--

INSERT INTO `game_settings` (`game_setting_ID`, `game_setting_name`, `game_setting_value`) VALUES
(1, 'user_session_validity_minutes', '60'),
(2, 'number_of_default_map_tiles', '50'),
(3, 'star_spawn_percentage', '4'),
(4, 'star_gravity_factor', '1000'),
(5, 'number_of_default_star_models', '4'),
(6, 'number_of_default_planet_models', '4');

-- --------------------------------------------------------

--
-- Table structure for table `map_default`
--
DROP TABLE IF EXISTS `map_default`;
CREATE TABLE `map_default` (
  `map_id` int unsigned auto_increment PRIMARY KEY,
  `map_name` varchar(100) NOT NULL,
  `map_X` int NOT NULL,
  `map_Y` int NOT NULL,
  `map_star` int NOT NULL DEFAULT '0',
  `map_image` varchar(500) NOT NULL,
  `map_tile` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `map_default`
--

INSERT INTO `map_default` (`map_id`, `map_name`, `map_X`, `map_Y`, `map_star`, `map_image`, `map_tile`) VALUES
(1, 'Solar System', 0, 0, 1, '0', 'solarsystem_1');

-- --------------------------------------------------------

--
-- Table structure for table `map_generated`
--
DROP TABLE IF EXISTS `map_generated`;
CREATE TABLE `map_generated` (
  `mapGen_id` int unsigned auto_increment PRIMARY KEY,
  `mapGen_name` varchar(1000) DEFAULT NULL,
  `mapGen_discoveredBy` int NOT NULL,
  `mapGen_X` int NOT NULL,
  `mapGen_Y` int NOT NULL,
  `mapGen_star` int NOT NULL DEFAULT '0',
  `mapGen_tile` varchar(500) NOT NULL,
  `mapGen_createdAt` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `planet_generated`
--
DROP TABLE IF EXISTS `planet_generated`;
CREATE TABLE `planet_generated` (
  `planet_id` int unsigned auto_increment PRIMARY KEY,
  `planet_name` varchar(200) NOT NULL,
  `planet_star` int NOT NULL,
  `planet_diameter` int NOT NULL,
  `planet_slots` int NOT NULL,
  `planet_max_temp` int NOT NULL,
  `planet_min_temp` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `planet_model`
--
DROP TABLE IF EXISTS `planet_model`;
CREATE TABLE `planet_model` (
  `model_id` int unsigned auto_increment PRIMARY KEY,
  `model_name` varchar(400) NOT NULL,
  `model_diameter_range` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `planet_model`
--

INSERT INTO `planet_model` (`model_id`, `model_name`, `model_diameter_range`) VALUES
(1, 'typeA', '10000;15000'),
(2, 'typeB', '5000;7500'),
(3, 'typeC', '100000;120000'),
(4, 'typeD', '25000;35000'),
(5, 'typeE', '7500;15000'),
(6, 'typeF', '10000;20000');

-- --------------------------------------------------------

--
-- Table structure for table `star_default`
--
DROP TABLE IF EXISTS `star_default`;
CREATE TABLE `star_default` (
  `star_id` int unsigned auto_increment PRIMARY KEY,
  `star_name` varchar(100) NOT NULL,
  `star_diameter` int NOT NULL,
  `star_heat` int NOT NULL,
  `star_gravity` int NOT NULL,
  `star_map` int NOT NULL,
  `star_model` int NOT NULL,
  `star_image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `star_default`
--

INSERT INTO `star_default` (`star_id`, `star_name`, `star_diameter`, `star_heat`, `star_gravity`, `star_map`, `star_model`, `star_image`) VALUES
(1, 'Sun', 1300000, 5500, 130, 1, 1, 'default_sun');

-- --------------------------------------------------------

--
-- Table structure for table `star_generated`
--
DROP TABLE IF EXISTS `star_generated`;
CREATE TABLE `star_generated` (
  `starGen_ID` int unsigned auto_increment PRIMARY KEY,
  `starGen_name` varchar(500) NOT NULL,
  `starGen_diameter` int NOT NULL,
  `starGen_heat` int NOT NULL,
  `starGen_gravity` int NOT NULL,
  `starGen_map` int NOT NULL,
  `starGen_model` int NOT NULL,
  `starGen_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `star_model`
--
DROP TABLE IF EXISTS `star_model`;
CREATE TABLE `star_model` (
  `model_id` int unsigned auto_increment PRIMARY KEY,
  `model_name` varchar(1500) NOT NULL,
  `model_diameter_range` varchar(1500) NOT NULL,
  `model_heat_range` varchar(1500) NOT NULL,
  `model_gravity_range` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `star_model`
--

INSERT INTO `star_model` (`model_id`, `model_name`, `model_diameter_range`, `model_heat_range`, `model_gravity_range`) VALUES
(1, 'Red Giant', '1000000;1500000', '5000;6000', '100;150');

-- --------------------------------------------------------

--
-- Table structure for table `unit_model_table`
--
DROP TABLE IF EXISTS `unit_model_table`;
CREATE TABLE `unit_model_table` (
  `model_id` int unsigned auto_increment PRIMARY KEY,
  `model_name` varchar(100) NOT NULL,
  `model_type` varchar(100) NOT NULL,
  `model_description` varchar(500) NOT NULL,
  `model_speed` int DEFAULT NULL,
  `model_hitpoints` int DEFAULT NULL,
  `model_attack` int DEFAULT NULL,
  `model_cargo` int DEFAULT NULL,
  `model_require_workers` int NOT NULL DEFAULT 0,
  `model_active` tinyint NOT NULL DEFAULT 1,
  UNIQUE KEY(`model_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_model_table`
--

INSERT INTO `unit_model_table` (`model_id`, `model_name`, `model_type`, `model_description`, `model_speed`, `model_hitpoints`, `model_attack`, `model_cargo`, `model_require_workers`, `model_active`) VALUES
(1, 'Mother Ship', 'ship', 'description_ship_1', 1, 1000000, 0, 15000, 100, 1),
(2, 'Explorer Probe', 'ship', 'description_ship_2', 100, 1, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `unit_table`
--
DROP TABLE IF EXISTS `unit_table`;
CREATE TABLE `unit_table` (
  `unit_id` int unsigned auto_increment PRIMARY KEY,
  `unit_model` int NOT NULL,
  `unit_owner` int(11) NOT NULL,
  `unit_name` varchar(100) NOT NULL,
  `unit_posX` int NOT NULL DEFAULT 0,
  `unit_posY` int NOT NULL DEFAULT 0,
  `unit_busy` tinyint NOT NULL DEFAULT 0,
  `unit_destroyed` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int unsigned auto_increment PRIMARY KEY,
  `username` varchar(100) NOT NULL,
  `email` varchar(128) NOT NULL,
  `active` tinyint NOT NULL DEFAULT '0',
  `createdAt` datetime DEFAULT NULL,
  `lastAction` datetime DEFAULT NULL,
  `password` varchar(40) NOT NULL,
  `workers` int NOT NULL DEFAULT '100',
  `gold` int NOT NULL DEFAULT '0',
  `location_ship` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY (`username`),
  UNIQUE KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_session`
--
DROP TABLE IF EXISTS `user_session`;
CREATE TABLE `user_session` (
  `session_id` int unsigned auto_increment PRIMARY KEY,
  `session_userID` int NOT NULL,
  `session_timestamp` int NOT NULL,
  `session_ip` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--
DROP TABLE IF EXISTS `user_token`;
CREATE TABLE `user_token` (
  `token_id` int unsigned auto_increment PRIMARY KEY,
  `token_username` varchar(100) NOT NULL,
  `token_token` varchar(50) NOT NULL,
  UNIQUE KEY (`token_username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
