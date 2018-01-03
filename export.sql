-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Ven 15 Décembre 2017 à 00:09
-- Version du serveur :  5.6.35
-- Version de PHP :  7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `sendmarks`
--

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `etudiant`
--

INSERT INTO `etudiant` (`id`, `numero`, `email`) VALUES
(1, 20152953, 'thomas.laigneau.pro@gmail.com'),
(2, 20151154, 'vincent.battez.pro@gmail.com'),
(3, 20174915, 'bonvarlet.a@gmail.com'),
(4, 200800468, 'chloecaquant@hotmail.com'),
(5, 20151592, 'benoit.carquillat@gmail.com'),
(6, 20150332, 'clementdlnn@gmail.com'),
(7, 201411677, 'dureisseixthibaut@gmail.com'),
(8, 20151435, 'tenessfevri@gmail.com'),
(9, 20141330, 'flamentjeandavid@yahoo.fr'),
(10, 20172115, 'nicolas.hallez@gmail.com'),
(11, 20150902, 'maxime1jacquet@gmail.com'),
(12, 20000193, 'clement1712@hotmail.fr'),
(13, 20150626, 'malengroslouis97@gmail.com'),
(14, 20137827, 'jnt.masson@gmail.com'),
(15, 20171846, 'florian.nalenne@gmail.com'),
(16, 20172304, 'Ostrowski.benjamin@gmail.com'),
(17, 20164484, 'damien.richez1@gmail.com'),
(18, 20140816, 'kevin-robillard'),
(19, 20172205, 'guillaume.souillard@gmail.com');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;