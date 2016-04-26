<?php
	$user = new \installation\controller\InstallUtilisateur($_POST['nom'], $_POST['prenom'], $_POST['pseudo'], $_POST['mdp'], $_POST['verif_mdp']);

	if ($user->getErreur() == true) {
		$_SESSION['nom'] = $_POST['nom'];
		$_SESSION['prenom'] = $_POST['prenom'];
		$_SESSION['pseudo'] = $_POST['pseudo'];
		$_SESSION['err_user'] = true;

		header("location:".WEBROOT."installation-ribs/utilisateur");
	}
	else {
		\core\App::supprimerDossier(ROOT."installation");

		header("location:".WEBROOT."administrator");
	}