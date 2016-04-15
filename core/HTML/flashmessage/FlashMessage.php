<?php
	namespace core\HTML\flashmessage;

	class FlashMessage {

		public function __construct() {
			self::setStartSession();
		}


		/**
		 * @param string $message message a affiche dans la popup d'erreur
		 * @param string $type type du message (error, success, info)
		 */
		public static function setFlash($message, $type = "error") {
			self::setStartSession();

			if ($type == "error") {
				$icone = "<i class='fa fa-close'></i>";
			}
			else if ($type == "success") {
				$icone = "<i class='fa fa-check'></i>";
			}
			else {
				$icone = "<i class='fa fa-info'></i>";
			}

			$_SESSION['flash'] = array(
				'message'=> $message,
				'type' => $type,
				'icone' => $icone
			);
		}

		/**
		 * pour afficher un message d'info definit avec setFlash()
		 */
		public static function getFlash() {
			self::setStartSession();
			if (isset($_SESSION['flash'])) {

				//on check si on vient de index.php ou admin.php
				if (strstr($_SERVER['SCRIPT_NAME'], "index.php")) {
					//definit le chemin sachant que l'on part de index.php
					$chemin = str_replace("\\", "/", str_replace("index.php", "", $_SERVER['SCRIPT_NAME']).__NAMESPACE__."/view/");
				}
				else if  (strstr($_SERVER['SCRIPT_NAME'], "installation.php")) {
					//definit le chemin sachant que l'on part de admin.php
					$chemin = str_replace("\\", "/", str_replace("installation.php", "", $_SERVER['SCRIPT_NAME']).__NAMESPACE__."/view/");
				}
				else {
					//definit le chemin sachant que l'on part de admin.php
					$chemin = str_replace("\\", "/", str_replace("admin.php", "", $_SERVER['SCRIPT_NAME']).__NAMESPACE__."/view/");
				}

				require("view/index.php");
				unset($_SESSION['flash']);
			}
		}

		private static function setStartSession() {
			if (session_id() == "") {
				session_start();
			}
		}
	}