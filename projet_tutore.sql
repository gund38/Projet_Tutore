-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Sam 10 Août 2013 à 10:25
-- Version du serveur: 5.5.31
-- Version de PHP: 5.3.10-1ubuntu3.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `projet_tutore`
--

-- --------------------------------------------------------

--
-- Structure de la table `Departement`
--

DROP TABLE IF EXISTS `Departement`;
CREATE TABLE IF NOT EXISTS `Departement` (
  `codeDe` int(3) NOT NULL,
  `nom` varchar(60) NOT NULL,
  `codePostal` varchar(3) NOT NULL,
  PRIMARY KEY (`codeDe`),
  UNIQUE KEY `codePostal` (`codePostal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Departement`
--

INSERT INTO `Departement` (`codeDe`, `nom`, `codePostal`) VALUES
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
(100, 'La Réunion', '974'),
(101, 'Mayotte', '976');

-- --------------------------------------------------------

--
-- Structure de la table `Diplome`
--

DROP TABLE IF EXISTS `Diplome`;
CREATE TABLE IF NOT EXISTS `Diplome` (
  `codeDi` int(8) NOT NULL AUTO_INCREMENT,
  `codePe` int(8) NOT NULL,
  `visibilite` tinyint(1) NOT NULL DEFAULT '0',
  `annee` int(4) DEFAULT NULL,
  `type` enum('BTS','IUT','Licence','Master','Ingénieur','Doctorat') NOT NULL,
  `discipline` varchar(30) DEFAULT NULL,
  `etablissement` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`codeDi`),
  KEY `codePe` (`codePe`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `Diplome`
--

INSERT INTO `Diplome` (`codeDi`, `codePe`, `visibilite`, `annee`, `type`, `discipline`, `etablissement`) VALUES
(2, 4, 0, 2012, 'Licence', 'Informatique', 'UFR Sciences, UPPA, Pau'),
(3, 4, 1, 2014, 'Master', 'Technologie de l&#39;Internet', 'UFR Sciences, UPPA, Pau'),
(4, 4, 1, 2011, 'IUT', 'Informatique', 'IUT de Bayonne, UPPA, Anglet');

-- --------------------------------------------------------

--
-- Structure de la table `ExpPro`
--

DROP TABLE IF EXISTS `ExpPro`;
CREATE TABLE IF NOT EXISTS `ExpPro` (
  `codeEP` int(8) NOT NULL AUTO_INCREMENT,
  `codePe` int(8) NOT NULL,
  `visibilite` tinyint(1) NOT NULL DEFAULT '0',
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `enCours` tinyint(1) NOT NULL DEFAULT '0',
  `intitule` varchar(30) DEFAULT NULL,
  `entreprise` varchar(30) DEFAULT NULL,
  `ville` varchar(30) DEFAULT NULL,
  `departement` int(3) NOT NULL,
  `salaire` enum('Ne souhaite pas répondre','Inférieur à 20 000 €','Entre 20 000 € et 25 000 €','Entre 25 000 € et 30 000 €','Entre 30 000 € et 35 000 €','Entre 35 000 € et 40 000 €','Entre 40 000 € et 45 000 €','Supérieur à 45 000 €') DEFAULT NULL,
  `visibiliteSalaire` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codeEP`),
  KEY `departement` (`departement`),
  KEY `codePe` (`codePe`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `ExpPro`
--

INSERT INTO `ExpPro` (`codeEP`, `codePe`, `visibilite`, `dateDebut`, `dateFin`, `enCours`, `intitule`, `entreprise`, `ville`, `departement`, `salaire`, `visibiliteSalaire`) VALUES
(2, 4, 1, '2011-04-20', '2011-06-11', 0, 'Développeur Web Stagiaire', 'A.T.I.', 'Bayonne', 65, 'Entre 35 000 € et 40 000 €', 0),
(3, 4, 1, '2013-02-11', '0000-00-00', 1, 'Développeur Web', 'UPPA', 'Pau', 65, 'Ne souhaite pas répondre', 1);

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
  `intitule` varchar(50) NOT NULL,
  `entreprise` varchar(30) NOT NULL,
  `ville` varchar(30) NOT NULL,
  `departement` int(3) NOT NULL,
  `remuneration` float NOT NULL,
  `cheminPDF` varchar(30) NOT NULL,
  PRIMARY KEY (`codeO`),
  KEY `codePe` (`codePe`),
  KEY `departement` (`departement`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `Offre`
--

INSERT INTO `Offre` (`codeO`, `codePe`, `dateDepot`, `type`, `intitule`, `entreprise`, `ville`, `departement`, `remuneration`, `cheminPDF`) VALUES
(7, 4, '2013-04-14 15:26:55', 'Stage', 'Développeur Java / C++', 'Google', 'Bayonne', 65, 2500, '516acabf55bf8.pdf'),
(8, 4, '2013-04-14 15:27:50', 'Emploi', 'Administrateur en base de données', 'Dassault', 'Toulouse', 32, 3500, '516acaf653c6a.pdf'),
(9, 4, '2013-05-09 18:01:06', 'Stage', 'Création de site web', 'UFR Sciences, UPPA', 'Pau', 65, 1337.42, '518be4623a80a.pdf'),
(10, 4, '2013-05-19 12:27:34', 'Emploi', 'Web Designer', 'Google', 'Paris', 76, 3500, '5198c5360472b.pdf'),
(11, 4, '2013-05-19 12:34:45', 'Emploi', 'Ingénieur en Tests Unitaires', 'Orange', 'Nice', 6, 2790.37, '5198c6e5db3b3.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `Personne`
--

DROP TABLE IF EXISTS `Personne`;
CREATE TABLE IF NOT EXISTS `Personne` (
  `codePe` int(8) NOT NULL AUTO_INCREMENT,
  `type` enum('Administrateur','Ancien_etudiant','Enseignant','Etudiant') NOT NULL,
  `compteValide` tinyint(1) NOT NULL DEFAULT '0',
  `prenom` varchar(30) NOT NULL,
  `nom` varchar(30) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `login` varchar(30) NOT NULL,
  `mdp` varchar(30) NOT NULL,
  PRIMARY KEY (`codePe`),
  UNIQUE KEY `login_unique` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `Personne`
--

INSERT INTO `Personne` (`codePe`, `type`, `compteValide`, `prenom`, `nom`, `email`, `login`, `mdp`) VALUES
(1, 'Etudiant', 1, 'Nicolas', 'Dubois', 'DU@gmail.com', 'DU', 'chemise'),
(2, 'Enseignant', 1, 'Annig', 'Lacayrelle', 'BD@gmail.com', 'Lacayrelle', 'bd'),
(3, 'Administrateur', 1, 'Nicolas', 'Belloir', 'UML@gmail.com', 'Belloir', 'uml'),
(4, 'Ancien_etudiant', 1, 'Kévin', 'Bélellou', 'polo@gmail.com', 'polo', 'marco'),
(5, 'Ancien_etudiant', 1, 'Maxime', 'Tchoupi', 'maxime.tchoupi@gmail.com', 'mtchoupi', 'mtchoupi'),
(6, 'Ancien_etudiant', 1, 'Kévin', 'Pringles', 'kpringles@gmail.com', 'kpringles', 'kpringles');

-- --------------------------------------------------------

--
-- Structure de la table `Profil`
--

DROP TABLE IF EXISTS `Profil`;
CREATE TABLE IF NOT EXISTS `Profil` (
  `codePe` int(8) NOT NULL,
  `promo` int(4) NOT NULL,
  `diplomeMaster` tinyint(1) NOT NULL DEFAULT '0',
  `visibiliteEmail` tinyint(1) NOT NULL DEFAULT '0',
  `dateNaissance` date DEFAULT NULL,
  `visibiliteDateNaissance` tinyint(1) NOT NULL DEFAULT '0',
  `cheminPhoto` varchar(30) DEFAULT NULL,
  `visibilitePhoto` tinyint(1) NOT NULL DEFAULT '0',
  `pagePerso` varchar(30) DEFAULT NULL,
  `visibilitePagePerso` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`codePe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Profil`
--

INSERT INTO `Profil` (`codePe`, `promo`, `diplomeMaster`, `visibiliteEmail`, `dateNaissance`, `visibiliteDateNaissance`, `cheminPhoto`, `visibilitePhoto`, `pagePerso`, `visibilitePagePerso`) VALUES
(4, 2014, 1, 1, '1990-04-04', 0, 'photo_profil_default.jpg', 0, 'http://www.google.fr', 1),
(5, 2012, 1, 0, NULL, 0, NULL, 0, NULL, 0),
(6, 2011, 0, 0, NULL, 0, NULL, 0, NULL, 0);

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
  ADD CONSTRAINT `ExpPro_ibfk_1` FOREIGN KEY (`codePe`) REFERENCES `Personne` (`codePe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ExpPro_ibfk_2` FOREIGN KEY (`departement`) REFERENCES `Departement` (`codeDe`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `Offre`
--
ALTER TABLE `Offre`
  ADD CONSTRAINT `Offre_ibfk_1` FOREIGN KEY (`codePe`) REFERENCES `Personne` (`codePe`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Offre_ibfk_2` FOREIGN KEY (`departement`) REFERENCES `Departement` (`codeDe`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `Profil`
--
ALTER TABLE `Profil`
  ADD CONSTRAINT `Profil_ibfk_1` FOREIGN KEY (`codePe`) REFERENCES `Personne` (`codePe`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
