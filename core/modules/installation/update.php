<?php
	$import_module = new \core\modules\ImportModule();
	$import_module->setUpdateModule($_GET['id_module']);

	echo("success");