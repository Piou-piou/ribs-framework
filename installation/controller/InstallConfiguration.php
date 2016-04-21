<?php
	namespace installation\controller;

	use core\App;

	class InstallConfiguration {
		
		
		
		//-------------------------- BUILDER ----------------------------------------------------------------------------//
		public function __construct($nom_site, $url_site, $gerant_site, $mail_site, $mail_administrateur) {
			$dbc = App::getDb();

			$dbc->insert("nom_site", $nom_site)
				->insert("url_site", $url_site)
				->insert("gerant_site", $gerant_site)
				->insert("mail_site", $mail_site)
				->insert("mail_administrateur", $mail_administrateur)
				->into("configuration")
				->set();

			FlashMessage::setFlash("la configuration de votre site a été correctement mse à jour", "success");
		}
		//-------------------------- END BUILDER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		//-------------------------- END SETTER ----------------------------------------------------------------------------//
	}