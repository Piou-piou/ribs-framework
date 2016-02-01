<?php
	if (isset($_SESSION['err_modification_droitsacces'])) {
		/*$balise_title = $_SESSION['balise_title'];
		$url = $_SESSION['url'];
		$meta_description = $_SESSION['meta_description'];
		$titre_courant = $_SESSION['titre_page'];
		$article = $_SESSION['contenu'];*/

		unset($_SESSION['err_modification_droitsacces']);
	}
	else if ($page == "gestion-droits-acces/modifier-liste") {
		$gestion_droit_acces = new \core\admin\droitsacces\GestionDroitAcces($_GET['id_liste']);
		/*$id_article = $_GET['id_article'];
		$balise_title = $admin_blog->getBaliseTitle();
		$url = $admin_blog->getUneUrl();
		$meta_description = $admin_blog->getMetaDescription();
		$titre_courant = $admin_blog->getTitre();
		$article = $admin_blog->getContenuArticle();*/
	}
	else {
		$balise_title = null;
		$url = null;
		$meta_description = null;
		$titre_courant = null;
		$article = null;
	}
?>