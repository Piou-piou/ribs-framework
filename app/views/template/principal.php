<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?=$titre_page?></title>
		<meta charset="utf-8">
		<meta name="description" content="<?=$description_page?>">
		<link rel="stylesheet" type="text/css" href="<?=WEBROOT?>libs/font_awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?=WEBROOT?>libs/font_awesome/css/animate.css">
		<?php if ($config->getResponsive() == 1){?>
			<link rel="stylesheet" type="text/css" href="<?=TPLWEBROOT?>css/foundation.css">
			<link rel="stylesheet" type="text/css" href="<?=TPLWEBROOT?>css/nav-responsive.css">
		<?php } else {?>
			<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>reset_css/reset.css">
		<?php } ?>
		<link rel="stylesheet" type="text/css" href="<?=TPLWEBROOT?>css/style.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	</head>
	<?=\core\HTML\flashmessage\FlashMessage::getFlash();?>
	<body>
		<header>
			<nav>
				<div class="inner">
					<ul>
						<?php if ($config->getContenusDynamique() == 1):?>
							<?php $nav = new \core\Navigation();foreach ($nav->getNavigation() as $nav):?>
								<li><a href="<?=WEBROOT.$nav[1]?>" title="<?=$nav[2]?>"><?=$nav[0]?></a>
									<?php if (count($nav[3]) > 0):?>
										<ul>
											<?php foreach ($nav[3] as $snav):?>
												<li><a href="<?=WEBROOT.$snav[1]?>" title="<?=$snav[2]?>"><?=$snav[0]?></a></li>
											<?php endforeach;?>
										</ul>
									<?php endif;?>
								</li>
							<?php endforeach;?>
						<?php endif;?>

						<?php if ($config->getActiverConnexion() == 1):?>
						<li><a href="">Connexion</a></li>
						<?php endif;?>

						<?php if ($config->getActiverInscription() == 1):?>
							<li><a href="">Inscription</a></li>
						<?php endif;?>

						<!-- pour afficher le menu des modules -->
						<?php for ($i=0 ; $i<count($gestion_module->getUrl()) ; $i++):?>
							<?php if(\core\modules\GestionModule::getModuleActiver($gestion_module->getNom()[$i]) == true)require_once(MODULEROOT.$gestion_module->getUrl()[$i]."app/views/nav.php");?>
						<?php endfor;?>
					</ul>
				</div>
			</nav>
		</header>

		<?php require($page.".php"); ?>

	</body>
</html>