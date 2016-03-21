<?php

	namespace core\mail;
        
	class Mail {
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct() {
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
    
    
    
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//


    
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @param $email
		 * @return bool
		 * fonction qui permet de valider si un E-mail est valide
		 */
		public function setVerifierMail($email) {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return true;
			}
			else {
				return false;
			}
		}

		/**
		 * fonction qui permet d'envoyer un mail
		 * @param $sujet
		 * @param $message
		 * @param null $destinataire -> si  null on envoi un mail au gerant du site
		 * @param null $destinataire -> si  null on emet le gerant du site car mail vient depuis l'admin
		 * @return bool
		 */
		public function setEnvoyerMail($sujet, $message, $destinataire = null, $from = null) {
			//on récupere le mail du site
			$config = new \core\Configuration();

			if ($from == null) $from = $config->getMailSite();

			$headers = 'Content-type: text/html; charset=utf-8'."\r\n";
			$headers .= "From: ".$from;

			//si pas de destinataire on envoi le mail au gérant du site car c'est un mail envoyé par le site lui même
			if (($destinataire == null)) {
				$destinataire = $config->getMailSite();
			}

			if (mail($destinataire, $sujet, $message, $headers)) {
				return true;
			}

			return false;
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}