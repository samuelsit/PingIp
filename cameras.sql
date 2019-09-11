-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  mer. 11 sep. 2019 à 22:40
-- Version du serveur :  5.7.25
-- Version de PHP :  7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `test`
--

-- --------------------------------------------------------

--
-- Structure de la table `cameras`
--

CREATE TABLE `cameras` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `groups` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `port` int(10) NOT NULL DEFAULT '37777',
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cameras`
--
ALTER TABLE `cameras`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cameras`
--
ALTER TABLE `cameras`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
