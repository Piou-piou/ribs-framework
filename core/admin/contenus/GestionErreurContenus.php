<?php
	namespace core\admin\contenus;
	
	
	use core\App;
	use core\HTML\flashmessage\FlashMessage;
	
	trait GestionErreurContenus {
		private $erreur;
		private $err_balise_title;
		private $err_url;
		private $err_meta_description;
		private $err_titre_page;
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
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
		
		/**
		 * @param $balise_title
		 * @param null $id_page
		 * @return string
		 */
		private function getTestBaliseTitle($balise_title, $id_page = null) {
			$err_balise_title_char = "Le titre pour le navigateur ne doit pas dépasser 70 caractères";
			$err_balise_title_egalite = "Ce titre est déjà présent en base de données, merci d'en choisir un autre pour optimiser le référencement de votre site";
			$this->err_balise_title = $this->getVerifChamp("page", "ID_page", "balise_title", $balise_title, 70, $err_balise_title_char, $err_balise_title_egalite, $id_page);
		}
		
		/**
		 * @param $url
		 * @param null $id_page
		 * @return string
		 */
		private function getTestUrl($url, $id_page = null) {
			$err_url_char = "L'url ne doit pas dépasser 92 caractères";
			$err_url_egalite = "Cette url est déjà présent en base de données, merci d'en choisir une autre pour ne pas avoir de conflit entre vos pages";
			$this->err_url = $this->getVerifChamp("page", "ID_page", "url", $url, 92, $err_url_char, $err_url_egalite, $id_page);
		}
		
		/**
		 * @param $meta_description
		 * @param null $id_page
		 * @return string
		 */
		private function getTestMetaDescription($meta_description, $id_page = null) {
			$err_meta_description_char = "La description de cette page ne doit pas dépasser 158 caractères";
			$err_meta_description_egalite = "Cette description est déjà présent en base de données, merci d'en choisir une autre pour optimiser le référencement de votre site";
			$this->err_meta_description = $this->getVerifChamp("page", "ID_page", "meta_description", $meta_description, 158, $err_meta_description_char, $err_meta_description_egalite, $id_page);
		}
		
		/**
		 * @param $titre_page
		 * @param null $id_page
		 * @return string
		 */
		private function getTestTitrePage($titre_page, $id_page = null) {
			$err_titre_page_char = "Le titre de cette page ne doit pas dépasser 50 caractères";
			$err_titre_page_egalite = "Cette titre de page est déjà présent en base de données, merci d'en choisir un autre pour ne pas avoir de conflit dans votre navigation";
			$this->err_titre_page = $this->getVerifChamp("page", "ID_page", "titre", $titre_page, 50, $err_titre_page_char, $err_titre_page_egalite, $id_page);
		}
		
		/**
		 * @param $balise_title
		 * @param $url
		 * @param $meta_description
		 * @param $titre_page
		 * @param null $id_page
		 */
		private function getTestParam($balise_title, $url, $meta_description, $titre_page, $id_page = null) {
			$this->getTestBaliseTitle($balise_title, $id_page);
			$this->getTestUrl($url, $id_page);
			$this->getTestMetaDescription($meta_description, $id_page);
			$this->getTestTitrePage($titre_page, $id_page);
		}
		//-------------------------- END GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		private function setErreurContenus() {
			$_SESSION['balise_title'] = $this->balise_title;
			$_SESSION['url'] = $this->url;
			$_SESSION['meta_description'] = $this->meta_description;
			$_SESSION['titre_page'] = $this->titre_page;
			$_SESSION['parent'] = $this->parent;
			$_SESSION['err_modification_contenu'] = true;
			
			$message = "<ul>".$this->err_balise_title.$this->err_url.$this->err_meta_description.$this->err_titre_page."</ul>";
			FlashMessage::setFlash($message);
		}
		//-------------------------- END SETTER ----------------------------------------------------------------------------//
	}