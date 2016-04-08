<?php
	$admin_nav = new \core\admin\navigation\AdminNavigation();
	$admin_nav->setOrdreNavigation($_POST["lien"]);

	echo(\core\HTML\flashmessage\FlashMessage::getFlash());