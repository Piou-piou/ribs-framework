<nav class="nav-page">
	<div class="inner">
		<ul>
			<li><a href="<?=ADMROOT?>gestion-droits-acces/ajouter-article">Ajouter une liste</a></li>
			<li><a href="<?=ADMROOT?>gestion-droits-acces/liste-droits-acces">Modifier une liste</a></li>
			<li><a href="<?=ADMROOT?>gestion-droits-acces/liste-droits-acces">Toutes les listes</a></li>
		</ul>
	</div>
</nav>
<script src="<?=WEBROOT?>admin/views/gestion-droits-acces/js/droit_acces.js"></script>



<div class="popup">
	<div class="content">
		<h2>Etes-vous sûr de vouloir supprimer cette liste ?</h2>
		<p>Si vous le supprimez, tous les droits qui y sont associés seront supprimés ainsi que les droits sur les pages<br/>
			Les utilisateurs n'auront donc plus accès aux éléments qui sont présent dans cette liste.
		</p>

		<div class="lien">
			<a class="annuler">Annuler</a>
			<a href="" class="valider">Valider</a>
		</div>
		<div class="clear"></div>
	</div>
</div>