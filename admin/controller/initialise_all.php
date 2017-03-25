<?php
	//---------- actif pour toutes les pages ------------------------------------//
	$gestion_module = new \core\modules\GestionModule();
	$gestion_module->getListeModuleActiver();

	$membre = new \core\auth\Membre($_SESSION["idlogin".CLEF_SITE]);
	$nom_user = $membre->getPrenom()." ".$membre->getNom();
	//---------- fin actif pour toutes les pages ------------------------------------//



	//---------- partie pour les droite d'acces ------------------------------------//
	if ($page == "gestion-droits-acces/index" || $page == "gestion-droits-acces/liste-droits-acces") {
		$gestion_droit_acces = new \core\admin\droitsacces\GestionDroitAcces();
	}
	
	$gestion_contenu = new \core\admin\contenus\GestionContenus();
	//---------- fin partie pour les droite d'acces ------------------------------------//



	//---------- partie pour la gestion des comptes ------------------------------------//
	if ($page == "gestion-comptes/index") {
		$all_users = $admin->getAllUser();
	}
	
	if ($page == "gestion-comptes/creer-utilisateur") {
		if (isset($_SESSION['err_ajout_utilisateur'])) {
			\core\App::setValues([
				"nom" => $_SESSION['nom'],
				"prenom" => $_SESSION['prenom'],
				"pseudo" => $_SESSION['pseudo'],
				"mail" => $_SESSION['mail'],
			]);

			unset($_SESSION['err_ajout_utilisateur']);
		}
	}
	//---------- fin partie pour la gestion des comptes ------------------------------------//



	//---------- pour les pages sur la modification de contenus ----------------------------------------------//
	if (($page == "gestion-contenus/modifier-contenu") || ($page == "gestion-contenus/creer-une-page") || ($page == "gestion-contenus/inline")) {
		$nav = new \core\Navigation("page only");
		
		if (isset($_GET['id'])) {
			$id_page = $_GET['id'];
		}
		
		$droit_acces->getListeDroitModificationContenu($id_page);
		
		if (isset($_SESSION['err_modification_contenu'])) {
			\core\App::setValues([
				"id_page" => $id_page_courante,
				"balise_title" => $_SESSION['balise_title'],
				"url" => $_SESSION['url'],
				"meta_description" => $_SESSION['meta_description'],
				"titre_page" => $_SESSION['titre_page'],
				"parent" => $_SESSION['parent'],
			]);

			unset($_SESSION['err_modification_contenu']);
			unset($_SESSION['balise_title']);
			unset($_SESSION['url']);
			unset($_SESSION['meta_description']);
			unset($_SESSION['titre_page']);
			unset($_SESSION['parent']);
		}
		else if (($page == "gestion-contenus/modifier-contenu") || ($page == "gestion-contenus/inline")) {
			$id_page_courante = $_GET['id'];

			$gestion_contenu->getHeadPage($id_page_courante);
			$balise_title = $gestion_contenu->getBaliseTitle();
			$meta_description = $gestion_contenu->getMetaDescription();

			$gestion_contenu->getContenuPage($id_page_courante);
			$url = $gestion_contenu->getUrl();
			$titre_courant = $gestion_contenu->getTitre();
			$parent_courant = $gestion_contenu->getParent();
			$texte_parent_courant = $gestion_contenu->getParentTexte($parent_courant);
			$contenu_page = $gestion_contenu->getContenu();
			$bloc_editable = $gestion_contenu->getBlocEditable($id_page_courante);
			$redirect_page = $gestion_contenu->getTestRedirectPage($url);
		}
	}
	//---------- fin pour les pages sur la modification de contenus ----------------------------------------------//
	
	
	
	//---------- actif pour la configuration de la navigation ------------------------------------//
	if ($page == "gestion-navigation/index") {
		$nav = new \core\Navigation();
	}
	//---------- fin actif pour la configuration de la navigation ------------------------------------//



	//---------- actif pour la configuration des modules ------------------------------------//
	if ($page == "configuration/module") {
		$gestion_module->getListeModule();
	}
	//---------- fin actif pour la configuration des modules ------------------------------------//



	//---------- actif pour la configuration des bases de données ------------------------------------//
	if ($page == "configuration/base-de-donnees") {
		if (isset($_SESSION['err_modification_configini'])) {
			$db_type_dev = $_SESSION["db_type_dev"];
			$db_name_dev = $_SESSION["db_name_dev"];
			$db_user_dev = $_SESSION["db_user_dev"];
			$db_pass_dev = $_SESSION["db_pass_dev"];
			$db_host_dev = $_SESSION["db_host_dev"];

			unset($_SESSION['err_modification_configini']);
		}
		else {
			\core\App::setValues(["bdd" => $ini]);
		}
	}
	//---------- fin actif pour la configuration des bases de données ------------------------------------//
	$arr_admin = \core\App::getValues();