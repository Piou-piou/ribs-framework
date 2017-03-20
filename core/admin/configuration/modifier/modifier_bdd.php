<?php

	$ini = new \core\iniparser\IniParser();

	$dev_info = [
		$_POST["db_type_dev"],
		$_POST["db_name_dev"],
		$_POST["db_user_dev"],
		$_POST["db_pass_dev"],
		$_POST["db_host_dev"]
	];

	$ini->setModifierConfigIni($_POST["developpement"], $dev_info);

	header("location:".ADMWEBROOT."configuration/base-de-donnees");