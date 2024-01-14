/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `customers` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `customer_firstname` varchar(50) DEFAULT NULL,
  `customer_surname` varchar(50) DEFAULT NULL,
  `customer_ssn` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `customer_phone` varchar(10) DEFAULT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `customer_address` varchar(50) DEFAULT NULL,
  `customer_city` varchar(50) DEFAULT NULL,
  `customer_zip` varchar(5) DEFAULT NULL,
  `created` date DEFAULT (curdate()),
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customer_ssn` (`customer_ssn`),
  UNIQUE KEY `customer_email` (`customer_email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `media` (
  `media_id` int NOT NULL AUTO_INCREMENT,
  `media_name` varchar(50) DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  PRIMARY KEY (`media_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `media_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `order_items` (
  `order_item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `subtotal` int DEFAULT NULL,
  `created` date DEFAULT (curdate()),
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `total` int DEFAULT NULL,
  `created` date DEFAULT (curdate()),
  PRIMARY KEY (`order_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(25) DEFAULT NULL,
  `price` int DEFAULT NULL,
  `saleable` tinyint(1) DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `media_id` int DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `customers` (`customer_id`, `customer_firstname`, `customer_surname`, `customer_ssn`, `customer_phone`, `customer_email`, `customer_address`, `customer_city`, `customer_zip`, `created`) VALUES
(1, 'Bettina', 'Efternamn', '9603091234', '0764023977', 'bettina.toth@gritacademy.se', 'Visitörsgatan 8', 'Helsingborg', '25248', '2023-11-23');
INSERT INTO `customers` (`customer_id`, `customer_firstname`, `customer_surname`, `customer_ssn`, `customer_phone`, `customer_email`, `customer_address`, `customer_city`, `customer_zip`, `created`) VALUES
(2, 'Hugo', 'Fransson', '6704068181', '0767723977', 'HugoBror@email.com', 'Slottsvägen 34', 'Skövde', '34567', '2023-11-22');
INSERT INTO `customers` (`customer_id`, `customer_firstname`, `customer_surname`, `customer_ssn`, `customer_phone`, `customer_email`, `customer_address`, `customer_city`, `customer_zip`, `created`) VALUES
(3, 'Nelly', 'Cruse', '8704038181', '0769923977', 'nelly@email.com', 'Hultentorps gränd 12', 'Gävle', '45671', '2023-11-19');
INSERT INTO `customers` (`customer_id`, `customer_firstname`, `customer_surname`, `customer_ssn`, `customer_phone`, `customer_email`, `customer_address`, `customer_city`, `customer_zip`, `created`) VALUES
(4, 'Julia', 'Gunnarsson', '6104078981', '0790023977', 'julia@gmail.com', 'Torpgatan 13', 'Kiruna', '35671', '2023-11-27'),
(5, 'Margareta', 'Eriksson', '9704068143', '0764023847', 'maggan@hotmail.com', 'Ugglevägen 89', 'Uppsala', '45277', '2023-11-13'),
(6, 'Gunnar', 'Lennartsson', '9603093333', '0736325777', 'email2@email.com', 'Fäladtorpsvägen 55', 'Staffanstorp', '34112', '2023-11-24'),
(8, 'Silvia', 'Stankovic', '9203077333', '0736325777', 'silvia@email.com', 'Kolibrigatan 14', 'Dalhem', '33442', '2023-11-28'),
(9, 'Anna', 'Eklund', '9203090022', '0764032944', 'anna@gmail.com', NULL, NULL, NULL, '2023-11-27'),
(10, 'Bubbi', 'Buggice', '8911123456', '0736325557', 'bub@email.com', 'Dalhemsvägen 4', 'Helsingborg', '25465', '2023-11-26'),
(11, 'Bo', 'Karlsson', '6509113333', '0744325477', 'bo@email.com', 'Dalhemsvägen 88', 'Helsingborg', '25465', '2023-11-29'),
(12, 'Jeremias', 'Hillerberg', '9303079777', '0737133797', 'jerre@gmail.com', 'Håkan Lundbergs gata 28', 'Helsingborg', '25233', '2023-11-29'),
(13, 'Ulf', 'Ros', '6703038785', '0734024866', 'ulf@email.com', 'Gatan 1', 'Malmö', '11122', '2023-11-29'),
(14, 'David', 'Jonsson', '8402345555', '0784678422', 'Jzz@email.com', 'Bullegatan 1', 'Stockholm', '33344', '2023-11-29'),
(15, 'Sally', 'Bell', '9303096662', '0873467788', 'sally@gmail.com', 'Gunnarsgatan 2', 'Gåsebäck', '11355', '2023-11-30'),
(16, 'Franz', 'Kafka', '9303196662', '0873467788', 'sally2@gmail.com', 'Gunnarsgatan 2', 'Gåsebäck', '11355', '2023-11-30'),
(17, 'Camilla', 'Ekenstam', '9293970011', '0786535511', 'shukarije@gmail.com', 'Bagaregatan 6', 'Eslöv', '88224', '2023-12-01'),
(18, 'Michele', 'Nordsten', '5603091111', '0736315477', 'dsfds@email.com', 'Dalhemsvägen 5', 'Helsingborg', '25465', '2023-12-01'),
(19, 'Array', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-01-05'),
(20, 'Jonas', 'Bergman', '6409240101', '091234567', 'mandarin@email.com', 'Mandarinvägen 7', 'Gåsebäck', '78133', '2024-01-05'),
(21, 'Jobi', 'Yoda', '7602021111', '098755555', 'y@email.com', 'Bobigatan 4', 'Ghetto', '33355', '2024-01-05'),
(22, 'Nalle', 'Björn', '9901014444', '123456789', 'b@email.com', 'Bogatan 1', 'Simrishamn', '12123', '2024-01-06'),
(23, 'Bettina', 'Toth', '9603093321', '0764032977', 'bbettinatoth@gmail.com', 'Visitörsgatan 8', 'Helsingborg', '25248', '2024-01-07'),
(24, 'Simon', 'Hillerberg', '9303070537', '0737133797', 'jeremias@test.se', 'Håkan Lundbergs gata 28', 'Helsingborg', '25233', '2024-01-07'),
(25, 'Danny', 'Bo', '9603034444', '0764034488', 'gf@dsd.com', 'fdg', 'a', 'a', '2024-01-12');

INSERT INTO `media` (`media_id`, `media_name`, `product_id`) VALUES
(1, '\\assets\\img\\1.png', 1);
INSERT INTO `media` (`media_id`, `media_name`, `product_id`) VALUES
(2, '\\assets\\img\\2.png', 2);
INSERT INTO `media` (`media_id`, `media_name`, `product_id`) VALUES
(3, '\\assets\\img\\3.png', 3);
INSERT INTO `media` (`media_id`, `media_name`, `product_id`) VALUES
(4, '\\assets\\img\\4.png', 4),
(5, '\\assets\\img\\5.png', 5),
(6, '\\assets\\img\\6.png', 6),
(7, '\\assets\\img\\7.png', 7),
(8, '\\assets\\img\\8.png', 8),
(9, '\\assets\\img\\9.png', 9),
(10, '\\assets\\img\\10.png', 10),
(11, '\\assets\\img\\11.png', 11),
(12, '\\assets\\img\\12.png', 12);

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `subtotal`, `created`) VALUES
(1, 1, 1, 4, 40, '2023-11-26');
INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `subtotal`, `created`) VALUES
(2, 14, 1, 1, 10, '2023-11-29');
INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `subtotal`, `created`) VALUES
(3, 15, 1, 1, 10, '2023-11-29');
INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `subtotal`, `created`) VALUES
(4, 15, 2, 2, 100, '2023-11-29'),
(5, 16, 1, 1, 10, '2023-11-29'),
(6, 16, 2, 2, 100, '2023-11-29'),
(7, 17, 8, 8, 96, '2023-11-29'),
(8, 17, 9, 9, 315, '2023-11-29'),
(9, 17, 11, 11, 275, '2023-11-29'),
(10, 18, 2, 2, 100, '2023-11-29'),
(11, 18, 5, 5, 60, '2023-11-29'),
(12, 19, 2, 2, 100, '2023-11-29'),
(13, 19, 5, 5, 60, '2023-11-29'),
(14, 20, 4, 4, 120, '2023-11-29'),
(15, 20, 7, 7, 420, '2023-11-29'),
(18, 22, 2, 2, 100, '2023-11-30'),
(19, 22, 7, 7, 420, '2023-11-30'),
(20, 28, 11, 5, 125, '2024-01-05'),
(21, 29, 7, 3, 180, '2024-01-05'),
(22, 29, 8, 2, 24, '2024-01-05'),
(23, 30, 4, 2, 60, '2024-01-05'),
(24, 31, 4, 2, 60, '2024-01-06'),
(25, 31, 5, 2, 24, '2024-01-06'),
(26, 45, 1, 1, 10, '2024-01-07'),
(27, 45, 2, 2, 100, '2024-01-07'),
(28, 45, 4, 1, 30, '2024-01-07'),
(29, 45, 5, 1, 12, '2024-01-07'),
(30, 45, 7, 1, 60, '2024-01-07'),
(31, 45, 8, 1, 12, '2024-01-07'),
(32, 45, 9, 1, 35, '2024-01-07'),
(33, 45, 11, 1, 25, '2024-01-07');

