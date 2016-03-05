<?php
	namespace core\admin\droitsacces;

	use core\App;

	class GestionDroitAcces extends DroitAcces {
		//pour les droit_acces standard
		private $id_liste_droit_acces;
		private $nom_liste;
		private $droit_acces;
		private $nb_droit_acces;

		//pour les droits d'acces sur les page
		private $id_page;
		private $titre_page;
		private $nb_droit_acces_page;

		//pour la table identite
		private $id_identite;
		private $pseudo;
		private $nom;
		private $prenom;
		private $nb_user;



		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct($id_liste_droit_acces = null) {
			$dbc = App::getDb();

			if ($id_liste_droit_acces == null) {
				//pour affichage de la liste des listes de droit d'acces
				//récupération des droits d'acces génériques
				$query = $dbc->query("SELECT * FROM liste_droit_acces");

				if ((is_array($query)) && (count($query) > 0)) {
					$id_liste_droit_acces = [];
					$nom_liste = [];
					$nb_droit_acces = [];
					$nb_droit_acces_page = [];
					$nb_user = [];

					foreach ($query as $obj) {
						$id_liste_droit_acces[] = $obj->ID_liste_droit_acces;
						$nom_liste[] = $obj->nom_liste;

						//récupération du nombre de droits d'acces pour cette liste
						$nb_droit_acces = $this->getNombreDroitAccesListe($obj->ID_liste_droit_acces);

						//récupération du nombre d'utilisateurs qui sont dans cette liste
						$nb_user = $this->getNombreUtilisateurListe($obj->ID_liste_droit_acces);

						//récupération du nombres de pages dans cette liste
						$nb_droit_acces_page = $this-> getNombrePageListe($obj->ID_liste_droit_acces);
					}

					$this->setListeDroitAcces($id_liste_droit_acces, $nom_liste, $nb_droit_acces, $nb_droit_acces_page, $nb_user);
				}
			}
			else {
				$this->id_liste_droit_acces = $id_liste_droit_acces;
			}
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//



		//-------------------------- GETTER ----------------------------------------------------------------------------//
		//pour les droit_acces standard
		public function getIdListeDroitAcces() {
			return $this->id_liste_droit_acces;
		}
		public function getNomListe() {
			return $this->nom_liste;
		}
		public function getDroitAcces() {
			return $this->droit_acces;
		}
		public function getNbDroitAcces() {
			return $this->nb_droit_acces;
		}

		//pour les droits d'acces sur les page
		public function getIdPage() {
			return $this->id_page;
		}
		public function getTitrePage() {
			return $this->titre_page;
		}
		public function getNbDroitAccesPage() {
			return $this->nb_droit_acces_page;
		}

		//pour la table identite
		public function getIdidentite() {
			return $this->id_identite;
		}
		public function getNom() {
			return $this->nom;
		}
		public function getPrenom() {
			return $this->prenom;
		}
		public function getPseudo() {
			return $this->pseudo;
		}
		public function getNbUser() {
			return $this->nb_user;
		}

		/**
		 * @param $id_liste_droit_acces
		 * @return integer
		 */
		private function getNombreUtilisateurListe($id_liste_droit_acces) {
			$dbc = App::getDb();

			$nb_user = 0;

			$query2 = $dbc->query("SELECT count(ID_identite) as ID_identite FROM identite WHERE liste_droit=".$id_liste_droit_acces);
			if ((is_array($query2)) && (count($query2) > 0)) {
				foreach ($query2 as $obj2) {
					$nb_user[] = $obj2->ID_identite;
				}
			}

			return $nb_user;
		}

		/**
		 * @param $id_liste_droit_acces
		 * @return integer
		 */
		private function getNombreDroitAccesListe($id_liste_droit_acces) {
			$dbc = App::getDb();

			$nb_droit_acces = 0;

			$query1 = $dbc->query("SELECT count(ID_droit_acces) as ID_droit_acces FROM liaison_liste_droit WHERE ID_liste_droit_acces =".$id_liste_droit_acces);
			if ((is_array($query1)) && (count($query1) > 0)) {
				foreach ($query1 as $obj1) {
					$nb_droit_acces[] = $obj1->ID_droit_acces;
				}
			}

			return $nb_droit_acces;
		}

		/**
		 * @param $id_liste_droit_acces
		 * @return integer
		 */
		private function getNombrePageListe($id_liste_droit_acces) {
			$dbc = App::getDb();

			$nb_droit_acces_page = 0;

			$query3 = $dbc->query("SELECT count(ID_page) as ID_page FROM droit_acces_page WHERE ID_liste_droit_acces =".$id_liste_droit_acces);
			if ((is_array($query3)) && (count($query3) > 0)) {
				foreach ($query3 as $obj3) {
					$nb_droit_acces_page[] = $obj3->ID_page;
				}
			}

			return $nb_droit_acces_page;
		}

		/**
		 * fonction qui récupère la liste des droits d'acces en texte en fonction de l'id de la liste
		 * @param $id_liste_droit_acces
		 */
		public function getListeDroitAccesDetailDroit($id_liste_droit_acces = null) {
			$dbc = \core\App::getDb();

			if ($id_liste_droit_acces == null) $id_liste_droit_acces = $this->id_liste_droit_acces;

			$query = $dbc->query("SELECT * FROM droit_acces, liaison_liste_droit WHERE
										droit_acces.ID_droit_acces = liaison_liste_droit.ID_droit_acces AND
										liaison_liste_droit.ID_liste_droit_acces =".$id_liste_droit_acces);
			if ((is_array($query)) && (count($query) > 0)) {
				$droit_acces = [];

				foreach ($query as $obj) {
					$droit_acces[] = $obj->droit_acces;
				}

				$this->setListeDroitAccesDetailDroit($droit_acces);
			}
		}

		/**
		 * fonction qui récupère la liste des utilisateur dans une liste de droits d'acces en texte en fonction de l'id de la liste
		 * @param $id_liste_droit_acces
		 */
		public function getListeDroitAccesDetailUser($id_liste_droit_acces = null) {
			$dbc = \core\App::getDb();

			if ($id_liste_droit_acces == null) $id_liste_droit_acces = $this->id_liste_droit_acces;

			//récupératin des utilisateurs qui sont dans cette liste
			$query = $dbc->query("SELECT * FROM identite WHERE liste_droit=".$id_liste_droit_acces);
			if ((is_array($query)) && (count($query) > 0)) {
				$id_identite = [];
				$pseudo = [];
				$nom = [];
				$prenom = [];

				foreach ($query as $obj) {
					$id_identite[] = $obj->ID_identite;
					$pseudo[] = $obj->pseudo;
					$nom[] = $obj->nom;
					$prenom[] = $obj->prenom;
				}

				$this->setListeDroitAccesDetailUser($id_identite, $pseudo, $nom, $prenom);
			}
		}

		/**
		 * fonction qui récupère la liste des droits d'acces sur les pages en texte en fonction de l'id de la liste
		 * @param $id_liste_droit_acces
		 */
		public function getListeDroitAccesDetailPage($id_liste_droit_acces = null) {
			$dbc = \core\App::getDb();

			if ($id_liste_droit_acces == null) $id_liste_droit_acces = $this->id_liste_droit_acces;

			//récupération des droits d'acces pour les pages
			$query = $dbc->query("SELECT * FROM liste_droit_acces, droit_acces_page, page WHERE
									liste_droit_acces.ID_liste_droit_acces = droit_acces_page.ID_liste_droit_acces AND
									droit_acces_page.ID_page = page.ID_page AND
									liste_droit_acces.ID_liste_droit_acces = $id_liste_droit_acces
			");
			if ((is_array($query)) && (count($query) > 0)) {
				$id_page = [];
				$titre_page = [];

				foreach ($query as $obj) {
					$id_page[] = $obj->ID_page;
					$titre_page[] = $obj->titre;
				}

				$this->setListeDroitAccesDetailPage($id_page, $titre_page);
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//



		//-------------------------- SETTER ----------------------------------------------------------------------------//
		private function setListeDroitAcces($id_liste_droit_acces, $nom_liste, $nb_droit_acces, $nb_droit_acces_page, $nb_user) {
			$this->id_liste_droit_acces = $id_liste_droit_acces;
			$this->nom_liste = $nom_liste;
			$this->nb_droit_acces = $nb_droit_acces;
			$this->nb_droit_acces_page = $nb_droit_acces_page;
			$this->nb_user = $nb_user;
		}
		private function setListeDroitAccesDetailDroit($droit_acces) {
			$this->droit_acces = $droit_acces;
		}
		private function setListeDroitAccesDetailPage($id_page, $titre_page) {
			$this->id_page = $id_page;
			$this->titre_page = $titre_page;
		}
		private function setListeDroitAccesDetailUser($id_identite, $pseudo, $nom, $prenom) {
			$this->id_identite = $id_identite;
			$this->pseudo = $pseudo;
			$this->nom = $nom;
			$this->prenom = $prenom;
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}