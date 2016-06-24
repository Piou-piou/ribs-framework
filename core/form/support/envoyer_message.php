<?php
	$validator = new \core\form\FormValidator($_POST);
	$validator->Check('objet', 'required');
	$validator->Check('type', 'required');
	$validator->Check('demande', 'required');


	if ($validator->getErrors() !== null) {
		\core\HTML\flashmessage\FlashMessage::setFlash($validator->getErrors());
	}
	else {
		$type = $_POST["type"];
		$objet = $_POST['objet']." de la part de ".$_SERVER['HTTP_HOST'];
		$demande = $_POST['demande'];
		include("message.inc.php");

		\core\App::envoyerMail($config->getMailSite(), $config->getMailAdministrateur(), $objet, $message);

		\core\HTML\flashmessage\FlashMessage::setFlash("Votre message a été correctement envoyé au support et sera traité au plus vite", "success");
	}

	header("location:".ADMWEBROOT."contacter-support");