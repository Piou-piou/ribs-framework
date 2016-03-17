<?php
	namespace core\modules;
	
	
	use core\App;

	trait CheckVersionModule {
		private $nom;
		private $version;
		private $online_version;

		//-------------------------- GETTER ----------------------------------------------------------------------------//
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
					return $obj->mettre_jour;
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
		}

		/**
		 * fonction qui se lance à chaquer fois que l'on ouvre l'admin
		 * permet de tester si tous les modules présent sur le site sont bien à jour
		 */
		public function getCheckModuleVersion() {
			$dbc = App::getDb();
			$today = date("Y-m-d");

			$query = $dbc->query("SELECT next_check_version, version, url_telechargement, mettre_jour, delete_old_version, ID_module FROM module");

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					if ($obj->next_check_version == null) {
						//si pas de version a checker, cela veut dire qu'on vient d'installer le module
						//du coup on met le next_check aa la semaine pro
						$this->setNextCheckUpdate($obj->ID_module);
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

						$this->getCheckModuleUpToDate($version_txt, $obj->version, $obj->ID_module);
					}
				}
			}
		}



		//-------------------------- SETTER ----------------------------------------------------------------------------//
		private function setListeModuleMettreJour($nom_module, $version, $online_version) {
			$this->nom = $nom_module;
			$this->version = $version;
			$this->online_version = $online_version;
		}

		/**
		 * @param $id_module
		 * fonction qui permet de palnnifier la nouvelle check de si il il y aa une new maj du module
		 */
		private function setNextCheckUpdate($id_module) {
			$dbc = App::getDb();
			$today_o = new \DateTime(date("Y-m-d"));

			$value = [
				"next_check" => $today_o->add(new \DateInterval("P1W"))->format("Y-m-d"),
				"id_module" => $id_module
			];

			$dbc->prepare("UPDATE module SET next_check_version=:next_check WHERE ID_module=:id_module", $value);
		}

		/**
		 * @param $version_txt
		 * @param $version
		 * @param $id_module
		 * fonction qui va vérifier si notre mdule est bien a jour
		 */
		private function getCheckModuleUpToDate($version_txt, $version, $id_module) {
			$dbc = App::getDb();

			if (file_get_contents($version_txt) !== "") {
				//online pour bdd
				$version_online_txt = file_get_contents($version_txt);

				$version_online = floatval($version_online_txt);
				$version_site = floatval($version);

				//la version sur le serveur de telechargement est plus récente, on va donc proposer
				//en passant la valeur update a 1 dans la table module pour ce module
				// au client de mettre a jour sa version sinon on met la next check a la semaine pro
				if ($version_online > $version_site) {
					$value = [
						"update" => 1,
						"online_version" => $version_online_txt,
						"id_module" => $id_module
					];

					//on met la notification admin à 1
					$dbc->query("UPDATE notification SET admin=1 WHERE ID_notification=1");

					$dbc->prepare("UPDATE module SET mettre_jour=:update, online_version=:online_version WHERE ID_module=:id_module", $value);
				}
			}

			$this->setNextCheckUpdate($id_module);
		}
	}