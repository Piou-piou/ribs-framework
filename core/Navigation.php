<?php
	namespace core;
	class Navigation {
		private $navigation;
		private $last_ordre;
		
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct() {
			$dbc = App::getDb();
			$navigation = [];

			$query = $dbc->select()->from("navigation")->orderBy("ordre")->get();

			if (is_array($query) && (count($query) > 0)) {
				foreach ($query as $obj) {
					if ($obj->ID_page === null) {
						$navigation[] = $this->getLienNavigationModule($obj->ID_module);
					}
					else {
						$navigation[] = $this->getLienNavigationPage($obj->ID_page);
					}
					$last_ordre = $obj->ordre;
				}

				$this->last_ordre = $last_ordre;
				$this->setNavigation($navigation);
			}
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getNavigation() {
			return $this->navigation;
		}

		private function getLienNavigationPage($id_page) {
			$dbc = App::getDb();

			$query = $dbc->select()
				->from("navigation")
				->from("page")
				->where("navigation.ID_page", "=", "page.ID_page", "AND")
				->where("page.ID_page", "=", $id_page, "AND")
				->where("page.affiche", "=", 1)
				->get();

			if (is_array($query) && (count($query) > 0)) {
				foreach ($query as $obj) {
					return [$obj->titre,$obj->url];
				}
			}
		}

		private function getLienNavigationModule($id_module) {
			$dbc = App::getDb();

			$query = $dbc->select()
				->from("navigation")
				->from("module")
				->where("navigation.ID_module", "=", "module.ID_module", "AND")
				->where("module.ID_module", "=", $id_module, "AND")
				->where("module.installer", "=", 1, "AND")
				->where("module.activer", "=", 1)
				->get();

			if (is_array($query) && (count($query) > 0)) {
				foreach ($query as $obj) {
					return [$obj->nom_module,$obj->url];
				}
			}
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		private function setNavigation($navigation) {
			$this->navigation = $navigation;
		}

		public function setTestAjoutLien($id, $value_id, $afficher) {
			$dbc = App::getDb();

			if ($afficher != null) {
				$dbc->insert($id, $value_id)->insert("ordre", $this->last_ordre+1)->into("navigation")->set();
			}
		}

		public function setSupprimerLien($id, $value_id) {echo("$id, $value_id");
			$dbc = App::getDb();

			$dbc->delete()->from("navigation")->where($id, "=", $value_id)->del();
		}
		//-------------------------- END SETTER ----------------------------------------------------------------------------//
	}