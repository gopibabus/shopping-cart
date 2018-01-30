#Drop Database
DROP DATABASE IF EXISTS `ks_shop`;

#Create Database
CREATE DATABASE ks_shop;
USE ks_shop;

# Dump of table categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `name`)
VALUES
	(1,'Toys'),
	(2,'Electronics'),
	(3,'Clothing');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` text,
  `price` double DEFAULT NULL,
  `image` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `image`)
VALUES
	(1,1,'Beach Toys','Beach toys description here.',8.99,'product_beachtoys.jpg'),
	(2,1,'Stuffed Bear','Stuffed bear description here.',15.99,'product_bear.jpg'),
	(3,2,'Computer Monitor','Computer monitor description here.',299.99,'product_computermonitor.jpg'),
	(4,1,'Stuffed Hippo','Stuffed Hippo description.',13,'product_hippo.jpg'),
	(5,1,'Stuffed Reindeer','Reindeer description here.',14.49,'product_reindeer.jpg'),
	(6,2,'Headphones','Headphones description here',19.99,'product_headphones.jpg');

/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
