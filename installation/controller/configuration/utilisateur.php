<?php
	$user = new \installation\controller\InstallUtilisateur($_POST['nom'], $_POST['prenom'], $_POST['pseudo'], $_POST['mdp'], $_POST['verif_mdp']);

	if ($user->getErreur() == true) {
		header("location:".WEBROOT."installation-ribs/utilisateur");
	}
	else {
		header("location:".WEBROOT."administrator");
	}