-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: compteeurope
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `affiliations`
--

DROP TABLE IF EXISTS `affiliations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `affiliations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `parrain_id` bigint(20) unsigned DEFAULT NULL,
  `code_affiliation` varchar(255) NOT NULL,
  `commission_rate` decimal(5,2) NOT NULL DEFAULT 5.00,
  `total_commissions` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_parraines` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `affiliations_code_affiliation_unique` (`code_affiliation`),
  KEY `affiliations_user_id_foreign` (`user_id`),
  KEY `affiliations_parrain_id_foreign` (`parrain_id`),
  CONSTRAINT `affiliations_parrain_id_foreign` FOREIGN KEY (`parrain_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `affiliations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `affiliations`
--

LOCK TABLES `affiliations` WRITE;
/*!40000 ALTER TABLE `affiliations` DISABLE KEYS */;
INSERT INTO `affiliations` VALUES (45,60,NULL,'AFFF0AC1C2B',5.00,25275.00,7,1,NULL,'2025-11-08 07:34:35','2025-11-28 22:05:21'),(51,70,NULL,'AFFCB31C833',5.00,0.00,0,1,NULL,'2025-11-14 16:03:58','2025-11-14 16:03:58'),(52,71,NULL,'AFFA571D7B6',5.00,0.00,0,1,NULL,'2025-11-18 16:44:53','2025-11-18 16:44:53'),(53,72,NULL,'AFFCEE45FDF',5.00,0.00,0,1,NULL,'2025-11-18 21:46:39','2025-11-18 21:46:39'),(54,73,NULL,'AFF38747F13',5.00,0.00,0,1,NULL,'2025-11-19 07:20:41','2025-11-19 07:20:41'),(55,74,60,'AFFA8B9B7B5',5.00,0.00,0,1,NULL,'2025-11-19 12:22:08','2025-11-19 12:22:08'),(56,75,NULL,'AFF0A1C9027',5.00,0.00,0,1,NULL,'2025-11-19 15:16:38','2025-11-19 15:16:38'),(57,76,NULL,'AFF62415FDA',5.00,0.00,0,1,NULL,'2025-11-19 15:59:42','2025-11-19 15:59:42'),(58,77,NULL,'AFFD8D6D5F9',5.00,0.00,0,1,NULL,'2025-11-20 08:05:16','2025-11-20 08:05:16'),(59,78,NULL,'AFFBF26751D',5.00,0.00,0,1,NULL,'2025-11-20 08:25:44','2025-11-20 08:25:44'),(60,79,NULL,'AFFCCC03BBD',5.00,0.00,0,1,NULL,'2025-11-20 09:23:52','2025-11-20 09:23:52'),(61,80,NULL,'AFF18F6ACFE',5.00,0.00,0,1,NULL,'2025-11-20 12:16:29','2025-11-20 12:16:29'),(62,81,NULL,'AFFF2EB8D2F',5.00,0.00,0,1,NULL,'2025-11-20 13:19:32','2025-11-20 13:19:32'),(63,82,60,'AFF64D1871C',5.00,0.00,0,1,NULL,'2025-11-20 17:53:35','2025-11-20 17:53:35'),(64,83,NULL,'AFFE6FB3E9F',5.00,20200.00,2,1,NULL,'2025-11-20 23:40:44','2025-11-26 20:32:18'),(65,84,83,'AFFEBB8BB3F',5.00,0.00,0,1,NULL,'2025-11-21 00:57:06','2025-11-21 00:57:06'),(66,85,NULL,'AFF252832FA',5.00,0.00,0,1,NULL,'2025-11-21 07:18:21','2025-11-21 07:18:21'),(68,87,60,'AFF6255D88D',5.00,0.00,0,1,NULL,'2025-11-25 12:08:44','2025-11-25 12:08:44'),(69,88,83,'AFFDDE691FB',5.00,0.00,0,1,NULL,'2025-11-26 20:32:18','2025-11-26 20:32:18'),(70,89,NULL,'AFFBDDFB04D',5.00,0.00,0,1,NULL,'2025-11-28 21:44:58','2025-11-28 21:44:58'),(71,90,60,'AFF6596C04C',5.00,0.00,0,1,NULL,'2025-11-28 22:05:21','2025-11-28 22:05:21');
/*!40000 ALTER TABLE `affiliations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
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
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cars` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `showroom_user_id` bigint(20) unsigned DEFAULT NULL,
  `make` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `carrosserie` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `date_mise_en_circulation` date DEFAULT NULL,
  `kilometrage` int(11) DEFAULT NULL,
  `carburant` varchar(255) DEFAULT NULL,
  `boite_vitesse` varchar(255) DEFAULT NULL,
  `cylindree` int(11) DEFAULT NULL,
  `puissance_fiscale` int(11) DEFAULT NULL,
  `puissance_reelle` int(11) DEFAULT NULL,
  `emissions_co2` int(11) DEFAULT NULL,
  `crit_air` varchar(255) DEFAULT NULL,
  `etat` varchar(255) DEFAULT NULL,
  `garantie_mois` int(11) DEFAULT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `statut` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `archived` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cars_showroom_user_id_index` (`showroom_user_id`),
  CONSTRAINT `cars_showroom_user_id_foreign` FOREIGN KEY (`showroom_user_id`) REFERENCES `users_2` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars`
--

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
INSERT INTO `cars` VALUES (6,1,'TOYOTA','AVALON',NULL,2002,NULL,1567,NULL,'manuelle',1598,6,110,120,NULL,'excellent',6,NULL,'disponible',1250.00,NULL,1,1,'2025-12-06 18:52:32','2025-12-06 19:49:19'),(7,1,'TestBrand','ModelX','berline',2020,NULL,10000,'essence','automatique',NULL,NULL,NULL,NULL,NULL,'excellent',NULL,'[\"climatisation\"]','disponible',12345.00,'Vehicule de test pour validation webhook',1,0,'2025-12-06 19:04:22','2025-12-08 12:14:31'),(8,1,'TOYOTA','AVALON',NULL,2002,NULL,1567,NULL,'manuelle',1598,6,110,120,NULL,'excellent',6,NULL,'disponible',1250.00,NULL,1,0,'2025-12-06 19:53:12','2025-12-06 19:53:31'),(9,1,'TOYOTA','AVALON',NULL,2002,NULL,1567,NULL,'manuelle',1598,6,110,120,NULL,'excellent',6,NULL,'disponible',1250.00,NULL,1,0,'2025-12-06 19:57:09','2025-12-08 14:06:14');
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commissions`
--

