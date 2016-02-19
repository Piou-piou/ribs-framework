<?php
	$config = new \core\Configuration();
	$config->setModifierConfiguration($_POST['nom_site'], $_POST['url_site'], $_POST['gerant_site'], $_POST['mail_site'], $_POST['mail_administrateur']);

	header("location:".ADMWEBROOT."configuration/infos-generales");
?>