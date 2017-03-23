<?php
	$page_root = "admin.php";

	require("vendor/autoload.php");

	use \core\Autoloader;

	use \core\auth\Connexion;
	use \core\admin\Admin;
	use \core\HTML\flashmessage\FlashMessage;
	use \core\admin\droitsacces\DroitAcces;

	require("config/initialise.php");

	$login = new Connexion();
	if (isset($_SESSION["idlogin".CLEF_SITE])) {
		$droit_acces = new DroitAcces();
	}

	$config = new \core\Configuration();

	if ($config->getAccesAdmin() != 1) {
		FlashMessage::setFlash("Il n'y a pas d'interface d'administration sur ce site !");
		header("location:".WEBROOT);
	}

	require(ROOT."core/save/save.php");



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
				Connexion::setObgConnecte(WEBROOT."administrator/login");
			}
			else {
				$admin = new Admin($_SESSION["idlogin".CLEF_SITE]);
				$router_module = new \core\modules\RouterModule();
				if ($router_module->getRouteModuleExist($page)) {
					$page = $router_module->getUrl($page, "admin");
					
					if ($router_module->getController() != "") {
						require_once(MODULEROOT.$router_module->getController());
					}
					
					$loader = new Twig_Loader_Filesystem(['modules/'.$router_module->getModule()."/admin/views", "admin/views"]);
					$twig = new Twig_Environment($loader);
					
					$page = $router_module->getPage();
					$twig_page = true;
				}
				else {
					//pour les pages normales
					//pour l'acces a la gestion des comptes, si pas activée oin renvoi une erreur
					$twig_ok_page = [
						"index",
						"notifications",
						"contacter-support",
						"configuration/index",
						"configuration/module",
						"configuration/infos-generales",
						"configuration/mon-compte",
						"configuration/base-de-donnees",
						"gestion-navigation/index",
						"gestion-comptes/index"
					];
					
					if (in_array($page, $twig_ok_page)) {
						$loader = new Twig_Loader_Filesystem("admin/views");
						$twig = new Twig_Environment($loader);
						$twig_page = true;
					}
				}
				require(ROOT."admin/controller/initialise_all.php");
				require(ROOT."admin/views/template/principal.php");
			}
		}
	}
	else {
		Connexion::setObgConnecte(WEBROOT."administrator/login");

		if (!isset($_SESSION["idlogin".CLEF_SITE])) {
			Connexion::setObgConnecte(WEBROOT."administrator/login");
		}
		else {
			$page = "index";
			$admin = new Admin($_SESSION["idlogin".CLEF_SITE]);
			require(ROOT."admin/controller/initialise_all.php");
			require("admin/views/template/principal.php");
		}
	}
	//--------------------------------------------- FIN ROUTING -------------------------------------------------------//