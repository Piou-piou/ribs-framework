<?php
	$pseudo = $_POST['pseudo'];
	$mdp = $_POST['mdp'];

	if (isset($_POST['admin'])) {
		\core\auth\Connexion::setLogin($pseudo, $mdp, WEBROOT."administrator/login", WEBROOT."administrator", 0);
	}
	else {
		\core\auth\Connexion::setLogin($pseudo, $mdp, WEBROOT."login", WEBROOT."index.php", 0);
	}