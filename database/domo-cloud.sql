-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 03 Février 2016 à 11:34
-- Version du serveur :  5.6.28-0ubuntu0.15.10.1
-- Version de PHP :  5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `domo-cloud`
--
CREATE DATABASE IF NOT EXISTS `domo-cloud` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `domo-cloud`;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `expire` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `default_orders`
--

DROP TABLE IF EXISTS `default_orders`;
CREATE TABLE IF NOT EXISTS `default_orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `temperature` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `derogative_orders`
--

DROP TABLE IF EXISTS `derogative_orders`;
CREATE TABLE IF NOT EXISTS `derogative_orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `temperature` float NOT NULL,
  `start` time NOT NULL,
  `stop` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `weekly_orders`
--

DROP TABLE IF EXISTS `weekly_orders`;
CREATE TABLE IF NOT EXISTS `weekly_orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `day` varchar(3) NOT NULL,
  `room_id` int(11) NOT NULL,
  `temperature` float NOT NULL,
  `start` time NOT NULL,
  `stop` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `default_orders`
--
ALTER TABLE `default_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `derogative_orders`
--
ALTER TABLE `derogative_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `weekly_orders`
--
ALTER TABLE `weekly_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
