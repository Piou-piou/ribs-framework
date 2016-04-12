<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?=$titre_page?></title>
		<meta charset="utf-8">
		<meta name="description" content="<?=$description_page?>">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?=WEBROOT?>libs/font_awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?=WEBROOT?>libs/font_awesome/css/animate.css">
		<?php if ($config->getResponsive() == 1){?>
			<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
			<link rel="stylesheet" type="text/css" href="<?=TPLWEBROOT?>css/foundation.css">
			<link rel="stylesheet" type="text/css" href="<?=TPLWEBROOT?>css/nav-responsive.css">
			<script src="<?=TPLWEBROOT?>js/nav-responsive.js"></script>
		<?php } else {?>
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>reset_css/reset.css">
		<?php } ?>
		<link rel="stylesheet" type="text/css" href="<?=TPLWEBROOT?>css/style.css">
	</head>
	<?=\core\HTML\flashmessage\FlashMessage::getFlash();?>
	<body>
		<header>
			<nav class="nav-no-respsonsive">
				<div class="inner">
					<ul>
						<?php if ($config->getContenusDynamique() == 1):?>
							<?php foreach (\core\App::getNav()->getNavigation() as $nav):?>
								<li><a href="<?=WEBROOT.$nav[2]?>" title="<?=$nav[3]?>"><?=$nav[1]?></a>
									<?php if ((isset($nav[5]) && count($nav[5]) > 0)):?>
										<ul>
											<?php foreach ($nav[5] as $snav):?>
												<li><a href="<?=WEBROOT.$snav[2]?>" title="<?=$snav[3]?>"><?=$snav[1]?></a></li>
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
					</ul>
				</div>
			</nav>

			<?php if ($config->getResponsive() == 1) require_once(ROOT."app/views/template/nav_responsive.php");?>
		</header>

		<?php require($page.".php"); ?>

		<script>
			$(document).ready(function() {
				$("div").each(function() {
					$(this).removeAttr("contenteditable").blur();
				})
			})
		</script>

	</body>
</html>