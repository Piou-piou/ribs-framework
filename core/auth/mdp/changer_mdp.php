<?php
	use core\HTML\flashmessage\FlashMessage;

	$membre = new \core\auth\Membre($_SESSION["idlogin".CLEF_SITE]);

	$mdp = $_POST['mdp'];
	$new_mdp = $_POST['mdp_new'];
	$verif_new_mdp = $_POST['verif_mdp_new'];

	if (isset($_POST['admin'])) {
		$membre->setMdp($mdp, $new_mdp, $verif_new_mdp);

		if ($membre->getErreur() != "") {
			FlashMessage::setFlash($membre->getErreur());
			header("location:".ADMWEBROOT."configuration/mon-compte");
		}
		else {
			\core\auth\Connexion::setDeconnexion(WEBROOT."administrator/login");
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
			\core\auth\Connexion::setDeconnexion("index.php?page=login");
			FlashMessage::setFlash("Votre mot de passe a été changé avec succès, vous pouvez vous reconnecter avec votre nouveau mot de passe", "info");
		}
	}