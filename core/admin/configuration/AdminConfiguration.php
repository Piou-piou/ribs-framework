<?php
	namespace core\admin\configuration;

	use core\App;
	use core\Configuration;
	use core\HTML\flashmessage\FlashMessage;

	class AdminConfiguration extends Configuration {
		
		
		
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
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

		/**
		 * @param $option
		 * @param $activer
		 * fonction qui permet de modifier une option dans la configuration (responsive, cache...)
		 */
		public function setModificerOption($option, $activer) {
			$dbc = App::getDb();

			$value = [
				$option => $activer,
				"id_config" => 1
			];

			$dbc->prepare("UPDATE configuration SET $option=:$option WHERE ID_configuration=:id_config", $value);

			FlashMessage::setFlash("L'option $option a bien été modifiée", "success");
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}