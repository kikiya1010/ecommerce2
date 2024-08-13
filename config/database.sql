-- Create DB
DROP DATABASE IF EXISTS PetShop;
CREATE DATABASE IF NOT EXISTS PetShop;
USE PetShop;

-- Table 'product'
CREATE TABLE IF NOT EXISTS `product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `img_url` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `img_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table 'role'
CREATE TABLE IF NOT EXISTS `role` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table 'user'
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `role_id` (`role_id`),
  FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table 'user_order'
CREATE TABLE IF NOT EXISTS `user_order` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ref` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add role super admin
INSERT INTO `role` (`name`, `description`) VALUES ('superadmin', 'Super Administrator');

-- Insert super admin with password '12345678'
INSERT INTO `user` (`user_name`, `email`, `pwd`, `fname`, `lname`, `role_id`)
VALUES ('superadmin', 'superadmin@admin.ca', '$2y$10$XbVZVwOxlwfv4iiSvMhZdOXiuWWlWhqWJIgZQ5aM5UiUyDhhcHKMa', 'Super', 'Admin', (SELECT `id` FROM `role` WHERE `name` = 'superadmin'));

-- Add role client
INSERT INTO `role` (`name`, `description`) VALUES ('client', 'Client');

-- Insert a client
INSERT INTO `user` (`user_name`, `email`, `pwd`, `fname`, `lname`, `role_id`)
VALUES ('client', 'client@example.com', '$2y$10$WvUt5YLCr9E6H/sbCdtemeyfdK0xKdxd2cj1.pBpKa42QrIK46qpS', 'Client', 'Client', (SELECT `id` FROM `role` WHERE `name` = 'client'));

-- Insert items by default
INSERT INTO `product` (`name`, `quantity`, `price`, `img_url`, `description`, `img_path`)
VALUES 
  ('Arbre à chat', 100, 49.99, '/public/img/Arbre Chat.jpg', 'Structure verticale pour grimper, se percher et aiguiser les griffes.', '/public/img/Arbre Chat.jpg'),
  ('Chaton', 50, 19.99, '/public/img/Chaton.jpg', 'Jeune chat nécessitant des soins spéciaux et une alimentation adaptée.', '/public/img/Chaton.jpg'),
  ('Chiot', 50, 19.99, '/public/img/Chiot.jpg', 'Jeune chien joueur nécessitant éducation précoce et vaccinations.', '/public/img/Chiot.jpg'),
  ('Éliminateur d''odeur', 150, 9.99, '/public/img/Eliminateur Odeur.jpg', 'Produit pour neutraliser les mauvaises odeurs à la maison.', '/public/img/Eliminateur Odeur.jpg'),
  ('Litière', 200, 14.99, '/public/img/Litiere.jpg', 'Matériau absorbant pour le bac à litière des chats.', '/public/img/Litiere.jpg'),
  ('Tapis pour chats', 100, 24.99, '/public/img/Tapis Chats.jpg', 'Tapis conçu pour le jeu et l''aiguisage des griffes des chats.', '/public/img/Tapis Chats.jpg'),
  ('Mur pour chats', 50, 59.99, '/public/img/Mur Chats.jpg', 'Installation murale pour grimper et se détendre en hauteur.', '/public/img/Mur Chats.jpg'),
  ('Nourriture pour chiens', 200, 29.99, '/public/img/Nourriture Chiens.jpg', 'Aliment formulé pour les besoins nutritionnels des chiens.', '/public/img/Nourriture Chiens.jpg'),
  ('Shampoing', 150, 12.99, '/public/img/Shampoing.jpg', 'Produit de toilettage pour nettoyer le pelage des animaux.', '/public/img/Shampoing.jpg');
