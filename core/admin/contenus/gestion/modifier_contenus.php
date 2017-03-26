<?php
	$gestion_contenu = new \core\admin\contenus\GestionContenus($_POST['url_avant']);
	$droit_acces = new \core\admin\droitsacces\DroitAcces();
	
	if ($droit_acces->getSuperAdmin() == 1 || in_array("GESTION CONTENUS", $droit_acces->getListeDroitsAcces())) {
		$droit_acces->getListeDroitModificationContenu($_POST['id_page']);
		
		if ($droit_acces->getModifSeo() != 0 || $droit_acces->getSuperAdmin() == 1) {
			$balise_title = $_POST['balise_title'];
			$url = $_POST['url'];
			$meta_description = $_POST['meta_description'];
		}
		else {
			$balise_title = $gestion_contenu->getBaliseTitle();
			$url = $gestion_contenu->getUrl();
			$meta_description = $gestion_contenu->getMetaDescription();
		}
		
		if ($droit_acces->getModifNavigation() != 0 || $droit_acces->getSuperAdmin() == 1) {
			$titre_page = $_POST['titre_page'];
			$parent = $_POST['parent_texte'];
		}
		else {
			$titre_page = $gestion_contenu->getTitre();
			$parent = $gestion_contenu->getParent();
		}
		
		$gestion_contenu->setModifierPage($_POST['id_page'], $balise_title, $url, $meta_description, $titre_page, $parent);
		
		if ((\core\App::getErreur() !== true) && ($gestion_contenu->getErreur() !== true)) {
			\core\HTML\flashmessage\FlashMessage::setFlash("La page ".$_POST['titre_page']." a été mise à jour", "success");
		}
	}
	else {
		\core\HTML\flashmessage\FlashMessage::setFlash("Vous n'avez pas l'autorisation de modifier cette page !");
	}
	
	header("location:".ADMWEBROOT."gestion-contenus/modifier-contenu?id=".$_POST['id_page']."&url=".$gestion_contenu->getUrl());