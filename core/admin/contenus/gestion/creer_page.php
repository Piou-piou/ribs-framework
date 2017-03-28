<?php
	if ($droit_acces->getSuperAdmin() == 1 || in_array("CREATION PAGE", $droit_acces->getListeDroitsAcces())) {
		$gestion_contenu = new \core\admin\contenus\GestionContenus(0, 1);
		
		$gestion_contenu->setCreerPage($_POST['balise_title'], $_POST['url'], $_POST['meta_description'], $_POST['titre_page'], $_POST['parent']);
		
		if ($gestion_contenu->getErreur() !== true) {
			\core\HTML\flashmessage\FlashMessage::setFlash("La page ".$_POST['titre_page']." a bien été crée", "success");
			header("location:".ADMWEBROOT."gestion-contenus/modifier-contenu?id=".$gestion_contenu->getIdPage()."&url=".$gestion_contenu->getUrl());
		}
		else {
			header("location:".ADMWEBROOT."gestion-contenus/creer-une-page");
		}
	}
	else {
		\core\HTML\flashmessage\FlashMessage::setFlash("Vous n'avez pas le droit de créer cette page");
		header("location:".ADMWEBROOT."gestion-contenus/index");
	}