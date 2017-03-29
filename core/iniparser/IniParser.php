<?php
	namespace core\iniparser;

	class IniParser {


		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct() {
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getParse($file) {
			if (file_exists($file)) {
				return parse_ini_file($file);
			}
			else {
				return false;
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @param $dev_info
		 * fonction pour modifier les infos dans config.ini
		 */
		public function setModifierConfigIni($dev_info) {
			$value = "installation = 0
				developpment = 1

				[dev]
				dev[DB_TYPE] = $dev_info[0]
				dev[DB_NAME] = $dev_info[1]
				dev[DB_USER] = $dev_info[2]
				dev[DB_PASS] = $dev_info[3]
				dev[DB_HOST] = $dev_info[4]
				dev[SMTP_HOST] =
				dev[SMTP_USER] =
				dev[SMTP_PASS] =
				dev[SMTP_SECURE] =
				dev[SMTP_PORT] =";

			$value = str_replace("\t", "", $value);

			file_put_contents(ROOT."config/config.ini", $value);
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}