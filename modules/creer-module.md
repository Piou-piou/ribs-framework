#Create a module for Ribs framework

##Tree of a module

* module_name
	* admin
		* controller
			* initialise
				* page_detect.php
		* views
			* header.php
	* app
		* controller
    	* views
    	    * nav.php
	* router
		* config.php
		* routes.php
	* install.php
	* uninstall.php

##Explication of files

###Downloading a virgin module

You can download a virgin module at this adress : library.anthony-pilloud.fr/virgin_module.zip



###File : install.php

This file contain only one variable, and this variable contain all the sql request which are needed for creating all the tables
for using the module.

In all those requests, one must be an insert into the table 'module', tanks to this, the module will be incremented by the system.

the requests into this file  is something such as :


```php
$requete = "
		CREATE TABLE IF NOT EXISTS _blog_article (
		ID_article int(11) NOT NULL,
		  titre varchar(200) DEFAULT NULL,
		  article text,
		  date date DEFAULT NULL,
		  url varchar(255) DEFAULT NULL,
		  meta_description varchar(160),
		  balise_title varchar(70),
		  nb_commentaire int(11) DEFAULT NULL,
		  ID_identite int(11)
		) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

		ALTER TABLE _blog_article
        		 ADD PRIMARY KEY (ID_article);

        ALTER TABLE _blog_article
        		MODIFY ID_article int(11) NOT NULL AUTO_INCREMENT;

		INSERT INTO module (url, nom_module, installer, icone) VALUES ('url_olf_my_module/', 'name_of_mymodule', '1', 'an incon in font awesome');
```



###File : uninstall.php
This file contain only one variable, and this variable contain all the sql request which are needed for delete all the tables
of this module.

the requests into this file  is something such as :


```php
$requete = "
		DROP TABLE _blog_article;
```



###File : router/routes.php

First of all, you must create an array which contain all the front pages of the module.

The first condition will test if our module is activated (if activer == 1 in table module into the bdd).

Then if module is activated, we initialise it. After initialisation, we test if the page which is called in the url is
a valid page in the module.

And below those verification we test what page is called and we initialise the good controller with parameters passed in url.

This exemple is for the blog module, an url of this module is such as : http://mywebsite.com/blog/article/one-article-of-the-blog

In this url :
- blog/ : define the module, it is in module table in fiel url
- article : define the page which is going to be called into the module
- one-article-of-the-blog : is the parameter, here the url of an article (field url in the table _blog_article)


```php
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
```



###File : router/config.php

This file contain a lots constants that can facilitate your development.

I use it just for define my roots for calling some files.

Example for blog module


```php
//pour le dossier racine du blog
define("BLOGWEBROOT", str_replace("$page_root", '', $_SERVER['SCRIPT_NAME'])."modules/blog/app/views/");

//pour le dossier racine du blog -> for include and require
define('BLOGROOT', str_replace("$page_root", '', $_SERVER['SCRIPT_FILENAME'])."modules/blog/app/views/");
```



###File : app/views/nav.php

This file include the config for the module and the css necessary for the module.

And below those includes, we have the navigation which will be displayed on the front of
the website (called in app/views/template/principal.php)

Example :


```php
<?php require_once(MODULEROOT."blog/router/config.php"); ?>
<link rel="stylesheet" href="<?=BLOGWEBROOT?>css/style.css"/>
<li><a href="<?=WEBROOT?>blog">Blog</a></li>
```



###File : admin/views/header.php

This file is included by all the file into the views of the admin for the module.

This file contain the navigation of the module and one or more popup.

The navigation can contain one drop down menu, no more.

At the top of this file, there is the required files which are :
- router/config.php : see documentation above
- admin/controller/initialise/page_detect.php : see the documentation below

Example :


```php
<?php require_once(MODULEROOT."blog/router/config.php"); ?>
<?php require_once(MODULEROOT."blog/admin/controller/initialise/page_detect.php"); ?>
<nav class="nav-page">
	<div class="inner">
		<ul>
			<li><a href="">Articles</a>
				<ul>
					<?php if ($droit_acces->getDroitAccesAction("AJOUTER ARTICLE BLOG") == true):?>
						<li><a href="<?=ADMWEBROOT?>modules/blog/ajouter-article">Ajouter un article</a></li>
					<?php endif;?>
					<?php if ($droit_acces->getDroitAccesAction("MODIFIER ARTICLE BLOG") == true):?>
						<li><a href="<?=ADMWEBROOT?>modules/blog/liste-article">Modifier un article</a></li>
					<?php endif;?>
					<li><a href="<?=ADMWEBROOT?>modules/blog/liste-article">Liste des articles</a></li>
				</ul>
			</li>
			<li><a href="">Catégories</a>
				<ul>
					<li><a href="<?=ADMWEBROOT?>modules/blog/categorie/ajouter-categorie">Ajouter une catégorie</a></li>
					<li><a href="<?=ADMWEBROOT?>modules/blog/categorie/liste-categorie">Modifier une catégorie</a></li>
					<li><a href="<?=ADMWEBROOT?>modules/blog/categorie/liste-categorie">Liste des catégoriese</a></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>



<div class="popup" id="popup-delete">
	<div class="content">
		<h2>Etes-vous sûr de vouloir supprimer cet article ?</h2>
		<p>Si vous le supprimé, tous les commentaires qui y sont associés seront supprimés ainsi que l'article et son contenu textuel.<br/>
			Les images qui le compose seront quant à elle sauvegardées.
		</p>

		<div class="lien">
			<a class="annuler">Annuler</a>
			<a href="" class="valider">Valider</a>
		</div>
		<div class="clear"></div>
	</div>
</div>
```



