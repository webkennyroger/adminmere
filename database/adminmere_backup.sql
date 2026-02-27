-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: adminmere
-- ------------------------------------------------------
-- Server version	8.0.45-0ubuntu0.24.04.1

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
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sport_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'run',
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `distance` decimal(8,2) NOT NULL DEFAULT '0.00',
  `duration` int NOT NULL DEFAULT '0',
  `calories` decimal(8,2) NOT NULL DEFAULT '0.00',
  `polylines` json DEFAULT NULL,
  `privacy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `feed_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'personal',
  `tagged_users` json DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `mood` int DEFAULT NULL,
  `media` json DEFAULT NULL,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_user_id_foreign` (`user_id`),
  KEY `activities_app_id_index` (`app_id`),
  CONSTRAINT `activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blocked_users`
--

DROP TABLE IF EXISTS `blocked_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blocked_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `blocked_user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blocked_users_user_id_blocked_user_id_unique` (`user_id`,`blocked_user_id`),
  KEY `blocked_users_blocked_user_id_foreign` (`blocked_user_id`),
  CONSTRAINT `blocked_users_blocked_user_id_foreign` FOREIGN KEY (`blocked_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blocked_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocked_users`
--

LOCK TABLES `blocked_users` WRITE;
/*!40000 ALTER TABLE `blocked_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `blocked_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
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
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'zinc',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Corrida','corrida','red','2026-02-10 13:36:20','2026-02-10 13:36:20'),(2,'Caminhada','caminhada','green','2026-02-10 13:36:20','2026-02-10 13:36:20'),(3,'Ciclismo','ciclismo','blue','2026-02-10 13:36:20','2026-02-10 13:36:20'),(4,'Natação','natacao','cyan','2026-02-10 13:36:20','2026-02-10 13:36:20'),(5,'Yoga','yoga','purple','2026-02-10 13:36:20','2026-02-10 13:36:20'),(6,'Musculação','musculacao','orange','2026-02-10 13:36:20','2026-02-10 13:36:20'),(7,'Misto','misto','zinc','2026-02-10 13:36:20','2026-02-10 13:36:20');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `challenge_user`
--

DROP TABLE IF EXISTS `challenge_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `challenge_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `challenge_id` bigint unsigned NOT NULL,
  `progress` decimal(8,2) NOT NULL DEFAULT '0.00',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'joined',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `challenge_user_user_id_foreign` (`user_id`),
  KEY `challenge_user_challenge_id_foreign` (`challenge_id`),
  CONSTRAINT `challenge_user_challenge_id_foreign` FOREIGN KEY (`challenge_id`) REFERENCES `challenges` (`id`) ON DELETE CASCADE,
  CONSTRAINT `challenge_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `challenge_user`
--

LOCK TABLES `challenge_user` WRITE;
/*!40000 ALTER TABLE `challenge_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `challenge_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `challenges`
--

DROP TABLE IF EXISTS `challenges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `challenges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `goal_km` decimal(8,2) NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `challenges_category_id_foreign` (`category_id`),
  CONSTRAINT `challenges_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `challenges`
--

LOCK TABLES `challenges` WRITE;
/*!40000 ALTER TABLE `challenges` DISABLE KEYS */;
INSERT INTO `challenges` VALUES (1,NULL,'Desafio 30 Dias de Corrida','Corra pelo menos 5km por dia durante 30 dias consecutivos','2026-02-10','2026-03-12',150.00,1,0,'2026-02-10 13:36:22','2026-02-10 13:36:22',NULL),(2,NULL,'Maratona de Caminhada','Complete 10.000 passos por dia durante 21 dias','2026-02-10','2026-03-12',100.00,2,0,'2026-02-10 13:36:22','2026-02-10 13:36:22',NULL),(3,NULL,'Ciclismo Extremo','Percorra 100km de bicicleta em uma semana','2026-02-10','2026-03-12',100.00,3,0,'2026-02-10 13:36:22','2026-02-10 13:36:22',NULL),(4,NULL,'Natação Diária','Nade 1km por dia durante 15 dias','2026-02-10','2026-03-12',15.00,4,0,'2026-02-10 13:36:22','2026-02-10 13:36:22',NULL),(5,NULL,'Yoga Matinal','Pratique 30 minutos de yoga todas as manhãs por 30 dias','2026-02-10','2026-03-12',0.00,5,0,'2026-02-10 13:36:22','2026-02-10 13:36:22',NULL),(6,NULL,'Força Total','Complete 20 treinos de musculação em 30 dias','2026-02-10','2026-03-12',0.00,6,0,'2026-02-10 13:36:22','2026-02-10 13:36:22',NULL);
/*!40000 ALTER TABLE `challenges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_group_members`
--

DROP TABLE IF EXISTS `chat_group_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_group_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `chat_group_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `is_archived` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_group_members_chat_group_id_foreign` (`chat_group_id`),
  KEY `chat_group_members_user_id_foreign` (`user_id`),
  CONSTRAINT `chat_group_members_chat_group_id_foreign` FOREIGN KEY (`chat_group_id`) REFERENCES `chat_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chat_group_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_group_members`
--

LOCK TABLES `chat_group_members` WRITE;
/*!40000 ALTER TABLE `chat_group_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_group_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_groups`
--

DROP TABLE IF EXISTS `chat_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_groups_created_by_foreign` (`created_by`),
  CONSTRAINT `chat_groups_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_groups`
--

LOCK TABLES `chat_groups` WRITE;
/*!40000 ALTER TABLE `chat_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_preferences`
--

DROP TABLE IF EXISTS `chat_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_preferences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `peer_id` bigint unsigned NOT NULL,
  `is_muted` tinyint(1) NOT NULL DEFAULT '0',
  `is_archived` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_peer` (`user_id`,`peer_id`),
  KEY `chat_preferences_user_id_index` (`user_id`),
  KEY `chat_preferences_peer_id_index` (`peer_id`),
  CONSTRAINT `chat_preferences_peer_id_foreign` FOREIGN KEY (`peer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chat_preferences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_preferences`
--

LOCK TABLES `chat_preferences` WRITE;
/*!40000 ALTER TABLE `chat_preferences` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_preferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `media_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commentable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_parent_id_foreign` (`parent_id`),
  KEY `comments_commentable_type_commentable_id_index` (`commentable_type`,`commentable_id`),
  CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,2,NULL,'Boa, continue assim!',NULL,'App\\Models\\Activity',1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(2,3,NULL,'Foi pesado mas valeu a pena!',NULL,'App\\Models\\Activity',4,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(7,1,NULL,'teste',NULL,'App\\Models\\Post',15,'2026-02-20 20:01:42','2026-02-20 20:01:42'),(8,1,7,'resre',NULL,'App\\Models\\Post',15,'2026-02-20 20:02:16','2026-02-20 20:02:16'),(9,1,NULL,'teste 2',NULL,'App\\Models\\Post',15,'2026-02-20 20:03:53','2026-02-20 20:03:53'),(10,1,9,'testeeeeeee',NULL,'App\\Models\\Post',15,'2026-02-20 20:11:16','2026-02-20 20:11:16'),(11,1,9,'testesres',NULL,'App\\Models\\Post',15,'2026-02-20 20:23:47','2026-02-20 20:23:47'),(12,1,NULL,'kkk',NULL,'App\\Models\\Post',21,'2026-02-20 20:42:44','2026-02-20 20:42:44'),(13,1,NULL,'tesre',NULL,'App\\Models\\Post',22,'2026-02-20 20:57:03','2026-02-20 20:57:03'),(14,1,13,'teste',NULL,'App\\Models\\Post',22,'2026-02-20 20:57:11','2026-02-20 20:57:11'),(55,1,NULL,'teste comentario',NULL,'App\\Models\\Post',58,'2026-02-27 00:39:38','2026-02-27 00:39:38'),(56,1,NULL,'teste',NULL,'App\\Models\\Post',58,'2026-02-27 00:40:41','2026-02-27 00:40:41'),(58,1,NULL,'','comments/ScZTfgOXAqUeFvoVZnJ2gdiUauV9dmNhxzjOYXQR.png','App\\Models\\Post',58,'2026-02-27 01:26:47','2026-02-27 01:26:47'),(59,1,NULL,'tesre',NULL,'App\\Models\\Post',58,'2026-02-27 01:28:28','2026-02-27 01:28:28'),(60,1,NULL,'Kenny',NULL,'App\\Models\\Post',58,'2026-02-27 01:28:39','2026-02-27 01:28:39'),(61,1,NULL,'','comments/media/KJPW4Hrn4j39o77AwYnOG1leJgwidN3pJPWe1vJ8.jpg','App\\Models\\Post',58,'2026-02-27 01:28:48','2026-02-27 01:28:48'),(62,1,55,'@Mere App texto',NULL,'App\\Models\\Post',58,'2026-02-27 02:00:04','2026-02-27 02:00:04'),(63,1,NULL,'teste',NULL,'App\\Models\\Post',59,'2026-02-27 02:01:42','2026-02-27 02:01:42'),(64,1,63,'@Mere App','comments/media/ZnHgA8qPDbDYwL6sa6s8AbrnePU6iU1S83EcHb9Y.jpg','App\\Models\\Post',59,'2026-02-27 02:01:53','2026-02-27 02:01:53'),(65,1,NULL,'tem',NULL,'App\\Models\\Post',60,'2026-02-27 02:04:26','2026-02-27 02:04:26'),(66,1,NULL,'','comments/media/4Vs6CvksFEDpjJgzfQ7TwtYsTXNMUkYHduh4QR7k.jpg','App\\Models\\Post',60,'2026-02-27 09:00:32','2026-02-27 09:00:32');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
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
-- Table structure for table `followers`
--

DROP TABLE IF EXISTS `followers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `followers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `follower_id` bigint unsigned NOT NULL,
  `following_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `followers_follower_id_following_id_unique` (`follower_id`,`following_id`),
  KEY `followers_following_id_foreign` (`following_id`),
  CONSTRAINT `followers_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `followers_following_id_foreign` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `followers`
--

LOCK TABLES `followers` WRITE;
/*!40000 ALTER TABLE `followers` DISABLE KEYS */;
INSERT INTO `followers` VALUES (19,1,20,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(21,2,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(22,3,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(23,4,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(24,5,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(25,6,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(26,7,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(27,8,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(28,9,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(29,10,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(30,11,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(31,12,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(32,13,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(33,14,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(34,15,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(35,16,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(36,17,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(37,18,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(38,19,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(39,20,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(40,21,1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(41,2,7,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(42,7,2,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(43,2,8,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(44,8,2,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(45,2,9,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(46,9,2,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(47,2,10,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(48,10,2,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(49,2,11,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(50,11,2,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(51,3,7,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(52,7,3,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(53,3,8,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(54,8,3,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(55,3,9,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(56,9,3,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(57,3,10,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(58,10,3,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(59,3,11,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(60,11,3,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(61,4,7,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(62,7,4,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(63,4,8,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(64,8,4,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(65,4,9,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(66,9,4,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(67,4,10,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(68,10,4,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(69,4,11,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(70,11,4,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(71,5,7,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(72,7,5,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(73,5,8,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(74,8,5,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(75,5,9,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(76,9,5,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(77,5,10,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(78,10,5,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(79,5,11,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(80,11,5,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(81,6,7,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(82,7,6,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(83,6,8,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(84,8,6,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(85,6,9,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(86,9,6,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(87,6,10,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(88,10,6,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(89,6,11,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(90,11,6,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(91,22,1,'2026-02-10 15:33:37','2026-02-10 15:33:37');
/*!40000 ALTER TABLE `followers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goals`
--

DROP TABLE IF EXISTS `goals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `goals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metric` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_value` decimal(15,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goals`
--

LOCK TABLES `goals` WRITE;
/*!40000 ALTER TABLE `goals` DISABLE KEYS */;
INSERT INTO `goals` VALUES (1,'Meta de Usuários','users','monthly',100.00,'2026-02-01','2026-02-28','2026-02-10 13:36:22','2026-02-10 13:36:22'),(2,'Meta de Vendas','sales','monthly',50.00,'2026-02-01','2026-02-28','2026-02-10 13:36:22','2026-02-10 13:36:22'),(3,'Meta de Receita','revenue','monthly',10000.00,'2026-02-01','2026-02-28','2026-02-10 13:36:22','2026-02-10 13:36:22');
/*!40000 ALTER TABLE `goals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_messages`
--

DROP TABLE IF EXISTS `group_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `chat_group_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `attachments` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_messages_chat_group_id_foreign` (`chat_group_id`),
  KEY `group_messages_user_id_foreign` (`user_id`),
  CONSTRAINT `group_messages_chat_group_id_foreign` FOREIGN KEY (`chat_group_id`) REFERENCES `chat_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `group_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_messages`
--

LOCK TABLES `group_messages` WRITE;
/*!40000 ALTER TABLE `group_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `group_messages` ENABLE KEYS */;
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
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,'default','{\"uuid\":\"4dfb797f-1092-42dd-86bd-3aea72bd4dc5\",\"displayName\":\"App\\\\Events\\\\MessageSent\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\MessageSent\\\":1:{s:7:\\\"message\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:18:\\\"App\\\\Models\\\\Message\\\";s:2:\\\"id\\\";i:1;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1771516451,\"delay\":null}',0,NULL,1771516451,1771516451),(2,'default','{\"uuid\":\"f1943d93-2cbd-47b6-815a-4af43339490a\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:7:\\\"post_51\\\";s:8:\\\"is_liked\\\";b:1;s:11:\\\"likes_count\\\";i:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772028224,\"delay\":null}',0,NULL,1772028224,1772028224),(3,'default','{\"uuid\":\"651992e8-68ca-4848-86fa-328de028e914\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:7:\\\"post_51\\\";s:8:\\\"is_liked\\\";b:0;s:11:\\\"likes_count\\\";i:0;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772029228,\"delay\":null}',0,NULL,1772029228,1772029228),(4,'default','{\"uuid\":\"e2b6e8db-dcba-4b63-aa37-fd9026c15a95\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:7:\\\"poll_52\\\";s:8:\\\"is_liked\\\";b:1;s:11:\\\"likes_count\\\";i:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772029246,\"delay\":null}',0,NULL,1772029246,1772029246),(5,'default','{\"uuid\":\"9d2d926a-6997-4179-808b-43d04ff88396\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"poll_52\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"36\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"teste\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-25T11:20:55-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772029255,\"delay\":null}',0,NULL,1772029255,1772029255),(6,'default','{\"uuid\":\"fce28c1f-7613-4038-91ec-0b4a761216d1\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"poll_52\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"37\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"teste\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-25T11:21:00-03:00\\\";s:9:\\\"parent_id\\\";s:2:\\\"36\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772029260,\"delay\":null}',0,NULL,1772029260,1772029260),(7,'default','{\"uuid\":\"27cc8e16-c211-4ce5-a780-fe9a5e954cb4\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:7:\\\"poll_54\\\";s:8:\\\"is_liked\\\";b:1;s:11:\\\"likes_count\\\";i:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772035234,\"delay\":null}',0,NULL,1772035234,1772035234),(8,'default','{\"uuid\":\"fc566a7e-6bc2-4bc0-9f0e-254ab6e22fdb\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:7:\\\"post_53\\\";s:8:\\\"is_liked\\\";b:1;s:11:\\\"likes_count\\\";i:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772036047,\"delay\":null}',0,NULL,1772036047,1772036047),(9,'default','{\"uuid\":\"c527416e-db32-4336-af0b-f2d15991f023\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"post_53\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"38\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"teste\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-25T13:14:25-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772036065,\"delay\":null}',0,NULL,1772036065,1772036065),(10,'default','{\"uuid\":\"c7dca546-2835-4326-9d0c-fbb139f73803\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"post_53\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"39\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"teste\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-25T13:14:31-03:00\\\";s:9:\\\"parent_id\\\";s:2:\\\"38\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772036071,\"delay\":null}',0,NULL,1772036071,1772036071),(11,'default','{\"uuid\":\"2a7be9a0-3261-41a6-b043-239b168e2d64\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"poll_54\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"40\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"teste\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-25T13:36:01-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772037361,\"delay\":null}',0,NULL,1772037361,1772037361),(12,'default','{\"uuid\":\"f5e45476-ef4b-4647-8649-7c91bf91b394\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"poll_54\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"41\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"teste\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-25T13:36:06-03:00\\\";s:9:\\\"parent_id\\\";s:2:\\\"40\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772037366,\"delay\":null}',0,NULL,1772037366,1772037366),(13,'default','{\"uuid\":\"024fb648-3ab1-43d0-bae8-7c72afd0423c\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"poll_54\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"42\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"teste\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-25T13:53:35-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772038415,\"delay\":null}',0,NULL,1772038415,1772038415),(14,'default','{\"uuid\":\"981da2c3-acf8-4870-a836-c35666347440\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"poll_54\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"43\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"teste\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-25T14:06:20-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772039180,\"delay\":null}',0,NULL,1772039180,1772039180),(15,'default','{\"uuid\":\"d2390669-88ca-4acb-959d-ad7ff6512f09\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"poll_54\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"44\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:2:\\\"te\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-25T14:06:34-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772039194,\"delay\":null}',0,NULL,1772039194,1772039194),(16,'default','{\"uuid\":\"08259a76-687c-4f94-9b2f-357b3c84c873\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"poll_54\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"45\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:1:\\\"f\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-25T14:06:38-03:00\\\";s:9:\\\"parent_id\\\";s:2:\\\"44\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772039198,\"delay\":null}',0,NULL,1772039198,1772039198),(17,'default','{\"uuid\":\"5a5e2aab-5ab1-4753-8e50-99f36d9967fa\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"poll_54\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"46\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:1:\\\"f\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-25T14:06:42-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772039202,\"delay\":null}',0,NULL,1772039202,1772039202),(18,'default','{\"uuid\":\"3b78efb4-7772-4621-a179-1d6b8d505c93\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"post_53\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"47\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"teste\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-25T14:07:03-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772039223,\"delay\":null}',0,NULL,1772039223,1772039223),(19,'default','{\"uuid\":\"63e2fcef-bc2b-4784-936c-43bcebb4cebf\",\"displayName\":\"App\\\\Events\\\\StoryPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\StoryPosted\\\":1:{s:7:\\\"user_id\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772044558,\"delay\":null}',0,NULL,1772044558,1772044558),(20,'default','{\"uuid\":\"11083d46-53f3-41cb-8f07-8e5bb24cb893\",\"displayName\":\"App\\\\Events\\\\StoryPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\StoryPosted\\\":1:{s:7:\\\"user_id\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772052259,\"delay\":null}',0,NULL,1772052259,1772052259),(21,'default','{\"uuid\":\"79e8129d-bcf5-4563-a39c-ba4a96c1e251\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:7:\\\"poll_55\\\";s:8:\\\"is_liked\\\";b:1;s:11:\\\"likes_count\\\";i:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772108239,\"delay\":null}',0,NULL,1772108239,1772108239),(22,'default','{\"uuid\":\"3c3f265c-7142-4ccf-8be3-829e3ebb6a29\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"poll_55\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"48\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"teste\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-26T09:17:27-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772108247,\"delay\":null}',0,NULL,1772108247,1772108247),(23,'default','{\"uuid\":\"895d0e90-bcdb-4530-a8dd-7ecc5dad0423\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"poll_55\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"49\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"teste\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-26T09:17:34-03:00\\\";s:9:\\\"parent_id\\\";s:2:\\\"48\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772108254,\"delay\":null}',0,NULL,1772108254,1772108254),(24,'default','{\"uuid\":\"1bf6238d-24b5-4c8f-84c8-bea4c4937abf\",\"displayName\":\"App\\\\Events\\\\SaveToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\SaveToggled\\\":3:{s:2:\\\"id\\\";s:7:\\\"poll_55\\\";s:8:\\\"is_saved\\\";b:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772108256,\"delay\":null}',0,NULL,1772108256,1772108256),(25,'default','{\"uuid\":\"0a663064-9779-49c3-8aa9-7ed4e73843a8\",\"displayName\":\"App\\\\Events\\\\SaveToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\SaveToggled\\\":3:{s:2:\\\"id\\\";s:7:\\\"post_56\\\";s:8:\\\"is_saved\\\";b:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772108287,\"delay\":null}',0,NULL,1772108287,1772108287),(26,'default','{\"uuid\":\"1087de05-f8cd-4d61-85f3-c418907405ad\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:7:\\\"post_56\\\";s:8:\\\"is_liked\\\";b:1;s:11:\\\"likes_count\\\";i:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772108289,\"delay\":null}',0,NULL,1772108289,1772108289),(27,'default','{\"uuid\":\"c557abf6-4418-49ab-9019-c553ae26179d\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"post_56\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"50\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"teste\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-26T09:40:32-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772109632,\"delay\":null}',0,NULL,1772109632,1772109632),(28,'default','{\"uuid\":\"63e6dbed-0d69-409b-8ed0-1d685ab45ebf\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"post_56\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"51\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:7:\\\"teshgdx\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-26T09:40:44-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772109644,\"delay\":null}',0,NULL,1772109644,1772109644),(29,'default','{\"uuid\":\"dfb247e1-6d3c-40f3-890a-a2801aaee452\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:11:\\\"activity_70\\\";s:8:\\\"is_liked\\\";b:1;s:11:\\\"likes_count\\\";i:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772112184,\"delay\":null}',0,NULL,1772112184,1772112184),(30,'default','{\"uuid\":\"bc44b62e-8132-4750-aaaf-562d3a839378\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:11:\\\"activity_70\\\";s:8:\\\"is_liked\\\";b:0;s:11:\\\"likes_count\\\";i:0;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772112189,\"delay\":null}',0,NULL,1772112189,1772112189),(31,'default','{\"uuid\":\"ed99317e-3b98-49c8-aa9a-22ad83efc416\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:11:\\\"activity_70\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"52\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:4:\\\"yfcv\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-26T10:24:05-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772112245,\"delay\":null}',0,NULL,1772112245,1772112245),(32,'default','{\"uuid\":\"248aaad9-446b-42e1-abde-9f9678b32afb\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:11:\\\"activity_70\\\";s:8:\\\"is_liked\\\";b:1;s:11:\\\"likes_count\\\";i:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772112251,\"delay\":null}',0,NULL,1772112251,1772112251),(33,'default','{\"uuid\":\"bff5dac7-51aa-4a26-b30e-f5cf249f6475\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:11:\\\"activity_70\\\";s:8:\\\"is_liked\\\";b:0;s:11:\\\"likes_count\\\";i:0;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772112252,\"delay\":null}',0,NULL,1772112252,1772112252),(34,'default','{\"uuid\":\"65afab8d-5830-4f5c-a6e8-dd4cbbcac953\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:11:\\\"activity_70\\\";s:8:\\\"is_liked\\\";b:1;s:11:\\\"likes_count\\\";i:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772112252,\"delay\":null}',0,NULL,1772112252,1772112252),(35,'default','{\"uuid\":\"475b9a78-c584-42df-9e9a-f4c5517d21e0\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:11:\\\"activity_70\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"53\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:3:\\\"hjj\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-26T10:24:16-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772112256,\"delay\":null}',0,NULL,1772112256,1772112256),(36,'default','{\"uuid\":\"eec05c0f-cb10-4e4c-90ea-8a4e90b55097\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:11:\\\"activity_70\\\";s:7:\\\"comment\\\";a:11:{s:2:\\\"id\\\";s:2:\\\"54\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:14:\\\"@Mere App hjjh\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-26T10:24:20-03:00\\\";s:9:\\\"parent_id\\\";s:2:\\\"53\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772112260,\"delay\":null}',0,NULL,1772112260,1772112260),(37,'default','{\"uuid\":\"8cf5158f-3634-404c-83a4-f829acb7ed27\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:7:\\\"post_58\\\";s:8:\\\"is_liked\\\";b:1;s:11:\\\"likes_count\\\";i:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772118081,\"delay\":null}',0,NULL,1772118081,1772118081),(38,'default','{\"uuid\":\"929214a0-1bd8-42c4-80e5-1f4309b7b753\",\"displayName\":\"App\\\\Events\\\\SaveToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\SaveToggled\\\":3:{s:2:\\\"id\\\";s:7:\\\"post_58\\\";s:8:\\\"is_saved\\\";b:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772118102,\"delay\":null}',0,NULL,1772118102,1772118102),(39,'default','{\"uuid\":\"b7baec70-539a-4639-83fa-b68556398765\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"post_58\\\";s:7:\\\"comment\\\";a:12:{s:2:\\\"id\\\";s:2:\\\"55\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:16:\\\"teste comentario\\\";s:8:\\\"mediaUrl\\\";N;s:9:\\\"timestamp\\\";s:25:\\\"2026-02-27T00:39:38-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772163578,\"delay\":null}',0,NULL,1772163578,1772163578),(40,'default','{\"uuid\":\"b5a73e9a-cdae-4184-941c-cae8096dfed4\",\"displayName\":\"App\\\\Events\\\\StoryPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\StoryPosted\\\":1:{s:7:\\\"user_id\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772164004,\"delay\":null}',0,NULL,1772164004,1772164004),(41,'default','{\"uuid\":\"f5c2ddbb-2a18-4e12-a218-cdcd207a6422\",\"displayName\":\"App\\\\Events\\\\StoryPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\StoryPosted\\\":1:{s:7:\\\"user_id\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772164128,\"delay\":null}',0,NULL,1772164128,1772164128),(42,'default','{\"uuid\":\"dd1def36-5750-4750-9e67-58e6d8146657\",\"displayName\":\"App\\\\Events\\\\StoryPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\StoryPosted\\\":1:{s:7:\\\"user_id\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772164183,\"delay\":null}',0,NULL,1772164183,1772164183),(43,'default','{\"uuid\":\"0f1da59a-f254-4036-a2c3-e7ef3ae21678\",\"displayName\":\"App\\\\Events\\\\StoryPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\StoryPosted\\\":1:{s:7:\\\"user_id\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772164436,\"delay\":null}',0,NULL,1772164436,1772164436),(44,'default','{\"uuid\":\"8e9e2c3f-4cc6-4e9e-a31c-3f22df3939e4\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"post_58\\\";s:7:\\\"comment\\\";a:12:{s:2:\\\"id\\\";s:2:\\\"59\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"tesre\\\";s:8:\\\"mediaUrl\\\";N;s:9:\\\"timestamp\\\";s:25:\\\"2026-02-27T01:28:28-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772166508,\"delay\":null}',0,NULL,1772166508,1772166508),(45,'default','{\"uuid\":\"2134228e-c552-4bd8-b436-5fd1da01239b\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"post_58\\\";s:7:\\\"comment\\\";a:12:{s:2:\\\"id\\\";s:2:\\\"60\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"Kenny\\\";s:8:\\\"mediaUrl\\\";N;s:9:\\\"timestamp\\\";s:25:\\\"2026-02-27T01:28:39-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772166519,\"delay\":null}',0,NULL,1772166519,1772166519),(46,'default','{\"uuid\":\"c53839ef-e00d-438a-8b53-4f9a83fe71fa\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"post_58\\\";s:7:\\\"comment\\\";a:12:{s:2:\\\"id\\\";s:2:\\\"61\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:0:\\\"\\\";s:8:\\\"mediaUrl\\\";s:93:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/comments\\/media\\/KJPW4Hrn4j39o77AwYnOG1leJgwidN3pJPWe1vJ8.jpg\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-27T01:28:48-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772166528,\"delay\":null}',0,NULL,1772166528,1772166528),(47,'default','{\"uuid\":\"3d46d5f7-bbc5-4b9c-b5a1-853a35513c05\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"post_58\\\";s:7:\\\"comment\\\";a:12:{s:2:\\\"id\\\";s:2:\\\"62\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:15:\\\"@Mere App texto\\\";s:8:\\\"mediaUrl\\\";N;s:9:\\\"timestamp\\\";s:25:\\\"2026-02-27T02:00:04-03:00\\\";s:9:\\\"parent_id\\\";s:2:\\\"55\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772168404,\"delay\":null}',0,NULL,1772168404,1772168404),(48,'default','{\"uuid\":\"af200211-3050-4b1c-a480-d134eab211c7\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:7:\\\"post_59\\\";s:8:\\\"is_liked\\\";b:1;s:11:\\\"likes_count\\\";i:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772168491,\"delay\":null}',0,NULL,1772168491,1772168491),(49,'default','{\"uuid\":\"55dee432-bed5-411b-bb68-a5213f3dd5df\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"post_59\\\";s:7:\\\"comment\\\";a:12:{s:2:\\\"id\\\";s:2:\\\"63\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:5:\\\"teste\\\";s:8:\\\"mediaUrl\\\";N;s:9:\\\"timestamp\\\";s:25:\\\"2026-02-27T02:01:42-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772168502,\"delay\":null}',0,NULL,1772168502,1772168502),(50,'default','{\"uuid\":\"10163c54-69ab-408c-8d4a-2a4f63714a3a\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"post_59\\\";s:7:\\\"comment\\\";a:12:{s:2:\\\"id\\\";s:2:\\\"64\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:9:\\\"@Mere App\\\";s:8:\\\"mediaUrl\\\";s:93:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/comments\\/media\\/ZnHgA8qPDbDYwL6sa6s8AbrnePU6iU1S83EcHb9Y.jpg\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-27T02:01:53-03:00\\\";s:9:\\\"parent_id\\\";s:2:\\\"63\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772168513,\"delay\":null}',0,NULL,1772168513,1772168513),(51,'default','{\"uuid\":\"730a8aa7-0a0b-49d1-9286-93d67e90da32\",\"displayName\":\"App\\\\Events\\\\LikeToggled\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:22:\\\"App\\\\Events\\\\LikeToggled\\\":4:{s:2:\\\"id\\\";s:7:\\\"poll_60\\\";s:8:\\\"is_liked\\\";b:1;s:11:\\\"likes_count\\\";i:1;s:7:\\\"user_id\\\";s:1:\\\"1\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772168656,\"delay\":null}',0,NULL,1772168656,1772168656),(52,'default','{\"uuid\":\"6329c90b-52e7-4073-be27-8efaf5ae06e2\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"poll_60\\\";s:7:\\\"comment\\\";a:12:{s:2:\\\"id\\\";s:2:\\\"65\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:3:\\\"tem\\\";s:8:\\\"mediaUrl\\\";N;s:9:\\\"timestamp\\\";s:25:\\\"2026-02-27T02:04:26-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772168666,\"delay\":null}',0,NULL,1772168666,1772168666),(53,'default','{\"uuid\":\"62043846-541c-482c-967b-74b0b335d8d9\",\"displayName\":\"App\\\\Events\\\\CommentPosted\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":17:{s:5:\\\"event\\\";O:24:\\\"App\\\\Events\\\\CommentPosted\\\":2:{s:7:\\\"item_id\\\";s:7:\\\"poll_60\\\";s:7:\\\"comment\\\";a:12:{s:2:\\\"id\\\";s:2:\\\"66\\\";s:6:\\\"userId\\\";s:1:\\\"1\\\";s:8:\\\"userName\\\";s:8:\\\"Mere App\\\";s:13:\\\"userAvatarUrl\\\";s:87:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/profiles\\/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg\\\";s:4:\\\"text\\\";s:0:\\\"\\\";s:8:\\\"mediaUrl\\\";s:93:\\\"https:\\/\\/kennyroger.com.br\\/storage\\/comments\\/media\\/4Vs6CvksFEDpjJgzfQ7TwtYsTXNMUkYHduh4QR7k.jpg\\\";s:9:\\\"timestamp\\\";s:25:\\\"2026-02-27T09:00:32-03:00\\\";s:9:\\\"parent_id\\\";s:0:\\\"\\\";s:7:\\\"replies\\\";a:0:{}s:10:\\\"isArchived\\\";b:0;s:5:\\\"likes\\\";i:0;s:7:\\\"isLiked\\\";b:0;}}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:23:\\\"deleteWhenMissingModels\\\";b:1;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1772193632,\"delay\":null}',0,NULL,1772193632,1772193632);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `likes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `likeable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `likeable_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `likes_user_id_likeable_id_likeable_type_unique` (`user_id`,`likeable_id`,`likeable_type`),
  KEY `likes_likeable_type_likeable_id_index` (`likeable_type`,`likeable_id`),
  CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (1,2,'App\\Models\\Activity',1,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(5,22,'App\\Models\\Activity',7,'2026-02-10 15:34:03','2026-02-10 15:34:03'),(7,1,'App\\Models\\Post',10,'2026-02-13 14:12:31','2026-02-13 14:12:31'),(8,1,'App\\Models\\Post',12,'2026-02-13 15:21:57','2026-02-13 15:21:57'),(9,1,'App\\Models\\Post',13,'2026-02-13 15:22:05','2026-02-13 15:22:05'),(20,1,'App\\Models\\Post',2,'2026-02-20 19:17:11','2026-02-20 19:17:11'),(24,1,'App\\Models\\Post',15,'2026-02-20 20:01:06','2026-02-20 20:01:06'),(25,1,'App\\Models\\Comment',7,'2026-02-20 20:02:07','2026-02-20 20:02:07'),(26,1,'App\\Models\\Comment',9,'2026-02-20 20:23:07','2026-02-20 20:23:07'),(27,1,'App\\Models\\Comment',13,'2026-02-20 20:57:15','2026-02-20 20:57:15'),(62,1,'App\\Models\\Post',58,'2026-02-26 12:01:21','2026-02-26 12:01:21'),(63,1,'App\\Models\\Comment',55,'2026-02-27 00:40:43','2026-02-27 00:40:43'),(64,1,'App\\Models\\Comment',56,'2026-02-27 01:59:43','2026-02-27 01:59:43'),(65,1,'App\\Models\\Comment',60,'2026-02-27 01:59:49','2026-02-27 01:59:49'),(66,1,'App\\Models\\Comment',59,'2026-02-27 01:59:49','2026-02-27 01:59:49'),(67,1,'App\\Models\\Comment',58,'2026-02-27 01:59:50','2026-02-27 01:59:50'),(68,1,'App\\Models\\Post',59,'2026-02-27 02:01:31','2026-02-27 02:01:31'),(69,1,'App\\Models\\Post',60,'2026-02-27 02:04:16','2026-02-27 02:04:16'),(70,1,'App\\Models\\Comment',65,'2026-02-27 02:04:29','2026-02-27 02:04:29'),(71,1,'App\\Models\\Comment',66,'2026-02-27 09:01:01','2026-02-27 09:01:01');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint unsigned NOT NULL,
  `receiver_id` bigint unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachments` json DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `deleted_by_sender` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_by_receiver` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_sender_id_foreign` (`sender_id`),
  KEY `messages_receiver_id_foreign` (`receiver_id`),
  CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,1,12,'ola','text',NULL,NULL,NULL,0,0,'2026-02-19 12:54:11','2026-02-19 12:54:11'),(2,1,12,'yrs','text',NULL,NULL,NULL,0,0,'2026-02-26 10:21:40','2026-02-26 10:21:40');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_12_15_000000_create_messages_table',1),(5,'2025_12_04_155201_create_challenges_table',1),(6,'2025_12_04_215958_create_support_system_tables',1),(7,'2025_12_10_143030_create_profiles_table',1),(8,'2025_12_12_000000_create_social_interactions_tables',1),(9,'2025_12_16_175000_create_subscription_system_tables',1),(10,'2025_12_16_180701_create_personal_access_tokens_table',1),(11,'2025_12_19_000000_create_events_management_tables',1),(12,'2026_01_09_000000_create_chat_system_tables',1),(13,'2026_01_27_113426_add_tagged_users_to_activities_table',1),(14,'2026_01_28_131627_create_chat_preferences_table',1),(15,'2026_01_28_142224_create_stories_table',1),(16,'2026_01_30_160000_fix_chat_preferences_table',1),(17,'2026_02_08_154000_add_location_and_feed_type_to_activities_table',1),(18,'2026_02_08_212000_create_posts_table',1),(19,'2026_02_08_215000_create_polls_system_tables',1),(20,'2026_02_09_120000_add_is_mandatory_to_posts_table',1),(21,'2026_02_11_163742_add_settings_to_profiles_table',2),(22,'2026_02_19_131336_create_blocked_users_table',3),(23,'2026_02_22_104908_add_meta_to_posts_and_activities_tables',4),(24,'2026_02_22_105045_fix_poll_votes_unique_index',4),(25,'2026_02_22_213543_create_saved_items_table',5),(26,'2026_02_26_101409_add_media_path_to_comments_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES ('1bdf54cf-fd87-4861-9faa-dfedc8de4911','App\\Notifications\\NewFollower','App\\Models\\User',2,'{\"title\":\"Novo Seguidor\",\"description\":\"Mere App come\\u00e7ou a seguir voc\\u00ea.\",\"image\":\"https:\\/\\/lh3.googleusercontent.com\\/a\\/ACg8ocIJ84vZh-clZJd0Qjye6hCh0DHjbbEzI1iQXetsu__g7CfWfA=s96-c\",\"link\":\"https:\\/\\/kennyroger.com.br\\/@1\"}',NULL,'2026-02-24 14:29:54','2026-02-24 14:29:54'),('8ecd72cc-2bda-41e4-b214-25c1d6ad7e77','App\\Notifications\\NewFollower','App\\Models\\User',22,'{\"title\":\"Novo Seguidor\",\"description\":\"Mere App come\\u00e7ou a seguir voc\\u00ea.\",\"image\":\"https:\\/\\/lh3.googleusercontent.com\\/a\\/ACg8ocIJ84vZh-clZJd0Qjye6hCh0DHjbbEzI1iQXetsu__g7CfWfA=s96-c\",\"link\":\"https:\\/\\/kennyroger.com.br\\/@1\"}',NULL,'2026-02-24 14:30:04','2026-02-24 14:30:04'),('e2cd0766-7a57-4fd6-9e0e-1c84728a1a33','App\\Notifications\\NewFollower','App\\Models\\User',3,'{\"title\":\"Novo Seguidor\",\"description\":\"Mere App come\\u00e7ou a seguir voc\\u00ea.\",\"image\":\"https:\\/\\/lh3.googleusercontent.com\\/a\\/ACg8ocIJ84vZh-clZJd0Qjye6hCh0DHjbbEzI1iQXetsu__g7CfWfA=s96-c\",\"link\":\"https:\\/\\/kennyroger.com.br\\/@1\"}',NULL,'2026-02-24 14:29:55','2026-02-24 14:29:55');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
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
-- Table structure for table `payment_histories`
--

DROP TABLE IF EXISTS `payment_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `subscription_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BRL',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_histories_stripe_payment_id_unique` (`stripe_payment_id`),
  KEY `payment_histories_user_id_foreign` (`user_id`),
  CONSTRAINT `payment_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_histories`
--

LOCK TABLES `payment_histories` WRITE;
/*!40000 ALTER TABLE `payment_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_histories` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'auth_token','2c911a7ae508c0e57892138621a2e95d0d4ee44fa121a4407bc1cd297ac6b8cf','[\"*\"]','2026-02-10 15:28:31',NULL,'2026-02-10 15:25:35','2026-02-10 15:28:31'),(2,'App\\Models\\User',22,'auth_token','edb7ae4b97c44e1f40e9946e2cb12137b2a94d5bcc34d18ca8d5e8d779ed29e1','[\"*\"]','2026-02-10 22:26:27',NULL,'2026-02-10 15:29:40','2026-02-10 22:26:27'),(3,'App\\Models\\User',1,'auth_token','2320a65fc97e8f7228f16d0c740eee7d4798221a84ccf2204f245876360dfa9e','[\"*\"]','2026-02-11 09:27:41',NULL,'2026-02-10 22:27:05','2026-02-11 09:27:41'),(4,'App\\Models\\User',1,'auth_token','9729b2eebca7f6c07b68b575f76db3436ddb3d42f1d0818c736aac636ab501e1','[\"*\"]','2026-02-11 10:40:21',NULL,'2026-02-11 10:03:21','2026-02-11 10:40:21'),(5,'App\\Models\\User',1,'auth_token','443a1654edd16dd1aa9a7b5aae041ca315f39981a8476ef3ba71fcba4a5782ef','[\"*\"]','2026-02-11 11:41:50',NULL,'2026-02-11 11:38:27','2026-02-11 11:41:50'),(6,'App\\Models\\User',1,'auth_token','244a296350f625a3eec41a8f10f1950b733ebbb3fbcc07949327039fd964126b','[\"*\"]','2026-02-11 14:11:05',NULL,'2026-02-11 13:27:45','2026-02-11 14:11:05'),(7,'App\\Models\\User',1,'auth_token','37124a457d6ab11024ff603c07030da1bd4df321e635c9fb1297d370366dfa01','[\"*\"]','2026-02-11 15:06:16',NULL,'2026-02-11 14:13:38','2026-02-11 15:06:16'),(8,'App\\Models\\User',1,'auth_token','9f9fbaf5bef1e4f90036bba6c1f932c5919b4e2d99c3672b1c3946d57158cfe8','[\"*\"]','2026-02-11 16:14:18',NULL,'2026-02-11 15:47:27','2026-02-11 16:14:18'),(9,'App\\Models\\User',1,'auth_token','d5d629fb5e3f1a2aa40da9b12563b19333e217d3f2c2e656ba367b0ed135a243','[\"*\"]','2026-02-11 17:09:15',NULL,'2026-02-11 17:08:16','2026-02-11 17:09:15'),(10,'App\\Models\\User',1,'auth_token','da06760963693313a382a67fc38fd8db8700e27fba4e3c12e53c1b28fa185c84','[\"*\"]','2026-02-12 13:38:59',NULL,'2026-02-11 18:01:07','2026-02-12 13:38:59'),(11,'App\\Models\\User',1,'auth_token','6b65fa708447f725b395e0044ae07edc5f06db3e3252c04d6aba7c5eeffbf743','[\"*\"]','2026-02-12 15:34:56',NULL,'2026-02-12 13:48:42','2026-02-12 15:34:56'),(12,'App\\Models\\User',1,'auth_token','420247aed126e5ac9d219c8b1a3243692e49ea6e5bf34376353c88ca7c1b2984','[\"*\"]','2026-02-13 17:14:22',NULL,'2026-02-13 16:27:22','2026-02-13 17:14:22'),(13,'App\\Models\\User',1,'auth_token','ab95676f4c86f0335c7950b348ce81f4021569f57e69ebb1f64906790cd5f0fe','[\"*\"]','2026-02-18 18:48:05',NULL,'2026-02-18 17:27:22','2026-02-18 18:48:05'),(14,'App\\Models\\User',1,'auth_token','1b5ce4606aa28f0b1a361bcb346ab545ac14c6d5ae91e80140eac757a6ea93ae','[\"*\"]','2026-02-22 22:58:45',NULL,'2026-02-20 19:02:19','2026-02-22 22:58:45'),(15,'App\\Models\\User',1,'auth_token','1cad3606ff48683e509f53fc04cb0122ebad2f264f9bb77614d829c6f1599c76','[\"*\"]','2026-02-24 13:46:27',NULL,'2026-02-24 13:37:16','2026-02-24 13:46:27'),(16,'App\\Models\\User',1,'auth_token','c9d8daff4bac56f61204a9833d889920115c1e2f0d9bcc7a592bd3170c8cd6e6','[\"*\"]','2026-02-24 14:49:04',NULL,'2026-02-24 13:55:23','2026-02-24 14:49:04'),(17,'App\\Models\\User',1,'auth_token','155e6a65ab2e774912a930c3146cc7226c071a2d980a34e389944b9cd98afe27','[\"*\"]','2026-02-25 11:21:07',NULL,'2026-02-25 10:36:57','2026-02-25 11:21:07'),(18,'App\\Models\\User',1,'auth_token','7932d31800b3d8a7c39a86c40454590d6c22101cdff4c990c5074022f2abe431','[\"*\"]','2026-02-25 18:09:25',NULL,'2026-02-25 12:58:30','2026-02-25 18:09:25'),(19,'App\\Models\\User',1,'auth_token','844b15a6607d5770c9b766c5666caa04a3f48bb001f0808d50ccd2a98a919443','[\"*\"]','2026-02-26 12:01:44',NULL,'2026-02-26 09:14:01','2026-02-26 12:01:44'),(20,'App\\Models\\User',1,'auth_token','0ced6d54c91b3b0123997b80418d76cd70f4255b7015f5bdc203cd2958a3f8e5','[\"*\"]','2026-02-26 14:01:56',NULL,'2026-02-26 14:01:52','2026-02-26 14:01:56'),(21,'App\\Models\\User',1,'auth_token','03b81114b76f40706f174cd69f8a86b342ed0ddbf576aaae5be3cdaecbeb24ab','[\"*\"]','2026-02-27 11:02:33',NULL,'2026-02-26 22:13:04','2026-02-27 11:02:33'),(22,'App\\Models\\User',1,'auth_token','f95347c2f66572869a860b46adbef5a013f9107e76a290a62ec080ddeb4de0d5','[\"*\"]','2026-02-27 00:19:31',NULL,'2026-02-27 00:19:30','2026-02-27 00:19:31'),(23,'App\\Models\\User',1,'auth_token','bda5a54a261148fc23f15795b294c4301654be7068a0ffa4cf5980834c62acb1','[\"*\"]','2026-02-27 00:22:00',NULL,'2026-02-27 00:22:00','2026-02-27 00:22:00'),(24,'App\\Models\\User',1,'auth_token','47ca572c099db7b32cf938048b65cc7e4093ae2022d65fb28e1155ad3894523f','[\"*\"]','2026-02-27 00:34:27',NULL,'2026-02-27 00:34:26','2026-02-27 00:34:27'),(25,'App\\Models\\User',1,'auth_token','93013ac3960832470860586744a72606188b90d4ff1d9198e4af23a2b90a7b67','[\"*\"]','2026-02-27 00:35:09',NULL,'2026-02-27 00:35:09','2026-02-27 00:35:09'),(26,'App\\Models\\User',1,'auth_token','a79d3f7358b9ec96ac2b26927b9298842a2a84b0b20a56ff3a0a51cca330a7d8','[\"*\"]','2026-02-27 00:39:38',NULL,'2026-02-27 00:39:38','2026-02-27 00:39:38');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poll_options`
--

DROP TABLE IF EXISTS `poll_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `poll_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `option_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `votes_count` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `poll_options_post_id_foreign` (`post_id`),
  CONSTRAINT `poll_options_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poll_options`
--

LOCK TABLES `poll_options` WRITE;
/*!40000 ALTER TABLE `poll_options` DISABLE KEYS */;
INSERT INTO `poll_options` VALUES (44,60,'g',1,'2026-02-27 02:02:19','2026-02-27 02:02:23'),(45,60,'g',1,'2026-02-27 02:02:19','2026-02-27 02:02:22');
/*!40000 ALTER TABLE `poll_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poll_votes`
--

DROP TABLE IF EXISTS `poll_votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `poll_votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `post_id` bigint unsigned NOT NULL,
  `poll_option_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `poll_votes_user_id_poll_option_id_unique` (`user_id`,`poll_option_id`),
  KEY `poll_votes_post_id_foreign` (`post_id`),
  KEY `poll_votes_poll_option_id_foreign` (`poll_option_id`),
  KEY `poll_votes_user_id_index` (`user_id`),
  CONSTRAINT `poll_votes_poll_option_id_foreign` FOREIGN KEY (`poll_option_id`) REFERENCES `poll_options` (`id`) ON DELETE CASCADE,
  CONSTRAINT `poll_votes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `poll_votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poll_votes`
--

LOCK TABLES `poll_votes` WRITE;
/*!40000 ALTER TABLE `poll_votes` DISABLE KEYS */;
INSERT INTO `poll_votes` VALUES (18,1,60,45,'2026-02-27 02:02:22','2026-02-27 02:02:22'),(19,1,60,44,'2026-02-27 02:02:23','2026-02-27 02:02:23');
/*!40000 ALTER TABLE `poll_votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `is_mandatory` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `media` json DEFAULT NULL,
  `feed_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'personal',
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `meta` json DEFAULT NULL,
  `poll_expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_index` (`user_id`),
  KEY `posts_feed_type_index` (`feed_type`),
  KEY `posts_created_at_index` (`created_at`),
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (58,1,'post',0,'Jjj','Jjjj','[]','feed',NULL,'public',NULL,NULL,'2026-02-26 12:01:17','2026-02-26 12:01:17'),(59,1,'post',0,'Teste','Teste','[\"/data/user/0/com.mere.app/cache/de49ad3b-f113-48f5-b1f9-dd01924436d5/VID-20260226-WA0008.mp4\", \"/data/user/0/com.mere.app/cache/693bfe5f-1c48-49e7-a372-8f3e93700529/Screenshot_2026-02-26-21-32-30-444_com.instagram.android.jpg\", \"/data/user/0/com.mere.app/cache/978637c7-62be-45dd-92b9-8da8f9102b25/Screenshot_2026-02-26-21-32-26-261_com.instagram.android.jpg\", \"/data/user/0/com.mere.app/cache/1567494b-0862-437b-b798-255d5cacfdb1/Screenshot_2026-02-26-09-16-51-539_com.runbuddy.prod.jpg\", \"/data/user/0/com.mere.app/cache/c2b332e5-0909-4879-b4d2-d140b579d134/Screenshot_2026-02-25-17-38-26-159_com.instagram.android.jpg\"]','feed',NULL,'public',NULL,NULL,'2026-02-27 02:01:18','2026-02-27 02:01:18'),(60,1,'poll',0,'Enquete','Enquete','[]','feed',NULL,'public','{\"isMultiple\": true}','2026-03-06 01:02:17','2026-02-27 02:02:19','2026-02-27 02:02:19'),(61,1,'post',0,'Vídeo vídeo','','[\"/data/user/0/com.mere.app/cache/4675031d-6702-495f-b9d3-aba6e98d13ff/VID_20260109_083110.mp4\"]','feed',NULL,'public',NULL,NULL,'2026-02-27 09:02:02','2026-02-27 09:02:02');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `plan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'free',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `height` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mere` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `x` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiktok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profiles_user_id_foreign` (`user_id`),
  CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,1,'admin','annual','active',NULL,'mere',NULL,'teste do Mere','Masculino','22/9/1985','Brasil',NULL,NULL,NULL,'177','85.0','profiles/WnUSr2LnfNhiljLmqdMz96aHOp0gkTraBCg6DbKN.jpg','covers/ICmYFdtznti6Ade7KgaCRJltlksKLNVN5BsMBZm2.jpg',NULL,NULL,NULL,NULL,NULL,NULL,'{\"disable_sounds\": true, \"disable_notifications\": true}','2026-02-10 13:36:18','2026-02-19 13:25:47'),(2,2,'user','free','active','(11) 98715-3809',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:18','2026-02-10 13:36:18'),(3,3,'user','free','active','(11) 98842-2796',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:18','2026-02-10 13:36:18'),(4,4,'user','free','active','(11) 92302-4894',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:18','2026-02-10 13:36:18'),(5,5,'user','free','active','(11) 98754-4731',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:19','2026-02-10 13:36:19'),(6,6,'user','monthly','active','(11) 95758-1503',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:19','2026-02-10 13:36:19'),(7,7,'user','monthly','active','(11) 93979-2038',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:19','2026-02-10 13:36:19'),(8,8,'user','monthly','active','(11) 96673-7160',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:19','2026-02-10 13:36:19'),(9,9,'user','annual','active','(11) 94845-5049',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:20','2026-02-10 13:36:20'),(10,10,'user','annual','active','(11) 98503-4368',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:20','2026-02-10 13:36:20'),(11,11,'user','annual','active','(11) 94445-4132',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:20','2026-02-10 13:36:20'),(12,12,'user','monthly','active','(11) 95928-8812',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:20','2026-02-10 13:36:20'),(13,13,'user','annual','active','(11) 94334-6870',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:20','2026-02-10 13:36:20'),(14,14,'user','monthly','active','(11) 92530-6776',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:21','2026-02-10 13:36:21'),(15,15,'user','monthly','active','(11) 95986-3261',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:21','2026-02-10 13:36:21'),(16,16,'user','annual','active','(11) 97554-6033',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:21','2026-02-10 13:36:21'),(17,17,'user','annual','active','(11) 91802-8653',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:21','2026-02-10 13:36:21'),(18,18,'user','monthly','active','(11) 97998-4442',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(19,19,'user','monthly','active','(11) 93449-4517',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(20,20,'user','annual','active','(11) 95343-2667',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:22','2026-02-10 13:36:22'),(21,21,'user','monthly','active','(11) 94927-2079',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:22','2026-02-10 13:36:22');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reporter_id` bigint unsigned NOT NULL,
  `reported_user_id` bigint unsigned DEFAULT NULL,
  `reported_message_id` bigint unsigned DEFAULT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_reporter_id_foreign` (`reporter_id`),
  KEY `reports_reported_user_id_foreign` (`reported_user_id`),
  KEY `reports_reported_message_id_foreign` (`reported_message_id`),
  CONSTRAINT `reports_reported_message_id_foreign` FOREIGN KEY (`reported_message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reports_reported_user_id_foreign` FOREIGN KEY (`reported_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reports_reporter_id_foreign` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saved_items`
--

DROP TABLE IF EXISTS `saved_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `saved_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `saved_item_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `saved_item_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `saved_items_user_id_saved_item_id_saved_item_type_unique` (`user_id`,`saved_item_id`,`saved_item_type`),
  KEY `saved_items_saved_item_type_saved_item_id_index` (`saved_item_type`,`saved_item_id`),
  CONSTRAINT `saved_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saved_items`
--

LOCK TABLES `saved_items` WRITE;
/*!40000 ALTER TABLE `saved_items` DISABLE KEYS */;
INSERT INTO `saved_items` VALUES (1,1,'App\\Models\\Post',45,'2026-02-23 10:10:51','2026-02-23 10:10:51'),(2,1,'App\\Models\\Post',48,'2026-02-24 14:15:31','2026-02-24 14:15:31'),(4,1,'App\\Models\\Post',55,'2026-02-26 09:17:36','2026-02-26 09:17:36'),(5,1,'App\\Models\\Post',56,'2026-02-26 09:18:07','2026-02-26 09:18:07'),(6,1,'App\\Models\\Post',58,'2026-02-26 12:01:42','2026-02-26 12:01:42');
/*!40000 ALTER TABLE `saved_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#3788d8',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_user_id_foreign` (`user_id`),
  CONSTRAINT `schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` VALUES (1,1,'Treino Matinal','Corrida leve no parque',NULL,'2026-02-11','07:00:00','Primary','2026-02-10 13:36:22','2026-02-10 13:36:22');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('0lABsjZ7wuB9JN4mrPBSl9oLyg9etBOaWxwCY3ch',NULL,'167.94.138.116','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoicHRkM3FzWjd4ZTZWQ0VVSHJhMVcwRzBwalJBOFl0RWNwbTJqWmI2RyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly83Ni4xMy4xNjguMzMiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1772189667),('0sXs15OSMbmFwO1YhICumAgriRt3wULnwZAsstJP',NULL,'201.71.131.222','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRkZZSzJTemxoUll5cUxocHVNM3BSdmFwQjAzbVVtQkJ4TmFFeXFUTiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMDoiaHR0cHM6Ly9rZW5ueXJvZ2VyLmNvbS5ici9ob21lIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8va2Vubnlyb2dlci5jb20uYnIvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1772204955),('1BKx6LdFEIOa4qAP9TedaOGTv4CLoIs9irMP5NQl',NULL,'74.7.243.131','Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.3; +https://openai.com/gptbot)','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT2pxNGUzQ1h1bHpiTkQzeHhjSUFzN04xWFFrbjRmd0YyRmttZWtSTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vd3d3Lmtlbm55cm9nZXIuY29tLmJyL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cHM6Ly93d3cua2Vubnlyb2dlci5jb20uYnIvaG9tZSI7fX0=',1772164901),('56q1Fv1gjdMXh6WpLAufEsV4jdUtTJb80JuSpFh2',NULL,'167.94.138.116','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoibzJiMXB1em04ZnZZRUJqWEVZYjRTeVFMUml2Q3VFelhPSExpaXJrOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vNzYuMTMuMTY4LjMzL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1772189674),('6JYH9v64egUgnxc3aoU5E4sotACgWhEOau89e3yZ',NULL,'216.180.246.47','Mozilla/5.0 (compatible; GenomeCrawlerd/1.0; +https://www.nokia.com/genomecrawler)','YTozOntzOjY6Il90b2tlbiI7czo0MDoialBMVFVuVjBYMW5KQTdNdUJIOG01UVJZa2hDblA4YXRINWNqbE5yRSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vNzYuMTMuMTY4LjMzL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1772189038),('7wU9Cnkzoe7OhUUpjGv4yqM6yzSydIrLhA6QarSw',1,'177.200.189.23','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVjZLU0ZJZkVScnkyOTY1N3U0ZHo5eURuS1lpUDdZNkdwMmxBUXdqRiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwczovL2tlbm55cm9nZXIuY29tLmJyL2hvbWUiO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1772170530),('aSRd7X5N3lOJ5qvMOP9Y9XtENJeWexWWTsJehihI',NULL,'167.94.138.174','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoicnRhUllmWjZYOUtPYmFqR0ExVkliY0ZzZVpaSUFyaWtBN3ptMnJwRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vNzYuMTMuMTY4LjMzL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1772195264),('ghr4Y2pi8EBrHT8Nri7ALJ029oE9OaDQTPMKo8Mi',NULL,'199.244.88.224','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoia0RQNW10S2F6Y1pwcGpKRFBBRU1GY3UyUjJPbmlTMUVhMjNsbVlDSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8va2Vubnlyb2dlci5jb20uYnIvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1772194499),('gRK9igj6vs2PqZLAq0xoKQw4U3Fo1CByN3aBZhNq',NULL,'167.94.138.174','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoidkdGQ1AySVZCY1ZtQ2ZiRTdONVI4cGQ2Tm90Zm1ob0lpdkhRa3VDZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vNzYuMTMuMTY4LjMzL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1772195299),('Gs6ykqEWLP4qw3q23TrusbdQRe6sVGrTsQ8OkZR7',NULL,'167.94.138.174','Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVkNlOFBOZFVNYmtWVUdoNzNIOEFoblA0NmNVeDBYQUk5ZGFlTlhESiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vNzYuMTMuMTY4LjMzIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1772195256),('HywFkKtxswAvWeSLUnicpNYTjat5UgLs6h2tnzhZ',NULL,'51.68.111.204','Mozilla/5.0 (compatible; MJ12bot/v2.0.5; http://mj12bot.com/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRG8zODh6TTk5TWU2czVod2oxakhIYWNuYW1OSnhaUlJpRGFOM0Y0TSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vd3d3Lmtlbm55cm9nZXIuY29tLmJyIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1772191884),('iezKXytREF27mJevsmYrmfBWViowT5IwJdREqm4H',NULL,'177.200.189.23','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQmNtQU0zdDhlNzd1dm5RMUVMOHlKaDJMVjdYT3dKbWd3RlRUbFc4eSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMDoiaHR0cHM6Ly9rZW5ueXJvZ2VyLmNvbS5ici9ob21lIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8va2Vubnlyb2dlci5jb20uYnIvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1772195123),('jXswfMP9mUTMRpOyPspJ8OxH4V8eSWNs2B5Gbxcw',NULL,'74.7.242.34','Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.3; +https://openai.com/gptbot)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaGF4VmI0SjFOSXJpc2lhVFplY2dZajNVaGJYclZiQXA3RGFjMXBBOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8va2Vubnlyb2dlci5jb20uYnIvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1772197689),('ORq1BiXXRPlmVz2wANdcCJxXyFcW7iJbq4IPFLn1',NULL,'177.200.189.23','Dart/3.9 (dart:io)','YToyOntzOjY6Il90b2tlbiI7czo0MDoiZFZibExDb2lvQmRZOWtOcXdDeURMeUhkY0VWdnE3dmZSUWtWUHBUViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1772164682),('PkHe3DvxqBGaw2Eblqh8j29j7C4YGNWDJ8zf0ooM',NULL,'216.180.246.47','Mozilla/5.0 (compatible; GenomeCrawlerd/1.0; +https://www.nokia.com/genomecrawler)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMXlSVUxMMHM2VTJmVjE2eUlLb1BZWk00c1prUEZNVFNlSVhqSDBXSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vNzYuMTMuMTY4LjMzIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1772189036),('SqvsRNYEPq5OF1r6VoIBaDAmaIF3pQIxypDkVxL8',NULL,'177.200.189.23','Dart/3.9 (dart:io)','YTozOntzOjY6Il90b2tlbiI7czo0MDoicDZMVVJpckJzWDZ2aHBUN2hPcTlmUm5sSlc1SkIzaFpDeUNPNXNKOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8va2Vubnlyb2dlci5jb20uYnIvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1772164551),('tiZDdvuOjd6JKDBj6cd3Z7KjZD1WpwU1fYgRuzlh',NULL,'177.200.189.23','Dart/3.9 (dart:io)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUlFKbzlHSVo1TzQ4VnNPOHl3TnFYMlBlNUNsZGhKV1NQWHNmYTZCeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8va2Vubnlyb2dlci5jb20uYnIvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1772164682),('Tk6embXlGMomQQOPoLXq0SZXrG2fZQ4jkV0pg2LZ',1,'177.200.189.23','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRFhUTnNaUXRkSUExRjVuRGxQWVBoZ3A0OWNkaU5NVGs1bmZlVWxuMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTk1OiJodHRwczovL2tlbm55cm9nZXIuY29tLmJyL2xpdmV3aXJlLTIyOTczMjZhL3ByZXZpZXctZmlsZS9wZXZpTmZrREhjc3pSM29DaUdpNnJZMnhwWDA0RGxiVldrdXR4Tm55LmpwZz9leHBpcmVzPTE3NzIxNjgzOTkmc2lnbmF0dXJlPTUyOGY2NDQ4NmI1OWZjMWZmZTA4OTEyOWMwYWM5ZTk3NjUxM2I1OTNjOWVlN2QyNDRjM2Y1NTMzNGFmZTc3ZjYiO3M6NToicm91dGUiO3M6MjE6ImxpdmV3aXJlLnByZXZpZXctZmlsZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1772171227),('vcWCLTT1EPuWdJBljByIH1dBnI47JCGDWVMX5TEO',NULL,'220.197.78.72','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoib3JkM2pJQ2VvaXJRbkxUYnBpT1hiWld5bWxTSXhmcHlHQjNLYTJ0ciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vNzYuMTMuMTY4LjMzIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1772172864),('WPdBJcZDBewPF0TqeSfNfsW8gyvgcwymY1eg7eYH',NULL,'123.160.175.80','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoic3FzQ3VkY21QaWhUZWEzRmhVaWFjRE1sUzZtNjZYMnc5WHNtbW9rSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vNzYuMTMuMTY4LjMzL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1772172874),('xbvZ6vzaORJZ1ZPRMeXIbTniMzeXKm1XWydYyp3r',NULL,'107.189.17.131','curl/7.81.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoibXBaVXNidXB6cUJkUXJyZnlUUFFCTUp3NWtlWFFjUjM0QncxaFY4TiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjU6Imh0dHA6Ly83Ni4xMy4xNjguMzMvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1772199820),('XhZtLMmF54Olj1s7JAgQkKUZ0zMy2axzdjGk0c0x',NULL,'134.122.71.48','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ0duVDROSTJhU1Zra0d0VWJVVmdZcUt0bnNBSHFvaU9UT0R3a0tNSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8va2Vubnlyb2dlci5jb20uYnIvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1772203003),('zqm6y8PZsvQru7BmX4ZcpP2kC6zRw7ZW0GhqLpsR',NULL,'51.68.111.204','Mozilla/5.0 (compatible; MJ12bot/v2.0.5; http://mj12bot.com/)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWjlQd2I1bVdtUlNMUlNEODBsUFBKMTBaMjJxRGt0dzlZWGNTN0lkNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vd3d3Lmtlbm55cm9nZXIuY29tLmJyL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1772191884);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stories`
--

DROP TABLE IF EXISTS `stories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stories_user_id_foreign` (`user_id`),
  CONSTRAINT `stories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stories`
--

LOCK TABLES `stories` WRITE;
/*!40000 ALTER TABLE `stories` DISABLE KEYS */;
INSERT INTO `stories` VALUES (1,1,'https://picsum.photos/seed/10/1080/1920','2026-02-11 02:36:22','2026-02-10 09:52:22','2026-02-10 13:36:22'),(2,1,'https://picsum.photos/seed/11/1080/1920','2026-02-10 20:36:22','2026-02-10 10:46:22','2026-02-10 13:36:22'),(3,1,'https://picsum.photos/seed/12/1080/1920','2026-02-11 03:36:22','2026-02-10 13:26:22','2026-02-10 13:36:22'),(4,2,'https://picsum.photos/seed/20/1080/1920','2026-02-11 10:36:22','2026-02-10 09:04:22','2026-02-10 13:36:22'),(5,2,'https://picsum.photos/seed/21/1080/1920','2026-02-10 22:36:22','2026-02-10 13:04:22','2026-02-10 13:36:22'),(6,2,'https://picsum.photos/seed/22/1080/1920','2026-02-10 23:36:22','2026-02-10 09:45:22','2026-02-10 13:36:22'),(7,3,'https://picsum.photos/seed/30/1080/1920','2026-02-10 19:36:22','2026-02-10 08:42:22','2026-02-10 13:36:22'),(8,3,'https://picsum.photos/seed/31/1080/1920','2026-02-11 01:36:22','2026-02-10 10:11:22','2026-02-10 13:36:22'),(9,3,'https://picsum.photos/seed/32/1080/1920','2026-02-11 12:36:22','2026-02-10 10:26:22','2026-02-10 13:36:22'),(10,4,'https://picsum.photos/seed/40/1080/1920','2026-02-11 08:36:22','2026-02-10 08:54:22','2026-02-10 13:36:22'),(11,4,'https://picsum.photos/seed/41/1080/1920','2026-02-11 10:36:22','2026-02-10 09:58:22','2026-02-10 13:36:22'),(12,4,'https://picsum.photos/seed/42/1080/1920','2026-02-11 12:36:22','2026-02-10 12:34:22','2026-02-10 13:36:22'),(13,5,'https://picsum.photos/seed/50/1080/1920','2026-02-11 11:36:22','2026-02-10 08:50:22','2026-02-10 13:36:22'),(14,5,'https://picsum.photos/seed/51/1080/1920','2026-02-11 10:36:22','2026-02-10 09:25:22','2026-02-10 13:36:22'),(15,5,'https://picsum.photos/seed/52/1080/1920','2026-02-10 21:36:22','2026-02-10 12:43:22','2026-02-10 13:36:22'),(16,6,'https://picsum.photos/seed/60/1080/1920','2026-02-11 10:36:22','2026-02-10 13:26:22','2026-02-10 13:36:22'),(17,6,'https://picsum.photos/seed/61/1080/1920','2026-02-11 10:36:22','2026-02-10 11:15:22','2026-02-10 13:36:22'),(18,6,'https://picsum.photos/seed/62/1080/1920','2026-02-11 00:36:22','2026-02-10 11:34:22','2026-02-10 13:36:22'),(19,7,'https://picsum.photos/seed/70/1080/1920','2026-02-10 17:36:22','2026-02-10 10:55:22','2026-02-10 13:36:22'),(20,7,'https://picsum.photos/seed/71/1080/1920','2026-02-10 19:36:22','2026-02-10 10:34:22','2026-02-10 13:36:22'),(21,7,'https://picsum.photos/seed/72/1080/1920','2026-02-11 04:36:22','2026-02-10 09:58:22','2026-02-10 13:36:22'),(22,8,'https://picsum.photos/seed/80/1080/1920','2026-02-11 08:36:22','2026-02-10 08:38:22','2026-02-10 13:36:22'),(23,8,'https://picsum.photos/seed/81/1080/1920','2026-02-10 18:36:22','2026-02-10 12:24:22','2026-02-10 13:36:22'),(24,8,'https://picsum.photos/seed/82/1080/1920','2026-02-10 18:36:22','2026-02-10 12:46:22','2026-02-10 13:36:22'),(25,9,'https://picsum.photos/seed/90/1080/1920','2026-02-11 10:36:22','2026-02-10 12:57:22','2026-02-10 13:36:22'),(26,9,'https://picsum.photos/seed/91/1080/1920','2026-02-11 00:36:22','2026-02-10 12:09:22','2026-02-10 13:36:22'),(27,9,'https://picsum.photos/seed/92/1080/1920','2026-02-11 04:36:22','2026-02-10 10:20:22','2026-02-10 13:36:22'),(28,10,'https://picsum.photos/seed/100/1080/1920','2026-02-11 06:36:23','2026-02-10 08:58:23','2026-02-10 13:36:23'),(29,10,'https://picsum.photos/seed/101/1080/1920','2026-02-11 02:36:23','2026-02-10 11:39:23','2026-02-10 13:36:23'),(30,10,'https://picsum.photos/seed/102/1080/1920','2026-02-11 12:36:23','2026-02-10 12:36:23','2026-02-10 13:36:23'),(31,11,'https://picsum.photos/seed/110/1080/1920','2026-02-11 07:36:23','2026-02-10 11:22:23','2026-02-10 13:36:23'),(32,11,'https://picsum.photos/seed/111/1080/1920','2026-02-11 13:36:23','2026-02-10 10:50:23','2026-02-10 13:36:23'),(33,11,'https://picsum.photos/seed/112/1080/1920','2026-02-11 04:36:23','2026-02-10 12:59:23','2026-02-10 13:36:23'),(34,12,'https://picsum.photos/seed/120/1080/1920','2026-02-11 01:36:23','2026-02-10 10:08:23','2026-02-10 13:36:23'),(35,12,'https://picsum.photos/seed/121/1080/1920','2026-02-11 10:36:23','2026-02-10 12:30:23','2026-02-10 13:36:23'),(36,12,'https://picsum.photos/seed/122/1080/1920','2026-02-10 17:36:23','2026-02-10 08:43:23','2026-02-10 13:36:23'),(37,13,'https://picsum.photos/seed/130/1080/1920','2026-02-11 12:36:23','2026-02-10 10:51:23','2026-02-10 13:36:23'),(38,13,'https://picsum.photos/seed/131/1080/1920','2026-02-11 08:36:23','2026-02-10 08:47:23','2026-02-10 13:36:23'),(39,13,'https://picsum.photos/seed/132/1080/1920','2026-02-11 04:36:23','2026-02-10 11:07:23','2026-02-10 13:36:23'),(40,14,'https://picsum.photos/seed/140/1080/1920','2026-02-11 07:36:23','2026-02-10 09:59:23','2026-02-10 13:36:23'),(41,14,'https://picsum.photos/seed/141/1080/1920','2026-02-11 11:36:23','2026-02-10 12:30:23','2026-02-10 13:36:23'),(42,14,'https://picsum.photos/seed/142/1080/1920','2026-02-10 21:36:23','2026-02-10 12:38:23','2026-02-10 13:36:23'),(43,15,'https://picsum.photos/seed/150/1080/1920','2026-02-11 07:36:23','2026-02-10 11:36:23','2026-02-10 13:36:23'),(44,15,'https://picsum.photos/seed/151/1080/1920','2026-02-10 19:36:23','2026-02-10 10:44:23','2026-02-10 13:36:23'),(45,15,'https://picsum.photos/seed/152/1080/1920','2026-02-11 04:36:23','2026-02-10 11:49:23','2026-02-10 13:36:23'),(46,16,'https://picsum.photos/seed/160/1080/1920','2026-02-11 01:36:23','2026-02-10 09:11:23','2026-02-10 13:36:23'),(47,16,'https://picsum.photos/seed/161/1080/1920','2026-02-11 11:36:23','2026-02-10 10:26:23','2026-02-10 13:36:23'),(48,16,'https://picsum.photos/seed/162/1080/1920','2026-02-11 02:36:23','2026-02-10 09:42:23','2026-02-10 13:36:23'),(49,17,'https://picsum.photos/seed/170/1080/1920','2026-02-11 07:36:23','2026-02-10 12:49:23','2026-02-10 13:36:23'),(50,17,'https://picsum.photos/seed/171/1080/1920','2026-02-10 20:36:23','2026-02-10 12:50:23','2026-02-10 13:36:23'),(51,17,'https://picsum.photos/seed/172/1080/1920','2026-02-10 20:36:23','2026-02-10 08:37:23','2026-02-10 13:36:23'),(52,18,'https://picsum.photos/seed/180/1080/1920','2026-02-11 12:36:23','2026-02-10 11:06:23','2026-02-10 13:36:23'),(53,18,'https://picsum.photos/seed/181/1080/1920','2026-02-11 09:36:23','2026-02-10 09:19:23','2026-02-10 13:36:23'),(54,18,'https://picsum.photos/seed/182/1080/1920','2026-02-10 17:36:23','2026-02-10 13:22:23','2026-02-10 13:36:23'),(55,19,'https://picsum.photos/seed/190/1080/1920','2026-02-11 07:36:23','2026-02-10 11:58:23','2026-02-10 13:36:23'),(56,19,'https://picsum.photos/seed/191/1080/1920','2026-02-11 03:36:23','2026-02-10 10:25:23','2026-02-10 13:36:23'),(57,19,'https://picsum.photos/seed/192/1080/1920','2026-02-11 08:36:23','2026-02-10 13:22:23','2026-02-10 13:36:23'),(58,20,'https://picsum.photos/seed/200/1080/1920','2026-02-10 20:36:23','2026-02-10 09:24:23','2026-02-10 13:36:23'),(59,20,'https://picsum.photos/seed/201/1080/1920','2026-02-11 05:36:23','2026-02-10 10:31:23','2026-02-10 13:36:23'),(60,20,'https://picsum.photos/seed/202/1080/1920','2026-02-10 21:36:23','2026-02-10 12:33:23','2026-02-10 13:36:23'),(61,21,'https://picsum.photos/seed/210/1080/1920','2026-02-10 23:36:23','2026-02-10 13:01:23','2026-02-10 13:36:23'),(62,21,'https://picsum.photos/seed/211/1080/1920','2026-02-10 22:36:23','2026-02-10 12:08:23','2026-02-10 13:36:23'),(63,21,'https://picsum.photos/seed/212/1080/1920','2026-02-11 02:36:23','2026-02-10 11:53:23','2026-02-10 13:36:23'),(64,1,'https://kennyroger.com.br/storage/stories/5gWxZNpVpsBB76DVCHI8hC4oNKqTmd0ZO8wSJ4NK.jpg','2026-02-26 15:35:58','2026-02-25 15:35:58','2026-02-25 15:35:58'),(65,1,'https://kennyroger.com.br/storage/stories/b1CGUMvUPNkM0D5qWUKY2TWmyZgR62HW28GdPmIX.jpg','2026-02-26 17:44:19','2026-02-25 17:44:19','2026-02-25 17:44:19'),(66,1,'https://kennyroger.com.br/storage/stories/FpkRbbLp1e1k4gXfiGPPXrZoZvGfVGHlfhJbby8n.png','2026-02-28 00:46:44','2026-02-27 00:46:44','2026-02-27 00:46:44'),(67,1,'https://kennyroger.com.br/storage/stories/hAcZRqQnCydW8cNPzBJ1bb4Kudb4elPrxzhzb6A6.gif','2026-02-28 00:48:48','2026-02-27 00:48:48','2026-02-27 00:48:48'),(68,1,'https://kennyroger.com.br/storage/stories/7E05MRiPFR68pe2svfevtkuFZDOAlN23zc9FWZDX.gif','2026-02-28 00:49:43','2026-02-27 00:49:43','2026-02-27 00:49:43'),(69,1,'https://kennyroger.com.br/storage/stories/lY71F38cP1kk2aazrQOl2UpU5flgbAAUSSPv4pP2.jpg','2026-02-28 00:53:56','2026-02-27 00:53:56','2026-02-27 00:53:56');
/*!40000 ALTER TABLE `stories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription_items`
--

DROP TABLE IF EXISTS `subscription_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscription_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subscription_id` bigint unsigned NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_product` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meter_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `meter_event_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscription_items_stripe_id_unique` (`stripe_id`),
  KEY `subscription_items_subscription_id_stripe_price_index` (`subscription_id`,`stripe_price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_items`
--

LOCK TABLES `subscription_items` WRITE;
/*!40000 ALTER TABLE `subscription_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscription_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription_plans`
--

DROP TABLE IF EXISTS `subscription_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscription_plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BRL',
  `billing_period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `features` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscription_plans_slug_unique` (`slug`),
  UNIQUE KEY `subscription_plans_stripe_plan_id_unique` (`stripe_plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_plans`
--

LOCK TABLES `subscription_plans` WRITE;
/*!40000 ALTER TABLE `subscription_plans` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscription_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subscriptions_stripe_id_unique` (`stripe_id`),
  KEY `subscriptions_user_id_stripe_status_index` (`user_id`,`stripe_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_replies`
--

DROP TABLE IF EXISTS `support_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_replies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `support_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `support_replies_support_id_foreign` (`support_id`),
  KEY `support_replies_user_id_foreign` (`user_id`),
  CONSTRAINT `support_replies_support_id_foreign` FOREIGN KEY (`support_id`) REFERENCES `supports` (`id`) ON DELETE CASCADE,
  CONSTRAINT `support_replies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_replies`
--

LOCK TABLES `support_replies` WRITE;
/*!40000 ALTER TABLE `support_replies` DISABLE KEYS */;
/*!40000 ALTER TABLE `support_replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supports`
--

DROP TABLE IF EXISTS `supports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `ticket_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'low',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `supports_ticket_id_unique` (`ticket_id`),
  KEY `supports_user_id_foreign` (`user_id`),
  CONSTRAINT `supports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supports`
--

LOCK TABLES `supports` WRITE;
/*!40000 ALTER TABLE `supports` DISABLE KEYS */;
INSERT INTO `supports` VALUES (1,1,'TICKET-698B5E86A4AE9','Problema com login','Não consigo acessar minha conta premium.','open','high','2026-02-10 13:36:22','2026-02-10 13:36:22'),(2,1,'TICKET-698B5E86A551C','Dúvida sobre planos','Quais as formas de pagamento aceitas?','pending','medium','2026-02-10 13:36:22','2026-02-10 13:36:22');
/*!40000 ALTER TABLE `supports` ENABLE KEYS */;
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
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_last_four` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_google_id_unique` (`google_id`),
  KEY `users_stripe_id_index` (`stripe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mere App','mereapp.mt@gmail.com','2026-02-10 13:36:18','$2y$12$DsX1kTHrM8/pwRy748tYxu1W.AEgDM5i2/IBV2sZXJR9q03lliMca',NULL,NULL,NULL,'112684525080651459485','https://lh3.googleusercontent.com/a/ACg8ocIJ84vZh-clZJd0Qjye6hCh0DHjbbEzI1iQXetsu__g7CfWfA=s96-c','0uiqMWk8jtMTm1FuiVBFL5n5LR7urUhsBGMIOgl409HycvAlz2ZWxpNlrupg','2026-02-10 13:36:18','2026-02-18 18:46:40',NULL,NULL,NULL,NULL),(2,'Usuário 1','usuario1@example.com','2026-02-10 13:36:18','$2y$12$nQtKyhIV9.n.H5bQ.56MqumYSuFVAybR00D6evxPGfzWJdUpIn9Va',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:18','2026-02-10 13:36:18',NULL,NULL,NULL,NULL),(3,'Usuário 2','usuario2@example.com','2026-02-10 13:36:18','$2y$12$X/ot0ID8Gn9kv47B4GOU7uc6k3v8ZBoZEOLBYZ51dIqNcT1O8xCSO',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:18','2026-02-10 13:36:18',NULL,NULL,NULL,NULL),(4,'Usuário 3','usuario3@example.com','2026-02-10 13:36:18','$2y$12$xjIqivr1vivzgaPlgGgo7.Loup6sJvXcdvRoBUwvm6vwPK4GjZ0GC',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:18','2026-02-10 13:36:18',NULL,NULL,NULL,NULL),(5,'Usuário 4','usuario4@example.com','2026-02-10 13:36:19','$2y$12$i3l4OhR2s4J6qXIi7Zfs0.Wbvj96bgzPCkcZkeSq190KA4s8PlQcm',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:19','2026-02-10 13:36:19',NULL,NULL,NULL,NULL),(6,'Usuário 5','usuario5@example.com','2026-02-10 13:36:19','$2y$12$yNjtW03at5Mw95.Iea6jI.riN4E.wcymeucTN3vqH4Qw/F9cRxSMO',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:19','2026-02-10 13:36:19',NULL,NULL,NULL,NULL),(7,'Usuário 6','usuario6@example.com','2026-02-10 13:36:19','$2y$12$xsqYdgpKGZIuwmFBGRLTk.iJo1lcIGH./tSTMFaLnbNwmhbLzmWii',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:19','2026-02-10 13:36:19',NULL,NULL,NULL,NULL),(8,'Usuário 7','usuario7@example.com','2026-02-10 13:36:19','$2y$12$lmgURHIz2uvW0TucrH58IegodA5CS7ttpfz7z6Wo3qjDY7f74HsmW',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:19','2026-02-10 13:36:19',NULL,NULL,NULL,NULL),(9,'Usuário 8','usuario8@example.com','2026-02-10 13:36:20','$2y$12$Q0R/Cknbq9nE0OLfHYEctOYavXxbRf44ssw5rWXEt6c84UkMdEJ..',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:20','2026-02-10 13:36:20',NULL,NULL,NULL,NULL),(10,'Usuário 9','usuario9@example.com','2026-02-10 13:36:20','$2y$12$F2tYkdGCtoR8960PmjLxTuxuyJ4m4jjbtjU4FyacMYp1p2OB0RFby',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:20','2026-02-10 13:36:20',NULL,NULL,NULL,NULL),(11,'Usuário 10','usuario10@example.com','2026-02-10 13:36:20','$2y$12$AuAlCOKfFzwQf0vE/DM6sO/sIGDBUrRlR.HtV0Usn3WNegds7pCKq',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:20','2026-02-10 13:36:20',NULL,NULL,NULL,NULL),(12,'Assinante 1','subscriber1@example.com','2026-02-10 13:36:20','$2y$12$89mCxxX.fPuut/X0HWbam.G50MjFIz/rFPby7TTr29U1lNeFfTwbO',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:20','2026-02-10 13:36:20',NULL,NULL,NULL,NULL),(13,'Assinante 2','subscriber2@example.com','2026-02-10 13:36:20','$2y$12$Iln40x2JlJT2ag4Wazq4PuwSfKZMn1N9N0u79lOVjupXqmdmmk5/6',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:20','2026-02-10 13:36:20',NULL,NULL,NULL,NULL),(14,'Assinante 3','subscriber3@example.com','2026-02-10 13:36:21','$2y$12$rGap0Vw5cAMpW1YHbwwEi.qDi3P4DeyulL/SZ/UA/a7xJqedRK10W',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:21','2026-02-10 13:36:21',NULL,NULL,NULL,NULL),(15,'Assinante 4','subscriber4@example.com','2026-02-10 13:36:21','$2y$12$/lWnJmnGOCsorCDncTglxujkKIaTxu8xoT9henMUEaIQDJFx9E/iC',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:21','2026-02-10 13:36:21',NULL,NULL,NULL,NULL),(16,'Assinante 5','subscriber5@example.com','2026-02-10 13:36:21','$2y$12$EgZJurCwEmvfyql.mloUtuKpZKqAQPUxTKcraPdj4G.1bdlmnQJNq',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:21','2026-02-10 13:36:21',NULL,NULL,NULL,NULL),(17,'Assinante 6','subscriber6@example.com','2026-02-10 13:36:21','$2y$12$942uR6O8XQVlVgLABag0v.HtCavtFES02PidibRP4vqtTVgWr4eAK',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:21','2026-02-10 13:36:21',NULL,NULL,NULL,NULL),(18,'Assinante 7','subscriber7@example.com','2026-02-10 13:36:21','$2y$12$Kpu1PM5NZ3vatvVXZraBvO/dSqg4Gp8RAPgFsMKfj1zBPNqZDd5MG',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:21','2026-02-10 13:36:21',NULL,NULL,NULL,NULL),(19,'Assinante 8','subscriber8@example.com','2026-02-10 13:36:22','$2y$12$lWW9Vfqzmh9.WOxXMivKeuxjvGQlwgmXcNl5wbUu2.tpmMPc0oQJC',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:22','2026-02-10 13:36:22',NULL,NULL,NULL,NULL),(20,'Assinante 9','subscriber9@example.com','2026-02-10 13:36:22','$2y$12$uVdmpH4D0L42fdgUmSD/pO6V0t0o1t8TfqXo3jNmjMbgDO2Tz2/J6',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:22','2026-02-10 13:36:22',NULL,NULL,NULL,NULL),(21,'Assinante 10','subscriber10@example.com','2026-02-10 13:36:22','$2y$12$yDEREawep1s6co4syxXneOe2KgizcziC22UthkicFlSGR9cNhZ/gy',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 13:36:22','2026-02-10 13:36:22',NULL,NULL,NULL,NULL),(22,'Kenny  roger','webkennyroger@gmail.com',NULL,'$2y$12$sQCgUCSHdKOBVAUiecBTWesV1Ia/WH015yFjAFbyXERMBPJQsjAqS',NULL,NULL,NULL,NULL,NULL,NULL,'2026-02-10 15:29:40','2026-02-10 15:29:40',NULL,NULL,NULL,NULL);
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

-- Dump completed on 2026-02-27 15:22:32
