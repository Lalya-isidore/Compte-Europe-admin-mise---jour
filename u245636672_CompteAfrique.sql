-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 29 mars 2026 à 20:31
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
-- Base de données : `u245636672_CompteAfrique`
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
  `commission_rate` decimal(5,2) NOT NULL DEFAULT 10.00,
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
(1, 1, NULL, 'AFFB18F63A7', 5.00, 512.50, 3, 1, NULL, '2025-11-29 17:09:03', '2025-12-30 16:58:38'),
(3, 3, 1, 'AFFC7DCA276', 5.00, 1900750.00, 1, 1, NULL, '2025-11-30 21:31:06', '2026-02-03 11:00:22'),
(4, 4, 1, 'AFFC2F2D52E', 5.00, 0.00, 0, 1, NULL, '2025-12-01 13:12:58', '2025-12-01 13:12:58'),
(5, 5, NULL, 'AFF85BEFB9E', 5.00, 0.00, 0, 1, NULL, '2025-12-04 15:51:02', '2025-12-04 15:51:02'),
(6, 6, 1, 'AFF77D28218', 5.00, 0.00, 0, 1, NULL, '2025-12-04 19:21:15', '2025-12-04 19:21:15'),
(7, 7, 3, 'AFFF49AAC1A', 5.00, 0.00, 0, 1, NULL, '2025-12-05 06:39:37', '2025-12-05 06:39:37'),
(8, 8, NULL, 'AFFF91117DF', 5.00, 0.00, 0, 1, NULL, '2025-12-05 20:30:41', '2025-12-05 20:30:41'),
(9, 9, NULL, 'AFF0297F624', 5.00, 0.00, 0, 1, NULL, '2025-12-27 10:11:52', '2025-12-27 10:11:52'),
(10, 10, NULL, 'AFFA25BE4BB', 5.00, 0.00, 0, 1, NULL, '2025-12-28 22:02:54', '2025-12-28 22:02:54'),
(11, 11, NULL, 'AFF369A94F7', 5.00, 0.00, 0, 1, NULL, '2026-01-01 16:09:15', '2026-01-01 16:09:15'),
(12, 12, NULL, 'AFF8AF3FABA', 5.00, 0.00, 0, 1, NULL, '2026-01-05 13:39:58', '2026-01-05 13:39:58'),
(13, 13, NULL, 'AFF6C64A28A', 5.00, 0.00, 0, 1, NULL, '2026-01-11 05:36:22', '2026-01-11 05:36:22'),
(14, 14, NULL, 'AFFFD559B75', 5.00, 0.00, 0, 1, NULL, '2026-01-21 19:10:26', '2026-01-21 19:10:26'),
(15, 15, NULL, 'AFF37971BDC', 5.00, 0.00, 0, 1, NULL, '2026-01-29 16:14:47', '2026-01-29 16:14:47'),
(16, 16, NULL, 'AFF0C44743A', 5.00, 0.00, 0, 1, NULL, '2026-02-02 10:03:28', '2026-02-02 10:03:28'),
(17, 17, NULL, 'AFF72769713', 5.00, 0.00, 0, 1, NULL, '2026-02-03 15:23:43', '2026-02-03 15:23:43'),
(18, 18, NULL, 'AFF27439CE3', 5.00, 0.00, 0, 1, NULL, '2026-02-03 16:19:54', '2026-02-03 16:19:54'),
(19, 19, NULL, 'AFFBEFB50B1', 5.00, 0.00, 0, 1, NULL, '2026-02-03 22:57:52', '2026-02-03 22:57:52'),
(20, 20, NULL, 'AFF0BD37304', 5.00, 0.00, 0, 1, NULL, '2026-02-04 14:15:07', '2026-02-04 14:15:07'),
(21, 21, NULL, 'AFF3A213FDB', 5.00, 0.00, 0, 1, NULL, '2026-02-05 07:38:47', '2026-02-05 07:38:47'),
(22, 22, NULL, 'AFFF761D8E6', 5.00, 0.00, 0, 1, NULL, '2026-02-05 20:57:13', '2026-02-05 20:57:13'),
(23, 23, NULL, 'AFF59124FF7', 5.00, 0.00, 0, 1, NULL, '2026-02-07 05:02:26', '2026-02-07 05:02:26'),
(24, 24, NULL, 'AFFC4BCAD03', 5.00, 323190.45, 5, 1, NULL, '2026-02-08 21:52:10', '2026-03-25 21:12:52'),
(25, 25, 24, 'AFF8D702B7F', 5.00, 0.00, 0, 1, NULL, '2026-02-08 22:00:09', '2026-02-08 22:00:09'),
(26, 26, NULL, 'AFFE55CB598', 5.00, 0.00, 0, 1, NULL, '2026-02-09 10:51:16', '2026-02-09 10:51:16'),
(27, 27, NULL, 'AFF335104B4', 5.00, 0.00, 0, 1, NULL, '2026-02-09 13:12:26', '2026-02-09 13:12:26'),
(28, 28, NULL, 'AFF28CC3632', 5.00, 0.00, 0, 1, NULL, '2026-02-09 17:10:14', '2026-02-09 17:10:14'),
(29, 29, NULL, 'AFF7C5A3F7A', 5.00, 0.00, 0, 1, NULL, '2026-02-10 10:24:54', '2026-02-10 10:24:54'),
(30, 30, NULL, 'AFF6572B53A', 5.00, 0.00, 0, 1, NULL, '2026-02-10 19:34:36', '2026-02-10 19:34:36'),
(31, 31, NULL, 'AFF88192B10', 5.00, 0.00, 0, 1, NULL, '2026-02-11 11:24:17', '2026-02-11 11:24:17'),
(32, 32, 24, 'AFF60C97DC3', 5.00, 0.00, 0, 1, NULL, '2026-02-11 11:51:30', '2026-02-11 11:51:30'),
(33, 33, 24, 'AFFC3403361', 5.00, 0.00, 0, 1, NULL, '2026-02-13 07:21:46', '2026-02-13 07:21:46'),
(34, 34, NULL, 'AFF8AED544E', 5.00, 0.00, 0, 1, NULL, '2026-02-18 17:25:01', '2026-02-18 17:25:01'),
(35, 35, NULL, 'AFFC6FF82C7', 5.00, 0.00, 0, 1, NULL, '2026-02-19 12:00:49', '2026-02-19 12:00:49'),
(36, 36, NULL, 'AFFC269BCEA', 5.00, 0.00, 0, 1, NULL, '2026-02-20 07:51:17', '2026-02-20 07:51:17'),
(37, 37, NULL, 'AFF0410E8E2', 5.00, 0.00, 0, 1, NULL, '2026-02-23 10:52:03', '2026-02-23 10:52:03'),
(38, 38, NULL, 'AFF80A1A05F', 5.00, 0.00, 0, 1, NULL, '2026-02-25 20:39:06', '2026-02-25 20:39:06'),
(39, 39, NULL, 'AFF38982A70', 5.00, 0.00, 0, 1, NULL, '2026-02-26 06:49:40', '2026-02-26 06:49:40'),
(40, 40, NULL, 'AFF844C788A', 5.00, 0.00, 0, 1, NULL, '2026-02-27 09:48:16', '2026-02-27 09:48:16'),
(41, 41, NULL, 'AFFD47CDD61', 5.00, 0.00, 0, 1, NULL, '2026-03-05 04:19:19', '2026-03-05 04:19:19'),
(42, 42, NULL, 'AFFFDDC097E', 5.00, 0.00, 0, 1, NULL, '2026-03-09 12:10:05', '2026-03-09 12:10:05'),
(43, 43, NULL, 'AFFA063D205', 5.00, 0.00, 0, 1, NULL, '2026-03-12 06:10:19', '2026-03-12 06:10:19'),
(44, 44, NULL, 'AFFE1DAF9C4', 5.00, 0.00, 0, 1, NULL, '2026-03-12 16:22:55', '2026-03-12 16:22:55'),
(45, 45, NULL, 'AFF5E69DB30', 5.00, 0.00, 0, 1, NULL, '2026-03-13 18:42:41', '2026-03-13 18:42:41'),
(46, 46, NULL, 'AFFA26180F7', 5.00, 0.00, 0, 1, NULL, '2026-03-14 11:22:54', '2026-03-14 11:22:54'),
(47, 47, NULL, 'AFF8BC235CB', 5.00, 0.00, 0, 1, NULL, '2026-03-16 19:53:39', '2026-03-16 19:53:39'),
(48, 48, 24, 'AFF73BC3599', 5.00, 0.00, 0, 1, NULL, '2026-03-17 07:52:38', '2026-03-17 07:52:38'),
(49, 49, NULL, 'AFF5B7CC136', 5.00, 0.00, 0, 1, NULL, '2026-03-18 05:45:55', '2026-03-18 05:45:55'),
(50, 50, NULL, 'AFFF2DB9E19', 5.00, 0.00, 0, 1, NULL, '2026-03-18 09:06:47', '2026-03-18 09:06:47'),
(51, 51, NULL, 'AFF7B550771', 5.00, 0.00, 0, 1, NULL, '2026-03-22 19:23:28', '2026-03-22 19:23:28'),
(52, 52, 24, 'AFF7573FD1E', 5.00, 0.00, 0, 1, NULL, '2026-03-25 21:12:52', '2026-03-25 21:12:52');

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 3, 7, 8, 'recharge', 5000.00, 5.00, 250.00, 'valide', '2025-12-05 07:07:29', '2025-12-05 07:07:29', '{\"transaction_id\":\"RCTB7TSQZV1764918408\",\"payment_method\":\"mobile_money\",\"credits_earned\":5000,\"auto_processed\":true}', '2025-12-05 07:07:29', '2025-12-05 07:07:29'),
(2, 1, 3, 4, 'depot', 250.00, 5.00, 12.50, 'en_attente', '2025-12-05 07:07:29', NULL, '{\"description\":\"Commission sur d\\u00e9p\\u00f4t de 250.00 F CFA par Dupond \\u00c9ric\",\"solde_avant\":\"10000.00\",\"solde_apres\":\"10250.00\",\"augmentation\":250}', '2025-12-05 07:07:29', '2025-12-05 07:07:29'),
(5, 3, 7, 11, 'creation_compte', 7000000.00, 5.00, 350000.00, 'en_attente', '2025-12-05 13:20:39', NULL, '{\"description\":\"Commission pour la cr\\u00e9ation du compte Standard par Yves Lovard\"}', '2025-12-05 13:20:39', '2025-12-05 13:20:39'),
(7, 3, 7, 11, 'depot', 7000000.00, 5.00, 350000.00, 'en_attente', '2025-12-28 09:40:41', NULL, '{\"description\":\"Commission sur d\\u00e9p\\u00f4t de 7000000.00 F CFA par Yves Lovard\",\"solde_avant\":\"0.00\",\"solde_apres\":\"7000000.00\",\"augmentation\":7000000}', '2025-12-28 09:40:41', '2025-12-28 09:40:41'),
(8, 1, 6, 7, 'depot', 10000.00, 5.00, 500.00, 'en_attente', '2025-12-30 16:58:38', NULL, '{\"description\":\"Commission sur d\\u00e9p\\u00f4t de 10000.00 F CFA par Yves Yves\",\"solde_avant\":\"0.00\",\"solde_apres\":\"10000.00\",\"augmentation\":10000}', '2025-12-30 16:58:38', '2025-12-30 16:58:38'),
(9, 3, 7, 8, 'depot', 10000.00, 5.00, 500.00, 'en_attente', '2025-12-31 10:02:00', NULL, '{\"description\":\"Commission sur d\\u00e9p\\u00f4t de 10000.00 F CFA par Yves Lovard\",\"solde_avant\":\"0.00\",\"solde_apres\":\"10000.00\",\"augmentation\":10000}', '2025-12-31 10:02:00', '2025-12-31 10:02:00'),
(11, 24, 32, 53, 'creation_compte', 6458809.00, 5.00, 322940.45, 'en_attente', '2026-02-27 17:21:50', NULL, '{\"description\":\"Commission pour la cr\\u00e9ation du compte Professionnel par Ce kit\"}', '2026-02-27 17:21:50', '2026-02-27 17:21:50'),
(12, 24, 25, 34, 'recharge', 5000.00, 5.00, 250.00, 'valide', '2026-03-16 07:50:06', '2026-03-16 07:50:06', '{\"transaction_id\":\"RCMNEGCXYR1773647326\",\"payment_method\":\"mobile_money\",\"credits_earned\":5000,\"auto_processed\":true}', '2026-03-16 07:50:06', '2026-03-16 07:50:06');

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
  `account_status` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `transfer_supported` varchar(255) NOT NULL,
  `token` varchar(60) DEFAULT NULL,
  `iban` varchar(255) DEFAULT NULL,
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`parameters`)),
  `card_number` varchar(255) NOT NULL,
  `numerocompte` varchar(255) DEFAULT NULL,
  `cvv` varchar(255) NOT NULL,
  `start_percentage` varchar(255) NOT NULL,
  `end_percentage` varchar(255) NOT NULL,
  `failure_message` varchar(255) NOT NULL,
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

