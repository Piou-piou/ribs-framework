<?php
	namespace core\modules;
	use core\App;

	class GestionModule {
		private $id_module;
		private $url;
		private $nom;
		private $version;
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

			if (count($query) > 0) {
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
		 * recupere la listes des modules ajouter par un autre admin
		 * fonction utilisée uniquement dans la config
		 */
		public function getListeModule() {
			$dbc = App::getDb();

			$query = $dbc->query("SELECT * FROM module WHERE systeme IS NULL");

			if (count($query) > 0) {
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
		 * recupere la listes des modules systeme
		 * fonction utilisée uniquement dans la config
		 */
		public function getListeModuleSysteme() {
			$dbc = App::getDb();

			$query = $dbc->query("SELECT * FROM module WHERE systeme = 1");

			if (count($query) > 0) {
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

			if (count($query) > 0) {
				foreach ($query as $obj) {
					$installer = $obj->installer;
				}

				if ($installer == 1) {
					return true;
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}

		/**
		 * @param $nom_module
		 * @return bool
		 * return true si le module est activer sinon false
		 */
		public static function getModuleActiver($nom_module) {
			$dbc = App::getDb();

			$query = $dbc->query("SELECT activer FROM module WHERE nom_module = ".$dbc->quote($nom_module));

			foreach ($query as $obj) {
				if ($obj->activer == 1) {
					return true;
				}
				else {
					return false;
				}
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		private function setListeModuleActiver($id_module, $url, $version, $nom, $icone=null, $url_telechargement=null) {
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