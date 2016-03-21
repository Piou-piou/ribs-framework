<?php
	namespace core\modules;

	use core\App;
	use core\HTML\flashmessage\FlashMessage;

	class ImportModule {
		private $nom_dossier;
		private $nom_fichier;
		private $extension;
		private $erreur;

		//pour les infos du module
		private $id_module;
		private $url_telechargement;
		private $version_ok;
		private $dossier_module;

		
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct() {
			//On test si dossier temporaire + modules a la racines existes bien sinon on les crées
			if (!file_exists(ROOT."temp")) mkdir(ROOT."temp");
			if (!file_exists(ROOT."modules")) mkdir(ROOT."modules");
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		private function getUrl($id) {
			$dbc = App::getDb();

			$query = $dbc->select("url")->from("module")->where("ID_module", "=", $id);

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					return MODULEROOT.$obj->url;
				}
			}
		}

		/**
		 * @param $id_module
		 * permets de récupérer des informations sur un module
		 */
		private function getInfoModule($id_module) {
			$dbc = App::getDb();

			$query = $dbc->query("select * from module WHERE ID_module=".$dbc->quote($id_module));

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$this->id_module = $obj->ID_module;
					$this->url_telechargement = $obj->url_telechargement;
					$this->version_ok = $obj->online_version;
					$this->dossier_module = str_replace("/", "", $obj->url);
				}
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		private function setInstallModule($url_module) {
			$zip = new \ZipArchive();

			if (($this->extension == "zip") &&
				(file_exists(MODULEROOT.$this->nom_dossier) == false) &&
				(file_put_contents(TEMPROOT.$this->nom_fichier, fopen($url_module, 'r')) != false) &&
				($zip->open(TEMPROOT.$this->nom_fichier) == true) &&
				($zip->extractTo(TEMPROOT) == true) &&
				(rename(TEMPROOT.$this->nom_dossier, MODULEROOT.$this->nom_dossier) == true)) {

				$zip->close();
				return true;
			}

			return false;
		}
		/**
		 * @param $url_module
		 * @param boolean $update
		 * fonction qui permets d'importer un module dans notre site internet
		 */
		public function setImportModule($url_module, $update = null) {
			$dbc = App::getDb();

			//avant tout on récupère le nom du fichier pour le mettre dans le dossier temporaire
			$explode = explode("/", $url_module);
			$this->nom_fichier = end($explode);

			//on recupere le nom du dossier + extention
			$explode = explode(".", $this->nom_fichier);
			$this->nom_dossier = $explode[0];
			$this->extension = $explode[1];

			if ($this->setInstallModule($url_module) == true) {
				$this->setSupprimerArchiveTemp();

				//si c'est une install et non une mise à jour
				if ($update == null) {
					$requete = "";
					require_once(MODULEROOT.$this->nom_dossier."/install.php");
					$dbc->query($requete);
				}

				FlashMessage::setFlash("Votre module a bien été ajouté au site.", "success");
			}
			else {
				FlashMessage::setFlash("Le module n'a pas pu être correctement téléchargé et installé, veuillez réesseyer dans un instant");
			}
		}

		/**
		 * @param $id_module
		 * permet de mettre à jour un module en gardant une copie de l'ancienne version pendant une semaine
		 */
		Public function setUpdateModule($id_module) {
			$dbc = App::getDb();

			$this->getInfoModule($id_module);

			//on rename le dossier actuel du module
			if (rename(MODULEROOT.$this->dossier_module, MODULEROOT.$this->dossier_module."_OLDVERSION")) {
				$this->setImportModule($this->url_telechargement, true);

				//si pas d'erreur on met la date de next check a la semaine pro ++ on dit
				//de delete l'ancienne version au next check
				if (($this->erreur !== true) || (!isset($this->erreur))) {
					$today = date("Y-m-d");
					$today = new \DateTime($today);

					$value = [
						"next_check" => $today->add(new \DateInterval("P1W"))->format("Y-m-d"),
						"version" => $this->version_ok,
						"online_version" => "",
						"mettre_jour" => "",
						"delete_old_version" => 1,
						"id_module" => $id_module
					];

					$dbc->prepare("UPDATE module SET next_check_version=:next_check, version=:version, online_version=:online_version, mettre_jour=:mettre_jour, delete_old_version=:delete_old_version WHERE ID_module=:id_module", $value);

					FlashMessage::setFlash("Votre module a bien été mis à jour", "success");
				}
			}
			else {
				FlashMessage::setFlash("Impossible de télécharger la mise à jour, veuillez réesseyer dans un instant");
			}
		}

		/**
		 * @return bool
		 * fonction qui après l'installation d'un module supprime les fichier temporaires
		 */
		private function setSupprimerArchiveTemp() {
			if (unlink(TEMPROOT.$this->nom_fichier) == true) {
				return true;
			}
			else {
				return false;
			}
		}

		/**
		 * @param $id_module
		 * fonction qui permet de supprimer un module (suppression des tables + appel fonction supprimer dossier)
		 */
		public function setSupprimerModule($id_module, $systeme) {
			$dbc = App::getDb();

			if ($systeme == 1) {
				$value = array(
					"id_module" => $id_module,
					"activer" => 0,
					"installer" => 0,
				);

				$dbc->prepare("UPDATE module SET activer=:activer, installer=:installer WHERE ID_module=:id_module", $value);
			}
			else {
				$value = array(
					"id_module" => $id_module,
				);

				$dbc->prepare("DELETE FROM module WHERE ID_module=:id_module", $value);
			}

			$requete = "";
			require_once($this->getUrl($id_module)."uninstall.php");
			$dbc->query($requete);

			$this->supprimerDossier($this->getUrl($id_module));
		}

		/**
		 * @param $id_module
		 * fonction qui permet de supprimer le dossier d'une vielle version d'un module une semaine après son ajout
		 */
		public function setSupprimerOldModule($id_module) {
			$dbc = App::getDb();

			$this->getInfoModule($id_module);

			$this->supprimerDossier(MODULEROOT.$this->dossier_module);

			$value = [
				"id_module" => $this->id_module,
				"delete_old_version" => ""
			];

			$dbc->prepare("UPDATE module SET delete_old_version=:delete_old_version WHERE ID_module=:id_module", $value);
		}

		/**
		 * @param string $url
		 * fonction qui permet de supprmer un dossier avec toute son abrorescence en fonction d'une URL
		 */
		private function supprimerDossier($url) {
			if (is_dir($url)) {
				$objects = scandir($url);
				foreach ($objects as $object) {
					if ($object != "." && $object != "..") {
						if (filetype($url."/".$object) == "dir") $this->supprimerDossier($url."/".$object); else unlink($url."/".$object);
					}
				}
				reset($objects);
				rmdir($url);
			}
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}