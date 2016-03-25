<?php
	namespace core\modules;
	use core\App;
	use core\Navigation;

	class GestionModule {
		use CheckVersionModule;

		private $id_module;
		private $url;
		private $icone;
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
		public function getOnlineVersion() {
			return $this->online_version;
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
		 */
		public function getListeModule() {
			$dbc = App::getDb();

			$query = $dbc->select()->from("module")->get();

			if ((is_array($query)) && (count($query) > 0)) {
				$id_module = [];
				$url = [];
				$nom = [];
				$version = [];
				$url_telechargement = [];

				foreach ($query as $obj) {
					$id_module[] = $obj->ID_module;
					$url[] = $obj->url;
					$nom[] = $obj->nom_module;
					$version[] = $obj->version;
					$url_telechargement[] = $obj->url_telechargement;
				}

				$this->setListeModuleActiver($id_module, $url, $version, $nom, null, $url_telechargement);
			}
		}

		/**
		 * @param $nom_module
		 * @return bool
		 * permets de savoir si un module est installé ou non
		 */
		public static function getModuleInstaller($nom_module) {
			$dbc = App::getDb();

			$query = $dbc->select("installer")->from("module")->where("nom_module", "=", $dbc->quote($nom_module), "", true)->get();

			if ((is_array($query)) && (count($query) > 0)) {
				$installer = 0;

				foreach ($query as $obj) {
					$installer = $obj->installer;
				}

				return $installer;
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

			$query = $dbc->select("ID_module")->from("module")->where("url", "=", $dbc->quote($url))->get();

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