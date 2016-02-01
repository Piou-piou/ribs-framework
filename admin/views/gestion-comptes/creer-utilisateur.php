<?=\core\HTML\flashmessage\FlashMessage::getFlash();?>
<header>
	<div class="inner">
		<h1>Créer un compte utilisateur</h1>
	</div>
</header>
<form action="<?=ADMROOT?>controller/core/admin/comptes/creer_utilisateur" method="post">
	<div class="inner">
		<button type="submit" class="submit-contenu" type="submit"><i class="fa fa-check"></i>Valider</button>

		<section class="contenu modifier-contenu">
			<h2>Information relatives à l'utilisateur</h2>

			<div>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="nom" data-error="Le nom de l'utilisateur doit faire plus de deux caractères">Nom de l'utilisateur</label>
						<input type="text" name="nom" value="<?=$nom?>" required>
					</div>
				</div>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="prenom" data-error="Le prenom de l'utilisateur doit faire plus de deux caractères">Prénom de l'utilisateur</label>
						<input type="text" name="prenom" value="<?=$prenom?>" required>
					</div>
				</div>
			</div>
			<div>
				<div class="colonne">
					<div class="bloc">
						<labe class="label" for="mdp" data-error="Le mot de passe ne peut pas être vide">Entrez le mot de passe de l'utilisateur</labe>
						<input type="password" name="mdp" required>
					</div>
				</div>
				<div class="colonne">
					<div class="bloc">
						<labe class="label" for="verif_mdp" data-error="La vérification du mot de passe ne peut pas être vide">Ré-entrez le mot de passe de l'utilisateur</labe>
						<input type="password" name="verif_mdp" required>
					</div>
				</div>
			</div>
			<div>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="pseudo" data-error="Le pseudo de l'utilisateur doit faire plus de deux caractères">Pseudo de l'utilisateur</label>
						<input type="text" name="pseudo" value="<?=$pseudo?>" required>
					</div>
				</div>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="mail" data-error="L'Email de l'utilisateur doit faire plus de deux caractères">E-mail de l'utilisateur</label>
						<input type="mail" name="mail" value="<?=$mail?>" required>
					</div>
				</div>
			</div>
		</section>

		<section class="contenu modifier-contenu">
			<h2>Informations relatives aux droit d'administration sur le site</h2>

			<div>
				<div class="colonne">
					<div class="bloc">
						<select name="acces_admin" id="">
							<option value="0">L'utilisateur aura t-il accès à l'administration du site</option>
							<option value="1">Oui</option>
							<option value="0">Non</option>
						</select>
					</div>
				</div>
				<div class="colonne">
					<div class="bloc">
						<select name="liste_acces" id="">
							<option value="0">Ajouter l'utilisateur à une liste de droit d'accès</option>
						</select>
					</div>
				</div>
			</div>
		</section>
	</div>
</form>