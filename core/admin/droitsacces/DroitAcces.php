<?php
	namespace core\admin\droitsacces;

	use core\App;

	class DroitAcces {

		//pour la table identite
		protected $id_identite;
		private $super_admin;

		//pour la table liste_droit_acces
		protected $id_liste_droit_acces;

		//pour des droits pour la gestion des contenus
		private $modif_seo;
		private $modif_contenu;
		private $modif_navigation;
		private $supprimer_page;
		
		private $liste_droits_acces;


		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct() {
			$dbc = \core\App::getDb();

			$this->id_identite = $_SESSION["idlogin".CLEF_SITE];

			//on test voir si super admin
			$query = $dbc->select("super_admin")->select("liste_droit")->from("identite")->where("ID_identite", "=", $this->id_identite)->get();

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$this->super_admin = $obj->super_admin;
					$this->id_liste_droit_acces = $obj->liste_droit;
				}
				$this->liste_droits_acces = $this->getListeDroitAcces();
				App::setValues(["super_admin" => $this->super_admin]);
			}
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
    
    
    
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getSuperAdmin() {
			return $this->super_admin;
		}
		public function getModifSeo() {
			return $this->modif_seo;
		}
		public function getModifContenu() {
			return $this->modif_contenu;
		}
		public function getModifNavigation() {
			return $this->modif_navigation;
		}
		public function getSupprimerPage() {
			return $this->supprimer_page;
		}
		public function getListeDroitsAcces() {
			return $this->liste_droits_acces;
		}

		/**
		 * @return array
		 */
		private function getListeDroitAcces() {
			$dbc = App::getDb();

			$liste_droit_acces = [];

			$query = $dbc->select()->from("droit_acces")
				->from("liste_droit_acces")
				->from("liaison_liste_droit")
				->where("liste_droit_acces.ID_liste_droit_acces", "=", $this->id_liste_droit_acces, "AND")
				->where("droit_acces.ID_droit_acces", "=", "liaison_liste_droit.ID_droit_acces", "AND", true)
				->where("liste_droit_acces.ID_liste_droit_acces", "=", "liaison_liste_droit.ID_liste_droit_acces", "", true)
				->get();

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$liste_droit_acces[] = $obj->droit_acces;
				}
			}
			
			App::setValues(["droit_acces_user" => $liste_droit_acces]);
			return $liste_droit_acces;
		}

		/**
		 * @param $id_page
		 * function that get if user can edit content SEO nav or contenu of the current page
		 */
		public function getListeDroitModificationContenu($id_page) {
			$dbc = App::getDb();
			
			$query = $dbc->select()->from("droit_acces_page")
				->from("liste_droit_acces")
				->where("droit_acces_page.ID_page", "=", $id_page, "AND")
				->where("liste_droit_acces.ID_liste_droit_acces", "=", $this->id_liste_droit_acces, "AND")
				->where("droit_acces_page.ID_liste_droit_acces", "=", "liste_droit_acces.ID_liste_droit_acces", "", true)
				->get();
			
			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					App::setValues(["droit_acces_page" => [
						"seo" => $this->modif_seo = $obj->seo,
						"contenu" => $this->modif_contenu = $obj->contenu,
						"navigation" => $this->modif_navigation = $obj->navigation,
						"supprimer" => $this->supprimer_page = $obj->supprimer
					]]);
				}
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
    
    
    
		//-------------------------- SETTER ----------------------------------------------------------------------------//

		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}