<nav class="nav-no-respsonsive">
	<div class="inner">
		<ul>
			<?php if ($config->getContenusDynamique() == 1):?>
				<?php foreach (\core\App::getNav()->getNavigation() as $nav):?>
					<li><a href="<?=$nav[2]?>" title="<?=$nav[3]?>" target="<?=$nav[5]?>"><?=$nav[1]?></a>
						<?php if ((isset($nav[6]) && count($nav[6]) > 0)):?>
							<ul>
								<?php foreach ($nav[6] as $snav):?>
									<li><a href="<?=$snav[2]?>" title="<?=$snav[3]?>"><?=$snav[1]?></a></li>
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