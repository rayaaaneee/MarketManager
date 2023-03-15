-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 15 mars 2023 à 16:19
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
-- Base de données : `placemarket`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL,
  `unity_price` float NOT NULL,
  `type_id` int NOT NULL,
  `article_in_list_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66C54C8C93` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `name`, `stock`, `unity_price`, `type_id`, `article_in_list_id`) VALUES
(1, 'Pâtes', 47, 1.5, 1, 0),
(2, 'Riz', 37, 2.3, 1, 0),
(3, 'Chips', 38, 1.8, 1, 0),
(4, 'Biscuits', 66, 1.2, 2, 0),
(5, 'Chocolat', 38, 2.5, 2, 0),
(6, 'Bonbons', 40, 0.8, 2, 0),
(7, 'Lessive', 17, 6.5, 3, 0),
(8, 'Liquide vaisselle', 14, 2.2, 3, 0),
(9, 'Papier toilette', 10, 1.8, 3, 0),
(10, 'Chemise homme', 54, 20, 4, 0),
(11, 'Robe femme', 59, 25, 4, 0),
(12, 'Ceinture', 12, 8.5, 4, 0),
(13, 'Coussin', 43, 12, 5, 0),
(14, 'Tapis', 57, 30, 5, 0),
(15, 'Table basse', 33, 50, 5, 0),
(16, 'Aspirine', 39, 2.5, 6, 0),
(17, 'Vitamine C', 31, 6, 6, 0),
(18, 'Pansements', 28, 1.2, 6, 0),
(19, 'Puzzle', 39, 8, 7, 0),
(20, 'Jeux de cartes', 44, 4.5, 7, 0),
(21, 'Ballon de football', 38, 12, 10, 0),
(22, 'Ballon de basket', 48, 15, 10, 0),
(23, 'Raquette de tennis', 59, 35, 10, 0),
(24, 'Crayon à lèvres', 29, 6.5, 8, 0),
(25, 'Mascara', 16, 8, 8, 0),
(26, 'Vernis à ongles', 39, 5, 8, 0),
(27, 'Roman', 23, 10, 9, 0),
(28, 'Magazine', 47, 3.5, 9, 0);

-- --------------------------------------------------------

--
-- Structure de la table `article_in_list`
--

DROP TABLE IF EXISTS `article_in_list`;
CREATE TABLE IF NOT EXISTS `article_in_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_shopping_list` int NOT NULL,
  `id_article` int NOT NULL,
  `quantity` int NOT NULL,
  `total_price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('DoctrineMigrations\\Version20230307100251', '2023-03-07 10:03:14', 253),
('DoctrineMigrations\\Version20230315155847', '2023-03-15 16:00:31', 519);

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
  `id_user` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` double NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'Alimentation Salé'),
(2, 'Alimentation Sucré'),
(3, 'Produits ménagers'),
(4, 'Vêtements et accessoires'),
(5, 'Articles de maison et de décoration'),
(6, 'Santé et bien-être'),
(7, 'Jouets et jeux'),
(8, 'Produits cosmétiques et de beauté'),
(9, 'Livres et magazines'),
(10, 'Articles de sport');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `password`) VALUES
(10, 'viggo', 'cas', '$2y$10$86C8uQYnJ88LxpTMJe4jK.BodoafdUG44OfnlpW91DJwJZ2.eeIUG'),
(11, 'root', 'root', '$2y$10$zGfzuM6vBrTFAQHgxzlHg.iKZr5v1f0KICAsNzesly2qq/jMWYYj6');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66C54C8C93` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
