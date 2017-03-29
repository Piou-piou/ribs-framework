<?php
	$page_root = "admin.php";
	$page = "index";

	require("vendor/autoload.php");
	
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
		$page = $_GET['page'];
	}
	else {
		$titre_page = "Administration du site";
		$description_page = "Administration du site";
	}
	//--------------------------------------------- FIN GENERATION META TITLE ++ DESCRIPTION -------------------------------------------------------//



	//--------------------------------------------- ROUTING -------------------------------------------------------//
	$controller = new \core\RouterController($page, "admin");
	
	if ($controller->getErreur() === false) {
		require_once($controller->getController());
	}
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
			}
			else {
				$loader = new Twig_Loader_Filesystem("admin/views");
				$twig = new Twig_Environment($loader);
			}
			require(ROOT."admin/controller/initialise_all.php");
			require(ROOT."admin/views/template/principal.php");
		}
	}
	//--------------------------------------------- FIN ROUTING -------------------------------------------------------//