DROP TABLE IF EXISTS `commissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `affiliation_id` bigint(20) unsigned NOT NULL,
  `parraine_user_id` bigint(20) unsigned NOT NULL,
  `compte_id` bigint(20) unsigned DEFAULT NULL,
  `action_type` varchar(255) NOT NULL,
  `montant_base` decimal(10,2) NOT NULL DEFAULT 0.00,
  `taux_commission` decimal(5,2) NOT NULL,
  `montant_commission` decimal(10,2) NOT NULL,
  `statut` enum('en_attente','valide','paye','annule','en_cours_de_retrait','retiree') DEFAULT 'en_attente',
  `date_action` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_validation` timestamp NULL DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commissions_affiliation_id_foreign` (`affiliation_id`),
  KEY `commissions_parraine_user_id_foreign` (`parraine_user_id`),
  KEY `commissions_compte_id_foreign` (`compte_id`),
  CONSTRAINT `commissions_affiliation_id_foreign` FOREIGN KEY (`affiliation_id`) REFERENCES `affiliations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `commissions_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `commissions_parraine_user_id_foreign` FOREIGN KEY (`parraine_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commissions`
--

LOCK TABLES `commissions` WRITE;
/*!40000 ALTER TABLE `commissions` DISABLE KEYS */;
INSERT INTO `commissions` VALUES (23,64,84,122,'recharge',10000.00,5.00,500.00,'valide','2025-11-22 12:42:44','2025-11-22 12:42:44','{\"transaction_id\":\"RC8WG91HKV1763686818\",\"payment_method\":\"mobile_money\",\"credits_earned\":15000,\"auto_processed\":true}','2025-11-22 12:42:44','2025-11-22 12:42:44'),(24,64,84,133,'creation_compte',44000.00,5.00,2200.00,'en_attente','2025-11-24 22:32:55',NULL,'{\"description\":\"Commission pour la cr\\u00e9ation du compte Professionnel par Adeline Maria\"}','2025-11-24 22:32:55','2025-11-24 22:32:55'),(25,64,84,135,'creation_compte',350000.00,5.00,17500.00,'en_attente','2025-11-25 12:37:26',NULL,'{\"description\":\"Commission pour la cr\\u00e9ation du compte Professionnel par Adeline Maria\"}','2025-11-25 12:37:26','2025-11-25 12:37:26'),(26,45,87,134,'recharge',5000.00,5.00,250.00,'valide','2025-11-28 12:11:39','2025-11-28 12:11:39','{\"transaction_id\":\"RC2L7WX9DB1764331821\",\"payment_method\":\"mobile_money\",\"credits_earned\":5000,\"auto_processed\":true}','2025-11-28 12:11:39','2025-11-28 12:11:39'),(27,45,87,137,'creation_compte',500000.00,5.00,25000.00,'en_attente','2025-11-28 12:16:19',NULL,'{\"description\":\"Commission pour la cr\\u00e9ation du compte Professionnel par Lejeune christophe\"}','2025-11-28 12:16:19','2025-11-28 12:16:19');
/*!40000 ALTER TABLE `commissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comptes`
--

DROP TABLE IF EXISTS `comptes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comptes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `region` varchar(20) NOT NULL DEFAULT 'europe',
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `devise` varchar(255) NOT NULL,
  `lang` varchar(255) NOT NULL,
  `account_balance` decimal(15,2) NOT NULL,
  `account_balance2` decimal(15,2) NOT NULL,
  `credits_available` decimal(15,2) NOT NULL DEFAULT 0.00,
  `account_type` varchar(255) NOT NULL,
  `code_virement` varchar(255) NOT NULL,
  `code_virement_utilise` tinyint(1) NOT NULL DEFAULT 0,
  `account_status` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `transfer_supported` varchar(255) NOT NULL,
  `token` varchar(60) DEFAULT NULL,
  `public_token` varchar(64) DEFAULT NULL,
  `iban` varchar(255) DEFAULT NULL,
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parameters`)),
  `card_number` varchar(255) NOT NULL,
  `cvv` varchar(255) NOT NULL,
  `numerocompte` varchar(255) NOT NULL,
  `start_percentage` varchar(255) NOT NULL,
  `end_percentage` varchar(255) NOT NULL,
  `failure_message` text DEFAULT NULL,
  `success_message` text DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `alert_email` tinyint(1) NOT NULL DEFAULT 1,
  `alert_sms` tinyint(1) NOT NULL DEFAULT 0,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `auto_deletes_at` timestamp NULL DEFAULT NULL,
  `is_auto_created` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `comptes_numerocompte_unique` (`numerocompte`),
  UNIQUE KEY `comptes_public_token_unique` (`public_token`),
  KEY `comptes_user_id_foreign` (`user_id`),
  KEY `comptes_auto_deletes_at_index` (`auto_deletes_at`),
  KEY `comptes_is_auto_created_index` (`is_auto_created`),
  KEY `comptes_region_index` (`region`),
  CONSTRAINT `comptes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=176 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comptes`
--

LOCK TABLES `comptes` WRITE;
/*!40000 ALTER TABLE `comptes` DISABLE KEYS */;
INSERT INTO `comptes` VALUES (106,70,'europe','Franck','Durand','durandfranck249@gmail.com','+2250564325906','Bénin-City','Cotonou-Bénin','€','fr',25000.00,25000.00,0.00,'Standard','913916',0,'Activé','330754','Virement bancaire',NULL,NULL,NULL,NULL,'4378********7655','477','FC-CUSYWEXFUE','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'comptes-photos/compte_69175377dd963.jpg',1,0,0,'2025-11-14 16:03:58','2025-12-04 07:55:17',NULL,1),(108,71,'europe','nguyen thi','kim dung','bellsonnesonia@gmail.com','+2550153244976','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','870649',0,'Activé','538564','Virement bancaire',NULL,NULL,NULL,NULL,'4632********4666','946','FC-R95MAPXE4N','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=kim+dung+nguyen+thi&background=28a745&color=fff&size=50',1,0,0,'2025-11-18 16:44:53','2025-12-04 07:55:17',NULL,1),(109,72,'europe','Fostinos','Charmakh','fostinoscharmakh@gmail.com','+2290191702794','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','128931',0,'Activé','718469','Virement bancaire',NULL,NULL,NULL,NULL,'4671********5673','953','FC-MOUMRHBCKY','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Charmakh+Fostinos&background=28a745&color=fff&size=50',1,0,0,'2025-11-18 21:46:39','2025-12-04 07:55:17',NULL,1),(110,73,'europe','Christophe','LEJEUNE','amadjicarmel11@gmail.com','+22953221824','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','535762',0,'Activé','456645','Virement bancaire',NULL,NULL,NULL,NULL,'4952********9536','346','FC-5GNUXRNN1L','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=LEJEUNE+Christophe&background=28a745&color=fff&size=50',1,0,0,'2025-11-19 07:20:41','2025-12-04 07:55:17',NULL,1),(111,74,'europe','Tz la','Hauteur','tzlahauteur91@gmail.com','+22957524467','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','893134',0,'Activé','895207','Virement bancaire',NULL,NULL,NULL,NULL,'4492********8476','203','FC-IHDA8HDYZU','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Hauteur+Tz+la&background=28a745&color=fff&size=50',1,0,0,'2025-11-19 12:22:08','2025-12-04 07:55:17',NULL,1),(112,75,'europe','Hugo','PITMAN','assicurazioneprestitionline@gmail.com','+31647975034','Bénin-City','Cotonou-Bénin','€','fr',0.00,10000.00,0.00,'Standard','511038',0,'Activé','107630','Virement bancaire',NULL,NULL,NULL,NULL,'4811********2440','469','FC-4BRUYYIXTF','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=PITMAN+Hugo&background=28a745&color=fff&size=50',1,0,0,'2025-11-19 15:16:38','2025-12-04 07:55:17',NULL,1),(113,76,'europe','Boga','St Paul','saraovidente@gmail.com','2290168460884','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','704478',0,'Activé','988875','Virement bancaire',NULL,NULL,NULL,NULL,'4973********7593','808','FC-EUK50IW8MU','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=St+Paul+Boga&background=28a745&color=fff&size=50',1,0,0,'2025-11-19 15:59:42','2025-12-04 07:55:17',NULL,1),(114,77,'europe','Savi','Audrey','jikelmike@gmail.com','+2290191640768','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','188049',0,'Activé','931344','Virement bancaire',NULL,NULL,NULL,NULL,'4308********7193','717','FC-CKAZLKVN85','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Audrey+Savi&background=28a745&color=fff&size=50',1,0,0,'2025-11-20 08:05:16','2025-12-04 07:55:17',NULL,1),(115,78,'europe','Sowanou','Sylvain','sowanousyl@gmail.com','+2290166842969','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','439389',0,'Activé','771457','Virement bancaire',NULL,NULL,NULL,NULL,'4967********4933','161','FC-U89IFMYKSN','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Sylvain+Sowanou&background=28a745&color=fff&size=50',1,0,0,'2025-11-20 08:25:44','2025-12-04 07:55:17',NULL,1),(116,70,'europe','Sandrina Carlo','Rosa','sandrinacarlo98@gmail.com','+33 7 45 33 89 75','France (+33)','France rue marrion45','€','fr',700000.00,700000.00,0.00,'Professionnel','406942',0,'Examen','716429','AXA banque',NULL,NULL,NULL,NULL,'4741********2167','129','FC-AFHPDTGYAW','1','100','Vous venez de recevoir un virement bancaire de 700000 veillez consulter votre solde',NULL,'comptes-photos/compte_691edd00e7c7a.jpg',1,1,0,'2025-11-20 09:18:56','2025-11-20 09:18:56',NULL,0),(117,79,'europe','Joël','Joël','autogarantieversicherung@gmail.com','+22960067966','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','142736',0,'Activé','665950','Virement bancaire',NULL,NULL,NULL,NULL,'4386********8952','473','FC-ADZVFE1WN3','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Jo%C3%ABl+Jo%C3%ABl&background=28a745&color=fff&size=50',1,0,0,'2025-11-20 09:23:52','2025-12-04 07:55:17',NULL,1),(118,80,'europe','Antonio','Maniscalco','laboitedetabac@gmail.com','+2290147536584','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','415902',0,'Activé','394227','Virement bancaire',NULL,NULL,NULL,NULL,'4548********6890','105','FC-IRSZSXXORO','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Maniscalco+Antonio&background=28a745&color=fff&size=50',1,0,0,'2025-11-20 12:16:29','2025-12-04 07:55:17',NULL,1),(119,81,'europe','Alexis','Dautin','alexisedautin@gmail.com','+22962133940','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','769029',0,'Activé','442105','Virement bancaire',NULL,NULL,NULL,NULL,'4234********8206','514','FC-WGDPALCDIB','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Dautin+Alexis&background=28a745&color=fff&size=50',1,0,0,'2025-11-20 13:19:32','2025-12-04 07:55:17',NULL,1),(120,82,'europe','Soares Marque Da Silva','Fernando','fernandosoaresmarquedasilva@gmail.com','229016588114','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','539688',0,'Activé','688623','Virement bancaire',NULL,NULL,NULL,NULL,'4219********1553','118','FC-J9HZ3J8T6Z','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Fernando+Soares+Marque+Da+Silva&background=28a745&color=fff&size=50',1,0,0,'2025-11-20 17:53:35','2025-12-04 07:55:17',NULL,1),(121,83,'europe','Jean','Laurant','hospicehounwanou66@gmail.com','+2290159253951','Bénin-City','Cotonou-Bénin','€','fr',10500.00,10000.00,0.00,'Standard','697731',0,'Activé','421599','Virement bancaire',NULL,NULL,NULL,NULL,'4770********3178','258','FC-F7ANHHE2JB','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Laurant+Jean&background=28a745&color=fff&size=50',1,0,0,'2025-11-20 23:40:44','2025-12-04 07:55:17',NULL,1),(122,84,'europe','Maria','Adeline','Princessleonorofficial62@gmail.com','2290158553191','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','501697',0,'Activé','264505','Virement bancaire',NULL,NULL,NULL,NULL,'4911********1401','675','FC-TKVOHQT8E2','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Adeline+Maria&background=28a745&color=fff&size=50',1,0,0,'2025-11-21 00:57:06','2025-12-04 07:55:17',NULL,1),(123,85,'europe','Mino\'','Maria-rosa','mariarosapatriziam@gmail.com','+2290166864988','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','329128',0,'Activé','977250','Virement bancaire',NULL,NULL,NULL,NULL,'4608********4390','357','FC-3NN57CRIVO','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Maria-rosa+Mino%27&background=28a745&color=fff&size=50',1,0,0,'2025-11-21 07:18:21','2025-12-04 07:55:17',NULL,1),(130,83,'europe','Daniele','martorelli','Danimartore@gmail.com','3716667885','Italie (+39)','Italie','€','it',300000.00,300000.00,0.00,'Professionnel','162727',0,'Activé','591941','BBVA',NULL,NULL,NULL,NULL,'4633********1255','866','FC-8XWCAK1YNM','1','100','Vous avez reçu un\r\nVirement de 300000€',NULL,NULL,1,0,0,'2025-11-24 21:00:41','2025-11-24 21:00:41',NULL,0),(131,83,'europe','Françoise','Dubois','marchiottomatteo70@gmail.com','+33773827800','France (+33)','Bordeaux','€','fr',14000000.00,14000000.00,0.00,'Professionnel','215325',0,'Activé','109388','BBVA',NULL,NULL,NULL,NULL,'4999********2895','766','FC-TA2TITLF8W','1','100','Virement crédité',NULL,NULL,1,1,0,'2025-11-24 21:14:06','2025-11-24 21:14:06',NULL,0),(133,84,'europe','Flores Llanque','Wilfredo Fredy','fisiologow@gmail.com','+51912607770','Pérou (+51)','Perú puno','PEN','es',44000.00,44000.00,0.00,'Professionnel','699182',0,'Activé','469867','BBVA',NULL,NULL,NULL,NULL,'4179********9528','668','FC-YG7GOVFWFY','1','100','Nota: Para retirar los fondos, debe activar la transferencia de 44.000 soles, ya que es una transferencia internacional. Comisión de activación: 2.800 soles.\r\nTransferencia completada con éxito el 24 de noviembre de 2025',NULL,NULL,1,1,0,'2025-11-24 22:32:55','2025-11-24 22:32:55',NULL,0),(134,87,'europe','christophe','Lejeune','christophelejeune002@gmail.com','+22953221824','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','386163',0,'Activé','891930','Virement bancaire',NULL,NULL,NULL,NULL,'4451********4893','628','FC-OMDNDK1UK3','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Lejeune+christophe&background=28a745&color=fff&size=50',1,0,0,'2025-11-25 12:08:44','2025-12-04 07:55:17',NULL,1),(135,84,'europe','De la Croix','Michele','Micheledelacroix76@gmail.com','+33 7 89 21 38 97','France (+33)','France,40 résidence les belles etentes','€','fr',350000.00,350000.00,0.00,'Professionnel','154772',0,'Activé','799501','CIC Banque',NULL,NULL,NULL,NULL,'4699********4759','378','FC-TCQ6NT8LAX','1','100','Vous avez reçu 350 000 euros de la banque CIC sur votre compte n° Fr7630003007330005164149741 au nom de Michele de la Croix .\r\n\r\nFrais d\'activation pour créditer les fonds sur: 2800 euros.',NULL,NULL,1,1,0,'2025-11-25 12:37:26','2025-11-25 12:37:26',NULL,0),(136,88,'europe','Dupont','Alice','estevedossou508@gmail.com','+2290199609798','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','567409',0,'Activé','663481','Virement bancaire',NULL,NULL,NULL,NULL,'4912********7875','958','FC-MGVSCNQWPD','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Alice+Dupont&background=28a745&color=fff&size=50',1,0,0,'2025-11-26 20:32:18','2025-12-04 07:55:17',NULL,1),(137,87,'europe','Germelis','Vilberds','vilberds61@gmail.com','7784964577','Royaume-Uni (+44)','vilberds61@gmail.com','€','en',500000.00,500000.00,0.00,'Professionnel','389405',0,'Activé','363064','Bannvale Credit Union',NULL,NULL,NULL,NULL,'4239********2756','978','FC-FAOQVKB3IU','1','85','Please contact the bank manager to pay the activation fee which is 127 euros to obtain the activation codes for your transfer to be finalized',NULL,'comptes-photos/compte_69299293800f9.jpg',1,1,0,'2025-11-28 12:16:19','2025-11-28 12:16:19',NULL,0),(138,89,'europe','Thomas','Uriel','j7702471@gmail.com','2290191137547','Bénin-City','Cotonou-Bénin','€','fr',10100.00,10100.00,0.00,'Standard','144417',0,'Activé','427288','Virement bancaire',NULL,NULL,NULL,NULL,'4985********3469','755','FC-ITXZYKICAJ','1','100','Transfert réussi',NULL,'https://ui-avatars.com/api/?name=Uriel+Thomas&background=28a745&color=fff&size=50',1,0,0,'2025-11-28 21:44:58','2025-12-04 07:55:17',NULL,1),(139,90,'europe','Bonnafé','Jean Laurent','scotiabank143@gmail.com','+2290191635916','Bénin-City','Cotonou-Bénin','€','fr',10000.00,10000.00,0.00,'Standard','809460',0,'Activé','281749','Virement bancaire',NULL,NULL,NULL,NULL,'4844********6723','688','FC-6RLTQUQWTV','1','100','Transfert échoué. Veuillez contacter le support.',NULL,'https://ui-avatars.com/api/?name=Jean+Laurent+Bonnaf%C3%A9&background=28a745&color=fff&size=50',1,0,0,'2025-11-28 22:05:21','2025-12-04 07:55:17',NULL,1),(174,60,'afrique','CANDIDE','CANDIDE','lalyaisidore@gmail.com','+22500000000','Côte d\'Ivoire (+225)','Abidjan, Côte d\'Ivoire','XOF','fr',500000.00,500000.00,0.00,'Professionnel','111111',0,'Activé','000000','Oui',NULL,NULL,NULL,NULL,'4769********2693','635','test_1c4073','0','50','Votre virement a échoué en raison d\'une vérification de sécurité. Veuillez contacter le support pour finaliser l\'opération.','Votre virement a été effectué avec succès. Les fonds seront disponibles sous 24 à 48 heures.',NULL,1,0,0,'2026-03-29 11:16:27','2026-03-29 11:36:04',NULL,0);
/*!40000 ALTER TABLE `comptes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `credit_audits`
--

