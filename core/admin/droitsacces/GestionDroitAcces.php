<?php
	namespace core\admin\droitsacces;

	use core\App;

	class GestionDroitAcces extends DroitAcces {
		use GetDetailListeAcces;

		//pour les droit_acces standard
		private $nom_liste;
		private $droit_acces;
		private $nb_droit_acces;

		//pour les droits d'acces sur les page
		private $id_page;
		private $titre_page;
		private $nb_droit_acces_page;

		//pour la table identite
		private $pseudo;
		private $nom;
		private $prenom;
		private $nb_user;



		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct($id_liste_droit_acces = null) {
			if ($id_liste_droit_acces === null) {
				$this->getListeDroitAccesAdmin();
			}
			else {
				$this->id_liste_droit_acces = $id_liste_droit_acces;
			}
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//



		//-------------------------- GETTER ----------------------------------------------------------------------------//
		//pour les droit_acces standard
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
		 * appellee dans le constructeur pour afficher les listes de droit d'acces
		 */
		private function getListeDroitAccesAdmin() {
			$dbc = App::getDb();

			//pour affichage de la liste des listes de droit d'acces
			//récupération des droits d'acces génériques
			$query = $dbc->select()->from("liste_droit_acces")->get();

			if ((is_array($query)) && (count($query) > 0)) {
				$values = [];

				foreach ($query as $obj) {
					$values[] = [
						"id_liste" => $obj->ID_liste_droit_acces,
						"nom_liste" => $obj->nom_liste,
						"nb_droit_acces" => $this->getNombreDroitAccesListe($obj->ID_liste_droit_acces),
						"nb_droit_acces_page" => $this->getNombrePageListe($obj->ID_liste_droit_acces),
						"nb_user" => $this->getNombreUtilisateurListe($obj->ID_liste_droit_acces),
					];
				}

				App::setValues(["liste_droit_acces" => $values]);
			}
		}

		/**
		 * fonction qui récupère la liste des droits d'acces en texte en fonction de l'id de la liste
		 * @param $id_liste_droit_acces
		 */
		public function getListeDroitAccesDetailDroit() {
			$dbc = \core\App::getDb();

			$query = $dbc->select()->from("droit_acces")
				->from("liaison_liste_droit")
				->where("liaison_liste_droit.ID_liste_droit_acces", "=", $this->id_liste_droit_acces, "AND")
				->where("droit_acces.ID_droit_acces", "=", "liaison_liste_droit.ID_droit_acces", "", true)
				->get();
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
		public function getListeDroitAccesDetailUser() {
			$dbc = \core\App::getDb();

			//récupératin des utilisateurs qui sont dans cette liste
			$query = $dbc->select()->from("identite")->where("liste_droit", "=", $this->id_liste_droit_acces)->get();
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
		public function getListeDroitAccesDetailPage() {
			$dbc = \core\App::getDb();

			//récupération des droits d'acces pour les pages
			$query = $dbc->select()->from("liste_droit_acces")
				->from("droit_acces_page")
				->from("page")
				->where("liste_droit_acces.ID_liste_droit_acces", "=", $this->id_liste_droit_acces, "AND")
				->where("liste_droit_acces.ID_liste_droit_acces", "=", "droit_acces_page.ID_liste_droit_acces", "AND", true)
				->where("droit_acces_page.ID_page", "=", "page.ID_page", "", true)
				->get();

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