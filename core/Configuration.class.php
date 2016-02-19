<?php
    namespace core;


    use core\HTML\flashmessage\FlashMessage;

	class Configuration {
		//pour la configuration générale du site
        private $nom_site; //-> nom du site
        private $mail_site; //-> pour le gérant du site contact@nomdedomaine;com
        private $gerant_site; //->nom du gérant du site
        private $url_site; //-> url de site
        private $mail_administrateur; //-> mail de l'administrateur web@clicand.com
		private $last_save; //-> derniere sauvegarde de la bdd
		private $acces_admin; //-> si == 1 on a acces à l'admin
		private $contenu_dynamique; //->savoir si es contenus sont dynamique (stockés in DB)
		private $responsive; //-> si == 1 alors le site est reponsive et on charge foundation
		private $cache; //-> si == 1 alors on mets les pages du site en cache

		//pour la configuration des comptes
		private $valider_inscription;
		private $activer_inscription;
		private $activer_connexion;


        //-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
        public function __construct() {
            $dbc = \core\App::getDb();

			//pour la configuration générale du site
            $query = $dbc->query("SELECT * FROM configuration WHERE ID_configuration=1");
            foreach ($query as $obj) {
                $this->nom_site = $obj->nom_site;
                $this->mail_site = $obj->mail_site;
                $this->gerant_site = $obj->gerant_site;
                $this->url_site = $obj->url_site;
                $this->mail_administrateur = $obj->mail_administrateur;
                $this->last_save = $obj->last_save;
				$this->acces_admin = $obj->acces_admin;
				$this->contenu_dynamique = $obj->contenu_dynamique;
				$this->responsive = $obj->responsive;
				$this->cache = $obj->cache;
            }

			//pour la configuration des comptes
			$query = $dbc->query("SELECT * FROM configuration_compte WHERE ID_configuration_compte=1");
			foreach ($query as $obj) {
				$this->valider_inscription = $obj->valider_inscription;
				$this->activer_inscription = $obj->activer_inscription;
				$this->activer_connexion = $obj->activer_connexion;
			}
        }
        //-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//



        //-------------------------- GETTER ----------------------------------------------------------------------------//
		//pour la configuration générale du site
        public function getNomSite(){
            return $this->nom_site;
        }
        public function getMailSite(){
            return $this->mail_site;
        }
        public function getGerantSite(){
            return $this->gerant_site;
        }
        public function getUrlSite(){
            return $this->url_site;
        }
        public function getMailAdministrateur(){
            return $this->mail_administrateur;
        }
        public function getLastSave(){
            return $this->last_save;
        }
		public function getAccesAdmin() {
			return $this->acces_admin;
		}
		public function getContenusDynamique() {
			return $this->contenu_dynamique;
		}
		public function getResponsive() {
			return $this->responsive;
		}
		public function getCache() {
			return $this->cache;
		}

		//pour la configuration des comptes
		public function getValiderInscription() {
			return $this->valider_inscription;
		}
		public function getActiverInscription() {
			return $this->activer_inscription;
		}
		public function getActiverConnexion() {
			return $this->activer_connexion;
		}
        //-------------------------- FIN GETTER ----------------------------------------------------------------------------//



        //-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * fonction qui permet de mettre à jour la date de la derniere save de la bdd
		 * + supprimer la sauverde ancienne d'il y a 1 mois
		 */
		public function setDateSaveToday() {
			$dbc = App::getDb();

			$value = array(
				"date" => date("Y-m-d"),
				"id_configuration" => 1
			);

			$dbc->prepare("UPDATE configuration SET last_save=:date WHERE ID_configuration=:id_configuration", $value);

			$today = new \DateTime(date("Y-m-d"));
			$today->sub(new \DateInterval('P32D'));

			$nom_save = "save-".$today->format("Y-m-d").".sql";

			if (file_exists(ROOT."bdd_backup/".$nom_save)) {
				unlink(ROOT."bdd_backup/".$nom_save);
			}
		}

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