<?php
	namespace core\admin;

	use core\HTML\flashmessage\FlashMessage;

	$admin = new Admin($_SESSION["idlogin".CLEF_SITE]);

	$id_identite = $_GET['id_identite'];

	$admin->setValideCompte($id_identite);

	FlashMessage::setFlash("Le compte de ".$admin->getPrenom()." ".$admin->getNom()." a bien été validé", "success");

	header("location:".ADMWEBROOT."gestion-comptes/index");