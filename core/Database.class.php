<?php
	namespace core;

	use core\HTML\flashmessage\FlashMessage;
	use PDO;

	class Database {
		private $db_type;
		private $db_name;
		private $db_user;
		private $db_pass;
		private $db_host;
		private $dbc;

		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct($db_type, $db_name, $db_user, $db_pass, $db_host) {
			$this->db_type = $db_type;
			$this->db_name = $db_name;
			$this->db_user = $db_user;
			$this->db_pass = $db_pass;
			$this->db_host = $db_host;
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//



		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * function qui fait la connexion a la bdd ne peu etre appelee que dans la classe
		 * @return PDO
		 */
		private function getPdo() {
			if ($this->dbc === null) {
				$dbc = new PDO($this->db_type.':host='.$this->db_host.';dbname='.$this->db_name, $this->db_user, $this->db_pass);
				$dbc->exec("set names utf8");
				$this->dbc = $dbc;
			}
			return $this->dbc;
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//

		//-------------------------- FUNCTION QUI FONT DES REQUETES SUR LA BDD --------------------------------------------//
		/**
		 * effectue une requete en selectr dans la BDD, si ok on renvoit les donnees sinon on renvoi une erreur
		 * @param $req
		 * @return array
		 */
		public function query($req) {
			$query = $this->getPdo()->query($req);

			if ($query) {
				$obj = $query->fetchAll(PDO::FETCH_OBJ);
				return $obj;
			}
			else {
				FlashMessage::setFlash("Une erreur est survenue en executant cette requette : ".$req);
			}
		}

		/**
		 * fonction qui prepare une requete et qui l'envoi, marche pour insert et update et delete
		 * @param $req -> la req a executer
		 * @param $value -> le ou les tableaux de valeurs
		 */
		public function prepare($req, $value = null) {
			//si pas de donnees
			if ($value === null) {
				$this->getPdo()->query($req);
			}
			else {
				$query = $this->getPdo()->prepare($req);
				//si on a plusieurs tableaux
				if (array_key_exists(0, $value)) {
					foreach ($value as $val) {
						if (!$query->execute($val)) {
							$err = true;
						}
					}
				}
				else {
					if (!$query->execute($value)) {
						$err = true;
					}
				}
			}

			//si on a une erreur on renvoi un message
			if (isset($err)) {
				FlashMessage::setFlash("Une erreur est survenue en executant cette requette : ".$req);
			}
		}

		/**
		 * pour savoir si une valeur sur un champ précis existe deja en bdd, renvoi true si vrai
		 * @param $table
		 * @param $champ
		 * @param $value
		 * @return boolean|null
		 */
		public function rechercherEgalite($table, $champ, $value, $id_table = null, $id = null) {
			if ($id == null) {
				$query = $this->getPdo()->query("SELECT COUNT($champ) as nb FROM $table WHERE $champ LIKE '$value'");
			}
			else {
				$query = $this->getPdo()->query("SELECT COUNT($champ) as nb FROM $table WHERE $champ LIKE '$value' AND $id_table != $id");
			}

			if (count($query) > 0) {
				foreach ($query as $obj) {
					$nb = $obj["nb"];
				}

				if (isset($nb)) return true;
			}
			else {
				return false;
			}
		}
		//-------------------------- FIN FUNCTION QUI FONT DES REQUETES SUR LA BDD --------------------------------------------//


		/**
		 * tester si une table dans la base donnee existe
		 * @param string $table definit la table pour laquelle on doit tester l'existance
		 * @return boolean
		 */
		public function TestTableExist($table) {
			$query = $this->getPdo()->query("SHOW TABLES LIKE '$table'");

			if ($query->rowCount() > 0) {
				return true;
			}
			else {
				return false;
			}
		}

		public function quote($quote) {
			return $this->getPdo()->quote($quote);
		}

		public function lastInsertId() {
			return $this->getPdo()->lastInsertId();
		}
	}
