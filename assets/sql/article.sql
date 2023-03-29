-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 mars 2023 à 12:28
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
