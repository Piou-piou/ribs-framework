<?php
	namespace core\admin\navigation;

	use core\App;
	use core\HTML\flashmessage\FlashMessage;
	use core\Navigation;

	class AdminNavigation extends Navigation {

		public function setOrdreNavigation($nav) {
			$dbc = App::getDb();
			$count_nav = count($nav);

			for ($i = 0 ; $i < $count_nav ; $i++) {
				$lien = explode(".", $nav[$i]);

				if ($lien[1] == "page") {
					$dbc->update("ordre", $i+1)->from("navigation")->where("ID_page", "=", $lien[0])->set();
				}
				else {
					$dbc->update("ordre", $i+1)->from("navigation")->where("ID_module", "=", $lien[0])->set();
				}
			}

			FlashMessage::setFlash("La navigation a été correctement mise à jour", "success");
		}
	}