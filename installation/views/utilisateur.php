<div class="inner">
	<div class="installation-form active" id="login">
		<form  action="<?=WEBROOT?>installation-ribs/controller/configuration/utilisateur" method="POST">
			<img src="<?=WEBROOT?>admin/views/template/images/ribs.png" alt="">

			<h1>Initialisation du super admin</h1>

			<div class="modifier-contenu">
				<div class="bloc">
					<label for="nom" class="label"  data-error="Le nom de votre site doit être entre 3 et 50 caractères">Votre nom</label>
					<input type="text" name="nom" type-val="string" min="3" max="50" value="<?=$nom?>">
				</div>

				<div class="bloc">
					<label for="prenom" class="label"  data-error="L'url de votre site doit être entre 3 et 50 caractères">Votre prénom</label>
					<input type="text" name="prenom" type-val="string" min="3" max="50" value="<?=$prenom?>">
				</div>

				<div class="bloc">
					<label for="pseudo" class="label"  data-error="Le nom du gérant du site doit être entre 3 et 50 caractères">Votre pseudo (utilisé pour le login)</label>
					<input type="text" name="pseudo" type-val="string" min="3" max="50" value="<?=$pseudo?>">
				</div>

				<div class="bloc">
					<label for="mdp" class="label"  data-error="Le mail administrateur doit être entre 3 et 100 caractères">Votre mot de passe</label>
					<input type="password" name="mdp" type-val="string" min="3" max="100">
				</div>

				<div class="bloc">
					<label for="verif_mdp" class="label"  data-error="Le mail administrateur doit être entre 3 et 100 caractères">Votre mot de passe</label>
					<input type="password" name="verif_mdp" type-val="string" min="3" max="100">
				</div>
			</div>

			<input type="submit" class="submit-contenu submit-standard no-shadow full-width" value="Installer la base de données">
		</form>
	</div>
</div>