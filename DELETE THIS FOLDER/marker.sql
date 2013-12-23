-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: marker
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.12.04.1

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
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cars` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `isactive` tinyint(1) DEFAULT NULL,
  `code` text NOT NULL,
  `static` text NOT NULL,
  `manufacture` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars`
--

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
INSERT INTO `cars` VALUES (7,'this is the title','this is the desc',1,'/** **/','1','3'),(8,'this is the title','this is the desc',1,'/** **/','1','3'),(9,'this is the title','this is the desc',1,'/** **/','1','3'),(10,'this is the title','this is the desc',1,'/** **/','1','3'),(11,'this is the title2','this is the desc',3,'/** **/','1','3');
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dashboard`
--

DROP TABLE IF EXISTS `dashboard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dashboard` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `link` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ispublished` tinyint(1) NOT NULL,
  `bgcolor` varchar(7) COLLATE utf8_bin NOT NULL,
  `iconclass` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dashboard`
--

LOCK TABLES `dashboard` WRITE;
/*!40000 ALTER TABLE `dashboard` DISABLE KEYS */;
INSERT INTO `dashboard` VALUES (1,'Cars','Manage the cars module','m/2',1,'#d42424','icon-truck'),(2,'Manufactures','This is the manu','m/manu',1,'ccb2ee','icon-folder-close'),(3,'Systems','0','m/systems',1,'0','0'),(4,'Providers','0','m/providers',1,'0','0'),(5,'Devices','','m/devices',1,'','');
/*!40000 ALTER TABLE `dashboard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `color` varchar(7) DEFAULT '#000000',
  `description` text,
  `isactive` tinyint(1) DEFAULT '0',
  `images` text,
  `amount` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entities`
--

DROP TABLE IF EXISTS `entities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `internaltitle` varchar(50) CHARACTER SET latin1 NOT NULL,
  `mappedtable` varchar(100) COLLATE utf8_bin NOT NULL,
  `title` varchar(250) CHARACTER SET latin1 DEFAULT '',
  `description` text CHARACTER SET latin1,
  `identity` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT 'Identity Column Name',
  `ispublished` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `createdby` int(10) unsigned DEFAULT NULL,
  `modifiedby` int(10) unsigned DEFAULT NULL,
  `protected` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `attrs` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`internaltitle`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entities`
--

LOCK TABLES `entities` WRITE;
/*!40000 ALTER TABLE `entities` DISABLE KEYS */;
INSERT INTO `entities` VALUES (1,'dashboard','dashboard','Dashboard','Manage what should appear on the Dashboard page','',1,'2013-07-21 00:00:00','2013-11-04 00:00:00',0,NULL,0,'{\"cssClass\":\"\",\"view_edit\":true,\"view_delete\":true,\"view_create\":true}'),(2,'cars','cars','Cars','','id',1,'2013-10-29 00:00:00','2013-11-11 16:02:44',0,NULL,0,'{\"cssClass\":\"cars-css\",\"view_edit\":true,\"view_delete\":true,\"view_create\":true}'),(3,'manu','manu','Manu1','','id',1,'2013-11-06 00:00:00','2013-11-11 16:02:05',0,NULL,0,'null'),(42,'devices','devices','Devices','','id',1,'2013-11-13 14:30:36','2013-11-13 17:13:52',NULL,NULL,0,'{\"view_create\":true,\"view_edit\":true,\"view_delete\":true}');
/*!40000 ALTER TABLE `entities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fields`
--

DROP TABLE IF EXISTS `fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entityid` int(10) unsigned DEFAULT NULL,
  `internaltitle` varchar(50) CHARACTER SET latin1 NOT NULL,
  `title` varchar(250) CHARACTER SET latin1 NOT NULL,
  `definition` tinyint(3) unsigned NOT NULL,
  `attrs` text CHARACTER SET latin1,
  `description` text CHARACTER SET latin1,
  `roworder` int(11) NOT NULL DEFAULT '0' COMMENT 'Field Order',
  `ispublished` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `listid` (`entityid`),
  CONSTRAINT `entity_fk` FOREIGN KEY (`entityid`) REFERENCES `entities` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fields`
