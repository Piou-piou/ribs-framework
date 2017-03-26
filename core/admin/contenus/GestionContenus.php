<?php
	namespace core\admin\contenus;

	use core\App;
	use core\contenus\Contenus;
	use core\functions\ChaineCaractere;
	use core\HTML\flashmessage\FlashMessage;
	use core\Navigation;

	class GestionContenus extends Contenus {
		use ParentTexte;

		private $erreur;


		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getErreur() {
			return $this->erreur;
		}

		public function getBlocEditable($id_page_courante) {
			$dbc = App::getDb();
			$bloc_editable = 0;

			$query = $dbc->select("bloc_editable")->from("page")->where("ID_page", "=", $id_page_courante)->get();

			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$bloc_editable = $obj->bloc_editable;
				}
			}

			return $bloc_editable;
		}

		private function getOrdrePage($parent) {
			if (($parent != "") || ($parent != 0)) {
				$dbc = \core\App::getDb();
				$ordre = 1;

				$query = $dbc->select("ordre")->from("page")->orderBy("ordre", "DESC")->limit(0, 1)->get();
				if ((is_array($query)) && (count($query) > 0)) {
					foreach ($query as $obj) {
						$ordre = $obj->ordre;
					}
				}

				return $ordre;
			}
		}

		private function getParentId($parent) {
			$dbc = \core\App::getDb();

			if ($parent == "") return 0;

			$query = $dbc->select("ID_page")->from("page")->where("titre", " LIKE ", '"%'.$parent.'%"', "", true)->get();

			if ((is_array($query)) && (count($query) == 1)) {
				foreach ($query as $obj) {
					return $obj->ID_page;
				}
			}

			return 0;
		}

		/**
		 * @param $nom_table
		 * @param $nom_id_table
		 * @param $champ
		 * @param $value
		 * @param $limit_char
		 * @param $err_char
		 * @param $err_egalite
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

			$page_type = ROOT."config/page_type/page_type.html";
			$new_page = ROOT."app/views/".$nom_page.".html";

			$err_balise_title_char = "Le titre pour le navigateur ne doit pas dépasser 70 caractères";
			$err_balise_title_egalite = "Ce titre est déjà présent en base de données, merci d'en choisir un autre pour optimiser le référencement de votre site";
			$err_balise_title = $this->getVerifChamp("page", "ID_page", "balise_title", $balise_title, 70, $err_balise_title_char, $err_balise_title_egalite);

			$err_url_char = "L'url ne doit pas dépasser 92 caractères";
			$err_url_egalite = "Cette url est déjà présent en base de données, merci d'en choisir une autre pour ne pas avoir de conflit entre vos pages";
			$err_url = $this->getVerifChamp("page", "ID_page", "url", $url, 92, $err_url_char, $err_url_egalite);

			$err_meta_description_char = "La description de cette page ne doit pas dépasser 158 caractères";
			$err_meta_description_egalite = "Cette description est déjà présent en base de données, merci d'en choisir une autre pour optimiser le référencement de votre site";
			$err_meta_description = $this->getVerifChamp("page", "ID_page", "meta_description", $meta_description, 158, $err_meta_description_char, $err_meta_description_egalite);

			$err_titre_page_char = "Le titre de cette page ne doit pas dépasser 50 caractères";
			$err_titre_page_egalite = "Cette titre de page est déjà présent en base de données, merci d'en choisir un autre pour ne pas avoir de conflit dans votre navigation";
			$err_titre_page = $this->getVerifChamp("page", "ID_page", "titre", $titre_page, 50, $err_titre_page_char, $err_titre_page_egalite);

			if ($this->erreur !== true) {
				//si le fichier n'existe pas et que la copy est ok on insert en bdd
				if ((!file_exists($new_page)) && (copy($page_type, $new_page))) {
					$parent = intval($this->getParentId($parent));
					$ordre = intval($this->getOrdrePage($parent));
					$dbc->insert("titre", $titre_page)
						->insert("url", $url)
						->insert("meta_description", $meta_description)
						->insert("balise_title", $balise_title)
						->insert("ordre", $ordre)
						->insert("parent", $parent)
						->insert("affiche", $affiche)
						->into("page")
						->set();

					$this->id_page = $dbc->lastInsertId();
					if ($parent == "") {
						$this->setAjoutLienNavigation("ID_page", $this->id_page, 1);
					}
				}
				else {
					FlashMessage::setFlash("Impossible de créer cette page, veuillez réeseyer dans un moment. Si le problème persiste contactez votre administrateur.");
					$this->erreur = true;
				}
			}
			else {
				$this->setErreurContenus($balise_title, $url, $meta_description, $titre_page, $parent, $err_balise_title, $err_url, $err_meta_description, $err_titre_page);
				$this->erreur = true;
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

			$err_balise_title_char = "Le titre pour le navigateur ne doit pas dépasser 70 caractères";
			$err_balise_title_egalite = "Ce titre est déjà présent en base de données, merci d'en choisir un autre pour optimiser le référencement de votre site";
			$err_balise_title = $this->getVerifChamp("page", "ID_page", "balise_title", $balise_title, 70, $err_balise_title_char, $err_balise_title_egalite);

			$err_url_char = "L'url ne doit pas dépasser 92 caractères";
			$err_url_egalite = "Cette url est déjà présent en base de données, merci d'en choisir une autre pour ne pas avoir de conflit entre vos pages";
			$err_url = $this->getVerifChamp("page", "ID_page", "url", $url, 92, $err_url_char, $err_url_egalite);

			$err_titre_page_char = "Le titre de cette page ne doit pas dépasser 50 caractères";
			$err_titre_page_egalite = "Cette titre de page est déjà présent en base de données, merci d'en choisir un autre pour ne pas avoir de conflit dans votre navigation";
			$err_titre_page = $this->getVerifChamp("page", "ID_page", "titre", $titre_page, 50, $err_titre_page_char, $err_titre_page_egalite);

			if ($this->erreur !== true) {
				//si le fichier n'existe pas et que la copy est ok on insert en bdd
				$parent = intval($this->getParentId($parent));
				$ordre = intval($this->getOrdrePage($parent));
				$dbc->insert("titre", $titre_page)
					->insert("url", $url)
					->insert("balise_title", $balise_title)
					->insert("ordre", $ordre)
					->insert("parent", $parent)
					->insert("affiche", $affiche)
					->insert("target", "_blanck")
					->into("page")
					->set();

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

			//on trouve l'ancien fichier à parir de la fin de l'url
			$old_url = explode("/", $this->url);
			$filename = ROOT."app/views/".end($old_url).".html";

			//si le fichier existe on modifie le tout
			if (file_exists($filename) || ($id_page == 1)) {
				$this->id_page = $id_page;
				$url = ChaineCaractere::setUrl($url);

				$err_balise_title_char = "Le titre pour le navigateur ne doit pas dépasser 70 caractères";
				$err_balise_title_egalite = "Ce titre est déjà présent en base de données, merci d'en choisir un autre pour optimiser le référencement de votre site";
				$err_balise_title = $this->getVerifChamp("page", "ID_page", "balise_title", $balise_title, 70, $err_balise_title_char, $err_balise_title_egalite, $this->id_page);

				$err_url_char = "L'url ne doit pas dépasser 92 caractères";
				$err_url_egalite = "Cette url est déjà présent en base de données, merci d'en choisir une autre pour ne pas avoir de conflit entre vos pages";
				$err_url = $this->getVerifChamp("page", "ID_page", "url", $url, 92, $err_url_char, $err_url_egalite, $this->id_page);

				$err_meta_description_char = "La description de cette page ne doit pas dépasser 158 caractères";
				$err_meta_description_egalite = "Cette description est déjà présent en base de données, merci d'en choisir une autre pour optimiser le référencement de votre site";
				$err_meta_description = $this->getVerifChamp("page", "ID_page", "meta_description", $meta_description, 158, $err_meta_description_char, $err_meta_description_egalite, $this->id_page);

				$err_titre_page_char = "Le titre de cette page ne doit pas dépasser 50 caractères";
				$err_titre_page_egalite = "Cette titre de page est déjà présent en base de données, merci d'en choisir un autre pour ne pas avoir de conflit dans votre navigation";
				$err_titre_page = $this->getVerifChamp("page", "ID_page", "titre", $titre_page, 50, $err_titre_page_char, $err_titre_page_egalite, $this->id_page);

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
						->from("page")
						->where("ID_page", "=", $id_page, "", true)
						->set();

					$this->setModifierLienNavigation("ID_page", $id_page, $this->getParentId($parent), $affiche);
					$this->url = $url;
				}
				else {
					$this->setErreurContenus($balise_title, $url, $meta_description, $titre_page, $parent, $err_balise_title, $err_url, $err_meta_description, $err_titre_page);
				}
			}
			//sinon on renvoi une erreur en disant que le fichier n'existe pas et qu'il faut contacter un administrateur
			else {
				FlashMessage::setFlash("Impossible de modifier cette page, veuillez contacter votre administrateur pour corriger ce problème");
				$this->erreur = true;
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
		public function setSupprimerPage($id_page) {
			$dbc = \core\App::getDb();

			//le premier id_page sera tojours l'accueil donc on ne peut pas le delete
			if ($id_page != 1) {
				$url = explode("/", $this->url);
				$filename = ROOT."app/views/".end($url).".html";

				//si le fichier existe supprimer en bdd plus l fichier
				if (file_exists($filename)) {
					unlink($filename);

					$dbc->delete()->from("page")->where("ID_page", "=", $id_page)->del();

					$nav = new Navigation();
					$nav->setSupprimerLien("ID_page", $id_page);
				}
				//sinon on renvoi une erreur en disant que le fichier n'existe pas et qu'il faut contacter un administrateur
				else {
					FlashMessage::setFlash("Impossible de supprimer cette page, veuillez contacter votre administrateur pour corriger ce problème");
					$this->erreur = true;
				}
			}
			else {
				FlashMessage::setFlash("Impossible de supprimer cette page, veuillez contacter votre administrateur pour corriger ce problème");
				$this->erreur = true;
			}
		}

		/**
		 * @param string $id
		 * @param $value_id
		 * @param integer $affiche
		 */
		private function setAjoutLienNavigation($id, $value_id, $affiche) {
			if ($affiche !== null) {
				$nav = new Navigation();
				$nav->setAjoutLien($id, $value_id);
			}
		}

		/**
		 * @param string $id
		 * @param integer $affiche
		 */
		private function setModifierLienNavigation($id, $id_page, $parent, $affiche) {
			$nav = new Navigation();
			if ($parent != "") {
				$nav->setSupprimerLien($id, $id_page);
			}
			else if (($affiche == 0) && ($parent == "")) {
				$nav->setSupprimerLien($id, $id_page);
			}
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}