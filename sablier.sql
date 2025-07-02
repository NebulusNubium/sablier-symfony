-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 02 juil. 2025 à 08:02
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sablier`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `picture_id` int NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_5F9E962AA76ED395` (`user_id`),
  KEY `IDX_5F9E962AEE45BDBF` (`picture_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `picture_id`, `content`, `created_at`) VALUES
(2, 2, 1, 'Hello dude!', '2025-06-27 14:36:31'),
(3, 2, 4, 'Hi!', '2025-07-01 14:39:22');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250625091857', '2025-06-25 09:19:07', 859),
('DoctrineMigrations\\Version20250625124537', '2025-06-25 12:45:45', 90),
('DoctrineMigrations\\Version20250625124710', '2025-06-25 12:47:13', 36),
('DoctrineMigrations\\Version20250626093138', '2025-06-26 09:31:47', 88),
('DoctrineMigrations\\Version20250626122742', '2025-06-26 12:27:50', 115),
('DoctrineMigrations\\Version20250626142438', '2025-06-26 14:24:46', 234),
('DoctrineMigrations\\Version20250701100927', '2025-07-01 10:09:30', 151);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pictures`
--

DROP TABLE IF EXISTS `pictures`;
CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `valeur` int NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `specificite` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_detaille` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8F7C2FC0A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pictures`
--

INSERT INTO `pictures` (`id`, `user_id`, `nom`, `description`, `valeur`, `image_name`, `updated_at`, `specificite`, `description_detaille`) VALUES
(1, 1, 'fsg', 'sgdf', 0, 'wicked-685bf163ded86795744277.jpg', '2025-06-25 12:53:55', '', ''),
(3, 2, 'Fantasy', 'Pour les amateurs de fantasy', 0, 'fantaisie-685d0b1f61f8c439002326.png', '2025-06-26 08:55:59', '', ''),
(4, 2, 'Who knows?', 'I don\'t fucking know', 0, 'collection-685d0b414ac6e202780137.png', '2025-06-26 08:56:33', '', ''),
(5, 2, 'N°2 Channel', 'Eeeeeh', 0, 'doomsdayhourglass-685d0b6f3941a931872610.png', '2025-06-26 08:57:19', '', ''),
(6, 2, 'Collection', 'Lorem', 200, 'timeturner-685d15385766f438471735.png', '2025-06-26 09:39:04', 'Le plus gros sablier du monde', 'Do you even know what I do with my lif? No you don\'t, I don\'t, and I don\'t know what I\'m even writing'),
(7, 3, 'La seule et l\'unique', 'Elle est unique', 15, NULL, NULL, 'Seule  unique', 'Elle est seule'),
(8, 3, 'test', 'rege', 155, 'wicked-685d2d93b9fdb650245600.jpg', '2025-06-26 11:22:59', 'Seule & unique', 'ergeg');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_USERNAME` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(1, 'admin', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$GCrx8iqDklvgvaaUX8DOveefKA55d6ZJhjn00D.E5KtoBqWZUqk/u'),
(2, 'toto', '[\"ROLE_USER\"]', '$2y$13$XOrw8pow//6ikjBhZqIkeuwQI7PmIoO.XVlgktn49kqllwoMyyOGG'),
(3, 'test', '[\"ROLE_USER\"]', '$2y$13$kpWIC3/VMttLjbkqe7nj8ueT4cgX.CABBwX0o75goJqfXantK7Zcy'),
(4, 'reimu', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(5, 'marisa', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(6, 'sakuya', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(7, 'remilia', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(8, 'flandre', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(9, 'cirno', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(10, 'youmu', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(11, 'yuyuko', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(12, 'alice', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(13, 'patchouli', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(14, 'reisen', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(15, 'sawako', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(16, 'meiling', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(17, 'sanae', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK'),
(18, 'fujiwara', '[\"ROLE_USER\"]', '$2y$13$iKgR8I8rYqz3wKv7xfoLpOPGWDSHAbZr2LyXO9clqpAmpjDXhWfCK');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_5F9E962AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_5F9E962AEE45BDBF` FOREIGN KEY (`picture_id`) REFERENCES `pictures` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `FK_8F7C2FC0A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
