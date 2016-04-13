<?php

	if (isset($_SESSION["menu_plie".CLEF_SITE])) {
		$menu_active = $_SESSION["menu_plie".CLEF_SITE];

		if ($menu_active == "plie") {
			$_SESSION["menu_plie".CLEF_SITE] = "deplie";
		}
		else {
			$_SESSION["menu_plie".CLEF_SITE] = "plie";
		}
	}
	else {
		$_SESSION["menu_plie".CLEF_SITE] = "plie";
	}