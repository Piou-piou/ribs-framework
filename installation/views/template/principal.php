<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Initialisation de l'installation de ribs</title>
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

		<?php require("installation/views/".$page.".php"); ?>

		<!-- scripts particules -->
		<script src="<?=WEBROOT?>admin/views/template/js/login/particles.js"></script>
		<script src="<?=WEBROOT?>admin/views/template/js/login/app.js"></script>
	</body>
</html>