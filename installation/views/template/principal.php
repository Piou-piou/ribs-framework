<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?=$titre_page?></title>
		<meta charset="utf-8">
		<meta name="description" content="<?=$description_page?>">
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>reset_css/reset.css">
		<link rel="stylesheet" type="text/css" href="<?=WEBROOT?>installation/views/template/css/style.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script src="<?=WEBROOT?>installation/views/template/js/login.js"></script>

		<!-- Les librairies utlisées -->
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>input_type_admin/css/style.css">
		<script src="<?=LIBSWEBROOT?>input_type_admin/js/effet_input.js"></script>
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>font_awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>font_awesome/css/animate.css">
	</head>
	<?=core\HTML\flashmessage\FlashMessage::getFlash(); ?>
	<body class="installation">
		<div id="particles-js"></div>

		<div class="inner">
			<div class="installation-form active" id="login">
				<form  action="<?=ADMWEBROOT?>controller/core/auth/connexion/login" method="POST">
					<img src="<?=WEBROOT?>admin/views/template/images/ribs.png" alt="">

					<h1>Installation de Ribs ramework</h1>

					<p>Ribs framework of <a href="http://anthony-pilloud.fr">Pilloud Anthony</a> is avaible under the terms of
						<a href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons licence Attribution - Sharing in the same Conditions 4.0 International</a>.
					   Founded on a work at <a href="https://github.com/Piou-piou/ribs-framwork.git">https://github.com/Piou-piou/ribs-framwork.git</a>.
					</p>

					<p>Si vous installez ce framework, vous acceptez la licence Creative Commons ci-dessus</p>

					<button type="button" class="submit-contenu submit-standard no-shadow full-width">Installer Ribs</button>
					<input type="hidden" name="admin" value="true"/>
				</form>
			</div>
		</div>

		<!-- scripts particules -->
		<script src="<?=WEBROOT?>admin/views/template/js/login/particles.js"></script>
		<script src="<?=WEBROOT?>admin/views/template/js/login/app.js"></script>
	</body>
</html>