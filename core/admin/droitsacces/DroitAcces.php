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

			if (isset($_SESSION["idlogin".CLEF_SITE])) {
				$this->logged = true;
				$this->id_identite = $_SESSION["idlogin".CLEF_SITE];

				//on test voir si super admin
				$query = $dbc->query("SELECT super_admin,liste_droit FROM identite WHERE ID_identite=".$this->id_identite);

				if ((is_array($query)) && (count($query) > 0)) {
					foreach ($query as $obj) {
						$this->super_admin = $obj->super_admin;
						$this->id_liste_droit_acces = $obj->liste_droit;
					}
				}
			}
			else {
				$this->logged = false;
			}
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
    
    
    
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getLogged(){
			return $this->logged;
		}
		public function getSuperAdmin(){
			return $this->super_admin;
		}
		public function getIdListeDroitAcces(){
			return $this->id_liste_droit_acces;
		}
		public function getModifSeo(){
			return $this->modif_seo;
		}
		public function getModifContenu(){
			return $this->modif_contenu;
		}
		public function getModifNavigation(){
			return $this->modif_navigation;
		}
		public function getSupprimerPage(){
			return $this->supprimer_page;
		}

		/**
		 * @return array
		 */
		private function getListeDroitAcces() {
			$dbc = App::getDb();

			$liste_droit_acces = [];

			$query = $dbc->query("SELECT * FROM droit_acces, liste_droit_acces, liaison_liste_droit WHERE
								droit_acces.ID_droit_acces = liaison_liste_droit.ID_droit_acces AND
								liste_droit_acces.ID_liste_droit_acces = liaison_liste_droit.ID_liste_droit_acces AND
								liste_droit_acces.ID_liste_droit_acces = $this->id_liste_droit_acces
				");

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) $liste_droit_acces[] = $obj->droit_acces;
			}

			return $liste_droit_acces;
		}

		/**
		 * @return array
		 */
		private function getListeDroitPage($page) {
			$dbc = App::getDb();
			$droit_acces = [];

			$query = $dbc->query("SELECT droit_acces FROM droit_acces WHERE page LIKE '%$page%'");
			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) $droit_acces = $obj->droit_acces;
			}

			return $droit_acces;
		}

		/**
		 * @param $id_page
		 */
		private function getListeDroitModificationContenu($id_page) {
			$dbc = App::getDb();

			//on check si il a le droit de modifier ou supprimer cette page
			$query = $dbc->query("SELECT * FROM droit_acces_page, liste_droit_acces WHERE
									droit_acces_page.ID_liste_droit_acces = liste_droit_acces.ID_liste_droit_acces AND
									droit_acces_page.ID_page = $id_page AND
									liste_droit_acces.ID_liste_droit_acces = $this->id_liste_droit_acces
					");

			//si on a un resultat
			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$this->modif_seo = $obj->seo;
					$this->modif_contenu = $obj->contenu;
					$this->modif_navigation = $obj->navigation;
					$this->supprimer_page = $obj->supprimer;
				}
			}

			if ($this->super_admin == 1) {
				$this->modif_seo = 1;
				$this->modif_contenu = 1;
				$this->modif_navigation = 1;
				$this->supprimer_page = 1;
			}
		}

		//autres getter
		/**
		 * pour savoir si en fonction des droits d'accès de l'utilisateur il peu ou non accéder à cete page
		 * on passe outre les test si on est super admin
		 * @param string $page
		 * @return bool
		 */
		public function getDroitAccesPage($page) {
			//page sans droit dans admin
			$all_access = array("gestion-comptes/mon-compte", "index");

			if (($this->super_admin == 1) || (in_array($this->getListeDroitPage($page), $this->getListeDroitAcces())) || (($page == "") || ($page == null)) || (in_array($page, $all_access))) {
				return true;
			}
			else {
				return false;
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

			//si les trois sont différent de 0 on renvoit true soinon false
			if (($this->super_admin == 1) || ((in_array($droit, $liste_droit_acces)) && (($this->modif_seo != 0) || ($this->modif_contenu != 0) || ($this->modif_navigation != 0) || ($this->supprimer_page != 0)))) {
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
		public function getDroitAccesAction($droit_acces) {
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