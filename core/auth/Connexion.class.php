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
		 * Fonction de connexions a un espace membre ou prive avec un login / mdp
		 * @param string $pseudo pseudo que l'utilisateur utilise pour se connecter
		 * @param string $mdp mot de passe que l'utilisateur utilise
		 * @param string $page_retour_err page de retour en cas d'err de mdp ou pseudo
		 * @param string $page_retour page de retour quand connexion ok
		 */
		public static function setLogin($pseudo, $mdp, $page_retour_err, $page_retour) {
			$dbc = App::getDb();

			//recup des donnees
			$pseudo = $dbc->quote(htmlspecialchars($pseudo));
			$mdp_noncrypt = $mdp;
			$mdp = md5(htmlspecialchars($mdp));

			$query = $dbc->query("select * from identite where pseudo=$pseudo");

			//aficher query tant que qqch dans $ligne
			if (count($query) > 0) {
				foreach ($query as $obj) {
					$id = $obj->ID_identite;
					$pseudo = $obj->pseudo;
					$valide = $obj->valide;
					$archiver = $obj->archiver;
				}
			}


			//verif si num enr = 0
			if (!isset($id)) {
				FlashMessage::setFlash("Vos identifiants de connexions sont incorrects");
				header("location:$page_retour_err");
			}
			else {
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

				$mdpbdd = "";
				$query2 = $dbc->query("select mdp from identite where ID_identite='$id'");
				foreach ($query2 as $obj2) {
					$mdpbdd = Encrypt::setDecryptMdp($obj2->mdp, $id);
				}
				

				//si les mdp sont egaux on redirige ver esace membre sinon ver login avec un mess d'erreur
				if ($mdp == $mdpbdd) {
					$_SESSION['login'] = $pseudo;
					$_SESSION["idlogin".CLEF_SITE] = $id;

					//on test quand le user s'est connecté pour la derniere fois, si la date est supérrieur de trois jour, on refait un mdp
					$date_array = DateHeure::dateBddToArray(self::getlastConnexion($id));
					$last_change_mdp = mktime(0, 0, 0, $date_array[1], $date_array[2], $date_array[0]);
					$today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));

					if (($today - $last_change_mdp) > 259200) {
						self::setUpdatelastConnexion($id);

						$membre = new Membre($id);
						$membre->setMdp($mdpbdd, $mdp_noncrypt, $mdp_noncrypt);

						if (isset($_POST['remember'])) {
							setcookie("auth".CLEF_SITE, $id."-----".sha1($pseudo.$membre->getMdp()), time() + 3600 * 24 * 3, "/", "", false, true);
						}
					}
					else {
						if (isset($_POST['remember'])) {
							setcookie("auth".CLEF_SITE, $id."-----".sha1($pseudo.$mdpbdd), time() + 3600 * 24 * 3, "/", "", false, true);
						}
					}


					FlashMessage::setFlash("Vous êtes maintenant connecté", "info");
					header("location:$page_retour");
				}
				else {
					FlashMessage::setFlash("Vos identifiants de connexions sont incorrects");
					header("location:$page_retour_err");
				}
			}
		}

		/**
		 * Fonction pour lancer une connexoin avec un compte
		 * @param int $obj_connecte si = 1 on est obligge d'être connecte pour avoir acces à la page
		 * @param string $page_retour page sur laquel rediriger le mec qui a clique sur déconnexion
		 *
		 * Ne pa oublier de changer auth et mettre auth_nomdusite opur ne pas avoir de conflits
		 */
		public static function setConnexion($obj_connecte, $page_retour) {
			$dbc = App::getDb();

			//si le user n'a rien mis dans login on lui de pense a se connecter
			if ((isset($_COOKIE["auth".CLEF_SITE])) && (!empty($_SESSION["idlogin".CLEF_SITE]))) {
				$auth = $_COOKIE["auth".CLEF_SITE];

				$auth = explode("-----", $auth);

				$query = $dbc->query("SELECT * FROM identite WHERE ID_identite=".$auth[0]);
				foreach ($query as $obj) {
					//si le compte est archivé on déconnecte la session et le cookie
					if ($obj->archiver == 1) {
						setcookie("auth".CLEF_SITE, NULL, -1);
						self::setDeconnexion($page_retour);
					}
					else {
						$key = sha1($obj->pseudo.$obj->mdp);

						if ($key == $auth[1]) {
							$_SESSION['login'] = $obj->pseudo;
							$_SESSION["idlogin".CLEF_SITE] = $obj->ID_identite;

							//on test quand le user s'est connecté pour la derniere fois, si la date est supérrieur de trois jour, on refait un mdp
							$date_array = DateHeure::dateBddToArray(self::getlastConnexion($obj->ID_identite));
							$last_change_mdp = mktime(0, 0, 0, $date_array[1], $date_array[2], $date_array[0]);
							$today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));

							if (($today - $last_change_mdp) > 259200) {
								self::setUpdatelastConnexion($obj->ID_identite);

								//on refait un nouveau mdp encrypté avec le même mdp
								$mdp_actuel = Encrypt::setDecryptMdp($obj->mdp, $obj->ID_identite);
								$membre = new Membre($obj->ID_identite);
								$membre->setMdp($mdp_actuel, $mdp_actuel, $mdp_actuel);

								//on detruit le cookie et on le refait avec le mdp regénéré
								setcookie("auth".CLEF_SITE, NULL, -1);
								$key = sha1($obj->pseudo.$membre->getMdp());
								setcookie("auth".CLEF_SITE, $obj->ID_identite."-----".$key, time() + 3600 * 24 * 3, "/", "", false, true);
							}
							else {
								setcookie("auth".CLEF_SITE, $obj->ID_identite."-----".$key, time() + 3600 * 24 * 3, "/", "", false, true);
							}
						}
						else {
							if ($obj_connecte == 1) {
								self::setDeconnexion($page_retour);
							}
						}
					}

				}
			}
			else if (!isset($_SESSION["idlogin".CLEF_SITE])) {
				if ($obj_connecte == 1) {
					FlashMessage::setFlash("Vous devez être connecté pour accéder à cette page");
					header("location:".$page_retour);
				}
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
			FlashMessage::setFlash("Vous avez été déconnecté avec succès", "success");

			header("location:".$page_retour);
		}


		//--------------------------------- info concernant les connexion au site du user --------------------------
		/**
		 * pour remettre la derniere connexoin à la date du jour
		 * @param $id_identite
		 */
		public static function setUpdatelastConnexion($id_identite) {
			$dbc = App::getDb();

			$dbc->prepare("UPDATE identite SET last_change_mdp=:date WHERE ID_identite=:id_identite", array("date"=>date("Y-m-d"), "id_identite"=>$id_identite));
		}

		/**
		 * permet de récupérer la dernier fois que l'utilisateur s'est connecté au site
		 * @param $id_identite
		 * @return mixed
		 */
		public static function getlastConnexion($id_identite) {
			$dbc = App::getDb();

			$query = $dbc->query("SELECT last_change_mdp FROM identite WHERE ID_identite=".$id_identite);
			foreach ($query as $obj) return $obj->last_change_mdp;
		}
	}