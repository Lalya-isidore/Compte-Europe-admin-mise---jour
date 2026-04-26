-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 29 mars 2026 à 20:16
-- Version du serveur : 11.8.6-MariaDB-log
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `u245636672_CompteEurope`
--

-- --------------------------------------------------------

--
-- Structure de la table `affiliations`
--

CREATE TABLE `affiliations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `parrain_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code_affiliation` varchar(255) NOT NULL,
  `commission_rate` decimal(5,2) NOT NULL DEFAULT 5.00,
  `total_commissions` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_parraines` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `affiliations`
--

INSERT INTO `affiliations` (`id`, `user_id`, `parrain_id`, `code_affiliation`, `commission_rate`, `total_commissions`, `total_parraines`, `is_active`, `settings`, `created_at`, `updated_at`) VALUES
(45, 60, NULL, 'AFFF0AC1C2B', 5.00, 3434785.16, 16, 1, NULL, '2025-11-08 07:34:35', '2026-02-25 10:10:32'),
(51, 70, NULL, 'AFFCB31C833', 5.00, 0.00, 0, 1, NULL, '2025-11-14 16:03:58', '2025-11-14 16:03:58'),
(52, 71, NULL, 'AFFA571D7B6', 5.00, 0.00, 0, 1, NULL, '2025-11-18 16:44:53', '2025-11-18 16:44:53'),
(53, 72, NULL, 'AFFCEE45FDF', 5.00, 0.00, 0, 1, NULL, '2025-11-18 21:46:39', '2025-11-18 21:46:39'),
(54, 73, NULL, 'AFF38747F13', 5.00, 0.00, 0, 1, NULL, '2025-11-19 07:20:41', '2025-11-19 07:20:41'),
(55, 74, 60, 'AFFA8B9B7B5', 5.00, 0.00, 0, 1, NULL, '2025-11-19 12:22:08', '2025-11-19 12:22:08'),
(56, 75, NULL, 'AFF0A1C9027', 5.00, 0.00, 0, 1, NULL, '2025-11-19 15:16:38', '2025-11-19 15:16:38'),
(57, 76, NULL, 'AFF62415FDA', 5.00, 0.00, 0, 1, NULL, '2025-11-19 15:59:42', '2025-11-19 15:59:42'),
(58, 77, NULL, 'AFFD8D6D5F9', 5.00, 0.00, 0, 1, NULL, '2025-11-20 08:05:16', '2025-11-20 08:05:16'),
(59, 78, NULL, 'AFFBF26751D', 5.00, 0.00, 0, 1, NULL, '2025-11-20 08:25:44', '2025-11-20 08:25:44'),
(60, 79, NULL, 'AFFCCC03BBD', 5.00, 0.00, 0, 1, NULL, '2025-11-20 09:23:52', '2025-11-20 09:23:52'),
(61, 80, NULL, 'AFF18F6ACFE', 5.00, 0.00, 0, 1, NULL, '2025-11-20 12:16:29', '2025-11-20 12:16:29'),
(62, 81, NULL, 'AFFF2EB8D2F', 5.00, 0.00, 0, 1, NULL, '2025-11-20 13:19:32', '2025-11-20 13:19:32'),
(63, 82, 60, 'AFF64D1871C', 5.00, 0.00, 0, 1, NULL, '2025-11-20 17:53:35', '2025-11-20 17:53:35'),
(64, 83, NULL, 'AFFE6FB3E9F', 5.00, 57950.00, 3, 1, NULL, '2025-11-20 23:40:44', '2026-01-29 09:49:41'),
(65, 84, 83, 'AFFEBB8BB3F', 5.00, 0.00, 0, 1, NULL, '2025-11-21 00:57:06', '2025-11-21 00:57:06'),
(66, 85, NULL, 'AFF252832FA', 5.00, 0.00, 0, 1, NULL, '2025-11-21 07:18:21', '2025-11-21 07:18:21'),
(68, 87, 60, 'AFF6255D88D', 5.00, 0.00, 0, 1, NULL, '2025-11-25 12:08:44', '2025-11-25 12:08:44'),
(69, 88, 83, 'AFFDDE691FB', 5.00, 0.00, 0, 1, NULL, '2025-11-26 20:32:18', '2025-11-26 20:32:18'),
(70, 89, NULL, 'AFFBDDFB04D', 5.00, 0.00, 0, 1, NULL, '2025-11-28 21:44:58', '2025-11-28 21:44:58'),
(71, 90, 60, 'AFF6596C04C', 5.00, 0.00, 0, 1, NULL, '2025-11-28 22:05:21', '2025-11-28 22:05:21'),
(72, 91, NULL, 'AFFBD52B340', 5.00, 0.00, 0, 1, NULL, '2025-12-03 12:24:27', '2025-12-03 12:24:27'),
(76, 95, NULL, 'AFFD2CABC47', 5.00, 0.00, 0, 1, NULL, '2025-12-04 09:03:55', '2025-12-04 09:03:55'),
(78, 97, 60, 'AFFB3E612A9', 5.00, 0.00, 0, 1, NULL, '2025-12-04 13:41:27', '2025-12-04 13:41:27'),
(79, 98, NULL, 'AFF782EC04A', 5.00, 0.00, 0, 1, NULL, '2025-12-04 19:46:41', '2025-12-04 19:46:41'),
(80, 99, NULL, 'AFFE34CB07B', 5.00, 0.00, 0, 1, NULL, '2025-12-05 20:29:23', '2025-12-05 20:29:23'),
(81, 100, NULL, 'AFF2F8DDDA4', 5.00, 0.00, 0, 1, NULL, '2025-12-06 10:36:30', '2025-12-06 10:36:30'),
(82, 101, NULL, 'AFF013FFE8E', 5.00, 0.00, 0, 1, NULL, '2025-12-12 09:22:39', '2025-12-12 09:22:39'),
(83, 102, 60, 'AFF23A3E3A9', 5.00, 0.00, 0, 1, NULL, '2025-12-16 19:43:13', '2025-12-16 19:43:13'),
(84, 103, NULL, 'AFF7530622F', 5.00, 0.00, 0, 1, NULL, '2025-12-20 19:40:50', '2025-12-20 19:40:50'),
(85, 104, NULL, 'AFF368C7DD5', 5.00, 0.00, 0, 1, NULL, '2025-12-22 20:44:09', '2025-12-22 20:44:09'),
(86, 105, NULL, 'AFFD6AEC19C', 5.00, 0.00, 0, 1, NULL, '2025-12-22 21:02:47', '2025-12-22 21:02:47'),
(87, 106, NULL, 'AFFC9262EC9', 5.00, 0.00, 0, 1, NULL, '2025-12-22 21:41:34', '2025-12-22 21:41:34'),
(88, 107, NULL, 'AFF234146A9', 5.00, 0.00, 0, 1, NULL, '2025-12-22 23:08:48', '2025-12-22 23:08:48'),
(89, 108, NULL, 'AFFB5A4BEFC', 5.00, 0.00, 0, 1, NULL, '2025-12-23 00:53:29', '2025-12-23 00:53:29'),
(91, 110, NULL, 'AFF31285928', 5.00, 0.00, 0, 1, NULL, '2025-12-23 06:35:30', '2025-12-23 06:35:30'),
(92, 111, NULL, 'AFFABB03629', 5.00, 0.00, 0, 1, NULL, '2025-12-23 10:10:31', '2025-12-23 10:10:31'),
(93, 112, NULL, 'AFFC7C7114F', 5.00, 0.00, 0, 1, NULL, '2025-12-23 10:55:47', '2025-12-23 10:55:47'),
(94, 113, NULL, 'AFFCC099CCD', 5.00, 0.00, 0, 1, NULL, '2025-12-23 10:56:44', '2025-12-23 10:56:44'),
(95, 114, NULL, 'AFFA2533B88', 5.00, 0.00, 0, 1, NULL, '2025-12-23 10:58:00', '2025-12-23 10:58:00'),
(96, 115, NULL, 'AFF36D5987F', 5.00, 0.00, 0, 1, NULL, '2025-12-23 13:18:03', '2025-12-23 13:18:03'),
(97, 116, 60, 'AFFD615450F', 5.00, 0.00, 0, 1, NULL, '2025-12-23 14:16:46', '2025-12-23 14:16:46'),
(98, 117, NULL, 'AFF386272D4', 5.00, 0.00, 0, 1, NULL, '2025-12-23 17:55:16', '2025-12-23 17:55:16'),
(99, 118, NULL, 'AFFD596BAEF', 5.00, 0.00, 0, 1, NULL, '2025-12-23 17:57:19', '2025-12-23 17:57:19'),
(100, 119, NULL, 'AFFA8E6AD68', 5.00, 0.00, 0, 1, NULL, '2025-12-23 19:14:54', '2025-12-23 19:14:54'),
(101, 120, 60, 'AFF3FD2137F', 5.00, 0.00, 0, 1, NULL, '2025-12-23 21:21:23', '2025-12-23 21:21:23'),
(102, 121, NULL, 'AFF36CA119C', 5.00, 0.00, 0, 1, NULL, '2025-12-25 23:36:29', '2025-12-25 23:36:29'),
(103, 122, 60, 'AFFC702250C', 5.00, 0.00, 0, 1, NULL, '2025-12-26 13:24:12', '2025-12-26 13:24:12'),
(104, 123, 60, 'AFFCE98BF4E', 5.00, 0.00, 0, 1, NULL, '2025-12-26 13:28:30', '2025-12-26 13:28:30'),
(105, 124, 60, 'AFFC4C9D851', 5.00, 0.00, 0, 1, NULL, '2025-12-26 21:11:19', '2025-12-26 21:11:19'),
(106, 125, NULL, 'AFF2BF49CC2', 5.00, 0.00, 0, 1, NULL, '2025-12-26 21:14:27', '2025-12-26 21:14:27'),
(107, 126, NULL, 'AFF297C8CCD', 5.00, 0.00, 0, 1, NULL, '2026-01-12 17:32:44', '2026-01-12 17:32:44'),
(108, 127, NULL, 'AFFD7BB4FA0', 5.00, 0.00, 0, 1, NULL, '2026-01-20 09:38:35', '2026-01-20 09:38:35'),
(109, 128, 83, 'AFF469814DD', 5.00, 0.00, 0, 1, NULL, '2026-01-29 06:58:25', '2026-01-29 06:58:25'),
(110, 129, NULL, 'AFF2B83ECC4', 5.00, 0.00, 0, 1, NULL, '2026-02-04 20:17:11', '2026-02-04 20:17:11'),
(111, 130, NULL, 'AFFBAE6736E', 5.00, 0.00, 0, 1, NULL, '2026-02-05 09:48:26', '2026-02-05 09:48:26'),
(112, 131, NULL, 'AFF975F22DB', 5.00, 0.00, 0, 1, NULL, '2026-02-12 09:57:27', '2026-02-12 09:57:27'),
(113, 132, NULL, 'AFF57A1D0D0', 5.00, 0.00, 0, 1, NULL, '2026-02-13 14:14:36', '2026-02-13 14:14:36'),
(114, 133, NULL, 'AFF13159557', 5.00, 0.00, 0, 1, NULL, '2026-02-19 19:22:37', '2026-02-19 19:22:37'),
(115, 134, NULL, 'AFFB3914A4F', 5.00, 0.00, 0, 1, NULL, '2026-02-21 08:47:34', '2026-02-21 08:47:34'),
(116, 135, NULL, 'AFF21377C18', 5.00, 0.00, 0, 1, NULL, '2026-02-23 17:51:17', '2026-02-23 17:51:17'),
(117, 136, NULL, 'AFF69ECC269', 5.00, 0.00, 0, 1, NULL, '2026-02-25 09:10:44', '2026-02-25 09:10:44'),
(118, 137, NULL, 'AFF1CABD3ED', 5.00, 0.00, 0, 1, NULL, '2026-03-04 19:34:02', '2026-03-04 19:34:02'),
(119, 138, NULL, 'AFF3BD2344A', 5.00, 0.00, 0, 1, NULL, '2026-03-17 01:39:27', '2026-03-17 01:39:27');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('flashcompte-cache-support_admin_last_active', 'O:25:\"Illuminate\\Support\\Carbon\":4:{s:4:\"date\";s:26:\"2025-12-26 16:48:13.611302\";s:13:\"timezone_type\";i:3;s:8:\"timezone\";s:3:\"UTC\";s:18:\"dumpDateProperties\";a:2:{s:4:\"date\";s:26:\"2025-12-26 16:48:13.611302\";s:8:\"timezone\";s:3:\"UTC\";}}', 1766789293);

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commissions`
--

CREATE TABLE `commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `affiliation_id` bigint(20) UNSIGNED NOT NULL,
  `parraine_user_id` bigint(20) UNSIGNED NOT NULL,
  `compte_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action_type` varchar(255) NOT NULL,
  `montant_base` decimal(10,2) NOT NULL DEFAULT 0.00,
  `taux_commission` decimal(5,2) NOT NULL,
  `montant_commission` decimal(10,2) NOT NULL,
  `statut` enum('en_attente','valide','paye','annule','en_cours_de_retrait','retiree') DEFAULT 'en_attente',
  `date_action` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_validation` timestamp NULL DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commissions`
--

