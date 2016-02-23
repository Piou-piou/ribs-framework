<header>
	<div class="inner">
		<h1>Configuration | Infos Générales</h1>
	</div>
</header>

<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>popup/css/style.css">
<script src="<?=LIBSWEBROOT?>popup/js/popup.js"></script>
<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>checkbox/css/style.css">
<script src="<?=LIBSWEBROOT?>checkbox/js/anim.js"></script>
<?php require_once(ROOT."admin/views/configuration/js/infos_generales.php");?>
<?php require_once('header.php');?>

<div class="inner">
	<?php require_once(LIBSROOT."barre_chargement/index.php");?>
	<a class="submit-contenu supprimer-page link" href="<?=ADMWEBROOT?>configuration/index"><i class="fa fa-times"></i>Annuler</a>
	<form action="<?=ADMWEBROOT?>controller/core/admin/configuration/modifier" method="post">
		<div class="contenu modifier-contenu">

			<h2>Gestion des infos</h2>

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
	</form>

	<div class="contenu modifier-contenu gestion-comptes">
		<h2>Gestion des options</h2>

		<table>
			<thead>
				<tr>
					<td>Nom de l'option</td>
					<td>Activer / déasctiver</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Responsive</td>
					<td>
						<label for="responsive" class="checkbox-perso switched">
							<input type="checkbox" class="test-check" id="responsive" <?php if ($responsive == 1): ?>checked<?php endif;?>>
						</label>
					</td>
				</tr>
				<tr>
					<td>Contenu dynamique</td>
					<td>
						<label for="contenu_dynamique" class="checkbox-perso switched">
							<input type="checkbox" class="test-check" id="contenu_dynamique" <?php if ($contenu_dynamique == 1): ?>checked<?php endif;?>>
						</label>
					</td>
				</tr>
				<tr>
					<td>Cache</td>
					<td>
						<label for="cache_config" class="checkbox-perso switched">
							<input type="checkbox" class="test-check" id="cache_config" <?php if ($cache_config == 1): ?>checked<?php endif;?>>
						</label>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>