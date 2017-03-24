<?php

	$datas = [
		 ["nom", $_POST['nom'], "required"],
		 ["prenom", $_POST['prenom'], "required"],
		 ["pseudo", $_POST['pseudo'], "required"],
		 ["mdp", $_POST['mdp'], "required"],
		 ["mail", $_POST['mail'], "required"],
		 ["RetapeMdp", $_POST['verif_mdp']],
		 ["AccesAdministration", $_POST['acces_admin']],
		 ["ListeDroitAcces", $_POST['liste_acces']]
	];

	$inscription = new \core\admin\inscription\AdminInscription($datas);


	if ($inscription->getErreur()) {
		$_SESSION['err_ajout_utilisateur'] = true;
		$_SESSION['nom'] = $_POST['nom'];
		$_SESSION['prenom'] = $_POST['prenom'];
		$_SESSION['pseudo'] = $_POST['pseudo'];
		$_SESSION['mail'] = $_POST['mail'];

		\core\HTML\flashmessage\FlashMessage::setFlash("<ul>".$inscription->getErreur()."</ul>");
	}
	else {
		\core\HTML\flashmessage\FlashMessage::setFlash("L'utilisateur ".$inscription->getNom()." ".$inscription->getPrenom()."a bien été inscrit", "success");
		$inscription->setInscrireUtilisateur();
	}

	header("location:".ADMWEBROOT."gestion-comptes/creer-utilisateur");