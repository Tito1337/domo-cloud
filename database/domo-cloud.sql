-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 03 Mai 2016 à 21:21
-- Version du serveur :  5.6.30-0ubuntu0.15.10.1
-- Version de PHP :  5.6.11-1ubuntu3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

--
-- Base de données :  `domo-cloud`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `expire` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `clients`
--

INSERT INTO `clients` (`id`, `name`, `expire`, `email`, `password`) VALUES
(1, 'Alexis', '2016-03-31 00:00:00', 'alexis@domocloud.com', 'password');

-- --------------------------------------------------------

--
-- Structure de la table `default_orders`
--

CREATE TABLE IF NOT EXISTS `default_orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `temperature` float NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `default_orders`
--

INSERT INTO `default_orders` (`id`, `client_id`, `room_id`, `temperature`) VALUES
(13, 1, 1, 26);

-- --------------------------------------------------------

--
-- Structure de la table `derogative_orders`
--

CREATE TABLE IF NOT EXISTS `derogative_orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `temperature` float NOT NULL,
  `start` datetime NOT NULL,
  `stop` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `rooms`
--

INSERT INTO `rooms` (`id`, `client_id`, `name`) VALUES
(1, 1, 'Salon'),
(2, 1, 'Chambre'),
(3, 1, 'Salle de bain');

-- --------------------------------------------------------

--
-- Structure de la table `weekly_orders`
--

CREATE TABLE IF NOT EXISTS `weekly_orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `day` varchar(3) NOT NULL,
  `room_id` int(11) NOT NULL,
  `temperature` float NOT NULL,
  `start` time NOT NULL,
  `stop` time NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `weekly_orders`
--

INSERT INTO `weekly_orders` (`id`, `client_id`, `day`, `room_id`, `temperature`, `start`, `stop`) VALUES
(167, 1, '3', 2, 20, '04:30:00', '08:30:00'),
(168, 1, '2', 2, 20, '09:00:00', '11:00:00'),
(177, 1, '3', 1, 30, '07:00:00', '12:30:00'),
(178, 1, '4', 1, 30, '08:30:00', '11:30:00'),
(179, 1, '1', 1, 24, '18:00:00', '23:00:00'),
(180, 1, '4', 1, 42, '15:00:00', '17:00:00');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `default_orders`
--
ALTER TABLE `default_orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `derogative_orders`
--
ALTER TABLE `derogative_orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `weekly_orders`
--
ALTER TABLE `weekly_orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `default_orders`
--
ALTER TABLE `default_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `derogative_orders`
--
ALTER TABLE `derogative_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `weekly_orders`
--
ALTER TABLE `weekly_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=181;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
