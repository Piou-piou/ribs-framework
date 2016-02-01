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
				foreach ($query as $obj) {
					if ($obj->super_admin == 1) $this->super_admin = 1;

					if ($obj->liste_droit == 1) {
						$this->id_liste_droit_acces = $obj->liste_droit;
					}
					else {
						$this->id_liste_droit_acces = 0;
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

		//pour la table liste_droit_acces
		public function getIdListeDroitAcces(){
		    return $this->id_liste_droit_acces;
		}

		//pour les droits sur la gestion des contenus
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

		//autres getter
		/**
		 * pour savoir si en fonction des droits d'accès de l'utilisateur il peu ou non accéder à cete page
		 * on passe outre les test si on est super admin
		 * @param $page
		 * @param null $id_page
		 * @return bool
		 */
		public function getDroitAccesPage($page) {
			$dbc = \core\App::getDb();

			if ($this->super_admin != 1) {
				//page sans droit dans admin
				$all_access = array("gestion-comptes/mon-compte", "index");

				if (!in_array($page, $all_access)) {
					$query = $dbc->query("SELECT droit_acces FROM droit_acces WHERE page LIKE '%$page%'");
					foreach ($query as $obj) $droit_acces = $obj->droit_acces;
				}

				//si la page n'est pas trouvée dans les droit d'accès c'est qu'elle est obligatoirement accessible dans admin
				if (!isset($droit_acces)) {
					$acces = true;
				}
				else {
					$acces = false;
				}

				//récupération de la liste des droits de l'utilisateur
				$query = $dbc->query("SELECT * FROM droit_acces, liste_droit_acces, liaison_liste_droit WHERE
								droit_acces.ID_droit_acces = liaison_liste_droit.ID_droit_acces AND
								liste_droit_acces.ID_liste_droit_acces = liaison_liste_droit.ID_liste_droit_acces AND
								liste_droit_acces.ID_liste_droit_acces = $this->id_liste_droit_acces
				");

				if (count($query) > 0) {
					foreach ($query as $obj) $liste_droit_acces[] = $obj->droit_acces;

					if (($this->super_admin == 1) || ($acces == true) || (in_array($droit_acces, $liste_droit_acces)) || (($page == "") || ($page == null))) {
						return true;
					}
					else {
						return false;
					}
				}
				else {
					if ($acces == true) {
						return true;
					}
					else {
						return false;
					}
				}
			}
			else {
				return true;
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
		 * @return bool
		 */
		public function getDroitAccesContenu($droit, $id_page) {
			$dbc = \core\App::getDb();

			//récupération de la liste des droits de l'utilisateur si aps super admin
			if ($this->super_admin != 1) {
				$query = $dbc->query("SELECT * FROM droit_acces, liste_droit_acces, liaison_liste_droit WHERE
								droit_acces.ID_droit_acces = liaison_liste_droit.ID_droit_acces AND
								liste_droit_acces.ID_liste_droit_acces = liaison_liste_droit.ID_liste_droit_acces AND
								liste_droit_acces.ID_liste_droit_acces = $this->id_liste_droit_acces
				");
				foreach ($query as $obj) $liste_droit_acces[] = $obj->droit_acces;

				if (in_array($droit, $liste_droit_acces)) {
					//on check si il a le droit de modifier ou supprimer cette page
					if (isset($id_page)) {
						$query = $dbc->query("SELECT * FROM droit_acces_page, liste_droit_acces WHERE
									droit_acces_page.ID_liste_droit_acces = liste_droit_acces.ID_liste_droit_acces AND
									droit_acces_page.ID_page = $id_page AND
									liste_droit_acces.ID_liste_droit_acces = $this->id_liste_droit_acces
					");

						//si on a un resultat
						if (count($query) > 0) {
							foreach ($query as $obj) {
								$this->modif_seo = $obj->seo;
								$this->modif_contenu = $obj->contenu;
								$this->modif_navigation = $obj->navigation;
								$this->supprimer_page = $obj->supprimer;
							}

							//si les trois sont différent de 0 on renvoit true soinon false
							if (($this->modif_seo != 0) || ($this->modif_contenu != 0) || ($this->modif_navigation != 0) || ($this->supprimer_page != 0)) {
								return true;
							}
							else {
								return false;
							}
						}
						else {
							return false;
						}
					}
					else if ($id_page == "creation_page") {
						$this->getDroitAccesPage("gestion-contenus/index");
					}
					else {
						return false;
					}
				}
				else {
					return false;
				}
			}
			else {
				$this->modif_seo = 1;
				$this->modif_contenu = 1;
				$this->modif_navigation = 1;
				$this->supprimer_page = 1;

				return true;
			}
		}

		/**
		 * pour savoir si un utilisateur à le droit de supprimer, modifier ou ajouter des trucs
		 * @param $droit_acces
		 * @return bool
		 */
		public function getDroitAccesAction($droit_acces) {
			$dbc = App::getDb();

			if ($this->super_admin != 1) {
				$query = $dbc->query("SELECT * FROM droit_acces, liste_droit_acces, liaison_liste_droit WHERE
								droit_acces.ID_droit_acces = liaison_liste_droit.ID_droit_acces AND
								liste_droit_acces.ID_liste_droit_acces = liaison_liste_droit.ID_liste_droit_acces AND
								liste_droit_acces.ID_liste_droit_acces = $this->id_liste_droit_acces
				");
				if (count($query) > 0) {
					foreach ($query as $obj) $liste_droit_acces[] = $obj->droit_acces;

					if (($this->super_admin == 1) || (in_array($droit_acces, $liste_droit_acces))) {
						return true;
					}
					else {
						return false;
					}
				}
				else {
					return false;
				}
			}
			else {
				return true;
			}
		}
        //-------------------------- FIN GETTER ----------------------------------------------------------------------------//
    
    
    
        //-------------------------- SETTER ----------------------------------------------------------------------------//

        //-------------------------- FIN SETTER ----------------------------------------------------------------------------//
    }