<?php
	$gestion_contenu = new \core\admin\contenus\GestionContenus();
	$droit_acces = new \core\admin\droitsacces\DroitAcces();

	if ((($droit_acces->getDroitAccesContenu("GESTION CONTENU PAGE", $_POST['id_page']) == true) &&  ($droit_acces->getModifContenu() != 0)) || ($droit_acces->getSuperAdmin() == 1)) {

		$gestion_contenu->setModifierContenu($_GET['id_page'], $_GET['contenu']);

		if ((\core\App::getErreur() !== true) && ($gestion_contenu->getErreur() !== true)) {
			\core\HTML\flashmessage\FlashMessage::setFlash("La page ".$_POST['titre_page']." a été mise à jour", "success");
		}
	}
	else {
		\core\HTML\flashmessage\FlashMessage::setFlash("Vous n'avez pas l'autorisation de modifier cette page !");
	}

	header("location:".ADMWEBROOT."gestion-contenus/inline?id=".$_GET['id_page']);