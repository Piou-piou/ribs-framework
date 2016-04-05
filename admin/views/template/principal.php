<!DOCTYPE html>
<html lang="fr" class="no-js">
	<head>
		<title><?=$titre_page?></title>
		<meta charset="utf-8">
		<meta name="description" content="<?=$description_page?>">
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>font_awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>font_awesome/css/animate.css">
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>reset_css/reset.css">
		<link rel="stylesheet" type="text/css" href="<?=WEBROOT?>admin/views/template/css/style.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<script src="<?=WEBROOT?>admin/views/template/js/menu.js"></script>

		<!-- Les librairies utlisées -->
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>popup/css/style.css">
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>input_type_admin/css/style.css">
		<script src="<?=LIBSWEBROOT?>popup/js/popup.js"></script>
		<script src="<?=LIBSWEBROOT?>input_type_admin/js/effet_input.js"></script>
	</head>
	<?=\core\HTML\flashmessage\FlashMessage::getFlash(); ?>
	<body>
		<nav class="menu active">
			<div class="titre">
				<h1>Ribs V2.3.5</h1>
				<i class="fa fa-bars"></i>
			</div>
			<ul>
				<div class="principal">
					<li><i class="fa fa-user"></i><a href="<?=ADMWEBROOT?>gestion-comptes/mon-compte">Mon compte</a></li>

					<!-- Pour avoir accès à la gestion des autres comptes -->
					<?php if ($droit_acces->getDroitAccesPage("gestion-comptes/index") == true):?>
						<li><i class="fa fa-users"></i><a href="<?=ADMWEBROOT?>gestion-comptes/index">Gestion des comptes</a>
							<ul>
								<?php if ($droit_acces->getDroitAccesAction("CREATION COMPTE ADMIN")):?>
									<li><i class="fa fa-user"></i><a href="<?=ADMWEBROOT?>gestion-comptes/creer-utilisateur">Créer un utilisateur</a></li>
								<?php endif;?>
							</ul>
						</li>
					<?php endif; ?>

					<!-- Pour avoir accès à la gestion des autres comptes -->
					<?php if ($droit_acces->getDroitAccesPage("gestion-droits-acces/index") == true):?>
						<li><i class="fa fa-lock"></i><a href="<?=ADMWEBROOT?>gestion-droits-acces/index">Gestion des droits d'accès</a></li>
					<?php endif; ?>

					<!-- Pour avoir accès à la gestion des autres comptes -->
					<?php if ($droit_acces->getDroitAccesPage("gestion-contenus/index") == true):?>
						<li><i class="fa fa-file-text"></i><a href="<?=ADMWEBROOT?>gestion-contenus/index">Gestion des contenus</a>
							<ul>
								<?php if ($droit_acces->getDroitAccesAction("CREATION PAGE")):?>
									<li><i class="fa fa-newspaper-o"></i><a href="<?=ADMWEBROOT?>gestion-contenus/creer-une-page">Créer une page</a></li>
								<?php endif; ?>
							</ul>
						</li>
					<?php endif; ?>

					<!-- pour afficher le menu des modules -->
					<?php for ($i = 0; $i < count($gestion_module->getUrl()); $i++):?>
						<?php if ((\core\modules\GestionModule::getModuleActiver($gestion_module->getNom()[$i]) == true) && ($droit_acces->getDroitAccesPage($gestion_module->getUrl()[$i]."index") == true)):?>
							<li>
								<i class="fa <?=$gestion_module->getIcone()[$i]?>"></i>
								<a href="<?=MODULEADMWEBROOT.$gestion_module->getUrl()[$i]?>index">Gestion <?=$gestion_module->getNom()[$i]?> (V<?=$gestion_module->getVersion()[$i]?>)</a>
							</li>
						<?php endif; ?>
					<?php endfor; ?>
				</div>

				<div class="speciaux">
					<!-- lien fixes en bas de la page -->
					<?php if ($droit_acces->getSuperAdmin() == 1):?>
						<li class="notification <?php if ($admin->getNotification() == 1): ?> non-vue<?php endif; ?>">
							<i class="fa fa-exclamation <?php if ($admin->getNotification() == 1):?> animated infinite swing<?php endif; ?>"></i>
							<a href="<?=ADMWEBROOT?>notifications">Notifications systèmes</a>
						</li>
					<?php endif; ?>
					<?php if ($droit_acces->getSuperAdmin() == 1):?>
						<li class="configuration"><i class="fa fa-gear"></i><a href="<?=ADMWEBROOT?>configuration/index">Configuration</a>
							<ul>
								<li><a href="<?=ADMWEBROOT?>configuration/module">Modules</a></li>
								<li><a href="<?=ADMWEBROOT?>configuration/infos-generales">Infos générales</a></li>
								<li><a href="<?=ADMWEBROOT?>configuration/base-de-donnees">Base de données</a></li>
							</ul>
						</li>
					<?php endif; ?>
					<li class="support"><i class="fa fa-envelope"></i><a href="<?=ADMWEBROOT?>contacter-support">Contacter le support</a></li>
					<li class="logout"><i class="fa fa-times animated activate swing infinite"></i><a href="<?=WEBROOT?>administrator/controller/core/auth/connexion/logout">Déconexion</a></li>
				</div>
			</ul>
		</nav>
		<div class="clear"></div>

		<?php require("admin/views/".$page.".php"); ?>

		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
		<script src="<?=WEBROOT?>libs/input_file/js/input_file.js"></script>
	</body>
</html>