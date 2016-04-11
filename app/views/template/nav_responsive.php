<nav class="nav-responsive">
	<i class="fa fa-bars fa-3x"></i>

	<ul>
		<?php if ($config->getContenusDynamique() == 1):?>
			<?php foreach (\core\App::getNav()->getNavigation() as $nav):?>
				<li><a href="<?=WEBROOT.$nav[2]?>" title="<?=$nav[3]?> responsive"><?=$nav[1]?></a>
					<?php if ((isset($nav[5]) && count($nav[5]) > 0)):?>
						<ul class="desactiver">
							<?php foreach ($nav[5] as $snav):?>
								<li><a href="<?=WEBROOT.$snav[2]?>" title="<?=$snav[3]?> responsive"><?=$snav[1]?></a></li>
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
</nav>