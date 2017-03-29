<?php
	namespace core;
	use core\functions\ChaineCaractere;

	class Navigation {
		private $last_ordre;
		
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		/**
		 * Navigation constructor.
		 * @param null $no_module
		 * to init get navigation link (if no module != null) whe only get page it's for admin content gestion pages
		 */
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

			if (count($query) > 0) {
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
				
				App::setValues(["navigation" => $navigation]);
			}
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * @param $id_page
		 * @return array
		 * to get the navigation link of pages of the website
		 */
		private function getLienNavigationPage($id_page) {
			$dbc = App::getDb();
			$query = $dbc->select()->from("navigation")->from("page")->where("page.ID_page", "=", $id_page, "AND")->where("page.affiche", "=", 1, "AND")->where("page.parent", "=", 0, "AND")->where("navigation.ID_page", "=", "page.ID_page", "", true)->get();
			if (is_array($query) && (count($query) > 0)) {
				$nav = [];
				foreach ($query as $obj) {
					$nav = [
						"id" => $obj->ID_page,
						"titre" => $obj->titre,
						"lien_page" => $this->getLienPage($obj->url),
						"url" => $obj->url,
						"balise_title" => $obj->balise_title,
						"sous_menu" => $this->getSousMenu($id_page),
						"type" => "page",
						"target" => $obj->target,
					];
				}
				return $nav;
			}
		}

		/**
		 * @param $id_page
		 * @return array
		 * to get the sub navigation of a page which have it
		 */
		private function getSousMenu($id_page) {
			$dbc = App::getDb();
			$sous_menu = [];

			$query = $dbc->select()->from("page")->where("parent", "=", $id_page, "AND")->where("affiche", "=", 1)->get();

			if (is_array($query) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$sous_menu[] = [
						"id" => $obj->ID_page,
						"titre" => $obj->titre,
						"lien_page" => $this->getLienPage($obj->url),
						"url" => $obj->url,
						"balise_title" => $obj->balise_title,
						"type" => "page",
						"target" => $obj->target,
					];
				}
			}
			return $sous_menu;
		}

		/**
		 * @param $id_module
		 * @return array
		 * to get the navigation link of modules of the website
		 */
		private function getLienNavigationModule($id_module) {
			$dbc = App::getDb();

			$query = $dbc->select()->from("navigation")->from("module")->where("module.ID_module", "=", $id_module, "AND")->where("module.installer", "=", 1, "AND")->where("module.activer", "=", 1, "AND")->where("navigation.ID_module", "=", "module.ID_module", "", true)->get();

			if (is_array($query) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$nav = [
						"id" => $obj->ID_module,
						"titre" => $obj->nom_module,
						"lien_page" => $this->getLienPage($obj->url),
						"balise_title" => $obj->nom_module,
						"type" => "module",
						"target" => $obj->target,
					];
					return $nav;
				}
			}
		}

		/*to verify if page exist*/
		private function getLienPageExist($id_page) {
			$dbc = App::getDb();

			$query = $dbc->select("ID_page")->from("navigation")->where("ID_page", "=", $id_page)->get();

			if (count($query) < 1) {
				return false;
			}

			return true;
		}

		private function getLienPage($url) {
			if (ChaineCaractere::FindInString($url, "http://")) {
				return $url;
			}
			else {
				return WEBROOT.$url;
			}
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @param $id
		 * @param $value_id
		 * to add a link in navigation table
		 */
		public function setAjoutLien($id, $value_id) {
			$dbc = App::getDb();

			if ($this->getLienPageExist($id) === false) {
				$dbc->insert($id, $value_id)->insert("ordre", $this->last_ordre+1)->into("navigation")->set();
			}
		}

		/**
		 * @param $id
		 * @param $value_id
		 * to delete a link in navigation table
		 */
		public function setSupprimerLien($id, $value_id) {
			$dbc = App::getDb();

			$dbc->delete()->from("navigation")->where($id, "=", $value_id)->del();
		}
		//-------------------------- END SETTER ----------------------------------------------------------------------------//
	}