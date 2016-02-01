<?php

    namespace core\mail;
        
    class Mail {
        private $mail;
    
    
        //-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
        public function __construct($mail=null) {
            $this->mail = $mail;
        }
        //-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
    
    
    
        //-------------------------- GETTER ----------------------------------------------------------------------------//
        //-------------------------- FIN GETTER ----------------------------------------------------------------------------//


    
        //-------------------------- SETTER ----------------------------------------------------------------------------//
        /**
         * fonction qui permet de valider si un E-mail est valide
         * @return bool
         */
        public function setVerifierMail() {
            if (filter_var($this->mail, FILTER_VALIDATE_EMAIL)) {
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
        public function setEnvoyerMail($sujet, $message, $destinataire=null, $from=null) {
            //on récupere le mail du site
            $config = new \core\Configuration();

            if ($from == null) $from = $config->getMailSite();

            $headers = 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= "From: ".$from;

            //si pas de destinataire on envoi le mail au gérant du site car c'est un mail envoyé par le site lui même
            if (($destinataire == null) && ($this->mail == null)) {
                $destinataire = $config->getMailSite();
            }
            else if ($destinataire == null) {
                $destinataire = $this->mail;
            }

            if (mail($destinataire, $sujet, $message, $headers)) {
                return true;
            }
            else {
                return false;
            }
        }
        //-------------------------- FIN SETTER ----------------------------------------------------------------------------//
    }