-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  sam. 02 mai 2020 à 12:18
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.8

DROP DATABASE IF EXISTS BileMo;

CREATE DATABASE BileMo CHARACTER SET 'utf8';

USE BileMo;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `BileMo`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `name`) VALUES
(1, 'Orange'),
(2, 'Bouygues Télécom'),
(3, 'SFR'),
(4, 'Boulanger'),
(5, 'Darty');

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) PRIMARY KEY COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200424125752', '2020-04-24 12:57:59');

-- --------------------------------------------------------

--
-- Structure de la table `phone`
--

CREATE TABLE `phone` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `brand` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_of_marketing` date NOT NULL,
  `screen_size` decimal(5,2) NOT NULL,
  `screen_resolution` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `os_version` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specific_absorption_rate` decimal(3,2) NOT NULL,
  `rom_memory` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `phone` (`id`, `brand`, `model`, `year_of_marketing`, `screen_size`, `screen_resolution`, `os_version`, `color`, `specific_absorption_rate`, `rom_memory`, `description`, `price`) VALUES
(1, 'Apple', 'iPhone 11', '2019-09-20', '6.10', '1792x828', 'iOS 13', 'Vert', '0.95', 64, 'Le dernier iPhone de Apple', '809.00'),
(2, 'Apple', 'iPhone 11 Pro', '2019-09-20', '5.80', '2436x1125', 'iOS 13', 'Vert', '0.99', 64, 'Le dernier iPhone pour les Pros de Apple', '1159.00'),
(3, 'Apple', 'iPhone 11 Pro Max', '2019-09-20', '6.50', '2688x1242', 'iOS 13', 'Vert', '0.95', 64, 'L\'iPhone de très grande taille pour les Pros de Apple', '1259.00'),
(4, 'Samsung', 'Galaxy S20', '2020-02-11', '6.10', '3200x1440', 'Android', 'Cloud Blue', '0.95', 128, 'Le dernier smartphone de Samsung', '909.00'),
(5, 'Samsung', 'Galaxy S10 ultra 5G', '2020-02-11', '6.70', '3200x1440', 'iOS 13', 'Cosmic Black', '0.95', 128, 'Le premier smartphone 5G de Samsung', '809.00'),
(6, 'OnePlus', '7T Pro', '2019-10-17', '6.67', '1792x828', 'Android', 'Vert', '1.12', 256, 'Le dernier iPhone de Apple', '809.00');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `username` varchar(180) UNIQUE KEY COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  CONSTRAINT `FK_8D93D64919EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  KEY `IDX_8D93D64919EB6921` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `client_id`) VALUES
(1, 'Damien', '[\"ROLE_USER\"]', '$2y$13$ySAUTX4.3JShn3pl7ZmyYOwA9ZZgOCNedfbl9aZuP7AZ9ls94LCJ2', 1),
(2, 'Kévin', '[\"ROLE_USER\"]', '$2y$13$fxan7UqF3kTguocYbmg91ebJ0Q3.93Fw.0q6.fe4uC7hyRn9ZBR.y', 2),
(3, 'Ambre', '[\"ROLE_USER\"]', '$2y$13$fxan7UqF3kTguocYbmg91ebJ0Q3.93Fw.0q6.fe4uC7hyRn9ZBR.y', 3),
(4, 'Jade', '[\"ROLE_USER\"]', '$2y$13$fxan7UqF3kTguocYbmg91ebJ0Q3.93Fw.0q6.fe4uC7hyRn9ZBR.y', 4),
(5, 'Chloé', '[\"ROLE_USER\"]', '$2y$13$fxan7UqF3kTguocYbmg91ebJ0Q3.93Fw.0q6.fe4uC7hyRn9ZBR.y', 5),
(6, 'Allan', '[\"ROLE_USER\"]', '$2y$13$fxan7UqF3kTguocYbmg91ebJ0Q3.93Fw.0q6.fe4uC7hyRn9ZBR.y', 1),
(7, 'Nadine', '[\"ROLE_USER\"]', '$2y$13$fxan7UqF3kTguocYbmg91ebJ0Q3.93Fw.0q6.fe4uC7hyRn9ZBR.y', 2),
(8, 'Didier', '[\"ROLE_USER\"]', '$2y$13$fxan7UqF3kTguocYbmg91ebJ0Q3.93Fw.0q6.fe4uC7hyRn9ZBR.y', 3),
(9, 'Théo', '[\"ROLE_USER\"]', '$2y$13$fxan7UqF3kTguocYbmg91ebJ0Q3.93Fw.0q6.fe4uC7hyRn9ZBR.y', 4),
(10, 'Thierry', '[\"ROLE_USER\"]', '$2y$13$fxan7UqF3kTguocYbmg91ebJ0Q3.93Fw.0q6.fe4uC7hyRn9ZBR.y', 5),
(11, 'Samuel', '[\"ROLE_USER\"]', '$2y$13$fxan7UqF3kTguocYbmg91ebJ0Q3.93Fw.0q6.fe4uC7hyRn9ZBR.y', 2),
(12, 'Eleonora', '[\"ROLE_USER\"]', '$2y$13$fxan7UqF3kTguocYbmg91ebJ0Q3.93Fw.0q6.fe4uC7hyRn9ZBR.y', 2);
