<?php
	namespace core\admin;

	$admin = new Admin($_SESSION["idlogin".CLEF_SITE]);

	$id_identite = $_GET['id_identite'];

	$admin->setReinitialiserMdp($id_identite);

	header("location:".ADMWEBROOT."gestion-comptes/index");