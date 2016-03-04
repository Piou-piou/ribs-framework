<?php

	namespace core\images;

	use core\App;

	class Images {
		//initialisée pour le bon fonctionnement de la class
		private $autorized_extention = array("jpg", "png", "jpeg", "gif", "JPG", "PNG", "JPEG", "GIF");
		private $erreur;

		//var init dans constructeur
		private $poid_max;
		private $width_max;
		private $height_max;
		private $dossier_image;

		private $old_image;
		private $chemin_image;
		private $image;
		private $nom_image;

		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		/**
		 * Recoit un tableau contenant les parametres pour la/les images qui vont être upload
		 * index du tableau
		 * - poid_max de l'img
		 * - width_max de l'img
		 * - height_max de l'img
		 * - dossier_image dans lequel se trouve l'ancienne et ou se trovera la nouvelle
		 * @param $parameter = array()
		 */
		public function __construct($parameter) {
			$this->poid_max = $parameter[0];
			$this->width_max = $parameter[1];
			$this->height_max = $parameter[2];
			$this->dossier_image = $parameter[3];
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//

		public function getOldImage() {
			return $this->old_image;
		}
		public function getCheminImage() {
			return $this->chemin_image;
		}
		public function getErreur() {
			return $this->erreur;
		}
		public function getNomImage() {
			return $this->nom_image;
		}
		private function getImage() {
			if ($this->chemin_image != "") {
				$explode = explode("/", $this->chemin_image);
				$this->image = end($explode);
				return $this->image;
			}
			else {
				$this->erreur = "Impossible de trouver votre image, vuellez réessayer dans un instant";
				return false;
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * fonction qui permet d'upload une image sur le serveur
		 * @param $old_image_req
		 * @param int $autorize_empty
		 * @param int $delete_old_img
		 * @return null|boolean -> renvoi false si err sinon renvoi le chemin vers l'img
		 */
		public function setEnvoyerImage($name, $old_image_req = null, $autorize_empty = 1, $delete_old_img = 1) {
			$dbc = App::getDb();

			$this->old_image = null;
			$this->chemin_image = null;
			$this->nom_image = null;

			$image = $_FILES[$name]['name'];

			if (empty($_FILES[$name]['name'])) {
				if ($autorize_empty == 0) {
					$this->erreur = "Vous devez obligatoirement ajouter une image";
					return false;
				}
			}
			else {
				//test si il y a deja une img
				if ($old_image_req != null) {
					$query = $dbc->query($old_image_req);
					if (count($query > 0)) {
						foreach ($query as $obj) {
							$this->old_image = $obj->$name;
						}
					}
				}


				//recuperation info sur img
				$infos_img = getimagesize($_FILES[$name]['tmp_name']);

				if (!in_array(substr($image, -3), $this->autorized_extention)) {
					$this->erreur = "Votre image ne comporte pas l'extension jpg, png, jpeg, gif, JPG, PNG, JPEG, GIF";
					return false;
				}
				else if (($infos_img[0] >= $this->width_max) && ($infos_img[1] >= $this->height_max) && ($_FILES[$name]['size'] >= $this->poid_max)) {
					$this->erreur = "Problème dans les dimensions ou taille de l'image.";
					return false;
				}
				else {
					$uniqid = uniqid();

					if (move_uploaded_file($_FILES[$name]['tmp_name'], $this->dossier_image."/".$uniqid.substr($image, -4))) {
						$imageok = $uniqid.substr($image, -4);

						$urlimg = $this->dossier_image."/$imageok";
						$this->chemin_image = $urlimg;
						$this->nom_image = $imageok;

						if (($delete_old_img == 1) && ($this->old_image != "") && (!empty($_FILES[$name]['name']))) {
							$this->setDeleteImage();
						}

						return true;
					}
					else {
						$this->erreur = "Impossible d'envoyer votre image sur le serveur, veuillez réessayer dans une instant, si l'erreur se reproduit, contactez votre administrateur";
					}
				}
			}
		}

		/**
		 * fonction qui permet de resize des images en fonction d'une taille et d'une hauteur donnée
		 * si $req_img == null, on prend l'image active dans la class via chemin_image
		 * @param $width
		 * @param $height
		 * @param $prefixe
		 * @param null $req_img
		 * @return string
		 */
		public function setResizeImage($width, $height, $prefixe, $delete_old = 1, $req_img = null) {
			if (($req_img == null) && ($this->chemin_image != "")) {
				$this->getImage();

				$resize = new Resize($this->chemin_image);
				$resize->resizeImage($width, $height, 'crop');
				$img_resize = $prefixe."_".$this->image;
				$resize->saveImage($this->dossier_image."/".$img_resize, 100);

				$this->nom_image = $img_resize;
			}
			else {
				$this->nom_image = null;
			}

			if (($delete_old == 1) && ($req_img == null) && ($this->chemin_image != "")) {
				unlink($this->chemin_image);
			}
		}


		/**
		 * fonction qui permet de supprimer une image en fonction d'une requete ou de la variable old_image
		 * @param null|string $nom_image
		 * @return boolean|null
		 */
		public function setDeleteImage($nom_image = null) {
			//si pas de requete et qu'on a une old_img on la supprime
			if (($this->old_image != "") && ($nom_image === null)) {
				$old_image = explode("/", $this->old_image);

				if (end($old_image) === "defaut.png") {
					echo($this->dossier_image."/".end($old_image));
					unlink($this->dossier_image."/".end($old_image));
					return true;
				}
			}
			else if ($nom_image !== null) {
				$success = false;


				if (is_array($nom_image)) {
					$count = count($nom_image);
					for ($i = 0; $i < $count; $i++) {
						$chemin_img = $this->dossier_image."/".$nom_image[$i];

						if (unlink($chemin_img)) {
							$success = true;
						}
						else {
							if (unlink($this->chemin_image)) {
								$success = true;
							}
							else {
								$this->erreur = "Impossible de supprimer cette image, veuillez réesayer dans un instant, sinon contacter l'administrateur de votre site";
								$success = false;
							}
						}
					}
				}
				else {
					if (unlink($this->dossier_image."/".$nom_image)) {
						$success = true;
					}
					else {
						if (unlink($this->chemin_image)) {
							$success = true;
						}
						else {
							$this->erreur = "Impossible de supprimer cette image, veuillez réesayer dans un instant, sinon contacter l'administrateur de votre site";
							$success = false;
						}
					}
				}

				return $success;
			}
			else {
				$this->erreur = "Impossible de supprimer cette image";
				return false;
			}
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}