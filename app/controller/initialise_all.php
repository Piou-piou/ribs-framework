<?php
	$gestion_module = new \core\modules\GestionModule();
	$gestion_module->getListeModuleActiver();

	if (\core\modules\GestionModule::getModuleActiver("galerie photo") == true) {
		$gphoto = new \modules\galerie_photo\app\controller\GaleriePhoto(null, 1);
	}