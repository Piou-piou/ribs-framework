<?php
	namespace core\auth;

	use core\App;
	use core\functions\ChaineCaractere;

	class Encrypt {
		private static $params;
		
		
		//-------------------------- CONSTRUCTEUR ----------------------------------------------------------------------------//
		//-------------------------- FIN CONSTRUCTEUR ----------------------------------------------------------------------------//
		
		
		//-------------------------- GETTER ----------------------------------------------------------------------------//
		/**
		 * @param null $id_identite
		 * @return string
		 */
		public static function getParams($id_identite = null) {
			if ($id_identite != null) {
				$dbc = App::getDb();
				$params = "";

				$query = $dbc->select("mdp_params")->from("identite")->where("ID_identite", "=", $id_identite)->get();
				if ((is_array($query)) && (count($query) > 0)) {
					foreach ($query as $obj) {
						$params = $obj->mdp_params;
					}
				}
			}
			else {
				$params = self::$params;
			}

			return $params;
		}
		//-------------------------- FIN GETTER ----------------------------------------------------------------------------//
		
		
		//-------------------------- SETTER ----------------------------------------------------------------------------//
		/**
		 * fonction qui permet d'encrypter un mot de passe, une fois encrype, on save les params pour le retrouver en bdd
		 * @param string|null $mdp
		 * @param $id_identite
		 * @return string
		 */
		public static function setEncryptMdp($mdp, $id_identite = null) {
			$encrypt_str = ChaineCaractere::random(154);

			//on cache le mdp
			$mdp = md5($mdp);

			//récupération de la logneur du mot de passe
			$longeur_mdp = strlen($mdp);

			//on va couper le mot de passe en 2 suivant un nombre aleatoire
			$nb_aleatoire_mdp = rand(3, $longeur_mdp - 2);
			$bout1_mdp = mb_substr($mdp, 0, $longeur_mdp / 2, "UTF-8");
			$bout2_mdp = mb_substr($mdp, $longeur_mdp / 2, $longeur_mdp, "UTF-8");

			//on stock la taille des bouts pour pouvoir les décrypter
			$taille_bout1 = strlen($bout1_mdp);
			$taille_bout2 = strlen($bout2_mdp);

			//on insere le premier bout aleatoirement dans le hashmdp
			//on calcul sa longeur total (celle duhash + la logneur du mdp que l'on va rajouter dedans)
			$longueur_hash = strlen($encrypt_str);
			$debut_bout1 = rand(0, $longueur_hash / 2);

			//on rajouter le premier bout dans le mot de passe + recalcule de la longeur du hash avec le mdp add
			$encrypt_str = mb_substr($encrypt_str, 0, $debut_bout1).$bout1_mdp.mb_substr($encrypt_str, $debut_bout1, $longueur_hash);

			//on insere le second bout aleatoirement dans le hashmdp
			//on calcul sa longeur total (celle duhash + la logneur premier bout du mdp que l'on va rajouter dedans)
			$longueur_hash = strlen($encrypt_str);
			$debut_bout2 = rand($longueur_hash / 2, $longueur_hash);

			//on rajoute le deuxieme
			$mdp_encrypt = mb_substr($encrypt_str, 0, $debut_bout2).$bout2_mdp.mb_substr($encrypt_str, $debut_bout2, $longueur_hash);

			if ($id_identite != null) {
				self::setSaveParams("$taille_bout1, $debut_bout2, $nb_aleatoire_mdp, $taille_bout2, $debut_bout1, ".ChaineCaractere::random(20), $id_identite);
			}
			else {
				self::$params = "$taille_bout1, $debut_bout2, $nb_aleatoire_mdp, $taille_bout2, $debut_bout1, ".ChaineCaractere::random(20);
			}

			return $mdp_encrypt;
		}

		/**
		 * fonction qui permet de décrypter un mdp
		 * @param $mdp
		 * @param $id_identite
		 * @return string
		 */
		public static function setDecryptMdp($mdp, $id_identite) {
			//récupérations des parametres pour la décryption
			self::$params = explode(", ", self::getParams($id_identite));

			//récupération du premier bout en fonction du tableau
			$bout1_mdp = mb_substr($mdp, self::$params[4], self::$params[0]);
			$bout2_mdp = mb_substr($mdp, self::$params[1], self::$params[3]);

			return $bout1_mdp.$bout2_mdp;
		}

		/**
		 * sauvegarde les parametres pour retrouver le mot de passe dans la bdd
		 * @param string $params
		 * @param $id_identite
		 */
		public static function setSaveParams($params, $id_identite) {
			$dbc = App::getDb();

			$dbc->update("mdp_params", $params)->from("identite")->where("ID_identite", "=", $id_identite)->set();
		}
		//-------------------------- FIN SETTER ----------------------------------------------------------------------------//
	}