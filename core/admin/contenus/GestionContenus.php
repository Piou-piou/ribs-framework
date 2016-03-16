<?php
	namespace core\admin\contenus;

	use core\App;
	use core\contenus\Contenus;
	use core\admin\droitsacces\DroitAcces;
	use core\functions\ChaineCaractere;
	use core\HTML\flashmessage\FlashMessage;

	class GestionContenus extends Contenus {
		private $parent_texte;
		private $erreur;


		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct($init_all = 0) {
			$dbc = \core\App::getDb();

			if ($init_all == 1) {
				$droit_acces = new DroitAcces();
				$id_identite = $_SESSION["idlogin".CLEF_SITE];

				//on construit le menu
				if ($droit_acces->getSuperAdmin() != 1) {
					$query = $dbc->query("SELECT page.ID_page, page.titre, page.balise_title, page.parent, page.url, droit_acces_page.seo, droit_acces_page.contenu, droit_acces_page.navigation, droit_acces_page.supprimer FROM page, droit_acces_page, liste_droit_acces, identite WHERE
                                    identite.liste_droit = liste_droit_acces.ID_liste_droit_acces AND
									liste_droit_acces.ID_liste_droit_acces = droit_acces_page.ID_liste_droit_acces AND
									page.ID_page = droit_acces_page.ID_page AND
									(droit_acces_page.seo != 0 OR droit_acces_page.contenu != 0 OR droit_acces_page.navigation != 0 OR droit_acces_page.supprimer != 0 OR identite.super_admin = 1) AND
									identite.ID_identite = $id_identite
                                    ORDER BY page.ordre
                    ");
				}
				else {
					$query = $dbc->query("SELECT ID_page, titre, balise_title, parent, url FROM page ORDER BY ordre");
				}

				$this->getMenu($query);
			}
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//



		//-------------------------- GETTER ----------------------------------------------------------------------------//
		public function getParentTexte($parent) {
			$dbc = \core\App::getDb();

			$query = $dbc->query("SELECT titre FROM page WHERE ID_page=".$parent);
			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) $this->parent_texte = $obj->titre;
			}

			return $this->parent_texte;
		}
		public function getErreur() {
			return $this->erreur;
		}

		private function getLastOrdre() {
			$dbc = \core\App::getDb();
			$ordre = "";

			$query = $dbc->query("SELECT ordre FROM page ORDER BY ordre ASC LIMIT 1");
			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$ordre = $obj->ordre;
				}
			}

			return $ordre;
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//



		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * fonction qui permet de créer un page
		 * @param $balise_title
		 * @param $url
		 * @param $meta_description
		 * @param $titre_page
		 * @param $parent
		 * @param $contenu
		 */
		public function setCreerPage($balise_title, $url, $meta_description, $titre_page, $parent, $contenu) {
			$dbc = \core\App::getDb();

			$url = ChaineCaractere::setUrl($url);

			$nom_page = explode("/", $url);
			$nom_page = end($nom_page);

			$page_type = ROOT."config/page_type/page_type.php";
			$new_page = ROOT."app/views/".$nom_page.".php";

			$err_balise_title_char = "Le titre pour le navigateur ne doit pas dépasser 70 caractères";
			$err_balise_title_egalite = "Ce titre est déjà présent en base de données, merci d'en choisir un autre pour optimiser le référencement de votre site";
			$err_balise_title = App::getVerifChamp("page", "ID_page", "balise_title", $balise_title, 70, $err_balise_title_char, $err_balise_title_egalite);

			$err_url_char = "L'url ne doit pas dépasser 92 caractères";
			$err_url_egalite = "Cette url est déjà présent en base de données, merci d'en choisir une autre pour ne pas avoir de conflit entre vos pages";
			$err_url = App::getVerifChamp("page", "ID_page", "url", $url, 92, $err_url_char, $err_url_egalite);

			$err_meta_description_char = "La description de cette page ne doit pas dépasser 158 caractères";
			$err_meta_description_egalite = "Cette description est déjà présent en base de données, merci d'en choisir une autre pour optimiser le référencement de votre site";
			$err_meta_description = App::getVerifChamp("page", "ID_page", "meta_description", $meta_description, 158, $err_meta_description_char, $err_meta_description_egalite);

			$err_titre_page_char = "Le titre de cette page ne doit pas dépasser 50 caractères";
			$err_titre_page_egalite = "Cette titre de page est déjà présent en base de données, merci d'en choisir un autre pour ne pas avoir de conflit dans votre navigation";
			$err_titre_page = App::getVerifChamp("page", "ID_page", "titre", $titre_page, 50, $err_titre_page_char, $err_titre_page_egalite);

			if (App::getErreur() !== true) {
				//si le fichier n'existe pas et que la copy est ok on insert en bdd
				if ((!file_exists($new_page)) && (copy($page_type, $new_page))) {
					$ordre = $this->getLastOrdre() + 1;
					$value = array(
						"balise_title" => $balise_title,
						"url" => $url,
						"meta_description" => $meta_description,
						"titre" => $titre_page,
						"parent" => $parent,
						"contenu" => $contenu,
						"ordre" => $ordre,
						"affiche" => 1
					);

					$dbc->prepare("INSERT INTO page (titre, contenu, url, meta_description, balise_title, ordre, parent, affiche) VALUES (:titre, :contenu, :url, :meta_description, :balise_title, :ordre, :parent, :affiche)", $value);
					$this->id_page = $dbc->lastInsertId();
				}
				else {
					FlashMessage::setFlash("Impossible de créer cette page, veuillez réeseyer dans un moment. Si le problème persiste contactez votre administrateur.");
					$this->erreur = true;
				}
			}
			else {
				$_SESSION['balise_title'] = $balise_title;
				$_SESSION['url'] = $url;
				$_SESSION['meta_description'] = $meta_description;
				$_SESSION['titre_page'] = $titre_page;
				$_SESSION['parent'] = $parent;
				$_SESSION['contenu'] = $contenu;
				$_SESSION['err_modification_contenu'] = true;

				$message = "<ul>".$err_balise_title.$err_url.$err_meta_description.$err_titre_page."</ul>";
				FlashMessage::setFlash($message);
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
		public function setModifierPage($id_page, $balise_title, $url, $meta_description, $titre_page, $parent, $contenu) {
			$dbc = \core\App::getDb();

			//on trouve l'ancien fichier à parir de la fin de l'url
			$this->getHeadPage($id_page);
			$this->getContenuPage($id_page);
			$old_url = explode("/", $this->url);
			$filename = ROOT."app/views/".end($old_url).".php";

			//si le fichier existe on modifie le tout
			if (file_exists($filename) || ($id_page == 1)) {
				$this->id_page = $id_page;
				$url = ChaineCaractere::setUrl($url);

				$err_balise_title_char = "Le titre pour le navigateur ne doit pas dépasser 70 caractères";
				$err_balise_title_egalite = "Ce titre est déjà présent en base de données, merci d'en choisir un autre pour optimiser le référencement de votre site";
				$err_balise_title = App::getVerifChamp("page", "ID_page", "balise_title", $balise_title, 70, $err_balise_title_char, $err_balise_title_egalite, $this->id_page);

				$err_url_char = "L'url ne doit pas dépasser 92 caractères";
				$err_url_egalite = "Cette url est déjà présent en base de données, merci d'en choisir une autre pour ne pas avoir de conflit entre vos pages";
				$err_url = App::getVerifChamp("page", "ID_page", "url", $url, 92, $err_url_char, $err_url_egalite, $this->id_page);

				$err_meta_description_char = "La description de cette page ne doit pas dépasser 158 caractères";
				$err_meta_description_egalite = "Cette description est déjà présent en base de données, merci d'en choisir une autre pour optimiser le référencement de votre site";
				$err_meta_description = App::getVerifChamp("page", "ID_page", "meta_description", $meta_description, 158, $err_meta_description_char, $err_meta_description_egalite, $this->id_page);

				$err_titre_page_char = "Le titre de cette page ne doit pas dépasser 50 caractères";
				$err_titre_page_egalite = "Cette titre de page est déjà présent en base de données, merci d'en choisir un autre pour ne pas avoir de conflit dans votre navigation";
				$err_titre_page = App::getVerifChamp("page", "ID_page", "titre", $titre_page, 50, $err_titre_page_char, $err_titre_page_egalite, $this->id_page);

				if (App::getErreur() !== true) {
					$new_url = explode("/", $url);
					$new_filename = ROOT."app/views/".end($new_url).".php";

					rename($filename, $new_filename);

					$value = array(
						"id_page" => $id_page,
						"balise_title" => $balise_title,
						"url" => $url,
						"meta_description" => $meta_description,
						"titre_page" => $titre_page,
						"parent" => $parent,
						"contenu" => $contenu
					);

					$dbc->prepare("UPDATE page SET titre=:titre_page, contenu=:contenu, url=:url, meta_description=:meta_description, balise_title=:balise_title, parent=:parent WHERE ID_page=:id_page", $value);
				}
				else {
					$_SESSION['balise_title'] = $balise_title;
					$_SESSION['url'] = $url;
					$_SESSION['meta_description'] = $meta_description;
					$_SESSION['titre_page'] = $titre_page;
					$_SESSION['parent'] = $parent;
					$_SESSION['contenu'] = $contenu;
					$_SESSION['err_modification_contenu'] = true;

					$message = "<ul>".$err_balise_title.$err_url.$err_meta_description.$err_titre_page."</ul>";
					FlashMessage::setFlash($message);
				}
			}
			//sinon on renvoi une erreur en disant que le fichier n'existe pas et qu'il faut contacter un administrateur
			else {
				FlashMessage::setFlash("Impossible de modifier cette page, veuillez contacter votre administrateur pour corriger ce problème");
				$this->erreur = true;
			}
		}

		/**
		 * fonction qui permet de supprimer une page, test si fichier exist, si oui on delete
		 * @param $id_page
		 */
		public function setSupprimerPage($id_page) {
			$dbc = \core\App::getDb();

			//le premier id_page sera tojours l'accueil donc on ne peut pas le delete
			if ($id_page != 1) {
				$this->getContenuPage($id_page);

				$url = explode("/", $this->url);
				$filename = ROOT."app/views/".end($url).".php";

				//si le fichier existe supprimer en bdd plus l fichier
				if (file_exists($filename)) {
					unlink($filename);

					$value = array(
						"id_page" => $id_page
					);

					$dbc->prepare("DELETE FROM page WHERE ID_page=:id_page", $value);
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
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}