CREATE DATABASE  IF NOT EXISTS `geekspace` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `geekspace`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: geekspace
-- ------------------------------------------------------
-- Server version	5.6.17

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
-- Table structure for table `accesslog`
--

DROP TABLE IF EXISTS `accesslog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accesslog` (
  `logentryid` int(11) NOT NULL AUTO_INCREMENT,
  `doorid` int(11) DEFAULT NULL,
  `rfidnumber` varchar(45) DEFAULT NULL,
  `tentry` datetime DEFAULT NULL,
  `memberid` varchar(45) DEFAULT NULL,
  `notes` text,
  `errorcode` int(11) DEFAULT NULL,
  `accesslogcol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`logentryid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesslog`
--

LOCK TABLES `accesslog` WRITE;
/*!40000 ALTER TABLE `accesslog` DISABLE KEYS */;
/*!40000 ALTER TABLE `accesslog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assets` (
  `idassets` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category` varchar(200) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `ownerid` int(11) DEFAULT NULL,
  `description` text,
  `image` blob,
  `dateadded` datetime DEFAULT NULL,
  `datereturnby` datetime DEFAULT NULL,
  `value` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`idassets`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assets`
--

LOCK TABLES `assets` WRITE;
/*!40000 ALTER TABLE `assets` DISABLE KEYS */;
/*!40000 ALTER TABLE `assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_categories`
--

DROP TABLE IF EXISTS `event_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_categories` (
  `catid` int(11) NOT NULL AUTO_INCREMENT,
  `catname` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_categories`
--

LOCK TABLES `event_categories` WRITE;
/*!40000 ALTER TABLE `event_categories` DISABLE KEYS */;
INSERT INTO `event_categories` VALUES (1,'Open House'),(2,'LAN Party'),(3,'Workshop'),(4,'Membership Meeting'),(5,'Fundraiser'),(6,'Work Day');
/*!40000 ALTER TABLE `event_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_locations`
--

DROP TABLE IF EXISTS `event_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_locations` (
  `locid` int(11) NOT NULL AUTO_INCREMENT,
  `locname` varchar(99) DEFAULT NULL,
  PRIMARY KEY (`locid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_locations`
--

LOCK TABLES `event_locations` WRITE;
/*!40000 ALTER TABLE `event_locations` DISABLE KEYS */;
INSERT INTO `event_locations` VALUES (1,'GG'),(2,'Main Room'),(3,'Workshop'),(4,'Classroom 1'),(5,'Classroom 2'),(6,'Classrooms & Main Room');
/*!40000 ALTER TABLE `event_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_registration`
--

DROP TABLE IF EXISTS `event_registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_registration` (
  `regid` int(11) NOT NULL AUTO_INCREMENT,
  `evid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `dtreg` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `dtunreg` datetime DEFAULT NULL,
  `dtattend` datetime DEFAULT NULL,
  PRIMARY KEY (`regid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_registration`
--

LOCK TABLES `event_registration` WRITE;
/*!40000 ALTER TABLE `event_registration` DISABLE KEYS */;
INSERT INTO `event_registration` VALUES (1,1,7,'2014-06-18 22:05:28',NULL,'2014-06-18 18:05:28'),(2,9,14,'2014-06-19 19:18:02',NULL,'2014-06-19 15:18:02'),(3,11,5,'2014-06-19 20:11:12',NULL,'2014-06-19 16:11:12'),(4,9,14,'2014-06-19 23:46:40',NULL,'2014-06-19 19:46:40');
/*!40000 ALTER TABLE `event_registration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `evid` int(11) NOT NULL AUTO_INCREMENT,
  `eventname` varchar(45) DEFAULT NULL,
  `eventdesc` text,
  `evstartdate` datetime DEFAULT NULL,
  `evenddate` datetime DEFAULT NULL,
  `evprice` int(11) DEFAULT NULL,
  `evhostid` int(11) DEFAULT NULL,
  `evlocation` varchar(45) DEFAULT NULL,
  `catid` int(11) DEFAULT NULL,
  PRIMARY KEY (`evid`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'Test','','2014-06-18 18:00:00','2014-06-18 14:45:29',NULL,11,'GG',NULL),(2,'July LAN','','2014-07-19 10:00:00','2014-06-18 23:00:00',NULL,11,'GG',2),(3,'Test2','','2014-06-18 00:00:00','2014-06-18 18:55:14',NULL,11,'GG',3),(4,'Engine rebuild','','2014-06-20 16:00:00','2014-06-20 18:00:00',NULL,11,'GG',3),(5,'Blargh','','2014-06-18 00:00:00','2014-06-18 19:10:27',NULL,11,'GG',3),(6,'Blark2','','2014-06-18 00:00:00','2014-06-18 19:13:07',NULL,7,'GG',3),(7,'Blargh5','','2014-06-18 20:43:13','2014-06-18 20:43:13',NULL,11,'GG',6),(8,'Blargh5','','2014-06-18 20:43:52','2014-06-18 20:43:52',NULL,11,'GG',6),(9,'Rebuilding engines 101','','2014-06-19 18:00:00','2014-06-19 15:15:41',NULL,11,'GG',3),(10,'YAE','','2014-06-19 00:00:00','2014-06-19 15:26:04',NULL,11,'GG',3),(11,'YAE2','','2014-06-19 00:00:00','2014-06-19 15:27:10',NULL,16,'GG',3);
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invitems`
--

DROP TABLE IF EXISTS `invitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invitems` (
  `lineid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `invid` bigint(20) unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `disc` float NOT NULL,
  `srcitemid` varchar(30) NOT NULL,
  `tadd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tax` decimal(10,2) NOT NULL,
  `taxable` int(11) DEFAULT '1',
  `memo` varchar(45) DEFAULT NULL,
  `effdate` datetime DEFAULT NULL,
  `planid` int(11) DEFAULT '0' COMMENT '0 = item',
  PRIMARY KEY (`lineid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invitems`
--

LOCK TABLES `invitems` WRITE;
/*!40000 ALTER TABLE `invitems` DISABLE KEYS */;
INSERT INTO `invitems` VALUES (1,1,1,50.00,0,'','2014-06-20 18:33:17',0.00,0,NULL,'2014-04-20 00:00:00',1),(2,2,1,50.00,0,'','2014-06-20 18:38:25',0.00,0,NULL,'2014-06-20 00:00:00',1),(3,3,1,50.00,0,'','2014-06-20 18:41:23',0.00,0,NULL,'2014-05-20 00:00:00',1),(4,4,1,0.00,0,'','2014-06-20 18:41:43',0.00,0,NULL,'2014-05-23 00:00:00',0),(5,5,1,50.00,0,'','2014-06-20 18:42:30',0.00,0,NULL,'2014-05-24 00:00:00',1),(6,6,1,50.00,0,'','2014-06-20 18:43:00',0.00,0,NULL,'2014-05-17 00:00:00',1),(7,7,1,500.00,0,'','2014-06-20 18:43:18',0.00,0,NULL,'2013-05-20 00:00:00',2),(8,8,1,500.00,0,'','2014-06-20 19:32:35',0.00,0,NULL,'2014-02-20 00:00:00',2),(9,9,1,750.00,0,'','2014-06-20 19:33:01',0.00,0,NULL,'2014-02-20 00:00:00',5),(10,10,1,50.00,0,'','2014-06-20 19:35:42',0.00,0,NULL,'2014-06-04 00:00:00',1);
/*!40000 ALTER TABLE `invitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoices` (
  `invid` bigint(10) NOT NULL AUTO_INCREMENT,
  `uid` bigint(10) NOT NULL,
  `sid` int(10) NOT NULL,
  `tcreate` datetime NOT NULL,
  `tmod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `void` int(10) unsigned NOT NULL DEFAULT '0',
  `paycode` enum('Cash','Credit Card','House Charge') NOT NULL,
  `haspaid` int(11) NOT NULL DEFAULT '0',
  `tendered` decimal(10,2) NOT NULL,
  `batchid` int(10) unsigned NOT NULL DEFAULT '0',
  `rtime` datetime NOT NULL,
  `paymemo` varchar(45) DEFAULT NULL,
  `pending` int(11) DEFAULT '0',
  PRIMARY KEY (`invid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,2,11,'2014-06-20 14:33:12','2014-06-20 18:33:20',0,'House Charge',1,0.00,0,'0000-00-00 00:00:00','',0),(2,16,11,'2014-06-20 14:38:22','2014-06-20 18:38:28',0,'House Charge',1,0.00,0,'0000-00-00 00:00:00','',0),(3,6,11,'2014-06-20 14:41:16','2014-06-20 18:41:26',0,'Cash',1,50.00,0,'0000-00-00 00:00:00','',0),(4,7,11,'2014-06-20 14:41:38','2014-06-20 18:41:51',0,'Cash',1,0.00,0,'0000-00-00 00:00:00','',0),(5,7,11,'2014-06-20 14:42:21','2014-06-20 18:42:33',0,'Cash',1,50.00,0,'0000-00-00 00:00:00','',0),(6,10,11,'2014-06-20 14:42:51','2014-06-20 18:43:02',0,'Cash',1,50.00,0,'0000-00-00 00:00:00','',0),(7,3,11,'2014-06-20 14:43:09','2014-06-20 18:43:20',0,'Cash',1,500.00,0,'0000-00-00 00:00:00','',0),(8,14,11,'2014-06-20 15:32:26','2014-06-20 19:32:40',0,'House Charge',1,0.00,0,'0000-00-00 00:00:00','',0),(9,9,11,'2014-06-20 15:32:53','2014-06-20 19:33:05',0,'Cash',1,750.00,0,'0000-00-00 00:00:00','',0),(10,17,11,'2014-06-20 15:35:32','2014-06-20 19:35:46',0,'House Charge',1,0.00,0,'0000-00-00 00:00:00','',0);
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `itemid` bigint(20) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  `desc` varchar(45) NOT NULL,
  `cst` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price` decimal(10,2) NOT NULL,
  `onhand` int(11) NOT NULL DEFAULT '-1',
  `tadd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `discgroup` int(10) unsigned DEFAULT '2',
  `critqty` int(10) unsigned NOT NULL DEFAULT '0',
  `discprice` decimal(10,2) NOT NULL,
  `cat` varchar(20) NOT NULL,
  `taxreg` decimal(10,2) NOT NULL,
  `taxdisc` decimal(10,2) NOT NULL,
  `pointval` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (847242000101,'SubMonth','Geekspace Membership - 1 Month',0.00,50.00,0,'2012-10-27 16:22:13',0,0,50.00,'NonTaxable',0.00,0.00,0),(847242000103,'SubQuarter','Geekspace Membership - 3 month',0.00,150.00,0,'2012-10-28 20:42:49',0,0,150.00,'NonTaxable',0.00,0.00,0),(11111111111,'Test Item','TestItem',0.00,1.00,0,'2012-10-29 02:56:49',0,1,1.00,'Taxable',0.00,0.00,0),(847242000301,'GiftMonth','Gift Membership - 30 day',0.00,50.00,0,'2012-10-30 01:57:57',0,0,50.00,'NonTaxable',0.00,0.00,0),(847400000050,'donation50','$50 donation (non-ded)',0.00,50.00,0,'2012-12-03 18:13:25',0,0,50.00,'NonTaxable',0.00,0.00,0),(847242000201,'depsubmonth','Family Membership - 1 month',0.00,20.00,0,'2013-01-16 02:34:14',0,0,20.00,'NonTaxable',0.00,0.00,0);
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keycards`
--

DROP TABLE IF EXISTS `keycards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keycards` (
  `keycardsid` int(11) NOT NULL AUTO_INCREMENT,
  `rfidnumber` varchar(45) DEFAULT NULL,
  `uid` varchar(45) DEFAULT NULL,
  `tremoved` datetime DEFAULT NULL,
  `keytype` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`keycardsid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keycards`
--

LOCK TABLES `keycards` WRITE;
/*!40000 ALTER TABLE `keycards` DISABLE KEYS */;
INSERT INTO `keycards` VALUES (7,'3501D5CC7F','96',NULL,'Card');
/*!40000 ALTER TABLE `keycards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lockacl`
--

DROP TABLE IF EXISTS `lockacl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lockacl` (
  `idmemberacl` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(45) DEFAULT NULL,
  `lockid` varchar(45) DEFAULT NULL,
  `tadded` datetime DEFAULT NULL,
  `tremoved` datetime DEFAULT NULL,
  `days` varchar(45) DEFAULT NULL,
  `timestart` time DEFAULT '00:00:00',
  `timestop` time DEFAULT '23:59:59',
  PRIMARY KEY (`idmemberacl`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lockacl`
--

LOCK TABLES `lockacl` WRITE;
/*!40000 ALTER TABLE `lockacl` DISABLE KEYS */;
INSERT INTO `lockacl` VALUES (3,'0','1','2012-11-04 21:06:00',NULL,'0,1,2,3,4,5,6','00:00:00','24:00:00');
/*!40000 ALTER TABLE `lockacl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locks`
--

DROP TABLE IF EXISTS `locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locks` (
  `lockid` int(11) NOT NULL AUTO_INCREMENT,
  `macaddr` varchar(45) DEFAULT NULL,
  `name` text,
  `hasacl` int(11) DEFAULT '1',
  PRIMARY KEY (`lockid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='	';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locks`
--

LOCK TABLES `locks` WRITE;
/*!40000 ALTER TABLE `locks` DISABLE KEYS */;
INSERT INTO `locks` VALUES (1,'b8:27:eb:06:04:56','Front Door',1),(2,'b8:27:eb:06:04:56','Front Door Outbound',0);
/*!40000 ALTER TABLE `locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maillog`
--

DROP TABLE IF EXISTS `maillog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maillog` (
  `idmaillog` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text,
  PRIMARY KEY (`idmaillog`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maillog`
--

LOCK TABLES `maillog` WRITE;
/*!40000 ALTER TABLE `maillog` DISABLE KEYS */;
/*!40000 ALTER TABLE `maillog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL DEFAULT '',
  `pass` varchar(80) NOT NULL DEFAULT '',
  `lname` varchar(45) NOT NULL DEFAULT '',
  `fname` varchar(45) NOT NULL DEFAULT '',
  `address` varchar(45) NOT NULL DEFAULT '',
  `address2` varchar(45) NOT NULL DEFAULT '',
  `city` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `state` varchar(2) NOT NULL DEFAULT '',
  `zip` varchar(10) NOT NULL DEFAULT '',
  `phone1` varchar(15) NOT NULL DEFAULT '',
  `email1` varchar(60) NOT NULL DEFAULT '',
  `dob` date NOT NULL DEFAULT '0000-00-00',
  `wantemail` enum('No','Yes') NOT NULL DEFAULT 'Yes',
  `wantsnail` enum('No','Yes') NOT NULL DEFAULT 'Yes',
  `tcreate` datetime DEFAULT NULL,
  `unotes` text NOT NULL,
  `snotes` text NOT NULL,
  `umod` int(11) NOT NULL DEFAULT '0',
  `tmod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `showname` enum('No','Yes') DEFAULT 'Yes',
  `showphone` enum('No','Yes') DEFAULT 'No',
  `showemail` enum('No','Yes') DEFAULT 'Yes',
  `showstats` enum('No','Yes') DEFAULT 'Yes',
  `showaddress` enum('No','Yes') DEFAULT 'No',
  `showinspace` enum('No','Yes') DEFAULT 'Yes',
  `econtactname` varchar(45) DEFAULT NULL,
  `econtactrelation` varchar(45) DEFAULT NULL,
  `econtactphone` varchar(45) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `rank` int(11) DEFAULT '2',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'admin','44187653643d6dfef1bba9747551a378caa821e8','User','Admin','','','','','','678-555-5521','admin@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(2,'mobrien','44187653643d6dfef1bba9747551a378caa821e8','O\'Brien','Miles','','','','','','678-555-5521','thechief@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(3,'mscott','44187653643d6dfef1bba9747551a378caa821e8','Scott','Montgomery','','','','','','678-555-5521','scotty@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(4,'glaforge','44187653643d6dfef1bba9747551a378caa821e8','LaForge','Geordi','','','','','','678-555-5521','geordi@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(5,'ctucker','44187653643d6dfef1bba9747551a378caa821e8','Tucker','Charles','','','','','','678-555-5521','trip@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(6,'kfrye','44187653643d6dfef1bba9747551a378caa821e8','Frye','Kaylee','','','','','','678-555-5521','kaylee@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(7,'scarter','44187653643d6dfef1bba9747551a378caa821e8','Carter','Sam','','','','','','678-555-5521','sam@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(8,'rmckay','44187653643d6dfef1bba9747551a378caa821e8','McKay','Rodney','','','','','','678-555-5521','mckay@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(9,'jharkness','44187653643d6dfef1bba9747551a378caa821e8','Harkness','Jack','','','','','','678-555-5521','jack@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(10,'sjsmith','44187653643d6dfef1bba9747551a378caa821e8','Smith','Sarah Jane','','','','','','678-555-5521','sarahjane@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(11,'pjfry','44187653643d6dfef1bba9747551a378caa821e8','Fry','Phillip','','','','','','678-555-5521','geekspacegwinnett@gmail.com','0000-00-00','Yes','Yes',NULL,'','',0,'2014-07-06 04:15:33','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',5),(15,'','e5f8a03fcbb9a5a8e0c5e445493beec16d4870fc','Farnsworth','Hubert','','','','','','','professor@planetexpress.com','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-19 19:12:57','Yes','No','Yes','Yes','No','Yes','Fry',NULL,'2125551212','d}[hi{$*1!0a=d_\'',2),(14,'','c0ea4ea00dad6cf62a1821d61d18f695c1ed8d61','Spengler','Egon','','','','','','','egon@ghostbusters.com','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-19 19:11:09','Yes','No','Yes','Yes','No','Yes','Ray',NULL,'2125551211','io\'%/*k_qh#\"`#}:',2),(16,'','10b8985db770bc3d66b76bbed11d6514f538ef62','Frink','John','','','','','','','frink@springfieldlabs.com','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-19 19:15:08','Yes','No','Yes','Yes','No','Yes','Homer J',NULL,'2125551212','f9\"::5%zk%t%u\'&',2),(17,'','562e024250757b141f9a637a632127539cf12585','Newton','Brad','','','','','','','srqhivemind@gmail.com','0000-00-00','Yes','Yes',NULL,'','',0,'2014-07-06 04:16:44','Yes','No','Yes','Yes','No','Yes','No one',NULL,'','>f!o=\"!0m_^a5=&%',4);
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plans` (
  `planid` int(11) NOT NULL AUTO_INCREMENT,
  `planname` varchar(45) DEFAULT NULL,
  `planlength` int(11) DEFAULT NULL,
  `plancost` varchar(7) DEFAULT NULL,
  `votable` int(11) DEFAULT '1',
  PRIMARY KEY (`planid`),
  UNIQUE KEY `planid_UNIQUE` (`planid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (1,'Full - Monthly',30,'50',1),(2,'Full - Annual',365,'500',1),(3,'Associate',30,'25',0),(4,'Family - Monthly',30,'75',1),(5,'Family - Annual',365,'750',1);
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriptions` (
  `idsubscriptions` int(11) NOT NULL AUTO_INCREMENT,
  `subname` varchar(45) DEFAULT NULL,
  `substart` datetime DEFAULT NULL,
  `subend` datetime DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `suspenddate` datetime DEFAULT NULL,
  `invid` int(11) DEFAULT NULL,
  `voiddate` datetime DEFAULT NULL,
  `votable` int(11) DEFAULT '1',
  PRIMARY KEY (`idsubscriptions`),
  UNIQUE KEY `idsubscriptions_UNIQUE` (`idsubscriptions`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COMMENT='memberships are defined here';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` VALUES (1,'Plan: 1','2014-04-20 00:00:00','2014-05-20 23:59:59',2,NULL,1,NULL,1),(2,'Plan: 1','2014-06-20 00:00:00','2014-07-20 23:59:59',16,NULL,2,NULL,1),(3,'Plan: 1','2014-05-20 00:00:00','2014-06-19 23:59:59',6,NULL,3,NULL,1),(4,'Plan: 0','2014-05-23 00:00:00','2014-05-23 23:59:59',7,NULL,4,NULL,0),(5,'Plan: 1','2014-05-24 00:00:00','2014-06-23 23:59:59',7,NULL,5,NULL,1),(6,'Plan: 1','2014-05-17 00:00:00','2014-06-16 23:59:59',10,NULL,6,NULL,1),(7,'Plan: 2','2013-05-20 00:00:00','2014-05-20 23:59:59',3,NULL,7,NULL,1),(8,'Plan: 2','2014-02-20 00:00:00','2015-02-20 23:59:59',14,NULL,8,NULL,1),(9,'Plan: 5','2014-02-20 00:00:00','2015-02-20 23:59:59',9,NULL,9,NULL,1),(10,'Plan: 1','2014-06-04 00:00:00','2014-07-04 23:59:59',17,NULL,10,NULL,1);
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userrank`
--

DROP TABLE IF EXISTS `userrank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userrank` (
  `rankid` int(11) NOT NULL,
  `rankname` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`rankid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userrank`
--

LOCK TABLES `userrank` WRITE;
/*!40000 ALTER TABLE `userrank` DISABLE KEYS */;
INSERT INTO `userrank` VALUES (1,'user'),(2,'member'),(3,'Event Coordinator'),(4,'Staff'),(5,'Treasurer');
/*!40000 ALTER TABLE `userrank` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-06  0:19:24