INSERT INTO `commissions` (`id`, `affiliation_id`, `parraine_user_id`, `compte_id`, `action_type`, `montant_base`, `taux_commission`, `montant_commission`, `statut`, `date_action`, `date_validation`, `details`, `created_at`, `updated_at`) VALUES
(23, 64, 84, 122, 'recharge', 10000.00, 5.00, 500.00, 'valide', '2025-11-22 12:42:44', '2025-11-22 12:42:44', '{\"transaction_id\":\"RC8WG91HKV1763686818\",\"payment_method\":\"mobile_money\",\"credits_earned\":15000,\"auto_processed\":true}', '2025-11-22 12:42:44', '2025-11-22 12:42:44'),
(24, 64, 84, 133, 'creation_compte', 44000.00, 5.00, 2200.00, 'en_attente', '2025-11-24 22:32:55', NULL, '{\"description\":\"Commission pour la cr\\u00e9ation du compte Professionnel par Adeline Maria\"}', '2025-11-24 22:32:55', '2025-11-24 22:32:55'),
(25, 64, 84, 135, 'creation_compte', 350000.00, 5.00, 17500.00, 'en_attente', '2025-11-25 12:37:26', NULL, '{\"description\":\"Commission pour la cr\\u00e9ation du compte Professionnel par Adeline Maria\"}', '2025-11-25 12:37:26', '2025-11-25 12:37:26'),
(26, 45, 87, 134, 'recharge', 5000.00, 5.00, 250.00, 'valide', '2025-11-28 12:11:39', '2025-11-28 12:11:39', '{\"transaction_id\":\"RC2L7WX9DB1764331821\",\"payment_method\":\"mobile_money\",\"credits_earned\":5000,\"auto_processed\":true}', '2025-11-28 12:11:39', '2025-11-28 12:11:39'),
(27, 45, 87, 137, 'creation_compte', 500000.00, 5.00, 25000.00, 'en_attente', '2025-11-28 12:16:19', NULL, '{\"description\":\"Commission pour la cr\\u00e9ation du compte Professionnel par Lejeune christophe\"}', '2025-11-28 12:16:19', '2025-11-28 12:16:19'),
(28, 45, 90, 139, 'recharge', 5000.00, 5.00, 250.00, 'valide', '2025-12-16 12:17:25', '2025-12-16 12:17:25', '{\"transaction_id\":\"RCRVLRIX8Q1765887352\",\"payment_method\":\"mobile_money\",\"credits_earned\":5000,\"auto_processed\":true}', '2025-12-16 12:17:25', '2025-12-16 12:17:25'),
(29, 45, 90, 153, 'creation_compte', 962775.00, 5.00, 48138.75, 'en_attente', '2025-12-16 19:11:44', NULL, '{\"description\":\"Commission pour la cr\\u00e9ation du compte Professionnel par Jean Laurent Bonnaf\\u00e9\"}', '2025-12-16 19:11:44', '2025-12-16 19:11:44'),
(30, 45, 90, 139, 'recharge', 5000.00, 5.00, 250.00, 'valide', '2025-12-20 12:36:10', '2025-12-20 12:36:10', '{\"transaction_id\":\"RCCL30QS9E1766234094\",\"payment_method\":\"fedapay\",\"credits_earned\":5000,\"auto_processed\":true}', '2025-12-20 12:36:10', '2025-12-20 12:36:10'),
(31, 45, 90, 156, 'creation_compte', 62841835.00, 5.00, 3142091.75, 'en_attente', '2025-12-20 12:57:16', NULL, '{\"description\":\"Commission pour la cr\\u00e9ation du compte Professionnel par Jean Laurent Bonnaf\\u00e9\"}', '2025-12-20 12:57:16', '2025-12-20 12:57:16'),
(32, 45, 90, 139, 'recharge', 5000.00, 5.00, 250.00, 'valide', '2026-01-21 14:28:13', '2026-01-21 14:28:13', '{\"transaction_id\":\"RCE4EU5LMQ1769005585\",\"payment_method\":\"mobile_money\",\"credits_earned\":5000,\"auto_processed\":true}', '2026-01-21 14:28:13', '2026-01-21 14:28:13'),
(33, 45, 90, 187, 'creation_compte', 750000.00, 5.00, 37500.00, 'en_attente', '2026-01-21 14:45:16', NULL, '{\"description\":\"Commission pour la cr\\u00e9ation du compte Standard par Jean Laurent Bonnaf\\u00e9\"}', '2026-01-21 14:45:16', '2026-01-21 14:45:16'),
(34, 45, 90, 139, 'recharge', 5000.00, 5.00, 250.00, 'valide', '2026-01-24 14:38:20', '2026-01-24 14:38:20', '{\"transaction_id\":\"RCOPDJ6N461769265388\",\"payment_method\":\"mobile_money\",\"credits_earned\":5000,\"auto_processed\":true}', '2026-01-24 14:38:20', '2026-01-24 14:38:20'),
(35, 45, 90, 188, 'creation_compte', 750000.00, 5.00, 37500.00, 'en_attente', '2026-01-24 14:47:47', NULL, '{\"description\":\"Commission pour la cr\\u00e9ation du compte Standard par Jean Laurent Bonnaf\\u00e9\"}', '2026-01-24 14:47:47', '2026-01-24 14:47:47'),
(36, 64, 128, 189, 'recharge', 5000.00, 5.00, 250.00, 'valide', '2026-01-29 09:14:25', '2026-01-29 09:14:25', '{\"transaction_id\":\"RCDDYCMK5X1769677486\",\"payment_method\":\"mobile_money\",\"credits_earned\":5000,\"auto_processed\":true}', '2026-01-29 09:14:25', '2026-01-29 09:14:25'),
(37, 64, 128, 190, 'creation_compte', 750.00, 5.00, 37.50, 'en_attente', '2026-01-29 09:38:49', NULL, '{\"description\":\"Commission pour la cr\\u00e9ation du compte Professionnel par Angel lopez Molina\"}', '2026-01-29 09:38:49', '2026-01-29 09:38:49'),
(38, 64, 128, 190, 'depot', 749250.00, 5.00, 37462.50, 'en_attente', '2026-01-29 09:49:41', NULL, '{\"description\":\"Commission sur d\\u00e9p\\u00f4t de 749250.00 F CFA par Angel lopez Molina\",\"solde_avant\":\"750.00\",\"solde_apres\":\"750000.00\",\"augmentation\":749250}', '2026-01-29 09:49:41', '2026-01-29 09:49:41'),
(39, 45, 90, 139, 'recharge', 5000.00, 5.00, 250.00, 'valide', '2026-02-17 13:17:54', '2026-02-17 13:17:54', '{\"transaction_id\":\"RCTQMY3V4Y1771334186\",\"payment_method\":\"mobile_money\",\"credits_earned\":5000,\"auto_processed\":true}', '2026-02-17 13:17:54', '2026-02-17 13:17:54'),
(40, 45, 90, 196, 'creation_compte', 1180296.60, 5.00, 59014.83, 'en_attente', '2026-02-17 14:06:36', NULL, '{\"description\":\"Commission pour la cr\\u00e9ation du compte Standard par Jean Laurent Bonnaf\\u00e9\"}', '2026-02-17 14:06:36', '2026-02-17 14:06:36'),
(41, 45, 90, 139, 'recharge', 5000.00, 5.00, 250.00, 'valide', '2026-02-17 16:07:45', '2026-02-17 16:07:45', '{\"transaction_id\":\"RCKDAQVWSC1771344384\",\"payment_method\":\"mobile_money\",\"credits_earned\":5000,\"auto_processed\":true}', '2026-02-17 16:07:45', '2026-02-17 16:07:45'),
(42, 45, 90, 197, 'creation_compte', 490000.00, 5.00, 24500.00, 'en_attente', '2026-02-17 16:27:58', NULL, '{\"description\":\"Commission pour la cr\\u00e9ation du compte Standard par Jean Laurent Bonnaf\\u00e9\"}', '2026-02-17 16:27:58', '2026-02-17 16:27:58'),
(43, 45, 90, 196, 'depot', 1180296.60, 5.00, 59014.83, 'en_attente', '2026-02-23 06:54:51', NULL, '{\"description\":\"Commission sur d\\u00e9p\\u00f4t de 1180296.60 F CFA par Jean Laurent Bonnaf\\u00e9\",\"solde_avant\":\"0.00\",\"solde_apres\":\"1180296.60\",\"augmentation\":1180296.6}', '2026-02-23 06:54:51', '2026-02-23 06:54:51'),
(44, 45, 90, 139, 'recharge', 5000.00, 5.00, 250.00, 'valide', '2026-02-25 10:10:32', '2026-02-25 10:10:32', '{\"transaction_id\":\"RCANTHGYFI1772014153\",\"payment_method\":\"mobile_money\",\"credits_earned\":5000,\"auto_processed\":true}', '2026-02-25 10:10:32', '2026-02-25 10:10:32');

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE `comptes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
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
  `photo_path` varchar(255) DEFAULT NULL,
  `alert_email` tinyint(1) NOT NULL DEFAULT 1,
  `alert_sms` tinyint(1) NOT NULL DEFAULT 0,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `auto_deletes_at` timestamp NULL DEFAULT NULL,
  `is_auto_created` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`id`, `user_id`, `nom`, `prenom`, `email`, `phone_number`, `country`, `address`, `devise`, `lang`, `account_balance`, `account_balance2`, `credits_available`, `account_type`, `code_virement`, `code_virement_utilise`, `account_status`, `password`, `transfer_supported`, `token`, `public_token`, `iban`, `parameters`, `card_number`, `cvv`, `numerocompte`, `start_percentage`, `end_percentage`, `failure_message`, `photo_path`, `alert_email`, `alert_sms`, `is_default`, `created_at`, `updated_at`, `auto_deletes_at`, `is_auto_created`) VALUES
(93, 60, 'CANDIDE', 'CANDIDE', 'lalyaisidore@gmail.com', '+2290198201610', 'France', '14e Rue de MontFort Paris-France', '€', 'fr', 542000.00, 540250.00, 0.00, 'Standard', '379176', 0, 'Activé', '180902', 'Virement bancaire', NULL, NULL, NULL, NULL, '4249*******3643', '607', 'FC-CPYDLQYCHI', '1', '10', 'transfert échouer. Veuillez contacter votre banque', 'comptes-photos/compte_694041ee1241e.jpg', 1, 0, 0, '2025-11-08 07:34:35', '2026-02-25 10:10:32', '2025-11-08 08:34:35', 1),
(106, 70, 'Franck', 'Durand', 'durandfranck249@gmail.com', '+2250564325906', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 25000.00, 25000.00, 0.00, 'Standard', '913916', 0, 'Activé', '330754', 'Virement bancaire', NULL, NULL, NULL, NULL, '4378********7655', '477', 'FC-CUSYWEXFUE', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'comptes-photos/compte_69175377dd963.jpg', 1, 0, 0, '2025-11-14 16:03:58', '2025-11-14 16:08:36', '2025-11-14 17:03:58', 1),
(108, 71, 'nguyen thi', 'kim dung', 'bellsonnesonia@gmail.com', '+2550153244976', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '870649', 0, 'Activé', '538564', 'Virement bancaire', NULL, NULL, NULL, NULL, '4632********4666', '946', 'FC-R95MAPXE4N', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=kim+dung+nguyen+thi&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-18 16:44:53', '2025-11-18 16:44:53', '2025-11-18 17:44:53', 1),
(109, 72, 'Fostinos', 'Charmakh', 'fostinoscharmakh@gmail.com', '+2290191702794', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '128931', 0, 'Activé', '718469', 'Virement bancaire', NULL, NULL, NULL, NULL, '4671********5673', '953', 'FC-MOUMRHBCKY', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Charmakh+Fostinos&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-18 21:46:39', '2025-11-18 21:46:39', '2025-11-18 22:46:39', 1),
(110, 73, 'Christophe', 'LEJEUNE', 'amadjicarmel11@gmail.com', '+22953221824', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '535762', 0, 'Activé', '456645', 'Virement bancaire', NULL, NULL, NULL, NULL, '4952********9536', '346', 'FC-5GNUXRNN1L', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=LEJEUNE+Christophe&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-19 07:20:41', '2025-11-19 07:20:41', '2025-11-19 08:20:41', 1),
(111, 74, 'Tz la', 'Hauteur', 'tzlahauteur91@gmail.com', '+22957524467', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '893134', 0, 'Activé', '895207', 'Virement bancaire', NULL, NULL, NULL, NULL, '4492********8476', '203', 'FC-IHDA8HDYZU', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Hauteur+Tz+la&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-19 12:22:08', '2025-11-19 12:22:08', '2025-11-19 13:22:08', 1),
(112, 75, 'Hugo', 'PITMAN', 'assicurazioneprestitionline@gmail.com', '+31647975034', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 0.00, 10000.00, 0.00, 'Standard', '511038', 0, 'Activé', '107630', 'Virement bancaire', NULL, NULL, NULL, NULL, '4811********2440', '469', 'FC-4BRUYYIXTF', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=PITMAN+Hugo&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-19 15:16:38', '2025-11-19 15:16:38', '2025-11-19 16:16:38', 1),
(113, 76, 'Boga', 'St Paul', 'saraovidente@gmail.com', '2290168460884', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '704478', 0, 'Activé', '988875', 'Virement bancaire', NULL, NULL, NULL, NULL, '4973********7593', '808', 'FC-EUK50IW8MU', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=St+Paul+Boga&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-19 15:59:42', '2025-11-19 15:59:42', '2025-11-19 16:59:42', 1),
(114, 77, 'Savi', 'Audrey', 'jikelmike@gmail.com', '+2290191640768', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '188049', 0, 'Activé', '931344', 'Virement bancaire', NULL, NULL, NULL, NULL, '4308********7193', '717', 'FC-CKAZLKVN85', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Audrey+Savi&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-20 08:05:16', '2025-11-20 08:05:16', '2025-11-20 09:05:16', 1),
(115, 78, 'Sowanou', 'Sylvain', 'sowanousyl@gmail.com', '+2290166842969', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '439389', 0, 'Activé', '771457', 'Virement bancaire', NULL, NULL, NULL, NULL, '4967********4933', '161', 'FC-U89IFMYKSN', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Sylvain+Sowanou&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-20 08:25:44', '2025-11-20 08:25:44', '2025-11-20 09:25:44', 1),
(116, 70, 'Sandrina Carlo', 'Rosa', 'sandrinacarlo98@gmail.com', '+33 7 45 33 89 75', 'France (+33)', 'France rue marrion45', '€', 'fr', 700000.00, 700000.00, 0.00, 'Professionnel', '406942', 0, 'Examen', '716429', 'AXA banque', NULL, NULL, NULL, NULL, '4741********2167', '129', 'FC-AFHPDTGYAW', '1', '100', 'Vous venez de recevoir un virement bancaire de 700000 veillez consulter votre solde', 'comptes-photos/compte_691edd00e7c7a.jpg', 1, 1, 0, '2025-11-20 09:18:56', '2025-11-20 09:18:56', NULL, 0),
(117, 79, 'Joël', 'Joël', 'autogarantieversicherung@gmail.com', '+22960067966', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '142736', 0, 'Activé', '665950', 'Virement bancaire', NULL, NULL, NULL, NULL, '4386********8952', '473', 'FC-ADZVFE1WN3', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Jo%C3%ABl+Jo%C3%ABl&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-20 09:23:52', '2025-11-20 09:23:52', '2025-11-20 10:23:52', 1),
(118, 80, 'Antonio', 'Maniscalco', 'laboitedetabac@gmail.com', '+2290147536584', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '415902', 0, 'Activé', '394227', 'Virement bancaire', NULL, NULL, NULL, NULL, '4548********6890', '105', 'FC-IRSZSXXORO', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Maniscalco+Antonio&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-20 12:16:29', '2025-11-20 12:16:29', '2025-11-20 13:16:29', 1),
(119, 81, 'Alexis', 'Dautin', 'alexisedautin@gmail.com', '+22962133940', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '769029', 0, 'Activé', '442105', 'Virement bancaire', NULL, NULL, NULL, NULL, '4234********8206', '514', 'FC-WGDPALCDIB', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Dautin+Alexis&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-20 13:19:32', '2025-11-20 13:19:32', '2025-11-20 14:19:32', 1),
(120, 82, 'Soares Marque Da Silva', 'Fernando', 'fernandosoaresmarquedasilva@gmail.com', '229016588114', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '539688', 0, 'Activé', '688623', 'Virement bancaire', NULL, NULL, NULL, NULL, '4219********1553', '118', 'FC-J9HZ3J8T6Z', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Fernando+Soares+Marque+Da+Silva&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-20 17:53:35', '2025-11-20 17:53:35', '2025-11-20 18:53:35', 1),
(121, 83, 'Jean', 'Laurant', 'hospicehounwanou66@gmail.com', '+2290159253951', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10750.00, 10000.00, 0.00, 'Standard', '697731', 0, 'Activé', '421599', 'Virement bancaire', NULL, NULL, NULL, NULL, '4770********3178', '258', 'FC-F7ANHHE2JB', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Laurant+Jean&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-20 23:40:44', '2026-01-29 09:14:25', '2025-11-21 00:40:44', 1),
(122, 84, 'Maria', 'Adeline', 'Princessleonorofficial62@gmail.com', '2290158553191', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '501697', 0, 'Activé', '264505', 'Virement bancaire', NULL, NULL, NULL, NULL, '4911********1401', '675', 'FC-TKVOHQT8E2', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Adeline+Maria&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-21 00:57:06', '2025-11-21 00:57:06', '2025-11-21 01:57:06', 1),
(123, 85, 'Mino\'', 'Maria-rosa', 'mariarosapatriziam@gmail.com', '+2290166864988', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '329128', 0, 'Activé', '977250', 'Virement bancaire', NULL, NULL, NULL, NULL, '4608********4390', '357', 'FC-3NN57CRIVO', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Maria-rosa+Mino%27&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-21 07:18:21', '2025-11-21 09:51:57', '2025-11-21 08:18:21', 1),
(124, 60, 'OUEDRAOGO', 'Jack', 'floralalya4@gmail.com', '22676543890', 'Burkina Faso (+226)', 'Ouagadou Burkina Faso', 'XOF', 'fr', 0.00, 540000.00, 0.00, 'Professionnel', '200052', 0, 'Activé', '622493', 'Orabank', NULL, NULL, NULL, NULL, '4156********2934', '158', 'FC-XNVDABXYMQ', '1', '100', 'transfert effectué avec succès', NULL, 1, 0, 0, '2025-11-21 21:28:47', '2025-11-21 21:41:31', NULL, 0),
(130, 83, 'Daniele', 'martorelli', 'Danimartore@gmail.com', '3716667885', 'Italie (+39)', 'Italie', '€', 'it', 300000.00, 300000.00, 0.00, 'Professionnel', '162727', 0, 'Activé', '591941', 'BBVA', NULL, NULL, NULL, NULL, '4633********1255', '866', 'FC-8XWCAK1YNM', '1', '100', 'Vous avez reçu un\r\nVirement de 300000€', NULL, 1, 0, 0, '2025-11-24 21:00:41', '2025-11-24 21:00:41', NULL, 0),
(131, 83, 'Françoise', 'Dubois', 'marchiottomatteo70@gmail.com', '+33773827800', 'France (+33)', 'Bordeaux', '€', 'fr', 14000000.00, 14000000.00, 0.00, 'Professionnel', '215325', 0, 'Activé', '109388', 'BBVA', NULL, NULL, NULL, NULL, '4999********2895', '766', 'FC-TA2TITLF8W', '1', '100', 'Virement crédité', NULL, 1, 1, 0, '2025-11-24 21:14:06', '2025-11-24 21:14:06', NULL, 0),
(133, 84, 'Flores Llanque', 'Wilfredo Fredy', 'fisiologow@gmail.com', '+51912607770', 'Pérou (+51)', 'Perú puno', 'PEN', 'es', 44000.00, 44000.00, 0.00, 'Professionnel', '699182', 0, 'Activé', '469867', 'BBVA', NULL, NULL, NULL, NULL, '4179********9528', '668', 'FC-YG7GOVFWFY', '1', '100', 'Nota: Para retirar los fondos, debe activar la transferencia de 44.000 soles, ya que es una transferencia internacional. Comisión de activación: 2.800 soles.\r\nTransferencia completada con éxito el 24 de noviembre de 2025', NULL, 1, 1, 0, '2025-11-24 22:32:55', '2025-11-24 22:32:55', NULL, 0),
(134, 87, 'christophe', 'Lejeune', 'christophelejeune002@gmail.com', '+22953221824', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '386163', 0, 'Activé', '891930', 'Virement bancaire', NULL, NULL, NULL, NULL, '4451********4893', '628', 'FC-OMDNDK1UK3', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Lejeune+christophe&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-25 12:08:44', '2025-11-25 12:08:44', '2025-11-25 13:08:44', 1),
(135, 84, 'De la Croix', 'Michele', 'Micheledelacroix76@gmail.com', '+33 7 89 21 38 97', 'France (+33)', 'France,40 résidence les belles etentes', '€', 'fr', 0.00, 350000.00, 0.00, 'Professionnel', '154772', 0, 'Activé', '799501', 'CIC Banque', NULL, NULL, NULL, NULL, '4699********4759', '378', 'FC-TCQ6NT8LAX', '1', '100', 'Vous avez reçu 350 000 euros de la banque CIC sur votre compte n° Fr7630003007330005164149741 au nom de Michele de la Croix .\r\n\r\nFrais d\'activation pour créditer les fonds sur: 2800 euros.', NULL, 1, 1, 0, '2025-11-25 12:37:26', '2025-11-25 12:37:26', NULL, 0),
(136, 88, 'Dupont', 'Alice', 'estevedossou508@gmail.com', '+2290199609798', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '567409', 0, 'Activé', '663481', 'Virement bancaire', NULL, NULL, NULL, NULL, '4912********7875', '958', 'FC-MGVSCNQWPD', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Alice+Dupont&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-26 20:32:18', '2025-11-26 20:32:18', '2025-11-26 21:32:18', 1),
(137, 87, 'Germelis', 'Vilberds', 'vilberds61@gmail.com', '7784964577', 'Royaume-Uni (+44)', 'vilberds61@gmail.com', '€', 'en', 500000.00, 500000.00, 0.00, 'Professionnel', '389405', 0, 'Activé', '363064', 'Bannvale Credit Union', NULL, NULL, NULL, NULL, '4239********2756', '978', 'FC-FAOQVKB3IU', '1', '85', 'Please contact the bank manager to pay the activation fee which is 127 euros to obtain the activation codes for your transfer to be finalized', 'comptes-photos/compte_69299293800f9.jpg', 1, 1, 0, '2025-11-28 12:16:19', '2025-11-28 12:16:19', NULL, 0),
(138, 89, 'Thomas', 'Uriel', 'j7702471@gmail.com', '2290191137547', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10100.00, 10100.00, 0.00, 'Standard', '144417', 0, 'Activé', '427288', 'Virement bancaire', NULL, NULL, NULL, NULL, '4985********3469', '755', 'FC-ITXZYKICAJ', '1', '100', 'Transfert réussi', 'https://ui-avatars.com/api/?name=Uriel+Thomas&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-28 21:44:58', '2025-11-28 21:57:18', '2025-11-28 22:44:58', 1),
(139, 90, 'Bonnafé', 'Jean Laurent', 'scotiabank143@gmail.com', '+2290191635916', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 0.00, 10000.00, 0.00, 'Standard', '436230', 0, 'Bloqué', '281749', 'Virement bancaire', NULL, NULL, NULL, NULL, '4844********6723', '688', 'FC-6RLTQUQWTV', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Jean+Laurent+Bonnaf%C3%A9&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-28 22:05:21', '2025-12-16 19:44:11', '2025-11-28 23:05:21', 1),
(140, 60, 'ISIDORE', 'LALYA', 'candide730@gmail.com', '72547553', 'Espagne (+34)', 'Abomey - CAlavi, Tokan Aitchédji', '€', 'es', 0.00, 560300.00, 0.00, 'Professionnel', '203924', 0, 'Bloqué', '308054', 'SEPA', NULL, NULL, NULL, NULL, '4843********6845', '649', 'FC-WSKO5ZYLOM', '1', '100', 'Transfert échouer', 'comptes-photos/compte_692abe50c02bd.jpg', 1, 0, 0, '2025-11-29 09:35:12', '2026-01-21 17:57:13', NULL, 0),
(141, 91, 'DOUTCHECON', 'Tonny', 'freddyduvar32@gmail.com', '2290162905344', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '718606', 0, 'Activé', '850913', 'Virement bancaire', NULL, NULL, NULL, NULL, '4155********6356', '958', 'FC-Q8F42A9ZIR', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Tonny+DOUTCHECON&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-03 12:24:27', '2025-12-03 12:24:27', '2025-12-03 13:24:27', 1),
(145, 95, 'EZÉCHIEL', 'TCHOKPONHOUE', 'ezechieltchokponhoue@gmail.com', '+22960067966', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 0.00, 10000.00, 0.00, 'Standard', '269396', 0, 'Activé', '773827', 'Virement bancaire', NULL, NULL, NULL, NULL, '4261********5878', '841', 'FC-4D13WQ7S38', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=TCHOKPONHOUE+EZ%C3%89CHIEL&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-04 09:03:55', '2025-12-04 09:03:55', '2025-12-04 10:03:55', 1),
(147, 97, 'Fernando', 'Gomez', 'fernandogomez77@outlook.fr', '0198718457', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '562064', 0, 'Activé', '228764', 'Virement bancaire', NULL, NULL, NULL, NULL, '4871********2571', '591', 'FC-BBYRG85YXD', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Gomez+Fernando&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-04 13:41:27', '2025-12-04 13:41:27', NULL, 1),
(148, 98, 'Laurent', 'Louis', 'js233380@gmail.com', '+22960562519', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '321167', 0, 'Activé', '685551', 'Virement bancaire', NULL, NULL, NULL, NULL, '4172********2763', '548', 'FC-GDUSSPEQB2', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Louis+Laurent&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-04 19:46:41', '2025-12-04 19:46:41', NULL, 1),
(149, 99, 'PAPA', 'Kanfa', 'papapakanfa@gmail.com', '226053504648', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '610738', 0, 'Activé', '773900', 'Virement bancaire', NULL, NULL, NULL, NULL, '4462********7271', '681', 'FC-FLSFVTN8ZG', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Kanfa+PAPA&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-05 20:29:23', '2025-12-05 20:29:23', NULL, 1),
(150, 100, 'EWEN', 'Kiki', 'vistabank606@gmail.com', '0168748542', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 9800.00, 9800.00, 0.00, 'Standard', '265464', 0, 'Activé', '746656', 'Virement bancaire', NULL, NULL, NULL, NULL, '4909********3237', '739', 'FC-GSJUDDRKH6', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Kiki+EWEN&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-06 10:36:30', '2026-03-17 14:19:55', NULL, 1),
(151, 101, 'Hernandez', 'Jesus', 'joaogbeti92@gmail.com', '0169966025', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '717355', 0, 'Activé', '175619', 'Virement bancaire', NULL, NULL, NULL, NULL, '4292********7312', '582', 'FC-1SX7RWOQI4', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Jesus+Hernandez&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-12 09:22:39', '2025-12-12 09:22:39', NULL, 1),
(152, 70, 'CIRCA CHIRILA', 'Mircea Adrian', 'circachirilamirceaadrian@gmail.com', '+40 771 543 124', 'Roumanie (+40)', 'Arad, Arad, str. Turturicii Nr. 11, Romania', 'RON', 'ro', 50913.66, 50913.66, 0.00, 'Professionnel', '801443', 0, 'Examen', '334880', 'Sepa', NULL, NULL, NULL, NULL, '4968********2695', '827', 'FC-NVNDVJGMDV', '0', '100', 'Transfert effectué avec succès', 'comptes-photos/compte_693c39237b9e3.jpg', 1, 0, 0, '2025-12-12 15:47:47', '2025-12-12 15:47:47', NULL, 0),
(153, 90, 'Rocha', 'Jorge', 'jr.4049458@gmail.com', '14996766059', 'Brésil (+55)', 'Rua Geraldo José Silvestre 344 bairro Avare 1 cidade Avare SP.', 'R$', 'pt', 962775.00, 962775.00, 0.00, 'Professionnel', '408752', 0, 'Examen', '557424', 'SEPA', NULL, NULL, NULL, NULL, '4514********9296', '285', 'FC-AUMVCYLYVW', '0', '100', 'Transferência concluída com sucesso.', 'comptes-photos/compte_6941aef0cb9d2.jpg', 1, 1, 0, '2025-12-16 19:11:44', '2025-12-16 19:11:44', NULL, 0),
(154, 102, 'Jean Leaurent', 'Bonnafe', 'paribasbanquefinancebnp@gmail.com', '+22959361411', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '174754', 0, 'Activé', '742299', 'Virement bancaire', NULL, NULL, NULL, NULL, '4561********1934', '263', 'FC-D2SLLLOIFZ', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Bonnafe+Jean+Leaurent&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-16 19:43:13', '2025-12-16 19:43:13', NULL, 1),
(155, 70, 'MOTA MEDRANO', 'Karina Lisbet', 'Motamedranok@gmail.com', '+1 (829) 836-3205', 'République dominicaine (+1)', 'Calle Juan Pablo no.24', '$', 'es', 7633.27, 7633.27, 0.00, 'Professionnel', '825391', 0, 'Examen', '827365', 'Sepa', NULL, NULL, NULL, NULL, '4507********1351', '205', 'FC-3ZSU81YMAS', '0', '100', 'Transfert effectué avec succès', 'comptes-photos/compte_69455622da7b3.jpg', 1, 0, 0, '2025-12-19 13:41:54', '2025-12-19 13:41:54', NULL, 0),
(156, 90, 'Reshetnikov', 'Alexander', 'alix15dan@gmail.com', '9523961851', 'Russie (+7)', 'Petropavlovsk-Kamchatsky', '₽', 'ru', 62841835.00, 62841835.00, 0.00, 'Professionnel', '737745', 0, 'Examen', '177668', 'SEPA', NULL, NULL, NULL, NULL, '4301********1932', '305', 'FC-IHAQEYQN82', '0', '100', 'Перевод успешно завершен !', 'comptes-photos/compte_69469d2c42931.jpg', 1, 1, 0, '2025-12-20 12:57:16', '2025-12-20 12:57:16', NULL, 0),
(157, 103, 'Lil', 'Daryl', 'lildaryl726@gmail.com', '+2290154761259', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '521999', 0, 'Activé', '661145', 'Virement bancaire', NULL, NULL, NULL, NULL, '4252********1137', '383', 'FC-KMV9LDTUQO', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Daryl+Lil&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-20 19:40:50', '2025-12-20 22:43:42', NULL, 1),
(158, 103, 'VANDA', 'DA CRUZ CORREIA JORGE', 'vanda_jorge@hotmail.com', '920095725', 'Portugal (+351)', 'Rua José Afonso n9 4F código postal 2660-282 Santo António dos Cavaleiros', '€', 'pt', 2000.00, 2000.00, 0.00, 'Professionnel', '393103', 0, 'Activé', '540079', 'SEPA', NULL, NULL, NULL, NULL, '4817********7114', '309', 'FC-PVBOYVTMBJ', '2', '95', 'Estimado cliente\r\n\r\nLe informamos de que, a pesar del pago completo de todos los gastos relacionados con su solicitud de préstamo, la transferencia de fondos no se puede finalizar en esta etapa.\r\n\r\nDe hecho, el depósito de garantía, por un importe de 100 €, sigue pendiente de pago hasta la fecha. Este depósito es necesario para finalizar la seguridad de su préstamo y permitir la liberación de los fondos.\r\n\r\nLe invitamos a proceder al pago de esta garantía lo antes posible. Una vez recibido el depósito de garantía, el importe del préstamo se abonará inmediatamente en su cuenta.\r\n\r\nQuedamos a su disposición para cualquier información adicional.\r\n\r\nAtentamente,\r\n\r\nEl Servicio Financiero', NULL, 1, 1, 0, '2025-12-20 21:24:08', '2026-01-08 09:59:02', NULL, 0),
(159, 104, 'Eba', 'Benjamin', 'benjamineba237@icloud.com', '+237657161661', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '559876', 0, 'Activé', '573408', 'Virement bancaire', NULL, NULL, NULL, NULL, '4402********2367', '124', 'FC-6I2D98QTYV', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Benjamin+Eba&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-22 20:44:09', '2025-12-22 20:44:09', NULL, 1),
(160, 105, 'Chabani', 'Chabani', 'chabaniklk10@gmail.com', '+243899664449', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '356603', 0, 'Activé', '488807', 'Virement bancaire', NULL, NULL, NULL, NULL, '4621********6314', '622', 'FC-Y6LECKWB64', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Chabani+Chabani&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-22 21:02:47', '2025-12-22 21:02:47', NULL, 1),
(161, 106, 'Nnang', 'Moïse', 'Mkzveritable@gmail.com', '+24177189788', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '199225', 0, 'Activé', '654341', 'Virement bancaire', NULL, NULL, NULL, NULL, '4829********6950', '832', 'FC-WECPEDDNYP', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Mo%C3%AFse+Nnang&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-22 21:41:34', '2025-12-22 21:41:34', NULL, 1),
(162, 107, 'sompwe', 'ilunga', 'jeannymoise00@gmail.com', '+243987105111', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '985099', 0, 'Activé', '971723', 'Virement bancaire', NULL, NULL, NULL, NULL, '4447********7402', '970', 'FC-74JLT3FYIK', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=ilunga+sompwe&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-22 23:08:48', '2025-12-22 23:08:48', NULL, 1),
(163, 108, 'Phoba', 'Romain', 'romainphoba75@gmail.com', '+243993251905', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '857585', 0, 'Activé', '784878', 'Virement bancaire', NULL, NULL, NULL, NULL, '4444********4025', '225', 'FC-6BKK2OZQHE', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Romain+Phoba&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-23 00:53:29', '2025-12-23 00:53:29', NULL, 1),
(165, 110, 'Apash', 'Ash', 'apashash28@gmail.com', '+237655917668', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '282720', 0, 'Activé', '419775', 'Virement bancaire', NULL, NULL, NULL, NULL, '4834********4073', '515', 'FC-10GYAU19OZ', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Ash+Apash&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-23 06:35:30', '2025-12-23 06:35:30', NULL, 1),
(166, 111, 'ok', 'okkkkk', 'phishing@gmail.com', '+2777777777', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '909332', 0, 'Activé', '779204', 'Virement bancaire', NULL, NULL, NULL, NULL, '4240********1976', '904', 'FC-NHWEHR38MQ', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=okkkkk+ok&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-23 10:10:31', '2025-12-23 10:10:31', NULL, 1),
(167, 112, 'Fuck', 'You', 'hacker@ndumba.com', '+243900000000', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '411544', 0, 'Activé', '236155', 'Virement bancaire', NULL, NULL, NULL, NULL, '4307********3775', '831', 'FC-K01XQRVWC0', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=You+Fuck&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-23 10:55:47', '2025-12-23 10:55:47', NULL, 1),
(168, 113, 'Mukaya', 'israel', 'hacker@gmail.com', '+243900000000', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '360523', 0, 'Activé', '987077', 'Virement bancaire', NULL, NULL, NULL, NULL, '4697********8894', '315', 'FC-KGY37JYVCT', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=israel+Mukaya&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-23 10:56:44', '2025-12-23 10:56:44', NULL, 1),
(169, 114, 'Israel', 'Ntalu', 'israelntalu328@gmail.com', '+243900000000', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '625392', 0, 'Activé', '960751', 'Virement bancaire', NULL, NULL, NULL, NULL, '4638********5053', '696', 'FC-6WKJQVPQWN', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Ntalu+Israel&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-23 10:58:00', '2025-12-23 10:58:00', NULL, 1),
(170, 115, 'Whannou', 'Daniel', 'danielw@smileupplatform.com', '+22940592157', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '805136', 0, 'Activé', '678928', 'Virement bancaire', NULL, NULL, NULL, NULL, '4941********8816', '697', 'FC-YM218NBTFR', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Daniel+Whannou&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-23 13:18:03', '2025-12-23 13:18:03', NULL, 1),
(171, 116, 'Hollande', 'Marie Louise', 'topoat602@magim.be', '2290150095378', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '397811', 0, 'Activé', '413641', 'Virement bancaire', NULL, NULL, NULL, NULL, '4740********5600', '776', 'FC-MIYDPUK2DO', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Marie+Louise+Hollande&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-23 14:16:46', '2025-12-23 14:16:46', NULL, 1),
(172, 117, 'Glody', 'Maestro', 'maestroglody31@gmail.com', '0846790969', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '629766', 0, 'Activé', '405910', 'Virement bancaire', NULL, NULL, NULL, NULL, '4723********7396', '427', 'FC-SVBLJREJC9', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Maestro+Glody&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-23 17:55:16', '2025-12-23 17:55:16', NULL, 1),
(173, 118, 'GLODY', 'Maestro', 'maestroglody7@gmail.com', '+243846790969', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '169324', 0, 'Activé', '615202', 'Virement bancaire', NULL, NULL, NULL, NULL, '4125********6265', '366', 'FC-0FTLPBPTIB', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Maestro+GLODY&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-23 17:57:19', '2025-12-23 17:57:19', NULL, 1),
(174, 119, 'Hollande', 'Marie Louise', 'fedexexpresslagence7@gmail.com', '22950095378', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '677822', 0, 'Activé', '312852', 'Virement bancaire', NULL, NULL, NULL, NULL, '4456********2191', '236', 'FC-JPG53LTBNG', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Marie+Louise+Hollande&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-23 19:14:54', '2025-12-23 19:14:54', NULL, 1),
(175, 120, 'Kijoho', 'Raphaël', 'ubabanque.dg@gmail.com', '22942663596', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '116185', 0, 'Activé', '342572', 'Virement bancaire', NULL, NULL, NULL, NULL, '4225********7440', '840', 'FC-1VXBNJDY8G', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Rapha%C3%ABl+Kijoho&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-23 21:21:23', '2025-12-23 21:21:23', NULL, 1),
(176, 103, 'ANA PAULA', 'TRONCÃO SOARES', 'ap2838904@gmail.com', '917010548', 'Portugal (+351)', 'Rua Alves Redol lote 240 -8200-344 monte choro albufeira faro', '€', 'pt', 3595.00, 3595.00, 0.00, 'Professionnel', '654128', 0, 'Activé', '941421', 'SEPA', NULL, NULL, NULL, NULL, '4883********7966', '807', 'FC-ZBDBASNKVX', '1', '94', '⚠️ Transferência suspensa!\r\n\r\nSua transferência está atualmente suspensa. Uma vez que o motivo do seu empréstimo diz respeito ao pagamento do aluguel, um IVA de 5% é aplicável sobre o valor do empréstimo.\r\n\r\nCálculo: €3 500 × 5/100 = €175,00.\r\n\r\nPor favor, proceda ao pagamento deste valor (€175,00) para permitir a retomada imediata da transferência.', NULL, 1, 1, 0, '2025-12-24 10:45:51', '2026-01-03 18:47:31', NULL, 0),
(177, 121, 'Hollande', 'Marie Louise', 'tarpophow@cream.pink', '22950095378', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '343114', 0, 'Activé', '184416', 'Virement bancaire', NULL, NULL, NULL, NULL, '4526********1213', '210', 'FC-CYZOBHEVRS', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Marie+Louise+Hollande&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-25 23:36:29', '2025-12-25 23:36:29', NULL, 1),
(178, 122, 'Dupont', 'Henry', 'Idasodou@gmail.com', '2290146017212', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '825258', 0, 'Activé', '484547', 'Virement bancaire', NULL, NULL, NULL, NULL, '4446********9954', '863', 'FC-1AHHRTGCCZ', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Henry+Dupont&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-26 13:24:12', '2025-12-26 13:24:12', NULL, 1),
(179, 123, 'Crépin', 'Antoine', 'egideegide19@gmail.com', '22958826176', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '474232', 0, 'Activé', '181962', 'Virement bancaire', NULL, NULL, NULL, NULL, '4795********7948', '909', 'FC-KGL0ESDO80', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Antoine+Cr%C3%A9pin&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-26 13:28:30', '2025-12-26 13:28:30', NULL, 1),
(180, 124, 'Kmj', 'Dröm', 'emilykym614@gmail.com', '+22999856044', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '266157', 0, 'Activé', '781181', 'Virement bancaire', NULL, NULL, NULL, NULL, '4956********5863', '794', 'FC-SSU66AYVQ6', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Dr%C3%B6m+Kmj&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-26 21:11:19', '2025-12-26 21:11:19', NULL, 1),
(181, 125, 'Yemeli', 'Adeline', 'dreamsagencycontact0@gmail.com', '+237652455010', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '444436', 0, 'Activé', '757784', 'Virement bancaire', NULL, NULL, NULL, NULL, '4185********7255', '302', 'FC-TZXWWTMBTI', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Adeline+Yemeli&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-26 21:14:27', '2025-12-26 21:14:27', NULL, 1),
(182, 103, 'Quiñones', 'Obregón Rolando', 'rquinonesobregon@gmail.com', '623 72 97 43', 'Espagne (+34)', 'ciudad Barcelona ciudad San Feliu de guixols', '€', 'es', 25000.00, 25000.00, 0.00, 'Professionnel', '133433', 0, 'Activé', '639608', 'SEPA', NULL, NULL, NULL, NULL, '4431********5532', '764', 'FC-GBEFAWWOHB', '2', '50', 'TRANSFERENCIA SUSPENDIDA POR FALTA DE PAGO DE LOS GASTOS DE TRANSPORTE. PAGAR LA COMISIÓN DE TRANSACCIÓN PARA CONTINUAR CON SU TRANSACCIÓN. \r\n\r\n\r\nPÓNGASE EN CONTACTO CON SU PRESTADOR PARA MÁS INFORMACIÓN.\r\n\r\n  IMPUESTO A PAGAR: €290', NULL, 1, 1, 0, '2025-12-31 15:46:39', '2025-12-31 15:46:39', NULL, 0),
(183, 103, 'SÍLVIA CRISTINA', 'ROBALO DA SILVA', 'silvia.robalo2501@hotmail.com', '935723665', 'Portugal (+351)', 'ENDEREÇO ATUAL E CÓDIGO POSTAL 8005-456', '€', 'pt', 5005.00, 5005.00, 0.00, 'Professionnel', '436416', 0, 'Activé', '286875', 'SEPA', NULL, NULL, NULL, NULL, '4406********8819', '298', 'FC-MEGFGQVB5C', '1', '95', 'Antes da libertação do empréstimo, o cliente deve pagar as taxas referentes à formalização e ao registo do contrato.\r\n\r\nEstas taxas contratuais abrangem, nomeadamente, a formalização do acordo entre o cliente e o banco, o registo do contrato nos sistemas do banco, a validação legal do processo e a aplicação dos termos e condições gerais e específicos aplicáveis ​​ao empréstimo.\r\n\r\nO pagamento destas taxas torna o contrato plenamente válido, exequível e juridicamente vinculativo, condição essencial para a libertação dos fundos.\r\n\r\nApós a conclusão destas formalidades e o pagamento das taxas, o banco poderá proceder ao desembolso do montante do empréstimo, de acordo com os termos acordados.\r\n\r\nTAXAS A PAGAR:⚠️(€120)⚠️', NULL, 1, 1, 0, '2026-01-02 16:02:41', '2026-01-05 08:11:01', NULL, 0),
(184, 103, 'MARIA CARMEN', 'ESTEVAN CASTILLO', 'Estevancastillomaricarmen@gmail.com', '643138200', 'Espagne (+34)', 'Albixarres 30 casa 46600 alzira / Valencia', '€', 'es', 0.00, 603000.00, 0.00, 'Professionnel', '820581', 0, 'Activé', '689215', 'SEPA', NULL, NULL, NULL, NULL, '4868********5392', '652', 'FC-8ROBAFJBTV', '2', '100', 'Transferencia succesfuly', NULL, 1, 1, 0, '2026-01-10 12:43:58', '2026-01-12 18:17:34', NULL, 0),
(185, 126, 'VARLET', 'Olivier', 'oliviercavard33@gmail.com', '+15143123880', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 144000.00, 144000.00, 0.00, 'Standard', '550024', 0, 'Activé', '538401', 'Virement bancaire', NULL, NULL, NULL, NULL, '4134********9218', '421', 'FC-INTEFQJBDJ', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Olivier+VARLET&background=28a745&color=fff&size=50', 1, 0, 0, '2026-01-12 17:32:44', '2026-01-12 17:35:23', NULL, 1),
(186, 127, 'Smith', 'Espoir', 'smithespoir283@gmail.com', '+22963741328', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '655557', 0, 'Activé', '649161', 'Virement bancaire', NULL, NULL, NULL, NULL, '4762********4139', '569', 'FC-6XYKQHO2SA', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Espoir+Smith&background=28a745&color=fff&size=50', 1, 0, 0, '2026-01-20 09:38:35', '2026-01-20 09:38:35', NULL, 1),
(187, 90, 'Mendoza Joaquin', 'Carlos Eliseo', 'eliseomendoza@gmail.com', '78901689', 'El Salvador (+503)', 'El Salvador', '$', 'es', 750000.00, 750000.00, 0.00, 'Standard', '612599', 0, 'Examen', '859177', 'SEPA', NULL, NULL, NULL, NULL, '4912********1150', '662', 'FC-TKIDVOEZNG', '0', '99', 'Estimado señor, su transferencia ha fallado. Para más información, comuníquese con el banco que la inició. Gracias por su comprensión.', 'comptes-photos/compte_6970e67c7bbe7.jpg', 1, 1, 0, '2026-01-21 14:45:16', '2026-01-21 14:45:16', NULL, 0),
(188, 90, 'Mendoza', 'Carlos Eliseo Joaquín', 'eliseomendiza@gmail.com', '7890 1689', 'El Salvador (+503)', 'eliseomendiza@gmail.com', '$', 'es', 750000.00, 750000.00, 0.00, 'Standard', '144031', 0, 'Examen', '905712', 'SEPA', NULL, NULL, NULL, NULL, '4954********5596', '715', 'FC-U8QYI6FCBS', '0', '99', 'Transfert échoué. Veuillez contacter la banque émetteur du transfert pour avoir plus d’informations et régler le problème', 'comptes-photos/compte_6974db9303162.jpg', 1, 1, 0, '2026-01-24 14:47:47', '2026-01-24 14:47:47', NULL, 0),
(189, 128, 'Molina', 'Angel lopez', 'angelalopezmolina55@gmail.com', '2290152454486', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '805732', 0, 'Activé', '805035', 'Virement bancaire', NULL, NULL, NULL, NULL, '4935********3196', '187', 'FC-YIPZAOMJCR', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Angel+lopez+Molina&background=28a745&color=fff&size=50', 1, 0, 0, '2026-01-29 06:58:25', '2026-01-29 06:58:25', NULL, 1),
(190, 128, 'MIGUEL BARNILS', 'Fernando', 'ferran.orbe@gmail.com', '+34 655 12 30 07', 'France (+33)', 'Cerdanyola del V Vallés. (08290) Barcelona', '€', 'es', 750000.00, 750000.00, 0.00, 'Professionnel', '160692', 0, 'Activé', '140977', 'SEPA', NULL, NULL, NULL, NULL, '4979********4706', '446', 'FC-PPFXWFTIQD', '0', '100', 'Monsieur Fernando, nous vous confirmons avoir reçu sur votre compte un virement bancaire de 750.000 euros de Bancodeespana en date de 29/01/2026 provenant de l\'assurance vie', 'comptes-photos/compte_697b2aa98d115.jpg', 1, 1, 0, '2026-01-29 09:38:49', '2026-01-29 09:49:41', NULL, 0),
(191, 129, 'Soltani', 'Rachid', 'diagonaleroger@gmail.com', '2290194600300', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '684424', 0, 'Activé', '827963', 'Virement bancaire', NULL, NULL, NULL, NULL, '4861********7418', '868', 'FC-QLEAKROKCR', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Rachid+Soltani&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-04 20:17:11', '2026-02-04 20:17:11', NULL, 1),
(192, 130, 'Buberl', 'Thomas', 'pepesoymillonario8@gmail.com', '0193943596', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '394438', 0, 'Activé', '205492', 'Virement bancaire', NULL, NULL, NULL, NULL, '4358********6907', '477', 'FC-XFW2ULXLG9', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Thomas+Buberl&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-05 09:48:26', '2026-02-05 09:48:26', NULL, 1),
(193, 100, 'N\'DOLI', 'Kouame François', 'jesushandoli@gmail.com', '+2250707908975', 'Côte d’Ivoire (+225)', 'Yamoussoukro', 'XOF', 'fr', 0.00, 0.00, 0.00, 'Standard', '843328', 0, 'Examen', '696148', 'SWIFT', NULL, NULL, NULL, NULL, '4467********2567', '888', 'FC-0YYTROZWTA', '1', '100', 'Transfert de 7 millions effectué avec succès.', NULL, 1, 0, 0, '2026-02-06 14:50:33', '2026-03-17 14:17:56', NULL, 0),
(194, 131, 'Justice', 'Divine', 'justicedivine99933@gmail.com', '+2260150593218', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '927534', 0, 'Activé', '669660', 'Virement bancaire', NULL, NULL, NULL, NULL, '4949********5089', '251', 'FC-4VQOCKGGZ9', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Divine+Justice&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-12 09:57:27', '2026-02-12 09:57:27', NULL, 1),
(195, 132, 'Sossou', 'Benjamin', 'sossoubenjamin937@gmail.com', '+22999578404', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '345241', 0, 'Activé', '110773', 'Virement bancaire', NULL, NULL, NULL, NULL, '4818********9339', '959', 'FC-ZY8OJEFJ43', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Benjamin+Sossou&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-13 14:14:36', '2026-02-13 14:14:36', NULL, 1),
(196, 90, 'Kruszewski', 'Daniel', 'karolina-biesik660@wp.pl', '723829597', 'Pologne (+48)', 'Jasne 7, Dzierzgoń, Pologne', 'zł', 'pl', 1180296.60, 1180296.60, 0.00, 'Standard', '303362', 0, 'Activé', '306874', 'SEPA', NULL, NULL, NULL, NULL, '4224********3845', '870', 'FC-VWSZHP4FTL', '0', '63', 'Szanowny Kliencie, z przykrością informujemy, że przelew zainicjowany niedawno na Twoją korzyść nie mógł zostać zrealizowany. Po weryfikacji okazało się, że Twoje konto bankowe nie posiada obecnie wymaganych parametrów ani limitów, aby otrzymać pełną kwotę środków. W związku z tym transakcja została automatycznie odrzucona przez nasz system bezpieczeństwa.\r\nZachęcamy do kontaktu z bankiem, który zainicjował przelew, w celu zwiększenia możliwości odbioru środków na koncie lub uzyskania dalszych informacji na ten temat. Dziękujemy.', 'comptes-photos/compte_699475ecce247.jpg', 1, 1, 0, '2026-02-17 14:06:36', '2026-02-25 08:59:45', NULL, 0),
(197, 90, 'GELŽINIENĖ', 'NÉRINGA', 'neringa.brazdziuniene@gmail.com', '67046803', 'Lituanie (+370)', 'Klevus rue 25, Keravos km. Velži sen, Panevezys', '€', 'lt', 490000.00, 490000.00, 0.00, 'Standard', '112677', 0, 'Examen', '391172', 'SEPA', NULL, NULL, NULL, NULL, '4134********3700', '462', 'FC-SLXHSHORIJ', '0', '100', 'Norėdami gauti atsakymą, parašykite bankui, kuris apdorojo pavedimą. Dėkojame už supratingumą!', 'comptes-photos/compte_6994970e1b8a6.jpg', 1, 1, 0, '2026-02-17 16:27:58', '2026-02-19 14:04:43', NULL, 0),
(198, 133, 'ADJOVI', 'Ghislain', 'ghislainadjovi6@gmail.com', '2290164141728', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '254828', 0, 'Activé', '842084', 'Virement bancaire', NULL, NULL, NULL, NULL, '4825********5551', '622', 'FC-FRJHT9DAUU', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Ghislain+ADJOVI&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-19 19:22:37', '2026-02-19 19:22:37', NULL, 1),
(199, 134, 'Sawadoga', 'Roger', 'sawadogaroger02@gmail.com', '+22955771656', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '524711', 0, 'Activé', '738079', 'Virement bancaire', NULL, NULL, NULL, NULL, '4440********5265', '228', 'FC-OYAZZTTTCZ', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Roger+Sawadoga&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-21 08:47:34', '2026-02-21 08:47:34', NULL, 1),
(200, 135, 'Jean', 'Veil', 'jeanviel631@gmail.com', '2290153655565', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '424911', 0, 'Activé', '656695', 'Virement bancaire', NULL, NULL, NULL, NULL, '4851********6721', '409', 'FC-ZOWVWZOUSF', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Veil+Jean&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-23 17:51:17', '2026-02-23 17:51:17', NULL, 1),
(201, 136, 'Dedeyan', 'Stéphane', 'gedeonlate545@gmail.com', '+22960046025', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '107613', 0, 'Activé', '597242', 'Virement bancaire', NULL, NULL, NULL, NULL, '4623********5027', '732', 'FC-8VR6MS09OC', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=St%C3%A9phane+Dedeyan&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-25 09:10:44', '2026-02-25 09:10:44', NULL, 1),
(202, 137, 'Robinson Fluit', 'Mark', 'procarmelo51@gmail.com', '22991217069', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '682741', 0, 'Activé', '207730', 'Virement bancaire', NULL, NULL, NULL, NULL, '4924********2808', '936', 'FC-TPSSPT72PY', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Mark+Robinson+Fluit&background=28a745&color=fff&size=50', 1, 0, 0, '2026-03-04 19:34:02', '2026-03-04 19:34:02', NULL, 1),
(203, 138, 'Horváth', 'Marie', 'mariehorváth443@gmail.com', '99490517', 'Bénin-City', 'Cotonou-Bénin', '€', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '593540', 0, 'Activé', '320998', 'Virement bancaire', NULL, NULL, NULL, NULL, '4743********7206', '713', 'FC-BBNLHPL9VF', '0', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Marie+Horv%C3%A1th&background=28a745&color=fff&size=50', 1, 0, 0, '2026-03-17 01:39:27', '2026-03-21 09:17:29', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `credit_audits`
--

CREATE TABLE `credit_audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `compte_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action_type` varchar(255) NOT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `credits_before` bigint(20) UNSIGNED DEFAULT NULL,
  `credits_after` bigint(20) UNSIGNED DEFAULT NULL,
  `change` bigint(20) DEFAULT NULL,
  `reference_type` varchar(255) DEFAULT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `dismissed_alerts`
