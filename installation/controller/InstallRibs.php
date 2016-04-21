<?php
	namespace installation\controller;
	use core\functions\ChaineCaractere;
	use core\HTML\flashmessage\FlashMessage;

	class InstallRibs {
		private $db_type;
		private $db_name;
		private $db_user;
		private $db_pass;
		private $db_host;

		private $dbc;

		private $erreur;
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct($db_type, $db_host, $db_name, $db_user, $db_pass) {
			$this->db_type = $db_type;
			$this->db_name = $db_name;
			$this->db_user = $db_user;
			$this->db_pass = $db_pass;
			$this->db_host = $db_host;

			try {
				$this->dbc = new \PDO($this->db_type.':host='.$this->db_host.';dbname='.$this->db_name, $this->db_user, $this->db_pass);

				$this->setinstallbdd();
			}
			catch (\PDOException $e) {
				//on tente de créer la bdd
				$erreur = "getErreur".$e->getCode();
				$this->$erreur();
			}
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getErreur() {
			return $this->erreur;
		}

		/**
		 * server adress not ok
		 */
		private function getErreur2002() {
			FlashMessage::setFlash("Le serveur : ".$this->db_host." est introuvable");

			$this->erreur = true;
		}

		/**
		 * seerver type not correct
		 */
		private function getErreur0() {
			FlashMessage::setFlash("Le type : ".$this->db_type." n'est pas un type de base de données correct");

			$this->erreur = true;
		}

		/**
		 * couldn't find database
		 */
		private function getErreur1049() {
			//si on ne trouve pas la bdd on la créée
			$dbc = new \PDO($this->db_type.':host='.$this->db_host, $this->db_user, $this->db_pass);

			$dbc->query("CREATE DATABASE ".$this->db_name." DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci");

			$this->dbc = new \PDO($this->db_type.':host='.$this->db_host.';dbname='.$this->db_name, $this->db_user, $this->db_pass);

			$this->setinstallbdd();
		}

		/**
		 * user uncorrect
		 */
		private function getErreur1044() {
			FlashMessage::setFlash("Le nom d'utilisateur : ".$this->db_user." est incorrect");

			$this->erreur = true;
		}

		/**
		 * password uncorrect
		 */
		private function getErreur1045() {
			FlashMessage::setFlash("Le  mot de passe : ".$this->db_pass." est incorrect");

			$this->erreur = true;
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		private function setinstallbdd() {
			$this->dbc->query(file_get_contents(ROOT.'installation/controller/sq/install.sql'));
		}
		//-------------------------- END SETTER ----------------------------------------------------------------------------//
	}