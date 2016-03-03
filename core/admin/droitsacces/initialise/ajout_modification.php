<?php
	if (isset($_SESSION['err_modification_droitsacces'])) {

		unset($_SESSION['err_modification_droitsacces']);
	}
	else if ($page == "gestion-droits-acces/modifier-liste") {
		$gestion_droit_acces = new \core\admin\droitsacces\GestionDroitAcces($_GET['id_liste']);
	}
	else {
		$balise_title = null;
		$url = null;
		$meta_description = null;
		$titre_courant = null;
		$article = null;
	}