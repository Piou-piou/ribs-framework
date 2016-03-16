<?php
	namespace core;
	trait Querybuilder {
		protected $req_beginning;
		protected $champs = [];
		protected $value = [];
		protected $conditions = [];
		protected $table = [];

		abstract public function query();
		abstract public function prepare();

		
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