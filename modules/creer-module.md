#Create a module for Ribs framework

##Tree

* module_name
	* admin
		* controller
		* views
	* app
		* controller
    	* views
	* router
		* config.php
		* routes.php
	* install.php
	* uninstall.php

##Explication of files



###File : install.php

This file contain only one variable, and this variable contain all the sql request which are needed for creating all the tables
for using the module.

In all those requests, one must be an insert into the table 'module', tanks to this, the module will be incremented by the system.

the request for the table module is something such as : 'INSERT INTO module (url, nom_module, installer, icone) VALUES ('url_olf_my_module/', 'name_of_mymodule', '1', 'an incon in font awesome')';



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