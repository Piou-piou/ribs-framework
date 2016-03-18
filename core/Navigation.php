<?php
	namespace core;
	class Navigation {
		
		
		
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct() {
			$dbc = App::getDb();

			$query = $dbc->select()->from("navigation")->orderBy("ordre")->get();

			if (is_array($query) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$this->getLienNavigation($obj->ID_page, $obj->ID_module);
				}
			}
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		private function getLienNavigation($id_page, $id_module) {
			$dbc = App::getDb();

			//pour un module
			if ($id_page == "") {
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
			else {
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
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}