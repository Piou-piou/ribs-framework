<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?=$titre_page?></title>
		<meta charset="utf-8">
		<meta name="description" content="<?=$description_page?>">
		<link rel="stylesheet" type="text/css" href="<?=WEBROOT?>libs/font_awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?=WEBROOT?>libs/font_awesome/css/animate.css">
		<?php if ($config->getResponsive() == 1){?>
			<link rel="stylesheet" type="text/css" href="<?=TPLROOT?>css/foundation.css">
			<link rel="stylesheet" type="text/css" href="<?=TPLROOT?>css/nav-responsive.css">
		<?php } else {?>
			<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>reset_css/reset.css">
		<?php } ?>
		<link rel="stylesheet" type="text/css" href="<?=TPLROOT?>css/style.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	</head>
	<?=\core\HTML\flashmessage\FlashMessage::getFlash();?>
	<body>
		<header>
			<nav>
				<div class="inner">
					<ul>
						<?php if ($config->getContenusDynamique() == 1):?>
							<?php for ($i=0 ; $i<count($id_page) ; $i++): ?>
								<?php if ($parent[$i] == 0): ?>
									<li><a href="<?=WEBROOT?><?=$url[$i]?>" title="<?=$balise_title[$i]?> <?=$titre[$i]?>"><?=$titre[$i]?></a>
										<ul>
											<?php for ($j=0 ; $j<count($id_page) ; $j++): ?>
												<?php if ($parent[$j] == $id_page[$i]): ?>
													<li><a href="<?=WEBROOT?><?=$url[$j]?>" title="<?=$balise_title[$j]?> <?=$titre[$j]?>"><?=$titre[$j]?></a></li>
												<?php endif;?>
											<?php endfor;?>
										</ul>
									</li>
								<?php endif;?>
							<?php endfor;?>
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

		<div class="inner">
			<?php require($page.".php"); ?>
		</div>
	</body>
</html>