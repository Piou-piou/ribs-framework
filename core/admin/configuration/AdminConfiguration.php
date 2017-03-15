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
		 * @param $gerant_site
		 * @param $mail_site
		 * @param $mail_administrateur
		 * fonction qui permet de mettre à jour la configuration du site sans avoir besoin de passer par la bdd
		 */
		public function setModifierConfiguration($nom_site, $gerant_site, $mail_site, $mail_administrateur) {
			$dbc = App::getDb();

			$dbc->update("nom_site", $nom_site)
				->update("gerant_site", $gerant_site)
				->update("mail_site", $mail_site)
				->update("mail_administrateur", $mail_administrateur)
				->from("configuration")
				->where("ID_configuration", "=", 1)
				->set();

			$_SESSION['nom_site'] = $nom_site;
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

			$dbc->update($option, $activer)->from("configuration")->where("ID_configuration", "=", 1)->set();

			FlashMessage::setFlash("L'option $option a bien été modifiée", "success");
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}