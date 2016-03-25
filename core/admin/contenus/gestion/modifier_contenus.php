<?php
	$gestion_contenu = new \core\admin\contenus\GestionContenus();
	$contenu_class = new \core\contenus\Contenus();
	$droit_acces = new \core\admin\droitsacces\DroitAcces();

	if ($droit_acces->getDroitAccesContenu("GESTION CONTENU PAGE", $_POST['id_page']) == true) {
		if ((($droit_acces->getModifSeo() != 0) && ($droit_acces->getModifContenu() != 0) && ($droit_acces->getModifNavigation() != 0)) || $droit_acces->getSuperAdmin() == 1) {
			$balise_title = $_POST['balise_title'];
			$url = $_POST['url'];
			$meta_description = $_POST['meta_description'];
			$titre_page = $_POST['titre_page'];
			$parent = $_POST['parent_texte'];
			$contenu = $_POST['contenu'];
		}
		else {
			$contenu_class->getHeadPage($_POST['id_page']);
			$contenu_class->getContenuPage($_POST['id_page']);

			if ($droit_acces->getModifSeo() != 0) {
				$balise_title = $_POST['balise_title'];
				$url = $_POST['url'];
				$meta_description = $_POST['meta_description'];
			}
			else {
				$balise_title = $contenu_class->getBaliseTitle();
				$url = $contenu_class->getUrl();
				$meta_description = $contenu_class->getMetaDescription();
			}

			if ($droit_acces->getModifContenu() != 0) {
				$contenu = $_POST['contenu'];
			}
			else {
				$contenu = $contenu_class->getContenu();
			}

			if ($droit_acces->getModifNavigation() != 0) {
				$titre_page = $_POST['titre_page'];
				$parent = $_POST['parent_texte'];
			}
			else {
				$titre_page = $contenu_class->getTitre();
				$parent = $contenu_class->getParent();
			}
		}

		$gestion_contenu->setModifierPage($_POST['id_page'], $balise_title, $url, $meta_description, $titre_page, $parent, $contenu);

		if ((\core\App::getErreur() !== true) && ($gestion_contenu->getErreur() !== true)) {
			\core\HTML\flashmessage\FlashMessage::setFlash("La page ".$_POST['titre_page']." a été mise à jour", "success");
		}
	}
	else {
		\core\HTML\flashmessage\FlashMessage::setFlash("Vous n'avez pas l'autorisation de modifier cette page !");
	}

	header("location:".ADMWEBROOT."gestion-contenus/modifier-contenu?id=".$_POST['id_page']);