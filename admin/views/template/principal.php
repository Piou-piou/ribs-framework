<!DOCTYPE html>
<html lang="fr" class="no-js">
	<head>
		<title><?=$titre_page?></title>
		<meta charset="utf-8">
		<meta name="description" content="<?=$description_page?>">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?=WEBROOT?>admin/views/template/css/style.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<?php require_once(ROOT."admin/views/template/js/menu.php"); ?>
		
		<!-- Les librairies utlisées -->
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>popup/css/style.css">
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>input_type_admin/css/style.css">
		<script src="<?=LIBSWEBROOT?>popup/js/popup.js"></script>
		<script src="<?=LIBSWEBROOT?>input_type_admin/js/effet_input.js"></script>
	</head>
	<?=\core\HTML\flashmessage\FlashMessage::getFlash(); ?>
	<body>
		<nav class="menu <?php if (($_SESSION["menu_plie".CLEF_SITE] == "deplie") || (!isset($_SESSION["menu_plie".CLEF_SITE]))):?>active<?php endif; ?>">
			<div class="titre">
				<h1>Ribs V0.1</h1>
				<i class="fa fa-bars"></i>
			</div>
			
			<div class="mon-compte">
				<div class="colonne">
					<div class="image">
						<img src="<?=WEBROOT?>app/images/profil/defaut.png" alt="">
					</div>
				</div>
				<div class="colonne">
					<div class="info-compte">
						<h3><?=$nom_user?></h3>
						<div class="fonctions">
							<?php if ($droit_acces->getSuperAdmin() == 1):?>
								<div class="colonne">
									<div class="notif <?php if ($admin->getNotification() == 1): ?> non-vue<?php endif; ?>">
										<a href="<?=ADMWEBROOT?>notifications"><i class="fa fa-bell  <?php if ($admin->getNotification() == 1):?> animated infinite swing<?php endif; ?>"></i></a>
									</div>
								</div>
							<?php endif; ?>
							<div class="colonne">
								<div class="config">
									<a href="<?=ADMWEBROOT?>configuration/index"><i class="fa fa-gear"></i></a>
								</div>
							</div>
							<div class="colonne">
								<div class="logout">
									<a href="<?=WEBROOT?>administrator/controller/core/auth/connexion/logout"><i class="fa fa-sign-out"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<ul>
				<div class="principal">
					<?php
						if (!isset($arr)) {
							$arr = [];
						}
						echo $twig->render("template/left-navigation.html", array_merge(array_merge(array_merge(array_merge($arr, $constant), $_REQUEST), $_SESSION), $arr_admin));
					?>
					
					<!-- pour afficher le menu des modules -->
					<?php for ($i = 0; $i < count($gestion_module->getUrl()); $i++):?>
						<?php if (\core\modules\GestionModule::getModuleActiver($gestion_module->getNom()[$i]) == true):?>
							<li>
								<i class="fa <?=$gestion_module->getIcone()[$i]?>"></i>
								<a href="<?=MODULEADMWEBROOT.$gestion_module->getUrl()[$i]?>index">Gestion <?=$gestion_module->getNom()[$i]?> (V<?=$gestion_module->getVersion()[$i]?>)</a>
							</li>
						<?php endif; ?>
					<?php endfor; ?>
				</div>
				
				<div class="speciaux">
					<li class="support"><i class="fa fa-envelope"></i><a href="<?=ADMWEBROOT?>contacter-support">Contacter le support</a></li>
				</div>
			</ul>
		</nav>
		<div class="clear"></div>
		
		<?php
			echo $twig->render($page.".html", array_merge(array_merge(array_merge(array_merge($arr, $constant), $_REQUEST), $_SESSION), $arr_admin));
		?>
		
		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
		<script src="<?=WEBROOT?>libs/input_file/js/input_file.js"></script>
	</body>
</html>