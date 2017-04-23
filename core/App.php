<?php
	namespace core;

	use core\database\Database;

	class App {
		private static $database;
		private static $nav;
		private static $erreur;
		
		private static $title;
		private static $description;
		
		private static $values = [];
    
    
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct() {
            
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
    
    
    
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public static function getErreur() {
			return self::$erreur;
		}
		
		/**
		 * @return array
		 * get array of all values wich will be used in the page
		 */
		public static function getValues() {
			return ["app" => self::$values];
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
		 * @return mixed
		 * function tu get the title of the page
		 */
		public static function getTitle() {
			return self::$title;
		}
		
		/**
		 * @return mixed
		 * function to get description of the page
		 */
		public static function getDescription() {
			return self::$description;
		}

		/**
		 * @param string $url
		 * fonction qui permet de supprmer un dossier avec toute son abrorescence en fonction d'une URL
		 */
		public static function supprimerDossier($url) {
			if (is_dir($url) === true) {
				$files = array_diff(scandir($url), array('.', '..'));
				
				foreach ($files as $file) {
					self::supprimerDossier(realpath($url).'/'.$file);
				}
				
				return rmdir($url);
			}
			else if (is_file($url) === true) {
				return unlink($url);
			}
			
			return false;
		}

		/**
		 * @param $from
		 * @param $to
		 * @param $sujet
		 * @param $message
		 */
		public static function envoyerMail($from, $to, $sujet, $message) {
			$mail = new \Nette\Mail\Message();
			$mail->setFrom($from)
				->addTo($to)
				->setSubject($sujet)
				->setHtmlBody($message);

			if (SMTP_HOST != "") {
				$mailer = new \Nette\Mail\SmtpMailer([
					'host' => SMTP_HOST,
					'username' => SMTP_USER,
					'password' => SMTP_PASS,
					'secure' => SMTP_SECURE,
					'port' => SMTP_PORT
				]);
			}
			else {
				$mailer = new \Nette\Mail\SmtpMailer();
			}

			$mailer->send($mail);
		}
		
		/**
		 * @return int
		 */
		public static function getIdIdentite() {
			if (isset($_SESSION['idlogin'.CLEF_SITE])) {
				return $_SESSION['idlogin'.CLEF_SITE];
			}
			
			return 0;
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
    
    
    
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @param $values
		 * can set values while keep older infos
		 */
		public static function setValues($values) {
			self::$values = array_merge(self::$values, $values);
		}
		
		/**
		 * @param $title
		 * function to set title of the page
		 */
		public static function setTitle($title) {
			self::$title = $title;
		}
		
		/**
		 * @param $description
		 * function to set description of the page
		 */
		public static function setDescription($description) {
			self::$description = $description;
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}