-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 07 sep. 2019 à 10:12
-- Version du serveur :  5.7.19
-- Version de PHP :  7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `jany-chaussures`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(5, 'admin', '$2y$10$KYpLs4ZGEk9ui5rBgqhgkuGYZdQincAWK9xcWnqUC1nbOjV82jVSe'),
(8, 'carococo', '$2y$10$Z1hvIsCij2No2h4/.3DNwuJuOIgWgvynJUTlKOIGBIDJSrGtzhMJu');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `selected_category` tinyint(1) DEFAULT NULL,
  `is_news` tinyint(4) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`category_id`, `title`, `selected_category`, `is_news`) VALUES
(1, 'automne', 1, 1),
(2, 'hiver', 0, 1),
(3, 'printemps', 0, 1),
(4, 'été', 0, 1),
(7, 'top', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marque` varchar(255) NOT NULL,
  `modele` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `marque`, `modele`, `description`) VALUES
(83, 'Sketchers', 'Horizon', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed maximus elit eget libero dapibus, eu molestie purus sollicitudin. Nunc elementum at ipsum non tempor.'),
(84, 'Trekking', 'Quechua', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed maximus elit eget libero dapibus, eu molestie purus sollicitudin. Nunc elementum at ipsum non tempor.'),
(85, 'Trekking', 'Montagne', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed maximus elit eget libero dapibus, eu molestie purus sollicitudin. Nunc elementum at ipsum non tempor.'),
(86, 'Victoria', 'Charol', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed maximus elit eget libero dapibus, eu molestie purus sollicitudin. Nunc elementum at ipsum non tempor.'),
(87, 'Tribeka', 'Black', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed maximus elit eget libero dapibus, eu molestie purus sollicitudin. Nunc elementum at ipsum non tempor.'),
(88, 'Pont', 'Bleu', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed maximus elit eget libero dapibus, eu molestie purus sollicitudin. Nunc elementum at ipsum non tempor.'),
(89, 'Hugo-Boss', 'Saturn', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sed elit eros. Vestibulum eu finibus mi, nec tempor elit. Integer tincidunt nibh eros. '),
(90, 'Alpine', 'Tech', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sed elit eros. Vestibulum eu finibus mi, nec tempor elit. Integer tincidunt nibh eros. '),
(91, 'Mustang', 'Navy', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sed elit eros. Vestibulum eu finibus mi, nec tempor elit. Integer tincidunt nibh eros. '),
(92, 'Sparco', 'Slalom', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sed elit eros. Vestibulum eu finibus mi, nec tempor elit. Integer tincidunt nibh eros.'),
(99, 'Bull', 'Boxer', 'lorem');

-- --------------------------------------------------------

--
-- Structure de la table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE IF NOT EXISTS `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`category_id`),
  KEY `FK_category` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
(86, 1),
(87, 1),
(89, 1),
(92, 1),
(84, 2),
(85, 2),
(99, 2),
(83, 3),
(88, 3),
(90, 3),
(91, 3),
(83, 7),
(84, 7),
(85, 7),
(86, 7),
(87, 7),
(88, 7);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
