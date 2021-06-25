-- MariaDB dump 10.19  Distrib 10.5.10-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: ristorante
-- ------------------------------------------------------
-- Server version	10.5.10-MariaDB

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
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`dish_id`),
  KEY `dish_id` (`dish_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_items` (
  `cart_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`cart_id`,`dish_id`),
  KEY `dish_id` (`dish_id`),
  CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (1,1,'2021-06-23 10:52:53',NULL),(2,2,'2021-06-25 09:22:56',NULL);
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'entrées','2021-06-22 08:53:57',NULL),(2,'plats','2021-06-22 08:53:57',NULL),(3,'desserts','2021-06-22 08:53:57','2021-06-22 12:21:35'),(4,'boissons','2021-06-22 08:53:57',NULL),(5,'test','2021-06-22 12:21:53',NULL),(6,'rhndrjiuhdrjiuhdr','2021-06-25 09:06:08',NULL),(7,'jyjtfjtj','2021-06-25 10:17:59',NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dishes`
--

DROP TABLE IF EXISTS `dishes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dishes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` enum('junior','medium','senior') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float(5,2) NOT NULL,
  `image_url` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `dishes_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dishes`
--

LOCK TABLES `dishes` WRITE;
/*!40000 ALTER TABLE `dishes` DISABLE KEYS */;
INSERT INTO `dishes` VALUES (1,'AntiPasti','medium','Les antipasti ou antipasto (au singulier) (« apéritif », ou « avant le plat principal », en italien) sont une assiette composée traditionnelle de la cuisine italienne. Ils sont servis en collation, apéritif, entrée ou hors-d\'œuvre de repas, ou au dîner, généralement composés d\'une plus ou moins riche variété de divers produits culinaires régionaux d\'Italie (légumes, charcuterie, fromages, poissons, crustacés, olives, huile d\'olive…), ordinairement accompagnés de vin italien.',12.99,'/public/uploads/dishes/e5755569-2325-4149-a1d3-7de74f9e232c.jpg',1,'2021-06-22 08:53:57','2021-06-23 12:16:40'),(2,'Salade','medium','La salade est initialement un mets préparé, composé de feuilles d\'herbes potagères crues, éventuellement assaisonnées de vinaigrette (voir aussi salade composée).',10.99,'/public/uploads/dishes/19e205bf-a081-4f13-ae53-8fb3355c59f7.jpg',1,'2021-06-22 08:53:57','2021-06-23 12:18:07'),(3,'Carpaccio','medium','Le carpaccio est une préparation culinaire typique de la cuisine italienne, à base de viande de bœuf crue, coupée en tranches très fines, assaisonnée traditionnellement d\'un filet d\'huile d\'olive, jus de citron, sel, poivre et parsemé de copeaux de parmigiano reggiano ou de pecorino.',10.99,'/public/uploads/dishes/813ed4cd-8396-4cf3-a680-3090b4a83f36.jpg',1,'2021-06-22 08:53:57','2021-06-23 10:29:48'),(4,'Raviole','medium','Le ravioli est un produit typique de la cuisine italienne. Les plus anciennes recettes figurent dans la littérature culinaire arabe de l’époque abbasside, notamment dans le Kitab al-Tabikh, livre de cuisine, d’al-Warrak. Le sambusaj est probablement la plus ancienne pasta ripiena connue. Il est l’ancêtre du ravioli.',10.99,'/public/uploads/dishes/45d9d0df-d4f7-4295-a3ab-e5b42f89b25c.jpg',1,'2021-06-22 08:53:57','2021-06-23 11:34:51'),(5,'Lasagnes','medium','Les lasagnes sont des pâtes alimentaires en forme de larges plaques. Il s\'agit également de la préparation utilisant ces mêmes pâtes et généralement faite de couches alternées de pâtes, de fromage et d\'une sauce tomate avec de la viande, bien qu\'il en existe au poisson, notamment au saumon, et végétariennes.',10.99,'/public/uploads/dishes/be54cb47-5ffe-47a1-b9d5-61466c27ddf1.jpg',2,'2021-06-22 08:53:57','2021-06-23 10:26:41'),(6,'Pizza','medium','La pizza est une recette de cuisine traditionnelle de la cuisine italienne, originaire de Naples à base de galette de pâte à pain, garnie de divers mélanges d’ingrédients et cuite au four.',9.99,'/public/uploads/dishes/a4c49a4c-7450-4f3d-951a-59aa490988f1.jpg',2,'2021-06-22 08:53:57','2021-06-23 10:07:56'),(7,'Gratin','medium','Un gratin est une préparation qui est cuite au four ou dont une partie de la cuisson se passe au four, en utilisant plus particulièrement le gril, ou à la salamandre, de telle sorte qu\'il se forme en surface de la préparation une croûte plus ou moins légère et dorée. ',10.99,'/public/uploads/dishes/9572a10e-cf52-4986-9288-269cb95bc0bf.jpg',2,'2021-06-22 08:53:57','2021-06-23 11:36:10'),(8,'Pasta','medium','Les pâtes alimentaires sont des aliments fabriqués à partir d\'un mélange pétri de farine, de semoule de blé dur, d\'épeautre, de blé noir, de riz, de maïs ou d\'autres types de céréales, d\'eau et parfois d\'œuf et de sel.',10.99,'/public/uploads/dishes/e4d4273e-535b-4ec3-b2bb-5cc0b29cffa8.jpg',2,'2021-06-22 08:53:57','2021-06-23 11:33:51'),(9,'Cannoli','medium','Le cannolo est une pâtisserie originaire de Sicile qui constitue une partie essentielle de la cuisine sicilienne.',10.99,'/public/uploads/dishes/5279c9e6-c8e2-4545-8596-0f8cd839c4e5.jpg',3,'2021-06-22 08:53:57','2021-06-23 11:37:30'),(10,'Tiramisu','medium','Le tiramisu (de l\'italien « tiramisù », du vénitien « tiramesù », littéralement « tire-moi vers le haut », « remonte-moi le moral », « redonne-moi des forces ») est une pâtisserie et un dessert traditionnel de la cuisine italienne.',6.99,'/public/uploads/dishes/eddc70e0-eacd-41ef-96f6-578d7bc28e1c.jpg',3,'2021-06-22 08:53:57','2021-06-23 10:27:59'),(11,'Cheescake','medium','Traduit de l\'anglais-Le cheesecake est un dessert sucré composé d\'une ou plusieurs couches. La couche principale, et la plus épaisse, consiste en un mélange de fromage frais, d\'oeufs et de sucre.',10.99,'/public/uploads/dishes/b101d259-b7dc-4679-b901-9d5f45c30d48.jpg',3,'2021-06-22 08:53:57','2021-06-23 11:38:27'),(12,'Panna Cotta','junior','La panna cotta est un dessert traditionnel de la cuisine italienne, originaire du Piémont, à base de crème, lait, sucre, et gélatine.',5.99,'/public/uploads/dishes/954ec871-3f66-4909-94af-dfab977eaf3c.jpg',3,'2021-06-22 08:53:57','2021-06-23 11:39:25'),(13,'S.Pellegrino','medium','Traduit de l\'anglais-S.Pellegrino est une marque italienne d\'eau minérale naturelle, détenue par la société Sanpellegrino SpA, qui fait partie de la société suisse Nestlé depuis 1997. ',10.99,'/public/uploads/dishes/e07c39f8-a574-42c9-b366-41f95f5d6042.jpg',4,'2021-06-22 08:53:57','2021-06-23 12:19:34'),(14,'Cocktail','medium','Un cocktail, aussi parfois orthographié coquetel au Canada, est un mélange de boissons et d’éléments aromatiques et décoratifs en quantité variable. Ils contiennent souvent de l\'alcool, mais de très nombreuses recettes en sont dépourvues.',10.99,'/public/uploads/dishes/d2c0f490-4f74-44f8-a406-a7a37579f920.jpg',4,'2021-06-22 08:53:57','2021-06-23 11:40:40'),(15,'Vin rouge','medium','Un vin rouge est obtenu par la fermentation du moût de raisins noirs en présence de la pellicule, des pépins et éventuellement de la rafle. ',10.99,'/public/uploads/dishes/3f72618c-9066-4a82-bbdc-9552c3cf2686.jpg',4,'2021-06-22 08:53:57','2021-06-23 11:41:31'),(16,'Vin blanc','medium','Le vin blanc est un vin produit par la fermentation alcoolique du moût des raisins à pulpe non colorée et à pellicule blanche ou noire. Il est traité de façon à conserver une couleur jaune transparente au produit final.',10.99,'/public/uploads/dishes/ed7f5000-fd7b-43be-ac5e-8473dfc3aa78.jpg',4,'2021-06-22 08:53:57','2021-06-23 11:42:54'),(18,'Pâtes carbonara','medium','Les pâtes à la carbonara sont une recette de pâtes d\'origine romaine et très populaire en Italie.',11.99,'/public/uploads/dishes/89bce7fd-32f4-43ea-a33a-60ec6cbd29fa.jpg',2,'2021-06-22 16:06:36','2021-06-23 10:27:15');
/*!40000 ALTER TABLE `dishes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingredients` (
  `product_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`product_id`,`dish_id`),
  KEY `dish_id` (`dish_id`),
  CONSTRAINT `ingredients_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ingredients_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredients`
--

LOCK TABLES `ingredients` WRITE;
/*!40000 ALTER TABLE `ingredients` DISABLE KEYS */;
/*!40000 ALTER TABLE `ingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_details` (
  `dish_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`dish_id`,`order_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_details`
--

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
INSERT INTO `order_details` VALUES (1,6,1,'2021-06-25 16:54:15',NULL),(2,4,1,'2021-06-25 15:52:20',NULL),(2,6,3,'2021-06-25 16:54:15',NULL),(3,5,1,'2021-06-25 16:18:35',NULL),(3,6,3,'2021-06-25 16:54:15',NULL),(4,4,1,'2021-06-25 15:52:20',NULL),(5,4,1,'2021-06-25 15:52:20',NULL),(5,6,2,'2021-06-25 16:54:15',NULL),(6,4,1,'2021-06-25 15:52:20',NULL),(6,6,1,'2021-06-25 16:54:15',NULL),(7,6,3,'2021-06-25 16:54:15',NULL),(8,6,1,'2021-06-25 16:54:15',NULL),(9,6,1,'2021-06-25 16:54:15',NULL),(10,4,1,'2021-06-25 15:52:20',NULL),(11,4,1,'2021-06-25 15:52:20',NULL),(11,6,3,'2021-06-25 16:54:15',NULL),(12,6,1,'2021-06-25 16:54:15',NULL),(13,4,2,'2021-06-25 15:52:20',NULL),(14,6,2,'2021-06-25 16:54:15',NULL),(15,6,1,'2021-06-25 16:54:15',NULL),(18,5,1,'2021-06-25 16:18:35',NULL),(18,6,6,'2021-06-25 16:54:15',NULL);
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (4,'reçu','visa',1,'2021-06-25 15:52:20',NULL),(5,'reçu','visa',1,'2021-06-25 16:18:35',NULL),(6,'reçu','visa',1,'2021-06-25 16:54:15',NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` float(5,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float(5,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'tomates',7,1.99,1,'2021-06-22 11:48:27','2021-06-22 12:21:06');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` enum('1','2','3','4','5') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `dish_id` (`dish_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`dish_id`) REFERENCES `dishes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'John','Doe','0123456789','4 rue du test','testville','testpays','75001','test@test.com','$2y$14$MvQ8WCwDVeJbr36FUzP32.dn6hWOVVVR6rbe8mNX9NiFsr9WDFAeW',1,'2021-06-22 08:53:57',NULL),(2,'jack','Doe','0123456789','3 rue du test','testville','France','57489','test@test.fr','$2y$14$r0wyc9KXaSDLXC3.pwHLGOtNNHe32UK8bBldN2GONdxL4Jk9zBU86',0,'2021-06-25 09:22:56',NULL);
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

-- Dump completed on 2021-06-25 17:03:46
