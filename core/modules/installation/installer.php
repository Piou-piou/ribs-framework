<?php
	$import_module = new \core\modules\ImportModule();
	$import_module->setImportModule($_GET['url']);

	echo("success");
?>