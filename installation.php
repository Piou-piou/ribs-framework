<?php
	$page_root = "installation.php";
	require("vendor/autoload.php");
	require("config/initialise.php");



	//--------------------------------------------- ROUTING -------------------------------------------------------//
	if ((isset($_GET['page'])) && ($_GET['page'] != "")) {
		$page = $_GET['page'];

		$find = 'controller/';
		$pos = strpos($page, $find);

		if ($pos !== false) {
			$explode = explode("/", $page, 2);
			foreach ($explode as $lien);

			//si c'est un controleur de base on va cerhcer dans core/admin
			require_once("installation/controller/".$lien.".php");
		}
		else {
			require("installation/views/template/principal.php");
		}
	}
	else {
		$page = "installation/views/index";
		require("installation/views/template/principal.php");
	}
	//--------------------------------------------- FIN ROUTING -------------------------------------------------------//