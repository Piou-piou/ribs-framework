<header>
	<div class="inner">
		<h1>Gestion des droits d'accès | modifier la liste : </h1>
	</div>
</header>
<?php include("header.php");?>

<form action="<?=ADMROOT?>controller/core/admin/modules/blog/article/modifier" method="post">
	<button type="submit" class="submit-contenu" type="submit"><i class="fa fa-pencil"></i>Modifier</button>
	<button class="submit-contenu supprimer-page popup-delete" href="<?=ADMROOT?>controller/core/admin/modules/blog/article/supprimer?id_article=<?=$id_article?>"><i class="fa fa-times"></i>Supprimer l'article</button>

	<div class="inner">
		<section class="contenu modifier-contenu">
			<h2>Partie concernant les droits d'accès standards</h2>
			<div class="colonne">
				<div class="bloc">
					<label class="label" data-error="Le titre pour le navigateur doit être entre 10 et 70 caractères" for="balise_title">Titre pour le navigateur</label>
					<input type="text" name="balise_title" type-val="string" min="10" max="70" value="" required=""/>
				</div>
			</div>
			<div class="colonne">
				<div class="bloc">
					<label class="label" for="url" data-error="L'url doit être comprise entre 3 et 92 caractères">Url affichée dans le navigateur</label>
					<input type="text" name="url" type-val="string" min="3" max="92" value="" required=""/>
				</div>
			</div>
		</section>

		<section class="contenu modifier-contenu">
			<h2>Partie concernant les droits d'accès aux pages</h2>
			<div class="colonne">
				<div class="bloc">
					<label class="label" data-error="Le titre pour le navigateur doit être entre 10 et 70 caractères" for="balise_title">Titre pour le navigateur</label>
					<input type="text" name="balise_title" type-val="string" min="10" max="70" value="" required=""/>
				</div>
			</div>
			<div class="colonne">
				<div class="bloc">
					<label class="label" for="url" data-error="L'url doit être comprise entre 3 et 92 caractères">Url affichée dans le navigateur</label>
					<input type="text" name="url" type-val="string" min="3" max="92" value="" required=""/>
				</div>
			</div>
		</section>

		<section class="contenu modifier-contenu">
			<h2>Partie concernant les utilisateurs qui sont dans cette liste</h2>
			<div class="colonne">
				<div class="bloc">
					<label class="label" data-error="Le titre pour le navigateur doit être entre 10 et 70 caractères" for="balise_title">Titre pour le navigateur</label>
					<input type="text" name="balise_title" type-val="string" min="10" max="70" value="" required=""/>
				</div>
			</div>
			<div class="colonne">
				<div class="bloc">
					<label class="label" for="url" data-error="L'url doit être comprise entre 3 et 92 caractères">Url affichée dans le navigateur</label>
					<input type="text" name="url" type-val="string" min="3" max="92" value="" required=""/>
				</div>
			</div>
		</section>
	</div>

	<input type="hidden" name="id_article" value="<?=$id_article?>"/>
</form>