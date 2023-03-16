-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 16 mars 2023 à 08:19
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
  `id_shopping_list` int NOT NULL,
  `id_article` int NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `brand` text COLLATE utf8mb4_unicode_ci,
  `unity_price` int NOT NULL,
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
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
