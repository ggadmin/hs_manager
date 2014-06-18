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
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesslog`
--

LOCK TABLES `accesslog` WRITE;
/*!40000 ALTER TABLE `accesslog` DISABLE KEYS */;
INSERT INTO `accesslog` VALUES (1,0,'','2013-03-02 06:06:35','0','Bad Card',1,NULL),(2,0,'','2013-03-02 06:08:33','0','Bad Card',1,NULL),(3,0,'','2013-03-02 06:08:52','0','Bad Card',1,NULL),(4,0,'','2013-03-02 06:09:01','0','Bad Card',1,NULL),(5,0,'','2013-03-02 06:09:30','0','Bad Card',1,NULL),(6,0,'','2013-03-02 06:12:18','0','Bad Card',1,NULL),(7,0,'','2013-03-02 06:12:36','0','Bad Card',1,NULL),(8,3501,'','2013-03-02 06:14:58','0','Bad Card',1,NULL),(9,3501,'','2013-03-02 06:50:22','0','Bad Card',1,NULL),(10,3501,'','2013-03-02 06:50:50','0','Bad Card',1,NULL),(11,3501,'','2013-03-02 06:51:13','0','Bad Card',1,NULL),(12,3501,'','2013-03-02 06:51:46','0','Bad Card',1,NULL),(13,3501,'','2013-03-02 06:53:30','0','Bad Card',1,NULL),(14,3501,'','2013-03-02 06:53:45','0','Bad Card',1,NULL),(15,1,'HACK ATTEMPT: 192.168.40.33','2013-03-02 06:54:10','HACK ATTEMPT','',99,NULL),(16,1,'3501D5CC7F','2013-03-02 07:11:12','96','Access Granted To User',0,NULL),(17,1,'3501D5CC7F','2013-03-02 07:11:56','96','Access Granted To User',0,NULL),(18,1,'3501D5CC7F','2013-03-02 07:12:56','96','Access Granted To User',0,NULL),(19,1,'3501D5CC7F','2013-03-02 07:13:07','96','Access Granted To User',0,NULL),(20,1,'3501D5CC7F','2013-03-02 07:13:16','96','Access Granted To User',0,NULL),(21,1,'3501D5CC7F','2013-03-02 07:13:24','96','Access Granted To User',0,NULL),(22,1,'HACK ATTEMPT: 192.168.40.33','2013-03-02 07:14:04','HACK ATTEMPT','',99,NULL),(23,0,'HACK ATTEMPT: 192.168.40.30','2013-03-02 07:19:40','HACK ATTEMPT','',99,NULL),(24,0,'HACK ATTEMPT: 192.168.40.30','2013-03-02 07:21:04','HACK ATTEMPT','',99,NULL),(25,0,'HACK ATTEMPT: 192.168.40.30','2013-03-02 07:21:44','HACK ATTEMPT','',99,NULL),(26,0,'HACK ATTEMPT: 192.168.40.30','2013-03-02 07:21:58','HACK ATTEMPT','',99,NULL),(27,0,'HACK ATTEMPT: 192.168.40.30','2013-03-02 07:22:12','HACK ATTEMPT','',99,NULL),(28,1,'060095F8D7','2013-03-02 07:22:49','0','Bad Card',1,NULL),(29,1,'3501D5CC7F','2013-03-02 07:23:03','96','Access Granted To User',0,NULL),(30,1,'060095F8D7','2013-03-02 07:23:54','0','Bad Card',1,NULL),(31,1,'3501D5CC7F','2013-03-02 07:24:02','96','Access Granted To User',0,NULL),(32,1,'060095F8D7','2013-03-02 07:25:47','0','Bad Card',1,NULL),(33,1,'060095F8D7','2013-03-02 07:27:23','0','Bad Card',1,NULL),(34,1,'3501D5CC7F','2013-03-02 07:27:36','96','Access Granted To User',0,NULL),(35,1,'060095F8D7','2013-03-02 07:27:45','0','Bad Card',1,NULL),(36,1,'060095F8D7','2013-03-02 07:44:21','0','Bad Card',1,NULL),(37,1,'060095F8D7','2013-03-02 07:55:43','0','Bad Card',1,NULL),(38,1,'060095F8D7','2013-03-02 07:57:25','0','Bad Card',1,NULL),(39,1,'060095F8D7','2013-03-02 07:57:26','0','Bad Card',1,NULL),(40,1,'060095F8D7','2013-03-02 07:57:27','0','Bad Card',1,NULL),(41,1,'060095F8D7','2013-03-02 07:57:27','0','Bad Card',1,NULL),(42,1,'060095F8D7','2013-03-02 07:57:28','0','Bad Card',1,NULL),(43,1,'060095F8D7','2013-03-02 07:57:29','0','Bad Card',1,NULL),(44,1,'060095F8D7','2013-03-02 07:58:08','0','Bad Card',1,NULL),(45,1,'060095F8D7','2013-03-02 07:58:29','0','Bad Card',1,NULL),(46,1,'3501D5CC7F','2013-03-02 07:58:40','96','Access Granted To User',0,NULL),(47,1,'3501D5CC7F','2013-03-02 07:58:40','96','Access Granted To User',0,NULL),(48,1,'3501D5CC7F','2013-03-02 07:58:41','96','Access Granted To User',0,NULL),(49,1,'3501D5CC7F','2013-03-02 07:59:28','96','Access Granted To User',0,NULL),(50,1,'060095F8D7','2013-03-02 07:59:51','0','Bad Card',1,NULL),(51,1,'060095F8D7','2013-03-02 08:02:32','0','Bad Card',1,NULL),(52,1,'3501D5CC7F','2013-03-02 08:17:08','96','Access Granted To User',0,NULL),(53,1,'060095F8D7','2013-03-02 08:17:15','0','Bad Card',1,NULL),(54,1,'060095F8D7','2013-03-02 09:07:35','0','Bad Card',1,NULL),(55,1,'060095F8D7','2013-03-02 09:07:54','0','Bad Card',1,NULL),(56,1,'060095F8D7','2013-03-02 09:12:38','0','Bad Card',1,NULL),(57,1,'060095F8D7','2013-03-02 09:13:31','0','Bad Card',1,NULL),(58,1,'060095F8D7','2013-03-02 09:13:51','0','Bad Card',1,NULL),(59,1,'060095F8D7','2013-03-02 09:14:01','0','Bad Card',1,NULL),(60,1,'3501D5CC7F','2013-03-02 09:14:13','96','Access Granted To User',0,NULL);
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_registration`
--

