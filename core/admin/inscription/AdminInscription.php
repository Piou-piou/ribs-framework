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
		 * @return bool
		 */
		protected function setVerifAccesAdministration($value) {
			//on verifie que la valeur est bien un int
			//test avec le required, si le champe est vide et que le required est != null on return fa	lse sinon on va tester
			if ($this->getTestInt($value) === true) {
				$this->acces_administration = $value;
				return true;
			}
			else if ($this->getTestInt($value) === false) {
				$this->erreur .= "<li>Le champs accès administration n'est pas au bon format</li>";
				return false;
			}
			else {
				return true;
			}

		}

		/**
		 * vient de la partie admin du site pages gestion-comptes/creer-utilisateur
		 * @param $value
		 * @return bool
		 */
		protected function setVerifListeDroitAcces($value) {
			//on verifie que la valeur est bien un int
			//test avec le required, si le champe est vide et que le required est != null on return fa	lse sinon on va tester
			if ($this->getTestInt($value) === true) {
				$this->id_liste_droit_acces = $value;
				return true;
			}
			else if ($this->getTestInt($value) === false) {
				$this->erreur .= "<li>Le champs accès administration n'est pas au bon format</li>";
				return false;
			}
			else {
				return true;
			}

		}

		/**
		 * si tous les test concernant le formulaire sont passés on inscrit le user
		 */
		public function setInscrireUtilisateur() {
			$dbc = App::getDb();

			$dbc->insert("pseudo", $this->pseudo)
				->insert("nom", $this->nom)
				->insert("prenom", $this->prenom)
				->insert("mail", $this->mail)
				->insert("mdp", Encrypt::setEncryptMdp($this->mdp))
				->insert("mdp_params", Encrypt::getParams())
				->insert("last_change_mdp", date("Y-m-d"))
				->insert("img_profil", "profil/defaut.png")
				->insert("img_profil_blog", "profil/defaut_blog.png")
				->insert("valide", 1)
				->insert("archiver", 0)
				->insert("acces_admin", $this->acces_administration)
				->insert("liste_droit", $this->id_liste_droit_acces)
				->into("identite")
				->set();
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}