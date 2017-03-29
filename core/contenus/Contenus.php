<?php
	namespace core\contenus;

	use core\App;
	use core\functions\ChaineCaractere;
	use core\RedirectError;


	class Contenus {
		//pour la table page
		protected $id_page;
		protected $titre;
		protected $contenu;
		protected $url;
		protected $meta_description;
		protected $balise_title;
		protected $parent;



		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct($url, $admin_contenu = null) {
			if ($admin_contenu === null) {
				$this->getPage($url);
			}
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//



		//-------------------------- GETTER ----------------------------------------------------------------------------//
		//pour la table page
		public function getIdPage() {
			return $this->id_page;
		}
		public function getTitre() {
			return $this->titre;
		}
		public function getContenu() {
			return $this->contenu;
		}
		public function getUrl() {
			return $this->url;
		}
		public function getMetaDescription() {
			return $this->meta_description;
		}
		public function getBaliseTitle() {
			return $this->balise_title;
		}
		public function getParent() {
			return $this->parent;
		}
		
		/**
		 * @param $url
		 * function that get all content of a page
		 */
		private function getPage($url) {
			$dbc = \core\App::getDb();
			
			$query = $dbc->select()->from("page")->where("url", "=", $url)->get();
			
			if (RedirectError::testRedirect404($query, $url) === true) {
				foreach ($query as $obj) {
					$redirect = 0;
					if (ChaineCaractere::FindInString($url, "http://") === true) {
						$redirect = 1;
					}
					
					App::setValues(["contenus" => [
						"id_page" => $this->id_page = $obj->ID_page,
						"meta_description" => $this->meta_description = $obj->meta_description,
						"balise_title" => $this->balise_title = $obj->balise_title,
						"url" => $this->url = $obj->url,
						"titre" => $this->titre = $obj->titre,
						"contenu" => $this->contenu = $obj->contenu,
						"parent" => $this->parent = $obj->parent,
						"redirect_page" => $redirect,
						"bloc_editable" => $obj->bloc_editable
					]]);
				}
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//



		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}