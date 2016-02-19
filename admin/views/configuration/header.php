<nav class="nav-page">
	<div class="inner">
		<ul>
			<li><a href="<?=ADMWEBROOT?>configuration/module">Modules</a></li>
			<li><a href="<?=ADMWEBROOT?>configuration/infos-generales">Infos générales</a></li>
		</ul>
	</div>
</nav>
<?php require_once(ROOT."admin/views/configuration/js/configuration.php");?>


<div class="popup" id="popup-delete-module">
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


<div class="popup" id="popup-update-module">
	<div class="content">
		<h2>Etes-vous sûr de vouloir mettre à jour ce module ?</h2>
		<p>Si vous mettez à jour ce module, le dossier du module actuel sera renomée comme suit : url_du_moduleVversion.<br/>
			Un dossier url_du_module sera crée et contiendra la nouvelle version de votre module.
		</p>

		<p class="attention">Si vous aviez modifier les style.css ou autres fichiers, vous devrez retransférer ces modifications !</p>

		<p>Vous pouvez annuler cette mise à jour pendant une semaine avant que celle-ci ne soit définitive.</p>

		<p class="attention">Au bout d'une semaine le dossier contenant l'ancienne version du module sera supprimé définitivement !</p>

		<div class="lien">
			<a class="annuler">Annuler</a>
			<a href="" class="valider" id="config-update-ajax">Valider</a>
		</div>
		<div class="clear"></div>
	</div>
</div>