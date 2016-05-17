<?php
	namespace core\functions;

	use core\HTML\flashmessage\FlashMessage;

	/**
	 * Class DateHeure
	 * contient des fonctions afin de faire des calculs sur des dates et des heures,
	 * class static
	 * @package core\functions
	 */
	class DateHeure {
		public static $annee;
		public static $mois;
		public static $jour;



		/**
		 * Fonction pour passer du format H:m en seconde
		 * @param int $heure recoit l'heure a passer en minute
		 * @param int $minute recoit les minutes a passer en minute
		 * @return double|null
		 **/
		public static function Heureenseconde($heure, $minute) {
			if ((is_numeric($heure)) && (is_numeric($minute))) {
				$heuresec = $heure * 3600;
				$minutesec = $minute * 60;
				$heureseconde = $heuresec + $minutesec;
				return $heureseconde;
			}
			else {
				FlashMessage::setFlash("La/les valeurs entrée n'est/ne sont pas de type int");
				FlashMessage::getFlash();
				die();
			}
		}

		/**
		 * passe des secondes au format H:m
		 * @return string
		 */
		public static function Secondeenheure($seconde) {
			if (is_numeric($seconde)) {
				$heure = intval($seconde / 3600);
				$minute = intval(($seconde % 3600) / 60);
				$seconde = intval(($seconde % 3600) % 60);

				$temps = $heure."h".$minute."m".$seconde;
				return $temps;
			}
			else {
				FlashMessage::setFlash("La valeur entrée n'est pas de type int");
				FlashMessage::getFlash();
				die();
			}
		}

		/**
		 * fonction qui change le format heure 12:10 en 12h10
		 * @param $temps
		 * @return mixed
		 */
		public static function ChangerFormatHeure($temps) {
			if (ChaineCaractere::FindInString($temps, ":") === true) {
				$chaine = str_replace(":", "h", $temps);

				return $chaine;
			}
			else {
				FlashMessage::setFlash("La valeur entrée n'est pas de type h:m");
				FlashMessage::getFlash();
				die();
			}
		}

		/**
		 * affiche la date du jour au format jeudi 12 janvier
		 * @param integer $date si NULL on prend la date du jour sinon on prend la date qui est mise
		 * @return string
		 */
		public static function date_fr_texte($date = 0) {
			$mois = array("Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre");
			$jours = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");

			if ($date == 0) {
				return $jours[date("w")]." ".date("j").(date("j") == 1 ? "er" : " ").$mois[date("n") - 1]." ".date("Y");
			}
			else if ((strpos($date, "-") > 0) || (strpos($date, "/") > 0)) {
				$explode = explode("/", $date);
				$jour_d = $explode[0];
				$mois_d = $explode[1];
				$annee_d = $explode[2];

				//si $pos > 0 cela veut dire qu'on est en YYYY-mm-jj
				$pos = strpos($date, "-");
				if ($pos > 0) {
					$explode = explode("-", $date);
					$jour_d = $explode[2];
					$mois_d = $explode[1];
					$annee_d = $explode[0];
				}

				$jour_semaine = $jours[date("w", mktime(0, 0, 0, $mois_d, $jour_d, $annee_d))];

				return $jour_semaine." ".$jour_d." ".$mois[$mois_d - 1]." ".$annee_d;
			}

			FlashMessage::setFlash("Format de date passé en paramètre ne correspond pas à YYYY-mm-jj ou jj/mm/YYYY");
			FlashMessage::getFlash();
			die();
		}

		/**
		 * Transformation de la date format YYYY-mm-jj en jj/mm/aaaa
		 * @param string $date corespond a la date au format YYYY-mm-jj
		 * @return string
		 */
		public static function modif_date_affichage($date) {
			$pos = strpos($date, "-");

			if ($pos > 0) {
				$explode = explode("-", $date);
				$jour = $explode[2];
				$mois = $explode[1];
				$annee = $explode[0];

				self::$jour = $jour;
				self::$mois = $mois;
				self::$annee = $annee;

				return $jour."/".$mois."/".$annee;
			}
			else {
				FlashMessage::setFlash("format de date passé en paramètre ne correspond pas à YYYY-mm-jj");
				FlashMessage::getFlash();
				die();
			}
		}

		/**
		 * Transformation de la date format jj/mm/aaaa en YYYY-mm-jj pour insertion bdd
		 * @param string $date corespond a la date au format jj/mm/aaaa
		 * @return string
		 */
		public static function modif_date_bdd($date) {
			$pos = strpos($date, "/");

			if ($pos > 0) {
				$explode = explode("/", $date);
				$jour = $explode[0];
				$mois = $explode[1];
				$annee = $explode[2];

				return $annee."-".$mois."-".$jour;
			}
			else {
				FlashMessage::setFlash("Format de date passé en paramètre ne correspond pas à jj/mm/aaaa");
				FlashMessage::getFlash();
				die();
			}
		}

		/**
		 * fonction qui permet de passer une date d'une bdd en tableau
		 * @param $date
		 * @return array
		 */
		public static function dateBddToArray($date) {
			$array = explode("-", $date);

			return $array;
		}
	}