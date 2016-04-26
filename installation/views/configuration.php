<div class="inner">
	<div class="installation-form active" id="login">
		<form  action="<?=WEBROOT?>installation-ribs/controller/configuration/info_generales" method="POST">
			<img src="<?=WEBROOT?>admin/views/template/images/ribs.png" alt="">

			<h1>Initialisation de la base de données</h1>

			<div class="modifier-contenu">
				<div class="bloc">
					<label for="nom_site" class="label"  data-error="Le nom de votre site doit être entre 3 et 50 caractères">Nom de votre site</label>
					<input type="text" name="nom_site" type-val="string" min="3" max="50" value="<?=$nom_site?>" required>
				</div>

				<div class="bloc">
					<label for="url_site" class="label"  data-error="L'url de votre site doit être entre 3 et 90 caractères">Url de votre site</label>
					<input type="text" name="url_site" type-val="string" min="3" max="90" value="<?=$url_site?>" required>
				</div>

				<div class="bloc">
					<label for="gerant_site" class="label"  data-error="Le nom du gérant du site doit être entre 3 et 50 caractères">Nom du gérant du site</label>
					<input type="text" name="gerant_site" type-val="string" min="3" max="50" value="<?=$gerant_site?>" required>
				</div>

				<div class="bloc">
					<label for="mail_site" class="label"  data-error="Le mail du gérant de votre site doit être entre 3 et 90 caractères">Mail du gérant du site</label>
					<input type="text" name="mail_site" type-val="string" min="3" max="90" value="<?=$mail_site?>" required>
				</div>

				<div class="bloc">
					<label for="mail_administrateur" class="label"  data-error="Le mail administrateur doit être entre 3 et 50 caractères">Mail du développeur web  du site </label>
					<input type="text" name="mail_administrateur" type-val="string" min="3" max="50" value="<?=$mail_administrateur?>" required>
				</div>
			</div>

			<input type="submit" class="submit-contenu submit-standard no-shadow full-width" value="Installer la base de données">
		</form>
	</div>
</div>