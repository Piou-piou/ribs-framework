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
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//



		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}