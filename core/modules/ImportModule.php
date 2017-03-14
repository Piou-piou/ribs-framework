<?php
	namespace core\modules;

	use core\App;

	class ImportModule {
		//pour les infos du module
		private $id_module;
		private $url_telechargement;
		private $version_ok;
		private $dossier_module;
		private $url_module;

		
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * @param $id_module
		 * permets de récupérer des informations sur un module
		 */
		private function getInfoModule($id_module) {
			$dbc = App::getDb();

			$query = $dbc->select()->from("module")->where("ID_module", "=", $id_module)->get();

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$this->id_module = $obj->ID_module;
					$this->url_telechargement = $obj->url_telechargement;
					$this->version_ok = $obj->online_version;
					$this->dossier_module = str_replace("/", "", $obj->url);
					$this->url_module = $obj->url;
				}
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//


		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @param $id_module
		 * fonction qui permet de supprimer un module (suppression des tables + appel fonction supprimer dossier)
		 */
		public function setSupprimerModule($id_module) {
			$dbc = App::getDb();
			$this->getInfoModule($id_module);

			$dbc->delete()->from("module")->where("ID_module", "=", $id_module)->del();

			$requete = "";
			require_once(MODULEROOT.$this->url_module."uninstall.php");
			$dbc->query($requete);

			App::supprimerDossier(str_replace("/", "", $this->url_module));
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}