--

LOCK TABLES `fields` WRITE;
/*!40000 ALTER TABLE `fields` DISABLE KEYS */;
INSERT INTO `fields` VALUES (1,1,'title','Title',11,'{\"required\":true}','',1,1,NULL,'2013-11-11 15:36:16'),(2,1,'description','Description',11,'[]','',2,1,NULL,'2013-11-11 15:36:16'),(3,1,'link','link',11,'{\"required\":true}','',3,1,NULL,'2013-11-11 15:36:16'),(4,1,'ispublished','Is Published',11,'[]','',4,1,NULL,'2013-11-11 15:36:16'),(5,1,'bgcolor','BgColor',11,'[]','0',5,1,NULL,'2013-11-11 15:36:16'),(6,1,'iconclass','Icon Class',11,'{\"default\":\"icon-folder-close\"}','0',6,1,NULL,'2013-11-11 15:36:17'),(57,2,'title','Title',14,'{\"required\":true}','The car title',1,1,NULL,'2013-11-11 16:02:44'),(58,2,'description','Description',11,'{\"required\":true}','Enter Description here',2,1,NULL,'2013-11-11 16:02:44'),(60,2,'isactive','Is Active',11,'{\"hide_index\":true,\"required\":true}','',3,1,NULL,'2013-11-11 16:02:44'),(62,2,'code','Code',11,'{\"required\":true}','This is the code',4,1,NULL,'2013-11-11 16:02:44'),(64,2,'static','Static',11,'{\"type\":\"static\",\"type_static\":\"a\\nb\\nc\"}','',5,1,NULL,'2013-11-11 16:02:44'),(67,3,'title','Title',12,'null','',1,1,NULL,'2013-11-11 16:02:05'),(68,3,'description','Description',11,'null','',2,1,NULL,'2013-11-11 16:02:05'),(69,2,'manufacture','Manufacture',11,'{\"pointer\":3,\"pointer_show\":[67,70],\"pointer_separator\":\" \",\"hide_index\":true}','',6,1,NULL,'2013-11-11 16:02:44'),(70,3,'color','Color2',11,'null',NULL,3,0,NULL,'2013-11-11 16:02:05'),(106,42,'images','Images',51,'{\"required\":false,\"default\":\"\"}','',1,1,'2013-11-13 14:30:36','2013-11-13 17:13:52');
/*!40000 ALTER TABLE `fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fieldsdefinitions`
--

DROP TABLE IF EXISTS `fieldsdefinitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fieldsdefinitions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ref` tinyint(3) DEFAULT NULL,
  `type` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `db_type` text CHARACTER SET latin1,
  `category` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `defaults` text COLLATE utf8_bin NOT NULL COMMENT 'store the defaults attributes as Json representation',
  PRIMARY KEY (`id`),
  UNIQUE KEY `reference` (`ref`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fieldsdefinitions`
--

LOCK TABLES `fieldsdefinitions` WRITE;
/*!40000 ALTER TABLE `fieldsdefinitions` DISABLE KEYS */;
INSERT INTO `fieldsdefinitions` VALUES (1,11,'shorttext','{\"type\":\"VARCHAR\",\"constraint\":\"255\"}','text',''),(2,12,'longtext','{\"type\":\"TEXT\"}','text',''),(3,13,'rich text','{\"type\":\"TEXT\"}','text',''),(4,14,'code','{\"type\":\"TEXT\"}','text',''),(5,15,'color','{\"type\":\"VARCHAR\",\"constraint\":\"7\"}','text',''),(6,31,'int','{\"type\":\"INT\"}','number',''),(7,32,'float','{\"type\":\"FLOAT\"}','number',''),(8,41,'select','{\"type\":\"TEXT\"}','list',''),(9,42,'checkbox','{\"type\":\"TEXT\"}','list',''),(10,43,'radio','{\"type\":\"TEXT\"}','list',''),(11,44,'boolean','{\"type\":\"TINYINT\", \"constraint\":\"1\"}','list',''),(12,51,'images','{\"type\":\"TEXT\"}','media',''),(13,52,'video','{\"type\":\"TEXT\"}','media',''),(14,53,'audio','{\"type\":\"TEXT\"}','media',''),(15,61,'attachements','{\"type\":\"TEXT\"}','files',''),(16,71,'date','{\"type\":\"DATE\"}','date',''),(17,72,'datetime','{\"type\":\"DATETIME\"}','date',''),(18,73,'month','{\"type\":\"DATE\"}','date',''),(19,74,'year','{\"type\":\"YEAR\"}','date',''),(20,16,'barcode','{\"type\":\"VARCHAR\",\"constraint\":\"128\"}','text','');
/*!40000 ALTER TABLE `fieldsdefinitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manu`
--

DROP TABLE IF EXISTS `manu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `color` varchar(10) DEFAULT 'rgb',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manu`
--

LOCK TABLES `manu` WRITE;
/*!40000 ALTER TABLE `manu` DISABLE KEYS */;
INSERT INTO `manu` VALUES (1,'Honda','Honda','rgb'),(2,'Toyota','0','rgb'),(3,'Mazda','0','rgb');
/*!40000 ALTER TABLE `manu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `description` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'admin','$2y$08$/X9k6wAJVwsAEJbSHAopMuOI5vMSybYYx5OC9vaAXBw6.Hv9q3I3q','0',NULL,NULL),(2,'ahmad','$2y$08$/V/L9RKfmIobdZopsuSVyeAn8Hs5payK1CmIgsLe0NQ','this is the description','2013-11-12 14:01:42','2013-11-12 14:01:42'),(3,'mazen','$2y$08$Oj42G6GWKhETP850PTO.IeVeHUWkyPPZi6zuWkhSohA','this is the description','2013-11-12 14:07:54','2013-11-12 14:07:54'),(4,'rawad','$2y$08$gDLGWRc9NAvJM/LwFqik9eZlO91gBBwQe3MnjgC0zmuPp1EVtMzKG','this is the description','2013-11-12 14:09:12','2013-11-13 10:21:42');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membersinroles`
--

DROP TABLE IF EXISTS `membersinroles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membersinroles` (
  `memberid` int(10) unsigned NOT NULL DEFAULT '0',
  `roleid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`memberid`,`roleid`),
  KEY `memberid` (`memberid`),
  KEY `roleid` (`roleid`),
  CONSTRAINT `membersinroles_ibfk_1` FOREIGN KEY (`memberid`) REFERENCES `members` (`id`),
  CONSTRAINT `membersinroles_ibfk_2` FOREIGN KEY (`roleid`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membersinroles`
--

LOCK TABLES `membersinroles` WRITE;
/*!40000 ALTER TABLE `membersinroles` DISABLE KEYS */;
INSERT INTO `membersinroles` VALUES (1,1),(1,2),(1,3);
/*!40000 ALTER TABLE `membersinroles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `owners`
--

DROP TABLE IF EXISTS `owners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `owners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `owners`
--

LOCK TABLES `owners` WRITE;
/*!40000 ALTER TABLE `owners` DISABLE KEYS */;
INSERT INTO `owners` VALUES (1,'Ahmad',20),(2,'Maya',30);
/*!40000 ALTER TABLE `owners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `bitmask` int(11) DEFAULT NULL,
  `description` text CHARACTER SET latin1,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'administrators',NULL,NULL),(2,'super',NULL,NULL),(3,'contributors',NULL,NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `session_id` varchar(40) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `ip_address` varchar(45) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `user_agent` varchar(120) CHARACTER SET latin1 NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-12-23 21:28:14
