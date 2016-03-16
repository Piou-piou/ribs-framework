<?php
	date_default_timezone_set('Europe/Berlin');

	if (!file_exists(ROOT."bdd_backup")) mkdir(ROOT."bdd_backup");


	if ($config->getLastSave() != date("Y-m-d")) {
		try {
			$dump = new \core\save\Mysqldump(DB_NAME, DB_USER, DB_PASS, DB_HOST);
			$dump->start("bdd_backup/save-".date("Y-m-d").".sql");

			$config->setDateSaveToday();
		}
		catch (Exception $e) {
			echo("impossible de faire une save ".$e->getMessage());
		}
	}