-- phpMyAdmin SQL Dump
-- version 4.2.0
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 21 Janvier 2016 à 11:02
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `ribs`
--

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE IF NOT EXISTS `cache` (
`ID_cache` int(11) NOT NULL,
  `nom_fichier` varchar(255) NOT NULL,
  `reload_cache` int(11) DEFAULT NULL,
  `no_cache` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
`ID_configuration` int(11) NOT NULL,
  `nom_site` varchar(255) NOT NULL,
  `mail_site` varchar(255) NOT NULL,
  `gerant_site` varchar(255) NOT NULL,
  `url_site` varchar(255) NOT NULL,
  `mail_administrateur` varchar(255) NOT NULL,
  `last_save` date DEFAULT NULL,
  `acces_admin` int(1) DEFAULT '1',
  `contenu_dynamique` int(1) DEFAULT '1',
  `responsive` int(1) DEFAULT NULL,
  `cache` int(1) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `configuration`
--

INSERT INTO `configuration` (`ID_configuration`, `nom_site`, `mail_site`, `gerant_site`, `url_site`, `mail_administrateur`, `last_save`, `acces_admin`, `contenu_dynamique`) VALUES
(1, 'MVC', 'mvc@mvc.com', 'kiki ouioui', 'http://127.0.0.1/plugins/NEW_MVC/', 'web@clicand.com', '2016-01-21', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `configuration_compte`
--

CREATE TABLE IF NOT EXISTS `configuration_compte` (
`ID_configuration_compte` int(11) NOT NULL,
  `valider_inscription` int(1) DEFAULT NULL,
  `activer_inscription` int(1) DEFAULT NULL,
  `activer_connexion` int(1) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `configuration_compte`
--

INSERT INTO `configuration_compte` (`ID_configuration_compte`, `valider_inscription`, `activer_inscription`, `activer_connexion`) VALUES
(1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `droit_acces`
--

CREATE TABLE IF NOT EXISTS `droit_acces` (
`ID_droit_acces` int(11) NOT NULL,
  `droit_acces` varchar(255) DEFAULT NULL,
  `page` varchar(255) DEFAULT NULL,
  `nom_module` varchar(255) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Contenu de la table `droit_acces`
--

INSERT INTO `droit_acces` (`ID_droit_acces`, `droit_acces`, `page`, `actif`) VALUES
(1, 'GESTION COMPTES', 'gestion-comptes/index', 1),
(2, 'GESTION DROIT ACCES', 'gestion-droits-acces/index', 1),
(3, 'GESTION COMPTES ADMIN', NULL, 1),
(4, 'GESTION CONTENUS', 'gestion-contenus/index,gestion-contenus/modifier-contenu,gestion-contenus/creer-une-page', 1),
(5, 'CREATION PAGE', 'gestion-contenus/creer-une-page', 1),
(7, 'GESTION CONTENU PAGE', NULL, 1),
(8, 'CREATION COMPTE ADMIN', 'gestion-comptes/index', '1');

-- --------------------------------------------------------

--
-- Structure de la table `droit_acces_page`
--

CREATE TABLE IF NOT EXISTS `droit_acces_page` (
`ID_droit_acces_page` int(11) NOT NULL,
  `ID_page` int(11) NOT NULL,
  `seo` int(11) DEFAULT NULL,
  `contenu` int(11) DEFAULT NULL,
  `navigation` int(11) DEFAULT NULL,
  `supprimer` int(11) DEFAULT NULL,
  `ID_liste_droit_acces` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `identite`
--

CREATE TABLE IF NOT EXISTS `identite` (
`ID_identite` int(11) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `nom` varchar(200) DEFAULT NULL,
  `prenom` varchar(255) NOT NULL,
  `mail` varchar(150) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `mdp_params` varchar(255) DEFAULT NULL,
  `last_change_mdp` date NOT NULL,
  `img_profil` varchar(255) NOT NULL,
  `img_profil_blog` varchar(255) DEFAULT NULL,
  `valide` int(11) DEFAULT NULL,
  `archiver` int(11) DEFAULT NULL,
  `acces_admin` int(11) DEFAULT NULL,
  `liste_droit` int(11) DEFAULT NULL,
  `super_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `identite`
--

INSERT INTO `identite` (`ID_identite`, `pseudo`, `nom`, `prenom`, `mail`, `mdp`, `mdp_params`, `last_change_mdp`, `img_profil`, `img_profil_blog`, `valide`, `acces_admin`, `liste_droit`, `super_admin`) VALUES
(1, 'adminclicandcom', 'admin', 'admin', NULL, 'y5zlsrif018ltajtjd8le9e5rkd0a29v3kdivmunz3e3lpiqca64xm9z5c33r6sdb57e7eeba9fefab7azveth658f1647671e152a8v1cfshakl867dizzjmvn529dvmc7123h1ycsfgvqpz93l72sb7kj6gbubtpm36wueyjzuaeqik321rcn2m9', '16, 86, 10, 16, 65, vl7wkz7sqq6x8ks0y602', '2016-01-20', 'profil/defaut.png', 'profil/defaut_blog.png', 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `liaison_liste_droit`
--

CREATE TABLE IF NOT EXISTS `liaison_liste_droit` (
`liaison_liste_droit` int(11) NOT NULL,
  `ID_droit_acces` int(11) NOT NULL,
  `ID_liste_droit_acces` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `liste_droit_acces`
--

CREATE TABLE IF NOT EXISTS `liste_droit_acces` (
`ID_liste_droit_acces` int(11) NOT NULL,
  `nom_liste` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
`ID_module` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `nom_module` varchar(255) NOT NULL,
  `version` varchar(15) NOT NULL,
  `online_version` varchar(15) DEFAULT NULL,
  `next_check_version` date DEFAULT NULL,
  `activer` int(1) NOT NULL,
  `installer` int(1) NOT NULL,
  `mettre_jour` int(1) DEFAULT NULL,
  `systeme` int(1) DEFAULT NULL,
  `icone` varchar(255) DEFAULT NULL,
  `url_telechargement` varchar(255) NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `module`
--

INSERT INTO `module` (`ID_module`, `url`, `nom_module`, `version`,  `activer`, `installer`, `systeme`, `icone`, `url_telechargement`) VALUES
(1, 'livre_or/', 'livre d''or', '1.0', 0, 0, 1, 'fa-book', 'http://library.clicand.com/livre_or.zip'),
(2, 'blog/', 'blog', '1.0', 0, 0, 1, 'fa-newspaper-o', 'http://library.clicand.com/blog.zip'),
(3, 'galerie_photo/', 'galerie photo', '1.0', 0, 0, 1, 'fa-photo', 'http://library.clicand.com/galerie_photo.zip');

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
`ID_page` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `contenu` longtext,
  `url` varchar(92) DEFAULT NULL,
  `meta_description` varchar(160) DEFAULT NULL,
  `balise_title` varchar(70) DEFAULT NULL,
  `ordre` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `affiche` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `page`
--

INSERT INTO `page` (`ID_page`, `titre`, `contenu`, `url`, `meta_description`, `balise_title`, `ordre`, `parent`, `affiche`) VALUES
(1, 'Accueil', 'Accueil du site', '', 'Accueil de mon site', 'Accueil de mon site', 1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
`ID_notification` int(11) NOT NULL,
  `admin` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `notification` (`ID_notification`, `admin`) VALUES ('1', '0');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
 ADD PRIMARY KEY (`ID_cache`);

--
-- Index pour la table `configuration`
--
ALTER TABLE `configuration`
 ADD PRIMARY KEY (`ID_configuration`);

--
-- Index pour la table `configuration_compte`
--
ALTER TABLE `configuration_compte`
 ADD PRIMARY KEY (`ID_configuration_compte`);

--
-- Index pour la table `droit_acces`
--
ALTER TABLE `droit_acces`
 ADD PRIMARY KEY (`ID_droit_acces`);

--
-- Index pour la table `droit_acces_page`
--
ALTER TABLE `droit_acces_page`
 ADD PRIMARY KEY (`ID_droit_acces_page`);

--
-- Index pour la table `identite`
--
ALTER TABLE `identite`
 ADD PRIMARY KEY (`ID_identite`);

--
-- Index pour la table `liaison_liste_droit`
--
ALTER TABLE `liaison_liste_droit`
 ADD PRIMARY KEY (`liaison_liste_droit`);

--
-- Index pour la table `liste_droit_acces`
--
ALTER TABLE `liste_droit_acces`
 ADD PRIMARY KEY (`ID_liste_droit_acces`);

--
-- Index pour la table `module`
--
ALTER TABLE `module`
 ADD PRIMARY KEY (`ID_module`);

--
-- Index pour la table `page`
--
ALTER TABLE `page`
 ADD PRIMARY KEY (`ID_page`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
 ADD PRIMARY KEY (`ID_notification`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `cache`
--
ALTER TABLE `cache`
MODIFY `ID_cache` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `configuration`
--
ALTER TABLE `configuration`
MODIFY `ID_configuration` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `configuration_compte`
--
ALTER TABLE `configuration_compte`
MODIFY `ID_configuration_compte` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `droit_acces`
--
ALTER TABLE `droit_acces`
MODIFY `ID_droit_acces` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `droit_acces_page`
--
ALTER TABLE `droit_acces_page`
MODIFY `ID_droit_acces_page` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `identite`
--
ALTER TABLE `identite`
MODIFY `ID_identite` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `liaison_liste_droit`
--
ALTER TABLE `liaison_liste_droit`
MODIFY `liaison_liste_droit` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `liste_droit_acces`
--
ALTER TABLE `liste_droit_acces`
MODIFY `ID_liste_droit_acces` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `module`
--
ALTER TABLE `module`
MODIFY `ID_module` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `page`
--
ALTER TABLE `page`
MODIFY `ID_page` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
MODIFY `ID_notification` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
