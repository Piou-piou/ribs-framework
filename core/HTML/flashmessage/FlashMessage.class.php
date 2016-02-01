<?php
	namespace core\HTML\flashmessage;

	class FlashMessage {

		public function __construct() {

			if (session_id() == null) {
				session_start();
			}
		}


		/**
		 * @param string $message message a affiche dans la popup d'erreur
		 * @param string $type type du message (error, success, info)
		 */
		public static function setFlash($message, $type="error") {
			if (session_id() == "") {
				session_start();
			}

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
			if (session_id() == "") {
				session_start();
			}
			if (isset($_SESSION['flash'])) {
				$message = $_SESSION['flash']['message'];
				$type = $_SESSION['flash']['type'];
				$icone = $_SESSION['flash']['icone'];

				//test le fichier index.php du module existe
				if (file_exists(__DIR__."/view/index.php")) {
					//on check si on vient de index.php ou admin.php
					if (strstr($_SERVER['SCRIPT_NAME'], "index.php")) {
						//definit le chemin sachant que l'on part de index.php
						$chemin = str_replace("\\", "/", str_replace("index.php", "", $_SERVER['SCRIPT_NAME']).__NAMESPACE__."/view/");
					}
					else {
						//definit le chemin sachant que l'on part de admin.php
						$chemin = str_replace("\\", "/", str_replace("admin.php", "", $_SERVER['SCRIPT_NAME']).__NAMESPACE__."/view/");
					}


					require("view/index.php");
				}
				else {
					echo("$icone $type : $message");
				}
				unset($_SESSION['flash']);
			}
		}
	}