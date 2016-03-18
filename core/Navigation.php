<?php
	namespace core;
	class Navigation {
		
		
		
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct() {
			$dbc = App::getDb();

			$query = $dbc->select()->from("navigation")->orderBy("ordre")->get();

			if (is_array($query) && (count($query) > 0)) {
				foreach ($query as $obj) {
					if ($obj->ID_page === null) {
						$this->getLienNavigationModule($obj->ID_module);
					}
					else {
						$this->getLienNavigationPage($obj->ID_page);
					}
				}
			}
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		private function getLienNavigationPage($id_page) {
			$dbc = App::getDb();

			$query = $dbc->select()
				->from("navigation")
				->from("page")
				->where("navigation.ID_page", "=", "page.ID_page", "AND")
				->where("page.ID_page", "=", $id_page)
				->get();

			if (is_array($query) && (count($query) > 0)) {
				foreach ($query as $obj) {
					echo($obj->titre." ++ ".$obj->url."<br>");
				}
			}
		}

		private function getLienNavigationModule($id_module) {
			$dbc = App::getDb();

			$query = $dbc->select()
				->from("navigation")
				->from("module")
				->where("navigation.ID_module", "=", "module.ID_module", "AND")
				->where("module.ID_module", "=", $id_module)
				->get();

			if (is_array($query) && (count($query) > 0)) {
				foreach ($query as $obj) {
					echo($obj->nom_module." ++ ".$obj->url."<br>");
				}
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}