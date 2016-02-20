<header>
	<div class="inner">
		<h1>Configuration | Infos Générales</h1>
	</div>
</header>

<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>popup/css/style.css">
<script src="<?=LIBSWEBROOT?>popup/js/popup.js"></script>
<?php require_once('header.php');?>

<div class="inner">
	<a class="submit-contenu supprimer-page link" href="<?=ADMWEBROOT?>configuration/index"><i class="fa fa-times"></i>Annuler</a>
	<form action="<?=ADMWEBROOT?>controller/core/admin/configuration/modifier" method="post">
		<div class="contenu modifier-contenu">

			<button type="submit" class="submit-contenu" type="submit"><i class="fa fa-check"></i>Valider</button>

			<div>
				<div class="colonne">
					<div class="bloc">
						<label for="nom_site" class="label"  data-error="Le nom de votre site doit être entre 3 et 50 caractères">Nom de votre site</label>
						<input type="text" name="nom_site" type-val="string" min="3" max="50" value="<?=$nom_site?>">
					</div>
				</div>
				<div class="colonne">
					<div class="bloc">
						<label for="url_site" class="label"  data-error="L'url de votre site doit être entre 3 et 90 caractères">Url de votre site</label>
						<input type="text" name="url_site" type-val="string" min="3" max="90" value="<?=$url_site?>">
					</div>
				</div>
			</div>

			<div>
				<div class="colonne">
					<div class="bloc">
						<label for="gerant_site" class="label"  data-error="Le nom du gérant du site doit être entre 3 et 50 caractères">Nom du gérant du site</label>
						<input type="text" name="gerant_site" type-val="string" min="3" max="50" value="<?=$gerant_site?>">
					</div>
				</div>
				<div class="colonne">
					<div class="bloc">
						<label for="mail_site" class="label"  data-error="Le mail du gérant de votre site doit être entre 3 et 90 caractères">Mail du gérant du site</label>
						<input type="text" name="mail_site" type-val="string" min="3" max="90" value="<?=$mail_site?>">
					</div>
				</div>
			</div>

			<div>
				<div class="colonne">
					<div class="bloc">
						<label for="mail_administrateur" class="label"  data-error="Le mail administrateur doit être entre 3 et 50 caractères">Mail du développeur web  du site </label>
						<input type="text" name="mail_administrateur" type-val="string" min="3" max="50" value="<?=$mail_administrateur?>">
					</div>
				</div>
			</div>
		</div>

		<div class="contenu modifier-contenu">
			<div>
				<div class="colonne">
					<div class="bloc">
						<select name="" id="">
							<option value="">Ce site doit il être responsive</option>
							<option value="1">oui</option>
							<option value="0">non</option>
						</select>
					</div>
				</div>
				<div class="colonne">
					<div class="bloc">
						<select name="" id="">
							<option value="">Ce site doit il est responsive</option>
							<option value="1">oui</option>
							<option value="0">non</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>