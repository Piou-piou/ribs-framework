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
				$query = $dbc->query("SELECT * FROM identite where ID_identite=$id_identite");

				if ((is_array($query)) && (count($query) > 0)) {
					foreach ($query as $obj) {
						$this->id_identite = $obj->ID_identite;
						$this->nom = $obj->nom;
						$this->prenom = $obj->prenom;
						$this->mail = $obj->mail;
						$this->pseudo = $obj->pseudo;
						$this->mdp = $obj->mdp;
						$this->valide = $obj->valide;

						if ($obj->img_profil == "") {
							$this->img = $this->debut_lien."defaut.png";
						}
						else {
							$this->img = $obj->img_profil;
						}
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
			
			//recherche si pseudo pas deja existant
			$pseudo_bdd = "";
			$query = $dbc->query("SELECT pseudo FROM identite WHERE pseudo=$new_pseudo");
			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$pseudo_bdd = $dbc->quote(htmlspecialchars($obj->pseudo));
				}
			}
			
			//si pseudo trop court
			if (strlen($new_pseudo) < 5) {
				$err = "Votre pseudo est trop court";
				$this->erreur = $err;
			}
			else if (strlen($new_pseudo) > 15) {
				$err = "Votre pseudo est trop long";
				$this->erreur = $err;
			}
			else if ($new_pseudo == $pseudo_bdd) {
				$err = "Ce pseudo est déjà utilisé, veuillez en choisir un autre";
				$this->erreur = $err;
			}
			else {
				$dbc->query("UPDATE identite set pseudo=$new_pseudo WHERE ID_identite=".$_SESSION["idlogin".CLEF_SITE]);
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
			else {
				if ($new_mdp != $verif_new_mdp) {
					$err = "Vos mots de passe sont différents";
					$this->erreur = $err;
				}
				else {
					$testmdp = $this->testpassword($new_mdp);
					
					if (strlen($new_mdp) < 5) {
						$err = "Votre mot de passe est trop court";
						$this->erreur = $err;
					}
					else if ($testmdp < 40) {
						$err = "Votre mot de passe est trop simple";
						$this->erreur = $err;
					}
					else {
						$mdpok = Encrypt::setEncryptMdp($new_mdp, $this->id_identite);
						//le nouveau mdp est bon on update
						$dbc->query("UPDATE identite SET mdp='$mdpok' WHERE ID_identite=".$this->id_identite);

						$this->mdp = $mdpok;
					}
				}
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
			$longueur = strlen($mdp);
			$point = 0;
			$point_min = 0;
			$point_maj = 0;
			$point_chiffre = 0;
			$point_caracteres = 0;

			for ($i = 0; $i < $longueur; $i++) {
				$lettre = $mdp[$i];

				if ($lettre >= 'a' && $lettre <= 'z') {
					$point = $point + 1;
					$point_min = 1;
				}
				else if ($lettre >= 'A' && $lettre <= 'Z') {
					$point = $point + 2;
					$point_maj = 2;
				}
				else if ($lettre >= '0' && $lettre <= '9') {
					$point = $point + 3;
					$point_chiffre = 3;
				}
				else {
					$point = $point + 5;
					$point_caracteres = 5;
				}
			}

			// Calcul du coefficient points/longueur
			$etape1 = $point / $longueur;

			// Calcul du coefficient de la diversite des types de caracteres...
			$etape2 = $point_min + $point_maj + $point_chiffre + $point_caracteres;

			// Multiplication du coefficient de diversite avec celui de la longueur
			$resultat = $etape1 * $etape2;

			// Multiplication du resultat par la longueur de la chaene
			$final = $resultat * $longueur;

			return $final;
		}
		//-------------------------- FIN FONCTIONS POUR TESTER SECURITE D'UN MDP ----------------------------------------------------------------------------//
	}