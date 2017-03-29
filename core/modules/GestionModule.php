<?php
	namespace core\modules;
	use core\App;
	use core\Navigation;

	class GestionModule {
		private $id_module;
		private $url;
		private $icone;
		private $nom;
		private $version;
		private $url_telechargement;
		
		
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getIdModule() {
			return $this->id_module;
		}
		public function getUrl() {
			return $this->url;
		}
		public function getNom() {
			return $this->nom;
		}
		public function getVersion() {
			return $this->version;
		}
		public function getIcone() {
			return $this->icone;
		}
		public function getUrlTelechargement() {
			return $this->url_telechargement;
		}

		/**
		 * récupere la liste des modules activé utilisé pour toutes les pages
		 */
		public function getListeModuleActiver() {
			$dbc = App::getDb();
			$query = $dbc->select()->from("module")->where("activer", "=", 1, "AND")->where("installer", "=", 1)->get();

			if ((is_array($query)) && (count($query) > 0)) {
				$id_module = [];
				$url = [];
				$nom = [];
				$version = [];
				$icone = [];

				foreach ($query as $obj) {
					$id_module[] = $obj->ID_module;
					$url[] = $obj->url;
					$nom[] = $obj->nom_module;
					$version[] = $obj->version;
					$icone[] = $obj->icone;
				}

				$this->setListeModuleActiver($id_module, $url, $version, $nom, $icone);
			}
		}

		/**
		 * fonction qui renvoi la liste de tous les modules
		 */
		public function getListeModule() {
			$dbc = App::getDb();

			$query = $dbc->select()->from("module")->get();

			if ((is_array($query)) && (count($query) > 0)) {
				$values = [];
				foreach ($query as $obj) {
					$values[] = [
						"id_module" => $obj->ID_module,
						"url" => $obj->url,
						"nom" => $obj->nom_module,
						"version" => $obj->version,
						"icone" => $obj->icone,
						"activer" => $obj->activer,
						"installer" => $obj->installer
					];
				}
				App::setValues(["active_modules" => $values]);
			}
		}

		/**
		 * @param $nom_module
		 * @return boolean|null
		 * return true si le module est activer sinon false
		 */
		public static function getModuleActiver($nom_module) {
			$dbc = App::getDb();

			$query = $dbc->select("activer")->from("module")->where("nom_module", "=", $dbc->quote($nom_module), "", true)->get();

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					if ($obj->activer == 1) {
						return true;
					}
					else {
						return false;
					}
				}
			}
		}

		private static function getUrlToId($url) {
			$dbc = App::getDb();

			$query = $dbc->select("ID_module")->from("module")->where("url", "=", $url)->get();

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					return $obj->ID_module;
				}
			}
		}


		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		private function setListeModuleActiver($id_module, $url, $version, $nom, $icone = null, $url_telechargement = null) {
			$this->id_module = $id_module;
			$this->url = $url;
			$this->nom = $nom;
			$this->version = $version;
			$this->icone = $icone;
			$this->url_telechargement = $url_telechargement;
		}

		/**
		 * @param $activer
		 * @param $url
		 * fonction qui permet d'activer || désactiver un module
		 */
		public static function setActiverDesactiverModule($activer, $url) {
			$dbc = App::getDb();

			$dbc->update("activer", $activer)->from("module")->where("url", "=", $url)->set();

			$nav = new Navigation();

			if ($activer == 1) {
				$nav->setAjoutLien("ID_module", self::getUrlToId($url));
			}
			else {
				$nav->setSupprimerLien("ID_module", self::getUrlToId($url));
			}
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}