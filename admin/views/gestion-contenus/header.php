<nav class="nav-page">
	<div class="inner">
		<ul>
			<?php for ($i=0 ; $i<count($id_page) ; $i++): ?>
				<?php if ($parent[$i] == 0): ?>
					<li><a href="<?=ADMROOT?>gestion-contenus/modifier-contenu?id=<?=$id_page[$i]?>"><?=$titre[$i]?></a>
						<ul>
							<?php for ($j=0 ; $j<count($id_page) ; $j++): ?>
								<?php if ($parent[$j] == $id_page[$i]): ?>
									<li><a href="<?=ADMROOT?>gestion-contenus/modifier-contenu?id=<?=$id_page[$j]?>"><?=$titre[$j]?></a></li>
								<?php endif;?>
							<?php endfor;?>
						</ul>
					</li>
				<?php endif;?>
			<?php endfor;?>
		</ul>
	</div>
</nav>
<script src="<?=WEBROOT?>admin/views/gestion-contenus/js/contenu.js"></script>

<div class="popup">
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