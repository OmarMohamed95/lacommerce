-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.23 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table ecommerce.admins
DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.admins: ~2 rows (approximately)
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'omar', 'omar@test.com', '$2y$10$5iOWVGhy.cRyqTkwVAbhFe7XFf5aDj3O19QO7FSyMm2hB0UTE4yOG', 'r6IkU2iD1xizMVwHe5ek0DSF5NycA6Gi3G8R4FRaPPF2UE5oKCPF1a7IXkWQ', '2018-10-17 12:03:18', '2018-10-30 13:52:16'),
	(2, 'test', 'test@test.com', '$2y$10$PwMMNChdXjeFhKFxVfe3QepJnWXPEOxkD4v8AbtJAysuetKjTsdPi', 'tAueF8UpAqlN9YatAd92oZMzeTvW2IxCg6aCfGGW0GuTnDdPedTVusDBmpoZ', '2018-10-18 11:48:31', '2019-01-13 11:20:19');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;


-- Dumping structure for table ecommerce.brands
DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.brands: ~5 rows (approximately)
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` (`id`, `name`, `img`, `created_at`, `updated_at`) VALUES
	(1, 'brand one', 'brand4-1540669758.png', '2018-10-25 21:48:03', '2018-11-14 23:57:42'),
	(2, 'brand two', 'no-image-available.jpg', '2018-10-25 21:49:35', '2018-11-14 23:57:59'),
	(3, 'brand three', 'brand1-1540671303.png', '2018-10-26 17:37:05', '2018-10-27 20:15:03'),
	(4, 'brand four', 'brand2-1541350100.png', '2018-11-04 16:48:20', '2018-11-04 16:53:56'),
	(6, 'test brand', 'appleStore-1546700310.png', '2019-01-05 14:58:30', '2019-01-05 15:05:46');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;


-- Dumping structure for table ecommerce.carts
DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.carts: 0 rows
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;


-- Dumping structure for table ecommerce.categories
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentID` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `home` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.categories: ~17 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `parentID`, `name`, `status`, `admin_id`, `sort`, `created_at`, `updated_at`, `home`) VALUES
	(1, NULL, 'PHONES & TABLETS', 1, 1, 1, '2018-10-22 17:23:58', '2018-11-16 20:07:57', 0),
	(2, NULL, 'ELECTRONICS', 1, 1, 2, '2018-10-22 19:20:41', '2018-11-14 23:30:06', 0),
	(3, NULL, 'HOME & OFFICE', 1, 1, 3, '2018-10-23 13:54:54', '2018-11-14 23:58:50', 0),
	(4, 1, 'CELL PHONES', 1, 1, 1, '2018-10-23 10:56:40', '2018-11-14 23:59:14', 0),
	(5, 1, 'SMART PHONES', 1, 1, 2, '2018-11-02 01:46:57', '2018-11-14 23:59:28', 1),
	(6, NULL, 'HEALTH & BEAUTY', 1, 1, 4, '2018-11-02 01:47:48', '2018-11-15 00:13:30', 0),
	(7, 3, 'OFFICE PRODUCTS', 1, 1, 4, '2018-11-02 01:48:23', '2018-11-14 23:35:25', 0),
	(8, 2, 'GAMING', 1, 1, 2, '2018-11-02 01:49:31', '2018-11-14 23:36:02', 0),
	(9, 3, 'HOME & FURNITURE', 1, 1, 3, '2018-11-02 01:49:57', '2018-11-14 23:34:18', 1),
	(10, 3, 'HOME & KITCHEN', 1, 1, 1, '2018-11-02 01:50:10', '2018-11-14 23:33:26', 0),
	(11, 2, 'CAMERA', 1, 1, 2, '2018-11-02 01:50:30', '2018-11-14 23:31:44', 0),
	(12, 2, 'TELEVISION', 1, 1, 1, '2018-11-02 01:51:22', '2018-11-14 23:30:47', 0),
	(13, 1, 'IPAD', 1, 1, 4, '2018-11-02 01:51:57', '2018-11-14 23:28:32', 0),
	(14, 1, 'TABLETS', 1, 1, 3, '2018-11-02 01:52:14', '2018-11-14 23:28:06', 0),
	(15, 6, 'BEAUTY & PERSONAL CARE', 1, 1, 1, '2018-11-14 23:37:37', '2018-11-14 23:37:37', 0),
	(16, 6, 'HEALTH CARE', 1, 1, 2, '2018-11-14 23:38:09', '2018-11-15 00:13:42', 1),
	(17, NULL, 'FASHION', 1, 1, 5, '2018-11-14 23:38:49', '2018-11-14 23:38:49', 0),
	(18, 17, 'WOMEN\'S FASHION', 1, 1, 1, '2018-11-14 23:39:20', '2018-11-14 23:39:20', 0),
	(19, 17, 'MEN\'S FASHION', 1, 1, 2, '2018-11-14 23:40:03', '2018-11-14 23:40:03', 0);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


