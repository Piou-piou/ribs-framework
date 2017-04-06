<?php
	namespace core\database;
	trait Querybuilder {
		protected $req_beginning;
		protected $select_champ = [];
		protected $champs = [];
		protected $value = [];
		protected $champs_where = [];
		protected $value_where = [];
		protected $conditions = [];
		protected $conditions_table = [];
		protected $closure = [];
		protected $table = [];
		protected $values = [];
		protected $order_by;
		protected $group_by;
		protected $limit;
		
		abstract public function prepare($req, $value);
		
		
		//-------------------------- QUERY BUILDER --------------------------------------------//
		/**
		 * @param string $champs
		 * @return $this
		 *
		 * pour initialisé une requete avec un select
		 */
		public function select($champs = "*") {
			$this->req_beginning = "SELECT ";
			$this->select_champ[] = $champs;
			
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
		 * @param string $table
		 * @return $this
		 *
		 * pour initialiser la les listes des tables ou il faudra aler chercher les données
		 */
		public function from($table) {
			$this->table[] = $table;
			
			return $this;
		}
		
		/**
		 * @param string $table
		 *
		 * pour initialiser la table dans laquelle on va insérer les données
		 */
		public function into($table) {
			$this->table[] = $table;
			
			return $this;
		}
		
		/**
		 * @param $champ
		 * @param string $cond
		 * @param $champ_test
		 * @param string $closure
		 * @param bool $no_bind
		 * @return $this
		 * pour intialiser la ou les clauses where d'une requete
		 */
		public function where($champ, $cond, $champ_test, $closure = "", $no_bind = false) {
			$this->closure[] = $closure;
			
			if ($no_bind === true) {
				$this->conditions_table[] = $champ.$cond.$champ_test." ".$closure;
			}
			else {
				$this->conditions[] = $cond;
				$this->addWhere($champ, $champ_test);
			}
			
			return $this;
		}
		
		/**
		 * @param string $order
		 * @param string $type
		 */
		public function orderBy($order, $type = null) {
			if ($type === null) {
				$type = "ASC";
			}
			
			$this->order_by = " ORDER BY ".$order." ".$type." ";
			
			return $this;
		}
		
		/**
		 * @param integer $debut
		 * @param integer $fin
		 */
		public function limit($debut, $fin = "no") {
			if ($fin == "no") {
				$this->limit = " LIMIT ".$debut." ";
			}
			else {
				$this->limit = " LIMIT ".$debut.", ".$fin." ";
			}
			
			
			return $this;
		}
		
		public function groupBy($name) {
			$this->group_by = " GROUP BY ".$name." ";
			
			return $this;
		}
		
		/**
		 * @return array
		 *
		 * fonction qui permet de récupérer un select fait sur une table
		 */
		public function get() {
			$values = [];
			$requete = $this->req_beginning.implode(",", $this->select_champ)." FROM ".implode(",", $this->table);
			if ((!empty($this->conditions)) || (!empty($this->conditions_table))) {
				$requete .= $this->getWhereConditions()[0];
				$values = $this->getWhereConditions()[1];
			}
			
			$requete .= $this->group_by;
			
			$requete .= $this->order_by;
			
			$requete .= $this->limit;
			
			$this->unsetQueryBuilder();
			return $this->prepare($requete, $values);
		}
		
		/**
		 * fonction utlisée pour terminer un insert ou un update dans la base de données
		 */
		public function set() {
			$this->values = array_combine($this->champs, $this->value);
			$datas = [];
			$count = count($this->champs);
			for ($i = 0; $i < $count; $i++) {
				$datas[] = $this->champs[$i]."=:".$this->champs[$i];
			}
			
			//si on a des conditions alors on sera dans un insert
			$requete = $this->req_beginning.implode(",", $this->table)." SET ".implode(", ", $datas);
			
			if ((!empty($this->conditions)) || (!empty($this->conditions_table))) {
				$requete .= $this->getWhereConditions()[0];
				$this->setValues();
			}
			
			$requete .= $this->limit;
			
			$this->prepare($requete, $this->values);
			$this->unsetQueryBuilder();
		}
		
		/**
		 * fonction utilisée pour finir un delete
		 */
		public function del() {
			$requete = $this->req_beginning.implode(",", $this->table);
			
			if (!empty($this->conditions)) {
				$requete .= $this->getWhereConditions()[0];
				$this->setValues();
			}
			
			$requete .= $this->order_by;
			
			$requete .= $this->limit;
			
			$this->prepare($requete, $this->values);
			$this->unsetQueryBuilder();
		}
		
		
		
		//-------------------------- PRIVATE FUNCTIONS --------------------------------------------//
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
		 * @param $champ
		 * @param $value
		 *
		 * fonction qui se cahrge d'ajouter les valeurs et les champs si non null dans leurs
		 * tableaux respectifs (appellée dans this->insert et this->update
		 */
		private function addWhere($champ, $value) {
			if (($champ !== null) && ($value !== null)) {
				$this->champs_where[] = $champ;
				$this->value_where[] = $value;
			}
		}
		
		/**
		 * @return array
		 * crée les tableau et renvoi la clause where
		 */
		private function getWhereConditions() {
			$values = [];
			$datas = [];
			
			if ((!empty($this->conditions))) {
				$values = array_combine(str_replace(".", "", $this->champs_where), $this->value_where);
				
				$count = count($this->champs_where);
				
				for ($i = 0; $i < $count; $i++) {
					$datas[] = $this->champs_where[$i]." ".$this->conditions[$i]." :".str_replace(".", "", $this->champs_where[$i])." ".$this->closure[$i]." ";
				}
			}
			
			if ((!empty($this->conditions_table))) {
				foreach ($this->conditions_table as $cond) {
					$datas[] = $cond;
				}
			}
			
			return [" WHERE ".implode(" ", $datas), $values];
		}
		
		/**
		 * function that set values for insert update and delete
		 */
		private function setValues() {
			$this->values = array_merge($this->values, $this->getWhereConditions()[1]);
		}
		
		/**
		 * fonction qui détruit toutes les variables utilisées.
		 */
		private function unsetQueryBuilder() {
			$this->req_beginning;
			$this->select_champ = [];
			$this->champs = [];
			$this->value = [];
			$this->values = [];
			$this->champs_where = [];
			$this->value_where = [];
			$this->conditions = [];
			$this->conditions_table = [];
			$this->closure = [];
			$this->table = [];
			$this->order_by = "";
			$this->group_by = "";
			$this->limit = "";
		}
	}