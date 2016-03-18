<?php

	$nav = new \core\Navigation();

	foreach ($nav->getNavigation() as $nav) {
		echo($nav[0]." +++ ".$nav[1]);
	}