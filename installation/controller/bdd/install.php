<?php
	$bdd = new \installation\controller\InstallRibs($_POST['db_type'], $_POST['db_host'], $_POST['db_name'], $_POST['db_user'], $_POST['db_pass']);

	echo \core\HTML\flashmessage\FlashMessage::getFlash();