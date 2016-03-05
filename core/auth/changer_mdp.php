<?php
	namespace core\auth;

	use core\HTML\flashmessage\FlashMessage;

	require("Membre.class.php");

	$membre = new Membre($_SESSION["idlogin".CLEF_SITE]);

	$mdp = $_POST['mdp'];
	$new_mdp = $_POST['mdp_new'];
	$verif_new_mdp = $_POST['verif_mdp_new'];

	if (isset($_POST['admin'])) {
		$membre->setMdp($mdp, $new_mdp, $verif_new_mdp);

		if ($membre->getErreur() != "") {
			FlashMessage::setFlash($membre->getErreur());
			header("location:".ADMWEBROOT."gestion-comptes/mon-compte");
		}
		else {
			Connexion::setDeconnexion(WEBROOT."administrator/login");
			FlashMessage::setFlash("Votre mot de passe a été changé avec succès, vous pouvez vous reconnecter avec votre nouveau mot de passe", "info");
		}
	}
	else {
		$membre->setMdp($mdp, $new_mdp, $verif_new_mdp);

		if ($membre->getErreur() != "") {
			FlashMessage::setFlash($membre->getErreur());
			header("location:index.php");
		}
		else {
			Connexion::setDeconnexion("index.php?page=login");
			FlashMessage::setFlash("Votre mot de passe a été changé avec succès, vous pouvez vous reconnecter avec votre nouveau mot de passe", "info");
		}
	}