INSERT INTO `comptes` (`id`, `user_id`, `nom`, `prenom`, `email`, `phone_number`, `country`, `address`, `devise`, `lang`, `account_balance`, `account_balance2`, `credits_available`, `account_type`, `code_virement`, `account_status`, `password`, `transfer_supported`, `token`, `iban`, `parameters`, `card_number`, `numerocompte`, `cvv`, `start_percentage`, `end_percentage`, `failure_message`, `photo_path`, `alert_email`, `alert_sms`, `is_default`, `created_at`, `updated_at`, `auto_deletes_at`, `is_auto_created`) VALUES
(1, 1, 'AHOSSI', 'Candide', 'lalyaisidore@gmail.com', '+22656311804', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 0.00, 978800.00, 0.00, 'Standard', '614070', 'Bloqué', '980527', 'Virement bancaire', NULL, NULL, NULL, '4464********1794', 'FC-GEVINFJJG8', '677', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Candide+Candide&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-29 17:09:02', '2026-02-03 14:35:15', '2025-11-29 18:09:02', 1),
(3, 1, 'Flora', 'Lalya', 'isidorelalya@gmail.com', '0198201610', 'Bénin (+229)', 'Paris-France', 'XAF', 'en', 56900.00, 56900.00, 0.00, 'Professionnel', '924194', 'Activé', '181337', 'SEPA', NULL, NULL, NULL, '4777********8331', 'FC-C575SEJ1A0', '814', '1', '100', 'Transfert effectuer', NULL, 1, 1, 0, '2025-11-30 13:47:37', '2025-12-26 16:51:48', NULL, 0),
(4, 3, 'Éric', 'Dupond', 'esterode44@gmail.com', '+2290159323034', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10250.00, 10000.00, 0.00, 'Standard', '699072', 'Activé', '241890', 'Virement bancaire', NULL, NULL, NULL, '4327********3710', 'FC-FVHYG4OBSW', '656', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Dupond+%C3%89ric&background=28a745&color=fff&size=50', 1, 0, 0, '2025-11-30 21:31:06', '2025-12-05 07:07:29', '2025-11-30 22:31:06', 1),
(5, 4, 'Dupont', 'François', 'rethispremier@gmail.com', '+2290155649488', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '112283', 'Activé', '806622', 'Virement bancaire', NULL, NULL, NULL, '4727********4130', 'FC-5MNEKIRYC5', '853', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Fran%C3%A7ois+Dupont&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-01 13:12:58', '2025-12-01 13:12:58', '2025-12-01 14:12:58', 1),
(6, 5, 'EZÉCHIEL', 'TCHOKPONHOUE', 'ezechieltchokponhoue@gmail.com', '+22960067966', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '445732', 'Activé', '849152', 'Virement bancaire', NULL, NULL, NULL, '4760********7645', 'FC-VK2KOANXYX', '252', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=TCHOKPONHOUE+EZ%C3%89CHIEL&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-04 15:51:02', '2025-12-04 15:51:02', '2025-12-04 16:51:02', 1),
(7, 6, 'Yves', 'Yves', 'yveslovard@gmail.com', '+2290168447610', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '298182', 'Activé', '369331', 'Virement bancaire', NULL, NULL, NULL, '4691********1464', 'FC-BKNAEQVNNX', '992', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Yves+Yves&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-04 19:21:15', '2025-12-30 16:58:38', '2025-12-04 20:21:15', 1),
(8, 7, 'Lovard', 'Yves', 'yvesmahugnon56@gmail.com', '+2290168447610', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 4500.00, 4500.00, 0.00, 'Standard', '319162', 'Activé', '238877', 'Virement bancaire', NULL, NULL, NULL, '4642********1247', 'FC-KFK9Y3FAJ7', '839', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Yves+Lovard&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-05 06:39:37', '2026-01-01 17:37:46', '2025-12-05 07:39:37', 1),
(11, 7, 'N\'DOLI', 'Kouame François', 'jesushandoli@gmail.com', '+225 09 97 82 26', 'Côte d’Ivoire (+225)', 'Abidjan', 'XOF', 'fr', 0.00, 0.00, 0.00, 'Standard', '256555', 'Bloqué', '665232', 'Ecobank', NULL, NULL, NULL, '4791********6941', 'FC-VBWWXBTYIR', '488', '1', '25', 'Votre compte est temporairement bloqué pour des raisons de sécurité. Contactez le service client pour une meilleure prise en charge', 'comptes-photos/compte_6932dc27a8549.jpg', 1, 1, 0, '2025-12-05 13:20:39', '2026-01-01 17:38:33', NULL, 0),
(12, 8, 'PAPA', 'Kanfa', 'papakanfa@gmail.com', '22653504648', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 0.00, 10000.00, 0.00, 'Standard', '678120', 'Activé', '747488', 'Virement bancaire', NULL, NULL, NULL, '4930********7932', 'FC-FP42NMRQYI', '276', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Kanfa+PAPA&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-05 20:30:41', '2025-12-05 20:30:41', '2025-12-05 21:30:41', 1),
(13, 1, 'OUEDRAOGO', 'Jacques', 'jacquesrichesse1340@gmail.com', '+226 57 11 06 32', 'Burkina Faso (+226)', 'Ouagadou Burkina Faso', 'XOF', 'fr', 200000.00, 200000.00, 0.00, 'Professionnel', '486623', 'Examen', '834470', 'Instantané', NULL, NULL, NULL, '4890********8901', 'FC-Q3IAS4C06K', '467', '1', '100', 'Transfert effectué avec succès', NULL, 1, 1, 0, '2025-12-08 11:16:59', '2025-12-08 11:16:59', NULL, 0),
(15, 9, 'Flora', 'Flora', 'floralalya@gmail.com', '+22954491959', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '810466', 'Activé', '596175', 'Virement bancaire', NULL, NULL, NULL, '4516********5119', 'FC-SGODYC9X15', '515', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Flora+Flora&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-27 10:11:52', '2025-12-27 10:11:52', '2025-12-27 11:11:52', 1),
(16, 9, 'SERVICE', 'ASLAN', 'floralalya4@gmail.com', '51503188', 'Bénin (+229)', 'Abomey - CAlavi, Tokan Aitchédji', '€', 'zh-CN', 5000.00, 5000.00, 0.00, 'Professionnel', '507969', 'Activé', '471221', 'TRANSERCASH', NULL, NULL, NULL, '4944********5472', 'FC-OM8IMSB2YX', '620', '1', '100', 'Transfert effectuer', NULL, 1, 1, 0, '2025-12-27 10:13:49', '2025-12-27 10:13:49', NULL, 0),
(17, 10, 'Elisabeth', 'Saraiva', 'saraivaelisabeth73@gmail.com', '+2290146411332', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '884453', 'Activé', '197001', 'Virement bancaire', NULL, NULL, NULL, '4480********3316', 'FC-FXF4X87BFN', '488', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Saraiva+Elisabeth&background=28a745&color=fff&size=50', 1, 0, 0, '2025-12-28 22:02:54', '2025-12-28 22:02:54', '2025-12-28 23:02:54', 1),
(18, 11, 'FARGEOT', 'ANNE-MARIE CLAUDE', 'ainokubard70@gmail.com', '+33725545545', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '500236', 'Activé', '862325', 'Virement bancaire', NULL, NULL, NULL, '4167********1280', 'FC-OPPGN9I52L', '628', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=ANNE-MARIE+CLAUDE+FARGEOT&background=28a745&color=fff&size=50', 1, 0, 0, '2026-01-01 16:09:15', '2026-01-01 16:09:15', '2026-01-01 17:09:15', 1),
(19, 12, 'Dupont', 'Alice', 'laurianoali4@gmail.com', '22961771273', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '482678', 'Activé', '383491', 'Virement bancaire', NULL, NULL, NULL, '4617********7571', 'FC-A9QLPUMQGN', '685', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Alice+Dupont&background=28a745&color=fff&size=50', 1, 0, 0, '2026-01-05 13:39:58', '2026-01-05 13:39:58', '2026-01-05 14:39:58', 1),
(20, 13, 'Fagbemy', 'Charbel', 'roberttaghetti@gmail.com', '+2290152785348', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '661960', 'Activé', '122201', 'Virement bancaire', NULL, NULL, NULL, '4572********2039', 'FC-N1HNCXRQIK', '935', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Charbel+Fagbemy&background=28a745&color=fff&size=50', 1, 0, 0, '2026-01-11 05:36:22', '2026-01-11 05:50:30', '2026-01-11 06:36:22', 1),
(21, 14, 'Janna', 'Alvarez', 'jannalvre@gmail.com', '22953197987', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '608483', 'Activé', '730693', 'Virement bancaire', NULL, NULL, NULL, '4385********2693', 'FC-RIDWDO1CHR', '234', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Alvarez+Janna&background=28a745&color=fff&size=50', 1, 0, 0, '2026-01-21 19:10:26', '2026-01-21 19:10:26', '2026-01-21 20:10:26', 1),
(22, 15, 'Estelle', 'Estelle', 'estellestelle.nina@gmail.com', '+22994319785', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '426244', 'Activé', '636625', 'Virement bancaire', NULL, NULL, NULL, '4468********6556', 'FC-2KOHNKTUP7', '796', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Estelle+Estelle&background=28a745&color=fff&size=50', 1, 0, 0, '2026-01-29 16:14:47', '2026-01-29 16:14:47', '2026-01-29 17:14:47', 1),
(23, 16, 'MORALES GUTIERREZ', 'IRENE', 'molaregu@gmail.com', '+34655418051', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '365310', 'Activé', '807485', 'Virement bancaire', NULL, NULL, NULL, '4578********6282', 'FC-3VCG3ZR7ZM', '819', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=IRENE+MORALES+GUTIERREZ&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-02 10:03:28', '2026-02-02 10:03:28', '2026-02-02 11:03:28', 1),
(25, 1, 'OUEDRAOGO', 'Jean', 'sidoinelalya@gmail.com', '22656311804', 'Burkina Faso (+226)', 'Ouagadougou Secteur 104', 'XOF', 'fr', 0.00, 4720000.00, 0.00, 'Professionnel', '812973', 'Activé', '339959', 'Instantané', NULL, NULL, NULL, '4971********9261', 'FC-T5XTCYRR14', '924', '1', '100', 'Transfert effectuer avec succès', NULL, 1, 1, 0, '2026-02-03 15:01:56', '2026-02-03 15:51:33', NULL, 0),
(26, 17, 'Dupont', 'Claude', 'hj923167@gmail.com', '+237691155830', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '947551', 'Activé', '931059', 'Virement bancaire', NULL, NULL, NULL, '4359********2147', 'FC-ZRKIHNEU1T', '465', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Claude+Dupont&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-03 15:23:43', '2026-02-03 15:23:43', '2026-02-03 16:23:43', 1),
(27, 18, 'Ngo\'o', 'Cyrus', 'cyrusboscongoo@gmail.com', '+237691351168', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 0.00, 10000.00, 0.00, 'Standard', '127166', 'Activé', '203879', 'Virement bancaire', NULL, NULL, NULL, '4952********8544', 'FC-CKMA5KNLCT', '866', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'comptes-photos/compte_6982216bd9753.jpg', 1, 0, 0, '2026-02-03 16:19:54', '2026-02-03 16:25:15', '2026-02-03 17:19:54', 1),
(28, 19, 'Dupont', 'Alice', 'loloche205@gmail.com', '+22953995324', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 0.00, 100006010000.00, 0.00, 'Standard', '807598', 'Activé', '855716', 'Virement bancaire', NULL, NULL, NULL, '4870********9654', 'FC-6VOL0YKIZH', '527', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Alice+Dupont&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-03 22:57:52', '2026-02-04 18:33:33', '2026-02-03 23:57:52', 1),
(29, 20, 'Tanoh', 'Kouadou Célestine', 'Tanohcelestine272@gmail.com', '+2250779121150', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 25000000.00, 25000000.00, 0.00, 'Standard', '222057', 'Activé', '749483', 'Virement bancaire', NULL, NULL, NULL, '4630********3080', 'FC-NCKUVYGOCH', '957', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Kouadou+C%C3%A9lestine+Tanoh&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-04 14:15:07', '2026-02-04 14:27:06', '2026-02-04 15:15:07', 1),
(30, 21, 'Rodrigo', 'Kizito', 'rodrigokizito9@gmail.com', '+2290150494200', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 450000.00, 450000.00, 0.00, 'Standard', '453990', 'Activé', '901460', 'Virement bancaire', NULL, NULL, NULL, '4681********2673', 'FC-M9CUZP2GJ2', '259', '1', '97', 'Cher bénéficiaire votre compte bancaire n\'est pas compatible pour garder les fonds afin qu\'il puisse garder vous aurez payer une facture de 8400 soles avant de recevoir les 450000 Euros sur ton compte', 'https://ui-avatars.com/api/?name=Kizito+Rodrigo&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-05 07:38:47', '2026-02-16 00:59:06', '2026-02-05 08:38:47', 1),
(31, 22, 'Dupont', 'Elsa', 'elsa52346@gmail.com', '+4915126192695', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '347082', 'Activé', '459616', 'Virement bancaire', NULL, NULL, NULL, '4217********3555', 'FC-NQRBD9XXME', '629', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Elsa+Dupont&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-05 20:57:13', '2026-02-05 20:57:13', '2026-02-05 21:57:13', 1),
(32, 23, 'Maria', 'Pavard', 'Bmobank38@gmail.com', '22953570853', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '541499', 'Activé', '467187', 'Virement bancaire', NULL, NULL, NULL, '4847********8276', 'FC-ITY8IOE1KL', '570', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Pavard+Maria&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-07 05:02:26', '2026-02-07 05:02:26', '2026-02-07 06:02:26', 1),
(33, 24, 'Alexandre', 'Huessou', 'alexandrehouessou212@gmail.com', '+22956456919', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 250.00, 15000.00, 0.00, 'Standard', '819152', 'Activé', '733425', 'Virement bancaire', NULL, NULL, NULL, '4910********1825', 'FC-WNXQ2EMZDH', '772', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Huessou+Alexandre&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-08 21:52:10', '2026-03-16 07:50:06', '2026-02-08 22:52:10', 1),
(34, 25, 'Walter', 'Rosemberg', 'internationalhurge@gmail.com', '+22950632067', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '935551', 'Activé', '338779', 'Virement bancaire', NULL, NULL, NULL, '4982********1372', 'FC-GGE5QNJFL3', '279', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Rosemberg+Walter&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-08 22:00:09', '2026-02-08 22:00:09', '2026-02-08 23:00:09', 1),
(35, 26, 'Hyves Haled', 'Ouedraogo', 'sandrinechaux71@gmail.com', '+2250152247446', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '338180', 'Activé', '678488', 'Virement bancaire', NULL, NULL, NULL, '4493********4568', 'FC-0IFSQKBPK9', '174', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Ouedraogo+Hyves+Haled&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-09 10:51:16', '2026-02-09 10:51:16', '2026-02-09 11:51:16', 1),
(36, 27, 'Marie', 'David', 'reondavid871@gmail.com', '+22893180880', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '424774', 'Activé', '587010', 'Virement bancaire', NULL, NULL, NULL, '4693********3349', 'FC-P7MZTQB3EC', '481', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=David+Marie&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-09 13:12:26', '2026-02-09 13:12:26', '2026-02-09 14:12:26', 1),
(37, 28, 'Bbva', 'Banco', 'asistentebancariobbva@gmail.com', '+351916348312', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 0.00, 10000.00, 0.00, 'Standard', '738681', 'Activé', '167230', 'Virement bancaire', NULL, NULL, NULL, '4493********5193', 'FC-DMP3UDQIEZ', '514', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Banco+Bbva&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-09 17:10:14', '2026-02-09 17:10:14', '2026-02-09 18:10:14', 1),
(38, 29, 'David', 'Jeanne', 'davance046@gmail.com', '+22893180880', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '360191', 'Activé', '806679', 'Virement bancaire', NULL, NULL, NULL, '4912********3030', 'FC-W3WQWGIRGD', '203', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Jeanne+David&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-10 10:24:54', '2026-02-10 10:24:54', '2026-02-10 11:24:54', 1),
(39, 28, 'François', 'Lefebvre', 'franslefebvre62@gmail.com', '7 63 64 78 07', 'France (+33)', 'Paris', '€', 'es', 20000.00, 20000.00, 0.00, 'Prépayé', '689184', 'Activé', '863157', 'BBVA BANCO', NULL, NULL, NULL, '4448********1578', 'FC-GXNHRJSLYY', '166', '37', '96', 'Transferencia de 20.000 € completada con éxito a la cuenta FR7614690000015600092202041 de François Lefebvre Émile Joseph', NULL, 1, 1, 0, '2026-02-10 13:54:41', '2026-02-10 13:54:41', NULL, 0),
(40, 30, 'Dedeyan', 'Stéphane', 'gedeonlate545@gmail.com', '+22960046025', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '805442', 'Activé', '508063', 'Virement bancaire', NULL, NULL, NULL, '4306********6753', 'FC-NGPDMPDJG6', '921', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=St%C3%A9phane+Dedeyan&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-10 19:34:35', '2026-02-10 19:34:35', '2026-02-10 20:34:35', 1),
(41, 31, 'Akpacla', 'Richard', 'moulinfrantzal@gmail.com', '+2290167563031', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '313853', 'Activé', '417600', 'Virement bancaire', NULL, NULL, NULL, '4895********1094', 'FC-7YJEJDPUNA', '278', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Richard+Akpacla&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-11 11:24:17', '2026-02-11 11:24:17', '2026-02-11 12:24:17', 1),
(42, 32, 'kit', 'Ce', '003cekit@gmail.com', '+2290160100912', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 0.00, 10000.00, 0.00, 'Standard', '959924', 'Activé', '453856', 'Virement bancaire', NULL, NULL, NULL, '4835********3129', 'FC-LTXIQRJOQY', '588', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Ce+kit&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-11 11:51:30', '2026-02-11 11:51:30', '2026-02-11 12:51:30', 1),
(43, 33, 'Elsa', 'Maria', 'anaciaramarine84@gmail.com', '+2290161831708', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '725757', 'Activé', '602271', 'Virement bancaire', NULL, NULL, NULL, '4289********1387', 'FC-LVH5PQMWM4', '589', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Maria+Elsa&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-13 07:21:46', '2026-02-13 07:21:46', '2026-02-13 08:21:46', 1),
(44, 34, 'Samwil', 'Biaou', 'samwilbiaou6@gmail.com', '0142235392', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '349792', 'Activé', '692422', 'Virement bancaire', NULL, NULL, NULL, '4215********2924', 'FC-NCYQY4XFAP', '934', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Biaou+Samwil&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-18 17:25:01', '2026-02-18 17:25:01', '2026-02-18 18:25:01', 1),
(45, 35, 'Sawadoga', 'Roger', 'sawadogaroger02@gmail.com', '+22955771656', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '821412', 'Activé', '236166', 'Virement bancaire', NULL, NULL, NULL, '4553********5719', 'FC-DUGWFD8IBM', '519', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Roger+Sawadoga&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-19 12:00:49', '2026-02-19 12:00:49', '2026-02-19 13:00:49', 1),
(46, 35, 'Delamou', 'Jean', 'Jeandelamou02@gmail.com', '+2250789103610', 'Côte d’Ivoire (+225)', 'Cocody', 'XOF', 'fr', 1000000.00, 1000000.00, 0.00, 'Professionnel', '698262', 'Activé', '132687', '1 000 000FCFA', NULL, NULL, NULL, '4645********2864', 'FC-RBMG5TPCO0', '707', '1', '100', 'Transferts', NULL, 1, 1, 0, '2026-02-19 15:54:30', '2026-02-19 15:54:30', NULL, 0),
(47, 36, 'Justice', 'Divine', 'justicedivine99933@gmail.com', '+2990150583061', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '804611', 'Activé', '230722', 'Virement bancaire', NULL, NULL, NULL, '4771********7171', 'FC-0P7AIXJP8U', '898', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Divine+Justice&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-20 07:51:17', '2026-02-20 07:51:17', '2026-02-20 08:51:17', 1),
(48, 1, 'Zanahin', 'Monke Germain', 'zanahinm@gmail.com', '0504161214', 'Côte d’Ivoire (+225)', 'Abidjan', 'XOF', 'fr', 2000000.00, 2000000.00, 0.00, 'Professionnel', '818238', 'Activé', '259991', 'Régionale', NULL, NULL, NULL, '4238********4772', 'FC-QAHBL3SFAI', '996', '1', '100', 'Transfert effectuer avec succès', NULL, 1, 1, 0, '2026-02-21 15:00:42', '2026-03-07 08:31:52', NULL, 0),
(49, 37, 'DIAZ', 'M. TOREADOR', 'yavamaua@gmail.com', '+22959397737', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '307246', 'Activé', '579260', 'Virement bancaire', NULL, NULL, NULL, '4603********3762', 'FC-IT7J92EH28', '105', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=M.+TOREADOR+DIAZ&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-23 10:52:03', '2026-02-23 10:52:03', '2026-02-23 11:52:03', 1),
(50, 38, 'Klaus', 'Caroline', 'bzmpllw@gmail.com', '+33644663440', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '141330', 'Activé', '297263', 'Virement bancaire', NULL, NULL, NULL, '4603********7127', 'FC-LP2IOTJR6J', '404', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Caroline+Klaus&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-25 20:39:06', '2026-02-25 20:39:06', '2026-02-25 21:39:06', 1),
(51, 39, 'YAO', 'Narcisse', 'transfert816@gmail.com', '+2290190969603', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '336008', 'Activé', '350798', 'Virement bancaire', NULL, NULL, NULL, '4703********8430', 'FC-TVOMERGBNM', '875', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Narcisse+YAO&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-26 06:49:40', '2026-02-26 06:49:40', '2026-02-26 07:49:40', 1),
(52, 40, 'Bossou', 'Babaro', 'sneosurf98@gmail.com', '+2290190280115', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '671152', 'Activé', '762933', 'Virement bancaire', NULL, NULL, NULL, '4282********2815', 'FC-TYEX6QZYI9', '214', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Babaro+Bossou&background=28a745&color=fff&size=50', 1, 0, 0, '2026-02-27 09:48:16', '2026-02-27 09:48:16', '2026-02-27 10:48:16', 1),
(53, 32, 'Tossou', 'Onis Coffi', 'coffionist@gmail.com', '+22795186285', 'Niger (+227)', 'Niamey', 'XOF', 'fr', 0.00, 6458809.00, 0.00, 'Professionnel', '697241', 'Activé', '335449', 'BANK IBAN', NULL, NULL, NULL, '4791********7841', 'FC-OQ1L95WCTP', '441', '1', '100', 'Transfert effectué', NULL, 1, 1, 0, '2026-02-27 17:21:50', '2026-02-27 17:21:50', NULL, 0),
(54, 41, 'HODONOU', 'Cardnelle', 'hodonoucardnelle@gmail.com', '0141752620', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '648006', 'Activé', '960126', 'Virement bancaire', NULL, NULL, NULL, '4626********4314', 'FC-RJ8MFBKMRZ', '864', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Cardnelle+HODONOU&background=28a745&color=fff&size=50', 1, 0, 0, '2026-03-05 04:19:19', '2026-03-05 04:19:19', '2026-03-05 05:19:19', 1),
(55, 41, 'RAVELOSON', 'Lôlô Virginie Lucienne', 'ravelosonlolo@gmail.com', '0341681020', 'Madagascar (+261)', 'Lot D-109 Ambodivondava', '€', 'fr', 30500.00, 30500.00, 0.00, 'Professionnel', '624412', 'Activé', '159592', '30 500', NULL, NULL, NULL, '4561********8339', 'FC-7IHDPCFDCZ', '816', '1', '97', 'Chère client, veuillez contacter le gestionnaire pour assurer la sécurité le virement.\r\nUne somme de 112€ sont nécessaires pour assurer le virement à 100%', 'comptes-photos/compte_69a95120797c8.jpg', 1, 1, 0, '2026-03-05 09:47:12', '2026-03-05 09:47:12', NULL, 0),
(56, 42, 'Dochli', 'Sylvie', 'Sylviedochli39@gmail.com', '+33756843126', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10370.00, 10370.00, 0.00, 'Standard', '651190', 'Activé', '101283', 'Virement bancaire', NULL, NULL, NULL, '4725********8802', 'FC-BD2VWCF7NP', '786', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Sylvie+Dochli&background=28a745&color=fff&size=50', 1, 0, 0, '2026-03-09 12:10:05', '2026-03-09 12:17:33', '2026-03-09 13:10:05', 1),
(57, 43, 'Thomas', 'bulberl', 'partinieraliou@gmail.com', '+22963660357', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '325430', 'Activé', '550102', 'Virement bancaire', NULL, NULL, NULL, '4939********2310', 'FC-9LWL6G0VK0', '644', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=bulberl+Thomas&background=28a745&color=fff&size=50', 1, 0, 0, '2026-03-12 06:10:19', '2026-03-12 06:10:19', '2026-03-12 07:10:19', 1),
(58, 44, 'Bill', 'leonaldo', 'leonaldobill92@gmail.com', '2290157119465', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '452441', 'Activé', '754529', 'Virement bancaire', NULL, NULL, NULL, '4353********1787', 'FC-FNL69PJLAK', '813', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=leonaldo+Bill&background=28a745&color=fff&size=50', 1, 0, 0, '2026-03-12 16:22:55', '2026-03-12 16:22:55', '2026-03-12 17:22:55', 1),
(59, 45, 'Jean', 'Laurent', 'pbanque772@gmail.com', '22995440899', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 5010000.00, 5010000.00, 0.00, 'Standard', '605342', 'Activé', '433320', 'Virement bancaire', NULL, NULL, NULL, '4803********5146', 'FC-OUE1CWKKPK', '283', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Laurent+Jean&background=28a745&color=fff&size=50', 1, 0, 0, '2026-03-13 18:42:41', '2026-03-13 18:44:46', '2026-03-13 19:42:41', 1),
(60, 46, 'Cate', 'Tanya', 'Kahkenny444@gmail.com', '+2250596344663', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '931726', 'Activé', '759185', 'Virement bancaire', NULL, NULL, NULL, '4823********1995', 'FC-QLJ30ASBUE', '837', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Tanya+Cate&background=28a745&color=fff&size=50', 1, 0, 0, '2026-03-14 11:22:54', '2026-03-14 11:22:54', '2026-03-14 12:22:54', 1),
(61, 47, 'Ange', 'Go', 'djokpeangelo@gmail.com', '22957588819', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '313330', 'Activé', '675034', 'Virement bancaire', NULL, NULL, NULL, '4180********3971', 'FC-OEKGWDIJ3I', '936', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Go+Ange&background=28a745&color=fff&size=50', 1, 0, 0, '2026-03-16 19:53:39', '2026-03-16 19:53:39', '2026-03-16 20:53:39', 1),
(62, 48, 'Banco', 'HSBC', 'bancohsbc052@gmail.com', '+339521943295', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '323804', 'Activé', '325783', 'Virement bancaire', NULL, NULL, NULL, '4120********9368', 'FC-1COQGJSH4C', '773', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=HSBC+Banco&background=28a745&color=fff&size=50', 1, 0, 0, '2026-03-17 07:52:38', '2026-03-17 07:52:38', '2026-03-17 08:52:38', 1),
(63, 49, 'Rossi', 'Rebecca', 'rebeccarossi161@gmail.com', '2250704062734', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '634785', 'Activé', '249746', 'Virement bancaire', NULL, NULL, NULL, '4520********8303', 'FC-CPQFP6EXYR', '453', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Rebecca+Rossi&background=28a745&color=fff&size=50', 1, 0, 0, '2026-03-18 05:45:54', '2026-03-18 05:45:54', '2026-03-18 06:45:54', 1),
(64, 50, 'FUNDACIÓN', 'FUNBERT', 'funbertfundacion6@gmail.com', '0158703010', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '242469', 'Activé', '634899', 'Virement bancaire', NULL, NULL, NULL, '4106********5938', 'FC-1EJRUYSZTA', '579', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=FUNBERT+FUNDACI%C3%93N&background=28a745&color=fff&size=50', 1, 0, 0, '2026-03-18 09:06:47', '2026-03-18 09:06:47', '2026-03-18 10:06:47', 1),
(65, 51, 'Dupont', 'Romio', 'romeodahouindji21@gmail.com', '+2290158403807', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '453239', 'Activé', '683932', 'Virement bancaire', NULL, NULL, NULL, '4633********6382', 'FC-AHFTFMFJCM', '529', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'https://ui-avatars.com/api/?name=Romio+Dupont&background=28a745&color=fff&size=50', 1, 0, 0, '2026-03-22 19:23:28', '2026-03-22 19:23:28', '2026-03-22 20:23:28', 1),
(66, 52, 'Lez', 'Niche', 'bancobnpparibasacquavivaalessa@gmail.com', '+23409037772494', 'Bénin-City', 'Cotonou-Bénin', 'XOF', 'fr', 10000.00, 10000.00, 0.00, 'Standard', '671099', 'Activé', '282555', 'Virement bancaire', NULL, NULL, NULL, '4563********5253', 'FC-UITKFIBQX2', '172', '1', '100', 'Transfert échoué. Veuillez contacter le support.', 'comptes-photos/compte_69c5801bae093.jpg', 1, 0, 0, '2026-03-25 21:12:52', '2026-03-26 18:51:07', '2026-03-25 22:12:52', 1);

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
(11, '2025_11_01_000001_add_credit_user_to_users_table', 1),
(12, '2025_11_02_000000_add_is_default_to_comptes_table', 1),
(13, '2025_11_02_000001_add_alert_columns_to_comptes_table', 1),
(14, '2025_11_03_064607_create_affiliations_table', 1),
(15, '2025_11_03_064748_create_commissions_table', 1),
(16, '2025_11_03_065133_add_affiliation_to_users_table', 1),
(17, '2025_11_03_081823_create_recharge_transactions_table', 1),
(18, '2025_11_03_101510_create_retraits_table', 1),
(19, '2025_11_03_120000_add_credits_to_comptes_table', 1),
(20, '2025_11_06_000002_add_phone_to_users_table', 1),
(21, '2025_11_06_000003_add_compte_id_to_transaction_histories', 1),
(22, '2025_11_06_155445_update_transaction_histories_make_compte_id_required', 1),
(23, '2025_11_07_163330_add_auto_deletes_at_to_comptes_table', 1),
(24, '2025_11_07_180000_add_compte_id_to_transfers_table', 1),
(25, '2025_11_07_182000_add_compte_id_inferred_to_transfers_table', 1),
(26, '2025_11_09_100000_create_support_tables', 1),
(27, '2025_11_10_120000_add_attachments_to_support_messages', 1),
(28, '2025_11_10_171351_add_columns_to_unlock_codes_table', 1),
(29, '2025_11_10_171607_make_transfer_id_nullable_in_unlock_codes', 1),
(30, '2025_11_11_000001_update_retraits_table_add_new_operators', 1),
(31, '2025_11_11_001329_update_retraits_table_add_new_operators', 1),
(32, '2025_11_11_002000_add_withdrawal_statuses_to_commissions', 1),
(33, '2025_11_23_165000_add_numerocompte_to_comptes_table', 1),
(34, '2025_11_23_170200_add_photo_path_to_comptes_table', 1),
(35, '2025_11_23_182500_add_photo_path_to_comptes_table', 1),
(36, '2025_11_23_184200_add_mobile_number_to_transfers_table', 1),
(37, '2025_11_23_190400_update_transaction_histories_compte_fk_cascade', 1),
(38, '2025_11_23_193200_move_mobile_number_to_transaction_histories', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
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
(1, 1, 1, 'RCH34RAKNG1764521403', 5000.00, 5000, 'fedapay', 'fedapay', 'failed', '107768228', NULL, '{\"fedapay_id\":107768228,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzc2ODIyOCwiZXhwIjoxNzY0NjA3ODA3fQ.qUbS_we3x-EuoBUlUc5dv_LT5ovZRwEH9li4MVBa9D4\"}', 'Payment canceled/declined by user (redirect)', NULL, '2025-11-30 16:50:03', '2025-11-30 16:50:09'),
(2, 6, 7, 'RCOP4RHZ2R1764917893', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '107853963', NULL, '{\"fedapay_id\":107853963,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzg1Mzk2MywiZXhwIjoxNzY1MDA0Mjk4fQ.ZHwrUuAlDRprj_p86doLJWbq-xnNY_jtWswkEt4qstA\"}', NULL, NULL, '2025-12-05 06:58:13', '2025-12-05 06:58:15'),
(3, 6, 7, 'RC1RVUHHTB1764917905', 5000.00, 5000, 'mobile_money', 'fedapay', 'failed', '107853965', NULL, '{\"fedapay_id\":107853965,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzg1Mzk2NSwiZXhwIjoxNzY1MDA0MzA5fQ.hqPv9O2wsxaR4bg69F1T5rxPTa2jXldyzpa34VFSLUY\"}', 'Payment canceled/declined by user (redirect)', NULL, '2025-12-05 06:58:25', '2025-12-05 06:58:36'),
(4, 7, 8, 'RCTB7TSQZV1764918408', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '107854039', NULL, '{\"fedapay_id\":107854039,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwNzg1NDAzOSwiZXhwIjoxNzY1MDA0ODEyfQ.NZqA5BxvsKE-_UNGabfS2q8WbWHV_QnWxDtZLdgwCos\"}', NULL, '2025-12-05 07:07:29', '2025-12-05 07:06:48', '2025-12-05 07:07:29'),
(5, 15, 22, 'RCKKFCEZCU1769703678', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '109097991', NULL, '{\"fedapay_id\":109097991,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTA5Nzk5MSwiZXhwIjoxNzY5NzkwMDc5fQ.u7QOxspqn76M-SaDby6nszvtHQwicE95BkGMwlgVDig\"}', NULL, NULL, '2026-01-29 16:21:18', '2026-01-29 16:21:19'),
(6, 19, 28, 'RC3WY6W7OT1770160845', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '109249854', NULL, '{\"fedapay_id\":109249854,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTI0OTg1NCwiZXhwIjoxNzcwMjQ3MjQ2fQ.RYZoupPALWxIU0DhqyMNPjO2LWM7bZEuZc6vz8DKpxQ\"}', NULL, NULL, '2026-02-03 23:20:45', '2026-02-03 23:20:46'),
(7, 27, 36, 'RCJ6G1KZHO1770643662', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '109403642', NULL, '{\"fedapay_id\":109403642,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTQwMzY0MiwiZXhwIjoxNzcwNzMwMDYzfQ.5NYZoXi6MaYbYOQlQAgPzdLE2E2ks-KqNgkd1_V30N4\"}', NULL, NULL, '2026-02-09 13:27:42', '2026-02-09 13:27:43'),
(8, 27, 36, 'RCAMVNJ3ZQ1770643735', 5000.00, 5000, 'fedapay', 'fedapay', 'failed', '109403680', NULL, '{\"fedapay_id\":109403680,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTQwMzY4MCwiZXhwIjoxNzcwNzMwMTM2fQ.JtoBMobv8fNPaHtb1dujG1rQY3VMUttZkGI_ijyDcag\"}', 'Payment canceled/declined by user (redirect)', NULL, '2026-02-09 13:28:55', '2026-02-09 13:29:03'),
(9, 27, 36, 'RC3MXCEEAK1770643985', 5000.00, 5000, 'fedapay', 'fedapay', 'failed', '109403785', NULL, '{\"fedapay_id\":109403785,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTQwMzc4NSwiZXhwIjoxNzcwNzMwMzg2fQ.9YKEv5GyDGuM-yqsQ_IbCT2GhlPlBWEI0Me-QABtZ-8\"}', 'Payment canceled/declined by user (redirect)', NULL, '2026-02-09 13:33:05', '2026-02-09 13:33:14'),
(10, 28, 37, 'RCTG2WJTSQ1770657233', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '109409796', NULL, '{\"fedapay_id\":109409796,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTQwOTc5NiwiZXhwIjoxNzcwNzQzNjM0fQ.M_paCUjNT_3-hZz99GT9D2ycauuXRnUhv1uocwd7wks\"}', NULL, NULL, '2026-02-09 17:13:53', '2026-02-09 17:13:54'),
(11, 28, 37, 'RCZ6LVLWIZ1770661121', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '109411604', NULL, '{\"fedapay_id\":109411604,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTQxMTYwNCwiZXhwIjoxNzcwNzQ3NTIyfQ.am2wRlYG1KNdV2A8ytnLT2GrMmo30zkmlVDnqdAQXIA\"}', NULL, '2026-02-09 18:20:14', '2026-02-09 18:18:41', '2026-02-09 18:20:14'),
(12, 24, 33, 'RCYRXKH7YC1770839335', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '109473605', NULL, '{\"fedapay_id\":109473605,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTQ3MzYwNSwiZXhwIjoxNzcwOTI1NzM3fQ.fZjfPTDnMjOYyhIrPZ_CautHa5mD7gYmWNAMNoxfgfo\"}', NULL, NULL, '2026-02-11 19:48:55', '2026-02-11 19:48:57'),
(13, 24, 33, 'RCU26MKZ6M1770839383', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '109473634', NULL, '{\"fedapay_id\":109473634,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTQ3MzYzNCwiZXhwIjoxNzcwOTI1Nzg0fQ.czrJ6ebJPJmHmTphEj9OS_3OJMDjnGbJkP8OHCkj01A\"}', NULL, NULL, '2026-02-11 19:49:43', '2026-02-11 19:49:44'),
(14, 32, 42, 'RCYR13PTNQ1770839403', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '109473644', NULL, '{\"fedapay_id\":109473644,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTQ3MzY0NCwiZXhwIjoxNzcwOTI1ODA1fQ.-cOYUmloxeE7FaZH_bSouLFhw2Iancz_wc2sfhANe5I\"}', NULL, NULL, '2026-02-11 19:50:03', '2026-02-11 19:50:05'),
(15, 32, 42, 'RC3GKXLYGL1770839440', 5000.00, 5000, 'fedapay', 'fedapay', 'pending', '109473664', NULL, '{\"fedapay_id\":109473664,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTQ3MzY2NCwiZXhwIjoxNzcwOTI1ODQxfQ.c6ks2WDkL4uNywIvOBcu7oVRRGW8meBE2aLs20rQVvQ\"}', NULL, NULL, '2026-02-11 19:50:40', '2026-02-11 19:50:41'),
(16, 32, 42, 'RCBJ6LUJ6W1770890852', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '109485074', NULL, '{\"fedapay_id\":109485074,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTQ4NTA3NCwiZXhwIjoxNzcwOTc3MjUzfQ.gH4v-ZJsYCNsoxWKCVwW3MQc844YBYHqaXbhB9jfbRg\"}', NULL, NULL, '2026-02-12 10:07:32', '2026-02-12 10:07:33'),
(17, 32, 42, 'RCLRNWWAPL1770989714', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '109515870', NULL, '{\"fedapay_id\":109515870,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTUxNTg3MCwiZXhwIjoxNzcxMDc2MTE1fQ.Prfc2T3Q5BmnHPWzYU6WxtK9eI_9AXu15Xse7jcj6zY\"}', NULL, NULL, '2026-02-13 13:35:14', '2026-02-13 13:35:15'),
(18, 35, 45, 'RCNUQPSXM41771516095', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '109649662', NULL, '{\"fedapay_id\":109649662,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTY0OTY2MiwiZXhwIjoxNzcxNjAyNDk3fQ.DeBF6VnxNu_TRqjKJWK1jibWf6wzMWftL0gzXXQhQh8\"}', NULL, '2026-02-19 15:51:02', '2026-02-19 15:48:15', '2026-02-19 15:51:02'),
(19, 41, 54, 'RCBMLSKDCC1772693432', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '109842298', NULL, '{\"fedapay_id\":109842298,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTg0MjI5OCwiZXhwIjoxNzcyNzc5ODM0fQ.VZXAmq55gG-BuW9VY1gL8gub1b-f-7MogLBsPDpFre0\"}', NULL, '2026-03-05 06:52:58', '2026-03-05 06:50:32', '2026-03-05 06:52:58'),
(20, 43, 57, 'RCER5RBFAF1773306303', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '109970702', NULL, '{\"fedapay_id\":109970702,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEwOTk3MDcwMiwiZXhwIjoxNzczMzkyNzA1fQ.LEMnW8DXDseDe5bqkLq3SPHudSlDgYyQy0WPM-eBef4\"}', NULL, NULL, '2026-03-12 09:05:03', '2026-03-12 09:05:05'),
(21, 25, 34, 'RCMNEGCXYR1773647326', 5000.00, 5000, 'mobile_money', 'fedapay', 'completed', '110030446', NULL, '{\"fedapay_id\":110030446,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjExMDAzMDQ0NiwiZXhwIjoxNzczNzMzNzI3fQ.1q_E9AHTYKpDzeGLY94avj8jWnKv5uA59hnW_8Gw4DI\"}', NULL, '2026-03-16 07:50:06', '2026-03-16 07:48:46', '2026-03-16 07:50:06'),
(22, 47, 61, 'RCYK8DCKWL1773691153', 5000.00, 5000, 'mobile_money', 'fedapay', 'failed', '110043522', NULL, '{\"fedapay_id\":110043522,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjExMDA0MzUyMiwiZXhwIjoxNzczNzc3NTU1fQ.RVwl-yfdgfduzHqz5SDxyung5z6GRrQlhaNTGiSW1eA\"}', 'Payment canceled/declined by user (redirect)', NULL, '2026-03-16 19:59:13', '2026-03-16 19:59:59'),
(23, 47, 61, 'RCCLHRIPOG1774521390', 5000.00, 5000, 'mobile_money', 'fedapay', 'pending', '110195488', NULL, '{\"fedapay_id\":110195488,\"token\":\"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjExMDE5NTQ4OCwiZXhwIjoxNzc0NjA3NzkxfQ.IwUCUNTI3-3gYtl2tYi17IpmSI0PyXv1T8UHt5KWQJY\"}', NULL, NULL, '2026-03-26 10:36:30', '2026-03-26 10:36:31');

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
(1, 1, 10000.00, '2025-11-29 17:51:02', '2025-11-29 17:51:02'),
(2, 1, 10300.00, '2025-11-29 21:44:02', '2025-11-29 21:44:02'),
(3, 1, 87500.00, '2025-11-30 12:26:38', '2025-11-30 12:26:38'),
(4, 1, 87500.00, '2025-11-30 12:31:55', '2025-11-30 12:31:55'),
(5, 1, 580800.00, '2025-11-30 12:55:38', '2025-11-30 12:55:38'),
(6, 1, 46800.00, '2025-11-30 13:38:49', '2025-11-30 13:38:49'),
(7, 1, 46800.00, '2025-11-30 18:57:57', '2025-11-30 18:57:57'),
(8, 11, 7000000.00, '2025-12-28 09:40:41', '2025-12-28 09:40:41'),
(9, 7, 10000.00, '2025-12-30 16:58:38', '2025-12-30 16:58:38'),
(10, 8, 10000.00, '2025-12-31 10:02:00', '2025-12-31 10:02:00'),
(11, 20, 10000.00, '2026-01-11 05:50:30', '2026-01-11 05:50:30'),
(12, 48, 2000000.00, '2026-02-22 11:42:18', '2026-02-22 11:42:18'),
(13, 48, 2000000.00, '2026-02-25 07:58:30', '2026-02-25 07:58:30');

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
(1, 1, 19, 0, 'Oui j\'ai problème de recharge', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:13:58', '2026-02-03 23:17:27', '2026-02-25 08:13:58'),
(2, 1, NULL, 1, 'Bonjour, posez-moi toutes vos questions à propos de nos services', NULL, NULL, NULL, NULL, NULL, '2026-02-03 23:17:27', '2026-02-03 23:17:27', '2026-02-03 23:17:27'),
(3, 1, 19, 0, 'Oui j\'ai problème de recharge', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:13:58', '2026-02-03 23:17:38', '2026-02-25 08:13:58'),
(4, 2, 27, 0, 'Je veux recharger ma carte', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:22:10', '2026-02-09 13:21:55', '2026-02-25 08:22:10'),
(5, 2, NULL, 1, 'Bonjour, posez-moi toutes vos questions à propos de nos services', NULL, NULL, NULL, NULL, NULL, '2026-02-09 13:21:56', '2026-02-09 13:21:55', '2026-02-09 13:21:56'),
(6, 3, 28, 0, 'Bonsoir je lance votre flash compte mais ça ne marche pas', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:24:24', '2026-02-09 18:48:02', '2026-02-25 08:24:24'),
(7, 3, NULL, 1, 'Bonjour, posez-moi toutes vos questions à propos de nos services', NULL, NULL, NULL, NULL, NULL, '2026-02-09 18:48:02', '2026-02-09 18:48:02', '2026-02-09 18:48:02'),
(8, 3, 28, 0, 'Bonsoir je lance votre flash compte mais ça ne marche pas', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:24:24', '2026-02-09 18:48:31', '2026-02-25 08:24:24'),
(9, 4, 30, 0, 'Combien je recharge pour effectuer un virement de 750.000€ ?', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:28:28', '2026-02-10 22:09:03', '2026-02-25 08:28:28'),
(10, 4, NULL, 1, 'Bonjour, posez-moi toutes vos questions à propos de nos services', NULL, NULL, NULL, NULL, NULL, '2026-02-10 22:09:03', '2026-02-10 22:09:03', '2026-02-10 22:09:03'),
(11, 5, 32, 0, 'Je viens de faire un rechargement que je n\'ai pas reçu', 'FedaPay Recu No. trx_4W8_1770890852374.pdf', 'support/attachments/S2OjkeXZ7Sri71CbYE1kfLHxUJmuOdPwaLPX4Azp.pdf', 'application/pdf', 19616, NULL, '2026-02-25 08:13:00', '2026-02-12 10:13:19', '2026-02-25 08:13:00'),
(12, 5, NULL, 1, 'Bonjour, posez-moi toutes vos questions à propos de nos services', NULL, NULL, NULL, NULL, NULL, '2026-02-12 10:13:19', '2026-02-12 10:13:19', '2026-02-12 10:13:19'),
(13, 5, 32, 0, '', 'FedaPay Recu No. trx_4W8_1770890852374.pdf', 'support/attachments/YOKjrbuUzdS1v68EfLEltNaTFytc6TKuuVkWPrZA.pdf', 'application/pdf', 19616, NULL, '2026-02-25 08:13:00', '2026-02-12 12:08:46', '2026-02-25 08:13:00'),
(14, 5, 32, 0, '', 'Screenshot_20260212-130823_Chrome.jpg', 'support/attachments/2GSabMXNhPSe6ZzHXsmhY2QKfkxP1jwHlv99ous0.jpg', 'image/jpeg', 133401, NULL, '2026-02-25 08:13:00', '2026-02-12 12:08:59', '2026-02-25 08:13:00'),
(15, 5, 32, 0, 'J\'ai fait un rechargement que je n\'ai pas reçu', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:13:00', '2026-02-12 12:09:30', '2026-02-25 08:13:00'),
(16, 5, 32, 0, 'Vous n\'êtes pas sérieux avec vos partenaires ce du sérieux', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:13:00', '2026-02-13 13:33:39', '2026-02-25 08:13:00'),
(17, 5, NULL, 1, 'Bonjour monsieur\r\nDésolé pour le silence', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:18:00', '2026-02-25 08:13:43', '2026-02-25 08:18:00'),
(18, 5, 32, 0, 'Ok merci beaucoup', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:18:40', '2026-02-25 08:18:36', '2026-02-25 08:18:40'),
(19, 5, NULL, 1, 'C\'est résolu', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:18:48', '2026-02-25 08:18:40', '2026-02-25 08:18:48'),
(20, 5, 32, 0, 'Bon maintenant je peux le faire encore maintenant pour recevoir vite', NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:21:19', '2026-02-25 08:19:17', '2026-02-25 08:21:19'),
(21, 5, NULL, 1, 'Oui c\'est résolu', NULL, NULL, NULL, NULL, NULL, '2026-02-26 20:59:07', '2026-02-25 08:21:45', '2026-02-26 20:59:07'),
(22, 1, NULL, 1, 'Le problème de recharge est résolu', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:22:06', '2026-02-25 08:22:06'),
(23, 2, NULL, 1, 'Bonjour monsieur\r\nDésolé pour le silence\r\nAvez-vous pu recharger votre carte ?', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:24:13', '2026-02-25 08:24:13'),
(24, 3, NULL, 1, 'Bonjour monsieur\r\nJe vous ai envoyé un message sur WhatsApp', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:28:22', '2026-02-25 08:28:22'),
(25, 4, NULL, 1, 'Bonjour monsieur\r\nVous devez utilisé notre plateforme Flash compte Europe pour effectuer un virement en euro pour un client en européen', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-25 08:32:53', '2026-02-25 08:32:53'),
(26, 5, NULL, 1, 'Veuillez nous écrire sur WhatsApp si vous avez d\'autres préoccupation', NULL, NULL, NULL, NULL, NULL, '2026-02-26 20:59:07', '2026-02-25 08:35:40', '2026-02-26 20:59:07'),
(27, 5, 32, 0, 'Veuillez m\'envoyer votre numéro de whatsapp', NULL, NULL, NULL, NULL, NULL, '2026-03-05 22:00:56', '2026-02-26 20:59:34', '2026-03-05 22:00:56'),
(28, 5, NULL, 1, '22656311804', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-05 22:01:48', '2026-03-05 22:01:48'),
(29, 6, 47, 0, 'J\'ai déjà recharger le compte mais l\'argent n\'arrive pas', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-26 10:39:53', '2026-03-26 10:39:53'),
(30, 6, NULL, 1, 'Bonjour, posez-moi toutes vos questions à propos de nos services', NULL, NULL, NULL, NULL, NULL, '2026-03-26 10:39:53', '2026-03-26 10:39:53', '2026-03-26 10:39:53'),
(31, 6, 47, 0, 'Je veux un remboursement de Mes 5000', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-29 06:48:57', '2026-03-29 06:48:57');

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
(1, 19, 'Oui j\'ai problème de recharge', 'answered', '2026-02-25 08:22:06', '2026-02-03 23:17:27', '2026-02-25 08:22:06'),
(2, 27, 'Recharge', 'answered', '2026-02-25 08:24:13', '2026-02-09 13:21:55', '2026-02-25 08:24:13'),
(3, 28, 'Bonsoir je lance votre flash compte mais ça ne marche pas', 'answered', '2026-02-25 08:28:22', '2026-02-09 18:48:02', '2026-02-25 08:28:22'),
(4, 30, 'Combien je recharge pour effectuer un virement de 750.000€ ?', 'answered', '2026-02-25 08:32:53', '2026-02-10 22:09:03', '2026-02-25 08:32:53'),
(5, 32, 'Recharge non approuvé', 'answered', '2026-03-05 22:01:48', '2026-02-12 10:13:19', '2026-03-05 22:01:48'),
(6, 47, 'Problème recharge', 'pending', '2026-03-29 06:48:57', '2026-03-26 10:39:53', '2026-03-29 06:48:57');

-- --------------------------------------------------------

--
-- Structure de la table `transaction_histories`
--

CREATE TABLE `transaction_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `compte_id` bigint(20) UNSIGNED NOT NULL,
  `transfer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `devise` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transaction_histories`
--

INSERT INTO `transaction_histories` (`id`, `user_id`, `compte_id`, `transfer_id`, `mobile_number`, `transaction_type`, `amount`, `description`, `devise`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2025-11-29 17:09:03', '2025-11-29 20:47:31'),
(2, 1, 1, 1, '+22 951503188', 'Transfer sent', 10000.00, '+22 951503188 - MTN Money - BIC: MTN', 'XOF', '2025-11-29 17:48:08', '2025-11-29 20:47:31'),
(3, 1, 1, NULL, NULL, 'Refund received', 10000.00, 'MTN Money - BIC: MTN', 'XOF', '2025-11-29 17:51:02', '2025-11-29 20:47:31'),
(4, 1, 1, NULL, NULL, 'Funds added', 500.00, 'TRANSAFRICASH', 'XOF', '2025-11-29 20:50:03', '2025-11-29 20:50:03'),
(5, 1, 1, NULL, NULL, 'Funds deducted', 200.00, 'TRANSAFRICASH', 'XOF', '2025-11-29 20:51:06', '2025-11-29 20:51:06'),
(6, 1, 1, 2, '+2290 198201610', 'Transfer sent', 10300.00, '+2290 198201610 - Moov Money - BIC: MOOV', 'XOF', '2025-11-29 21:43:15', '2025-11-29 21:43:15'),
(7, 1, 1, NULL, NULL, 'Refund received', 10300.00, 'Moov Money - BIC: MOOV', 'XOF', '2025-11-29 21:44:02', '2025-11-29 21:44:02'),
(8, 1, 1, 3, '+2260 572974835', 'Transfer sent', 10300.00, '+2260 572974835 - Orange Money - BIC: ORANGE', 'XOF', '2025-11-29 21:49:07', '2025-11-29 21:49:07'),
(9, 1, 1, NULL, NULL, 'Funds added', 96000.00, 'TRANSAFRICASH', 'XOF', '2025-11-29 21:51:51', '2025-11-29 21:51:51'),
(10, 1, 1, 4, '+22 172974835', 'Transfer sent', 96000.00, '+22 172974835 - Airtel Money - BIC: AIRTEL', 'XOF', '2025-11-29 21:55:32', '2025-11-29 21:55:32'),
(11, 1, 1, NULL, NULL, 'Funds added', 87500.00, 'TRANSAFRICASH', 'XOF', '2025-11-29 21:57:14', '2025-11-29 21:57:14'),
(12, 1, 1, 5, '+2250 596974835', 'Transfer sent', 87500.00, '+2250 596974835 - Wave - BIC: WAVE', 'XOF', '2025-11-30 12:25:43', '2025-11-30 12:25:43'),
(13, 1, 1, NULL, NULL, 'Refund received', 87500.00, 'Wave - BIC: WAVE', 'XOF', '2025-11-30 12:26:38', '2025-11-30 12:26:38'),
(14, 1, 1, 6, 'lalyaisidore@gmail.com', 'Transfer sent', 87500.00, 'PayPal', 'XOF', '2025-11-30 12:30:42', '2025-11-30 12:30:42'),
(15, 1, 1, NULL, NULL, 'Refund received', 87500.00, 'PayPal', 'XOF', '2025-11-30 12:31:55', '2025-11-30 12:31:55'),
(16, 1, 1, NULL, NULL, 'Funds added', 76000.00, 'TRANSAFRICASH', 'XOF', '2025-11-30 12:38:23', '2025-11-30 12:38:23'),
(17, 1, 1, 7, '+22 998201610', 'Transfer sent', 163500.00, '+22 998201610 - Moov Money - BIC: MOOV', 'XOF', '2025-11-30 12:42:01', '2025-11-30 12:42:01'),
(18, 1, 1, NULL, NULL, 'Funds added', 580800.00, 'TRANSAFRICASH', 'XOF', '2025-11-30 12:47:22', '2025-11-30 12:47:22'),
(19, 1, 1, 8, '+22 951508122', 'Transfer sent', 580800.00, '+22 951508122 - MTN Money - BIC: MTN', 'XOF', '2025-11-30 12:50:36', '2025-11-30 12:50:36'),
(20, 1, 1, NULL, NULL, 'Refund received', 580800.00, 'MTN Money - BIC: MTN', 'XOF', '2025-11-30 12:55:37', '2025-11-30 12:55:37'),
(21, 1, 1, 9, '+2290 151503188', 'Transfer sent', 580800.00, '+2290 151503188 - Wave - BIC: WAVE', 'XOF', '2025-11-30 13:05:20', '2025-11-30 13:05:20'),
(22, 1, 1, NULL, NULL, 'Funds added', 46800.00, 'TRANSAFRICASH', 'XOF', '2025-11-30 13:12:56', '2025-11-30 13:12:56'),
(23, 1, 1, 10, '+2290 198201610', 'Transfer sent', 46800.00, '+2290 198201610 - Moov Money - BIC: MOOV', 'XOF', '2025-11-30 13:15:21', '2025-11-30 13:15:21'),
(24, 1, 1, NULL, NULL, 'Refund received', 46800.00, 'Moov Money - BIC: MOOV', 'XOF', '2025-11-30 13:38:49', '2025-11-30 13:38:49'),
(26, 1, 3, NULL, NULL, 'Funds added', 56900.00, 'TRANSFERFLUX', 'XAF', '2025-11-30 13:47:37', '2025-11-30 13:47:37'),
(27, 1, 1, 11, '+2290 151503285', 'Transfer sent', 46800.00, '+2290 151503285 - MTN Money - BIC: MTN', 'XOF', '2025-11-30 18:56:37', '2025-11-30 18:56:37'),
(28, 1, 1, NULL, NULL, 'Refund received', 46800.00, 'MTN Money - BIC: MTN', 'XOF', '2025-11-30 18:57:57', '2025-11-30 18:57:57'),
(29, 3, 4, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2025-11-30 21:31:06', '2025-11-30 21:31:06'),
(30, 4, 5, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2025-12-01 13:12:58', '2025-12-01 13:12:58'),
(31, 5, 6, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2025-12-04 15:51:02', '2025-12-04 15:51:02'),
(32, 6, 7, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2025-12-04 19:21:15', '2025-12-04 19:21:15'),
(33, 7, 8, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2025-12-05 06:39:37', '2025-12-05 06:39:37'),
(36, 7, 11, NULL, NULL, 'Funds added', 7000000.00, 'TRANSFERFLUX', 'XOF', '2025-12-05 13:20:39', '2025-12-05 13:20:39'),
(37, 8, 12, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2025-12-05 20:30:41', '2025-12-05 20:30:41'),
(38, 8, 12, 12, '+2290 157616286', 'Transfer sent', 10000.00, '+2290 157616286 - MTN Money - BIC: MTN', 'XOF', '2025-12-05 20:58:59', '2025-12-05 20:58:59'),
(39, 1, 13, NULL, NULL, 'Funds added', 200000.00, 'TRANSFERFLUX', 'XOF', '2025-12-08 11:16:59', '2025-12-08 11:16:59'),
(40, 7, 8, 13, '+2250 711913917', 'Transfer sent', 10000.00, '+2250 711913917 - MTN Money - BIC: MTN', 'XOF', '2025-12-11 20:21:19', '2025-12-11 20:21:19'),
(41, 1, 1, 14, '+2250 596385213', 'Transfer sent', 46800.00, '+2250 596385213 - MTN Money - BIC: MTN', 'XOF', '2025-12-11 20:51:23', '2025-12-11 20:51:23'),
(42, 6, 7, 15, '+2250 711913917', 'Transfer sent', 10000.00, '+2250 711913917 - MTN Money - BIC: MTN', 'XOF', '2025-12-11 21:21:34', '2025-12-11 21:21:34'),
(45, 1, 1, NULL, NULL, 'Funds added', 352000.00, 'TRANSAFRICASH', 'XOF', '2025-12-25 10:38:10', '2025-12-25 10:38:10'),
(46, 1, 1, 16, '+2250 596321804', 'Transfer sent', 352000.00, '+2250 596321804 - Wave - BIC: WAVE', 'XOF', '2025-12-25 10:43:51', '2025-12-25 10:43:51'),
(47, 7, 11, 17, '+2250 707908975', 'Transfer sent', 7000000.00, '+2250 707908975 - Wave - BIC: WAVE', 'XOF', '2025-12-26 17:15:57', '2025-12-26 17:15:57'),
(48, 9, 15, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2025-12-27 10:11:52', '2025-12-27 10:11:52'),
(49, 9, 16, NULL, NULL, 'Funds added', 5000.00, 'TRANSFERFLUX', '€', '2025-12-27 10:13:49', '2025-12-27 10:13:49'),
(50, 7, 11, NULL, NULL, 'Refund received', 7000000.00, 'Wave - BIC: WAVE', 'XOF', '2025-12-28 09:40:41', '2025-12-28 09:40:41'),
(51, 10, 17, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2025-12-28 22:02:54', '2025-12-28 22:02:54'),
(52, 6, 7, NULL, NULL, 'Refund received', 10000.00, 'MTN Money - BIC: MTN', 'XOF', '2025-12-30 16:58:38', '2025-12-30 16:58:38'),
(53, 7, 8, NULL, NULL, 'Refund received', 10000.00, 'MTN Money - BIC: MTN', 'XOF', '2025-12-31 10:02:00', '2025-12-31 10:02:00'),
(54, 7, 8, NULL, NULL, 'Funds deducted', 500.00, 'TRANSAFRICASH', 'XOF', '2025-12-31 10:02:57', '2025-12-31 10:02:57'),
(55, 7, 11, NULL, NULL, 'Funds deducted', 5000000.00, 'TRANSAFRICASH', 'XOF', '2025-12-31 10:03:50', '2025-12-31 10:03:50'),
(56, 11, 18, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-01-01 16:09:15', '2026-01-01 16:09:15'),
(57, 7, 8, NULL, NULL, 'Funds deducted', 5000.00, 'TRANSAFRICASH', 'XOF', '2026-01-01 17:37:46', '2026-01-01 17:37:46'),
(58, 7, 11, NULL, NULL, 'Funds deducted', 2000000.00, 'TRANSAFRICASH', 'XOF', '2026-01-01 17:38:33', '2026-01-01 17:38:33'),
(59, 12, 19, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-01-05 13:39:58', '2026-01-05 13:39:58'),
(60, 13, 20, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-01-11 05:36:22', '2026-01-11 05:36:22'),
(61, 13, 20, 18, '+2290 197170691', 'Transfer sent', 10000.00, '+2290 197170691 - MTN Money - BIC: MTN', 'XOF', '2026-01-11 05:47:36', '2026-01-11 05:47:36'),
(62, 13, 20, NULL, NULL, 'Refund received', 10000.00, 'MTN Money - BIC: MTN', 'XOF', '2026-01-11 05:50:30', '2026-01-11 05:50:30'),
(63, 14, 21, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-01-21 19:10:26', '2026-01-21 19:10:26'),
(64, 15, 22, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-01-29 16:14:47', '2026-01-29 16:14:47'),
(65, 16, 23, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-02 10:03:28', '2026-02-02 10:03:28'),
(67, 1, 1, NULL, NULL, 'Funds added', 580000.00, 'TRANSAFRICASH', 'XOF', '2026-02-02 14:35:15', '2026-02-02 14:35:15'),
(68, 1, 1, 19, '+2290 198201610', 'Transfer sent', 580000.00, '+2290 198201610 - Moov Money - BIC: MOOV', 'XOF', '2026-02-02 14:50:52', '2026-02-03 14:50:52'),
(69, 1, 25, NULL, NULL, 'Funds added', 870000.00, 'TRANSFERFLUX', 'XOF', '2026-01-02 15:01:56', '2026-01-02 15:01:56'),
(70, 1, 25, 20, '+22 656311804', 'Transfer sent', 870000.00, '+22 656311804 - Orange Money - BIC: ORANGE', 'XOF', '2026-01-02 16:13:25', '2026-01-02 16:12:25'),
(71, 17, 26, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-03 15:23:43', '2026-02-03 15:23:43'),
(73, 1, 25, NULL, NULL, 'Funds added', 3850000.00, 'TRANSAFRICASH', 'XOF', '2026-02-03 15:51:33', '2026-02-03 15:51:33'),
(74, 1, 25, 21, '+22 656311804', 'Transfer sent', 3850000.00, '+22 656311804 - Orange Money - BIC: ORANGE', 'XOF', '2026-02-03 16:12:21', '2026-02-03 16:12:21'),
(75, 18, 27, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-03 16:19:54', '2026-02-03 16:19:54'),
(76, 18, 27, 22, '+237 698622774', 'Transfer sent', 10000.00, '+237 698622774 - Orange Money - BIC: ORANGE', 'XOF', '2026-02-03 17:02:57', '2026-02-03 17:02:57'),
(77, 19, 28, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-03 22:57:52', '2026-02-03 22:57:52'),
(78, 19, 28, NULL, NULL, 'Funds added', 1000000.00, 'TRANSAFRICASH', 'XOF', '2026-02-03 23:01:52', '2026-02-03 23:01:52'),
(79, 19, 28, 23, '+29 965656546', 'Transfer sent', 1010000.00, '+29 965656546 - MTN Money - BIC: MTN', 'XOF', '2026-02-04 08:38:57', '2026-02-04 08:38:57'),
(80, 20, 29, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-04 14:15:07', '2026-02-04 14:15:07'),
(81, 20, 29, NULL, NULL, 'Funds added', 24000000.00, 'TRANSAFRICASH', 'XOF', '2026-02-04 14:17:32', '2026-02-04 14:17:32'),
(82, 20, 29, NULL, NULL, 'Funds added', 990000.00, 'TRANSAFRICASH', 'XOF', '2026-02-04 14:27:06', '2026-02-04 14:27:06'),
(83, 19, 28, NULL, NULL, 'Funds added', 5000000.00, 'TRANSAFRICASH', 'XOF', '2026-02-04 17:46:42', '2026-02-04 17:46:42'),
(84, 19, 28, 24, '+22 953995324', 'Transfer sent', 5000000.00, '+22 953995324 - MTN Money - BIC: MTN', 'XOF', '2026-02-04 17:56:06', '2026-02-04 17:56:06'),
(85, 19, 28, 25, '+22 953995324', 'Transfer sent', 99999999.99, '+22 953995324 - MTN Money - BIC: MTN', 'XOF', '2026-02-04 18:37:17', '2026-02-04 18:37:17'),
(86, 21, 30, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-05 07:38:47', '2026-02-05 07:38:47'),
(87, 22, 31, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-05 20:57:13', '2026-02-05 20:57:13'),
(88, 23, 32, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-07 05:02:26', '2026-02-07 05:02:26'),
(89, 24, 33, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-08 21:52:10', '2026-02-08 21:52:10'),
(90, 25, 34, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-08 22:00:09', '2026-02-08 22:00:09'),
(91, 26, 35, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-09 10:51:16', '2026-02-09 10:51:16'),
(92, 27, 36, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-09 13:12:26', '2026-02-09 13:12:26'),
(93, 28, 37, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-09 17:10:14', '2026-02-09 17:10:14'),
(94, 28, 37, 26, '+0 191137517', 'Transfer sent', 10000.00, '+0 191137517 - MTN Money - BIC: MTN', 'XOF', '2026-02-09 19:09:31', '2026-02-09 19:09:31'),
(95, 29, 38, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-10 10:24:54', '2026-02-10 10:24:54'),
(96, 28, 39, NULL, NULL, 'Funds added', 20000.00, 'TRANSFERFLUX', '€', '2026-02-10 13:54:41', '2026-02-10 13:54:41'),
(97, 24, 33, NULL, NULL, 'Funds added', 5000.00, 'TRANSAFRICASH', 'XOF', '2026-02-10 15:48:32', '2026-02-10 15:48:32'),
(98, 24, 33, 27, '+0 156456919', 'Transfer sent', 15000.00, '+0 156456919 - MTN Money - BIC: MTN', 'XOF', '2026-02-10 15:59:50', '2026-02-10 15:59:50'),
(99, 30, 40, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-10 19:34:36', '2026-02-10 19:34:36'),
(100, 31, 41, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-11 11:24:17', '2026-02-11 11:24:17'),
(101, 32, 42, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-11 11:51:30', '2026-02-11 11:51:30'),
(102, 33, 43, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-13 07:21:46', '2026-02-13 07:21:46'),
(103, 21, 30, NULL, NULL, 'Funds added', 440000.00, 'TRANSAFRICASH', 'XOF', '2026-02-16 00:55:14', '2026-02-16 00:55:14'),
(104, 34, 44, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-18 17:25:01', '2026-02-18 17:25:01'),
(105, 35, 45, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-19 12:00:49', '2026-02-19 12:00:49'),
(106, 35, 46, NULL, NULL, 'Funds added', 1000000.00, 'TRANSFERFLUX', 'XOF', '2026-02-19 15:54:30', '2026-02-19 15:54:30'),
(107, 36, 47, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-20 07:51:17', '2026-02-20 07:51:17'),
(108, 1, 48, NULL, NULL, 'Funds added', 2000000.00, 'TRANSFERFLUX', 'XOF', '2026-02-21 15:00:42', '2026-02-21 15:00:42'),
(109, 1, 48, 28, '+2250 504161214', 'Transfer sent', 2000000.00, '+2250 504161214 - Wave - BIC: WAVE', 'XOF', '2026-02-21 15:04:56', '2026-02-21 15:04:56'),
(110, 1, 48, NULL, NULL, 'Refund received', 2000000.00, 'Wave - BIC: WAVE', 'XOF', '2026-02-22 11:42:18', '2026-02-22 11:42:18'),
(111, 1, 48, 29, '+2250 504161214', 'Transfer sent', 2000000.00, '+2250 504161214 - Wave - BIC: WAVE', 'XOF', '2026-02-23 00:28:26', '2026-02-23 00:28:26'),
(112, 37, 49, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-23 10:52:03', '2026-02-23 10:52:03'),
(113, 1, 48, NULL, NULL, 'Refund received', 2000000.00, 'Wave - BIC: WAVE', 'XOF', '2026-02-25 07:58:30', '2026-02-25 07:58:30'),
(114, 38, 50, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-25 20:39:06', '2026-02-25 20:39:06'),
(115, 39, 51, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-26 06:49:40', '2026-02-26 06:49:40'),
(116, 40, 52, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-02-27 09:48:16', '2026-02-27 09:48:16'),
(117, 32, 53, NULL, NULL, 'Funds added', 6458809.00, 'TRANSFERFLUX', 'XOF', '2026-02-27 17:21:50', '2026-02-27 17:21:50'),
(118, 32, 42, 30, '+2290 160100912', 'Transfer sent', 10000.00, '+2290 160100912 - Moov Money - BIC: MOOV', 'XOF', '2026-02-27 17:32:09', '2026-02-27 17:32:09'),
(119, 32, 53, 31, '+22 795186285', 'Transfer sent', 6458809.00, '+22 795186285 - Moov Money - BIC: MOOV', 'XOF', '2026-03-03 11:38:56', '2026-03-03 11:38:56'),
(120, 41, 54, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-03-05 04:19:19', '2026-03-05 04:19:19'),
(121, 41, 55, NULL, NULL, 'Funds added', 30500.00, 'TRANSFERFLUX', '€', '2026-03-05 09:47:12', '2026-03-05 09:47:12'),
(122, 42, 56, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-03-09 12:10:05', '2026-03-09 12:10:05'),
(123, 42, 56, NULL, NULL, 'Funds added', 370.00, 'TRANSAFRICASH', 'XOF', '2026-03-09 12:17:33', '2026-03-09 12:17:33'),
(124, 43, 57, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-03-12 06:10:19', '2026-03-12 06:10:19'),
(125, 44, 58, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-03-12 16:22:55', '2026-03-12 16:22:55'),
(126, 45, 59, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-03-13 18:42:41', '2026-03-13 18:42:41'),
(127, 45, 59, NULL, NULL, 'Funds added', 5000000.00, 'TRANSAFRICASH', 'XOF', '2026-03-13 18:44:46', '2026-03-13 18:44:46'),
(128, 46, 60, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-03-14 11:22:54', '2026-03-14 11:22:54'),
(129, 47, 61, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-03-16 19:53:39', '2026-03-16 19:53:39'),
(130, 48, 62, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-03-17 07:52:38', '2026-03-17 07:52:38'),
(131, 49, 63, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-03-18 05:45:55', '2026-03-18 05:45:55'),
(132, 50, 64, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-03-18 09:06:47', '2026-03-18 09:06:47'),
(133, 51, 65, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-03-22 19:23:28', '2026-03-22 19:23:28'),
(134, 52, 66, NULL, NULL, 'Solde initial', 10000.00, 'TRANSFERFLUX', 'XOF', '2026-03-25 21:12:52', '2026-03-25 21:12:52');

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
(1, NULL, 1, 1, '+22 951503188', 'MTN Money - BIC: MTN', 'Lalya isidore', 'Transfert', '€', '', '10000', 'rembourse', '2025-11-29 18:46:28', '2025-11-29 17:51:02'),
(2, NULL, 1, 1, '+2290 198201610', 'Moov Money - BIC: MOOV', 'Lalya isidore', 'Transfert', 'XOF', '', '10300', 'rembourse', '2025-11-29 22:41:34', '2025-11-29 21:44:02'),
(3, NULL, 1, 1, '+2260 572974835', 'Orange Money - BIC: ORANGE', 'Lalya isidore', 'Transfert', 'XOF', '', '10300', 'completed', '2025-11-29 22:47:27', '2025-11-29 22:47:27'),
(4, NULL, 1, 1, '+22 172974835', 'Airtel Money - BIC: AIRTEL', 'Lalya isidore', 'Transfert', 'XOF', '', '96000', 'completed', '2025-11-29 22:53:52', '2025-11-29 22:53:52'),
(5, NULL, 1, 1, '+2250 596974835', 'Wave - BIC: WAVE', 'Lalya isidore', 'Transfert', 'XOF', '', '87500', 'rembourse', '2025-11-30 13:24:03', '2025-11-30 12:26:38'),
(6, NULL, 1, 1, 'lalyaisidore@gmail.com', 'PayPal', 'PayPal - lalyaisidore@gmail.com', 'Transfert', 'XOF', '', '87500', 'rembourse', '2025-11-30 13:29:01', '2025-11-30 12:31:55'),
(7, NULL, 1, 1, '+22 998201610', 'Moov Money - BIC: MOOV', 'Lalya isidore', 'Transfert', 'XOF', '', '163500', 'completed', '2025-11-30 13:40:21', '2025-11-30 13:40:21'),
(8, NULL, 1, 1, '+22 951508122', 'MTN Money - BIC: MTN', 'Lalya isidore', 'Transfert', 'XOF', '', '580800', 'rembourse', '2025-11-30 13:48:55', '2025-11-30 12:55:37'),
(9, NULL, 1, 1, '+2290 151503188', 'Wave - BIC: WAVE', 'Restaurant la Tendance', 'Transfert', 'XOF', '', '580800', 'completed', '2025-11-30 14:03:40', '2025-11-30 14:03:40'),
(10, NULL, 1, 1, '+2290 198201610', 'Moov Money - BIC: MOOV', 'Lalya Flora', 'Transfert', 'XOF', '', '46800', 'rembourse', '2025-11-30 14:13:41', '2025-11-30 13:38:49'),
(11, NULL, 1, 1, '+2290 151503285', 'MTN Money - BIC: MTN', 'CARMELLE Lili', 'Transfer', 'XOF', '', '46800', 'rembourse', '2025-11-30 19:53:38', '2025-11-30 18:57:57'),
(12, NULL, 1, 8, '+2290 157616286', 'MTN Money - BIC: MTN', 'Marc Germano DE-SOUZA', 'Loyer', 'XOF', '', '10000', 'completed', '2025-12-05 21:57:18', '2025-12-05 21:57:18'),
(13, NULL, 1, 7, '+2250 711913917', 'MTN Money - BIC: MTN', 'Laurent Konan', 'Prêt', 'XOF', '', '10000', 'rembourse', '2025-12-11 21:19:38', '2025-12-31 10:02:00'),
(14, NULL, 1, 1, '+2250 596385213', 'MTN Money - BIC: MTN', 'Comlan Lili', 'Transfer', 'XOF', '', '46800', 'completed', '2025-12-11 21:49:20', '2025-12-11 21:49:20'),
(15, NULL, 1, 6, '+2250 711913917', 'MTN Money - BIC: MTN', 'Laurent Konan', 'Prêt', 'XOF', '', '10000', 'rembourse', '2025-12-11 22:19:53', '2025-12-30 16:58:38'),
(16, NULL, 1, 1, '+2250 596321804', 'Wave - BIC: WAVE', 'Credo DIALLO', 'Aide', 'XOF', '', '352000', 'completed', '2025-12-25 11:42:07', '2025-12-25 11:42:07'),
(17, NULL, 1, 7, '+2250 707908975', 'Wave - BIC: WAVE', 'KOUAME FRANCOIS N\'DOLI', 'Prêt', 'XOF', '', '7000000', 'rembourse', '2025-12-26 18:14:15', '2025-12-28 09:40:41'),
(18, NULL, 1, 13, '+2290 197170691', 'MTN Money - BIC: MTN', 'Beryl Latoundji', 'Depot', 'XOF', '', '10000', 'rembourse', '2026-01-11 06:45:55', '2026-01-11 05:50:30'),
(19, NULL, 1, 1, '+2290 198201610', 'Moov Money - BIC: MOOV', 'Candide AHOSSI', 'Prêt', 'XOF', '', '580000', 'completed', '2026-02-03 15:49:10', '2026-02-03 15:49:10'),
(20, NULL, 1, 1, '+22 656311804', 'Orange Money - BIC: ORANGE', 'Jean OUEDRAOGO', 'Prêt', 'XOF', '', '870000', 'completed', '2026-02-03 16:05:43', '2026-02-03 16:05:43'),
(21, NULL, 1, 1, '+22 656311804', 'Orange Money - BIC: ORANGE', 'Jacques OUEDRAOGO', 'Prêt 💵', 'XOF', '', '3850000', 'completed', '2026-02-03 17:09:43', '2026-02-03 17:09:43'),
(22, NULL, 1, 18, '+237 698622774', 'Orange Money - BIC: ORANGE', 'Fotso Eric', 'Mala', 'XOF', '', '10000', 'completed', '2026-02-03 18:01:15', '2026-02-03 18:01:15'),
(23, NULL, 1, 19, '+29 965656546', 'MTN Money - BIC: MTN', 'Labnfk Marie', 'Virement', 'XOF', '', '1010000', 'completed', '2026-02-04 09:37:16', '2026-02-04 09:37:16'),
(24, NULL, 1, 19, '+22 953995324', 'MTN Money - BIC: MTN', 'Dupont Alice', 'Virement', 'XOF', '', '5000000', 'completed', '2026-02-04 18:54:25', '2026-02-04 18:54:25'),
(25, NULL, 1, 19, '+22 953995324', 'MTN Money - BIC: MTN', 'Dupont Alice', '10000', 'XOF', '', '100000000000', 'completed', '2026-02-04 19:35:36', '2026-02-04 19:35:36'),
(26, NULL, 1, 28, '+0 191137517', 'MTN Money - BIC: MTN', 'Prudencio Brahi', 'Aco', 'XOF', '', '10000', 'completed', '2026-02-09 20:07:49', '2026-02-09 20:07:49'),
(27, NULL, 1, 24, '+0 156456919', 'MTN Money - BIC: MTN', 'Kakou Charles', 'Aide', 'XOF', '', '15000', 'completed', '2026-02-10 16:58:09', '2026-02-10 16:58:09'),
(28, NULL, 1, 1, '+2250 504161214', 'Wave - BIC: WAVE', 'Monke Germain Zanahin', 'Prêt', 'XOF', '', '2000000', 'rembourse', '2026-02-21 16:03:12', '2026-02-22 11:42:18'),
(29, NULL, 1, 1, '+2250 504161214', 'Wave - BIC: WAVE', 'Monke Germain Zanahin', 'Prêt', 'XOF', '', '2000000', 'rembourse', '2026-02-23 01:26:44', '2026-02-25 07:58:30'),
(30, NULL, 1, 32, '+2290 160100912', 'Moov Money - BIC: MOOV', 'Ce kit', 'Transfert', 'XOF', '', '10000', 'completed', '2026-02-27 18:30:24', '2026-02-27 18:30:24'),
(31, NULL, 1, 32, '+22 795186285', 'Moov Money - BIC: MOOV', 'Coffi Tossou', 'Aide sociale', 'XOF', '', '6458809', 'completed', '2026-03-03 12:37:15', '2026-03-03 12:37:15');

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
(1, 8, NULL, '63692113', '2025-12-26 16:17:20', NULL, '2025-12-11 20:10:54', '2025-12-26 16:17:20'),
(2, 7, NULL, '92705942', '2025-12-11 21:48:14', NULL, '2025-12-11 21:18:14', '2025-12-11 21:18:14'),
(4, 11, NULL, '97436916', '2025-12-31 14:04:04', NULL, '2025-12-26 16:05:45', '2025-12-31 14:04:04'),
(5, 11, NULL, '13783621', '2025-12-31 14:04:04', NULL, '2025-12-26 16:16:19', '2025-12-31 14:04:04'),
(6, 8, NULL, '32833836', '2025-12-26 16:47:20', NULL, '2025-12-26 16:17:20', '2025-12-26 16:17:20'),
(7, 3, NULL, '97478010', '2025-12-26 16:52:21', NULL, '2025-12-26 16:18:53', '2025-12-26 16:52:21'),
(8, 3, NULL, '92270835', '2025-12-26 17:22:21', NULL, '2025-12-26 16:52:21', '2025-12-26 16:52:21'),
(9, 11, NULL, '98094582', '2025-12-31 14:04:04', NULL, '2025-12-26 16:54:26', '2025-12-31 14:04:04'),
(10, 11, NULL, '76950382', '2025-12-31 14:34:04', '2026-01-01 17:38:33', '2025-12-31 14:04:04', '2026-01-01 17:38:33'),
(12, 27, NULL, '57294088', '2026-02-03 16:59:58', NULL, '2026-02-03 16:59:56', '2026-02-03 16:59:58'),
(13, 27, NULL, '52989755', '2026-02-03 17:29:58', NULL, '2026-02-03 16:59:58', '2026-02-03 16:59:58'),
(14, 31, NULL, '38483987', '2026-02-05 21:32:08', NULL, '2026-02-05 21:02:08', '2026-02-05 21:02:08'),
(15, 32, NULL, '73944581', '2026-02-07 05:43:18', NULL, '2026-02-07 05:13:18', '2026-02-07 05:13:18'),
(16, 37, NULL, '48343478', '2026-02-09 19:28:48', NULL, '2026-02-09 18:58:48', '2026-02-09 18:58:48'),
(17, 40, NULL, '90118313', '2026-02-10 20:15:23', NULL, '2026-02-10 19:45:23', '2026-02-10 19:45:23'),
(18, 43, NULL, '35162648', '2026-02-13 07:53:44', NULL, '2026-02-13 07:23:44', '2026-02-13 07:23:44'),
(19, 46, NULL, '49397543', '2026-02-20 23:54:14', NULL, '2026-02-20 23:24:14', '2026-02-20 23:24:14'),
(20, 48, NULL, '52927876', '2026-02-22 22:18:08', NULL, '2026-02-22 21:48:08', '2026-02-22 21:48:08'),
(21, 42, NULL, '65103125', '2026-02-27 18:04:26', NULL, '2026-02-27 17:34:26', '2026-02-27 17:34:26'),
(22, 53, NULL, '74704313', '2026-03-03 11:54:41', NULL, '2026-03-03 11:24:41', '2026-03-03 11:24:41'),
(23, 57, NULL, '74862528', '2026-03-12 06:54:55', NULL, '2026-03-12 06:24:55', '2026-03-12 06:24:55');

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
(1, 'AHOSSI', 'Candide', 'lalyaisidore@gmail.com', '+22656311804', NULL, '$2y$12$Rd8kVIUsCZlwQjE56vFdk.pbiwwvTTDv4v0gfgAy.4H7y3QttVarK', 45000, NULL, NULL, NULL, '2025-11-29 17:09:02', '2026-02-21 15:00:42'),
(3, 'Éric', 'Dupond', 'esterode44@gmail.com', '+2290159323034', NULL, '$2y$12$.1aq1dNtyn6i2OwXOLOxhOZeTJMtSJvsRWR4uuLEQmOmXJ.9Tk8tS', 0, NULL, 1, NULL, '2025-11-30 21:31:06', '2025-11-30 21:31:06'),
(4, 'Dupont', 'François', 'rethispremier@gmail.com', '+2290155649488', NULL, '$2y$12$9TbKfheRVVj.kPQFZbXn2ep8XZVY/j9HOc2L8p8W1ih/bVwgVd6V.', 0, NULL, 1, NULL, '2025-12-01 13:12:58', '2025-12-01 13:12:58'),
(5, 'EZÉCHIEL', 'TCHOKPONHOUE', 'ezechieltchokponhoue@gmail.com', '+22960067966', NULL, '$2y$12$c07Fb8v1eR0ZheDlFzMHw.ClYhP8e7/jteWvrWw.DPhdIRz5FbLtu', 0, NULL, NULL, NULL, '2025-12-04 15:51:02', '2025-12-04 15:51:02'),
(6, 'Yves', 'Yves', 'yveslovard@gmail.com', '+2290168447610', NULL, '$2y$12$zATfIZ8XQk2gvgWjWF7dv.UGFB6fFoFtLaLlK.B/Gssi82F4Z6yxq', 0, NULL, 1, NULL, '2025-12-04 19:21:15', '2025-12-04 19:21:15'),
(7, 'Lovard', 'Yves', 'yvesmahugnon56@gmail.com', '+2290168447610', NULL, '$2y$12$3qBNqLExfNPvnwt8iE4DLeGqr0XrIr/b1K295tcvO0Kpt.5UT.i3O', 0, NULL, 3, NULL, '2025-12-05 06:39:37', '2026-02-03 11:00:22'),
(8, 'PAPA', 'Kanfa', 'papakanfa@gmail.com', '22653504648', NULL, '$2y$12$2BxvjlR7icV79th.reXTv.wUvGAVnJs6g/7kPR5kPDAXV3/eDj622', 0, NULL, NULL, NULL, '2025-12-05 20:30:41', '2025-12-05 20:30:41'),
(9, 'Flora', 'Flora', 'floralalya@gmail.com', '+22954491959', NULL, '$2y$12$HgENyngGJQfgNBeDMaP5WeT6fLLJGWUBQX4yPC8zp3Q/iI5bB9.e.', 0, NULL, NULL, NULL, '2025-12-27 10:11:52', '2025-12-27 10:13:49'),
(10, 'Elisabeth', 'Saraiva', 'saraivaelisabeth73@gmail.com', '+2290146411332', NULL, '$2y$12$iIdnoAUZBtQuuuOPkesupe4TZJDty3JDLrf8iCtMVCbZ9MMp9QizG', 0, NULL, NULL, NULL, '2025-12-28 22:02:54', '2025-12-28 22:02:54'),
(11, 'FARGEOT', 'ANNE-MARIE CLAUDE', 'ainokubard70@gmail.com', '+33725545545', NULL, '$2y$12$wHqjRblM3Vw/hpDkb2VzfeFoF09HAhULIEV4dvLm91Yjmc/NwDa9C', 0, NULL, NULL, NULL, '2026-01-01 16:09:15', '2026-01-01 16:09:15'),
(12, 'Dupont', 'Alice', 'laurianoali4@gmail.com', '22961771273', NULL, '$2y$12$eTHfffX6L/jXvxbmZ6o92.xqJUjBq5tFTbVoJST22MMYbZ4fMGyju', 0, NULL, NULL, NULL, '2026-01-05 13:39:58', '2026-01-05 13:39:58'),
(13, 'Fagbemy', 'Charbel', 'roberttaghetti@gmail.com', '+2290152785348', NULL, '$2y$12$sPrDtTofY1gUh3lel0KEOOzXx/Ix.8oBP71hbSUSWCQu0A8PlAU9K', 0, NULL, NULL, NULL, '2026-01-11 05:36:22', '2026-01-11 05:36:22'),
(14, 'Janna', 'Alvarez', 'jannalvre@gmail.com', '22953197987', NULL, '$2y$12$rbZQy.EM6YgrWovV87dbMOnRljCVzUWVd4kd4NYUrXqS8IOffKzTm', 0, NULL, NULL, NULL, '2026-01-21 19:10:26', '2026-01-21 19:10:26'),
(15, 'Estelle', 'Estelle', 'estellestelle.nina@gmail.com', '+22994319785', NULL, '$2y$12$7qzlBcGJqRy.QSApfr2rregAHo5HGL8DgU8p4.l7fnV49dv1KD.lG', 0, NULL, NULL, NULL, '2026-01-29 16:14:47', '2026-01-29 16:14:47'),
(16, 'MORALES GUTIERREZ', 'IRENE', 'molaregu@gmail.com', '+34655418051', NULL, '$2y$12$vBZhW1INq4Z0UFOAgrqyr.lA9SMJcI93bJa4RkuKYUPDrP6hKOvF.', 0, NULL, NULL, NULL, '2026-02-02 10:03:28', '2026-02-02 10:03:28'),
(17, 'Dupont', 'Claude', 'hj923167@gmail.com', '+237691155830', NULL, '$2y$12$jtz852tlY.1sXcsKWc5UG.R3GWl2I6Ng7Po8Md7gVq8fqxtCUouSy', 0, NULL, NULL, NULL, '2026-02-03 15:23:43', '2026-02-03 15:23:43'),
(18, 'Ngo\'o', 'Cyrus', 'cyrusboscongoo@gmail.com', '+237691351168', NULL, '$2y$12$1yZptrnLNN2e3cmP6CHVxOtw6P1AKTQIgcey4/48hiR9qYGrMdwBW', 0, NULL, NULL, NULL, '2026-02-03 16:19:54', '2026-02-03 16:19:54'),
(19, 'Dupont', 'Alice', 'loloche205@gmail.com', '+22953995324', NULL, '$2y$12$s.eyt.0x.9ooVVzkJtEDYe0w36GhOMSRyk1eLSsJcGrEfxD3U4aLi', 0, NULL, NULL, NULL, '2026-02-03 22:57:52', '2026-02-03 22:57:52'),
(20, 'Tanoh', 'Kouadou Célestine', 'Tanohcelestine272@gmail.com', '+2250779121150', NULL, '$2y$12$FMUXnDhtIy4vcAb5kbRPf.Qb83f/TuqDfG.2qr8QJrz4pzb/OEbT.', 0, NULL, NULL, NULL, '2026-02-04 14:15:07', '2026-02-04 14:15:07'),
(21, 'Rodrigo', 'Kizito', 'rodrigokizito9@gmail.com', '+2290150494200', NULL, '$2y$12$LS.tZ1znlFEIKMMzdAaAA.GwLcR6n4vKCTDii2Kxd5KnWBi6qSusy', 0, NULL, NULL, NULL, '2026-02-05 07:38:47', '2026-02-05 07:38:47'),
(22, 'Dupont', 'Elsa', 'elsa52346@gmail.com', '+4915126192695', NULL, '$2y$12$mJ.K3b8Xa.yjxfCYVolzK.qXtwj3T7GFx9tJX3dnZzLMtwW0QI2Ey', 0, NULL, NULL, NULL, '2026-02-05 20:57:13', '2026-02-05 20:57:13'),
(23, 'Maria', 'Pavard', 'Bmobank38@gmail.com', '22953570853', NULL, '$2y$12$alQmW8tfYUlY8LeNwVJPzOElhYU5jMqj6ZBvgyA0XQJrz/5G/jmhm', 0, NULL, NULL, NULL, '2026-02-07 05:02:26', '2026-02-07 05:02:26'),
(24, 'Alexandre', 'Huessou', 'alexandrehouessou212@gmail.com', '+22956456919', NULL, '$2y$12$BEqZ/8lhgS29pDucVk3qUuNMQeegVn74Y3s202X7eIN3bOj1VC62e', 0, NULL, NULL, NULL, '2026-02-08 21:52:10', '2026-02-08 21:52:10'),
(25, 'Walter', 'Rosemberg', 'internationalhurge@gmail.com', '+22950632067', NULL, '$2y$12$rUUtNE9tBhWzoNQGf5.useK6a.Bx5OUGlDpf2ruv4qqJZI0tmy54u', 5000, NULL, 24, NULL, '2026-02-08 22:00:09', '2026-02-08 22:00:09'),
(26, 'Hyves Haled', 'Ouedraogo', 'sandrinechaux71@gmail.com', '+2250152247446', NULL, '$2y$12$yJlNR7Yklc56YX2KLu8OSO3Wc.2Lz3kkwddLkpObfe.zcGm6bhYC2', 0, NULL, NULL, NULL, '2026-02-09 10:51:16', '2026-02-09 10:51:16'),
(27, 'Marie', 'David', 'reondavid871@gmail.com', '+22893180880', NULL, '$2y$12$IOtbYmqdl2LsIs7jX3fRYOOS39er6krYirnnCBjSefxm9YH2/pjhK', 0, NULL, NULL, NULL, '2026-02-09 13:12:26', '2026-02-09 13:12:26'),
(28, 'Bbva', 'Banco', 'asistentebancariobbva@gmail.com', '+351916348312', NULL, '$2y$12$xhy5WNmKAEMqMEg0jsLRU.F37fOLPNSMVZolKVFn4WjzPIbubfnWq', 0, NULL, NULL, NULL, '2026-02-09 17:10:14', '2026-02-10 13:54:41'),
(29, 'David', 'Jeanne', 'davance046@gmail.com', '+22893180880', NULL, '$2y$12$kg27KCtkKcgGqVZ3UfrxTe5vYHer4/FHeBC.iPflkx9QOw7U6LF2y', 0, NULL, NULL, NULL, '2026-02-10 10:24:54', '2026-02-10 10:24:54'),
(30, 'Dedeyan', 'Stéphane', 'gedeonlate545@gmail.com', '+22960046025', NULL, '$2y$12$k2/c.xRGGe6SfG1Cenq3qOQMYve6viR63IAK.Y0CujkIL8HnbGuWy', 0, NULL, NULL, NULL, '2026-02-10 19:34:35', '2026-02-10 19:34:35'),
(31, 'Akpacla', 'Richard', 'moulinfrantzal@gmail.com', '+2290167563031', NULL, '$2y$12$a79BJGxWeC.vKnTU2A/yp.07KR0/xa2QEKJldYHfkKtO1..p5bqbC', 0, NULL, NULL, NULL, '2026-02-11 11:24:17', '2026-02-11 11:24:17'),
(32, 'kit', 'Ce', '003cekit@gmail.com', '+2290160100912', NULL, '$2y$12$N0mUAyv/06PA2Zm3vpJFpOcGppq2eDtoWGBga8nSyl6/mfFx/Ynam', 0, NULL, 24, NULL, '2026-02-11 11:51:30', '2026-02-27 17:21:50'),
(33, 'Elsa', 'Maria', 'anaciaramarine84@gmail.com', '+2290161831708', NULL, '$2y$12$0HPFcEK6pdSx5HJjXXpM.eVBvtxRqhydRgn0JLAQdoXGQ8hVcYoQK', 0, NULL, 24, NULL, '2026-02-13 07:21:46', '2026-02-13 07:21:46'),
(34, 'Samwil', 'Biaou', 'samwilbiaou6@gmail.com', '0142235392', NULL, '$2y$12$JUFlYgJMI8TOXf/Im22iSO8Gd1cN64zcO8Fly4FTX6iaVTnpi9vGW', 0, NULL, NULL, NULL, '2026-02-18 17:25:01', '2026-02-18 17:25:01'),
(35, 'Sawadoga', 'Roger', 'sawadogaroger02@gmail.com', '+22955771656', NULL, '$2y$12$mzgtl8kxRLzOcl6c6nwY0.TjL0TC7u/7D9rs8XriCOYs3oTRRtvcq', 0, NULL, NULL, NULL, '2026-02-19 12:00:49', '2026-02-19 15:54:30'),
(36, 'Justice', 'Divine', 'justicedivine99933@gmail.com', '+2990150583061', NULL, '$2y$12$WB0MDF1/KUhTf47zeuwE/Ow6fIWILZXT/s9As4skuNP4nmhJYWUgG', 0, NULL, NULL, NULL, '2026-02-20 07:51:17', '2026-02-20 07:51:17'),
(37, 'DIAZ', 'M. TOREADOR', 'yavamaua@gmail.com', '+22959397737', NULL, '$2y$12$ZqhZ.aeJCUE5CGSS5Mo9aevqgTK7caEbmIKJ7MDv5vlGuvxAaupva', 0, NULL, NULL, NULL, '2026-02-23 10:52:03', '2026-02-23 10:52:03'),
(38, 'Klaus', 'Caroline', 'bzmpllw@gmail.com', '+33644663440', NULL, '$2y$12$zwGSd5O3muAABf2xJ/KGr.ZXQOqLXvJYeM/uknvSWZEtFZjHxyMMO', 0, NULL, NULL, NULL, '2026-02-25 20:39:06', '2026-02-25 20:39:06'),
(39, 'YAO', 'Narcisse', 'transfert816@gmail.com', '+2290190969603', NULL, '$2y$12$H4EGnuq68kNNSIGCPNml2ua8I5GJj4WJ4Y10w1rSCgE1cEKCNTCIe', 0, NULL, NULL, NULL, '2026-02-26 06:49:40', '2026-02-26 06:49:40'),
(40, 'Bossou', 'Babaro', 'sneosurf98@gmail.com', '+2290190280115', NULL, '$2y$12$i4q/XjXdZb6BF82cMa6LPuvz8kkOQG.eRlI40XV61b25Y2qek6mxe', 0, NULL, NULL, NULL, '2026-02-27 09:48:16', '2026-02-27 09:48:16'),
(41, 'HODONOU', 'Cardnelle', 'hodonoucardnelle@gmail.com', '0141752620', NULL, '$2y$12$WJJ/E./IBvcMcRNOPwzvzeU6zFOD4q3W0AcDS/TBcuYE1uAJFEesq', 0, NULL, NULL, NULL, '2026-03-05 04:19:19', '2026-03-05 09:47:12'),
(42, 'Dochli', 'Sylvie', 'Sylviedochli39@gmail.com', '+33756843126', NULL, '$2y$12$46I6Ehdl9/n//rRXXHVGw.717UcabC1J.DoaAkyFYxSh.FJxpgemq', 0, NULL, NULL, NULL, '2026-03-09 12:10:05', '2026-03-09 12:10:05'),
(43, 'Thomas', 'bulberl', 'partinieraliou@gmail.com', '+22963660357', NULL, '$2y$12$6lMT1Dt6HN7zjK3sWbu7ZOjlxhfbPLABQrHuO9KzKVzNYzVdKFLrm', 0, NULL, NULL, NULL, '2026-03-12 06:10:19', '2026-03-12 06:10:19'),
(44, 'Bill', 'leonaldo', 'leonaldobill92@gmail.com', '2290157119465', NULL, '$2y$12$eZ3CtlymX.jaBqMWZchSUOP5aUTNvL6uU432n6Ufk8bE5haZ8.JTC', 0, NULL, NULL, NULL, '2026-03-12 16:22:55', '2026-03-12 16:22:55'),
(45, 'Jean', 'Laurent', 'pbanque772@gmail.com', '22995440899', NULL, '$2y$12$y5JiKr6UPgKoq5KU/aXmsO6GsYgxvv/CnW1SsfQRN1qGilhvLZPO.', 0, NULL, NULL, NULL, '2026-03-13 18:42:41', '2026-03-13 18:42:41'),
(46, 'Cate', 'Tanya', 'Kahkenny444@gmail.com', '+2250596344663', NULL, '$2y$12$Nj1re56bGYbMP4ejBhAU2.8Y5c5nXJjze.2rmcKQ.WvVMq.wT5.t.', 0, NULL, NULL, NULL, '2026-03-14 11:22:54', '2026-03-14 11:22:54'),
(47, 'Ange', 'Go', 'djokpeangelo@gmail.com', '22957588819', NULL, '$2y$12$RuNjnw1Ac34ONmFunZpU0uE57cFBgvlqLgf2WgV7.pCUJnf2yyhla', 0, NULL, NULL, NULL, '2026-03-16 19:53:39', '2026-03-16 19:53:39'),
(48, 'Banco', 'HSBC', 'bancohsbc052@gmail.com', '+339521943295', NULL, '$2y$12$Y8h1Z8XQB2U0Lanm0fw8r.UzldjTZAZUyj2hGjRYCVzUQ8Sbc8v9a', 0, NULL, 24, NULL, '2026-03-17 07:52:38', '2026-03-17 07:52:38'),
(49, 'Rossi', 'Rebecca', 'rebeccarossi161@gmail.com', '2250704062734', NULL, '$2y$12$GMRLLOtnvk9QKLG4QwoRd.wn7rAZsClcMuZpZE4/HGTCapWivkwjq', 0, NULL, NULL, NULL, '2026-03-18 05:45:54', '2026-03-18 05:45:54'),
(50, 'FUNDACIÓN', 'FUNBERT', 'funbertfundacion6@gmail.com', '0158703010', NULL, '$2y$12$aiarTRwLn77LO2tAe8rmAuuTrCMjCL42hTLacjSyD79Sef/zAVVIm', 0, NULL, NULL, NULL, '2026-03-18 09:06:47', '2026-03-18 09:06:47'),
(51, 'Dupont', 'Romio', 'romeodahouindji21@gmail.com', '+2290158403807', NULL, '$2y$12$mNb6Bfo6dciKKDWweKmPF.RVIzN0m/oRxqcq0rZbX3mSzBazH0I9W', 0, NULL, NULL, NULL, '2026-03-22 19:23:28', '2026-03-22 19:23:28'),
(52, 'Lez', 'Niche', 'bancobnpparibasacquavivaalessa@gmail.com', '+23409037772494', NULL, '$2y$12$tmLIVLPn0xRVyUlOw/YbDOwu/xuGRCdDcFDuJdJf3hv2YiQ1Vjtdq', 0, NULL, 24, NULL, '2026-03-25 21:12:52', '2026-03-25 21:12:52');

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
  ADD KEY `comptes_user_id_foreign` (`user_id`),
  ADD KEY `comptes_auto_deletes_at_index` (`auto_deletes_at`),
  ADD KEY `comptes_is_auto_created_index` (`is_auto_created`);

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
  ADD KEY `transaction_histories_compte_id_index` (`compte_id`),
  ADD KEY `idx_transaction_histories_transfer_id` (`transfer_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `commissions`
--
ALTER TABLE `commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `comptes`
--
ALTER TABLE `comptes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

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
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `recharge_transactions`
--
ALTER TABLE `recharge_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `remboursements`
--
ALTER TABLE `remboursements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `retraits`
--
ALTER TABLE `retraits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `transaction_histories`
--
ALTER TABLE `transaction_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT pour la table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `unlock_codes`
--
ALTER TABLE `unlock_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
  ADD CONSTRAINT `transaction_histories_compte_id_foreign` FOREIGN KEY (`compte_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
