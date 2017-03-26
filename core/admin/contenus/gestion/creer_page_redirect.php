<?php
	$gestion_contenu = new \core\admin\contenus\GestionContenus(0, 1);

	$gestion_contenu->setCreerPageRedirect($_POST['balise_title'], $_POST['url'], $_POST['titre_page'], $_POST['parent']);

	if ((\core\App::getErreur() !== true) && ($gestion_contenu->getErreur() !== true)) {
		\core\HTML\flashmessage\FlashMessage::setFlash("La page ".$_POST['titre_page']." a bien été crée", "success");
		header("location:".ADMWEBROOT."gestion-contenus/modifier-contenu?id=".$gestion_contenu->getIdPage());
	}
	else {
		header("location:".ADMWEBROOT."gestion-contenus/creer-une-page");
	}