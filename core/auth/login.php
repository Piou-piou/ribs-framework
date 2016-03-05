<?php
	namespace core\auth;


	$pseudo = $_POST['pseudo'];
	$mdp = $_POST['mdp'];

	if (isset($_POST['admin'])) {
		Connexion::setLogin($pseudo, $mdp, WEBROOT."administrator/login", WEBROOT."administrator", 0);
	}
	else {
		Connexion::setLogin($pseudo, $mdp, WEBROOT."login", WEBROOT."index.php", 0);
	}