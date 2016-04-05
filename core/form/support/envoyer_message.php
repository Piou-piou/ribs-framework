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

		$mail_test = new \Nette\Mail\Message();
		$mail_test->setFrom($config->getMailSite())
			->addTo($config->getMailAdministrateur())
			->setSubject($objet)
			->setHtmlBody($message);

		$mailer = new \Nette\Mail\SmtpMailer();
		$mailer->send($mail_test);

		\core\HTML\flashmessage\FlashMessage::setFlash("Votre message a été correctement envoyé au support et sera traité au plus vite", "success");
	}

	header("location:".ADMWEBROOT."contacter-support");