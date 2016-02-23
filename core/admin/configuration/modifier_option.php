<?php
	$config = new \core\admin\configuration\AdminConfiguration();
	$config->setModificerOption($_GET['option'], $_GET['activer']);

	echo("success");
?>