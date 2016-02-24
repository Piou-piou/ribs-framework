<?php

	$ini = new \core\iniparser\IniParser();

	$dev_info = [
		$_POST["db_type_dev"],
		$_POST["db_name_dev"],
		$_POST["db_user_dev"],
		$_POST["db_pass_dev"],
		$_POST["db_host_dev"],
		"/plugins/ribs-framework/app/images/",
		"ribs-framework/app/images/pages"
	];

	$prod_info = [
		$_POST["db_type_prod"],
		$_POST["db_name_prod"],
		$_POST["db_user_prod"],
		$_POST["db_pass_prod"],
		$_POST["db_host_prod"],
		"/app/images/",
		"/app/images/pages"
	];

	$ini->setModifierConfigIni($_POST["developpement"], $dev_info, $prod_info);

	header("location:".ADMWEBROOT."configuration/base-données");
?>