<?php
	namespace core\admin\droitsacces;
	trait GetDetailListeAcces {
		
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * @param $id_liste_droit_acces
		 * @return integer
		 */
		protected function getNombreUtilisateurListe($id_liste_droit_acces) {
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
		protected function getNombreDroitAccesListe($id_liste_droit_acces) {
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
		protected function getNombrePageListe($id_liste_droit_acces) {
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
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- END SETTER ----------------------------------------------------------------------------//
	}