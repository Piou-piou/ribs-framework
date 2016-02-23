<?php
	namespace core\admin\configuration;

	use core\Configuration;

	class AdminConfiguration extends Configuration {
		
		
		
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct() {
			
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @param $nom_site
		 * @param $url_site
		 * @param $gerant_site
		 * @param $mail_site
		 * @param $mail_administrateur
		 * fonction qui permet de mettre à jour la configuration du site sans avoir besoin de passer par la bdd
		 */
		public function setModifierConfiguration($nom_site, $url_site, $gerant_site, $mail_site, $mail_administrateur) {
			$dbc = App::getDb();

			$value = [
				"nom_site" => $nom_site,
				"url_site" => $url_site,
				"gerant_site" => $gerant_site,
				"mail_site" => $mail_site,
				"mail_administrateur" => $mail_administrateur,
				"id_configuration" => 1
			];

			$dbc->prepare("UPDATE configuration SET nom_site=:nom_site, url_site=:url_site, gerant_site=:gerant_site, mail_site=:mail_site, mail_administrateur=:mail_administrateur WHERE ID_configuration=:id_configuration", $value);

			$_SESSION['nom_site'] = $nom_site;
			$_SESSION['url_site'] = $url_site;
			$_SESSION['gerant_site'] = $gerant_site;
			$_SESSION['mail_site'] = $mail_site;
			$_SESSION['mail_administrateur'] = $mail_administrateur;
			$_SESSION['err_modification_infos_config'] = true;

			FlashMessage::setFlash("la configuration de votre site a été correctement mse à jour", "success");
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}