LOCK TABLES `event_registration` WRITE;
/*!40000 ALTER TABLE `event_registration` DISABLE KEYS */;
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
  PRIMARY KEY (`evid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'Test','','2014-06-18 18:00:00','2014-06-18 14:45:29',NULL,11,'GG');
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
  `linetype` int(11) DEFAULT '0' COMMENT '0 = item',
  PRIMARY KEY (`lineid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invitems`
--

LOCK TABLES `invitems` WRITE;
/*!40000 ALTER TABLE `invitems` DISABLE KEYS */;
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
  `paycode` enum('Cash','Credit Card','House Charge','Check','Dwolla','Amazon') NOT NULL,
  `haspaid` int(11) NOT NULL DEFAULT '0',
  `tendered` decimal(10,2) NOT NULL,
  `batchid` int(10) unsigned NOT NULL DEFAULT '0',
  `rtime` datetime NOT NULL,
  `paymemo` varchar(45) DEFAULT NULL,
  `pending` int(11) DEFAULT '0',
  PRIMARY KEY (`invid`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (40,115,0,'2014-03-13 13:21:11','2014-03-13 17:21:11',0,'Cash',0,0.00,0,'0000-00-00 00:00:00',NULL,0),(41,115,0,'2014-03-13 18:08:50','2014-03-13 22:08:50',0,'Cash',0,0.00,0,'0000-00-00 00:00:00',NULL,0),(42,115,0,'2014-03-18 18:07:36','2014-03-18 22:07:36',0,'Cash',0,0.00,0,'0000-00-00 00:00:00',NULL,0),(43,115,0,'2014-03-18 18:49:14','2014-03-18 22:49:14',0,'Cash',0,0.00,0,'0000-00-00 00:00:00',NULL,0),(44,115,0,'2014-03-25 16:03:10','2014-03-25 20:03:10',0,'Cash',0,0.00,0,'0000-00-00 00:00:00',NULL,0),(45,115,0,'2014-03-25 16:54:09','2014-03-25 20:54:09',0,'Cash',0,0.00,0,'0000-00-00 00:00:00',NULL,0),(46,115,0,'2014-03-25 18:32:44','2014-03-25 22:32:44',0,'Cash',0,0.00,0,'0000-00-00 00:00:00',NULL,0),(47,11,0,'0000-00-00 00:00:00','2014-04-03 00:29:43',0,'Cash',0,0.00,0,'0000-00-00 00:00:00',NULL,0),(48,11,0,'0000-00-00 00:00:00','2014-04-11 21:36:45',0,'Cash',0,0.00,0,'0000-00-00 00:00:00',NULL,0);
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
  `rank` int(11) DEFAULT '3',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'admin','44187653643d6dfef1bba9747551a378caa821e8','User','Admin','','','','','','678-555-5521','admin@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(2,'mobrien','44187653643d6dfef1bba9747551a378caa821e8','O\'Brien','Miles','','','','','','678-555-5521','thechief@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(3,'mscott','44187653643d6dfef1bba9747551a378caa821e8','Scott','Montgomery','','','','','','678-555-5521','scotty@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(4,'glaforge','44187653643d6dfef1bba9747551a378caa821e8','LaForge','Geordi','','','','','','678-555-5521','geordi@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(5,'ctucker','44187653643d6dfef1bba9747551a378caa821e8','Tucker','Charles','','','','','','678-555-5521','trip@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(6,'kfrye','44187653643d6dfef1bba9747551a378caa821e8','Frye','Kaylee','','','','','','678-555-5521','kaylee@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(7,'scarter','44187653643d6dfef1bba9747551a378caa821e8','Carter','Sam','','','','','','678-555-5521','sam@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(8,'rmckay','44187653643d6dfef1bba9747551a378caa821e8','McKay','Rodney','','','','','','678-555-5521','mckay@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(9,'jharkness','44187653643d6dfef1bba9747551a378caa821e8','Harkness','Jack','','','','','','678-555-5521','jack@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(10,'sjsmith','44187653643d6dfef1bba9747551a378caa821e8','Smith','Sarah Jane','','','','','','678-555-5521','sarahjane@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',2),(11,'pjfry','44187653643d6dfef1bba9747551a378caa821e8','Fry','Phillip','','','','','','678-555-5521','fry@geekspacegwinnett.org','0000-00-00','Yes','Yes',NULL,'','',0,'2014-06-18 20:56:15','Yes','No','Yes','Yes','No','Yes','A. MacGyver',NULL,'202-555-1138','user_salt',5);
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
  PRIMARY KEY (`planid`),
  UNIQUE KEY `planid_UNIQUE` (`planid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (1,'Full - Monthly',30,'50'),(2,'Full - Annual',365,'500'),(3,'Associate',30,'25'),(4,'Family - Monthly',30,'75'),(5,'Family - Annual',365,'750');
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
  PRIMARY KEY (`idsubscriptions`),
  UNIQUE KEY `idsubscriptions_UNIQUE` (`idsubscriptions`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=latin1 COMMENT='memberships are defined here';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
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
INSERT INTO `userrank` VALUES (1,'anonymous'),(2,'associate'),(3,'member'),(4,'staff'),(5,'treasurer');
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

-- Dump completed on 2014-06-18 16:58:52
