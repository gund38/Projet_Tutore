-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Sam 23 Mars 2013 à 19:51
-- Version du serveur: 5.1.66
-- Version de PHP: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `projet_tutore`
--

-- --------------------------------------------------------

--
-- Structure de la table `Diplome`
--

DROP TABLE IF EXISTS `Diplome`;
CREATE TABLE IF NOT EXISTS `Diplome` (
  `codeDi` int(8) NOT NULL AUTO_INCREMENT,
  `codePe` int(8) NOT NULL,
  `visibilite` tinyint(1) NOT NULL,
  `annee` int(4) NOT NULL,
  `type` enum('Licence','Master') NOT NULL,
  `discipline` varchar(30) NOT NULL,
  `etablissement` varchar(30) NOT NULL,
  PRIMARY KEY (`codeDi`),
  KEY `codePe` (`codePe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Diplome`
--


-- --------------------------------------------------------

--
-- Structure de la table `ExpPro`
--

DROP TABLE IF EXISTS `ExpPro`;
CREATE TABLE IF NOT EXISTS `ExpPro` (
  `codeEP` int(8) NOT NULL AUTO_INCREMENT,
  `codePe` int(8) NOT NULL,
  `visibilite` tinyint(1) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date DEFAULT NULL,
  `enCours` tinyint(1) NOT NULL,
  `intitule` varchar(30) NOT NULL,
  `entreprise` varchar(30) NOT NULL,
  `ville` varchar(30) NOT NULL,
  `departement` int(3) NOT NULL,
  `salaire` enum('< 5000','>2000000000') NOT NULL,
  `visibiliteSalaire` tinyint(1) NOT NULL,
  PRIMARY KEY (`codeEP`),
  KEY `departement` (`departement`),
  KEY `codePe` (`codePe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `ExpPro`
--


-- --------------------------------------------------------

--
-- Structure de la table `ListeDepartement`
--

DROP TABLE IF EXISTS `ListeDepartement`;
CREATE TABLE IF NOT EXISTS `ListeDepartement` (
  `codeDe` int(3) NOT NULL,
  `Nom` varchar(60) NOT NULL,
  `codePostal` varchar(3) NOT NULL,
  PRIMARY KEY (`codeDe`),
  UNIQUE KEY `codePostal` (`codePostal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ListeDepartement`
--

INSERT INTO `ListeDepartement` (`codeDe`, `Nom`, `codePostal`) VALUES
(1, 'Ain', '01'),
(2, 'Aisne', '02'),
(3, 'Allier', '03'),
(4, 'Alpes-de-Haute-Provence', '04'),
(5, 'Hautes-Alpes', '05'),
(6, 'Alpes-Maritimes', '06'),
(7, 'Ardèche', '07'),
(8, 'Ardennes', '08'),
(9, 'Ariège', '09'),
(10, 'Aube', '10'),
(11, 'Aude', '11'),
(12, 'Aveyron', '12'),
(13, 'Bouches-du-Rhône', '13'),
(14, 'Calvados', '14'),
(15, 'Cantal', '15'),
(16, 'Charente', '16'),
(17, 'Charente-Maritime', '17'),
(18, 'Cher', '18'),
(19, 'Corrèze', '19'),
(20, 'Corse-du-Sud', '2A'),
(21, 'Haute-Corse', '2B'),
(22, 'Côte-d''Or', '21'),
(23, 'Côtes-d''Armor', '22'),
(24, 'Creuse', '23'),
(25, 'Dordogne', '24'),
(26, 'Doubs', '25'),
(27, 'Drôme', '26'),
(28, 'Eure', '27'),
(29, 'Eure-et-Loir', '28'),
(30, 'Finistère', '29'),
(31, 'Gard', '30'),
(32, 'Haute-Garonne', '31'),
(33, 'Gers', '32'),
(34, 'Gironde', '33'),
(35, 'Hérault', '34'),
(36, 'Ille-et-Vilaine', '35'),
(37, 'Indre', '36'),
(38, 'Indre-et-Loire', '37'),
(39, 'Isère', '38'),
(40, 'Jura', '39'),
(41, 'Landes', '40'),
(42, 'Loir-et-Cher', '41'),
(43, 'Loire', '42'),
(44, 'Haute-Loire', '43'),
(45, 'Loire-Atlantique', '44'),
(46, 'Loiret', '45'),
(47, 'Lot', '46'),
(48, 'Lot-et-Garonne', '47'),
(49, 'Lozère', '48'),
(50, 'Maine-et-Loire', '49'),
(51, 'Manche', '50'),
(52, 'Marne', '51'),
(53, 'Haute-Marne', '52'),
(54, 'Mayenne', '53'),
(55, 'Meurthe-et-Moselle', '54'),
(56, 'Meuse', '55'),
(57, 'Morbihan', '56'),
(58, 'Moselle', '57'),
(59, 'Nièvre', '58'),
(60, 'Nord', '59'),
(61, 'Oise', '60'),
(62, 'Orne', '61'),
(63, 'Pas-de-Calais', '62'),
(64, 'Puy-de-Dôme', '63'),
(65, 'Pyrénées-Atlantiques', '64'),
(66, 'Hautes-Pyrénées', '65'),
(67, 'Pyrénées-Orientales', '66'),
(68, 'Bas-Rhin', '67'),
(69, 'Haut-Rhin', '68'),
(70, 'Rhône', '69'),
(71, 'Haute-Saône', '70'),
(72, 'Saône-et-Loire', '71'),
(73, 'Sarthe', '72'),
(74, 'Savoie', '73'),
(75, 'Haute-Savoie', '74'),
(76, 'Paris', '75'),
(77, 'Seine-Maritime', '76'),
(78, 'Seine-et-Marne', '77'),
(79, 'Yvelines', '78'),
(80, 'Deux-Sèvres', '79'),
(81, 'Somme', '80'),
(82, 'Tarn', '81'),
(83, 'Tarn-et-Garonne', '82'),
(84, 'Var', '83'),
(85, 'Vaucluse', '84'),
(86, 'Vendée', '85'),
(87, 'Vienne', '86'),
(88, 'Haute-Vienne', '87'),
(89, 'Vosges', '88'),
(90, 'Yonne', '89'),
(91, 'Territoire de Belfort', '90'),
(92, 'Essonne', '91'),
(93, 'Hauts-de-Seine', '92'),
(94, 'Seine-Saint-Denis', '93'),
(95, 'Val-de-Marne', '94'),
(96, 'Val-d''Oise', '95'),
(97, 'Guadeloupe', '971'),
(98, 'Martinique', '972'),
(99, 'Guyane', '973'),
(100, 'La Réunion', '974');

-- --------------------------------------------------------

--
-- Structure de la table `Offre`
--

DROP TABLE IF EXISTS `Offre`;
CREATE TABLE IF NOT EXISTS `Offre` (
  `codeO` int(8) NOT NULL AUTO_INCREMENT,
  `codePe` int(8) NOT NULL,
  `dateDepot` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` enum('Emploi','Stage') NOT NULL,
  `intitule` varchar(30) NOT NULL,
  `entreprise` varchar(30) NOT NULL,
  `ville` varchar(30) NOT NULL,
  `departement` int(3) NOT NULL,
  `remuneration` int(8) NOT NULL,
  `cheminPDF` varchar(30) NOT NULL,
  PRIMARY KEY (`codeO`),
  KEY `codePe` (`codePe`),
  KEY `departement` (`departement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Offre`
--


-- --------------------------------------------------------

--
-- Structure de la table `Personne`
--

DROP TABLE IF EXISTS `Personne`;
CREATE TABLE IF NOT EXISTS `Personne` (
  `codePe` int(8) NOT NULL AUTO_INCREMENT,
  `type` enum('Administrateur','Ancien_etudiant','Enseignant','Etudiant') NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `login` varchar(30) NOT NULL,
  `mdp` varchar(30) NOT NULL,
  PRIMARY KEY (`codePe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Personne`
--


-- --------------------------------------------------------

--
-- Structure de la table `Profil`
--

DROP TABLE IF EXISTS `Profil`;
CREATE TABLE IF NOT EXISTS `Profil` (
  `codePe` int(8) NOT NULL,
  `promo` int(4) NOT NULL,
  `visibiliteEmail` tinyint(1) NOT NULL,
  `dateNaissance` date NOT NULL,
  `visibiliteDateNaissance` tinyint(1) NOT NULL,
  `cheminPhoto` varchar(30) DEFAULT NULL,
  `visibilitePhoto` tinyint(1) NOT NULL,
  `pagePerso` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`codePe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Profil`
--


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Diplome`
--
ALTER TABLE `Diplome`
  ADD CONSTRAINT `Diplome_ibfk_1` FOREIGN KEY (`codePe`) REFERENCES `Personne` (`codePe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ExpPro`
--
ALTER TABLE `ExpPro`
  ADD CONSTRAINT `ExpPro_ibfk_2` FOREIGN KEY (`departement`) REFERENCES `ListeDepartement` (`codeDe`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `ExpPro_ibfk_1` FOREIGN KEY (`codePe`) REFERENCES `Personne` (`codePe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Offre`
--
ALTER TABLE `Offre`
  ADD CONSTRAINT `Offre_ibfk_2` FOREIGN KEY (`departement`) REFERENCES `ListeDepartement` (`codeDe`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Offre_ibfk_1` FOREIGN KEY (`codePe`) REFERENCES `Personne` (`codePe`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `Profil`
--
ALTER TABLE `Profil`
  ADD CONSTRAINT `Profil_ibfk_1` FOREIGN KEY (`codePe`) REFERENCES `Personne` (`codePe`) ON DELETE CASCADE ON UPDATE CASCADE;
