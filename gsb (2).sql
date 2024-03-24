-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 24 mars 2024 à 11:59
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
-- Base de données : `gsb`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id_commande` int(11) NOT NULL,
  `id_utilisateur` int(11) DEFAULT NULL,
  `date_commande` datetime DEFAULT current_timestamp(),
  `statut` enum('en_attente','validee','invalidée') DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `demandes_commandes`
--

CREATE TABLE `demandes_commandes` (
  `id_demande` int(11) NOT NULL,
  `id_stock` int(11) DEFAULT NULL,
  `quantite_demandee` int(11) DEFAULT NULL,
  `date_demande` datetime DEFAULT current_timestamp(),
  `statut` enum('en_attente','validee','rejetee') DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `demandes_commandes`
--

INSERT INTO `demandes_commandes` (`id_demande`, `id_stock`, `quantite_demandee`, `date_demande`, `statut`) VALUES
(2, 1, 1, '2024-03-23 19:44:28', 'validee'),
(9, 2, 1, '2024-03-23 20:03:38', 'validee'),
(10, 1, 2, '2024-03-23 20:46:52', 'validee'),
(11, 4, 4, '2024-03-23 20:53:02', 'en_attente'),
(12, 5, 1, '2024-03-23 21:11:30', 'en_attente');

-- --------------------------------------------------------

--
-- Structure de la table `mouvements`
--

CREATE TABLE `mouvements` (
  `id_mouvement` int(11) NOT NULL,
  `id_stock` int(11) DEFAULT NULL,
  `type_mouvement` enum('entree','sortie') DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `date_mouvement` datetime DEFAULT current_timestamp(),
  `id_commande` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `mouvements`
--

INSERT INTO `mouvements` (`id_mouvement`, `id_stock`, `type_mouvement`, `quantite`, `date_mouvement`, `id_commande`) VALUES
(1, 5, 'entree', 4, '2024-03-23 21:09:31', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `pseudo` int(11) NOT NULL,
  `mdp` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  `rr` int(11) NOT NULL,
  `idrr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `nom_role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id_role`, `nom_role`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'Super-admin');

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

CREATE TABLE `stocks` (
  `id_stock` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantite_disponible` int(11) DEFAULT NULL,
  `type` enum('medicament','materiel') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stocks`
--

INSERT INTO `stocks` (`id_stock`, `nom`, `description`, `quantite_disponible`, `type`) VALUES
(1, 'smecta', 'pour les maux de ventre ', 50, 'medicament'),
(2, 'brosse a dent', 'souple ', 4, 'materiel'),
(4, 'brique', 'yftydytd', 7, 'materiel'),
(5, 'Paracétamol', ' Antalgique • Antipyrétique', 4, 'medicament');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `email`, `mot_de_passe`, `id_role`) VALUES
(7, 'superadm', NULL, 'caca@gmail.com', '$2y$10$7R0Z03YIe7QLHVHPo7d7nuqUeyYooRXxLeOUCJ1kTPgcBmpMWwmcW', 3),
(11, 'adm', NULL, 'adm@adm', '$2y$10$RkBgLu90cF8mxW4dspKsG.Se3xD03mRuQiwm1H85WkJSg85w.Wi1G', 1),
(13, '1', NULL, '1@1', '$2y$10$Yw/EpSzgNBOkSXaIq1V52.VNqqofHZ8HtScPXhW76OeMlK8I9p5sm', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `demandes_commandes`
--
ALTER TABLE `demandes_commandes`
  ADD PRIMARY KEY (`id_demande`),
  ADD KEY `id_stock` (`id_stock`);

--
-- Index pour la table `mouvements`
--
ALTER TABLE `mouvements`
  ADD PRIMARY KEY (`id_mouvement`),
  ADD KEY `id_stock` (`id_stock`),
  ADD KEY `id_commande` (`id_commande`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id_stock`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `demandes_commandes`
--
ALTER TABLE `demandes_commandes`
  MODIFY `id_demande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `mouvements`
--
ALTER TABLE `mouvements`
  MODIFY `id_mouvement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `demandes_commandes`
--
ALTER TABLE `demandes_commandes`
  ADD CONSTRAINT `demandes_commandes_ibfk_1` FOREIGN KEY (`id_stock`) REFERENCES `stocks` (`id_stock`);

--
-- Contraintes pour la table `mouvements`
--
ALTER TABLE `mouvements`
  ADD CONSTRAINT `mouvements_ibfk_1` FOREIGN KEY (`id_stock`) REFERENCES `stocks` (`id_stock`),
  ADD CONSTRAINT `mouvements_ibfk_2` FOREIGN KEY (`id_commande`) REFERENCES `commandes` (`id_commande`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
