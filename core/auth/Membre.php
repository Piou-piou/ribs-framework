<?php
	namespace core\auth;


	class Membre {
		protected $id_identite;
		protected $nom;
		protected $prenom;
		protected $mail;
		protected $pseudo;
		protected $img;
		protected $mdp;
		protected $valide;
		protected $erreur;
		
		private $debut_lien;
		
		//------------------------------ constructeur-----------------------------------
		//Récupérer en base de données les infos du membre
		public function __construct($id_identite = null) {
			$dbc = \core\App::getDb();

			$this->debut_lien = IMGROOT."profil/";

			if ($id_identite != null) {
				$query = $dbc->select()->from("identite")->where("ID_identite", "=", $id_identite)->get();

				if ((is_array($query)) && (count($query) > 0)) {
					foreach ($query as $obj) {
						$this->id_identite = $obj->ID_identite;
						$this->nom = $obj->nom;
						$this->prenom = $obj->prenom;
						$this->mail = $obj->mail;
						$this->pseudo = $obj->pseudo;
						$this->mdp = $obj->mdp;
						$this->valide = $obj->valide;
						$this->img = $obj->img_profil;
					}
				}
			}
		}
		//------------------------------ fin constructeur -----------------------------------
		
		
		
		//------------------------------ getter-----------------------------------
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
		public function getMail() {
			return $this->mail;
		}
		public function getImg() {
			return $this->img;
		}
		public function getMdp() {
			return $this->mdp;
		}
		public function getValide() {
			return $this->valide;
		}
		public function getErreur() {
			return $this->erreur;
		}
		//------------------------------ fin getter -----------------------------------
		
		
		
		//------------------------------ setter-----------------------------------

		/**
		 * @param string $new_pseudo
		 */
		public function setPseudo($new_pseudo) {
			$dbc = \core\App::getDb();
			
			//si pseudo trop court
			if ((strlen($new_pseudo) < 5) || (strlen($new_pseudo) > 15)) {
				$err = "Votre pseudo doit être entre 5 et 15 caractères";
				$this->erreur = $err;
			}
			else if ($dbc->rechercherEgalite("identite", "pseudo", $new_pseudo) == false) {
				$err = "Ce pseudo est déjà utilisé, veuillez en choisir un autre";
				$this->erreur = $err;
			}
			else {
				$dbc->update("pseudo", $new_pseudo)->from("identite")->where("ID_identite", "=", $_SESSION["idlogin".CLEF_SITE])->set();
				$this->pseudo = $new_pseudo;
			}
		}

		/**
		 * @param string $old_mdp
		 * @param string $new_mdp
		 * @param string $verif_new_mdp
		 */
		public function setMdp($old_mdp, $new_mdp, $verif_new_mdp) {
			$dbc = \core\App::getDb();

			$mdp = Encrypt::setDecryptMdp($this->mdp, $this->id_identite);

			//si mdp trop court
			if (md5($old_mdp) != $mdp) {
				$err = "Votre mot de passe est incorrect";
				$this->erreur = $err;
			}
			else if ($new_mdp != $verif_new_mdp) {
				$err = "Vos mots de passe sont différents";
				$this->erreur = $err;
			}
			else if ($this->testpassword($new_mdp) == false) {
				$err = "Votre mot de passe est trop simple, il doit contenir 5 caractères et au moins un chiffre";
				$this->erreur = $err;
			}
			else {
				$mdpok = Encrypt::setEncryptMdp($new_mdp, $this->id_identite);
				//le nouveau mdp est bon on update
				$dbc->update("mdp", $mdpok)->from("identite")->where("ID_identite", "=", $this->id_identite)->set();

				$this->mdp = $mdpok;
			}
		}
		//------------------------------ fin setter -----------------------------------


		//-------------------------- FONCTIONS SPECIFIQUES ----------------------------------------------------------------------------//
		//-------------------------- FONCTIONS POUR TESTER SECURITE D'UN MDP ----------------------------------------------------------------------------//
		/**
		 * Fonction  qui permet de verifier la securite d'un mdp
		 * @param string $mdp
		 * @return integer
		 */
		private function testpassword($mdp) {
			if (strlen($mdp) < 5) {
				return false;
			}

			if (!preg_match("#[0-9]+#", $mdp)) {
				return false;
			}
		}
		//-------------------------- FIN FONCTIONS POUR TESTER SECURITE D'UN MDP ----------------------------------------------------------------------------//
	}