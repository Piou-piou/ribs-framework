<?php
	$page_root = "index.php";

	require("vendor/autoload.php");

	use \core\Autoloader;
	use \core\auth\Connexion;
	use \core\contenus\Contenus;
	use \core\modules\RouterModule;
	use \core\Configuration;

	require("config/initialise.php");


	//--------------------------------------------- INITIALISATION DES CLASS -------------------------------------------------------//
	$login = new Connexion();
	$config = new Configuration();
	$arr = [];

	if (isset($_SESSION["idlogin".CLEF_SITE])) {
		$membre = new \core\auth\Membre($_SESSION["idlogin".CLEF_SITE]);
		$img_profil = $membre->getImg();
	}
	//--------------------------------------------- FIN INITIALISATION DES CLASS -------------------------------------------------------//


	//--------------------------------------------- GENERATION META TITLE ++ DESCRIPTION -------------------------------------------------------//
	if ($config->getContenusDynamique() == 1) {
		//initialisation des contenus
		$contenu = new Contenus();

		if ((isset($_GET['page'])) && ($_GET['page'] != null)) {
			$page = $_GET['page'];
			$contenu->getHeadPage(0, $page);
		}
		else {
			$contenu->getHeadPage(1);
		}

		\core\App::setTitle($contenu->getBaliseTitle());
		\core\App::setDescription($contenu->getMetaDescription());
	}

	//--------------------------------------------- FIN GENERATION META TITLE ++ DESCRIPTION -------------------------------------------------------//



	//--------------------------------------------- ROUTING -------------------------------------------------------//
	if ((isset($_GET['page'])) && ($_GET['page'] != "")) {
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

				require_once(ROOT.$explode[0]."/".$explode[1]."/app/controller/".$explode[2].".php");
			}
			else {
				require_once("app/controller/".$lien.".php");
			}
		}
		else {
			$cache = new \core\Cache($page);

			$router_module = new RouterModule();
			if ($router_module->getRouteModuleExist($page)) {
				$page = $router_module->getUrl($page);

				if ($router_module->getController() != "") {
					require_once(MODULEROOT.$router_module->getController());
				}

				$loader = new Twig_Loader_Filesystem('modules/'.$router_module->getModule()."/app/views");
				$twig = new Twig_Environment($loader);

				$page = $router_module->getPage();
			}
			else {
				$contenu->getContenuPage();
				$contenu_page = $contenu->getContenu();

				$explode = explode("/", $page);

				$loader = new Twig_Loader_Filesystem('app/views');
				$twig = new Twig_Environment($loader);
				
				$arr_page = ["contenu_page" => $contenu_page];
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
	}
	else {
		$contenu->getContenuPage();
		$contenu_page = $contenu->getContenu();

		$loader = new Twig_Loader_Filesystem('app/views');
		$twig = new Twig_Environment($loader);

		$arr_page = ["contenu_page" => $contenu_page];
		$page = "index";
		
		$cache = new \core\Cache($page);
		if ($cache->setStart() === false) {
			require("app/controller/initialise_all.php");
			require("app/views/template/principal.php");
		}
		$cache->setEnd();
	}
	//--------------------------------------------- FIN ROUTING -------------------------------------------------------//