<?php
	namespace core\iniparser;

	class IniParser {
		private $file;
		
		
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct($file = null) {
			//if we got a file, we parse it
			if ($file != null) {
				$this->file = $file;
			}
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getParse() {
			return parse_ini_file($this->file);
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @param $developpment
		 * @param $dev_info
		 * @param $prod_info
		 * function to modify informations in config.ini file
		 */
		public function setModifierConfigIni($developpment, $dev_info, $prod_info) {
			$value = "installation = 0
				developpment = $developpment

				[dev]
				dev[DB_TYPE] = $dev_info[0]
				dev[DB_NAME] = $dev_info[1]
				dev[DB_USER] = $dev_info[2]
				dev[DB_PASS] = $dev_info[3]
				dev[DB_HOST] = $dev_info[4]
				dev[IMGROOT] = $dev_info[5]
				dev[ROOTCKFINDER] = $dev_info[6]

				[prod]
				prod[DB_TYPE] = $prod_info[0]
				prod[DB_NAME] = $prod_info[1]
				prod[DB_USER] = $prod_info[2]
				prod[DB_PASS] = $prod_info[3]
				prod[DB_HOST] = $prod_info[4]
				prod[IMGROOT] = $prod_info[5]
				prod[ROOTCKFINDER] = $prod_info[6]";

			$value = str_replace("\t", "", $value);

			file_put_contents(ROOT."config/config.ini", $value);
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}