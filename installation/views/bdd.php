<div class="inner">
	<div class="installation-form active" id="login">
		<form  action="<?=WEBROOT?>installation-ribs/controller/bdd/install" method="POST">
			<img src="<?=WEBROOT?>admin/views/template/images/ribs.png" alt="">

			<h1>Initialisation de la base de données</h1>

			<div class="modifier-contenu">
				<div class="bloc">
					<label class="label" for="db_host" data-error="L'adresse du serveur doit être comprise entre 3 et 100 caractères">Adresse du serveur de la base de données</label>
					<input type="text" name="db_host" type-val="string" min="3" max="100" required/>
				</div>

				<div class="bloc">
					<label class="label" for="db_type" data-error="Le type de base de données doit être comprise entre 3 et 15 caractères">Type base de données (MySQL, POSTGRE, ...)</label>
					<input type="text" name="db_type" type-val="string" min="3" max="15" required/>
				</div>

				<div class="bloc">
					<label class="label" for="db_name" data-error="Le nom de base de données doit être comprise entre 3 et 50 caractères">Nom base de données (existante ou à créer)</label>
					<input type="text" name="db_name" type-val="string" min="3" max="50" required/>
				</div>

				<div class="bloc">
					<label class="label" for="db_user" data-error="Le nom d'utilisateur de base de données doit être comprise entre 3 et 50 caractères">Nom d'utilisateur de la base de données</label>
					<input type="text" name="db_user" type-val="string" min="3" max="50" required/>
				</div>

				<div class="bloc">
					<label class="label" for="db_pass">Mot de passe de la base de données</label>
					<input type="text" name="db_pass"/>
				</div>
			</div>

			<input type="submit" class="submit-contenu submit-standard no-shadow full-width" value="Installer la base de données">
		</form>
	</div>
</div>