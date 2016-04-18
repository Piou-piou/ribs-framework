<?php
	session_start();
	if ($page == "bdd") {
		if (isset($_SESSION['err_db'])) {
			$db_type = $_SESSION['db_type'];
			$db_host = $_SESSION['db_host'];
			$db_name = $_SESSION['db_name'];
			$db_user = $_SESSION['db_user'];
			$db_pass = $_SESSION['db_pass'];
			unset($_SESSION['err_db']);
		}
		else {
			$db_type = null;
			$db_host = null;
			$db_name = null;
			$db_user = null;
			$db_pass = null;
		}
	}