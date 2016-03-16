<?php
	namespace core\modules;
	use core\App;

	class GestionModule {
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
		 * recupere la listes des modules ajouter par un autre admin
		 * fonction utilisée uniquement dans la config
		 */
		public function getListeModule() {
			$dbc = App::getDb();

			$query = $dbc->query("SELECT * FROM module WHERE systeme IS NULL");

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
		 * recupere la listes des modules systeme
		 * fonction utilisée uniquement dans la config
		 */
		public function getListeModuleSysteme() {
			$dbc = App::getDb();

			$query = $dbc->query("SELECT * FROM module WHERE systeme = 1");

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
			else {
				return false;
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

		/**
		 * @param $nom_module
		 * @return boolean|null
		 * fonction qui permet de savoir si un module est à jour ou non
		 * si a jour renvoi true sinon renvoi false
		 */
		public static function getModuleAJour($nom_module) {
			$dbc = App::getDb();

			$query = $dbc->query("SELECT mettre_jour FROM module WHERE nom_module = ".$dbc->quote($nom_module));

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					if ($obj->mettre_jour == 1) {
						return false;
					}
					else {
						return true;
					}
				}
			}
		}

		/**
		 * fonction qui se lance à chaquer fois que l'on ouvre l'admin
		 * permet de tester si tous les modules présent sur le site sont bien à jour
		 */
		public function getCheckModuleVersion() {
			$dbc = App::getDb();
			$today = date("Y-m-d");
			$today_o = new \DateTime($today);

			$query = $dbc->query("SELECT next_check_version, version, url_telechargement, mettre_jour, delete_old_version, ID_module FROM module");

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					if ($obj->next_check_version == null) {
						//si pas de version a checker, cela veut dire qu'on vient d'installer le module
						//du coup on met le next_check aa la semaine pro
						$set_next = true;
					}
					else if (($obj->next_check_version <= $today) && ($obj->mettre_jour != 1)) {
						//avant tout on regarde si on doit delete une vieille version
						if ($obj->delete_old_version == 1) {
							$import = new ImportModule();
							$import->setSupprimerOldModule($obj->ID_module);
						}

						//on recupere le nom du dossier + extention
						$explode = explode(".", $obj->url_telechargement);
						array_pop($explode);

						$version_txt = implode(".", $explode)."_version.txt";

						if (file_get_contents($version_txt) !== "") {

							//online pour bdd
							$version_online_txt = file_get_contents($version_txt);

							$version_online = floatval($version_online_txt);
							$version_site = floatval($obj->version);

							//la version sur le serveur de telechargement est plus récente, on va donc proposer
							//en passant la valeur update a 1 dans la table module pour ce module
							// au client de mettre a jour sa version sinon on met la next check a la semaine pro
							if ($version_online > $version_site) {
								$value = [
									"update" => 1,
									"online_version" => $version_online_txt,
									"id_module" => $obj->ID_module
								];

								//on met la notification admin à 1
								$dbc->query("UPDATE notification SET admin=1 WHERE ID_notification=1");

								$dbc->prepare("UPDATE module SET mettre_jour=:update, online_version=:online_version WHERE ID_module=:id_module", $value);

								$set_next = true;
							}
							else {
								$set_next = true;
							}
						}
					}

					if ((isset($set_next)) && ($set_next === true)) {
						$value = [
							"next_check" => $today_o->add(new \DateInterval("P1W"))->format("Y-m-d"),
							"id_module" => $obj->ID_module
						];

						$dbc->prepare("UPDATE module SET next_check_version=:next_check WHERE ID_module=:id_module", $value);
					}
				}
			}
		}

		public function getListeModuleMettreJour() {
			$dbc = App::getDb();

			$query = $dbc->query("SELECT * FROM module WHERE mettre_jour=1");

			if ((is_array($query)) && (count($query) > 0)) {
				$nom_module = [];
				$version = [];
				$online_version = [];

				foreach ($query as $obj) {
					$nom_module[] = $obj->nom_module;
					$version[] = $obj->version;
					$online_version[] = $obj->online_version;
				}

				$this->setListeModuleMettreJour($nom_module, $version, $online_version);

				return true;
			}
			else {
				return false;
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

		private function setListeModuleMettreJour($nom_module, $version, $online_version) {
			$this->nom = $nom_module;
			$this->version = $version;
			$this->online_version = $online_version;
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