<?php
	$gestion_contenu = new \core\admin\contenus\GestionContenus($_POST['url']);
	$droit_acces = new \core\admin\droitsacces\DroitAcces();
	
	if ($droit_acces->getSuperAdmin() == 1 || in_array("GESTION CONTENUS", $droit_acces->getListeDroitsAcces())) {
		$droit_acces->getListeDroitModificationContenu($_POST['id_page']);
		
		if ($droit_acces->getModifContenu() != 0 || $droit_acces->getSuperAdmin() == 1) {
			$gestion_contenu->setModifierContenu($_POST['id_page'], $_POST['contenu']);
			
			\core\HTML\flashmessage\FlashMessage::setFlash("La page ".$_POST['titre_page']." a été mise à jour", "success");
		}
	}
	else {
		\core\HTML\flashmessage\FlashMessage::setFlash("Vous n'avez pas l'autorisation de modifier cette page !");
	}