-- Dumping structure for table ecommerce.category_brand
DROP TABLE IF EXISTS `category_brand`;
CREATE TABLE IF NOT EXISTS `category_brand` (
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.category_brand: 6 rows
/*!40000 ALTER TABLE `category_brand` DISABLE KEYS */;
INSERT INTO `category_brand` (`category_id`, `brand_id`) VALUES
	(8, 4),
	(5, 6),
	(4, 6),
	(7, 3),
	(5, 2),
	(5, 1);
/*!40000 ALTER TABLE `category_brand` ENABLE KEYS */;


-- Dumping structure for table ecommerce.checkouts
DROP TABLE IF EXISTS `checkouts`;
CREATE TABLE IF NOT EXISTS `checkouts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'preparing',
  `order_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.checkouts: 14 rows
/*!40000 ALTER TABLE `checkouts` DISABLE KEYS */;
INSERT INTO `checkouts` (`id`, `product_id`, `user_id`, `quantity`, `address`, `phone`, `state`, `order_code`, `created_at`, `updated_at`) VALUES
	(1, 48, 1, 2, 'Feisal', '114545545545', 'shipped', '15445541', '2019-01-06 16:28:43', '2019-01-10 20:55:47'),
	(2, 48, 1, 2, 'Feisal', '1145215502', 'shipped', '15447796', '2019-01-06 16:31:30', '2019-01-10 20:55:47'),
	(3, 49, 1, 1, 'Feisal', '01145455455', 'shipped', '112640', '2019-01-07 14:27:08', '2019-01-10 20:55:47'),
	(4, 48, 1, 1, 'Feisal', '01145455455', 'shipped', '1843152', '2019-01-07 14:28:45', '2019-01-10 20:55:47'),
	(5, 28, 1, 1, 'Feisal', '01145455455', 'shipped', '1843152', '2019-01-07 14:28:45', '2019-01-10 20:55:47'),
	(6, 48, 1, 1, 'Feisal', '01145455455', 'shipped', '1639396', '2019-01-08 12:50:06', '2019-01-10 20:55:47'),
	(12, 28, 1, 1, 'Feisal', '1145215502', 'preparing', '1537587', '2019-01-14 18:26:13', '2019-01-14 18:26:13'),
	(7, 28, 1, 1, 'Feisal', '01145455455', 'shipped', '1107401', '2019-01-09 13:43:36', '2019-01-10 20:55:47'),
	(8, 48, 1, 1, 'Feisal', '01145455455', 'shipped', '1107401', '2019-01-09 13:43:36', '2019-01-10 20:55:47'),
	(9, 28, 1, 1, 'Feisal', '01145455455', 'shipped', '171348', '2019-01-10 17:43:06', '2019-01-10 20:54:44'),
	(10, 48, 1, 2, 'Feisal', '01145455455', 'shipped', '171348', '2019-01-10 17:43:06', '2019-01-10 20:54:44'),
	(11, 48, 1, 1, 'Feisal', '01145455455', 'shipped', '1568895', '2019-01-10 20:53:48', '2019-01-10 20:55:00'),
	(13, 48, 1, 1, 'Feisal', '1145215502', 'preparing', '1537587', '2019-01-14 18:26:13', '2019-01-14 18:26:13'),
	(14, 48, 1, 1, 'Feisal', '01145455455', 'preparing', '1579898', '2019-01-15 19:19:26', '2019-01-15 19:19:26');
/*!40000 ALTER TABLE `checkouts` ENABLE KEYS */;


-- Dumping structure for table ecommerce.custom_fields
DROP TABLE IF EXISTS `custom_fields`;
CREATE TABLE IF NOT EXISTS `custom_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `show_in_filter` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.custom_fields: 3 rows
/*!40000 ALTER TABLE `custom_fields` DISABLE KEYS */;
INSERT INTO `custom_fields` (`id`, `name`, `type`, `show_in_filter`, `created_at`, `updated_at`) VALUES
	(1, 'size', 'number', 1, '2019-01-06 13:50:17', '2019-01-06 13:50:17'),
	(2, 'test', 'text', 1, '2019-01-09 15:02:13', '2019-01-09 15:02:13'),
	(3, 'color', 'text', 1, '2019-01-15 14:02:31', '2019-01-15 14:15:10');
/*!40000 ALTER TABLE `custom_fields` ENABLE KEYS */;


-- Dumping structure for table ecommerce.custom_field_categories
DROP TABLE IF EXISTS `custom_field_categories`;
CREATE TABLE IF NOT EXISTS `custom_field_categories` (
  `category_id` int(11) NOT NULL,
  `custom_field_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.custom_field_categories: 4 rows
/*!40000 ALTER TABLE `custom_field_categories` DISABLE KEYS */;
INSERT INTO `custom_field_categories` (`category_id`, `custom_field_id`) VALUES
	(4, 1),
	(5, 1),
	(5, 2),
	(5, 3);
/*!40000 ALTER TABLE `custom_field_categories` ENABLE KEYS */;


-- Dumping structure for table ecommerce.custom_field_products
DROP TABLE IF EXISTS `custom_field_products`;
CREATE TABLE IF NOT EXISTS `custom_field_products` (
  `product_id` int(11) NOT NULL,
  `custom_field_id` int(11) NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.custom_field_products: 47 rows
/*!40000 ALTER TABLE `custom_field_products` DISABLE KEYS */;
INSERT INTO `custom_field_products` (`product_id`, `custom_field_id`, `value`) VALUES
	(28, 1, '600'),
	(47, 1, '200'),
	(47, 1, '200'),
	(48, 1, '600'),
	(49, 1, '500'),
	(53, 1, '500'),
	(54, 1, '300'),
	(57, 1, '250'),
	(58, 1, '150'),
	(55, 1, '400'),
	(60, 1, '55'),
	(61, 1, '55'),
	(28, 2, 'hello'),
	(59, 2, 'world'),
	(59, 1, '500'),
	(60, 2, 'man'),
	(60, 1, '600'),
	(61, 2, 'women'),
	(61, 1, '500'),
	(62, 2, 'happy'),
	(62, 1, '500'),
	(63, 2, 'sad'),
	(63, 1, '500'),
	(64, 2, 'heat'),
	(64, 1, '500'),
	(65, 2, 'low'),
	(65, 1, '500'),
	(66, 2, 'home'),
	(66, 1, '500'),
	(67, 2, 'kkss'),
	(67, 1, '500'),
	(59, 2, 'bad'),
	(59, 1, '50'),
	(60, 2, 'good'),
	(60, 1, '500'),
	(61, 2, 'good'),
	(61, 1, '500'),
	(62, 2, 'good'),
	(62, 1, '500'),
	(63, 2, 'good'),
	(63, 1, '500'),
	(64, 2, 'ggoofo'),
	(64, 1, '500'),
	(65, 2, 'ahaa'),
	(65, 1, '500'),
	(66, 2, 'Egypt'),
	(66, 1, '500');
/*!40000 ALTER TABLE `custom_field_products` ENABLE KEYS */;


-- Dumping structure for table ecommerce.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.migrations: ~18 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2018_10_16_130647_create_admins_table', 1),
	(9, '2018_10_17_221005_create_categories_table', 2),
	(11, '2018_10_25_093953_create_product_imgs_table', 3),
	(12, '2018_10_25_094821_create_products_table', 4),
	(13, '2018_10_25_142626_create_brands_table', 5),
	(15, '2018_10_29_141739_add_offer_coulmn_to_products', 6),
	(16, '2018_10_30_104216_create_sittings_table', 7),
	(17, '2018_11_03_103453_add_category_id_to_products', 8),
	(18, '2018_11_03_103859_add_home_to_categories', 9),
	(19, '2018_11_04_161651_add_category_id_to_brands', 10),
	(20, '2018_11_08_103529_create_reviews_table', 11),
	(22, '2018_11_10_183300_create_wishlists_table', 12),
	(26, '2018_11_12_141246_create_carts_table', 13),
	(27, '2018_11_13_174022_add_quantity_to_product', 13),
	(34, '2018_11_14_143532_create_checkouts_table', 14),
	(36, '2018_12_21_155033_create_custom_field_table', 15),
	(39, '2019_01_05_100642_create_category_brand_table', 16);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;


-- Dumping structure for table ecommerce.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;


-- Dumping structure for table ecommerce.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `offer` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.products: ~16 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `desc`, `price`, `brand_id`, `created_at`, `updated_at`, `offer`, `category_id`, `quantity`) VALUES
	(28, 'Apple iPhone 7 - 32GB - Black', '<ul>\r\n	<li>4.7&quot; IPS LCD Capacitive Touch Screen</li>\r\n	<li>32 GB Internal Storage</li>\r\n	<li>12 MP Back Camera, 7 MP Front Camera</li>\r\n	<li>Quad-core CPU, 2 GB RAM</li>\r\n	<li>OS: iOS 10</li>\r\n	<li>Li-Ion 1960 mAh Battery</li>\r\n</ul>', 12000, 1, '2018-10-28 15:39:48', '2019-01-14 18:26:13', 0, 5, 3),
	(42, 'Home Furniture - Bedroom', '<p>Key Features</p>\r\n\r\n<ul>\r\n	<li>Panel Type: LED</li>\r\n	<li>Screen Size:&nbsp;32 inch</li>\r\n	<li>Resolution:&nbsp;768x 1366&nbsp;HD</li>\r\n	<li>Inputs: 1x&nbsp;HDMI - 1x&nbsp;USB</li>\r\n</ul>', 200, 3, '2018-10-28 17:15:41', '2018-12-19 19:35:39', 0, 9, 4),
	(43, 'Growth Driver Aloe Vera – LR', '<p>Key Features</p>\r\n\r\n<ul>\r\n	<li>Panel Type: LED</li>\r\n	<li>Screen Size:&nbsp;32 inch</li>\r\n	<li>Resolution:&nbsp;768x 1366&nbsp;HD</li>\r\n	<li>Inputs: 1x&nbsp;HDMI - 1x&nbsp;USB</li>\r\n</ul>', 300, 3, '2018-10-29 16:01:37', '2018-11-15 00:11:57', 0, 16, 7),
	(45, 'Infinix X606 Hot 6 - 6.0-inch 16GB 3G Mobile Phone - Blue', '<p>Key Features</p>\r\n\r\n<ul>\r\n	<li>6.0-inch IPS Capacitive Touch Screen</li>\r\n	<li>16 GB Storage, MicroSD up to 128GB</li>\r\n	<li>13MP Back Camera, 5MP Front Camera</li>\r\n	<li>Quad-core 1.3 GHz CPU, 2GB RAM</li>\r\n	<li>Android OS, v8.1 (Oreo)</li>\r\n	<li>4000mAh Battery, Fingerprint Sensor</li>\r\n</ul>', 850, 1, '2018-10-29 16:33:25', '2018-11-16 20:45:22', 1, 9, 4),
	(46, 'ATA Green 32-inch HD LED TV', '<p>Key Features</p>\r\n\r\n<ul>\r\n	<li>Panel Type: LED</li>\r\n	<li>Screen Size:&nbsp;32 inch</li>\r\n	<li>Resolution:&nbsp;768x 1366&nbsp;HD</li>\r\n	<li>Inputs: 1x&nbsp;HDMI - 1x&nbsp;USB</li>\r\n</ul>', 2500, 2, '2018-10-29 16:35:17', '2019-01-05 17:48:17', 1, 12, 9),
	(47, 'product four', 'this is the description of product four', 250, 1, '2018-11-03 12:50:49', '2018-11-03 12:50:49', 0, 4, 8),
	(48, 'samsung galaxy s7', '<p>Key Features</p>\r\n\r\n<ul>\r\n	<li>Panel Type: LED</li>\r\n	<li>Screen Size:&nbsp;32 inch</li>\r\n	<li>Resolution:&nbsp;768x 1366&nbsp;HD</li>\r\n	<li>Inputs: 1x&nbsp;HDMI - 1x&nbsp;USB</li>\r\n</ul>', 7000, 1, '2018-11-15 00:03:14', '2019-01-15 19:19:26', 0, 5, 2),
	(49, 'samsung galaxy s9', '<p>Key Features</p>\r\n\r\n<ul>\r\n	<li>Panel Type: LED</li>\r\n	<li>Screen Size:&nbsp;32 inch</li>\r\n	<li>Resolution:&nbsp;768x 1366&nbsp;HD</li>\r\n	<li>Inputs: 1x&nbsp;HDMI - 1x&nbsp;USB</li>\r\n</ul>', 16000, 1, '2018-11-15 00:07:57', '2019-01-07 14:27:08', 0, 5, 2),
	(50, 'SkyLine 3221A - 32-inch HD LED TV', '<p>Key Features</p>\r\n\r\n<ul>\r\n	<li>Display Size: 32-inch</li>\r\n	<li>Panel Backlight: LED</li>\r\n	<li>Resolution: 1366 x 768 (HD)</li>\r\n	<li>Connectivity: 2 x HDMI, 2 x USB, 1 x VGA</li>\r\n	<li>USB Multimedia Player</li>\r\n</ul>', 10000, 1, '2018-11-16 20:37:11', '2018-11-16 20:37:11', 1, 12, 0),
	(51, 'Kinerase Kenzo Tap - For The Treatment Of Pain, Arthritis, Muscle And Bone Pain', '<p>Key Features</p>\r\n\r\n<ul>\r\n	<li>Display Size: 32-inch</li>\r\n	<li>Panel Backlight: LED</li>\r\n	<li>Resolution: 1366 x 768 (HD)</li>\r\n	<li>Connectivity: 2 x HDMI, 2 x USB, 1 x VGA</li>\r\n	<li>USB Multimedia Player</li>\r\n</ul>', 500, 4, '2018-11-16 20:39:36', '2018-11-16 20:39:36', 1, 16, 0),
	(53, 'test', '<p>test</p>', 500, 1, '2018-12-27 12:23:42', '2018-12-27 12:23:42', 0, 5, 0),
	(54, 'big test', '<p>tetst</p>', 500, 1, '2018-12-28 11:08:23', '2018-12-28 11:08:23', 0, 4, 0),
	(55, 'big test 2', '<p>big test 2&nbsp;</p>', 400, 2, '2018-12-28 11:09:38', '2018-12-28 11:09:38', 0, 5, 0),
	(56, 'test office products omar', '<p>test office products</p>', 500, 1, '2019-01-02 13:39:27', '2019-01-02 21:12:08', 0, 7, 0),
	(57, 'test brand', '<p>sysysys</p>', 100, 6, '2019-01-05 16:55:20', '2019-01-05 16:55:20', 0, 4, 0),
	(58, 'test brands', '<p>sysysys</p>', 100, 6, '2019-01-05 16:56:40', '2019-01-05 17:54:51', 0, 4, 20);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;


-- Dumping structure for table ecommerce.product_imgs
DROP TABLE IF EXISTS `product_imgs`;
CREATE TABLE IF NOT EXISTS `product_imgs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.product_imgs: ~19 rows (approximately)
/*!40000 ALTER TABLE `product_imgs` DISABLE KEYS */;
INSERT INTO `product_imgs` (`id`, `product_id`, `img`) VALUES
	(77, 47, 'perfume8-1541249450.png'),
	(86, 45, 'special-offers-1542239163.jpg'),
	(87, 46, 'offer2-1542239439.jpg'),
	(95, 48, '302281-PDP-Overview-SSGS7-img1@2x-1542240194.jpg'),
	(96, 48, 'galaxy-s7-edge_gallery_front_silver_s3-1542240194.png'),
	(97, 48, 'samsung_sm_g935f_32gb_slv_galaxy_s7_edge_sm_g935f_1225381-1542240194.jpg'),
	(100, 49, '81+h9mpyQmL._SX522_-1542240477.jpg'),
	(101, 49, 'Samsung_Galaxy_S9_L_1-1542240477.jpg'),
	(102, 43, 'LR_Lifetakt_Drinking_Gel_Honey_highres-1542240623.jpg'),
	(103, 42, 'wk21_furniture_accent-1542240979.jpg'),
	(104, 50, 'ten-ways-promote-new-offer-307862141-1542400631.jpg'),
	(105, 51, 'Offer_page-1542400776.png'),
	(106, 53, 'info-box9-1545913422.png'),
	(107, 54, 'info-box8-1545995304.png'),
	(108, 55, 'info-box10-1545995378.png'),
	(109, 56, 'info-box9-1546436367.png'),
	(110, 58, 'info-box8-1546707400.png'),
	(113, 28, 'Apple-iPhone-7-Balck-2-1547308430.jpg'),
	(114, 28, 'iPhone 71-1547308430.jpg');
/*!40000 ALTER TABLE `product_imgs` ENABLE KEYS */;


-- Dumping structure for table ecommerce.reviews
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.reviews: ~1 rows (approximately)
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` (`id`, `content`, `product_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(60, 'test', 28, 1, '2018-11-09 12:55:21', '2018-11-09 12:55:21'),
	(61, 'test 1', 28, 1, '2019-01-09 13:55:44', '2019-01-09 13:55:44'),
	(62, 'test', 48, 1, '2019-01-10 21:08:42', '2019-01-10 21:08:42');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;


-- Dumping structure for table ecommerce.sittings
DROP TABLE IF EXISTS `sittings`;
CREATE TABLE IF NOT EXISTS `sittings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fb` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tw` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `yt` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.sittings: ~0 rows (approximately)
/*!40000 ALTER TABLE `sittings` DISABLE KEYS */;
INSERT INTO `sittings` (`id`, `email`, `fb`, `tw`, `yt`, `created_at`, `updated_at`) VALUES
	(1, 'ecommerce@test.com', 'https://www.facebook.com/', 'https://www.twitter.com/', 'https://www.youtube.com/', '2018-10-30 11:20:32', '2018-10-30 11:21:26');
/*!40000 ALTER TABLE `sittings` ENABLE KEYS */;


-- Dumping structure for table ecommerce.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Omar', 'omar@test.com', '$2y$10$0SMHFCKGhalffK..2DJn7edDACQh5AK93iyFO1FIaIq0lGJ/lcYPK', 'UOxpb21PqYaCNGWNgi9eqfADBW9XE9gd2gW0lJZAzWH4aCZMSvkhGVZwp7ym', '2019-01-09 11:46:52', '2019-01-09 12:09:58');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table ecommerce.wishlists
DROP TABLE IF EXISTS `wishlists`;
CREATE TABLE IF NOT EXISTS `wishlists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ecommerce.wishlists: 1 rows
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
	(74, 1, 28, '2019-01-14 16:49:48', '2019-01-14 16:49:48');
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
