<?php
	$bdd = new \installation\controller\InstallRibs($_POST['db_type'], $_POST['db_host'], $_POST['db_name'], $_POST['db_user'], $_POST['db_pass']);

	if ($bdd->getErreur() != "") {
		header("location:".WEBROOT."installation-ribs/bdd");
	}