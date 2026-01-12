-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.4.3 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Copiando estrutura para tabela linkbiotop.audience_contacts
CREATE TABLE IF NOT EXISTS `audience_contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `workspace_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL COMMENT 'Dono do workspace',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'booking, tipjar, shop, etc',
  `source_id` bigint unsigned DEFAULT NULL COMMENT 'ID do registro original',
  `metadata` json DEFAULT NULL COMMENT 'Dados adicionais específicos da origem',
  `tags` json DEFAULT NULL COMMENT 'Tags para segmentação',
  `total_interactions` int NOT NULL DEFAULT '0',
  `total_spent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `last_interaction_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','inactive','blocked') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `subscribed_newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `audience_contacts_email_workspace_id_unique` (`email`,`workspace_id`),
  KEY `audience_contacts_workspace_id_index` (`workspace_id`),
  KEY `audience_contacts_user_id_index` (`user_id`),
  KEY `audience_contacts_source_index` (`source`),
  KEY `audience_contacts_status_index` (`status`),
  KEY `audience_contacts_last_interaction_at_index` (`last_interaction_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.audience_contacts: ~3 rows (aproximadamente)
INSERT IGNORE INTO `audience_contacts` (`id`, `workspace_id`, `user_id`, `name`, `email`, `phone`, `avatar`, `source`, `source_id`, `metadata`, `tags`, `total_interactions`, `total_spent`, `last_interaction_at`, `status`, `subscribed_newsletter`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Adriano', 'adrianowebm@gmail.com', '11941150086', NULL, 'booking', NULL, '[]', NULL, 1, 0.00, '2026-01-08 16:54:58', 'active', 0, '2026-01-08 16:54:58', '2026-01-08 16:54:58'),
	(2, 4, 1, 'Adriano', 'adrianowebm@gmail.com', '11941150086', NULL, 'booking', NULL, '[]', '[]', 1, 0.00, '2026-01-08 19:04:01', 'active', 0, '2026-01-08 19:04:01', '2026-01-08 19:04:01'),
	(3, 4, 1, 'Teste ADR', 'mmdesignersrg3@gmail.com', '11941150086', NULL, 'booking', NULL, '[]', '[]', 1, 0.00, '2026-01-08 20:13:30', 'active', 0, '2026-01-08 20:13:30', '2026-01-08 20:13:30');

-- Copiando estrutura para tabela linkbiotop.audience_interactions
CREATE TABLE IF NOT EXISTS `audience_interactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contact_id` bigint unsigned NOT NULL,
  `workspace_id` bigint unsigned NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'booking, purchase, tip, message, etc',
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'created, updated, cancelled, etc',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `audience_interactions_contact_id_index` (`contact_id`),
  KEY `audience_interactions_workspace_id_index` (`workspace_id`),
  KEY `audience_interactions_type_index` (`type`),
  KEY `audience_interactions_created_at_index` (`created_at`),
  CONSTRAINT `audience_interactions_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `audience_contacts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.audience_interactions: ~0 rows (aproximadamente)
INSERT IGNORE INTO `audience_interactions` (`id`, `contact_id`, `workspace_id`, `type`, `action`, `amount`, `metadata`, `created_at`) VALUES
	(1, 1, 1, 'booking', 'created', 0.00, '[]', '2026-01-08 13:54:58'),
	(2, 2, 4, 'booking', 'created', 0.00, '[]', '2026-01-08 16:04:01'),
	(3, 3, 4, 'booking', 'created', 0.00, '[]', '2026-01-08 17:13:30');

-- Copiando estrutura para tabela linkbiotop.auth_activity
CREATE TABLE IF NOT EXISTS `auth_activity` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `browser` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.auth_activity: ~12 rows (aproximadamente)
INSERT IGNORE INTO `auth_activity` (`id`, `user`, `type`, `message`, `ip`, `os`, `browser`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Login', 'Login Failed', '127.0.0.1', 'Windows', 'Firefox', '2026-01-07 21:25:40', '2026-01-07 21:25:40'),
	(2, 1, 'Login', 'Login realizado com sucesso', '127.0.0.1', 'Windows', 'Firefox', '2026-01-07 21:25:51', '2026-01-07 21:25:51'),
	(3, 1, 'plan', 'Pro Ativado com Sucesso.', '127.0.0.1', 'Windows', 'Firefox', '2026-01-07 23:49:00', '2026-01-07 23:49:00'),
	(4, 1, 'plan', 'Gratuito Ativado com Sucesso.', '127.0.0.1', 'Windows', 'Firefox', '2026-01-07 23:55:41', '2026-01-07 23:55:41'),
	(5, 1, 'plan', 'Pro Ativado com Sucesso.', '127.0.0.1', 'Windows', 'Firefox', '2026-01-08 00:06:46', '2026-01-08 00:06:46'),
	(6, 1, 'Login', 'Login realizado com sucesso', '127.0.0.1', 'Windows', 'Firefox', '2026-01-08 00:33:39', '2026-01-08 00:33:39'),
	(7, 2, 'Login', 'Login realizado com sucesso', '127.0.0.1', 'Windows', 'Firefox', '2026-01-08 00:39:46', '2026-01-08 00:39:46'),
	(8, 2, 'plan', 'Gratuito Ativado com Sucesso.', '127.0.0.1', 'Windows', 'Firefox', '2026-01-08 00:39:46', '2026-01-08 00:39:46'),
	(9, 1, 'Login', 'Login realizado com sucesso', '127.0.0.1', 'Windows', 'Firefox', '2026-01-08 01:27:06', '2026-01-08 01:27:06'),
	(10, 2, 'Login', 'Login realizado com sucesso', '127.0.0.1', 'Windows', 'Firefox', '2026-01-08 01:27:34', '2026-01-08 01:27:34'),
	(11, 1, 'Login', 'Login realizado com sucesso', '127.0.0.1', 'Windows', 'Firefox', '2026-01-08 01:27:59', '2026-01-08 01:27:59'),
	(12, 1, 'Login', 'Login realizado com sucesso', '127.0.0.1', 'Windows', 'Firefox', '2026-01-08 02:46:23', '2026-01-08 02:46:23'),
	(13, 1, 'Login', 'Login realizado com sucesso', '127.0.0.1', 'Windows', 'Firefox', '2026-01-08 03:54:47', '2026-01-08 03:54:47'),
	(14, 1, 'Login', 'Login realizado com sucesso', '127.0.0.1', 'Windows', 'Firefox', '2026-01-08 04:12:27', '2026-01-08 04:12:27'),
	(15, 1, 'api_reset', 'Redefinição de chave de API. Chave anterior :', '127.0.0.1', 'Windows', 'Firefox', '2026-01-08 18:57:09', '2026-01-08 18:57:09'),
	(16, 1, 'Security', 'Enabled 2FA', '127.0.0.1', 'Windows', 'Firefox', '2026-01-09 01:49:11', '2026-01-09 01:49:11'),
	(17, 1, 'Login', 'Successful Login (2FA)', '127.0.0.1', 'Windows', 'Firefox', '2026-01-09 01:58:37', '2026-01-09 01:58:37'),
	(18, 1, 'Login', 'Login Failed', '127.0.0.1', 'Windows', 'Firefox', '2026-01-12 20:59:05', '2026-01-12 20:59:05');

-- Copiando estrutura para tabela linkbiotop.bio_devicetoken
CREATE TABLE IF NOT EXISTS `bio_devicetoken` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int DEFAULT NULL,
  `device_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.bio_devicetoken: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.bio_push_notification
CREATE TABLE IF NOT EXISTS `bio_push_notification` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.bio_push_notification: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.blocks
CREATE TABLE IF NOT EXISTS `blocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned DEFAULT NULL,
  `block` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci,
  `blocks` longtext COLLATE utf8mb4_unicode_ci,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blocks_workspace_id_index` (`workspace_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.blocks: ~18 rows (aproximadamente)
INSERT IGNORE INTO `blocks` (`id`, `user`, `workspace_id`, `block`, `title`, `blocks`, `settings`, `position`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'image', NULL, NULL, NULL, 0, '2026-01-07 21:24:39', '2026-01-07 21:24:39'),
	(2, 1, 1, 'links', NULL, NULL, NULL, 0, '2026-01-07 21:24:40', '2026-01-07 21:24:40'),
	(3, 1, 1, 'text', NULL, '{"heading":"Welcome Aboard \\ud83e\\udd29","content":"<ul><li><p>We have added some blocks to help you get started.<\\/p><\\/li><\\/ul><ul><li><p>Click this to edit or any of the elements below.<\\/p><\\/li><\\/ul><ul><li><p>You can drag them to reorder their position.<\\/p><\\/li><\\/ul><ul><li><p>Click on the (+) icon to add more blocks.<\\/p><\\/li><\\/ul><ul><li><p>Click on the blot menu to add elements.<\\/p><\\/li><\\/ul><ul><li><p>Elements can be in the form of email collection, paid items, etc.<\\/p><\\/li><\\/ul>"}', NULL, 0, '2026-01-07 21:24:40', '2026-01-07 21:24:40'),
	(4, 2, NULL, 'links', 'My New Block', '{"heading":"My New Block"}', NULL, 0, '2026-01-08 00:48:16', '2026-01-08 00:48:16'),
	(5, 1, 4, 'links', 'My New Block', '{"heading":"My New Block"}', NULL, 0, '2026-01-08 01:58:49', '2026-01-08 01:58:49'),
	(6, 1, 1, 'booking', 'My Booking', '{"heading":"My Booking"}', NULL, 0, '2026-01-08 02:53:37', '2026-01-08 02:53:37'),
	(7, 1, 1, 'course', NULL, '{"all_course":1}', NULL, 0, '2026-01-08 03:11:00', '2026-01-08 03:11:00'),
	(8, 1, 1, 'shop', NULL, '{"all_product":1}', NULL, 0, '2026-01-08 16:30:06', '2026-01-08 16:30:06'),
	(9, 1, 4, 'booking', NULL, NULL, NULL, 0, '2026-01-08 17:41:33', '2026-01-08 17:41:33'),
	(10, 1, 4, 'text', 'Welcome Aboard! 🎉', '{"content":"<ul><li><p>We have added some blocks to help you get started.<\\/p><\\/li><\\/ul><ul><li><p>Click this to edit or any of the elements below.<\\/p><\\/li><\\/ul><ul><li><p>You can drag them to reorder their position.<\\/p><\\/li><\\/ul><ul><li><p>Click on the (+) icon to add more blocks.<\\/p><\\/li><\\/ul><ul><li><p>Click on the blot menu to add elements.<\\/p><\\/li><\\/ul><ul><li><p>Elements can be in the form of email collection, paid items, etc.<\\/p><\\/li><\\/ul>","heading":"Welcome Aboard! \\ud83c\\udf89"}', NULL, 0, '2026-01-08 19:06:10', '2026-01-08 19:06:10'),
	(11, 1, 4, 'links', 'My New Block', '{"heading":"My New Block"}', NULL, 0, '2026-01-08 19:06:16', '2026-01-08 19:06:16'),
	(12, 1, 4, 'embed', 'My New Embed Link', '{"heading":"My New Embed Link"}', NULL, 0, '2026-01-08 19:07:41', '2026-01-08 19:07:41'),
	(13, 1, 4, 'links', NULL, NULL, NULL, 0, '2026-01-08 22:56:04', '2026-01-08 22:56:04'),
	(14, 1, 4, 'links', NULL, NULL, NULL, 0, '2026-01-08 23:19:44', '2026-01-08 23:19:44'),
	(15, 1, 4, 'video', 'My New Video', '{"heading":"My New Video"}', NULL, 0, '2026-01-08 23:21:07', '2026-01-08 23:21:07'),
	(16, 1, 4, 'video', 'My New Video', '{"heading":"My New Video"}', NULL, 0, '2026-01-08 23:21:39', '2026-01-08 23:21:39'),
	(17, 1, 4, 'image', 'My New Image Block', '{"heading":"My New Image Block"}', NULL, 0, '2026-01-08 23:21:50', '2026-01-08 23:21:50'),
	(18, 1, 4, 'lists', 'My New List Items', '{"heading":"My New List Items"}', NULL, 0, '2026-01-09 00:19:38', '2026-01-09 00:19:38');

-- Copiando estrutura para tabela linkbiotop.blocks_element
CREATE TABLE IF NOT EXISTS `blocks_element` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `block_id` int NOT NULL,
  `thumbnail` longtext COLLATE utf8mb4_unicode_ci,
  `is_element` int DEFAULT NULL,
  `element` int DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.blocks_element: ~20 rows (aproximadamente)
INSERT IGNORE INTO `blocks_element` (`id`, `user`, `block_id`, `thumbnail`, `is_element`, `element`, `link`, `content`, `settings`, `position`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '{"type":"external","upload":null,"link":"http:\\/\\/127.0.0.1:8000\\/assets\\/image\\/others\\/default-sandy-skeleton.png"}', NULL, NULL, NULL, '{"caption":"Second Image","alt":"Our Second Preset Image"}', NULL, 0, '2026-01-07 21:24:39', '2026-01-07 21:24:39'),
	(2, 1, 1, '{"type":"external","upload":null,"link":"http:\\/\\/127.0.0.1:8000\\/assets\\/image\\/others\\/default-sandy-skeleton.png"}', NULL, NULL, NULL, '{"caption":"First Image","alt":"Our First Preset Image"}', NULL, 0, '2026-01-07 21:24:39', '2026-01-07 21:24:39'),
	(3, 1, 2, '{"type":"external","upload":null,"link":"http:\\/\\/127.0.0.1:8000\\/assets\\/image\\/others\\/default-sandy-skeleton.png"}', NULL, NULL, NULL, '{"heading":"Crazy Links \\ud83e\\udd74"}', NULL, 2, '2026-01-07 21:24:40', '2026-01-08 01:46:18'),
	(4, 1, 2, '{"type":"external","upload":null,"link":"http:\\/\\/127.0.0.1:8000\\/assets\\/image\\/others\\/default-sandy-skeleton.png"}', NULL, NULL, NULL, '{"heading":"Earn Cash \\ud83e\\udd11"}', NULL, 3, '2026-01-07 21:24:40', '2026-01-08 01:46:18'),
	(5, 1, 2, '{"type":"external","upload":null,"link":"http:\\/\\/127.0.0.1:8000\\/assets\\/image\\/others\\/default-sandy-skeleton.png"}', NULL, NULL, NULL, '{"heading":"Dont Click! \\ud83d\\ude3a"}', NULL, 1, '2026-01-07 21:24:40', '2026-01-08 01:46:18'),
	(6, 2, 4, '[]', NULL, NULL, NULL, '{"heading":"New Link \\ud83e\\udd29","link":"https:\\/\\/yetti.page"}', NULL, 3, '2026-01-08 00:48:16', '2026-01-08 00:49:08'),
	(7, 2, 4, '[]', NULL, NULL, NULL, '{"heading":"New Link \\ud83e\\udd29","link":"https:\\/\\/yetti.page"}', NULL, 1, '2026-01-08 00:48:25', '2026-01-08 00:49:08'),
	(8, 2, 4, '[]', NULL, NULL, NULL, '{"heading":"New Link \\ud83e\\udd29","link":"https:\\/\\/yetti.page"}', NULL, 2, '2026-01-08 00:49:01', '2026-01-08 00:49:08'),
	(9, 1, 5, '[]', NULL, NULL, NULL, '{"heading":"New Link \\ud83e\\udd29","link":"https:\\/\\/yetti.page"}', NULL, 0, '2026-01-08 01:58:49', '2026-01-08 01:58:49'),
	(10, 1, 7, NULL, NULL, NULL, 'https://', NULL, NULL, 0, '2026-01-08 03:11:00', '2026-01-08 03:11:00'),
	(11, 1, 8, NULL, NULL, NULL, 'https://', NULL, NULL, 0, '2026-01-08 16:30:06', '2026-01-08 16:30:06'),
	(12, 1, 5, '[]', NULL, NULL, NULL, '{"heading":"New Link \\ud83e\\udd29","link":"https:\\/\\/yetti.page"}', NULL, 0, '2026-01-08 17:32:34', '2026-01-08 17:32:34'),
	(13, 1, 5, '[]', NULL, NULL, NULL, '{"heading":"New Link \\ud83e\\udd29","link":"https:\\/\\/yetti.page"}', NULL, 0, '2026-01-08 17:33:04', '2026-01-08 17:33:04'),
	(14, 1, 11, '{"type":"upload","upload":"\\/3Y8fcJuRuxU5iosIZn2oyksXx3fRo7a0aZJk1IVQ.jpg"}', NULL, NULL, NULL, '{"heading":"Teste\\ud83e\\udd29","link":"\\/elements\\/contact_me\\/SFRG"}', NULL, 0, '2026-01-08 19:06:16', '2026-01-09 00:19:17'),
	(15, 1, 12, '[]', NULL, NULL, NULL, '{"link":"http:\\/\\/linkbiotop.test","fetch":{"w":"linkbiotop.test","fw":"http:\\/\\/linkbiotop.test\\/","t":"LinkBio.top","f":"http:\\/\\/linkbiotop.test\\/assets\\/image\\/others\\/default-favicon.png"}}', NULL, 0, '2026-01-08 19:07:41', '2026-01-08 19:07:41'),
	(16, 1, 13, NULL, 1, 1, 'https:///elements/contact_me/SFRG', '{"heading":"Contato","link":"\\/elements\\/contact_me\\/SFRG"}', NULL, 0, '2026-01-08 22:56:04', '2026-01-08 22:56:04'),
	(17, 1, 14, NULL, 1, 2, 'https:///elements/articles/jUj1', '{"heading":"Teste","link":"\\/elements\\/articles\\/jUj1"}', NULL, 0, '2026-01-08 23:19:44', '2026-01-08 23:19:44'),
	(18, 1, 15, '[]', NULL, NULL, NULL, '{"type":"youtube","link":"https:\\/\\/youtu.be\\/lJp6BezFLCk","thumbnail":"https:\\/\\/img.youtube.com\\/vi\\/lJp6BezFLCk\\/maxresdefault.jpg","isIframe":false}', NULL, 0, '2026-01-08 23:21:07', '2026-01-08 23:21:07'),
	(19, 1, 16, '[]', NULL, NULL, NULL, '{"type":"youtube","link":"https:\\/\\/youtu.be\\/lJp6BezFLCk","thumbnail":"https:\\/\\/img.youtube.com\\/vi\\/lJp6BezFLCk\\/maxresdefault.jpg","isIframe":false}', NULL, 0, '2026-01-08 23:21:39', '2026-01-08 23:21:39'),
	(20, 1, 17, '{"type":"external","upload":null,"link":"https:\\/\\/api.dicebear.com\\/9.x\\/adventurer-neutral\\/svg?seed=rtu1x4OytC"}', NULL, NULL, NULL, '{"caption":"This is Fascinating!","alt":"Perfect page builder for creatives & get to do more with a linkinbio"}', NULL, 0, '2026-01-08 23:21:51', '2026-01-08 23:21:51'),
	(21, 1, 18, '{"type":"external","upload":null,"link":"https:\\/\\/api.dicebear.com\\/9.x\\/adventurer-neutral\\/svg?seed=E6GiW"}', NULL, NULL, NULL, '{"heading":"How Crazy Am I?","subheading":"Perfect page builder for creatives & get to do more with a linkinbio"}', NULL, 0, '2026-01-09 00:19:38', '2026-01-09 00:19:38');

-- Copiando estrutura para tabela linkbiotop.blog
CREATE TABLE IF NOT EXISTS `blog` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postedBy` int DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'internal',
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `author` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ttr` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int NOT NULL DEFAULT '0',
  `total_views` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.blog: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.booking_appointments
CREATE TABLE IF NOT EXISTS `booking_appointments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned DEFAULT NULL,
  `payee_user_id` int DEFAULT NULL,
  `service_ids` longtext COLLATE utf8mb4_unicode_ci,
  `date` date DEFAULT NULL,
  `time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `info` longtext COLLATE utf8mb4_unicode_ci,
  `appointment_status` int NOT NULL DEFAULT '0',
  `price` double(16,2) DEFAULT NULL,
  `is_paid` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `guest_contact_id` bigint unsigned DEFAULT NULL,
  `guest_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_appointments_workspace_id_index` (`workspace_id`),
  KEY `booking_appointments_guest_contact_id_index` (`guest_contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.booking_appointments: ~0 rows (aproximadamente)
INSERT IGNORE INTO `booking_appointments` (`id`, `user`, `workspace_id`, `payee_user_id`, `service_ids`, `date`, `time`, `settings`, `info`, `appointment_status`, `price`, `is_paid`, `created_at`, `updated_at`, `guest_contact_id`, `guest_name`, `guest_email`, `guest_phone`) VALUES
	(1, 1, 1, 1, '["2"]', '2026-01-08', '600-630', '[]', NULL, 0, 55.00, 0, '2026-01-08 16:54:58', '2026-01-08 16:54:58', NULL, NULL, NULL, NULL),
	(2, 1, 4, 1, '["4"]', '2026-01-08', '570-630', '[]', NULL, 0, 200.00, 0, '2026-01-08 19:04:01', '2026-01-08 19:04:01', NULL, NULL, NULL, NULL),
	(3, 1, 4, 1, '["3"]', '2026-01-08', '540-600', '[]', NULL, 0, 200.00, 0, '2026-01-08 20:13:30', '2026-01-08 20:13:30', NULL, NULL, NULL, NULL);

-- Copiando estrutura para tabela linkbiotop.booking_orders
CREATE TABLE IF NOT EXISTS `booking_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned DEFAULT NULL,
  `payee_user_id` int DEFAULT NULL,
  `appointment_id` int DEFAULT NULL,
  `method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(16,2) DEFAULT NULL,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_orders_workspace_id_index` (`workspace_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.booking_orders: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.booking_reviews
CREATE TABLE IF NOT EXISTS `booking_reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned DEFAULT NULL,
  `reviewer_id` int DEFAULT NULL,
  `rating` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_reviews_workspace_id_index` (`workspace_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.booking_reviews: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.booking_services
CREATE TABLE IF NOT EXISTS `booking_services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` longtext COLLATE utf8mb4_unicode_ci,
  `price` double(16,2) NOT NULL DEFAULT '0.00',
  `duration` int DEFAULT NULL,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_services_workspace_id_index` (`workspace_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.booking_services: ~4 rows (aproximadamente)
INSERT IGNORE INTO `booking_services` (`id`, `user`, `workspace_id`, `name`, `thumbnail`, `price`, `duration`, `settings`, `status`, `position`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Barba', NULL, 45.00, 20, NULL, 1, 2, '2026-01-08 02:50:34', '2026-01-08 02:58:10'),
	(2, 1, 1, 'Corte Cabelo 2', NULL, 55.00, 30, NULL, 1, 1, '2026-01-08 02:50:45', '2026-01-08 17:16:15'),
	(3, 1, 4, 'Meu Novo Serviço de Reserva', NULL, 200.00, 60, NULL, 1, 2, '2026-01-08 17:14:07', '2026-01-08 17:14:13'),
	(4, 1, 4, 'Meu Novo Serviço de Reserva', NULL, 200.00, 60, NULL, 1, 1, '2026-01-08 17:14:08', '2026-01-08 17:14:13');

-- Copiando estrutura para tabela linkbiotop.booking_working_breaks
CREATE TABLE IF NOT EXISTS `booking_working_breaks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_working_breaks_workspace_id_index` (`workspace_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.booking_working_breaks: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `price_type` int NOT NULL DEFAULT '1',
  `price` double(16,2) DEFAULT NULL,
  `price_pwyw` longtext COLLATE utf8mb4_unicode_ci,
  `compare_price` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_level` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `course_includes` longtext COLLATE utf8mb4_unicode_ci,
  `course_duration` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_expiry_type` int NOT NULL DEFAULT '1',
  `course_expiry` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` longtext COLLATE utf8mb4_unicode_ci,
  `banner` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `courses_workspace_id_index` (`workspace_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.courses: ~1 rows (aproximadamente)
INSERT IGNORE INTO `courses` (`id`, `user`, `workspace_id`, `name`, `status`, `price_type`, `price`, `price_pwyw`, `compare_price`, `course_level`, `settings`, `course_includes`, `course_duration`, `course_expiry_type`, `course_expiry`, `tags`, `banner`, `description`, `position`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Teste', 1, 1, 50.00, NULL, NULL, '["beginner"]', NULL, '["You will learn how to be code","Free and easy to use"]', NULL, 0, NULL, NULL, '{"type":"upload","upload":"uFAXP90bSa9yKZCEoxK1SvlDUAxS8fuik0NZEtbT.jpg","link":null,"solid_color":"#000"}', '<p>asdsad sad sad sad sadsad</p>', 0, '2026-01-08 03:10:59', '2026-01-08 03:10:59');

-- Copiando estrutura para tabela linkbiotop.courses_enrollments
CREATE TABLE IF NOT EXISTS `courses_enrollments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `payee_user_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  `lesson_taken` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.courses_enrollments: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.courses_lesson
CREATE TABLE IF NOT EXISTS `courses_lesson` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `course_id` int DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `lesson_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '1',
  `lesson_duration` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lesson_data` longtext COLLATE utf8mb4_unicode_ci,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.courses_lesson: ~0 rows (aproximadamente)
INSERT IGNORE INTO `courses_lesson` (`id`, `user`, `course_id`, `name`, `description`, `lesson_type`, `status`, `lesson_duration`, `lesson_data`, `settings`, `position`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'asdsad', 'asdsads', 'video', 1, '30 Min', '{"type":"youtube","link":"https:\\/\\/www.youtube.com\\/watch?v=Xqq-d4lUfyc","is_iframe":false,"thumbnail":"https:\\/\\/img.youtube.com\\/vi\\/Xqq-d4lUfyc\\/maxresdefault.jpg"}', NULL, 0, '2026-01-08 03:12:05', '2026-01-08 03:12:05');

-- Copiando estrutura para tabela linkbiotop.courses_order
CREATE TABLE IF NOT EXISTS `courses_order` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `payee_user_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(16,2) DEFAULT NULL,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.courses_order: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.courses_reviews
CREATE TABLE IF NOT EXISTS `courses_reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `reviewer_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  `rating` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.courses_reviews: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.docs_categories
CREATE TABLE IF NOT EXISTS `docs_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media` longtext COLLATE utf8mb4_unicode_ci,
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.docs_categories: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.docs_guides
CREATE TABLE IF NOT EXISTS `docs_guides` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `docs_category` int DEFAULT NULL,
  `media` longtext COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.docs_guides: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.domains
CREATE TABLE IF NOT EXISTS `domains` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int DEFAULT NULL,
  `workspace_id` bigint unsigned NOT NULL,
  `is_active` int NOT NULL DEFAULT '0',
  `scheme` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `host` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `domains_workspace_id_index` (`workspace_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.domains: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.elementdb
CREATE TABLE IF NOT EXISTS `elementdb` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `element` int DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `database` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.elementdb: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.elements
CREATE TABLE IF NOT EXISTS `elements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `element` longtext COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `elements_slug_unique` (`slug`),
  KEY `elements_workspace_id_index` (`workspace_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.elements: ~2 rows (aproximadamente)
INSERT IGNORE INTO `elements` (`id`, `user`, `workspace_id`, `slug`, `name`, `thumbnail`, `element`, `content`, `settings`, `position`, `created_at`, `updated_at`) VALUES
	(1, 1, 4, 'SFRG', 'Contato', NULL, 'contact_me', '{"description":"sadsadsadsad"}', NULL, 0, '2026-01-08 22:56:04', '2026-01-08 22:56:04');

-- Copiando estrutura para tabela linkbiotop.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.failed_jobs: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.highlights
CREATE TABLE IF NOT EXISTS `highlights` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned DEFAULT NULL,
  `thumbnail` longtext COLLATE utf8mb4_unicode_ci,
  `is_element` int DEFAULT NULL,
  `element` int DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `highlights_workspace_id_index` (`workspace_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.highlights: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.jobs: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.linker
CREATE TABLE IF NOT EXISTS `linker` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.linker: ~0 rows (aproximadamente)
INSERT IGNORE INTO `linker` (`id`, `url`, `slug`, `created_at`, `updated_at`, `user`) VALUES
	(1, 'mailto: adrianowebm@gmail.com', 'VUtSV', '2026-01-08 19:02:00', '2026-01-08 19:02:00', 1),
	(2, 'http://linkbiotop.test/', 'gGZYz', '2026-01-08 19:56:40', '2026-01-08 19:56:40', 1);

-- Copiando estrutura para tabela linkbiotop.linker_track
CREATE TABLE IF NOT EXISTS `linker_track` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `linker` int DEFAULT NULL,
  `user` int DEFAULT NULL,
  `session` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking` longtext COLLATE utf8mb4_unicode_ci,
  `views` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.linker_track: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.memberships
CREATE TABLE IF NOT EXISTS `memberships` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `workspace_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `billing_cycle` enum('monthly','yearly','lifetime') COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` json DEFAULT NULL,
  `limits` json DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `memberships_user_id_index` (`user_id`),
  KEY `memberships_workspace_id_index` (`workspace_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.memberships: ~1 rows (aproximadamente)
INSERT IGNORE INTO `memberships` (`id`, `user_id`, `workspace_id`, `name`, `description`, `price`, `billing_cycle`, `permissions`, `limits`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Teste', '<p>sad sad sasad sdsd sads dsa sad s</p>', 50.00, '', NULL, NULL, 'active', '2026-01-08 19:51:17', '2026-01-08 19:51:17');

-- Copiando estrutura para tabela linkbiotop.membership_subscriptions
CREATE TABLE IF NOT EXISTS `membership_subscriptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `workspace_id` bigint unsigned NOT NULL,
  `membership_id` bigint unsigned NOT NULL,
  `contact_id` bigint unsigned NOT NULL,
  `payment_status` enum('active','pending','cancelled','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `started_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `last_payment_at` timestamp NULL DEFAULT NULL,
  `next_payment_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membership_subscriptions_workspace_id_index` (`workspace_id`),
  KEY `membership_subscriptions_membership_id_index` (`membership_id`),
  KEY `membership_subscriptions_contact_id_index` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.membership_subscriptions: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.migrations: ~27 rows (aproximadamente)
INSERT IGNORE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2021_12_19_123324_booking', 1),
	(2, '2021_12_19_204459_courses', 2),
	(3, '2021_12_19_123324_shop', 3),
	(4, '2014_10_12_000000_create_users_table', 4),
	(5, '2014_10_12_100000_create_password_resets_table', 4),
	(6, '2019_08_19_000000_create_failed_jobs_table', 4),
	(7, '2021_05_27_101636_tables', 4),
	(8, '2021_05_27_101700_updates', 4),
	(9, '2021_07_09_085122_create_sessions_table', 4),
	(10, '2021_10_01_184643_create_jobs_table', 4),
	(11, '2026_01_07_000000_create_pages_table', 5),
	(12, '2026_01_07_000001_create_workspaces_table', 6),
	(13, '2026_01_07_000002_add_workspace_id_to_content_tables', 7),
	(14, '2025_01_15_000000_add_deleted_at_to_users_table', 8),
	(15, '2025_01_15_000001_create_user_backups_table', 8),
	(16, '2026_01_07_000003_add_workspace_id_to_domains_table', 9),
	(17, '2026_01_07_000004_hash_existing_api_tokens', 10),
	(18, '2026_01_07_000005_add_workspace_id_to_booking_tables', 11),
	(19, '2026_01_08_000001_create_audience_contacts_table', 12),
	(20, '2026_01_08_000002_create_audience_interactions_table', 12),
	(21, '2026_01_08_000003_add_guest_fields_to_booking_appointments_table', 13),
	(22, '2026_01_08_150305_create_audience_tables', 14),
	(23, '2026_01_08_163000_create_membership_tables', 15),
	(24, '2026_01_08_191628_alter_memberships_tables_to_match_schema', 16),
	(25, '2026_01_08_191500_alter_memberships_tables_to_match_schema', 17),
	(26, '2026_01_08_195202_add_workspace_id_to_shop_tables', 18),
	(27, '2026_01_08_195203_add_workspace_id_to_course_tables', 18),
	(28, '2026_01_08_195251_add_workspace_id_to_course_tables', 18),
	(29, '2026_01_08_195523_add_workspace_id_to_analytics_tables', 19),
	(31, '2026_01_08_195525_add_workspace_id_to_domains_table', 20),
	(32, '2026_01_08_205000_add_workspace_settings_columns', 21),
	(33, '2026_01_08_224252_add_google2fa_columns_to_users_table', 22);

-- Copiando estrutura para tabela linkbiotop.pages
CREATE TABLE IF NOT EXISTS `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'internal',
  `status` int NOT NULL DEFAULT '1',
  `category` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `total_views` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.pages: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.password_resets: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.payments_spv
CREATE TABLE IF NOT EXISTS `payments_spv` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sxref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `is_paid` int NOT NULL DEFAULT '0',
  `price` double(16,2) DEFAULT NULL,
  `method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `callback` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keys` longtext COLLATE utf8mb4_unicode_ci,
  `meta` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.payments_spv: ~0 rows (aproximadamente)
INSERT IGNORE INTO `payments_spv` (`id`, `sxref`, `email`, `currency`, `status`, `is_paid`, `price`, `method`, `method_ref`, `callback`, `keys`, `meta`, `created_at`, `updated_at`) VALUES
	(1, 'wj_1767879056695fb190ec5c2', 'grupoamv@outlook.com', NULL, 0, 0, 50.00, NULL, NULL, 'http://linkbiotop.test/adriano/shop/bag/checkout/callback?sxref=wj_1767879056695fb190ec5c2', NULL, '{"bio_id":1,"item":{"name":"1 Produtos","description":"Produto(s) comprado(s) em 1 em Adriano"},"cart":{"52f361000e92d21cdfc8c2decbac6a33":{"id":"52f361000e92d21cdfc8c2decbac6a33","name":"Teste","price":50,"quantity":"1","attributes":{"product_id":1,"options":[],"membership":{"status":false,"type":null,"expire":false}},"conditions":[]}},"shipping":[],"payee_id":null,"shipping_location":"No Shipping","products":[1]}', '2026-01-08 16:30:56', '2026-01-08 16:30:56');

-- Copiando estrutura para tabela linkbiotop.payments_spv_history
CREATE TABLE IF NOT EXISTS `payments_spv_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `spv_id` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_data` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.payments_spv_history: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.pending_plan
CREATE TABLE IF NOT EXISTS `pending_plan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan` int DEFAULT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` longtext COLLATE utf8mb4_unicode_ci,
  `method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bank',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.pending_plan: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.pixels
CREATE TABLE IF NOT EXISTS `pixels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `pixel_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pixel_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_workspace_id` (`workspace_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.pixels: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.plans
CREATE TABLE IF NOT EXISTS `plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `price` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `defaults` int NOT NULL DEFAULT '0',
  `price_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'price',
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.plans: ~3 rows (aproximadamente)
INSERT IGNORE INTO `plans` (`id`, `name`, `slug`, `status`, `price`, `settings`, `extra`, `defaults`, `price_type`, `position`, `created_at`, `updated_at`) VALUES
	(1, 'Gratuito', NULL, '1', '{"monthly":null,"annually":null,"trial_duration":null}', '{"ads":"0","qrcode":"1","pixel_codes":"0","social":"1","add_to_head":"0","custom_domain":"0","seo":"1","verified":"0","api":"0","branding":"0","customize":"0","support":"0","pwa":"0","pwa_messaging":"0","block_course":"0","block_shop":"0","block_booking":"0","blocks_limit":"5","workspaces_limit":"1","pixel_limit":"1"}', '{"description":"Ideal para come\\u00e7ar. Crie sua p\\u00e1gina de links em poucos minutos com recursos essenciais e design simples. Perfeito para quem quer divulgar links sem custo.","featured":0}', 1, 'free', 0, '2026-01-07 23:43:23', '2026-01-07 23:47:37'),
	(2, 'Pro', NULL, '1', '{"monthly":"39.90","annually":"29.90","trial_duration":null}', '{"ads":"1","qrcode":"1","pixel_codes":"1","social":"1","add_to_head":"1","custom_domain":"1","seo":"1","verified":"1","api":"1","branding":"1","customize":"1","support":"1","pwa":"1","pwa_messaging":"1","block_course":"1","block_shop":"1","block_booking":"1","blocks_limit":"100","workspaces_limit":"100","pixel_limit":"10"}', '{"description":"Perfeito para criadores e neg\\u00f3cios. Desbloqueie dom\\u00ednio pr\\u00f3prio, integra\\u00e7\\u00f5es, automa\\u00e7\\u00f5es e ferramentas avan\\u00e7adas para crescer online.","featured":"0"}', 0, 'paid', 0, '2026-01-07 23:46:29', '2026-01-07 23:48:02'),
	(3, 'Starter', NULL, '1', '{"monthly":"18.90","annually":"14.90","trial_duration":null}', '{"ads":"1","qrcode":"1","pixel_codes":"1","social":"1","add_to_head":"1","custom_domain":"1","seo":"1","verified":"1","api":"1","branding":"1","customize":"1","support":"1","pwa":"1","pwa_messaging":"1","block_course":"1","block_shop":"1","block_booking":"1","blocks_limit":"50","workspaces_limit":"3","pixel_limit":"3"}', '{"description":"Plano ideal para quem deseja personalizar seu LinkBio com mais estilo e aumentar o engajamento. Inclui recursos de branding, verifica\\u00e7\\u00e3o e ferramentas iniciais de otimiza\\u00e7\\u00e3o.","featured":"1"}', 0, 'paid', 0, '2026-01-07 23:47:37', '2026-01-07 23:47:37');

-- Copiando estrutura para tabela linkbiotop.plans_history
CREATE TABLE IF NOT EXISTS `plans_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `plan_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.plans_history: ~2 rows (aproximadamente)
INSERT IGNORE INTO `plans_history` (`id`, `plan_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, '2026-01-07 23:49:00', '2026-01-07 23:49:00'),
	(2, 1, 1, '2026-01-07 23:55:41', '2026-01-07 23:55:41'),
	(3, 2, 1, '2026-01-08 00:06:46', '2026-01-08 00:06:46'),
	(4, 1, 2, '2026-01-08 00:39:46', '2026-01-08 00:39:46');

-- Copiando estrutura para tabela linkbiotop.plans_users
CREATE TABLE IF NOT EXISTS `plans_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `plan_id` int NOT NULL,
  `user_id` int NOT NULL,
  `plan_due` datetime DEFAULT NULL,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.plans_users: ~2 rows (aproximadamente)
INSERT IGNORE INTO `plans_users` (`id`, `plan_id`, `user_id`, `plan_due`, `settings`, `created_at`, `updated_at`) VALUES
	(3, 2, 1, '2051-01-20 00:00:00', NULL, '2026-01-08 00:06:46', '2026-01-08 00:06:46'),
	(4, 1, 2, NULL, NULL, '2026-01-08 00:39:46', '2026-01-08 00:39:46');

-- Copiando estrutura para tabela linkbiotop.plan_payments
CREATE TABLE IF NOT EXISTS `plan_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plan_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(16,2) DEFAULT NULL,
  `gateway` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.plan_payments: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `price_type` int NOT NULL DEFAULT '1',
  `price` double(16,2) DEFAULT NULL,
  `price_pwyw` longtext COLLATE utf8mb4_unicode_ci,
  `comparePrice` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enableOptions` int NOT NULL DEFAULT '0',
  `isDeal` int NOT NULL DEFAULT '0',
  `dealPrice` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dealEnds` datetime DEFAULT NULL,
  `enableBid` int NOT NULL DEFAULT '0',
  `stock` int DEFAULT NULL,
  `stock_settings` longtext COLLATE utf8mb4_unicode_ci,
  `productType` int NOT NULL DEFAULT '0',
  `banner` longtext COLLATE utf8mb4_unicode_ci,
  `media` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `ribbon` longtext COLLATE utf8mb4_unicode_ci,
  `seo` longtext COLLATE utf8mb4_unicode_ci,
  `api` longtext COLLATE utf8mb4_unicode_ci,
  `files` longtext COLLATE utf8mb4_unicode_ci,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_workspace_id` (`workspace_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.products: ~3 rows (aproximadamente)
INSERT IGNORE INTO `products` (`id`, `user`, `workspace_id`, `name`, `slug`, `status`, `price_type`, `price`, `price_pwyw`, `comparePrice`, `enableOptions`, `isDeal`, `dealPrice`, `dealEnds`, `enableBid`, `stock`, `stock_settings`, `productType`, `banner`, `media`, `description`, `ribbon`, `seo`, `api`, `files`, `extra`, `position`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Teste workspace de teste criado la', NULL, 1, 1, 50.00, NULL, NULL, 0, 0, NULL, NULL, 0, 5, '{"enasble":"0","enable":"1","sku":"5595"}', 0, '{"type":"upload","upload":"gDCCqtH1puDFcaNsndRsn6lRAUkIa4uruCdHFqGF.jpg","link":null,"solid_color":"#000"}', NULL, '<p>asdsa dsadsadsa</p>', NULL, '{"enable":"0","page_name":null,"page_description":null}', NULL, '[]', '{"price_monthly":null,"price_annual":null}', 0, '2026-01-08 16:30:06', '2026-01-08 23:10:28'),
	(2, 1, 0, 'Teste produto teste', NULL, 1, 1, 120.00, NULL, NULL, 0, 0, NULL, NULL, 0, 10, '{"enasble":"0","enable":"1","sku":"5599"}', 0, '{"type":"upload","upload":"VEje9GhkSf2qCPVvMqA0zJuberMKTXMhzxJ62o6b.png","link":null,"solid_color":"#000"}', NULL, 'sadsadsadsasadsadsa', NULL, '{"enable":"0","page_name":null,"page_description":null}', NULL, '[]', '{"price_monthly":null,"price_annual":null}', 0, '2026-01-08 23:35:37', '2026-01-08 23:35:37'),
	(3, 1, 4, 'asdsadsa', NULL, 1, 1, 120.00, NULL, NULL, 0, 0, NULL, NULL, 0, NULL, '{"enasble":"0","sku":null}', 0, '{"type":"upload","upload":"izJBQGC74W9w00k2UkPnqswiKIOhqEzuSWbr2BSF.png","link":null,"solid_color":"#000"}', NULL, 'dsads adsa dsad sa d', NULL, '{"enable":"0","page_name":null,"page_description":null}', NULL, '[]', '{"price_monthly":null,"price_annual":null}', 0, '2026-01-08 23:39:33', '2026-01-08 23:39:33');

-- Copiando estrutura para tabela linkbiotop.product_options
CREATE TABLE IF NOT EXISTS `product_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned NOT NULL,
  `product_id` int NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(16,2) DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `files` longtext COLLATE utf8mb4_unicode_ci,
  `position` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_workspace_id` (`workspace_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.product_options: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.product_order
CREATE TABLE IF NOT EXISTS `product_order` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned NOT NULL,
  `payee_user_id` int DEFAULT NULL,
  `details` longtext COLLATE utf8mb4_unicode_ci,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double(16,2) DEFAULT NULL,
  `is_deal` int NOT NULL DEFAULT '0',
  `deal_discount` int DEFAULT NULL,
  `products` longtext COLLATE utf8mb4_unicode_ci,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_workspace_id` (`workspace_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.product_order: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.product_order_note
CREATE TABLE IF NOT EXISTS `product_order_note` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `tid` int NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.product_order_note: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.product_order_timeline
CREATE TABLE IF NOT EXISTS `product_order_timeline` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `tid` int NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.product_order_timeline: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.product_reviews
CREATE TABLE IF NOT EXISTS `product_reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `workspace_id` bigint unsigned NOT NULL,
  `reviewer_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `rating` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_workspace_id` (`workspace_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.product_reviews: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.product_shipping
CREATE TABLE IF NOT EXISTS `product_shipping` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `country_iso` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locations` longtext COLLATE utf8mb4_unicode_ci,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.product_shipping: ~0 rows (aproximadamente)
INSERT IGNORE INTO `product_shipping` (`id`, `user`, `country_iso`, `country`, `locations`, `extra`, `created_at`, `updated_at`) VALUES
	(1, 1, 'BR', 'Brazil', NULL, NULL, '2026-01-08 19:48:20', '2026-01-08 19:48:20');

-- Copiando estrutura para tabela linkbiotop.product_shipping_locations
CREATE TABLE IF NOT EXISTS `product_shipping_locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `shipping_id` int DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` double(16,2) DEFAULT NULL,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.product_shipping_locations: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.sandy_embed_store
CREATE TABLE IF NOT EXISTS `sandy_embed_store` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.sandy_embed_store: ~0 rows (aproximadamente)
INSERT IGNORE INTO `sandy_embed_store` (`id`, `link`, `data`, `created_at`, `updated_at`) VALUES
	(1, 'http://linkbiotop.test', '{"w":"linkbiotop.test","fw":"http:\\/\\/linkbiotop.test\\/","t":"LinkBio.top","f":"http:\\/\\/linkbiotop.test\\/assets\\/image\\/others\\/default-favicon.png"}', '2026-01-08 19:07:41', '2026-01-08 19:07:41');

-- Copiando estrutura para tabela linkbiotop.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `user_bio` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tracking` longtext COLLATE utf8mb4_unicode_ci,
  `last_activity` int NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.sessions: ~4 rows (aproximadamente)
INSERT IGNORE INTO `sessions` (`id`, `user_id`, `user_bio`, `ip_address`, `user_agent`, `payload`, `tracking`, `last_activity`) VALUES
	('847fIGbH6yMGBSKM07ZUmpUim17iUG43hLK9EAAE', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaGtKU2VwTGJjNGRSTUtZejNFWWwwMVJYbTA0TnA3MWVSbEc0Y3RRWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9saW5rYmlvdG9wLnRlc3QvYXV0aC8yZmEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjExOiIyZmE6dXNlcjppZCI7aToxO30=', NULL, 1768240787),
	('eSCNlUefnWkhlEfLj91iowjCiMErK5Zz2UiHP6uE', NULL, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidXphSmUwa2hlbEx0MUZ2OW5hU2RlZThTRjhkNnczRVN1Sk1GaXEwVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9saW5rYmlvdG9wLnRlc3QvdGVzdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjEyOiIxX2NhcnRfaXRlbXMiO086MzI6IkRhcnJ5bGRlY29kZVxDYXJ0XENhcnRDb2xsZWN0aW9uIjoyOntzOjg6IgAqAGl0ZW1zIjthOjE6e3M6MzI6IjUyZjM2MTAwMGU5MmQyMWNkZmM4YzJkZWNiYWM2YTMzIjtPOjMyOiJEYXJyeWxkZWNvZGVcQ2FydFxJdGVtQ29sbGVjdGlvbiI6Mzp7czo4OiIAKgBpdGVtcyI7YTo3OntzOjI6ImlkIjtzOjMyOiI1MmYzNjEwMDBlOTJkMjFjZGZjOGMyZGVjYmFjNmEzMyI7czo0OiJuYW1lIjtzOjU6IlRlc3RlIjtzOjU6InByaWNlIjtpOjUwO3M6ODoicXVhbnRpdHkiO3M6MToiMSI7czoxMDoiYXR0cmlidXRlcyI7Tzo0MToiRGFycnlsZGVjb2RlXENhcnRcSXRlbUF0dHJpYnV0ZUNvbGxlY3Rpb24iOjI6e3M6ODoiACoAaXRlbXMiO2E6Mzp7czoxMDoicHJvZHVjdF9pZCI7aToxO3M6Nzoib3B0aW9ucyI7YTowOnt9czoxMDoibWVtYmVyc2hpcCI7YTozOntzOjY6InN0YXR1cyI7YjowO3M6NDoidHlwZSI7TjtzOjY6ImV4cGlyZSI7YjowO319czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO31zOjEwOiJjb25kaXRpb25zIjthOjA6e31zOjE1OiJhc3NvY2lhdGVkTW9kZWwiO086MzI6IlNhbmR5XEJsb2Nrc1xzaG9wXE1vZGVsc1xQcm9kdWN0IjozMDp7czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJteXNxbCI7czo4OiIAKgB0YWJsZSI7czo4OiJwcm9kdWN0cyI7czoxMzoiACoAcHJpbWFyeUtleSI7czoyOiJpZCI7czoxMDoiACoAa2V5VHlwZSI7czozOiJpbnQiO3M6MTI6ImluY3JlbWVudGluZyI7YjoxO3M6NzoiACoAd2l0aCI7YTowOnt9czoxMjoiACoAd2l0aENvdW50IjthOjA6e31zOjE5OiJwcmV2ZW50c0xhenlMb2FkaW5nIjtiOjA7czoxMDoiACoAcGVyUGFnZSI7aToxNTtzOjY6ImV4aXN0cyI7YjoxO3M6MTg6Indhc1JlY2VudGx5Q3JlYXRlZCI7YjowO3M6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjI4OntzOjI6ImlkIjtpOjE7czo0OiJ1c2VyIjtpOjE7czo0OiJuYW1lIjtzOjU6IlRlc3RlIjtzOjQ6InNsdWciO047czo2OiJzdGF0dXMiO2k6MTtzOjEwOiJwcmljZV90eXBlIjtpOjE7czo1OiJwcmljZSI7ZDo1MDtzOjEwOiJwcmljZV9wd3l3IjtOO3M6MTI6ImNvbXBhcmVQcmljZSI7TjtzOjEzOiJlbmFibGVPcHRpb25zIjtpOjA7czo2OiJpc0RlYWwiO2k6MDtzOjk6ImRlYWxQcmljZSI7TjtzOjg6ImRlYWxFbmRzIjtOO3M6OToiZW5hYmxlQmlkIjtpOjA7czo1OiJzdG9jayI7aTo1O3M6MTQ6InN0b2NrX3NldHRpbmdzIjtzOjQxOiJ7ImVuYXNibGUiOiIwIiwiZW5hYmxlIjoiMSIsInNrdSI6IjU1OTUifSI7czoxMToicHJvZHVjdFR5cGUiO2k6MDtzOjY6ImJhbm5lciI7czoxMDY6InsidHlwZSI6InVwbG9hZCIsInVwbG9hZCI6ImdEQ0NxdEgxcHVERmNhTnNuZFJzbjZsUkFVa0lhNHVydUNkSEZxR0YuanBnIiwibGluayI6bnVsbCwic29saWRfY29sb3IiOiIjMDAwIn0iO3M6NToibWVkaWEiO047czoxMToiZGVzY3JpcHRpb24iO3M6MTU6ImFzZHNhIGRzYWRzYWRzYSI7czo2OiJyaWJib24iO047czozOiJzZW8iO3M6NTU6InsiZW5hYmxlIjoiMCIsInBhZ2VfbmFtZSI6bnVsbCwicGFnZV9kZXNjcmlwdGlvbiI6bnVsbH0iO3M6MzoiYXBpIjtOO3M6NToiZmlsZXMiO3M6MjoiW10iO3M6NToiZXh0cmEiO3M6NDI6InsicHJpY2VfbW9udGhseSI6bnVsbCwicHJpY2VfYW5udWFsIjpudWxsfSI7czo4OiJwb3NpdGlvbiI7aTowO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMjYtMDEtMDggMTM6MzA6MDYiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMjYtMDEtMDggMTM6MzA6MDYiO31zOjExOiIAKgBvcmlnaW5hbCI7YToyODp7czoyOiJpZCI7aToxO3M6NDoidXNlciI7aToxO3M6NDoibmFtZSI7czo1OiJUZXN0ZSI7czo0OiJzbHVnIjtOO3M6Njoic3RhdHVzIjtpOjE7czoxMDoicHJpY2VfdHlwZSI7aToxO3M6NToicHJpY2UiO2Q6NTA7czoxMDoicHJpY2VfcHd5dyI7TjtzOjEyOiJjb21wYXJlUHJpY2UiO047czoxMzoiZW5hYmxlT3B0aW9ucyI7aTowO3M6NjoiaXNEZWFsIjtpOjA7czo5OiJkZWFsUHJpY2UiO047czo4OiJkZWFsRW5kcyI7TjtzOjk6ImVuYWJsZUJpZCI7aTowO3M6NToic3RvY2siO2k6NTtzOjE0OiJzdG9ja19zZXR0aW5ncyI7czo0MToieyJlbmFzYmxlIjoiMCIsImVuYWJsZSI6IjEiLCJza3UiOiI1NTk1In0iO3M6MTE6InByb2R1Y3RUeXBlIjtpOjA7czo2OiJiYW5uZXIiO3M6MTA2OiJ7InR5cGUiOiJ1cGxvYWQiLCJ1cGxvYWQiOiJnRENDcXRIMXB1REZjYU5zbmRSc242bFJBVWtJYTR1cnVDZEhGcUdGLmpwZyIsImxpbmsiOm51bGwsInNvbGlkX2NvbG9yIjoiIzAwMCJ9IjtzOjU6Im1lZGlhIjtOO3M6MTE6ImRlc2NyaXB0aW9uIjtzOjE1OiJhc2RzYSBkc2Fkc2Fkc2EiO3M6NjoicmliYm9uIjtOO3M6Mzoic2VvIjtzOjU1OiJ7ImVuYWJsZSI6IjAiLCJwYWdlX25hbWUiOm51bGwsInBhZ2VfZGVzY3JpcHRpb24iOm51bGx9IjtzOjM6ImFwaSI7TjtzOjU6ImZpbGVzIjtzOjI6IltdIjtzOjU6ImV4dHJhIjtzOjQyOiJ7InByaWNlX21vbnRobHkiOm51bGwsInByaWNlX2FubnVhbCI6bnVsbH0iO3M6ODoicG9zaXRpb24iO2k6MDtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDI2LTAxLTA4IDEzOjMwOjA2IjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDI2LTAxLTA4IDEzOjMwOjA2Ijt9czoxMDoiACoAY2hhbmdlcyI7YTowOnt9czo4OiIAKgBjYXN0cyI7YToxNjp7czo0OiJ1c2VyIjtzOjM6ImludCI7czo2OiJzdGF0dXMiO3M6MzoiaW50IjtzOjEwOiJwcmljZV90eXBlIjtzOjM6ImludCI7czo1OiJwcmljZSI7czo1OiJmbG9hdCI7czoxMzoiZW5hYmxlT3B0aW9ucyI7czozOiJpbnQiO3M6NjoiaXNEZWFsIjtzOjM6ImludCI7czo5OiJlbmFibGVCaWQiO3M6MzoiaW50IjtzOjU6InN0b2NrIjtzOjM6ImludCI7czoxMToicHJvZHVjdFR5cGUiO3M6MzoiaW50IjtzOjg6InBvc2l0aW9uIjtzOjM6ImludCI7czo1OiJtZWRpYSI7czo1OiJhcnJheSI7czo1OiJleHRyYSI7czo1OiJhcnJheSI7czo2OiJiYW5uZXIiO3M6NToiYXJyYXkiO3M6MTQ6InN0b2NrX3NldHRpbmdzIjtzOjU6ImFycmF5IjtzOjM6InNlbyI7czo1OiJhcnJheSI7czo1OiJmaWxlcyI7czo1OiJhcnJheSI7fXM6MTc6IgAqAGNsYXNzQ2FzdENhY2hlIjthOjA6e31zOjIxOiIAKgBhdHRyaWJ1dGVDYXN0Q2FjaGUiO2E6MDp7fXM6ODoiACoAZGF0ZXMiO2E6MTp7aTowO3M6ODoiZGVhbEVuZHMiO31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MDp7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6MDp7fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6MTA6InRpbWVzdGFtcHMiO2I6MTtzOjk6IgAqAGhpZGRlbiI7YTowOnt9czoxMDoiACoAdmlzaWJsZSI7YTowOnt9czoxMToiACoAZmlsbGFibGUiO2E6MjY6e2k6MDtzOjQ6InVzZXIiO2k6MTtzOjQ6Im5hbWUiO2k6MjtzOjQ6InNsdWciO2k6MztzOjY6InN0YXR1cyI7aTo0O3M6NToicHJpY2UiO2k6NTtzOjEwOiJlbmFibGVQd3l3IjtpOjY7czoxODoiZW5hYmxlQ29tcGFyZXByaWNlIjtpOjc7czoxMjoiY29tcGFyZVByaWNlIjtpOjg7czoxMzoiZW5hYmxlT3B0aW9ucyI7aTo5O3M6NjoiaXNEZWFsIjtpOjEwO3M6OToiZGVhbFByaWNlIjtpOjExO3M6ODoiZGVhbEVuZHMiO2k6MTI7czo5OiJlbmFibGVCaWQiO2k6MTM7czo1OiJzdG9jayI7aToxNDtzOjExOiJwcm9kdWN0VHlwZSI7aToxNTtzOjU6Im1lZGlhIjtpOjE2O3M6MTE6ImRlc2NyaXB0aW9uIjtpOjE3O3M6MTY6InN0b2NrX21hbmFnZW1lbnQiO2k6MTg7czo4OiJwb3N0ZWRCeSI7aToxOTtzOjk6InVwZGF0ZWRCeSI7aToyMDtzOjY6InJpYmJvbiI7aToyMTtzOjM6InNlbyI7aToyMjtzOjM6ImFwaSI7aToyMztzOjU6ImZpbGVzIjtpOjI0O3M6NToiZXh0cmEiO2k6MjU7czo4OiJwb3NpdGlvbiI7fXM6MTA6IgAqAGd1YXJkZWQiO2E6MTp7aTowO3M6MToiKiI7fX19czoyODoiACoAZXNjYXBlV2hlbkNhc3RpbmdUb1N0cmluZyI7YjowO3M6OToiACoAY29uZmlnIjthOjY6e3M6MTQ6ImZvcm1hdF9udW1iZXJzIjtiOjA7czo4OiJkZWNpbWFscyI7aTowO3M6OToiZGVjX3BvaW50IjtzOjE6Ii4iO3M6MTM6InRob3VzYW5kc19zZXAiO3M6MToiLCI7czo3OiJzdG9yYWdlIjtOO3M6NjoiZXZlbnRzIjtOO319fXM6Mjg6IgAqAGVzY2FwZVdoZW5DYXN0aW5nVG9TdHJpbmciO2I6MDt9fQ==', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 1767915584),
	('GI3HleQ41e6zbpjoS0Jr0nCGRUd8wLTB3hAnlQXh', 1, 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibjJ4Q3Q4ckxmM2pLbzNmbDNjYlR2M2hkVDBTZkwyOW1QVlRkR21TTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9saW5rYmlvdG9wLnRlc3QvdGVzdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTk6ImFjdGl2ZV93b3Jrc3BhY2VfaWQiO2k6NDt9', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 1767916484),
	('k2bgspS4efWROgfBDnpmYb4RZ3EEywxIoRyi0YuY', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidzZrS2l3enBzQXhwelZqbEVZN3pLRHkyVkdaZmpzdXFwRDA3QlhIMSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cDovL2xpbmtiaW90b3AudGVzdC9taXgvc2V0dGluZ3MvdGhlbWUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0MToiaHR0cDovL2xpbmtiaW90b3AudGVzdC9taXgvc2V0dGluZ3MvdGhlbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', NULL, 1767908835);

-- Copiando estrutura para tabela linkbiotop.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.settings: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.support_conversations
CREATE TABLE IF NOT EXISTS `support_conversations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `topic` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.support_conversations: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.support_messages
CREATE TABLE IF NOT EXISTS `support_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `conversation_id` int NOT NULL,
  `user_id` int NOT NULL,
  `from` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `from_id` int DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `data` longtext COLLATE utf8mb4_unicode_ci,
  `seen` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.support_messages: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.tip_collection
CREATE TABLE IF NOT EXISTS `tip_collection` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `payee_user_id` int DEFAULT NULL,
  `element_id` int DEFAULT NULL,
  `is_private` int NOT NULL DEFAULT '0',
  `amount` double(16,2) DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.tip_collection: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` longtext COLLATE utf8mb4_unicode_ci,
  `social` longtext COLLATE utf8mb4_unicode_ci,
  `background` longtext COLLATE utf8mb4_unicode_ci,
  `background_settings` longtext COLLATE utf8mb4_unicode_ci,
  `booking` longtext COLLATE utf8mb4_unicode_ci,
  `buttons` longtext COLLATE utf8mb4_unicode_ci,
  `font` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` longtext COLLATE utf8mb4_unicode_ci,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `payments` longtext COLLATE utf8mb4_unicode_ci,
  `integrations` longtext COLLATE utf8mb4_unicode_ci,
  `store` longtext COLLATE utf8mb4_unicode_ci,
  `seo` longtext COLLATE utf8mb4_unicode_ci,
  `pwa` longtext COLLATE utf8mb4_unicode_ci,
  `role` int NOT NULL DEFAULT '0',
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_settings` longtext COLLATE utf8mb4_unicode_ci,
  `emailToken` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `hasTrial` int NOT NULL DEFAULT '0',
  `lastActivity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastAgent` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastCountry` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` longtext COLLATE utf8mb4_unicode_ci,
  `api` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google2fa_secret` text COLLATE utf8mb4_unicode_ci,
  `google2fa_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_api_unique` (`api`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.users: ~2 rows (aproximadamente)
INSERT IGNORE INTO `users` (`id`, `name`, `email`, `username`, `bio`, `social`, `background`, `background_settings`, `booking`, `buttons`, `font`, `theme`, `color`, `settings`, `payments`, `integrations`, `store`, `seo`, `pwa`, `role`, `avatar`, `avatar_settings`, `emailToken`, `facebook_id`, `google_id`, `email_verified_at`, `password`, `status`, `hasTrial`, `lastActivity`, `lastAgent`, `lastCountry`, `phone_number`, `api`, `extra`, `remember_token`, `google2fa_secret`, `google2fa_enabled`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Adriano Andrade', 'adrianowebm@gmail.com', 'adriano', 'Click here to add a brief summary about your page to get your audience interested in what you do.', '{"email":"adrianowebm@gmail.com","whatsapp":null,"facebook":null,"instagram":null,"twitter":null,"youtube":null,"linkedin":null,"telegram":null,"snapchat":null,"discord":null,"twitch":null,"pinterest":null,"tiktok":null,"github":null}', NULL, '{"video":{"source":"url","external_url":null,"video":null},"image":{"source":"url","external_url":null,"image":null},"solid":{"color":"#000"},"gradient":{"color_1":"#fff","color_2":"#fff","animate":"0"}}', '{"gallery":["\\/79EJ3tNm3ibUkdbBW509DqjPXPiMMNvZqSLhL0sZ.jpg","\\/BeQDnvbgo1o3mzW8DLl66r37p1oBagszT4CcRFAa.png"],"workhours":{"1":{"enable":"0","from":540,"to":1080},"2":{"enable":"1","from":540,"to":1260},"3":{"enable":"0","from":540,"to":1080},"4":{"enable":"1","from":540,"to":1260},"5":{"enable":"0","from":540,"to":1080},"6":{"enable":"0","from":540,"to":1080},"7":{"enable":"0","from":540,"to":1080}},"title":"Teste","description":"sad sadsdd sad sad","hrs_type":"12","time_interval":"15"}', '[]', NULL, 'magma', '{"button_background":"#00F4FF","button_color":"#000000","text":"#000"}', '{"bio_align":"center","always_dark":"0","remove_branding":"0","verified":"1","banner_or_background":"0"}', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$dFvcV/CDCts7rYVnUCEGd.8gFHN6aqfzkdSndxYNvA0frHIb34Ibi', 1, 0, '2026-01-12 17:59:05', 'Windows', '', NULL, 'ac05cdac17b7e5b6d8b850280eb30c829beefc5b0ed5059763f8280442f97926', NULL, 'wdMaEJyut97gPOg9xLcWuIsbIa4VVBWpSgXcSP7aXvEFzsPiyuGBKcA035Lp', 'H57NG2PAWPOLR7KJ2JHK7EJYUUMJ63HY', 1, '2026-01-07 21:24:39', '2026-01-12 20:59:05', NULL),
	(2, 'Testeb', 'teste@gmail.com', 'testevb_qatn', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$hx0sSYxEjvgcEvba1WPsku/fOyj6eUbhAkzHuObEAb3dKKCMSX2L2', 1, 0, '2026-01-07 22:27:34', 'Windows', '', NULL, NULL, NULL, 'h6aNIrX7Ia2EjkAGbUCnPs6eaiBYPWzciOonb6VJuBIhbtwe9OXdtYGCr6U6', NULL, 0, '2026-01-08 00:34:11', '2026-01-08 01:27:46', '2026-01-08 01:27:46');

-- Copiando estrutura para tabela linkbiotop.user_backups
CREATE TABLE IF NOT EXISTS `user_backups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backup_file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nome do arquivo JSON do backup',
  `backup_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Caminho completo do arquivo de backup',
  `file_size` int DEFAULT NULL COMMENT 'Tamanho do arquivo em bytes',
  `backup_metadata` text COLLATE utf8mb4_unicode_ci COMMENT 'Metadados adicionais em JSON',
  `backup_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` timestamp NOT NULL COMMENT 'Data de expiração do backup (6 meses)',
  `is_restored` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica se o backup foi restaurado',
  `restored_at` timestamp NULL DEFAULT NULL COMMENT 'Data da restauração',
  `restored_by` bigint unsigned DEFAULT NULL COMMENT 'ID do admin que restaurou',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_backups_user_id_index` (`user_id`),
  KEY `user_backups_email_index` (`email`),
  KEY `user_backups_username_index` (`username`),
  KEY `user_backups_backup_date_index` (`backup_date`),
  KEY `user_backups_expires_at_index` (`expires_at`),
  KEY `user_backups_is_restored_index` (`is_restored`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.user_backups: ~0 rows (aproximadamente)
INSERT IGNORE INTO `user_backups` (`id`, `user_id`, `username`, `email`, `name`, `backup_file`, `backup_path`, `file_size`, `backup_metadata`, `backup_date`, `expires_at`, `is_restored`, `restored_at`, `restored_by`, `created_at`, `updated_at`) VALUES
	(1, 2, 'testevb_qatn', 'teste@gmail.com', 'Testeb', 'user_backup_2_1767824866.json', 'D:\\ARQUIVOS\\PROJETOS\\2025\\SITES\\linkbiotop\\storage\\app/backups/users/user_backup_2_1767824866.json', 6323, '{"total_blocks":1,"total_elements":0,"total_workspaces":0,"has_plan":true,"backup_version":"1.0"}', '2026-01-08 01:27:46', '2026-07-08 01:27:46', 0, NULL, NULL, '2026-01-08 01:27:46', '2026-01-08 01:27:46');

-- Copiando estrutura para tabela linkbiotop.user_upload_paths
CREATE TABLE IF NOT EXISTS `user_upload_paths` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int DEFAULT NULL,
  `path` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.user_upload_paths: ~4 rows (aproximadamente)
INSERT IGNORE INTO `user_upload_paths` (`id`, `user`, `path`, `created_at`, `updated_at`) VALUES
	(1, 1, 'media/courses/banner/uFAXP90bSa9yKZCEoxK1SvlDUAxS8fuik0NZEtbT.jpg', '2026-01-08 03:10:59', '2026-01-08 03:10:59'),
	(2, 1, 'media/shop/banner/gDCCqtH1puDFcaNsndRsn6lRAUkIa4uruCdHFqGF.jpg', '2026-01-08 16:30:06', '2026-01-08 16:30:06'),
	(3, 1, 'media/shop/banner/VEje9GhkSf2qCPVvMqA0zJuberMKTXMhzxJ62o6b.png', '2026-01-08 23:35:37', '2026-01-08 23:35:37'),
	(4, 1, 'media/shop/banner/izJBQGC74W9w00k2UkPnqswiKIOhqEzuSWbr2BSF.png', '2026-01-08 23:39:33', '2026-01-08 23:39:33');

-- Copiando estrutura para tabela linkbiotop.visitors
CREATE TABLE IF NOT EXISTS `visitors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int DEFAULT NULL,
  `workspace_id` bigint unsigned DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking` longtext COLLATE utf8mb4_unicode_ci,
  `views` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `visitors_workspace_id_index` (`workspace_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.visitors: ~16 rows (aproximadamente)
INSERT IGNORE INTO `visitors` (`id`, `user`, `workspace_id`, `slug`, `session`, `ip`, `tracking`, `views`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, NULL, '2yAS3ZrWZ5ruRjmKSGUuN1zkJHtPaBSRgNjvnqUF', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 9, '2026-01-07 21:39:41', '2026-01-08 00:26:40'),
	(2, 1, 1, NULL, 'Bb7C3G1NTrpxxtUpGcDY6iXsDe7ln7Kdn3YpUWhh', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 1, '2026-01-07 21:57:49', '2026-01-07 21:57:49'),
	(3, 2, NULL, NULL, 'o9Awd3BaQMIJE4Ui9dOw0QQxF3UJXs7k8mrNDOq5', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 6, '2026-01-08 00:47:49', '2026-01-08 01:25:00'),
	(4, 2, NULL, NULL, 'xkwuhiyHRtqu08q29BqHjcNanA176CZutuTGFqth', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 1, '2026-01-08 01:25:16', '2026-01-08 01:25:16'),
	(5, 1, NULL, NULL, 'rRJ0IsG8jCv49KrhO1OblAW3zRBUdZaqQAArphqu', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 13, '2026-01-08 01:31:18', '2026-01-08 02:13:24'),
	(6, 1, NULL, NULL, 'Gm0VQ5QLj6nxXrtiwm3MsO4WF6kuzCAbQeplml9N', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 34, '2026-01-08 02:53:32', '2026-01-08 03:53:35'),
	(7, 1, NULL, NULL, 'sFe0ciUWgqiSgUTla1YYlZ2qoYLE7MRLVRp9355N', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 2, '2026-01-08 03:36:29', '2026-01-08 03:36:37'),
	(8, 1, NULL, NULL, 'JedpteHwK9qDy7NkDVSzidalX6UWqxMqHTLjlhDZ', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 9, '2026-01-08 04:29:04', '2026-01-08 04:36:43'),
	(9, 1, NULL, NULL, 'E9pwIiiQFArWl0TaQUMcysMAyQxuocCznScFrBK0', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 48, '2026-01-08 15:13:31', '2026-01-08 19:56:05'),
	(10, 1, NULL, NULL, 'eSCNlUefnWkhlEfLj91iowjCiMErK5Zz2UiHP6uE', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 130, '2026-01-08 15:35:51', '2026-01-09 02:39:42'),
	(11, 1, NULL, NULL, 'dtDFJfb3NgqJWL19SOura0IWYf5VTNJY4BSOLtn1', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 1, '2026-01-08 15:59:21', '2026-01-08 15:59:21'),
	(12, 1, NULL, NULL, 'oRdE2jHVjkwKkgol5lIV8yfeiJ1wVF1NnCOD8Sg1', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 1, '2026-01-08 16:55:10', '2026-01-08 16:55:10'),
	(13, 1, NULL, NULL, 'N1aaPSgkHwAdgiqlvNOTDt4PbTf92xb1IZ7y7lKq', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 1, '2026-01-08 17:53:55', '2026-01-08 17:53:55'),
	(14, 1, NULL, NULL, 'mtgK9h3biRnXGzuuXoPH7RSvgNi8xfGwGWXYUevL', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 1, '2026-01-08 19:06:46', '2026-01-08 19:06:46'),
	(15, 1, NULL, NULL, '8uw2we65DAkcDM0jQ7NhOpfv1gddGbpWVNkC71op', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 38, '2026-01-08 22:53:35', '2026-01-09 00:39:41'),
	(16, 1, NULL, NULL, 'GI3HleQ41e6zbpjoS0Jr0nCGRUd8wLTB3hAnlQXh', '127.0.0.1', '{"country":{"iso":"","name":null,"city":null},"agent":{"browser":"Firefox","os":"Windows"}}', 2, '2026-01-09 02:39:35', '2026-01-09 02:54:43');

-- Copiando estrutura para tabela linkbiotop.wallet
CREATE TABLE IF NOT EXISTS `wallet` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `balance` double(16,2) NOT NULL DEFAULT '0.00',
  `default_country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NG',
  `default_currency` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NGN',
  `default_method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `settlement` longtext COLLATE utf8mb4_unicode_ci,
  `pin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `rave_setup` int NOT NULL DEFAULT '0',
  `rave_subaccount` longtext COLLATE utf8mb4_unicode_ci,
  `rave_payout` longtext COLLATE utf8mb4_unicode_ci,
  `stripe_setup` int NOT NULL DEFAULT '0',
  `stripe_info` longtext COLLATE utf8mb4_unicode_ci,
  `wallet_setup` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.wallet: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.wallet_saved_cards
CREATE TABLE IF NOT EXISTS `wallet_saved_cards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_four` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci,
  `extra` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.wallet_saved_cards: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.wallet_settlements
CREATE TABLE IF NOT EXISTS `wallet_settlements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `settlement_id` int DEFAULT NULL,
  `settlement` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.wallet_settlements: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.wallet_transactions
CREATE TABLE IF NOT EXISTS `wallet_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `spv_id` int DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(16,2) DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction` longtext COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.wallet_transactions: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.workspaces
CREATE TABLE IF NOT EXISTS `workspaces` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'My Workspace',
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `is_default` int NOT NULL DEFAULT '0',
  `bio` longtext COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` longtext COLLATE utf8mb4_unicode_ci,
  `background` longtext COLLATE utf8mb4_unicode_ci,
  `background_settings` longtext COLLATE utf8mb4_unicode_ci,
  `buttons` longtext COLLATE utf8mb4_unicode_ci,
  `social` longtext COLLATE utf8mb4_unicode_ci,
  `font` longtext COLLATE utf8mb4_unicode_ci,
  `theme` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` longtext COLLATE utf8mb4_unicode_ci,
  `avatar_settings` longtext COLLATE utf8mb4_unicode_ci,
  `seo` longtext COLLATE utf8mb4_unicode_ci,
  `pwa` longtext COLLATE utf8mb4_unicode_ci,
  `store` longtext COLLATE utf8mb4_unicode_ci,
  `integrations` longtext COLLATE utf8mb4_unicode_ci,
  `api` text COLLATE utf8mb4_unicode_ci,
  `booking` longtext COLLATE utf8mb4_unicode_ci,
  `payments` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `workspaces_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.workspaces: ~2 rows (aproximadamente)
INSERT IGNORE INTO `workspaces` (`id`, `user_id`, `name`, `slug`, `status`, `is_default`, `bio`, `avatar`, `settings`, `background`, `background_settings`, `buttons`, `social`, `font`, `theme`, `color`, `avatar_settings`, `seo`, `pwa`, `store`, `integrations`, `api`, `booking`, `payments`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Adriano', 'adriano', 1, 1, 'Click here to add a brief summary about your page to get your audience interested in what you do.', NULL, '{"bio_align":"center","always_dark":"1","remove_branding":"0","verified":"1","banner_or_background":"0"}', NULL, '{"video":{"source":"url","external_url":null,"video":null},"image":{"source":"url","external_url":null,"image":null},"solid":{"color":"#000"},"gradient":{"color_1":"#fff","color_2":"#fff","animate":"0"}}', '[]', '{"email":"adrianowebm2@gmail.com","whatsapp":null,"facebook":null,"instagram":null,"twitter":null,"youtube":null,"linkedin":null,"telegram":null,"snapchat":null,"discord":null,"twitch":null,"pinterest":null,"tiktok":null,"github":null}', NULL, 'shadow', '{"button_background":"#6200FF","button_color":"#FFFFFF","text":"#000"}', NULL, '{"enable":"0","block_engine":"0","page_name":"Adriano 333","page_description":"teste adriano"}', NULL, NULL, NULL, 'ac05cdac17b7e5b6d8b850280eb30c829beefc5b0ed5059763f8280442f97926', NULL, NULL, '2026-01-07 21:51:39', '2026-01-09 00:09:54'),
	(4, 1, 'Teste', 'teste', 1, 0, NULL, NULL, '{"bio_align":"center","always_dark":"0","remove_branding":"1","verified":"1","banner_or_background":"1","radius":"rounded-3xl"}', 'image', '{"video":{"source":"url","external_url":null,"video":null},"image":{"source":"url","external_url":"http:\\/\\/linkbiotop.test\\/assets\\/image\\/theme\\/bloom\\/linear-gradient(135deg, #FF9A9E 0%, #FECFEF 100%)","image":null},"solid":{"color":"#000"},"gradient":{"color_1":"#fff","color_2":"#fff","animate":"0"}}', '[]', '{"email":"mmdesignersrg3@gmail.com","whatsapp":null,"facebook":null,"instagram":null,"twitter":null,"youtube":null,"linkedin":null,"telegram":null,"snapchat":null,"discord":null,"twitch":null,"pinterest":null,"tiktok":null,"github":null}', 'Poppins', 'bloom', '{"button_background":"rgba(255, 255, 255, 0.9)","button_color":"#D4145A","text":"#D4145A"}', NULL, '{"enable":"0","block_engine":"0","page_name":"Teste","page_description":"sadsadsa dsad sad sad sa dsa"}', NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-08 01:54:40', '2026-01-09 01:24:25');

-- Copiando estrutura para tabela linkbiotop.yetti_spv
CREATE TABLE IF NOT EXISTS `yetti_spv` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `payee_user_id` int DEFAULT NULL,
  `sxref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_paid` int NOT NULL DEFAULT '0',
  `price` double(16,2) DEFAULT NULL,
  `split_price` double(16,2) DEFAULT NULL,
  `method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `callback` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.yetti_spv: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela linkbiotop.yetti_spv_history
CREATE TABLE IF NOT EXISTS `yetti_spv_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `spv_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_ref` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload_data` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela linkbiotop.yetti_spv_history: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
