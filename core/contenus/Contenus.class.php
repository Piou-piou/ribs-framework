<?php
	namespace core\contenus;

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
		public function __construct($init_all=0) {
			$dbc = \core\App::getDb();

			if ($init_all == 1) {
				//on construit le menu
				$query = $dbc->query("SELECT ID_page, titre, balise_title, parent, url FROM page WHERE affiche=1 ORDER BY ordre");

				if (count($query) > 0) {
					foreach ($query as $obj) {
						$id_page[] = $obj->ID_page;
						$titre[] = $obj->titre;
						$balise_title[] = $obj->balise_title;
						$url[] = $obj->url;
						$parent[] = $obj->parent;
					}

					$this->setMenu($id_page, $titre, $balise_title, $url, $parent);
				}
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
		 * pour récupérer l'en tete d'une page (balise title ++ meta description)
		 * @param $id_page
		 */
		public function getHeadPage($id_page, $url=null) {
			$dbc = \core\App::getDb();

			if ($id_page != 0) {
				$query = $dbc->query("SELECT balise_title, meta_description, ID_page FROM page WHERE ID_page=".$id_page);
			}
			else {
				$query = $dbc->query("SELECT balise_title, meta_description, ID_page FROM page WHERE url LIKE '$url'");
			}

			if (RedirectError::testRedirect404($query, $url) == true) {
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
		public function getContenuPage($id_page=null) {
			$dbc = \core\App::getDb();

			if ($id_page == null) {
				$id_page = $this->id_page;
			}

			if ($id_page != null) {
				$query = $dbc->query("SELECT * FROM page WHERE ID_page=".$id_page);

				if (count($query) > 0) {
					foreach ($query as $obj) {
						$this->id_page = $obj->ID_page;
						$this->titre = $obj->titre;
						$this->contenu = $obj->contenu;
						$this->url = $obj->url;
						$this->parent = $obj->parent;
					}
				}
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//



		//-------------------------- SETTER ----------------------------------------------------------------------------//
		protected function setMenu($id_page, $titre, $balise_title, $url, $parent ){
			$this->id_page = $id_page;
			$this->titre = $titre;
			$this->balise_title = $balise_title;
			$this->url = $url;
			$this->parent = $parent;
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}