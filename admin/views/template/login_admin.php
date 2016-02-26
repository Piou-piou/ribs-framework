<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?=$titre_page?></title>
		<meta charset="utf-8">
		<meta name="description" content="<?=$description_page?>">
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>reset_css/reset.css">
		<link rel="stylesheet" type="text/css" href="<?=WEBROOT?>admin/views/template/css/style.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script src="<?=WEBROOT?>admin/views/template/js/login.js"></script>

		<!-- Les librairies utlisées -->
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>input_type_admin/css/style.css">
		<script src="<?=LIBSWEBROOT?>input_type_admin/js/effet_input.js"></script>
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>font_awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>font_awesome/css/animate.css">
	</head>
	<?=core\HTML\flashmessage\FlashMessage::getFlash();?>
	<body class="login">
		<div id="particles-js"></div>

		<div class="inner">
			<div class="login-form active" id="login">
				<form  action="<?=ADMWEBROOT?>controller/core/auth/login" method="POST">
					<img src="<?=WEBROOT?>admin/views/template/images/ribs.png" alt="">

					<h1>Connexion à Ribs</h1>

					<div class="modifier-contenu">
						<div class="bloc">
							<label class="label" for="pseudo" type-val="string" min="3" max="15" data-error="Le doit être comprise entre 3 et 15 caractères">Pseudo</label>
							<input type="text" name="pseudo" required/>
						</div>

						<div class="bloc">
							<label class="label" for="mdp" type-val="string" min="3" max="15" data-error="Le mot de passe être comprise entre 3 et 15 caractères">Mot de passe</label>
							<input type="password" name="mdp" required/>
						</div>
					</div>

					<input type="submit" class="submit-contenu submit-standard no-shadow full-width" value="Connexion">
					<input type="hidden" name="admin" value="true"/>
				</form>

				<div class="lien">
					<a id="mdp-oublie">Mot de passe oublié ?</a>
				</div>
			</div>


			<div class="login-form" id="mdp-oublie">
				<form  action="" method="POST">
					<img src="<?=WEBROOT?>admin/views/template/images/ribs1.png" alt="">

					<h1>Mot de passe oublié</h1>

					<div class="modifier-contenu">
						<div class="bloc">
							<label class="label" for="mail" data-error="L'adresse mail doit êtreau minimum de 3 caractères">Entrez votre adresse E-mail</label>
							<input type="text" name="mail" required/>
						</div>
					</div>

					<input type="submit" class="submit-contenu submit-standard no-shadow full-width" value="Valider">
					<input type="hidden" name="admin" value="true"/>
				</form>

				<div class="lien">
					<a id="login">Retour</a>
				</div>
			</div>
		</div>

		<!-- scripts particules -->
		<script src="<?=WEBROOT?>admin/views/template/js/login/particles.js"></script>
		<script src="<?=WEBROOT?>admin/views/template/js/login//app.js"></script>
		<!--<script src="js/lib/stats.js"></script>-->
	</body>
</html>