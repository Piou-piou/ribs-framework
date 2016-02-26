<?php
	if ($config->getContenusDynamique() == 1) {
		$contenu = new \core\contenus\Contenus(1);
		$id_page = $contenu->getIdPage();
		$url = $contenu->getUrl();
		$titre = $contenu->getTitre();
		$parent = $contenu->getParent();
		$balise_title = $contenu->getBaliseTitle();
	}

	$gestion_module = new \core\modules\GestionModule();
	$gestion_module->getListeModuleActiver();

	if (\core\modules\GestionModule::getModuleActiver("galerie photo") == true) {
		$gphoto = new \modules\galerie_photo\app\controller\GaleriePhoto(null, 1);
	}