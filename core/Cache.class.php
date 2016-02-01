<?php
	namespace core;
	use core\functions\ChaineCaractere;

	class Cache {
		private $dossier_cache; //dossier ou sont stockés tous les caches

		private $chemin_page; //chemin vers la page a mettre ou aller chercher en cache
		private $page; //nom de la page a chercher ou a mettre en cache
		private $chemin_cache; //chemin du fichier dans le dossier cache
		private $no_cache; //definit dans get cache pour dire que cette page ne doit jamais etre en cache
		


		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		public function __construct($page, $admin=null) {
			//on crée les dossier du cache si ils n'existent pas deja
			if (!file_exists(ROOT."cache")) {
				mkdir(ROOT."cache");
				mkdir(ROOT."cache/admin");
				mkdir(ROOT."cache/app");
			}

			if ($admin == null) {
				$this->dossier_cache =  ROOT."cache/app/";
			}
			else {
				$this->dossier_cache =  ROOT."cache/admin/";
			}

			$page = ChaineCaractere::setUrl($page);
			$page = str_replace("/", "-", $page);

			$this->page = $page.".php";
			$this->chemin_cache = $this->dossier_cache.$this->page;
			$this->chemin_page = $page.".php";
		}
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * @return bool
		 * fonction verifie en bdd si on a déjà enregistrer le fichier en cache
		 * si il ne l'est pas on le met, et si il y est et que reload cache == 0 on prend le fichier qui est en cache
		 * sinon soit on update la bdd et on refait un cache soit on crée tout
		 */
		private function getCache() {
			$dbc = App::getDb();

			//on regarde si il existe et un cache et si il faut ou non le remettre à jour
			$query = $dbc->query("SELECT * FROM cache WHERE nom_fichier like '$this->page'");

			if (count($query) > 0) {
				foreach ($query as $obj) {
					$reload_cache = $obj->reload_cache;
					$this->no_cache = $obj->no_cache;
				}
			}
			else {
				$value = [
					"nom_fichier" => $this->page,
					"reload_cache" => 0
				];
				$dbc->prepare("INSERT INTO cache (nom_fichier, reload_cache) VALUES (:nom_fichier, :reload_cache)", $value);

				$reload_cache = 0;
			}

			if ((file_exists($this->chemin_cache)) && ($reload_cache == 0) && ($this->no_cache == null)) {
				return true;
			}
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
		
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * @return bool
		 * fonction qui permet de démarrer l'affichage de la page
		 * soit en allant la chercher dans le cache
		 * sinon on lance un ob_start
		 */
		public function setStart() {
			$config = new Configuration();

			if ($config->getCache() == 1) {
				if ($this->getCache() == true) {
					require_once($this->chemin_cache);

					return true;
				}
				else {
					if ($this->no_cache == null) {
						ob_start();
					}

					return false;
				}
			}
			else {
				return false;
			}
		}

		/**
		 * fonction qui fini de récupérer le contenu et qui le met en cache
		 * une fois mis en cache on affiche la page
		 */
		public function setEnd() {
			$config = new Configuration();

			if ($config->getCache() == 1) {
				if (($this->getCache() != true) && ($this->no_cache == null)) {
					$contenu = ob_get_clean();

					$this->setCache($contenu);

					echo $contenu;
				}
			}
		}

		/**
		 * @param $contenu_fichier
		 * fonction qui met en cache le contenu du fichier enregistrer dans le ob
		 */
		private function setCache($contenu_fichier) {
			$dbc= App::getDb();

			$fichier_cache = $this->chemin_cache;

			file_put_contents($fichier_cache, $contenu_fichier);

			$value = [
				"nom_fichier" => $this->page,
			];

			$dbc->prepare("UPDATE cache SET reload_cache=0 WHERE nom_fichier=:nom_fichier", $value);
		}

		/**
		 * @param $nom_fichier
		 * fonction qui permet de dire qu'il faut recharger le cache d'un fichier spécifique
		 * appeler par des controller (dans des modules ou dans l'admin...)
		 */
		public static function setReloadCache($nom_fichier) {
			$dbc = App::getDb();

			$nom_fichier = ChaineCaractere::setUrl($nom_fichier);
			$nom_fichier = str_replace("/", "-", $nom_fichier);

			$value = [
				"reload" => 1,
				"nom_fichier" => $nom_fichier
			];

			$dbc->prepare("UPDATE cache SET reload_cache=:reload WHERE nom_fichier LIKE :nom_fichier", $value);
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}