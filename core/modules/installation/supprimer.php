<?php
	$import_module = new \core\modules\ImportModule();
	$import_module->setSupprimerModule($_GET['id_module'], $_GET['systeme']);

	echo("success");