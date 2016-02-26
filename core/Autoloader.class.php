<?php
	namespace core;

	class Autoloader {

		public static function register() {
			spl_autoload_register(array(__CLASS__, "autoload"));
		}

		public static function autoload($class) {
			$class = str_replace(__NAMESPACE__.'\\', '', $class);
			$class = str_replace('\\', '/', $class);
			require($class.'.class.php');
		}
	}