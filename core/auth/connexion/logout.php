<?php
	namespace core\auth;
	
	FlashMessage::setFlash("Vous avez été déconnecté avec succès", "success");
	Connexion::setDeconnexion(WEBROOT."index.php");