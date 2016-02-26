<?php
	namespace core\admin;

	use core\auth\Membre;
	use core\HTML\flashmessage\FlashMessage;

	$admin = new Admin($_SESSION["idlogin".CLEF_SITE]);

	$id_identite = $_GET['id_identite'];
	$membre = new Membre($id_identite);
	$prenom = $membre->getPrenom();
	$nom = $membre->getNom();

	$admin->setSupprimerCompte($id_identite);

	FlashMessage::setFlash("Le compte de $prenom $nom a bien été supprimé", "success");

	header("location:".ADMWEBROOT."gestion-comptes/index");