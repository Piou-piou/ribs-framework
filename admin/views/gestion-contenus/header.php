<nav class="nav-page">
	<div class="inner">
		<ul>
			<?php foreach (\core\App::getNav(1)->getNavigation() as $nav):?>
				<li><a href="<?=ADMWEBROOT?>gestion-contenus/modifier-contenu?id=<?=$nav[0]?>" title="<?=$nav[3]?>"><?=$nav[1]?></a>
					<?php if ((isset($nav[6]) && count($nav[6]) > 0)):?>
						<ul>
							<?php foreach ($nav[6] as $snav):?>
								<li><a href="<?=ADMWEBROOT?>gestion-contenus/modifier-contenu?id=<?=$snav[0]?>" title="<?=$snav[3]?>"><?=$snav[1]?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</nav>
<script src="<?=WEBROOT?>admin/views/gestion-contenus/js/contenu.js"></script>

<div class="popup" id="supprimer-page">
	<div class="content">
		<h2>Etes-vous sûr de vouloir supprimer cette page ?</h2>
		<p>Si vous la supprimée, tous les liens qui y sont associés renverront une erreur, la page et son contenu textuel seront supprimés.<br/>
			Les images qui la compose seront quant à elle sauvegardées.
		</p>

		<div class="lien">
			<a class="annuler">Annuler</a>
			<a href="" class="valider">Valider</a>
		</div>
		<div class="clear"></div>
	</div>
</div>