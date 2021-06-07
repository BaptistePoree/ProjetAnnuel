-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : sql210.byetcluster.com
-- Généré le :  ven. 04 juin 2021 à 05:22
-- Version du serveur :  5.6.48-88.0
-- Version de PHP :  7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `epiz_28381532_projetAnnuel`
--

-- --------------------------------------------------------

--
-- Structure de la table `cles`
--

CREATE TABLE `cles` (
  `id` int(11) NOT NULL,
  `idRole` int(11) NOT NULL,
  `cles` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `isValider` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `cles`
--

INSERT INTO `cles` (`id`, `idRole`, `cles`, `isValider`) VALUES
(1, 1, 'e4a63cfa02da93fb25009e83a371e2', 1),
(2, 2, '17c42c4c2adc34b316aa075d37fb5d', 1),
(3, 2, 'ac3730d0f90e972b159d83ff5286e0', 1),
(7, 1, 'd20ae9de72d94f0f84975ef600976e', 1),
(8, 2, 'e9b923224638824f088515b2e02729', 1),
(9, 1, 'ad6b50b3022e3bbafe68969232276b', 1),
(10, 1, 'd2f2be4950e7935251967485f12e48', NULL),
(29, 2, '64ae3348bbf932ed36734f47bc7432', NULL),
(31, 1, 'e7b1acc8ec6cbdb65a8ce44b8f5a78', NULL),
(26, 1, '470c1a6d4e3568420b3ba32590d578', NULL),
(27, 2, '0e8a98bcb9c930a64f03361e2e5f01', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `investments`
--

CREATE TABLE `investments` (
  `id` int(11) NOT NULL,
  `idProject` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `investments`
--

INSERT INTO `investments` (`id`, `idProject`, `idUser`, `amount`, `comment`) VALUES
(15, 6, 2, 6000, ''),
(13, 4, 2, 1000, ''),
(14, 5, 2, 3000, ''),
(12, 2, 2, 2000, ''),
(11, 1, 2, 5000, '');

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `projectMember` mediumtext COLLATE utf8mb4_bin
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `image`, `projectMember`) VALUES
(1, 'Projet n°1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc nulla sapien, condimentum eu neque ut, pellentesque rhoncus lacus. Donec auctor rutrum odio nec feugiat. Suspendisse egestas et nulla vel ultricies.', NULL, '{\"1\":[\"Nom1\",\"Prenom1\"],\"2\":[\"Nom2\",\"Prenom2\"],\"3\":[\"Nom3\",\"Prenom3\"]}'),
(2, 'Projet n°2', 'Une petite description...', NULL, NULL),
(3, 'Projet n°3', '', NULL, NULL),
(4, 'Projet n°4', '123456', NULL, NULL),
(5, 'Projet 22', '', NULL, NULL),
(6, 'Projet D\'eau', 'Un jet d\'eau connecté', NULL, NULL),
(10, '^p', '', NULL, NULL),
(11, 'Test', 'On test la pop up lors de la création du projet', NULL, NULL),
(12, 'reTest', 'Je reteste la pop up', NULL, NULL),
(13, 'Tiem', 'bah je suis pas sûr de te faire ', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `nomRole` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `insvestire` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `nomRole`, `insvestire`) VALUES
(1, 'Admin', 0),
(3, 'Professeurs', 0),
(2, 'Crowd-fondeurs', 0),
(4, 'Etudiant ', 0);

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `parameter` varchar(255) CHARACTER SET latin1 NOT NULL,
  `value` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`id`, `parameter`, `value`) VALUES
(1, 'maximumInvestment', '100000');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `mail` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `firstName` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `idRole` int(11) NOT NULL,
  `canInvest` tinyint(1) NOT NULL,
  `idCles` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `mail`, `password`, `firstName`, `lastName`, `idRole`, `canInvest`, `idCles`) VALUES
(1, 'admin@email.fr', '46af6fc1a00438d61fca6c630850e104020fd9a0', 'Admin', 'Admin', 1, 0, 1),
(2, 'exemple1@email.fr', '2b9d532f4052374ffa8dc86f41c452e861b2bc09', 'Arthur', 'LEPONT', 2, 1, 2),
(3, 'exemple2@email.fr', '$2y$10$gVbjVDpvuj.vMDHcYwCu0uYOlCrBzEcP2SQX5n7zFt7knlAKrPlTW', 'Victor', 'RULER', 2, 1, 3),
(26, 'baptiste@email.fr', '1cfd48a9a65a966defdcd720f66cd790094000c4', 'Baptiste', 'Poree', 2, 0, 8),
(25, 'baptiste.poree@email.fr', '1cfd48a9a65a966defdcd720f66cd790094000c4', 'Baptiste', 'Poree', 1, 0, 7);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cles`
--
ALTER TABLE `cles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cles`
--
ALTER TABLE `cles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
