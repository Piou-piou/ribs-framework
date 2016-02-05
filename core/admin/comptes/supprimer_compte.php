<?php
	namespace core\admin;

	use core\HTML\flashmessage\FlashMessage;

	$admin = new Admin($_SESSION["idlogin".CLEF_SITE]);

	$id_identite = $_GET['id_identite'];
	$prenom = $admin->getPrenom();
	$nom = $admin->getNom();

	$admin->setSupprimerCompte($id_identite);

	FlashMessage::setFlash("Le compte de $prenom $nom a bien été supprimé", "success");

	header("location:".ADMWEBROOT."gestion-comptes/index");
?>