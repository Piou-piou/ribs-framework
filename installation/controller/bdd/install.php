<?php
	$bdd = new \installation\controller\InstallRibs($_POST['db_type'], $_POST['db_host'], $_POST['db_name'], $_POST['db_user'], $_POST['db_pass']);

	if ($bdd->getErreur() != "") {
		$_SESSION['db_type'] = $_POST['db_type'];
		$_SESSION['db_host'] = $_POST['db_host'];
		$_SESSION['db_name'] = $_POST['db_name'];
		$_SESSION['db_user'] = $_POST['db_user'];
		$_SESSION['db_pass'] = $_POST['db_pass'];
		$_SESSION['err_db'] = true;

		header("location:".WEBROOT."installation-ribs/bdd");
	}
	else {
		header("location:".WEBROOT."installation/configuration");
	}