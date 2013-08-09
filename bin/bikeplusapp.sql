-- phpMyAdmin SQL Dump
-- version 4.0.0-beta1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 25, 2013 at 07:18 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nycbikeplus`
--

-- --------------------------------------------------------

--
-- Table structure for table `stationBeanList`
--

CREATE TABLE IF NOT EXISTS `stationBeanList` (
  `parseTime` bigint(20) NOT NULL,
  `executionTime` bigint(20) NOT NULL,
  `id` char(6) NOT NULL,
  `stationName` varchar(255) NOT NULL,
  `availableDocks` smallint(6) NOT NULL,
  `totalDocks` smallint(6) NOT NULL,
  `latitude` decimal(11,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `statusValue` varchar(255) NOT NULL,
  `statusKey` smallint(6) DEFAULT NULL,
  `availableBikes` smallint(6) NOT NULL,
  `stAddress1` varchar(255) DEFAULT NULL,
  `stAddress2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postalCode` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `altitude` decimal(11,8) DEFAULT NULL,
  `testStation` varchar(255) DEFAULT NULL,
  `lastCommunicationTime` varchar(255) DEFAULT NULL,
  `landMark` varchar(255) DEFAULT NULL,
  KEY `id_idx` (`id`),
  KEY `parseTime` (`parseTime`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `openGraph` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uuid` varchar(255) DEFAULT NULL,
  `start_dockid` varchar(255) DEFAULT NULL,
  `start_lat` varchar(255) DEFAULT NULL,
  `start_lng` varchar(255) DEFAULT NULL,
  `stop_dockid` varchar(255) DEFAULT NULL,
  `stop_lat` varchar(255) DEFAULT NULL,
  `stop_lng` varchar(255) DEFAULT NULL,
  `start_fitness_metrics_location_latitude` varchar(255) DEFAULT NULL,
  `start_fitness_metrics_location_longitude` varchar(255) DEFAULT NULL,
  `start_fitness_metrics_location_altitude` varchar(255) DEFAULT NULL,
  `start_fitness_metrics_timestamp` varchar(255) DEFAULT NULL,
  `start_fitness_metrics_distance_value` varchar(255) DEFAULT NULL,
  `start_fitness_metrics_distance_units` varchar(255) DEFAULT NULL,
  `start_fitness_metrics_pace_value` varchar(255) DEFAULT NULL,
  `start_fitness_metrics_pace_units` varchar(255) DEFAULT NULL,
  `start_fitness_metrics_calories` varchar(255) DEFAULT NULL,
  `start_fitness_metrics_custom_quantity_value` varchar(255) DEFAULT NULL,
  `start_fitness_metrics_custom_quantity_units` varchar(255) DEFAULT NULL,
  `stop_fitness_metrics_location_latitude` varchar(255) DEFAULT NULL,
  `stop_fitness_metrics_location_longitude` varchar(255) DEFAULT NULL,
  `stop_fitness_metrics_location_altitude` varchar(255) DEFAULT NULL,
  `stop_fitness_metrics_timestamp` varchar(255) DEFAULT NULL,
  `stop_fitness_metrics_distance_value` varchar(255) DEFAULT NULL,
  `stop_fitness_metrics_distance_units` varchar(255) DEFAULT NULL,
  `stop_fitness_metrics_pace_value` varchar(255) DEFAULT NULL,
  `stop_fitness_metrics_pace_units` varchar(255) DEFAULT NULL,
  `stop_fitness_metrics_calories` varchar(255) DEFAULT NULL,
  `stop_fitness_metrics_custom_quantity_value` varchar(255) DEFAULT NULL,
  `stop_fitness_metrics_custom_quantity_units` varchar(255) DEFAULT NULL,
  `googlemap` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nick` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `fb_id` varchar(255) NOT NULL,
  `fb_email` varchar(255) NOT NULL,
  `fb_name` varchar(255) NOT NULL,
  `fb_first_name` varchar(255) NOT NULL,
  `fb_last_name` varchar(255) NOT NULL,
  `fb_gender` varchar(255) NOT NULL,
  `fb_link` varchar(255) NOT NULL,
  `fb_username` varchar(255) NOT NULL,
  `fb_verified` varchar(255) NOT NULL,
  `notification_lastid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_idx` (`email`),
  KEY `fb_id_idx` (`fb_id`),
  KEY `fb_email_idx` (`fb_email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS  `ci_sessions` (
  session_id varchar(40) DEFAULT '0' NOT NULL,
  ip_address varchar(45) DEFAULT '0' NOT NULL,
  user_agent varchar(120) NOT NULL,
  last_activity int(10) unsigned DEFAULT 0 NOT NULL,
  user_data text NOT NULL,
  PRIMARY KEY (session_id),
  KEY `last_activity_idx` (`last_activity`)
);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
