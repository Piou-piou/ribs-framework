<?php
	$droit_acces = new \core\admin\droitsacces\GestionDroitAcces();
	$droit_acces->setGestionDroitAccesListe($_POST['id_droit'], $_POST['id_liste'], $_POST['checked']);
	
	echo \core\HTML\flashmessage\FlashMessage::getFlash();