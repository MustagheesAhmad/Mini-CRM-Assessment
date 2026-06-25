-- MySQL dump 10.13  Distrib 9.7.1, for macos26.4 (arm64)
--
-- Host: localhost    Database: mini_crm
-- ------------------------------------------------------
-- Server version	9.7.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
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
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lead_conversions`
--

DROP TABLE IF EXISTS `lead_conversions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lead_conversions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` bigint unsigned NOT NULL,
  `lead_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `converted_by` bigint unsigned NOT NULL,
  `converted_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lead_conversions_converted_by_foreign` (`converted_by`),
  KEY `lead_conversions_lead_id_index` (`lead_id`),
  CONSTRAINT `lead_conversions_converted_by_foreign` FOREIGN KEY (`converted_by`) REFERENCES `users` (`id`),
  CONSTRAINT `lead_conversions_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lead_conversions`
--

LOCK TABLES `lead_conversions` WRITE;
/*!40000 ALTER TABLE `lead_conversions` DISABLE KEYS */;
/*!40000 ALTER TABLE `lead_conversions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lead_notes`
--

DROP TABLE IF EXISTS `lead_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lead_notes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lead_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lead_notes_user_id_foreign` (`user_id`),
  KEY `lead_notes_lead_id_created_at_index` (`lead_id`,`created_at`),
  CONSTRAINT `lead_notes_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  CONSTRAINT `lead_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lead_notes`
--

LOCK TABLES `lead_notes` WRITE;
/*!40000 ALTER TABLE `lead_notes` DISABLE KEYS */;
INSERT INTO `lead_notes` VALUES (6,3,2,'Very interested from the first call. Budget already approved.','2026-06-25 13:15:00'),(7,3,2,'Sent contract for review. Legal team is going through it.','2026-06-25 13:45:00'),(8,3,1,'Contract signed. Onboarding scheduled for next week. Great win!','2026-06-25 14:15:00'),(9,4,1,'Came in through LinkedIn ad. Requested a demo for next week.','2026-06-25 13:15:00'),(10,8,1,'Hello','2026-06-25 14:10:29'),(11,8,1,'Hello','2026-06-25 14:11:38'),(12,8,1,'This is good','2026-06-25 14:11:43'),(13,8,1,'Ok','2026-06-25 14:11:57'),(14,8,2,'The lead will close at 10:00 PM !!!!','2026-06-25 14:15:11'),(15,10,2,'Initial enquiry received. Will follow up within 48 hours.','2026-05-26 14:16:50'),(16,11,2,'Had an introductory call. Prospect is evaluating options and will get back to us.','2026-05-27 14:16:50'),(17,12,2,'Deal closed successfully. Onboarding kicked off.','2026-05-28 14:16:50'),(18,13,1,'Initial enquiry received. Will follow up within 48 hours.','2026-05-29 14:16:50'),(19,14,2,'Had an introductory call. Prospect is evaluating options and will get back to us.','2026-05-30 14:16:50'),(20,15,2,'Initial enquiry received. Will follow up within 48 hours.','2026-05-31 14:16:50'),(21,16,1,'Deal closed successfully. Onboarding kicked off.','2026-06-01 14:16:50'),(22,17,2,'Had an introductory call. Prospect is evaluating options and will get back to us.','2026-06-02 14:16:50'),(23,18,1,'Initial enquiry received. Will follow up within 48 hours.','2026-06-03 14:16:50'),(24,19,2,'Initial enquiry received. Will follow up within 48 hours.','2026-06-04 14:16:50'),(25,20,2,'Had an introductory call. Prospect is evaluating options and will get back to us.','2026-06-05 14:16:50'),(26,21,2,'Deal closed successfully. Onboarding kicked off.','2026-06-06 14:16:50'),(29,24,2,'Deal closed successfully. Onboarding kicked off.','2026-06-09 14:16:50'),(30,25,2,'Initial enquiry received. Will follow up within 48 hours.','2026-06-10 14:16:50'),(31,26,1,'Had an introductory call. Prospect is evaluating options and will get back to us.','2026-06-11 14:16:50'),(32,27,2,'Initial enquiry received. Will follow up within 48 hours.','2026-06-12 14:16:50'),(33,28,2,'Deal closed successfully. Onboarding kicked off.','2026-06-13 14:16:50'),(34,29,2,'Had an introductory call. Prospect is evaluating options and will get back to us.','2026-06-14 14:16:50'),(35,30,1,'Initial enquiry received. Will follow up within 48 hours.','2026-06-15 14:16:50'),(36,31,2,'Deal closed successfully. Onboarding kicked off.','2026-06-16 14:16:50'),(37,32,2,'Had an introductory call. Prospect is evaluating options and will get back to us.','2026-06-17 14:16:50'),(38,33,2,'Initial enquiry received. Will follow up within 48 hours.','2026-06-18 14:16:50'),(39,34,1,'Deal closed successfully. Onboarding kicked off.','2026-06-19 14:16:50'),(40,35,2,'Had an introductory call. Prospect is evaluating options and will get back to us.','2026-06-20 14:16:50'),(41,36,2,'Initial enquiry received. Will follow up within 48 hours.','2026-06-21 14:16:50'),(43,38,1,'Deal closed successfully. Onboarding kicked off.','2026-06-23 14:16:50'),(44,39,2,'Initial enquiry received. Will follow up within 48 hours.','2026-06-24 14:16:50'),(45,41,1,'Hello','2026-06-25 15:00:42');
/*!40000 ALTER TABLE `lead_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','contacted','converted') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `assigned_to` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leads_created_by_foreign` (`created_by`),
  KEY `leads_status_index` (`status`),
  KEY `leads_assigned_to_index` (`assigned_to`),
  CONSTRAINT `leads_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `leads_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leads`
--

LOCK TABLES `leads` WRITE;
/*!40000 ALTER TABLE `leads` DISABLE KEYS */;
INSERT INTO `leads` VALUES (3,'David Kim','david.kim@startup.co','+1-312-555-0148','converted',2,1,'2026-06-25 13:15:00','2026-06-25 14:35:27','2026-06-25 14:35:27'),(4,'Emily Johnson','emily.j@globalretail.com','+1-646-555-0103','new',NULL,1,'2026-06-25 13:15:00','2026-06-25 13:15:00',NULL),(7,'Syed Mustgees Ahmad','smustgheesahmed@gmail.com','03338632260','converted',NULL,1,'2026-06-25 13:53:33','2026-06-25 14:01:04',NULL),(8,'Syed Mustgees Ahmad','smustgheesahmed@gmail.com','03338632260','contacted',2,1,'2026-06-25 13:54:08','2026-06-25 14:14:25',NULL),(10,'Liam Anderson','liam.anderson@nexustech.com','+1-503-555-0121','new',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(11,'Olivia Brown','olivia.brown@brightmedia.io','+1-617-555-0134','contacted',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(12,'Noah Williams','noah.w@alphalogistics.net','+1-214-555-0177','converted',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(13,'Emma Jones','emma.jones@vertexsolutions.com','+1-713-555-0188','new',NULL,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(14,'William Davis','william.davis@cloudpeak.io','+1-312-555-0145','contacted',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(15,'Ava Miller','ava.miller@horizonretail.com','+1-404-555-0162','new',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(16,'James Wilson','james.wilson@summitgroup.co','+1-206-555-0193','converted',NULL,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(17,'Isabella Moore','isabella.m@prismanalytics.com','+1-602-555-0116','contacted',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(18,'Oliver Taylor','oliver.t@blueridgefinance.com','+1-702-555-0129','new',NULL,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(19,'Sophia Thomas','sophia.t@zenithcorp.net','+1-512-555-0154','new',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(20,'Benjamin Jackson','ben.jackson@aurorainc.com','+1-303-555-0167','contacted',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(21,'Mia White','mia.white@cascadedigital.io','+1-801-555-0180','converted',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(24,'Lucas Thompson','lucas.t@polarstarsystems.net','+1-480-555-0158','converted',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(25,'Amelia Garcia','amelia.g@crestlinetech.com','+1-720-555-0173','new',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(26,'Mason Martinez','mason.m@harborwave.io','+1-954-555-0186','contacted',NULL,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(27,'Harper Robinson','harper.r@ironwoodconsulting.com','+1-571-555-0119','new',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(28,'Ethan Clark','ethan.c@solsticemarketing.com','+1-469-555-0132','converted',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(29,'Evelyn Rodriguez','evelyn.r@apexbuilders.net','+1-253-555-0147','contacted',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(30,'Alexander Lewis','alex.l@northstarenterprise.com','+1-347-555-0163','new',NULL,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(31,'Abigail Lee','abigail.l@sterlingsolutions.io','+1-816-555-0176','converted',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(32,'Michael Walker','michael.w@cobaltventures.com','+1-561-555-0189','contacted',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(33,'Emily Hall','emily.h@vanguarddigital.net','+1-773-555-0122','new',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(34,'Daniel Allen','daniel.a@tidewatersystems.com','+1-630-555-0135','converted',NULL,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(35,'Sofia Young','sofia.y@crescentlabs.io','+1-907-555-0148','contacted',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(36,'Matthew Hernandez','matt.h@keystonegroup.com','+1-228-555-0161','new',2,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(38,'Henry Wright','henry.w@silverlakecorp.com','+1-239-555-0187','converted',NULL,1,'2026-06-25 14:16:50','2026-06-25 14:16:50',NULL),(39,'Luna Scottttt','luna.s@tridentinnovations.io','+1-518-555-0110','new',2,1,'2026-06-25 14:16:50','2026-06-25 14:21:05',NULL),(40,'John Doe','john@example.com','+1-555-0100','new',2,1,'2026-06-25 14:57:49','2026-06-25 14:57:49',NULL),(41,'John Doe','john@example.com','+1-555-0100','new',2,1,'2026-06-25 14:59:15','2026-06-25 14:59:15',NULL);
/*!40000 ALTER TABLE `leads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_06_25_133320_create_personal_access_tokens_table',1),(5,'2026_06_25_133400_create_leads_table',1),(6,'2026_06_25_133401_create_lead_notes_table',1),(7,'2026_06_25_133402_create_lead_conversions_table',1),(8,'2026_06_25_193107_add_soft_deletes_to_leads_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',2,'web-session','ecbc05eaa2b4a99ed76572b791953507dc4a8537cdc01b6718598c390ee4ced0','[\"*\"]',NULL,NULL,'2026-06-25 13:18:48','2026-06-25 13:18:48'),(2,'App\\Models\\User',1,'web-session','3160087bd9982aa25f39552984426029ce8a98e9ec4aaff53f25fdcf25c20363','[\"*\"]',NULL,NULL,'2026-06-25 13:22:25','2026-06-25 13:22:25'),(3,'App\\Models\\User',1,'web-session','2c70712dcf6a94e263accfb75d016d9e10cdc78b216996c7e9ec28f0088fbb6e','[\"*\"]',NULL,NULL,'2026-06-25 13:36:01','2026-06-25 13:36:01'),(4,'App\\Models\\User',1,'web-session','8b5e19a77df157747806d6908f2d423d687a0bf9d977cf6dd2c7f9fdff90e0f0','[\"*\"]',NULL,NULL,'2026-06-25 13:45:46','2026-06-25 13:45:46'),(5,'App\\Models\\User',2,'web-session','5b240f46cc1b77c8765b03119e49c20e824048422f5c0dd139fc8ae920f4cd29','[\"*\"]',NULL,NULL,'2026-06-25 14:01:54','2026-06-25 14:01:54'),(6,'App\\Models\\User',1,'web-session','a5b2419b2f1e7558bd837fd9399a625756f237b76ae4be7627e92307000781b5','[\"*\"]',NULL,NULL,'2026-06-25 14:07:20','2026-06-25 14:07:20'),(7,'App\\Models\\User',2,'web-session','2881db04342f8b1c633d5df2fc8019027e569799ac8ff7ec1451e0aec1973aa6','[\"*\"]',NULL,NULL,'2026-06-25 14:12:41','2026-06-25 14:12:41'),(8,'App\\Models\\User',1,'web-session','2bb8a082876eb8531861369a08f10a265b042274d5bb0ac649809752c90d5722','[\"*\"]',NULL,NULL,'2026-06-25 14:14:16','2026-06-25 14:14:16'),(9,'App\\Models\\User',2,'web-session','c3fa2ffab91b84722cb6fbb9e1c88774c9b9fb09df4f7af9679a3ecf1bb10ddf','[\"*\"]',NULL,NULL,'2026-06-25 14:14:48','2026-06-25 14:14:48'),(10,'App\\Models\\User',1,'web-session','ac4bc8f9877dbd621ed6bad783313d69013f4e7f2a7cb4e03c8fbae34e8ca2f8','[\"*\"]',NULL,NULL,'2026-06-25 14:15:19','2026-06-25 14:15:19'),(11,'App\\Models\\User',1,'web','e2d3ff86d8d304a0d3d847025f1e104ecdf0eefdcd5f4fdc827836f7e1de6799','[\"*\"]',NULL,NULL,'2026-06-25 14:54:36','2026-06-25 14:54:36'),(12,'App\\Models\\User',1,'web','5f7415691d58449bb9b11e07527bb7c4c99c9560cbbb3eaac54ee0f434788195','[\"*\"]',NULL,NULL,'2026-06-25 14:54:50','2026-06-25 14:54:50'),(13,'App\\Models\\User',1,'web','1564cef10c2621eefd49069fd5758c006095fef74687a2f762f9628a822f61b7','[\"*\"]','2026-06-25 15:00:49',NULL,'2026-06-25 14:57:05','2026-06-25 15:00:49'),(14,'App\\Models\\User',2,'web-session','cc7da9ee39c8744665f56d6be2d34344e587a5301263e842b461c39fffbe37dc','[\"*\"]',NULL,NULL,'2026-06-25 15:13:18','2026-06-25 15:13:18');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Test','admin@minicrm.test',NULL,'$2y$12$/m02EtyjhjsvRwOmGwztheri6Xvdy9vTQwhjnzcwm1CIt/npTDUv.','admin','Qy59OxODe1mD9BkErMDXdOVFNtVm0iFo8hknHKtCnjKayAFLxhI9gKMyQqdM','2026-06-25 13:15:00','2026-06-25 13:15:00'),(2,'Standard User','user@minicrm.test',NULL,'$2y$12$0NAW3avU00Kpj.TFay8DsO.owCTKYx5OKTNCCs2..wjwsl60asFV2','user','89b7YqEfmO0l49hkZupa52vGnQ2MxcayYTmWXE1pZY5xpkKMpLSG3KBCecnY','2026-06-25 13:15:00','2026-06-25 13:15:00');
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

-- Dump completed on 2026-06-26  1:22:33
