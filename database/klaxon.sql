-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 08 avr. 2026 à 09:13
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `klaxon`
--

-- --------------------------------------------------------

--
-- Structure de la table `agence`
--

CREATE TABLE `agence` (
  `id_agence` int(10) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `agence`
--

INSERT INTO `agence` (`id_agence`, `nom`) VALUES
(8, 'Bordeaux'),
(9, 'Lille'),
(2, 'Lyon'),
(7, 'Montpellier'),
(5, 'Nantes'),
(4, 'Nice'),
(1, 'Paris'),
(11, 'Reims'),
(10, 'Rennes'),
(6, 'Strasbourg'),
(3, 'Toulouse');

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `id_employe` int(10) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id_employe`, `nom`, `prenom`, `email`, `telephone`, `mot_de_passe`, `role`) VALUES
(1, 'Martin', 'Alexandre', 'alexandre.martin@email.fr', '0612345678', '', 'user'),
(2, 'Dubois', 'Sophie', 'sophie.dubois@email.fr', '0698765432', '', 'user'),
(3, 'Bernard', 'Julien', 'julien.bernard@email.fr', '0622446688', '', 'user'),
(4, 'Moreau', 'Camille', 'camille.moreau@email.fr', '0611223344', '', 'user'),
(5, 'Lefèvre', 'Lucie', 'lucie.lefevre@email.fr', '0777889900', '', 'user'),
(6, 'Leroy', 'Thomas', 'thomas.leroy@email.fr', '0655443322', '', 'user'),
(7, 'Roux', 'Chloé', 'chloe.roux@email.fr', '0633221199', '', 'user'),
(8, 'Petit', 'Maxime', 'maxime.petit@email.fr', '0766778899', '', 'user'),
(9, 'Garnier', 'Laura', 'laura.garnier@email.fr', '0688776655', '', 'user'),
(10, 'Dupuis', 'Antoine', 'antoine.dupuis@email.fr', '0744556677', '', 'user'),
(11, 'Lefebvre', 'Emma', 'emma.lefebvre@email.fr', '0699887766', '', 'user'),
(12, 'Fontaine', 'Louis', 'louis.fontaine@email.fr', '0655667788', '', 'user'),
(13, 'Chevalier', 'Clara', 'clara.chevalier@email.fr', '0788990011', '', 'user'),
(14, 'Robin', 'Nicolas', 'nicolas.robin@email.fr', '0644332211', '', 'user'),
(15, 'Gauthier', 'Marine', 'marine.gauthier@email.fr', '0677889922', '', 'user'),
(16, 'Fournier', 'Pierre', 'pierre.fournier@email.fr', '0722334455', '', 'user'),
(17, 'Girard', 'Sarah', 'sarah.girard@email.fr', '0688665544', '', 'user'),
(18, 'Lambert', 'Hugo', 'hugo.lambert@email.fr', '0611223366', '', 'user'),
(19, 'Masson', 'Julie', 'julie.masson@email.fr', '0733445566', '', 'user'),
(20, 'Henry', 'Arthur', 'arthur.henry@email.fr', '0666554433', '', 'user');

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

CREATE TABLE `trajet` (
  `id_trajet` int(10) UNSIGNED NOT NULL,
  `gdh_depart` datetime NOT NULL,
  `gdh_arrivee` datetime NOT NULL,
  `nb_places_total` tinyint(3) UNSIGNED NOT NULL,
  `nb_places_dispo` tinyint(3) UNSIGNED NOT NULL,
  `id_employe` int(10) UNSIGNED NOT NULL,
  `id_agence_depart` int(10) UNSIGNED NOT NULL,
  `id_agence_arrivee` int(10) UNSIGNED NOT NULL
) ;

--
-- Déchargement des données de la table `trajet`
--

INSERT INTO `trajet` (`id_trajet`, `gdh_depart`, `gdh_arrivee`, `nb_places_total`, `nb_places_dispo`, `id_employe`, `id_agence_depart`, `id_agence_arrivee`) VALUES
(1, '2026-04-09 09:06:17', '2026-04-09 11:06:17', 4, 3, 2, 1, 2),
(2, '2026-04-10 09:06:17', '2026-04-10 12:06:17', 3, 2, 3, 2, 3),
(3, '2026-04-11 09:06:17', '2026-04-11 13:06:17', 5, 4, 4, 1, 4),
(4, '2026-04-12 09:06:17', '2026-04-12 10:06:17', 2, 1, 5, 5, 6),
(5, '2026-04-13 09:06:17', '2026-04-13 12:06:17', 4, 2, 6, 6, 7),
(6, '2026-04-14 09:06:17', '2026-04-14 14:06:17', 3, 3, 2, 8, 1),
(7, '2026-04-15 09:06:17', '2026-04-15 11:06:17', 2, 0, 3, 3, 4),
(8, '2026-04-06 09:06:17', '2026-04-06 11:06:17', 4, 2, 4, 1, 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agence`
--
ALTER TABLE `agence`
  ADD PRIMARY KEY (`id_agence`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id_employe`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD PRIMARY KEY (`id_trajet`),
  ADD KEY `fk_trajet_employe` (`id_employe`),
  ADD KEY `fk_trajet_agence_depart` (`id_agence_depart`),
  ADD KEY `fk_trajet_agence_arrivee` (`id_agence_arrivee`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agence`
--
ALTER TABLE `agence`
  MODIFY `id_agence` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `id_employe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
  MODIFY `id_trajet` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD CONSTRAINT `fk_trajet_agence_arrivee` FOREIGN KEY (`id_agence_arrivee`) REFERENCES `agence` (`id_agence`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trajet_agence_depart` FOREIGN KEY (`id_agence_depart`) REFERENCES `agence` (`id_agence`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trajet_employe` FOREIGN KEY (`id_employe`) REFERENCES `employe` (`id_employe`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
