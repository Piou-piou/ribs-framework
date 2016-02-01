<?php
	\core\modules\GestionModule::setActiverDesactiverModule($_GET['activer'], $_GET['url_module']);

	echo("success");
?>