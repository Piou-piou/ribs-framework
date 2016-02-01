<header>
	<div class="inner">
		<h1>Contactez le support</h1>
	</div>
</header>

<?php require_once("admin/controller/ckeditor.php");?>


<form action="<?=ADMROOT?>controller/core/form/support/envoyer_message.php" method="post">
	<button type="submit" class="submit-contenu" type="submit"><i class="fa fa-check"></i>Valider</button>
	<a href="<?=ADMROOT?>index"><button type="button" class="submit-contenu supprimer-page"><i class="fa fa-times"></i>Annuler</button></a>
	<div class="inner">
		<section class="contenu modifier-contenu">
			<h2>Contactez le support</h2>
			<div class="colonne">
				<div class="bloc">
					<label class="label" data-error="L'objet de votre demande doit être entre 5 et 92 caractères" for="objet">Objet dez votre demande</label>
					<input type="text" name="objet" type-val="string" min="5" max="92" value="" required=""/>
				</div>
			</div>
			<div class="colonne">
				<div class="bloc">
					<select name="type" id="type" required="">
						<option value="">Sélectionner un type pour votre demande</option>
						<option value="Bug dans l'utilisation de l'administration">Bug dans l'utilisation de l'administration</option>
						<option value="Demande concernant une fonctionnalité dans l'administration">Demande concernant une fonctionnalité dans l'administration</option>
						<option value="Concerne le site sans l'administration">Concerne le site sans l'administration</option>
						<option value="Autre demande">Autre demande</option>
					</select>
				</div>
			</div>

			<div class="bloc no-input">
				<label class="label label-textarea" for="demande" data-error="La demande doit être au minimum de 50 caractères">Votre demande doit faire au minimum de 50 caractères</label>
				<textarea name="demande" type-val="string" min="50" required=""></textarea>
			</div>
		</section>
	</div>
</form>

