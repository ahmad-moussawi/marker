-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 21, 2013 at 11:51 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

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
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE IF NOT EXISTS `fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `listid` int(10) unsigned DEFAULT NULL,
  `internaltitle` varchar(50) CHARACTER SET latin1 NOT NULL,
  `title` varchar(250) CHARACTER SET latin1 NOT NULL,
  `type` varchar(3) COLLATE utf8_bin NOT NULL DEFAULT '1.1',
  `attrs` text CHARACTER SET latin1,
  `description` text CHARACTER SET latin1,
  `ispublished` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `listid` (`listid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=63 ;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`id`, `listid`, `internaltitle`, `title`, `type`, `attrs`, `description`, `ispublished`) VALUES
(34, 15, 'title', 'Title', '1.1', '{}', '0', 0),
(35, 15, 'images', 'Images', '5.1', '{"max":3,"required":false,"path":"cars","thumb":true,"thumb_path":"cars","thumb_prefix":"thumb_"}', '0', 0),
(36, 17, 'body', 'Body', '1.3', '{"theme":"minimal"}', '0', 0),
(37, 17, 'title', 'Title', '1.1', '{"required":true}', '0', 0),
(38, 17, 'header', 'Header', '1.4', '{}', '0', 0),
(39, 18, 'title', 'Title', '1.1', '{}', '0', 0),
(49, 20, 'title', 'title', '1.1', '{"required":true}', '0', 0),
(50, 20, 'description', 'Description', '1.1', '{}', '0', 0),
(51, 18, 'type', 'Type', '4.1', '{"type":"internal","type_internal":"20","type_internal_display":"49,50"}', '0', 0),
(52, 21, 'firstname', 'First Name', '1.1', '{"required":true}', '0', 0),
(53, 21, 'lastname', 'Last Name', '1.1', '{"required":true}', '0', 0),
(54, 21, 'description', 'Description', '1.2', '{}', '0', 0),
(55, 18, 'owner', 'Owner', '4.1', '{"type":"internal","type_internal":"21","type_internal_display":"52,53"}', '0', 0),
(57, 18, 'showonhomepage', 'Show On Home Page', '4.4', '{"default":"true"}', '0', 0),
(58, 22, 'title', 'Title', '1.1', '{"default":"title","required":true}', '0', 0),
(59, 1, 'title', 'Title', '1.1', '{"required":true}', '0', 0),
(60, 1, 'description', 'Description', '1.2', '{}', '0', 0),
(61, 1, 'link', 'link', '1.1', '{"required":true}', '0', 0),
(62, 1, 'ispublished', 'Is Published', '4.4', '{}', '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fields_types`
--

CREATE TABLE IF NOT EXISTS `fields_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(3) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `db_type` text,
  `category` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reference` (`reference`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `fields_types`
--

INSERT INTO `fields_types` (`id`, `reference`, `type`, `db_type`, `category`) VALUES
(1, '1.1', 'shorttext', '{"type":"VARCHAR","constraint":"255"}', 'text'),
(2, '1.2', 'longtext', '{"type":"TEXT"}', 'text'),
(3, '1.3', 'rich text', '{"type":"TEXT"}', 'text'),
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
(4, '1.4', 'code', '{"type":"TEXT"}', 'text');

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE IF NOT EXISTS `lists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `internaltitle` varchar(50) NOT NULL,
  `mapped_table` varchar(100) NOT NULL,
  `title` varchar(250) DEFAULT '',
  `description` text,
  `ispublished` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `createdby` int(10) unsigned DEFAULT NULL,
  `modifiedby` int(10) unsigned DEFAULT NULL,
  `protected` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`internaltitle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `lists`
--

INSERT INTO `lists` (`id`, `internaltitle`, `mapped_table`, `title`, `description`, `ispublished`, `created`, `modified`, `createdby`, `modifiedby`, `protected`) VALUES
(1, 'dashboard', 'lists_dashboard', 'Dashboard', 'Manage what should appear on the Dashboard page', 1, '2013-07-21 00:00:00', NULL, 0, NULL, 1),
(17, 'pages', 'lists_pages', 'Pages', '', 1, '2013-07-17 00:00:00', NULL, NULL, NULL, 0),
(18, 'cars', 'lists_cars', 'Cars', '', 1, '2013-07-18 00:00:00', '2013-07-20 00:00:00', NULL, NULL, 0),
(20, 'carstype', 'lists_carstype', 'Cars Type', '', 1, '2013-07-20 00:00:00', '2013-07-21 00:00:00', NULL, NULL, 0),
(21, 'owner', 'lists_owner', 'Owner', '', 1, '2013-07-20 00:00:00', NULL, NULL, NULL, 0),
(22, 'products', 'lists_products', 'Products', '', 1, '2013-07-21 00:00:00', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lists_cars`
--

CREATE TABLE IF NOT EXISTS `lists_cars` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `type` text NOT NULL,
  `owner` text NOT NULL,
  `showonhomepage` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `lists_cars`
--

INSERT INTO `lists_cars` (`id`, `title`, `type`, `owner`, `showonhomepage`) VALUES
(4, 'Mazda', '1', '1', 1),
(5, 'Porshe', '1', '1', 1),
(6, 'Subaro', '1', '3', 1),
(7, 'erwer', '1', '1', 0),
(8, 'Suzuki', '1', '1', 1),
(9, 'Mercedes', '1', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lists_carstype`
--

CREATE TABLE IF NOT EXISTS `lists_carstype` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `lists_carstype`
--

INSERT INTO `lists_carstype` (`id`, `title`, `description`) VALUES
(1, 'Automatic', 'Automatic Gear'),
(2, 'Manual', '0');

-- --------------------------------------------------------

--
-- Table structure for table `lists_dashboard`
--

CREATE TABLE IF NOT EXISTS `lists_dashboard` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `ispublished` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `lists_dashboard`
--

INSERT INTO `lists_dashboard` (`id`, `title`, `description`, `link`, `ispublished`) VALUES
(1, 'Pages', 'Pages Modules', 'pages/index', 1),
(2, 'Cars', 'Cars Modules', 'modules/18/index', 1),
(3, 'Products', 'Products Modules', 'modules/22/index', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lists_owner`
--

CREATE TABLE IF NOT EXISTS `lists_owner` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `lists_owner`
--

INSERT INTO `lists_owner` (`id`, `firstname`, `lastname`, `description`) VALUES
(1, 'Ahmad', 'Moussawi', '0'),
(2, 'Faysal', 'Karame', 'Faysal Description'),
(3, 'Majid', 'Mashaalani', '');

-- --------------------------------------------------------

--
-- Table structure for table `lists_pages`
--

CREATE TABLE IF NOT EXISTS `lists_pages` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `body` text NOT NULL,
  `title` varchar(255) NOT NULL,
  `header` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `lists_products`
--

CREATE TABLE IF NOT EXISTS `lists_products` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `description` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `login`, `password`, `description`) VALUES
(2, 'admin', '123456', NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `urlpath`, `body`, `meta`, `links`, `images`, `params`, `ispublished`, `isdraft`, `published`, `created`, `modified`, `publishedby`, `createdby`, `modifiedby`) VALUES
(16, 'My first-page', 'my-first-page', '<h1>Dei melior pace toto undis</h1>\n\n<p>Litem principio extendi madescit. Permisit aethera habendum. Iussit diremit nitidis nuper. Inposuit totidemque otia solidumque. Ipsa frigore elementaque. Pontus speciem agitabilis premuntur origine valles tum rectumque manebat. Homo adspirate sive totidem plagae.</p>\n\n<h2>Praecipites exemit porrexerat animalia mollia</h2>\n\n<h3>Ad sinistra spisso membra frigore</h3>\n\n<p>Sua obliquis parte aliud posset:</p>\n\n<p>Lapidosos valles pontus fulminibus lucis legebantur aberant. Sic inter. Fuit media mortales secrevit obliquis extendi. Viseret derecti media dissaepserat nuper. Phoebe congeriem praecipites. Elementaque evolvit animal quarum hunc levitate tanta illas. Elementaque fluminaque lege melioris vix metusque ne iussit.</p>\n', '', NULL, '[]', NULL, 1, 0, NULL, '2013-07-17 10:13:24', NULL, 0, 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