DROP TABLE IF EXISTS `credit_audits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `credit_audits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `compte_id` bigint(20) unsigned DEFAULT NULL,
  `action_type` varchar(255) NOT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `credits_before` bigint(20) unsigned DEFAULT NULL,
  `credits_after` bigint(20) unsigned DEFAULT NULL,
  `change` bigint(20) DEFAULT NULL,
  `reference_type` varchar(255) DEFAULT NULL,
  `reference_id` bigint(20) unsigned DEFAULT NULL,
  `description` text DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `credit_audits_user_id_index` (`user_id`),
  KEY `credit_audits_compte_id_index` (`compte_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credit_audits`
--

LOCK TABLES `credit_audits` WRITE;
/*!40000 ALTER TABLE `credit_audits` DISABLE KEYS */;
/*!40000 ALTER TABLE `credit_audits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dismissed_alerts`
--

DROP TABLE IF EXISTS `dismissed_alerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dismissed_alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `compte_id` int(11) NOT NULL,
  `alert_type` varchar(50) NOT NULL,
  `alert_id` varchar(128) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_user_alert_compte` (`compte_id`,`alert_type`,`alert_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dismissed_alerts`
--

LOCK TABLES `dismissed_alerts` WRITE;
/*!40000 ALTER TABLE `dismissed_alerts` DISABLE KEYS */;
INSERT INTO `dismissed_alerts` VALUES (1,175,'transaction','427','2026-03-29 18:47:13'),(2,175,'transaction','426','2026-03-29 18:47:13'),(3,175,'transaction','379','2026-03-29 18:47:13'),(4,175,'transaction','370','2026-03-29 18:47:13'),(5,175,'transaction','425','2026-03-29 18:57:04'),(6,175,'transaction','424','2026-03-29 18:57:04'),(7,175,'transaction','423','2026-03-29 18:57:04'),(8,175,'transaction','422','2026-03-29 18:57:04'),(9,175,'transaction','421','2026-03-29 18:57:04');
/*!40000 ALTER TABLE `dismissed_alerts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_extractor_history`
--

DROP TABLE IF EXISTS `email_extractor_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_extractor_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `separator` varchar(32) NOT NULL,
  `result_count` int(10) unsigned NOT NULL DEFAULT 0,
  `emails` text NOT NULL,
  `source_preview` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_extractor_history_user_id_foreign` (`user_id`),
  CONSTRAINT `email_extractor_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_extractor_history`
--

LOCK TABLES `email_extractor_history` WRITE;
/*!40000 ALTER TABLE `email_extractor_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_extractor_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
-- Table structure for table `iban_verifications`
--

DROP TABLE IF EXISTS `iban_verifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iban_verifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `type` varchar(10) NOT NULL,
  `number_masked` varchar(50) NOT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 0,
  `country` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bic_code` varchar(20) DEFAULT NULL,
  `card_brand` varchar(30) DEFAULT NULL,
  `card_type` varchar(30) DEFAULT NULL,
  `lookup_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`lookup_data`)),
  `credits_used` int(10) unsigned NOT NULL DEFAULT 0,
  `error_message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `iban_verifications_user_id_created_at_index` (`user_id`,`created_at`),
  CONSTRAINT `iban_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iban_verifications`
--

LOCK TABLES `iban_verifications` WRITE;
/*!40000 ALTER TABLE `iban_verifications` DISABLE KEYS */;
INSERT INTO `iban_verifications` VALUES (1,60,'iban','FR76*******************0189',1,'France',NULL,NULL,NULL,NULL,'{\"iban\":\"FR76*******************0189\",\"country_code\":\"FR\",\"bank_code\":\"30006\"}',500,NULL,'2026-03-25 00:53:00','2026-03-25 00:53:00'),(2,60,'iban','FR76*******************0180',0,'France',NULL,NULL,NULL,NULL,'{\"iban\":\"FR76*******************0180\",\"country_code\":\"FR\",\"bank_code\":\"30006\"}',500,NULL,'2026-03-25 00:53:40','2026-03-25 00:53:40');
/*!40000 ALTER TABLE `iban_verifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
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
-- Table structure for table `mail_history`
--

DROP TABLE IF EXISTS `mail_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `expediteur` varchar(255) NOT NULL,
  `destinataire` varchar(255) NOT NULL,
  `objet` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `adresse_reponse` varchar(255) DEFAULT NULL,
  `fichier_joint` varchar(255) DEFAULT NULL,
  `credits_used` int(11) NOT NULL DEFAULT 0,
  `status` enum('Envoyé','Livré','Rejeté','Ouvert') DEFAULT 'Envoyé',
  `opened_at` timestamp NULL DEFAULT NULL,
  `open_count` int(10) unsigned NOT NULL DEFAULT 0,
  `message_id` varchar(255) DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mail_history_user_id_foreign` (`user_id`),
  CONSTRAINT `mail_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mail_history`
--

LOCK TABLES `mail_history` WRITE;
/*!40000 ALTER TABLE `mail_history` DISABLE KEYS */;
INSERT INTO `mail_history` VALUES (1,60,'TRANSFERFLUx','lalyaisidore@gmail.com','Inscription','<p>C\'est partie</p>',NULL,'mail_attachments/7pFlvUchJG86mcbGRTuuU4m81zHBIuJ44obNmswO.pdf',2000,'Envoyé',NULL,0,'MAIL_59ec5998-ea5a-4d53-abce-b33364ead454',NULL,'2025-12-01 16:01:50','2025-12-01 16:01:50');
/*!40000 ALTER TABLE `mail_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_05_25_092626_create_comptes_table',1),(5,'2024_06_01_202859_create_virements_table',1),(6,'2024_06_01_210224_create_transfers_table',1),(7,'2024_06_01_210745_create_unlock_codes_table',1),(8,'2024_06_03_232415_create_remboursements_table',1),(9,'2024_06_06_222459_create_transaction_histories_table',1),(10,'2024_06_09_094629_create_sub_account_sessions_table',1),(11,'2025_11_01_000001_add_credit_user_to_users_table',2),(12,'2025_11_02_000000_add_is_default_to_comptes_table',3),(13,'2025_11_02_000001_add_alert_columns_to_comptes_table',4),(14,'2025_11_03_064607_create_affiliations_table',5),(15,'2025_11_03_064748_create_commissions_table',5),(16,'2025_11_03_065133_add_affiliation_to_users_table',5),(17,'2025_11_03_081823_create_recharge_transactions_table',6),(18,'2025_11_03_101510_create_retraits_table',7),(19,'2025_11_03_120000_add_credits_to_comptes_table',8),(20,'2025_11_03_000001_add_public_token_to_comptes_table',9),(21,'2025_11_04_000000_add_photo_path_to_comptes_table',10),(22,'2025_11_05_000000_add_compte_id_to_transaction_histories_table',11),(23,'2025_11_05_000002_add_numerocompte_to_comptes_table',12),(24,'2025_11_06_000000_create_recharge_histories_table',13),(25,'2025_11_06_000001_create_credit_audits_table',13),(26,'2025_11_06_000002_add_phone_to_users_table',14),(27,'2025_11_06_000003_add_compte_id_to_transaction_histories',15),(28,'2025_11_06_155445_update_transaction_histories_make_compte_id_required',16),(29,'2025_11_07_163330_add_auto_deletes_at_to_comptes_table',17),(30,'2025_11_07_180000_add_compte_id_to_transfers_table',18),(31,'2025_11_07_182000_add_compte_id_inferred_to_transfers_table',19),(32,'2025_11_09_100000_create_support_tables',20),(33,'2025_11_10_120000_add_attachments_to_support_messages',21),(34,'2025_11_10_171351_add_columns_to_unlock_codes_table',22),(35,'2025_11_10_171607_make_transfer_id_nullable_in_unlock_codes',23),(36,'2025_11_11_000001_update_retraits_table_add_new_operators',24),(37,'2025_11_11_001329_update_retraits_table_add_new_operators',24),(38,'2025_11_11_002000_add_withdrawal_statuses_to_commissions',25),(39,'2025_11_12_000000_add_code_virement_utilise_to_comptes_table',26),(40,'2025_11_26_000001_add_numerocompte_to_comptes_table',27),(41,'2025_11_26_000002_add_photo_path_to_comptes_table',27),(42,'2025_11_26_123000_add_transfer_id_to_transaction_histories_table',27),(43,'2025_11_27_000000_modify_failure_message_in_comptes',27),(44,'2025_12_01_102443_create_sms_history_table',27),(45,'2025_12_01_122032_update_sms_history_status_enum',28),(46,'2025_12_01_124136_add_envoye_status_to_sms_history',29),(47,'2025_12_01_131840_create_mail_history_table',30),(48,'2025_12_01_150000_add_open_tracking_to_mail_history',31),(49,'2025_12_01_160000_create_url_shortener_history_table',31),(50,'2025_12_01_160500_create_url_verifications_table',31),(51,'2025_12_01_170000_create_email_extractor_history_table',32),(52,'2025_12_05_000001_create_users_2_table',33),(53,'2025_12_05_000002_create_plans_table',33),(54,'2025_12_05_000003_create_subscriptions_table',33),(55,'2025_12_05_000004_create_cars_table',34),(56,'2025_12_05_000005_create_photos_table',34),(57,'2025_12_06_000001_add_fields_to_cars_table',35),(58,'2025_12_08_185500_add_config_vitrine_to_users_2_table',36),(59,'2026_03_25_000001_add_region_to_users_table',37),(60,'2026_03_25_000002_add_mobile_number_to_transaction_histories',37),(61,'2026_03_25_000003_add_region_to_comptes_table',37),(62,'2026_03_25_012425_create_phone_verifications_table',38),(63,'2026_03_25_014759_create_iban_verifications_table',39),(65,'2026_03_28_081014_add_success_message_to_comptes_table',40);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
INSERT INTO `password_reset_tokens` VALUES ('durandfranck249@gmail.com','$2y$12$RnlFSHQcGq2mFtlDJBeKKu2r3rT0VNVeUNbMsWjED0S8fjyi8Drau','2025-11-20 08:32:19'),('lalyaisidore@gmail.com','$2y$12$MTzJl9jEsJIwoC9XsgCb6uZAc/.ABCPQuOYN3E.RpNO45t26KFB3W','2025-11-13 12:15:54');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phone_verifications`
--

DROP TABLE IF EXISTS `phone_verifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phone_verifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `is_valid` tinyint(1) NOT NULL DEFAULT 0,
  `country_name` varchar(255) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL,
  `network_name` varchar(255) DEFAULT NULL,
  `network_type` varchar(20) DEFAULT NULL,
  `is_reachable` tinyint(1) NOT NULL DEFAULT 0,
  `lookup_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`lookup_data`)),
  `credits_used` int(10) unsigned NOT NULL DEFAULT 0,
  `error_message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `phone_verifications_user_id_created_at_index` (`user_id`,`created_at`),
  CONSTRAINT `phone_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phone_verifications`
--

LOCK TABLES `phone_verifications` WRITE;
/*!40000 ALTER TABLE `phone_verifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `phone_verifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `car_id` bigint(20) unsigned NOT NULL,
  `path` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `photos_car_id_index` (`car_id`),
  CONSTRAINT `photos_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photos`
--

LOCK TABLES `photos` WRITE;
/*!40000 ALTER TABLE `photos` DISABLE KEYS */;
INSERT INTO `photos` VALUES (8,6,'vehicles/medium/car_6934898117d75.webp',0,'2025-12-06 18:52:38','2025-12-06 18:52:38'),(11,9,'vehicles/medium/car_693498a5be00a.webp',0,'2025-12-06 19:57:09','2025-12-06 19:57:09'),(12,9,'vehicles/medium/car_6936d3a2d84e6.webp',0,'2025-12-08 12:33:24','2025-12-08 12:33:24'),(13,8,'vehicles/medium/car_6937390b401af.jpg',0,'2025-12-08 19:46:05','2025-12-08 19:46:05'),(14,8,'vehicles/medium/car_6937390e09df3.jpg',0,'2025-12-08 19:46:06','2025-12-08 19:46:06'),(15,8,'vehicles/medium/car_6937390e6919c.jpg',0,'2025-12-08 19:46:06','2025-12-08 19:46:06'),(16,7,'vehicles/medium/car_6937397776bef.jpg',0,'2025-12-08 19:47:51','2025-12-08 19:47:51'),(17,7,'vehicles/medium/car_6937397796be0.jpg',0,'2025-12-08 19:47:51','2025-12-08 19:47:51'),(18,7,'vehicles/medium/car_69373977ca65f.jpg',0,'2025-12-08 19:47:51','2025-12-08 19:47:51'),(19,7,'vehicles/medium/car_69373977d509d.jpg',0,'2025-12-08 19:47:51','2025-12-08 19:47:51');
/*!40000 ALTER TABLE `photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `interval_months` int(11) NOT NULL DEFAULT 1,
  `price_cents` bigint(20) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `plans_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (1,'free','Gratuit',1,0,'Présence minimale sur la vitrine publique, idéal pour débuter','2025-12-09 15:36:26','2025-12-09 15:36:26'),(2,'pro','Pro',1,9900,'Visibilité renforcée et options avancées pour professionnels','2025-12-09 15:36:26','2025-12-09 15:36:26'),(3,'premium','Premium',12,99900,'Offre annuelle avec support prioritaire et fonctionnalités premium','2025-12-09 15:36:26','2025-12-09 15:36:26');
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recharge_histories`
--

DROP TABLE IF EXISTS `recharge_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recharge_histories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `compte_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `devise` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recharge_histories_user_id_foreign` (`user_id`),
  KEY `recharge_histories_compte_id_foreign` (`compte_id`),
  CONSTRAINT `recharge_histories_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recharge_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recharge_histories`
--

LOCK TABLES `recharge_histories` WRITE;
/*!40000 ALTER TABLE `recharge_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `recharge_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recharge_transactions`
--

DROP TABLE IF EXISTS `recharge_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recharge_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `compte_id` bigint(20) unsigned DEFAULT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `credits_earned` int(11) NOT NULL DEFAULT 0,
  `payment_method` enum('fedapay','oosic','card','mobile_money','bank_transfer') NOT NULL,
  `payment_provider` varchar(255) DEFAULT NULL,
  `status` enum('pending','processing','completed','failed','cancelled') NOT NULL DEFAULT 'pending',
  `external_transaction_id` varchar(255) DEFAULT NULL,
  `payment_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_details`)),
  `response_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response_data`)),
  `failure_reason` varchar(255) DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `recharge_transactions_transaction_id_unique` (`transaction_id`),
  KEY `recharge_transactions_compte_id_foreign` (`compte_id`),
  KEY `recharge_transactions_user_id_status_index` (`user_id`,`status`),
  KEY `recharge_transactions_status_created_at_index` (`status`,`created_at`),
  CONSTRAINT `recharge_transactions_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `recharge_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recharge_transactions`
--

LOCK TABLES `recharge_transactions` WRITE;
/*!40000 ALTER TABLE `recharge_transactions` DISABLE KEYS */;
INSERT INTO `recharge_transactions` VALUES (55,84,122,'RC8WG91HKV1763686818',10000.00,15000,'mobile_money','fedapay','completed','107602391',NULL,'{\"fedapay_id\":107602391,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzYwMjM5MSwiZXhwIjoxNzYzNzczMjIxfQ.um2rGR0ZOgfDI7faMPPjR4C7NvM__JY_lMJvJtcMoe8\"}',NULL,'2025-11-22 12:42:44','2025-11-21 01:00:18','2025-11-22 12:42:44'),(56,85,123,'RC8L4N7RCJ1763719169',5000.00,5000,'fedapay','fedapay','pending','107606521',NULL,'{\"fedapay_id\":107606521,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzYwNjUyMSwiZXhwIjoxNzYzODA1NTcyfQ.D-L-aPwoGtyhbnXRqpwOp188FEpP8SRNJZ7Gp0ysyuA\"}',NULL,NULL,'2025-11-21 09:59:29','2025-11-21 09:59:31'),(57,85,123,'RCF2J4ORVD1763719192',5000.00,5000,'mobile_money','fedapay','pending','107606529',NULL,'{\"fedapay_id\":107606529,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzYwNjUyOSwiZXhwIjoxNzYzODA1NTk2fQ.uplqEY3i3YAhLM2XckgSoFuU7jks4pm66V9iRpHSOAE\"}',NULL,NULL,'2025-11-21 09:59:52','2025-11-21 09:59:54'),(92,88,136,'RCRDZLVTVX1764190125',5000.00,5000,'mobile_money','fedapay','pending','107701725',NULL,'{\"fedapay_id\":107701725,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzcwMTcyNSwiZXhwIjoxNzY0Mjc2NTI5fQ.huIeaxnMUilo-ceLX8wpxYRv9VLEQNwVd3YT-j14ch0\"}',NULL,NULL,'2025-11-26 20:48:45','2025-11-26 20:48:46'),(93,88,136,'RCX2SXGGI91764190258',5000.00,5000,'fedapay','fedapay','pending','107701764',NULL,'{\"fedapay_id\":107701764,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzcwMTc2NCwiZXhwIjoxNzY0Mjc2NjYyfQ.0mjouMCFMYyF6ZqSGLvoM2Y5nDbGqFQFibEucZnQlHk\"}',NULL,NULL,'2025-11-26 20:50:58','2025-11-26 20:50:59'),(95,83,121,'RCRZXZ2V331764190337',10000.00,15000,'mobile_money','fedapay','pending','107701794',NULL,'{\"fedapay_id\":107701794,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzcwMTc5NCwiZXhwIjoxNzY0Mjc2NzQwfQ.gZ5jqODMFxVpcrFt36PaPwFp-oIyIGc0xlpEEb-z1gM\"}',NULL,NULL,'2025-11-26 20:52:17','2025-11-26 20:52:18'),(98,87,134,'RC2L7WX9DB1764331821',5000.00,5000,'mobile_money','fedapay','completed','107730844',NULL,'{\"fedapay_id\":107730844,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzczMDg0NCwiZXhwIjoxNzY0NDE4MjI1fQ.Wzc7zlEaKPXITFkn6es9PoM29TtDtgXeGPEaVpa7wY8\"}',NULL,'2025-11-28 12:11:39','2025-11-28 12:10:21','2025-11-28 12:11:39'),(100,89,138,'RCRYM2TZXN1764367098',5000.00,5000,'fedapay','fedapay','failed','107740853',NULL,'{\"fedapay_id\":107740853,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzc0MDg1MywiZXhwIjoxNzY0NDUzNTAyfQ.MSTZ0rOJRoEjj48JMliQKOiIzrg3zanpisfMQQ39KwQ\"}','Payment canceled/declined by user (redirect)',NULL,'2025-11-28 21:58:18','2025-11-28 21:58:37'),(104,60,NULL,'RCPSAAVMSI1764661485',10000.00,15000,'fedapay','fedapay','failed','107795835',NULL,'{\"fedapay_id\":107795835,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzc5NTgzNSwiZXhwIjoxNzY0NzQ3ODk0fQ.nS6qu2N3ZlIJbosmP9ZmOgDFa6WWq26j8_eKb2jEhd0\"}','Payment canceled/declined by user (redirect)',NULL,'2025-12-02 06:44:45','2025-12-02 06:44:57'),(105,60,NULL,'RCOGYHOM6S1764710519',25000.00,40000,'fedapay','fedapay','failed','107812289',NULL,'{\"fedapay_id\":107812289,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzgxMjI4OSwiZXhwIjoxNzY0Nzk2OTIzfQ.AY1PZRSBOLutRwyEX9jJoXTRI1CWbkQqCUqAsP0R18A\"}','Payment canceled/declined by user (redirect)',NULL,'2025-12-02 20:21:59','2025-12-02 20:22:08');
/*!40000 ALTER TABLE `recharge_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `remboursements`
--

DROP TABLE IF EXISTS `remboursements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `remboursements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `compte_id` bigint(20) unsigned NOT NULL,
  `montant` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `remboursements_compte_id_foreign` (`compte_id`),
  CONSTRAINT `remboursements_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `remboursements`
--

LOCK TABLES `remboursements` WRITE;
/*!40000 ALTER TABLE `remboursements` DISABLE KEYS */;
INSERT INTO `remboursements` VALUES (62,123,10000.00,'2025-11-21 09:51:57','2025-11-21 09:51:57'),(68,138,10000.00,'2025-11-28 21:51:38','2025-11-28 21:51:38');
/*!40000 ALTER TABLE `remboursements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `retraits`
--

DROP TABLE IF EXISTS `retraits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `retraits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `affiliation_id` bigint(20) unsigned NOT NULL,
  `montant` decimal(15,2) NOT NULL,
  `operateur` enum('mtn_benin','moov_benin','orange_burkina','mtn_ci','moov_ci','orange_ci','wave_ci','orange_mali','tmoney_togo','moov_togo','orange_senegal','free_senegal','emoney_senegal','wave_senegal') NOT NULL,
  `numero_telephone` varchar(20) NOT NULL,
  `statut` enum('en_attente','en_cours','traite','annule') NOT NULL DEFAULT 'en_attente',
  `date_demande` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_traitement` timestamp NULL DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `retraits_user_id_statut_index` (`user_id`,`statut`),
  KEY `retraits_affiliation_id_date_demande_index` (`affiliation_id`,`date_demande`),
  CONSTRAINT `retraits_affiliation_id_foreign` FOREIGN KEY (`affiliation_id`) REFERENCES `affiliations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `retraits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `retraits`
--

LOCK TABLES `retraits` WRITE;
/*!40000 ALTER TABLE `retraits` DISABLE KEYS */;
INSERT INTO `retraits` VALUES (1,60,45,9000.00,'moov_benin','+2290198201610','traite','2025-11-11 00:53:10','2025-11-10 23:53:10',NULL,'{\"commissions_traitees\":[11,12,13,14],\"traite_le\":\"2025-11-11 00:53:10\"}','2025-11-10 23:30:10','2025-11-10 23:53:10'),(2,60,45,9000.00,'moov_benin','+2290198201610','traite','2025-11-11 00:53:16','2025-11-10 23:53:16',NULL,'{\"commissions_traitees\":[],\"montant_non_rapproche\":9000,\"traite_le\":\"2025-11-11 00:53:16\"}','2025-11-10 23:45:20','2025-11-10 23:53:16'),(3,60,45,9000.00,'moov_benin','+2290198201610','traite','2025-11-11 00:53:21','2025-11-10 23:53:21',NULL,'{\"commissions_traitees\":[],\"montant_non_rapproche\":9000,\"traite_le\":\"2025-11-11 00:53:21\"}','2025-11-10 23:52:41','2025-11-10 23:53:21');
/*!40000 ALTER TABLE `retraits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
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
INSERT INTO `sessions` VALUES ('JC7BTNJxc0uPHdm2sGgFdvDz38sMvEvwzaOXOA9D',3,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR2ZBS1N6TjFNRlJ0bnY1cEluSXJKdGdKUWtMQ2IzZUhHRDQyTE55cyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZmZpbGlhdGlvbiI7czo1OiJyb3V0ZSI7czoxNzoiYWZmaWxpYXRpb24uaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=',1762154994),('RlPCQwYAEKNVUufZII5HHcOMYkC8yBZuNLdmaofa',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.105.1 Chrome/138.0.7204.251 Electron/37.6.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoibndzejRuWkk0MG00eW41aHBLcklFZjlYM2lWYVdQY0M4Y1ZJYTB5WSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jb25uZXhpb24iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1762154890),('Shr9rr2f8LDq1f7AF3JmCUVfjMKwdQ6wmeeZlncn',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.105.1 Chrome/138.0.7204.251 Electron/37.6.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTZCenluRHV2UEo1Y1h6bk9pY0RJalc5b21INzYxNG9PSnhSdHpkbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC8/aWQ9Y2YxMDJiZmYtY2JmZi00MjYxLWJhOWYtNDkwMDcyZjJkZGFiJnZzY29kZUJyb3dzZXJSZXFJZD0xNzYyMTU0MDAxNTk1IjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1762154010),('sNxsy2WlYHae48djMJqYCdL4xPA8PBTfdHMskGEL',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.105.1 Chrome/138.0.7204.251 Electron/37.6.0 Safari/537.36','YToyOntzOjY6Il90b2tlbiI7czo0MDoiUVFuQTF6a0tmdzg1SGt5UHNReXp1ZTNOT2MxeW9RYmNVc25xTHJLaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1762154937),('TLHzLk9rhAT7w1TeoRlFONHiWbjRHUNMdZqISCBU',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.105.1 Chrome/138.0.7204.251 Electron/37.6.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN2JVRW0xc2xhQlpkQk5HaGg2Y0Y0eXJiT3pjeHhTTmFnelN1NFhPUyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZmZpbGlhdGlvbj9pZD1jZjEwMmJmZi1jYmZmLTQyNjEtYmE5Zi00OTAwNzJmMmRkYWImdnNjb2RlQnJvd3NlclJlcUlkPTE3NjIxNTQ4ODk1MTAiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoxMDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZmZpbGlhdGlvbj9pZD1jZjEwMmJmZi1jYmZmLTQyNjEtYmE5Zi00OTAwNzJmMmRkYWImdnNjb2RlQnJvd3NlclJlcUlkPTE3NjIxNTQ4ODk1MTAiO3M6NToicm91dGUiO3M6MTc6ImFmZmlsaWF0aW9uLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1762154889);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_history`
--

DROP TABLE IF EXISTS `sms_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `expediteur` varchar(11) NOT NULL,
  `pays` varchar(10) NOT NULL,
  `destinataire` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `sms_count` int(11) NOT NULL DEFAULT 1,
  `credits_used` int(11) NOT NULL DEFAULT 1,
  `status` enum('Envoyé','Livré','Rejeté') DEFAULT 'Envoyé',
  `message_id` varchar(255) DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sms_history_user_id_foreign` (`user_id`),
  CONSTRAINT `sms_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_history`
--

LOCK TABLES `sms_history` WRITE;
/*!40000 ALTER TABLE `sms_history` DISABLE KEYS */;
INSERT INTO `sms_history` VALUES (6,60,'TRANSFERFLU','+229','+2290198201610','Service de messagerie SMS Professionnel mondiale. Que vous soyez un particulier, une start-up ou une entreprise, communiquez facilement avec vos clients en envoyant des SMS Pro dans le monde entier grâce à notre plateforme ayant plus de 240 connexions directes avec les opérateurs à l\'international. Optimisé pour la vitesse, la qualité et les coûts, envoyez des alertes bancaires, des confirmations de commande, des SMS cross selling, marketing, de rappel, de relance client inactif, de fidélisation ou promotionnel, etc... avec le nom d\'expéditeur de votre choix.',1,0,'Rejeté','SMS_692d8bbbf2aa3','Échec de l\'envoi du SMS','2025-12-01 11:36:12','2025-12-01 11:36:12');
/*!40000 ALTER TABLE `sms_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_account_sessions`
--

DROP TABLE IF EXISTS `sub_account_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_account_sessions` (
  `id` varchar(255) NOT NULL,
  `compte_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_account_sessions_compte_id_index` (`compte_id`),
  KEY `sub_account_sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_account_sessions`
--

LOCK TABLES `sub_account_sessions` WRITE;
/*!40000 ALTER TABLE `sub_account_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sub_account_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `showroom_user_id` bigint(20) unsigned NOT NULL,
  `plan_id` bigint(20) unsigned DEFAULT NULL,
  `external_id` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'inactive',
  `current_period_end` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscriptions_showroom_user_id_index` (`showroom_user_id`),
  KEY `subscriptions_plan_id_index` (`plan_id`),
  CONSTRAINT `subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE SET NULL,
  CONSTRAINT `subscriptions_showroom_user_id_foreign` FOREIGN KEY (`showroom_user_id`) REFERENCES `users_2` (`id`) ON DELETE CASCADE
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
-- Table structure for table `support_messages`
--

DROP TABLE IF EXISTS `support_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `support_ticket_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `sent_by_admin` tinyint(1) NOT NULL DEFAULT 0,
  `content` text NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(120) DEFAULT NULL,
  `file_size` int(10) unsigned DEFAULT NULL,
  `voice_path` varchar(255) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `support_messages_user_id_foreign` (`user_id`),
  KEY `support_messages_support_ticket_id_created_at_index` (`support_ticket_id`,`created_at`),
  CONSTRAINT `support_messages_support_ticket_id_foreign` FOREIGN KEY (`support_ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `support_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_messages`
--

LOCK TABLES `support_messages` WRITE;
/*!40000 ALTER TABLE `support_messages` DISABLE KEYS */;
INSERT INTO `support_messages` VALUES (1,1,60,0,'Je ne sais pas comment recharger mon compte',NULL,NULL,NULL,NULL,NULL,'2025-11-10 10:48:06','2025-11-09 17:45:06','2025-11-10 10:48:06'),(2,1,NULL,1,'Quel est votre ID',NULL,NULL,NULL,NULL,NULL,'2025-11-10 09:34:12','2025-11-09 17:45:54','2025-11-10 09:34:12'),(3,1,NULL,1,'Envoyer le mail',NULL,NULL,NULL,NULL,NULL,'2025-11-10 09:49:35','2025-11-10 09:49:23','2025-11-10 09:49:35'),(4,1,60,0,'','premium_photo-1675242132223-9aa7268fbbc7.jpg','support/attachments/9ElmJy3MsiRjDai9rKdCENf4pasFCrH4CFmhtMfU.jpg','image/jpeg',39725,NULL,'2025-11-10 10:48:06','2025-11-10 09:50:27','2025-11-10 10:48:06'),(5,1,NULL,1,'D\'accord',NULL,NULL,NULL,NULL,NULL,'2025-11-10 10:13:44','2025-11-10 10:13:38','2025-11-10 10:13:44'),(6,1,NULL,1,'J\'ai compris',NULL,NULL,NULL,NULL,NULL,'2025-11-10 10:15:58','2025-11-10 10:14:29','2025-11-10 10:15:58'),(7,1,60,0,'D\'accord',NULL,NULL,NULL,NULL,NULL,'2025-11-10 10:48:06','2025-11-10 10:16:06','2025-11-10 10:48:06'),(8,1,NULL,1,'Ok',NULL,NULL,NULL,NULL,NULL,'2025-11-10 10:16:29','2025-11-10 10:16:20','2025-11-10 10:16:29'),(9,1,NULL,1,'J\'ai compris',NULL,NULL,NULL,NULL,NULL,'2025-11-10 10:17:34','2025-11-10 10:16:55','2025-11-10 10:17:34'),(10,1,NULL,1,'Ok',NULL,NULL,NULL,NULL,NULL,'2025-11-10 10:17:34','2025-11-10 10:17:22','2025-11-10 10:17:34'),(11,1,60,0,'D\'accord',NULL,NULL,NULL,NULL,NULL,'2025-11-10 10:48:06','2025-11-10 10:48:01','2025-11-10 10:48:06'),(12,1,60,0,'Bonjour',NULL,NULL,NULL,NULL,NULL,'2025-11-13 08:01:47','2025-11-13 08:01:37','2025-11-13 08:01:47'),(19,1,60,0,'Bonjours',NULL,NULL,NULL,NULL,NULL,'2025-11-13 09:12:40','2025-11-13 09:12:23','2025-11-13 09:12:40'),(20,1,60,0,'Bonjour 👋',NULL,NULL,NULL,NULL,NULL,'2025-11-19 06:20:59','2025-11-19 06:20:33','2025-11-19 06:20:59'),(21,1,60,0,'Problème de recharge',NULL,NULL,NULL,NULL,NULL,'2025-11-21 22:03:41','2025-11-21 22:03:14','2025-11-21 22:03:41');
/*!40000 ALTER TABLE `support_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_tickets`
--

DROP TABLE IF EXISTS `support_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `support_tickets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `subject` varchar(255) NOT NULL,
  `status` enum('open','pending','answered','closed') NOT NULL DEFAULT 'open',
  `last_message_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `support_tickets_user_id_foreign` (`user_id`),
  KEY `support_tickets_status_updated_at_index` (`status`,`updated_at`),
  CONSTRAINT `support_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_tickets`
--

LOCK TABLES `support_tickets` WRITE;
/*!40000 ALTER TABLE `support_tickets` DISABLE KEYS */;
INSERT INTO `support_tickets` VALUES (1,60,'Problème de recharge','open','2025-11-21 22:03:14','2025-11-09 17:45:06','2025-11-21 22:04:22');
/*!40000 ALTER TABLE `support_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_histories`
--

DROP TABLE IF EXISTS `transaction_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction_histories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `compte_id` bigint(20) unsigned NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `devise` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_histories_user_id_foreign` (`user_id`),
  KEY `transaction_histories_compte_id_foreign` (`compte_id`),
  KEY `idx_transaction_transfer_id` (`transfer_id`),
  CONSTRAINT `transaction_histories_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=433 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_histories`
--

LOCK TABLES `transaction_histories` WRITE;
/*!40000 ALTER TABLE `transaction_histories` DISABLE KEYS */;
INSERT INTO `transaction_histories` VALUES (266,70,106,'Solde initial',10000.00,'Flux Bank',NULL,NULL,'€','2025-11-14 16:03:58','2025-11-14 16:03:58'),(267,70,106,'Funds added',15000.00,'TRANSAFRICASH',NULL,NULL,'€','2025-11-14 16:08:36','2025-11-14 16:08:36'),(276,71,108,'Solde initial',10000.00,'Flux Bank',NULL,NULL,'€','2025-11-18 16:44:53','2025-11-18 16:44:53'),(277,72,109,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-18 21:46:39','2025-11-18 21:46:39'),(278,73,110,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-19 07:20:41','2025-11-19 07:20:41'),(279,74,111,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-19 12:22:08','2025-11-19 12:22:08'),(280,75,112,'Solde initial',10000.00,'Flux Bank',NULL,NULL,'€','2025-11-19 15:16:38','2025-11-19 15:16:38'),(281,75,112,'Transfer sent',10000.00,'Bcp - BIC: BCP123',NULL,NULL,'€','2025-11-19 15:56:26','2025-11-19 15:56:26'),(282,76,113,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-19 15:59:42','2025-11-19 15:59:42'),(283,77,114,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-20 08:05:16','2025-11-20 08:05:16'),(284,78,115,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-20 08:25:44','2025-11-20 08:25:44'),(285,70,116,'Funds added',700000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-20 09:18:56','2025-11-20 09:18:56'),(286,79,117,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-20 09:23:52','2025-11-20 09:23:52'),(287,80,118,'Solde initial',10000.00,'Flux Bank',NULL,NULL,'€','2025-11-20 12:16:29','2025-11-20 12:16:29'),(288,81,119,'Solde initial',10000.00,'Flux Bank',NULL,NULL,'€','2025-11-20 13:19:32','2025-11-20 13:19:32'),(289,82,120,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-20 17:53:35','2025-11-20 17:53:35'),(290,83,121,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-20 23:40:44','2025-11-20 23:40:44'),(291,84,122,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-21 00:57:06','2025-11-21 00:57:06'),(292,85,123,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-21 07:18:21','2025-11-21 07:18:21'),(293,85,123,'Transfer sent',10000.00,'Tu - BIC: Azerty',NULL,NULL,'€','2025-11-21 09:25:13','2025-11-21 09:25:13'),(294,85,123,'Refund received',10000.00,'Tu - BIC: Azerty',NULL,NULL,'€','2025-11-21 09:51:57','2025-11-21 09:51:57'),(309,83,130,'Funds added',300000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-24 21:00:41','2025-11-24 21:00:41'),(310,83,131,'Funds added',14000000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-24 21:14:06','2025-11-24 21:14:06'),(312,84,133,'Funds added',44000.00,'TRANSFERFLUX',NULL,NULL,'PEN','2025-11-24 22:32:55','2025-11-24 22:32:55'),(313,87,134,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-25 12:08:44','2025-11-25 12:08:44'),(314,84,135,'Funds added',350000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-25 12:37:26','2025-11-25 12:37:26'),(315,88,136,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-26 20:32:18','2025-11-26 20:32:18'),(316,87,137,'Funds added',500000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-28 12:16:19','2025-11-28 12:16:19'),(322,89,138,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-28 21:44:58','2025-11-28 21:44:58'),(323,89,138,'Transfer sent',10000.00,'Paribas - BIC: 12345 - IBAN: 123446789',96,NULL,'€','2025-11-28 21:50:20','2025-11-28 21:50:20'),(324,89,138,'Refund received',10000.00,'Paribas - BIC: 12345',NULL,NULL,'€','2025-11-28 21:51:38','2025-11-28 21:51:38'),(325,89,138,'Funds deducted',200.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-28 21:53:23','2025-11-28 21:53:23'),(326,89,138,'Funds added',300.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-28 21:53:50','2025-11-28 21:53:50'),(327,90,139,'Solde initial',10000.00,'TRANSFERFLUX',NULL,NULL,'€','2025-11-28 22:05:21','2025-11-28 22:05:21'),(420,60,174,'Funds added',500000.00,'TRANSFERFLUX',NULL,NULL,'XOF','2026-03-28 11:36:04','2026-03-28 11:36:04');
/*!40000 ALTER TABLE `transaction_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transfers`
--

DROP TABLE IF EXISTS `transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transfers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `compte_id` bigint(20) unsigned DEFAULT NULL,
  `compte_id_inferred` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) unsigned NOT NULL,
  `numerocompte` varchar(255) NOT NULL,
  `name_servieur` varchar(255) NOT NULL,
  `beneficiary_name` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `devise` text NOT NULL,
  `token` text NOT NULL,
  `solidvire` text NOT NULL,
  `status` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfers_user_id_foreign` (`user_id`),
  KEY `transfers_compte_id_index` (`compte_id`),
  KEY `transfers_compte_id_inferred_index` (`compte_id_inferred`),
  CONSTRAINT `transfers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transfers`
--

LOCK TABLES `transfers` WRITE;
/*!40000 ALTER TABLE `transfers` DISABLE KEYS */;
INSERT INTO `transfers` VALUES (22,NULL,1,60,'123456789','AXA - BIC: TRWIBEB1XXX','NOUKPO','1','€','','6000.00','rembourse','2025-11-08 10:18:20','2025-11-08 09:23:23'),(23,NULL,1,60,'123456789','AXA - BIC: TRWIBEB1XXX','NOUKPO','1','€','','6000.00','rembourse','2025-11-08 10:24:15','2025-11-08 09:43:09'),(24,NULL,1,60,'123456789','AXA - BIC: TRWIBEB1XXX','NOUKPO','1','€','','6000.00','rembourse','2025-11-08 10:43:51','2025-11-08 09:52:05'),(25,NULL,1,60,'123456789','AXA - BIC: TRWIBEB1XXX','NOUKPO','1','€','','6000.00','rembourse','2025-11-08 10:52:50','2025-11-08 09:56:49'),(26,NULL,1,60,'123456789B','AXA - BIC: TRWIBEB1XXX','NOUKPO','1','€','','6000.00','rembourse','2025-11-08 10:57:37','2025-11-08 10:19:13'),(27,NULL,1,60,'12345678','AXA - BIC: TRWIBEB1XXX','NOUKPO','1','€','','6000.00','rembourse','2025-11-08 11:20:32','2025-11-08 10:27:46'),(28,NULL,1,60,'123456789','AXA - BIC: TRWIBEB1XXX','NOUKPO','1','€','','6000.00','rembourse','2025-11-08 11:28:20','2025-11-08 10:33:38'),(29,NULL,1,60,'1000','AXA - BIC: TRWIBEB1XXX','NOUKPO','1','€','','1000.00','rembourse','2025-11-08 11:36:18','2025-11-08 10:39:55'),(30,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','','€','','10000','rembourse','2025-11-08 17:49:36','2025-11-08 16:52:27'),(31,NULL,1,60,'123456789','AXA - BIC: TRWIBEB1XXX','NOUKPO','1','€','','10000.00','rembourse','2025-11-08 21:46:50','2025-11-09 08:12:58'),(32,NULL,1,60,'123456778','AXA - BIC: TRWIBEB1XXX','NOUKPO','1','€','','10000.00','rembourse','2025-11-09 09:33:55','2025-11-09 08:36:39'),(33,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','10000','completed','2025-11-09 11:57:03','2025-11-09 11:57:03'),(34,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','10000','completed','2025-11-09 12:01:57','2025-11-09 12:01:57'),(35,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','10000','completed','2025-11-09 12:03:53','2025-11-09 12:03:53'),(36,NULL,1,60,'123456789','AXA - BIC: TRWIBEB1XXX','NOUKPO','1','€','','10000','completed','2025-11-09 12:07:57','2025-11-09 12:07:57'),(37,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','10000','completed','2025-11-09 12:12:18','2025-11-09 12:12:18'),(38,NULL,1,60,'123456789','AXA - BIC: TRWIBEB1XXX','NOUKPO','1','€','','10000','completed','2025-11-09 12:20:07','2025-11-09 12:20:07'),(39,NULL,1,60,'1234556789','BE3245678945 - BIC: BE19420','LALYA','Règlement de compte','€','','10000','rembourse','2025-11-09 12:31:17','2025-11-09 11:33:39'),(40,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','10000','rembourse','2025-11-09 12:34:45','2025-11-09 11:47:24'),(41,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','10000','rembourse','2025-11-09 12:47:51','2025-11-09 11:50:39'),(42,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','10000','rembourse','2025-11-09 13:07:40','2025-11-09 17:22:53'),(43,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','10000','rembourse','2025-11-09 18:31:39','2025-11-09 17:47:18'),(44,NULL,1,60,'1234567890','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','10000','rembourse','2025-11-09 18:49:59','2025-11-09 17:54:58'),(45,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','10000','rembourse','2025-11-09 18:59:34','2025-11-09 18:02:02'),(46,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','10000','rembourse','2025-11-09 19:03:51','2025-11-09 18:09:05'),(47,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','10000','rembourse','2025-11-09 19:11:36','2025-11-09 22:36:14'),(48,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','Règlement de compte','€','','10000','rembourse','2025-11-09 23:39:29','2025-11-09 22:53:58'),(49,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','10000','rembourse','2025-11-10 00:09:39','2025-11-09 23:13:54'),(50,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','10000','rembourse','2025-11-10 01:02:38','2025-11-10 00:05:16'),(51,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','Règlement de compte','€','','10000','rembourse','2025-11-10 01:05:40','2025-11-10 00:14:25'),(52,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','10000','rembourse','2025-11-10 01:14:54','2025-11-10 12:46:44'),(53,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','1000','rembourse','2025-11-11 10:42:13','2025-11-11 09:48:08'),(54,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','1000','rembourse','2025-11-11 10:48:42','2025-11-11 09:55:41'),(55,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','1000','completed','2025-11-11 10:56:39','2025-11-11 10:56:39'),(57,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','9200','rembourse','2025-11-11 12:49:16','2025-11-11 14:59:35'),(58,NULL,1,60,'1234567890','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','9200','rembourse','2025-11-11 16:37:27','2025-11-11 16:39:49'),(59,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','9200','rembourse','2025-11-11 17:56:52','2025-11-11 17:01:17'),(60,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','9200','rembourse','2025-11-11 18:01:54','2025-11-11 17:32:01'),(67,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','9200','rembourse','2025-11-11 18:32:32','2025-11-11 17:45:08'),(68,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','9200','rembourse','2025-11-11 18:46:19','2025-11-11 18:00:57'),(69,NULL,1,60,'1234567890','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','9200','rembourse','2025-11-11 19:01:22','2025-11-11 19:30:52'),(70,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','9200','rembourse','2025-11-11 20:31:43','2025-11-11 19:36:17'),(71,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','9200','rembourse','2025-11-11 20:36:51','2025-11-11 19:45:04'),(72,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','9200','rembourse','2025-11-11 20:45:25','2025-11-11 19:48:49'),(73,NULL,1,60,'1234567890','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','9200','rembourse','2025-11-11 20:49:34','2025-11-11 19:56:56'),(74,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','9200','rembourse','2025-11-11 20:57:51','2025-11-11 20:01:34'),(75,NULL,1,60,'1234444','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','9200','rembourse','2025-11-11 21:02:13','2025-11-11 20:07:31'),(76,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','9200','rembourse','2025-11-11 21:08:03','2025-11-11 20:11:45'),(77,NULL,1,60,'123322123','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','9200','rembourse','2025-11-11 21:12:15','2025-11-11 20:24:25'),(78,NULL,1,60,'1234567890','ParisBas - BIC: BE19420','LALYA','Règlement de compte','€','','9200','rembourse','2025-11-11 21:25:04','2025-11-11 20:33:30'),(79,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','9200','completed','2025-11-11 21:34:08','2025-11-11 21:34:08'),(80,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','NIO','','3100','rembourse','2025-11-12 20:54:01','2025-11-12 21:04:53'),(81,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','NIO','','3100','completed','2025-11-12 22:23:37','2025-11-12 22:23:37'),(82,NULL,1,60,'123456789','ParisBas - BIC: BE19420','LALYA','Règlement de compte','NIO','','2700','rembourse','2025-11-13 07:49:43','2025-11-13 06:52:09'),(83,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','NIO','','2700','rembourse','2025-11-13 07:52:41','2025-11-13 07:45:17'),(84,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','Transferts','€','','2300','rembourse','2025-11-15 15:31:19','2025-11-16 13:43:54'),(85,NULL,1,60,'123456789','Paribas - BIC: 1234567','Candide','transfert','€','','150510','rembourse','2025-11-18 16:53:57','2025-11-18 15:57:29'),(86,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','Transfert','€','','150510','completed','2025-11-18 17:03:15','2025-11-18 17:03:15'),(87,NULL,1,75,'19400345542031','Bcp - BIC: BCP123','Hugo PITMAN','Donacion','€','','10000','completed','2025-11-19 16:54:44','2025-11-19 16:54:44'),(88,NULL,1,85,'1234567','Tu - BIC: Azerty','Mionet-rosignol','Transfert','€','','10000','rembourse','2025-11-21 10:23:31','2025-11-21 09:51:57'),(89,NULL,1,60,'+22 676580456','Orange Money - BIC: ORANGE','Jack OUEDRAOGO','Transfert','XOF','','870000','completed','2025-11-21 22:33:39','2025-11-21 22:33:39'),(90,NULL,1,60,'+22 676580456','Wave - BIC: WAVE','Jack OUEDRAOGO','Transfert','XOF','','540000','rembourse','2025-11-21 22:38:37','2025-11-21 21:41:31'),(91,NULL,1,60,'+2250 596385213','MTN Money - BIC: MTN','Comlan Cossi','Transfert','XOF','','540000','rembourse','2025-11-21 22:43:27','2025-11-23 06:45:14'),(92,NULL,1,60,'BE123456789','AXA - BIC: BE19420','Lalya','1','€','','540000','rembourse','2025-11-23 21:19:45','2025-11-23 20:26:44'),(93,NULL,1,60,'FR897654324567','PARIBAS - BIC: DE34632','Candide','Règlement de compte','€','','540250','rembourse','2025-11-28 18:19:34','2025-11-28 20:34:42'),(94,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','Règlement de services','€','','540250','rembourse','2025-11-28 21:37:05','2025-11-28 20:40:25'),(95,NULL,1,60,'BE38967728519472','BELFIUS - BIC: TX357799','Credo M’BA','Transfer','€','','540250','rembourse','2025-11-28 21:51:51','2025-12-02 18:24:25'),(96,NULL,1,89,'123446789','Paribas - BIC: 12345','Dossier','Transfert','€','','10000','rembourse','2025-11-28 22:48:40','2025-11-28 21:51:38'),(97,NULL,1,60,'DE45092671244566','ParisBas - BIC: TRWIBEB1XXX','NOUKPO DAGBEMABU','Règlement de compte','€','','560000','rembourse','2025-12-02 10:27:27','2025-12-02 09:52:12'),(98,NULL,1,60,'FR35679876425','AXA - BIC: TRWIBEB1XXX','LALYA','Règlement de compte','€','','560000','rembourse','2025-12-02 10:58:50','2025-12-02 12:50:46'),(99,NULL,1,60,'FR35679876425','AXA - BIC: TRWIBEB1XXX','LALYA','Règlement de compte','€','','560000','rembourse','2025-12-02 13:56:34','2025-12-02 13:15:14'),(100,NULL,1,60,'FR35679876425','AXA - BIC: TRWIBEB1XXX','LALYA','Règlement de compte','€','','560000','rembourse','2025-12-02 14:16:18','2025-12-02 13:26:47'),(101,NULL,1,60,'FR35679876425','AXA - BIC: TRWIBEB1XXX','LALYA','Règlement de compte','€','','560000','rembourse','2025-12-02 16:28:45','2025-12-02 15:36:25'),(102,NULL,1,60,'FR35679876425','AXA - BIC: TRWIBEB1XXX','LALYA','Règlement de compte','€','','560000','rembourse','2025-12-02 16:37:32','2025-12-02 15:47:49'),(103,NULL,1,60,'FR35679876425','AXA - BIC: TRWIBEB1XXX','LALYA','Règlement de compte','€','','540250','rembourse','2025-12-02 19:25:03','2025-12-02 18:27:41'),(104,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','Règlement de compte','€','','540250','rembourse','2025-12-02 19:52:24','2025-12-02 18:56:49'),(105,NULL,1,60,'FR35679876425','AXA - BIC: TRWIBEB1XXX','LALYA','Règlement de compte','€','','540250','rembourse','2025-12-02 19:57:20','2025-12-02 18:59:57'),(106,NULL,1,60,'FR35679876425','AXA - BIC: TRWIBEB1XXX','LALYA','Règlement de compte','€','','540250','rembourse','2025-12-02 21:10:23','2025-12-02 20:19:01'),(107,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','€','','10000','completed','2026-03-28 07:42:44','2026-03-28 07:42:44'),(108,NULL,1,60,'PayPal','lalyaisidore@gmail.com','PayPal - lalyaisidore@gmail.com','transfert','XOF','','5000','rembourse','2026-03-28 08:35:12','2026-03-28 07:43:53'),(109,NULL,1,60,'+2290 198201610','MTN Money - BIC: MTN','Lalya Flora','Prêt','XOF','','500000','completed','2026-03-29 11:09:12','2026-03-29 11:09:12'),(110,NULL,1,60,'FR76 22636747448873','ParisBas - BIC: TRWIBEB1XXX','NOUKPO','Règlement de compte','€','','10000','completed','2026-03-29 11:49:36','2026-03-29 11:49:36'),(111,NULL,1,60,'FR76 22636747448873','ParisBas - BIC: TRWIBEB1XXX','NOUKPO','Règlement de compte','€','','10000','completed','2026-03-29 12:20:29','2026-03-29 12:20:29'),(112,NULL,1,60,'+2290 198201610','Orange Money - BIC: ORANGE','Lalya Flora','Prêt','XOF','','500000','completed','2026-03-29 12:31:38','2026-03-29 12:31:38'),(113,NULL,1,60,'+2290 198201610','Orange Money - BIC: ORANGE','Lalya Flora','Prêt','XOF','','6000','rembourse','2026-03-29 17:42:56','2026-03-29 15:54:28'),(114,NULL,1,60,'FR76 42536784903','ParisBas - BIC: BE19420','NOUKPO','Règlement de compte','€','','25500','completed','2026-03-29 19:30:04','2026-03-29 19:30:04');
/*!40000 ALTER TABLE `transfers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unlock_codes`
--

DROP TABLE IF EXISTS `unlock_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unlock_codes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `compte_id` bigint(20) unsigned DEFAULT NULL,
  `transfer_id` bigint(20) unsigned DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `unlock_codes_transfer_id_foreign` (`transfer_id`),
  KEY `unlock_codes_compte_id_foreign` (`compte_id`),
  CONSTRAINT `unlock_codes_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `unlock_codes_transfer_id_foreign` FOREIGN KEY (`transfer_id`) REFERENCES `transfers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unlock_codes`
--

LOCK TABLES `unlock_codes` WRITE;
/*!40000 ALTER TABLE `unlock_codes` DISABLE KEYS */;
INSERT INTO `unlock_codes` VALUES (5,112,NULL,'10863512','2025-11-19 16:11:46',NULL,'2025-11-19 15:41:46','2025-11-19 15:41:46'),(6,121,NULL,'07854696','2025-11-21 22:02:40',NULL,'2025-11-21 21:32:40','2025-11-21 21:32:40');
/*!40000 ALTER TABLE `unlock_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `url_shortener_history`
--

DROP TABLE IF EXISTS `url_shortener_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `url_shortener_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `original_url` varchar(255) NOT NULL,
  `short_url` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL DEFAULT 'is.gd',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_shortener_history_short_url_unique` (`short_url`),
  KEY `url_shortener_history_user_id_foreign` (`user_id`),
  CONSTRAINT `url_shortener_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `url_shortener_history`
--

LOCK TABLES `url_shortener_history` WRITE;
/*!40000 ALTER TABLE `url_shortener_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `url_shortener_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `url_verifications`
--

DROP TABLE IF EXISTS `url_verifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `url_verifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `domain` varchar(255) NOT NULL,
  `lookup_status` varchar(255) NOT NULL DEFAULT 'pending',
  `registrar` varchar(255) DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `lookup_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`lookup_data`)),
  `error_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `url_verifications_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `url_verifications_domain_index` (`domain`),
  CONSTRAINT `url_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `url_verifications`
--

LOCK TABLES `url_verifications` WRITE;
/*!40000 ALTER TABLE `url_verifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `url_verifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `region` enum('europe','afrique') NOT NULL DEFAULT 'europe',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `credit_user` bigint(20) unsigned NOT NULL DEFAULT 0,
  `code_parrainage` varchar(255) DEFAULT NULL,
  `parrain_id` bigint(20) unsigned DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_parrain_id_foreign` (`parrain_id`),
  KEY `users_region_index` (`region`),
  CONSTRAINT `users_parrain_id_foreign` FOREIGN KEY (`parrain_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (60,'CANDIDE','CANDIDE','lalyaisidore@gmail.com','+2290198201610','europe',NULL,'$2y$12$ZFe2wGWmC6GqVaHv2sgdKuS0BhWcdTaigI2/CTYZP9Pq8itqdZFhq',10500,NULL,NULL,NULL,'2025-11-08 07:34:35','2026-03-29 12:39:45'),(70,'Franck','Durand','durandfranck249@gmail.com','+2250564325906','europe',NULL,'$2y$12$ynRUcySoCR9k80NKSQhxo.MhpVrfNnrMg0a2VHzAlvctcqQ6uMU0q',3000,NULL,NULL,NULL,'2025-11-14 16:03:58','2025-11-20 09:18:56'),(71,'nguyen thi','kim dung','bellsonnesonia@gmail.com','+2550153244976','europe',NULL,'$2y$12$ZFUmtSVc4287oqibiFbC5.HoRDYQsv51q.UJHtTqxI.xFB0Nhee7G',0,NULL,NULL,NULL,'2025-11-18 16:44:53','2025-11-18 16:44:53'),(72,'Fostinos','Charmakh','fostinoscharmakh@gmail.com','+2290191702794','europe',NULL,'$2y$12$bkeYRAVz0foLznSJX8mMKuXjeE4HHboTESSbVTfyoINV0gwq1WsbC',0,NULL,NULL,NULL,'2025-11-18 21:46:39','2025-11-18 21:46:39'),(73,'Christophe','LEJEUNE','amadjicarmel11@gmail.com','+22953221824','europe',NULL,'$2y$12$PPrMvllhm6lrioQZPOf76.YHE80Xvq0iPdqrXpRl471fT1kvFDMaW',0,NULL,NULL,NULL,'2025-11-19 07:20:41','2025-11-19 07:20:41'),(74,'Tz la','Hauteur','tzlahauteur91@gmail.com','+22957524467','europe',NULL,'$2y$12$y0tvLn/6etPuwgEREkTlAuKrAbrnVWNHpm3bqVsZKNQA9S1.12EkG',0,NULL,60,NULL,'2025-11-19 12:22:08','2025-11-19 12:22:08'),(75,'Hugo','PITMAN','assicurazioneprestitionline@gmail.com','+31647975034','europe',NULL,'$2y$12$.bJtrjHkCu29Fn3SIiYPEePpafycxJSDjieyJVARrQm9KeUtfJMwi',0,NULL,NULL,NULL,'2025-11-19 15:16:38','2025-11-19 15:16:38'),(76,'Boga','St Paul','saraovidente@gmail.com','2290168460884','europe',NULL,'$2y$12$y3BUafPZ59hf2RIlRlC/kep7ZCRn1UBP7L9hLvCMENLjX1eFvJgLS',0,NULL,NULL,NULL,'2025-11-19 15:59:42','2025-11-19 15:59:42'),(77,'Savi','Audrey','jikelmike@gmail.com','+2290191640768','europe',NULL,'$2y$12$MwGYJ5iEHkFGCxcAqXprTeTTrpnm5DzlQXagI7ZE4WMNU8FtWbUhO',0,NULL,NULL,NULL,'2025-11-20 08:05:16','2025-11-20 08:05:16'),(78,'Sowanou','Sylvain','sowanousyl@gmail.com','+2290166842969','europe',NULL,'$2y$12$4IyqStyZI8Ld4xy8wKBVVuC0TTvwb390gkQrqibj9VMRxKyWseZ0W',0,NULL,NULL,NULL,'2025-11-20 08:25:44','2025-11-20 08:25:44'),(79,'Joël','Joël','autogarantieversicherung@gmail.com','+22960067966','europe',NULL,'$2y$12$tQq0MRjaMFDTM85oNE8qDOerF5sqD/HoJwscSjGJZ/2P/IK8DAgja',0,NULL,NULL,NULL,'2025-11-20 09:23:52','2025-11-20 09:23:52'),(80,'Antonio','Maniscalco','laboitedetabac@gmail.com','+2290147536584','europe',NULL,'$2y$12$1SC./sJC6SB858/GPAsr2eDTiLL6Jl8xMIuEu2gCdvAT0fwRV8Fsi',0,NULL,NULL,NULL,'2025-11-20 12:16:29','2025-11-20 12:16:29'),(81,'Alexis','Dautin','alexisedautin@gmail.com','+22962133940','europe',NULL,'$2y$12$ZBkVMi2DG7CMZVbijxgPLee33m4dQstNFZ72Uct7CEvmqhJO0V7Oa',0,NULL,NULL,NULL,'2025-11-20 13:19:32','2025-11-20 13:19:32'),(82,'Soares Marque Da Silva','Fernando','fernandosoaresmarquedasilva@gmail.com','229016588114','europe',NULL,'$2y$12$aRFcCqpkjD52l.V99qHMje4.JqgYqN6wSMp5qmL9z1/Bb978NpLDu',0,NULL,60,NULL,'2025-11-20 17:53:35','2025-11-20 17:53:35'),(83,'Jean','Laurant','hospicehounwanou66@gmail.com','+2290159253951','europe',NULL,'$2y$12$v5nlnmSt5qCXGtWt2DW6Qu4aaUC2ZVKmOQ9lxXYk8UnPtdCzL75M6',0,NULL,NULL,NULL,'2025-11-20 23:40:44','2025-11-24 21:14:06'),(84,'Maria','Adeline','Princessleonorofficial62@gmail.com','2290158553191','europe',NULL,'$2y$12$/ox89rE1zwY3u3dZD00Rkuixi9YECCarzGF6pBF3HNF1b9bhfrHnW',5000,NULL,83,NULL,'2025-11-21 00:57:06','2025-11-25 12:37:26'),(85,'Mino\'','Maria-rosa','mariarosapatriziam@gmail.com','+2290166864988','europe',NULL,'$2y$12$9IKllWfRmFg0FKJ3rUPgae.V0BrCISZcsKxxN2b7gelCDS9cG07dG',0,NULL,NULL,NULL,'2025-11-21 07:18:21','2025-11-21 07:18:21'),(87,'christophe','Lejeune','christophelejeune002@gmail.com','+22953221824','europe',NULL,'$2y$12$.P4.zeoAluEGIJb6BSBZC.0cMcIb3AjaHy1AaBzNZD9Rrp5KqUhyK',0,NULL,60,NULL,'2025-11-25 12:08:44','2025-11-28 12:16:19'),(88,'Dupont','Alice','estevedossou508@gmail.com','+2290199609798','europe',NULL,'$2y$12$0pRfGPrkgBqlCkfpAuEccOJg4DzVpGfkC7Eb6sz/6jYrOdOX.GKGi',0,NULL,83,NULL,'2025-11-26 20:32:18','2025-11-26 20:32:18'),(89,'Thomas','Uriel','j7702471@gmail.com','2290191137547','europe',NULL,'$2y$12$l7xFVkRDJzFa28CrCheLsOEp04K5v3gzACwV42sdOFqqep6vIk5Xe',0,NULL,NULL,NULL,'2025-11-28 21:44:58','2025-11-28 21:44:58'),(90,'Bonnafé','Jean Laurent','scotiabank143@gmail.com','+2290191635916','europe',NULL,'$2y$12$XtuUJQMQlaHdzaT63qBYxexfoRYyTAzbWCj/oEsCLiDnX7uGXJKBu',0,NULL,60,NULL,'2025-11-28 22:05:21','2025-11-28 22:05:21');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_2`
--

DROP TABLE IF EXISTS `users_2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `primary_color` varchar(255) DEFAULT NULL,
  `accent_color` varchar(255) DEFAULT NULL,
  `showroom_token` varchar(64) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `config_vitrine` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config_vitrine`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_2_email_unique` (`email`),
  UNIQUE KEY `users_2_showroom_token_unique` (`showroom_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_2`
--

LOCK TABLES `users_2` WRITE;
/*!40000 ALTER TABLE `users_2` DISABLE KEYS */;
INSERT INTO `users_2` VALUES (1,'DELCO','lalyaisidore@gmail.com','$2y$12$ZTRO9E20NCM4yq2w8dq5LOasfQ1EyiXbRpwz7TcIc2HNJws85PfSS','+33774951791','showroom_logos/mXuRFvxayg5R9TOk3wOt8dFvJGK2PF2jyVgj7ozg.png','#105d98','#a28e06','RH5tfApq',1,NULL,'{\"footer\":{\"address\":\"Cotonou-B\\u00e9nin\",\"social\":{\"facebook\":null,\"instagram\":null,\"linkedin\":null}}}','2025-12-04 22:51:33','2025-12-10 15:48:39');
/*!40000 ALTER TABLE `users_2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `virements`
--

DROP TABLE IF EXISTS `virements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `virements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `compte_id` bigint(20) unsigned NOT NULL,
  `iban` varchar(255) NOT NULL,
  `bic` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `beneficiary_name` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `solidvire` decimal(15,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `unlock_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `virements_compte_id_foreign` (`compte_id`),
  CONSTRAINT `virements_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `virements`
--

LOCK TABLES `virements` WRITE;
/*!40000 ALTER TABLE `virements` DISABLE KEYS */;
/*!40000 ALTER TABLE `virements` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-29 21:21:39