--

CREATE TABLE `dismissed_alerts` (
  `id` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `alert_type` varchar(50) NOT NULL,
  `alert_id` varchar(128) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `email_extractor_history`
--

CREATE TABLE `email_extractor_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `separator` varchar(32) NOT NULL,
  `result_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `emails` text NOT NULL,
  `source_preview` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

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
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mail_history`
--

CREATE TABLE `mail_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `expediteur` varchar(255) NOT NULL,
  `destinataire` varchar(255) NOT NULL,
  `objet` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `adresse_reponse` varchar(255) DEFAULT NULL,
  `fichier_joint` varchar(255) DEFAULT NULL,
  `credits_used` int(11) NOT NULL DEFAULT 0,
  `status` enum('Envoyé','Livré','Rejeté','Ouvert') DEFAULT 'Envoyé',
  `opened_at` timestamp NULL DEFAULT NULL,
  `open_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `message_id` varchar(255) DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `mail_history`
--

INSERT INTO `mail_history` (`id`, `user_id`, `expediteur`, `destinataire`, `objet`, `contenu`, `adresse_reponse`, `fichier_joint`, `credits_used`, `status`, `opened_at`, `open_count`, `message_id`, `error_message`, `created_at`, `updated_at`) VALUES
(1, 60, 'TRANSFERFLUx', 'lalyaisidore@gmail.com', 'Inscription', '<p>C\'est partie</p>', NULL, 'mail_attachments/7pFlvUchJG86mcbGRTuuU4m81zHBIuJ44obNmswO.pdf', 2000, 'Envoyé', NULL, 0, 'MAIL_59ec5998-ea5a-4d53-abce-b33364ead454', NULL, '2025-12-01 16:01:50', '2025-12-01 16:01:50'),
(2, 60, 'ISIDORE LALYA', 'lalyaisidore@gmail.com', 'Essaie', '<p>Bonjour Madame c’est Monsieur <span style=\"background-color: rgb(255, 255, 0);\"><b>Madame</b>&nbsp;</span></p>', NULL, NULL, 1000, 'Ouvert', '2025-12-02 23:23:55', 1, 'MAIL_ee4c6ff3-3d87-4589-b1e7-ac726ace6001', NULL, '2025-12-02 23:22:49', '2025-12-02 23:23:55'),
(3, 60, 'PAPA TRÉSOR', 'assoulolo94@gmail.com', 'Mail d’essais', '<p>C’est moi papa trésor qui <span style=\"background-color: rgb(255, 255, 0);\">voulais</span> t’envoyer un mail pro privé&nbsp;</p><ol><li>Je ne sais pas si tu sais le faire</li><li style=\"text-align: left;\">Ou je ne sais plus&nbsp;</li></ol><table class=\"table table-bordered\"><tbody><tr><td><br></td><td><br></td></tr><tr><td><br></td><td><br></td></tr><tr><td><br></td><td><br></td></tr><tr><td><br></td><td><br></td></tr></tbody></table><ol><br></ol>', NULL, NULL, 1000, 'Ouvert', '2025-12-03 12:58:51', 2, 'MAIL_51838a4c-d736-4a0e-afd7-33bd652518f9', NULL, '2025-12-03 12:58:48', '2025-12-03 13:00:09'),
(4, 60, 'BANK OF AFRICA', 'lalyaisidore@gmail.com', 'Demande de virement', '<p>Je suis là banque 🏦 centrale de France 🇫🇷 africaine jdkkfkfl</p><ol><li>Je ne sais pas&nbsp;</li><li>Aucune demaine</li><li><a href=\"http://https//flashbilan.fR\" target=\"_blank\">Cliquer ici pour rejoindre notre site</a></li><li><span style=\"font-family: Impact;\">Holà&nbsp;</span><br></li></ol>', NULL, NULL, 1000, 'Ouvert', '2025-12-03 13:05:59', 6, 'MAIL_5cafb1cf-38d8-4261-97c0-03fd3ab82494', NULL, '2025-12-03 13:05:57', '2025-12-03 17:35:41'),
(5, 60, 'BANK OF AFRICA', 'lalyaisidore@gmail.com', 'Demande de virement', '<p>Je suis là <b><i>banque</i></b> de <span style=\"background-color: rgb(255, 255, 0);\">France</span> 🇫🇷&nbsp;<span style=\"font-family: Impact;\"><br></span></p><p><span style=\"font-family: Impact;\">C’est la banque postale</span></p>', NULL, 'mail_attachments/9Hlr6ivMdQs7WKHPMPaYNbzwQajMMth0oZFkrGth.jpg', 2000, 'Ouvert', '2025-12-15 17:07:05', 3, 'MAIL_3512083a-bd6e-4beb-ad07-d71fe650c956', NULL, '2025-12-15 17:07:02', '2025-12-15 17:07:51');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_05_25_092626_create_comptes_table', 1),
(5, '2024_06_01_202859_create_virements_table', 1),
(6, '2024_06_01_210224_create_transfers_table', 1),
(7, '2024_06_01_210745_create_unlock_codes_table', 1),
(8, '2024_06_03_232415_create_remboursements_table', 1),
(9, '2024_06_06_222459_create_transaction_histories_table', 1),
(10, '2024_06_09_094629_create_sub_account_sessions_table', 1),
(11, '2025_11_01_000001_add_credit_user_to_users_table', 2),
(12, '2025_11_02_000000_add_is_default_to_comptes_table', 3),
(13, '2025_11_02_000001_add_alert_columns_to_comptes_table', 4),
(14, '2025_11_03_064607_create_affiliations_table', 5),
(15, '2025_11_03_064748_create_commissions_table', 5),
(16, '2025_11_03_065133_add_affiliation_to_users_table', 5),
(17, '2025_11_03_081823_create_recharge_transactions_table', 6),
(18, '2025_11_03_101510_create_retraits_table', 7),
(19, '2025_11_03_120000_add_credits_to_comptes_table', 8),
(20, '2025_11_03_000001_add_public_token_to_comptes_table', 9),
(21, '2025_11_04_000000_add_photo_path_to_comptes_table', 10),
(22, '2025_11_05_000000_add_compte_id_to_transaction_histories_table', 11),
(23, '2025_11_05_000002_add_numerocompte_to_comptes_table', 12),
(24, '2025_11_06_000000_create_recharge_histories_table', 13),
(25, '2025_11_06_000001_create_credit_audits_table', 13),
(26, '2025_11_06_000002_add_phone_to_users_table', 14),
(27, '2025_11_06_000003_add_compte_id_to_transaction_histories', 15),
(28, '2025_11_06_155445_update_transaction_histories_make_compte_id_required', 16),
(29, '2025_11_07_163330_add_auto_deletes_at_to_comptes_table', 17),
(30, '2025_11_07_180000_add_compte_id_to_transfers_table', 18),
(31, '2025_11_07_182000_add_compte_id_inferred_to_transfers_table', 19),
(32, '2025_11_09_100000_create_support_tables', 20),
(33, '2025_11_10_120000_add_attachments_to_support_messages', 21),
(34, '2025_11_10_171351_add_columns_to_unlock_codes_table', 22),
(35, '2025_11_10_171607_make_transfer_id_nullable_in_unlock_codes', 23),
(36, '2025_11_11_000001_update_retraits_table_add_new_operators', 24),
(37, '2025_11_11_001329_update_retraits_table_add_new_operators', 24),
(38, '2025_11_11_002000_add_withdrawal_statuses_to_commissions', 25),
(39, '2025_11_12_000000_add_code_virement_utilise_to_comptes_table', 26),
(40, '2025_11_26_000001_add_numerocompte_to_comptes_table', 27),
(41, '2025_11_26_000002_add_photo_path_to_comptes_table', 27),
(42, '2025_11_26_123000_add_transfer_id_to_transaction_histories_table', 27),
(43, '2025_11_27_000000_modify_failure_message_in_comptes', 27),
(44, '2025_12_01_102443_create_sms_history_table', 27),
(45, '2025_12_01_122032_update_sms_history_status_enum', 28),
(46, '2025_12_01_124136_add_envoye_status_to_sms_history', 29),
(47, '2025_12_01_131840_create_mail_history_table', 30),
(48, '2025_12_01_150000_add_open_tracking_to_mail_history', 31),
(49, '2025_12_01_160000_create_url_shortener_history_table', 31),
(50, '2025_12_01_160500_create_url_verifications_table', 31),
(51, '2025_12_01_170000_create_email_extractor_history_table', 32);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('durandfranck249@gmail.com', '$2y$12$RnlFSHQcGq2mFtlDJBeKKu2r3rT0VNVeUNbMsWjED0S8fjyi8Drau', '2025-11-20 08:32:19'),
('fedexexpresslagence7@gmail.com', '$2y$12$DduBZQs.YyJgIWA4e8WGAuNZ0CYlClZLPRMKhLTENPy/pAAuzy5ei', '2025-12-25 23:12:14'),
('j7702471@gmail.com', '$2y$12$KIsCuflR2yWjgv.jpw56r.PIUtaj8J./ISuDm9j/UPNrXDhvJn5.e', '2025-12-10 19:03:14'),
('lalyaisidore@gmail.com', '$2y$12$MTzJl9jEsJIwoC9XsgCb6uZAc/.ABCPQuOYN3E.RpNO45t26KFB3W', '2025-11-13 12:15:54'),
('Mkzveritable@gmail.com', '$2y$12$1BIyGl/MsNAzvdKHX.v2uuyyXzQy5FonYKjJ5Dvaq/gdQq9n3T63m', '2025-12-22 21:41:53');

-- --------------------------------------------------------

--
-- Structure de la table `recharge_histories`
--

CREATE TABLE `recharge_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `compte_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `devise` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recharge_transactions`
--

CREATE TABLE `recharge_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `compte_id` bigint(20) UNSIGNED DEFAULT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `recharge_transactions`
--

INSERT INTO `recharge_transactions` (`id`, `user_id`, `compte_id`, `transaction_id`, `amount`, `credits_earned`, `payment_method`, `payment_provider`, `status`, `external_transaction_id`, `payment_details`, `response_data`, `failure_reason`, `completed_at`, `created_at`, `updated_at`) VALUES
(55, 84, 122, 'RC8WG91HKV1763686818', 10000.00, 15000, 'mobile_money', 'fedapay', 'completed', '107602391', NULL, '{\"fedapay_id\":107602391,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzYwMjM5MSwiZXhwIjoxNzYzNzczMjIxfQ.um2rGR0ZOgfDI7faMPPjR4C7NvM__JY_lMJvJtcMoe8\"}', NULL, '2025-11-22 12:42:44', '2025-11-21 01:00:18', '2025-11-22 12:42:44'),
(56, 85, 123, 'RC8L4N7RCJ1763719169', 5000.00, 5000, 'fedapay', 'fedapay', 'pending', '107606521', NULL, '{\"fedapay_id\":107606521,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzYwNjUyMSwiZXhwIjoxNzYzODA1NTcyfQ.D-L-aPwoGtyhbnXRqpwOp188FEpP8SRNJZ7Gp0ysyuA\"}', NULL, NULL, '2025-11-21 09:59:29', '2025-11-21 09:59:31'),
(57, 85, 123, 'RCF2J4ORVD1763719192', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '107606529', NULL, '{\"fedapay_id\":107606529,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzYwNjUyOSwiZXhwIjoxNzYzODA1NTk2fQ.uplqEY3i3YAhLM2XckgSoFuU7jks4pm66V9iRpHSOAE\"}', NULL, NULL, '2025-11-21 09:59:52', '2025-11-21 09:59:54'),
(92, 88, 136, 'RCRDZLVTVX1764190125', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '107701725', NULL, '{\"fedapay_id\":107701725,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzcwMTcyNSwiZXhwIjoxNzY0Mjc2NTI5fQ.huIeaxnMUilo-ceLX8wpxYRv9VLEQNwVd3YT-j14ch0\"}', NULL, NULL, '2025-11-26 20:48:45', '2025-11-26 20:48:46'),
(93, 88, 136, 'RCX2SXGGI91764190258', 5000.00, 5000, 'fedapay', 'fedapay', 'pending', '107701764', NULL, '{\"fedapay_id\":107701764,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzcwMTc2NCwiZXhwIjoxNzY0Mjc2NjYyfQ.0mjouMCFMYyF6ZqSGLvoM2Y5nDbGqFQFibEucZnQlHk\"}', NULL, NULL, '2025-11-26 20:50:58', '2025-11-26 20:50:59'),
(95, 83, 121, 'RCRZXZ2V331764190337', 10000.00, 15000, 'mobile_money', 'fedapay', 'pending', '107701794', NULL, '{\"fedapay_id\":107701794,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzcwMTc5NCwiZXhwIjoxNzY0Mjc2NzQwfQ.gZ5jqODMFxVpcrFt36PaPwFp-oIyIGc0xlpEEb-z1gM\"}', NULL, NULL, '2025-11-26 20:52:17', '2025-11-26 20:52:18'),
(98, 87, 134, 'RC2L7WX9DB1764331821', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '107730844', NULL, '{\"fedapay_id\":107730844,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzczMDg0NCwiZXhwIjoxNzY0NDE4MjI1fQ.Wzc7zlEaKPXITFkn6es9PoM29TtDtgXeGPEaVpa7wY8\"}', NULL, '2025-11-28 12:11:39', '2025-11-28 12:10:21', '2025-11-28 12:11:39'),
(100, 89, 138, 'RCRYM2TZXN1764367098', 5000.00, 5000, 'fedapay', 'fedapay', 'failed', '107740853', NULL, '{\"fedapay_id\":107740853,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzc0MDg1MywiZXhwIjoxNzY0NDUzNTAyfQ.MSTZ0rOJRoEjj48JMliQKOiIzrg3zanpisfMQQ39KwQ\"}', 'Payment canceled/declined by user (redirect)', NULL, '2025-11-28 21:58:18', '2025-11-28 21:58:37'),
(104, 60, 93, 'RCPSAAVMSI1764661485', 10000.00, 15000, 'fedapay', 'fedapay', 'failed', '107795835', NULL, '{\"fedapay_id\":107795835,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzc5NTgzNSwiZXhwIjoxNzY0NzQ3ODk0fQ.nS6qu2N3ZlIJbosmP9ZmOgDFa6WWq26j8_eKb2jEhd0\"}', 'Payment canceled/declined by user (redirect)', NULL, '2025-12-02 06:44:45', '2025-12-02 06:44:57'),
(105, 60, 93, 'RCXXQ2TKK01764783018', 5000.00, 5000, 'mobile_money', 'fedapay', 'failed', '107827737', NULL, '{\"fedapay_id\":107827737,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzgyNzczNywiZXhwIjoxNzY0ODY5NDIyfQ.21jBwfeIy1JjRbqfVEypZDW2a3ihkH8-qQ2Pi7qtLvM\"}', 'Payment canceled/declined by user (redirect)', NULL, '2025-12-03 17:30:18', '2025-12-03 17:31:35'),
(106, 60, 93, 'RCCTDN0IVJ1765818593', 5000.00, 5000, 'mobile_money', 'fedapay', 'failed', '108065575', NULL, '{\"fedapay_id\":108065575,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODA2NTU3NSwiZXhwIjoxNzY1OTA0OTk4fQ.nnpv6kMiqll2y5WAd5HH4haNCtY6KoNPhMfN1aWeFng\"}', 'Payment canceled/declined by user (redirect)', NULL, '2025-12-15 17:09:53', '2025-12-15 17:10:56'),
(107, 90, 139, 'RCOHQXVNOV1765887248', 5000.00, 5000, 'mobile_money', 'fedapay', 'failed', '108080212', NULL, '{\"fedapay_id\":108080212,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODA4MDIxMiwiZXhwIjoxNzY1OTczNjUzfQ.aFMd1LKAejF6re1zPgNVjZq4k8_pBuxmEZUHVMigu7A\"}', 'Payment canceled/declined by user (redirect)', NULL, '2025-12-16 12:14:08', '2025-12-16 12:14:33'),
(108, 90, 139, 'RCRVLRIX8Q1765887352', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '108080243', NULL, '{\"fedapay_id\":108080243,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODA4MDI0MywiZXhwIjoxNzY1OTczNzU3fQ.yB-0p0uZC3xMBByLt8n-p1dvYDXZpZq8wOL46CEYwXI\"}', NULL, '2025-12-16 12:17:25', '2025-12-16 12:15:52', '2025-12-16 12:17:25'),
(109, 102, 154, 'RC1OQYQ5NO1765914397', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108088917', NULL, '{\"fedapay_id\":108088917,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODA4ODkxNywiZXhwIjoxNzY2MDAwODAyfQ.ZYcIyy3aiKoVQS1qAKiGnkVvoJVKUkmBAyIlFo_pdwk\"}', NULL, NULL, '2025-12-16 19:46:37', '2025-12-16 19:46:38'),
(110, 90, 139, 'RCTSJEGKHJ1766233925', 5000.00, 5000, 'fedapay', 'fedapay', 'pending', '108163191', NULL, '{\"fedapay_id\":108163191,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODE2MzE5MSwiZXhwIjoxNzY2MzIwMzMxfQ.AFWS41jMfeRNEonOp8BZ7-SrLSUXxgHniXqw0pJn5CE\"}', NULL, NULL, '2025-12-20 12:32:05', '2025-12-20 12:32:07'),
(111, 90, 139, 'RCQ3ONKTCE1766233968', 5000.00, 5000, 'fedapay', 'fedapay', 'pending', '108163207', NULL, '{\"fedapay_id\":108163207,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODE2MzIwNywiZXhwIjoxNzY2MzIwMzczfQ.H_xh6WmSLys9PgdDUZYbl8yY2ivx7JagwebliNL6_Hk\"}', NULL, NULL, '2025-12-20 12:32:48', '2025-12-20 12:32:49'),
(112, 90, 139, 'RCCL30QS9E1766234094', 5000.00, 5000, 'fedapay', 'fedapay', 'completed', '108163253', NULL, '{\"fedapay_id\":108163253,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODE2MzI1MywiZXhwIjoxNzY2MzIwNTAwfQ.x8bMxqvDISU66z9CVz1vMgR_bguYDFYQw3Wg2fUdtZI\"}', NULL, '2025-12-20 12:36:10', '2025-12-20 12:34:54', '2025-12-20 12:36:10'),
(113, 103, 157, 'RCK9SGV9YJ1766265295', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '108174175', NULL, '{\"fedapay_id\":108174175,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODE3NDE3NSwiZXhwIjoxNzY2MzUxNzAxfQ.5igwO6X6Ktd_SCU-9n-VhMHETA7LyGEkG0f7CjwWk0w\"}', NULL, '2025-12-20 21:16:01', '2025-12-20 21:14:55', '2025-12-20 21:16:01'),
(114, 104, 159, 'RCG1BSGI801766436391', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108213962', NULL, '{\"fedapay_id\":108213962,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxMzk2MiwiZXhwIjoxNzY2NTIyNzk3fQ.OKvkNDrxg33hltdQNuhNTT8m9BebvdANnZaCPdBGlZs\"}', NULL, NULL, '2025-12-22 20:46:31', '2025-12-22 20:46:32'),
(115, 106, 161, 'RC8GYG7UEG1766439909', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108215347', NULL, '{\"fedapay_id\":108215347,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNTM0NywiZXhwIjoxNzY2NTI2MzE1fQ.MDg7nFGulbDs_IVrGHNPVDmE8U6R2e5tghOHsqQFtT0\"}', NULL, NULL, '2025-12-22 21:45:09', '2025-12-22 21:45:10'),
(116, 106, 161, 'RCPEX9GVFF1766439923', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108215352', NULL, '{\"fedapay_id\":108215352,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNTM1MiwiZXhwIjoxNzY2NTI2MzI5fQ.5CkyCAljBV6fCtER1Rg7YHdbJ-mXq5hFlmfu0ZoquS8\"}', NULL, NULL, '2025-12-22 21:45:23', '2025-12-22 21:45:24'),
(117, 107, 162, 'RCNI6VYO4B1766445450', 5000.00, 5000, 'fedapay', 'fedapay', 'pending', '108217094', NULL, '{\"fedapay_id\":108217094,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNzA5NCwiZXhwIjoxNzY2NTMxODU2fQ.ZR69zLIFSeFkSEbnQxeD0s2BiRST7KwNCECGwEUeyM8\"}', NULL, NULL, '2025-12-22 23:17:30', '2025-12-22 23:17:31'),
(118, 107, 162, 'RCGVLNUWO41766445464', 5000.00, 5000, 'fedapay', 'fedapay', 'pending', '108217095', NULL, '{\"fedapay_id\":108217095,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNzA5NSwiZXhwIjoxNzY2NTMxODcwfQ.mauoEK84maN9AyNxlNVwuwFP8YxMgVZXY--TBsDpQWw\"}', NULL, NULL, '2025-12-22 23:17:44', '2025-12-22 23:17:46'),
(119, 107, 162, 'RCYOIXAML81766445474', 5000.00, 5000, 'fedapay', 'fedapay', 'pending', '108217098', NULL, '{\"fedapay_id\":108217098,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNzA5OCwiZXhwIjoxNzY2NTMxODgwfQ.6qwP9QZ-UxcGqGexn7Qn-_lgNOGkv4bc8zULCAeKrG8\"}', NULL, NULL, '2025-12-22 23:17:54', '2025-12-22 23:17:55'),
(120, 107, 162, 'RCRL4PPGFJ1766445478', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108217101', NULL, '{\"fedapay_id\":108217101,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNzEwMSwiZXhwIjoxNzY2NTMxODg0fQ.Qk7nwhaJq2RgF7498kDgX1pYTFm6em2TEhXJxnys-n8\"}', NULL, NULL, '2025-12-22 23:17:58', '2025-12-22 23:18:00'),
(121, 107, 162, 'RCWQD3YZRR1766445481', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108217102', NULL, '{\"fedapay_id\":108217102,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNzEwMiwiZXhwIjoxNzY2NTMxODg3fQ.yVvdUrrjkyY3l1bU78iATewCj415yZZFTDShdqkYZdQ\"}', NULL, NULL, '2025-12-22 23:18:01', '2025-12-22 23:18:02'),
(122, 107, 162, 'RCHIPRW5841766445484', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108217104', NULL, '{\"fedapay_id\":108217104,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNzEwNCwiZXhwIjoxNzY2NTMxODg5fQ.jGcNj8OFSDmVwaHwyoSXYzgdj3-bt_FXYAddJTQMd5E\"}', NULL, NULL, '2025-12-22 23:18:04', '2025-12-22 23:18:05'),
(123, 107, 162, 'RC7ST4VR8R1766445486', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108217107', NULL, '{\"fedapay_id\":108217107,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNzEwNywiZXhwIjoxNzY2NTMxODkyfQ.rjTDpAju_blpOLf4uX6VojygKGsHa8FcMZxwMwP7cwY\"}', NULL, NULL, '2025-12-22 23:18:06', '2025-12-22 23:18:07'),
(124, 107, 162, 'RCFZCBECV61766445507', 10000.00, 15000, 'fedapay', 'fedapay', 'pending', '108217113', NULL, '{\"fedapay_id\":108217113,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNzExMywiZXhwIjoxNzY2NTMxOTEzfQ.jywBSkHOO9nslRLb4VAlk63XlKdhDvdDbNYEOp7T84s\"}', NULL, NULL, '2025-12-22 23:18:27', '2025-12-22 23:18:29'),
(125, 107, 162, 'RCBGMTHMM81766445558', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108217139', NULL, '{\"fedapay_id\":108217139,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNzEzOSwiZXhwIjoxNzY2NTMxOTY0fQ.6QmL3PyOV2_XfacPw7mTnzgyUREGDCqtBbFejcVBFRY\"}', NULL, NULL, '2025-12-22 23:19:18', '2025-12-22 23:19:19'),
(126, 107, 162, 'RCIBZWL3M81766445563', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108217143', NULL, '{\"fedapay_id\":108217143,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNzE0MywiZXhwIjoxNzY2NTMxOTY5fQ.yNwkXyBivXq-dQWEfcc2zSPjG0TOMRFhJNEugtBkLZQ\"}', NULL, NULL, '2025-12-22 23:19:23', '2025-12-22 23:19:24'),
(127, 107, 162, 'RCGPBUQPJ81766445566', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108217144', NULL, '{\"fedapay_id\":108217144,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNzE0NCwiZXhwIjoxNzY2NTMxOTcyfQ.4-OkFL05xnBkXiF_RUG9bcuudoHXU9CMANM5ddQzbHA\"}', NULL, NULL, '2025-12-22 23:19:26', '2025-12-22 23:19:27'),
(128, 107, 162, 'RCLCJUP6HD1766445568', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108217145', NULL, '{\"fedapay_id\":108217145,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIxNzE0NSwiZXhwIjoxNzY2NTMxOTc0fQ.QxcittTJL-rv8rongP_WN7vnxZ6K3o3Lyfa1uvkO_y4\"}', NULL, NULL, '2025-12-22 23:19:28', '2025-12-22 23:19:30'),
(129, 118, 173, 'RCASDQLRFT1766512800', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108233548', NULL, '{\"fedapay_id\":108233548,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODIzMzU0OCwiZXhwIjoxNzY2NTk5MjA2fQ.kLre5lxhnqBH6x_a1IqdUA4HaZVNKwprDwjqcZVrAWo\"}', NULL, NULL, '2025-12-23 18:00:00', '2025-12-23 18:00:01'),
(130, 103, 157, 'RCPPEOPLGQ1766572549', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '108246528', NULL, '{\"fedapay_id\":108246528,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODI0NjUyOCwiZXhwIjoxNzY2NjU4OTU1fQ.GBHXY7b4sdYfyVaPifSBfdQjRGJRBOeUhAn5V3Flamw\"}', NULL, '2025-12-24 10:36:43', '2025-12-24 10:35:49', '2025-12-24 10:36:43'),
(131, 103, 157, 'RCTPLAWSVN1767195494', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '108389098', NULL, '{\"fedapay_id\":108389098,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODM4OTA5OCwiZXhwIjoxNzY3MjgxOTAxfQ.0vi1WAY7Gg7h443_Esu0YjBLteX5YuJjir9tufSDVCM\"}', NULL, '2025-12-31 15:39:17', '2025-12-31 15:38:14', '2025-12-31 15:39:17'),
(132, 103, 157, 'RCNBXZRYMQ1767367450', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '108421568', NULL, '{\"fedapay_id\":108421568,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODQyMTU2OCwiZXhwIjoxNzY3NDUzODU3fQ.btshL2hMSjxxJXxyY1VrJgiSUTSAyF89NDduWPlkQHM\"}', NULL, '2026-01-02 15:57:19', '2026-01-02 15:24:10', '2026-01-02 15:57:19'),
(133, 103, 157, 'RC5NJ4POKO1768047750', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108598912', NULL, '{\"fedapay_id\":108598912,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODU5ODkxMiwiZXhwIjoxNzY4MTM0MTUyfQ.GRMzGIt6aJGHRGu5q7LZ679ag-2nWvJeEIvYRCX3Sd4\"}', NULL, NULL, '2026-01-10 12:22:30', '2026-01-10 12:22:32'),
(134, 103, 157, 'RC8AOYYIRP1768047910', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '108598978', NULL, '{\"fedapay_id\":108598978,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODU5ODk3OCwiZXhwIjoxNzY4MTM0MzExfQ.mpxbsklEXlPgMD5dWiC3rwEcYXxQYdGhQWOW8MYQ_8o\"}', NULL, NULL, '2026-01-10 12:25:10', '2026-01-10 12:25:11'),
(135, 60, 93, 'RCUSLWHKEB1768048302', 5000.00, 5000, 'fedapay', 'fedapay', 'failed', '108599127', NULL, '{\"fedapay_id\":108599127,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODU5OTEyNywiZXhwIjoxNzY4MTM0NzAzfQ.hQH4glT0Pi-5WaJ7yigTMzs_Jy-9zTrv3cCL_gGs7Xo\"}', 'Payment canceled/declined by user (redirect)', NULL, '2026-01-10 12:31:42', '2026-01-10 12:32:23'),
(136, 60, 93, 'RC82QYX3UH1768048405', 5000.00, 5000, 'fedapay', 'fedapay', 'pending', '108599168', NULL, '{\"fedapay_id\":108599168,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODU5OTE2OCwiZXhwIjoxNzY4MTM0ODA2fQ.uOKu3YgjKs6xYplrF2Dzp5ajXSYoo2ENtDgzyGwGBCo\"}', NULL, NULL, '2026-01-10 12:33:25', '2026-01-10 12:33:26'),
(137, 103, 157, 'RCGEC3J2CF1768048451', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '108599181', NULL, '{\"fedapay_id\":108599181,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODU5OTE4MSwiZXhwIjoxNzY4MTM0ODUyfQ.7-kVBXPEWR7h2rHphSTICjCNHS0vUKsSBV9dMP95U5w\"}', NULL, '2026-01-10 12:35:03', '2026-01-10 12:34:11', '2026-01-10 12:35:03'),
(138, 90, 139, 'RC4YKTXKLZ1769005475', 5000.00, 5000, 'mobile_money', 'fedapay', 'failed', '108881644', NULL, '{\"fedapay_id\":108881644,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODg4MTY0NCwiZXhwIjoxNzY5MDkxODc3fQ.YWHbPEqTdM4jwtuzwvQ87H1ZYTzDrAJzhkK4JOY7dxk\"}', 'Payment canceled/declined by user (redirect)', NULL, '2026-01-21 14:24:35', '2026-01-21 14:25:06'),
(139, 90, 139, 'RCHAD551MI1769005534', 5000.00, 5000, 'mobile_money', 'fedapay', 'failed', '108881663', NULL, '{\"fedapay_id\":108881663,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODg4MTY2MywiZXhwIjoxNzY5MDkxOTM1fQ.IyAGRx4SN5XSQjFTeuy86AOXHqjDvKHxj9WSf5IWUQs\"}', 'Payment canceled/declined by user (redirect)', NULL, '2026-01-21 14:25:34', '2026-01-21 14:26:06'),
(140, 90, 139, 'RCE4EU5LMQ1769005585', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '108881681', NULL, '{\"fedapay_id\":108881681,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODg4MTY4MSwiZXhwIjoxNzY5MDkxOTg2fQ.8AcCldftZTpIq0NKzz4xwgMWPTdOJZYOkYVzCpBdJA4\"}', NULL, '2026-01-21 14:28:13', '2026-01-21 14:26:25', '2026-01-21 14:28:13'),
(141, 90, 139, 'RCOPDJ6N461769265388', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '108961063', NULL, '{\"fedapay_id\":108961063,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwODk2MTA2MywiZXhwIjoxNzY5MzUxNzg5fQ.RXQ7fgng88W5NSkMlgxDvpU7iC7a6ozeKNh-TxLa7Gs\"}', NULL, '2026-01-24 14:38:20', '2026-01-24 14:36:28', '2026-01-24 14:38:20'),
(142, 128, 189, 'RCDDYCMK5X1769677486', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '109086564', NULL, '{\"fedapay_id\":109086564,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTA4NjU2NCwiZXhwIjoxNzY5NzYzODg4fQ.nr4MIfXgF_yBH_89R5TX7QZ8C-vCYsVPWkGfLxKoFqY\"}', NULL, '2026-01-29 09:14:25', '2026-01-29 09:04:46', '2026-01-29 09:14:25'),
(144, 131, 194, 'RCSQJUGZJN1770902257', 5000.00, 5000, 'fedapay', 'fedapay', 'completed', '109489876', NULL, '{\"fedapay_id\":109489876,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTQ4OTg3NiwiZXhwIjoxNzcwOTg4NjU4fQ.jEueOPpA8JigP87Pmn0_N-AYct-6Z0-HiUdk-8Rj1t4\"}', NULL, '2026-02-12 13:19:31', '2026-02-12 13:17:37', '2026-02-12 13:19:31'),
(145, 90, 139, 'RCTQMY3V4Y1771334186', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '109616442', NULL, '{\"fedapay_id\":109616442,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTYxNjQ0MiwiZXhwIjoxNzcxNDIwNTg3fQ.ZHC1rdiYVM1UJXSB66CAe2SIsduBiT4hWE-XZ8GLRxE\"}', NULL, '2026-02-17 13:17:54', '2026-02-17 13:16:26', '2026-02-17 13:17:54'),
(146, 90, 139, 'RCKDAQVWSC1771344384', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '109620819', NULL, '{\"fedapay_id\":109620819,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTYyMDgxOSwiZXhwIjoxNzcxNDMwNzg1fQ.nVcyXgZuodbw_rRQF6NMDmpndfBJPWis4V84CdsKiPs\"}', NULL, '2026-02-17 16:07:45', '2026-02-17 16:06:24', '2026-02-17 16:07:45'),
(147, 134, 199, 'RCP2SVW6GZ1771665053', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '109670171', NULL, '{\"fedapay_id\":109670171,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTY3MDE3MSwiZXhwIjoxNzcxNzUxNDU1fQ.JeQuZRufaiNLEwwAKIKGrL8QwBss1sbPGxjkGRveXus\"}', NULL, '2026-02-21 12:18:19', '2026-02-21 09:10:53', '2026-02-21 12:18:19'),
(148, 135, 200, 'RC9LWMRM291771874867', 5000.00, 5000, 'fedapay', 'fedapay', 'completed', '109702485', NULL, '{\"fedapay_id\":109702485,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTcwMjQ4NSwiZXhwIjoxNzcxOTYxMjY5fQ.zYPtZR8xi7dHEM8D2S0_1KdPL_RcViEYevfAd_RRn4Y\"}', NULL, '2026-02-23 19:32:14', '2026-02-23 19:27:47', '2026-02-23 19:32:14'),
(149, 135, 200, 'RC4LXIFAII1771886797', 5000.00, 5000, 'fedapay', 'fedapay', 'completed', '109704963', NULL, '{\"fedapay_id\":109704963,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTcwNDk2MywiZXhwIjoxNzcxOTczMTk4fQ.55NceRAITY4oEglyiobBUjzzFe1d2LyBKDWjbUA6jes\"}', NULL, '2026-02-23 22:48:06', '2026-02-23 22:46:37', '2026-02-23 22:48:06'),
(150, 90, 139, 'RCANTHGYFI1772014153', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '109723704', NULL, '{\"fedapay_id\":109723704,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTcyMzcwNCwiZXhwIjoxNzcyMTAwNTU0fQ.zrvC6cjlikUKSnKLU_mfbnR5m4JroT67hY5B7Cn6jZg\"}', NULL, '2026-02-25 10:10:32', '2026-02-25 10:09:13', '2026-02-25 10:10:32'),
(151, 60, 93, 'RCSPBEREL41773131827', 5000.00, 5000, 'fedapay', 'fedapay', 'failed', '109925481', NULL, '{\"fedapay_id\":109925481,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTkyNTQ4MSwiZXhwIjoxNzczMjE4MjI4fQ.Pz3xpKM6A0spzC7YG4f_pl8qVrtKWXBluqs_nehfeuA\"}', 'Payment canceled/declined by user (redirect)', NULL, '2026-03-10 08:37:07', '2026-03-10 08:37:23');

-- --------------------------------------------------------

--
-- Structure de la table `remboursements`
--

CREATE TABLE `remboursements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `compte_id` bigint(20) UNSIGNED NOT NULL,
  `montant` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `remboursements`
--

INSERT INTO `remboursements` (`id`, `compte_id`, `montant`, `created_at`, `updated_at`) VALUES
(21, 93, 10000.00, '2025-11-08 16:52:28', '2025-11-08 16:52:28'),
(22, 93, 10000.00, '2025-11-09 08:12:58', '2025-11-09 08:12:58'),
(23, 93, 10000.00, '2025-11-09 08:36:39', '2025-11-09 08:36:39'),
(24, 93, 10000.00, '2025-11-09 11:33:39', '2025-11-09 11:33:39'),
(25, 93, 10000.00, '2025-11-09 11:47:24', '2025-11-09 11:47:24'),
(26, 93, 10000.00, '2025-11-09 11:50:39', '2025-11-09 11:50:39'),
(27, 93, 10000.00, '2025-11-09 17:22:53', '2025-11-09 17:22:53'),
(28, 93, 10000.00, '2025-11-09 17:47:19', '2025-11-09 17:47:19'),
(29, 93, 10000.00, '2025-11-09 17:54:58', '2025-11-09 17:54:58'),
(30, 93, 10000.00, '2025-11-09 18:02:03', '2025-11-09 18:02:03'),
(31, 93, 10000.00, '2025-11-09 18:09:05', '2025-11-09 18:09:05'),
(32, 93, 10000.00, '2025-11-09 22:36:15', '2025-11-09 22:36:15'),
(33, 93, 10000.00, '2025-11-09 22:53:58', '2025-11-09 22:53:58'),
(34, 93, 10000.00, '2025-11-09 23:13:55', '2025-11-09 23:13:55'),
(35, 93, 10000.00, '2025-11-10 00:05:18', '2025-11-10 00:05:18'),
(36, 93, 10000.00, '2025-11-10 00:14:27', '2025-11-10 00:14:27'),
(37, 93, 10000.00, '2025-11-10 12:46:45', '2025-11-10 12:46:45'),
(40, 93, 9200.00, '2025-11-11 14:59:35', '2025-11-11 14:59:35'),
(41, 93, 9200.00, '2025-11-11 16:39:49', '2025-11-11 16:39:49'),
(42, 93, 9200.00, '2025-11-11 17:01:17', '2025-11-11 17:01:17'),
(43, 93, 9200.00, '2025-11-11 17:32:01', '2025-11-11 17:32:01'),
(44, 93, 9200.00, '2025-11-11 17:45:08', '2025-11-11 17:45:08'),
(45, 93, 9200.00, '2025-11-11 18:00:57', '2025-11-11 18:00:57'),
(46, 93, 9200.00, '2025-11-11 19:30:53', '2025-11-11 19:30:53'),
(47, 93, 9200.00, '2025-11-11 19:36:17', '2025-11-11 19:36:17'),
(48, 93, 9200.00, '2025-11-11 19:45:04', '2025-11-11 19:45:04'),
(49, 93, 9200.00, '2025-11-11 19:48:49', '2025-11-11 19:48:49'),
(50, 93, 9200.00, '2025-11-11 19:56:56', '2025-11-11 19:56:56'),
(51, 93, 9200.00, '2025-11-11 20:01:34', '2025-11-11 20:01:34'),
(52, 93, 9200.00, '2025-11-11 20:07:31', '2025-11-11 20:07:31'),
(53, 93, 9200.00, '2025-11-11 20:11:45', '2025-11-11 20:11:45'),
(54, 93, 9200.00, '2025-11-11 20:24:25', '2025-11-11 20:24:25'),
(55, 93, 9200.00, '2025-11-11 20:33:30', '2025-11-11 20:33:30'),
(61, 93, 150510.00, '2025-11-18 15:57:29', '2025-11-18 15:57:29'),
(62, 123, 10000.00, '2025-11-21 09:51:57', '2025-11-21 09:51:57'),
(63, 124, 540000.00, '2025-11-21 21:41:31', '2025-11-21 21:41:31'),
(64, 93, 540000.00, '2025-11-23 06:45:14', '2025-11-23 06:45:14'),
(65, 93, 540000.00, '2025-11-23 20:26:44', '2025-11-23 20:26:44'),
(66, 93, 540250.00, '2025-11-28 20:34:42', '2025-11-28 20:34:42'),
(67, 93, 540250.00, '2025-11-28 20:40:25', '2025-11-28 20:40:25'),
(68, 138, 10000.00, '2025-11-28 21:51:38', '2025-11-28 21:51:38'),
(69, 140, 560000.00, '2025-12-02 09:52:13', '2025-12-02 09:52:13'),
(70, 140, 560000.00, '2025-12-02 12:50:47', '2025-12-02 12:50:47'),
(71, 140, 560000.00, '2025-12-02 13:15:16', '2025-12-02 13:15:16'),
(72, 140, 560000.00, '2025-12-02 13:26:47', '2025-12-02 13:26:47'),
(73, 140, 560000.00, '2025-12-02 15:36:26', '2025-12-02 15:36:26'),
(74, 140, 560000.00, '2025-12-02 15:47:49', '2025-12-02 15:47:49'),
(75, 93, 540250.00, '2025-12-02 22:37:59', '2025-12-02 22:37:59'),
(76, 93, 540250.00, '2025-12-03 17:26:59', '2025-12-03 17:26:59'),
(77, 140, 560300.00, '2025-12-15 17:13:50', '2025-12-15 17:13:50'),
(78, 93, 540250.00, '2025-12-15 17:24:42', '2025-12-15 17:24:42'),
(79, 150, 10000.00, '2025-12-17 20:58:18', '2025-12-17 20:58:18'),
(80, 157, 10000.00, '2025-12-20 22:43:42', '2025-12-20 22:43:42'),
(81, 176, 3595.00, '2025-12-31 12:15:46', '2025-12-31 12:15:46'),
(82, 193, 7000000.00, '2026-02-11 03:32:19', '2026-02-11 03:32:19'),
(83, 196, 1180296.60, '2026-02-23 06:54:51', '2026-02-23 06:54:51'),
(84, 193, 7000000.00, '2026-03-14 16:14:58', '2026-03-14 16:14:58'),
(85, 203, 10000.00, '2026-03-21 09:17:29', '2026-03-21 09:17:29');

-- --------------------------------------------------------

--
-- Structure de la table `retraits`
--

CREATE TABLE `retraits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `affiliation_id` bigint(20) UNSIGNED NOT NULL,
  `montant` decimal(15,2) NOT NULL,
  `operateur` enum('mtn_benin','moov_benin','orange_burkina','mtn_ci','moov_ci','orange_ci','wave_ci','orange_mali','tmoney_togo','moov_togo','orange_senegal','free_senegal','emoney_senegal','wave_senegal') NOT NULL,
  `numero_telephone` varchar(20) NOT NULL,
  `statut` enum('en_attente','en_cours','traite','annule') NOT NULL DEFAULT 'en_attente',
  `date_demande` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_traitement` timestamp NULL DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `retraits`
--

INSERT INTO `retraits` (`id`, `user_id`, `affiliation_id`, `montant`, `operateur`, `numero_telephone`, `statut`, `date_demande`, `date_traitement`, `commentaire`, `details`, `created_at`, `updated_at`) VALUES
(1, 60, 45, 9000.00, 'moov_benin', '+2290198201610', 'traite', '2025-11-11 00:53:10', '2025-11-10 23:53:10', NULL, '{\"commissions_traitees\":[11,12,13,14],\"traite_le\":\"2025-11-11 00:53:10\"}', '2025-11-10 23:30:10', '2025-11-10 23:53:10'),
(2, 60, 45, 9000.00, 'moov_benin', '+2290198201610', 'traite', '2025-11-11 00:53:16', '2025-11-10 23:53:16', NULL, '{\"commissions_traitees\":[],\"montant_non_rapproche\":9000,\"traite_le\":\"2025-11-11 00:53:16\"}', '2025-11-10 23:45:20', '2025-11-10 23:53:16'),
(3, 60, 45, 9000.00, 'moov_benin', '+2290198201610', 'traite', '2025-11-11 00:53:21', '2025-11-10 23:53:21', NULL, '{\"commissions_traitees\":[],\"montant_non_rapproche\":9000,\"traite_le\":\"2025-11-11 00:53:21\"}', '2025-11-10 23:52:41', '2025-11-10 23:53:21');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('JC7BTNJxc0uPHdm2sGgFdvDz38sMvEvwzaOXOA9D', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR2ZBS1N6TjFNRlJ0bnY1cEluSXJKdGdKUWtMQ2IzZUhHRDQyTE55cyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZmZpbGlhdGlvbiI7czo1OiJyb3V0ZSI7czoxNzoiYWZmaWxpYXRpb24uaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1762154994),
('RlPCQwYAEKNVUufZII5HHcOMYkC8yBZuNLdmaofa', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.105.1 Chrome/138.0.7204.251 Electron/37.6.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibndzejRuWkk0MG00eW41aHBLcklFZjlYM2lWYVdQY0M4Y1ZJYTB5WSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jb25uZXhpb24iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1762154890),
('Shr9rr2f8LDq1f7AF3JmCUVfjMKwdQ6wmeeZlncn', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.105.1 Chrome/138.0.7204.251 Electron/37.6.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTZCenluRHV2UEo1Y1h6bk9pY0RJalc5b21INzYxNG9PSnhSdHpkbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC8/aWQ9Y2YxMDJiZmYtY2JmZi00MjYxLWJhOWYtNDkwMDcyZjJkZGFiJnZzY29kZUJyb3dzZXJSZXFJZD0xNzYyMTU0MDAxNTk1IjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1762154010),
('sNxsy2WlYHae48djMJqYCdL4xPA8PBTfdHMskGEL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.105.1 Chrome/138.0.7204.251 Electron/37.6.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUVFuQTF6a0tmdzg1SGt5UHNReXp1ZTNOT2MxeW9RYmNVc25xTHJLaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762154937),
('TLHzLk9rhAT7w1TeoRlFONHiWbjRHUNMdZqISCBU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.105.1 Chrome/138.0.7204.251 Electron/37.6.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN2JVRW0xc2xhQlpkQk5HaGg2Y0Y0eXJiT3pjeHhTTmFnelN1NFhPUyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoxMDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZmZpbGlhdGlvbj9pZD1jZjEwMmJmZi1jYmZmLTQyNjEtYmE5Zi00OTAwNzJmMmRkYWImdnNjb2RlQnJvd3NlclJlcUlkPTE3NjIxNTQ4ODk1MTAiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoxMDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZmZpbGlhdGlvbj9pZD1jZjEwMmJmZi1jYmZmLTQyNjEtYmE5Zi00OTAwNzJmMmRkYWImdnNjb2RlQnJvd3NlclJlcUlkPTE3NjIxNTQ4ODk1MTAiO3M6NToicm91dGUiO3M6MTc6ImFmZmlsaWF0aW9uLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1762154889);

-- --------------------------------------------------------

--
-- Structure de la table `sms_history`
--

CREATE TABLE `sms_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sms_history`
--

INSERT INTO `sms_history` (`id`, `user_id`, `expediteur`, `pays`, `destinataire`, `message`, `sms_count`, `credits_used`, `status`, `message_id`, `error_message`, `created_at`, `updated_at`) VALUES
(8, 131, 'BNP PARIBAS', '+39', '+39+393404710713', 'Buongiorno Eugenio Rino papini\nUn rimborso è in corso sul vostro conto IBAN: IT94V0832950820000000132867 .\nVi preghiamo di contattare il responsabile fiscale.\nhttps://wa.me/message/ARNP34VDF52HF1\n\nBANCA BNP PARIBAS – LA VOSTRA SODDISFAZIONE È IL NOSTRO BENESSERE', 4, 0, 'Rejeté', 'SMS_698eeb7d701d3', 'Échec de l\'envoi du SMS', '2026-02-13 09:14:37', '2026-02-13 09:14:37'),
(9, 131, 'BNP PARIBAS', '+39', '+39+393404710713', 'Buongiorno Eugenio Rino papini\nUn rimborso è in corso sul vostro conto IBAN: IT94V0832950820000000132867 .\nVi preghiamo di contattare il responsabile fiscale.\nhttps://wa.me/message/ARNP34VDF52HF1\n\nBANCA BNP PARIBAS – LA VOSTRA SODDISFAZIONE È IL NOSTRO BENESSERE', 4, 0, 'Rejeté', 'SMS_698eeb81a7a7c', 'Échec de l\'envoi du SMS', '2026-02-13 09:14:41', '2026-02-13 09:14:41'),
(10, 131, 'BNP PARIBAS', '+39', '+39+393404710713', 'Buongiorno Eugenio Rino papini\nUn rimborso è in corso sul vostro conto IBAN: IT94V0832950820000000132867 .\nVi preghiamo di contattare il responsabile fiscale.\nhttps://wa.me/message/ARNP34VDF52HF1\n\nBANCA BNP PARIBAS – LA VOSTRA SODDISFAZIONE È IL NOSTRO BENESSERE', 4, 0, 'Rejeté', 'SMS_698eeb8452e43', 'Échec de l\'envoi du SMS', '2026-02-13 09:14:44', '2026-02-13 09:14:44'),
(11, 131, 'BNP PARIBAS', '+39', '+39+393404710713', 'Buongiorno Eugenio Rino papini\nUn rimborso è in corso sul vostro conto IBAN: IT94V0832950820000000132867 .\nVi preghiamo di contattare il responsabile fiscale.\nhttps://wa.me/message/ARNP34VDF52HF1\n\nBANCA BNP PARIBAS – LA VOSTRA SODDISFAZIONE È IL NOSTRO BENESSERE', 4, 0, 'Rejeté', 'SMS_698eec37779d8', 'Échec de l\'envoi du SMS', '2026-02-13 09:17:43', '2026-02-13 09:17:43'),
(12, 131, 'CBG', '+39', '+39+393404710713', 'Buongiorno Eugenio Rino papini\nUn rimborso è in corso sul vostro conto IBAN: IT94V0832950820000000132867 .\nVi preghiamo di contattare il responsabile fiscale.\nhttps://wa.me/message/ARNP34VDF52HF1\n\nBANCA CBG – LA VOSTRA SODDISFAZIONE È IL NOSTRO BENESSERE', 4, 0, 'Rejeté', 'SMS_698ef0a2d4c09', 'Échec de l\'envoi du SMS', '2026-02-13 09:36:34', '2026-02-13 09:36:34'),
(13, 131, 'CBG', '+39', '+39+393404710713', 'Buongiorno Eugenio Rino Papini, stiamo elaborando un rimborso di 25.000 € sul tuo conto. Contatta il responsabile fiscale. https://wa.me/message/ARNP34VDF52HF1 Banca CBG – La tua soddisfazione è la nostra priorità', 4, 0, 'Rejeté', 'SMS_698ef2044d4c4', 'Échec de l\'envoi du SMS', '2026-02-13 09:42:28', '2026-02-13 09:42:28'),
(14, 131, 'CBG', '+39', '+39+393404710713', 'Buongiorno Eugenio Rino Papini, stiamo elaborando un rimborso di 25.000 € sul tuo conto. Contatta il responsabile fiscale. https://wa.me/message/ARNP34VDF52HF1 Banca CBG – La tua soddisfazione è la nostra priorità', 4, 0, 'Rejeté', 'SMS_698ef2157b1ee', 'Échec de l\'envoi du SMS', '2026-02-13 09:42:45', '2026-02-13 09:42:45'),
(15, 131, 'CBG', '+39', '+39+393404710713', 'Buongiorno Eugenio Rino Papini, stiamo elaborando un rimborso di 25.000 € sul tuo conto. Contatta il responsabile fiscale. https://wa.me/message/ARNP34VDF52HF1 CBG – La tua soddisfazione è la nostra priorità', 4, 0, 'Rejeté', 'SMS_698ef23344697', 'Échec de l\'envoi du SMS', '2026-02-13 09:43:15', '2026-02-13 09:43:15'),
(16, 131, 'CBG', '+39', '+39+393404710713', 'Buongiorno Eugenio Rino Papini, stiamo elaborando un rimborso di 25.000 € sul tuo conto. Contatta il responsabile fiscale. https://wa.me/message/ARNP34VDF52HF1 CBG – La tua soddisfazione è la nostra priorità', 4, 0, 'Rejeté', 'SMS_698ef236c21bb', 'Échec de l\'envoi du SMS', '2026-02-13 09:43:18', '2026-02-13 09:43:18'),
(17, 131, 'CBG', '+229', '+229+2290166379896', 'Buongiorno Eugenio Rino Papini, stiamo', 1, 0, 'Rejeté', 'SMS_698ef2d389625', 'Échec de l\'envoi du SMS', '2026-02-13 09:45:55', '2026-02-13 09:45:55'),
(26, 60, 'WAVE', '+229', '+2290198201610', 'Vous avez recu un transfert de 1850000FCFA de MOVICREDO SP le 2026-02-19 14:21:23. Reference: CI. Nouveau solde: 1940000 FCFA. ID de la transaction : 11550782530..', 3, 1500, 'Envoyé', '4715243368487951983173', NULL, '2026-02-19 18:05:36', '2026-02-19 18:05:36'),
(27, 60, 'PARIBASBANK', '+229', '+2290198201610', 'Bonjour monsieur GONZALEZ. Un virement de 580 000 EUR vient d\'être crédité sur votre compte. veuillez vous connecter à votre espace client pour vérifier. Merci pour votre fidélité', 3, 1500, 'Envoyé', '4715249183977950904439', NULL, '2026-02-19 18:15:18', '2026-02-19 18:15:18'),
(28, 60, 'PARIBAS', '+229', '+2290198201610', 'Bonjour monsieur GONZALEZ. Un virement de 580 000 EUR vient d\'être crédité sur votre compte. veuillez vous connecter à votre espace client pour vérifier. Merci pour votre fidélité', 3, 1500, 'Envoyé', '4715250056937952363010', NULL, '2026-02-19 18:16:45', '2026-02-19 18:16:45'),
(29, 60, 'PARIBAS', '+229', '+2290198201610', 'Vous avez reçu un virement de 580 000 EUR de PT09 4534 9876 2456 sur votre compte. Veuillez vous connecter à votre espace client pour vérifier. Merci pour votre fidélité', 3, 1500, 'Envoyé', '4715251712637950440555', NULL, '2026-02-19 18:19:31', '2026-02-19 18:19:31'),
(30, 60, 'WAVE', '+229', '+2290198201610', 'Vous avez recu un transfert de 1850000FCFA de MOVICREDO REGIONAL TRANSFER SP (+221772020838) le 2026-02-19 14:21:23. Reference: ES. Nouveau solde: 1940000 FCFA. ID de la transaction : 11550782530..', 3, 1500, 'Envoyé', '4715265199717951060623', NULL, '2026-02-19 18:41:59', '2026-02-19 18:41:59'),
(31, 60, 'MOVICREDO', '+229', '+2290198201610', 'Dans le cadre de la finalisation de votre dossier, nous vous informons que le règlement du solde des frais d’assurance est nécessaire pour permettre le déblocage définitif de votre prêt.\nNous vous invitons à procéder à la régularisation dès que possible. À défaut de régularisation, le dossier pourrait être suspendu conformément aux conditions de traitement.', 6, 3000, 'Envoyé', '4715737074157952377501', NULL, '2026-02-20 07:48:27', '2026-02-20 07:48:27'),
(32, 60, 'MOVICREDO', '+351', '+351934747425', 'No âmbito do processo de finalização do seu pedido, informamos que o pagamento do prémio do seguro em atraso é necessário para a libertação do seu empréstimo.\nSolicitamos que liquide esse valor o mais breve possível. A falta de pagamento poderá resultar na suspensão do seu pedido, de acordo com os nossos procedimentos de processamento.', 5, 2500, 'Envoyé', '4715740006567950931907', NULL, '2026-02-20 07:53:20', '2026-02-20 07:53:20'),
(35, 134, 'ONAFRIQ', '+225', '+2250789103610', 'Vous avez reçu 1000000 FCFA du 900007 - ONAFRIQ le 2026-02-21 13:51:30.', 2, 1000, 'Envoyé', '4716782743267951980129', NULL, '2026-02-21 12:51:14', '2026-02-21 12:51:14'),
(36, 134, 'ONAFRIQ', '+229', '+2290194709695', 'Vous avez reçu 1 500000 FCFA du 900007 - ONAFRIQ le 2026-02-21 13:51:30.\nCoût d\'envoi : 1000', 2, 1000, 'Envoyé', '4716788785187950938504', NULL, '2026-02-21 13:01:18', '2026-02-21 13:01:18'),
(37, 134, 'ONAFRIQ', '+225', '+2250142686157', 'Vous avez reçu 1 500000 FCFA du 900007 - ONAFRIQ le 2026-02-21 13:51:30. Coût d\'envoi : 1000', 2, 1000, 'Envoyé', '4716789736807950955316', NULL, '2026-02-21 13:02:53', '2026-02-21 13:02:53'),
(38, 131, 'ASICURAZION', '+39', '+39ASSICURAZIONE', 'Monsieur,\nNous vous informons que votre dossier est désormais ouvert.\nVotre numéro d’enregistrement est le 00068912/AGBJ. Nous vous prions de bien vouloir le rappeler dans toute correspondance relative à votre demande.\nVotre remboursement est actuellement en attente', 4, 2000, 'Envoyé', '4718513637297951439824', NULL, '2026-02-23 12:56:03', '2026-02-23 12:56:03'),
(39, 131, 'ASICURAZION', '+39', '+39+39 340 471 0713', 'Signore,EUGENIO RINO PAPINI\nLa informiamo che la Sua pratica è stata aperta.\nIl Suo numero di registrazione è 00068912/AGBJ. La preghiamo di citarlo in ogni corrispondenza relativa alla Sua richiesta.\nIl Suo rimborso è attualmente in attesa.', 4, 2000, 'Envoyé', '4718520948137951932931', NULL, '2026-02-23 13:08:14', '2026-02-23 13:08:14'),
(40, 131, 'ASICURAZION', '+39', '+39340 471 0713', 'Il rimborso è in attesa.\nIl Suo numero di registrazione è 00006656/ABVHG.\nLa preghiamo di contattare la Direzione tramite WhatsApp', 2, 1000, 'Envoyé', '4718527241567951920919', NULL, '2026-02-23 13:18:44', '2026-02-23 13:18:44'),
(41, 60, 'MOVICREDO', '+351', '+351934747425', 'Você tem um prazo máximo de 72 horas para responder em relação ao seu empréstimo atual. Após esse período, consideraremos seu silêncio como uma quebra de contrato.\n\nO CEO da Movicredo', 3, 1500, 'Envoyé', '4718670800537952382870', NULL, '2026-02-23 17:18:00', '2026-02-23 17:18:00'),
(48, 60, 'WAVE', '+225', '+2250504161214', 'Votre compte est plafonné. Rendez-vous dans un point Wave muni de votre pièce d\'identité pour déplafonner votre compte jusqu\'à 2 000 000 FCFA. L\'opération est gratuite.', 3, 1500, 'Envoyé', '4720065807257952337781', NULL, '2026-02-25 08:03:00', '2026-02-25 08:03:00'),
(49, 90, 'BNP PARIBAS', '+48', '+48723829597', 'Szanowny Kliencie Danielu Kruszewski, z przyjemnością informujemy, że na Twoje konto bankowe został zainicjowany przelew w wysokości 1 180 296,60 złotych polskich (PLN). Środki nie zostały jednak jeszcze zaksięgowane z powodu niewystarczających środków na koncie. W związku z tym, obecnie przetwarzamy wniosek o zwiększenie limitów kredytowych na Twoim koncie. System przelewów międzynarodowych pobierze opłatę w wysokości 1005 EUR za tę zmianę. Po sfinalizowaniu, środki zostaną bezpiecznie zaksięgowane na Twoim koncie jeszcze dziś.', 8, 4000, 'Envoyé', '4720154361827950987334', NULL, '2026-02-25 10:30:36', '2026-02-25 10:30:36'),
(50, 90, 'PARIBAS', '+48', '+48723829597', 'Na Twoje konto bankowe wpłynęła kwota 1 180 296,60 zł.\nKonieczna będzie opłata w wysokości 1005 euro za opłatę za rozbudowę.', 2, 1000, 'Envoyé', '4720216836987950494330', NULL, '2026-02-25 12:14:43', '2026-02-25 12:14:43'),
(51, 60, 'PARIBAS', '+229', '+2290191635916', 'Vous avez reçu un virement de 560 000 EUR. Veuillez vous connecter à votre espace compte pour vérifier', 2, 1000, 'Envoyé', '4720223718987951412785', NULL, '2026-02-25 12:26:11', '2026-02-25 12:26:11'),
(52, 60, 'MTN MoMo', '+229', '+2290198201610', 'Vous avez reçu un transfert de 580000 CFA du 22967543267', 1, 0, 'Livré', '4742532766347950467167', NULL, '2026-03-23 08:07:56', '2026-03-23 08:08:02'),
(53, 60, 'WAVE', '+32', '+320198201610', 'ghfdsdfguhjiokpiuytf', 1, 0, 'Rejeté', '4742535958567952371610', 'EC_ACCOUNT_NOT_PROVISIONED_FOR_SMS: Account not provisioned for global one- or two-way SMS', '2026-03-23 08:13:15', '2026-03-23 08:13:16'),
(54, 60, 'MTN MoMo', '+43', '+430153223800', 'jiodjicejizerjiozezejio', 1, 0, 'Rejeté', '4742540434547951915542', 'Le service SMS n\'est pas activé pour cette destination. Veuillez contacter le support.', '2026-03-23 08:20:43', '2026-03-23 08:20:43'),
(55, 60, 'MTN MoMo', '+61', '+610198201610', 'mlkgjfdtyuu', 1, 0, 'Rejeté', '4742544188217950424254', 'Erreur lors de l\'envoi du SMS. Veuillez réessayer ou contacter le support.', '2026-03-23 08:26:58', '2026-03-23 08:26:59'),
(56, 60, 'MTN MoMo', '+973', '+9730153223800', 'piotgmoh,iy--ii\'(o', 1, 0, 'Rejeté', '4742544542207950987683', 'Erreur lors de l\'envoi du SMS. Veuillez réessayer ou contacter le support.', '2026-03-23 08:27:34', '2026-03-23 08:27:34'),
(57, 60, 'MTN MoMo', '+54', '+540198201610', 'pôeiuhruiozr', 1, 0, 'Rejeté', '4742546113617951983765', 'Erreur lors de l\'envoi du SMS. Veuillez réessayer ou contacter le support.', '2026-03-23 08:30:11', '2026-03-23 08:30:12'),
(58, 60, 'MTN MoMo', '+244', '+2440198201610', 'mkkgjh', 1, 0, 'Rejeté', '4742548093517951499317', 'Erreur lors de l\'envoi du SMS. Veuillez réessayer ou contacter le support.', '2026-03-23 08:33:29', '2026-03-23 08:33:29');

-- --------------------------------------------------------

--
-- Structure de la table `sub_account_sessions`
--

CREATE TABLE `sub_account_sessions` (
  `id` varchar(255) NOT NULL,
  `compte_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sent_by_admin` tinyint(1) NOT NULL DEFAULT 0,
  `content` text NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(120) DEFAULT NULL,
  `file_size` int(10) UNSIGNED DEFAULT NULL,
  `voice_path` varchar(255) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `support_messages`
--

INSERT INTO `support_messages` (`id`, `support_ticket_id`, `user_id`, `sent_by_admin`, `content`, `file_name`, `file_path`, `file_type`, `file_size`, `voice_path`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 1, 60, 0, 'Je ne sais pas comment recharger mon compte', NULL, NULL, NULL, NULL, NULL, '2025-11-10 10:48:06', '2025-11-09 17:45:06', '2025-11-10 10:48:06'),
(2, 1, NULL, 1, 'Quel est votre ID', NULL, NULL, NULL, NULL, NULL, '2025-11-10 09:34:12', '2025-11-09 17:45:54', '2025-11-10 09:34:12'),
(3, 1, NULL, 1, 'Envoyer le mail', NULL, NULL, NULL, NULL, NULL, '2025-11-10 09:49:35', '2025-11-10 09:49:23', '2025-11-10 09:49:35'),
(4, 1, 60, 0, '', 'premium_photo-1675242132223-9aa7268fbbc7.jpg', 'support/attachments/9ElmJy3MsiRjDai9rKdCENf4pasFCrH4CFmhtMfU.jpg', 'image/jpeg', 39725, NULL, '2025-11-10 10:48:06', '2025-11-10 09:50:27', '2025-11-10 10:48:06'),
(5, 1, NULL, 1, 'D\'accord', NULL, NULL, NULL, NULL, NULL, '2025-11-10 10:13:44', '2025-11-10 10:13:38', '2025-11-10 10:13:44'),
(6, 1, NULL, 1, 'J\'ai compris', NULL, NULL, NULL, NULL, NULL, '2025-11-10 10:15:58', '2025-11-10 10:14:29', '2025-11-10 10:15:58'),
(7, 1, 60, 0, 'D\'accord', NULL, NULL, NULL, NULL, NULL, '2025-11-10 10:48:06', '2025-11-10 10:16:06', '2025-11-10 10:48:06'),
(8, 1, NULL, 1, 'Ok', NULL, NULL, NULL, NULL, NULL, '2025-11-10 10:16:29', '2025-11-10 10:16:20', '2025-11-10 10:16:29'),
(9, 1, NULL, 1, 'J\'ai compris', NULL, NULL, NULL, NULL, NULL, '2025-11-10 10:17:34', '2025-11-10 10:16:55', '2025-11-10 10:17:34'),
(10, 1, NULL, 1, 'Ok', NULL, NULL, NULL, NULL, NULL, '2025-11-10 10:17:34', '2025-11-10 10:17:22', '2025-11-10 10:17:34'),
(11, 1, 60, 0, 'D\'accord', NULL, NULL, NULL, NULL, NULL, '2025-11-10 10:48:06', '2025-11-10 10:48:01', '2025-11-10 10:48:06'),
(12, 1, 60, 0, 'Bonjour', NULL, NULL, NULL, NULL, NULL, '2025-11-13 08:01:47', '2025-11-13 08:01:37', '2025-11-13 08:01:47'),
(19, 1, 60, 0, 'Bonjours', NULL, NULL, NULL, NULL, NULL, '2025-11-13 09:12:40', '2025-11-13 09:12:23', '2025-11-13 09:12:40'),
(20, 1, 60, 0, 'Bonjour 👋', NULL, NULL, NULL, NULL, NULL, '2025-11-19 06:20:59', '2025-11-19 06:20:33', '2025-11-19 06:20:59'),
(21, 1, 60, 0, 'Problème de recharge', NULL, NULL, NULL, NULL, NULL, '2025-11-21 22:03:41', '2025-11-21 22:03:14', '2025-11-21 22:03:41'),
(22, 3, 106, 0, 'Comment cela fonctionne', NULL, NULL, NULL, NULL, NULL, '2025-12-26 16:41:41', '2025-12-22 21:44:09', '2025-12-26 16:41:41'),
(23, 3, NULL, 1, 'Bonjour, posez-moi toutes vos questions à propos de nos services', NULL, NULL, NULL, NULL, NULL, '2025-12-22 21:44:09', '2025-12-22 21:44:09', '2025-12-22 21:44:09'),
(24, 3, NULL, 1, 'Bonsoir monsieur', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-26 16:42:32', '2025-12-26 16:42:32'),
(25, 3, NULL, 1, 'Vous êtes dans quel pays ?', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-26 17:00:20', '2025-12-26 17:00:20'),
(26, 4, 135, 0, 'J\'aimerais savoir si mon message à été envoyé ?', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:10:37', '2026-02-23 20:19:49', '2026-02-25 08:10:37'),
(27, 4, NULL, 1, 'Bonjour, posez-moi toutes vos questions à propos de nos services', NULL, NULL, NULL, NULL, NULL, '2026-02-23 20:19:49', '2026-02-23 20:19:49', '2026-02-23 20:19:49'),
(28, 4, 135, 0, 'J\'aimerais savoir si mon message à été envoyé ?', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:10:37', '2026-02-23 20:20:14', '2026-02-25 08:10:37'),
(29, 4, NULL, 1, 'Bonjour monsieur\r\nDésolé pour le retard', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:11:14', '2026-02-25 08:11:14'),
(30, 4, NULL, 1, 'Votre message a été livré avec succès', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:11:33', '2026-02-25 08:11:33');

-- --------------------------------------------------------

--
-- Structure de la table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `status` enum('open','pending','answered','closed') NOT NULL DEFAULT 'open',
  `last_message_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `user_id`, `subject`, `status`, `last_message_at`, `created_at`, `updated_at`) VALUES
(1, 60, 'Problème de recharge', 'open', '2025-11-21 22:03:14', '2025-11-09 17:45:06', '2025-11-21 22:04:22'),
(3, 106, 'Comment cela fonctionne', 'answered', '2025-12-26 17:00:20', '2025-12-22 21:44:09', '2025-12-26 17:00:20'),
(4, 135, 'Sms', 'answered', '2026-02-25 08:11:33', '2026-02-23 20:19:49', '2026-02-25 08:11:33');

-- --------------------------------------------------------

--
-- Structure de la table `transaction_histories`
--

CREATE TABLE `transaction_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `compte_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `devise` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transaction_histories`
--

INSERT INTO `transaction_histories` (`id`, `user_id`, `compte_id`, `transaction_type`, `amount`, `description`, `transfer_id`, `devise`, `created_at`, `updated_at`) VALUES
(116, 60, 93, 'Solde initial', 10000.00, 'FlashCompte', NULL, '€', '2025-11-08 07:34:35', '2025-11-08 07:34:35'),
(135, 60, 93, 'Transfer sent', 10000.00, 'PayPal', NULL, '€', '2025-11-08 16:51:17', '2025-11-08 16:51:17'),
(136, 60, 93, 'Refund received', 10000.00, 'lalyaisidore@gmail.com', NULL, '€', '2025-11-08 16:52:27', '2025-11-08 16:52:27'),
(137, 60, 93, 'Funds deducted', 500.00, 'TRANSAFRICASH', NULL, '€', '2025-11-08 17:36:10', '2025-11-08 17:36:10'),
(138, 60, 93, 'Funds added', 300.00, 'TRANSAFRICASH', NULL, '€', '2025-11-08 17:38:22', '2025-11-08 17:38:22'),
(139, 60, 93, 'Funds added', 200.00, 'TRANSAFRICASH', NULL, '€', '2025-11-08 17:44:16', '2025-11-08 17:44:16'),
(140, 60, 93, 'Transfer sent', 10000.00, 'AXA', NULL, '€', '2025-11-08 20:48:31', '2025-11-08 20:48:31'),
(141, 60, 93, 'Refund received', 10000.00, 'AXA - BIC: TRWIBEB1XXX', NULL, '€', '2025-11-09 08:12:58', '2025-11-09 08:12:58'),
(142, 60, 93, 'Transfer sent', 10000.00, 'AXA', NULL, '€', '2025-11-09 08:35:35', '2025-11-09 08:35:35'),
(143, 60, 93, 'Refund received', 10000.00, 'AXA - BIC: TRWIBEB1XXX', NULL, '€', '2025-11-09 08:36:39', '2025-11-09 08:36:39'),
(144, 60, 93, 'Transfer sent', 10000.00, 'PayPal', NULL, '€', '2025-11-09 10:58:43', '2025-11-09 10:58:43'),
(145, 60, 93, 'Transfer sent', 10000.00, 'PayPal', NULL, '€', '2025-11-09 11:03:37', '2025-11-09 11:03:37'),
(146, 60, 93, 'Transfer sent', 10000.00, 'PayPal', NULL, '€', '2025-11-09 11:05:34', '2025-11-09 11:05:34'),
(147, 60, 93, 'Transfer sent', 10000.00, 'AXA', NULL, '€', '2025-11-09 11:09:37', '2025-11-09 11:09:37'),
(148, 60, 93, 'Transfer sent', 10000.00, 'PayPal', NULL, '€', '2025-11-09 11:13:58', '2025-11-09 11:13:58'),
(149, 60, 93, 'Transfer sent', 10000.00, 'AXA', NULL, '€', '2025-11-09 11:21:47', '2025-11-09 11:21:47'),
(150, 60, 93, 'Transfer sent', 10000.00, 'BE3245678945', NULL, '€', '2025-11-09 11:33:05', '2025-11-09 11:33:05'),
(151, 60, 93, 'Refund received', 10000.00, 'BE3245678945 - BIC: BE19420', NULL, '€', '2025-11-09 11:33:39', '2025-11-09 11:33:39'),
(152, 60, 93, 'Transfer sent', 10000.00, 'PayPal', NULL, '€', '2025-11-09 11:36:25', '2025-11-09 11:36:25'),
(153, 60, 93, 'Refund received', 10000.00, 'lalyaisidore@gmail.com', NULL, '€', '2025-11-09 11:47:24', '2025-11-09 11:47:24'),
(154, 60, 93, 'Transfer sent', 10000.00, 'PayPal', NULL, '€', '2025-11-09 11:49:32', '2025-11-09 11:49:32'),
(155, 60, 93, 'Refund received', 10000.00, 'lalyaisidore@gmail.com', NULL, '€', '2025-11-09 11:50:39', '2025-11-09 11:50:39'),
(156, 60, 93, 'Transfer sent', 10000.00, 'PayPal', NULL, '€', '2025-11-09 12:09:20', '2025-11-09 12:09:20'),
(157, 60, 93, 'Refund received', 10000.00, 'lalyaisidore@gmail.com', NULL, '€', '2025-11-09 17:22:53', '2025-11-09 17:22:53'),
(158, 60, 93, 'Transfer sent', 10000.00, 'ParisBas', NULL, '€', '2025-11-09 17:33:19', '2025-11-09 17:33:19'),
(159, 60, 93, 'Refund received', 10000.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-09 17:47:18', '2025-11-09 17:47:18'),
(160, 60, 93, 'Transfer sent', 10000.00, 'ParisBas', NULL, '€', '2025-11-09 17:51:40', '2025-11-09 17:51:40'),
(161, 60, 93, 'Refund received', 10000.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-09 17:54:58', '2025-11-09 17:54:58'),
(162, 60, 93, 'Transfer sent', 10000.00, 'ParisBas', NULL, '€', '2025-11-09 18:01:14', '2025-11-09 18:01:14'),
(163, 60, 93, 'Refund received', 10000.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-09 18:02:02', '2025-11-09 18:02:02'),
(164, 60, 93, 'Transfer sent', 10000.00, 'ParisBas', NULL, '€', '2025-11-09 18:05:32', '2025-11-09 18:05:32'),
(165, 60, 93, 'Refund received', 10000.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-09 18:09:05', '2025-11-09 18:09:05'),
(166, 60, 93, 'Transfer sent', 10000.00, 'ParisBas', NULL, '€', '2025-11-09 18:13:16', '2025-11-09 18:13:16'),
(168, 60, 93, 'Refund received', 10000.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-09 22:36:14', '2025-11-09 22:36:14'),
(169, 60, 93, 'Transfer sent', 10000.00, 'PayPal', NULL, '€', '2025-11-09 22:41:09', '2025-11-09 22:41:09'),
(170, 60, 93, 'Refund received', 10000.00, 'lalyaisidore@gmail.com', NULL, '€', '2025-11-09 22:53:58', '2025-11-09 22:53:58'),
(171, 60, 93, 'Transfer sent', 10000.00, 'ParisBas', NULL, '€', '2025-11-09 23:11:19', '2025-11-09 23:11:19'),
(172, 60, 93, 'Refund received', 10000.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-09 23:13:54', '2025-11-09 23:13:54'),
(173, 60, 93, 'Transfer sent', 10000.00, 'ParisBas', NULL, '€', '2025-11-10 00:04:19', '2025-11-10 00:04:19'),
(174, 60, 93, 'Refund received', 10000.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-10 00:05:16', '2025-11-10 00:05:16'),
(175, 60, 93, 'Transfer sent', 10000.00, 'PayPal', NULL, '€', '2025-11-10 00:07:20', '2025-11-10 00:07:20'),
(176, 60, 93, 'Refund received', 10000.00, 'lalyaisidore@gmail.com', NULL, '€', '2025-11-10 00:14:25', '2025-11-10 00:14:25'),
(177, 60, 93, 'Transfer sent', 10000.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-10 00:16:35', '2025-11-10 00:16:35'),
(178, 60, 93, 'Refund received', 10000.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-10 12:46:44', '2025-11-10 12:46:44'),
(180, 60, 93, 'Funds added', 1500.00, 'TRANSAFRICASH', NULL, '€', '2025-11-11 00:49:13', '2025-11-11 00:49:13'),
(181, 60, 93, 'Funds deducted', 2000.00, 'TRANSAFRICASH', NULL, '€', '2025-11-11 00:50:03', '2025-11-11 00:50:03'),
(184, 60, 93, 'Funds deducted', 500.00, 'TRANSAFRICASH', NULL, '€', '2025-11-11 07:57:54', '2025-11-11 07:57:54'),
(185, 60, 93, 'Funds deducted', 5.00, 'TRANSAFRICASH', NULL, '€', '2025-11-11 07:58:34', '2025-11-11 07:58:34'),
(186, 60, 93, 'Funds added', 200.00, 'TRANSAFRICASH', NULL, '€', '2025-11-11 08:08:15', '2025-11-11 08:08:15'),
(193, 60, 93, 'Transfer sent', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 11:50:56', '2025-11-11 11:50:56'),
(195, 60, 93, 'Refund received', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 14:59:35', '2025-11-11 14:59:35'),
(196, 60, 93, 'Transfer sent', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 15:39:08', '2025-11-11 15:39:08'),
(197, 60, 93, 'Refund received', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 16:39:49', '2025-11-11 16:39:49'),
(198, 60, 93, 'Transfer sent', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 16:58:33', '2025-11-11 16:58:33'),
(199, 60, 93, 'Refund received', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 17:01:17', '2025-11-11 17:01:17'),
(200, 60, 93, 'Transfer sent', 9200.00, 'PayPal', NULL, '€', '2025-11-11 17:03:34', '2025-11-11 17:03:34'),
(201, 62, 93, 'Transfer sent', 50.00, 'BANK TEST - BIC: AGRIFRPP', NULL, 'EUR', '2025-11-11 17:25:00', '2025-11-11 17:25:00'),
(202, 62, 93, 'Transfer sent', 50.00, 'BANK TEST - BIC: AGRIFRPP', NULL, 'EUR', '2025-11-11 17:25:52', '2025-11-11 17:25:52'),
(203, 62, 93, 'Transfer sent', 50.00, 'BANK TEST - BIC: AGRIFRPP', NULL, 'EUR', '2025-11-11 17:27:26', '2025-11-11 17:27:26'),
(204, 62, 93, 'Transfer sent', 50.00, 'BANK TEST - BIC: AGRIFRPP', NULL, 'EUR', '2025-11-11 17:31:27', '2025-11-11 17:31:27'),
(205, 60, 93, 'Refund received', 9200.00, 'lalyaisidore@gmail.com', NULL, '€', '2025-11-11 17:32:01', '2025-11-11 17:32:01'),
(206, 60, 93, 'Transfer sent', 9200.00, 'PayPal', NULL, '€', '2025-11-11 17:34:12', '2025-11-11 17:34:12'),
(207, 60, 93, 'Refund received', 9200.00, 'lalyaisidore@gmail.com', NULL, '€', '2025-11-11 17:45:08', '2025-11-11 17:45:08'),
(208, 60, 93, 'Transfer sent', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 17:48:01', '2025-11-11 17:48:01'),
(209, 60, 93, 'Refund received', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 18:00:57', '2025-11-11 18:00:57'),
(210, 60, 93, 'Transfer sent', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 18:03:02', '2025-11-11 18:03:02'),
(211, 60, 93, 'Refund received', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 19:30:52', '2025-11-11 19:30:52'),
(212, 60, 93, 'Transfer sent', 9200.00, 'PayPal', NULL, '€', '2025-11-11 19:33:24', '2025-11-11 19:33:24'),
(213, 60, 93, 'Refund received', 9200.00, 'lalyaisidore@gmail.com', NULL, '€', '2025-11-11 19:36:17', '2025-11-11 19:36:17'),
(214, 60, 93, 'Transfer sent', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 19:38:31', '2025-11-11 19:38:31'),
(215, 60, 93, 'Refund received', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 19:45:04', '2025-11-11 19:45:04'),
(216, 60, 93, 'Transfer sent', 9200.00, 'PayPal', NULL, '€', '2025-11-11 19:47:05', '2025-11-11 19:47:05'),
(217, 60, 93, 'Refund received', 9200.00, 'lalyaisidore@gmail.com', NULL, '€', '2025-11-11 19:48:49', '2025-11-11 19:48:49'),
(218, 60, 93, 'Transfer sent', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 19:51:14', '2025-11-11 19:51:14'),
(219, 60, 93, 'Refund received', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 19:56:56', '2025-11-11 19:56:56'),
(220, 60, 93, 'Transfer sent', 9200.00, 'PayPal', NULL, '€', '2025-11-11 19:59:31', '2025-11-11 19:59:31'),
(221, 60, 93, 'Refund received', 9200.00, 'lalyaisidore@gmail.com', NULL, '€', '2025-11-11 20:01:34', '2025-11-11 20:01:34'),
(222, 60, 93, 'Transfer sent', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 20:03:54', '2025-11-11 20:03:54'),
(223, 60, 93, 'Refund received', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 20:07:31', '2025-11-11 20:07:31'),
(224, 60, 93, 'Transfer sent', 9200.00, 'PayPal', NULL, '€', '2025-11-11 20:09:43', '2025-11-11 20:09:43'),
(225, 60, 93, 'Refund received', 9200.00, 'lalyaisidore@gmail.com', NULL, '€', '2025-11-11 20:11:45', '2025-11-11 20:11:45'),
(226, 60, 93, 'Transfer sent', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 20:13:55', '2025-11-11 20:13:55'),
(227, 60, 93, 'Refund received', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 20:24:25', '2025-11-11 20:24:25'),
(228, 60, 93, 'Transfer sent', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 20:26:44', '2025-11-11 20:26:44'),
(229, 60, 93, 'Refund received', 9200.00, 'ParisBas - BIC: BE19420', NULL, '€', '2025-11-11 20:33:30', '2025-11-11 20:33:30'),
(230, 60, 93, 'Transfer sent', 9200.00, 'PayPal', NULL, '€', '2025-11-11 20:35:48', '2025-11-11 20:35:48'),
(231, 60, 93, 'Funds added', 50000.00, 'TRANSAFRICASH', NULL, '€', '2025-11-11 20:48:52', '2025-11-11 20:48:52'),
(232, 60, 93, 'Funds added', 50000.00, 'TRANSAFRICASH', NULL, '€', '2025-11-11 20:48:55', '2025-11-11 20:48:55'),
(233, 60, 93, 'Funds added', 50000.00, 'TRANSAFRICASH', NULL, '€', '2025-11-11 20:48:58', '2025-11-11 20:48:58'),
(266, 70, 106, 'Solde initial', 10000.00, 'Flux Bank', NULL, '€', '2025-11-14 16:03:58', '2025-11-14 16:03:58'),
(267, 70, 106, 'Funds added', 15000.00, 'TRANSAFRICASH', NULL, '€', '2025-11-14 16:08:36', '2025-11-14 16:08:36'),
(271, 60, 93, 'Funds added', 300.00, 'TRANSAFRICASH', NULL, '€', '2025-11-17 07:55:19', '2025-11-17 07:55:19'),
(272, 60, 93, 'Funds added', 200.00, 'TRANSAFRICASH', NULL, '€', '2025-11-17 10:35:00', '2025-11-17 10:35:00'),
(273, 60, 93, 'Transfer sent', 150510.00, 'Paribas - BIC: 1234567', NULL, '€', '2025-11-18 15:55:39', '2025-11-18 15:55:39'),
(274, 60, 93, 'Refund received', 150510.00, 'Paribas - BIC: 1234567', NULL, '€', '2025-11-18 15:57:29', '2025-11-18 15:57:29'),
(275, 60, 93, 'Transfer sent', 150510.00, 'PayPal', NULL, '€', '2025-11-18 16:04:57', '2025-11-18 16:04:57'),
(276, 71, 108, 'Solde initial', 10000.00, 'Flux Bank', NULL, '€', '2025-11-18 16:44:53', '2025-11-18 16:44:53'),
(277, 72, 109, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-18 21:46:39', '2025-11-18 21:46:39'),
(278, 73, 110, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-19 07:20:41', '2025-11-19 07:20:41'),
(279, 74, 111, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-19 12:22:08', '2025-11-19 12:22:08'),
(280, 75, 112, 'Solde initial', 10000.00, 'Flux Bank', NULL, '€', '2025-11-19 15:16:38', '2025-11-19 15:16:38'),
(281, 75, 112, 'Transfer sent', 10000.00, 'Bcp - BIC: BCP123', NULL, '€', '2025-11-19 15:56:26', '2025-11-19 15:56:26'),
(282, 76, 113, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-19 15:59:42', '2025-11-19 15:59:42'),
(283, 77, 114, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-20 08:05:16', '2025-11-20 08:05:16'),
(284, 78, 115, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-20 08:25:44', '2025-11-20 08:25:44'),
(285, 70, 116, 'Funds added', 700000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-20 09:18:56', '2025-11-20 09:18:56'),
(286, 79, 117, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-20 09:23:52', '2025-11-20 09:23:52'),
(287, 80, 118, 'Solde initial', 10000.00, 'Flux Bank', NULL, '€', '2025-11-20 12:16:29', '2025-11-20 12:16:29'),
(288, 81, 119, 'Solde initial', 10000.00, 'Flux Bank', NULL, '€', '2025-11-20 13:19:32', '2025-11-20 13:19:32'),
(289, 82, 120, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-20 17:53:35', '2025-11-20 17:53:35'),
(290, 83, 121, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-20 23:40:44', '2025-11-20 23:40:44'),
(291, 84, 122, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-21 00:57:06', '2025-11-21 00:57:06'),
(292, 85, 123, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-21 07:18:21', '2025-11-21 07:18:21'),
(293, 85, 123, 'Transfer sent', 10000.00, 'Tu - BIC: Azerty', NULL, '€', '2025-11-21 09:25:13', '2025-11-21 09:25:13'),
(294, 85, 123, 'Refund received', 10000.00, 'Tu - BIC: Azerty', NULL, '€', '2025-11-21 09:51:57', '2025-11-21 09:51:57'),
(295, 60, 124, 'Funds added', 870000.00, 'TRANSFERFLUX', NULL, 'XOF', '2025-11-21 21:28:47', '2025-11-21 21:28:47'),
(296, 60, 124, 'Transfer sent', 870000.00, '+22 676580456 - Orange Money - BIC: ORANGE', NULL, 'XOF', '2025-11-21 21:35:25', '2025-11-21 21:35:25'),
(297, 60, 124, 'Funds added', 540000.00, 'TRANSAFRICASH', NULL, 'XOF', '2025-11-21 21:36:22', '2025-11-21 21:36:22'),
(298, 60, 124, 'Transfer sent', 540000.00, '+22 676580456 - Wave - BIC: WAVE', NULL, 'XOF', '2025-11-21 21:40:19', '2025-11-21 21:40:19'),
(299, 60, 124, 'Refund received', 540000.00, 'Wave - BIC: WAVE', NULL, 'XOF', '2025-11-21 21:41:31', '2025-11-21 21:41:31'),
(300, 60, 124, 'Transfer sent', 540000.00, '+2250 596385213 - MTN Money - BIC: MTN', NULL, 'XOF', '2025-11-21 21:45:13', '2025-11-21 21:45:13'),
(303, 60, 93, 'Refund received', 540000.00, 'MTN Money - BIC: MTN', NULL, '€', '2025-11-23 06:45:14', '2025-11-23 06:45:14'),
(307, 60, 93, 'Transfer sent', 540000.00, 'AXA - BIC: BE19420', NULL, '€', '2025-11-23 20:21:27', '2025-11-23 20:21:27'),
(308, 60, 93, 'Refund received', 540000.00, 'AXA - BIC: BE19420', NULL, '€', '2025-11-23 20:26:44', '2025-11-23 20:26:44'),
(309, 83, 130, 'Funds added', 300000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-24 21:00:41', '2025-11-24 21:00:41'),
(310, 83, 131, 'Funds added', 14000000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-24 21:14:06', '2025-11-24 21:14:06'),
(312, 84, 133, 'Funds added', 44000.00, 'TRANSFERFLUX', NULL, 'PEN', '2025-11-24 22:32:55', '2025-11-24 22:32:55'),
(313, 87, 134, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-25 12:08:44', '2025-11-25 12:08:44'),
(314, 84, 135, 'Funds added', 350000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-25 12:37:26', '2025-11-25 12:37:26'),
(315, 88, 136, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-26 20:32:18', '2025-11-26 20:32:18'),
(316, 87, 137, 'Funds added', 500000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-28 12:16:19', '2025-11-28 12:16:19'),
(317, 60, 93, 'Transfer sent', 540250.00, 'PARIBAS - BIC: DE34632 - IBAN: FR897654324567', 93, '€', '2025-11-28 17:21:45', '2025-11-28 17:21:45'),
(318, 60, 93, 'Refund received', 540250.00, 'PARIBAS - BIC: DE34632', NULL, '€', '2025-11-28 20:34:42', '2025-11-28 20:34:42'),
(319, 60, 93, 'Transfer sent', 540250.00, 'PayPal', 94, '€', '2025-11-28 20:38:46', '2025-11-28 20:38:46'),
(320, 60, 93, 'Refund received', 540250.00, 'lalyaisidore@gmail.com', NULL, '€', '2025-11-28 20:40:25', '2025-11-28 20:40:25'),
(321, 60, 93, 'Transfer sent', 540250.00, 'BELFIUS - BIC: TX357799 - IBAN: BE38967728519472', 95, '€', '2025-11-28 20:53:31', '2025-11-28 20:53:31'),
(322, 89, 138, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-28 21:44:58', '2025-11-28 21:44:58'),
(323, 89, 138, 'Transfer sent', 10000.00, 'Paribas - BIC: 12345 - IBAN: 123446789', 96, '€', '2025-11-28 21:50:20', '2025-11-28 21:50:20'),
(324, 89, 138, 'Refund received', 10000.00, 'Paribas - BIC: 12345', NULL, '€', '2025-11-28 21:51:38', '2025-11-28 21:51:38'),
(325, 89, 138, 'Funds deducted', 200.00, 'TRANSFERFLUX', NULL, '€', '2025-11-28 21:53:23', '2025-11-28 21:53:23'),
(326, 89, 138, 'Funds added', 300.00, 'TRANSFERFLUX', NULL, '€', '2025-11-28 21:53:50', '2025-11-28 21:53:50'),
(327, 90, 139, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-28 22:05:21', '2025-11-28 22:05:21'),
(328, 60, 140, 'Funds added', 560000.00, 'TRANSFERFLUX', NULL, '€', '2025-11-29 09:35:12', '2025-11-29 09:35:12'),
(329, 60, 140, 'Funds added', 200.00, 'TRANSFERFLUX', NULL, '€', '2025-12-01 08:52:21', '2025-12-01 08:52:21'),
(330, 60, 140, 'Funds deducted', 200.00, 'TRANSFERFLUX', NULL, '€', '2025-12-01 08:53:29', '2025-12-01 08:53:29'),
(331, 60, 140, 'Transfer sent', 560000.00, 'ParisBas - BIC: TRWIBEB1XXX - IBAN: DE45092671244566', 97, '€', '2025-12-02 09:29:07', '2025-12-02 09:29:07'),
(332, 60, 140, 'Refund received', 560000.00, 'ParisBas - BIC: TRWIBEB1XXX', NULL, '€', '2025-12-02 09:52:12', '2025-12-02 09:52:12'),
(333, 60, 140, 'Transfer sent', 560000.00, 'AXA - BIC: TRWIBEB1XXX - IBAN: FR35679876425', 98, '€', '2025-12-02 10:00:31', '2025-12-02 10:00:31'),
(334, 60, 140, 'Refund received', 560000.00, 'AXA - BIC: TRWIBEB1XXX', NULL, '€', '2025-12-02 12:50:46', '2025-12-02 12:50:46'),
(335, 60, 140, 'Transfer sent', 560000.00, 'AXA - BIC: TRWIBEB1XXX - IBAN: FR35679876425', 99, '€', '2025-12-02 12:58:15', '2025-12-02 12:58:15'),
(336, 60, 140, 'Refund received', 560000.00, 'AXA - BIC: TRWIBEB1XXX', NULL, '€', '2025-12-02 13:15:14', '2025-12-02 13:15:14'),
(337, 60, 140, 'Transfer sent', 560000.00, 'AXA - BIC: TRWIBEB1XXX - IBAN: FR35679876425', 100, '€', '2025-12-02 13:17:59', '2025-12-02 13:17:59'),
(338, 60, 140, 'Refund received', 560000.00, 'AXA - BIC: TRWIBEB1XXX', NULL, '€', '2025-12-02 13:26:47', '2025-12-02 13:26:47'),
(339, 60, 140, 'Transfer sent', 560000.00, 'AXA - BIC: TRWIBEB1XXX - IBAN: FR35679876425', 101, '€', '2025-12-02 15:30:29', '2025-12-02 15:30:29'),
(340, 60, 140, 'Refund received', 560000.00, 'AXA - BIC: TRWIBEB1XXX', NULL, '€', '2025-12-02 15:36:26', '2025-12-02 15:36:26'),
(341, 60, 140, 'Transfer sent', 560000.00, 'AXA - BIC: TRWIBEB1XXX - IBAN: FR35679876425', 102, '€', '2025-12-02 15:39:12', '2025-12-02 15:39:12'),
(342, 60, 140, 'Refund received', 560000.00, 'AXA - BIC: TRWIBEB1XXX', NULL, '€', '2025-12-02 15:47:49', '2025-12-02 15:47:49'),
(343, 60, 140, 'Funds added', 500.00, 'TRANSFERFLUX', NULL, '€', '2025-12-02 16:48:46', '2025-12-02 16:48:46'),
(344, 60, 140, 'Funds deducted', 200.00, 'TRANSFERFLUX', NULL, '€', '2025-12-02 16:49:35', '2025-12-02 16:49:35'),
(345, 60, 93, 'Refund received', 540250.00, 'BELFIUS - BIC: TX357799', NULL, '€', '2025-12-02 22:37:59', '2025-12-02 22:37:59'),
(346, 60, 140, 'Transfer sent', 560300.00, 'PARIBAS - BIC: TX357799 - IBAN: BE38967728519472', 103, '€', '2025-12-02 22:56:23', '2025-12-02 22:56:23'),
(347, 91, 141, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-03 12:24:27', '2025-12-03 12:24:27'),
(348, 60, 93, 'Transfer sent', 540250.00, 'PARIBAS - BIC: TX357799 - IBAN: FR897654324567', 104, '€', '2025-12-03 17:23:53', '2025-12-03 17:23:53'),
(349, 60, 93, 'Refund received', 540250.00, 'PARIBAS - BIC: TX357799', NULL, '€', '2025-12-03 17:26:59', '2025-12-03 17:26:59'),
(353, 95, 145, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-04 09:03:55', '2025-12-04 09:03:55'),
(354, 95, 145, 'Transfer sent', 10000.00, 'PayPal', 105, '€', '2025-12-04 09:26:04', '2025-12-04 09:26:04'),
(356, 97, 147, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-04 13:41:27', '2025-12-04 13:41:27'),
(357, 98, 148, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-04 19:46:41', '2025-12-04 19:46:41'),
(358, 99, 149, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-05 20:29:23', '2025-12-05 20:29:23'),
(359, 100, 150, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-06 10:36:30', '2025-12-06 10:36:30'),
(360, 84, 135, 'Transfer sent', 350000.00, 'S-pankki - BIC: SBANFIHH - IBAN: FI5139390016468548', 106, '€', '2025-12-08 12:49:45', '2025-12-08 12:49:45'),
(361, 101, 151, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-12 09:22:39', '2025-12-12 09:22:39'),
(362, 70, 152, 'Funds added', 50913.66, 'TRANSFERFLUX', NULL, 'RON', '2025-12-12 15:47:47', '2025-12-12 15:47:47'),
(363, 60, 140, 'Refund received', 560300.00, 'PARIBAS - BIC: TX357799', NULL, '€', '2025-12-15 17:13:50', '2025-12-15 17:13:50'),
(364, 60, 93, 'Transfer sent', 540250.00, 'PARIBAS - BIC: TX357799 - IBAN: FR897654324567', 107, '€', '2025-12-15 17:21:11', '2025-12-15 17:21:11'),
(365, 60, 93, 'Refund received', 540250.00, 'PARIBAS - BIC: TX357799', NULL, '€', '2025-12-15 17:24:42', '2025-12-15 17:24:42'),
(366, 100, 150, 'Transfer sent', 10000.00, 'CBAO - BIC: CBAOSNDA - IBAN: 035171944001', 108, '€', '2025-12-16 14:56:21', '2025-12-16 14:56:21'),
(367, 90, 153, 'Funds added', 962775.00, 'TRANSFERFLUX', NULL, 'R$', '2025-12-16 19:11:44', '2025-12-16 19:11:44'),
(368, 90, 139, 'Transfer sent', 10000.00, 'BNP Paribas - BIC: 5356789 - IBAN: FR152727282929292', 109, '€', '2025-12-16 19:35:49', '2025-12-16 19:35:49'),
(369, 102, 154, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-16 19:43:13', '2025-12-16 19:43:13'),
(370, 100, 150, 'Refund received', 10000.00, 'CBAO - BIC: CBAOSNDA', NULL, '€', '2025-12-17 20:58:18', '2025-12-17 20:58:18'),
(371, 70, 155, 'Funds added', 7633.27, 'TRANSFERFLUX', NULL, '$', '2025-12-19 13:41:54', '2025-12-19 13:41:54'),
(372, 90, 156, 'Funds added', 62841835.00, 'TRANSFERFLUX', NULL, '₽', '2025-12-20 12:57:16', '2025-12-20 12:57:16'),
(373, 103, 157, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-20 19:40:50', '2025-12-20 19:40:50'),
(374, 103, 158, 'Funds added', 4000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-20 21:24:08', '2025-12-20 21:24:08'),
(375, 103, 157, 'Transfer sent', 10000.00, 'BANCO ATLÂNTICO EUROPA, SA - BIC: BAPAPTPLXXX - IBAN: PT50 0189 0006 0994 4710 0014 8', 110, '€', '2025-12-20 22:41:25', '2025-12-20 22:41:25'),
(376, 103, 157, 'Refund received', 10000.00, 'BANCO ATLÂNTICO EUROPA, SA - BIC: BAPAPTPLXXX', NULL, '€', '2025-12-20 22:43:42', '2025-12-20 22:43:42'),
(377, 104, 159, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-22 20:44:09', '2025-12-22 20:44:09'),
(378, 105, 160, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-22 21:02:47', '2025-12-22 21:02:47'),
(379, 106, 161, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-22 21:41:34', '2025-12-22 21:41:34'),
(380, 107, 162, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-22 23:08:48', '2025-12-22 23:08:48'),
(381, 108, 163, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-23 00:53:29', '2025-12-23 00:53:29'),
(383, 110, 165, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-23 06:35:30', '2025-12-23 06:35:30'),
(384, 111, 166, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-23 10:10:31', '2025-12-23 10:10:31'),
(385, 112, 167, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-23 10:55:47', '2025-12-23 10:55:47'),
(386, 113, 168, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-23 10:56:44', '2025-12-23 10:56:44'),
(387, 114, 169, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-23 10:58:00', '2025-12-23 10:58:00'),
(388, 115, 170, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-23 13:18:03', '2025-12-23 13:18:03'),
(389, 116, 171, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-23 14:16:46', '2025-12-23 14:16:46'),
(390, 117, 172, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-23 17:55:16', '2025-12-23 17:55:16'),
(391, 118, 173, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-23 17:57:19', '2025-12-23 17:57:19'),
(392, 119, 174, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-23 19:14:54', '2025-12-23 19:14:54'),
(393, 120, 175, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-23 21:21:23', '2025-12-23 21:21:23'),
(394, 103, 176, 'Funds added', 3500.00, 'TRANSFERFLUX', NULL, '€', '2025-12-24 10:45:51', '2025-12-24 10:45:51'),
(395, 103, 176, 'Funds added', 5.00, 'TRANSFERFLUX', NULL, '€', '2025-12-24 16:53:54', '2025-12-24 16:53:54'),
(396, 103, 176, 'Funds added', 90.00, 'TRANSFERFLUX', NULL, '€', '2025-12-25 13:32:34', '2025-12-25 13:32:34'),
(397, 121, 177, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-25 23:36:29', '2025-12-25 23:36:29'),
(398, 122, 178, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-26 13:24:12', '2025-12-26 13:24:12'),
(399, 123, 179, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-26 13:28:30', '2025-12-26 13:28:30'),
(400, 124, 180, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-26 21:11:19', '2025-12-26 21:11:19'),
(401, 125, 181, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-26 21:14:27', '2025-12-26 21:14:27'),
(402, 103, 176, 'Transfer sent', 3595.00, 'Novo banco - BIC: BESCPTPL - IBAN: Pt50000700000033882585123', 111, '€', '2025-12-30 16:09:55', '2025-12-30 16:09:55'),
(403, 103, 176, 'Refund received', 3595.00, 'Novo banco - BIC: BESCPTPL', NULL, '€', '2025-12-31 12:15:46', '2025-12-31 12:15:46'),
(404, 103, 182, 'Funds added', 25000.00, 'TRANSFERFLUX', NULL, '€', '2025-12-31 15:46:39', '2025-12-31 15:46:39'),
(405, 103, 183, 'Funds added', 5000.00, 'TRANSFERFLUX', NULL, '€', '2026-01-02 16:02:41', '2026-01-02 16:02:41'),
(406, 103, 183, 'Funds added', 5.00, 'TRANSFERFLUX', NULL, '€', '2026-01-05 08:11:01', '2026-01-05 08:11:01'),
(407, 103, 158, 'Funds deducted', 2000.00, 'TRANSFERFLUX', NULL, '€', '2026-01-08 09:59:02', '2026-01-08 09:59:02'),
(408, 103, 184, 'Funds added', 3000.00, 'TRANSFERFLUX', NULL, '€', '2026-01-10 12:43:58', '2026-01-10 12:43:58'),
(409, 126, 185, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2026-01-12 17:32:44', '2026-01-12 17:32:44'),
(410, 126, 185, 'Funds added', 134000.00, 'TRANSFERFLUX', NULL, '€', '2026-01-12 17:35:23', '2026-01-12 17:35:23'),
(411, 103, 184, 'Funds added', 500000.00, 'TRANSFERFLUX', NULL, '€', '2026-01-12 18:08:03', '2026-01-12 18:08:03'),
(412, 103, 184, 'Transfer sent', 503000.00, 'BANCO CTT - BIC: CTTV - IBAN: PT50 0193 0000 1050 0028 4844 0', 112, '€', '2026-01-12 18:16:36', '2026-01-12 18:16:36'),
(413, 103, 184, 'Funds added', 100000.00, 'TRANSFERFLUX', NULL, '€', '2026-01-12 18:17:34', '2026-01-12 18:17:34'),
(414, 103, 184, 'Transfer sent', 100000.00, 'BANCO CTT - BIC: EMPRÉSTIMO - IBAN: PT50 0193 0000 1050 0028 4844 0', 113, '€', '2026-01-12 18:20:46', '2026-01-12 18:20:46'),
(415, 127, 186, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2026-01-20 09:38:35', '2026-01-20 09:38:35'),
(416, 90, 187, 'Funds added', 750000.00, 'TRANSFERFLUX', NULL, '$', '2026-01-21 14:45:16', '2026-01-21 14:45:16'),
(417, 60, 140, 'Transfer sent', 560300.00, 'PayPal', 114, '€', '2026-01-21 17:56:07', '2026-01-21 17:56:07'),
(418, 90, 188, 'Funds added', 750000.00, 'TRANSFERFLUX', NULL, '$', '2026-01-24 14:47:47', '2026-01-24 14:47:47'),
(419, 128, 189, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2026-01-29 06:58:25', '2026-01-29 06:58:25'),
(420, 128, 190, 'Funds added', 750.00, 'TRANSFERFLUX', NULL, '€', '2026-01-29 09:38:49', '2026-01-29 09:38:49'),
(421, 128, 190, 'Funds added', 749250.00, 'TRANSFERFLUX', NULL, '€', '2026-01-29 09:49:41', '2026-01-29 09:49:41'),
(422, 129, 191, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2026-02-04 20:17:11', '2026-02-04 20:17:11'),
(423, 130, 192, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2026-02-05 09:48:26', '2026-02-05 09:48:26'),
(424, 100, 193, 'Funds added', 7000000.00, 'TRANSFERFLUX', NULL, 'XOF', '2026-02-06 14:50:33', '2026-02-06 14:50:33'),
(425, 100, 193, 'Transfer sent', 7000000.00, 'BNI ( BANQUE NATIONAL D\'INVESTISSEMENT) - BIC: CSSSCIABXXX - IBAN: CI93  CI09  2010  0100  5046  5900  1047', 115, 'XOF', '2026-02-09 10:22:20', '2026-02-09 10:22:20'),
(426, 100, 193, 'Refund received', 7000000.00, 'BNI ( BANQUE NATIONAL D\'INVESTISSEMENT) - BIC: CSSSCIABXXX', NULL, 'XOF', '2026-02-11 03:32:19', '2026-02-11 03:32:19'),
(427, 131, 194, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2026-02-12 09:57:27', '2026-02-12 09:57:27'),
(428, 132, 195, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2026-02-13 14:14:36', '2026-02-13 14:14:36'),
(429, 90, 196, 'Funds added', 1180296.60, 'TRANSFERFLUX', NULL, 'zł', '2026-02-17 14:06:36', '2026-02-17 14:06:36'),
(430, 90, 197, 'Funds added', 490000.00, 'TRANSFERFLUX', NULL, '€', '2026-02-17 16:27:58', '2026-02-17 16:27:58'),
(431, 90, 196, 'Transfer sent', 1180296.60, 'Bank pko bd - BIC: PKOPLPW - IBAN: 85102017780000200201187582', 116, 'zł', '2026-02-19 14:02:38', '2026-02-19 14:02:38'),
(432, 133, 198, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2026-02-19 19:22:37', '2026-02-19 19:22:37'),
(433, 134, 199, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2026-02-21 08:47:34', '2026-02-21 08:47:34'),
(434, 90, 196, 'Refund received', 1180296.60, 'Bank pko bd - BIC: PKOPLPW', NULL, 'zł', '2026-02-23 06:54:51', '2026-02-23 06:54:51'),
(435, 135, 200, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2026-02-23 17:51:17', '2026-02-23 17:51:17'),
(436, 136, 201, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2026-02-25 09:10:44', '2026-02-25 09:10:44'),
(437, 137, 202, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2026-03-04 19:34:02', '2026-03-04 19:34:02'),
(438, 100, 193, 'Transfer sent', 7000000.00, 'BNI ( BANQUE NATIONAL D\'INVESTISSEMENT) - BIC: CSSSCIABXXX - IBAN: CI93 CI09 2010 0100 5046 5900 1047', 117, 'XOF', '2026-03-05 15:24:28', '2026-03-05 15:24:28'),
(439, 100, 193, 'Refund received', 7000000.00, 'BNI ( BANQUE NATIONAL D\'INVESTISSEMENT) - BIC: CSSSCIABXXX', NULL, 'XOF', '2026-03-14 16:14:58', '2026-03-14 16:14:58'),
(440, 138, 203, 'Solde initial', 10000.00, 'TRANSFERFLUX', NULL, '€', '2026-03-17 01:39:27', '2026-03-17 01:39:27'),
(441, 100, 193, 'Funds deducted', 7000000.00, 'TRANSFERFLUX', NULL, 'XOF', '2026-03-17 14:17:56', '2026-03-17 14:17:56'),
(442, 100, 150, 'Funds deducted', 200.00, 'TRANSFERFLUX', NULL, '€', '2026-03-17 14:19:55', '2026-03-17 14:19:55'),
(443, 138, 203, 'Transfer sent', 10000.00, 'Parubas - BIC: FR217 - IBAN: FR12345668458', 118, '€', '2026-03-21 09:13:00', '2026-03-21 09:13:00'),
(444, 138, 203, 'Refund received', 10000.00, 'Parubas - BIC: FR217', NULL, '€', '2026-03-21 09:17:29', '2026-03-21 09:17:29');

-- --------------------------------------------------------

--
-- Structure de la table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `compte_id` bigint(20) UNSIGNED DEFAULT NULL,
  `compte_id_inferred` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `numerocompte` varchar(255) NOT NULL,
  `name_servieur` varchar(255) NOT NULL,
  `beneficiary_name` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `devise` text NOT NULL,
  `token` text NOT NULL,
  `solidvire` text NOT NULL,
  `status` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transfers`
--

INSERT INTO `transfers` (`id`, `compte_id`, `compte_id_inferred`, `user_id`, `numerocompte`, `name_servieur`, `beneficiary_name`, `reason`, `devise`, `token`, `solidvire`, `status`, `created_at`, `updated_at`) VALUES
(22, NULL, 1, 60, '123456789', 'AXA - BIC: TRWIBEB1XXX', 'NOUKPO', '1', '€', '', '6000.00', 'rembourse', '2025-11-08 10:18:20', '2025-11-08 09:23:23'),
(23, NULL, 1, 60, '123456789', 'AXA - BIC: TRWIBEB1XXX', 'NOUKPO', '1', '€', '', '6000.00', 'rembourse', '2025-11-08 10:24:15', '2025-11-08 09:43:09'),
(24, NULL, 1, 60, '123456789', 'AXA - BIC: TRWIBEB1XXX', 'NOUKPO', '1', '€', '', '6000.00', 'rembourse', '2025-11-08 10:43:51', '2025-11-08 09:52:05'),
(25, NULL, 1, 60, '123456789', 'AXA - BIC: TRWIBEB1XXX', 'NOUKPO', '1', '€', '', '6000.00', 'rembourse', '2025-11-08 10:52:50', '2025-11-08 09:56:49'),
(26, NULL, 1, 60, '123456789B', 'AXA - BIC: TRWIBEB1XXX', 'NOUKPO', '1', '€', '', '6000.00', 'rembourse', '2025-11-08 10:57:37', '2025-11-08 10:19:13'),
(27, NULL, 1, 60, '12345678', 'AXA - BIC: TRWIBEB1XXX', 'NOUKPO', '1', '€', '', '6000.00', 'rembourse', '2025-11-08 11:20:32', '2025-11-08 10:27:46'),
(28, NULL, 1, 60, '123456789', 'AXA - BIC: TRWIBEB1XXX', 'NOUKPO', '1', '€', '', '6000.00', 'rembourse', '2025-11-08 11:28:20', '2025-11-08 10:33:38'),
(29, NULL, 1, 60, '1000', 'AXA - BIC: TRWIBEB1XXX', 'NOUKPO', '1', '€', '', '1000.00', 'rembourse', '2025-11-08 11:36:18', '2025-11-08 10:39:55'),
(30, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', '', '€', '', '10000', 'rembourse', '2025-11-08 17:49:36', '2025-11-08 16:52:27'),
(31, NULL, 1, 60, '123456789', 'AXA - BIC: TRWIBEB1XXX', 'NOUKPO', '1', '€', '', '10000.00', 'rembourse', '2025-11-08 21:46:50', '2025-11-09 08:12:58'),
(32, NULL, 1, 60, '123456778', 'AXA - BIC: TRWIBEB1XXX', 'NOUKPO', '1', '€', '', '10000.00', 'rembourse', '2025-11-09 09:33:55', '2025-11-09 08:36:39'),
(33, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '10000', 'completed', '2025-11-09 11:57:03', '2025-11-09 11:57:03'),
(34, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '10000', 'completed', '2025-11-09 12:01:57', '2025-11-09 12:01:57'),
(35, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '10000', 'completed', '2025-11-09 12:03:53', '2025-11-09 12:03:53'),
(36, NULL, 1, 60, '123456789', 'AXA - BIC: TRWIBEB1XXX', 'NOUKPO', '1', '€', '', '10000', 'completed', '2025-11-09 12:07:57', '2025-11-09 12:07:57'),
(37, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '10000', 'completed', '2025-11-09 12:12:18', '2025-11-09 12:12:18'),
(38, NULL, 1, 60, '123456789', 'AXA - BIC: TRWIBEB1XXX', 'NOUKPO', '1', '€', '', '10000', 'completed', '2025-11-09 12:20:07', '2025-11-09 12:20:07'),
(39, NULL, 1, 60, '1234556789', 'BE3245678945 - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '10000', 'rembourse', '2025-11-09 12:31:17', '2025-11-09 11:33:39'),
(40, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '10000', 'rembourse', '2025-11-09 12:34:45', '2025-11-09 11:47:24'),
(41, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '10000', 'rembourse', '2025-11-09 12:47:51', '2025-11-09 11:50:39'),
(42, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '10000', 'rembourse', '2025-11-09 13:07:40', '2025-11-09 17:22:53'),
(43, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '10000', 'rembourse', '2025-11-09 18:31:39', '2025-11-09 17:47:18'),
(44, NULL, 1, 60, '1234567890', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '10000', 'rembourse', '2025-11-09 18:49:59', '2025-11-09 17:54:58'),
(45, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '10000', 'rembourse', '2025-11-09 18:59:34', '2025-11-09 18:02:02'),
(46, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '10000', 'rembourse', '2025-11-09 19:03:51', '2025-11-09 18:09:05'),
(47, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '10000', 'rembourse', '2025-11-09 19:11:36', '2025-11-09 22:36:14'),
(48, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'Règlement de compte', '€', '', '10000', 'rembourse', '2025-11-09 23:39:29', '2025-11-09 22:53:58'),
(49, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '10000', 'rembourse', '2025-11-10 00:09:39', '2025-11-09 23:13:54'),
(50, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '10000', 'rembourse', '2025-11-10 01:02:38', '2025-11-10 00:05:16'),
(51, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'Règlement de compte', '€', '', '10000', 'rembourse', '2025-11-10 01:05:40', '2025-11-10 00:14:25'),
(52, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '10000', 'rembourse', '2025-11-10 01:14:54', '2025-11-10 12:46:44'),
(53, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '1000', 'rembourse', '2025-11-11 10:42:13', '2025-11-11 09:48:08'),
(54, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '1000', 'rembourse', '2025-11-11 10:48:42', '2025-11-11 09:55:41'),
(55, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '1000', 'completed', '2025-11-11 10:56:39', '2025-11-11 10:56:39'),
(57, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '9200', 'rembourse', '2025-11-11 12:49:16', '2025-11-11 14:59:35'),
(58, NULL, 1, 60, '1234567890', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '9200', 'rembourse', '2025-11-11 16:37:27', '2025-11-11 16:39:49'),
(59, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '9200', 'rembourse', '2025-11-11 17:56:52', '2025-11-11 17:01:17'),
(60, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '9200', 'rembourse', '2025-11-11 18:01:54', '2025-11-11 17:32:01'),
(67, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '9200', 'rembourse', '2025-11-11 18:32:32', '2025-11-11 17:45:08'),
(68, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '9200', 'rembourse', '2025-11-11 18:46:19', '2025-11-11 18:00:57'),
(69, NULL, 1, 60, '1234567890', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '9200', 'rembourse', '2025-11-11 19:01:22', '2025-11-11 19:30:52'),
(70, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '9200', 'rembourse', '2025-11-11 20:31:43', '2025-11-11 19:36:17'),
(71, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '9200', 'rembourse', '2025-11-11 20:36:51', '2025-11-11 19:45:04'),
(72, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '9200', 'rembourse', '2025-11-11 20:45:25', '2025-11-11 19:48:49'),
(73, NULL, 1, 60, '1234567890', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '9200', 'rembourse', '2025-11-11 20:49:34', '2025-11-11 19:56:56'),
(74, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '9200', 'rembourse', '2025-11-11 20:57:51', '2025-11-11 20:01:34'),
(75, NULL, 1, 60, '1234444', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '9200', 'rembourse', '2025-11-11 21:02:13', '2025-11-11 20:07:31'),
(76, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '9200', 'rembourse', '2025-11-11 21:08:03', '2025-11-11 20:11:45'),
(77, NULL, 1, 60, '123322123', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '9200', 'rembourse', '2025-11-11 21:12:15', '2025-11-11 20:24:25'),
(78, NULL, 1, 60, '1234567890', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', '€', '', '9200', 'rembourse', '2025-11-11 21:25:04', '2025-11-11 20:33:30'),
(79, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', '€', '', '9200', 'completed', '2025-11-11 21:34:08', '2025-11-11 21:34:08'),
(80, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', 'NIO', '', '3100', 'rembourse', '2025-11-12 20:54:01', '2025-11-12 21:04:53'),
(81, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', 'NIO', '', '3100', 'completed', '2025-11-12 22:23:37', '2025-11-12 22:23:37'),
(82, NULL, 1, 60, '123456789', 'ParisBas - BIC: BE19420', 'LALYA', 'Règlement de compte', 'NIO', '', '2700', 'rembourse', '2025-11-13 07:49:43', '2025-11-13 06:52:09'),
(83, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'transfert', 'NIO', '', '2700', 'rembourse', '2025-11-13 07:52:41', '2025-11-13 07:45:17'),
(84, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'Transferts', '€', '', '2300', 'rembourse', '2025-11-15 15:31:19', '2025-11-16 13:43:54'),
(85, NULL, 1, 60, '123456789', 'Paribas - BIC: 1234567', 'Candide', 'transfert', '€', '', '150510', 'rembourse', '2025-11-18 16:53:57', '2025-11-18 15:57:29'),
(86, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'Transfert', '€', '', '150510', 'completed', '2025-11-18 17:03:15', '2025-11-18 17:03:15'),
(87, NULL, 1, 75, '19400345542031', 'Bcp - BIC: BCP123', 'Hugo PITMAN', 'Donacion', '€', '', '10000', 'completed', '2025-11-19 16:54:44', '2025-11-19 16:54:44'),
(88, NULL, 1, 85, '1234567', 'Tu - BIC: Azerty', 'Mionet-rosignol', 'Transfert', '€', '', '10000', 'rembourse', '2025-11-21 10:23:31', '2025-11-21 09:51:57'),
(89, NULL, 1, 60, '+22 676580456', 'Orange Money - BIC: ORANGE', 'Jack OUEDRAOGO', 'Transfert', 'XOF', '', '870000', 'completed', '2025-11-21 22:33:39', '2025-11-21 22:33:39'),
(90, NULL, 1, 60, '+22 676580456', 'Wave - BIC: WAVE', 'Jack OUEDRAOGO', 'Transfert', 'XOF', '', '540000', 'rembourse', '2025-11-21 22:38:37', '2025-11-21 21:41:31'),
(91, NULL, 1, 60, '+2250 596385213', 'MTN Money - BIC: MTN', 'Comlan Cossi', 'Transfert', 'XOF', '', '540000', 'rembourse', '2025-11-21 22:43:27', '2025-11-23 06:45:14'),
(92, NULL, 1, 60, 'BE123456789', 'AXA - BIC: BE19420', 'Lalya', '1', '€', '', '540000', 'rembourse', '2025-11-23 21:19:45', '2025-11-23 20:26:44'),
(93, NULL, 1, 60, 'FR897654324567', 'PARIBAS - BIC: DE34632', 'Candide', 'Règlement de compte', '€', '', '540250', 'rembourse', '2025-11-28 18:19:34', '2025-11-28 20:34:42'),
(94, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', 'Règlement de services', '€', '', '540250', 'rembourse', '2025-11-28 21:37:05', '2025-11-28 20:40:25'),
(95, NULL, 1, 60, 'BE38967728519472', 'BELFIUS - BIC: TX357799', 'Credo M’BA', 'Transfer', '€', '', '540250', 'rembourse', '2025-11-28 21:51:51', '2025-12-02 22:37:59'),
(96, NULL, 1, 89, '123446789', 'Paribas - BIC: 12345', 'Dossier', 'Transfert', '€', '', '10000', 'rembourse', '2025-11-28 22:48:40', '2025-11-28 21:51:38'),
(97, NULL, 1, 60, 'DE45092671244566', 'ParisBas - BIC: TRWIBEB1XXX', 'NOUKPO DAGBEMABU', 'Règlement de compte', '€', '', '560000', 'rembourse', '2025-12-02 10:27:27', '2025-12-02 09:52:12'),
(98, NULL, 1, 60, 'FR35679876425', 'AXA - BIC: TRWIBEB1XXX', 'LALYA', 'Règlement de compte', '€', '', '560000', 'rembourse', '2025-12-02 10:58:50', '2025-12-02 12:50:46'),
(99, NULL, 1, 60, 'FR35679876425', 'AXA - BIC: TRWIBEB1XXX', 'LALYA', 'Règlement de compte', '€', '', '560000', 'rembourse', '2025-12-02 13:56:34', '2025-12-02 13:15:14'),
(100, NULL, 1, 60, 'FR35679876425', 'AXA - BIC: TRWIBEB1XXX', 'LALYA', 'Règlement de compte', '€', '', '560000', 'rembourse', '2025-12-02 14:16:18', '2025-12-02 13:26:47'),
(101, NULL, 1, 60, 'FR35679876425', 'AXA - BIC: TRWIBEB1XXX', 'LALYA', 'Règlement de compte', '€', '', '560000', 'rembourse', '2025-12-02 16:28:45', '2025-12-02 15:36:25'),
(102, NULL, 1, 60, 'FR35679876425', 'AXA - BIC: TRWIBEB1XXX', 'LALYA', 'Règlement de compte', '€', '', '560000', 'rembourse', '2025-12-02 16:37:32', '2025-12-02 15:47:49'),
(103, NULL, 1, 60, 'BE38967728519472', 'PARIBAS - BIC: TX357799', 'Credo M’BA', 'Règlement de service', '€', '', '560300', 'rembourse', '2025-12-02 23:54:44', '2025-12-15 17:13:50'),
(104, NULL, 1, 60, 'FR897654324567', 'PARIBAS - BIC: TX357799', 'Credo M’BA', 'transfert', '€', '', '540250', 'rembourse', '2025-12-03 18:22:13', '2025-12-03 17:26:59'),
(105, NULL, 1, 95, 'PayPal', 'ezechieltchokponhoue@gmail.com', 'PayPal - ezechieltchokponhoue@gmail.com', 'Don', '€', '', '10000', 'completed', '2025-12-04 10:24:22', '2025-12-04 10:24:22'),
(106, NULL, 1, 84, 'FI5139390016468548', 'S-pankki - BIC: SBANFIHH', 'komi Marja Aulikki', 'Don', '€', '', '350000', 'completed', '2025-12-08 13:48:03', '2025-12-08 13:48:03'),
(107, NULL, 1, 60, 'FR897654324567', 'PARIBAS - BIC: TX357799', 'Lalya isidore', 'Transfer', '€', '', '540250', 'rembourse', '2025-12-15 18:19:31', '2025-12-15 17:24:42'),
(108, NULL, 1, 100, '035171944001', 'CBAO - BIC: CBAOSNDA', 'DIOUF Babacar', 'Projet d\'élevage', '€', '', '10000', 'rembourse', '2025-12-16 15:54:40', '2025-12-17 20:58:18'),
(109, NULL, 1, 90, 'FR152727282929292', 'BNP Paribas - BIC: 5356789', 'Claire Rouselle', 'Instantané', '€', '', '10000', 'completed', '2025-12-16 20:34:09', '2025-12-16 20:34:09'),
(110, NULL, 1, 103, 'PT50 0189 0006 0994 4710 0014 8', 'BANCO ATLÂNTICO EUROPA, SA - BIC: BAPAPTPLXXX', 'Daryl lil', 'Motuf', '€', '', '10000', 'rembourse', '2025-12-20 23:39:43', '2025-12-20 22:43:42'),
(111, NULL, 1, 103, 'Pt50000700000033882585123', 'Novo banco - BIC: BESCPTPL', 'Ana Paula troncao soares', 'Imprestimo', '€', '', '3595', 'rembourse', '2025-12-30 17:08:15', '2025-12-31 12:15:46'),
(112, NULL, 1, 103, 'PT50 0193 0000 1050 0028 4844 0', 'BANCO CTT - BIC: CTTV', 'SARA RIBEIRO', 'EMPRÉSTIMO', '€', '', '503000', 'completed', '2026-01-12 19:14:57', '2026-01-12 19:14:57'),
(113, NULL, 1, 103, 'PT50 0193 0000 1050 0028 4844 0', 'BANCO CTT - BIC: EMPRÉSTIMO', 'SARA RIBEIRO', 'EMPRÉSTIMO', '€', '', '100000', 'completed', '2026-01-12 19:19:07', '2026-01-12 19:19:07'),
(114, NULL, 1, 60, 'PayPal', 'lalyaisidore@gmail.com', 'PayPal - lalyaisidore@gmail.com', '1', '€', '', '560300', 'completed', '2026-01-21 18:54:26', '2026-01-21 18:54:26'),
(115, NULL, 1, 100, 'CI93  CI09  2010  0100  5046  5900  1047', 'BNI ( BANQUE NATIONAL D\'INVESTISSEMENT) - BIC: CSSSCIABXXX', 'N\'DOLI KOUAME FRANCOIS', 'PRÊT', 'XOF', '', '7000000', 'rembourse', '2026-02-09 11:20:37', '2026-02-11 03:32:19'),
(116, NULL, 1, 90, '85102017780000200201187582', 'Bank pko bd - BIC: PKOPLPW', 'Daniel Kruszewski', 'Darowizna', 'zł', '', '1180296.6', 'rembourse', '2026-02-19 15:00:57', '2026-02-23 06:54:51'),
(117, NULL, 1, 100, 'CI93 CI09 2010 0100 5046 5900 1047', 'BNI ( BANQUE NATIONAL D\'INVESTISSEMENT) - BIC: CSSSCIABXXX', 'N\'DOLI KOUAME FRANCOIS', 'SOUTIEN FAMILIAL', 'XOF', '', '7000000', 'rembourse', '2026-03-05 16:22:47', '2026-03-14 16:14:58'),
(118, NULL, 1, 138, 'FR12345668458', 'Parubas - BIC: FR217', 'Hfhgfhhg', 'Yfgjjug', '€', '', '10000', 'rembourse', '2026-03-21 10:11:17', '2026-03-21 09:17:29');

-- --------------------------------------------------------

--
-- Structure de la table `unlock_codes`
--

CREATE TABLE `unlock_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `compte_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transfer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `unlock_codes`
--

INSERT INTO `unlock_codes` (`id`, `compte_id`, `transfer_id`, `code`, `expires_at`, `used_at`, `created_at`, `updated_at`) VALUES
(1, 93, NULL, '12769180', '2025-12-29 19:53:55', NULL, '2025-11-10 16:16:58', '2025-12-29 19:53:55'),
(2, 93, NULL, '30269551', '2025-12-29 19:53:55', NULL, '2025-11-10 16:19:10', '2025-12-29 19:53:55'),
(3, 93, NULL, '21244243', '2025-12-29 19:53:55', NULL, '2025-11-10 16:21:37', '2025-12-29 19:53:55'),
(4, 93, NULL, '03611074', '2025-12-29 19:53:55', NULL, '2025-11-13 09:32:55', '2025-12-29 19:53:55'),
(5, 112, NULL, '10863512', '2025-11-19 16:11:46', NULL, '2025-11-19 15:41:46', '2025-11-19 15:41:46'),
(6, 121, NULL, '07854696', '2025-11-21 22:02:40', NULL, '2025-11-21 21:32:40', '2025-11-21 21:32:40'),
(7, 140, NULL, '80936626', '2026-02-06 19:33:03', NULL, '2025-12-01 08:27:01', '2026-02-06 19:33:03'),
(8, 140, NULL, '58045027', '2026-02-06 19:33:03', NULL, '2025-12-01 08:30:56', '2026-02-06 19:33:03'),
(9, 140, NULL, '77723134', '2026-02-06 19:33:03', NULL, '2025-12-01 08:49:06', '2026-02-06 19:33:03'),
(10, 140, NULL, '219582', '2026-02-06 19:33:03', NULL, '2025-12-02 12:19:02', '2026-02-06 19:33:03'),
(11, 140, NULL, '246225', '2026-02-06 19:33:03', NULL, '2025-12-02 13:23:08', '2026-02-06 19:33:03'),
(12, 140, NULL, '246225', NULL, '2025-12-02 15:33:29', '2025-12-02 15:33:29', '2025-12-02 15:33:29'),
(13, 140, NULL, '246225', NULL, '2025-12-02 15:33:39', '2025-12-02 15:33:39', '2025-12-02 15:33:39'),
(14, 140, NULL, '600856', '2026-02-06 19:33:03', NULL, '2025-12-02 15:37:07', '2026-02-06 19:33:03'),
(15, 140, NULL, '955411', '2026-02-06 19:33:03', NULL, '2025-12-02 15:49:11', '2026-02-06 19:33:03'),
(16, 140, NULL, '955411', NULL, '2025-12-02 15:53:01', '2025-12-02 15:53:01', '2025-12-02 15:53:01'),
(17, 140, NULL, '615342', '2026-02-06 19:33:03', NULL, '2025-12-02 15:54:37', '2026-02-06 19:33:03'),
(18, 140, NULL, '615342', NULL, '2025-12-02 15:55:00', '2025-12-02 15:55:00', '2025-12-02 15:55:00'),
(19, 140, NULL, '229033', '2026-02-06 19:33:03', NULL, '2025-12-02 16:16:24', '2026-02-06 19:33:03'),
(20, 140, NULL, '742855', '2026-02-06 19:33:03', NULL, '2025-12-02 16:18:05', '2026-02-06 19:33:03'),
(21, 140, NULL, '742855', '2026-02-06 19:33:03', NULL, '2025-12-02 16:21:27', '2026-02-06 19:33:03'),
(22, 93, NULL, '585686', '2025-12-29 19:53:55', NULL, '2025-12-02 16:41:39', '2025-12-29 19:53:55'),
(23, 140, NULL, '470951', '2026-02-06 19:33:03', NULL, '2025-12-02 16:46:08', '2026-02-06 19:33:03'),
(24, 140, NULL, '746329', '2026-02-06 19:33:03', NULL, '2025-12-02 16:47:04', '2026-02-06 19:33:03'),
(25, 140, NULL, '107397', '2026-02-06 19:33:03', NULL, '2025-12-02 16:48:46', '2026-02-06 19:33:03'),
(26, 140, NULL, '375831', '2026-02-06 19:33:03', NULL, '2025-12-02 16:49:35', '2026-02-06 19:33:03'),
(27, 93, NULL, '444575', '2025-12-29 19:53:55', NULL, '2025-12-02 22:37:07', '2025-12-29 19:53:55'),
(28, 140, NULL, '375831', NULL, '2025-12-02 22:48:07', '2025-12-02 22:48:07', '2025-12-02 22:48:07'),
(29, 93, NULL, '762616', '2025-12-29 19:53:55', NULL, '2025-12-02 22:51:17', '2025-12-29 19:53:55'),
(30, 140, NULL, '955868', '2026-02-06 19:33:03', NULL, '2025-12-02 22:53:30', '2026-02-06 19:33:03'),
(31, 140, NULL, '955868', NULL, '2025-12-02 22:54:43', '2025-12-02 22:54:43', '2025-12-02 22:54:43'),
(32, 141, NULL, '718606', NULL, NULL, '2025-12-03 12:24:27', '2025-12-03 12:24:27'),
(33, 93, NULL, '664578', '2025-12-29 19:53:55', NULL, '2025-12-03 17:05:55', '2025-12-29 19:53:55'),
(34, 93, NULL, '109990', '2025-12-29 19:53:55', NULL, '2025-12-03 17:06:49', '2025-12-29 19:53:55'),
(35, 93, NULL, '439961', '2025-12-29 19:53:55', NULL, '2025-12-03 17:12:49', '2025-12-29 19:53:55'),
(36, 93, NULL, '439961', '2025-12-29 19:53:55', NULL, '2025-12-03 17:14:43', '2025-12-29 19:53:55'),
(37, 93, NULL, '439961', NULL, '2025-12-03 17:16:16', '2025-12-03 17:16:16', '2025-12-03 17:16:16'),
(38, 93, NULL, '209917', '2025-12-29 19:53:55', NULL, '2025-12-03 17:20:34', '2025-12-29 19:53:55'),
(39, 93, NULL, '209917', NULL, '2025-12-03 17:22:13', '2025-12-03 17:22:13', '2025-12-03 17:22:13'),
(43, 145, NULL, '269396', '2025-12-04 09:24:21', NULL, '2025-12-04 09:03:55', '2025-12-04 09:24:21'),
(44, 145, NULL, '269396', NULL, '2025-12-04 09:24:21', '2025-12-04 09:24:21', '2025-12-04 09:24:21'),
(46, 147, NULL, '562064', NULL, NULL, '2025-12-04 13:41:27', '2025-12-04 13:41:27'),
(47, 148, NULL, '321167', NULL, NULL, '2025-12-04 19:46:41', '2025-12-04 19:46:41'),
(48, 149, NULL, '610738', NULL, NULL, '2025-12-05 20:29:23', '2025-12-05 20:29:23'),
(49, 150, NULL, '681608', '2026-03-17 14:19:55', NULL, '2025-12-06 10:36:30', '2026-03-17 14:19:55'),
(50, 135, NULL, '154772', NULL, '2025-12-08 12:48:03', '2025-12-08 12:48:03', '2025-12-08 12:48:03'),
(51, 151, NULL, '717355', NULL, NULL, '2025-12-12 09:22:39', '2025-12-12 09:22:39'),
(52, 152, NULL, '801443', NULL, NULL, '2025-12-12 15:47:47', '2025-12-12 15:47:47'),
(53, 93, NULL, '401266', '2025-12-29 19:53:55', NULL, '2025-12-15 17:14:22', '2025-12-29 19:53:55'),
(54, 93, NULL, '401266', '2025-12-29 19:53:55', NULL, '2025-12-15 17:18:55', '2025-12-29 19:53:55'),
(55, 93, NULL, '401266', NULL, '2025-12-15 17:19:31', '2025-12-15 17:19:31', '2025-12-15 17:19:31'),
(56, 93, NULL, '443804', '2025-12-29 19:53:55', NULL, '2025-12-15 17:24:11', '2025-12-29 19:53:55'),
(57, 93, NULL, '724216', '2025-12-29 19:53:55', NULL, '2025-12-15 17:26:07', '2025-12-29 19:53:55'),
(58, 93, NULL, '165983', '2025-12-29 19:53:55', NULL, '2025-12-15 17:27:11', '2025-12-29 19:53:55'),
(59, 150, NULL, '681608', NULL, '2025-12-16 14:54:40', '2025-12-16 14:54:40', '2025-12-16 14:54:40'),
(60, 153, NULL, '408752', NULL, NULL, '2025-12-16 19:11:44', '2025-12-16 19:11:44'),
(61, 139, NULL, '809460', '2025-12-16 19:44:11', NULL, '2025-12-16 19:33:47', '2025-12-16 19:44:11'),
(62, 139, NULL, '809460', NULL, '2025-12-16 19:34:09', '2025-12-16 19:34:09', '2025-12-16 19:34:09'),
(63, 154, NULL, '174754', NULL, NULL, '2025-12-16 19:43:13', '2025-12-16 19:43:13'),
(64, 139, NULL, '436230', NULL, NULL, '2025-12-16 19:44:11', '2025-12-16 19:44:11'),
(65, 155, NULL, '825391', NULL, NULL, '2025-12-19 13:41:54', '2025-12-19 13:41:54'),
(66, 156, NULL, '737745', '2026-02-23 11:47:53', NULL, '2025-12-20 12:57:16', '2026-02-23 11:47:53'),
(67, 157, NULL, '521999', '2025-12-20 22:39:43', NULL, '2025-12-20 19:40:50', '2025-12-20 22:39:43'),
(68, 158, NULL, '972894', '2026-01-08 09:59:02', NULL, '2025-12-20 21:24:08', '2026-01-08 09:59:02'),
(69, 158, NULL, '972894', NULL, '2025-12-20 22:09:50', '2025-12-20 22:09:50', '2025-12-20 22:09:50'),
(70, 158, NULL, '972894', NULL, '2025-12-20 22:17:11', '2025-12-20 22:17:11', '2025-12-20 22:17:11'),
(71, 158, NULL, '942616', '2026-01-08 09:59:02', NULL, '2025-12-20 22:25:29', '2026-01-08 09:59:02'),
(72, 157, NULL, '521999', NULL, '2025-12-20 22:39:43', '2025-12-20 22:39:43', '2025-12-20 22:39:43'),
(73, 93, NULL, '379176', '2025-12-29 19:53:55', NULL, '2025-12-20 22:44:22', '2025-12-29 19:53:55'),
(74, 93, NULL, '379176', NULL, '2025-12-20 22:46:37', '2025-12-20 22:46:37', '2025-12-20 22:46:37'),
(75, 158, NULL, '942616', NULL, '2025-12-20 22:48:06', '2025-12-20 22:48:06', '2025-12-20 22:48:06'),
(76, 158, NULL, '942616', NULL, '2025-12-20 22:49:40', '2025-12-20 22:49:40', '2025-12-20 22:49:40'),
(77, 158, NULL, '942616', NULL, '2025-12-20 22:51:14', '2025-12-20 22:51:14', '2025-12-20 22:51:14'),
(78, 158, NULL, '942616', NULL, '2025-12-20 22:52:36', '2025-12-20 22:52:36', '2025-12-20 22:52:36'),
(79, 158, NULL, '942616', NULL, '2025-12-20 22:54:43', '2025-12-20 22:54:43', '2025-12-20 22:54:43'),
(80, 158, NULL, '970733', '2026-01-08 09:59:02', NULL, '2025-12-21 00:05:40', '2026-01-08 09:59:02'),
(81, 158, NULL, '970733', NULL, '2025-12-21 00:11:53', '2025-12-21 00:11:53', '2025-12-21 00:11:53'),
(82, 158, NULL, '650623', '2026-01-08 09:59:02', NULL, '2025-12-22 10:25:22', '2026-01-08 09:59:02'),
(83, 158, NULL, '650623', NULL, '2025-12-22 10:53:45', '2025-12-22 10:53:45', '2025-12-22 10:53:45'),
(84, 159, NULL, '559876', NULL, NULL, '2025-12-22 20:44:09', '2025-12-22 20:44:09'),
(85, 160, NULL, '356603', NULL, NULL, '2025-12-22 21:02:47', '2025-12-22 21:02:47'),
(86, 161, NULL, '199225', NULL, NULL, '2025-12-22 21:41:34', '2025-12-22 21:41:34'),
(87, 162, NULL, '985099', NULL, NULL, '2025-12-22 23:08:48', '2025-12-22 23:08:48'),
(88, 163, NULL, '857585', NULL, NULL, '2025-12-23 00:53:29', '2025-12-23 00:53:29'),
(90, 165, NULL, '282720', NULL, NULL, '2025-12-23 06:35:30', '2025-12-23 06:35:30'),
(91, 166, NULL, '909332', NULL, NULL, '2025-12-23 10:10:31', '2025-12-23 10:10:31'),
(92, 167, NULL, '411544', NULL, NULL, '2025-12-23 10:55:47', '2025-12-23 10:55:47'),
(93, 168, NULL, '360523', NULL, NULL, '2025-12-23 10:56:44', '2025-12-23 10:56:44'),
(94, 169, NULL, '625392', NULL, NULL, '2025-12-23 10:58:00', '2025-12-23 10:58:00'),
(95, 170, NULL, '805136', NULL, NULL, '2025-12-23 13:18:03', '2025-12-23 13:18:03'),
(96, 171, NULL, '397811', NULL, NULL, '2025-12-23 14:16:46', '2025-12-23 14:16:46'),
(97, 172, NULL, '629766', NULL, NULL, '2025-12-23 17:55:16', '2025-12-23 17:55:16'),
(98, 173, NULL, '169324', '2026-03-29 10:49:37', NULL, '2025-12-23 17:57:19', '2026-03-29 10:49:37'),
(99, 174, NULL, '677822', '2026-03-29 11:20:30', NULL, '2025-12-23 19:14:54', '2026-03-29 11:20:30'),
(100, 175, NULL, '116185', '2026-03-29 18:30:04', NULL, '2025-12-23 21:21:23', '2026-03-29 18:30:04'),
(101, 176, NULL, '139303', '2026-01-03 18:53:07', NULL, '2025-12-24 10:45:51', '2026-01-03 18:53:07'),
(102, 176, NULL, '139303', NULL, '2025-12-24 11:23:57', '2025-12-24 11:23:57', '2025-12-24 11:23:57'),
(103, 176, NULL, '139303', NULL, '2025-12-24 12:02:28', '2025-12-24 12:02:28', '2025-12-24 12:02:28'),
(104, 176, NULL, '139303', NULL, '2025-12-24 12:02:28', '2025-12-24 12:02:28', '2025-12-24 12:02:28'),
(105, 176, NULL, '139303', NULL, '2025-12-24 13:09:25', '2025-12-24 13:09:25', '2025-12-24 13:09:25'),
(106, 176, NULL, '139303', NULL, '2025-12-24 15:25:15', '2025-12-24 15:25:15', '2025-12-24 15:25:15'),
(107, 176, NULL, '500573', '2026-01-03 18:53:07', NULL, '2025-12-24 16:53:54', '2026-01-03 18:53:07'),
(108, 176, NULL, '582615', '2026-01-03 18:53:07', NULL, '2025-12-24 16:54:18', '2026-01-03 18:53:07'),
(109, 176, NULL, '628292', '2026-01-03 18:53:07', NULL, '2025-12-24 16:54:42', '2026-01-03 18:53:07'),
(110, 176, NULL, '628292', NULL, '2025-12-24 16:59:01', '2025-12-24 16:59:01', '2025-12-24 16:59:01'),
(111, 176, NULL, '272829', '2026-01-03 18:53:07', NULL, '2025-12-24 17:03:32', '2026-01-03 18:53:07'),
(112, 176, NULL, '272829', NULL, '2025-12-24 17:16:41', '2025-12-24 17:16:41', '2025-12-24 17:16:41'),
(113, 176, NULL, '272829', NULL, '2025-12-24 23:09:37', '2025-12-24 23:09:37', '2025-12-24 23:09:37'),
(114, 176, NULL, '272829', NULL, '2025-12-24 23:13:52', '2025-12-24 23:13:52', '2025-12-24 23:13:52'),
(115, 176, NULL, '272829', NULL, '2025-12-24 23:20:41', '2025-12-24 23:20:41', '2025-12-24 23:20:41'),
(116, 176, NULL, '272829', NULL, '2025-12-24 23:24:15', '2025-12-24 23:24:15', '2025-12-24 23:24:15'),
(117, 176, NULL, '272829', NULL, '2025-12-25 08:20:16', '2025-12-25 08:20:16', '2025-12-25 08:20:16'),
(118, 176, NULL, '642685', '2026-01-03 18:53:07', NULL, '2025-12-25 13:32:34', '2026-01-03 18:53:07'),
(119, 176, NULL, '750664', '2026-01-03 18:53:07', NULL, '2025-12-25 13:32:55', '2026-01-03 18:53:07'),
(120, 176, NULL, '121893', '2026-01-03 18:53:07', NULL, '2025-12-25 13:43:04', '2026-01-03 18:53:07'),
(121, 176, NULL, '475025', '2026-01-03 18:53:07', NULL, '2025-12-25 14:01:35', '2026-01-03 18:53:07'),
(122, 176, NULL, '475025', NULL, '2025-12-25 14:03:14', '2025-12-25 14:03:14', '2025-12-25 14:03:14'),
(123, 177, NULL, '343114', NULL, NULL, '2025-12-25 23:36:29', '2025-12-25 23:36:29'),
(124, 178, NULL, '825258', NULL, NULL, '2025-12-26 13:24:12', '2025-12-26 13:24:12'),
(125, 179, NULL, '474232', NULL, NULL, '2025-12-26 13:28:30', '2025-12-26 13:28:30'),
(126, 140, NULL, '52462172', '2026-02-06 19:33:03', NULL, '2025-12-26 16:43:46', '2026-02-06 19:33:03'),
(127, 180, NULL, '266157', NULL, NULL, '2025-12-26 21:11:19', '2025-12-26 21:11:19'),
(128, 181, NULL, '444436', NULL, NULL, '2025-12-26 21:14:27', '2025-12-26 21:14:27'),
(129, 93, NULL, '379176', NULL, '2025-12-29 19:53:55', '2025-12-29 19:53:55', '2025-12-29 19:53:55'),
(130, 176, NULL, '956356', '2026-01-03 18:53:07', NULL, '2025-12-30 12:56:34', '2026-01-03 18:53:07'),
(131, 176, NULL, '148138', '2026-01-03 18:53:07', NULL, '2025-12-30 13:00:46', '2026-01-03 18:53:07'),
(132, 176, NULL, '714364', '2026-01-03 18:53:07', NULL, '2025-12-30 13:03:09', '2026-01-03 18:53:07'),
(133, 176, NULL, '714364', NULL, '2025-12-30 16:08:15', '2025-12-30 16:08:15', '2025-12-30 16:08:15'),
(134, 176, NULL, '714364', NULL, '2025-12-30 16:17:03', '2025-12-30 16:17:03', '2025-12-30 16:17:03'),
(135, 182, NULL, '133433', '2025-12-31 17:20:20', NULL, '2025-12-31 15:46:39', '2025-12-31 17:20:20'),
(136, 182, NULL, '133433', NULL, '2025-12-31 17:20:20', '2025-12-31 17:20:20', '2025-12-31 17:20:20'),
(137, 183, NULL, '539230', '2026-01-05 11:21:04', NULL, '2026-01-02 16:02:41', '2026-01-05 11:21:04'),
(138, 183, NULL, '539230', NULL, '2026-01-02 17:06:29', '2026-01-02 17:06:29', '2026-01-02 17:06:29'),
(139, 183, NULL, '313615', '2026-01-05 11:21:04', NULL, '2026-01-02 18:59:01', '2026-01-05 11:21:04'),
(140, 183, NULL, '313615', NULL, '2026-01-02 19:22:11', '2026-01-02 19:22:11', '2026-01-02 19:22:11'),
(141, 176, NULL, '916904', '2026-01-03 18:53:07', NULL, '2026-01-03 18:43:56', '2026-01-03 18:53:07'),
(142, 176, NULL, '654128', '2026-01-03 18:53:07', NULL, '2026-01-03 18:47:31', '2026-01-03 18:53:07'),
(143, 176, NULL, '654128', '2026-01-03 18:53:07', NULL, '2026-01-03 18:52:28', '2026-01-03 18:53:07'),
(144, 176, NULL, '654128', NULL, '2026-01-03 18:53:07', '2026-01-03 18:53:07', '2026-01-03 18:53:07'),
(145, 183, NULL, '579018', '2026-01-05 11:21:04', NULL, '2026-01-05 08:08:25', '2026-01-05 11:21:04'),
(146, 183, NULL, '608772', '2026-01-05 11:21:04', NULL, '2026-01-05 08:10:47', '2026-01-05 11:21:04'),
(147, 183, NULL, '436416', '2026-01-05 11:21:04', NULL, '2026-01-05 08:11:01', '2026-01-05 11:21:04'),
(148, 183, NULL, '436416', '2026-01-05 11:21:04', NULL, '2026-01-05 08:11:32', '2026-01-05 11:21:04'),
(149, 183, NULL, '436416', NULL, '2026-01-05 11:21:04', '2026-01-05 11:21:04', '2026-01-05 11:21:04'),
(150, 158, NULL, '393103', NULL, NULL, '2026-01-08 09:59:02', '2026-01-08 09:59:02'),
(151, 184, NULL, '185299', '2026-01-12 18:19:07', NULL, '2026-01-10 12:43:58', '2026-01-12 18:19:07'),
(152, 184, NULL, '185299', '2026-01-12 18:19:07', NULL, '2026-01-10 13:42:32', '2026-01-12 18:19:07'),
(153, 184, NULL, '185299', NULL, '2026-01-10 13:42:34', '2026-01-10 13:42:34', '2026-01-10 13:42:34'),
(154, 184, NULL, '551292', '2026-01-12 18:19:07', NULL, '2026-01-10 13:44:53', '2026-01-12 18:19:07'),
(155, 184, NULL, '855819', '2026-01-12 18:19:07', NULL, '2026-01-10 13:45:05', '2026-01-12 18:19:07'),
(156, 184, NULL, '855819', '2026-01-12 18:19:07', NULL, '2026-01-10 14:18:41', '2026-01-12 18:19:07'),
(157, 184, NULL, '855819', NULL, '2026-01-10 14:19:47', '2026-01-10 14:19:47', '2026-01-10 14:19:47'),
(158, 184, NULL, '855819', NULL, '2026-01-10 14:36:56', '2026-01-10 14:36:56', '2026-01-10 14:36:56'),
(159, 184, NULL, '777359', '2026-01-12 18:19:07', NULL, '2026-01-10 15:23:34', '2026-01-12 18:19:07'),
(160, 184, NULL, '777359', NULL, '2026-01-10 17:54:46', '2026-01-10 17:54:46', '2026-01-10 17:54:46'),
(161, 184, NULL, '777359', NULL, '2026-01-10 17:54:46', '2026-01-10 17:54:46', '2026-01-10 17:54:46'),
(162, 184, NULL, '777359', NULL, '2026-01-10 18:02:01', '2026-01-10 18:02:01', '2026-01-10 18:02:01'),
(163, 185, NULL, '136277', '2026-01-12 17:35:23', NULL, '2026-01-12 17:32:44', '2026-01-12 17:35:23'),
(164, 185, NULL, '550024', NULL, NULL, '2026-01-12 17:35:23', '2026-01-12 17:35:23'),
(165, 184, NULL, '616162', '2026-01-12 18:19:07', NULL, '2026-01-12 18:08:03', '2026-01-12 18:19:07'),
(166, 184, NULL, '979173', '2026-01-12 18:19:07', NULL, '2026-01-12 18:11:29', '2026-01-12 18:19:07'),
(167, 184, NULL, '979173', NULL, '2026-01-12 18:14:57', '2026-01-12 18:14:57', '2026-01-12 18:14:57'),
(168, 184, NULL, '820581', '2026-01-12 18:19:07', NULL, '2026-01-12 18:17:34', '2026-01-12 18:19:07'),
(169, 184, NULL, '820581', NULL, '2026-01-12 18:19:07', '2026-01-12 18:19:07', '2026-01-12 18:19:07'),
(170, 186, NULL, '655557', NULL, NULL, '2026-01-20 09:38:35', '2026-01-20 09:38:35'),
(171, 187, NULL, '612599', NULL, NULL, '2026-01-21 14:45:16', '2026-01-21 14:45:16'),
(172, 140, NULL, '955868', NULL, '2026-01-21 17:54:26', '2026-01-21 17:54:26', '2026-01-21 17:54:26'),
(173, 140, NULL, '203924', '2026-02-06 19:33:03', NULL, '2026-01-21 17:57:13', '2026-02-06 19:33:03'),
(174, 188, NULL, '144031', NULL, NULL, '2026-01-24 14:47:47', '2026-01-24 14:47:47'),
(175, 189, NULL, '805732', NULL, NULL, '2026-01-29 06:58:25', '2026-01-29 06:58:25'),
(176, 190, NULL, '583282', '2026-01-29 09:49:41', NULL, '2026-01-29 09:38:49', '2026-01-29 09:49:41'),
(177, 190, NULL, '160692', NULL, NULL, '2026-01-29 09:49:41', '2026-01-29 09:49:41'),
(178, 191, NULL, '684424', NULL, NULL, '2026-02-04 20:17:11', '2026-02-04 20:17:11'),
(179, 192, NULL, '394438', NULL, NULL, '2026-02-05 09:48:26', '2026-02-05 09:48:26'),
(180, 193, NULL, '640741', '2026-03-17 14:17:56', NULL, '2026-02-06 14:50:33', '2026-03-17 14:17:56'),
(181, 193, NULL, '640741', '2026-03-17 14:17:56', NULL, '2026-02-06 18:48:52', '2026-03-17 14:17:56'),
(182, 140, NULL, '203924', '2026-02-06 19:33:03', NULL, '2026-02-06 18:59:18', '2026-02-06 19:33:03'),
(183, 140, NULL, '203924', '2026-02-06 19:33:03', NULL, '2026-02-06 19:15:37', '2026-02-06 19:33:03'),
(184, 140, NULL, '203924', '2026-02-06 20:03:03', NULL, '2026-02-06 19:33:03', '2026-02-06 19:33:03'),
(185, 150, NULL, '681608', '2026-03-17 14:19:55', NULL, '2026-02-06 19:33:49', '2026-03-17 14:19:55'),
(186, 193, NULL, '640741', '2026-03-17 14:17:56', NULL, '2026-02-06 19:34:07', '2026-03-17 14:17:56'),
(187, 193, NULL, '640741', NULL, '2026-02-09 10:20:37', '2026-02-09 10:20:37', '2026-02-09 10:20:37'),
(188, 194, NULL, '927534', NULL, NULL, '2026-02-12 09:57:27', '2026-02-12 09:57:27'),
(189, 195, NULL, '345241', NULL, NULL, '2026-02-13 14:14:36', '2026-02-13 14:14:36'),
(190, 196, NULL, '964601', '2026-03-07 07:22:20', NULL, '2026-02-17 14:06:36', '2026-03-07 07:22:20'),
(191, 197, NULL, '564157', '2026-03-18 12:06:11', NULL, '2026-02-17 16:27:58', '2026-03-18 12:06:11'),
(192, 196, NULL, '964601', '2026-03-07 07:22:20', NULL, '2026-02-19 13:56:32', '2026-03-07 07:22:20'),
(193, 196, NULL, '964601', NULL, '2026-02-19 14:00:57', '2026-02-19 14:00:57', '2026-02-19 14:00:57'),
(194, 197, NULL, '592217', '2026-03-18 12:06:11', NULL, '2026-02-19 14:01:10', '2026-03-18 12:06:11'),
(195, 197, NULL, '112677', '2026-03-18 12:06:11', NULL, '2026-02-19 14:04:43', '2026-03-18 12:06:11'),
(196, 198, NULL, '254828', NULL, NULL, '2026-02-19 19:22:37', '2026-02-19 19:22:37'),
(197, 199, NULL, '524711', NULL, NULL, '2026-02-21 08:47:34', '2026-02-21 08:47:34'),
(198, 196, NULL, '664704', '2026-03-07 07:22:20', NULL, '2026-02-23 07:00:54', '2026-03-07 07:22:20'),
(199, 196, NULL, '764966', '2026-03-07 07:22:20', NULL, '2026-02-23 07:01:11', '2026-03-07 07:22:20'),
(200, 156, NULL, '737745', '2026-02-23 12:17:53', NULL, '2026-02-23 11:47:53', '2026-02-23 11:47:53'),
(201, 200, NULL, '424911', NULL, NULL, '2026-02-23 17:51:17', '2026-02-23 17:51:17'),
(202, 196, NULL, '329581', '2026-03-07 07:22:20', NULL, '2026-02-25 08:59:26', '2026-03-07 07:22:20'),
(203, 196, NULL, '303362', '2026-03-07 07:22:20', NULL, '2026-02-25 08:59:45', '2026-03-07 07:22:20'),
(204, 201, NULL, '107613', NULL, NULL, '2026-02-25 09:10:44', '2026-02-25 09:10:44'),
(205, 196, NULL, '303362', '2026-03-07 07:22:20', NULL, '2026-02-25 09:28:27', '2026-03-07 07:22:20'),
(206, 196, NULL, '303362', NULL, '2026-02-25 09:43:23', '2026-02-25 09:43:23', '2026-02-25 09:43:23'),
(207, 196, NULL, '303362', NULL, '2026-02-25 09:49:19', '2026-02-25 09:49:19', '2026-02-25 09:49:19'),
(208, 196, NULL, '303362', NULL, '2026-02-25 09:55:19', '2026-02-25 09:55:19', '2026-02-25 09:55:19'),
(209, 202, NULL, '682741', NULL, NULL, '2026-03-04 19:34:02', '2026-03-04 19:34:02'),
(210, 196, NULL, '303362', NULL, '2026-03-05 11:36:11', '2026-03-05 11:36:11', '2026-03-05 11:36:11'),
(211, 196, NULL, '303362', NULL, '2026-03-05 11:38:45', '2026-03-05 11:38:45', '2026-03-05 11:38:45'),
(212, 196, NULL, '303362', NULL, '2026-03-05 11:43:22', '2026-03-05 11:43:22', '2026-03-05 11:43:22'),
(213, 193, NULL, '912144', '2026-03-17 14:17:56', NULL, '2026-03-05 14:37:19', '2026-03-17 14:17:56'),
(214, 150, NULL, '368208', '2026-03-17 14:19:55', NULL, '2026-03-05 14:39:37', '2026-03-17 14:19:55'),
(215, 193, NULL, '735484', '2026-03-17 14:17:56', NULL, '2026-03-05 14:40:37', '2026-03-17 14:17:56'),
(216, 150, NULL, '576434', '2026-03-17 14:19:55', NULL, '2026-03-05 14:43:49', '2026-03-17 14:19:55'),
(217, 193, NULL, '735484', '2026-03-17 14:17:56', NULL, '2026-03-05 14:48:23', '2026-03-17 14:17:56'),
(218, 193, NULL, '735484', '2026-03-05 15:22:47', '2026-03-17 14:17:56', '2026-03-05 14:50:49', '2026-03-17 14:17:56'),
(219, 193, NULL, '735484', NULL, '2026-03-05 15:22:47', '2026-03-05 15:22:47', '2026-03-05 15:22:47'),
(220, 196, NULL, '303362', NULL, '2026-03-07 07:22:20', '2026-03-07 07:22:20', '2026-03-07 07:22:20'),
(221, 203, NULL, '593540', '2026-03-21 09:11:17', NULL, '2026-03-17 01:39:27', '2026-03-21 09:11:17'),
(222, 193, NULL, '843328', NULL, NULL, '2026-03-17 14:17:56', '2026-03-17 14:17:56'),
(223, 150, NULL, '265464', NULL, NULL, '2026-03-17 14:19:55', '2026-03-17 14:19:55'),
(224, 197, NULL, '112677', '2026-03-18 12:36:11', NULL, '2026-03-18 12:06:11', '2026-03-18 12:06:11'),
(225, 203, NULL, '593540', NULL, '2026-03-21 09:11:17', '2026-03-21 09:11:17', '2026-03-21 09:11:17'),
(226, 173, NULL, '169324', NULL, '2026-03-29 10:47:55', '2026-03-29 10:47:55', '2026-03-29 10:47:55'),
(227, 173, NULL, '169324', NULL, '2026-03-29 10:49:37', '2026-03-29 10:49:37', '2026-03-29 10:49:37'),
(228, 174, NULL, '677822', NULL, '2026-03-29 11:20:30', '2026-03-29 11:20:30', '2026-03-29 11:20:30'),
(229, 175, NULL, '116185', NULL, '2026-03-29 18:00:29', '2026-03-29 18:00:29', '2026-03-29 18:00:29'),
(230, 175, NULL, '116185', NULL, '2026-03-29 18:30:04', '2026-03-29 18:30:04', '2026-03-29 18:30:04');

-- --------------------------------------------------------

--
-- Structure de la table `url_shortener_history`
--

CREATE TABLE `url_shortener_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `original_url` varchar(255) NOT NULL,
  `short_url` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL DEFAULT 'is.gd',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `url_shortener_history`
--

INSERT INTO `url_shortener_history` (`id`, `user_id`, `original_url`, `short_url`, `provider`, `created_at`, `updated_at`) VALUES
(2, 114, 'https://google.com', 'https://is.gd/jAxBiv', 'is.gd', '2025-12-23 10:58:53', '2025-12-23 10:58:53');

-- --------------------------------------------------------

--
-- Structure de la table `url_verifications`
--

CREATE TABLE `url_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `domain` varchar(255) NOT NULL,
  `lookup_status` varchar(255) NOT NULL DEFAULT 'pending',
  `registrar` varchar(255) DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `lookup_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`lookup_data`)),
  `error_message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `credit_user` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `code_parrainage` varchar(255) DEFAULT NULL,
  `parrain_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `phone`, `email_verified_at`, `password`, `credit_user`, `code_parrainage`, `parrain_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(60, 'CANDIDE', 'CANDIDE', 'lalyaisidore@gmail.com', '+2290198201610', NULL, '$2y$12$ZFe2wGWmC6GqVaHv2sgdKuS0BhWcdTaigI2/CTYZP9Pq8itqdZFhq', 49500, NULL, NULL, NULL, '2025-11-08 07:34:35', '2025-12-01 11:04:38'),
(70, 'Franck', 'Durand', 'durandfranck249@gmail.com', '+2250564325906', NULL, '$2y$12$ynRUcySoCR9k80NKSQhxo.MhpVrfNnrMg0a2VHzAlvctcqQ6uMU0q', 11000, NULL, NULL, NULL, '2025-11-14 16:03:58', '2025-12-19 13:41:54'),
(71, 'nguyen thi', 'kim dung', 'bellsonnesonia@gmail.com', '+2550153244976', NULL, '$2y$12$ZFUmtSVc4287oqibiFbC5.HoRDYQsv51q.UJHtTqxI.xFB0Nhee7G', 0, NULL, NULL, NULL, '2025-11-18 16:44:53', '2025-11-18 16:44:53'),
(72, 'Fostinos', 'Charmakh', 'fostinoscharmakh@gmail.com', '+2290191702794', NULL, '$2y$12$bkeYRAVz0foLznSJX8mMKuXjeE4HHboTESSbVTfyoINV0gwq1WsbC', 0, NULL, NULL, NULL, '2025-11-18 21:46:39', '2025-11-18 21:46:39'),
(73, 'Christophe', 'LEJEUNE', 'amadjicarmel11@gmail.com', '+22953221824', NULL, '$2y$12$PPrMvllhm6lrioQZPOf76.YHE80Xvq0iPdqrXpRl471fT1kvFDMaW', 0, NULL, NULL, NULL, '2025-11-19 07:20:41', '2025-11-19 07:20:41'),
(74, 'Tz la', 'Hauteur', 'tzlahauteur91@gmail.com', '+22957524467', NULL, '$2y$12$y0tvLn/6etPuwgEREkTlAuKrAbrnVWNHpm3bqVsZKNQA9S1.12EkG', 0, NULL, 60, NULL, '2025-11-19 12:22:08', '2025-11-19 12:22:08'),
(75, 'Hugo', 'PITMAN', 'assicurazioneprestitionline@gmail.com', '+31647975034', NULL, '$2y$12$.bJtrjHkCu29Fn3SIiYPEePpafycxJSDjieyJVARrQm9KeUtfJMwi', 0, NULL, NULL, NULL, '2025-11-19 15:16:38', '2025-11-19 15:16:38'),
(76, 'Boga', 'St Paul', 'saraovidente@gmail.com', '2290168460884', NULL, '$2y$12$y3BUafPZ59hf2RIlRlC/kep7ZCRn1UBP7L9hLvCMENLjX1eFvJgLS', 0, NULL, NULL, NULL, '2025-11-19 15:59:42', '2025-11-19 15:59:42'),
(77, 'Savi', 'Audrey', 'jikelmike@gmail.com', '+2290191640768', NULL, '$2y$12$MwGYJ5iEHkFGCxcAqXprTeTTrpnm5DzlQXagI7ZE4WMNU8FtWbUhO', 0, NULL, NULL, NULL, '2025-11-20 08:05:16', '2025-11-20 08:05:16'),
(78, 'Sowanou', 'Sylvain', 'sowanousyl@gmail.com', '+2290166842969', NULL, '$2y$12$4IyqStyZI8Ld4xy8wKBVVuC0TTvwb390gkQrqibj9VMRxKyWseZ0W', 0, NULL, NULL, NULL, '2025-11-20 08:25:44', '2025-11-20 08:25:44'),
(79, 'Joël', 'Joël', 'autogarantieversicherung@gmail.com', '+22960067966', NULL, '$2y$12$tQq0MRjaMFDTM85oNE8qDOerF5sqD/HoJwscSjGJZ/2P/IK8DAgja', 0, NULL, NULL, NULL, '2025-11-20 09:23:52', '2025-11-20 09:23:52'),
(80, 'Antonio', 'Maniscalco', 'laboitedetabac@gmail.com', '+2290147536584', NULL, '$2y$12$1SC./sJC6SB858/GPAsr2eDTiLL6Jl8xMIuEu2gCdvAT0fwRV8Fsi', 0, NULL, NULL, NULL, '2025-11-20 12:16:29', '2025-11-20 12:16:29'),
(81, 'Alexis', 'Dautin', 'alexisedautin@gmail.com', '+22962133940', NULL, '$2y$12$ZBkVMi2DG7CMZVbijxgPLee33m4dQstNFZ72Uct7CEvmqhJO0V7Oa', 0, NULL, NULL, NULL, '2025-11-20 13:19:32', '2025-11-20 13:19:32'),
(82, 'Soares Marque Da Silva', 'Fernando', 'fernandosoaresmarquedasilva@gmail.com', '229016588114', NULL, '$2y$12$aRFcCqpkjD52l.V99qHMje4.JqgYqN6wSMp5qmL9z1/Bb978NpLDu', 0, NULL, 60, NULL, '2025-11-20 17:53:35', '2025-11-20 17:53:35'),
(83, 'Jean', 'Laurant', 'hospicehounwanou66@gmail.com', '+2290159253951', NULL, '$2y$12$v5nlnmSt5qCXGtWt2DW6Qu4aaUC2ZVKmOQ9lxXYk8UnPtdCzL75M6', 0, NULL, NULL, NULL, '2025-11-20 23:40:44', '2025-11-24 21:14:06'),
(84, 'Maria', 'Adeline', 'Princessleonorofficial62@gmail.com', '2290158553191', NULL, '$2y$12$/ox89rE1zwY3u3dZD00Rkuixi9YECCarzGF6pBF3HNF1b9bhfrHnW', 5000, NULL, 83, NULL, '2025-11-21 00:57:06', '2025-11-25 12:37:26'),
(85, 'Mino\'', 'Maria-rosa', 'mariarosapatriziam@gmail.com', '+2290166864988', NULL, '$2y$12$9IKllWfRmFg0FKJ3rUPgae.V0BrCISZcsKxxN2b7gelCDS9cG07dG', 0, NULL, NULL, NULL, '2025-11-21 07:18:21', '2025-11-21 07:18:21'),
(87, 'christophe', 'Lejeune', 'christophelejeune002@gmail.com', '+22953221824', NULL, '$2y$12$.P4.zeoAluEGIJb6BSBZC.0cMcIb3AjaHy1AaBzNZD9Rrp5KqUhyK', 0, NULL, 60, NULL, '2025-11-25 12:08:44', '2025-11-28 12:16:19'),
(88, 'Dupont', 'Alice', 'estevedossou508@gmail.com', '+2290199609798', NULL, '$2y$12$0pRfGPrkgBqlCkfpAuEccOJg4DzVpGfkC7Eb6sz/6jYrOdOX.GKGi', 0, NULL, 83, NULL, '2025-11-26 20:32:18', '2025-11-26 20:32:18'),
(89, 'Thomas', 'Uriel', 'j7702471@gmail.com', '2290191137547', NULL, '$2y$12$l7xFVkRDJzFa28CrCheLsOEp04K5v3gzACwV42sdOFqqep6vIk5Xe', 0, NULL, NULL, NULL, '2025-11-28 21:44:58', '2025-11-28 21:44:58'),
(90, 'Bonnafé', 'Jean Laurent', 'scotiabank143@gmail.com', '+2290191635916', NULL, '$2y$12$XtuUJQMQlaHdzaT63qBYxexfoRYyTAzbWCj/oEsCLiDnX7uGXJKBu', 0, NULL, 60, NULL, '2025-11-28 22:05:21', '2026-02-17 16:27:58'),
(91, 'DOUTCHECON', 'Tonny', 'freddyduvar32@gmail.com', '2290162905344', NULL, '$2y$12$Ebpid9sgIQtQPr.12coKK.l4C7lVvmu8S0sNBdF112G4xQcNYNgam', 0, NULL, NULL, NULL, '2025-12-03 12:24:27', '2025-12-03 12:24:27'),
(95, 'EZÉCHIEL', 'TCHOKPONHOUE', 'ezechieltchokponhoue@gmail.com', '+22960067966', NULL, '$2y$12$TEiOvaZD7688AZ.xBpvnp.6Dl.XmiqsKOLhoMPLAo0Ab3HY.lH95i', 0, NULL, NULL, NULL, '2025-12-04 09:03:55', '2025-12-04 09:03:55'),
(97, 'Fernando', 'Gomez', 'fernandogomez77@outlook.fr', '0198718457', NULL, '$2y$12$cL4wuWMUBH0UIELHd49GouMDUEzzlESwyHladAya6FJQLIXETr1Fe', 0, NULL, 60, NULL, '2025-12-04 13:41:27', '2025-12-04 13:41:27'),
(98, 'Laurent', 'Louis', 'js233380@gmail.com', '+22960562519', NULL, '$2y$12$3ZbKLMGYf10GIFvgApueJ.aQLztWIqXoLsNtb3IA0rMw4JZK2FeZK', 0, NULL, NULL, NULL, '2025-12-04 19:46:41', '2025-12-04 19:46:41'),
(99, 'PAPA', 'Kanfa', 'papapakanfa@gmail.com', '226053504648', NULL, '$2y$12$BZc7nLbAu8R2wm/RmqDLO.KKGWteDT0mPDMj2ewo/GXPU03IM2JJ2', 0, NULL, NULL, NULL, '2025-12-05 20:29:23', '2025-12-05 20:29:23'),
(100, 'EWEN', 'Kiki', 'vistabank606@gmail.com', '0168748542', NULL, '$2y$12$0aTza9gkllxgB.dq3ntEsujKVWHHx7qkvZQ6YmayMRp9IFTaM9qw6', 1000, NULL, NULL, NULL, '2025-12-06 10:36:30', '2026-02-06 14:50:33'),
(101, 'Hernandez', 'Jesus', 'joaogbeti92@gmail.com', '0169966025', NULL, '$2y$12$Xr2bM7HiZxkV359NbrTZW.z.GeOjA8Ol9Obk.lAWjCkD2gGxuDMdW', 0, NULL, NULL, NULL, '2025-12-12 09:22:39', '2025-12-12 09:22:39'),
(102, 'Jean Leaurent', 'Bonnafe', 'paribasbanquefinancebnp@gmail.com', '+22959361411', NULL, '$2y$12$37Q4U8yHdA4zNS7Orcw0g.bN8TST5/E1jbkRErR3x1bs2u6Fkqbe6', 0, NULL, 60, NULL, '2025-12-16 19:43:13', '2025-12-16 19:43:13'),
(103, 'Lil', 'Daryl', 'lildaryl726@gmail.com', '+2290154761259', NULL, '$2y$12$7IlpVWLwkue9IXCC9ZU2Q.QknWvL15B8hq.gYI/V0.XfvkartDYJC', 0, NULL, NULL, NULL, '2025-12-20 19:40:50', '2026-01-10 12:43:58'),
(104, 'Eba', 'Benjamin', 'benjamineba237@icloud.com', '+237657161661', NULL, '$2y$12$/S8xYpJprNyktE82No8/1eRfaMwFQjQFEiQ.a5.SR8v2iJ8XWihY.', 0, NULL, NULL, NULL, '2025-12-22 20:44:09', '2025-12-22 20:44:09'),
(105, 'Chabani', 'Chabani', 'chabaniklk10@gmail.com', '+243899664449', NULL, '$2y$12$Q56TgNl420yuqmf3futFn.JSh/2WcNJrLyOZCc9iZ4Ha.dZ36n/Pu', 0, NULL, NULL, NULL, '2025-12-22 21:02:47', '2025-12-22 21:02:47'),
(106, 'Nnang', 'Moïse', 'Mkzveritable@gmail.com', '+24177189788', NULL, '$2y$12$9vhcNZ/LMBy2j4DBAi/HKOkZI30oGfrSVRrtgXiUMFPVKEXlD/hqe', 0, NULL, NULL, NULL, '2025-12-22 21:41:34', '2025-12-22 21:41:34'),
(107, 'sompwe', 'ilunga', 'jeannymoise00@gmail.com', '+243987105111', NULL, '$2y$12$wPh5A.Sj6dF0.vjorBJjtuEVDwlHTyqvafZumHCenwgfCs//xkOFa', 0, NULL, NULL, NULL, '2025-12-22 23:08:48', '2025-12-22 23:08:48'),
(108, 'Phoba', 'Romain', 'romainphoba75@gmail.com', '+243993251905', NULL, '$2y$12$TZkL1rGU4EQTPKVgM7Sxlu1A9qftFebf84JT.GYF/Wgq5sewSdmN2', 0, NULL, NULL, NULL, '2025-12-23 00:53:29', '2025-12-23 00:53:29'),
(110, 'Apash', 'Ash', 'apashash28@gmail.com', '+237655917668', NULL, '$2y$12$DP5Wy53RtsfZy/OLTlES4OcC8/6uLlxdHz7h/uiJI2T1CxBZYn8xG', 0, NULL, NULL, NULL, '2025-12-23 06:35:29', '2025-12-23 06:35:29'),
(111, 'ok', 'okkkkk', 'phishing@gmail.com', '+2777777777', NULL, '$2y$12$QUcgnNb3ka7NOfztCuAmDuAOlhbYoVssDCbpjkunarMy97yxZoZ1m', 0, NULL, NULL, NULL, '2025-12-23 10:10:31', '2025-12-23 10:10:31'),
(112, 'Fuck', 'You', 'hacker@ndumba.com', '+243900000000', NULL, '$2y$12$KQ9R9KgVVBXaSkUKNyss1uBncvZJE4XBbH52l5pOeNuTHsmOCCXp6', 0, NULL, NULL, NULL, '2025-12-23 10:55:47', '2025-12-23 10:55:47'),
(113, 'Mukaya', 'israel', 'hacker@gmail.com', '+243900000000', NULL, '$2y$12$NlGRwS/tJY0ALZNSxo7JUOJAmWz8qG8FGM.ZBZZnTmYGuaXtrW6lK', 0, NULL, NULL, NULL, '2025-12-23 10:56:44', '2025-12-23 10:56:44'),
(114, 'Israel', 'Ntalu', 'israelntalu328@gmail.com', '+243900000000', NULL, '$2y$12$jovB17MJabfbQS4.13nhHulXyWA0r0QxFIyadT5cJgo5U6vNyrnPq', 0, NULL, NULL, NULL, '2025-12-23 10:58:00', '2025-12-23 10:58:00'),
(115, 'Whannou', 'Daniel', 'danielw@smileupplatform.com', '+22940592157', NULL, '$2y$12$KatCcrgOH2fiPnnDQCWTD.hqCA/36Z3HqTBLnHbIelESgHlX8btiC', 0, NULL, NULL, NULL, '2025-12-23 13:18:03', '2025-12-23 13:18:03'),
(116, 'Hollande', 'Marie Louise', 'topoat602@magim.be', '2290150095378', NULL, '$2y$12$DMLRcJ7mEvmyWUar2mJWYOiaWCA4RvD.as65JnPaMKzsTa5CGRJvK', 0, NULL, 60, NULL, '2025-12-23 14:16:46', '2025-12-23 14:16:46'),
(117, 'Glody', 'Maestro', 'maestroglody31@gmail.com', '0846790969', NULL, '$2y$12$j1x1FT2HetmW/uf.s.8XnewGkFdmQ3wl0WXkTBrzRUKZ9ACdLFpaa', 0, NULL, NULL, NULL, '2025-12-23 17:55:16', '2025-12-23 17:55:16'),
(118, 'GLODY', 'Maestro', 'maestroglody7@gmail.com', '+243846790969', NULL, '$2y$12$GSgIe4hRBRlNtkfbMsSKz.1FngMyfzjpbUhlBFcMHGRF2.zcacjW.', 0, NULL, NULL, NULL, '2025-12-23 17:57:19', '2025-12-23 17:57:19'),
(119, 'Hollande', 'Marie Louise', 'fedexexpresslagence7@gmail.com', '22950095378', NULL, '$2y$12$xkRb6NFOtc86m5ECfgoKyu4nUygu3x1Ic2er6F4x7wxbvh/RqtcMm', 0, NULL, NULL, NULL, '2025-12-23 19:14:54', '2025-12-23 19:14:54'),
(120, 'Kijoho', 'Raphaël', 'ubabanque.dg@gmail.com', '22942663596', NULL, '$2y$12$dqvWFTQU.AqDxaQ6S0Hg.OdXvZhKEKIv2JHROGzQFtRRnX3.tiipG', 0, NULL, 60, NULL, '2025-12-23 21:21:23', '2025-12-23 21:21:23'),
(121, 'Hollande', 'Marie Louise', 'tarpophow@cream.pink', '22950095378', NULL, '$2y$12$MS4ecAywZ1ZS1Z.21R7W0uvn/kyZwC15jcPhd7kFxdLchzLuVrUsq', 0, NULL, NULL, NULL, '2025-12-25 23:36:29', '2025-12-25 23:36:29'),
(122, 'Dupont', 'Henry', 'Idasodou@gmail.com', '2290146017212', NULL, '$2y$12$G5c72pPSj..9u/OFy1i1WeQ3eDKbGLvez7wBLKohDPlayibGT/BF.', 0, NULL, 60, NULL, '2025-12-26 13:24:12', '2025-12-26 13:24:12'),
(123, 'Crépin', 'Antoine', 'egideegide19@gmail.com', '22958826176', NULL, '$2y$12$jYQnqtusSCdsVGpLhazJHefc1jscXofIJs6rkLokR6Cdi0/sVksjO', 0, NULL, 60, NULL, '2025-12-26 13:28:30', '2025-12-26 13:28:30'),
(124, 'Kmj', 'Dröm', 'emilykym614@gmail.com', '+22999856044', NULL, '$2y$12$fwjdUoq37jSqFjHj7SknB.24TVz.MgZ0kxrzo8orGVbvdubCubSaK', 0, NULL, 60, NULL, '2025-12-26 21:11:19', '2025-12-26 21:11:19'),
(125, 'Yemeli', 'Adeline', 'dreamsagencycontact0@gmail.com', '+237652455010', NULL, '$2y$12$kN/GMPRSocksN2i/DwloEuXPUhFpAJC91P7ZA3FX7eBB.9yvym0gC', 0, NULL, NULL, NULL, '2025-12-26 21:14:27', '2025-12-26 21:14:27'),
(126, 'VARLET', 'Olivier', 'oliviercavard33@gmail.com', '+15143123880', NULL, '$2y$12$Ys2GUfn.pmA3UDDS.5jPQOBEy3SUftyv1SzJLpevarjuEISCj7Q2.', 0, NULL, NULL, NULL, '2026-01-12 17:32:44', '2026-01-12 17:32:44'),
(127, 'Smith', 'Espoir', 'smithespoir283@gmail.com', '+22963741328', NULL, '$2y$12$72qxGEb8VvHiriOGtMwjJOXRVEQwmXzJRrv.hQPoQPMGy2mygfIk2', 0, NULL, NULL, NULL, '2026-01-20 09:38:35', '2026-01-20 09:38:35'),
(128, 'Molina', 'Angel lopez', 'angelalopezmolina55@gmail.com', '2290152454486', NULL, '$2y$12$jVGXRusecNgByCGIjN7yu.8s6KYPDf9jttG9.DkYLDxg2DU9N3jti', 0, NULL, 83, NULL, '2026-01-29 06:58:25', '2026-01-29 09:38:49'),
(129, 'Soltani', 'Rachid', 'diagonaleroger@gmail.com', '2290194600300', NULL, '$2y$12$WTE/5aHm5UQMgEddVyD0OONaZJtL4YaKVNbOOsP3fjOCI9btuO9ye', 0, NULL, NULL, NULL, '2026-02-04 20:17:11', '2026-02-04 20:17:11'),
(130, 'Buberl', 'Thomas', 'pepesoymillonario8@gmail.com', '0193943596', NULL, '$2y$12$K/7WGULhWg22QXGWmL1iee8EUmUJOkLtiu9NrHrjtr5NlmToUtAbW', 0, NULL, NULL, NULL, '2026-02-05 09:48:26', '2026-02-05 09:48:26'),
(131, 'Justice', 'Divine', 'justicedivine99933@gmail.com', '+2260150593218', NULL, '$2y$12$lx5FHt4GQoZ9.w8epDgX3uVASv2QZ1jYNW0fOtKL6sOri6IPvdr4O', 4000, NULL, NULL, NULL, '2026-02-12 09:57:27', '2026-02-23 19:11:23'),
(132, 'Sossou', 'Benjamin', 'sossoubenjamin937@gmail.com', '+22999578404', NULL, '$2y$12$J70AXgVrje7kAMULe4564eG.UdrNi2pQlQ.CIhELw/N4HvgXwnMKi', 0, NULL, NULL, NULL, '2026-02-13 14:14:36', '2026-02-13 14:14:36'),
(133, 'ADJOVI', 'Ghislain', 'ghislainadjovi6@gmail.com', '2290164141728', NULL, '$2y$12$GNEAE/WWfoSkzqsV/SnESu.sWze.IPaXTvISE96uUAcJ.5C/w/Dfe', 0, NULL, NULL, NULL, '2026-02-19 19:22:37', '2026-02-19 19:22:37'),
(134, 'Sawadoga', 'Roger', 'sawadogaroger02@gmail.com', '+22955771656', NULL, '$2y$12$NiBauNRRyWmAqwL3ctIJ7uUAHOPxr0ENNip/.HzoZW1Hv3vQDM3sO', 0, NULL, NULL, NULL, '2026-02-21 08:47:34', '2026-02-21 08:47:34'),
(135, 'Jean', 'Veil', 'jeanviel631@gmail.com', '2290153655565', NULL, '$2y$12$IsYqB6GfoipBrHUUhjcE8.HucIGO5Cihw0MmM/LT2NrH6w71vKOhO', 0, NULL, NULL, NULL, '2026-02-23 17:51:17', '2026-02-23 17:51:17'),
(136, 'Dedeyan', 'Stéphane', 'gedeonlate545@gmail.com', '+22960046025', NULL, '$2y$12$cmkk5su1xibEXV8RAgItOecrlYesAb2Q4N30DqCNjub2FM76gRaPq', 0, NULL, NULL, NULL, '2026-02-25 09:10:44', '2026-02-25 09:10:44'),
(137, 'Robinson Fluit', 'Mark', 'procarmelo51@gmail.com', '22991217069', NULL, '$2y$12$AxrI0.V9qWCYzE2U1ZJDxO/lEsRE7dxcqu1iIizA9VTfOI7akh.n2', 0, NULL, NULL, NULL, '2026-03-04 19:34:01', '2026-03-04 19:34:01'),
(138, 'Horváth', 'Marie', 'mariehorváth443@gmail.com', '99490517', NULL, '$2y$12$Jq7UkLuyUy3EADTdqkEh/uedSJk4gR1hNVVOfBJfHJzXjLQgv/qQi', 4000, NULL, NULL, NULL, '2026-03-17 01:39:27', '2026-03-21 08:43:42');

-- --------------------------------------------------------

--
-- Structure de la table `virements`
--

CREATE TABLE `virements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `compte_id` bigint(20) UNSIGNED NOT NULL,
  `iban` varchar(255) NOT NULL,
  `bic` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `beneficiary_name` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `solidvire` decimal(15,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `unlock_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `affiliations`
--
ALTER TABLE `affiliations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `affiliations_code_affiliation_unique` (`code_affiliation`),
  ADD KEY `affiliations_user_id_foreign` (`user_id`),
  ADD KEY `affiliations_parrain_id_foreign` (`parrain_id`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `commissions`
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commissions_affiliation_id_foreign` (`affiliation_id`),
  ADD KEY `commissions_parraine_user_id_foreign` (`parraine_user_id`),
  ADD KEY `commissions_compte_id_foreign` (`compte_id`);

--
-- Index pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `comptes_numerocompte_unique` (`numerocompte`),
  ADD UNIQUE KEY `comptes_public_token_unique` (`public_token`),
  ADD KEY `comptes_user_id_foreign` (`user_id`),
  ADD KEY `comptes_auto_deletes_at_index` (`auto_deletes_at`),
  ADD KEY `comptes_is_auto_created_index` (`is_auto_created`);

--
-- Index pour la table `credit_audits`
--
ALTER TABLE `credit_audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `credit_audits_user_id_index` (`user_id`),
  ADD KEY `credit_audits_compte_id_index` (`compte_id`);

--
-- Index pour la table `dismissed_alerts`
--
ALTER TABLE `dismissed_alerts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ux_user_alert_compte` (`compte_id`,`alert_type`,`alert_id`);

--
-- Index pour la table `email_extractor_history`
--
ALTER TABLE `email_extractor_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_extractor_history_user_id_foreign` (`user_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mail_history`
--
ALTER TABLE `mail_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mail_history_user_id_foreign` (`user_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `recharge_histories`
--
ALTER TABLE `recharge_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recharge_histories_user_id_foreign` (`user_id`),
  ADD KEY `recharge_histories_compte_id_foreign` (`compte_id`);

--
-- Index pour la table `recharge_transactions`
--
ALTER TABLE `recharge_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recharge_transactions_transaction_id_unique` (`transaction_id`),
  ADD KEY `recharge_transactions_compte_id_foreign` (`compte_id`),
  ADD KEY `recharge_transactions_user_id_status_index` (`user_id`,`status`),
  ADD KEY `recharge_transactions_status_created_at_index` (`status`,`created_at`);

--
-- Index pour la table `remboursements`
--
ALTER TABLE `remboursements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `remboursements_compte_id_foreign` (`compte_id`);

--
-- Index pour la table `retraits`
--
ALTER TABLE `retraits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `retraits_user_id_statut_index` (`user_id`,`statut`),
  ADD KEY `retraits_affiliation_id_date_demande_index` (`affiliation_id`,`date_demande`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `sms_history`
--
ALTER TABLE `sms_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sms_history_user_id_foreign` (`user_id`);

--
-- Index pour la table `sub_account_sessions`
--
ALTER TABLE `sub_account_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_account_sessions_compte_id_index` (`compte_id`),
  ADD KEY `sub_account_sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_messages_user_id_foreign` (`user_id`),
  ADD KEY `support_messages_support_ticket_id_created_at_index` (`support_ticket_id`,`created_at`);

--
-- Index pour la table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_tickets_user_id_foreign` (`user_id`),
  ADD KEY `support_tickets_status_updated_at_index` (`status`,`updated_at`);

--
-- Index pour la table `transaction_histories`
--
ALTER TABLE `transaction_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_histories_user_id_foreign` (`user_id`),
  ADD KEY `transaction_histories_compte_id_foreign` (`compte_id`),
  ADD KEY `idx_transaction_transfer_id` (`transfer_id`);

--
-- Index pour la table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transfers_user_id_foreign` (`user_id`),
  ADD KEY `transfers_compte_id_index` (`compte_id`),
  ADD KEY `transfers_compte_id_inferred_index` (`compte_id_inferred`);

--
-- Index pour la table `unlock_codes`
--
ALTER TABLE `unlock_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unlock_codes_transfer_id_foreign` (`transfer_id`),
  ADD KEY `unlock_codes_compte_id_foreign` (`compte_id`);

--
-- Index pour la table `url_shortener_history`
--
ALTER TABLE `url_shortener_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url_shortener_history_short_url_unique` (`short_url`),
  ADD KEY `url_shortener_history_user_id_foreign` (`user_id`);

--
-- Index pour la table `url_verifications`
--
ALTER TABLE `url_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `url_verifications_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `url_verifications_domain_index` (`domain`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_parrain_id_foreign` (`parrain_id`);

--
-- Index pour la table `virements`
--
ALTER TABLE `virements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `virements_compte_id_foreign` (`compte_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `affiliations`
--
ALTER TABLE `affiliations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT pour la table `commissions`
--
ALTER TABLE `commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `comptes`
--
ALTER TABLE `comptes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT pour la table `credit_audits`
--
ALTER TABLE `credit_audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dismissed_alerts`
--
ALTER TABLE `dismissed_alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `email_extractor_history`
--
ALTER TABLE `email_extractor_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mail_history`
--
ALTER TABLE `mail_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT pour la table `recharge_histories`
--
ALTER TABLE `recharge_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `recharge_transactions`
--
ALTER TABLE `recharge_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT pour la table `remboursements`
--
ALTER TABLE `remboursements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT pour la table `retraits`
--
ALTER TABLE `retraits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `sms_history`
--
ALTER TABLE `sms_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT pour la table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `transaction_histories`
--
ALTER TABLE `transaction_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=445;

--
-- AUTO_INCREMENT pour la table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT pour la table `unlock_codes`
--
ALTER TABLE `unlock_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT pour la table `url_shortener_history`
--
ALTER TABLE `url_shortener_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `url_verifications`
--
ALTER TABLE `url_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT pour la table `virements`
--
ALTER TABLE `virements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `affiliations`
--
ALTER TABLE `affiliations`
  ADD CONSTRAINT `affiliations_parrain_id_foreign` FOREIGN KEY (`parrain_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `affiliations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `commissions`
--
ALTER TABLE `commissions`
  ADD CONSTRAINT `commissions_affiliation_id_foreign` FOREIGN KEY (`affiliation_id`) REFERENCES `affiliations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commissions_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commissions_parraine_user_id_foreign` FOREIGN KEY (`parraine_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD CONSTRAINT `comptes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `email_extractor_history`
--
ALTER TABLE `email_extractor_history`
  ADD CONSTRAINT `email_extractor_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `mail_history`
--
ALTER TABLE `mail_history`
  ADD CONSTRAINT `mail_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `recharge_histories`
--
ALTER TABLE `recharge_histories`
  ADD CONSTRAINT `recharge_histories_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recharge_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `recharge_transactions`
--
ALTER TABLE `recharge_transactions`
  ADD CONSTRAINT `recharge_transactions_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `recharge_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `remboursements`
--
ALTER TABLE `remboursements`
  ADD CONSTRAINT `remboursements_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `retraits`
--
ALTER TABLE `retraits`
  ADD CONSTRAINT `retraits_affiliation_id_foreign` FOREIGN KEY (`affiliation_id`) REFERENCES `affiliations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `retraits_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sms_history`
--
ALTER TABLE `sms_history`
  ADD CONSTRAINT `sms_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `support_messages`
--
ALTER TABLE `support_messages`
  ADD CONSTRAINT `support_messages_support_ticket_id_foreign` FOREIGN KEY (`support_ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `support_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `transaction_histories`
--
ALTER TABLE `transaction_histories`
  ADD CONSTRAINT `transaction_histories_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `transfers`
--
ALTER TABLE `transfers`
  ADD CONSTRAINT `transfers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `unlock_codes`
--
ALTER TABLE `unlock_codes`
  ADD CONSTRAINT `unlock_codes_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `unlock_codes_transfer_id_foreign` FOREIGN KEY (`transfer_id`) REFERENCES `transfers` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `url_shortener_history`
--
ALTER TABLE `url_shortener_history`
  ADD CONSTRAINT `url_shortener_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `url_verifications`
--
ALTER TABLE `url_verifications`
  ADD CONSTRAINT `url_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_parrain_id_foreign` FOREIGN KEY (`parrain_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `virements`
--
ALTER TABLE `virements`
  ADD CONSTRAINT `virements_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
