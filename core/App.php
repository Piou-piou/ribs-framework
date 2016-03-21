<?php
	namespace core;

	use core\database\Database;

	class App {
		private static $database;
		private static $nav;
		private static $erreur;
    
    
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct() {
            
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
    
    
    
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public static function getErreur() {
			return self::$erreur;
		}

		/**
		 * @return Database
		 * renvoi une instance de la classe Database
		 */
		public static function getDb() {
			if (self::$database == null) {
				self::$database = new Database(DB_TYPE, DB_NAME, DB_USER, DB_PASS, DB_HOST);
			}
			return self::$database;
		}

		/**
		 * @param null $no_module
		 * @return Navigation
		 * renvoi une instancde de la class navigation
		 */
		public static function getNav($no_module = null) {
			if (self::$nav == null) {
				self::$nav = new Navigation($no_module);
			}

			return self::$nav;
		}

		/**
		 * @param $nom_table
		 * @param $nom_id_table
		 * @param $champ
		 * @param $value
		 * @param $limit_char
		 * @param $err_char
		 * @param $err_egalite
		 * @param null $value_id_table
		 * @return string
		 * fonction qui permet de vérifier qu'il n'y ait pas d'erreur dans le champ spécifié ni de doublons
		 */
		public static function getVerifChamp($nom_table, $nom_id_table, $champ, $value, $limit_char, $err_char, $err_egalite, $value_id_table = null) {
			$dbc = self::getDb();

			if (strlen(utf8_decode($value)) > $limit_char) {
				self::$erreur = true;
				return "<li>$err_char</li>";
			}
			else if ($dbc->rechercherEgalite($nom_table, $champ, $value, $nom_id_table, $value_id_table) == true) {
				self::$erreur = true;
				return "<li>$err_egalite</li>";
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
    
    
    
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}