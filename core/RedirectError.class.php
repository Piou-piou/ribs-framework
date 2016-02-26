<?php
	namespace core;

	use core\modules\RouterModule;

	class RedirectError {

		/**
		 * @param integer $type
		 */
		public static function Redirect($type) {
			if ($type == 404) {
				header("HTTP/1.0 404 Not Found");
				header("location:".WEBROOT."404");
				die();
			}
		}


		/**
		 * test si la requete qui va chercher l'url de la page ++ les meta renvoi un resultat
		 * si elle ne renvoit pas de résultat, page does not  exist donc 404
		 * @param $query
		 * @param $url -> l'url a tester
		 * @return bool
		 */
		public static function testRedirect404($query, $url) {
			if (is_array($query)) {
				$count_query = count($query);
			}
			else {
				$count_query = 0;
			}


			$find   = 'controller/';
			$pos = strpos($url, $find);

			if ($pos !== false) {
				$controller = true;
			}
			else {
				$controller = false;
			}

			if (($count_query > 0) || ((!is_array($query)) && ($query > 0)) || ($controller == true)) {
				return true;
			}
			else {
				$router = new RouterModule();

				if ($router->getRouteModuleExist($url) == false) {
					self::Redirect(404);
				}

				return false;
			}
		}
	}