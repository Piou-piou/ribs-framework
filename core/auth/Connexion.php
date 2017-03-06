<?php
	namespace core\auth;

	use core\App;
	use core\Configuration;
	use core\functions\DateHeure;
	use core\HTML\flashmessage\FlashMessage;

	class Connexion {

		public function __construct() {
			if (session_id() == null) {
				session_start();
			}
		}

		/**
		 * @param $valide
		 * @param $archiver
		 * @param string $page_retour_err
		 */
		private function setTestParamCompte($valide, $archiver, $page_retour_err) {
			$config = new Configuration();

			//cela veut dire que l'utilisateur doit obligatoirement etre valider pour avoir acces au site
			if (($config->getValiderInscription() == 1) && ((isset($valide)) && ($valide != 1))) {
				FlashMessage::setFlash("Votre compta n'a encore pas été validé par un administrateur, vous ne pouvez donc pas accéder à ce site, veuillez réesseyer ultérieurement");
				header("location:$page_retour_err");
			}

			//si le compte est archiver (bloqué) l'utilisateur ne peut pas se connecter au site
			if ((isset($archiver)) && ($archiver == 1)) {
				FlashMessage::setFlash("Votre compte a été bloqué par un administrateur, vous ne pouvez donc pas vous connecter à ce site, veuillez réesseyer ultérieurement");
				header("location:$page_retour_err");
			}
		}

		private function setTestConnexion($query, $auth, $page_retour) {
			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					//si le compte est archivé on déconnecte la session et le cookie
					self::setTestParamCompte($obj->valide, $obj->archiver, $page_retour);

					$key = sha1($obj->pseudo.$obj->mdp);

					if ($key == $auth[1]) {
						$_SESSION['login'] = $obj->pseudo;
						$_SESSION["idlogin".CLEF_SITE] = $obj->ID_identite;

						setcookie("auth".CLEF_SITE, $obj->ID_identite."-----".$key, time() + 3600 * 24 * 3, "/", "", false, true);

						return true;
					}
				}
			}
		}


		/**
		 * Fonction de connexions a un espace membre ou prive avec un login / mdp
		 * @param string $pseudo pseudo que l'utilisateur utilise pour se connecter
		 * @param string $mdp mot de passe que l'utilisateur utilise
		 * @param string $page_retour_err page de retour en cas d'err de mdp ou pseudo
		 * @param string $page_retour page de retour quand connexion ok
		 * @param int $remember si on doit mémoriser la connexion au site
		 */
		public static function setLogin($pseudo, $mdp, $page_retour_err, $page_retour, $remember) {
			$dbc = App::getDb();
			$mdpbdd = "";
			$valide = "";
			$archiver = "";

			//recup des donnees
			$pseudo = $dbc->quote(htmlspecialchars($pseudo));
			$mdp_nonencrypt = $mdp;
			$mdp = md5(htmlspecialchars($mdp));
			$query = $dbc->select()->from("identite")->where("pseudo", "=", $pseudo, "", true)->get();

			//aficher query tant que qqch dans $ligne
			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) {
					$id = $obj->ID_identite;
					$pseudo = $obj->pseudo;
					$valide = $obj->valide;
					$archiver = $obj->archiver;
					$mdpbdd = Encrypt::setDecryptMdp($obj->mdp, $id);
				}
			}

			//verif si num enr = 0
			if (!isset($id)) {
				FlashMessage::setFlash("Vos identifiants de connexions sont incorrects");
				header("location:$page_retour_err");
			}
			else {
				self::setTestParamCompte($valide, $archiver, $page_retour_err);

				//si les mdp sont egaux on redirige ver esace membre sinon ver login avec un mess d'erreur
				if ($mdp == $mdpbdd) {
					$_SESSION['login'] = $pseudo;
					$_SESSION["idlogin".CLEF_SITE] = $id;

					self::setTestChangerMdp($id, $mdp_nonencrypt, $remember);

					FlashMessage::setFlash("Vous êtes maintenant connecté", "info");
					header("location:$page_retour");
				}
				else {
					FlashMessage::setFlash("Vos identifiants de connexions sont incorrects");
					header("location:$page_retour_err");
				}
			}
		}

		public static function setObgConnecte($page_retour) {
			if (!isset($_SESSION["idlogin".CLEF_SITE])) {
				FlashMessage::setFlash("Vous devez être connecté pour accéder à cette page");
				header("location:".$page_retour);
			}
		}

		/**
		 * Fonction pour lancer une connexoin avec un compte
		 * @param string $page_retour page sur laquel rediriger le mec qui a clique sur déconnexion
		 */
		public static function setConnexion($page_retour) {
			$dbc = App::getDb();

			//si le user n'a rien mis dans login on lui de pense a se connecter
			if ((isset($_COOKIE["auth".CLEF_SITE])) && (!empty($_SESSION["idlogin".CLEF_SITE]))) {
				$auth = $_COOKIE["auth".CLEF_SITE];

				$auth = explode("-----", $auth);

				$query = $dbc->select()->from("identite")->where("ID_identite", "=", $auth[0])->get();

				self::setTestConnexion($query, $auth, $page_retour);
			}
		}

		/**
		 * Fonction pour déconnecter un membre (on degage session et cookie)
		 * @param string $page_retour page sur laquel rediriger le mec qui a clique sur déconnexion
		 */
		public static function setDeconnexion($page_retour) {
			$_SESSION['login'];
			$_SESSION["idlogin".CLEF_SITE];
			unset($_SESSION['login']);
			unset($_SESSION["idlogin".CLEF_SITE]);
			session_destroy();
			setcookie("auth".CLEF_SITE, NULL, -1);

			session_start();

			header("location:".$page_retour);
		}


		//--------------------------------- info concernant les connexion au site du user --------------------------
		/**
		 * pour remettre la derniere connexoin à la date du jour
		 * @param $id_identite
		 */
		public static function setUpdatelastConnexion($id_identite) {
			$dbc = App::getDb();

			$dbc->update("last_change_mdp", date("Y-m-d"))->from("identite")->where("ID_identite", "=", $id_identite)->set();
		}

		/**
		 * permet de récupérer la dernier fois que l'utilisateur s'est connecté au site
		 * @param $id_identite
		 * @return mixed
		 */
		public static function getlastConnexion($id_identite) {
			$dbc = App::getDb();
			$query = $dbc->select("last_change_mdp")->from("identite")->where("ID_identite", "=", $id_identite)->get();
			if ((is_array($query)) && (count($query) > 0)) {
				foreach ($query as $obj) return $obj->last_change_mdp;
			}
		}

		/**
		 * @param $id_identite
		 * @param string $mdp_nonencrypt_tape
		 * @param integer $remember
		 */
		private static function setTestChangerMdp($id_identite, $mdp_nonencrypt_tape, $remember) {
			$membre = new Membre($id_identite);

			$date_array = DateHeure::dateBddToArray(self::getlastConnexion($id_identite));
			$last_change_mdp = mktime(0, 0, 0, $date_array[1], $date_array[2], $date_array[0]);
			$today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));

			if (($today - $last_change_mdp) > 259200) {
				self::setUpdatelastConnexion($id_identite);

				$membre->setMdp($mdp_nonencrypt_tape, $mdp_nonencrypt_tape, $mdp_nonencrypt_tape);
			}

			if ((isset($remember)) && ($remember != 0)) {
				setcookie("auth".CLEF_SITE, NULL, -1);
				setcookie("auth".CLEF_SITE, $id_identite."-----".sha1($membre->getPseudo().$membre->getMdp()), time() + 3600 * 24 * 3, "/", "", false, true);
			}
		}
	}