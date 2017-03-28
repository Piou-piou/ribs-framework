<?php
	//--------------------------------------------- INITIALISATION -------------------------------------------------------//
	$page_root = "index.php";

	require("vendor/autoload.php");

	use \core\Autoloader;
	use \core\auth\Connexion;
	use \core\contenus\Contenus;
	use \core\modules\RouterModule;
	use \core\Configuration;

	require("config/initialise.php");
	
	$page = "index";
	if ((isset($_GET['page'])) && ($_GET['page'] != null)) {
		$page = $_GET['page'];
	}
	//--------------------------------------------- FIN INITIALISATION DES CLASS -------------------------------------------------------//


	//--------------------------------------------- INITIALISATION DES CLASS -------------------------------------------------------//
	$login = new Connexion();
	$config = new Configuration();
	$nav = new \core\Navigation();
	$arr = [];

	if (isset($_SESSION["idlogin".CLEF_SITE])) {
		$membre = new \core\auth\Membre($_SESSION["idlogin".CLEF_SITE]);
		$img_profil = $membre->getImg();
	}
	//--------------------------------------------- FIN INITIALISATION DES CLASS -------------------------------------------------------//


	//--------------------------------------------- GENERATION META TITLE ++ DESCRIPTION -------------------------------------------------------//
	//initialisation des contenus
	//$contenu = new Contenus($page);
	//--------------------------------------------- FIN GENERATION META TITLE ++ DESCRIPTION -------------------------------------------------------//



	//--------------------------------------------- ROUTING -------------------------------------------------------//
	$controller = new \core\RouterController($page);
	
	if ($controller->getController() !== false) {
		require_once($controller->getController());
	}
	else {
		$cache = new \core\Cache($page);
		
		$router_module = new RouterModule();
		if ($router_module->getRouteModuleExist($page)) {
			$page = $router_module->getUrl($page);
		
			if ($router_module->getController() != "") {
				require_once(MODULEROOT.$router_module->getController());
			}
		
			$loader = new Twig_Loader_Filesystem(['modules/'.$router_module->getModule()."/app/views", "app/views"]);
			$twig = new Twig_Environment($loader);
			$arr_page = \core\App::getValues();
			$page = $router_module->getPage();
		}
		else {
			$explode = explode("/", $page);
		
			$loader = new Twig_Loader_Filesystem('app/views');
			$twig = new Twig_Environment($loader);
		
			$arr_page = array_merge(core\App::getValues());
			$page = end($explode);
		
			if (!file_exists(ROOT."app/views/".$page.".html")) {
				\core\RedirectError::Redirect(404);
			}
		}
		
		if ($cache->setStart() === false) {
			require("app/controller/initialise_all.php");
			require("app/views/template/principal.php");
		}
		$cache->setEnd();
	}
	//--------------------------------------------- FIN ROUTING -------------------------------------------------------//