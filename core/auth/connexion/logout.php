<?php
	namespace core\auth;
	
	use core\HTML\flashmessage\FlashMessage;
	
	FlashMessage::setFlash("Vous avez été déconnecté avec succès", "success");
	Connexion::setDeconnexion(WEBROOT."index.php");