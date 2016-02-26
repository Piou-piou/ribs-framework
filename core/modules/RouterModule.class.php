<?php
	namespace core\modules;


	use core\App;
	use core\functions\ChaineCaractere;

	class RouterModule {
		//varaibles de base de config
		private $controller;
		private $erreur;
		private $parametre;
		private $module; //varialbe qui contiendra le nom d'un module
		private $page;


		//-------------------------- GETTER ----------------------------------------------------------------------------//
		//pour les parametres du getUrl ++ getAction ++ getController
		public function getParametre() {
			return $this->parametre;
		}
		public function getPage() {
			return $this->page;
		}
		public function getController() {
			return $this->controller;
		}
		public function getErreur() {
			return $this->erreur;
		}

		private function getAllModules() {
			$dbc = App::getDb();

			$query = $query = $dbc->query("SELECT * FROM module");

			foreach ($query as $obj) {
				$module[] = str_replace("/", "", $obj->url);
			}

			return $module;
		}

		/**
		 * Permets de générer l'url pour aller charger la page concernee pour le module blog
		 * appele également l'actoin à effectur dans la page
		 * @param $url
		 * @return string
		 */
		public function getUrl($url){
			$explode = explode("/", $url);

			for ($i=0 ; $i<count($explode) ; $i++) {
				if (in_array($explode[$i], $this->getAllModules())) {
					$this->module = $explode[$i];
					$debut_url = $explode[$i];
				}
				else if ($i == 1) {
					$centre_url = $explode[$i];
					$this->page = $explode[$i];
				}
				else {
					$this->parametre = $explode[$i];
				}
			}

			if (!isset($centre_url) || ($centre_url == "")) {
				$this->page = "index";
				$centre_url = "index";
			}

			$this->setActionPage();

			return ROOT."modules/".$debut_url."/app/views/".$centre_url;
		}

		/**
		 * fonction qui permet de tester qu'une route existe bien
		 * appellee dans redirectError.class.php
		 * @param $url
		 */
		public function getRouteModuleExist($url) {
			$dbc = \core\App::getDb();

			$query = $dbc->query("SELECT * FROM module");

			foreach($query as $obj) {
				$test_module = ChaineCaractere::FindInString($url, $obj->url);
				$test_module1 = ChaineCaractere::FindInString($url, str_replace("/", "", $obj->url));
				$module_activer = \core\modules\GestionModule::getModuleActiver($obj->nom_module);

				if ((($test_module == true) || ($test_module1 == true)) && ($module_activer == true)) {
					$error = false;
					break;
				}
				else {
					$error = true;
				}
			}

			if ($error == true) {
				return false;
			}
			else {
				return true;
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//



		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * Fonction qui va se charger en focntion $this->page et de $this->action d'appeler la fonctoin qui va bien
		 * fontction appelee dans getUrl()
		 */
		private function setActionPage() {
			//on require le fichier routes.php dans /modules/nom_module/router/routes.php

			require_once(MODULEROOT.$this->module."/router/routes.php");
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}