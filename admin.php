<?php
	$page_root = "admin.php";

	/*require("vendor/autoload.php");*/

	use \core\Autoloader;

	use \core\auth\Connexion;
	use \core\admin\Admin;
	use \core\HTML\flashmessage\FlashMessage;
	use \core\admin\droitsacces\DroitAcces;

	require("core/Autoloader.class.php");
	Autoloader::register();

	require("config/initialise.php");

	$login = new Connexion();
	$droit_acces = new DroitAcces();
	$config = new \core\Configuration();

	if ($config->getAccesAdmin() != 1) {
		FlashMessage::setFlash("Il n'y a pas d'interface d'administration sur ce site !");
		header("location:".WEBROOT);
	}

	require(ROOT."core/save/dump/initialise.php");



	//--------------------------------------------- GENERATION META TITLE ++ DESCRIPTION -------------------------------------------------------//
	if (isset($_GET['page'])) {
		$titre_page = "Administration du site";
		$description_page = "Administration du site";
	}
	else {
		$titre_page = "Administration du site";
		$description_page = "Administration du site";
	}
	//--------------------------------------------- FIN GENERATION META TITLE ++ DESCRIPTION -------------------------------------------------------//



	//--------------------------------------------- ROUTING -------------------------------------------------------//
	if (isset($_GET['page'])) {
		$page = $_GET['page'];

		$find = 'controller/';
		$pos = strpos($page, $find);

		if ($pos !== false) {
			//recherche savoir si le fichier appele fait parti du core du systeme pour construire le lien
			$find_core = 'controller/core/';
			$core = strpos($page, $find_core);

			//recherche savoir si le fichier appele est un module du systeme pour construire le lien
			$find_module = 'controller/modules/';
			$module = strpos($page, $find_module);

			$explode = explode("/", $page, 2);
			foreach ($explode as $lien);

			//si c'est un controleur de base on va cerhcer dans core/admin
			if ($core !== false) {
				require_once(ROOT.$lien.".php");
			}
			else if ($module !== false) {
				$explode = explode("/", $lien, 3);

				require_once(ROOT.$explode[0]."/".$explode[1]."/admin/controller/".$explode[2].".php");
			}
			else {
				require_once("admin/controller/".$lien.".php");
			}
		}
		//pour la page de login
		else if ($page == "login") {
			require("admin/views/template/login_admin.php");
		}
		else {
			if (!isset($_SESSION["idlogin".CLEF_SITE])) {
				Connexion::setConnexion(1, WEBROOT."administrator/login");
			}
			else {
				if (\core\functions\ChaineCaractere::FindInString($page, "modules/") == true) {
					//utilisé pour initialiser les modules
					$page_module = $page;

					$explode = explode("/", $page, 3);

					$page = "../../".$explode[0]."/".$explode[1]."/admin/views/".$explode[2];
				}

				//pour les pages normales
				//pour l'acces a la gestion des comptes, si pas activée oin renvoi une erreur
				if (($droit_acces->getDroitAccesPage("gestion-comptes/index") == false) && ($page == "gestion-comptes")) {
					FlashMessage::setFlash("L'accès à cette page n'est pas activé, veuillez contacter votre administrateur pour y avoir accès");
					header("location:".WEBROOT."administrator");
				}
				else if (($droit_acces->getDroitAccesPage("gestion-droits-acces/index") == false) && ($page == "gestion-droits-acces")) {
					FlashMessage::setFlash("L'accès à cette page n'est pas activé, veuillez contacter votre administrateur pour y avoir accès");
					header("location:".WEBROOT."administrator");
				}

				if ($droit_acces->getDroitAccesPage($page) == false) {
					FlashMessage::setFlash("Vous n'avez pas les droits pour accéder à cette page, contacter votre gérant pour y avoir accès");
					header("location:".WEBROOT."administrator");
				}
				else {
					$cache = new \core\Cache($page, 1);
					$admin = new Admin($_SESSION["idlogin".CLEF_SITE]);

					if ($cache->setStart() == false) {
						require(ROOT."admin/controller/initialise_all.php");
						require(ROOT."admin/views/template/principal.php");
					}
					$cache->setEnd();
				}
			}
		}
	}
	else {
		Connexion::setConnexion(1, WEBROOT."administrator/login");

		if (!isset($_SESSION["idlogin".CLEF_SITE])) {
			Connexion::setConnexion(1, WEBROOT."administrator/login");
		}
		else {
			$page = "index";
			$admin = new Admin($_SESSION["idlogin".CLEF_SITE]);
			require(ROOT."admin/controller/initialise_all.php");
			require("admin/views/template/principal.php");
		}
	}
	//--------------------------------------------- FIN ROUTING -------------------------------------------------------//