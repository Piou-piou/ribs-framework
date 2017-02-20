<?php
	namespace core;

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
		private $desactiver_navigation; //-> si == 1 alors on n'affichera pas la nav dans principal.php

		//pour la configuration des comptes
		private $valider_inscription;
		private $activer_inscription;
		private $activer_connexion;


		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct() {
			//pour la configuration générale du site
			$this->getConfigurationGenerale();

			//pour la configuration des comptes
			$this->getConfigurationCompte();
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//



		//-------------------------- GETTER ----------------------------------------------------------------------------//
		//pour la configuration générale du site
		public function getNomSite() {
			return $this->nom_site;
		}

		/**
		 * @return string|null
		 */
		public function getMailSite() {
			return $this->mail_site;
		}
		public function getGerantSite() {
			return $this->gerant_site;
		}
		public function getUrlSite() {
			return $this->url_site;
		}
		public function getMailAdministrateur() {
			return $this->mail_administrateur;
		}
		public function getLastSave() {
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
		public function getDesactiverNavigation(){
		    return $this->desactiver_navigation;
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

		private function getConfigurationGenerale() {
			$dbc = App::getDb();

			$query = $dbc->select()->from("configuration")->where("ID_configuration", "=", 1)->get();

			if ((is_array($query)) && (count($query) > 0)) {
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
					$this->desactiver_navigation = $obj->desactiver_navigation;
				}
			}
		}

		private function getConfigurationCompte() {
			$dbc = App::getDb();

			$query = $dbc->select()->from("configuration_compte")->where("ID_configuration_compte", "=", 1)->get();

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$this->valider_inscription = $obj->valider_inscription;
					$this->activer_inscription = $obj->activer_inscription;
					$this->activer_connexion = $obj->activer_connexion;
				}
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//



		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * fonction qui permet de mettre à jour la date de la derniere save de la bdd
		 * + supprimer la sauverde ancienne d'il y a 1 mois
		 */
		public function setDateSaveToday() {
			$dbc = App::getDb();

			$dbc->update("last_save", date("Y-m-d"))->from("configuration")->where("ID_configuration", "=", 1)->set();

			$today = new \DateTime(date("Y-m-d"));
			$today->sub(new \DateInterval('P32D'));

			$nom_save = "save-".$today->format("Y-m-d").".sql";

			if (file_exists(ROOT."bdd_backup/".$nom_save)) {
				unlink(ROOT."bdd_backup/".$nom_save);
			}
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}