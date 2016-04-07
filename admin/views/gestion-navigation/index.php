<header>
	<div class="inner">
		<h1>Gestion de la navigation</h1>
	</div>
</header>
<?php include("header.php"); ?>


<div class="inner">
	<div class="contenu modifier-contenu gestion-navigation">
		<ul>
			<?php foreach (\core\App::getNav()->getNavigation() as $nav):?>
				<li><a href="<?=$nav[0]?>" title="<?=$nav[3]?>"><?=$nav[1]?></a>
					<?php if ((isset($nav[4]) && count($nav[4]) > 0)):?>
						<ul>
							<?php foreach ($nav[4] as $snav):?>
								<li><a href="<?=$snav[0]?>" title="<?=$snav[3]?>"><?=$snav[1]?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
