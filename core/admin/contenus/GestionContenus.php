<?php
	namespace core\admin\contenus;

	use core\App;
	use core\contenus\Contenus;
	use core\functions\ChaineCaractere;
	use core\HTML\flashmessage\FlashMessage;

	class GestionContenus extends Contenus {
		use ParentTexte;

		private $erreur;


		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getErreur() {
			return $this->erreur;
		}
		
		/**
		 * @param integer $parent
		 * @return int
		 */
		private function getOrdrePage($parent) {
			if ($parent != "") {
				$dbc = \core\App::getDb();
				$ordre = 1;

				$query = $dbc->select("ordre")->from("page")->orderBy("ordre", "DESC")->limit(0, 1)->get();
				if (count($query) > 0) {
					foreach ($query as $obj) {
						$ordre = $obj->ordre;
					}
				}

				return $ordre;
			}
		}

		private function getParentId($parent) {
			$dbc = \core\App::getDb();

			if ($parent == "") {
				return 0;
			}

			$query = $dbc->select("ID_page")->from("page")->where("titre", " LIKE ", '"%'.$parent.'%"', "", true)->get();

			if (count($query) == 1) {
				foreach ($query as $obj) {
					return $obj->ID_page;
				}
			}

			return 0;
		}

		/**
		 * @param string $nom_table
		 * @param string $nom_id_table
		 * @param string $champ
		 * @param $value
		 * @param integer $limit_char
		 * @param string $err_char
		 * @param string $err_egalite
		 * @param null $value_id_table
		 * @return string
		 * fonction qui permet de vérifier qu'il n'y ait pas d'erreur dans le champ spécifié ni de doublons
		 */
		private function getVerifChamp($nom_table, $nom_id_table, $champ, $value, $limit_char, $err_char, $err_egalite, $value_id_table = null) {
			$dbc = App::getDb();

			if (strlen(utf8_decode($value)) > $limit_char) {
				$this->erreur = true;
				return "<li>$err_char</li>";
			}
			else if ($dbc->rechercherEgalite($nom_table, $champ, $value, $nom_id_table, $value_id_table) == true) {
				$this->erreur = true;
				return "<li>$err_egalite</li>";
			}
		}
		
		private function getTestBaliseTitle($balise_title, $id_page = null) {
			$err_balise_title_char = "Le titre pour le navigateur ne doit pas dépasser 70 caractères";
			$err_balise_title_egalite = "Ce titre est déjà présent en base de données, merci d'en choisir un autre pour optimiser le référencement de votre site";
			return $this->getVerifChamp("page", "ID_page", "balise_title", $balise_title, 70, $err_balise_title_char, $err_balise_title_egalite, $id_page);
		}
		
		private function getTestUrl($url, $id_page = null) {
			$err_url_char = "L'url ne doit pas dépasser 92 caractères";
			$err_url_egalite = "Cette url est déjà présent en base de données, merci d'en choisir une autre pour ne pas avoir de conflit entre vos pages";
			return $this->getVerifChamp("page", "ID_page", "url", $url, 92, $err_url_char, $err_url_egalite, $id_page);
		}
		
		private function getTestMetaDescription($meta_description, $id_page = null) {
			$err_meta_description_char = "La description de cette page ne doit pas dépasser 158 caractères";
			$err_meta_description_egalite = "Cette description est déjà présent en base de données, merci d'en choisir une autre pour optimiser le référencement de votre site";
			return $this->getVerifChamp("page", "ID_page", "meta_description", $meta_description, 158, $err_meta_description_char, $err_meta_description_egalite, $id_page);
		}
		
		private function getTestTitrePage($titre_page, $id_page = null) {
			$err_titre_page_char = "Le titre de cette page ne doit pas dépasser 50 caractères";
			$err_titre_page_egalite = "Cette titre de page est déjà présent en base de données, merci d'en choisir un autre pour ne pas avoir de conflit dans votre navigation";
			return $this->getVerifChamp("page", "ID_page", "titre", $titre_page, 50, $err_titre_page_char, $err_titre_page_egalite, $id_page);
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//



		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @param string $url
		 * @param string $err_balise_title
		 * @param string $err_url
		 * @param string $err_meta_description
		 * @param string $err_titre_page
		 */
		private function setErreurContenus($balise_title, $url, $meta_description, $titre_page, $parent, $err_balise_title, $err_url, $err_meta_description, $err_titre_page) {
			$_SESSION['balise_title'] = $balise_title;
			$_SESSION['url'] = $url;
			$_SESSION['meta_description'] = $meta_description;
			$_SESSION['titre_page'] = $titre_page;
			$_SESSION['parent'] = $parent;
			$_SESSION['err_modification_contenu'] = true;

			$message = "<ul>".$err_balise_title.$err_url.$err_meta_description.$err_titre_page."</ul>";
			FlashMessage::setFlash($message);
		}
		
		private function setCreerFichier($new_page) {
			$page_type = ROOT."config/page_type/page_type.html";
			
			if ((!file_exists($new_page)) && (copy($page_type, $new_page))) {
				return true;
			}
			
			FlashMessage::setFlash("Impossible de créer cette page, veuillez réeseyer dans un moment. Si le problème persiste contactez votre administrateur.");
			$this->erreur = true;
			return false;
		}

		/**
		 * fonction qui permet de créer un page
		 * @param $balise_title
		 * @param $url
		 * @param $meta_description
		 * @param $titre_page
		 * @param $parent
		 */
		public function setCreerPage($balise_title, $url, $meta_description, $titre_page, $parent, $affiche = 1) {
			$dbc = \core\App::getDb();
			$url = ChaineCaractere::setUrl($url);
			$nom_page = explode("/", $url);
			$nom_page = end($nom_page);
			$new_page = ROOT."app/views/".$nom_page.".html";
			$err_balise_title = $this->getTestBaliseTitle($balise_title);
			$err_url = $this->getTestUrl($url);
			$err_meta_description = $this->getTestMetaDescription($meta_description);
			$err_titre_page = $this->getTestTitrePage($titre_page);
			
			if ($this->erreur === true) {
				$this->setErreurContenus($balise_title, $url, $meta_description, $titre_page, $parent, $err_balise_title, $err_url, $err_meta_description, $err_titre_page);
				return false;
			}
			
			if ($this->setCreerFichier($new_page) === false) {
				return false;
			}
			
			$parent = intval($this->getParentId($parent));
			$ordre = intval($this->getOrdrePage($parent));
			$dbc->insert("titre", $titre_page)->insert("url", $url)->insert("meta_description", $meta_description)
				->insert("balise_title", $balise_title)->insert("ordre", $ordre)->insert("parent", $parent)
				->insert("affiche", $affiche)->into("page")->set();
			
			$this->id_page = $dbc->lastInsertId();
			$this->url = $url;
			if ($parent == "") {
				$this->setAjoutLienNavigation("ID_page", $this->id_page, 1);
			}
		}

		/**
		 * function that will create a redirection on an other site
		 * @param $balise_title
		 * @param $url
		 * @param $titre_page
		 * @param $parent
		 */
		public function setCreerPageRedirect($balise_title, $url, $titre_page, $parent, $affiche = 1) {
			$dbc = \core\App::getDb();
			$err_balise_title = $this->getTestBaliseTitle($balise_title);
			$err_url = $this->getTestUrl($url);
			$err_titre_page = $this->getTestTitrePage($titre_page);
			
			if ($this->erreur !== true) {
				$parent = intval($this->getParentId($parent));
				$ordre = intval($this->getOrdrePage($parent));
				$dbc->insert("titre", $titre_page)->insert("url", $url)->insert("balise_title", $balise_title)->insert("ordre", $ordre)->insert("parent", $parent)->insert("affiche", $affiche)->insert("target", "_blanck")->into("page")->set();
				$this->id_page = $dbc->lastInsertId();
				if ($parent == "") {
					$this->setAjoutLienNavigation("ID_page", $this->id_page, 1);
				}
			}
			else {
				$this->setErreurContenus($balise_title, $url, "", $titre_page, $parent, $err_balise_title, $err_url, "", $err_titre_page);
				$this->erreur = true;
			}
		}

		/**
		 * fonction qui permet de modifier une page en fonction de son id
		 * @param $id_page
		 * @param $balise_title
		 * @param $url
		 * @param $meta_description
		 * @param $titre_page
		 * @param $parent
		 * @param $contenu
		 */
		public function setModifierPage($id_page, $balise_title, $url, $meta_description, $titre_page, $parent, $affiche = 1) {
			$dbc = \core\App::getDb();
			$old_url = explode("/", $this->url);
			$filename = ROOT."app/views/".end($old_url).".html";
			
			if (file_exists($filename) || ($id_page == 1)) {
				FlashMessage::setFlash("Impossible de modifier cette page, veuillez contacter votre administrateur pour corriger ce problème");
				$this->erreur = true;
				return false;
			}
			
			$this->id_page = $id_page;
			$url = ChaineCaractere::setUrl($url);
			$err_balise_title = $this->getTestBaliseTitle($balise_title, $id_page);
			$err_url = $this->getTestUrl($url, $id_page);
			$err_meta_description = $this->getTestMetaDescription($meta_description, $id_page);
			$err_titre_page = $this->getTestTitrePage($titre_page, $id_page);
			
			if ($this->erreur !== true) {
				$new_url = explode("/", $url);
				$new_filename = ROOT."app/views/".end($new_url).".html";
				
				rename($filename, $new_filename);
				
				$parent = intval($this->getParentId($parent));
				$dbc->update("titre", $titre_page)->update("url", $url)->update("meta_description", $meta_description)
					->update("balise_title", $balise_title)->update("parent", $parent)->update("affiche", $affiche)
					->from("page")->where("ID_page", "=", $id_page, "", true)->set();
				
				$this->setModifierLienNavigation("ID_page", $id_page, $this->getParentId($parent), $affiche);
				$this->url = $url;
			}
			else {
				$this->setErreurContenus($balise_title, $url, $meta_description, $titre_page, $parent, $err_balise_title, $err_url, $err_meta_description, $err_titre_page);
			}
		}

		/**
		 * @param $id_page
		 * @param $contenu
		 */
		public function setModifierContenu($id_page, $contenu) {
			$dbc = \core\App::getDb();

			$dbc->update("contenu", $contenu)->from("page")->where("ID_page", "=", $id_page)->set();
		}

		/**
		 * fonction qui permet de supprimer une page, test si fichier exist, si oui on delete
		 * @param $id_page
		 */
		public function setSupprimerPage() {
			$url = explode("/", $this->url);
			$filename = ROOT."app/views/".end($url).".html";
			
			if (file_exists($filename) && $this->id_page != 1) {
				unlink($filename);
				$this->setSupprimerLienNavigation();
				
				return true;
			}
			else if (ChaineCaractere::FindInString($this->url, "http://") === true) {
				$this->setSupprimerLienNavigation();
			}
			else {
				FlashMessage::setFlash("Impossible de supprimer cette page, veuillez contacter votre administrateur pour corriger ce problème");
				$this->erreur = true;
				return false;
			}
		}

		/**
		 * @param string $id
		 * @param string $value_id
		 * @param integer $affiche
		 */
		private function setAjoutLienNavigation($id, $value_id, $affiche) {
			if ($affiche !== null) {
				App::getNav()->setAjoutLien($id, $value_id);
			}
		}

		/**
		 * @param string $id
		 * @param integer $affiche
		 */
		private function setModifierLienNavigation($id, $id_page, $parent, $affiche) {
			if ($parent != "") {
				App::getNav()->setSupprimerLien($id, $id_page);
			}
			else if (($affiche == 0) && ($parent == "")) {
				App::getNav()->setSupprimerLien($id, $id_page);
			}
		}
		
		/**
		 * delete link in nav and delete page in table
		 */
		private function setSupprimerLienNavigation() {
			$dbc = App::getDb();
			
			$dbc->delete()->from("page")->where("ID_page", "=", $this->id_page)->del();
			
			App::getNav()->setSupprimerLien("ID_page", $this->id_page);
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}