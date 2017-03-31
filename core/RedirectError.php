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
			$find = 'controller/';
			$controller = strpos($url, $find);

			if (((is_array($query)) && (count($query) == 1)) || ($controller !== false)) {
				return true;
			}
			
			$router = new RouterModule();
			
			if ($router->getRouteModuleExist($url) !== true) {
				self::Redirect(404);
			}
			
			return false;
		}
	}