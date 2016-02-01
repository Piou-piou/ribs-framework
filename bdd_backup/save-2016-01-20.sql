-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: 127.0.0.1	Database: ribs
-- ------------------------------------------------------
-- Server version 	5.5.25a-log
-- Date: Wed, 20 Jan 2016 18:52:27 +0100

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `ID_cache` int(11) NOT NULL AUTO_INCREMENT,
  `nom_fichier` varchar(255) NOT NULL,
  `reload_cache` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_cache`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `configuration`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuration` (
  `ID_configuration` int(11) NOT NULL,
  `nom_site` varchar(255) NOT NULL,
  `mail_site` varchar(255) NOT NULL,
  `gerant_site` varchar(255) NOT NULL,
  `url_site` varchar(255) NOT NULL,
  `mail_administrateur` varchar(255) NOT NULL,
  `last_save` date DEFAULT NULL,
  `acces_admin` int(1) DEFAULT '1',
  `contenu_dynamique` int(1) DEFAULT '1',
  `responsive` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuration`
--

LOCK TABLES `configuration` WRITE;
/*!40000 ALTER TABLE `configuration` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `configuration` VALUES (1,'MVC','mvc@mvc.com','kiki ouioui','http://127.0.0.1/plugins/NEW_MVC/','web@clicand.com','2015-09-02',1,1,NULL);
/*!40000 ALTER TABLE `configuration` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `configuration_compte`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuration_compte` (
  `ID_configuration_compte` int(11) NOT NULL,
  `valider_inscription` int(1) DEFAULT NULL,
  `activer_inscription` int(1) DEFAULT NULL,
  `activer_connexion` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuration_compte`
--

LOCK TABLES `configuration_compte` WRITE;
/*!40000 ALTER TABLE `configuration_compte` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `configuration_compte` VALUES (1,0,0,0);
/*!40000 ALTER TABLE `configuration_compte` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `droit_acces`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `droit_acces` (
  `ID_droit_acces` int(11) NOT NULL,
  `droit_acces` varchar(255) DEFAULT NULL,
  `page` varchar(255) DEFAULT NULL,
  `actif` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `droit_acces`
--

LOCK TABLES `droit_acces` WRITE;
/*!40000 ALTER TABLE `droit_acces` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `droit_acces` VALUES (1,'GESTION COMPTES','gestion-comptes/index',1),(2,'GESTION DROIT ACCES','gestion-droits-acces/index',1),(3,'GESTION COMPTES ADMIN',NULL,1),(4,'GESTION CONTENUS','gestion-contenus/index,gestion-contenus/modifier-contenu,gestion-contenus/creer-une-page',1),(5,'CREATION PAGE','gestion-contenus/creer-une-page',1),(7,'GESTION CONTENU PAGE',NULL,1),(9,'ACCES_ADMIN_BLOG','modules/blog/index,modules/blog/ajouter-article,modules/blog/liste-article,modules/blog/modifier-article,modules/blog/gestion-commentaire',1),(10,'AJOUTER_ARTICLE_BLOG','modules/livre-or/ajouter-article',1),(11,'MODIFIER_ARTICLE_BLOG','modules/livre-or/modifier-article',1),(12,'SUPPRIMER_ARTICLE_BLOG',NULL,1),(13,'GESTION COMMENTAIRE BLOG','modules/blog/gestion-commentaire',1),(14,'ACCES ADMIN LIVRE OR','modules/livre-or/index,modules/livre-or/ajouter-article,modules/livre-or/liste-article,modules/livre-or/gestion-commentaire,modules/livre-or/modifier-article',1),(15,'AJOUTER ARTICLE LIVRE OR','modules/livre-or/ajouter-article',1),(16,'MODIFIER ARTICLE LIVRE OR','modules/livre-or/modifier-article',1),(17,'SUPPRIMER ARTICLE LIVRE OR',NULL,1),(18,'GESTION COMMENTAIRE LIVRE OR','modules/livre-or/gestion-commentaire',1),(19,'GESTION GALERIE PHOTO','modules/galerie-photo/index,modules/galerie-photo/creer-album,modules/galerie-photo/modifier-album,modules/galerie-photo/gestion-image',1),(20,'CREER ALBUM GALERIE PHOTO',NULL,1),(21,'MODIFIER ALBUM GALERIE PHOTO',NULL,1),(22,'SUPPRIMER ALBUM GALERIE PHOTO',NULL,1),(23,'AJOUTER IMAGE GALERIE PHOTO',NULL,1),(24,'SUPPRIMER IMAGE GALERIE PHOTO',NULL,1),(1,'GESTION COMPTES','gestion-comptes/index',1),(2,'GESTION DROIT ACCES','gestion-droits-acces/index',1),(3,'GESTION COMPTES ADMIN',NULL,1),(4,'GESTION CONTENUS','gestion-contenus/index,gestion-contenus/modifier-contenu,gestion-contenus/creer-une-page',1),(5,'CREATION PAGE','gestion-contenus/creer-une-page',1),(7,'GESTION CONTENU PAGE',NULL,1),(9,'ACCES_ADMIN_BLOG','modules/blog/index,modules/blog/ajouter-article,modules/blog/liste-article,modules/blog/modifier-article,modules/blog/gestion-commentaire',1),(10,'AJOUTER_ARTICLE_BLOG','modules/livre-or/ajouter-article',1),(11,'MODIFIER_ARTICLE_BLOG','modules/livre-or/modifier-article',1),(12,'SUPPRIMER_ARTICLE_BLOG',NULL,1),(13,'GESTION COMMENTAIRE BLOG','modules/blog/gestion-commentaire',1),(14,'ACCES ADMIN LIVRE OR','modules/livre-or/index,modules/livre-or/ajouter-article,modules/livre-or/liste-article,modules/livre-or/gestion-commentaire,modules/livre-or/modifier-article',1),(15,'AJOUTER ARTICLE LIVRE OR','modules/livre-or/ajouter-article',1),(16,'MODIFIER ARTICLE LIVRE OR','modules/livre-or/modifier-article',1),(17,'SUPPRIMER ARTICLE LIVRE OR',NULL,1),(18,'GESTION COMMENTAIRE LIVRE OR','modules/livre-or/gestion-commentaire',1),(19,'GESTION GALERIE PHOTO','modules/galerie-photo/index,modules/galerie-photo/creer-album,modules/galerie-photo/modifier-album,modules/galerie-photo/gestion-image',1),(20,'CREER ALBUM GALERIE PHOTO',NULL,1),(21,'MODIFIER ALBUM GALERIE PHOTO',NULL,1),(22,'SUPPRIMER ALBUM GALERIE PHOTO',NULL,1),(23,'AJOUTER IMAGE GALERIE PHOTO',NULL,1),(24,'SUPPRIMER IMAGE GALERIE PHOTO',NULL,1),(1,'GESTION COMPTES','gestion-comptes/index',1),(2,'GESTION DROIT ACCES','gestion-droits-acces/index',1),(3,'GESTION COMPTES ADMIN',NULL,1),(4,'GESTION CONTENUS','gestion-contenus/index,gestion-contenus/modifier-contenu,gestion-contenus/creer-une-page',1),(5,'CREATION PAGE','gestion-contenus/creer-une-page',1),(7,'GESTION CONTENU PAGE',NULL,1),(9,'ACCES_ADMIN_BLOG','modules/blog/index,modules/blog/ajouter-article,modules/blog/liste-article,modules/blog/modifier-article,modules/blog/gestion-commentaire',1),(10,'AJOUTER_ARTICLE_BLOG','modules/livre-or/ajouter-article',1),(11,'MODIFIER_ARTICLE_BLOG','modules/livre-or/modifier-article',1),(12,'SUPPRIMER_ARTICLE_BLOG',NULL,1),(13,'GESTION COMMENTAIRE BLOG','modules/blog/gestion-commentaire',1),(14,'ACCES ADMIN LIVRE OR','modules/livre-or/index,modules/livre-or/ajouter-article,modules/livre-or/liste-article,modules/livre-or/gestion-commentaire,modules/livre-or/modifier-article',1),(15,'AJOUTER ARTICLE LIVRE OR','modules/livre-or/ajouter-article',1),(16,'MODIFIER ARTICLE LIVRE OR','modules/livre-or/modifier-article',1),(17,'SUPPRIMER ARTICLE LIVRE OR',NULL,1),(18,'GESTION COMMENTAIRE LIVRE OR','modules/livre-or/gestion-commentaire',1),(19,'GESTION GALERIE PHOTO','modules/galerie-photo/index,modules/galerie-photo/creer-album,modules/galerie-photo/modifier-album,modules/galerie-photo/gestion-image',1),(20,'CREER ALBUM GALERIE PHOTO',NULL,1),(21,'MODIFIER ALBUM GALERIE PHOTO',NULL,1),(22,'SUPPRIMER ALBUM GALERIE PHOTO',NULL,1),(23,'AJOUTER IMAGE GALERIE PHOTO',NULL,1),(24,'SUPPRIMER IMAGE GALERIE PHOTO',NULL,1);
/*!40000 ALTER TABLE `droit_acces` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `droit_acces_page`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `droit_acces_page` (
  `ID_droit_acces_page` int(11) NOT NULL,
  `ID_page` int(11) NOT NULL,
  `seo` int(11) DEFAULT NULL,
  `contenu` int(11) DEFAULT NULL,
  `navigation` int(11) DEFAULT NULL,
  `supprimer` int(11) DEFAULT NULL,
  `ID_liste_droit_acces` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `droit_acces_page`
--

LOCK TABLES `droit_acces_page` WRITE;
/*!40000 ALTER TABLE `droit_acces_page` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `droit_acces_page` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `identite`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `identite` (
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
  `acces_admin` int(11) DEFAULT NULL,
  `liste_droit` int(11) DEFAULT NULL,
  `super_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `identite`
--

LOCK TABLES `identite` WRITE;
/*!40000 ALTER TABLE `identite` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `identite` VALUES (1,'adminclicandcom','admin','admin',NULL,'y5zlsrif018ltajtjd8le9e5rkd0a29v3kdivmunz3e3lpiqca64xm9z5c33r6sdb57e7eeba9fefab7azveth658f1647671e152a8v1cfshakl867dizzjmvn529dvmc7123h1ycsfgvqpz93l72sb7kj6gbubtpm36wueyjzuaeqik321rcn2m9','16, 86, 10, 16, 65, vl7wkz7sqq6x8ks0y602','2015-09-01','profil/defaut.png','profil/defaut_blog.png',1,1,0,1);
/*!40000 ALTER TABLE `identite` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `liaison_liste_droit`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liaison_liste_droit` (
  `liaison_liste_droit` int(11) NOT NULL,
  `ID_droit_acces` int(11) NOT NULL,
  `ID_liste_droit_acces` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liaison_liste_droit`
--

LOCK TABLES `liaison_liste_droit` WRITE;
/*!40000 ALTER TABLE `liaison_liste_droit` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `liaison_liste_droit` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `liste_droit_acces`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `liste_droit_acces` (
  `ID_liste_droit_acces` int(11) NOT NULL,
  `nom_liste` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liste_droit_acces`
--

LOCK TABLES `liste_droit_acces` WRITE;
/*!40000 ALTER TABLE `liste_droit_acces` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `liste_droit_acces` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `module`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `ID_module` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `nom_module` varchar(255) NOT NULL,
  `activer` int(1) NOT NULL,
  `installer` int(1) NOT NULL,
  `systeme` int(1) DEFAULT NULL,
  `icone` varchar(255) DEFAULT NULL,
  `url_telechargement` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_module`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `module` VALUES (1,'livre_or/','livre d\'or',0,0,1,'fa-book','http://library.anthony-pilloud.fr/livre_or.zip'),(2,'blog/','blog',1,1,1,'fa-newspaper-o','http://library.anthony-pilloud.fr/blog.zip'),(3,'galerie_photo/','galerie photo',0,0,1,'fa-photo','http://library.anthony-pilloud.fr/galerie_photo.zip');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

--
-- Table structure for table `page`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `ID_page` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `contenu` longtext,
  `url` varchar(92) DEFAULT NULL,
  `meta_description` varchar(160) DEFAULT NULL,
  `balise_title` varchar(70) DEFAULT NULL,
  `ordre` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `affiche` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page`
--

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `page` VALUES (1,'Accueil','Accueil du site','','Accueil de mon site','Accueil de mon site',1,0,1);
/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Wed, 20 Jan 2016 18:52:27 +0100
