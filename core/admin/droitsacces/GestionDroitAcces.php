<?php
	namespace core\admin\droitsacces;

	use core\App;

	class GestionDroitAcces extends DroitAcces {
		use GetDetailListeAcces;
		
		

		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct() {
				$this->getListeDroitAccesAdmin();
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//



		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * appellee dans le constructeur pour afficher les listes de droit d'acces
		 */
		private function getListeDroitAccesAdmin() {
			$dbc = App::getDb();
			
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
		 * @param $id_droit_acces
		 * @return string
		 * fonction qui renvoi le nom d'un droit d'accès en fonction de son id
		 */
		private function getNomDroitAcces($id_droit_acces) {
			$dbc = App::getDb();
			
			$query = $dbc->select("droit_acces")->from("droit_acces")->where("ID_droit_acces", "=", $id_droit_acces)->get();
		
			if (count($query) > 0) {
				foreach ($query as $obj) {
					return $obj->droit_acces;
				}
			}
			
			return "";
		}
		
		/**
		 * fonction qui récupère tous les droits d'accès
		 */
		private function getAllDroitAcces() {
			$dbc = App::getDb();
			
			$query = $dbc->select()->from("droit_acces")->get();
			
			if (count($query) > 0) {
				foreach ($query as $obj) {
					$values[] = [
						"id_droit_acces" => $obj->ID_droit_acces,
						"droit_acces" => $obj->droit_acces,
						"nom_module" => $obj->nom_module
					];
				}
				
				App::setValues(["droit_acces" => $values]);
			}
		}
		
		/**
		 * @param $id_liste
		 * recupere tous les id des droits dc'acces d'une liste
		 */
		public function getDroiAccesListe($id_liste) {
			$dbc = App::getDb();
			
			$query = $dbc->select()->from("liste_droit_acces, liaison_liste_droit")
				->where("liste_droit_acces.ID_liste_droit_acces", "=", $id_liste, "AND")
				->where("liste_droit_acces.ID_liste_droit_acces", "=", "liaison_liste_droit.ID_liste_droit_acces", "", true)
				->get();
			
			if (count($query) > 0) {
				foreach ($query as $obj) {
					$values[] = $this->getNomDroitAcces($obj->ID_droit_acces);
				}
				
				App::setValues(["droit_acces_liste" => $values]);
				$this->getAllDroitAcces();
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//



		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}