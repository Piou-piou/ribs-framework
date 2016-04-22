<?php
	$config = new \installation\controller\InstallConfiguration($_POST['nom_site'], $_POST['url_site'], $_POST['gerant_site'], $_POST['mail_site'], $_POST['mail_administrateur']);

	header("location:".WEBROOT."installation-ribs/utilisateur");