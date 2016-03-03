<?php
	$droit_acces = new \core\admin\droitsacces\DroitAcces();

	if ($droit_acces->getDroitAccesContenu("GESTION CONTENU PAGE", $_GET['id']) == true) {
		if ($droit_acces->getSupprimerPage() != 0) {
			$gestion_contenu = new \core\admin\contenus\GestionContenus();

			$gestion_contenu->setSupprimerPage($_GET['id']);

			if ($gestion_contenu->getErreur() !== true) {
				\core\HTML\flashmessage\FlashMessage::setFlash("La page a bien été supprimée", "success");
				header("location:".ADMWEBROOT."gestion-contenus/index");
			}
			else {
				header("location:".ADMWEBROOT."gestion-contenus/modifier-contenu?id=".$_GET['id']);
			}
		}
		else {
			\core\HTML\flashmessage\FlashMessage::setFlash("Vous n'avez pas le droit de supprimer cette page");

			if (isset($_GET['id'])) {
				header("location:".ADMWEBROOT."gestion-contenus/modifier-contenu?id=".$_GET['id']);
			}
			else {
				header("location:".ADMWEBROOT."gestion-contenus/index");
			}
		}
	}
	else {
		\core\HTML\flashmessage\FlashMessage::setFlash("Vous n'avez pas le droit de supprimer cette page");

		if (isset($_GET['id'])) {
			header("location:".ADMWEBROOT."gestion-contenus/modifier-contenu?id=".$_GET['id']);
		}
		else {
			header("location:".ADMWEBROOT."gestion-contenus/index");
		}
	}