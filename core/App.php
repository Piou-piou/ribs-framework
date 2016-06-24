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
		 * @param string $url
		 * fonction qui permet de supprmer un dossier avec toute son abrorescence en fonction d'une URL
		 */
		public static function supprimerDossier($url) {
			if (is_dir($url)) {
				$objects = scandir($url);
				foreach ($objects as $object) {
					if ($object != "." && $object != "..") {
						if (filetype($url."/".$object) == "dir") App::supprimerDossier($url."/".$object); else unlink($url."/".$object);
					}
				}
				reset($objects);
				rmdir($url);
			}
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
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
    
    
    
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}