<?php
	namespace core\modules;
	use core\App;

	class GestionModule {
		use CheckVersionModule;

		private $id_module;
		private $url;
		private $nom;
		private $version;
		private $online_version;
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

			$query = $dbc->query("SELECT * FROM module WHERE activer=1 AND installer=1");

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
		 * @param null $systeme
		 * recupere la listes des modules ajouter par un autre admin
		 * fonction utilisée uniquement dans la config
		 */
		public function getListeModule($systeme = 0) {
			$dbc = App::getDb();

			$query = $dbc->query("SELECT * FROM module WHERE systeme=".$dbc->quote($systeme));

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

			$query = $dbc->query("SELECT * FROM module WHERE nom_module = ".$dbc->quote($nom_module));

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

			$query = $dbc->query("SELECT activer FROM module WHERE nom_module = ".$dbc->quote($nom_module));

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

			$value = array(
				"activer" => $activer,
				"url" => $url
			);

			$dbc->prepare("UPDATE module SET activer=:activer WHERE url=:url", $value);
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}