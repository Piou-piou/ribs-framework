<?php

	namespace core\auth;

	class Inscription {
		protected $erreur;

		protected $nom;
		protected $prenom;
		protected $pseudo;
		protected $mdp;
		protected $mail;


		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct($datas) {
			$count = count($datas);
			for ($i = 0; $i < $count; $i++) {
				$function = "setVerif".ucfirst($datas[$i][0]);

				if (isset($datas[$i][2])) {
					$this->$function($datas[$i][1], $datas[$i][2]);
				}
				else {
					$this->$function($datas[$i][1]);
				}
			}
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//



		//-------------------------- GETTER ----------------------------------------------------------------------------//
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
		public function getErreur() {
			return $this->erreur; ;
		}

		/**
		 * @param $value
		 * @return bool
		 */
		protected function getTestRequired($value) {
			if (($value == "") || ($value == null) || (strlen($value) == 0)) {
				return false;
			}
			else {
				return true;
			}
		}

		/**
		 * @param $value
		 * @param integer $longeur
		 * @return bool
		 */
		protected function getTestLongueur($value, $longeur) {
			if (strlen($value) > $longeur) {
				return true;
			}
			else {
				return false;
			}
		}

		/**
		 * @param $value
		 * @return bool
		 */
		protected function getTestInt($value) {
			if (is_numeric($value)) {
				return true;
			}
			else {
				return false;
			}
		}

		/**
		 * @param $varaible
		 * @param $value
		 * @param $erreur
		 * @param $erreur_long
		 * @param null $required
		 * @return bool
		 */
		protected function getTestValue($varaible, $value, $erreur, $erreur_long, $required = null) {
			//test avec le required, si le champe est vide et que le required est != null on return fa	lse sinon on va tester
			if (($required != null) && ($this->getTestRequired($value) === false)) {
				$this->erreur .= "<li>$erreur</li>";
				return false;
			}
			else {
				if (($value != "") && ($this->getTestLongueur($value, 2) === true)) {
					$this->$varaible = $value;
					return true;
				}
				else if (($value != "") && ($this->getTestLongueur($value, 2) === false)) {
					$this->erreur .= "<li>$erreur_long</li>";
					return false;
				}
				else {
					return true;
				}
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//



		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * fonction qui permet de vérifié si le champs nom est conforme
		 * @param $value
		 * @param null $required
		 * @return bool
		 */
		protected function setVerifNom($value, $required = null) {
			return $this->getTestValue("nom", $value, "Le champs nom ne peut pas être vide", "Le champs nom doit être supérieur à deux caractères", $required);
		}

		/**
		 * fonction qui permet de vérifié si le champs nom est conforme
		 * @param $value
		 * @param null $required
		 * @return bool
		 */
		protected function setVerifPrenom($value, $required = null) {
			return $this->getTestValue("prenom", $value, "Le champs prénom ne peut pas être vide", "Le champs prénom doit être supérieur à deux caractères", $required);
		}

		/**
		 * fonction qui permet de vérifier que le mdp est ok
		 * @param $value
		 * @param null $required
		 * @return bool
		 */
		protected function setVerifMdp($value, $required = null) {
			return $this->getTestValue("mdp", $value, "Le champs mot de passe ne peut pas être vide", "Le champs mot de passe doit être supérieur à deux caractères", $required);
		}

		/**
		 * fonction qui permet de vérifier que le verif_mdp == mdp
		 * @param $value
		 * @return bool
		 */
		protected function setVerifRetapeMdp($value) {
			if ($this->mdp == $value) {
				return true;
			}
			else {
				$this->erreur .= "<li>Les mots de passent ne correspondent pas</li>";
				$this->mdp = null;
				return false;
			}
		}

		/**
		 * fonction qui permet de vérifié si le champs pseudo est conforme
		 * @param $value
		 * @param null $required
		 * @return bool
		 */
		protected function setVerifPseudo($value, $required = null) {
			return $this->getTestValue("pseudo", $value, "Le champs pseudo ne peut pas être vide", "Le champs pseudo doit être supérieur à deux caractères", $required);
		}

		/**
		 * fonction qui permet de vérifié si le champs nom est conforme
		 * @param $value
		 * @param null $required
		 * @return bool
		 */
		protected function setVerifMail($value, $required = null) {
			//test avec le required, si le champe est vide et que le required est != null on return fa	lse sinon on va tester
			if (($required != null) && ($this->getTestRequired($value) === false)) {
				$this->erreur .= "<li>Le champs E-mail ne peut pas être vide</li>";
				return false;
			}
			else {
				if (($value != "") && (filter_var($value, FILTER_VALIDATE_EMAIL) != false)) {
					$this->mail = $value;
					return true;
				}
				else if (($value != "") && (filter_var($value, FILTER_VALIDATE_EMAIL) == false)) {
					$this->erreur .= "<li>Le champs E-mail doit être une adresse E-mail valide</li>";
					return false;
				}
				else {
					return true;
				}
			}
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}