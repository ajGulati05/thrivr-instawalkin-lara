# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.26)
# Database: instawalkin
# Generation Time: 2019-07-09 21:06:07 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table action_events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `action_events`;

CREATE TABLE `action_events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actionable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actionable_id` int(10) unsigned NOT NULL,
  `target_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` int(10) unsigned DEFAULT NULL,
  `fields` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'running',
  `exception` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `original` text COLLATE utf8mb4_unicode_ci,
  `changes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `action_events_actionable_type_actionable_id_index` (`actionable_type`,`actionable_id`),
  KEY `action_events_batch_id_model_type_model_id_index` (`batch_id`,`model_type`,`model_id`),
  KEY `action_events_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table admins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;

INSERT INTO `admins` (`id`, `email`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'adevjit@gmail.com','$2y$10$Ld5rCKJl9evO.LGofW/QaeQ2IebyWYQWm83W8L2mh4ojhL.v152IO',NULL,'2018-03-05 21:12:30','2018-03-05 21:12:30');

/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table afterstatuscodes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `afterstatuscodes`;

CREATE TABLE `afterstatuscodes` (
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `afterstatuscodes_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `afterstatuscodes` WRITE;
/*!40000 ALTER TABLE `afterstatuscodes` DISABLE KEYS */;

INSERT INTO `afterstatuscodes` (`code`, `description`, `created_at`, `updated_at`)
VALUES
	('CP','CANCELLED BY PROVIDER',NULL,NULL),
	('CU','CANCELLED BY USER',NULL,NULL),
	('N','NO SHOW',NULL,NULL);

/*!40000 ALTER TABLE `afterstatuscodes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table appconfigs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `appconfigs`;

CREATE TABLE `appconfigs` (
  `codevalue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` int(11) DEFAULT NULL,
  `stringvalue` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  UNIQUE KEY `appconfig_codevalue_unique` (`codevalue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `appconfigs` WRITE;
/*!40000 ALTER TABLE `appconfigs` DISABLE KEYS */;

INSERT INTO `appconfigs` (`codevalue`, `description`, `value`, `stringvalue`)
VALUES
	('day_end_hour','End hour of the day',23,NULL),
	('day_end_min','End min of the day',30,NULL),
	('day_start_hour','Start hour of the day',9,NULL),
	('day_start_min','Start minute of the day',0,NULL),
	('max_days','max number of days to show',2,NULL),
	('max_month','Max months to show',3,NULL),
	('min_month','Min months to show',1,NULL),
	('min_step_add','Minute steps to add',15,NULL),
	('min_step_unix','Min steps in unix',900,NULL),
	('min_step_word','Min steps in word',NULL,'three hour'),
	('mins_add_init','Minutes to add initially',30,NULL),
	('time_dist','Distance to keep',2,NULL),
	('time_dist_unix','Distance in unix',7200,NULL);

/*!40000 ALTER TABLE `appconfigs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table betasignups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `betasignups`;

CREATE TABLE `betasignups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonetype` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `betasignups` WRITE;
/*!40000 ALTER TABLE `betasignups` DISABLE KEYS */;

INSERT INTO `betasignups` (`id`, `email`, `phonetype`, `created_at`, `updated_at`)
VALUES
	(1,'adev@gmail.com','APPLE','2018-07-17 04:01:42','2018-07-17 04:01:42'),
	(2,'adev@gmail.com','APPLE','2018-07-17 04:02:13','2018-07-17 04:02:13'),
	(3,'adev@gmail.com','APPLE','2018-07-17 04:02:55','2018-07-17 04:02:55'),
	(4,'asdasd@mail.com','APPLE','2018-07-18 01:45:56','2018-07-18 01:45:56'),
	(5,'adevjit@gmail.com','APPLE','2018-08-29 02:18:54','2018-08-29 02:18:54'),
	(6,'adevjit@gmail.com','APPLE','2018-08-29 02:19:23','2018-08-29 02:19:23'),
	(7,'adevjit@gmail.com','APPLE','2018-08-29 02:20:20','2018-08-29 02:20:20'),
	(8,'adevjit@gmail.com','APPLE','2018-08-29 02:20:33','2018-08-29 02:20:33'),
	(9,'adevjit@gmail.com','APPLE','2018-08-29 02:20:58','2018-08-29 02:20:58'),
	(10,'adevjit@gmail.com','APPLE','2018-08-29 02:21:28','2018-08-29 02:21:28');

/*!40000 ALTER TABLE `betasignups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table biweeklys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `biweeklys`;

CREATE TABLE `biweeklys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start_week` date NOT NULL,
  `end_week` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `biweeklys` WRITE;
/*!40000 ALTER TABLE `biweeklys` DISABLE KEYS */;

INSERT INTO `biweeklys` (`id`, `start_week`, `end_week`)
VALUES
	(1,'2018-03-10','2018-03-23'),
	(2,'2018-03-24','2018-04-06'),
	(3,'2018-04-07','2018-04-20'),
	(4,'2018-04-21','2018-05-04'),
	(5,'2018-05-05','2018-05-18'),
	(6,'2018-05-19','2018-06-01'),
	(7,'2018-06-02','2018-06-15'),
	(8,'2018-06-16','2018-06-29'),
	(9,'2018-06-30','2018-07-13'),
	(10,'2018-07-14','2018-07-27'),
	(11,'2018-07-28','2018-08-10'),
	(12,'2018-08-11','2018-08-24'),
	(13,'2018-08-25','2018-09-07'),
	(14,'2018-09-08','2018-09-21'),
	(15,'2018-09-22','2018-10-05'),
	(16,'2018-10-06','2018-10-19'),
	(17,'2018-10-20','2018-11-02'),
	(18,'2018-11-03','2018-11-16'),
	(19,'2018-11-17','2018-11-30'),
	(20,'2018-12-01','2018-12-14'),
	(21,'2018-12-15','2018-12-28'),
	(22,'2018-12-29','2019-01-11'),
	(23,'2019-01-12','2019-01-25'),
	(24,'2019-01-26','2019-02-08'),
	(25,'2019-02-09','2019-02-22'),
	(26,'2019-02-23','2019-03-08'),
	(27,'2019-03-09','2019-03-22'),
	(28,'2019-03-23','2019-04-05'),
	(29,'2019-04-06','2019-04-19'),
	(30,'2019-04-20','2019-05-03'),
	(31,'2019-05-04','2019-05-17'),
	(32,'2019-05-18','2019-05-31'),
	(33,'2019-06-01','2019-06-14'),
	(34,'2019-06-15','2019-06-28'),
	(35,'2019-06-29','2019-07-12'),
	(36,'2019-07-13','2019-07-26'),
	(37,'2019-07-27','2019-08-09'),
	(38,'2019-08-10','2019-08-23'),
	(39,'2019-08-24','2019-09-06'),
	(40,'2019-09-07','2019-09-20'),
	(41,'2019-09-21','2019-10-04'),
	(42,'2019-10-05','2019-10-18'),
	(43,'2019-10-19','2019-11-01'),
	(44,'2019-11-02','2019-11-15'),
	(45,'2019-11-16','2019-11-29'),
	(46,'2019-11-30','2019-12-13');

/*!40000 ALTER TABLE `biweeklys` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table businessservices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `businessservices`;

CREATE TABLE `businessservices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table contact_forms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contact_forms`;

CREATE TABLE `contact_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `acknowledged` tinyint(1) NOT NULL DEFAULT '0',
  `contacted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `contact_forms` WRITE;
/*!40000 ALTER TABLE `contact_forms` DISABLE KEYS */;

INSERT INTO `contact_forms` (`id`, `name`, `phone`, `email`, `comment`, `acknowledged`, `contacted`, `created_at`, `updated_at`)
VALUES
	(1,'ade','3062625152','adevjit@gmail.com','asdasd',0,0,'2018-07-20 03:32:11','2018-07-20 03:32:11'),
	(2,'tes','3062625152','adevjit@gmail.com','teast asds',0,0,'2018-07-21 03:40:03','2018-07-21 03:40:03'),
	(3,'adev','3062625152','adevjit@mail.com','asdsads',0,0,'2018-07-21 03:40:59','2018-07-21 03:40:59'),
	(4,'test','3062625152','adevjit@gmail.com','test again',0,0,'2018-07-21 03:47:05','2018-07-21 03:47:05'),
	(5,'ade','3062625152','adevjit@gmail.com','test aagin',0,0,'2018-07-21 03:47:51','2018-07-21 03:47:51'),
	(6,'test','3062625152','adevjit@gmail.com','teasdsa',0,0,'2018-07-21 03:49:58','2018-07-21 03:49:58'),
	(7,'adev','3062625152','adevjit@gmail.com','test test es',0,0,'2018-07-21 03:51:24','2018-07-21 03:51:24'),
	(8,'adev','3062625152','adevjit@gmail.com','asdasdsad',0,0,'2018-07-21 03:56:38','2018-07-21 03:56:38'),
	(9,'test','3062625152','adevjit@gmail.com','asdasds',0,0,'2018-07-21 03:58:32','2018-07-21 03:58:32'),
	(10,'adas','3062625152','adevjit@gmail.com','sadasds',0,0,'2018-07-21 03:59:27','2018-07-21 03:59:27'),
	(11,'teas','3062625152','adevjit@gmail.com','teast a',0,0,'2018-07-21 04:00:13','2018-07-21 04:00:13'),
	(12,'adev','3062625152','adevjit@gmail.com','test12345',0,0,'2018-07-21 04:13:37','2018-07-21 04:13:37'),
	(13,'adv','3062625152','adevjit@gmail.com','sadsadasd',0,0,'2018-07-21 04:15:03','2018-07-21 04:15:03'),
	(14,'adevjit','3062625152','adevjit@gmail.com','heloo 12345',0,0,'2018-07-21 04:16:05','2018-07-21 04:16:05'),
	(15,'adev','3062625152','adevjit@gmail.com','readsdasdsa',0,0,'2018-07-21 04:17:51','2018-07-21 04:17:51'),
	(16,'test','3062625152','adevjit@gmail.com','adsadsads',0,0,'2018-07-21 04:43:11','2018-07-21 04:43:11'),
	(17,'adevjit','3062625152','adevjit@gmail.com','hello adsad',0,0,'2018-07-21 04:46:16','2018-07-21 04:46:16'),
	(18,'test','3062625152','adevjit@gmail.com','naldsdksad',0,0,'2018-07-21 04:47:44','2018-07-21 04:47:44'),
	(19,'adevjit','3062625152','adevjit@gmail.com','asdasdklmasdlsakmd',0,0,'2018-07-21 04:48:46','2018-07-21 04:48:46'),
	(20,'test','3062625152','adevjit@gmail.com','dasdsadsads',0,0,'2018-07-21 04:49:36','2018-07-21 04:49:36'),
	(21,'adevjit','3062625152','adevjit@gmail.com','tasdsadsad',0,0,'2018-07-21 04:50:04','2018-07-21 04:50:04'),
	(22,'adevjit@gmail.com','3062625152','adevjit@gmail.com','asdalnkndkasdnsjdn',0,0,'2018-07-21 04:52:43','2018-07-21 04:52:43'),
	(23,'adevi','3062625152','adevjit@gmail.com','tedasdsad',0,0,'2018-07-21 04:53:32','2018-07-21 04:53:32'),
	(24,'aj','13062625152','asg452@mail.usasl.ca','ola',0,0,'2019-01-30 01:56:30','2019-01-30 01:56:30');

/*!40000 ALTER TABLE `contact_forms` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table corporationpromo_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `corporationpromo_users`;

CREATE TABLE `corporationpromo_users` (
  `corporationpromos_id` int(10) unsigned NOT NULL,
  `users_id` int(10) unsigned NOT NULL,
  `validated` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `corporationpromo_users_corporationpromos_id_foreign` (`corporationpromos_id`),
  KEY `corporationpromo_users_users_id_foreign` (`users_id`),
  CONSTRAINT `corporationpromo_users_corporationpromos_id_foreign` FOREIGN KEY (`corporationpromos_id`) REFERENCES `corporationpromos` (`id`),
  CONSTRAINT `corporationpromo_users_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `corporationpromo_users` WRITE;
/*!40000 ALTER TABLE `corporationpromo_users` DISABLE KEYS */;

INSERT INTO `corporationpromo_users` (`corporationpromos_id`, `users_id`, `validated`, `created_at`, `updated_at`)
VALUES
	(1,39,0,NULL,NULL);

/*!40000 ALTER TABLE `corporationpromo_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table corporationpromos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `corporationpromos`;

CREATE TABLE `corporationpromos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percent` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `corporationpromos_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `corporationpromos` WRITE;
/*!40000 ALTER TABLE `corporationpromos` DISABLE KEYS */;

INSERT INTO `corporationpromos` (`id`, `name`, `code`, `percent`, `comment`, `start_date`, `end_date`, `created_at`, `updated_at`)
VALUES
	(1,'test promo aj','TEST',10,'for aj','2019-03-09','2020-03-09',NULL,NULL);

/*!40000 ALTER TABLE `corporationpromos` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table corprequests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `corprequests`;

CREATE TABLE `corprequests` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `corprequests_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `corprequests` WRITE;
/*!40000 ALTER TABLE `corprequests` DISABLE KEYS */;

INSERT INTO `corprequests` (`email`, `code`, `company`, `created_at`, `updated_at`)
VALUES
	('adevjit@gmail.com','asdsad','test1','2019-04-10 05:25:56','2019-04-10 05:25:56');

/*!40000 ALTER TABLE `corprequests` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table credithistorys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `credithistorys`;

CREATE TABLE `credithistorys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) unsigned NOT NULL,
  `creditamount` decimal(10,2) NOT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reasoncode` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `credithistory_transaction_id_foreign` (`transaction_id`),
  KEY `credithistory_reasoncode_foreign` (`reasoncode`),
  CONSTRAINT `credithistory_reasoncode_foreign` FOREIGN KEY (`reasoncode`) REFERENCES `creditreasoncodes` (`code`),
  CONSTRAINT `credithistory_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `credithistorys` WRITE;
/*!40000 ALTER TABLE `credithistorys` DISABLE KEYS */;

INSERT INTO `credithistorys` (`id`, `transaction_id`, `creditamount`, `reason`, `created_at`, `updated_at`, `reasoncode`)
VALUES
	(1,243,30.00,'Test on 30','2018-12-01 23:51:56','2018-12-01 23:51:56','CLNO'),
	(2,243,30.00,'Test on 30a','2018-12-01 23:54:01','2018-12-01 23:54:01','CLNO'),
	(3,243,30.00,'Test on 30a','2018-12-01 23:54:12','2018-12-01 23:54:12','CLNO'),
	(4,243,301.00,'Test on 30a','2018-12-01 23:56:03','2018-12-01 23:56:03','CLNO'),
	(5,243,301.00,'Test on 30a','2018-12-02 00:08:07','2018-12-02 00:08:07','CLNO'),
	(6,243,80.00,'test 80','2018-12-02 00:09:40','2018-12-02 00:09:40','CL'),
	(7,243,80.00,'test','2018-12-02 00:10:25','2018-12-02 00:10:25','CL'),
	(8,243,40.00,'test 40','2018-12-02 00:10:46','2018-12-02 00:10:46','CL'),
	(9,318,69.00,'Provider accepted wrong','2018-12-02 04:52:54','2018-12-02 04:52:54','PR'),
	(10,465,100.00,'axas','2019-04-07 20:32:52','2019-04-07 20:32:52','CL');

/*!40000 ALTER TABLE `credithistorys` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table creditreasoncodes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `creditreasoncodes`;

CREATE TABLE `creditreasoncodes` (
  `code` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `creditreasoncodes` WRITE;
/*!40000 ALTER TABLE `creditreasoncodes` DISABLE KEYS */;

INSERT INTO `creditreasoncodes` (`code`, `description`, `created_at`, `updated_at`)
VALUES
	('CL','Client',NULL,NULL),
	('CLNO','Client No Show',NULL,NULL),
	('PR','Provider',NULL,NULL);

/*!40000 ALTER TABLE `creditreasoncodes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dailypromos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dailypromos`;

CREATE TABLE `dailypromos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `locationtype_id` int(10) unsigned NOT NULL,
  `percent` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dailypromos_locationtype_id_foreign` (`locationtype_id`),
  CONSTRAINT `dailypromos_locationtype_id_foreign` FOREIGN KEY (`locationtype_id`) REFERENCES `locationtypes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table days
# ------------------------------------------------------------

DROP TABLE IF EXISTS `days`;

CREATE TABLE `days` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `days` WRITE;
/*!40000 ALTER TABLE `days` DISABLE KEYS */;

INSERT INTO `days` (`id`, `description`)
VALUES
	(1,'MONDAY'),
	(2,'TUESDAY'),
	(3,'WEDNESDAY'),
	(4,'THURSDAY'),
	(5,'FRIDAY'),
	(6,'SATURDAY'),
	(7,'SUNDAY'),
	(8,'STAT');

/*!40000 ALTER TABLE `days` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dayschedules
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dayschedules`;

CREATE TABLE `dayschedules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `scheduledtime` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `schedulecode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table employee_service
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employee_service`;

CREATE TABLE `employee_service` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `employee_service` WRITE;
/*!40000 ALTER TABLE `employee_service` DISABLE KEYS */;

INSERT INTO `employee_service` (`id`, `employee_id`, `service_id`, `created_at`, `updated_at`)
VALUES
	(1,1,3,NULL,NULL),
	(3,2,4,NULL,NULL),
	(4,2,5,NULL,NULL),
	(5,3,6,NULL,NULL),
	(6,4,10,NULL,NULL),
	(7,4,9,NULL,NULL),
	(8,5,8,NULL,NULL),
	(9,5,11,NULL,NULL),
	(10,6,12,NULL,NULL),
	(11,6,16,NULL,NULL),
	(12,7,13,NULL,NULL),
	(13,7,14,NULL,NULL),
	(14,8,13,NULL,NULL),
	(15,8,16,NULL,NULL),
	(16,9,17,NULL,NULL),
	(17,9,18,NULL,NULL),
	(18,10,19,NULL,NULL),
	(19,1,1,NULL,NULL),
	(21,1,7,NULL,NULL),
	(24,1,2,NULL,NULL),
	(25,11,1,NULL,NULL),
	(26,11,3,NULL,NULL),
	(27,11,4,NULL,NULL);

/*!40000 ALTER TABLE `employee_service` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Employees
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Employees`;

CREATE TABLE `Employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gender_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `licenseno` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notificationcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `Employees` WRITE;
/*!40000 ALTER TABLE `Employees` DISABLE KEYS */;

INSERT INTO `Employees` (`id`, `gender_id`, `firstname`, `lastname`, `licenseno`, `created_at`, `updated_at`, `deleted_at`, `location_id`, `phone`, `email`, `notificationcode`)
VALUES
	(1,'F','xJUST','EYEBROW','1','2018-03-05 22:28:23','2018-09-06 01:44:47',NULL,1,'+13062625152','adevjit@gmail.com','E'),
	(2,'M','LANCE','ARTHURS','2','2018-03-05 22:43:04','2018-03-05 22:43:04',NULL,1,'+13062625152','adevjit@gmail.com','T'),
	(3,'M','AJ','GULATI','3','2018-03-05 22:44:05','2018-03-05 22:44:05',NULL,1,'+13062625152','adevjit@gmail.com','T'),
	(4,'M','JOHN','SPRAGUE','123','2018-03-05 23:52:03','2018-03-05 23:52:03',NULL,2,'+13062625152','adevjit@hotmail.com','E'),
	(5,'M','MILKY','GOLOWITZ','322','2018-03-05 23:52:52','2018-03-05 23:52:52',NULL,2,'+13062625152','adevjit@gmail.com','T'),
	(6,'F','JILL','THIRVE','1234','2018-03-05 23:59:19','2018-03-05 23:59:19',NULL,3,'+13062625152','adevjit@gmail.com','E'),
	(7,'M','TAYLER','PAISLEY','5432','2018-03-05 23:59:56','2018-03-05 23:59:56',NULL,3,'+13062625152','tpay@mail.com','T'),
	(8,'M','SHAUN','SYMC','6712','2018-03-06 00:00:53','2018-03-06 00:00:53',NULL,3,'+13062625152','sma@msa.com','T'),
	(9,'F','AMANDA','SMENDZIUK','4312','2018-03-06 00:02:47','2018-03-06 00:02:47',NULL,4,'+13062625152','adevjit@gmail.com','T'),
	(10,'M','AJ','GULATI','572','2018-03-06 00:03:54','2018-03-06 00:03:54',NULL,5,'+13062625152','adevjit@gmail.com','T'),
	(11,'M','LET','TEST','123123','2018-09-06 01:45:21','2018-09-06 01:45:21',NULL,1,'+13062625152','adevjit@gmail.com','N');

/*!40000 ALTER TABLE `Employees` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table failed_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;

INSERT INTO `failed_jobs` (`id`, `connection`, `queue`, `payload`, `exception`, `failed_at`)
VALUES
	(1,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:81;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"ceeaa3d3-9409-4b76-983d-16efa24b6e24\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Undefined property: App\\Notifications\\SendReciepts::$discount_type in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:65\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(65): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined prope...\', \'/Users/ajgulati...\', 65, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'f2f814b9-631f-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 00:38:12'),
	(2,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"6abafa3c-1f8f-4fec-9f5e-7ed3b861b9df\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:91\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(91): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 91, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'572633f1-8997-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 00:39:47'),
	(3,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"cc8c13aa-45c2-48a9-bd99-5028812d74c6\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','Illuminate\\Queue\\MaxAttemptsExceededException: App\\Notifications\\SendReciepts has been attempted too many times or run too long. The job may have previously timed out. in /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php:400\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(320): Illuminate\\Queue\\Worker->markJobAsFailedIfAlreadyExceedsMaxAttempts(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), 1)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#5 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#6 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#11 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#13 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#14 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#15 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#18 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 {main}','2019-04-17 00:42:23'),
	(4,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:81;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"1401722e-2d6e-4ecf-8660-0d3c50f686c7\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','Illuminate\\Queue\\MaxAttemptsExceededException: App\\Notifications\\SendReciepts has been attempted too many times or run too long. The job may have previously timed out. in /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php:400\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(320): Illuminate\\Queue\\Worker->markJobAsFailedIfAlreadyExceedsMaxAttempts(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), 1)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#5 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#6 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#11 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#13 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#14 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#15 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#18 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 {main}','2019-04-17 00:43:01'),
	(5,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"5fbe1f68-7736-486c-b457-440cba5fb150\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:91\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(91): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 91, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'ed4a000d-83ee-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 00:43:55'),
	(6,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"2908f2c1-3db8-4cae-bb7e-479e0ce90afa\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:91\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(91): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 91, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'c55da4be-31fe-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 00:44:08'),
	(7,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"baec9d6e-08b9-401e-804b-2ce734db5764\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:91\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(91): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 91, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'a7b28450-9187-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 00:45:13'),
	(8,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"d3a6a8fe-1cd1-4eb5-b097-09da2d467c4b\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','Illuminate\\Queue\\MaxAttemptsExceededException: App\\Notifications\\SendReciepts has been attempted too many times or run too long. The job may have previously timed out. in /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php:400\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(320): Illuminate\\Queue\\Worker->markJobAsFailedIfAlreadyExceedsMaxAttempts(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), 1)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#5 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#6 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#11 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#13 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#14 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#15 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#18 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 {main}','2019-04-17 00:45:44'),
	(9,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"d2053e66-8c47-4424-b11c-21ff2894120d\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:91\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(91): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 91, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'5e5a8e10-d163-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 00:46:00'),
	(10,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:80;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"8d64bb96-a528-432c-a287-c53b8ab8eda2\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','Illuminate\\Queue\\MaxAttemptsExceededException: App\\Notifications\\SendReciepts has been attempted too many times or run too long. The job may have previously timed out. in /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php:400\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(320): Illuminate\\Queue\\Worker->markJobAsFailedIfAlreadyExceedsMaxAttempts(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), 1)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#5 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#6 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#11 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#13 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#14 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#15 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#18 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 {main}','2019-04-17 00:47:11'),
	(11,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"1f2a76fb-3f5d-4343-92e9-2e1cac7da3e4\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:91\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(91): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 91, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'85e3f512-ad4f-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 00:48:56'),
	(12,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"b589570a-b2bc-4af6-8eec-20f689471f4e\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:91\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(91): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 91, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'cf7f65f7-7738-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 00:49:47'),
	(13,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"e9445354-1de7-41dd-a068-5888219664d8\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:69\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(69): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 69, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'510d2583-5577-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 00:50:04'),
	(14,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"495dccef-5e58-4d7f-b682-d74329ad36bd\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','Illuminate\\Queue\\MaxAttemptsExceededException: App\\Notifications\\SendReciepts has been attempted too many times or run too long. The job may have previously timed out. in /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php:400\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(320): Illuminate\\Queue\\Worker->markJobAsFailedIfAlreadyExceedsMaxAttempts(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), 1)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#5 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#6 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#11 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#13 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#14 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#15 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#18 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 {main}','2019-04-17 00:50:54'),
	(15,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"9b440f44-6a7a-4f16-a703-fce27ae3a4c8\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','Illuminate\\Queue\\MaxAttemptsExceededException: App\\Notifications\\SendReciepts has been attempted too many times or run too long. The job may have previously timed out. in /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php:400\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(320): Illuminate\\Queue\\Worker->markJobAsFailedIfAlreadyExceedsMaxAttempts(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), 1)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#5 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#6 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#11 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#13 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#14 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#15 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#18 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 {main}','2019-04-17 00:51:34'),
	(16,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"c834ec9d-977d-4c7e-95c4-9639c6316ea3\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:70\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(70): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 70, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'7ebd4ac4-02de-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 00:52:26'),
	(17,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"ce5a9812-b645-4dea-adab-073818512604\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:70\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(70): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 70, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'5b3a67a8-8710-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 00:53:38'),
	(18,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"038565e4-8751-41c8-ba91-bec8e97fd04c\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:51\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(51): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 51, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'5bdd1041-9f8f-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 00:57:47'),
	(19,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"65fba75a-f12f-48b6-a0d7-e9dffde1e32a\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:51\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(51): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 51, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'207e9ef2-61e0-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 00:58:30'),
	(20,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"ad0bfeb4-216f-4a88-9348-a4d70ce3e9c4\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','Illuminate\\Queue\\MaxAttemptsExceededException: App\\Notifications\\SendReciepts has been attempted too many times or run too long. The job may have previously timed out. in /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php:400\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(320): Illuminate\\Queue\\Worker->markJobAsFailedIfAlreadyExceedsMaxAttempts(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), 1)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#5 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#6 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#11 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#13 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#14 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#15 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#18 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 {main}','2019-04-17 00:59:43'),
	(21,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"2e44657b-4420-4a79-956f-b5a87d130e4c\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:51\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(51): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 51, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'604ac984-10ad-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 01:01:16'),
	(22,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"0ec3b6af-adb1-4b22-9e17-5328cd5f7e61\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','Illuminate\\Queue\\MaxAttemptsExceededException: App\\Notifications\\SendReciepts has been attempted too many times or run too long. The job may have previously timed out. in /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php:400\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(320): Illuminate\\Queue\\Worker->markJobAsFailedIfAlreadyExceedsMaxAttempts(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), 1)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#5 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#6 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#11 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#13 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#14 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#15 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#18 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 {main}','2019-04-17 01:04:03'),
	(23,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"b25d104f-ba64-45a4-ac6c-2d9233aa0436\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','Illuminate\\Queue\\MaxAttemptsExceededException: App\\Notifications\\SendReciepts has been attempted too many times or run too long. The job may have previously timed out. in /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php:400\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(320): Illuminate\\Queue\\Worker->markJobAsFailedIfAlreadyExceedsMaxAttempts(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), 1)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#5 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#6 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#11 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#13 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#14 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#15 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#18 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#19 {main}','2019-04-17 01:06:24'),
	(24,'sqs','https://sqs.ca-central-1.amazonaws.com/476705120696/partnerform-dev','{\"displayName\":\"App\\\\Notifications\\\\SendReciepts\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"timeout\":null,\"timeoutAt\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":9:{s:11:\\\"notifiables\\\";O:44:\\\"Illuminate\\\\Notifications\\\\AnonymousNotifiable\\\":1:{s:6:\\\"routes\\\";a:1:{s:4:\\\"mail\\\";s:17:\\\"adevjit@gmail.com\\\";}}s:12:\\\"notification\\\";O:30:\\\"App\\\\Notifications\\\\SendReciepts\\\":8:{s:14:\\\"\\u0000*\\u0000transaction\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:16:\\\"App\\\\Transactions\\\";s:2:\\\"id\\\";i:82;s:9:\\\"relations\\\";a:4:{i:0;s:5:\\\"users\\\";i:1;s:12:\\\"userprofiles\\\";i:2;s:9:\\\"employees\\\";i:3;s:9:\\\"locations\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:2:\\\"id\\\";s:36:\\\"0e163d8e-9b9c-4c59-866c-bee30d32e685\\\";s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Trying to get property of non-object in /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php:57\nStack trace:\n#0 /Users/ajgulati/code/instawalkin/app/Notifications/SendReciepts.php(57): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/Users/ajgulati...\', 57, Array)\n#1 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(50): App\\Notifications\\SendReciepts->toMail(Object(Illuminate\\Notifications\\AnonymousNotifiable))\n#2 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(113): Illuminate\\Notifications\\Channels\\MailChannel->send(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts))\n#3 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(89): Illuminate\\Notifications\\NotificationSender->sendToNotifiable(Object(Illuminate\\Notifications\\AnonymousNotifiable), \'7600551f-8861-4...\', Object(App\\Notifications\\SendReciepts), \'mail\')\n#4 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(50): Illuminate\\Notifications\\NotificationSender->sendNow(Array, Object(App\\Notifications\\SendReciepts), Array)\n#5 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(57): Illuminate\\Notifications\\ChannelManager->sendNow(Object(Illuminate\\Notifications\\AnonymousNotifiable), Object(App\\Notifications\\SendReciepts), Array)\n#6 [internal function]: Illuminate\\Notifications\\SendQueuedNotifications->handle(Object(Illuminate\\Notifications\\ChannelManager))\n#7 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#8 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call(Array)\n#12 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(116): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#13 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Notifications\\SendQueuedNotifications))\n#14 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(Illuminate\\Notifications\\SendQueuedNotifications), false)\n#16 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(83): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\SqsJob), Array)\n#17 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(326): Illuminate\\Queue\\Jobs\\Job->fire()\n#18 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(276): Illuminate\\Queue\\Worker->process(\'sqs\', Object(Illuminate\\Queue\\Jobs\\SqsJob), Object(Illuminate\\Queue\\WorkerOptions))\n#19 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(229): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\SqsJob), \'sqs\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Worker->runNextJob(\'sqs\', \'partnerform-dev\', Object(Illuminate\\Queue\\WorkerOptions))\n#21 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(84): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'sqs\', \'partnerform-dev\')\n#22 [internal function]: Illuminate\\Queue\\Console\\WorkCommand->handle()\n#23 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)\n#24 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#25 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#26 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Container/Container.php(564): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#27 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(179): Illuminate\\Container\\Container->call(Array)\n#28 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Command.php(166): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#30 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(886): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(262): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 /Users/ajgulati/code/instawalkin/vendor/symfony/console/Application.php(145): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Console/Application.php(89): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 /Users/ajgulati/code/instawalkin/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(122): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 /Users/ajgulati/code/instawalkin/artisan(35): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 {main}','2019-04-17 01:06:40');

/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table featurecodes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `featurecodes`;

CREATE TABLE `featurecodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `featurecodes_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `featurecodes` WRITE;
/*!40000 ALTER TABLE `featurecodes` DISABLE KEYS */;

INSERT INTO `featurecodes` (`id`, `code`, `description`, `created_at`, `updated_at`)
VALUES
	(1,'A','All Services',NULL,NULL),
	(2,'I','insta walkin service',NULL,NULL),
	(3,'S','Schedule Services',NULL,NULL);

/*!40000 ALTER TABLE `featurecodes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table genders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `genders`;

CREATE TABLE `genders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `genders` WRITE;
/*!40000 ALTER TABLE `genders` DISABLE KEYS */;

INSERT INTO `genders` (`id`, `description`, `created_at`, `updated_at`, `code`)
VALUES
	(1,'MALE',NULL,NULL,'M'),
	(2,'FEMALE',NULL,NULL,'F');

/*!40000 ALTER TABLE `genders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table holdingtransactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `holdingtransactions`;

CREATE TABLE `holdingtransactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `price_id` int(10) unsigned NOT NULL,
  `servicecategories_id` int(10) unsigned NOT NULL,
  `distance` int(11) NOT NULL,
  `userlocation_lat` double(10,6) NOT NULL,
  `userlocation_lng` double(10,6) NOT NULL,
  `servicedate` date NOT NULL,
  `service_starttime` datetime NOT NULL,
  `service_endtime` datetime NOT NULL,
  `creditamount` double(10,2) DEFAULT NULL,
  `promoamount` double(10,2) DEFAULT NULL,
  `promocode` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `corporatepercent` int(11) DEFAULT NULL,
  `corporatecode` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approved` tinyint(1) DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `statuscode` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'W',
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `locationinfo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount_type` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `holdingtransactions_servicecategories_id_foreign` (`servicecategories_id`),
  KEY `holdingtransactions_price_id_foreign` (`price_id`),
  KEY `holdingtransactions_user_id_foreign` (`user_id`),
  CONSTRAINT `holdingtransactions_price_id_foreign` FOREIGN KEY (`price_id`) REFERENCES `instaprices` (`id`),
  CONSTRAINT `holdingtransactions_servicecategories_id_foreign` FOREIGN KEY (`servicecategories_id`) REFERENCES `servicecategories` (`id`),
  CONSTRAINT `holdingtransactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `holdingtransactions` WRITE;
/*!40000 ALTER TABLE `holdingtransactions` DISABLE KEYS */;

INSERT INTO `holdingtransactions` (`id`, `user_id`, `price_id`, `servicecategories_id`, `distance`, `userlocation_lat`, `userlocation_lng`, `servicedate`, `service_starttime`, `service_endtime`, `creditamount`, `promoamount`, `promocode`, `corporatepercent`, `corporatecode`, `approved`, `comment`, `statuscode`, `read`, `locationinfo`, `created_at`, `updated_at`, `discount_type`, `gender`)
VALUES
	(43,39,4,14,30,52.108908,-106.672034,'2019-03-17','2019-03-18 14:32:00','2019-03-18 17:30:00',0.00,NULL,'0.00',NULL,NULL,1,NULL,'A',0,'[{\"id\":\"3\",\"email\":\"gulati.adevjit@gmail.com\",\"location\":\"MAJOR MASSAGE\",\"phone\":\"+13062625154\"},{\"id\":\"1\",\"email\":\"adevjit@gmail.com\",\"location\":\"SASKATOON WELNESS - JILL RMT500 \",\"phone\":\"+13062625152\"},{\"id\":\"6\",\"email\":\"testasd@mail.com\",\"location\":\"MASTER\",\"phone\":\"+13062625152\"}]','2019-03-18 01:47:23','2019-04-05 03:34:10',NULL,NULL),
	(79,39,3,3,30,52.101714,-106.567983,'2019-03-25','2019-03-25 09:00:00','2019-03-25 23:30:00',0.00,NULL,'0.00',10,'test promo aj',1,NULL,'A',0,'[{\"id\":\"3\",\"email\":\"gulati.adevjit@gmail.com\",\"location\":\"MAJOR MASSAGE\",\"phone\":\"+13062625154\"},{\"id\":\"6\",\"email\":\"testasd@mail.com\",\"location\":\"MASTER\",\"phone\":\"+13062625152\"},{\"id\":\"1\",\"email\":\"adevjit@gmail.com\",\"location\":\"SASKATOON WELNESS - JILL RMT500 \",\"phone\":\"+13062625152\"}]','2019-03-25 18:47:29','2019-04-05 03:45:43',NULL,NULL),
	(80,39,3,3,30,52.108939,-106.672292,'2019-04-01','2019-04-01 13:30:00','2019-04-01 21:00:00',0.00,NULL,'0.00',10,'test promo aj',1,NULL,'A',0,'[{\"id\":\"6\",\"email\":\"testasd@mail.com\",\"location\":\"MASTER\",\"phone\":\"+13062625152\"},{\"id\":\"1\",\"email\":\"adevjit@gmail.com\",\"location\":\"SASKATOON WELNESS - JILL RMT500 \",\"phone\":\"+13062625152\"},{\"id\":\"3\",\"email\":\"gulati.adevjit@gmail.com\",\"location\":\"MAJOR MASSAGE\",\"phone\":\"+13062625154\"}]','2019-04-01 18:55:09','2019-04-06 23:17:19','CO','E'),
	(81,39,2,3,30,52.108976,-106.672065,'2019-04-07','2019-04-07 15:00:00','2019-04-07 21:00:00',0.00,0.00,NULL,10,'test promo aj',1,NULL,'A',0,'[{\"id\":\"6\",\"email\":\"testasd@mail.com\",\"location\":\"MASTER\",\"phone\":\"+13062625152\"},{\"id\":\"1\",\"email\":\"adevjit@gmail.com\",\"location\":\"SASKATOON WELNESS - JILL RMT500 \",\"phone\":\"+13062625152\"},{\"id\":\"3\",\"email\":\"gulati.adevjit@gmail.com\",\"location\":\"MAJOR MASSAGE\",\"phone\":\"+13062625154\"}]','2019-04-07 20:20:28','2019-04-07 20:21:41','CO','E'),
	(82,39,2,3,30,52.108778,-106.671926,'2019-04-07','2019-04-07 15:15:00','2019-04-07 20:30:00',100.00,0.00,NULL,10,'test promo aj',NULL,NULL,'W',0,'[{\"id\":\"6\",\"email\":\"testasd@mail.com\",\"location\":\"MASTER\",\"phone\":\"+13062625152\"},{\"id\":\"3\",\"email\":\"gulati.adevjit@gmail.com\",\"location\":\"MAJOR MASSAGE\",\"phone\":\"+13062625154\"},{\"id\":\"1\",\"email\":\"adevjit@gmail.com\",\"location\":\"SASKATOON WELNESS - JILL RMT500 \",\"phone\":\"+13062625152\"}]','2019-04-07 20:33:11','2019-04-07 20:33:11','CO','E'),
	(83,39,2,3,30,52.108960,-106.672309,'2019-04-07','2019-04-07 15:15:00','2019-04-07 20:30:00',100.00,0.00,NULL,NULL,NULL,1,NULL,'A',0,'[{\"id\":\"6\",\"email\":\"testasd@mail.com\",\"location\":\"MASTER\",\"phone\":\"+13062625152\"},{\"id\":\"1\",\"email\":\"adevjit@gmail.com\",\"location\":\"SASKATOON WELNESS - JILL RMT500 \",\"phone\":\"+13062625152\"},{\"id\":\"3\",\"email\":\"gulati.adevjit@gmail.com\",\"location\":\"MAJOR MASSAGE\",\"phone\":\"+13062625154\"}]','2019-04-07 20:34:54','2019-04-07 20:35:55','C','E'),
	(84,39,2,3,30,52.108984,-106.672265,'2019-04-07','2019-04-07 15:30:00','2019-04-07 20:30:00',37.00,0.00,NULL,NULL,NULL,NULL,NULL,'W',0,'[{\"id\":\"6\",\"email\":\"testasd@mail.com\",\"location\":\"MASTER\",\"phone\":\"+13062625152\"},{\"id\":\"1\",\"email\":\"adevjit@gmail.com\",\"location\":\"SASKATOON WELNESS - JILL RMT500 \",\"phone\":\"+13062625152\"},{\"id\":\"3\",\"email\":\"gulati.adevjit@gmail.com\",\"location\":\"MAJOR MASSAGE\",\"phone\":\"+13062625154\"}]','2019-04-07 20:46:55','2019-04-07 20:46:55','C','E'),
	(85,39,2,3,30,52.108960,-106.672096,'2019-04-07','2019-04-07 15:30:00','2019-04-07 20:30:00',37.00,0.00,NULL,NULL,NULL,NULL,NULL,'W',0,'[{\"id\":\"6\",\"email\":\"testasd@mail.com\",\"location\":\"MASTER\",\"phone\":\"+13062625152\"},{\"id\":\"1\",\"email\":\"adevjit@gmail.com\",\"location\":\"SASKATOON WELNESS - JILL RMT500 \",\"phone\":\"+13062625152\"},{\"id\":\"3\",\"email\":\"gulati.adevjit@gmail.com\",\"location\":\"MAJOR MASSAGE\",\"phone\":\"+13062625154\"}]','2019-04-07 20:47:58','2019-04-07 20:47:58','C','E'),
	(86,39,3,13,30,52.108998,-106.672343,'2019-04-18','2019-04-18 09:00:00','2019-04-18 20:30:00',37.00,0.00,NULL,NULL,NULL,NULL,NULL,'W',0,'[{\"id\":\"6\",\"email\":\"testasd@mail.com\",\"location\":\"MASTER\",\"phone\":\"+13062625152\"},{\"id\":\"1\",\"email\":\"adevjit@gmail.com\",\"location\":\"SASKATOON WELNESS - JILL RMT500 \",\"phone\":\"+13062625152\"},{\"id\":\"3\",\"email\":\"gulati.adevjit@gmail.com\",\"location\":\"MAJOR MASSAGE\",\"phone\":\"+13062625154\"}]','2019-04-18 02:46:59','2019-04-18 02:46:59','C','E');

/*!40000 ALTER TABLE `holdingtransactions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table instaprices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `instaprices`;

CREATE TABLE `instaprices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `price` decimal(5,2) NOT NULL,
  `servicecategories_id` int(10) unsigned NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `instaprices_servicecategories_id_foreign` (`servicecategories_id`),
  CONSTRAINT `instaprices_servicecategories_id_foreign` FOREIGN KEY (`servicecategories_id`) REFERENCES `servicecategories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `instaprices` WRITE;
/*!40000 ALTER TABLE `instaprices` DISABLE KEYS */;

INSERT INTO `instaprices` (`id`, `price`, `servicecategories_id`, `start_date`, `end_date`, `created_at`, `updated_at`)
VALUES
	(1,80.00,2,NULL,NULL,NULL,NULL),
	(2,60.00,3,NULL,NULL,NULL,NULL),
	(3,30.00,13,NULL,NULL,NULL,NULL),
	(4,90.00,14,NULL,NULL,NULL,NULL),
	(5,120.00,15,NULL,NULL,NULL,NULL),
	(6,100.00,13,NULL,NULL,'2019-04-03 18:39:40','2019-04-03 18:39:40');

/*!40000 ALTER TABLE `instaprices` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table invoices
# ------------------------------------------------------------

DROP TABLE IF EXISTS `invoices`;

CREATE TABLE `invoices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `amountpaid` decimal(8,2) DEFAULT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `tobepaidby` date NOT NULL,
  `paidon` date NOT NULL,
  `sent_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table location_locationtype
# ------------------------------------------------------------

DROP TABLE IF EXISTS `location_locationtype`;

CREATE TABLE `location_locationtype` (
  `location_id` int(11) NOT NULL,
  `locationtype_id` int(11) NOT NULL,
  PRIMARY KEY (`locationtype_id`,`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `location_locationtype` WRITE;
/*!40000 ALTER TABLE `location_locationtype` DISABLE KEYS */;

INSERT INTO `location_locationtype` (`location_id`, `locationtype_id`)
VALUES
	(4,1),
	(1,2),
	(3,2),
	(6,2),
	(1,3),
	(1,4),
	(2,4),
	(3,4),
	(4,4),
	(5,4),
	(6,4),
	(5,5);

/*!40000 ALTER TABLE `location_locationtype` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table locationpercentages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locationpercentages`;

CREATE TABLE `locationpercentages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `cashpaymentpercent` int(11) DEFAULT '10',
  `creditpaymentpercent` int(11) NOT NULL DEFAULT '15',
  `creditpaymentcents` decimal(4,2) DEFAULT NULL,
  `contract_start` date NOT NULL,
  `contract_end` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `locationpercentages` WRITE;
/*!40000 ALTER TABLE `locationpercentages` DISABLE KEYS */;

INSERT INTO `locationpercentages` (`id`, `location_id`, `cashpaymentpercent`, `creditpaymentpercent`, `creditpaymentcents`, `contract_start`, `contract_end`, `created_at`, `updated_at`)
VALUES
	(1,1,0,15,NULL,'2018-10-05','2019-10-05','2018-10-16 17:24:27','2018-10-16 17:24:27'),
	(4,2,0,15,0.30,'2018-10-05','2019-10-05','2018-10-16 17:24:27','2018-10-16 17:24:27'),
	(5,3,0,15,0.30,'2018-10-05','2019-10-05','2018-10-16 17:24:27','2018-10-16 17:24:27'),
	(6,4,0,15,0.30,'2018-10-05','2019-10-05','2018-10-16 17:24:27','2018-10-16 17:24:27'),
	(7,5,0,15,0.30,'2018-10-05','2019-10-05','2018-10-16 17:24:27','2018-10-16 17:24:27'),
	(8,6,0,15,NULL,'2018-10-05','2019-10-05','2018-10-16 17:24:27','2018-10-16 17:24:27');

/*!40000 ALTER TABLE `locationpercentages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table locations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `manager_id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `postalcode` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` text COLLATE utf8mb4_unicode_ci,
  `long` text COLLATE utf8mb4_unicode_ci,
  `city` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'America/Regina',
  `features` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A',
  `googleraiting` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `notifywho` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'L',
  `hours` tinyint(1) NOT NULL DEFAULT '1',
  `variedprices` tinyint(1) NOT NULL DEFAULT '0',
  `cashonly` tinyint(1) NOT NULL DEFAULT '0',
  `number_reviews` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;

INSERT INTO `locations` (`id`, `manager_id`, `name`, `address`, `phone`, `postalcode`, `lat`, `long`, `city`, `province`, `created_at`, `updated_at`, `deleted_at`, `logo`, `locale`, `features`, `googleraiting`, `notifywho`, `hours`, `variedprices`, `cashonly`, `number_reviews`, `description`)
VALUES
	(1,1,'SASKATOON WELNESS - JILL RMT500 ','3102 CLARENCE AVE S - User backdoor','+13062625152','S7T0C9','52.085392','-106.646987','SASKATOON','SASKATCHEWAN','2018-03-05 21:48:33','2018-09-22 19:26:18',NULL,'test','AMERICA/REGINA','A','5','',0,0,0,0,'test description'),
	(2,2,'SASKATOON WELNESS - JILL RMT','1114 22 ST W B','+13062625153','S7M0S5','52.129570','-106.686648','SASKATOON','SASKATCHEWAN','2018-03-05 23:05:20','2018-03-05 23:05:20',NULL,'https://s3.ca-central-1.amazonaws.com/instawalkin-images/salon.jpeg','AMERICA/REGINA','A','2.7','L',1,0,0,0,NULL),
	(3,3,'MAJOR MASSAGE','102 20TH ST W','+13062625154','S7M0W6','52.126290','-106.670784','SASKATOON','SASKATCHEWAN','2018-03-05 23:11:09','2018-03-05 23:11:09',NULL,'https://s3.ca-central-1.amazonaws.com/instawalkin-images/salon.jpeg','AMERICA/REGINA','A','5','E',1,0,1,0,NULL),
	(4,4,'AMANDAS NAIL','1704 COY AVENUE','+13062625155','S7M0H7','52.108914','-106.672385','SASKATOON','SASKATCHEWAN','2018-03-05 23:13:50','2018-09-22 18:35:04',NULL,'https://s3.ca-central-1.amazonaws.com/instawalkin-images/salon.jpeg','AMERICA/REGINA','I','5','',1,0,0,0,NULL),
	(5,5,'AJS PHYISO','1-203 HEROLD TERRACE','+13062625156','S7V1H4','52.101541','-106.568131','SASKATOON','SASKATCHEWAN','2018-03-05 23:15:23','2018-03-05 23:15:23',NULL,'https://s3.ca-central-1.amazonaws.com/instawalkin-images/salon.jpeg','AMERICA/REGINA','S','5','E',1,0,0,0,NULL),
	(6,6,'MASTER','102 - 3102 CLARENCE AVE','+13062625152','S7N2X9','52.120076','-106.657360','SASKATOON','SASKATCHEWAN','2018-09-22 19:40:33','2018-09-22 19:40:33',NULL,'pet_icon.png','AMERICA/REGINA','A','5','L',1,0,1,0,NULL);

/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table locationtypes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locationtypes`;

CREATE TABLE `locationtypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `locationtypes` WRITE;
/*!40000 ALTER TABLE `locationtypes` DISABLE KEYS */;

INSERT INTO `locationtypes` (`id`, `description`, `created_at`, `updated_at`, `deleted_at`, `logo`)
VALUES
	(1,'NAIL SERVICES','2018-03-05 21:18:56','2018-03-05 21:18:56',NULL,'nail_icon.png'),
	(2,'MASSAGE SERVICES RMT','2018-03-05 21:19:33','2018-03-05 21:19:33',NULL,'massage_icon.png'),
	(3,'HAIR SERVICES','2018-03-05 21:19:40','2018-03-05 21:19:40',NULL,'hair_icon.png'),
	(4,'ESTHETICIAN SERVICES','2018-03-05 21:19:54','2018-03-05 21:19:54',NULL,'eyes_icon.png'),
	(5,'PHYSIO AND CHIRO SERVICES','2018-03-05 21:20:07','2018-03-05 21:20:07',NULL,'chiro_icon.png'),
	(6,'PET SERVICES','2018-04-13 13:33:54','2018-04-13 13:33:59',NULL,'pet_icon.png'),
	(7,'Chiropractor Services',NULL,NULL,NULL,'barber_icon.png');

/*!40000 ALTER TABLE `locationtypes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table locationtypes_servicecategories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `locationtypes_servicecategories`;

CREATE TABLE `locationtypes_servicecategories` (
  `ltype_id` int(11) NOT NULL,
  `scategories_id` int(11) NOT NULL,
  PRIMARY KEY (`ltype_id`,`scategories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `locationtypes_servicecategories` WRITE;
/*!40000 ALTER TABLE `locationtypes_servicecategories` DISABLE KEYS */;

INSERT INTO `locationtypes_servicecategories` (`ltype_id`, `scategories_id`)
VALUES
	(1,1),
	(1,8),
	(1,9),
	(1,12),
	(2,2),
	(2,3),
	(2,4),
	(3,1),
	(3,5),
	(3,7),
	(4,1),
	(4,10),
	(5,2),
	(5,3),
	(5,6),
	(6,11);

/*!40000 ALTER TABLE `locationtypes_servicecategories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table manager_licenses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `manager_licenses`;

CREATE TABLE `manager_licenses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `manager_id` int(10) unsigned NOT NULL,
  `license_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validated` tinyint(1) NOT NULL,
  `expired_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `manager_licenses_manager_id_foreign` (`manager_id`),
  CONSTRAINT `manager_licenses_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `managers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table manager_notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `manager_notifications`;

CREATE TABLE `manager_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `manager_id` int(11) NOT NULL,
  `desktop` tinyint(1) NOT NULL DEFAULT '1',
  `desktopsound` tinyint(1) NOT NULL DEFAULT '1',
  `web` tinyint(1) NOT NULL DEFAULT '1',
  `websound` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `alwaysonline` tinyint(1) NOT NULL DEFAULT '0',
  `switchtophone` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table manager_profiles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `manager_profiles`;

CREATE TABLE `manager_profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `manager_id` int(10) unsigned NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `manager_profiles_manager_id_foreign` (`manager_id`),
  CONSTRAINT `manager_profiles_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `managers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table manager_reviews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `manager_reviews`;

CREATE TABLE `manager_reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table managers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `managers`;

CREATE TABLE `managers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `lastpasswordchange_date` timestamp NULL DEFAULT NULL,
  `emailsent` tinyint(1) NOT NULL DEFAULT '0',
  `emailconfirmed` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `statusreason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `timekit_resource_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `managers_email_unique` (`email`),
  UNIQUE KEY `managers_timekit_resource_id_unique` (`timekit_resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `managers` WRITE;
/*!40000 ALTER TABLE `managers` DISABLE KEYS */;

INSERT INTO `managers` (`id`, `email`, `password`, `online`, `lastpasswordchange_date`, `emailsent`, `emailconfirmed`, `status`, `statusreason`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `timekit_resource_id`, `first_name`, `last_name`, `gender`)
VALUES
	(1,'adevjit@gmail.com','$2y$10$cUHljssluM0D848LhiKaJuHbjMs7yC0i/8yeutzHVR6Ef2XQygjW6',0,NULL,0,0,1,NULL,'jp8713gDfGYGgxdle6gqTTgB8KuiFX6nykrbpupg6HePDs6xM90d9kx98scQ','2018-03-05 21:32:44','2018-08-01 01:27:56',NULL,NULL,NULL,NULL,NULL),
	(2,'adevjit@hotmail.com','$2y$10$kdGQHNXlNWuAbpSc.6VFu.GOTCmMbOpCCK7csmFzLGj2SXQzVkrLO',0,NULL,0,0,1,NULL,'JM6EuYtWAE9tWVq6SLQBisH7A8gXKcyKszNURmEAM1YtUFd5qEAYanvz0Dnz','2018-03-05 22:59:03','2018-03-05 22:59:03',NULL,NULL,NULL,NULL,NULL),
	(3,'gulati.adevjit@gmail.com','$2y$10$O3kwBHWQGsiVhf3vQtuwU.a/wJuY3INolm1o3LVNZPCHAJNxYqK56',0,NULL,0,0,1,NULL,'wLc1plZcBjgHoHGwx0sdsVbjSDwRkEG4sUVBIF2IJ6yGsbGvdOilTHf9IvWY','2018-03-05 22:59:54','2018-03-05 22:59:54',NULL,NULL,NULL,NULL,NULL),
	(4,'asmednziuk@hotmail.com','$2y$10$BVdwCsHpf2RBnakFzGv.I.BqBrcgMYsfNfTHd7fWE4lV7IFbFH9z2',0,NULL,0,0,1,NULL,NULL,'2018-03-05 23:00:39','2018-03-05 23:00:39',NULL,NULL,NULL,NULL,NULL),
	(5,'aj.gulati@instawalkin.com','$2y$10$ewnpYWvW5w3pHeGCCcStdeQgbqFjjJHuGC3CybC4lKWDLHlTkI5VO',0,NULL,0,0,1,NULL,NULL,'2018-03-05 23:01:24','2018-03-05 23:01:24',NULL,NULL,NULL,NULL,NULL),
	(6,'testasd@mail.com','$2y$10$FoB3MHFX57ESKF7LCjMRN.7DgLGdmBisKEtaPkUmc5yXu1Zj47xjK',0,NULL,0,0,1,NULL,NULL,'2018-08-19 23:44:54','2018-08-19 23:44:54',NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `managers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table managers_password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `managers_password_resets`;

CREATE TABLE `managers_password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `managers_password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `managers_password_resets` WRITE;
/*!40000 ALTER TABLE `managers_password_resets` DISABLE KEYS */;

INSERT INTO `managers_password_resets` (`email`, `token`, `created_at`)
VALUES
	('adevjit@gmail.com','$2y$10$vdrQ64oUmDveewzlOG0fTu6voCktdtzV3b0ZVJcTEby/v.GjwY4Oa','2019-01-10 00:08:52');

/*!40000 ALTER TABLE `managers_password_resets` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table managers_projects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `managers_projects`;

CREATE TABLE `managers_projects` (
  `timekit_resource_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timekit_project_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  KEY `managers_projects_timekit_resource_id_foreign` (`timekit_resource_id`),
  KEY `managers_projects_project_id_foreign` (`project_id`),
  CONSTRAINT `managers_projects_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `managers_projects_timekit_resource_id_foreign` FOREIGN KEY (`timekit_resource_id`) REFERENCES `managers` (`timekit_resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(481,'2014_10_12_000000_create_users_table',1),
	(482,'2014_10_12_100000_create_password_resets_table',1),
	(483,'2017_04_13_010614_create_locations_table',1),
	(484,'2017_04_13_013310_create_services_table',1),
	(485,'2017_04_22_004045_create_managers_table',1),
	(486,'2017_05_05_042655_create_locationtypes_table',1),
	(487,'2017_05_06_212801_create_employees_table',1),
	(488,'2017_05_06_212854_create_genders_table',1),
	(489,'2017_05_06_215617_create_categories_table',1),
	(490,'2017_05_08_233743_create_businessservices_table',1),
	(491,'2017_05_08_233936_create_servicecategories_table',1),
	(492,'2017_05_22_181347_create_userprofiles_table',1),
	(493,'2017_06_15_224847_create_stripedatas_table',1),
	(494,'2017_06_15_224919_create_subscriptions_table',1),
	(495,'2017_08_01_023401_create_admins_table',1),
	(496,'2017_08_01_024645_create_user_notifications_table',1),
	(497,'2017_08_01_024832_create_manager_reviews_table',1),
	(498,'2017_08_01_024919_create_requests_table',1),
	(499,'2017_09_17_043650_changeservicescolumn',1),
	(500,'2017_09_17_194454_addmanagercolumns',1),
	(501,'2017_09_20_041849_addresetpasswordfieldtomanager',1),
	(502,'2017_09_22_012159_addonlinestatustomanagers',1),
	(503,'2017_10_04_022528_addApikeytoUsers',1),
	(504,'2017_10_15_153614_addcolumnstousers',1),
	(505,'2017_10_17_231908_alterusernotificationstable',1),
	(506,'2017_10_18_233736_alterstripedata',1),
	(507,'2017_10_21_190049_create_partner_forms_table',1),
	(508,'2017_10_21_190119_create_contact_forms_table',1),
	(509,'2017_10_24_235052_managers_password_resets',1),
	(510,'2017_10_26_233751_create_manager_notifications_table',1),
	(511,'2017_10_28_201228_create_taxes_table',1),
	(512,'2017_10_28_201256_create_tax_services_table',1),
	(513,'2017_10_28_210344_create_transactions_table',1),
	(514,'2017_10_28_211536_create_multi_service_locations_table',1),
	(515,'2017_10_30_232358_altercolumns',1),
	(516,'2017_10_31_003307_add_pivot_tables',1),
	(517,'2017_11_13_190416_create_locationtypes_servicecategories_table',1),
	(518,'2017_11_14_044728_create_sessions_table',1),
	(519,'2017_11_20_000824_softdelete',1),
	(520,'2017_11_20_001619_softdeletetwo',1),
	(521,'2017_11_20_021048_softdeletethree',1),
	(522,'2017_12_23_165540_AlterEmployeeandPricing',1),
	(523,'2017_12_25_235222_CreateDayschdeule',1),
	(524,'2018_01_30_020304_addOnlineAndSwitch',1),
	(525,'2018_02_12_045031_create_timing_tables',1),
	(526,'2018_02_25_003748_stat_holidays',1),
	(527,'2018_02_25_213652_create__expo_transactions__table',1),
	(528,'2018_03_01_042721_create_jobs_table',1),
	(529,'2018_03_01_234804_alter_employee',1),
	(530,'2018_03_02_002200_alter_schedule',1),
	(531,'2018_03_02_003123_alter_locations_locale_typeofservice',1),
	(532,'2018_03_02_011644_alter_dayschedule',1),
	(533,'2018_03_04_235225_create_employee_service_pivot',1),
	(534,'2018_03_05_190859_alert_locations_notifywhocode',1),
	(535,'2018_03_05_205654_gender_employee_alter',1),
	(536,'2018_05_21_194411_add_employeecolumn_to_transactions',2),
	(537,'2018_06_12_234642_alter_transactionstable',3),
	(538,'2018_06_27_011302_addunique_keys_to_usersprofile',4),
	(540,'2018_07_17_025003_beta_sign_up',5),
	(541,'2018_08_14_003714_alter_transactions',6),
	(542,'2018_08_29_234050_biweekly',7),
	(543,'2018_09_09_031536_alter_usernotfiications',8),
	(544,'2018_09_11_031228_alter_transactions_userprofiles_table',9),
	(546,'2018_09_15_025300_add_alternate_description_service',10),
	(547,'2018_09_18_010521_create_asterix_descriptions',11),
	(548,'2018_09_20_194649_add_invoice_table_and_cahs_only',12),
	(549,'2018_10_02_022914_transaction_table_tip_changes',13),
	(551,'2018_10_07_032433_alter_transacrtion_arrival_at',14),
	(553,'2018_10_11_010813_alter_users_table_aws',15),
	(554,'2018_10_14_164926_add_skip_credit_card',16),
	(555,'2018_10_16_172124_alter_location_percentages',16),
	(556,'2018_11_02_012029_add_discount_unsubscribe_email',17),
	(558,'2016_05_17_221000_create_promocodes_table',18),
	(559,'2018_11_21_034122_create_credit_user_histroy_table',19),
	(571,'2016_06_01_000001_create_oauth_auth_codes_table',20),
	(572,'2016_06_01_000002_create_oauth_access_tokens_table',20),
	(573,'2016_06_01_000003_create_oauth_refresh_tokens_table',20),
	(574,'2016_06_01_000004_create_oauth_clients_table',20),
	(575,'2016_06_01_000005_create_oauth_personal_access_clients_table',20),
	(576,'2018_11_26_232336_create_promocodetransaction_table',21),
	(577,'2018_12_01_211151_edit_user_credit',22),
	(585,'2018_12_11_033215_leftamount_default',23),
	(586,'2019_02_09_011846_create_review_tables',24),
	(588,'2019_02_11_220801_create_table_corppromo_dailypromos',25),
	(594,'2019_02_18_195101_add_numberofreviews_location',26),
	(595,'2019_02_25_034737_create_insta_prices_table',26),
	(596,'2019_02_27_003921_create_appconfig__table',27),
	(599,'2019_03_08_223645_create_holdingtransactions_table',28),
	(603,'2019_03_18_041036_alter_holdingtransactions_table',29),
	(605,'2019_03_28_213420_create_notifications_sent_table',30),
	(607,'2019_03_30_221003_alter_appconfig_table',31),
	(609,'2019_04_10_043919_create_corprequests_table',32),
	(610,'2019_04_17_003736_create_failed_jobs_table',33),
	(611,'2018_01_01_000000_create_action_events_table',34),
	(612,'2019_05_10_000000_add_fields_to_action_events_table',35),
	(613,'2019_07_03_223817_add_id_project_table',35),
	(614,'2019_07_03_231231_create_table_manager_profile_table',35),
	(615,'2019_07_03_231243_create_table_manager_liscence_table',35),
	(616,'2019_07_05_004038_create_projects_table',35),
	(617,'2019_07_05_004213_create_managers_projects_table',35),
	(618,'2019_07_08_232025_add_first_last_gender_managers',35);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table notification_limit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notification_limit`;

CREATE TABLE `notification_limit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_minutes` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notification_limit_description_unique` (`description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table notificationcodes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notificationcodes`;

CREATE TABLE `notificationcodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notificationcodes_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `notificationcodes` WRITE;
/*!40000 ALTER TABLE `notificationcodes` DISABLE KEYS */;

INSERT INTO `notificationcodes` (`id`, `code`, `description`, `created_at`, `updated_at`)
VALUES
	(1,'N','NO NOTIFICATION',NULL,NULL),
	(2,'T','TEXT',NULL,NULL),
	(3,'E','EMAIL',NULL,NULL);

/*!40000 ALTER TABLE `notificationcodes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table notifications_off
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notifications_off`;

CREATE TABLE `notifications_off` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notification_limit_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table notifications_sent
# ------------------------------------------------------------

DROP TABLE IF EXISTS `notifications_sent`;

CREATE TABLE `notifications_sent` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `priority` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `notification_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_sent_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_sent_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `notifications_sent` WRITE;
/*!40000 ALTER TABLE `notifications_sent` DISABLE KEYS */;

INSERT INTO `notifications_sent` (`id`, `priority`, `user_id`, `notification_data`, `read`, `created_at`, `updated_at`)
VALUES
	(8,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\",\"notification\":{\"title\":\"Sorry\",\"body\":\"No service provider available right now.\"}}',1,'2019-03-29 02:21:01','2019-03-29 02:34:50'),
	(9,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\",\"notification\":{\"title\":\"Sorry\",\"body\":\"No service provider available right now.\"}}',1,'2019-03-29 02:29:59','2019-03-29 02:34:40'),
	(10,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\",\"notification\":{\"title\":\"Sorry\",\"body\":\"No service provider available right now.\"}}',1,'2019-03-29 02:54:26','2019-03-29 02:54:27'),
	(11,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\",\"notification\":{\"title\":\"Sorry\",\"body\":\"No service provider available right now.\"}}',1,'2019-03-29 02:54:35','2019-03-29 02:55:01'),
	(12,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\",\"notification\":{\"title\":\"Sorry\",\"body\":\"No service provider available right now.\"}}',1,'2019-03-29 02:55:14','2019-03-29 02:55:21'),
	(13,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\",\"notification\":{\"title\":\"Sorry\",\"body\":\"No service provider available right now.\"}}',1,'2019-03-29 02:55:27','2019-03-29 02:55:31'),
	(14,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\",\"notification\":{\"title\":\"Sorry\",\"body\":\"No service provider available right now.\"}}',1,'2019-03-29 23:56:23','2019-03-29 23:56:25'),
	(15,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\",\"notification\":{\"title\":\"Sorry\",\"body\":\"No service provider available right now.\"}}',1,'2019-03-29 23:56:31','2019-03-30 18:37:40'),
	(16,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\",\"notification\":{\"title\":\"Sorry\",\"body\":\"No service provider available right now.\"}}',1,'2019-03-30 18:39:30','2019-03-30 18:40:06'),
	(17,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\",\"notification\":{\"title\":\"Sorry\",\"body\":\"No service provider available right now.\"}}',1,'2019-03-30 18:39:30','2019-03-30 18:39:34'),
	(18,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\",\"notification\":{\"title\":\"Sorry\",\"body\":\"No service provider available right now.\"}}',1,'2019-03-30 18:39:50','2019-03-30 18:40:01'),
	(24,'1',39,'{\"data\":{\"priority\":\"1\",\"body\":\"You have been connected.\",\"title\":\"Connected!\",\"payload\":\"{\\\"user_id\\\":39,\\\"expotoken\\\":\\\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\\\",\\\"order\\\":387,\\\"created_at\\\":\\\"2018-12-09T06:02:31.000Z\\\",\\\"time\\\":\\\"2018-12-09T06:02:31.000Z\\\",\\\"location\\\":\\\"SASKATOON WELNESS - JILL RMT500 \\\",\\\"service\\\":\\\"HAIR CUT\\\",\\\"serviceamount\\\":40,\\\"taxamount\\\":2,\\\"address\\\":\\\"3102 CLARENCE AVE S - User backdoor\\\",\\\"city\\\":\\\"SASKATOON\\\",\\\"postalcode\\\":\\\"S7T0C9\\\",\\\"lattitude\\\":\\\"52.085392\\\",\\\"longitude\\\":\\\"-106.646987\\\",\\\"email\\\":\\\"adevjit@gmail.com\\\",\\\"username\\\":\\\"Feexk\\\",\\\"phone\\\":\\\"+13062665152\\\",\\\"lastname\\\":\\\"Fecg\\\",\\\"arrival_at\\\":\\\"2018-12-09T06:18:31.000Z\\\",\\\"coupon_amount_calc\\\":100,\\\"tipamount\\\":0,\\\"totalamount\\\":-58}\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\",\"notification\":{\"title\":\"Connected!\",\"body\":\"You have been connected to SASKATOON WELNESS - JILL RMT500 . Your appointment starts atSun Dec 09 2018 00:18:31 GMT-0600 (CST) please be there 10 minutes early.\"}}',1,'2019-03-30 19:42:48','2019-03-30 19:52:17'),
	(25,'1',39,'{\"data\":{\"priority\":\"1\",\"body\":\"You have been connected.\",\"title\":\"Connected!\",\"payload\":\"{\\\"user_id\\\":39,\\\"expotoken\\\":\\\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\\\",\\\"order\\\":385,\\\"created_at\\\":\\\"2018-12-09T05:54:58.000Z\\\",\\\"time\\\":\\\"2018-12-09T05:54:58.000Z\\\",\\\"location\\\":\\\"SASKATOON WELNESS - JILL RMT500 \\\",\\\"service\\\":\\\"HAIR CUT\\\",\\\"serviceamount\\\":40,\\\"taxamount\\\":2,\\\"address\\\":\\\"3102 CLARENCE AVE S - User backdoor\\\",\\\"city\\\":\\\"SASKATOON\\\",\\\"postalcode\\\":\\\"S7T0C9\\\",\\\"lattitude\\\":\\\"52.085392\\\",\\\"longitude\\\":\\\"-106.646987\\\",\\\"email\\\":\\\"adevjit@gmail.com\\\",\\\"username\\\":\\\"Feexk\\\",\\\"phone\\\":\\\"+13062665152\\\",\\\"lastname\\\":\\\"Fecg\\\",\\\"arrival_at\\\":\\\"2018-12-09T06:11:58.000Z\\\",\\\"coupon_amount_calc\\\":100,\\\"tipamount\\\":0,\\\"totalamount\\\":-58}\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3\",\"notification\":{\"title\":\"Connected!\",\"body\":\"You have been connected to SASKATOON WELNESS - JILL RMT500 . Your appointment starts atSun Dec 09 2018 00:11:58 GMT-0600 (CST) please be there 10 minutes early.\"}}',1,'2019-03-30 19:52:43','2019-03-30 19:53:19'),
	(26,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"cEaXogOeZWI:APA91bFSjWJ1zgRJI1Ds3_HRXXo60p-9Nv4Ru3cXOo9_ijynaumxvVSlMZyqV5r02YSVGn1cbtxANcpTRhjeEfxpBECqZw3N-fl1yZs7ddqUw2A3ON-FzzxCoV6wcMZTz2irzcdLRp2n\",\"notification\":{\"title\":\"Sorry\",\"body\":\"Instawalkin here. All our providers are currently busy, please try again later or change your filter settings.\"}}',1,'2019-04-01 19:18:59','2019-04-01 19:19:09'),
	(27,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"cEaXogOeZWI:APA91bFSjWJ1zgRJI1Ds3_HRXXo60p-9Nv4Ru3cXOo9_ijynaumxvVSlMZyqV5r02YSVGn1cbtxANcpTRhjeEfxpBECqZw3N-fl1yZs7ddqUw2A3ON-FzzxCoV6wcMZTz2irzcdLRp2n\",\"notification\":{\"title\":\"Sorry\",\"body\":\"Instawalkin here. All our providers are currently busy, please try again later or change your filter settings.\"}}',1,'2019-04-01 19:19:12','2019-04-01 19:19:13'),
	(28,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"cEaXogOeZWI:APA91bFSjWJ1zgRJI1Ds3_HRXXo60p-9Nv4Ru3cXOo9_ijynaumxvVSlMZyqV5r02YSVGn1cbtxANcpTRhjeEfxpBECqZw3N-fl1yZs7ddqUw2A3ON-FzzxCoV6wcMZTz2irzcdLRp2n\",\"notification\":{\"title\":\"Sorry\",\"body\":\"Instawalkin here. All our providers are currently busy, please try again later or change your filter settings.\"}}',1,'2019-04-01 19:19:23','2019-04-01 19:19:26'),
	(29,'0',39,'{\"data\":{\"priority\":\"0\",\"body\":\"No service provider available right now.\",\"title\":\"Sorry\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"cEaXogOeZWI:APA91bFSjWJ1zgRJI1Ds3_HRXXo60p-9Nv4Ru3cXOo9_ijynaumxvVSlMZyqV5r02YSVGn1cbtxANcpTRhjeEfxpBECqZw3N-fl1yZs7ddqUw2A3ON-FzzxCoV6wcMZTz2irzcdLRp2n\",\"notification\":{\"title\":\"Sorry\",\"body\":\"Instawalkin here. All our providers are currently busy, please try again later or change your filter settings.\"}}',1,'2019-04-01 19:19:30','2019-04-01 19:19:43'),
	(30,'1',39,'{\"data\":{\"priority\":\"1\",\"body\":\"You have been connected.\",\"title\":\"Connected!\",\"payload\":\"{\\\"user_id\\\":39,\\\"expotoken\\\":\\\"cEaXogOeZWI:APA91bFSjWJ1zgRJI1Ds3_HRXXo60p-9Nv4Ru3cXOo9_ijynaumxvVSlMZyqV5r02YSVGn1cbtxANcpTRhjeEfxpBECqZw3N-fl1yZs7ddqUw2A3ON-FzzxCoV6wcMZTz2irzcdLRp2n\\\",\\\"order\\\":395,\\\"created_at\\\":\\\"2018-12-09T06:21:22.000Z\\\",\\\"time\\\":\\\"2018-12-09T06:21:22.000Z\\\",\\\"location\\\":\\\"SASKATOON WELNESS - JILL RMT500 \\\",\\\"service\\\":\\\"HAIR CUT\\\",\\\"serviceamount\\\":40,\\\"taxamount\\\":2,\\\"address\\\":\\\"3102 CLARENCE AVE S - User backdoor\\\",\\\"city\\\":\\\"SASKATOON\\\",\\\"postalcode\\\":\\\"S7T0C9\\\",\\\"lattitude\\\":\\\"52.085392\\\",\\\"longitude\\\":\\\"-106.646987\\\",\\\"email\\\":\\\"adevjit@gmail.com\\\",\\\"username\\\":\\\"Feexk\\\",\\\"phone\\\":\\\"+13062665152\\\",\\\"lastname\\\":\\\"Fecg\\\",\\\"arrival_at\\\":\\\"2018-12-09T06:51:22.000Z\\\",\\\"coupon_amount_calc\\\":null,\\\"tipamount\\\":0,\\\"totalamount\\\":42}\"},\"android\":{\"ttl\":3600000,\"notification\":{\"icon\":\"stock_ticker_update\",\"color\":\"#f45342\"}},\"apns\":{\"payload\":{\"aps\":{\"content_available\":true}}},\"token\":\"cEaXogOeZWI:APA91bFSjWJ1zgRJI1Ds3_HRXXo60p-9Nv4Ru3cXOo9_ijynaumxvVSlMZyqV5r02YSVGn1cbtxANcpTRhjeEfxpBECqZw3N-fl1yZs7ddqUw2A3ON-FzzxCoV6wcMZTz2irzcdLRp2n\",\"notification\":{\"title\":\"Connected!\",\"body\":\"You have been connected to SASKATOON WELNESS - JILL RMT500 . Your appointment starts atSun Dec 09 2018 00:51:22 GMT-0600 (CST) please be there 10 minutes early.\"}}',1,'2019-04-01 19:20:47','2019-04-08 05:10:55');

/*!40000 ALTER TABLE `notifications_sent` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table oauth_access_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_access_tokens`;

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table oauth_auth_codes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_auth_codes`;

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table oauth_clients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_clients`;

CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table oauth_personal_access_clients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_personal_access_clients`;

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table oauth_refresh_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_refresh_tokens`;

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table partner_forms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `partner_forms`;

CREATE TABLE `partner_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `businessname` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `contactname` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `contactphone` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `contactemail` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `acknowledged` tinyint(1) NOT NULL DEFAULT '0',
  `contacted` tinyint(1) NOT NULL DEFAULT '0',
  `partner` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `partner_forms` WRITE;
/*!40000 ALTER TABLE `partner_forms` DISABLE KEYS */;

INSERT INTO `partner_forms` (`id`, `businessname`, `contactname`, `contactphone`, `contactemail`, `city`, `acknowledged`, `contacted`, `partner`, `created_at`, `updated_at`)
VALUES
	(1,'test','test','3062625152','adevjit@gmail.com','saskatoon',0,0,0,'2018-07-21 05:04:26','2018-07-21 05:04:26'),
	(2,'test','test','3062625152','adevjit@gmail.com','saskatoon',0,0,0,'2018-07-21 05:04:44','2018-07-21 05:04:44'),
	(3,'test','test','3062625152','adevjit@gmail.com','saskatoon',0,0,0,'2018-07-21 05:06:31','2018-07-21 05:06:31'),
	(4,'test','test','3062625152','adevjit@gmail.com','saskatoon',0,0,0,'2018-07-21 05:06:49','2018-07-21 05:06:49'),
	(5,'test','test','3062625152','adevjit@gmail.com','saskatoon',0,0,0,'2018-07-21 05:07:35','2018-07-21 05:07:35'),
	(6,'adevjit','gulati','3062625152','adevjit@gmail.com','saskatoon',0,0,0,'2018-07-21 05:09:01','2018-07-21 05:09:01'),
	(7,'adevjit','test name','3062625152','adevjit@gmail.com','saskatoon',0,0,0,'2018-07-21 05:13:03','2018-07-21 05:13:03'),
	(8,'adevit','adevjit gulati','3062625152','adevjit@gmail.com','saskatoon',0,0,0,'2018-07-21 05:14:37','2018-07-21 05:14:37'),
	(9,'adevjit','adevjit','3062625152','adevjit@gmail.com','saskatoon',0,0,0,'2018-07-21 05:15:40','2018-07-21 05:15:40'),
	(10,'adevji','adev','3062625152','adevjit@gmail.com','saskatoon',0,0,0,'2018-07-21 05:18:44','2018-07-21 05:18:44'),
	(11,'adevjit','ade','3062625152','adevjit@gmail.com','sadasdsa',0,0,0,'2018-07-21 05:20:03','2018-07-21 05:20:03'),
	(12,'adevjit','adevjit','3062625152','adevjit@gmail.com','asdasds',0,0,0,'2018-07-21 05:21:37','2018-07-21 05:21:37'),
	(13,'adev','adevjit','3062625152','adevjit@gmail.com','saskatoon',0,0,0,'2018-07-21 05:25:34','2018-07-21 05:25:34'),
	(14,'adevjit','adevjit@gmail.com','3062625152','adevjit@gmail.com','asdsad',0,0,0,'2018-07-21 05:27:50','2018-07-21 05:27:50'),
	(15,'adevjit','adevjit','3062625152','adevjit@gmail.com','saskatoon',0,0,0,'2018-07-21 05:28:50','2018-07-21 05:28:50'),
	(16,'test','test','30626251552','adevjit@gmail.com','saskatoon',0,0,0,'2018-07-21 05:31:37','2018-07-21 05:31:37'),
	(17,'asdsd','asdsad','asdsad','asg@mi.com','asdasd',0,0,0,'2018-10-16 22:15:34','2018-10-16 22:15:34'),
	(18,'test','test','3062625152','asg452@mail.usask.ca','saskatoon',0,0,0,'2019-01-30 04:35:54','2019-01-30 04:35:54');

/*!40000 ALTER TABLE `partner_forms` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;

INSERT INTO `password_resets` (`email`, `token`, `created_at`)
VALUES
	('adevjit@gmail.com','$2y$10$.MjabXcWerZdGTByVgYdkemOccZsK0og6FB0xuRRjFYIEivrnUqFS','2018-10-09 00:11:59'),
	('test-c50cj@mail-tester.com','$2y$10$2boK.saruEtG3b0Jt1tni.aoyBcHTON8CaN2AXNMo0iy51suSd.ei','2019-01-08 04:32:44'),
	('fec@fec.com','$2y$10$XKG3wE5KCE8cOC7.37dc3.Z1T4TG6tg9nIk6JekE5VH3RzRCh832O','2019-01-10 00:37:25');

/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table projects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timekit_project_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_timekit_project_id_unique` (`timekit_project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table promocode_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `promocode_user`;

CREATE TABLE `promocode_user` (
  `user_id` int(10) unsigned NOT NULL,
  `promocode_id` int(10) unsigned NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `leftamount` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`user_id`,`promocode_id`),
  KEY `promocode_user_promocode_id_foreign` (`promocode_id`),
  CONSTRAINT `promocode_user_promocode_id_foreign` FOREIGN KEY (`promocode_id`) REFERENCES `promocodes` (`id`),
  CONSTRAINT `promocode_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `promocode_user` WRITE;
/*!40000 ALTER TABLE `promocode_user` DISABLE KEYS */;

INSERT INTO `promocode_user` (`user_id`, `promocode_id`, `used_at`, `leftamount`)
VALUES
	(39,8,'2019-02-21 16:23:14',15.00),
	(39,9,'2019-03-06 01:33:11',0.00),
	(39,10,'2019-04-06 23:05:07',-10.00),
	(41,8,'2019-02-12 20:33:37',40.00),
	(42,8,'2019-01-09 20:54:25',0.00),
	(46,8,'2019-03-30 21:11:22',0.00),
	(49,8,'2019-04-01 22:08:26',0.00);

/*!40000 ALTER TABLE `promocode_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table promocodehistorys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `promocodehistorys`;

CREATE TABLE `promocodehistorys` (
  `user_id` int(10) unsigned NOT NULL,
  `promocode_id` int(10) unsigned NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`promocode_id`,`transaction_id`),
  KEY `promocodehistory_transaction_id_foreign` (`transaction_id`),
  KEY `promocodehistory_promocode_id_foreign` (`promocode_id`),
  CONSTRAINT `promocodehistory_promocode_id_foreign` FOREIGN KEY (`promocode_id`) REFERENCES `promocodes` (`id`),
  CONSTRAINT `promocodehistory_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`),
  CONSTRAINT `promocodehistory_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `promocodehistorys` WRITE;
/*!40000 ALTER TABLE `promocodehistorys` DISABLE KEYS */;

INSERT INTO `promocodehistorys` (`user_id`, `promocode_id`, `transaction_id`, `used_at`)
VALUES
	(39,8,418,'2018-12-10 21:21:03'),
	(39,8,423,'2018-12-10 21:22:59'),
	(39,8,424,'2018-12-10 21:37:37'),
	(39,8,428,'2018-12-15 17:16:28'),
	(39,8,429,'2018-12-15 17:16:52'),
	(39,8,459,'2019-02-21 14:44:32'),
	(39,8,460,'2019-02-21 16:22:26'),
	(39,8,461,'2019-02-21 16:23:14'),
	(39,10,416,'2019-04-06 23:05:07');

/*!40000 ALTER TABLE `promocodehistorys` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table promocodes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `promocodes`;

CREATE TABLE `promocodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reward` double(10,2) DEFAULT NULL,
  `data` text COLLATE utf8mb4_unicode_ci,
  `is_disposable` tinyint(1) NOT NULL DEFAULT '0',
  `expires_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `promocodes_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `promocodes` WRITE;
/*!40000 ALTER TABLE `promocodes` DISABLE KEYS */;

INSERT INTO `promocodes` (`id`, `code`, `reward`, `data`, `is_disposable`, `expires_at`)
VALUES
	(1,'2QXZ-6YQ8',25.00,'{\"foo\":\"bar\",\"baz\":\"qux\"}',1,NULL),
	(2,'C7MQ-LUEP',NULL,'{\"food\":\"bood\"}',0,'2018-11-21 03:37:30'),
	(3,'DHTK',30.00,'{\"food\":\"bood\"}',0,'2018-11-21 03:37:30'),
	(4,'Y9PES-K6',25.00,'{\"food\":\"bood\"}',0,'2018-11-21 03:37:47'),
	(5,'QDAYR-NK',25.50,'{\"description\":\"test\",\"spread\":\"8\"}',0,'2018-11-25 01:26:39'),
	(6,'EECKZ-5H',12.00,'{\"description\":\"test\",\"spread\":\"8\"}',0,NULL),
	(7,'DWYMF-2C',50.00,'{\"description\":\"test\",\"spread\":\"8\"}',0,'2019-05-12 00:36:24'),
	(8,'INSTA5',50.00,'{\"spread\":\"10\",\"description\":\"5 across 10 services\"}',0,'2019-05-12 02:52:57'),
	(9,'TEST1',10.00,'{\"spread\":\"1\",\"description\":\"5 across 10 services\"}',0,'2019-02-11 02:52:57'),
	(10,'AMEX',3.00,'{\"spread\":\"1\",\"description\":\"5 across 10 services\"}',0,'2019-05-11 02:52:57');

/*!40000 ALTER TABLE `promocodes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table promocodetransactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `promocodetransactions`;

CREATE TABLE `promocodetransactions` (
  `user_id` int(10) unsigned NOT NULL,
  `promocode_id` int(10) unsigned NOT NULL,
  `transaction_id` int(10) unsigned NOT NULL,
  `used_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `promocodetransactions` WRITE;
/*!40000 ALTER TABLE `promocodetransactions` DISABLE KEYS */;

INSERT INTO `promocodetransactions` (`user_id`, `promocode_id`, `transaction_id`, `used_at`)
VALUES
	(39,8,100,'2018-12-03 16:54:31'),
	(39,8,101,'2018-12-03 16:54:47');

/*!40000 ALTER TABLE `promocodetransactions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table reciepts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reciepts`;

CREATE TABLE `reciepts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `sentbymanager` tinyint(1) NOT NULL DEFAULT '0',
  `requestedbyuser` tinyint(1) NOT NULL DEFAULT '0',
  `duplicate` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table requests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `requests`;

CREATE TABLE `requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table reviews
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reviews`;

CREATE TABLE `reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) unsigned NOT NULL,
  `review_score` int(11) DEFAULT NULL,
  `review_comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `reviews_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;

INSERT INTO `reviews` (`id`, `transaction_id`, `review_score`, `review_comment`, `created_at`, `updated_at`)
VALUES
	(3,440,3,'Lmao','2019-02-09 04:14:22','2019-02-09 04:14:22'),
	(6,444,5,'Test','2019-02-09 04:38:29','2019-02-09 04:38:29'),
	(7,442,5,'Bel','2019-02-09 04:38:56','2019-02-09 04:38:56'),
	(8,436,5,'Lmao','2019-02-09 04:39:33','2019-02-09 04:39:33');

/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table schedulecodes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `schedulecodes`;

CREATE TABLE `schedulecodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `schedulecodes_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `schedulecodes` WRITE;
/*!40000 ALTER TABLE `schedulecodes` DISABLE KEYS */;

INSERT INTO `schedulecodes` (`id`, `code`, `description`, `created_at`, `updated_at`)
VALUES
	(1,'C','Cancelled By Provider',NULL,NULL),
	(2,'CU','Cancelled By User',NULL,NULL),
	(3,'B','Booked',NULL,NULL);

/*!40000 ALTER TABLE `schedulecodes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table service_responses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `service_responses`;

CREATE TABLE `service_responses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_responses_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `service_responses` WRITE;
/*!40000 ALTER TABLE `service_responses` DISABLE KEYS */;

INSERT INTO `service_responses` (`id`, `code`, `description`, `created_at`, `updated_at`)
VALUES
	(1,'N','NO RESPONSE',NULL,NULL),
	(2,'D','DECLINED',NULL,NULL),
	(3,'A','ACCEPTED',NULL,NULL),
	(4,'W','WAITING ON CLIENT',NULL,NULL);

/*!40000 ALTER TABLE `service_responses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table service_taxes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `service_taxes`;

CREATE TABLE `service_taxes` (
  `service_id` int(11) NOT NULL,
  `taxes_id` int(11) NOT NULL,
  PRIMARY KEY (`taxes_id`,`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `service_taxes` WRITE;
/*!40000 ALTER TABLE `service_taxes` DISABLE KEYS */;

INSERT INTO `service_taxes` (`service_id`, `taxes_id`)
VALUES
	(1,1),
	(2,1),
	(3,1),
	(4,1),
	(5,1),
	(6,1),
	(7,1),
	(8,1),
	(9,1),
	(10,1),
	(12,1),
	(13,1),
	(14,1),
	(15,1),
	(16,1),
	(17,1),
	(18,1),
	(19,1),
	(3,2),
	(11,3),
	(20,3),
	(21,3),
	(22,3),
	(23,3),
	(24,3);

/*!40000 ALTER TABLE `service_taxes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table servicecategories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `servicecategories`;

CREATE TABLE `servicecategories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ordernumber` int(11) NOT NULL DEFAULT '1',
  `smalldescription` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `servicecategories` WRITE;
/*!40000 ALTER TABLE `servicecategories` DISABLE KEYS */;

INSERT INTO `servicecategories` (`id`, `description`, `created_at`, `updated_at`, `deleted_at`, `ordernumber`, `smalldescription`)
VALUES
	(1,'EYE BROWS THREADINGs','2018-03-05 21:21:07','2018-09-18 01:10:31',NULL,2,'Main threading'),
	(2,'80 MINUTE MASSAGE','2018-03-05 21:27:18','2018-03-05 21:27:18',NULL,3,NULL),
	(3,'60 MINUTE MASSAGE','2018-03-05 21:27:28','2018-03-05 21:27:28',NULL,2,NULL),
	(4,'SUCTION CUP','2018-03-05 21:27:39','2018-03-05 21:27:39',NULL,1,NULL),
	(5,'SHAVE','2018-03-05 21:27:44','2018-03-05 21:27:44',NULL,1,NULL),
	(6,'KNEE PHYSIO','2018-03-05 21:27:51','2018-03-05 21:27:51',NULL,1,NULL),
	(7,'HAIR CUT','2018-03-05 21:28:02','2018-03-05 21:28:02',NULL,1,NULL),
	(8,'NAIL ACRYLIC','2018-03-05 21:28:12','2018-03-05 21:28:12',NULL,1,NULL),
	(9,'NAIL GEL','2018-03-05 21:28:18','2018-03-05 21:28:18',NULL,1,NULL),
	(10,'WAXING','2018-03-05 21:28:26','2018-03-05 21:28:26',NULL,1,NULL),
	(11,'GROOMING','2018-06-01 22:55:54','2018-06-01 22:55:54',NULL,1,NULL),
	(12,'MALE NAILS','2018-09-18 01:11:15','2018-09-18 01:11:15',NULL,3,'fail nail'),
	(13,'30 Minute RMT Massage',NULL,NULL,NULL,1,NULL),
	(14,'90 Minute RMT Massage',NULL,NULL,NULL,4,NULL),
	(15,'120 Minute RMT Massage',NULL,NULL,NULL,5,NULL);

/*!40000 ALTER TABLE `servicecategories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table services
# ------------------------------------------------------------

DROP TABLE IF EXISTS `services`;

CREATE TABLE `services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` int(11) NOT NULL,
  `servicecategory_id` int(11) NOT NULL,
  `amount` decimal(5,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `end_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `altdescription` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;

INSERT INTO `services` (`id`, `location_id`, `servicecategory_id`, `amount`, `status`, `end_date`, `created_at`, `updated_at`, `deleted_at`, `altdescription`)
VALUES
	(1,1,3,60.00,0,NULL,'2018-03-05 22:07:32','2018-09-18 00:46:41',NULL,'TEST'),
	(2,1,8,80.00,0,NULL,'2018-03-05 22:07:42','2018-03-05 22:07:42',NULL,NULL),
	(3,1,9,30.00,0,NULL,'2018-03-05 22:07:51','2018-03-05 22:07:51',NULL,NULL),
	(4,1,7,40.00,0,NULL,'2018-03-05 22:08:02','2018-03-05 22:08:02',NULL,NULL),
	(5,1,5,15.00,0,NULL,'2018-03-05 22:08:31','2018-03-05 22:08:31',NULL,NULL),
	(6,1,10,80.00,0,NULL,'2018-03-05 22:08:50','2018-03-05 22:08:50',NULL,NULL),
	(7,1,1,60.00,0,NULL,'2018-03-05 22:09:08','2018-03-05 22:09:08',NULL,NULL),
	(8,2,1,50.00,0,NULL,'2018-03-05 23:48:46','2018-03-05 23:48:46',NULL,NULL),
	(9,2,1,30.00,0,NULL,'2018-03-05 23:48:59','2018-03-05 23:48:59',NULL,NULL),
	(10,2,10,80.00,0,NULL,'2018-03-05 23:49:20','2018-03-05 23:49:20',NULL,NULL),
	(11,2,10,100.00,0,NULL,'2018-03-05 23:49:30','2018-03-05 23:49:30',NULL,NULL),
	(12,3,2,120.00,0,NULL,'2018-03-05 23:55:08','2018-03-05 23:55:08',NULL,NULL),
	(13,3,2,50.00,0,NULL,'2018-03-05 23:55:17','2018-03-05 23:55:17',NULL,NULL),
	(14,3,3,60.00,0,NULL,'2018-03-05 23:55:25','2018-03-05 23:55:25',NULL,NULL),
	(15,3,3,50.00,0,NULL,'2018-03-05 23:55:34','2018-03-05 23:55:34',NULL,NULL),
	(16,3,4,40.00,0,NULL,'2018-03-05 23:55:41','2018-03-05 23:55:41',NULL,NULL),
	(17,4,9,80.00,0,NULL,'2018-03-06 00:01:38','2018-03-06 00:01:38',NULL,NULL),
	(18,4,8,120.00,0,NULL,'2018-03-06 00:01:48','2018-03-06 00:01:48',NULL,NULL),
	(19,5,15,100.00,0,NULL,'2018-03-06 00:03:06','2018-03-06 00:03:06',NULL,NULL),
	(20,2,1,60.00,0,NULL,'2018-03-05 22:09:08','2018-03-05 22:09:08',NULL,NULL),
	(21,3,1,50.00,0,NULL,'2018-03-05 23:48:46','2018-03-05 23:48:46',NULL,NULL),
	(22,4,1,30.00,0,NULL,'2018-03-05 23:48:59','2018-03-05 23:48:59',NULL,NULL),
	(23,5,1,80.00,0,NULL,'2018-03-05 23:49:20','2018-03-05 23:49:20',NULL,NULL),
	(24,6,1,80.00,0,NULL,'2018-03-05 23:49:20','2018-03-05 23:49:20',NULL,NULL);

/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`)
VALUES
	('C6JF5A91sz8CtP1yhFsFp9HGAgdai9Rbuu1TB6uN',50,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNjFpYmFGV2Z0Z3FDNVdYeHZCelhmMnNFVWRIcFc1TWpjcG1XNWtPSSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjU1OiJodHRwOi8vaW5zdGF3YWxraW4udGVzdC9ub3ZhL3Jlc291cmNlcy9tYW5hZ2VyLXByb2ZpbGVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTA7fQ==',1562706338);

/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table statholidays
# ------------------------------------------------------------

DROP TABLE IF EXISTS `statholidays`;

CREATE TABLE `statholidays` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `province` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `day_of` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `statholidays` WRITE;
/*!40000 ALTER TABLE `statholidays` DISABLE KEYS */;

INSERT INTO `statholidays` (`id`, `province`, `day_of`)
VALUES
	(1,'SK','2018-03-30'),
	(2,'SK','2018-05-21'),
	(3,'SK','2018-07-02'),
	(4,'SK','2018-08-06'),
	(5,'SK','2018-09-03'),
	(6,'SK','2018-10-08'),
	(7,'SK','2018-11-12'),
	(8,'SK','2018-12-25'),
	(9,'SK','2018-12-26'),
	(10,'SK','2019-02-18'),
	(11,'SK','2019-04-19'),
	(12,'SK','2019-05-20'),
	(13,'SK','2019-06-16'),
	(14,'SK','2019-07-01'),
	(15,'SK','2019-08-05'),
	(16,'SK','2019-09-02'),
	(17,'SK','2019-10-14'),
	(18,'SK','2019-11-11'),
	(19,'SK','2019-12-25'),
	(20,'SK','2019-12-31');

/*!40000 ALTER TABLE `statholidays` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table stripedatas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stripedatas`;

CREATE TABLE `stripedatas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `stripedatas` WRITE;
/*!40000 ALTER TABLE `stripedatas` DISABLE KEYS */;

INSERT INTO `stripedatas` (`id`, `user_id`, `stripe_id`, `card_brand`, `card_last_four`, `active`, `trial_ends_at`, `created_at`, `updated_at`, `deleted_at`)
VALUES
	(1,22,'cus_DhZH5KeVRiQhYa','Visa','4242',0,NULL,'2018-09-30 18:59:55','2018-09-30 18:59:55',NULL),
	(2,22,'cus_DhZoT8GiVIjerf','Visa','4242',0,NULL,'2018-09-30 19:33:15','2018-09-30 19:33:15',NULL),
	(3,22,'cus_DhZqAKeUO8bQEp','Visa','4242',0,NULL,'2018-09-30 19:35:04','2018-09-30 20:01:56','2018-09-30 20:01:56'),
	(4,22,'cus_DhaHKEMreU4fy8','Visa','4242',0,NULL,'2018-09-30 20:02:11','2018-09-30 20:02:11',NULL),
	(5,23,'cus_DhbKgG0suTa3RY','Visa','0101',0,NULL,'2018-09-30 21:06:21','2018-09-30 21:07:55','2018-09-30 21:07:55'),
	(6,23,'cus_DhbRMTO10tiLBt','Visa','0010',0,NULL,'2018-09-30 21:13:58','2018-10-07 23:20:18','2018-10-07 23:20:18'),
	(7,16,'cus_DiNhkUd6vioAXI','Visa','4242',0,NULL,'2018-10-02 23:05:31','2018-10-02 23:05:31',NULL),
	(8,24,'cus_DimJEjQoSyFFVH','Visa','4242',0,NULL,'2018-10-04 00:32:03','2018-10-04 00:32:31','2018-10-04 00:32:31'),
	(9,24,'cus_DimbByMkdHC8bx','Visa','4242',0,NULL,'2018-10-04 00:49:17','2018-10-04 00:49:17',NULL),
	(10,25,'cus_DkDkMcWZZ7DPUr','Visa','4242',0,NULL,'2018-10-07 20:56:14','2018-10-07 20:59:26','2018-10-07 20:59:26'),
	(11,25,'cus_DkDolqDHVqnWvE','Visa','4242',0,NULL,'2018-10-07 21:00:16','2018-10-08 21:58:40','2018-10-08 21:58:40'),
	(12,23,'cus_DkG4XFYWkLeJJJ','Visa','4242',0,NULL,'2018-10-07 23:20:32','2018-10-07 23:20:32',NULL),
	(13,25,'cus_Dkc04jXVlcZVhK','Visa','4242',0,NULL,'2018-10-08 22:00:41','2018-10-08 22:00:41',NULL),
	(14,27,'cus_DkeIG3NxojDk45','Visa','4242',0,NULL,'2018-10-09 00:22:22','2018-10-17 21:59:29','2018-10-17 21:59:29'),
	(15,28,'cus_Dkg0mLkKDytshS','Visa','4242',0,NULL,'2018-10-09 02:09:08','2018-10-09 02:09:08',NULL),
	(16,29,'cus_Dkg4uPf6vLaxe1','Visa','4242',0,NULL,'2018-10-09 02:12:29','2018-10-09 02:12:29',NULL),
	(17,30,'cus_DkiDwniLXfxwPl','Visa','4242',0,NULL,'2018-10-09 04:25:49','2018-10-09 04:25:49',NULL),
	(18,31,'cus_DkiOsENWwLYSyN','Visa','4242',0,NULL,'2018-10-09 04:36:42','2018-10-09 04:36:42',NULL),
	(19,32,'cus_DlUBTaVEYFE2l4','Visa','4242',0,NULL,'2018-10-11 05:59:22','2018-10-11 05:59:22',NULL),
	(20,34,'cus_DnKxFJ2TXLYO9i','Visa','4242',0,NULL,'2018-10-16 04:35:37','2018-10-16 04:35:37',NULL),
	(21,27,'cus_Dnz16zvPmVs2lI','Visa','4242',0,NULL,'2018-10-17 22:00:13','2018-10-30 23:45:58','2018-10-30 23:45:58'),
	(22,35,'cus_DnzeSioFawn7JH','Visa','4242',0,NULL,'2018-10-17 22:38:44','2018-10-17 22:38:44',NULL),
	(23,27,'cus_DtGwu9KeqVYxcy','Visa','4242',0,NULL,'2018-11-01 00:50:41','2018-11-01 00:50:59','2018-11-01 00:50:59'),
	(24,27,'cus_DtiR2wk0n8q78f','Visa','4242',0,NULL,'2018-11-02 05:16:16','2018-11-02 05:24:20','2018-11-02 05:24:20'),
	(25,27,'cus_DtiaJvdOMTfUuM','Visa','4242',0,NULL,'2018-11-02 05:25:13','2018-11-02 05:31:26','2018-11-02 05:31:26'),
	(26,27,'cus_Duh134qf9BFoxj','Visa','4242',0,NULL,'2018-11-04 19:52:00','2018-11-04 19:55:48','2018-11-04 19:55:48'),
	(27,27,'cus_DuhBBFmMKBRSSN','Visa','4242',0,NULL,'2018-11-04 20:01:39','2018-11-04 20:03:04','2018-11-04 20:03:04'),
	(28,27,'cus_DuhD4O9Ce1Fqmt','Visa','4242',0,NULL,'2018-11-04 20:03:48','2018-11-04 20:05:16','2018-11-04 20:05:16'),
	(29,27,'cus_DuhFYHmSQVGL3q','Visa','4242',0,NULL,'2018-11-04 20:05:54','2018-11-04 20:09:55','2018-11-04 20:09:55'),
	(30,27,'cus_DuhOXsVgDTNLyd','Visa','4242',0,NULL,'2018-11-04 20:15:08','2018-11-04 20:18:07','2018-11-04 20:18:07'),
	(31,27,'cus_DuhUEvQpCM2NeU','Visa','4242',0,NULL,'2018-11-04 20:20:43','2018-11-04 23:52:43','2018-11-04 23:52:43'),
	(32,36,'cus_DujIKFraU1uEuG','Visa','4242',0,NULL,'2018-11-04 22:13:10','2018-11-04 22:13:10',NULL),
	(33,27,'cus_DukxVfSs0Fdara','Visa','4242',0,NULL,'2018-11-04 23:56:18','2018-11-04 23:57:17','2018-11-04 23:57:17'),
	(34,27,'cus_DulCRSCemYUxvJ','Visa','4242',0,NULL,'2018-11-05 00:10:41','2018-11-05 02:35:26','2018-11-05 02:35:26'),
	(35,39,'cus_DumXTfzWw9zOFG','Visa','4242',0,NULL,'2018-11-05 01:33:44','2018-11-05 01:36:13','2018-11-05 01:36:13'),
	(36,39,'cus_DumaMBMNVAAi18','Visa','4242',0,NULL,'2018-11-05 01:36:41','2018-12-04 03:48:43','2018-12-04 03:48:43'),
	(37,38,'cus_DumrkLyX0Y9moc','Visa','4242',0,NULL,'2018-11-05 01:53:38','2018-11-05 01:53:38',NULL),
	(38,27,'cus_DunbSW8YdTJRlC','Visa','4242',0,NULL,'2018-11-05 02:40:13','2018-11-05 02:40:13',NULL),
	(39,39,'cus_E5gLvlAwvVOrLs','Visa','4242',0,NULL,'2018-12-04 03:53:43','2018-12-09 19:34:09','2018-12-09 19:34:09'),
	(40,39,'cus_E7pGTrNeWX5RUr','Visa','4242',0,NULL,'2018-12-09 21:14:23','2019-02-18 20:13:56','2019-02-18 20:13:56'),
	(41,41,'cus_E8I7B0xUbSof2S','Visa','4242',0,NULL,'2018-12-11 03:04:03','2018-12-11 03:04:40','2018-12-11 03:04:40'),
	(42,41,'cus_E8IAaM8nnwohEw','Visa','4242',0,NULL,'2018-12-11 03:07:16','2018-12-11 03:07:19','2018-12-11 03:07:19'),
	(43,41,'cus_E8ICbEQuhYCkz7','Visa','4242',0,NULL,'2018-12-11 03:09:11','2018-12-11 03:09:11',NULL),
	(44,40,'cus_EJN4IWx5AvDqiJ','Visa','4242',0,NULL,'2019-01-09 16:54:37','2019-01-09 16:54:37',NULL),
	(45,42,'cus_EJPKMNnCD47U4f','Visa','4242',0,NULL,'2019-01-09 19:14:24','2019-01-09 19:14:24',NULL),
	(46,26,'cus_EYURuUz1LatRjN','Visa','4242',0,NULL,'2019-02-19 01:32:14','2019-02-19 01:32:14',NULL),
	(47,39,'cus_EZXDZqEGI5YTSV','Visa','4242',0,NULL,'2019-02-21 20:28:11','2019-03-05 01:55:47','2019-03-05 01:55:47'),
	(48,39,'cus_Ee5oM7iH8yAUuq','Visa','4242',0,NULL,'2019-03-06 00:28:40','2019-03-06 22:01:09','2019-03-06 22:01:09'),
	(49,39,'cus_EfWZ4jcMrkxVf9','Visa','4242',0,NULL,'2019-03-09 20:11:31','2019-03-24 21:34:55','2019-03-24 21:34:55'),
	(50,39,'cus_ElANEebGT4yfZR','Visa','4242',0,NULL,'2019-03-24 21:39:29','2019-03-24 21:39:29',NULL);

/*!40000 ALTER TABLE `stripedatas` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table subscriptions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subscriptions`;

CREATE TABLE `subscriptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table taxes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `taxes`;

CREATE TABLE `taxes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taxcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taxpercent` int(11) NOT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `taxes` WRITE;
/*!40000 ALTER TABLE `taxes` DISABLE KEYS */;

INSERT INTO `taxes` (`id`, `taxcode`, `taxpercent`, `end_date`, `created_at`, `updated_at`)
VALUES
	(1,'SK GST 5',5,NULL,NULL,NULL),
	(2,'SK PST 7',7,NULL,NULL,NULL),
	(3,'NO TAX',0,NULL,NULL,NULL);

/*!40000 ALTER TABLE `taxes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table timings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `timings`;

CREATE TABLE `timings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `day_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  `stat_open` time DEFAULT NULL,
  `stat_close` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `timings` WRITE;
/*!40000 ALTER TABLE `timings` DISABLE KEYS */;

INSERT INTO `timings` (`id`, `location_id`, `day_id`, `open`, `close`, `stat_open`, `stat_close`, `created_at`, `updated_at`)
VALUES
	(1,'1','1','10:00:00','23:00:00',NULL,NULL,'2018-03-05 23:27:59','2018-12-09 05:48:19'),
	(2,'1','2','10:00:00','23:00:00',NULL,NULL,'2018-03-05 23:27:59','2018-12-09 05:48:19'),
	(3,'1','3','09:00:00','23:00:00',NULL,NULL,'2018-03-05 23:27:59','2018-12-09 05:48:19'),
	(4,'1','4','09:00:00','23:59:00',NULL,NULL,'2018-03-05 23:27:59','2018-12-09 05:48:19'),
	(5,'1','5','10:00:00','23:00:00',NULL,NULL,'2018-03-05 23:27:59','2018-12-09 05:48:19'),
	(6,'1','6','09:00:00','23:59:00',NULL,NULL,'2018-03-05 23:27:59','2018-12-09 05:48:19'),
	(7,'1','7','09:00:00','23:59:00',NULL,NULL,'2018-03-05 23:27:59','2018-12-09 05:48:19'),
	(8,'1','8','11:00:00','23:00:00',NULL,NULL,'2018-03-05 23:27:59','2018-12-09 05:48:19'),
	(9,'2','1','09:00:00','23:00:00',NULL,NULL,'2018-03-05 23:31:33','2018-12-09 05:49:24'),
	(10,'2','2','09:00:00','23:00:00',NULL,NULL,'2018-03-05 23:31:33','2018-12-09 05:49:24'),
	(11,'2','3','09:00:00','23:00:00',NULL,NULL,'2018-03-05 23:31:33','2018-12-09 05:49:24'),
	(12,'2','4','09:00:00','23:00:00',NULL,NULL,'2018-03-05 23:31:33','2018-12-09 05:49:24'),
	(13,'2','5','09:00:00','23:00:00',NULL,NULL,'2018-03-05 23:31:33','2018-12-09 05:49:24'),
	(14,'2','6','09:00:00','23:59:00',NULL,NULL,'2018-03-05 23:31:33','2018-12-09 05:49:24'),
	(15,'2','7','09:00:00','23:59:00',NULL,NULL,'2018-03-05 23:31:33','2018-12-09 05:49:24'),
	(16,'2','8','09:00:00','23:59:00',NULL,NULL,'2018-03-05 23:31:33','2018-12-09 05:49:24'),
	(17,'3','1','08:00:00','24:00:00',NULL,NULL,'2018-03-05 23:34:27','2018-03-05 23:34:27'),
	(18,'3','2','08:00:00','18:00:00',NULL,NULL,'2018-03-05 23:34:27','2018-03-05 23:34:27'),
	(19,'3','3','08:00:00','18:00:00',NULL,NULL,'2018-03-05 23:34:27','2018-03-05 23:34:27'),
	(20,'3','4','10:00:00','15:00:00',NULL,NULL,'2018-03-05 23:34:27','2018-03-05 23:34:27'),
	(21,'3','5','08:00:00','20:00:00',NULL,NULL,'2018-03-05 23:34:27','2018-03-05 23:34:27'),
	(22,'3','6','09:00:00','23:00:00',NULL,NULL,'2018-03-05 23:34:27','2018-03-05 23:34:27'),
	(23,'3','7','09:00:00','23:00:00',NULL,NULL,'2018-03-05 23:34:27','2018-03-05 23:34:27'),
	(24,'3','8','09:00:00','18:00:00',NULL,NULL,'2018-03-05 23:34:27','2018-03-05 23:34:27'),
	(25,'4','1','08:00:00','17:00:00',NULL,NULL,'2018-03-05 23:46:08','2018-03-05 23:46:08'),
	(26,'4','2','09:00:00','23:59:00',NULL,NULL,'2018-03-05 23:46:08','2018-03-05 23:46:08'),
	(27,'4','3','08:00:00','17:00:00',NULL,NULL,'2018-03-05 23:46:08','2018-03-05 23:46:08'),
	(28,'4','4','03:00:00','18:00:00',NULL,NULL,'2018-03-05 23:46:08','2018-03-05 23:46:08'),
	(29,'4','5','03:00:00','18:00:00',NULL,NULL,'2018-03-05 23:46:08','2018-03-05 23:46:08'),
	(30,'4','6','02:00:00','17:00:00',NULL,NULL,'2018-03-05 23:46:08','2018-03-05 23:46:08'),
	(31,'4','7','09:00:00','23:00:00',NULL,NULL,'2018-03-05 23:46:08','2018-03-05 23:46:08'),
	(32,'4','8','09:00:00','23:59:00',NULL,NULL,'2018-03-05 23:46:08','2018-03-05 23:46:08'),
	(33,'5','1','09:00:00','17:00:00',NULL,NULL,'2018-03-05 23:47:25','2018-03-05 23:47:25'),
	(34,'5','2','09:00:00','17:00:00',NULL,NULL,'2018-03-05 23:47:25','2018-03-05 23:47:25'),
	(35,'5','3','09:00:00','17:00:00',NULL,NULL,'2018-03-05 23:47:25','2018-03-05 23:47:25'),
	(36,'5','4','09:00:00','17:00:00',NULL,NULL,'2018-03-05 23:47:25','2018-03-05 23:47:25'),
	(37,'5','5','09:00:00','17:00:00',NULL,NULL,'2018-03-05 23:47:25','2018-03-05 23:47:25'),
	(38,'5','6','09:00:00','23:59:00',NULL,NULL,'2018-03-05 23:47:25','2018-03-05 23:47:25'),
	(39,'5','7','09:00:00','23:00:00',NULL,NULL,'2018-03-05 23:47:25','2018-03-05 23:47:25'),
	(40,'5','8','09:00:00','17:00:00',NULL,NULL,'2018-03-05 23:47:25','2018-03-05 23:47:25');

/*!40000 ALTER TABLE `timings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table transactions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `serviceamount` decimal(5,2) DEFAULT NULL,
  `tipamount` decimal(10,2) DEFAULT NULL,
  `taxamount` decimal(10,2) DEFAULT NULL,
  `success` tinyint(1) DEFAULT NULL,
  `chargeid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `captured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `service_response_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `askedprice` decimal(5,2) DEFAULT NULL,
  `servicecategory_id` int(11) DEFAULT NULL,
  `afterstatus` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wrongamount` tinyint(1) NOT NULL DEFAULT '0',
  `durationvalue` int(11) DEFAULT NULL,
  `tipcaptured` tinyint(1) NOT NULL DEFAULT '0',
  `tipsuccess` tinyint(1) NOT NULL DEFAULT '0',
  `tipchargeid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipdate_at` datetime DEFAULT NULL,
  `transactionclosed` tinyint(1) NOT NULL DEFAULT '0',
  `userreasons` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionreasons` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arrival_at` datetime DEFAULT NULL,
  `coupon_percent` int(11) DEFAULT NULL,
  `coupon_amount_calc` decimal(10,2) DEFAULT NULL,
  `coupon_tax_calc` decimal(10,2) DEFAULT NULL,
  `discount_type` text COLLATE utf8mb4_unicode_ci,
  `holdingtransactions_id` int(10) unsigned DEFAULT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `newaddress` text COLLATE utf8mb4_unicode_ci,
  `newpostalcode` text COLLATE utf8mb4_unicode_ci,
  `newlat` text COLLATE utf8mb4_unicode_ci,
  `newlong` text COLLATE utf8mb4_unicode_ci,
  `newcity` text COLLATE utf8mb4_unicode_ci,
  `newprovince` text COLLATE utf8mb4_unicode_ci,
  `newdescription` text COLLATE utf8mb4_unicode_ci,
  `newname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`id`),
  KEY `transactions_holdingtransactions_id_foreign` (`holdingtransactions_id`),
  CONSTRAINT `transactions_holdingtransactions_id_foreign` FOREIGN KEY (`holdingtransactions_id`) REFERENCES `holdingtransactions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;

INSERT INTO `transactions` (`id`, `user_id`, `location_id`, `service_id`, `serviceamount`, `tipamount`, `taxamount`, `success`, `chargeid`, `captured`, `created_at`, `updated_at`, `service_response_code`, `employee_id`, `askedprice`, `servicecategory_id`, `afterstatus`, `wrongamount`, `durationvalue`, `tipcaptured`, `tipsuccess`, `tipchargeid`, `tipdate_at`, `transactionclosed`, `userreasons`, `transactionreasons`, `arrival_at`, `coupon_percent`, `coupon_amount_calc`, `coupon_tax_calc`, `discount_type`, `holdingtransactions_id`, `read`, `newaddress`, `newpostalcode`, `newlat`, `newlong`, `newcity`, `newprovince`, `newdescription`, `newname`)
VALUES
	(76,1,1,1,60.00,0.00,0.00,0,'0',0,'2018-08-14 18:17:15','2019-06-30 19:46:32','A',1,300.00,9,'N',1,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(77,1,1,1,60.00,0.00,0.00,0,'0',0,'2018-08-14 18:17:15','2019-01-05 00:02:25','A',1,300.00,9,NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(78,1,1,1,60.00,0.00,0.00,0,'0',0,'2016-09-14 18:17:15','2018-09-29 00:12:33','A',3,300.00,9,'N',0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(79,1,1,1,60.00,0.00,0.00,0,'0',0,'2018-08-18 18:17:15','2019-01-05 00:02:51','A',3,300.00,9,'N',1,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(80,1,1,1,60.00,0.00,0.00,0,'0',0,'2016-10-14 18:17:15','2018-12-29 02:03:39','A',1,300.00,9,NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(81,1,1,1,60.00,0.00,0.00,0,'0',0,'2016-11-14 18:17:15','2019-01-08 02:04:19','A',3,300.00,9,'N',0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(82,1,1,1,60.00,0.00,0.00,0,'0',0,'2016-12-14 18:17:15','2018-08-14 18:17:15','A',NULL,300.00,9,NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(83,1,1,1,60.00,0.00,0.00,0,'0',0,'2018-06-14 18:17:15','2018-12-29 02:04:52','A',2,300.00,9,NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(84,1,1,1,60.00,0.00,0.00,0,'0',0,'2018-05-17 18:17:15','2018-08-29 01:43:02','A',3,300.00,9,NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(85,1,1,1,60.00,0.00,0.00,0,'0',0,'2018-05-14 18:17:15','2019-01-05 00:12:28','A',1,300.00,9,NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(89,1,1,1,60.00,0.00,0.00,0,'0',0,'2018-05-14 18:17:15','2019-01-05 00:12:48','A',2,300.00,9,NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(90,1,1,1,60.00,0.00,0.00,0,'0',0,'2018-05-04 18:17:15','2018-08-14 18:17:15','A',NULL,300.00,9,NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(91,1,1,1,60.00,0.00,0.00,0,'0',0,'2018-05-24 18:17:15','2018-08-14 18:17:15','A',NULL,300.00,9,NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(92,1,1,1,60.00,0.00,0.00,0,'0',0,'2018-09-12 18:17:15','2018-09-12 18:17:28','A',NULL,300.00,9,'N',1,NULL,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(93,23,2,8,50.00,6.00,0.00,1,'ch_1DGFZNEsU0NMi1hvSWRepLm6',1,'2018-09-30 18:47:30','2018-10-07 02:40:54','A',NULL,300.00,1,NULL,0,12,1,1,'ch_1DISCWEsU0NMi1hvu1xS4MgT','2018-10-07 02:40:54',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(94,22,2,10,80.00,0.00,0.00,1,'ch_1DGFsJEsU0NMi1hvx9M7mU1a',1,'2018-09-30 19:07:04','2018-09-30 19:07:04','A',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(95,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-01 21:37:15','2018-10-01 21:37:15','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(96,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-01 21:44:21','2018-10-01 21:44:21','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(97,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-01 21:47:49','2018-10-01 21:47:49','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(98,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-01 21:49:54','2018-10-01 21:49:54','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(99,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-01 21:53:31','2018-10-01 21:53:31','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(100,23,1,6,80.00,6000.00,0.00,0,'0',0,'2018-10-01 21:54:52','2018-10-07 00:47:28','W',NULL,300.00,10,NULL,0,12,1,1,'ch_1DIQQlEsU0NMi1hvk5VbExAe','2018-10-07 00:47:28',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(101,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-01 21:57:36','2018-10-01 21:57:36','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(102,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-01 22:04:00','2018-10-01 22:04:00','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(103,23,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-01 22:04:39','2018-10-01 22:04:39','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,1,'USER DECLINED','USER DECLINED',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(104,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-02 17:06:25','2018-10-02 17:06:25','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(105,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-02 17:07:39','2018-10-02 17:07:39','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(106,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-02 17:08:17','2018-10-02 17:08:17','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(107,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-02 17:09:28','2018-10-02 17:09:28','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(108,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-02 17:11:16','2018-10-02 17:11:16','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(109,23,1,7,60.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-02 17:19:08','2018-10-02 17:19:08','W',NULL,300.00,1,NULL,0,12,0,0,NULL,NULL,1,'USER DECLINED','USER DECLINED',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(110,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-03 17:20:17','2018-10-03 17:20:17','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(111,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-03 17:22:57','2018-10-03 17:22:57','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(112,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-03 17:25:08','2018-10-03 17:25:08','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(113,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-03 17:28:53','2018-10-03 17:28:53','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(114,23,1,6,80.00,0.00,0.00,NULL,'ch_1DHJo0EsU0NMi1hvlabXgdes',1,'2018-10-03 17:30:52','2018-10-03 17:30:52','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(115,23,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-03 17:37:28','2018-10-03 17:37:28','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(116,23,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-03 17:55:44','2018-10-03 17:55:44','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'USER DECLINED','USER DECLINED',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(117,23,1,6,80.00,10.00,0.00,NULL,'ch_1DHKkEEsU0NMi1hvsV1q2XTY',1,'2018-10-03 18:30:33','2018-10-07 04:23:34','A',NULL,300.00,10,NULL,0,12,1,1,'ch_1DITntEsU0NMi1hvvRHihB2e','2018-10-07 04:23:34',0,'AUTHORIZED','AUTHORIZED','2018-10-06 22:20:25',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(118,25,2,10,80.00,0.00,0.00,0,'0',0,'2018-10-07 15:55:23','2018-10-07 15:55:23','N',NULL,240.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(119,25,2,8,50.00,5.00,0.00,NULL,'ch_1DIlZ4EsU0NMi1hv1fBBLdec',1,'2018-10-07 17:21:17','2018-10-07 23:28:12','A',NULL,300.00,1,NULL,0,12,1,1,'ch_1DIlfcEsU0NMi1hvNMAMywba','2018-10-07 23:28:12',1,'AUTHORIZED','AUTHORIZED',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(120,25,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-08 13:57:00','2018-10-08 13:57:00','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 14:08:00',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(121,25,1,6,80.00,0.00,0.00,NULL,'ch_1DJ4sZEsU0NMi1hv1ZxIy7D7',1,'2018-10-08 13:58:42','2018-10-08 13:58:42','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-10-08 14:09:42',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(122,25,1,6,80.00,0.00,0.00,NULL,'ch_1DJ4yPEsU0NMi1hvNVOTJhqp',1,'2018-10-08 14:04:20','2018-10-08 14:04:20','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-10-08 14:15:20',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(123,25,1,6,80.00,0.00,0.00,NULL,'ch_1DJ50zEsU0NMi1hvWX24FVRW',1,'2018-10-08 14:07:27','2018-10-08 14:07:27','A',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-10-08 14:19:27',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(124,25,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-08 14:40:08','2018-10-08 14:40:08','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 14:51:08',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(125,25,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-08 14:49:45','2018-10-08 14:49:45','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 15:00:45',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(126,25,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-08 14:54:38','2018-10-08 14:54:38','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 15:05:38',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(127,25,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-08 15:02:15','2018-10-08 15:02:15','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 15:13:15',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(128,25,1,6,80.00,0.00,0.00,NULL,'ch_1DJ5viEsU0NMi1hvl20rCrvC',1,'2018-10-08 15:06:04','2018-10-08 15:06:04','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-10-08 15:17:04',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(129,25,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-08 15:44:48','2018-10-08 15:44:48','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'USER DECLINED','USER DECLINED','2018-10-08 15:55:48',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(130,25,1,6,80.00,5.00,0.00,NULL,'ch_1DJ6XlEsU0NMi1hvMXouomfV',1,'2018-10-08 15:45:20','2018-10-08 21:47:39','A',NULL,300.00,10,NULL,0,11,1,1,'ch_1DJ6ZsEsU0NMi1hvX3eLDFcg','2018-10-08 21:47:39',1,'AUTHORIZED','AUTHORIZED','2018-10-08 15:56:20',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(131,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-08 18:27:46','2018-10-08 18:27:46','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 18:38:46',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(132,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-08 18:27:47','2018-10-08 18:27:47','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 18:38:47',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(133,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-08 18:28:14','2018-10-08 18:28:14','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'USER DECLINED','USER DECLINED','2018-10-08 18:39:14',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(134,27,1,6,80.00,0.00,0.00,NULL,'ch_1DJ97OEsU0NMi1hv7ud0GGHF',1,'2018-10-08 18:29:31','2018-10-08 18:29:31','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-10-08 18:40:31',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(135,27,1,7,60.00,3.00,0.00,NULL,'ch_1DJ9RHEsU0NMi1hvZF6o4TIf',1,'2018-10-08 18:50:45','2018-10-18 01:01:07','A',NULL,300.00,1,NULL,0,11,1,1,'ch_1DMPssEsU0NMi1hvyIszsgWW','2018-10-18 01:01:07',1,'AUTHORIZED','AUTHORIZED','2018-10-08 19:01:45',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(136,27,1,6,80.00,0.00,0.00,NULL,'ch_1DJ9ZyEsU0NMi1hvm43Pv9Rg',1,'2018-10-08 18:59:08','2018-10-08 18:59:08','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-10-08 19:10:08',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(137,27,1,7,60.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-08 19:01:58','2018-10-08 19:01:58','W',NULL,300.00,1,NULL,0,11,0,0,NULL,NULL,1,'USER DECLINED','USER DECLINED','2018-10-08 19:12:58',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(138,27,1,7,60.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-08 19:03:30','2018-10-08 19:03:30','W',NULL,300.00,1,NULL,0,11,0,0,NULL,NULL,1,'USER DECLINED','USER DECLINED','2018-10-08 19:14:30',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(139,27,1,7,60.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-08 19:08:19','2018-10-08 19:08:19','W',NULL,300.00,1,NULL,0,11,0,0,NULL,NULL,1,'USER DECLINED','USER DECLINED','2018-10-08 19:19:19',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(140,27,1,7,60.00,0.00,0.00,0,'0',0,'2018-10-08 19:10:48','2018-10-08 19:10:48','W',NULL,300.00,1,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 19:21:48',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(141,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-08 19:14:48','2018-10-08 19:14:48','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 19:25:48',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(142,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-08 19:16:44','2018-10-08 19:16:44','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 19:27:44',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(143,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-08 19:16:45','2018-10-08 19:16:45','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 19:27:45',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(144,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-08 19:17:11','2018-10-08 19:17:11','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-08 19:28:11',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(145,27,1,7,60.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-08 19:19:34','2018-10-08 19:19:34','W',NULL,300.00,1,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-08 19:30:34',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(146,27,1,7,60.00,0.00,0.00,0,'0',0,'2018-10-08 19:21:42','2018-10-08 19:21:42','D',NULL,300.00,1,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 19:32:42',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(147,27,1,7,60.00,0.00,0.00,0,'0',0,'2018-10-08 19:21:43','2018-10-08 19:21:43','N',NULL,300.00,1,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 19:32:43',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(148,27,1,7,60.00,0.00,0.00,0,'0',0,'2018-10-08 19:23:32','2018-10-08 19:23:32','D',NULL,300.00,1,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 19:34:32',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(149,27,1,7,60.00,0.00,0.00,0,'0',0,'2018-10-08 19:23:33','2018-10-08 19:23:33','N',NULL,300.00,1,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-08 19:34:33',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(150,27,1,7,60.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-08 19:24:17','2018-10-08 19:24:17','W',NULL,300.00,1,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-08 19:35:17',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(151,27,1,7,60.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-08 19:28:00','2018-10-08 19:28:00','W',NULL,300.00,1,NULL,0,11,0,0,NULL,NULL,1,'USER DECLINED','USER DECLINED','2018-10-08 19:39:00',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(152,27,1,7,60.00,0.00,0.00,NULL,'ch_1DJA1oEsU0NMi1hvxa3ApdKF',1,'2018-10-08 19:28:35','2018-10-08 19:28:35','A',NULL,300.00,1,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-10-08 19:39:35',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(153,29,1,7,60.00,40.00,0.00,NULL,'ch_1DJAqvEsU0NMi1hv8RdUbO69',1,'2018-10-08 20:21:08','2018-10-09 02:23:44','A',NULL,300.00,1,NULL,0,12,1,1,'ch_1DJAt4EsU0NMi1hvNuyc5qzp','2018-10-09 02:23:44',1,'AUTHORIZED','AUTHORIZED','2018-10-08 20:33:08',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(154,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 19:54:41','2018-10-15 19:54:41','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:05:41',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(155,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 19:54:42','2018-10-15 19:54:42','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:05:42',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(156,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-15 19:55:53','2018-10-15 19:55:53','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-15 20:06:53',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(157,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:01:49','2018-10-15 20:01:49','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:12:49',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(158,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:01:51','2018-10-15 20:01:51','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:12:51',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(159,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:02:52','2018-10-15 20:02:52','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:13:52',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(160,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:02:53','2018-10-15 20:02:53','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:13:53',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(161,27,2,10,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:03:12','2018-10-15 20:03:12','D',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:15:12',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(162,27,2,10,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:03:13','2018-10-15 20:03:13','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:15:13',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(163,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:03:37','2018-10-15 20:03:37','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:14:37',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(164,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:03:38','2018-10-15 20:03:38','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:14:38',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(165,27,2,10,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-15 20:03:49','2018-10-15 20:03:49','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-15 20:15:49',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(166,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:05:23','2018-10-15 20:05:23','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:16:23',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(167,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:05:24','2018-10-15 20:05:24','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:16:24',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(168,27,2,10,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:05:38','2018-10-15 20:05:38','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:17:38',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(169,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-15 20:07:00','2018-10-15 20:07:00','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-15 20:18:00',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(170,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:09:47','2018-10-15 20:09:47','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:21:47',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(171,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:12:49','2018-10-15 20:12:49','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:23:49',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(172,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:15:16','2018-10-15 20:15:16','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:27:16',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(173,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:16:48','2018-10-15 20:16:48','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:28:48',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(174,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:19:55','2018-10-15 20:19:55','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:31:55',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(175,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:22:16','2018-10-15 20:22:16','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:33:16',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(176,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:23:24','2018-10-15 20:23:24','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:34:24',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(177,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 20:25:41','2018-10-15 20:25:41','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 20:37:41',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(178,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-15 20:58:15','2018-10-15 20:58:15','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-15 21:09:15',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(179,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:00:21','2018-10-15 21:00:21','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:11:21',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(180,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:01:48','2018-10-15 21:01:48','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:13:48',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(181,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:02:25','2018-10-15 21:02:25','W',NULL,300.00,10,NULL,0,10,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:12:25',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(182,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:03:19','2018-10-15 21:03:19','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:14:19',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(183,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:04:39','2018-10-15 21:04:39','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:15:39',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(184,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:05:43','2018-10-15 21:05:43','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:17:43',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(185,27,1,6,80.00,4.00,0.00,1,'ch_1DLj2TEsU0NMi1hvKowjitqB',1,'2018-10-15 21:16:04','2018-10-18 01:01:35','A',NULL,300.00,10,NULL,0,11,1,1,'ch_1DMPtKEsU0NMi1hvjG9dLHNP','2018-10-18 01:01:35',1,'AUTHORIZED','AUTHORIZED','2018-10-15 21:27:04',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(186,27,1,6,80.00,3.22,0.00,1,'ch_1DLj82EsU0NMi1hvqbPyK3Nb',1,'2018-10-15 21:21:50','2018-10-18 00:44:54','A',NULL,300.00,10,NULL,0,12,1,1,'ch_1DMPdCEsU0NMi1hvnHyFLRix','2018-10-18 00:44:54',1,'AUTHORIZED','AUTHORIZED','2018-10-15 21:33:50',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(187,27,1,6,80.00,4.50,0.00,1,'ch_1DLjCIEsU0NMi1hvsTM2uxDm',1,'2018-10-15 21:26:14','2018-10-18 00:45:33','A',NULL,300.00,10,NULL,0,12,1,1,'ch_1DMPdoEsU0NMi1hv7dkQgbXz','2018-10-18 00:45:33',1,'AUTHORIZED','AUTHORIZED','2018-10-15 21:38:14',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(188,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-15 21:33:31','2018-10-15 21:33:31','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-15 21:44:31',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(189,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:35:13','2018-10-15 21:35:13','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:46:13',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(190,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:35:14','2018-10-15 21:35:14','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:46:14',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(191,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:35:44','2018-10-15 21:35:44','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:46:44',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(192,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:35:45','2018-10-15 21:35:45','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:46:45',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(193,27,2,10,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:35:48','2018-10-15 21:35:48','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:47:48',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(194,27,2,10,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:35:57','2018-10-15 21:35:57','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:47:57',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(195,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:36:42','2018-10-15 21:36:42','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:47:42',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(196,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:36:43','2018-10-15 21:36:43','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:47:43',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(197,27,2,10,80.00,5.20,0.00,1,'ch_1DLjMdEsU0NMi1hvQq2KJoBB',1,'2018-10-15 21:36:53','2018-10-18 00:42:47','A',NULL,300.00,10,NULL,0,12,1,1,'ch_1DMPb8EsU0NMi1hvyn1AEugV','2018-10-18 00:42:47',1,'AUTHORIZED','AUTHORIZED','2018-10-15 21:48:53',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(198,27,1,6,80.00,5.23,0.00,1,'ch_1DLjRbEsU0NMi1hvSWBnczZl',1,'2018-10-15 21:41:59','2018-10-18 00:51:58','A',NULL,300.00,10,NULL,0,11,1,1,'ch_1DMPk2EsU0NMi1hv1OEYq7II','2018-10-18 00:51:58',1,'AUTHORIZED','AUTHORIZED','2018-10-15 21:52:59',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(199,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:45:36','2018-10-15 21:45:36','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 21:56:36',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(200,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-15 21:46:31','2018-10-15 21:46:31','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-15 21:58:31',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(201,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:48:09','2018-10-15 21:48:09','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:00:09',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(202,27,1,6,80.00,3.66,0.00,1,'ch_1DLjZOEsU0NMi1hv3G3uapUT',1,'2018-10-15 21:50:07','2018-10-18 00:41:33','A',NULL,300.00,10,NULL,0,12,1,1,'ch_1DMPZxEsU0NMi1hvMMFvPcDZ','2018-10-18 00:41:33',1,'AUTHORIZED','AUTHORIZED','2018-10-15 22:02:07',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(203,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-15 21:51:05','2018-10-15 21:51:05','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-15 22:03:05',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(204,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:52:07','2018-10-15 21:52:07','D',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:04:07',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(205,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:52:08','2018-10-15 21:52:08','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:04:08',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(206,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-15 21:53:23','2018-10-15 21:53:23','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-15 22:05:23',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(207,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:54:49','2018-10-15 21:54:49','D',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:06:49',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(208,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 21:54:50','2018-10-15 21:54:50','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:06:50',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(209,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-15 22:00:39','2018-10-15 22:00:39','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-15 22:12:39',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(210,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:01:01','2018-10-15 22:01:01','D',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:13:01',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(211,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:01:02','2018-10-15 22:01:02','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:13:02',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(212,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:03:58','2018-10-15 22:03:58','D',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:15:58',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(213,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:04:00','2018-10-15 22:04:00','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:16:00',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(214,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:08:49','2018-10-15 22:08:49','D',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:20:49',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(215,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:08:50','2018-10-15 22:08:50','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:20:50',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(216,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:15:06','2018-10-15 22:15:06','D',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:27:06',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(217,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:15:06','2018-10-15 22:15:06','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:27:06',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(218,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:18:19','2018-10-15 22:18:19','D',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:30:19',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(219,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:18:19','2018-10-15 22:18:19','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:30:19',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(220,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:27:06','2018-10-15 22:27:06','D',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:39:06',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(221,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:27:07','2018-10-15 22:27:07','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:39:07',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(222,34,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-15 22:40:01','2018-10-15 22:40:01','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-15 22:51:01',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(223,34,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-15 22:40:52','2018-10-15 22:40:52','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-15 22:51:52',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(224,34,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:48:33','2018-10-15 22:48:33','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:59:33',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(225,34,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:48:34','2018-10-15 22:48:34','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 22:59:34',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(226,34,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:50:58','2018-10-15 22:50:58','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 23:01:58',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(227,34,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-15 22:59:41','2018-10-15 22:59:41','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 23:11:41',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(228,34,1,6,80.00,0.00,0.00,1,'ch_1DLkfzEsU0NMi1hvpbMLuMvJ',1,'2018-10-15 23:00:48','2018-10-15 23:00:48','A',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-10-15 23:12:48',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(229,27,3,12,120.00,0.00,0.00,0,'0',0,'2018-10-15 23:22:08','2018-10-15 23:22:08','D',NULL,300.00,2,NULL,0,9,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 23:31:08',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(230,27,3,12,120.00,0.00,0.00,0,'0',0,'2018-10-15 23:22:09','2018-10-15 23:22:09','N',NULL,300.00,2,NULL,0,9,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 23:31:09',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(231,27,3,12,120.00,0.00,0.00,0,'0',0,'2018-10-15 23:22:23','2018-10-15 23:22:23','W',NULL,300.00,2,NULL,0,9,0,0,NULL,NULL,0,NULL,NULL,'2018-10-15 23:31:23',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(232,27,3,12,120.00,50.00,0.00,1,'ch_1DLl2qEsU0NMi1hvocS8XbQb',1,'2018-10-15 23:24:30','2018-10-17 22:06:17','D',NULL,300.00,2,NULL,0,9,1,1,'ch_1DMN9gEsU0NMi1hvdIDyIFF5','2018-10-17 22:06:17',1,'AUTHORIZED','AUTHORIZED','2018-10-15 23:33:30',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(233,35,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-17 16:48:06','2018-10-17 16:48:06','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-17 16:59:06',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(234,35,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-17 16:48:07','2018-10-17 16:48:07','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-17 16:59:07',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(235,35,2,10,80.00,0.00,0.00,0,'0',0,'2018-10-17 16:48:15','2018-10-17 16:48:15','D',NULL,300.00,10,NULL,0,13,0,0,NULL,NULL,0,NULL,NULL,'2018-10-17 17:01:15',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(236,35,2,10,80.00,0.00,0.00,0,'0',0,'2018-10-17 16:48:16','2018-10-17 16:48:16','N',NULL,300.00,10,NULL,0,13,0,0,NULL,NULL,0,NULL,NULL,'2018-10-17 17:01:16',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(237,35,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-17 16:51:24','2018-10-17 16:51:24','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-17 17:02:24',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(238,35,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-17 16:51:25','2018-10-17 16:51:25','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-17 17:02:25',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(239,35,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-17 16:51:41','2018-10-17 16:51:41','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-17 17:02:41',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(240,35,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-17 16:51:42','2018-10-17 16:51:42','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-17 17:02:42',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(241,35,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-10-17 16:52:00','2018-10-17 16:52:00','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-10-17 17:03:00',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(242,35,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-17 16:54:52','2018-10-17 16:54:52','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-17 17:05:52',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(243,35,2,10,80.00,4.00,0.00,1,'ch_1DMNv1EsU0NMi1hvUqSV5EBO',1,'2018-10-17 16:55:07','2018-10-17 23:14:00','A',NULL,300.00,10,NULL,0,13,1,1,'ch_1DMODDEsU0NMi1hv6Xq49oAU','2018-10-17 23:14:00',1,'AUTHORIZED','AUTHORIZED','2018-10-17 17:08:07',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(244,27,1,6,80.00,23.00,0.00,1,'ch_1DMOHSEsU0NMi1hvtukiP01x',1,'2018-10-17 17:18:19','2018-10-18 01:11:05','A',NULL,300.00,10,NULL,0,11,1,1,'ch_1DMQ2XEsU0NMi1hvH3jx6Woo','2018-10-18 01:11:05',1,'AUTHORIZED','AUTHORIZED','2018-10-17 17:29:19',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(245,27,1,6,80.00,0.00,0.00,1,'ch_1DMQ3OEsU0NMi1hvdCYK9jCa',1,'2018-10-17 19:11:54','2018-10-17 19:11:54','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-10-17 19:22:54',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(246,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-21 16:54:42','2018-10-21 16:54:42','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-21 17:05:42',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(247,27,1,6,80.00,0.00,0.00,1,'ch_1DNpq7EsU0NMi1hv6OtzXtL1',1,'2018-10-21 16:56:02','2018-10-21 16:56:02','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-10-21 17:07:02',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(248,27,1,6,80.00,5.00,0.00,1,'ch_1DNpwTEsU0NMi1hv2oEqMepX',1,'2018-10-21 17:02:38','2018-11-02 05:16:33','A',NULL,300.00,10,NULL,0,11,1,1,'ch_1DRv1IEsU0NMi1hvTS4dpB0G','2018-11-02 05:16:33',1,'AUTHORIZED','AUTHORIZED','2018-10-21 17:13:38',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(249,27,1,6,80.00,0.00,0.00,1,'ch_1DNpxsEsU0NMi1hvFXTL6TN3',1,'2018-10-21 17:04:04','2018-10-21 17:04:04','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-10-21 17:15:04',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(250,27,1,6,80.00,0.00,0.00,1,'ch_1DNq5nEsU0NMi1hvhurGKP50',1,'2018-10-21 17:12:16','2018-10-21 17:12:16','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-10-21 17:23:16',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(251,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-21 18:54:28','2018-10-21 18:54:28','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-21 19:05:28',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(252,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-21 18:56:56','2018-10-21 18:56:56','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-21 19:07:56',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(253,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-21 18:57:36','2018-10-21 18:57:36','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-21 19:08:36',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(254,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-21 20:30:34','2018-10-21 20:30:34','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-21 20:41:34',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(255,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-22 19:40:52','2018-10-22 19:40:52','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-22 19:51:52',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(256,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-22 19:40:53','2018-10-22 19:40:53','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-22 19:51:53',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(257,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-22 19:46:22','2018-10-22 19:46:22','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-22 19:57:22',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(258,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-22 19:46:23','2018-10-22 19:46:23','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-22 19:57:23',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(259,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-23 11:46:30','2018-10-23 11:46:30','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-23 11:58:30',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(260,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-23 11:49:53','2018-10-23 11:49:53','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-23 12:00:53',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(261,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-23 11:53:08','2018-10-23 11:53:08','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-23 12:04:08',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(262,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-23 11:54:23','2018-10-23 11:54:23','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-10-23 12:05:23',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(263,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-10-23 12:00:15','2018-10-23 12:00:15','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-10-23 12:12:15',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(264,27,1,6,80.00,0.00,0.00,1,'ch_1DSsuvEsU0NMi1hvD8cVBByQ',1,'2018-11-04 15:13:48','2018-11-04 15:13:48','A',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-11-04 15:25:48',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(265,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 15:15:20','2018-11-04 15:15:20','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 15:26:20',0,8.40,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(266,27,1,6,80.00,0.00,0.00,1,'ch_1DStRpEsU0NMi1hvP7ypHviE',1,'2018-11-04 15:47:50','2018-11-04 15:47:50','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-11-04 15:58:50',10,8.00,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(267,27,1,6,80.00,0.00,0.00,1,'ch_1DStlZEsU0NMi1hvFw9LbwIR',1,'2018-11-04 16:08:16','2018-11-04 16:08:16','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-11-04 16:19:16',0,8.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(268,27,1,6,80.00,0.00,0.00,1,'ch_1DSto6EsU0NMi1hv4XwaqSVk',1,'2018-11-04 16:10:52','2018-11-04 16:10:52','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-11-04 16:21:52',10,8.00,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(269,36,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 16:35:35','2018-11-04 16:35:35','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 16:46:35',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(270,36,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 16:35:36','2018-11-04 16:35:36','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 16:46:36',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(271,27,1,6,80.00,0.00,0.00,1,'ch_1DSvgMEsU0NMi1hvTJjHTn2t',1,'2018-11-04 18:10:59','2018-11-04 18:10:59','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-11-04 18:21:59',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(272,39,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-11-04 19:33:59','2018-11-04 19:33:59','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-11-04 19:44:59',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(273,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 19:36:17','2018-11-04 19:36:17','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 19:47:17',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(274,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 19:36:29','2018-11-04 19:36:29','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 19:47:29',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(275,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 19:37:12','2018-11-04 19:37:12','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 19:48:12',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(276,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 19:37:13','2018-11-04 19:37:13','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 19:48:13',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(277,39,1,6,80.00,0.00,0.00,1,'ch_1DSx4NEsU0NMi1hvHcqsxhJT',1,'2018-11-04 19:39:16','2018-11-04 19:39:16','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-11-04 19:50:16',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(278,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 19:41:45','2018-11-04 19:41:45','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 19:52:45',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(279,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 19:41:45','2018-11-04 19:41:45','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 19:52:45',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(280,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 19:42:02','2018-11-04 19:42:02','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 19:53:02',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(281,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-11-04 19:42:23','2018-11-04 19:42:23','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-11-04 19:53:23',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(282,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-11-04 19:43:30','2018-11-04 19:43:30','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-11-04 19:54:30',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(283,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-11-04 19:44:02','2018-11-04 19:44:02','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-11-04 19:55:02',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(284,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 19:44:58','2018-11-04 19:44:58','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 19:55:58',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(285,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 19:46:22','2018-11-04 19:46:22','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 19:57:22',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(286,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 19:46:54','2018-11-04 19:46:54','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 19:57:54',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(287,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-11-04 19:47:00','2018-11-04 19:47:00','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-11-04 19:58:00',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(288,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 19:48:39','2018-11-04 19:48:39','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 19:59:39',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(289,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-11-04 19:51:52','2018-11-04 19:51:52','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-11-04 20:02:52',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(290,38,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-11-04 19:53:51','2018-11-04 19:53:51','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-11-04 20:04:51',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(291,38,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 19:56:10','2018-11-04 19:56:10','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 20:07:10',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(292,38,1,6,80.00,0.00,0.00,1,'ch_1DSxKdEsU0NMi1hvcijWLhfx',1,'2018-11-04 19:56:28','2018-11-04 19:56:28','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-11-04 20:07:28',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(293,38,1,6,80.00,0.00,0.00,1,'ch_1DSxOhEsU0NMi1hvFsnauxYV',1,'2018-11-04 20:00:52','2018-11-04 20:00:52','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-11-04 20:11:52',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(294,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-11-04 20:46:01','2018-11-04 20:46:01','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-11-04 20:57:01',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(295,27,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-04 20:55:03','2018-11-04 20:55:03','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-04 21:06:03',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(296,27,1,6,80.00,0.00,0.00,1,'ch_1DSyGoEsU0NMi1hvSkty1fUx',1,'2018-11-04 20:56:46','2018-11-04 20:56:46','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-11-04 21:07:46',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(297,27,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-11-13 18:04:30','2018-11-13 18:04:30','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-11-13 18:15:30',10,8.00,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(298,39,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-11-13 18:07:52','2018-11-13 18:07:52','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-11-13 18:18:52',10,8.00,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(299,39,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-11-13 18:12:38','2018-11-13 18:12:38','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-11-13 18:23:38',10,8.00,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(300,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-13 18:16:30','2018-11-13 18:16:30','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-13 18:27:30',10,8.00,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(301,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-13 18:18:43','2018-11-13 18:18:43','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-13 18:29:43',10,8.00,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(302,39,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-11-13 18:24:48','2018-11-13 18:24:48','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'USER DECLINED','USER DECLINED','2018-11-13 18:35:48',10,8.00,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(303,39,1,6,80.00,0.00,0.00,1,'ch_1DWCByEsU0NMi1hvoaJhdVGt',1,'2018-11-13 18:25:11','2018-11-13 18:25:11','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-11-13 18:36:11',10,8.00,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(304,39,1,6,51.59,0.00,0.00,1,'ch_1DWCHPEsU0NMi1hvmxzWVFQt',1,'2018-11-13 18:30:43','2018-11-13 18:30:43','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-11-13 18:41:43',10,5.00,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(305,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-11-13 18:49:05','2018-11-13 18:49:05','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-11-13 19:00:05',10,8.40,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(306,39,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-11-13 19:17:52','2018-11-13 19:17:52','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'USER DECLINED','USER DECLINED','2018-11-13 19:28:52',10,8.40,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(307,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-03 21:54:00','2018-12-03 21:54:00','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-03 22:05:00',10,8.40,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(308,39,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-12-03 21:56:42','2018-12-03 21:56:42','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'USER DECLINED','USER DECLINED','2018-12-03 22:07:42',10,8.40,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(309,39,1,6,80.00,0.00,0.00,1,'ch_1DdV2bEsU0NMi1hvYirHGGfE',1,'2018-12-03 21:57:32','2018-12-03 21:57:32','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-12-03 22:08:32',10,8.40,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(310,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-03 22:03:23','2018-12-03 22:03:23','W',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-12-03 22:15:23',10,8.40,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(311,39,1,6,80.00,0.00,0.00,1,'ch_1DdV95EsU0NMi1hvNncHWMsC',1,'2018-12-03 22:04:21','2018-12-03 22:04:21','A',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-12-03 22:16:21',10,8.40,NULL,'D',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(312,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-04 18:03:13','2018-12-04 18:03:13','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-04 18:14:13',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(313,39,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-12-04 18:05:30','2018-12-04 18:05:30','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-12-04 18:16:30',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(314,39,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-12-04 18:11:11','2018-12-04 18:11:11','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-12-04 18:22:11',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(315,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-04 18:13:25','2018-12-04 18:13:25','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-04 18:24:25',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(316,39,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-12-04 18:59:51','2018-12-04 18:59:51','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'NO REPLY','TIMEOUT','2018-12-04 19:10:51',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(317,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-04 19:01:54','2018-12-04 19:01:54','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-04 19:12:54',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(318,39,1,6,80.00,0.00,0.00,1,'ch_1DdonREsU0NMi1hvkjewUiRU',1,'2018-12-04 19:03:07','2018-12-04 19:03:07','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-04 19:14:07',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(319,39,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-12-06 19:23:58','2018-12-06 19:23:58','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'USER DECLINED','USER DECLINED','2018-12-06 19:34:58',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(320,39,1,6,80.00,0.00,0.00,1,'ch_1DeYABEsU0NMi1hvLTgTTKLv',1,'2018-12-06 19:29:34','2018-12-06 19:29:34','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-12-06 19:40:34',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(321,39,1,6,80.00,0.00,0.00,1,'ch_1DeYCTEsU0NMi1hvQr43FGhC',1,'2018-12-06 19:32:06','2018-12-06 19:32:06','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-12-06 19:43:06',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(322,39,1,6,80.00,0.00,0.00,1,'ch_1DeYEWEsU0NMi1hvG8LdnNVj',1,'2018-12-06 19:34:07','2018-12-06 19:34:07','A',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,1,'AUTHORIZED','AUTHORIZED','2018-12-06 19:45:07',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(323,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-06 19:47:55','2018-12-06 19:47:55','W',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-06 19:58:55',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(324,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 17:28:33','2018-12-08 17:28:33','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 17:40:33',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(325,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 17:42:23','2018-12-08 17:42:23','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 17:53:23',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(326,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 17:45:01','2018-12-08 17:45:01','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 17:56:01',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(327,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 17:48:12','2018-12-08 17:48:12','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 17:59:12',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(328,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 17:48:46','2018-12-08 17:48:46','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 17:59:46',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(329,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 17:49:28','2018-12-08 17:49:28','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 18:00:28',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(330,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 17:50:15','2018-12-08 17:50:15','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 18:01:15',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(331,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 17:57:24','2018-12-08 17:57:24','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 18:08:24',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(332,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 18:00:50','2018-12-08 18:00:50','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 18:11:50',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(333,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 18:03:42','2018-12-08 18:03:42','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 18:14:42',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(334,39,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-12-08 18:04:09','2018-12-08 18:04:09','W',NULL,300.00,10,NULL,0,45,0,0,NULL,NULL,0,'NO REPLY','TIMEOUT','2018-12-08 18:49:09',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(335,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 18:04:10','2018-12-08 18:04:10','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 18:15:10',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(336,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 18:05:00','2018-12-08 18:05:00','W',NULL,300.00,10,NULL,0,60,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:05:00',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(337,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 18:05:01','2018-12-08 18:05:01','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 18:16:01',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(338,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 18:13:44','2018-12-08 18:13:44','W',NULL,300.00,10,NULL,0,45,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 18:58:44',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(339,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:29:30','2018-12-08 19:29:30','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:40:30',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(340,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:29:31','2018-12-08 19:29:31','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:40:31',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(341,39,2,10,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:29:41','2018-12-08 19:29:41','W',NULL,300.00,10,NULL,0,45,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 20:14:41',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(342,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:34:49','2018-12-08 19:34:49','D',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:45:49',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(343,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:34:50','2018-12-08 19:34:50','N',NULL,300.00,10,NULL,0,11,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:45:50',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(344,39,2,10,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:35:00','2018-12-08 19:35:00','W',NULL,300.00,10,NULL,0,13,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:48:00',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(345,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:36:38','2018-12-08 19:36:38','D',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:48:38',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(346,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:36:39','2018-12-08 19:36:39','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:48:39',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(347,39,2,10,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:37:48','2018-12-08 19:37:48','N',NULL,300.00,10,NULL,0,13,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:50:48',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(348,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:38:04','2018-12-08 19:38:04','D',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:50:04',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(349,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:38:05','2018-12-08 19:38:05','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:50:05',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(350,39,2,10,80.00,0.00,0.00,1,'ch_1DfHFTEsU0NMi1hvBEQZUxFq',1,'2018-12-08 19:38:13','2018-12-08 19:38:13','A',NULL,300.00,10,NULL,0,60,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-08 20:38:13',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(351,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:45:42','2018-12-08 19:45:42','N',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:57:42',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(352,39,2,10,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:45:51','2018-12-08 19:45:51','N',NULL,300.00,10,NULL,0,13,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:58:51',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(353,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:46:23','2018-12-08 19:46:23','D',NULL,300.00,10,NULL,0,12,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 19:58:23',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(354,39,2,10,80.00,0.00,0.00,0,'0',0,'2018-12-08 19:47:29','2018-12-08 19:47:29','D',NULL,300.00,10,NULL,0,13,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 20:00:29',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(355,39,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-12-08 20:06:35','2018-12-08 20:06:35','W',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'USER DECLINED','USER DECLINED','2018-12-08 20:23:35',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(356,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 21:50:33','2018-12-08 21:50:33','D',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:07:33',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(357,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 21:52:03','2018-12-08 21:52:03','D',NULL,300.00,10,NULL,0,15,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:07:03',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(358,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 21:55:13','2018-12-08 21:55:13','D',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:12:13',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(359,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 21:57:27','2018-12-08 21:57:27','D',NULL,300.00,10,NULL,0,15,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:12:27',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(360,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:00:41','2018-12-08 22:00:41','D',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:17:41',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(361,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:03:56','2018-12-08 22:03:56','D',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:20:56',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(362,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:04:46','2018-12-08 22:04:46','D',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:21:46',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(363,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:06:18','2018-12-08 22:06:18','D',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:23:18',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(364,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:07:57','2018-12-08 22:07:57','D',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:24:57',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(365,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:09:41','2018-12-08 22:09:41','D',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:26:41',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(366,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:10:54','2018-12-08 22:10:54','D',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:27:54',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(367,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:13:19','2018-12-08 22:13:19','D',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:29:19',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(368,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:13:46','2018-12-08 22:13:46','D',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:29:46',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(369,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:21:03','2018-12-08 22:21:03','D',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:37:03',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(370,39,1,6,80.00,0.00,0.00,0,'UNAUTHORIZED',0,'2018-12-08 22:22:37','2018-12-08 22:22:37','W',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,'USER DECLINED','USER DECLINED','2018-12-08 22:38:37',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(371,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:23:59','2018-12-08 22:23:59','D',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:39:59',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(372,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:24:26','2018-12-08 22:24:26','D',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:40:26',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(373,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:26:07','2018-12-08 22:26:07','D',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:42:07',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(374,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:26:08','2018-12-08 22:26:08','N',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:42:08',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(375,39,2,10,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:26:16','2018-12-08 22:26:16','D',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:43:16',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(376,39,2,10,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:26:17','2018-12-08 22:26:17','N',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:43:17',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(377,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:28:15','2018-12-08 22:28:15','D',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:44:15',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(378,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:28:16','2018-12-08 22:28:16','N',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:44:16',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(379,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:28:50','2018-12-08 22:28:50','D',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:44:50',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(380,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:28:51','2018-12-08 22:28:51','N',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:44:51',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(381,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-08 22:29:09','2018-12-08 22:29:09','N',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 22:45:09',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(382,39,2,10,80.00,0.00,0.00,0,'0',0,'2018-12-08 23:41:52','2018-12-08 23:41:52','W',NULL,300.00,10,NULL,0,18,0,0,NULL,NULL,0,NULL,NULL,'2018-12-08 23:59:52',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(383,39,1,4,40.00,0.00,0.00,0,'0',0,'2018-12-08 23:50:01','2018-12-08 23:50:01','W',NULL,300.00,7,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-09 00:07:01',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(384,39,1,4,40.00,0.00,0.00,0,'0',0,'2018-12-08 23:52:48','2018-12-08 23:52:48','W',NULL,300.00,7,NULL,0,15,0,0,NULL,NULL,0,NULL,NULL,'2018-12-09 00:07:48',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(385,39,1,4,40.00,0.00,0.00,1,'CREDIT',1,'2018-12-08 23:54:58','2018-12-08 23:54:58','A',NULL,300.00,7,NULL,0,17,0,0,NULL,NULL,0,'CREDIT','CREDIT','2018-12-09 00:11:58',0,100.00,NULL,'C',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(386,39,1,4,40.00,0.00,0.00,1,'CREDIT',1,'2018-12-08 23:58:36','2018-12-08 23:58:36','A',NULL,300.00,7,NULL,0,45,0,0,NULL,NULL,0,'CREDIT','CREDIT','2018-12-09 00:43:36',0,100.00,NULL,'C',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(387,39,1,4,40.00,0.00,0.00,1,'CREDIT',1,'2018-12-09 00:02:31','2018-12-09 00:02:31','A',NULL,300.00,7,NULL,0,16,0,0,NULL,NULL,0,'CREDIT','CREDIT','2018-12-09 00:18:31',0,100.00,NULL,'C',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(388,39,1,4,40.00,0.00,0.00,1,'CREDIT',1,'2018-12-09 00:05:08','2018-12-09 00:05:08','A',NULL,300.00,7,NULL,0,17,0,0,NULL,NULL,0,'CREDIT','CREDIT','2018-12-09 00:22:08',0,100.00,NULL,'C',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(389,39,1,4,40.00,0.00,0.00,0,'0',0,'2018-12-09 00:06:54','2018-12-09 00:06:54','D',NULL,300.00,7,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-09 00:23:54',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(390,39,1,4,40.00,0.00,0.00,0,'0',0,'2018-12-09 00:06:55','2018-12-09 00:06:55','N',NULL,300.00,7,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-09 00:23:55',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(391,39,1,4,40.00,0.00,0.00,0,'0',0,'2018-12-09 00:07:32','2018-12-09 00:07:32','N',NULL,300.00,7,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-09 00:24:32',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(392,39,1,4,40.00,0.00,0.00,0,'0',0,'2018-12-09 00:07:58','2018-12-09 00:07:58','D',NULL,300.00,7,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-09 00:24:58',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(393,39,1,4,40.00,0.00,0.00,0,'0',0,'2018-12-09 00:07:58','2018-12-09 00:07:58','N',NULL,300.00,7,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-09 00:24:58',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(394,39,1,4,40.00,0.00,0.00,1,'CREDIT',1,'2018-12-09 00:09:29','2018-12-09 00:09:29','A',NULL,300.00,7,NULL,0,45,0,0,NULL,NULL,0,'CREDIT','CREDIT','2018-12-09 00:54:29',0,42.00,NULL,'C',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(395,39,1,4,40.00,0.00,0.00,1,'CREDIT',1,'2018-12-09 00:21:22','2018-12-09 00:21:22','A',NULL,300.00,7,NULL,0,30,0,0,NULL,NULL,0,'CREDIT','CREDIT','2018-12-09 00:51:22',0,NULL,NULL,'C',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(396,39,1,4,40.00,0.00,0.00,1,'CREDIT',1,'2018-12-09 00:23:28','2018-12-09 00:23:28','A',NULL,300.00,7,NULL,0,15,0,0,NULL,NULL,0,'CREDIT','CREDIT','2018-12-09 00:38:28',0,NULL,NULL,'C',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(397,39,1,4,40.00,0.00,0.00,0,'0',0,'2018-12-09 00:24:48','2018-12-09 00:24:48','W',NULL,300.00,7,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2018-12-09 00:40:48',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(398,39,1,4,40.00,0.00,0.00,1,'CREDIT',1,'2018-12-09 00:26:32','2018-12-09 00:26:32','A',NULL,300.00,7,NULL,0,16,0,0,NULL,NULL,0,'CREDIT','CREDIT','2018-12-09 00:42:32',0,42.00,NULL,'C',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(399,39,1,4,40.00,0.00,0.00,1,'ch_1DfLldEsU0NMi1hvR2wJkeNT',1,'2018-12-09 00:27:51','2018-12-09 00:27:51','A',NULL,300.00,7,NULL,0,16,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-09 00:43:51',0,10.00,NULL,'C',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(400,39,1,4,40.00,0.00,0.00,1,'ch_1DfLquEsU0NMi1hv2la6ohaK',1,'2018-12-09 00:33:18','2018-12-09 00:33:18','A',NULL,300.00,7,NULL,0,16,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-09 00:49:18',0,10.00,NULL,'C',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(401,39,1,4,40.00,0.00,0.00,1,'ch_1DfLuBEsU0NMi1hvE0drrEgW',1,'2018-12-09 00:36:41','2018-12-09 00:36:41','A',NULL,300.00,7,NULL,0,16,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-09 00:52:41',0,0.00,NULL,'C',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(402,39,1,4,40.00,0.00,0.00,1,'ch_1DfMl4EsU0NMi1hvhS5XfFBv',1,'2018-12-09 01:31:22','2018-12-09 01:31:22','A',NULL,300.00,7,NULL,0,15,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-09 01:46:22',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(403,39,1,6,80.00,0.00,0.00,1,'ch_1DfNAIEsU0NMi1hvCoEEuzDs',1,'2018-12-09 01:57:24','2018-12-09 01:57:24','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-09 02:14:24',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(404,39,1,6,80.00,0.00,0.00,1,'ch_1DfNEKEsU0NMi1hv20vkZkLf',1,'2018-12-09 02:01:34','2018-12-09 02:01:34','A',NULL,300.00,10,NULL,0,15,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-09 02:16:34',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(405,39,1,4,40.00,0.00,0.00,1,'ch_1DfNGqEsU0NMi1hvyfQqFIF8',1,'2018-12-09 02:04:11','2018-12-09 02:04:11','A',NULL,300.00,7,NULL,0,15,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-09 02:19:11',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(406,39,1,4,40.00,0.00,0.00,1,'ch_1DfNIVEsU0NMi1hvTn83BUm3',1,'2018-12-09 02:05:54','2018-12-09 02:05:54','A',NULL,300.00,7,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-09 02:22:54',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(407,39,1,4,40.00,0.00,0.00,1,'ch_1DfZbxEsU0NMi1hvOnPO7VT2',1,'2018-12-09 15:14:47','2018-12-09 15:14:47','A',NULL,300.00,7,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-09 15:31:47',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(408,39,1,6,80.00,0.00,0.00,1,'ch_1DfZfCEsU0NMi1hvddvxWPDn',1,'2018-12-09 15:18:08','2018-12-09 15:18:08','A',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-09 15:34:08',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(409,39,1,6,80.00,0.00,0.00,1,'ch_1DfaarEsU0NMi1hvdzHRculX',1,'2018-12-09 16:17:43','2018-12-09 16:17:43','A',NULL,300.00,10,NULL,0,30,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-09 16:47:43',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(410,39,1,6,80.00,0.00,0.00,1,'CREDIT',1,'2018-12-09 17:33:37','2018-12-09 17:33:37','A',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,'CREDIT','CREDIT','2018-12-09 17:49:37',0,84.00,NULL,'C',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(411,39,1,6,80.00,0.00,0.00,1,'ch_1DfbnLEsU0NMi1hviTXyMDuz',1,'2018-12-09 17:34:43','2018-12-09 17:34:43','A',NULL,300.00,10,NULL,0,15,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-09 17:49:43',0,16.00,NULL,'C',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(412,41,2,10,80.00,0.00,0.00,0,'0',0,'2018-12-10 21:10:45','2018-12-10 21:10:45','D',NULL,300.00,10,NULL,0,18,0,0,NULL,NULL,0,NULL,NULL,'2018-12-10 21:28:45',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(413,41,2,10,80.00,0.00,0.00,0,'0',0,'2018-12-10 21:10:46','2018-12-10 21:10:46','N',NULL,300.00,10,NULL,0,18,0,0,NULL,NULL,0,NULL,NULL,'2018-12-10 21:28:46',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(414,41,1,6,80.00,0.00,0.00,1,'ch_1Dg1e8EsU0NMi1hvVYmivMQ0',1,'2018-12-10 21:10:55','2018-12-10 21:10:55','A',NULL,300.00,10,NULL,0,45,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-10 21:55:55',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(415,39,2,10,80.00,0.00,0.00,1,'ch_1Dg1gwEsU0NMi1hvmqfoKzws',1,'2018-12-10 21:13:48','2018-12-10 21:13:48','A',NULL,300.00,10,NULL,0,18,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-10 21:31:48',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(416,39,1,6,80.00,0.00,0.00,1,'ch_1Dg1kOEsU0NMi1hvnry6hWsy',1,'2018-12-10 21:17:22','2018-12-10 21:17:22','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-10 21:34:22',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(417,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-10 21:20:44','2018-12-10 21:20:44','N',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-10 21:37:44',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(418,39,1,6,80.00,0.00,0.00,1,'ch_1Dg1nwEsU0NMi1hvROJzcWdm',1,'2018-12-10 21:21:02','2018-12-10 21:21:02','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-10 21:38:02',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(419,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-10 21:21:45','2018-12-10 21:21:45','D',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-10 21:38:45',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(420,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-10 21:21:45','2018-12-10 21:21:45','N',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-10 21:38:45',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(421,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-10 21:22:15','2018-12-10 21:22:15','D',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-10 21:39:15',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(422,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-10 21:22:16','2018-12-10 21:22:16','N',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-10 21:39:16',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(423,39,1,6,80.00,0.00,0.00,1,'ch_1Dg1poEsU0NMi1hvSkEiJfIM',1,'2018-12-10 21:22:58','2018-12-10 21:22:58','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-10 21:39:58',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(424,39,1,6,80.00,0.00,0.00,1,'ch_1Dg23yEsU0NMi1hvMAagPqme',1,'2018-12-10 21:37:36','2018-12-10 21:37:36','A',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-10 21:53:36',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(425,39,1,6,80.00,0.00,0.00,1,'ch_1Dg25rEsU0NMi1hvLvrQxX5f',1,'2018-12-10 21:39:33','2018-12-10 21:39:33','A',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-10 21:55:33',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(426,39,2,10,80.00,0.00,0.00,1,'ch_1DhlxUEsU0NMi1hvdCoyRh3v',1,'2018-12-15 16:49:59','2018-12-15 16:49:59','A',NULL,300.00,10,NULL,0,18,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-15 17:07:59',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(427,39,1,6,80.00,0.00,0.00,1,'ch_1DhlyjEsU0NMi1hvXjluuaD1',1,'2018-12-15 16:51:16','2018-12-15 16:51:16','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-15 17:08:16',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(428,39,1,6,80.00,0.00,0.00,1,'ch_1DhmN6EsU0NMi1hvsusCNMZT',1,'2018-12-15 17:16:27','2018-12-15 17:16:27','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-15 17:33:27',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(429,39,1,6,80.00,0.00,0.00,1,'ch_1DhmNUEsU0NMi1hvOsswNdEf',1,'2018-12-15 17:16:51','2018-12-15 17:16:51','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-15 17:33:51',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(430,39,1,6,80.00,0.00,0.00,1,'ch_1DhmYLEsU0NMi1hvFl9J4sqJ',1,'2018-12-15 17:28:04','2018-12-15 17:28:04','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-15 17:45:04',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(431,39,1,6,80.00,0.00,0.00,1,'ch_1DhmZIEsU0NMi1hv4LTohEUt',1,'2018-12-15 17:29:03','2018-12-15 17:29:03','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-15 17:46:03',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(432,39,1,6,80.00,0.00,0.00,1,'ch_1DhmbeEsU0NMi1hv1ubjctIt',1,'2018-12-15 17:31:29','2018-12-15 17:31:29','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-15 17:48:29',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(433,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-15 17:34:07','2018-12-15 17:34:07','N',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-15 17:51:07',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(434,39,1,6,80.00,0.00,0.00,0,'0',0,'2018-12-15 17:34:32','2018-12-15 17:34:32','N',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,NULL,NULL,'2018-12-15 17:51:32',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(435,39,1,6,80.00,0.00,0.00,1,'ch_1DhmeqEsU0NMi1hvJ0962pmu',1,'2018-12-15 17:34:47','2018-12-15 17:34:47','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-15 17:51:47',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(436,39,1,6,80.00,0.00,0.00,1,'ch_1DhmfpEsU0NMi1hvaUyaAKjC',1,'2018-12-15 17:35:48','2018-12-15 17:35:48','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2018-12-15 17:52:48',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(437,39,1,1,60.00,0.00,0.00,0,'0',0,'2019-01-02 16:51:48','2019-01-02 16:51:48','D',NULL,300.00,9,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2019-01-02 17:07:48',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(438,39,1,1,60.00,0.00,0.00,0,'0',0,'2019-01-02 16:51:49','2019-01-02 16:51:49','N',NULL,300.00,9,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2019-01-02 17:07:49',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(439,39,1,1,60.00,5.00,0.00,1,'ch_1DoJgiEsU0NMi1hvgd7IHQGk',1,'2019-01-02 18:03:49','2019-02-18 00:01:12','A',2,300.00,9,NULL,0,16,1,1,'ch_1E4zZLEsU0NMi1hvNWeRefh6','2019-02-18 00:01:12',1,'AUTHORIZED','AUTHORIZED','2019-01-02 18:19:49',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(440,39,1,1,60.00,0.00,0.00,1,'ch_1DoJhIEsU0NMi1hvRtrATVcT',1,'2019-01-02 18:04:25','2019-01-02 18:04:25','A',NULL,300.00,9,NULL,0,16,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-02 18:20:25',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(441,39,1,1,60.00,0.00,0.00,0,'0',0,'2019-01-02 18:07:18','2019-01-02 18:07:18','N',NULL,300.00,9,NULL,0,16,0,0,NULL,NULL,0,NULL,NULL,'2019-01-02 18:23:18',0,0.00,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(442,39,1,1,60.00,0.00,0.00,1,'ch_1DoJkhEsU0NMi1hvHzg0EB7T',1,'2019-01-02 18:07:57','2019-01-02 18:07:57','A',NULL,300.00,9,NULL,0,16,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-02 18:23:57',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(443,39,1,6,80.00,5.00,0.00,1,'ch_1DoJxLEsU0NMi1hvlMN4CUdz',1,'2019-01-02 18:21:01','2019-02-08 23:53:32','A',NULL,300.00,10,NULL,0,16,1,1,'ch_1E1j9zEsU0NMi1hvcpkRKywB','2019-02-08 23:53:32',1,'AUTHORIZED','AUTHORIZED','2019-01-02 18:37:01',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(444,39,1,6,80.00,0.00,0.00,1,'ch_1DoK1aEsU0NMi1hvMRKsZMBQ',1,'2019-01-02 18:25:24','2019-01-02 18:25:24','A',NULL,300.00,10,NULL,0,16,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-02 18:41:24',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(445,40,2,8,50.00,0.00,0.00,1,'ch_1DqkKnEsU0NMi1hvhCrdQ3Rh',1,'2019-01-09 10:55:15','2019-01-09 10:55:15','A',NULL,300.00,1,NULL,0,30,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-09 11:25:15',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(446,40,1,6,80.00,0.00,0.00,1,'ch_1DqkMiEsU0NMi1hvQTu3rDDn',1,'2019-01-09 10:57:14','2019-01-09 10:57:14','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-09 11:14:14',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(447,40,1,6,80.00,0.00,0.00,1,'ch_1DqkNVEsU0NMi1hv9agFz9V2',1,'2019-01-09 10:58:03','2019-01-09 10:58:03','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-09 11:15:03',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(448,40,1,6,80.00,0.00,0.00,1,'ch_1DqkOAEsU0NMi1hvTdui3R7V',1,'2019-01-09 10:58:44','2019-01-09 10:58:44','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-09 11:15:44',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(449,40,1,6,80.00,0.00,0.00,1,'ch_1DqkPfEsU0NMi1hvg6zqW3q9',1,'2019-01-09 11:00:17','2019-01-09 11:00:17','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-09 11:17:17',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(450,40,1,6,80.00,0.00,0.00,1,'ch_1DqmTJEsU0NMi1hvhwGso1Rz',1,'2019-01-09 13:12:11','2019-01-09 13:12:11','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-09 13:29:11',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(451,42,1,6,80.00,0.00,0.00,1,'ch_1DqmVnEsU0NMi1hvgce73QME',1,'2019-01-09 13:14:45','2019-01-09 13:14:45','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-09 13:31:45',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(452,42,1,6,80.00,0.00,0.00,1,'ch_1DqmWREsU0NMi1hveYVdshsg',1,'2019-01-09 13:15:25','2019-01-09 13:15:25','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-09 13:32:25',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(453,42,1,6,80.00,0.00,0.00,1,'ch_1DqmWtEsU0NMi1hviedwdwfJ',1,'2019-01-09 13:15:53','2019-01-09 13:15:53','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-09 13:32:53',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(454,42,2,10,80.00,0.00,0.00,1,'ch_1DqnmxEsU0NMi1hvbNtAlL2R',1,'2019-01-09 14:36:32','2019-01-09 14:36:32','A',NULL,300.00,10,NULL,0,18,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-09 14:54:32',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(455,42,2,10,80.00,0.00,0.00,1,'ch_1DqnrREsU0NMi1hv5SIts7HG',1,'2019-01-09 14:41:12','2019-01-09 14:41:12','A',NULL,300.00,10,NULL,0,18,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-09 14:59:12',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(456,42,2,10,80.00,0.00,0.00,1,'ch_1Dqns3EsU0NMi1hvIO6bjDOi',1,'2019-01-09 14:41:50','2019-01-09 14:41:50','A',NULL,300.00,10,NULL,0,18,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-09 14:59:50',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(457,42,1,6,80.00,0.00,0.00,1,'ch_1DqnvqEsU0NMi1hvk3T8LGCW',1,'2019-01-09 14:45:44','2019-01-09 14:45:44','A',NULL,300.00,10,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-01-09 15:02:44',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(458,39,2,10,80.00,2.00,0.00,1,'ch_1DqoonEsU0NMi1hvIdGDxYFH',1,'2019-01-09 15:42:31','2019-02-08 23:52:11','A',NULL,300.00,10,NULL,0,17,1,1,'ch_1E1j8gEsU0NMi1hvHWdEoc3S','2019-02-08 23:52:11',1,'AUTHORIZED','AUTHORIZED','2019-01-09 15:59:31',0,0.00,NULL,'N',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(459,39,4,22,30.00,0.00,0.00,1,'ch_1E6OPDEsU0NMi1hvSmzVNp50',1,'2019-02-21 14:44:31','2019-02-21 14:44:31','A',NULL,300.00,1,NULL,0,11,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-02-21 22:09:31',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(460,39,5,23,80.00,0.00,0.00,1,'ch_1E6PvyEsU0NMi1hvv8u2uoqi',1,'2019-02-21 22:22:25','2019-02-21 22:22:25','A',NULL,300.00,1,NULL,0,23,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-02-21 22:45:25',0,5.00,NULL,'P',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(461,39,2,20,60.00,0.00,0.00,1,'ch_1E6PwkEsU0NMi1hv5IwNCtWh',1,'2019-02-21 22:23:13','2019-02-21 22:23:13','A',NULL,300.00,1,NULL,0,17,0,0,NULL,NULL,0,'AUTHORIZED','AUTHORIZED','2019-02-21 22:40:13',0,5.00,NULL,'P',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,'Please be there','Hakuna Massage Parlous'),
	(462,39,1,1,30.00,NULL,0.00,NULL,'0',0,'2019-04-05 00:48:35','2019-04-05 00:48:35','A',NULL,NULL,3,NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,'2019-03-25 23:30:00',NULL,NULL,NULL,'P',79,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(464,39,1,1,30.00,NULL,0.00,NULL,'0',0,'2019-04-06 23:17:20','2019-04-06 23:17:20','A',NULL,NULL,3,NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,'2019-04-01 13:30:00',NULL,NULL,NULL,NULL,80,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(465,39,1,1,60.00,NULL,0.00,NULL,'0',0,'2019-04-07 20:30:19','2019-04-07 20:30:19','A',NULL,NULL,3,NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,'2019-04-07 15:00:00',NULL,6.00,NULL,'CO',81,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(466,39,1,1,60.00,NULL,0.00,NULL,'0',0,'2019-04-07 20:44:51','2019-04-07 20:44:51','A',NULL,NULL,3,NULL,0,NULL,0,0,NULL,NULL,0,NULL,NULL,'2019-04-07 15:15:00',NULL,63.00,NULL,'C',83,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_notifications`;

CREATE TABLE `user_notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `allnotifications` tinyint(1) NOT NULL DEFAULT '0',
  `viapush` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `viatext` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `user_notifications` WRITE;
/*!40000 ALTER TABLE `user_notifications` DISABLE KEYS */;

INSERT INTO `user_notifications` (`id`, `allnotifications`, `viapush`, `created_at`, `updated_at`, `user_id`, `viatext`)
VALUES
	(1,1,1,'2018-03-25 04:24:08','2018-03-25 04:24:08',3,0),
	(2,1,1,'2018-03-25 04:24:32','2018-03-25 04:24:32',4,0),
	(3,1,1,'2018-03-25 04:25:04','2018-03-25 04:25:04',5,0),
	(4,1,1,'2018-03-25 04:26:20','2018-03-25 04:26:20',6,0),
	(5,1,1,'2018-03-25 04:27:36','2018-03-25 04:27:36',7,0),
	(6,1,1,'2018-03-25 04:28:13','2018-03-25 04:28:13',8,0),
	(7,0,1,'2018-03-25 04:36:19','2018-03-25 04:36:23',10,0),
	(8,1,1,'2018-08-04 23:34:46','2018-08-04 23:34:46',12,0),
	(9,1,1,'2018-08-04 23:37:43','2018-08-04 23:37:43',13,0),
	(10,1,1,'2018-08-07 00:15:28','2018-08-07 00:15:28',14,0),
	(11,1,1,'2018-08-07 00:17:08','2018-08-07 00:17:08',15,0),
	(12,1,1,'2018-08-07 00:23:05','2018-08-07 00:23:05',16,0),
	(13,1,1,'2018-09-12 02:42:53','2018-09-12 02:43:59',17,0),
	(14,1,1,'2018-09-12 02:45:19','2018-09-12 02:45:19',18,0),
	(15,1,1,'2018-09-12 04:37:12','2018-09-12 04:38:16',19,0),
	(16,1,1,'2018-09-12 04:40:48','2018-09-12 04:40:48',20,0),
	(17,1,1,'2018-09-12 04:47:54','2018-09-12 04:47:54',21,0),
	(18,1,0,'2018-09-30 18:39:26','2018-10-01 01:52:16',22,1),
	(19,1,0,'2018-09-30 21:02:34','2018-10-07 23:20:38',23,1),
	(20,1,0,'2018-10-04 00:31:51','2018-10-05 19:52:12',24,1),
	(21,1,1,'2018-10-07 20:51:36','2018-10-08 23:09:27',25,0),
	(22,1,1,'2018-10-09 00:21:31','2018-11-14 00:06:47',27,0),
	(23,1,1,'2018-10-09 02:08:56','2018-10-09 02:08:56',28,0),
	(24,1,0,'2018-10-09 02:11:58','2018-10-09 02:26:34',29,1),
	(25,1,0,'2018-10-09 04:25:02','2018-10-09 04:25:57',30,1),
	(26,1,0,'2018-10-09 04:36:29','2018-10-09 04:39:43',31,1),
	(27,1,1,'2018-10-11 05:59:09','2018-10-11 06:00:10',32,0),
	(28,1,1,'2018-10-14 16:56:06','2018-10-16 01:41:46',33,0),
	(29,1,0,'2018-10-16 04:32:34','2018-10-16 04:59:07',34,1),
	(30,1,1,'2018-10-17 22:38:33','2018-10-17 23:15:04',35,0),
	(31,1,1,'2018-11-04 22:12:14','2018-11-05 02:34:24',36,0),
	(32,1,1,'2018-11-05 01:30:46','2018-11-05 01:31:10',37,0),
	(33,1,1,'2018-11-05 01:31:40','2018-11-05 02:03:11',38,0),
	(34,1,1,'2018-11-05 01:33:12','2019-04-18 02:39:16',39,0),
	(35,1,1,'2018-12-11 02:47:17','2019-01-09 19:07:15',40,0),
	(36,1,1,'2018-12-11 02:57:05','2018-12-11 02:57:18',41,0),
	(37,1,1,'2019-01-09 19:13:52','2019-01-09 19:13:58',42,0),
	(38,1,1,'2019-01-19 01:02:44','2019-01-19 01:02:49',43,0),
	(39,1,1,'2019-02-16 17:53:09','2019-02-17 20:04:58',44,0),
	(40,1,1,'2019-02-17 21:01:10','2019-02-19 00:39:41',26,0),
	(41,1,1,'2019-02-18 20:59:00','2019-02-18 20:59:05',45,0),
	(42,1,0,'2019-03-29 05:06:18','2019-03-29 05:06:24',46,1),
	(43,1,0,'2019-03-30 21:17:22','2019-03-30 21:17:27',47,1),
	(44,1,0,'2019-04-01 22:03:13','2019-04-01 22:03:47',48,1),
	(45,1,0,'2019-04-01 22:06:16','2019-04-01 22:08:04',49,1);

/*!40000 ALTER TABLE `user_notifications` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table usercredits
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usercredits`;

CREATE TABLE `usercredits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usercredit_user_id_foreign` (`user_id`),
  CONSTRAINT `usercredit_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `usercredits` WRITE;
/*!40000 ALTER TABLE `usercredits` DISABLE KEYS */;

INSERT INTO `usercredits` (`id`, `user_id`, `amount`, `created_at`, `updated_at`)
VALUES
	(3,39,37.00,NULL,'2019-04-07 20:44:51');

/*!40000 ALTER TABLE `usercredits` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table userprofiles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userprofiles`;

CREATE TABLE `userprofiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `firstname` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `introskip` tinyint(1) NOT NULL DEFAULT '0',
  `instafirstclick` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `userprofiles_user_id_unique` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `userprofiles` WRITE;
/*!40000 ALTER TABLE `userprofiles` DISABLE KEYS */;

INSERT INTO `userprofiles` (`id`, `user_id`, `firstname`, `lastname`, `phone`, `created_at`, `updated_at`, `introskip`, `instafirstclick`)
VALUES
	(1,1,'Adevjitlc','Gulatietest','+13062625152','2018-03-06 00:46:38','2018-12-11 00:15:10',1,1),
	(2,10,'Lolnam','Testname','+13062615152','2018-03-25 04:36:19','2018-03-25 04:36:19',0,0),
	(3,12,'Human','Name','+13062625152','2018-08-04 23:34:46','2018-08-04 23:34:46',0,0),
	(4,13,'Fast','Mob','+13062625152','2018-08-04 23:37:43','2018-08-05 05:38:36',0,0),
	(5,14,'Matt','Fast','+13062625182','2018-08-07 00:15:28','2018-08-07 00:15:28',0,0),
	(6,15,'Hex','Mex','+16065625252','2018-08-07 00:17:08','2018-08-07 00:17:08',0,0),
	(7,16,'Gex','Lez','+13062625152','2018-08-07 00:23:05','2018-10-02 23:05:34',1,1),
	(8,17,'Bull','Shit','+13062625152','2018-09-12 02:42:53','2018-09-12 03:00:05',1,0),
	(9,18,'Lame','Male','+13062625152','2018-09-12 02:45:19','2018-09-12 02:57:23',1,0),
	(10,19,'Reg','Me','+13062625152','2018-09-12 04:37:12','2018-09-12 04:37:12',0,0),
	(11,20,'Fail','Me','+13062625152','2018-09-12 04:40:48','2018-09-12 04:40:48',0,0),
	(12,21,'Tes','Tesx','+13062625152','2018-09-12 04:47:54','2018-09-12 04:56:53',1,0),
	(13,22,'Aj','Gulati','+13062625152','2018-09-30 18:39:26','2018-10-01 01:05:31',1,1),
	(14,23,'Men','Men','+13062625152','2018-09-30 21:02:34','2018-10-01 00:11:17',1,1),
	(15,24,'Next','Nex','+13062625152','2018-10-04 00:31:51','2018-10-04 00:49:19',1,0),
	(16,25,'Devtes','Jit','+13062625152','2018-10-07 20:51:36','2018-10-08 23:06:46',1,1),
	(17,27,'Testmelo','Form','+13062625152','2018-10-09 00:21:31','2018-11-04 20:05:11',1,1),
	(18,28,'Fidox','Fisox','+13062625152','2018-10-09 02:08:56','2018-10-09 02:10:37',1,0),
	(19,29,'Daniel','Smolinski','+13062301875','2018-10-09 02:11:58','2018-10-09 02:24:08',1,1),
	(20,30,'Ad','Guk','+13062625152','2018-10-09 04:25:02','2018-10-09 04:25:53',1,0),
	(21,31,'Ma','Dam','+13062625152','2018-10-09 04:36:29','2018-10-09 04:36:47',1,0),
	(22,32,'Dest','Dest','+13062625152','2018-10-11 05:59:09','2018-10-11 05:59:53',1,0),
	(23,33,'Vid','Vid','+13062625152','2018-10-14 16:56:06','2018-10-14 16:59:24',1,0),
	(24,34,'Med','Med','+13062625152','2018-10-16 04:32:34','2018-10-16 04:35:43',1,1),
	(25,35,'Fald','Fal','+13062625152','2018-10-17 22:38:33','2018-10-17 22:46:03',1,1),
	(26,36,'Ade','Gula','+13062625152','2018-11-04 22:12:14','2018-11-04 22:12:23',1,0),
	(27,37,'Ade','Gul','+13062625152','2018-11-05 01:30:46','2018-11-05 01:31:08',1,0),
	(28,38,'Hec','Gul','+13062625452','2018-11-05 01:31:40','2018-11-05 02:03:11',1,0),
	(31,39,'Feexk','Fecg','+13062665152','2018-11-05 01:33:12','2019-03-24 20:08:17',1,0),
	(32,40,'Ajmewv2','V2','+13062625152','2018-12-11 02:47:17','2019-01-09 17:51:55',1,0),
	(33,41,'Testv2','V2','+13062625152','2018-12-11 02:57:05','2018-12-11 02:57:18',1,0),
	(34,42,'Al','Gul','+13062625152','2019-01-09 19:13:52','2019-01-09 19:16:18',1,0),
	(35,43,'Adevjit','Gulati','+13062625152','2019-01-19 01:02:44','2019-01-19 23:52:42',1,0),
	(36,44,'Hallo','Hallo','+13062625152','2019-02-16 17:53:09','2019-02-17 17:49:22',1,0),
	(37,26,'Fur','Gikati','+13062625152','2019-02-17 21:01:10','2019-02-17 21:01:14',1,0),
	(38,45,'Aj','Gulati','+13062625152','2019-02-18 20:59:00','2019-02-18 20:59:04',1,0),
	(39,46,'Aj','Gulti','+13062625152','2019-03-29 05:06:18','2019-03-29 05:06:24',1,0),
	(40,47,'Aj','Gulati','+13062625152','2019-03-30 21:17:22','2019-03-30 21:17:26',1,0),
	(41,48,'Faltu','Jakaa','+13062625152','2019-04-01 22:03:13','2019-04-01 22:03:13',0,0),
	(43,49,'And','Mod','+13062625152','2019-04-01 22:06:16','2019-04-01 22:06:16',0,0);

/*!40000 ALTER TABLE `userprofiles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `expotoken` text COLLATE utf8mb4_unicode_ci,
  `agree` tinyint(1) NOT NULL DEFAULT '0',
  `emailsent` tinyint(1) NOT NULL DEFAULT '0',
  `confirmed` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arn` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscribed` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `status`, `expotoken`, `agree`, `emailsent`, `confirmed`, `remember_token`, `created_at`, `updated_at`, `api_token`, `arn`, `platform`, `subscribed`)
VALUES
	(1,'asg452@mail.usask.ca','$2y$10$6FmcW0px/ZQxdOsJpPE2F.mr4HCbu.Fkx4pRBb8bblZaDO5VvX6L2',1,'e3EW4EANjPE:APA91bGHLes7fXhGaH21ZMY6KicvRoA1ARrHYwq6liNS81JWme8DXxIz5q5G5JAsk_-lPTWPRvwab_XZZh31T0AYecl-8RZy1jKB2E5XJFujE_NNTAtOmXraXFgKA5o-YUYhHRSBggnG',0,0,1,'1AvzB90sseaYnMHTde5CWQCydGKzMVztbwBJwpdRPRueToMwsIbM24otYvBv','2018-03-06 00:43:17','2018-10-22 00:06:26',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/dbd18d06-cd58-3f50-9217-0934aa1d42a7','ios',0),
	(2,'adevjittest@mail.com','$2y$10$H/l485OjiifkTxnh1yHXVOp3m5hUrh4J5dlkr2NR/ACZNy0PavcX.',1,'cTTezVGgf40:APA91bFDSrF64ggNFCAqSartowQJPYrmGTK_adbrnAuULOg-zWJVEEDuCEMvY64FOjeidJPzKVWodIRzPncBDRiB6LTS__RyuvEIoXk-Fe5Pv65vxjRnqHbdVybE424uQ9rpKrURj3A_',0,0,1,NULL,'2018-03-25 04:21:08','2019-04-08 04:52:03',NULL,NULL,'ios',0),
	(3,'adevjittesta@mail.com','123456',1,'12',0,0,1,NULL,'2018-03-25 04:24:08','2018-03-25 04:24:08',NULL,NULL,NULL,1),
	(4,'testnew@mail.com','123456',1,'12',0,0,0,NULL,'2018-03-25 04:24:32','2018-03-25 04:24:32',NULL,NULL,NULL,0),
	(5,'testnew@1mail.com','123456',1,'12',0,0,1,NULL,'2018-03-25 04:25:04','2018-03-25 04:25:04',NULL,NULL,NULL,1),
	(6,'testnew@1mail.coma','123456',1,'12',0,0,1,NULL,'2018-03-25 04:26:20','2018-03-25 04:26:20',NULL,NULL,NULL,1),
	(7,'adevjitxx@mail.com','123456',1,'12',0,0,1,NULL,'2018-03-25 04:27:36','2018-03-25 04:27:36',NULL,NULL,NULL,0),
	(8,'adevjitxx@mail.coma','123456',1,'12',0,0,1,NULL,'2018-03-25 04:28:13','2018-03-25 04:28:13',NULL,NULL,NULL,1),
	(9,'test1@mail.com','$2y$10$IL86Jin.qaPnVCGXcmRGQ.BU7LB7hubpkY0kTiJopjxMywv8me8iy',1,'12',0,0,1,NULL,'2018-03-25 04:32:45','2018-03-25 04:32:45',NULL,NULL,NULL,1),
	(10,'test1@mail.comx','$2y$10$oIO2Bphe6H6YSg9o7f5RMOC/1WPzjcUfud/h/x3bvArTdnS6o8UOi',1,'12',0,0,1,NULL,'2018-03-25 04:35:49','2018-03-25 04:35:49',NULL,NULL,NULL,0),
	(11,'ajfix@email.com','$2y$10$dQ5fLU1EM6WOs0PbUDwIx.hVTgPdyzpACJVwNQ.wLPJ5P7bt70JO2',1,'12',0,0,1,NULL,'2018-03-30 23:25:21','2018-03-30 23:25:21',NULL,NULL,NULL,1),
	(12,'dast@mail.com','$2y$10$8h648rNroRS0SL4HpkKyXOgo784PLUbebM6e1591jPndrlbgDTwlG',1,'ExponentPushToken[rv0IPiP6fZ59yF6aCsjT-5]',0,0,0,NULL,'2018-08-04 23:34:35','2018-08-04 23:36:49',NULL,NULL,NULL,1),
	(13,'fast@mail.com','$2y$10$CtrAiPqDT.w.FzUL6PxPk.cfkzkIXcyJ1nzq/HJe1p3jpaf.DcQn6',1,'ExponentPushToken[rv0IPiP6fZ59yF6aCsjT-5]',0,0,1,NULL,'2018-08-04 23:37:29','2018-08-04 23:41:30',NULL,NULL,NULL,1),
	(14,'fast@fast.com','$2y$10$A5SEkVX9X.0rIbGO3cXSr.1L7q.HV9zp0.QRIkI4PKw8DZ5QVlk62',1,'ExponentPushToken[9Mz_hgPiQvyQ5h2J0FRsXm]',0,0,1,NULL,'2018-08-07 00:15:16','2018-08-07 00:15:32',NULL,NULL,NULL,1),
	(15,'adevjit@gmail.comx','$2y$10$eNRaNN33493vJIrwqF4nneE06nRKTcqjSMq2GDOwI2FtC8G9iLQe.',1,'ExponentPushToken[9Mz_hgPiQvyQ5h2J0FRsXm]',0,0,1,NULL,'2018-08-07 00:16:54','2018-08-07 00:17:17',NULL,NULL,NULL,1),
	(16,'adevjit@gmail.comfex','$2y$10$LDA9kYWmlcQHoHKGtTEBtunzJuhfLEYspcNf7c64MtL.ZomiqqSHi',1,'ExponentPushToken[9Mz_hgPiQvyQ5h2J0FRsXm]',0,0,1,NULL,'2018-08-07 00:22:37','2018-08-07 00:23:07',NULL,NULL,NULL,1),
	(17,'mura@mura.com','$2y$10$EnESkDI2VOcRPuUUzZQ6Ter0N4B55ZvkNZwFRhY4yLrCWzJvphy/m',1,'ExponentPushToken[rv0IPiP6fZ59yF6aCsjT-5]',0,0,0,NULL,'2018-09-12 02:42:44','2018-09-12 02:43:59',NULL,NULL,NULL,1),
	(18,'lame@lame.com','$2y$10$UXm81b9CPDeOWy5VctvKBOTjBSagKacblgQgnv8DQfkowH/lja6/m',1,'ExponentPushToken[rv0IPiP6fZ59yF6aCsjT-5]',0,0,1,NULL,'2018-09-12 02:44:58','2018-09-12 02:45:19',NULL,NULL,NULL,1),
	(19,'test-c50cj@mail-tester.com','$2y$10$D1qhuj8OntGCumYyri1eI.i/zZn8wpPXU7kFwZugnfTiJfplPd1Km',1,'ExponentPushToken[rv0IPiP6fZ59yF6aCsjT-5]',0,0,1,NULL,'2018-09-12 04:37:04','2018-09-12 04:38:16',NULL,NULL,NULL,1),
	(20,'fail@me.com','$2y$10$nc95CvwfSBTTHaOC/9YaXO8bacRpQrVZZ2xInSP.A/RlXqn46wqO.',1,NULL,0,0,1,NULL,'2018-09-12 04:40:41','2018-09-12 04:40:41',NULL,NULL,NULL,1),
	(21,'ovio@mail.com','$2y$10$l.PAK.jMh4Ti1TAFSvwNa.gL7FC2kq1xN5vXb11m6PnhTnrbZLMCS',1,'ExponentPushToken[rv0IPiP6fZ59yF6aCsjT-5]',0,0,1,NULL,'2018-09-12 04:45:47','2018-09-12 05:01:30',NULL,NULL,NULL,1),
	(22,'fail@fail.com','$2y$10$Xh3tOBLGmRtrIis5bJg0Q.GpBYUWd4UTknAp.VysSlMCelHUH7ADm',1,NULL,0,0,1,NULL,'2018-09-30 18:39:15','2018-09-30 18:39:15',NULL,NULL,NULL,1),
	(23,'men@men.com','$2y$10$vHmciJmhH581d3aUsQv.8efzEU3pTvcqsohZ./LWCZuAZ8Mp/cx6q',1,NULL,0,0,1,NULL,'2018-09-30 21:02:22','2018-09-30 21:02:22',NULL,NULL,NULL,1),
	(24,'next@nex.com','$2y$10$IBC0jRUCQUzU6DThwrl.e.fQJBNt7c5x8J4zIPH.JDO5YYNCQtkM2',1,NULL,0,0,1,NULL,'2018-10-04 00:31:42','2018-10-04 00:31:42',NULL,NULL,NULL,1),
	(25,'dev@dev.com','$2y$10$RYpDRmZNhawoZB1k4DdR2OEea4C7t6ZV49oXJqA3Gnsx1lxeLCOz6',1,'ExponentPushToken[w4nFHWJ6wjZ_TPR3nKVl3F]',0,0,1,NULL,'2018-10-07 20:51:21','2018-10-07 21:00:28',NULL,NULL,NULL,1),
	(26,'fur@fur.com','$2y$10$hevv9VIGoT2ab34jhW7Sguj3Eczfg88qeY1iuHrRos6hof.B11m1K',1,'ddKqYW1ctLI:APA91bGcMkA1Yt2gzDRC8untGh9szMT4pphmU04Iw7ZMChC-hhe-acTH2uBJ86FZdg9QoI5Izp4IMZRjG0pQi40JrFLIScvx9ZC_GMIXAzV1HHZsDFqG00Fj8eqF0jHOh8KxqN18rfa9',0,0,1,NULL,'2018-10-09 00:12:32','2019-02-19 00:39:42',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/5122aca1-0da2-34f4-bff3-30cf439ef5ba','ios',1),
	(27,'two@two.com','$2y$10$qCNrJPwVbe0jW87pzXixpujTMddIoK9IzukXpLBooLywGmBSO/v0.',1,'dU2ReJt5ynI:APA91bGchvuvyFF4PJBIEyCQuUJIyqSGX1fewuJX8W6O3iqTupt7ftWD2c351IV9sIMYWvbqJXFYqGaSfVgoce8BZvWK36rclEL4qaPQcNmnNjbAShYPjMMha778OoZnBkrfo2Gm6Uo6',0,0,1,NULL,'2018-10-09 00:20:23','2018-11-14 00:04:04',NULL,'','',1),
	(28,'fed@fed.com','$2y$10$XwyGVDVLEz..qNuHxUeA6ufDtZN6lQvDGw9juwJngMCDE/7.H2RQm',1,NULL,0,0,1,NULL,'2018-10-09 02:08:47','2018-10-09 02:08:47',NULL,NULL,NULL,1),
	(29,'dsmolinski@ussu.ca','$2y$10$L9Cf1O2p/sgqsA59rWMUHujomi8Un3SETGg69Z3O3w3Wi2DZZg1pS',1,NULL,0,0,1,NULL,'2018-10-09 02:11:34','2018-10-09 02:11:34',NULL,NULL,NULL,1),
	(30,'fed@ged.com','$2y$10$mNWIUG20ZBGyQ8NF8R8dheUDGxyuDpf1V8n7Dtd6nafox7a7LO.cC',1,NULL,0,0,1,NULL,'2018-10-09 04:24:52','2018-10-09 04:24:52',NULL,NULL,NULL,1),
	(31,'des@des.com','$2y$10$405dQ3P04b8dKDA9.a7QtOHl54/cg8alD.iQHZQ6C.omTMI1u3HSK',1,NULL,0,0,1,NULL,'2018-10-09 04:36:19','2018-10-09 04:36:19',NULL,NULL,NULL,1),
	(32,'dest@dest.com','$2y$10$vp1raSs5RiFoTPiDw1tE.ea3Vrw6RYhDvkwJh9jVI/ejYzTUB1N7u',1,'dJ7KF3gG-n0:APA91bG11ASTXjIJ1W5a4sRuO1lWLQpilP1rgdt63U9ZXr6iPIwks1hExjXAYOpR5TxczPl6Zq6xOA4zRjOFj8_XXJ2sJygvyu6ukPH84Q-ltg_GuPajQ4mBx68rQFXvebxN0sdzt7iO',0,0,1,NULL,'2018-10-11 05:58:59','2018-10-11 19:54:59',NULL,NULL,NULL,1),
	(33,'vid@vid.com','$2y$10$hdQusJPRSQJO7wdCGrHu0uk5izZ62r.Jg4siYd.YWj3bNI3zcouUm',1,'cV2qSwzwne0:APA91bG2ZiT1WhKZ4bsaOK1LTdXmaC5jMiutKJueZs3F99QMvcm8D0gPYPRjhEGbdNDM3wXX9ReP1YKhwS2aBfGqqcJ0b0KRKPOMtf5Fom2fPNrVw29GbmdgE38yx_nrKYZb65vHv893',0,0,1,NULL,'2018-10-14 16:55:56','2018-10-14 16:56:15',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/47d68955-07bc-3d68-83d7-1dd2815f48a9','android',1),
	(34,'med@med.com','$2y$10$hgEugyAbeNYB1jP.D4PF9eItMTiDqEKKySgi09./WLIrnafq9fnfq',1,'ecdkNTFan-s:APA91bFNdCyA7sHTzVEWQx6Oo2md4WCTeHQLOxxfWqC0pYTPh-HYINJQWLFnDbNMJi6bA9kVCjrKJd58mSwbBQ-rBTr50aji40VV9LNUDrD5yl55fajqxZqDOHnq82lUAmoHpcRrt774',0,0,1,NULL,'2018-10-16 04:32:19','2018-10-16 04:32:47',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/4459b32b-5db3-3e9f-b542-c41e83204109','ios',1),
	(35,'fal@fal.com','$2y$10$UtAAuwBtPdnKoXcE7FcTWe8GpgHW/mLFtQEbI7W/BsICUW5q2STA.',1,'coOGYuSLui8:APA91bGLnevoXrTOh8iN0fkA5MuN0MbGZ2cT9N8nHoYS-gt4QATUsD53vqLKiFwqBCK5Fo2D6ZrhEbcWq-nwzVJNKuQOkzuEUcT7ZiGnulcRLyYWXMJ4U9g0_k4Pc3IP5Kdq9Dk68vYj',0,0,1,NULL,'2018-10-17 22:38:23','2018-10-17 22:39:14',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/c05df333-f0cf-3af8-900f-f917d0635f05','android',1),
	(36,'bo@u.com','$2y$10$knlNfTNGq8Z4Lve0ovtlRuM4glM/ZAbNcMtfdOx3opxpxgWRbwC/S',1,'cNC04x6yCC0:APA91bEAiKdvjhWjfpgi612IAM6WZY_wZJNJBzV8v7R1qGD9BhsoMUR2upDi3aDZ3RkUEKbnvuQ_DdZGZ7KZWGJgFmw0likW5uLjnqmldlsKzDGTxTBdLx0cyCH8unPe0N7XnnvNXQ0t',0,0,1,NULL,'2018-11-04 22:12:01','2018-11-04 22:12:24',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/816fb4dc-5a77-3514-930d-59b733645072','ios',1),
	(37,'fut@fut.com','$2y$10$Ef1rO.lrBvaWWsCa115aZuNsesxiIiV69XOEBlkRYuYmFC5vs9hDu',1,'dS5LzoA1XQ8:APA91bH6hMuEy_mR0o0csjQJjy2dwAckFgusLqO6c2_0AJMu9AE-j9FG1H_Harz60XuUEqdV7xylacw8lh48mZhLlXqRruSme5j7F3JUR0kryAOTaUX3S4EBXXnJHvTC0QzWkm-aO31R',0,0,1,NULL,'2018-11-05 01:30:37','2018-11-05 01:31:11',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/90e9115c-9e43-32d1-9a62-d93dcd754e4f','ios',1),
	(38,'hec@hec.com','$2y$10$.JCP2jjtfi76xDJZcIhAhu2Ee/YYLdxP8LLomc72JNET1akW63Acy',1,'fjFARYTBP40:APA91bHtmOLAY09VwqnikNyswiWq1xeu3VGEqBoRXiJJWVsTrGOAVpU6YP3Q00O-nwe87--tMb9o_-Gk7N9jfUtBqzKLtQ4cXj5CeA_esPccw6Vbumal8jINe2ObFg04qPwA5K0ZvOYd',0,0,1,NULL,'2018-11-05 01:31:30','2018-11-05 01:53:14',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/6489f811-b0d0-3880-988f-4d838f8c8f59','ios',1),
	(39,'fec@fec.com','$2y$10$GL7t3dAmCD1U9bG/DCJUCe4fx9TJjS3kZPVx6TyFnrCzqT1zjFDo2',1,'ekhFVkuvW6k:APA91bHTtSFKPFs7OGWEgNXjtpAZKhFoZx6oY5S1ZdhJhQPqc1NZsBcoQmhPu0ndtVmbTWjAjsQ8HZP0vVExAZz0eRH1OgJi6WuDKsIHHPcos67oKktu1xA_p1z_oSZ4JKcVDUelqFO7',0,0,1,NULL,'2018-11-05 01:33:04','2019-04-18 02:39:16',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/463103e7-fca0-3336-bd62-720296217955','ios',1),
	(40,'fe@fec.com','$2y$10$UiSViC.lZCXP2.pvARJu6eSSL09Lw5.8kvXPA5/nX32KGDeT7yAK2',1,'ddKqYW1ctLI:APA91bGcMkA1Yt2gzDRC8untGh9szMT4pphmU04Iw7ZMChC-hhe-acTH2uBJ86FZdg9QoI5Izp4IMZRjG0pQi40JrFLIScvx9ZC_GMIXAzV1HHZsDFqG00Fj8eqF0jHOh8KxqN18rfa9',0,0,1,NULL,'2018-12-11 02:47:00','2019-01-09 19:07:16',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/5122aca1-0da2-34f4-bff3-30cf439ef5ba','ios',1),
	(41,'nanu@namu.com','$2y$10$ynWhJgDUs7fGxRLk8EN6ZOe29f3vcorTPhhHu3SXg8CknxbE3V.jy',1,'ceVRr12h888:APA91bEHfyQyrLVyl5ujgR6TCkrpD-5SwFuPbfjAJjs67JrFVBtgGCG1ULvASClaBkfLmLhVkFjaXdB4VwNzauocTc-Y0TyBRHrlwL2J81ZTGI6LzlUtKBRpIbfywzsQO_SdBg_Wf7Gz',0,0,1,NULL,'2018-12-11 02:56:52','2018-12-11 02:57:19',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/6234cc14-0280-303b-aefd-717c7864f851','ios',1),
	(42,'alu@alu.com','$2y$10$kzs9868BS1kcnyP/94kQjOrBNEwne04Tu7psrsqVr9pdP2becVL3u',1,'ddKqYW1ctLI:APA91bGcMkA1Yt2gzDRC8untGh9szMT4pphmU04Iw7ZMChC-hhe-acTH2uBJ86FZdg9QoI5Izp4IMZRjG0pQi40JrFLIScvx9ZC_GMIXAzV1HHZsDFqG00Fj8eqF0jHOh8KxqN18rfa9',0,0,1,NULL,'2019-01-09 19:13:40','2019-01-09 19:13:58',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/5122aca1-0da2-34f4-bff3-30cf439ef5ba','ios',1),
	(43,'fexc@fezc.com','$2y$10$mBZL8VfJfdUy.2ySaByKgu17273gvRSnMD6ob2jX8LgqCccInIXxK',1,'dpSX9HBTag4:APA91bHIRo0902CC_EqdGTGAwGhI32jTsmxHj6q1wpyRYVaNH8eJj95mP0fPyuCkbfpu46t0dytrFVgAqIob3Kp5xSpIU0m_oZklU_ozdeKqZWpmYEUvA2ME6Gg1pVwyQoeJIyozH_BY',0,0,1,NULL,'2019-01-19 01:02:33','2019-01-19 01:02:49',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/bf51eb80-19e9-39c3-bcc3-16f0feca7a29','ios',1),
	(44,'hallo@most.com','$2y$10$xyfn2D2PnzOTiZ.zQTPzO.a6pX3.A/bf9.5vogCTHNh97OR0Cv3Wu',1,'f7TbsCsPVBk:APA91bEQ6zNRGC5SqDJYEi7sst7ORPW2VNRMCBBfn3H5Pp8Ep0lqVHIuPm1jUchCYVLxcymql_RKlOvaWdEPBdFRSRZCuU6Ow_bfKdRbE7avBSLE_U1UaKM6EwtLHeNDh_cul5cZFJp9',0,0,1,NULL,'2019-02-16 17:52:46','2019-02-17 20:04:59',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/dbcf7212-bd43-3da4-94bd-414775d2a309','ios',1),
	(45,'aj@hec.com','$2y$10$VVPR0FvwN6j7qqajxGGhHOcPH03/26QibwqC8fcYRgNcEtLP96WVK',1,'cea3uPPkWkM:APA91bEHzJGJVD2uLxKSBWxxLUDc-swq6PIGYp_TnGrUV8zvp36NyYGwtF2vKaZKQHuKhrmHaMplSdKtXS3w-92ETNI8uf07FNpgAU44Ea5ZNvdAqg0I8mVg7vvKxrGdp2_O2cnizx_z',0,0,1,NULL,'2019-02-18 20:57:46','2019-02-18 20:59:05',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/4fe20bbd-a5b3-38ac-b778-6449d1dedccd','ios',1),
	(46,'must@must.com','$2y$10$twsntBTBVp2fPUCnBc8ja.8oQudisLX5hZCGQY9VPbsAFWqIGwjIy',1,'dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3',0,0,1,NULL,'2019-03-29 05:06:02','2019-03-29 05:06:25',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/adec8d6b-224d-362d-a6d2-99295431635a','ios',1),
	(47,'nopromo@nopromo.com','$2y$10$ONdVURW4AXS0z4XSLsOSz.ejhFZHCo2DBgh9MC/TIQrTpJj28NxlS',1,'dgVt3ksD2tM:APA91bHZ11EKiasaFDp5k_jsCM6rPHe_hRZ9XJ0kB-wYfj5LOuieimXZ01DZaUFlyZAeGKqbYy2Z9C_GwPWFwztxGYoam4nr5GVnlo5gy8vraJYfH28wrwhzHD_E7L_EFVqTeE7EsWH3',0,0,1,NULL,'2019-03-30 21:17:11','2019-03-30 21:17:27',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/adec8d6b-224d-362d-a6d2-99295431635a','ios',1),
	(48,'androidnopromo@insta.com','$2y$10$J7gmlR8zWzoZGqL9zU.XAefPzZ.qu1ObrHW4Eznw4Vri1xNm1LFGq',1,'evr8SVGfLXI:APA91bEHY_uzvikwabgJ73WRCt3qe5zRX-x_O5Ki_3WfBn3m9_3D6oPQ1jDufvoUkAWp61Fg4W6YZH9WBRddATj7OHNWRItJ5dYT2N40VCST655wtxj7EoPO6DqrZdWsi4kbT-iTm7QY',0,0,1,NULL,'2019-04-01 22:02:58','2019-04-01 22:03:47',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/c46c87a6-5b0d-324f-9191-5179e0e99a7f','android',1),
	(49,'androidmodal@gmail.com','$2y$10$TEcSTGkXf.KuUA5HNztiLu/Z3MB2QgGF7J7LqIDP7GOvZt5Vh04ja',1,'evr8SVGfLXI:APA91bEHY_uzvikwabgJ73WRCt3qe5zRX-x_O5Ki_3WfBn3m9_3D6oPQ1jDufvoUkAWp61Fg4W6YZH9WBRddATj7OHNWRItJ5dYT2N40VCST655wtxj7EoPO6DqrZdWsi4kbT-iTm7QY',0,0,1,NULL,'2019-04-01 22:06:06','2019-04-01 22:08:05',NULL,'arn:aws:sns:us-east-1:476705120696:endpoint/GCM/android_dev/c46c87a6-5b0d-324f-9191-5179e0e99a7f','android',1),
	(50,'novatest@gmail.com','$2y$10$HZ/EgaKTt5EUSBrGq2eBieCAOM47E5GtcEbRyznAKn2wZ7fYjOLwW',1,NULL,0,0,1,NULL,'2019-07-09 21:05:04','2019-07-09 21:05:04',NULL,NULL,NULL,1);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
