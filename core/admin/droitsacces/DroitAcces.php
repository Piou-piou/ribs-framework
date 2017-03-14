<?php
	namespace core\admin\droitsacces;

	use core\App;

	class DroitAcces {
		private $logged;

		//pour la table identite
		private $id_identite;
		private $super_admin;

		//pour la table liste_droit_acces
		private $id_liste_droit_acces;

		//pour des droits pour la gestion des contenus
		private $modif_seo;
		private $modif_contenu;
		private $modif_navigation;
		private $supprimer_page;


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
			}
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
    
    
    
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getLogged() {
			return $this->logged;
		}
		public function getSuperAdmin() {
			return $this->super_admin;
		}
		public function getIdListeDroitAcces() {
			return $this->id_liste_droit_acces;
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
				foreach ($query as $obj) $liste_droit_acces[] = $obj->droit_acces;
			}

			return $liste_droit_acces;
		}

		/**
		 * @param $id_page
		 */
		private function getListeDroitModificationContenu($id_page) {
			$dbc = App::getDb();

			//on check si il a le droit de modifier ou supprimer cette page
			$query = $dbc->select()->from("droit_acces_page")
				->from("liste_droit_acces")
				->where("droit_acces_page.ID_page", "=", $id_page, "AND")
				->where("liste_droit_acces.ID_liste_droit_acces", "=", $this->id_liste_droit_acces, "AND")
				->where("droit_acces_page.ID_liste_droit_acces", "=", "liste_droit_acces.ID_liste_droit_acces", "", true)
				->get();

			//si on a un resultat
			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$this->modif_seo = $obj->seo;
					$this->modif_contenu = $obj->contenu;
					$this->modif_navigation = $obj->navigation;
					$this->supprimer_page = $obj->supprimer;
				}
			}
		}

		/**
		 * fonction qui permet de gérer les droits d'accès sur les contenus :
		 * - creer une page
		 * - modifier du contenu (SEO, navigation, contenu)
		 * - supprimer une page
		 * si on est super admin on passe outre tous les tests
		 * @param $droit
		 * @param $id_page
		 * @return bool|null
		 */
		public function getDroitAccesContenu($droit, $id_page) {
			$liste_droit_acces = $this->getListeDroitAcces();

			$this->getListeDroitModificationContenu($id_page);

			$array_modif = [$this->modif_seo, $this->modif_contenu, $this->modif_navigation];

			//si les trois sont différent de 0 on renvoit true soinon false
			if (($this->super_admin == 1) || ((in_array($droit, $liste_droit_acces)) && in_array(1, $array_modif))) {
				return true;
			}
			else {
				return false;
			}
		}

		/**
		 * pour savoir si un utilisateur à le droit de supprimer, modifier ou ajouter des trucs
		 * @param $droit_acces
		 * @return bool
		 */
		public function getDroitAcces($droit_acces) {
			$liste_droit_acces = $this->getListeDroitAcces();

			if (($this->super_admin == 1) || (in_array($droit_acces, $liste_droit_acces))) {
				return true;
			}
			else {
				return false;
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
    
    
    
		//-------------------------- SETTER ----------------------------------------------------------------------------//

		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}