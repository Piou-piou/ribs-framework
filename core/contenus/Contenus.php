<?php
	namespace core\contenus;

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
		 * pour récupérer l'en tete d'une page (balise title ++ meta description)
		 * @param $id_page
		 */
		public function getHeadPage($id_page, $url = null) {
			$dbc = \core\App::getDb();

			if ($id_page != 0) {
				$query = $dbc->select("balise_title")->select("meta_description")->select("ID_page")
					->from("page")
					->where("ID_page", "=", $id_page)
					->get();
			}
			else {
				$query = $dbc->select("balise_title")->select("meta_description")->select("ID_page")
					->from("page")
					->where("url", " LIKE ", $url)
					->get();
			}

			if (RedirectError::testRedirect404($query, $url) === true) {
				foreach ($query as $obj) {
					$this->id_page = $obj->ID_page;
					$this->meta_description = $obj->meta_description;
					$this->balise_title = $obj->balise_title;
				}
			}
		}

		/**
		 * pour récupérer une page en particulier
		 * @param $id_page
		 */
		public function getContenuPage($id_page = null) {
			$dbc = \core\App::getDb();

			if ($id_page == null) {
				$id_page = $this->id_page;
			}
			$query = $dbc->select()->from("page")->where("ID_page", "=", $id_page)->get();

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$this->id_page = $obj->ID_page;
					$this->titre = $obj->titre;
					$this->contenu = $obj->contenu;
					$this->url = $obj->url;
					$this->parent = $obj->parent;
				}
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//



		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}