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
		private $admin; //permet de savoir si on est dans l'administration du site ou pas et de charger lebon router
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		//pour les parametres du getUrl ++ getAction ++ getController
		public function getParametre() {
			return $this->parametre;
		}
		public function getPage() {
			return $this->page;
		}
		public function getModule(){
			return $this->module;
		}
		public function getController() {
			return $this->controller;
		}
		public function getErreur() {
			return $this->erreur;
		}
		
		private function getAllModules() {
			$dbc = App::getDb();
			$module = "";
			
			$query = $dbc->select()->from("module")->get();
			
			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$module[] = str_replace("/", "", $obj->url);
				}
			}
			
			return $module;
		}
		
		/**
		 * @param $url
		 * @param null $admin
		 * @return string
		 * Permets de générer l'url pour aller charger la page concernee pour le module blog
		 * appele également l'actoin à effectur dans la page
		 */
		public function getUrl($url, $admin=null) {
			$explode = explode("/", $url);
			$count = count($explode);
			$debut_url = "";
			
			for ($i = 0; $i < $count; $i++) {
				if (in_array($explode[$i], $this->getAllModules())) {
					$this->module = $explode[$i];
					$debut_url = $explode[$i];
				}
				else if ($i >= 1) {
					$centre_url[] = $explode[$i];
				}
			}
			
			$centre_url = implode("/", $centre_url);
			$this->page = $centre_url;
			
			if (!isset($centre_url) || ($centre_url == "")) {
				$this->page = "index";
			}
			else {
				$file = ROOT."modules/".$debut_url."/app/views/".$centre_url;
				
				if (!file_exists($file.".html")) {
					$centre_url = explode("/", $file);
					$this->parametre = array_pop($centre_url);
					$this->page = end($centre_url);
					
					$centre_url = implode("/", $centre_url);
				}
			}
			
			$this->admin = $admin;
			$this->setActionPage();
			
			return $centre_url."/".$this->parametre;
		}
		
		/**
		 * fonction qui permet de tester qu'une route existe bien
		 * appellee dans redirectError.class.php
		 * @param $url
		 */
		public function getRouteModuleExist($url) {
			$dbc = \core\App::getDb();
			$query = $dbc->select()->from("module")->get();
			
			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$test_module = ChaineCaractere::FindInString($url, $obj->url);
					$test_module1 = ChaineCaractere::FindInString($url, str_replace("/", "", $obj->url));
					$module_activer = \core\modules\GestionModule::getModuleActiver($obj->nom_module);
					
					if ((($test_module === true) || ($test_module1 === true)) && ($module_activer === true)) {
						return true;
					}
				}
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
			if ($this->admin !== null) {
				require_once(MODULEROOT.$this->module."/router/admin_routes.php");
			}
			else {
				require_once(MODULEROOT.$this->module."/router/routes.php");
			}
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}