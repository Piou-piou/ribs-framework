<?php
	namespace core;
	class Navigation {
		private $navigation;
		private $last_ordre;
		
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct($no_module = null) {
			$dbc = App::getDb();
			$navigation = [];
			$last_ordre = "";

			if ($no_module === null) {
				$query = $dbc->select()->from("navigation")->orderBy("ordre")->get();
			}
			else {
				$query = $dbc->select()->from("navigation")->where("ID_page", " IS NOT ", "NULL", "", true)->orderBy("ordre")->get();
			}

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
				->where("page.ID_page", "=", $id_page, "AND")
				->where("page.affiche", "=", 1, "AND")
				->where("page.parent", "=", 0, "AND")
				->where("navigation.ID_page", "=", "page.ID_page", "", true)
				->get();

			if (is_array($query) && (count($query) > 0)) {
				foreach ($query as $obj) {
					return [$obj->ID_page, $obj->titre, $obj->url, $obj->balise_title, $this->getSousMenu($id_page)];
				}
			}
		}

		private function getSousMenu($id_page) {
			$dbc = App::getDb();
			$sous_menu = [];

			$query = $dbc->select()
				->from("page")
				->where("parent", "=", $id_page, "AND")
				->where("affiche", "=", 1)
				->get();

			if (is_array($query) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$sous_menu[] = [$obj->ID_page, $obj->titre, $obj->url, $obj->balise_title, ];
				}
			}

			return $sous_menu;
		}

		private function getLienNavigationModule($id_module) {
			$dbc = App::getDb();

			$query = $dbc->select()
				->from("navigation")
				->from("module")
				->where("module.ID_module", "=", $id_module, "AND")
				->where("module.installer", "=", 1, "AND")
				->where("module.activer", "=", 1, "AND")
				->where("navigation.ID_module", "=", "module.ID_module", "", true)
				->get();

			if (is_array($query) && (count($query) > 0)) {
				foreach ($query as $obj) {
					return [$obj->ID_module, $obj->nom_module, $obj->url];
				}
			}
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		private function setNavigation($navigation) {
			$this->navigation = $navigation;
		}

		public function setAjoutLien($id, $value_id) {
			$dbc = App::getDb();

			$dbc->insert($id, $value_id)->insert("ordre", $this->last_ordre + 1)->into("navigation")->set();
		}

		public function setSupprimerLien($id, $value_id) {
			$dbc = App::getDb();

			$dbc->delete()->from("navigation")->where($id, "=", $value_id)->del();
		}
		//-------------------------- END SETTER ----------------------------------------------------------------------------//
	}