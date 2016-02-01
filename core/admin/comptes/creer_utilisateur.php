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
		session_start();
		$_SESSION['err_ajout_utilisateur'] = true;
		$_SESSION['nom'] = $inscription->getNom();
		$_SESSION['prenom']= $inscription->getPrenom();
		$_SESSION['pseudo'] = $inscription->getPseudo();
		$_SESSION['mail'] = $inscription->getMail();
		$_SESSION['acces_admin'] = $inscription->getAccesAdministration();
		//$id_liste_droit_acces = $_SESSION['id_liste_droit_acces'];
		\core\HTML\flashmessage\FlashMessage::setFlash("<ul>".$inscription->getErreur()."</ul>");
	}
	else {
		\core\HTML\flashmessage\FlashMessage::setFlash("L'utilisateur ".$inscription->getNom()." ".$inscription->getPrenom()."a bien été inscrit");
		$inscription->setInscrireUtilisateur();
	}

	header("location:".ADMROOT."gestion-comptes/creer-utilisateur");
?>