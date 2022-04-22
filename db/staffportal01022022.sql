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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 496339','access_token','sent','Tue, 01 Feb 2022 13:20:23','2022-02-01 10:20:24','2022-02-01 10:20:24'),(2,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 918385','access_token','sent','Tue, 01 Feb 2022 13:35:41','2022-02-01 10:35:41','2022-02-01 10:35:41'),(3,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 170491','access_token','sent','Tue, 01 Feb 2022 13:45:46','2022-02-01 10:45:46','2022-02-01 10:45:46'),(4,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 590035','access_token','sent','Tue, 01 Feb 2022 13:47:19','2022-02-01 10:47:19','2022-02-01 10:47:19'),(5,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 904048','access_token','sent','Tue, 01 Feb 2022 14:03:15','2022-02-01 11:03:15','2022-02-01 11:03:15'),(6,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 075665','access_token','sent','Tue, 01 Feb 2022 14:05:48','2022-02-01 11:05:48','2022-02-01 11:05:48'),(7,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 458395','access_token','sent','Tue, 01 Feb 2022 14:07:39','2022-02-01 11:07:39','2022-02-01 11:07:39'),(8,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 508877','access_token','sent','Tue, 01 Feb 2022 14:08:34','2022-02-01 11:08:34','2022-02-01 11:08:34'),(9,'Annuar Mulombi','254703539208','Good afternoon ANNUAR MULOMBI Your Access Token code is 762474','access_token','sent','Tue, 01 Feb 2022 14:46:20','2022-02-01 11:46:20','2022-02-01 11:46:20'),(10,'Annuar Mulombi','254703539208','Good evening ANNUAR MULOMBI Your Access Token code is 233248','access_token','sent','Tue, 01 Feb 2022 17:13:57','2022-02-01 14:13:57','2022-02-01 14:13:57'),(11,'Annuar Mulombi','254703539208','Good evening ANNUAR MULOMBI Your Access Token code is 067152','access_token','sent','Tue, 01 Feb 2022 17:16:11','2022-02-01 14:16:11','2022-02-01 14:16:11');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2022_02_01_061313_create_messages_table',1),(7,'2022_02_01_090711_create_profiles_table',1);
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
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,1,'male','1990-05-13',21,131,1,1,'0703539208','Christian','P.O Box 2299, Embu','avatar.png');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Annuar Mulombi','mulombiannuar@gmail.com',NULL,1,0,'$2y$10$MT.Bu0yXUas9NyQ8lPrHC.3arXQARm3/iTal3IA/ZJIXbpYAOhUau',NULL,NULL,'wv4fXtiyxFSARfbqKNbIyM8ltdHRex60wMw3tE0hupGxiEA3kTjGmMDuv1n4','2021-05-13 06:15:52','2022-02-01 11:38:04');
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

-- Dump completed on 2022-02-01 18:04:27