###File : admin/controller/initialise/page_detect.php

this file is like router/routes.php but for the administration.

At the top of the file there is an array which contain all the page in the views of the module.

First of all we test if the module is activated and if the page called in the url is in our array.

if we have $page_module (if we detect the keyword 'modules' in the url), we find what page of the views is called
and we load the correct controller.


```php
$page_blog = array(
	"modules/blog/index",
	"modules/blog/ajouter-article",
	"modules/blog/liste-article",
	"modules/blog/modifier-article",
	"modules/blog/gestion-commentaire"
);

if ((\core\modules\GestionModule::getModuleActiver("blog") == false) && (in_array($page_module, $page_blog))) {
	\core\HTML\flashmessage\FlashMessage::setFlash("L'accès à cette page n'est pas activé, veuillez contacter votre administrateur pour y avoir accès");
	header("location:".WEBROOT."administrator");
}

if (isset($page_module)) {
	if ($page_module == "modules/blog/liste-article") {
		require_once(MODULEROOT."blog/admin/controller/initialise/liste_article.php");
	}
	if (($page_module == "modules/blog/ajouter-article") || ($page_module == "modules/blog/modifier-article")) {
		require_once(MODULEROOT."blog/admin/controller/initialise/ajout_modification.php");
	}
	if ($page_module == "modules/blog/categorie/liste-categorie") {
		$admin_blog = new \modules\blog\admin\controller\AdminBlog();
		$admin_blog->getListeCategorie();
	}
	if (($page_module == "modules/blog/categorie/ajouter-categorie") || ($page_module == "modules/blog/categorie/modifier-categorie")) {
		require_once(MODULEROOT."blog/admin/controller/initialise/ajout_modification_categorie.php");
	}
	if ($page_module == "modules/blog/gestion-commentaire") {
		require_once(MODULEROOT."blog/admin/controller/initialise/gestion_commentaire.php");
	}
}
```

### Other pages and controllers

For the other pages, you can create it like you want.

#### Front Controllers

To call a controller in the front of your website in a module, the url is like : 

The number of sub-directory is unlimited into controller directory.


```php
<?=WEBROOT?>controller/modules/name_of_your_module/directory_in_controller/name_of_controller.php
```

#### Admin Controllers

To call a controller in the admin of your website in a module, the url is like : 

The number of sub-directory is unlimited into controller directory.


```php
<?=ADMWEBROOT?>controller/modules/name_of_your_module/directory_in_controller/name_of_controller
```

##Notification into a module

In a module you can add notification which is added a the right of the navigation menu.
This is very simple, just add the div whith notification class.

###File : admin/views/header.php

```php

<?php require_once(MODULEROOT."blog/router/config.php"); ?>
<?php require_once(MODULEROOT."blog/admin/controller/initialise/page_detect.php"); ?>
<nav class="nav-page">
	<a href="<?=ADMROOT?>modules/gestion_planning/demande-conges">
    	<div class="notification">
    		<div class="colonne">
    			<p>Lorem ipsum dolor sit amet</p>
    		</div>
    		<div class="colonne">
    			<i class="fa fa-exclamation animated swing infinite"></i>
    		</div>
    	</div>
    </a>

	<div class="inner">
		<ul>
			<li><a href="">Articles</a>
				<ul>
					<?php if ($droit_acces->getDroitAccesAction("AJOUTER ARTICLE BLOG") == true):?>
						<li><a href="<?=ADMWEBROOT?>modules/blog/ajouter-article">Ajouter un article</a></li>
					<?php endif;?>
					<?php if ($droit_acces->getDroitAccesAction("MODIFIER ARTICLE BLOG") == true):?>
						<li><a href="<?=ADMWEBROOT?>modules/blog/liste-article">Modifier un article</a></li>
					<?php endif;?>
					<li><a href="<?=ADMWEBROOT?>modules/blog/liste-article">Liste des articles</a></li>
				</ul>
			</li>
			<li><a href="">Catégories</a>
				<ul>
					<li><a href="<?=ADMWEBROOT?>modules/blog/categorie/ajouter-categorie">Ajouter une catégorie</a></li>
					<li><a href="<?=ADMWEBROOT?>modules/blog/categorie/liste-categorie">Modifier une catégorie</a></li>
					<li><a href="<?=ADMWEBROOT?>modules/blog/categorie/liste-categorie">Liste des catégoriese</a></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>



<div class="popup" id="popup-delete">
	<div class="content">
		<h2>Etes-vous sûr de vouloir supprimer cet article ?</h2>
		<p>Si vous le supprimé, tous les commentaires qui y sont associés seront supprimés ainsi que l'article et son contenu textuel.<br/>
			Les images qui le compose seront quant à elle sauvegardées.
		</p>

		<div class="lien">
			<a class="annuler">Annuler</a>
			<a href="" class="valider">Valider</a>
		</div>
		<div class="clear"></div>
	</div>
</div>
```		