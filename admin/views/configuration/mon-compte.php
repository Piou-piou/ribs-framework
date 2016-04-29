<?=\core\HTML\flashmessage\FlashMessage::getFlash(); ?>
<header>
	<div class="inner">
		<h1>Mon compte</h1>
	</div>
</header>
<?php require_once('header.php'); ?>

<div class="inner">
	<section class="contenu modifier-contenu modif-compte">
		<h2>Changer mon mot de passe</h2>
		<p>Sur votre compte administrateur, vous pouvez uniquement changer votre mot de passe</p>
		<form action="<?=ADMWEBROOT?>controller/core/auth/mdp/changer_mdp" method="post">
			<div class="bloc">
				<label class="label">Votre mot de passe actuel</label>
				<input type="password" name="mdp" required>
			</div>

			<div class="bloc">
				<label class="label" for="mdp_new">Votre nouveau mot de passe</label>
				<input type="password" name="mdp_new" required>
			</div>

			<div class="bloc">
				<label class="label" for="verif_mdp_new">Verfification de votre nouveau mot de passe</label>
				<input type="password" name="verif_mdp_new" required>
			</div>

			<button type="submit">Valider</button>
			<input type="hidden" name="admin" value="true">
		</form>
	</section>
</div>