-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: eshop
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (13,1,3,4),(14,1,4,5),(15,3,5,1),(16,3,2,1);
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (8,8,'Heather Grey Hoodie',8,54.99),(9,9,'Heather Grey Hoodie',5,54.99),(10,10,'Soft White Hoodie',5,59.99),(11,11,'Soft White Hoodie',3,59.99),(12,12,'Soft White Hoodie',3,59.99),(13,13,'Soft White Hoodie',5,59.99),(14,14,'Soft White Hoodie',5,59.99),(15,15,'Soft White Hoodie',5,59.99),(16,16,'Dark Mode Hoodie',1,39.99),(17,17,'Dark Mode Hoodie',1,39.99),(18,18,'Dark Mode Hoodie',1,39.99);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `card_name` varchar(100) DEFAULT NULL,
  `card_number` varchar(30) DEFAULT NULL,
  `expiry` varchar(10) DEFAULT NULL,
  `cvv` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (7,'elpidoforos','Elpidoforos Moysiadis',439.92,'2025-05-14 12:06:52',1,0.00,'Evaweg 3','Klagenfurt am Wörthersee','9020','Austria','067764798309','eeee','1341 2321 3132 1323','12/27','231'),(8,'elpidoforos','Elpidoforos Moysiadis',439.92,'2025-05-14 12:09:00',1,0.00,'Evaweg 3','Klagenfurt am Wörthersee','9020','Austria','067764798309','eeeeee','1231 2312 3131 2312','12/27','123'),(9,'elpidoforos','Elpidoforos Moysiadis',274.95,'2025-05-14 12:12:57',1,0.00,'bellisariou 78','thessaloniki','54633','Greece','067764798309','elpi','1231 2312 3213','12/27','342'),(10,'elpidoforos','Elpidoforos Moysiadis',299.95,'2025-05-14 12:13:32',1,0.00,'Evaweg 3','Klagenfurt am Wörthersee','9020','Austria','067764798309','elpi','1231 2312 3123 1231','12/07','123'),(11,'elpidoforos','elpidoforos ',179.97,'2025-05-14 12:21:02',1,0.00,'Evaweg 3','Klagenfurt am Wörthersee','9020','Greece','067764798309','elpi','1231231231231231','12/06','123'),(12,'elpidoforos','elpidoforos ',179.97,'2025-05-14 21:59:21',1,0.00,'Καρολιδου παυλου 3β','κατω τουμπα','54453','Greece','6906734517','elpidoforos1','1232 1312 3123 1231','12/27','213'),(13,'elpidoforos','Elpidoforos Moysiadis',299.95,'2025-05-14 21:59:46',1,0.00,'Evaweg 3','Klagenfurt am Wörthersee','9020','Italy','067764798309','deeeeee','2131 2312 3123 1231','12/43','123'),(14,'elpidoforos','Elpidoforos Moysiadis',299.95,'2025-05-14 22:02:55',1,0.00,'Evaweg 3','Klagenfurt am Wörthersee','9020','Italy','067764798309','eeeeeee','3123 1312 3123 1233','12/54','123'),(15,'elpidoforos','Ελπιδοφορος μωυσιαδης',299.95,'2025-05-14 22:04:30',1,0.00,'Καρολιδου παυλου 3β','κατω τουμπα','54453','Greece','6906734517','eeeee','2131 2312 3123 1231','12/43','123'),(16,'elpidoforos','Elpidoforos Moysiadis',39.99,'2025-05-14 22:06:16',1,0.00,'Evaweg 3','Klagenfurt am Wörthersee','9020','Greece','067764798309','eeeee','4523 4234 2342 3342','04/34','312'),(17,'elpidoforos','Ελπιδοφορος μωυσιαδης',39.99,'2025-05-14 22:06:59',1,0.00,'Καρολιδου παυλου 3β','κατω τουμπα','54453','Greece','6906734517','eeeeee','3432 3423 4123 4324','12/72','123'),(18,'elpidoforos','Elpidoforos Moysiadis',39.99,'2025-05-14 22:13:50',1,0.00,'Evaweg 3','Klagenfurt am Wörthersee','9020','Italy','067764798309','elpidoforos','1312 3123 1231 2312','12/28','123');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT 'default.png',
  `original_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Black Graphic Hoodie','Bold black hoodie with a statement graphic.',49.99,'hoodie1.png',NULL),(2,'Heather Grey Hoodie','Oversized heather grey hoodie for ultimate comfort.',54.99,'hoodie2.png',NULL),(3,'Soft White Hoodie','Clean minimalist white hoodie for any occasion.',59.99,'hoodie3.png',NULL),(4,'Dark Mode Hoodie','Sleek black hoodie, a wardrobe essential.',39.99,'hoodie4.png',49.99),(5,'Charcoal Relax Hoodie','Relaxed charcoal hoodie perfect for chill days.',44.99,'hoodie5.png',59.99);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'elpidoforos','panther.2004.em@gmail.com','$2y$10$6GH0JxPi2dEGPs4akuAS9eDkYCGRCHvl.IbHCfkRWziWt36V2fo1O'),(2,'kostas','moisiadis@gmail.com','$2y$10$u8ZmkLoBPgpYGfTOOE3iHu1MleI/AIQ2xQst.rkOa/GjHFIq4xDXe'),(3,'elpidoforos','moisiadis.2004.em@gmail.com','$2y$10$Y8Z.UgK3ZZs2LifR3MfEpORovNSnq1VVD0W0LVOiNc0tjguX8jejm'),(4,'elpidoforos','afidsiaf@gmail.com','$2y$10$/aP9Patjqq.sh3mE/onVSulbsDNJ0Mr7bROzVh13jSGDrCr0c3a6.');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
INSERT INTO `wishlists` VALUES (3,1,2);
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-01 23:51:00
