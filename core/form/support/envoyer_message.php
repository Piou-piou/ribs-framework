<?php
	$validator = new \core\form\FormValidator($_POST);
	$validator->Check('objet', 'required');
	$validator->Check('type', 'required');
	$validator->Check('demande', 'required');


	if ($validator->getErrors()) {
		\core\HTML\flashmessage\FlashMessage::setFlash($validator->getErrors());
	}
	else {
		$mail = new \core\mail\Mail($config->getMailAdministrateur());
		$type= $_POST["type"];
		$objet = $_POST['objet']." de la part de ".$_SERVER['HTTP_HOST'];
		$demande = $_POST['demande'];

		include("message.inc.php");

		if ($mail->setEnvoyerMail($objet, $message) === true) {
			\core\HTML\flashmessage\FlashMessage::setFlash("Votre message a été correctement envoyé au support et sera traité au plus vite", "success");
		}
		else {
			\core\HTML\flashmessage\FlashMessage::setFlash("Il y a eu un problème lors de l'envoi de votre E-mail, veuillez réesseyer dans un moment");
		}
	}

	header("location:".ADMWEBROOT."contacter-support");