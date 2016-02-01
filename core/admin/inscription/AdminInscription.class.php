<?php
	namespace core\admin\inscription;
	use core\App;
	use core\auth\Encrypt;
	use core\auth\Inscription;

	class AdminInscription extends Inscription {
		protected $acces_administration;
		protected $id_liste_droit_acces;
		
		
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getAccesAdministration() {
			return $this->acces_administration;
		}
		public function getidListeDroitAcces() {
			return $this->id_liste_droit_acces;
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
		

		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * vient de la partie admin n du site pages gestion-comptes/creer-utilisateur
		 * @param $value
		 * @param null $required
		 * @return bool
		 */
		protected function setVerifAccesAdministration($value, $required=null) {
			//on verifie que la valeur est bien un int
			//test avec le required, si le champe est vide et que le required est != null on return fa	lse sinon on va tester
			if (($required != null) && ($this->getTestRequired($value) == false)) {
				$this->erreur .= "<li>Le champs accès administration ne peut pas être vide</li>";
				return false;
			}
			else {
				if (($value != "") && ($this->getTestInt($value) == true)) {
					$this->acces_administration = $value;
					return true;
				}
				else if (($value != "") && ($this->getTestInt($value) == false)) {
					$this->erreur .= "<li>Le champs accès administration n'est pas au bon format</li>";
					return false;
				}
				else {
					return true;
				}
			}
		}

		/**
		 * vient de la partie admin du site pages gestion-comptes/creer-utilisateur
		 * @param $value
		 * @param null $required
		 * @return bool
		 */
		protected function setVerifListeDroitAcces($value, $required=null) {
			//on verifie que la valeur est bien un int
			//test avec le required, si le champe est vide et que le required est != null on return fa	lse sinon on va tester
			if (($required != null) && ($this->getTestRequired($value) == false)) {
				$this->erreur .= "<li>Le champs accès administration ne peut pas être vide</li>";
				return false;
			}
			else {
				if (($value != "") && ($this->getTestInt($value) == true)) {
					$this->id_liste_droit_acces = $value;
					return true;
				}
				else if (($value != "") && ($this->getTestInt($value) == false)) {
					$this->erreur .= "<li>Le champs accès administration n'est pas au bon format</li>";
					return false;
				}
				else {
					return true;
				}
			}
		}

		/**
		 * si tous les test concernant le formulaire sont passés on inscrit le user
		 */
		public function setInscrireUtilisateur() {
			$dbc = App::getDb();

			$value = array(
				"pseudo" => $this->pseudo,
				"nom" => $this->nom,
				"prenom" => $this->prenom,
				"mail" => $this->mail,
				"mdp" => Encrypt::setEncryptMdp($this->mdp),
				"mdp_params" => Encrypt::getParams(),
				"last_change_mdp" => date("Y-m-d"),
				"img_profil" => "profil/defaut.png",
				"img_profil_blog" => "profil/defaut_blog.png",
				"valide" => 1,
				"acces_admin" => $this->acces_administration,
				"liste_droit" => $this->id_liste_droit_acces
			);


			$dbc->prepare("INSERT INTO identite (pseudo, nom, prenom, mail, mdp, mdp_params, last_change_mdp, img_profil, img_profil_blog, valide, acces_admin, liste_droit) VALUES (:pseudo, :nom, :prenom, :mail, :mdp, :mdp_params, :last_change_mdp, :img_profil, :img_profil_blog, :valide, :acces_admin, :liste_droit)", $value);
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}