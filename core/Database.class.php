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

		//pour le query builder
		private $req_beginning;
		private $champs = [];
		private $value = [];
		private $conditions = [];
		private $table = [];



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
		public function prepare($req, $value) {
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

				if ((isset($nb)) && ($nb != 0)) return true;
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



		//-------------------------- QUERY BUILDER in construction no test have been done --------------------------------------------//
		/**
		 * @param string $champs
		 * @return $this
		 *
		 * pour initialisé une requete avec un select
		 */
		public function select($champs = "*") {
			$this->req_beginning = "SELECT ";
			$this->champs[] = $champs;

			return $this;
		}

		/**
		 * @param $champ
		 * @param $value
		 * @return $this
		 *
		 * fonction qui permet de préparer les champs et la valeur qui y sera associée
		 */
		public function insert($champ, $value) {
			$this->add($champ, $value);

			$this->req_beginning = "INSERT INTO ";

			return $this;
		}

		/**
		 * @param $champ
		 * @param $value
		 * @return $this
		 */
		public function update($champ, $value) {
			$this->add($champ, $value);

			$this->req_beginning = "UPDATE ";

			return $this;
		}

		/**
		 * @return $this
		 *
		 * fonction qui initialise un delete en base de donnée
		 */
		public function delete() {
			$this->req_beginning = "DELETE FROM ";

			return $this;
		}

		/**
		 * @param $champ
		 * @param $value
		 *
		 * fonction qui se cahrge d'ajouter les valeurs et les champs si non null dans leurs
		 * tableaux respectifs (appellée dans this->insert et this->update
		 */
		private function add($champ, $value) {
			if (($champ !== null) && ($value !== null)) {
				$this->champs[] = $champ;
				$this->value[] = $value;
			}
		}

		/**
		 * @param $table
		 * @return $this
		 *
		 * pour initialiser la les listes des tables ou il faudra aler chercher les données
		 */
		public function from($table) {
			$this->table[] = $table;

			return $this;
		}

		/**
		 * @param $table
		 *
		 * pour initialiser la table dans laquelle on va insérer les données
		 */
		public function into($table) {
			$this->table[] = $table;

			return $this;
		}

		/**
		 * @param $champ
		 * @param $cond
		 * @param $champ_test
		 * @param null $closure
		 * @return $this
		 *
		 * pour intialiser la ou les clauses where d'une requete
		 */
		public function where($champ, $cond, $champ_test, $closure = null) {
			if ( $closure === null) {
				$this->conditions[] = $champ.$cond.$champ_test;
			}
			else {
				$this->conditions[] = $champ.$cond.$champ_test." ".$closure;
			}

			return $this;
		}

		/**
		 * @return array
		 *
		 * fonction qui permet de récupérer un select fait sur une table
		 */
		public function get() {
			$requete = $this->req_beginning . implode(",", $this->champs) . " FROM " . implode(",", $this->table);

			if (!empty($this->conditions)) {
				$requete .= " WHERE ". implode(" ", $this->conditions);
			}

			$this->unsetQueryBuilder();
			return $this->query($requete);
		}

		/**
		 * fonction utlisée pour terminer un insert ou un update dans la base de données
		 */
		public function set() {
			$values = array_combine($this->champs, $this->value);

			$datas = [];
			$count = count($this->champs);
			for ($i=0 ; $i<$count ; $i++) {
				$datas[] = $this->champs[$i]."=:".$this->champs[$i];
			}

			//si on a des conditions alors on sera dans un insert
			$requete = $this->req_beginning . implode(",", $this->table) . " SET " . implode(", ", $datas);

			if (!empty($this->conditions)) {
				$requete .= " WHERE " . implode(" ", $this->conditions);
			}

			$this->prepare($requete, $values);
			$this->unsetQueryBuilder();
		}

		/**
		 * fonction utilisée pour finir un delete
		 */
		public function del() {
			$requete = $this->req_beginning . implode(",", $this->table);

			if (!empty($this->conditions)) {
				$requete .= " WHERE " . implode(" ", $this->conditions);
			}

			$this->query($requete);
			$this->unsetQueryBuilder();
		}

		/**
		 * fonction qui détruit toutes les variables utilisées.
		 */
		private function unsetQueryBuilder() {
			$this->req_beginning;
			$this->champs = [];
			$this->value = [];
			$this->conditions = [];
			$this->table = [];
		}
	}