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
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
    
    
    
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}