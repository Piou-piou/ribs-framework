<?php
	if (!isset($page_root)) $page_root = "index.php";

	//-------------------------- CONSTANTE POUR LES ROUTES ----------------------------------------------------------------------------//
	//definit le chemin vers la racine du projet (depuis racine serveur web
	define('WEBROOT', str_replace("$page_root", '', $_SERVER['SCRIPT_NAME']));

	//definit la racine du dossier depuis le début du systeme
	define('ROOT', str_replace("$page_root", '', $_SERVER['SCRIPT_FILENAME']));

	//definit le chemin vers la racine du template -> app/views/template/
	define('TPLWEBROOT', str_replace("$page_root", '', $_SERVER['SCRIPT_NAME'])."app/views/template/");

	//definit le chemin vers la racine des libs -> libs/
	define('LIBSWEBROOT', str_replace("$page_root", '', $_SERVER['SCRIPT_NAME'])."libs/");

	//definit le chemin vers la racine des libs -> libs/
	define('LIBSROOT', str_replace("$page_root", '', $_SERVER['SCRIPT_FILENAME'])."libs/");

	//definit le chemin vers la racine de l'admin -> admin/
	define('ADMWEBROOT', str_replace("$page_root", '', $_SERVER['SCRIPT_NAME'])."administrator/");

	//definit la route vers les modules utilisés
	define('MODULEROOT', str_replace("$page_root", '', $_SERVER['SCRIPT_FILENAME'])."modules/");

	//definit la route vers les modules utilisés
	define('MODULEWEBROOT', str_replace("$page_root", '', $_SERVER['SCRIPT_NAME'])."modules/");

	//definit la webroot our l'admin des modules
	define('MODULEADMWEBROOT', str_replace("$page_root", '', $_SERVER['SCRIPT_NAME'])."administrator/modules/");

	//definit la route vers le dossier temporaire
	define('TEMPROOT', str_replace("$page_root", '', $_SERVER['SCRIPT_FILENAME'])."temp/");
	//-------------------------- FIN CONSTANTE POUR LES ROUTES ----------------------------------------------------------------------------//



	//-------------------------- CONSTANTE BDD ----------------------------------------------------------------------------//
	$ini_parse = new \core\iniparser\IniParser();

	//on test si on a bien le fichier de config. sinon on est sur une nouvelle installation
	if (file_exists(ROOT."config/config.ini") === true) {
		$ini = $ini_parse->getParse("config/config.ini");

		//si l'installation est à 1 cela veut dire que l'on doit ainstaller le site
		if (($ini["installation"] == 1) && ($page_root != "installation.php")) {
			header("location:".WEBROOT."installation-ribs");
		}
	}
	else {
		header("location:".WEBROOT."installation");
	}
	
	$tab = "dev";

	define('DB_TYPE', $ini[$tab]["DB_TYPE"]);
	define('DB_NAME', $ini[$tab]["DB_NAME"]);
	define('DB_USER', $ini[$tab]["DB_USER"]);
	define('DB_PASS', $ini[$tab]["DB_PASS"]);
	define('DB_HOST', $ini[$tab]["DB_HOST"]);
	define('SMTP_HOST', $ini[$tab]["SMTP_HOST"]);
	define('SMTP_USER', $ini[$tab]["SMTP_USER"]);
	define('SMTP_PASS', $ini[$tab]["SMTP_PASS"]);
	define('SMTP_SECURE', $ini[$tab]["SMTP_SECURE"]);
	define('SMTP_PORT', $ini[$tab]["SMTP_PORT"]);

	//pour les images ajoutées par des utilisateurs
	define('IMGROOT', "http://".$_SERVER['SERVER_NAME']."/app/images/");
	define('ROOTCKFINDER', "/app/images/pages");
	//-------------------------- FIN CONSTANTE BDD ----------------------------------------------------------------------------//



	//-------------------------- AUTRES CONSTANTE ----------------------------------------------------------------------------//
	//definit la clef du site, utilisée lors des sessions de connexions
	define("CLEF_SITE", "65cbdfdd5b9219753f26b98419f52ddc");
	//-------------------------- FIN AUTRES CONSTANTE ----------------------------------------------------------------------------//



	//CONSTANT FOR TWIG
	$constant = [
		'WEBROOT' => str_replace("$page_root", '', $_SERVER['SCRIPT_NAME']),
		'ROOT' => str_replace("$page_root", '', $_SERVER['SCRIPT_FILENAME']),
		'TPLWEBROOT' => str_replace("$page_root", '', $_SERVER['SCRIPT_NAME'])."app/views/template/",
		'LIBSWEBROOT'=> str_replace("$page_root", '', $_SERVER['SCRIPT_NAME'])."libs/",
		'LIBSROOT' => str_replace("$page_root", '', $_SERVER['SCRIPT_FILENAME'])."libs/",
		'ADMWEBROOT' => str_replace("$page_root", '', $_SERVER['SCRIPT_NAME'])."administrator/",
		'MODULEROOT' => str_replace("$page_root", '', $_SERVER['SCRIPT_FILENAME'])."modules/",
		'MODULEWEBROOT' => str_replace("$page_root", '', $_SERVER['SCRIPT_NAME'])."modules/",
		'MODULEADMWEBROOT' => str_replace("$page_root", '', $_SERVER['SCRIPT_NAME'])."administrator/modules/",
		'TEMPROOT' => str_replace("$page_root", '', $_SERVER['SCRIPT_FILENAME'])."temp/",
		'IMGROOT' => "http://".$_SERVER['SERVER_NAME']."/app/images/",
		'ROOTCKFINDER' => "/app/images/pages",
		"CLEF_SITE" => "65cbdfdd5b9219753f26b98419f52ddc"
	];