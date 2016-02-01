<nav class="nav-page">
	<div class="inner">
		<ul>
			<li><a href="<?=ADMROOT?>configuration/module">Modules</a></li>
		</ul>
	</div>
</nav>
<?php require_once(ROOT."admin/views/configuration/js/configuration.php");?>


<div class="popup" id="popup-delete">
	<div class="content">
		<h2>Etes-vous sûr de vouloir supprimer ce module ?</h2>
		<p>Si vous supprimez ce module, tous les contenus, images qui y sont associés seront supprimés<br/></p>
		<p class="attention">Cette action est irréverssible !</p>

		<div class="lien">
			<a class="annuler">Annuler</a>
			<a href="" class="valider" id="config-suppress-ajax">Valider</a>
		</div>
		<div class="clear"></div>
	</div>
</div>