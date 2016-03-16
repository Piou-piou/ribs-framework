<?php
	$page_root = "index.php";

	require("vendor/autoload.php");

	use \core\Autoloader;
	use \core\auth\Connexion;
	use \core\contenus\Contenus;
	use \core\modules\RouterModule;
	use \core\Configuration;

	require("core/Autoloader.class.php");
	Autoloader::register();

	require("config/initialise.php");


	//--------------------------------------------- INITIALISATION DES CLASS -------------------------------------------------------//
	$login = new Connexion();
	$config = new Configuration();

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
			//récupération des balises
			$contenu->getHeadPage(0, $page);
			$titre_page = $contenu->getBaliseTitle();
			$description_page = $contenu->getMetaDescription();

			$contenu->getContenuPage();
			$contenu_page = $contenu->getContenu();
		}
		else {
			$contenu->getHeadPage(1);
			$titre_page = $contenu->getBaliseTitle();
			$description_page = $contenu->getMetaDescription();

			$contenu->getContenuPage();
			$contenu_page = $contenu->getContenu();
		}
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
			}
			else {
				$explode = explode("/", $page);
				$page = "app/views/".end($explode);

				if (!file_exists(ROOT.$page.".php")) {
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
		$page = "app/views/index";
		require("app/controller/initialise_all.php");
		require("app/views/template/principal.php");
	}
	//--------------------------------------------- FIN ROUTING -------------------------------------------------------//