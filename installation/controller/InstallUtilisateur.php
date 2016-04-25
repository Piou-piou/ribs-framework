<?php
	namespace installation\controller;
	use core\App;
	use core\auth\Encrypt;
	use core\HTML\flashmessage\FlashMessage;

	class InstallUtilisateur {
		private $nom;
		private $prenom;
		private $pseudo;
		private $mdp;
		private $erreur;
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct($nom, $prenom, $pseudo, $mdp, $verif_mdp) {
			$this->nom = $this->setTestChamp($nom, "nom");
			$this->prenom = $this->setTestChamp($prenom, "nom");
			$this->pseudo = $this->setTestChamp($pseudo, "nom");
			$this->mdp = $this->setTestMdp($mdp, $verif_mdp);

			if ($this->erreur == true) {
				FlashMessage::setFlash("<ul>".$this->nom.$this->prenom.$this->pseudo.$this->mdp."</ul>");
			}
			else {
				$this->setInscrireUtilisateur();

				FlashMessage::setFlash("Le compte super admin a bien été créé", "success");
			}
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getErreur() {
			return $this->erreur;
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @param $nom
		 * @param $champ
		 * @return string
		 */
		private function setTestChamp($nom, $champ) {
			if (strlen($nom) >= 3) {
				return $nom;
			}

			$this->erreur = true;
			return "<li>Votre ".$champ." doit être de trois caractère minimum</li>";
		}

		/**
		 * @param $mdp
		 * @param $verif_mdp
		 * @return string
		 */
		private function setTestMdp($mdp, $verif_mdp) {
			if ($mdp != $verif_mdp) {
				$this->erreur = true;
				return "<li>Vos mots de passe sont différents</li>";
			}
			else {
				return $mdp;
			}
		}

		/**
		 * insertion du super user
		 */
		public function setInscrireUtilisateur() {
			$dbc = App::getDb();

			$dbc->insert("pseudo", $this->pseudo)
				->insert("nom", $this->nom)
				->insert("prenom", $this->prenom)
				->insert("mdp", Encrypt::setEncryptMdp($this->mdp))
				->insert("mdp_params", Encrypt::getParams())
				->insert("last_change_mdp", date("Y-m-d"))
				->insert("img_profil", "profil/defaut.png")
				->insert("img_profil_blog", "profil/defaut_blog.png")
				->insert("valide", 1)
				->insert("acces_admin", 1)
				->insert("liste_droit", 0)
				->insert("super_admin", 1)
				->into("identite")
				->set();
		}
		//-------------------------- END SETTER ----------------------------------------------------------------------------//
	}