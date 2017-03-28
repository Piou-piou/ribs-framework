<?php
	$droit_acces = new \core\admin\droitsacces\DroitAcces();
	
	if ($droit_acces->getSuperAdmin() == 1 || in_array("GESTION CONTENUS", $droit_acces->getListeDroitsAcces())) {
		$droit_acces->getListeDroitModificationContenu($_GET['id']);
		
		if (($droit_acces->getSupprimerPage() != 0) || ($droit_acces->getSuperAdmin() == 1)) {
			$gestion_contenu = new \core\admin\contenus\GestionContenus($_GET['url']);
			
			$gestion_contenu->setSupprimerPage($_GET['id']);
			
			if ($gestion_contenu->getErreur() !== true) {
				\core\HTML\flashmessage\FlashMessage::setFlash("La page a bien été supprimée", "success");
				header("location:".ADMWEBROOT."gestion-contenus/index");
			}
			else {
				header("location:".ADMWEBROOT."gestion-contenus/modifier-contenu?id=".$_GET['id']."&url=".$_GET['url']);
			}
		}
		else {
			\core\HTML\flashmessage\FlashMessage::setFlash("Vous n'avez pas le droit de supprimer cette page");
			header("location:".ADMWEBROOT."gestion-contenus/modifier-contenu?id=".$_GET['id']."&url=".$_GET['url']);
		}
	}