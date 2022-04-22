-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: staffportal
-- ------------------------------------------------------
-- Server version	5.7.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `audit_trails`
--

DROP TABLE IF EXISTS `audit_trails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audit_trails` (
  `trail_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `activity_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`trail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_trails`
--

LOCK TABLES `audit_trails` WRITE;
/*!40000 ALTER TABLE `audit_trails` DISABLE KEYS */;
INSERT INTO `audit_trails` VALUES (1,1,'Password Change','Updated account password successfully','127.0.0.1','2022-02-02 12:41:38','2022-02-02 09:41:38',NULL),(2,1,'New Role Creation','Successfully Created new role System admin','127.0.0.1','2022-02-02 12:58:00','2022-02-02 09:58:00',NULL),(3,1,'Role Deletion','Deleted system role system admin with all its associations','127.0.0.1','2022-02-02 13:08:10','2022-02-02 10:08:10',NULL),(4,1,'User Creation','Successfully created new user woditekuby','127.0.0.1','2022-02-03 07:37:51','2022-02-03 04:37:51',NULL),(5,1,'User Profile Updation','Updated profile information for Samson Wafula','127.0.0.1','2022-02-03 08:32:53','2022-02-03 05:32:53',NULL),(6,1,'User Creation','Successfully created new user Allan Mwanzia','127.0.0.1','2022-02-03 08:34:35','2022-02-03 05:34:35',NULL),(7,1,'Assigned User Role','Assigned system roles to  Samson Wafula','127.0.0.1','2022-02-03 08:36:38','2022-02-03 05:36:38',NULL),(8,1,'User Creation','Successfully created new user Yusuf Chanzu','127.0.0.1','2022-02-03 08:47:53','2022-02-03 05:47:53',NULL),(9,1,'User Activation','Activated the user Yusuf Chanzu','127.0.0.1','2022-02-03 08:50:53','2022-02-03 05:50:53',NULL),(10,1,'User Deletion','Deleted the user Yusuf Chanzu','127.0.0.1','2022-02-03 08:51:35','2022-02-03 05:51:35',NULL),(11,1,'User Deletion','Deleted the user Yusuf Chanzu','127.0.0.1','2022-02-03 08:55:22','2022-02-03 05:55:22',NULL),(12,1,'User Deletion','Deleted the user Yusuf Chanzu','127.0.0.1','2022-02-03 08:56:00','2022-02-03 05:56:00',NULL),(13,1,'New Role Creation','Successfully Created new role bimas staff','127.0.0.1','2022-02-03 12:19:39','2022-02-03 09:19:39',NULL);
/*!40000 ALTER TABLE `audit_trails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `branches` (
  `branch_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_code` varchar(11) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `branch_status` int(11) NOT NULL DEFAULT '1',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updation_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branches`
--

LOCK TABLES `branches` WRITE;
/*!40000 ALTER TABLE `branches` DISABLE KEYS */;
INSERT INTO `branches` VALUES (1,'000','Head Office',1,'2019-08-20 18:06:11','2019-09-18 13:46:50'),(2,'001','Embu',1,'2019-08-20 18:06:11','2019-08-20 18:07:12'),(3,'002','Kiritiri',1,'2019-08-20 18:07:42','2019-08-20 18:07:59'),(4,'003','Mwea',1,'2019-08-21 06:39:57',NULL),(5,'004','Kerugoya',1,'2019-08-21 06:39:57',NULL),(6,'005','Nyeri',1,'2019-08-21 06:41:44',NULL),(7,'006','Nyahururu',1,'2019-08-21 06:41:44',NULL),(8,'007','Nakuru',1,'2019-08-21 06:43:38',NULL),(9,'009','Nairobi',1,'2019-08-21 06:43:38',NULL),(10,'010','Kiambu',1,'2019-08-21 06:44:06',NULL),(11,'011','Kitengela',1,'2019-08-21 06:44:06',NULL),(12,'012','Machakos',1,'2019-08-21 06:44:39',NULL),(13,'013','Tala',1,'2019-08-21 06:44:39',NULL),(14,'014','Makueni',1,'2019-08-21 06:45:18',NULL),(15,'015','Mwingi',1,'2019-08-21 06:45:18',NULL),(16,'016','Kitui',1,'2019-08-21 06:48:20',NULL),(17,'017','Kibwezi',1,'2019-08-21 06:48:20',NULL),(18,'018','Emali',1,'2019-08-21 06:48:20',NULL),(19,'019','Chuka',1,'2019-08-21 06:48:20',NULL),(20,'020','Nkubu',1,'2019-08-21 06:48:20',NULL),(21,'021','Meru',1,'2019-08-21 06:48:20',NULL),(22,'022','Maua',1,'2019-08-21 06:48:20',NULL),(23,'008','Thika',1,'2019-11-05 11:01:29',NULL);
/*!40000 ALTER TABLE `branches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `counties`
--

DROP TABLE IF EXISTS `counties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `counties` (
  `county_id` int(11) NOT NULL,
  `county_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counties`
--

LOCK TABLES `counties` WRITE;
/*!40000 ALTER TABLE `counties` DISABLE KEYS */;
INSERT INTO `counties` VALUES (1,'Mombasa'),(2,'Kwale'),(3,'Kilifi'),(4,'Tana River'),(5,'Lamu'),(6,'Taita-Taveta'),(7,'Garissa'),(8,'Wajir'),(9,'Mandera'),(10,'Marsabit'),(11,'Isiolo'),(12,'Meru'),(13,'Tharaka-Nithi'),(14,'Embu'),(15,'Kitui'),(16,'Machakos'),(17,'Makueni'),(18,'Nyandarua'),(19,'Nyeri'),(20,'Kirinyaga'),(21,'Murang\'a'),(22,'Kiambu'),(23,'Turkana'),(24,'West Pokot'),(25,'Samburu'),(26,'Trans-Nzoia'),(27,'Uasin Gishu'),(28,'Elgeyo-Marakwet'),(29,'Nandi'),(30,'Baringo'),(31,'Laikipia'),(32,'Nakuru'),(33,'Narok'),(34,'Kajiado'),(35,'Kericho'),(36,'Bomet'),(37,'Kakamega'),(38,'Vihiga'),(39,'Bungoma'),(40,'Busia'),(41,'Siaya'),(42,'Kisumu'),(43,'Homa Bay'),(44,'Migori'),(45,'Kisii'),(46,'Nyamira'),(47,'Nairobi');
/*!40000 ALTER TABLE `counties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `message_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `recipient_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logged_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 496339','access_token','sent','Tue, 01 Feb 2022 13:20:23','2022-02-01 10:20:24','2022-02-01 10:20:24'),(2,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 918385','access_token','sent','Tue, 01 Feb 2022 13:35:41','2022-02-01 10:35:41','2022-02-01 10:35:41'),(3,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 170491','access_token','sent','Tue, 01 Feb 2022 13:45:46','2022-02-01 10:45:46','2022-02-01 10:45:46'),(4,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 590035','access_token','sent','Tue, 01 Feb 2022 13:47:19','2022-02-01 10:47:19','2022-02-01 10:47:19'),(5,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 904048','access_token','sent','Tue, 01 Feb 2022 14:03:15','2022-02-01 11:03:15','2022-02-01 11:03:15'),(6,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 075665','access_token','sent','Tue, 01 Feb 2022 14:05:48','2022-02-01 11:05:48','2022-02-01 11:05:48'),(7,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 458395','access_token','sent','Tue, 01 Feb 2022 14:07:39','2022-02-01 11:07:39','2022-02-01 11:07:39'),(8,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 508877','access_token','sent','Tue, 01 Feb 2022 14:08:34','2022-02-01 11:08:34','2022-02-01 11:08:34'),(9,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 762474','access_token','sent','Tue, 01 Feb 2022 14:46:20','2022-02-01 11:46:20','2022-02-01 11:46:20'),(10,'Annuar Mulombi','254703539208','Good evening ANNUAR MULOMBI Your Access Token code is 233248','access_token','sent','Tue, 01 Feb 2022 17:13:57','2022-02-01 14:13:57','2022-02-01 14:13:57'),(11,'Annuar Mulombi','254703539208','Good evening ANNUAR MULOMBI Your Access Token code is 067152','access_token','sent','Tue, 01 Feb 2022 17:16:11','2022-02-01 14:16:11','2022-02-01 14:16:11'),(12,'Annuar Mulombi','254703539208','Good morning ANNUAR MULOMBI Your Access Token code is 122215','access_token','sent','Wed, 02 Feb 2022 09:11:34','2022-02-02 06:11:34','2022-02-02 06:11:34'),(13,'Annuar Mulombi','254703539208','Good morning ANNUAR MULOMBI Your Access Token code is 277216','access_token','sent','Wed, 02 Feb 2022 09:13:26','2022-02-02 06:13:26','2022-02-02 06:13:26'),(14,'Annuar Mulombi','254703539208','Good morning ANNUAR MULOMBI Your Access Token code is 342685','access_token','sent','Wed, 02 Feb 2022 10:11:09','2022-02-02 07:11:09','2022-02-02 07:11:09'),(15,'Annuar Mulombi','254703539208','Good evening ANNUAR MULOMBI Your Access Token code is 216534','access_token','sent','Wed, 02 Feb 2022 17:30:32','2022-02-02 14:30:32','2022-02-02 14:30:32'),(16,'Annuar Mulombi','254703539208','Good evening ANNUAR MULOMBI Your Access Token code is 772006','access_token','sent','Wed, 02 Feb 2022 17:32:16','2022-02-02 14:32:16','2022-02-02 14:32:16'),(17,'Annuar Mulombi','254703539208','Good evening ANNUAR MULOMBI Your Access Token code is 394108','access_token','sent','Wed, 02 Feb 2022 17:34:41','2022-02-02 14:34:41','2022-02-02 14:34:41'),(18,'Annuar Mulombi','254703539208','Good evening ANNUAR MULOMBI Your Access Token code is 254484','access_token','sent','Wed, 02 Feb 2022 17:35:44','2022-02-02 14:35:44','2022-02-02 14:35:44'),(19,'Annuar Mulombi','254703539208','Good evening ANNUAR MULOMBI Your Access Token code is 428930','access_token','sent','Wed, 02 Feb 2022 17:48:16','2022-02-02 14:48:16','2022-02-02 14:48:16'),(20,'Annuar Mulombi','254703539208','Good evening ANNUAR MULOMBI Your Access Token code is 719029','access_token','sent','Wed, 02 Feb 2022 17:53:15','2022-02-02 14:53:15','2022-02-02 14:53:15'),(21,'Annuar Mulombi','254703539208','Good evening ANNUAR MULOMBI Your Access Token code is 072046','access_token','sent','Wed, 02 Feb 2022 17:55:01','2022-02-02 14:55:01','2022-02-02 14:55:01'),(22,'Annuar Mulombi','254703539208','Good morning ANNUAR MULOMBI Your Access Token code is 623870','access_token','sent','Thu, 03 Feb 2022 08:30:34','2022-02-03 05:30:34','2022-02-03 05:30:34'),(23,'woditekuby','254704621587','Good morning WODITEKUBY Your new created account password is 8WFAyu}`{V&<HyDKu,>]','access_token','sent','Thu, 03 Feb 2022 10:37:55','2022-02-03 07:37:55','2022-02-03 07:37:55'),(24,'Samson Wafula','2547','Good morning SAMSON WAFULA Your profile details were successfully updated','access_token','sent','Thu, 03 Feb 2022 11:32:54','2022-02-03 08:32:54','2022-02-03 08:32:54'),(25,'Allan Mwanzia','254725345633','Good morning ALLAN MWANZIA Your new created account password is 2c{[.%lq4.','access_token','sent','Thu, 03 Feb 2022 11:34:40','2022-02-03 08:34:40','2022-02-03 08:34:40'),(26,'Yusuf Chanzu','254708789562','Good morning YUSUF CHANZU Your new created account password is &M#f!,Sl%1','access_token','sent','Thu, 03 Feb 2022 11:47:58','2022-02-03 08:47:58','2022-02-03 08:47:58');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2022_02_01_061313_create_messages_table',1),(7,'2022_02_01_090711_create_profiles_table',1),(8,'2022_02_02_072425_laratrust_setup_tables',2),(9,'2022_02_02_114457_create_audit_trails_table',3),(10,'2022_02_03_055855_add_id_tp_profiles_table',4),(11,'2022_02_03_073548_add_id_time_profiles_table',5),(12,'2022_02_03_084426_add_deleted_at_to_users_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `outposts`
--

DROP TABLE IF EXISTS `outposts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `outposts` (
  `outpost_id` int(11) NOT NULL AUTO_INCREMENT,
  `outpost_name` varchar(100) NOT NULL,
  `office_number` varchar(255) NOT NULL,
  `physical_location` varchar(255) NOT NULL,
  `outpost_branch_id` int(100) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`outpost_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `outposts`
--

LOCK TABLES `outposts` WRITE;
/*!40000 ALTER TABLE `outposts` DISABLE KEYS */;
INSERT INTO `outposts` VALUES (1,'Head Office','0701111700','Majengo Area Behind Chief\'s Camp (Embu)',1,'2020-03-12 15:30:15'),(2,'Embu','0729636080','NHIF Building, 2nd Floor',2,'2020-03-12 15:30:15'),(3,'Runyenjes','0704513152','Next to Mini - Supermarket',2,'2020-03-12 15:30:28'),(4,'Kiritiri','0712516511','Jodi Enterprises Building',3,'2020-03-12 15:31:11'),(5,'Siakago','0723793050','Muriuki Building Opp Peko Petrol Station',3,'2020-03-12 15:31:11'),(6,'Mwea','0724074353','Next to Co-operative Bank',4,'2020-03-12 15:31:50'),(7,'Kerugoya','0727135624','Adjacent to VPP Shah Distributors',5,'2020-03-12 15:31:50'),(8,'Nyeri','0725732843','Peak Business Centre',6,'2020-03-12 15:32:15'),(9,'Nanyuki','0712061023','Behind Ibis Hotel',6,'2020-03-12 15:32:15'),(10,'Nyahururu','0770852499','Mbaria Plaza',7,'2020-03-12 15:32:40'),(11,'Nakuru','0728241864','Indersingh House, Next to Family Bank',8,'2020-03-12 15:32:40'),(12,'Nairobi','0775277960','Enkei Center-Ngara, Same building with KCB',9,'2020-03-12 15:35:16'),(13,'Kasarani','0711647436','Pasuri Plaza Next to KCB',9,'2020-03-12 15:35:16'),(14,'Utawala','0717391142','Master Seed Plaza Opp Family Bank',9,'2020-03-12 15:35:32'),(15,'Rongai','0722427050','Naivas Building, 1st Floor',9,'2020-03-12 15:35:32'),(16,'Kiambu','0721843866','Geoma House Opp Equity Bank',10,'2020-03-12 15:35:52'),(17,'Limuru','0700410030','Next to Metropolitan Sacco',10,'2020-03-12 15:35:52'),(18,'Kitengela','0727689779','Gate House next to Gate Petrol Station',11,'2020-03-12 15:36:26'),(19,'Machakos','0723795810','Kinyari Building, Behind Equity Bank',12,'2020-03-12 15:36:26'),(20,'Masii','0723795810','Kinyari Building, Behind Equity Bank',12,'2020-03-12 15:36:49'),(21,'Tala','0728812157','Fiona Complex Next to KWFT',13,'2020-03-12 15:36:49'),(22,'Makueni','0714360403','Next to KCB',14,'2020-03-12 15:37:30'),(23,'Mwingi','0715576414','Old Pioneer - Hardware House',15,'2020-03-12 15:37:30'),(24,'Matuu','0708211478','Opposite KCB',15,'2020-03-12 15:39:04'),(25,'Kitui','0724387686','C-House Near Maguna Supermarket',16,'2020-03-12 15:39:04'),(26,'Kibwezi','0711487042','Tarabu House',17,'2020-03-12 15:39:41'),(27,'Voi','0723817142','Vision Guest House Next to Equity Bank',17,'2020-03-12 15:39:41'),(28,'Emali','0757925057','Eden Mall Building',18,'2020-03-12 15:40:09'),(29,'Loitokitok','0723076468','Next to Metropolitan Sacco',18,'2020-03-12 15:40:09'),(30,'Chuka','0724229395','Nthiga Plaza Next to KPLC',19,'2020-03-12 15:40:33'),(31,'Marimanti','0722960709','Next to KNUT  Office',19,'2020-03-12 15:40:33'),(32,'Nkubu','0706213643','Kariigi Plaza',20,'2020-03-12 15:40:54'),(33,'Meru','0725681446','BIMAS House Opp Barclays Bank',21,'2020-03-12 15:40:54'),(34,'Mikinduri','0740726138','Mwimbi Building',21,'2020-03-12 15:41:15'),(35,'Maua','0714396224','Next to Forester Fashion',22,'2020-03-12 15:41:15'),(36,'Laare','0723547095','Kimachia Building next to Smart Petrol Station',22,'2020-03-12 15:41:34'),(37,'Thika','','',24,'2020-03-12 15:41:34'),(38,'Murang\'a','','',24,'2020-03-12 15:41:47'),(39,'Karatina','0708654903','Harmony Plaza Next to Equity Bank',6,'2020-03-17 13:11:07'),(40,'Zombe','0724387686','Next to Maximum Miracle Center Church',16,'2020-03-17 13:15:39'),(42,'Thika','0757234576','Biashara Plaza opp. Equity plaza',23,'2021-07-01 08:12:05'),(43,'Murang\'a','0769687146','Muguma building next to Barclays Bank',23,'2021-07-02 11:02:33'),(44,'Taveta','0757234610','Taveta',17,'2021-07-02 11:02:33');
/*!40000 ALTER TABLE `outposts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission_role` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (7,5),(8,6);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_user`
--

DROP TABLE IF EXISTS `permission_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission_user` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  KEY `permission_user_permission_id_foreign` (`permission_id`),
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_user`
--

LOCK TABLES `permission_user` WRITE;
/*!40000 ALTER TABLE `permission_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (7,'approve.travel.expense','approve.travel.expense','approve travel expense','2022-02-02 08:21:02','2022-02-02 08:21:02'),(8,'download.travel.expense','download.travel.expense','download travel expense','2022-02-02 08:22:53','2022-02-02 08:22:53');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles` (
  `profile_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `county` int(11) NOT NULL,
  `sub_county` int(11) NOT NULL,
  `branch` int(11) NOT NULL,
  `outpost` int(11) NOT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `religion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `national_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`profile_id`),
  UNIQUE KEY `profiles_national_id_unique` (`national_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,1,'male','1990-05-13',21,131,1,1,'0703539208','Christian','P.O Box 2299, Embu','avatar.png','',NULL,NULL),(2,3,'male','2009-02-23',14,72,2,2,'0704621587','Christian','P.O Box 2299','avatar.png','39635623','2022-02-03 04:37:51','2022-02-03 05:32:53'),(3,4,'male','1998-03-02',28,178,18,29,'0725345633','Christian','P.O Box 2299','avatar.png','36789459','2022-02-03 05:34:35','2022-02-03 05:34:35'),(4,5,'male','1971-10-09',42,274,19,30,'0708789562','Islamist','P.O Box 2299','avatar.png','0708789562','2022-02-03 05:47:53','2022-02-03 05:47:53');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_user` (
  `role_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (2,1,'App\\Models\\User'),(3,1,'App\\Models\\User'),(3,2,'App\\Models\\User'),(3,3,'App\\Models\\User'),(3,4,'App\\Models\\User'),(3,5,'App\\Models\\User'),(4,1,'App\\Models\\User'),(4,3,'App\\Models\\User'),(5,1,'App\\Models\\User');
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (2,'admin','admin','Super admin role','2022-02-02 06:49:01','2022-02-02 06:53:20'),(3,'credit officer','credit officer','Credit Officer role','2022-02-02 06:50:40','2022-02-02 06:53:07'),(4,'hr assistant','hr assistant','HR and Admin role','2022-02-02 06:52:19','2022-02-02 06:53:36'),(5,'branch manager','Branch Manager','Branch Managers role','2022-02-02 06:52:58',NULL),(6,'finance','Finance','Finance role','2022-02-02 06:54:35',NULL),(8,'bimas staff','bimas staff','Bimas staff default role','2022-02-03 09:19:39',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_counties`
--

DROP TABLE IF EXISTS `sub_counties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_counties` (
  `sub_id` int(11) NOT NULL,
  `county_id` int(11) NOT NULL,
  `county_name` varchar(30) DEFAULT NULL,
  `sub_name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_counties`
--

LOCK TABLES `sub_counties` WRITE;
/*!40000 ALTER TABLE `sub_counties` DISABLE KEYS */;
INSERT INTO `sub_counties` VALUES (1,1,'Mombasa ','CHANGAMWE \r'),(2,1,'Mombasa ','JOMVU \r'),(3,1,'Mombasa ','KISAUNI \r'),(4,1,'Mombasa ','LIKONI \r'),(5,1,'Mombasa ','MVITA (MOMBASA) \r'),(6,1,'Mombasa ','NYALI \r'),(7,2,'Kwale ','KINANGO \r'),(8,2,'Kwale ','KWALE \r'),(9,2,'Kwale ','LUNGA LUNGA \r'),(10,2,'Kwale ','MSAMBWENI \r'),(11,3,'Kilifi ','BAHARI (KILIFI) \r'),(12,3,'Kilifi ','GANZE \r'),(13,3,'Kilifi ','KALOLENI \r'),(14,3,'Kilifi ','KILIFI SOUTH \r'),(15,3,'Kilifi ','MAGARINI \r'),(16,3,'Kilifi ','MALINDI \r'),(17,3,'Kilifi ','RABAI \r'),(18,4,'Tana River ','BURA (TANA NORTH) \r'),(19,4,'Tana River ','TANA DELTA \r'),(20,4,'Tana River ','TANA RIVER \r'),(21,5,'Lamu ','LAMU EAST \r'),(22,5,'Lamu ','LAMU WEST \r'),(23,6,'Taita Taveta ','MWATATE \r'),(24,6,'Taita Taveta ','TAVETA \r'),(25,6,'Taita Taveta ','VOI \r'),(26,6,'Taita Taveta ','WUNDANYI (TAITA) \r'),(27,7,'Garissa ','BALAMBALA \r'),(28,7,'Garissa ','DADAAB \r'),(29,7,'Garissa ','FAFI \r'),(30,7,'Garissa ','GARISSA \r'),(31,7,'Garissa ','HULUGHO \r'),(32,7,'Garissa ','IJARA \r'),(33,7,'Garissa ','LAGDERA \r'),(34,8,'Wajir ','BUNA \r'),(35,8,'Wajir ','ELDAS \r'),(36,8,'Wajir ','HABASWEIN \r'),(37,8,'Wajir ','TARBAJ \r'),(38,8,'Wajir ','WAJIR EAST \r'),(39,8,'Wajir ','WAJIR NORTH \r'),(40,8,'Wajir ','WAJIR SOUTH \r'),(41,8,'Wajir ','WAJIR WEST \r'),(42,9,'Mandera ','BANISA \r'),(43,9,'Mandera ','LAFEY \r'),(44,9,'Mandera ','MANDERA CENTRAL \r'),(45,9,'Mandera ','MANDERA EAST \r'),(46,9,'Mandera ','MANDERA NORTH \r'),(47,9,'Mandera ','MANDERA WEST \r'),(48,10,'Marsabit ','CHALBI \r'),(49,10,'Marsabit ','HORR NORTH \r'),(50,10,'Marsabit ','LOIYANGALANI \r'),(51,10,'Marsabit ','MARSABIT \r'),(52,10,'Marsabit ','MARSABIT SOUTH (LAISAMIS) \r'),(53,10,'Marsabit ','MOYALE \r'),(54,10,'Marsabit ','SOLOLO \r'),(55,11,'Isiolo ','GARBATULA \r'),(56,11,'Isiolo ','ISIOLO \r'),(57,11,'Isiolo ','MERTI \r'),(58,12,'Meru ','BUURI \r'),(59,12,'Meru ','IGEMBE CENTRAL \r'),(60,12,'Meru ','IGEMBE NORTH \r'),(61,12,'Meru ','IGEMBE SOUTH \r'),(62,12,'Meru ','IMENTI NORTH \r'),(63,12,'Meru ','IMENTI SOUTH \r'),(64,12,'Meru ','MERU CENTRAL \r'),(65,12,'Meru ','TIGANIA CENTRAL \r'),(66,12,'Meru ','TIGANIA EAST \r'),(67,12,'Meru ','TIGANIA WEST \r'),(68,13,'Tharaka-Nithi ','MAARA \r'),(69,13,'Tharaka-Nithi ','MERU SOUTH \r'),(70,13,'Tharaka-Nithi ','THARAKA NORTH \r'),(71,13,'Tharaka-Nithi ','THARAKA SOUTH \r'),(72,14,'Embu ','EMBU EAST \r'),(73,14,'Embu ','EMBU NORTH \r'),(74,14,'Embu ','EMBU WEST \r'),(75,14,'Embu ','MBEERE NORTH \r'),(76,14,'Embu ','MBEERE SOUTH \r'),(77,15,'Kitui ','IKUTHA \r'),(78,15,'Kitui ','KATULANI \r'),(79,15,'Kitui ','KISASI \r'),(80,15,'Kitui ','KITUI CENTRAL \r'),(81,15,'Kitui ','KITUI WEST \r'),(82,15,'Kitui ','KYUSO \r'),(83,15,'Kitui ','LOWER YATTA \r'),(84,15,'Kitui ','MATINYANI \r'),(85,15,'Kitui ','MUMONI \r'),(86,15,'Kitui ','MUTITO \r'),(87,15,'Kitui ','MUTOMO \r'),(88,15,'Kitui ','MWINGI CENTRAL \r'),(89,15,'Kitui ','MWINGI EAST \r'),(90,15,'Kitui ','MWINGI WEST /MIGWANI \r'),(91,15,'Kitui ','NZAMBANI \r'),(92,15,'Kitui ','TSEIKURU \r'),(93,16,'Machakos ','ATHI RIVER \r'),(94,16,'Machakos ','KANGUNDO \r'),(95,16,'Machakos ','KATHIANI \r'),(96,16,'Machakos ','MACHAKOS \r'),(97,16,'Machakos ','MASINGA \r'),(98,16,'Machakos ','MATUNGULU \r'),(99,16,'Machakos ','MWALA \r'),(100,16,'Machakos ','YATTA \r'),(101,17,'Makueni ','KATHONZWENI \r'),(102,17,'Makueni ','KIBWEZI \r'),(103,17,'Makueni ','KILUNGU \r'),(104,17,'Makueni ','MAKINDU \r'),(105,17,'Makueni ','MAKUENI \r'),(106,17,'Makueni ','MBOONI EAST \r'),(107,17,'Makueni ','MBOONI WEST \r'),(108,17,'Makueni ','MUKAA \r'),(109,17,'Makueni ','NZAUI \r'),(110,18,'Nyandarua ','KINANGOP \r'),(111,18,'Nyandarua ','KIPIPIRI \r'),(112,18,'Nyandarua ','MIRANGINE \r'),(113,18,'Nyandarua ','NYANDARUA CENTRAL \r'),(114,18,'Nyandarua ','NYANDARUA NORTH \r'),(115,18,'Nyandarua ','NYANDARUA SOUTH \r'),(116,18,'Nyandarua ','NYANDARUA WEST \r'),(117,19,'Nyeri ','KIENI EAST \r'),(118,19,'Nyeri ','KIENI WEST \r'),(119,19,'Nyeri ','MATHIRA EAST \r'),(120,19,'Nyeri ','MATHIRA WEST \r'),(121,19,'Nyeri ','MUKURWE-INI \r'),(122,19,'Nyeri ','NYERI CENTRAL \r'),(123,19,'Nyeri ','NYERI SOUTH \r'),(124,19,'Nyeri ','TETU \r'),(125,20,'Kirinyaga ','KIRINYAGA CENTRAL \r'),(126,20,'Kirinyaga ','KIRINYAGA EAST \r'),(127,20,'Kirinyaga ','KIRINYAGA WEST \r'),(128,20,'Kirinyaga ','MWEA EAST \r'),(129,20,'Kirinyaga ','MWEA WEST \r'),(130,21,'Murang\'a ','GATANGA \r'),(131,21,'Murang\'a ','KAHURO \r'),(132,21,'Murang\'a ','KANDARA \r'),(133,21,'Murang\'a ','KANGEMA \r'),(134,21,'Murang\'a ','KIGUMO \r'),(135,21,'Murang\'a ','MATHIOYA \r'),(136,21,'Murang\'a ','MURANG\'A EAST \r'),(137,21,'Murang\'a ','MURANG\'A SOUTH \r'),(138,22,'Kiambu ','GATUNDU NORTH \r'),(139,22,'Kiambu ','GATUNDU SOUTH \r'),(140,22,'Kiambu ','GITHUNGURI \r'),(141,22,'Kiambu ','JUJA \r'),(142,22,'Kiambu ','KABETE \r'),(143,22,'Kiambu ','KIAMBAA \r'),(144,22,'Kiambu ','KIAMBU \r'),(145,22,'Kiambu ','KIKUYU \r'),(146,22,'Kiambu ','LARI \r'),(147,22,'Kiambu ','LIMURU \r'),(148,22,'Kiambu ','RUIRU \r'),(149,22,'Kiambu ','THIKA EAST \r'),(150,22,'Kiambu ','THIKA WEST \r'),(151,23,'Turkana ','KIBISH \r'),(152,23,'Turkana ','LOIMA \r'),(153,23,'Turkana ','TURKANA CENTRAL \r'),(154,23,'Turkana ','TURKANA EAST \r'),(155,23,'Turkana ','TURKANA NORTH \r'),(156,23,'Turkana ','TURKANA SOUTH \r'),(157,23,'Turkana ','TURKANA WEST \r'),(158,24,'West Pokot ','KIPKOMO \r'),(159,24,'West Pokot ','POKOT CENTRAL \r'),(160,24,'West Pokot ','POKOT NORTH \r'),(161,24,'West Pokot ','POKOT SOUTH \r'),(162,24,'West Pokot ','WEST POKOT \r'),(163,25,'Samburu ','SAMBURU CENTRAL \r'),(164,25,'Samburu ','SAMBURU EAST \r'),(165,25,'Samburu ','SAMBURU NORTH \r'),(166,26,'Trans Nzoia ','ENDEBES \r'),(167,26,'Trans Nzoia ','KIMININI \r'),(168,26,'Trans Nzoia ','KWANZA \r'),(169,26,'Trans Nzoia ','TRANS NZOIA EAST \r'),(170,26,'Trans Nzoia ','TRANS NZOIA WEST \r'),(171,27,'Uasin Gishu ','ELDORET EAST \r'),(172,27,'Uasin Gishu ','ELDORET WEST \r'),(173,27,'Uasin Gishu ','KESSES \r'),(174,27,'Uasin Gishu ','MOIBEN \r'),(175,27,'Uasin Gishu ','SOY \r'),(176,27,'Uasin Gishu ','WARENG \r'),(177,28,'Elgeyo Marakwet ','KEIYO \r'),(178,28,'Elgeyo Marakwet ','KEIYO SOUTH \r'),(179,28,'Elgeyo Marakwet ','MARAKWET EAST \r'),(180,28,'Elgeyo Marakwet ','MARAKWET WEST \r'),(181,29,'Nandi ','CHESUMEI \r'),(182,29,'Nandi ','NANDI CENTRAL \r'),(183,29,'Nandi ','NANDI EAST \r'),(184,29,'Nandi ','NANDI NORTH \r'),(185,29,'Nandi ','NANDI SOUTH \r'),(186,29,'Nandi ','TINDERET \r'),(187,30,'Baringo ','BARINGO CENTRAL \r'),(188,30,'Baringo ','BARINGO NORTH \r'),(189,30,'Baringo ','EAST POKOT \r'),(190,30,'Baringo ','KOIBATEK \r'),(191,30,'Baringo ','MARIGAT \r'),(192,30,'Baringo ','MOGOTIO \r'),(193,31,'Laikipia ','LAIKIPIA CENTRAL \r'),(194,31,'Laikipia ','LAIKIPIA EAST \r'),(195,31,'Laikipia ','LAIKIPIA NORTH \r'),(196,31,'Laikipia ','LAIKIPIA WEST \r'),(197,31,'Laikipia ','NYAHURURU \r'),(198,32,'Nakuru ','GILGIL \r'),(199,32,'Nakuru ','KURESOI \r'),(200,32,'Nakuru ','KURESOI NORTH \r'),(201,32,'Nakuru ','MOLO \r'),(202,32,'Nakuru ','NAIVASHA \r'),(203,32,'Nakuru ','NAKURU EAST \r'),(204,32,'Nakuru ','NAKURU NORTH \r'),(205,32,'Nakuru ','NAKURU WEST \r'),(206,32,'Nakuru ','NJORO \r'),(207,32,'Nakuru ','RONGAI \r'),(208,32,'Nakuru ','SUBUKIA \r'),(209,33,'Narok ','NAROK EAST \r'),(210,33,'Narok ','NAROK NORTH \r'),(211,33,'Narok ','NAROK SOUTH \r'),(212,33,'Narok ','NAROK WEST \r'),(213,33,'Narok ','TRANS MARA EAST \r'),(214,33,'Narok ','TRANS MARA WEST \r'),(215,34,'Kajiado ','ISINYA \r'),(216,34,'Kajiado ','KAJIADO CENTRAL \r'),(217,34,'Kajiado ','KAJIADO NORTH \r'),(218,34,'Kajiado ','KAJIADO WEST \r'),(219,34,'Kajiado ','LOITOKITOK \r'),(220,34,'Kajiado ','MASHUURU \r'),(221,35,'Kericho ','BELGUT \r'),(222,35,'Kericho ','BURETI \r'),(223,35,'Kericho ','KERICHO \r'),(224,35,'Kericho ','KIPKELION \r'),(225,35,'Kericho ','LONDIANI \r'),(226,35,'Kericho ','SIGOWEI / SOIN \r'),(227,36,'Bomet ','BOMET \r'),(228,36,'Bomet ','BOMET EAST \r'),(229,36,'Bomet ','CHEPALUNGU \r'),(230,36,'Bomet ','KONOIN \r'),(231,36,'Bomet ','SOTIK \r'),(232,37,'Kakamega ','BUTERE \r'),(233,37,'Kakamega ','KAKAMEGA CENTRAL \r'),(234,37,'Kakamega ','KAKAMEGA EAST \r'),(235,37,'Kakamega ','KAKAMEGA NORTH \r'),(236,37,'Kakamega ','KAKAMEGA SOUTH \r'),(237,37,'Kakamega ','KHWISERO \r'),(238,37,'Kakamega ','LIKUYANI \r'),(239,37,'Kakamega ','LUGARI \r'),(240,37,'Kakamega ','MATETE \r'),(241,37,'Kakamega ','MATUNGU \r'),(242,37,'Kakamega ','MUMIAS \r'),(243,37,'Kakamega ','MUMIAS EAST \r'),(244,37,'Kakamega ','NAVAKHOLO \r'),(245,38,'Vihiga ','EMUHAYA \r'),(246,38,'Vihiga ','HAMISI \r'),(247,38,'Vihiga ','LUANDA \r'),(248,38,'Vihiga ','SABATIA \r'),(249,38,'Vihiga ','VIHIGA \r'),(250,39,'Bungoma ','BUMULA \r'),(251,39,'Bungoma ','BUNGOMA CENTRAL \r'),(252,39,'Bungoma ','BUNGOMA EAST \r'),(253,39,'Bungoma ','BUNGOMA NORTH \r'),(254,39,'Bungoma ','BUNGOMA SOUTH \r'),(255,39,'Bungoma ','BUNGOMA WEST \r'),(256,39,'Bungoma ','CHEPTAIS \r'),(257,39,'Bungoma ','KIMILILI \r'),(258,39,'Bungoma ','MT ELGON \r'),(259,39,'Bungoma ','WEBUYE WEST \r'),(260,40,'Busia ','BUNYALA \r'),(261,40,'Busia ','BUSIA \r'),(262,40,'Busia ','BUTULA \r'),(263,40,'Busia ','NAMBALE \r'),(264,40,'Busia ','SAMIA \r'),(265,40,'Busia ','TESO NORTH \r'),(266,40,'Busia ','TESO SOUTH \r'),(267,41,'Siaya ','BONDO \r'),(268,41,'Siaya ','GEM \r'),(269,41,'Siaya ','RARIEDA \r'),(270,41,'Siaya ','SIAYA \r'),(271,41,'Siaya ','UGENYA \r'),(272,41,'Siaya ','UGUNJA \r'),(273,42,'Kisumu ','KISUMU CENTRAL \r'),(274,42,'Kisumu ','KISUMU EAST \r'),(275,42,'Kisumu ','KISUMU WEST \r'),(276,42,'Kisumu ','MUHORONI \r'),(277,42,'Kisumu ','NYAKACH \r'),(278,42,'Kisumu ','NYANDO \r'),(279,42,'Kisumu ','SEME \r'),(280,43,'Homa Bay ','HOMA BAY \r'),(281,43,'Homa Bay ','MBITA \r'),(282,43,'Homa Bay ','NDHIWA \r'),(283,43,'Homa Bay ','RACHUONYO EAST \r'),(284,43,'Homa Bay ','RACHUONYO NORTH \r'),(285,43,'Homa Bay ','RACHUONYO SOUTH \r'),(286,43,'Homa Bay ','RANGWE \r'),(287,43,'Homa Bay ','SUBA \r'),(288,44,'Migori ','AWENDO \r'),(289,44,'Migori ','KURIA EAST \r'),(290,44,'Migori ','KURIA WEST \r'),(291,44,'Migori ','MIGORI \r'),(292,44,'Migori ','NYATIKE \r'),(293,44,'Migori ','RONGO \r'),(294,44,'Migori ','SUNA WEST \r'),(295,44,'Migori ','URIRI \r'),(296,45,'Kisii ','GUCHA \r'),(297,45,'Kisii ','GUCHA SOUTH \r'),(298,45,'Kisii ','KENYENYA \r'),(299,45,'Kisii ','KISII CENTRAL \r'),(300,45,'Kisii ','KISII SOUTH \r'),(301,45,'Kisii ','KITUTU CENTRAL \r'),(302,45,'Kisii ','MARANI \r'),(303,45,'Kisii ','MASABA SOUTH \r'),(304,45,'Kisii ','NYAMACHE \r'),(305,45,'Kisii ','SAMETA \r'),(306,46,'Nyamira ','BORABU \r'),(307,46,'Nyamira ','MANGA \r'),(308,46,'Nyamira ','MASABA NORTH \r'),(309,46,'Nyamira ','NYAMIRA NORTH \r'),(310,46,'Nyamira ','NYAMIRA SOUTH \r'),(311,47,'Nairobi ','DAGORETTI \r'),(312,47,'Nairobi ','EMBAKASI \r'),(313,47,'Nairobi ','KAMUKUNJI \r'),(314,47,'Nairobi ','KASARANI \r'),(315,47,'Nairobi ','KIBRA \r'),(316,47,'Nairobi ','LANGATA \r'),(317,47,'Nairobi ','MAKADARA \r'),(318,47,'Nairobi ','MATHARE \r'),(319,47,'Nairobi ','NJIRU \r'),(320,47,'Nairobi ','STAREHE \r'),(321,47,'Nairobi ','WESTLANDS \r');
/*!40000 ALTER TABLE `sub_counties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `accessibility` int(11) NOT NULL DEFAULT '1',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Annuar Mulombi','mulombiannuar@gmail.com',NULL,1,0,'$2y$10$eiKxdAj/56pGoWHoeTv2o.uTWh.9/mIizkASMi8NjglZb765tb3Be',NULL,NULL,'SohGiDF0kz9iiWSZKODqTzivuiAsDwFkWdPFRVPLHwB0HLJGFQBz65x8JKkx','2021-05-13 06:15:52','2022-02-02 09:41:38',NULL),(3,'Samson Wafula','ryhanedi@mailinator.com',NULL,1,1,'$2y$10$pZkOtRSnmyHH/yDGfKo.Du5rEN1loen3SqYklmoDyuZKeOrNiOkde',NULL,NULL,NULL,'2022-02-03 04:37:50','2022-02-03 05:30:06',NULL),(4,'Allan Mwanzia','amwanzia@bimaskenya.com',NULL,1,1,'$2y$10$T.YYmozPA5ukA4YrhCkVe.p7XSREE1AQ8dU3QOvwMRAtWRhlYvxWS',NULL,NULL,NULL,'2022-02-03 05:34:35','2022-02-03 05:34:35',NULL),(5,'Yusuf Chanzu','qejadoj@mailinator.com',NULL,1,1,'$2y$10$Bu3fZ.nKbwUZspB0VauDCOelJ5M/FkviHsq58ccpnbBoc5nSEBNTC',NULL,NULL,NULL,'2022-02-03 05:47:53','2022-02-03 05:56:00','2022-02-03 05:56:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-03 15:49:46
