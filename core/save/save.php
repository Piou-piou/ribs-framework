<?php
	date_default_timezone_set('Europe/Berlin');

	if (!file_exists(ROOT."bdd_backup")) mkdir(ROOT."bdd_backup");


	if ($config->getLastSave() != date("Y-m-d")) {
		try {
			$dsn = DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME;
			$dump = new \Ifsnop\Mysqldump\Mysqldump($dsn, DB_USER, DB_PASS);
			$dump->start("bdd_backup/save-".date("Y-m-d").".sql");

			$config->setDateSaveToday();
		}
		catch (Exception $e) {
			echo("impossible de faire une save ".$e->getMessage());
		}
	}