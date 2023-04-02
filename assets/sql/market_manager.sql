-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 01 avr. 2023 à 19:56
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `market_manager`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unity_price` double NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66C54C8C93` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `type_id`, `name`, `unity_price`, `image`) VALUES
(30, 1, 'Pastas', 1.5, 'pasta.png'),
(31, 1, 'Rice', 2.3, 'rice.png'),
(32, 1, 'Chips', 1.8, 'chips.png'),
(33, 2, 'Cookies', 1.2, 'cookies.png'),
(34, 2, 'Chocolate', 2.5, 'chocolate.png'),
(35, 2, 'Bonbons', 0.8, 'candy.png'),
(36, 3, 'Laundry', 6.5, 'laundry.png'),
(37, 3, 'Detergent', 2.2, 'detergent.png'),
(38, 3, 'Toilet paper', 1.8, 'toilet-paper.png'),
(39, 4, 'Man shirt', 20, 'man-shirt.png'),
(40, 4, 'Woman dress', 25, 'woman-dress.png'),
(41, 4, 'Belt', 8.5, 'belt.png'),
(42, 5, 'Pillow', 12, 'pillow.png'),
(43, 5, 'Rug', 30, 'rug.png'),
(44, 5, 'Coffee table', 50, 'coffee-table.png'),
(45, 6, 'Aspirin', 2.5, 'aspirin.png'),
(46, 6, 'Vitamin C', 6, 'vitamin-c.png'),
(47, 6, 'Band aid', 1.2, 'band-aid.png'),
(48, 7, 'Puzzle', 8, 'puzzle.png'),
(49, 7, 'Card game', 4.5, 'cards.png'),
(50, 10, 'Football ball', 12, 'football-ball.png'),
(51, 10, 'Basket ball', 15, 'basketball-ball.png'),
(52, 10, 'Tennis racket', 35, 'tennis-racket.png'),
(53, 8, 'Lip Stick', 6.5, 'lipstick.png'),
(54, 8, 'Mascara', 8, 'mascara.png'),
(55, 8, 'Nail polish', 5, 'nail-polish.png'),
(56, 9, 'Book', 10, 'book.png'),
(57, 9, 'Magazine', 3.5, 'magazine.png');

-- --------------------------------------------------------

--
-- Structure de la table `article_in_list`
--

DROP TABLE IF EXISTS `article_in_list`;
CREATE TABLE IF NOT EXISTS `article_in_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shopping_list_id` int NOT NULL,
  `article_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `total_price` double NOT NULL,
  `unity_price` double NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_83A183CB23245BF9` (`shopping_list_id`),
  KEY `IDX_83A183CB7294869C` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230330102907', '2023-03-30 10:29:24', 654),
('DoctrineMigrations\\Version20230330152432', '2023-03-30 15:24:43', 54);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `shopping_list`
--

DROP TABLE IF EXISTS `shopping_list`;
CREATE TABLE IF NOT EXISTS `shopping_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nb_articles` int NOT NULL DEFAULT '0',
  `total_price` double NOT NULL DEFAULT '0',
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DC1A459A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id`, `name`) VALUES
(1, 'Salty food'),
(2, 'Sweet food'),
(3, 'Produits ménagers'),
(4, 'Household products'),
(5, 'Home and decoration items'),
(6, 'health and selfcare'),
(7, 'Toys and games'),
(8, 'Cosmetics and beauty products'),
(9, 'Books and magazines'),
(10, 'Sport stuff');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`surname`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`);

--
-- Contraintes pour la table `article_in_list`
--
ALTER TABLE `article_in_list`
  ADD CONSTRAINT `FK_83A183CB23245BF9` FOREIGN KEY (`shopping_list_id`) REFERENCES `shopping_list` (`id`),
  ADD CONSTRAINT `FK_83A183CB7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

--
-- Contraintes pour la table `shopping_list`
--
ALTER TABLE `shopping_list`
  ADD CONSTRAINT `FK_3DC1A459A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
