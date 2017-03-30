<?php
	namespace core\admin\contenus;

	use core\App;
	use core\contenus\Contenus;
	use core\functions\ChaineCaractere;
	use core\HTML\flashmessage\FlashMessage;

	class GestionContenus extends Contenus {
		use GestionErreurContenus;
		private $erreur;


		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getErreur() {
			return $this->erreur;
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
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//



		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @param string $new_page
		 * @return bool
		 */
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
			$dbc->insert("titre", $titre_page)->insert("url", $url)->insert("meta_description", $meta_description)
				->insert("balise_title", $balise_title)->insert("parent", $parent)
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
				$dbc->insert("titre", $titre_page)->insert("url", $url)->insert("balise_title", $balise_title)->insert("parent", $parent)->insert("affiche", $affiche)->insert("target", "_blanck")->into("page")->set();
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
				$dbc->update("titre", $titre_page)
					->update("url", $url)
					->update("meta_description", $meta_description)
					->update("balise_title", $balise_title)
					->update("parent", $parent)
					->update("affiche", $affiche)
					->from("page")->where("ID_page", "=", $id_page, "", true)
					->set();
				
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