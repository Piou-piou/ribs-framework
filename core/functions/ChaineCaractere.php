<?php

	namespace core\functions;

	/**
	 * Class ChaineCaractere qui contient des fonctions pour des traitements sur des chaies de caracteres
	 * @package core\functions
	 */
	class ChaineCaractere {
		/**
		 * créer une chaine de caractere aléatoire suivant une logneur donnée
		 * @param $longueur
		 * @return string
		 */
		public static function random($longueur) {
			$string = "";
			$chaine = "abcdefghijklmnpqrstuvwxyz0123456789";
			srand((double)microtime()*1000000);
			for ($i = 0; $i < $longueur; $i++) {
				$string .= $chaine[rand()%strlen($chaine)];
			}
			return $string;
		}

		/**
		 * enleve les accents les espace guillement.. pour une url
		 * @param $url
		 * @return mixed
		 */
		public static function setUrl($url) {
			$search = array(' ', 'é', '"\"', 'è', '"', 'ê', '@', '&', '(', ')', '[', ']', '?', '*', "'", '@', ':', '&', '#', 'à', '=', '+', '°', '!', '%', '|', '$', '£');
			$replace = array('-', 'e', '-', 'e', '-', 'e', 'a', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', 'a', '-', '-', '-', '-', '%', '-', '-', '-');

			return strtolower(str_replace($search, $replace, $url));
		}

		/**
		 * rechercher une chaine de caracatere dans une autre
		 * renvoi true si elle est trouvée
		 * @param $string
		 * @param $find
		 * @return bool
		 */
		public static function FindInString($string, $find) {
			if (strpos($string, $find) !== false) {
				return true;
			}
			else {
				return false;
			}
		}

		/**
		 * fonction qui test si on a que des carac
		 * @param $string
		 * @return bool
		 */
		public static function alphaNumeric($string) {
			if (!preg_match('/^[a-zA-Z0-9]+$/', $string)) {
				return false;
			}
			else {
				return true;
			}
		}
		
		
		/**
		 * @param $string
		 * @param int $lenght
		 * @return bool
		 * fonction qui test si la taille minimale de
		 */
		public static function testMinLenght($string, $lenght = 0) {
			if (strlen($string) > $lenght) {
				return true;
			}
			
			return false;
		}
	}