-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 25, 2013 at 06:19 PM
-- Server version: 5.1.53
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `marker`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `ip_address` varchar(45) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `user_agent` varchar(120) CHARACTER SET latin1 NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE IF NOT EXISTS `fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `listid` int(10) unsigned DEFAULT NULL,
  `internaltitle` varchar(50) CHARACTER SET latin1 NOT NULL,
  `title` varchar(250) CHARACTER SET latin1 NOT NULL,
  `typeref` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '1.1',
  `attrs` text CHARACTER SET latin1,
  `description` text CHARACTER SET latin1,
  `roworder` int(11) NOT NULL DEFAULT '0' COMMENT 'Field Order',
  `ispublished` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `listid` (`listid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=57 ;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`id`, `listid`, `internaltitle`, `title`, `typeref`, `attrs`, `description`, `roworder`, `ispublished`) VALUES
(1, 1, 'title', 'Title', '1.1', '{"required":true}', '', 0, 1),
(2, 1, 'description', 'Description', '1.2', '{}', '', 0, 1),
(3, 1, 'link', 'link', '1.1', '{"required":true}', '', 0, 1),
(4, 1, 'ispublished', 'Is Published', '4.4', '{}', '', 0, 1),
(5, 1, 'bgcolor', 'BgColor', '1.5', '{}', '0', 2, 1),
(6, 1, 'iconclass', 'Icon Class', '1.1', '{"default":"icon-folder-close"}', '0', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fields_types`
--

CREATE TABLE IF NOT EXISTS `fields_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(3) CHARACTER SET latin1 NOT NULL,
  `type` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `db_type` text CHARACTER SET latin1,
  `category` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reference` (`reference`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=21 ;

--
-- Dumping data for table `fields_types`
--

INSERT INTO `fields_types` (`id`, `reference`, `type`, `db_type`, `category`) VALUES
(1, '1.1', 'shorttext', '{"type":"VARCHAR","constraint":"255"}', 'text'),
(2, '1.2', 'longtext', '{"type":"TEXT"}', 'text'),
(3, '1.3', 'rich text', '{"type":"TEXT"}', 'text'),
(4, '1.4', 'code', '{"type":"TEXT"}', 'text'),
(5, '1.5', 'color', '{"type":"VARCHAR","constraint":"7"}', 'text'),
(6, '3.1', 'int', '{"type":"INT"}', 'number'),
(7, '3.2', 'float', '{"type":"FLOAT"}', 'number'),
(8, '4.1', 'select', '{"type":"TEXT"}', 'list'),
(9, '4.2', 'checkbox', '{"type":"TEXT"}', 'list'),
(10, '4.3', 'radio', '{"type":"TEXT"}', 'list'),
(11, '4.4', 'boolean', '{"type":"TINYINT", "constraint":"1"}', 'list'),
(12, '5.1', 'images', '{"type":"TEXT"}', 'media'),
(13, '5.2', 'video', '{"type":"TEXT"}', 'media'),
(14, '5.3', 'audio', '{"type":"TEXT"}', 'media'),
(15, '6.1', 'attachements', '{"type":"TEXT"}', 'files'),
(16, '7.1', 'date', '{"type":"DATE"}', 'date'),
(17, '7.2', 'datetime', '{"type":"DATETIME"}', 'date'),
(18, '7.3', 'month', '{"type":"DATE"}', 'date'),
(19, '7.4', 'year', '{"type":"YEAR"}', 'date'),
(20, '1.6', 'barcode', '{"type":"VARCHAR","constraint":"128"}', 'text');

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE IF NOT EXISTS `lists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `internaltitle` varchar(50) CHARACTER SET latin1 NOT NULL,
  `mapped_table` varchar(100) CHARACTER SET latin1 NOT NULL,
  `title` varchar(250) CHARACTER SET latin1 DEFAULT '',
  `description` text CHARACTER SET latin1,
  `identity` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT 'Identity Column Name',
  `ispublished` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `createdby` int(10) unsigned DEFAULT NULL,
  `modifiedby` int(10) unsigned DEFAULT NULL,
  `protected` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `attrs` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`internaltitle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`id`, `internaltitle`, `mapped_table`, `title`, `description`, `identity`, `ispublished`, `created`, `modified`, `createdby`, `modifiedby`, `protected`, `attrs`) VALUES
(1, 'dashboard', 'lists_dashboard', 'Dashboard', 'Manage what should appear on the Dashboard page', '', 1, '2013-07-21 00:00:00', NULL, 0, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lists_dashboard`
--

CREATE TABLE IF NOT EXISTS `lists_dashboard` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `link` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ispublished` tinyint(1) NOT NULL,
  `bgcolor` varchar(7) COLLATE utf8_bin NOT NULL,
  `iconclass` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(50) CHARACTER SET utf8 NOT NULL,
  `description` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `login`, `password`, `description`) VALUES
(1, 'admin', '123456', '0');

-- --------------------------------------------------------

--
-- Table structure for table `membersinroles`
--

CREATE TABLE IF NOT EXISTS `membersinroles` (
  `memberid` int(10) unsigned NOT NULL DEFAULT '0',
  `roleid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`memberid`,`roleid`),
  KEY `memberid` (`memberid`),
  KEY `roleid` (`roleid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `membersinroles`
--

INSERT INTO `membersinroles` (`memberid`, `roleid`) VALUES
(1, 1),
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET latin1 NOT NULL,
  `urlpath` varchar(200) CHARACTER SET latin1 NOT NULL,
  `body` text CHARACTER SET latin1,
  `meta` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `links` text CHARACTER SET latin1,
  `images` text CHARACTER SET latin1,
  `params` text CHARACTER SET latin1,
  `ispublished` tinyint(1) DEFAULT '1',
  `isdraft` tinyint(1) NOT NULL DEFAULT '0',
  `published` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `publishedby` int(10) unsigned DEFAULT '0',
  `createdby` int(10) unsigned DEFAULT '0',
  `modifiedby` int(10) unsigned DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `bitmask` int(11) DEFAULT NULL,
  `description` text CHARACTER SET latin1,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `bitmask`, `description`) VALUES
(1, 'administrators', NULL, NULL),
(2, 'super', NULL, NULL),
(3, 'contributors', NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `membersinroles`
--
ALTER TABLE `membersinroles`
  ADD CONSTRAINT `membersinroles_ibfk_1` FOREIGN KEY (`memberid`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `membersinroles_ibfk_2` FOREIGN KEY (`roleid`) REFERENCES `roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
