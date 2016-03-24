<?php
	print_r($_GET);

	$import_module = new \core\modules\ImportModule();
	$import_module->setSupprimerModule($_GET['id_module']);

	echo("success");