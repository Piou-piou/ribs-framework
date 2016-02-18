<?php
	namespace core\modules;

	use core\App;
	use core\HTML\flashmessage\FlashMessage;

	class ImportModule {
		private $nom_dossier;
		private $nom_fichier;
		private $extension;
		private $erreur;
		
		
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct() {
			//On test si dossier temporaire + modules a la racines existes bien sinon on les crées
			if (!file_exists(ROOT."temp")) mkdir(ROOT."temp");
			if (!file_exists(ROOT."modules")) mkdir(ROOT."modules");
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @param $url_module
		 * fonction qui permets d'importer un module dans notre site internet
		 */
		public function setImportModule($url_module, $update=null) {
			$dbc= App::getDb();

			//avant tout on récupère le nom du fichier pour le mettre dans le dossier temporaire
			$explode = explode("/", $url_module);
			$this->nom_fichier = end($explode);

			//on recupere le nom du dossier + extention
			$explode  = explode(".", $this->nom_fichier);
			$this->nom_dossier = $explode[0];
			$this->extension = $explode[1];

			//si l'extension != zip on renvoit err
			if ($this->extension == "zip") {
				//on test dans le dossier module si il n'existe pas déjà
				if (file_exists(MODULEROOT.$this->nom_dossier) == false) {
					if (file_put_contents(TEMPROOT.$this->nom_fichier, fopen($url_module, 'r')) != false) {
						$zip = new \ZipArchive();

						if ($zip->open(TEMPROOT.$this->nom_fichier) == true) {
							if ($zip->extractTo(TEMPROOT) == true) {
								if (rename(TEMPROOT.$this->nom_dossier, MODULEROOT.$this->nom_dossier) == true) {
									//si c'est une install et non une mise à jour
									if ($update == null) {
										require_once(MODULEROOT.$this->nom_dossier."/install.php");
										$dbc->prepare($requete);
									}


									FlashMessage::setFlash("Votre module a bien été ajouté au site.", "success");
								}
								else {
									\core\HTML\flashmessage\FlashMessage::setFlash("Erreur lors du téléchargement du module, veuillez réessayer dans un instant.");
									$this->erreur = true;
								}
							}
							else {
								\core\HTML\flashmessage\FlashMessage::setFlash("Erreur lors du téléchargement du module, veuillez réessayer dans un instant.");
								$this->setSupprimerArchiveTemp();
								$this->erreur = true;
							}
						}
						else {
							\core\HTML\flashmessage\FlashMessage::setFlash("Erreur lors du téléchargement du module, veuillez réessayer dans un instant.");
							$this->setSupprimerArchiveTemp();
							$this->erreur = true;
						}

						$zip->close();
						$this->setSupprimerArchiveTemp();
					}
					else {
						FlashMessage::setFlash("Le module n'a pas pu être correctement téléchargé, veuillez réesseyer dans un instant");
						$this->erreur = true;
					}
				}
				else {
					FlashMessage::setFlash("Ce module est déjà présent sur ce site, merci de renommer votre module");
					$this->erreur = true;
				}
			}
			else {
				FlashMessage::setFlash("Le format de votre archive doit obligatoirement être un .zip");
				$this->erreur = true;
			}
		}

		Public function setUpdateModule($id_module) {
			$dbc = App::getDb();

			$query = $dbc->query("select * from module WHERE ID_module=".$dbc->quote($id_module));

			foreach ($query as $obj) {
				$url_telechargement = $obj->url_telechargement;
				$version_ok = $obj->online_version;
				$dossier_module = str_replace("/", "", $obj->url);
			}

			//on rename le dossier actuel du module
			if (rename(MODULEROOT.$dossier_module, MODULEROOT.$dossier_module."_OLDVERSION")) {
				$this->setImportModule($url_telechargement, true);

				//si pas d'erreur on met la date de next check a la semaine pro ++ on dit
				//de delete l'ancienne version au next check
				if (($this->erreur != true) || (!isset($this->erreur))) {
					$today = date("Y-m-d");
					$today = new \DateTime($today);

					$value = [
						"next_check" => $today->add(new \DateInterval("P1W"))->format("Y-m-d"),
						"version" => $version_ok,
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
		public function setSupprimerModule($id_module) {
			$dbc = App::getDb();

			$query = $dbc->query("SELECT * FROM module WHERE ID_module=".$id_module);

			foreach ($query as $obj) {
				$url = MODULEROOT.str_replace("/", "", $obj->url);
				$systeme = $obj->systeme;
			}

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

			require_once($url."/uninstall.php");
			$dbc->prepare($requete);

			$this->supprimerDossier($url);
		}

		/**
		 * @param $url
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