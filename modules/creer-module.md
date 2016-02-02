#Create a module for Ribs framework

##Tree

* module_name
	* admin
		* controller
		* views
	* app
		* controller
		* views
			* nav.php
	* router
		* config.php
		* routes.php
	* install.php
	* uninstall.php


`
<?php
	//pour le blog
	$pages_blog = array("index", "article", "rechercher");

	if (\core\modules\GestionModule::getModuleActiver("blog")) {
		$blog = new \modules\blog\app\controller\Blog();

		if (!in_array($this->page, $pages_blog)) {
			\core\HTML\flashmessage\FlashMessage::setFlash("Cette page n'existe pas ou plus");
			header("location:".WEBROOT);
		}

		//pour l'index -> on récupere les derniers articles
		if ($this->page == "index") {
			$this->controller = "blog/app/controller/initialise/initialise_index.php";
		}

		//pour l'article -> on récupere un seul article
		if ($this->page == "article") {
			\modules\blog\app\controller\Blog::$parametre_router = $this->parametre;
			$this->controller = "blog/app/controller/initialise/initialise_article.php";
		}

		//pour la rechercher -> on récupere tous les articles ayant cette catégorie
		if ($this->page == "rechercher") {
			\modules\blog\app\controller\Blog::$parametre_router = $this->parametre;
			$this->controller = "blog/app/controller/initialise/initialise_rechercher.php";
		}
	}
	else {
		\core\HTML\flashmessage\FlashMessage::setFlash("L'accès à ce module n'est pas configurer ou ne fais pas partie de votre offre, contactez votre administrateur pour résoudre ce problème", "info");
		header("location:".WEBROOT);
	}
?>
`