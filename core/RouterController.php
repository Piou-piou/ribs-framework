<?php
	namespace core;
	
	
	class RouterController {
		private $page;
		private $controller;
		private $part;
		private $erreur;
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct($page, $admin = null) {
			if (strpos($page, "controller") !== false) {
				$this->part = "app";
				if ($admin !== null) {
					$this->part = "admin";
				}
				
				$this->page = $page;
				
				$this->getLinkController();
				$this->getTestControllerExist();
				$this->erreur = false;
			}
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getController() {
			return $this->controller;
		}
		public function getErreur() {
			return $this->erreur;
		}
		
		/**
		 * function that get link of a controller
		 */
		private function getLinkController() {
			if (($this->getTestCoreController() === false) && ($this->getTestModuleController() === false)) {
				$this->controller = $this->part."/".$this->page.".php";
			}
		}
		
		/**
		 * @return bool
		 * this function set if is a controller core the link to the controller
		 */
		private function getTestCoreController() {
			if (strpos($this->page, "controller/core") !== false) {
				$this->controller = $this->getBaseLink().".php";
				return true;
			}
			
			return false;
		}
		
		/**
		 * @return bool
		 * this function set if is a controller module the link to the controller
		 */
		private function getTestModuleController() {
			if (strpos($this->page, "controller/modules") !== false) {
				$explode = explode("/", $this->getBaseLink(), 3);
				$this->controller = $explode[0]."/".$explode[1]."/".$this->part."/controller/".$explode[2].".php";
				return true;
			}
			
			return false;
		}
		
		/**
		 * @return mixed
		 * this function return link and delete controller at the begining of the link
		 */
		private function getBaseLink() {
			$explode = explode("/", $this->page, 2);
			return end($explode);
		}
		
		/**
		 * redirect on 404 if controller doesn't exist
		 */
		private function getTestControllerExist() {
			if (!file_exists($this->controller)) {
				RedirectError::Redirect(404);
			}
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- END SETTER ----------------------------------------------------------------------------//    
	}