INSERT INTO `orders` (`order_id`, `customer_id`, `status`, `total`, `created`) VALUES
(1, 3, 'shipped', NULL, '2023-11-26');
INSERT INTO `orders` (`order_id`, `customer_id`, `status`, `total`, `created`) VALUES
(2, 5, 'delivered', NULL, '2023-11-27');
INSERT INTO `orders` (`order_id`, `customer_id`, `status`, `total`, `created`) VALUES
(3, 6, NULL, NULL, '2023-11-27');
INSERT INTO `orders` (`order_id`, `customer_id`, `status`, `total`, `created`) VALUES
(4, 6, NULL, NULL, '2023-11-27'),
(5, 8, NULL, NULL, '2023-11-27'),
(6, 9, NULL, NULL, '2023-11-27'),
(7, 9, 'processed', 0, '2023-11-27'),
(8, NULL, 'processed', NULL, '2023-11-29'),
(9, NULL, 'processed', NULL, '2023-11-29'),
(10, NULL, 'processing', 0, '2023-11-29'),
(11, NULL, 'processing', 0, '2023-11-29'),
(12, NULL, 'processing', 0, '2023-11-29'),
(13, NULL, 'processing', 0, '2023-11-29'),
(14, 11, 'processed', 0, '2023-11-29'),
(15, 11, 'shipped', 0, '2023-11-29'),
(16, 11, 'processed', 0, '2023-11-29'),
(17, 12, 'processed', 0, '2023-11-29'),
(18, 13, 'delivered', 0, '2023-11-29'),
(19, 13, 'processed', 0, '2023-11-29'),
(20, 14, 'processed', 0, '2023-11-29'),
(22, 16, 'processed', 0, '2023-11-30'),
(23, 17, 'processing', 0, '2023-12-01'),
(24, 18, 'cancelled', 0, '2023-12-01'),
(25, 18, 'processing', 0, '2023-12-01'),
(26, 18, 'processing', 0, '2023-12-01'),
(27, 18, 'delivered', 0, '2023-12-01'),
(28, 19, 'shipped', NULL, '2024-01-05'),
(29, 20, 'processed', NULL, '2024-01-05'),
(30, 21, 'processed', NULL, '2024-01-05'),
(31, 22, 'processed', NULL, '2024-01-06'),
(32, 23, 'processed', NULL, '2024-01-07'),
(33, 23, 'processed', NULL, '2024-01-07'),
(34, 23, 'processed', NULL, '2024-01-07'),
(35, 23, 'processed', NULL, '2024-01-07'),
(36, 23, 'processed', NULL, '2024-01-07'),
(37, 23, 'processed', NULL, '2024-01-07'),
(38, 23, 'processed', NULL, '2024-01-07'),
(39, 23, 'processed', NULL, '2024-01-07'),
(40, 23, 'processed', NULL, '2024-01-07'),
(41, 23, 'processed', NULL, '2024-01-07'),
(42, 23, 'processed', NULL, '2024-01-07'),
(43, 23, 'processed', NULL, '2024-01-07'),
(44, 1, 'processed', NULL, '2024-01-07'),
(45, 24, 'completed', NULL, '2024-01-07'),
(46, 25, 'processing', NULL, '2024-01-12');

INSERT INTO `products` (`product_id`, `product_name`, `price`, `saleable`, `stock`, `media_id`) VALUES
(1, 'Kiwi', 10, 1, 30, 1);
INSERT INTO `products` (`product_id`, `product_name`, `price`, `saleable`, `stock`, `media_id`) VALUES
(2, 'Cherry', 50, 1, 20, 2);
INSERT INTO `products` (`product_id`, `product_name`, `price`, `saleable`, `stock`, `media_id`) VALUES
(3, 'Pear', 20, 0, 16, 3);
INSERT INTO `products` (`product_id`, `product_name`, `price`, `saleable`, `stock`, `media_id`) VALUES
(4, 'Mango', 30, 1, 40, 4),
(5, 'Orange', 12, 1, 30, 5),
(6, 'Pineapple', 40, 0, 50, 6),
(7, 'Watermelon', 60, 1, 25, 7),
(8, 'Banana', 12, 1, 90, 8),
(9, 'Pomegranate', 35, 1, 5, 9),
(10, 'Blackberry', 60, 0, 40, 10),
(11, 'Avocado', 25, 1, 50, 11),
(12, 'Lemon', 10, 0, 20, 12);


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;