<?php
	//---------- actif pour toutes les pages ------------------------------------//
	$gestion_module = new \core\modules\GestionModule();
	$gestion_module->getListeModuleActiver();

	$membre = new \core\auth\Membre($_SESSION["idlogin".CLEF_SITE]);
	$nom_user = $membre->getPrenom()." ".$membre->getNom();
	//---------- fin actif pour toutes les pages ------------------------------------//



	//---------- partie pour les droite d'acces ------------------------------------//
	$droit_acces = new \core\admin\droitsacces\DroitAcces();
	$gestion_droit_acces = new \core\admin\droitsacces\GestionDroitAcces();

	if ($droit_acces->getDroitAcces("GESTION CONTENUS")) {
		$contenu = new \core\contenus\Contenus();
		$gestion_contenu = new \core\admin\contenus\GestionContenus();
	}

	//pour les pages sur les droits d'acces
	if (($page == "gestion-droits-acces/ajouter-liste") || ($page == "gestion-droits-acces/modifier-liste")) {
		require_once(ROOT."core/admin/droitsacces/initialise/ajout_modification.php");
	}
	//---------- fin partie pour les droite d'acces ------------------------------------//



	//---------- partie pour la gestion des comptes ------------------------------------//
	if ($page == "gestion-comptes/creer-utilisateur") {
		if (isset($_SESSION['err_ajout_utilisateur'])) {
			$nom = $_SESSION['nom'];
			$prenom = $_SESSION['prenom'];
			$pseudo = $_SESSION['pseudo'];
			$mail = $_SESSION['mail'];
			$acces_admin = $_SESSION['acces_admin'];

			unset($_SESSION['err_ajout_utilisateur']);
		}
		else {
			$nom = null;
			$prenom = null;
			$pseudo = null;
			$mail = null;
			$acces_admin = null;
		}
	}
	//---------- fin partie pour la gestion des comptes ------------------------------------//



	//---------- pour les pages sur la modification de contenus ----------------------------------------------//
	if (($page == "gestion-contenus/modifier-contenu") || ($page == "gestion-contenus/creer-une-page") || ($page == "gestion-contenus/inline")) {
		if (isset($_SESSION['err_modification_contenu'])) {
			if (isset($_GET['id'])) {
				$id_page_courante = $_GET['id'];
			}

			$balise_title = $_SESSION['balise_title'];
			$url = $_SESSION['url'];
			$meta_description = $_SESSION['meta_description'];
			$titre_courant = $_SESSION['titre_page'];
			$parent_courant = $_SESSION['parent'];

			unset($_SESSION['err_modification_contenu']);
		}
		else if (($page == "gestion-contenus/modifier-contenu") || ($page == "gestion-contenus/inline")) {
			$id_page_courante = $_GET['id'];

			$contenu->getHeadPage($id_page_courante);
			$balise_title = $contenu->getBaliseTitle();
			$meta_description = $contenu->getMetaDescription();

			$contenu->getContenuPage($id_page_courante);
			$url = $contenu->getUrl();
			$titre_courant = $contenu->getTitre();
			$parent_courant = $contenu->getParent();
			$texte_parent_courant = $gestion_contenu->getParentTexte($parent_courant);
			$contenu_page = $contenu->getContenu();
			$bloc_editable = $gestion_contenu->getBlocEditable($id_page_courante);
		}
		else {
			$balise_title = null;
			$url = null;
			$meta_description = null;
			$titre_courant = null;
			$parent_courant = null;
			$contenu_page = null;
			$id_page_courante = null;
		}
	}
	//---------- fin pour les pages sur la modification de contenus ----------------------------------------------//



	//---------- actif pour la configuration des modules ------------------------------------//
	if ($page == "configuration/module") {
		$gestion_module_page = new \core\modules\GestionModule();
		$gestion_module_page->getListeModule();
	}
	//---------- fin actif pour la configuration des modules ------------------------------------//



	//---------- actif pour la configuration des infos générales ------------------------------------//
	if ($page == "configuration/infos-generales") {
		if (isset($_SESSION['err_modification_infos_config'])) {
			$nom_site = $_SESSION['nom_site'];
			$url_site = $_SESSION['url_site'];
			$gerant_site = $_SESSION['gerant_site'];
			$mail_site = $_SESSION['mail_site'];
			$mail_administrateur = $_SESSION['mail_administrateur'];

			unset($_SESSION['err_modification_infos_config']);

			$config = new \core\Configuration();
			$contenu_dynamique = $config->getContenusDynamique();
			$responsive = $config->getResponsive();
			$cache_config = $config->getCache();
		}
		else {
			$config = new \core\Configuration();
			$nom_site = $config->getNomSite();
			$url_site = $config->getUrlSite();
			$gerant_site = $config->getGerantSite();
			$mail_site = $config->getMailSite();
			$mail_administrateur = $config->getMailAdministrateur();

			$contenu_dynamique = $config->getContenusDynamique();
			$responsive = $config->getResponsive();
			$cache_config = $config->getCache();
		}
	}
	//---------- fin actif pour la configuration des infos générales ------------------------------------//



	//---------- actif pour la configuration des bases de données ------------------------------------//
	if ($page == "configuration/base-de-donnees") {
		$ini_parse1 = new \core\iniparser\IniParser();
		$ini1 = $ini_parse1->getParse(ROOT."config/config.ini");

		if (isset($_SESSION['err_modification_configini'])) {
			$db_type_dev = $_SESSION["db_type_dev"];
			$db_name_dev = $_SESSION["db_name_dev"];
			$db_user_dev = $_SESSION["db_user_dev"];
			$db_pass_dev = $_SESSION["db_pass_dev"];
			$db_host_dev = $_SESSION["db_host_dev"];

			$db_type_prod = $_SESSION["db_type_prod"];
			$db_name_prod = $_SESSION["db_name_prod"];
			$db_user_prod = $_SESSION["db_user_prod"];
			$db_pass_prod = $_SESSION["db_pass_prod"];
			$db_host_prod = $_SESSION["db_host_prod"];

			unset($_SESSION['err_modification_configini']);
		}
		else {
			$developpement = $ini["developpment"];

			$db_type_dev = $ini["dev"]["DB_TYPE"];
			$db_name_dev = $ini["dev"]["DB_NAME"];
			$db_user_dev = $ini["dev"]["DB_USER"];
			$db_pass_dev = $ini["dev"]["DB_PASS"];
			$db_host_dev = $ini["dev"]["DB_HOST"];

			$db_type_prod = $ini["prod"]["DB_TYPE"];
			$db_name_prod = $ini["prod"]["DB_NAME"];
			$db_user_prod = $ini["prod"]["DB_USER"];
			$db_pass_prod = $ini["prod"]["DB_PASS"];
			$db_host_prod = $ini["prod"]["DB_HOST"];
		}
	}
	//---------- fin actif pour la configuration des bases de données ------------------------------------//