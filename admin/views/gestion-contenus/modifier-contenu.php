<header>
	<div class="inner">
		<h1>Gestion des contenus : </h1>
		<h2>Modification de la page <?=$titre_courant?></h2>
	</div>
</header>
<?php include("header.php"); ?>
<?php $droit_acces->getDroitAccesContenu("GESTION CONTENU PAGE", $_GET['id']); ?>


<form action="<?=ADMWEBROOT?>controller/core/admin/contenus/gestion/modifier_contenus" method="post">
	<?php if (($droit_acces->getModifSeo() == 1) || ($droit_acces->getModifNavigation() == 1) || ($droit_acces->getModifContenu() == 1) || ($droit_acces->getSuperAdmin() == 1)):?>
		<button type="submit" class="submit-contenu" type="submit"><i class="fa fa-check"></i>Valider</button>
	<?php endif; ?>
	<input type="hidden" name="id_page" value="<?=$id_page_courante?>">
	<?php if (($_GET['id'] != 1) && (($droit_acces->getSupprimerPage() == 1) || ($droit_acces->getSuperAdmin() == 1))):?>
		<button id="supprimer-page-contenu" type="button" class="submit-contenu supprimer-page supprimer open-popup" popup="supprimer-page" href="<?=ADMWEBROOT?>controller/core/admin/contenus/gestion/supprimer_page?id=<?=$id_page_courante?>"><i class="fa fa-times"></i>Supprimer cette page</button>
	<?php endif; ?>

	<div class="inner">
		<?php if (($droit_acces->getModifSeo() == 0) && ($droit_acces->getModifNavigation() == 0) && ($droit_acces->getModifContenu() == 0) && ($droit_acces->getSuperAdmin() != 1)):?>
			<section class="contenu modifier-contenu">
				<h2>Vous n'avez pas l'autorisation de modifier cette page</h2>

				<?php if ($droit_acces->getSupprimerPage() == 1):?>
					<h3>Vous pouvez uniquement supprimer cette page</h3>
				<?php endif; ?>

				<p>Si vous voulez pouvoir modifier cette page, contactez votre gérant.</p>
			</section>
		<?php endif; ?>

		<?php if (($droit_acces->getModifSeo() == 1) || ($droit_acces->getSuperAdmin() == 1)):?>
			<section class="contenu modifier-contenu">
				<h2>Partie concernant le référencement SEO</h2>
				<div class="colonne">
					<div class="bloc">
						<label class="label" data-error="Le titre pour le navigateur doit être entre 10 et 70 caractères" for="balise_title">Titre pour le navigateur</label>
						<input type="text" name="balise_title" type-val="string" min="10" max="70" value="<?=$balise_title?>" required=""/>
					</div>
				</div>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="url" data-error="L'url doit être comprise entre 3 et 92 caractères">Url affichée dans le navigateur</label>
						<input type="text" name="url" type-val="string" min="3" max="92" value="<?=$url?>" <?php if ($id_page_courante == 1): ?>disabled<?php endif; ?>/>
					</div>
				</div>
				<?php if ($redirect_page == false):?>
					<div class="bloc no-input">
						<label class="label label-textarea" for="meta_description" data-error="La description doit être comprise entre 10 et 158 caractères">Description de votre site pour le navigateur (maximum 256 caractères)</label>
						<textarea name="meta_description" type-val="string" min="10" max="158" required=""><?=$meta_description?></textarea>
					</div>
				<?php endif;?>
			</section>
		<?php endif; ?>

		<?php if (($droit_acces->getModifNavigation() == 1) || ($droit_acces->getSuperAdmin() == 1)):?>
			<section class="contenu modifier-contenu">
				<h2>Partie concernant l'affichage dans la navigation</h2>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="titre_page" data-error="Le titre de la page doit être entre 5 et 50 caractères">Titre de la page (utilisée pour le menu)</label>
						<input type="text" name="titre_page" type-val="string" min="5" max="50" value="<?=$titre_courant?>" required=""/>
					</div>
				</div>
				<div class="colonne">
					<div class="bloc parent">
						<label class="label" for="parent_texte">Parent de la page</label>
						<input type="hidden" name="parent" value="<?=$parent_courant?>"/>
						<input type="text" name="parent_texte" value="<?=$texte_parent_courant?>"/>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if ((($droit_acces->getModifContenu() == 1) || ($droit_acces->getSuperAdmin() == 1)) && ($redirect_page == false)):?>
			<section class="contenu modifier-contenu">
				<h2>Partie concernant l'affichage dans le navigateur</h2>

				<p>En cliquant sur le lien ci-dessous, vous verrez un aperçu de la page. Pour modifier des contenus, il vous suffira de cliquer
					sur du texte, et si il est modifiable, vous pourrez l'éditer.
				</p>

				<a class="submit-contenu submit-standard inline no-shadow ml0" href="<?=ADMWEBROOT?>gestion-contenus/inline.php?id=<?=$id_page_courante?>">Modifier les contenus</a>
			</section>
		<?php endif; ?>
	</div>
</form>

