<?php


	$dbc = \core\App::getDb();
	$query = $dbc->select()
		->from("navigation")
		->from("page")
		->where("navigation.ID_page", "=", "page.ID_page", "AND")
		->where("page.ID_page", "=", 1, "AND")
		->where("page.affiche", "=", 1, "AND")
		->where("page.parent", "=", 0)
		->get();

	foreach ($query as $obj) {
		echo("dgfdgf".$obj->ID_page);
	}
