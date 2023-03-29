-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 mars 2023 à 19:27
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
-- Base de données : `marketmanager`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unity_price` float NOT NULL,
  `type_id` int NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66C54C8C93` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `name`, `unity_price`, `type_id`, `image`) VALUES
(1, 'Pâtes', 1.5, 1, 'pasta.png'),
(2, 'Riz', 2.3, 1, 'rice.png'),
(3, 'Chips', 1.8, 1, 'chips.png'),
(4, 'Biscuits', 1.2, 2, 'cookies.png'),
(5, 'Chocolat', 2.5, 2, 'chocolate.png'),
(6, 'Bonbons', 0.8, 2, 'candy.png'),
(7, 'Lessive', 6.5, 3, 'laundry.png'),
(8, 'Liquide vaisselle', 2.2, 3, 'detergent.png'),
(9, 'Papier toilette', 1.8, 3, 'toilet-paper.png'),
(10, 'Chemise homme', 20, 4, 'man-shirt.png'),
(11, 'Robe femme', 25, 4, 'woman-dress.png'),
(12, 'Ceinture', 8.5, 4, 'belt.png'),
(13, 'Coussin', 12, 5, 'pillow.png'),
(14, 'Tapis', 30, 5, 'rug.png'),
(15, 'Table basse', 50, 5, 'coffee-table.png'),
(16, 'Aspirine', 2.5, 6, 'aspirin.png'),
(17, 'Vitamine C', 6, 6, 'vitamin-c.png'),
(18, 'Pansements', 1.2, 6, 'band-aid.png'),
(19, 'Puzzle', 8, 7, 'puzzle.png'),
(20, 'Jeux de cartes', 4.5, 7, 'cards.png'),
(21, 'Ballon de football', 12, 10, 'football-ball.png'),
(22, 'Ballon de basket', 15, 10, 'basketball-ball.png'),
(23, 'Raquette de tennis', 35, 10, 'tennis-racket.png'),
(24, 'Crayon à lèvres', 6.5, 8, 'lipstick.png'),
(25, 'Mascara', 8, 8, 'mascara.png'),
(26, 'Vernis à ongles', 5, 8, 'nail-polish.png'),
(27, 'Roman', 10, 9, 'book.png'),
(28, 'Magazine', 3.5, 9, 'magazine.png');

-- --------------------------------------------------------

--
-- Structure de la table `article_in_list`
--

DROP TABLE IF EXISTS `article_in_list`;
CREATE TABLE IF NOT EXISTS `article_in_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unity_price` double NOT NULL,
  `quantity` int NOT NULL,
  `total_price` double NOT NULL,
  `id_shopping_list_id` int NOT NULL,
  `id_article_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_83A183CBC0AE0E28` (`id_shopping_list_id`),
  KEY `IDX_83A183CBD71E064B` (`id_article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article_in_list`
--

INSERT INTO `article_in_list` (`id`, `name`, `brand`, `unity_price`, `quantity`, `total_price`, `id_shopping_list_id`, `id_article_id`) VALUES
(1, 'Ballon de football', NULL, 12, 1, 12, 1, 21),
(2, 'Ballon de football', NULL, 15, 1, 15, 1, 21),
(3, 'Ballon de football', NULL, 12, 1, 12, 2, 21),
(4, 'Papier toilette super arbsorbant qui irrite le boulard en sah', 'Pampers', 3.5, 1, 3.5, 2, 9);

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
('DoctrineMigrations\\Version20230315155847', '2023-03-15 16:00:31', 519),
('DoctrineMigrations\\Version20230329123027', '2023-03-29 12:31:06', 272),
('DoctrineMigrations\\Version20230329192252', '2023-03-29 19:23:10', 502);

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
  `id_user_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` double NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DC1A45979F37AE5` (`id_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `shopping_list`
--

INSERT INTO `shopping_list` (`id`, `id_user_id`, `name`, `description`, `total_price`, `quantity`) VALUES
(1, 11, 'Ma liste pref ou quoi aha bakala', 'Oh oui niska ou quoi', 0, 0),
(2, 11, 'viggo petite catin', 'reel en vrai', 0, 0),
(3, 11, 'Liste de courses du 31/03/23', NULL, 0, 0);

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

--
-- Contraintes pour la table `article_in_list`
--
ALTER TABLE `article_in_list`
  ADD CONSTRAINT `FK_83A183CBC0AE0E28` FOREIGN KEY (`id_shopping_list_id`) REFERENCES `shopping_list` (`id`),
  ADD CONSTRAINT `FK_83A183CBD71E064B` FOREIGN KEY (`id_article_id`) REFERENCES `article` (`id`);

--
-- Contraintes pour la table `shopping_list`
--
ALTER TABLE `shopping_list`
  ADD CONSTRAINT `FK_3DC1A45979F37AE5` FOREIGN KEY (`id_user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
